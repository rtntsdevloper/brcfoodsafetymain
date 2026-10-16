 <?php
include 'connection.php';

$cdate = date('Y-m-d');
$timedatetime = date('Y-m-d H:i:s');

$user = $_GET['user'];

$tid = $_GET['tid'];

// Insert query for dailycheckss
$insert_query = "INSERT INTO dailycheckss (name, date, user, timedatetime) 
                 VALUES ('$tid', '$cdate', '$user', '$timedatetime')";

if(mysqli_query($con, $insert_query)) {
    echo "Record inserted successfully!";
} else {
    echo "Error: " . mysqli_error($con);
}
?>