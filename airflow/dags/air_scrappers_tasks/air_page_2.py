import json
import time
from datetime import datetime
from dotenv import load_dotenv
import chromedriver_autoinstaller
from selenium import webdriver
from selenium.common.exceptions import NoSuchElementException, TimeoutException
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.service import Service as ChromeService
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.support.ui import WebDriverWait
from src import Helper

import boto3
from botocore.exceptions import NoCredentialsError


# Load the variables from .env into the environment
load_dotenv()

def read_keywords_from_s3(bucket_name, file_key):
    s3 = boto3.client('s3')
    try:
        response = s3.get_object(Bucket=bucket_name, Key=file_key)
        content = response['Body'].read().decode('utf-8')
        return json.loads(content)
    except NoCredentialsError:
        print("Credentials not available")
        return None

# S3 bucket and file key
bucket_name = "logimo-outbound"
file_key = "news-reporter-models-files/keywords.json"

# Load keywords from S3
keywords = read_keywords_from_s3(bucket_name, file_key)

# Air traffic news website 1
URL = "https://www.aircargonews.net/"

# Define the path to the SQLite database
db_path = "data/news/maritime_air_news.db"
# Define table naming by date of execution
current_date = datetime.now().strftime("%m%d%Y")
air_news_table_name = f"air_news_{current_date}"


helper_obj = Helper(db_path, air_news_table_name)


def main_air():
    """ """
    conn = helper_obj.connect_to_db_mysql()
    cursor = conn.cursor()
    # Initialize DDBB and create tables
    helper_obj.initialize_tables()

    # Install and setup ChromeDriver
    chromedriver_autoinstaller.install()
    browser = webdriver.Chrome(service=ChromeService())
    browser.implicitly_wait(2)
    browser.get(URL)

    # Click cookies button
    try:
        # Wait for the button to be clickable
        WebDriverWait(browser, 10).until(
            EC.element_to_be_clickable((By.XPATH, "//button[text()='I Accept']"))
        )
        # Click the button once it is clickable
        browser.find_element(By.XPATH, "//button[text()='I Accept']").click()
    except (NoSuchElementException, TimeoutException):
        print("The cookie acceptance button was not found on the page.")

    # Recent NEWS
    location = "Global"
    browser.implicitly_wait(2)
    # List of latest global news
    category = browser.find_elements(By.CLASS_NAME, "lcp_catlist")
    cat_url = [
        cat.find_element(By.TAG_NAME, "a").get_attribute("href") for cat in category
    ]
    for cat in cat_url:
        # cat = cat_url[0]
        time.sleep(5)
        browser.get(cat)
        cat_items = browser.find_elements(By.CLASS_NAME, "category-item")
        # pagination = browser.find_element(By.CLASS_NAME, 'aircargo-pagination')
        # [element.get_attribute('href') for element in pagination.find_elements(By.TAG_NAME, "a")][-1]
        cat_items_url = [
            items.find_element(By.TAG_NAME, "a").get_attribute("href")
            for items in cat_items
        ]
        for items_url in cat_items_url:
            time.sleep(5)
            # items_url = cat_items_url[0]
            browser.get(items_url)
            article_title = browser.find_element(
                By.CSS_SELECTOR, "h1[class='blog-post-title']"
            ).text
            # summary = browser.find_element(By.XPATH, "//div[contains(@class, 'field field-name-field-penton-content-summary field-type-text-long field-label-hidden')]").text
            article_text = browser.find_element(
                By.CSS_SELECTOR, "div[class='content-section clearfix']"
            ).text
            article_date = browser.find_element(
                By.CSS_SELECTOR, "h4[class='post-date']"
            ).text.strip()
            date_obj = datetime.strptime(article_date.replace(" ", ""), "%d/%m/%Y")
            premium = False

            if premium:
                helper_obj.summarize_text(article_text)
            else:

                summary = "Get Premium for enabling AI-powered summary!"

            classification = helper_obj.classify_article(article_text, keywords)
            ml_classification = helper_obj.ml_classification(article_text)
            helper_obj.insert_article_data(
                cursor,
                article_title,
                article_text,
                summary,
                classification,
                ml_classification,
                location,
                items_url,
                date_obj,
                'air'
            )
            conn.commit()

    conn.close()
    browser.quit()


if __name__ == "__main__":
    main_air()