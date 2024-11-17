from fastapi import FastAPI
from db import db_init

app = FastAPI()

@app.on_event("startup")
def on_startup():
    db_init()

@app.get("/user")
async def user():
    return {"message":"Hello world!"}

