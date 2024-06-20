import os
from io import BytesIO, StringIO
from sklearn.preprocessing import StandardScaler
import pickle
import boto3
import pandas as pd
from sqlalchemy import create_engine

# Load variables from .env file, ignoring lines without '='
def load_env_variables(env_file='../.env'):
    current_dir = os.getcwd()
    env_path = os.path.join(current_dir, '..', env_file)
        
    print(f"Looking for .env file at: {env_path}")  # Debugging output

    if not os.path.exists(env_path):
        print(f".env file does not exist at: {env_path}")
        return

    with open(env_path, 'r') as file:
        for line in file:
            if '=' in line and not line.strip().startswith('#'):
                key, value = line.strip().split('=', 1)
                os.environ[key] = value


def load_data_to_mysql(merged_df, user, password, host, port, database, table_name):
    """
    Load data from a pandas dataframe to a MySQL database table.
    """
    # Create the connection string
    connection_string = f'mysql+pymysql://{user}:{password}@{host}:{port}/{database}'
    
    # Create the database engine
    engine = create_engine(connection_string)
    
    # Load the data into the database
    merged_df.to_sql(name=table_name, con=engine, if_exists='append', index=False)
    print("Data loaded successfully.")


def main():
    load_env_variables()

    s3 = boto3.client('s3')

    bucket_name = os.getenv('BUCKET_NAME_OUTBOUND')
    prefix = os.getenv('PREFIX_KEY')

    obj = s3.get_object(Bucket=bucket_name, Key=f'{prefix}/ship_cost_classification/Data_Pred_Demurrage_True_Join.csv')
    csv_content = obj['Body'].read().decode('utf-8')
    classification_df = pd.read_csv(StringIO(csv_content))

    data_bucket_name = os.getenv('BUCKET_NAME_ALIGNED')
    data_prefix = os.getenv('PREFIX_KEY')

    obj = s3.get_object(Bucket=data_bucket_name, Key=f'{data_prefix}/daily_feed_pred/Daily_Product_Data_Cleaned.csv')
    csv_content = obj['Body'].read().decode('utf-8')
    supply_chain_df_cleaned = pd.read_csv(StringIO(csv_content))

    merged_df = supply_chain_df_cleaned.merge(classification_df[['sku']], on='sku', how='right', suffixes=('', '_df1'))
    merged_df.drop(columns=['customer_demographics', 'supplier_name', 'availability', 'revenue_generated', 'product_type'], inplace=True)
    
    categorical_columns = ['shipping_carriers', 'location', 'inspection_results', 'transportation_modes', 'routes']
    supply_chain_encoded_df = pd.get_dummies(merged_df, columns=categorical_columns, drop_first=True)
    
    # Ensure all necessary columns are present
    expected_columns = ['estimated_price', 'number_of_products_sold', 'stock_levels', 'lead_times',
                        'order_quantities', 'shipping_times', 'shipping_costs', 'production_volumes',
                        'manufacturing_lead_time', 'manufacturing_costs', 'defect_rates', 'costs',
                        'demurrage', 'shipping_carriers_Carrier B', 'shipping_carriers_Carrier C',
                        'shipping_carriers_Unknown', 'location_Chennai', 'location_Delhi', 'location_Kolkata',
                        'location_Mumbai', 'location_Unknown', 'inspection_results_Pass', 'inspection_results_Pending',
                        'inspection_results_Unknown', 'transportation_modes_Rail', 'transportation_modes_Road', 
                        'transportation_modes_Sea', 'transportation_modes_Unknown', 'routes_Route_B', 'routes_Route_C',
                        'routes_Unknown']
    
    missing_cols = set(expected_columns) - set(supply_chain_encoded_df.columns)
    for col in missing_cols:
        supply_chain_encoded_df[col] = 0

    supply_chain_encoded_df = supply_chain_encoded_df[expected_columns]  # Ensure correct order

    scaler = StandardScaler()
    X_scaled = scaler.fit_transform(supply_chain_encoded_df)

    class_model_bucket_name = 'logimo-outbound'
    class_model_file_key = 'ship_cost_predictor/regression_models_files/random_forest_model.pkl'
    
    file_obj = BytesIO()
    s3.download_fileobj(class_model_bucket_name, class_model_file_key, file_obj)
    file_obj.seek(0)
    model = pickle.load(file_obj)

    predictions = model.predict(X_scaled)

    merged_df['demurrage_cost_prediction'] = predictions
    merged_df['demurrage_cost_prediction'] = merged_df['demurrage_cost_prediction'].astype(float)

    # Adding a demurrage column
    merged_df['demurrage_bin'] = True

    DB_USER = os.getenv('DB_USER')
    DB_PASSWORD = os.getenv('DB_PASSWORD')
    DB_HOST = os.getenv('DB_HOST')
    DB_PORT = os.getenv('DB_PORT')
    DB_NAME = os.getenv('DB_NAME')
    DB_TABLE = 'demurrage_predictor_data'

    # Load Data to MySQL database
    load_data_to_mysql(merged_df, DB_USER, DB_PASSWORD, DB_HOST, DB_PORT , DB_NAME, DB_TABLE)


if __name__ == "__main__":
    main()

