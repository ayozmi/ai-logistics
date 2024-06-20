# Imports
import pandas as pd
import boto3
from io import StringIO
import os

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
    bucket_name = os.getenv('BUCKET_NAME_ALIGNED')
    prefix = os.getenv('PREFIX_KEY')

    # Fetch the content of the cleaned CSV file from S3
    obj = s3.get_object(Bucket=bucket_name, 
                        Key=f'{prefix}/Sample_Data_Product_Cleaned.csv')

    # Read the content of the CSV file
    csv_content = obj['Body'].read().decode('utf-8')

    # Use pandas to read the CSV content into a DataFrame
    df= pd.read_csv(StringIO(csv_content))

    # Filter the DataFrame to include only rows where 'demurrage_bin' is True
    filtered_df = df[df['demurrage_bin'] == True]

    # Create the new DataFrame with only 'sku' and 'demurrage_bin' columns
    classification_df = filtered_df[['sku', 'demurrage_bin']]

    # Save the concatenated DataFrame to S3
    output_bucket_name = 'logimo-aligned'

    output_prefix = f'{prefix}/Data_Demurrage_True_Join.csv'
    csv_buffer = StringIO()
    classification_df.to_csv(csv_buffer, index=False)

    # Upload the CSV to S3
    s3.put_object(Bucket=output_bucket_name, Key=output_prefix, Body=csv_buffer.getvalue())

    print(f"Demurrage Subset file saved to s3://{output_bucket_name}/{output_prefix}")

    # Drop irrelevant columns if any (example)
    df = df.drop(['sku', 'demurrage', 'customer_demographics', 'supplier_name' ], axis=1) #'product_type'

    # Convert categorical variables to dummy variables
    df = pd.get_dummies(df)

    output_prefix = f'{prefix}/classification_model_df.csv'
    csv_buffer = StringIO()
    df.to_csv(csv_buffer, index=False)
    # Upload the CSV to S3
    s3.put_object(Bucket=output_bucket_name, Key=output_prefix, Body=csv_buffer.getvalue())

    print(f"Dataframe for classification file saved to s3://{output_bucket_name}/{output_prefix}")

        
if __name__ == "__main__":
    main()