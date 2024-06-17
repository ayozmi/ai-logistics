# Imports for data wrangling
import os
import boto3
import pandas as pd
from io import StringIO


# Load variables from .env file, ignoring lines without '='
def load_env_variables(env_file='../.env'):
    # Get the current working directory
    current_dir = os.getcwd()
    env_path = os.path.join(current_dir, '..', env_file)
        
    print(f"Looking for .env file at: {env_path}")  # Debugging output

    if not os.path.exists(env_path):
        print(f".env file does not exist at: {env_path}")
        return

    with open(env_path, 'r') as file:
        for line in file:
            # Skip lines without an equals sign or comments
            if '=' in line and not line.strip().startswith('#'):
                key, value = line.strip().split('=', 1)
                os.environ[key] = value


def main():

    # Load environment variables
    load_env_variables()

    # Create an S3 client
    s3 = boto3.client('s3')

    # Specify the bucket name and prefix (folder path)
    bucket_name = os.getenv('BUCKET_NAME_INBOUND')
    prefix = os.getenv('PREFIX_KEY')

    # List objects in the specified S3 folder
    response = s3.list_objects_v2(Bucket=bucket_name, Prefix=prefix)

    # Initialize a list to store CSV file keys
    csv_files = []

    # Iterate over the objects and collect keys of CSV files
    for obj in response.get('Contents', []):
        object_key = obj['Key']
        if object_key.endswith('.csv'):
            csv_files.append(object_key)
    
    # Initialize a list to store DataFrames
    dataframes = []

    # Read each CSV file and store in a DataFrame
    for csv_file in csv_files:
        # Get the object from S3
        csv_obj = s3.get_object(Bucket=bucket_name, Key=csv_file)

        # Get the body of the object (the file content)
        body = csv_obj['Body']

        # Read the body into a string
        csv_string = body.read().decode('utf-8')

        # Use pandas to read the CSV string into a DataFrame
        df = pd.read_csv(StringIO(csv_string))

        # Append the DataFrame to the list
        dataframes.append(df)

    # Concatenate dataframes
    supply_ch_df_raw = pd.concat(dataframes, ignore_index=True)

    # Drop the 'Lead time' column since it is repeated
    supply_ch_df_raw.drop(columns=['Lead time'], inplace=True)

    # Fill with 0
    supply_ch_df_raw['Demurrage'].fillna(0, inplace=True)

    # Fill with '$0'
    supply_ch_df_raw['Revenue generated'].fillna('$0', inplace=True)
    supply_ch_df_raw['Shipping costs'].fillna('$0', inplace=True)
    supply_ch_df_raw['Manufacturing costs'].fillna('$0', inplace=True)

    # Fill with 'Unknown'
    columns_to_fill_unknown = [
        'Customer demographics', 'Shipping carriers', 'Supplier name', 
        'Location', 'Inspection results', 'Transportation modes', 'Routes'
    ]
    supply_ch_df_raw[columns_to_fill_unknown] = supply_ch_df_raw[columns_to_fill_unknown].fillna('Unknown')

    # Median impute
    columns_to_median_impute = [
        'Availability', 'Number of products sold', 'Stock levels', 'Lead times', 'Costs',
        'Order quantities', 'Shipping times', 'Production volumes', 'Defect rates',
        'Manufacturing lead time', 'Estimated price', 'Manufacturing lead time'
    ]
    for column in columns_to_median_impute:
        median_value = supply_ch_df_raw[column].median()
        supply_ch_df_raw[column].fillna(median_value, inplace=True)

    # Dropping rows with null values
    supply_ch_df_cleaned = supply_ch_df_raw.dropna(axis=0)

    # Removing dollar sign and passing to numeric type
    for column in supply_ch_df_cleaned[['Revenue generated', 'Shipping costs', 'Manufacturing costs']]:
        supply_ch_df_cleaned.loc[:, column] = supply_ch_df_cleaned.loc[:, column].str.replace('[$,]', '', regex=True).astype(float)

    # Mapping dictionary
    route_mapping = {
        'a': 'Route_A', 'A': 'Route_A', 'A route': 'Route_A', 'routeA': 'Route_A', 'route_A': 'Route_A',
        'b': 'Route_B', 'B': 'Route_B', 'B route': 'Route_B', 'routeB': 'Route_B', 'route_B': 'Route_B',
        'c': 'Route_C', 'C': 'Route_C', 'C route': 'Route_C', 'routeC': 'Route_C', 'route_C': 'Route_C'
    }

    # Apply the mapping to the 'Routes' column
    supply_ch_df_cleaned.loc[:, 'Routes'] = supply_ch_df_cleaned.loc[:, 'Routes'].replace(route_mapping)

    supply_ch_df_cleaned.loc[:, 'Demurrage Bin'] = supply_ch_df_cleaned['Demurrage'] > 0

    # Renaming columns
    supply_ch_df_cleaned.columns = supply_ch_df_cleaned.columns.str.replace(' ', '_').str.replace(r'\W', '', regex=True).str.lower()

    # Save the concatenated DataFrame to S3
    output_bucket_name = 'logimo-aligned'
    output_prefix = f'{prefix}/Sample_Data_Product_Cleaned.csv'
    csv_buffer = StringIO()
    supply_ch_df_cleaned.to_csv(csv_buffer, index=False)

    # Upload the CSV to S3
    s3.put_object(Bucket=output_bucket_name, Key=output_prefix, Body=csv_buffer.getvalue())

    print(f"Concatenated file saved to s3://{output_bucket_name}/{output_prefix}")
    
if __name__ == "__main__":
    main()