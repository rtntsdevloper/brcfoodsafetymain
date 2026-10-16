<?php
session_start();

include 'connection.php';


// $fields = mysqli_fetch_fields($database, "tblaction");
// $columns = mysqli_num_fields($fields);
// for ($i = 0; $i < $columns; $i++) {$field_array[] = mysqli_field_name($fields, $i);}

// if (!in_array('preventive', $field_array))
// {
// $result = mysqli_query($con,'ALTER TABLE tblaction ADD preventive VARCHAR(2555)');
// }



// $fields1 = mysqli_fetch_fields($database, "tblaction1");
// $columns1 = mysqli_num_fields($fields1);
// for ($i1 = 0; $i1 < $columns1; $i1++) {$field_array[] = mysqli_field_name($fields1, $i1);}

// if (!in_array('status1', $field_array))
// {
// $result1= mysqli_query($con,'ALTER TABLE tblaction1 ADD status1 VARCHAR(255)');
// $result2= mysqli_query($con,'ALTER TABLE tblaction1 ADD status2 VARCHAR(255)');
// $result3= mysqli_query($con,'ALTER TABLE tblaction1 ADD status3 VARCHAR(255)');
// }


// $fields2 = mysqli_fetch_fields($database, "tblauditsection2");
// $columns2 = mysqli_num_fields($fields1);
// for ($i2= 0; $i2 < $columns2; $i2++) {$field_array[] = mysqli_field_name($fields2, $i2);}

// if (!in_array('img', $field_array))
// {
// $result3= mysqli_query($con,'ALTER TABLE tblauditsection2 ADD img VARCHAR(255)');

// }

// $fields3 = mysqli_fetch_fields($database, "tbldetail");
// $columns3 = mysqli_num_fields($fields3);
// for ($i3= 0; $i3 < $columns3; $i3++) {$field_array[] = mysqli_field_name($fields3, $i3);}

// if (!in_array('issuedate', $field_array))
// {
// $result3= mysqli_query($con,'ALTER TABLE tbldetail ADD issuedate date NOT NULL, ADD ver VARCHAR(255), ADD authrisedby VARCHAR(255),  ADD reason VARCHAR(255),ADD recertification	date NOT NULL');
// }


// $fields4 = mysqli_fetch_fields($database, "tblgmpaudit3");
// $columns4 = mysqli_num_fields($fields4);
// for ($i4= 0; $i4 < $columns4; $i4++) {$field_array[] = mysqli_field_name($fields4, $i4);}

// if (!in_array('auditsection', $field_array))
// {
// $result4= mysqli_query($con,'ALTER TABLE tblgmpaudit2  ADD auditsection VARCHAR(255) NOT NULL , ADD auditsection1 VARCHAR(255) NOT NULL');
// }


$user = $_POST['user'];
$pwd =  $_POST['pwd'];



 $mn=mysqli_query($con,"select * from tblmain where status='portal'");
 $mn1=mysqli_fetch_assoc($mn);
 $_SESSION['headingname']='BRCGS Portal';
 $tabs="";
  $mnn=mysqli_query($con,"select * from tbltabs");
 while($mnn1=mysqli_fetch_assoc($mnn))
 {
 $tabs.=$mnn1['sno'].";";
 }

if($user=="param" && $pwd=="12122")
{
$_SESSION['user']="Paramvir Deol";
$_SESSION['access']="Admin";
$_SESSION['tabs']=$tabs;
?>

<script language="javascript">
window.open('admin.php?id=1','_self');
</script>
<?php
}

else 
{
$sqlf=mysqli_query($con,"select * from tbladmin where username='$user' and pwd='$pwd' and status!='sncl'");
$matchf=mysqli_num_rows($sqlf);
$ghl=mysqli_fetch_assoc($sqlf);
if($matchf>=1)
{  
$_SESSION['user']=$ghl['name'];
$_SESSION['access']=$ghl['status'];
$_SESSION['tabs']=$ghl['tabs'];
?>
<script language="javascript">
window.open('admin.php?id=1','_self');
</script>
<?php
}
else if($matchf<=0)
{
$sql=mysqli_query($con,"select * from tblstaff where uname='$user' and pwd='$pwd' and status='active'");
$match=mysqli_num_rows($sql);
$gh=mysqli_fetch_assoc($sql);
if($match>=1)
{
$_SESSION['user']=$user;
$_SESSION['access']=$gh['access'];
?>
<script language="javascript">
window.open('onlinetraining/admin.php?id=1','_self');
</script>
<?php
}
else if($match<=0)
{
 

$sqle=mysqli_query($con,"select * from tblauditor where user='$user' and pwd='$pwd' and status='Active'");
$matche=mysqli_num_rows($sqle);
$ghe=mysqli_fetch_assoc($sqle);

if($matche>=1)
{
$_SESSION['user']=$ghe['name'];
$_SESSION['access']="Auditor";
$_SESSION['tabs']=$ghe['tabs'];
?>
<script language="javascript">
window.open('admin.php?id=1','_self');
</script>

<?php
}
else if($matche<=0)
{
$sqlf=mysqli_query($con,"select * from tblauditee where uname='$user' and pwd='$pwd'");
$matchf=mysqli_num_rows($sqlf);
$ghf=mysqli_fetch_assoc($sqlf);
if($matchf>=1)
{
$_SESSION['user']=$ghf['name'];
 $_SESSION['access']="Auditee";
 $_SESSION['tabs']=$ghf['tabs'];
 
 
?>
<script language="javascript">
window.open('admin.php?id=1','_self');
</script>

<?php
}
else if($matchf<=0)
{
$sqlf=mysqli_query($con,"select * from tbladmin where username='$user' and pwd='$pwd' and status='sncl'");
$matchw=mysqli_num_rows($sqlf);
$ghl=mysqli_fetch_assoc($sqlf);
if($matchw>=1)
{  
$_SESSION['user']=$ghl['name'];
?>
<script language="javascript">
window.open('snclproduct.php','_self');
</script>
<?php
}
else if($matchw<=0)
{
?>
<script language="javascript">
// window.open('index.php?msg=1','_self');
</script>
<?php
}
}
else
{
?>
<script language="javascript">
// window.open('index.php?msg=1','_self');
</script>
<?php
}
}
}
}
}
?>