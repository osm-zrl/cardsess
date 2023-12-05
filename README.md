<h1>CardSess</h1>
<p>CardSess is a presence management system designed to oversee and regulate student access by utilizing RFID technology to monitor and record students' presence or absence.
<br>
The system comprises several key components:
</p>


<ul>
  <li>Front-End: The dashboard's front-end was constructed using fundamental web technologies, including HTML5, CSS3, Bootstrap, JavaScript, and jQuery.</li>
  <li>Back-End: The back-end was entirely developed using vanilla PHP, ensuring robust functionality and performance.</li>
  <li>Database: MySQL serves as the foundational database for storing and managing essential system data.</li>
  <li>Local Server for Admin Scanner: Python sets up and operates a local server responsible for managing the admin scanner's functionality and communication within the system.</li>
  <li>RFID System: Testing of the RFID card system involved the utilization of an Arduino micro-controller (UNO3) and ESP8266 in conjunction with RFID sensors to ensure seamless integration and functionality.</li>
</ul>

<h2>How does it function?</h2>
<p>The system initiates with a server's cron job, constructed using Python, to generate sessions based on the inserted timetable. Subsequently, students are prompted to scan their cards using the ESP32 scanner. This scanner transmits their card data to the server's API, where the server cross-references this data with the database for validation.</p>
<p>Following confirmation, the server then checks for any available sessions for that student within a 15-minute range before and after the session start time. Finally, the system presents the data to the administrator in the form of charts and a session page containing details about present and absent students.</p>

<h2>Admin Side</h2>
<p>In order to store the student's data on the RFID card, a connection was established between the cable-attached scanner and the server. This was accomplished by employing a Python program to create a local server using the Bottle library, integrated with the Arduino library to manage serial communication with the Arduino device.</p>

<p>The process of storing data onto a card involved sending requests via AJAX to the local server. These requests contained commands to read the card. The local server responded by retrieving the card's data from the scanner. After verifying that the card was devoid of previous data, the dashboard sent a command to write the student's ID onto the card. Upon receiving confirmation, the data was stored in the database.</p>

<p>Additionally, the admin scanner offers the functionality to search for a student by scanning their card, providing an efficient means to access individual student records.</p>
