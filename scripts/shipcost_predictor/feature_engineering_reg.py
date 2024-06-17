# Imports for feat engineering
import os
import boto3
import pandas as pd
import numpy as np
import matplotlib.pyplot as plt
import seaborn as sns
from io import StringIO
from sklearn.model_selection import train_test_split
from sklearn.preprocessing import StandardScaler
from sklearn.decomposition import PCA
from sklearn.ensemble import RandomForestRegressor
from sklearn.linear_model import LinearRegression
from sklearn.svm import SVR
from sklearn.metrics import mean_squared_error, r2_score


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
    _ = load_env_variables()

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
    supply_chain_df_cleaned = pd.read_csv(StringIO(csv_content))

    # Fetch the content of the second CSV file from S3
    obj = s3.get_object(Bucket=bucket_name, Key=f'{prefix}/Data_Demurrage_True_Join.csv')

    # Read the content of the CSV file
    csv_content = obj['Body'].read().decode('utf-8')

    # Use pandas to read the CSV content into a DataFrame
    classification_df = pd.read_csv(StringIO(csv_content))

        # Perform the merge operation
    merged_df = supply_chain_df_cleaned.merge(classification_df[['sku', 'demurrage_bin']], 
                                            on='sku', 
                                            how='right', 
                                            suffixes=('', '_df1'))

    # Update the 'demurrage_bin' column
    merged_df['demurrage_bin'] = merged_df['demurrage_bin_df1'].combine_first(merged_df['demurrage_bin'])

    # Drop the temporary column
    merged_df.drop(columns=['demurrage_bin_df1', 'demurrage_bin', 'customer_demographics', 
                            'supplier_name', 'availability', 'revenue_generated', 'product_type'], inplace=True)
    
    supply_chain_encoded_df = merged_df.copy()

    # Encoding categorical variables
    categorical_columns = ['shipping_carriers', 'location', 'inspection_results', 'transportation_modes', 'routes']
    supply_chain_encoded_df = pd.get_dummies(supply_chain_encoded_df, columns=categorical_columns, drop_first=True)
    supply_chain_encoded_df.set_index('sku', inplace=True)

    # PCA
    X = supply_chain_encoded_df.drop(columns=['demurrage'])
    y = supply_chain_encoded_df['demurrage']

    # Scale and normalize features
    scaler = StandardScaler()
    X_scaled = scaler.fit_transform(X)

    # Apply PCA
    pca = PCA(n_components=0.95)  # Keep 95% of the variance
    X_pca = pca.fit_transform(X_scaled)

    supply_chain_X_pca_df = pd.DataFrame(X_pca)
    supply_chain_y_df = pd.DataFrame(y)

    # Save the concatenated DataFrame to S3
    output_bucket_name = 'logimo-aligned'

    output_prefix = f'{prefix}/regression_model_X_pca.csv'
    csv_buffer = StringIO()
    supply_chain_X_pca_df.to_csv(csv_buffer, index=False)
    # Upload the CSV to S3
    s3.put_object(Bucket=output_bucket_name, Key=output_prefix, Body=csv_buffer.getvalue())

    print(f"regression_model_X_pca file saved to s3://{output_bucket_name}/{output_prefix}")

    output_prefix = f'{prefix}/regression_model_Y_pca.csv'
    csv_buffer = StringIO()
    supply_chain_y_df.to_csv(csv_buffer, index=False)
    # Upload the CSV to S3
    s3.put_object(Bucket=output_bucket_name, Key=output_prefix, Body=csv_buffer.getvalue())

    print(f"regression_model_Y_pca file saved to s3://{output_bucket_name}/{output_prefix}")
    
if __name__ == "__main__":
    main()