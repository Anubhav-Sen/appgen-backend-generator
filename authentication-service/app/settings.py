import os
from os.path import join, dirname
from dotenv import load_dotenv

dotenv_path = join(dirname(dirname(__file__)), '.env')
load_dotenv(dotenv_path)

DB_PATH = join(dirname(dirname(__file__)), 'database.db')
DATABASE_URL = f"sqlite:///{DB_PATH}"
TOKEN_URL = "token"
SECRET_KEY = os.getenv("SECRET_KEY")
ALGORITHM = os.getenv("ALGORITHM")
ACCESS_TOKEN_EXPIRE_MINUTES = 60