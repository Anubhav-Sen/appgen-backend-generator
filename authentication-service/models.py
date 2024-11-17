import uuid

from typing import Annotated
from fastapi import Query
from pydantic import EmailStr
from sqlalchemy import String
from sqlmodel import Field, Session, SQLModel, create_engine, select

class User(SQLModel, table=True):
    id: uuid.UUID = Field(default_factory=uuid.uuid4, primary_key=True)
    username: str = Field(max_length=50)
    email_address: EmailStr = Field(max_length=255, sa_type=String(), unique=True, nullable= False)
    password: str = Field(max_length=255)



