import os
import settings
import sqlalchemy

from google.cloud.sql.connector import Connector, IPTypes
import pg8000

from typing import Annotated
from fastapi import Depends
from sqlmodel import Session, SQLModel, create_engine

#def connect_with_connector() -> sqlalchemy.engine.base.Engine:
#
#   ip_type = IPTypes.PRIVATE if os.environ.get("PRIVATE_IP") else IPTypes.PUBLIC
#
#   connector = Connector()
#
#  def getconn() -> pg8000.dbapi.Connection:
#       conn: pg8000.dbapi.Connection = connector.connect(
#         settings.INSTANCE_CONNECTION_NAME,
#          "pg8000",
#          user=settings.DB_USER,
#          password=settings.DB_PASSWORD,
#          db=settings.DB_NAME,
#          ip_type=ip_type,
#      )
#      return conn
#  
#  pool = sqlalchemy.create_engine( "postgresql+pg8000://", creator=getconn,)
    
connect_args = {"check_same_thread": False}
engine = create_engine(settings.DB_URL, connect_args = connect_args)

def db_init():
    SQLModel.metadata.create_all(engine)

def get_session():
    with Session(engine) as session:
        yield session 

SessionDep = Annotated[Session, Depends(get_session)]