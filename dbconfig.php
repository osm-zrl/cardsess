<?php
$conn = new mysqli('localhost:3306','root','','atdc');
if ($conn -> connect_errno){
    die('connection failed');
}