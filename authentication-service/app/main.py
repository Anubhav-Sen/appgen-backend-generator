import uuid

from fastapi import FastAPI, HTTPException
from models import *
from db import SessionDep

app = FastAPI()

@app.get("/user/{id}", response_model=UserPublic)
def get_user(id: uuid.UUID, session: SessionDep):

    user = session.get(User, id)
    
    if not user:
        raise HTTPException(status_code=404, detail="user not found.")
    
    return user

@app.post("/users/", response_model=UserPublic)
def post_user(user: UserCreate, session: SessionDep): 

    session.add(user)
    session.commit()
    session.refresh(user)

    return user