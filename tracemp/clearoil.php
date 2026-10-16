<?php

$qst = mysqli_query($con, "Select * from tblfrybatch where status='Active'");

$qst1 = mysqli_fetch_array($qst);
$qstid = $qst1['id'];

$odate = date('d-m-Y');
// print_r("Update `tblfrybatch` SET status='Drain', draindate='$odate' where id='$qstid' ");die;
$qst3 = mysqli_query($con, "Update `tblfrybatch` SET status='Drain', draindate='$odate' where id='$qstid' ");
if ($qst3) {
?>
    <script>
        alert('Previous Oil Drain Sucessfully!')
        document.location.href = 'admin.php?id=drainoil';
    </script>
<?php
}

?>