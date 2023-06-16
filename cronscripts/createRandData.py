import mysql.connector
import datetime

current_date = datetime.date.today()
db = mysql.connector.connect(
    host="localhost",
    port=3030,
    user="root",
    password="",
    database="atdc",
)
weekday = current_date.weekday()

