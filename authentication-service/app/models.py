import uuid

from datetime import datetime
from fastapi import Query
from pydantic import EmailStr
from sqlalchemy import String
from sqlmodel import Field, SQLModel, select

class User(SQLModel, table=True):
    __tablename__ = "users"

    id: uuid.UUID = Field(default_factory=uuid.uuid4, primary_key=True)
    username: str = Field(max_length=50)
    email_address: EmailStr = Field(max_length=255, sa_type=String(), unique=True, nullable= False)
    password: str = Field(max_length=255)
    date_created: datetime = Field(default_factory=datetime.utcnow, nullable=False)
    date_updated: datetime = Field(default_factory=datetime.utcnow, nullable=False)

