<?php
$did = $_GET['did'];
$sqli = mysqli_query($con, "SELECT * FROM `DELETE FROM `tblemailtrack` WHERE id=$did`");
if ($sqli) {
?>
    <script>
        alert('go');
    </script>
<?php
}


?>