<?php 
$date = new DateTime('2025-03-04'); 
$date->sub(new DateInterval('P7D')); 
echo $date->format('Y-m-d') . "\n"; 
?>