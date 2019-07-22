<?php
    $host = 'localhost';
    $username = 'assetmgtuser';
    $password = 'Pass4Assetmgtuser';
    $database = 'assetmgt';

    $con = new mysqli($host,$username,$password,$database);

    if($con->connect_error){
        die("Could not connect to Database: ".$con->connect_error);
    }

    $query = "ALTER TABLE users MODIFY COLUMN joindate date";

    if($con->query($query)===TRUE){
        echo "Table modified";
    }else{
        echo "Error: ".$query."<br>".$con->error;
    }


    
?>