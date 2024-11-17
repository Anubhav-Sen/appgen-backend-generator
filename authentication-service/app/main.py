import uuid

from fastapi import FastAPI, HTTPException, Query
from sqlmodel import select
from models import *
from db import SessionDep
from typing import Annotated

app = FastAPI()

@app.get("/users/{id}", response_model=UserPublic)
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

    db_user = User.model_validate(user)

    session.add(db_user)
    session.commit()
    session.refresh(db_user)

    return db_user

@app.patch("/users/{id}", response_model=UserPublic)
def patch_user(id: uuid.UUID, user: UserUpdate, session: SessionDep):
    
    db_user = session.get(User, id)

    if not db_user:
        raise HTTPException(status_code=404, detail="user not found.")
    
    update_data = user.model_dump(exclude_unset=True)

    db_user.sqlmodel_update(update_data)

    session.add(db_user)
    session.commit()
    session.refresh(db_user)

    return db_user

@app.delete("users/{id}")
def delete_user(id: uuid.UUID, session: SessionDep):

    db_user = session.get(User, id)

    if not db_user:
        raise HTTPException(status_code=404, detail="user not found.")

    session.delete(db_user)
    session.commit()

    return {"ok": True}

