import uuid

from fastapi import FastAPI, HTTPException, Query
from sqlmodel import select
from models import *
from db import SessionDep
from typing import Annotated

app = FastAPI()

@app.get("/user/{id}", response_model=UserPublic)
def get_user(id: uuid.UUID, session: SessionDep):

    user = session.get(User, id)
    
    if not user:
        raise HTTPException(status_code=404, detail="user not found.")
    
    return user

@app.get("/users/", response_model=list[UserPublic])
def get_users(session: SessionDep, offset: int = 0, limit: Annotated[int, Query(le=100)] = 100):
    
    users = session.exec(select(User).offset(offset).limit(limit)).all()    

    return users

@app.post("/users/", response_model=UserPublic)
def post_user(user: UserCreate, session: SessionDep): 

    session.add(user)
    session.commit()
    session.refresh(user)

    return user