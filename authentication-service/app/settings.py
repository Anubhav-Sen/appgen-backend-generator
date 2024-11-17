import os
from os.path import join, dirname
from dotenv import load_dotenv

dotenv_path = join(dirname(dirname(__file__)), '.env')
load_dotenv(dotenv_path)

DB_PATH = join(dirname(dirname(__file__)), 'database.db')

DATABASE_URL = f"sqlite:///{DB_PATH}"