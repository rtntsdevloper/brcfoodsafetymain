<?php

// include 'connection.php';

// date_default_timezone_set('Europe/London');

session_start();


session_unset();
session_destroy();

// $_SESSION['logouttime']=date('Y-m-d h:i:s',time());

// $sql=mysqli_query($con,"update tblsecurity set logout='$_SESSION[logouttime]' where id='$_SESSION[serialno]'");


// if (isset($_SERVER['HTTP_COOKIE'])) {

//     $cookies = explode(';', $_SERVER['HTTP_COOKIE']);

//     foreach($cookies as $cookie) {

//         $parts = explode('=', $cookie);

//         $name = trim($parts[0]);

//         setcookie($name, '', time()-1000);

//         setcookie($name, '', time()-1000, '/');

//     }

// }


?>
<script>
window.open('index.php','_self');
</script>