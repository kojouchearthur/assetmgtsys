<?php
session_start();
require 'lib/plug.php';
if(!isset($_SESSION['logged-in'])){
     header("Location:signup.php");
 }
 
 echo "You are Logged in as: ".$_SESSION['logged-in'];
 echo '<br><a href="logout.php">Log Out</a>';
 
?>