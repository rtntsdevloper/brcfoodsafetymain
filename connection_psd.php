<?php
$phost = "localhost"; 
$pusername = "root";  
$ppassword = ""; 
$pdatabase = "psd";


$pcon =  mysqli_connect("$phost","$pusername","$ppassword","$pdatabase");

mysqli_set_charset($con,'utf8');
 
?>
