import openai
import os
import sqlite3
import torch
import joblib
from sklearn.preprocessing import LabelEncoder
from transformers import AutoModelForSequenceClassification, AutoTokenizer
import mysql.connector
import boto3


# Load variables from .env file, ignoring lines without '='
def load_env_variables(env_file='/opt/airflow/config/.env'): # env_file='../.env' env_file='/opt/airflow/config/.env'
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

class Helper:
    def __init__(self, db_path, news_table_name) -> None:
        self.db_path = db_path
        self.news_table_name = news_table_name

    
    def connect_to_db_mysql(self):
        """ """
        load_env_variables()

        return mysql.connector.connect(
            host=os.getenv('DB_HOST'),
            port=os.getenv('DB_PORT'),
            user=os.getenv('DB_USER'),
            password=os.getenv('DB_PASSWORD'),
            database=os.getenv('DB_NAME'))

    def connect_to_db_sqlite(self):
        return sqlite3.connect(self.db_path)

    # Create a new table for storing only daily articles
    def create_daily_news_table(self, cursor):
        """ """
        cursor.execute(
            f"""CREATE TABLE IF NOT EXISTS news (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255),
                text TEXT,
                summary TEXT,
                classification VARCHAR(255),
                ml_classification VARCHAR(255),
                location VARCHAR(255),
                link VARCHAR(255),
                date DATE,
                `type` VARCHAR(10)
            );"""
        )

    def initialize_tables(self):
        """ """
        # Establish a connection and create a cursor
        conn = self.connect_to_db_mysql()
        cursor = conn.cursor()

        # Create tables for today's date with news
        self.create_daily_news_table(cursor)

        # Commit the changes and close the connection
        conn.commit()
        conn.close()

    def summarize_text(self, text):
        """ """
        response = openai.Completion.create(
            engine="text-davinci-003",
            prompt=f"""
    Please summarize the key points of the article for a business audience in a concise paragraph, limiting the summary to no more than 350 characters. Then, in a separate paragraph of 500 characters, elaborate on the potential impact of the situation described in the article on maritime logistics, port operations, and supply chain management, specifically focusing on its implications for Latin America. Label this second paragraph 'Impacto en LATAM:' and ensure there is a clear separation between the two sections. Present your response in Spanish and format it as markdown text for clarity:\n\n{text}
                    """,
            temperature=0.7,
            max_tokens=150,
            top_p=1,
            frequency_penalty=0,
            presence_penalty=0,
        )
        return response.choices[0].text.strip()

    def insert_article_data(
            self,
            cursor,
            article_title,
            article_text,
            summary,
            classification,
            ml_classification,
            location,
            link,
            date,
            type
    ):
        """ """
        # Check if an article with the same title already exists
        cursor.execute(
            f"SELECT id FROM news WHERE title = %s", (article_title,)
        )
        existing_article = cursor.fetchone()

        if existing_article is None:
            cursor.execute(
                f"""INSERT INTO news (title, text, summary, classification, ml_classification, location, link, date, type)
                            VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s);""",
                (
                    article_title,
                    article_text,
                    summary,
                    classification,
                    ml_classification,
                    location,
                    link,
                    date,
                    type,
                ),
            )

    def classify_article(self, article_text, keywords):
        """ """
        max_count = 0
        max_category = "Unclassified or Neutral"

        # Convert article text to lower case for comparison
        article_text_lower = article_text.lower()

        # Check for the presence of each keyword in the article
        for category, category_keywords in keywords.items():
            count = sum(keyword in article_text_lower for keyword in category_keywords)
            if count > max_count:
                max_count = count
                max_category = category

        return max_category

    # Function to classify text with BERT model
    def ml_classification(self, text):

        # Load the models and tokenizer
        path_to_bert_model = "../../models/news_reporter/bert_risk/"
        cls_model = AutoModelForSequenceClassification.from_pretrained(
            path_to_bert_model
        )
        tokenizer_cls = AutoTokenizer.from_pretrained(path_to_bert_model)

        label_column_values = ["risks", "opportunities", "neither"]
        label_encoder = LabelEncoder()
        label_encoder.fit(label_column_values)
        # Save the fitted LabelEncoder for future use
        joblib.dump(label_encoder, f"{path_to_bert_model}/encoder_labels.pkl")

        # Set the device (GPU or CPU)
        device = torch.device("cuda" if torch.cuda.is_available() else "cpu")

        # Tokenize the input text
        inputs_cls = tokenizer_cls(
            text, return_tensors="pt", max_length=512, truncation=True
        )
        inputs_cls = {key: value.to(device) for key, value in inputs_cls.items()}

        # Move cls_model to the specified device
        cls_model = cls_model.to(device)

        # Perform classification
        outputs_cls = cls_model(**inputs_cls)
        logits_cls = outputs_cls.logits
        predicted_class = torch.argmax(logits_cls, dim=1).item()

        # Decode the predicted class index into the label string
        classification = label_encoder.inverse_transform([predicted_class])[0]

        return classification
