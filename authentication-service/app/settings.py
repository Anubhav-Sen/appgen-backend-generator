import os
from dotenv import load_dotenv
from os.path import join, dirname

env_path = join(dirname(dirname(__file__)), '.env')
load_dotenv(env_path)

DB_USER = os.environ.get("DB_USER")
DB_PASSWORD = os.environ.get("DB_PASSWORD")
DB_NAME = os.environ.get("DB_NAME")
HOST_NAME = os.environ.get("HOST_NAME")
DB_URL = f"postgresql+pg8000://{DB_USER}:{DB_PASSWORD}@{HOST_NAME}/{DB_NAME}"
TOKEN_URL = os.environ.get("TOKEN_URL")
SECRET_KEY = str(os.environ.get("SECRET_KEY"))
ALGORITHM = os.environ.get("ALGORITHM")
ACCESS_TOKEN_EXPIRE_MINUTES = int(os.environ.get("ACCESS_TOKEN_EXPIRE_MINUTES"))