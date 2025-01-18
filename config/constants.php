<?php
    // start Session
    session_start();

    //  create constants to save non repeating values
    define('SITEURL','http://localhost/annapurna/');
    define('LOCALHOST','localhost');
    define('DB_USERNAME','root');
    define('DB_PASSWORD','');
    define('DB_NAME','annapurna');
    
     $conn = mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD) or die(mysqli_error());
     $db_select = mysqli_select_db($conn, 'annapurna') or die(mysqli_error());


?>