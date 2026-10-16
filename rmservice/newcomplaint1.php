<?php
include '../connection.php';
date_default_timezone_set('Europe/London');
$_SESSION['logintime']=date('Y-m-d h:i:s',time());
$ip=$_SERVER['REMOTE_ADDR'];


$date = date('Y-m-d');

$supnm = $_POST['supplier'];
$suptype = $_POST['spt'];
$ncdetail = $_POST['ncdetail'];


if($suptype  == 'Raw Material Supplier' || $suptype == 'Primary Packaging Supplier'){
    $ques = $_POST['ques'];
    $rawm = $_POST['rawm'];
}else{
    $ques = '';
    $rawm = '';
}
$file=$_FILES['file']['name'];
move_uploaded_file($_FILES['file']['tmp_name'],"docs/complaint/".$file);



$qry=mysqli_query($con,"select * from tblsuppliercomplaint order by id desc limit 1");
$row=mysqli_fetch_array($qry);
if(empty($row)){
    $sno = 1;
}
else{
$sno=$row['id']+1;
}









$refno="REF000".$sno;

$qry=mysqli_query($con,"INSERT INTO tblsuppliercomplaint(issue, img, date, refno,`supplier`,suptype,`ucheck`,ucmnt) VALUES
 ('$ncdetail', '$file', '$date','$refno','$supnm','$suptype','$ques','$rawm')");
if($qry){
   ?>
   <script>
window.open('../admin.php?id=complaintadd&refno=<?php echo $refno;?>','_self');

    
     </script>


   <?php
}
else{
    ?>
    <script>
alert('Sorry ! Unable to Process your Nc Right now');

    
     </script>


    <?php
}

?>
