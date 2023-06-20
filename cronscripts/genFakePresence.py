import mysql.connector
import datetime
import random

db = mysql.connector.connect(
    host="localhost",
    port=3030,
    user="root",
    password="",
    database="atdc",
)

def generate_random_datetime(start_date):
    
    random_min_intervals = random.randrange(-15,15)
    random_sec_intervals = random.randrange(60)
    
    random_datetime = start_date + datetime.timedelta(minutes=random_min_intervals)

    random_datetime =random_datetime + datetime.timedelta(seconds=random_sec_intervals)
    
    return random_datetime


sql_statement =f"SELECT * FROM `sessions`;"
cursor = db.cursor()
cursor.execute(sql_statement)
sessions_tables = cursor.fetchall()

inserted_array=[]
for i in sessions_tables:
    sess_id = i[0]
    date_start = i[2]
    date_end = i[3]
    sess_class_id=i[4]
    sql_statement =f"SELECT card_id from cards JOIN student ON cards.student_id = student.student_id WHERE card_active = 1 AND student.class_id = {sess_class_id}"
    cursor = db.cursor()
    cursor.execute(sql_statement)
    cards_tables = cursor.fetchall()
    
    rand_num = random.randrange(15,len(cards_tables))
    random_cards = random.sample(cards_tables,rand_num)
    for j in random_cards:
        
        arr = [sess_id,j[0],generate_random_datetime(date_start)]
        inserted_array.append(arr)

sql_statement = "INSERT INTO `log_history`(`session_id`, `card_id`, `scan_time`) VALUES(%s,%s,%s)"
cursor = db.cursor()
cursor.executemany(sql_statement,inserted_array)
db.commit()
print('data inserted')
db.close()
