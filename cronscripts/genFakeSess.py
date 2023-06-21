import mysql.connector
import datetime



current_date = datetime.date.today()

weekday = current_date.weekday()

db = mysql.connector.connect(
    host="localhost",
    port=3030,
    user="root",
    password="",
    database="atdc",
)
daydate=12


        

#making the request to get time tables of week day

for i in range(6):
    datedayStart = '2023-06-'+str(daydate)
    datedayStart = datetime.datetime.strptime(datedayStart,'%Y-%m-%d')
    datedayStart = datedayStart.date()

    class session:
        def __init__(self,name,class_id,date_start,date_end):
            self.class_id = class_id
            self.set_date_start(date_start)
            self.set_date_end(date_end)
            self.name = name

        def set_date_start(self,date_start):
            self.__date_start = str(datedayStart) +' '+ str(date_start)

        def set_date_end(self,date_end):
            self.__date_end = str(datedayStart) +' '+ str(date_end)

        def getdata(self):
            return [self.name,self.__date_start,self.__date_end,self.class_id]

    
    sql_statement =f"SELECT * FROM `time_table` where day={i};"
    cursor = db.cursor()
    cursor.execute(sql_statement)
    time_tables = cursor.fetchall()



    insertData_sql = "INSERT INTO `sessions`(`nom_session`, `date_start`, `date_end`, `class_id`) VALUES(%s,%s,%s,%s)"

    sessions_array = []

    for row in time_tables:
        sess = session(row[2],row[1],row[3],row[4])
        sessions_array.append(sess.getdata())
    
    print(sessions_array)
    
    try:
        cursor.executemany(insertData_sql,sessions_array)
        db.commit()
        print('done creating sessions!')
    except mysql.connector.Error as err: 
        print("MySQL Error:", err)

    daydate+=1