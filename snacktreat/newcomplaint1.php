<?php
include '../connection1.php';
date_default_timezone_set('Europe/London');
$_SESSION['logintime']=date('Y-m-d h:i:s',time());
$ip=$_SERVER['REMOTE_ADDR'];

$date=date("Y-m-d");
$name=mysqli_real_escape_string($con,$_POST['name']);
$contact=$_POST['contact'];
$email=$_POST['email'];
$address=mysqli_real_escape_string($con,$_POST['address']);
$product=mysqli_real_escape_string($con,$_POST['product']);
$code=mysqli_real_escape_string($con,$_POST['code']);
$batch=mysqli_real_escape_string($con,$_POST['batch']);
$udate=$_POST['udate'];
$issue=mysqli_real_escape_string($con,$_POST['issue']);
$file=$_FILES['file']['name'];
move_uploaded_file($_FILES['file']['tmp_name'],"http://nichem.rtnts.com/complaint/".$file);


$qry=mysqli_query($con,"select * from tblnewcomplaint order by id desc limit 1");
$row=mysqli_fetch_array($qry);
$sno=$row['id']+1;
$refno="REF000".$sno;

$qry=mysqli_query($con,"INSERT INTO tblnewcomplaint(customer, email, contact, adr, product, pcode, batch, useby, issue, img, date, ipadr,refno,supplier) VALUES ('$name', '$email', '$contact', '$address', '$product', '$code', '$batch', '$udate', '$issue', '$file', '$date', '$ip','$refno','Snack Treat')");

?>
<script>
window.open('CFB.php?refno=<?php echo $refno;?>','_self');
</script>