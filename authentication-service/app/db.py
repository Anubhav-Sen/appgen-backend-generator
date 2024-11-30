import settings
from typing import Annotated
from fastapi import Depends
from sqlmodel import Session, SQLModel, create_engine
    
connect_args = {
    "ssl_context":False, 
    }

engine = create_engine(settings.DB_URL, connect_args = connect_args)

def db_init():
    SQLModel.metadata.create_all(engine)

def get_session():
    with Session(engine) as session:
        yield session 

SessionDep = Annotated[Session, Depends(get_session)]