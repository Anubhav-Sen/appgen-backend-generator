from fastapi import FastAPI
from models import User
from db import SessionDep

app = FastAPI()

@app.get("/user")
async def user():
    return {"message":"Hello world!"}

@app.post("/users")
def user(user: User, session: SessionDep): 

    session.add(user)
    session.commit()
    session.refresh(user)

    return user