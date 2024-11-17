from typing import Annotated
from fastapi import Depends
from sqlmodel import Session, SQLModel, create_engine
from settings import DATABASE_URL

connect_args = {"check_same_thread": False}
engine = create_engine(DATABASE_URL, connect_args=connect_args)

def db_init():
    SQLModel.metadata.create_all(engine)

def get_session():
    with Session(engine) as session:
        yield session 

SessionDep = Annotated[Session, Depends(get_session)]