from fastapi import FastAPI
from db import db_init

app = FastAPI()

@app.get("/user")
async def user():
    return {"message":"Hello world!"}

