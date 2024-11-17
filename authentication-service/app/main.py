from fastapi import FastAPI

app = FastAPI()

@app.get("/user")
async def user():
    return {"message":"Hello world!"}

