<?php
include '../connection.php';

if (isset($_GET['batchcode'])) {
    $batchcode = $_GET['batchcode'];
    $query = "SELECT COUNT(*) FROM tblcookingccp WHERE batchcode = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $batchcode);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    echo $count > 0 ? "exists" : "available";
}
?>
