from airflow import DAG
from airflow.operators.python_operator import PythonOperator
from datetime import datetime, timedelta

# Import Python scripts as a modules
from data_wrangling_tasks.data_wrangling_class_reg import main_data_wrangling
from modeling_class_tasks.modeling_class import main_modeling_class
from modeling_reg_tasks.modeling_reg import main_modeling_reg

default_args = {
    'owner': 'airflow',
    'depends_on_past': False,
    'email_on_failure': False,
    'email_on_retry': False,
    'retries': 0,  # No retries
    'retry_delay': timedelta(minutes=5),
}

dag = DAG(
    'DAG_ml_pipeline_class_reg',
    default_args=default_args,
    description='DAG to run the machine learning pipeline for classifying and estimated costs of dmurrage twice a day',
    schedule_interval='0 0,12 * * *',  # At midnight and noon every day
    start_date=datetime(2023, 1, 1),
    catchup=False,
)

run_data_wrangling_class_reg = PythonOperator(
    task_id='run_data_wrangling_class_reg',
    python_callable=main_data_wrangling,
    dag=dag,
)

run_modeling_class = PythonOperator(
    task_id='run_modeling_classification',
    python_callable=main_modeling_class,
    dag=dag,
)

run_modeling_reg = PythonOperator(
    task_id='run_modeling_regression',
    python_callable=main_modeling_reg,
    dag=dag,
)


run_data_wrangling_class_reg >> run_modeling_class >> run_modeling_reg


