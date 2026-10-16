<?php
include '../connection.php';
 $supid = $_GET['supid'];

 $rawdata = mysqli_query($con,"SELECT pname,id FROM `tblrawmaterial` WHERE supid='$supid' order by pname asc") ;
foreach($rawdata as $rawd) {
?>

<option value="<?=  $rawd['id'] ?>"><?=  $rawd['pname'] ?></option>

<?php
}

?>