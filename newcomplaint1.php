<?php
include 'connection.php';
date_default_timezone_set('Europe/London');
$_SESSION['logintime'] = date('Y-m-d h:i:s', time());
$ip = $_SERVER['REMOTE_ADDR'];

$date = date("Y-m-d");
$name = mysqli_real_escape_string($con, $_POST['name']);
$contact = $_POST['contact'];
$email = $_POST['email'];
$sup = $_POST['supplier'];
$catdate = $_POST['compdate'];
$category = $_POST['catcomp'];
$address = mysqli_real_escape_string($con, $_POST['address']);
$product = mysqli_real_escape_string($con, $_POST['product']);
$code = mysqli_real_escape_string($con, $_POST['code']);
$batch = mysqli_real_escape_string($con, $_POST['batch']);



$usedate = $_POST['showOption'];
if($usedate =='Yes'){
    $udate = $_POST['udate'];
}else{
    $udate = $_POST['cdate'];
}

$issue = mysqli_real_escape_string($con, $_POST['issue']);
$file = $_FILES['file']['name'];
move_uploaded_file($_FILES['file']['tmp_name'], "complaint/" . $file);
$catt =  $_POST['catt'];
$channel =  $_POST['channel'];
$country = $_POST['country'];
$customerstore =  $_POST['customerstore'];
$capty =  $_POST['capty'];
$qry = mysqli_query($con, "select * from tblnewcomplaint order by id desc limit 1");
$row = mysqli_fetch_array($qry);
$sno = $row['id'] + 1;
$refno = "REF000" . $sno;






$qry = mysqli_query($con, "INSERT INTO tblnewcomplaint(customer, email, contact, adr, product, pcode, batch, useby, issue, img, date, ipadr,refno, `category`, `compdate`,`supplier`,catt, channel, country, customerstore, capty) 
VALUES ('$name', '$email', '$contact', '$address', '$product', '$code', '$batch', '$udate', '$issue', '$file', '$date', '$ip','$refno','$category','$catdate','$sup', '$catt', '$channel', '$country', '$customerstore', '$capty')");

?>
<script>
    window.open('CFB.php?refno=<?php echo $refno; ?>', '_self');
</script>