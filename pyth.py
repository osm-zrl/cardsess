#!C:\Users\lenovo\AppData\Local\Programs\Python\Python311\python.exe
print("Content-Type: text/html\n\n")
import sys
sys.path.append("C:\\Users\\lenovo\\AppData\\Local\\Programs\\Python\\Python311\\Lib\\site-packages")

import mysql.connector

db = mysql.connector.connect(
    host="localhost",
    port=3030,
    user="root",
    password="",
    database="atdc",
)

cursor = db.cursor()
cursor.execute("SELECT * FROM `log_history`;")
for row in cursor:
    print(row)