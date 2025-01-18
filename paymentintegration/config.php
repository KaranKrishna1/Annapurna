<?php

$host = "localhost";
$dbname = "annapurna";
$username = "root";
$password = "";

$conn = mysqli_connect($host,$username,$password,$dbname);

if(mysqli_connect_error()){
    echo "Failed to connect to MySQL". mysqli_connect_error();
}

?>