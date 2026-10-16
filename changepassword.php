<?php
 date_default_timezone_set("Europe/London");
 include'connection.php';
 session_start();
 
 if(!isset($_SESSION['user']))
 {
 header('location:index.php');
 }
 else
 {
 $user=$_SESSION['user'];
 $access=$_SESSION['access'];
 $headingname=$_SESSION['headingname'];
 }
if($access=="Auditor")
	{
$fields = mysqli_fetch_fields($database, "tblauditor");
$columns = mysqli_num_fields($fields);
for ($i = 0; $i < $columns; $i++) {$field_array[] = mysqli_field_name($fields, $i);}

if (!in_array('userstatus', $field_array))
{
$result = mysqli_query($con,'ALTER TABLE tblauditor ADD userstatus VARCHAR(255)');
}
	
	$sq=mysqli_query($con,"select * from tblauditor where name='$user' and userstatus='change'");
							$match=mysqli_num_rows($sq);
							
							if($match>=1)
							{
							?>
							<script language="javascript">
window.open('admin.php?id=1','_self');
</script>
							<?php
							}
							else
							{
							?>
							<script language="javascript">
window.open('changepassword1.php','_self');
</script>
<?php
}
}
							else if($access=="Auditee")
							{
							
							
$fields1 = mysqli_fetch_fields($database, "tblauditee");
$columns1 = mysqli_num_fields($fields1);
for ($i1 = 0; $i1 < $columns1; $i1++) {$field_array1[] = mysqli_field_name($fields1, $i1);}

if (!in_array('userstatus', $field_array1))
{
$result1 = mysqli_query($con,'ALTER TABLE tblauditee ADD userstatus VARCHAR(255)');
}
	
	$sq1=mysqli_query($con,"select * from tblauditee where name='$user' and userstatus='change'");
							$match1=mysqli_num_rows($sq1);
							
							if($match1>=1)
							{
							?>
							<script language="javascript">
window.open('admin.php?id=1','_self');
</script>
							<?php
							
							}
							else
							{
							?>
	<script language="javascript">
window.open('changepassword1.php','_self');
</script>
<?php
}
			}				else if($access=="Admin")
							{
							
							
$fields2 = mysqli_fetch_fields($database, "tbladmin");
$columns2 = mysqli_num_fields($fields2);
for ($i2 = 0; $i2 < $columns2; $i2++) {$field_array2[] = mysqli_field_name($fields2, $i2);}

if (!in_array('userstatus', $fields2))
{
$result2 = mysqli_query($con,'ALTER TABLE tbladmin ADD userstatus VARCHAR(255)');
}
	
	$sq2=mysqli_query($con,"select * from tbladmin where name='$user' and userstatus='change'");
							$match2=mysqli_num_rows($sq2);
							
							if($match2>=1)
							{
							?>
							<script language="javascript">
window.open('admin.php?id=1','_self');
</script>
							<?php
							
							}
							else
							{
							?>
							<script language="javascript">
window.open('changepassword1.php','_self');
</script>
<?php
}
}
							else if($access=="superadmin")
							{
							?>
							<script language="javascript">
window.open('admin.php?id=1','_self');
</script>
							<?php
							
							}
							else
							{
							?>
							<script language="javascript">
window.open('changepassword1.php','_self');
</script>

							<?php
							}
							?>