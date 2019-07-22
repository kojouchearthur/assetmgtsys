<?php
    $host = 'localhost';
    $username = 'user';
    $password = 'userpassword';
    $database = 'assetmgtsystem_database_name';

   $con = mysqli_connect($host, $username, $password, $database);
    if (mysqli_connect_errno()) {
        echo 'Unable to connect to Database '.mysqli_connect_error();
    }
    /*
    else{
        echo "Connection Successful";
    }
    */
?>