import os
from os.path import join, dirname

DB_PATH = join(dirname(dirname(__file__)), 'database.db')
DB_URL = f"sqlite:///{DB_PATH}"

DB_USER = os.environ.get("DB_USER")
DB_PASSWORD = os.environ.get("DB_PASSWORD")
DB_NAME = os.environ.get("DB_NAME")
INSTANCE_CONNECTION_NAME = os.environ.get("INSTANCE_CONNECTION_NAME")
#INSTANCE_UNIX_SOCKET = f"/cloudsql/{INSTANCE_CONNECTION_NAME}"
#DB_URL = f"postgresql+pg8000://{DB_USER}:{DB_PASSWORD}@/{DB_NAME}?unix_sock={INSTANCE_UNIX_SOCKET}/.s.PGSQL.5432"
TOKEN_URL = "token"
SECRET_KEY = os.environ.get("SECRET_KEY")
ALGORITHM = os.environ.get("ALGORITHM")
ACCESS_TOKEN_EXPIRE_MINUTES = os.environ.get("ACCESS_TOKEN_EXPIRE_MINUTES")