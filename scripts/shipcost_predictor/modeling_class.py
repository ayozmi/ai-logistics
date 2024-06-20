# Imports for feat engineering
import os
import pickle
import boto3
from io import BytesIO
import pandas as pd
from io import StringIO
from sklearn.preprocessing import StandardScaler

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
                        Key=f'{prefix}/daily_feed_pred/Daily_Product_Data_Cleaned.csv')

    # Read the content of the CSV file
    csv_content = obj['Body'].read().decode('utf-8')

    # Use pandas to read the CSV content into a DataFrame
    supply_chain_df_cleaned = pd.read_csv(StringIO(csv_content))

    # Retain the columns that you will drop for prediction
    retained_columns = supply_chain_df_cleaned[['sku', 'customer_demographics', 'supplier_name', 'product_type', 'revenue_generated']]

    # Drop irrelevant columns for prediction
    df = supply_chain_df_cleaned.drop(['sku', 'customer_demographics', 'supplier_name'], axis=1)

    # Convert categorical variables to dummy variables
    X = pd.get_dummies(df)

    # Standardize the features
    scaler = StandardScaler()
    X_scaled = scaler.fit_transform(X)

    # Define the S3 bucket and file path
    class_model_bucket_name = 'logimo-outbound'
    class_model_file_key = 'ship_cost_predictor/classification_models_files/logistic_regression_model.pkl'

    # Download the file from S3 into a BytesIO object
    file_obj = BytesIO()
    s3.download_fileobj(class_model_bucket_name, class_model_file_key, file_obj)
    file_obj.seek(0)  # Reset the file object's position to the beginning

    # Load the pre-trained model from the BytesIO object
    model = pickle.load(file_obj)

    # Predict using the loaded model
    predictions = model.predict(X_scaled)

    # Add the predictions as a new column to the DataFrame
    df['demurrage_prediction'] = predictions

    # Convert the prediction column to boolean (True/False)
    df['demurrage_prediction'] = df['demurrage_prediction'].astype(bool)

    # Combine the retained columns with the prediction DataFrame
    final_df = pd.concat([retained_columns, df], axis=1)

    # Filter the DataFrame to include only rows where 'demurrage_prediction' is True
    filtered_df = final_df[final_df['demurrage_prediction'] == True]

    # Create the new DataFrame with only 'sku' and 'demurrage_bin' columns
    classification_df = filtered_df[['sku', 'demurrage_prediction']]

    # Save the concatenated DataFrame to S3
    output_bucket_name = 'logimo-outbound'

    output_prefix = f'{prefix}/ship_cost_classification/Data_Pred_Demurrage_True_Join.csv'
    csv_buffer = StringIO()
    classification_df.to_csv(csv_buffer, index=False)

    # Upload the CSV to S3
    s3.put_object(Bucket=output_bucket_name, Key=output_prefix, Body=csv_buffer.getvalue())

    print(f"Demurrage Prediction file saved to s3://{output_bucket_name}/{output_prefix} for regressor ingestion")


if __name__ == "__main__":
    main()