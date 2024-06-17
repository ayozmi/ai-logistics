import boto3
import pandas as pd
import pickle
import pymysql
from sqlalchemy import create_engine

# AWS credentials and settings
aws_access_key_id = 'YOUR_AWS_ACCESS_KEY_ID'
aws_secret_access_key = 'YOUR_AWS_SECRET_ACCESS_KEY'
region_name = 'YOUR_AWS_REGION'
csv_bucket_name = 'your-csv-bucket-name'
csv_file_key = 'path/to/your/csvfile.csv'
model_bucket_name = 'your-model-bucket-name'
model_file_key = 'path/to/your/model.pkl'

# MySQL database settings
rds_host = 'your-rds-endpoint'
rds_port = '3306'
rds_dbname = 'your-db-name'
rds_user = 'your-username'
rds_password = 'your-password'
table_name = 'your-table-name'

# Initialize boto3 client
s3 = boto3.client('s3', aws_access_key_id=aws_access_key_id, aws_secret_access_key=aws_secret_access_key, region_name=region_name)

# Load CSV file from S3
csv_obj = s3.get_object(Bucket=csv_bucket_name, Key=csv_file_key)
csv_data = csv_obj['Body']
df = pd.read_csv(csv_data)

# Load model from S3
model_obj = s3.get_object(Bucket=model_bucket_name, Key=model_file_key)
model_body = model_obj['Body'].read()
model = pickle.loads(model_body)

# Make predictions
predictions = model.predict(df)
df['prediction'] = predictions

# Create SQLAlchemy engine for MySQL connection
connection_string = f'mysql+pymysql://{rds_user}:{rds_password}@{rds_host}:{rds_port}/{rds_dbname}'
engine = create_engine(connection_string)

# Write to MySQL database
df.to_sql(name=table_name, con=engine, if_exists='append', index=False)

print('Data successfully written to the RDS MySQL instance.')
