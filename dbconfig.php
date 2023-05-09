<?php
$conn = new mysqli('localhost:3030','root','','atdc');
if ($conn -> connect_errno){
    die('connection failed');
}