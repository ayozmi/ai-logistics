# Logimo: AI-Powered Logistics Platform

![python](https://img.shields.io/badge/Python-3776AB?style=for-the-badge&logo=python&logoColor=white)
![git](https://img.shields.io/badge/GIT-E44C30?style=for-the-badge&logo=git&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&logo=docker&logoColor=white)
![Airflow](https://img.shields.io/badge/Airflow-017CEE?style=for-the-badge&logo=apache-airflow&logoColor=white)
![AWS S3](https://img.shields.io/badge/AWS%20S3-569A31?style=for-the-badge&logo=amazon-aws&logoColor=white)
![json](https://img.shields.io/badge/JSON-000000?style=for-the-badge&logo=json&logoColor=white)
![php](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![javascript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![jquery](https://img.shields.io/badge/jQuery-0769AD?style=for-the-badge&logo=jquery&logoColor=white)
![CSS](https://img.shields.io/badge/CSS-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![html](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![AWS RDS](https://img.shields.io/badge/AWS%20RDS-527FFF?style=for-the-badge&logo=amazon-aws&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![AWS EC2](https://img.shields.io/badge/AWS%20EC2-FF9900?style=for-the-badge&logo=amazon-aws&logoColor=white)
![docker compose](https://img.shields.io/badge/Docker%20Compose-2496ED?style=for-the-badge&logo=docker&logoColor=white)
![github](https://img.shields.io/badge/GitHub-181717?style=for-the-badge&logo=github&logoColor=white)
![Streamlit](https://img.shields.io/badge/Streamlit-FF4B4B?style=for-the-badge&logo=Streamlit&logoColor=white)
![Hugging Face](https://img.shields.io/badge/Hugging%20Face-F9AB00?style=for-the-badge&logo=HuggingFace&logoColor=white)
![OpenAI](https://img.shields.io/badge/OpenAI-412991?style=for-the-badge&logo=OpenAI&logoColor=white)
![markdown](https://img.shields.io/badge/Markdown-000000?style=for-the-badge&logo=markdown&logoColor=white)
![Jupyter](https://img.shields.io/badge/Jupyter-F37626?style=for-the-badge&logo=Jupyter&logoColor=white)
![SQLite](https://img.shields.io/badge/SQLite-003B57?style=for-the-badge&logo=sqlite&logoColor=white)
![terminal](https://img.shields.io/badge/windows%20terminal-4D4D4D?style=for-the-badge&logo=windows%20terminal&logoColor=white)

Welcome to **Logimo**, an advanced AI-driven platform specifically designed for the logistics industry. Logimo leverages cutting-edge machine learning and data engineering techniques to provide predictive analytics for delays and costs, real-time data inquiries through an intelligent chatbot, and automated news monitoring to anticipate operational impacts.

App deployed in EC2 for Demo (Until July 26, 2024): [HERE](http://54.196.25.239/Logimo/login.php) 

## Key Features

- **Predictive Analytics**: Utilize machine learning models for accurate delay and cost predictions, enhancing operational efficiency.
- **Real-Time Data Inquiry Chatbot**: Access instant data through a conversational interface powered by advanced natural language processing (NLP).
- **Automated News Monitoring**: Stay ahead with real-time news scraping, classification, summarization, and translation using state-of-the-art models like BERT and OpenAI APIs.

## Technology Stack

- **Machine Learning & Data Science**: Incorporates sophisticated pipelines for classification and regression tasks, built with popular frameworks and libraries.
- **Natural Language Processing**: Employs basic JSON mappings and advanced BERT models for comprehensive text analysis.
- **Cloud Infrastructure**: Fully hosted on AWS, utilizing S3 as a data lake, EC2 for app deployment, and MySQL RDS for backend data management.
- **Orchestration with Airflow**: Manages and schedules complex workflows, ensuring smooth and efficient operation of all data processing tasks.

## Repository Structure

- **ai-logistics** (root directory)
  - `Airflow/`
    - `docker-compose.yml`: Configuration file for building a Docker image to create the Airflow environment.
    - `dags/`: Contains Directed Acyclic Graphs (DAGs) running the machine learning pipeline for both classification and regression tasks.
  - `app/`
    - `streamlit_app.py`: Prototype of the Streamlit application for news web scraping.
  - `data/`
    - Local data folder structure demonstrating the data lake architecture, including sample CSV datasets for each feature.
  - `documentation/`
    - Comprehensive documentation covering each feature, data sources, and justifications for chosen methodologies.
  - `images/`
    - Media files to assist in project understanding and visualization.
  - `notebooks/`
    - Jupyter notebooks following a structured data science methodology:
      1. Problem Statement
      2. Data Sources
      3. Data Ingestion and Wrangling
      4. Exploratory Data Analysis (EDA) and Data Visualization
      5. Feature Engineering
      6. Machine Learning Model Training and Evaluation
  - `scripts/`
    - Executable scripts for the machine learning pipeline, including classification, regression, NLP tasks, data lake interactions, and database operations.
  - `web_app/`
    - PHP application code for the web interface.
  - `.env.example`
    - Example environment configuration file.

## Getting Started

### Prerequisites

Ensure you have the following installed:
- Docker
- Python 3.x
- AWS CLI configured with appropriate permissions
- MySQL

### Installation

1. Clone the repository:
    ```sh
    git clone https://github.com/pablo-git8/ai-logistics.git
    cd ai-logistics
    ```

2. Set up the Airflow environment:
    ```sh
    cd Airflow
    docker-compose up --build
    ```

3. Configure environment variables:
    ```sh
    cp .env.example .env


### Usage

- **Airflow**: Monitor and manage your workflows through the Airflow web UI.
- **Machine Learning Pipelines**: Execute scripts in the `scripts/` directory to run the predictive models and data processing tasks.

## Contributing

We welcome contributions from the community!

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Acknowledgements

We extend our gratitude to the open-source community, our active contributors and the developers of the tools and libraries utilized in this project.

---

Logimo is committed to revolutionizing logistics management through the power of AI and data science. Join us in driving efficiency and smarter decision-making in the logistics industry. Consult the [DISCLAIMER](DISCLAIMER.md) for any professional usage of the application.

