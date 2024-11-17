import os
from os.path import join, dirname,abspath
from dotenv import load_dotenv

from logging.config import fileConfig

from sqlalchemy import engine_from_config
from sqlalchemy import pool
from sqlmodel import SQLModel

from alembic import context


from pathlib import Path

DATABASE_URL = str((Path().parent / "database.db").resolve())

print(test)