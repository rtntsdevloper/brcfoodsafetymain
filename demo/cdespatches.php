
<script language="javascript">
function cal()
{



if(document.form1.dt1.value == "" )
{
document.getElementById('error').innerHTML="Please select start date";
return false;
}
else if(document.form1.dt2.value == "" )
{
document.getElementById('error').innerHTML="Please select end date";
return false;
}

else if(document.form1.s1.value == "" )
{

document.getElementById('error').innerHTML="Please select concession";
return false;
}
else
{
return true;
}
}
</script>
<style type="text/css">
<!--
.style1 {
	font-family: Candara;
	color: #000000;
	font-weight: bold;
}
.style3 {
	font-family: Candara;
	font-style: italic;
	font-weight: bold;
	font-size: 18px;
	color: #3D6E51;
}
.style12 {font-family: Articulate; font-size: 14px; }
-->
</style>
<body>
<table width="928" border="0" align="center">
  <tr>
    <td width="177">&nbsp;</td>
    <td width="576"><span class="style1"></span></td>
    <td width="161"><div align="center"><font face="Candara" size="2">
      <?php
	
	echo"Logged in as ".ucfirst($_SESSION['user']);
	
    ?>
    </font></div></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
</table>
<h4 align="center" class="style3"><u> CONCESSION - WISE DESPATCHES DETAIL </u></h4>
<form name="form1" method="post" action="admin?id=cdespatch1"  onSubmit="return cal();"> 
<p>&nbsp;</p>
<div style="width:850px; height:auto; float:left; background:#ffffff; margin-top: 30px;margin-bottom: 50px; margin-left: 175px;border:#006600 1px solid">
  <table width="847" border="0">
    <tr>
      <td width="99" height="37"><div align="center"><span class="style12">Date from : </span></div></td>
      <td width="153"><input type="date" name="dt1" style="border-radius:5px 0px 5px 0px;border:#43729F 1px groove;" /></td>
      <td width="45"><div align="center"><span class="style12">To :</span> </div></td>
      <td width="201"><input name="dt2" type="date" id="dt2" style="border-radius:5px 0px 5px 0px;border:#43729F 1px groove;" /></td>
      <td width="128"><div align="center"><span class="style12">Select Concession : </span></div></td>
      <td width="143"><select style="border-radius:5px 0px 5px 0px;border:#43729F 1px groove;max-width:140px"  name="s1">
        <option value="">Select Concession</option>
        <?PHP
include 'connection.php';
$sql=mysql_query("select * from tblconcession order by consname asc");
while($row=mysql_fetch_array($sql))
{
?>
        <option value="<?php echo $row['consname'];?>"><?php echo $row['consname']?></option>
        <?php }
?>
      </select></td>
      <td width="48"><div  style="width:32px;height:25px;float:left;background:#4E894E;border-radius:5px">
          <div align="center">
            <input type="submit" name="submit" value="go" style="border: 1px hidden; background:none;color:#fff;font-size:13px;font-weight:bold; "/>
          </div>
      </div></td>
    </tr>
  </table>
</div>
<p>&nbsp;</p>
</form>

<div id="error" style="color:#FF0000;font-family:Calibri;margin-left:100px"><?php
if(isset($_GET['msg']))
{
 echo "You have selected more than  7 days";

}
?>
</div>
</body>
