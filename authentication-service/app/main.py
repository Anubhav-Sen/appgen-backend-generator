import uuid
import jwt
import settings

from fastapi import FastAPI, Depends, HTTPException, Query, status
from fastapi.security import OAuth2PasswordBearer, OAuth2PasswordRequestForm
from pydantic import EmailStr
from sqlmodel import select
from models import *
from db import SessionDep
from typing import Annotated
from passlib.context import CryptContext
from datetime import datetime, timedelta, timezone
from jwt.exceptions import InvalidTokenError

app = FastAPI()

password_context = CryptContext(schemes = ["bcrypt"], deprecated = "auto")

oauth2_scheme = OAuth2PasswordBearer(tokenUrl=settings.TOKEN_URL)

def verify_password(plain_password, hashed_password):
    return password_context.verify(plain_password, hashed_password)

def get_password_hash(password):
    return password_context.hash(password)

def get_user(session: SessionDep, username: EmailStr,):
    if username in session:
        db_user = session[username]
        return db_user

def authenticate_user(session: SessionDep, username: EmailStr, password: str):
    user = get_user(session, username)
    if not user:
        return False
    if not verify_password(password, user.hashed_password):
        return False
    return user

def create_access_token(data: dict, expires_delta: timedelta | None = None):

    to_encode = data.copy()

    if expires_delta:
        expire = datetime.now(timezone.utc) + expires_delta
    else:
        expire = datetime.now(timezone.utc) + timedelta(minutes=15)

    to_encode.update({"exp": expire})

    token = jwt.encode(to_encode, settings.SECRET_KEY, algorithm=settings.ALGORITHM)
    
    return token

def get_current_user(token: Annotated[str, Depends(oauth2_scheme)]):
    
    try: 
        payload = jwt.decode(token, settings.SECRET_KEY, algorithms=[settings.ALGORITHM])

        username: EmailStr = payload.get("sub")

        if username is None: 

           raise HTTPException(status_code=status.HTTP_401_UNAUTHORIZED, detail="Could not validate credentials", headers={"WWW-Authenticate": "Bearer"},)
                               
        token_data = TokenData(username=username)

    except InvalidTokenError:
        
        raise HTTPException(status_code=status.HTTP_401_UNAUTHORIZED, detail="Could not validate credentials", headers={"WWW-Authenticate": "Bearer"},)
    
    user = get_user(session=SessionDep, username=token_data.username)

    if user is None:
        raise HTTPException(status_code=status.HTTP_401_UNAUTHORIZED, detail="Could not validate credentials", headers={"WWW-Authenticate": "Bearer"},)
    
    return user

@app.post("/authenticate", response_model=Token)
def authenticate_user(form_data: Annotated[OAuth2PasswordRequestForm, Depends()], session: SessionDep):

    user = authenticate_user(session, form_data.username, form_data.password)
    
    if not user:
        raise HTTPException(status_code=status.HTTP_401_UNAUTHORIZED, detail="Incorrect username or password", headers={"WWW-Authenticate": "Bearer"},)
    
    access_token_expires = timedelta(minutes=settings.ACCESS_TOKEN_EXPIRE_MINUTES)

    access_token = create_access_token(data={"sub": user.email_address}, expires_delta=access_token_expires)
    
    return Token(access_token=access_token, token_type="bearer")

@app.get("/users/{id}", response_model=UserPublic, status_code=status.HTTP_200_OK)
def get_user(id: uuid.UUID, session: SessionDep):

    user = session.get(User, id)
    
    if not user:
        raise HTTPException(status_code=status.HTTP_404_NOT_FOUND, detail="User not found.")
    
    return user

@app.get("/users/", response_model=list[UserPublic], status_code=status.HTTP_200_OK)
def get_users(session: SessionDep, offset: int = 0, limit: Annotated[int, Query(le=100)] = 100):
    
    users = session.exec(select(User).offset(offset).limit(limit)).all()    

    return users

@app.post("/users/", response_model=UserPublic, status_code=status.HTTP_201_CREATED)
def post_user(user: UserCreate, session: SessionDep): 

    db_user = User.model_validate(user)

    session.add(db_user)
    session.commit()
    session.refresh(db_user)

    return db_user

@app.patch("/users/{id}", response_model=UserPublic, status_code=status.HTTP_200_OK)
def patch_user(id: uuid.UUID, user: UserUpdate, session: SessionDep):
    
    db_user = session.get(User, id)

    if not db_user:
        raise HTTPException(status_code=status.HTTP_404_NOT_FOUND, detail="User not found.")
    
    update_data = user.model_dump(exclude_unset=True)

    db_user.sqlmodel_update(update_data)

    session.add(db_user)
    session.commit()
    session.refresh(db_user)

    return db_user

@app.delete("/users/{id}", status_code=status.HTTP_200_OK)
def delete_user(id: uuid.UUID, session: SessionDep):

    db_user = session.get(User, id)

    if not db_user:
        raise HTTPException(status_code=status.HTTP_404_NOT_FOUND, detail="User not found.")

    session.delete(db_user)
    session.commit()

    return {"ok": True}