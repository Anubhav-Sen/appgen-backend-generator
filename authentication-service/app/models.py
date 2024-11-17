import uuid

from datetime import datetime
from fastapi import Query
from pydantic import EmailStr
from sqlalchemy import String
from sqlmodel import Field, SQLModel, select

class UserBase(SQLModel):
    username: str = Field(max_length=50)
    email_address: EmailStr = Field(max_length=255, sa_type=String(), unique=True, nullable= False)

class User(UserBase, table=True):
    __tablename__ = "users"

    id: uuid.UUID = Field(default_factory=uuid.uuid4, primary_key=True)
    password: str = Field(max_length=255)
    date_created: datetime = Field(default_factory=datetime.utcnow, nullable=False)
    date_updated: datetime = Field(default_factory=datetime.utcnow, nullable=False)

class UserPublic(UserBase):
    id: uuid.UUID

class UserCreate(UserBase):
    password: str = Field(max_length=255)

class UserUpdate():
    username: str | None = None
    password: str | None = None 
    