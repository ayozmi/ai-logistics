from airflow import DAG
from airflow.operators.python_operator import PythonOperator
from datetime import datetime, timedelta

# Import Python scripts as a modules
from air_scrappers_tasks.air_page_2 import main_air
from air_scrappers_tasks.air_page_2_latam import main_air_2_latam
from maritime_scrapers_task.maritime_page_1 import main_maritime
from maritime_scrapers_task.maritime_page_1_latam import main_maritime_latam
from maritime_scrapers_task.maritime_page_2 import main_maritime_page_2

default_args = {
    'owner': 'Pablo Ruiz Lopez',
    'depends_on_past': False,
    'email_on_failure': False,
    'email_on_retry': False,
    'retries': 0,  # No retries
    'retry_delay': timedelta(minutes=5),
}

dag = DAG(
    'DAG_news_web_scrappers',
    default_args=default_args,
    description='DAG to run the maritime and air web scrappers once per day',
    schedule_interval='0 0 * * *',  # At midnight and noon every day
    start_date=datetime(2023, 1, 1),
    catchup=False,
)

run_main_air_scrapper = PythonOperator(
    task_id='run_main_air_scrapper',
    python_callable=main_air,
    dag=dag,
)

run_latam_air_scrapper = PythonOperator(
    task_id='run_latam_air_scrapper',
    python_callable=main_air_2_latam,
    dag=dag,
)

run_main_maritime_scrapper = PythonOperator(
    task_id='run_main_maritime_scrapper',
    python_callable=main_maritime,
    dag=dag,
)

run_main_maritime_latam_scrapper = PythonOperator(
    task_id='run_main_maritime_latam_scrapper',
    python_callable=main_maritime_latam,
    dag=dag,
)

run_main_maritime_2_scrapper = PythonOperator(
    task_id='run_main_maritime_2_scrapper',
    python_callable=main_maritime_page_2,
    dag=dag,
)


run_main_air_scrapper >> run_latam_air_scrapper >> run_main_maritime_scrapper >> run_main_maritime_latam_scrapper >> run_main_maritime_2_scrapper
