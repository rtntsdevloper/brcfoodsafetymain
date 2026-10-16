<?php
include 'connection.php';
$consname=$_GET['consname'];

?>


<style type="text/css">
<!--
.style1 {
	font-family: Candara;
	color: #000000;
	font-weight: bold;
}
.myButton {	-moz-box-shadow:inset 0px 1px 0px 0px #bbdaf7;
	-webkit-box-shadow:inset 0px 1px 0px 0px #bbdaf7;
	box-shadow:inset 0px 1px 0px 0px #bbdaf7;
	background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #79bbff), color-stop(1, #378de5));
	background:-moz-linear-gradient(top, #79bbff 5%, #378de5 100%);
	background:-webkit-linear-gradient(top, #79bbff 5%, #378de5 100%);
	background:-o-linear-gradient(top, #79bbff 5%, #378de5 100%);
	background:-ms-linear-gradient(top, #79bbff 5%, #378de5 100%);
	background:linear-gradient(to bottom, #79bbff 5%, #378de5 100%);
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#79bbff', endColorstr='#378de5',GradientType=0);
	background-color:#79bbff;
	-moz-border-radius:6px;
	-webkit-border-radius:6px;
	border-radius:6px;
	border:1px solid #84bbf3;
	display:inline-block;
	cursor:pointer;
	color:#ffffff;
	font-family:arial;
	font-size:12px;
	font-weight:bold;
	padding:6px 24px;
	text-decoration:none;
	text-shadow:0px 1px 0px #528ecc;
}
.myButton1 {-moz-box-shadow:inset 0px 1px 0px 0px #bbdaf7;
	-webkit-box-shadow:inset 0px 1px 0px 0px #bbdaf7;
	box-shadow:inset 0px 1px 0px 0px #bbdaf7;
	background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #79bbff), color-stop(1, #378de5));
	background:-moz-linear-gradient(top, #79bbff 5%, #378de5 100%);
	background:-webkit-linear-gradient(top, #79bbff 5%, #378de5 100%);
	background:-o-linear-gradient(top, #79bbff 5%, #378de5 100%);
	background:-ms-linear-gradient(top, #79bbff 5%, #378de5 100%);
	background:linear-gradient(to bottom, #79bbff 5%, #378de5 100%);
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#79bbff', endColorstr='#378de5',GradientType=0);
	background-color:#79bbff;
	-moz-border-radius:6px;
	-webkit-border-radius:6px;
	border-radius:6px;
	border:1px solid #84bbf3;
	display:inline-block;
	cursor:pointer;
	color:#ffffff;
	font-family:arial;
	font-size:12px;
	font-weight:bold;
	padding:6px 24px;
	text-decoration:none;
	text-shadow:0px 1px 0px #528ecc;
}
::-webkit-input-placeholder { /* WebKit browsers */
    color:    #666666;
}
:-moz-placeholder { /* Mozilla Firefox 4 to 18 */
    color:     #666666;
}
::-moz-placeholder { /* Mozilla Firefox 19+ */
    color:     #666666;
}
:-ms-input-placeholder { /* Internet Explorer 10+ */
    color:     #666666;
}

.myButton {
	-moz-box-shadow:inset 0px 1px 0px 0px #bbdaf7;
	-webkit-box-shadow:inset 0px 1px 0px 0px #bbdaf7;
	box-shadow:inset 0px 1px 0px 0px #bbdaf7;
	background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #79bbff), color-stop(1, #378de5));
	background:-moz-linear-gradient(top, #79bbff 5%, #378de5 100%);
	background:-webkit-linear-gradient(top, #79bbff 5%, #378de5 100%);
	background:-o-linear-gradient(top, #79bbff 5%, #378de5 100%);
	background:-ms-linear-gradient(top, #79bbff 5%, #378de5 100%);
	background:linear-gradient(to bottom, #79bbff 5%, #378de5 100%);
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#79bbff', endColorstr='#378de5',GradientType=0);
	background-color:#79bbff;
	-moz-border-radius:6px;
	-webkit-border-radius:6px;
	border-radius:6px;
	border:1px solid #84bbf3;
	display:inline-block;
	cursor:pointer;
	color:#ffffff;
	font-family:arial;
	font-size:12px;
	font-weight:bold;
	padding:6px 24px;
	text-decoration:none;
	text-shadow:0px 1px 0px #528ecc;
}
.myButton:hover {
	background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #378de5), color-stop(1, #79bbff));
	background:-moz-linear-gradient(top, #378de5 5%, #79bbff 100%);
	background:-webkit-linear-gradient(top, #378de5 5%, #79bbff 100%);
	background:-o-linear-gradient(top, #378de5 5%, #79bbff 100%);
	background:-ms-linear-gradient(top, #378de5 5%, #79bbff 100%);
	background:linear-gradient(to bottom, #378de5 5%, #79bbff 100%);
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#378de5', endColorstr='#79bbff',GradientType=0);
	background-color:#378de5;
}
.myButton:active {
	position:relative;
	top:1px;
}
.myButton11 {-moz-box-shadow:inset 0px 1px 0px 0px #bbdaf7;
	-webkit-box-shadow:inset 0px 1px 0px 0px #bbdaf7;
	box-shadow:inset 0px 1px 0px 0px #bbdaf7;
	background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #79bbff), color-stop(1, #378de5));
	background:-moz-linear-gradient(top, #79bbff 5%, #378de5 100%);
	background:-webkit-linear-gradient(top, #79bbff 5%, #378de5 100%);
	background:-o-linear-gradient(top, #79bbff 5%, #378de5 100%);
	background:-ms-linear-gradient(top, #79bbff 5%, #378de5 100%);
	background:linear-gradient(to bottom, #79bbff 5%, #378de5 100%);
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#79bbff', endColorstr='#378de5',GradientType=0);
	background-color:#79bbff;
	-moz-border-radius:6px;
	-webkit-border-radius:6px;
	border-radius:6px;
	border:1px solid #84bbf3;
	display:inline-block;
	cursor:pointer;
	color:#ffffff;
	font-family:arial;
	font-size:12px;
	font-weight:bold;
	padding:6px 24px;
	text-decoration:none;
	text-shadow:0px 1px 0px #528ecc;
}
.style3 {
	font-family: Candara;
	color: #285C40;
	font-style: italic;
	font-size: 18px;
}
.error
{
width:200px;
height: 20px;
float:left;
color:#CC33FF;
margin-left:30px;
}
.style4 {
	font-family: Calibri;
	font-weight: bold;
}
.TFtable td{ 
		padding:7px;height:20px; border:#90C967 1px solid;
	}
	/* provide some minimal visual accomodation for IE8 and below */
	
	/*  Define the background color for all the ODD background rows  */
	.TFtable tr:nth-child(odd)
	{ 
		background:#D4EDC3;
		
		font-family:Candara;
	}
	/*  Define the background color for all the EVEN background rows  */
	.TFtable tr:nth-child(even){
		background:#DDFFDD;
		font-family:Candara;
	}
	.TFtable tr:nth-child(even):hover
	{
	background-color:#FFFFEC;
	
	}
	.TFtable tr:nth-child(odd):hover
	{
	background-color:#FFFFEC;
	}
.style5 {font-family: Articulate}
.style84 {	color: #000000;
	font-size: 16px;
	font-family:Candara;
}
.style85 {font-family: Candara}
.myButton112 {-moz-box-shadow:inset 0px 1px 0px 0px #bbdaf7;
	-webkit-box-shadow:inset 0px 1px 0px 0px #bbdaf7;
	box-shadow:inset 0px 1px 0px 0px #bbdaf7;
	background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #79bbff), color-stop(1, #378de5));
	background:-moz-linear-gradient(top, #79bbff 5%, #378de5 100%);
	background:-webkit-linear-gradient(top, #79bbff 5%, #378de5 100%);
	background:-o-linear-gradient(top, #79bbff 5%, #378de5 100%);
	background:-ms-linear-gradient(top, #79bbff 5%, #378de5 100%);
	background:linear-gradient(to bottom, #79bbff 5%, #378de5 100%);
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#79bbff', endColorstr='#378de5',GradientType=0);
	background-color:#79bbff;
	-moz-border-radius:6px;
	-webkit-border-radius:6px;
	border-radius:6px;
	border:1px solid #84bbf3;
	display:inline-block;
	cursor:pointer;
	color:#ffffff;
	font-family:arial;
	font-size:12px;
	font-weight:bold;
	padding:6px 24px;
	text-decoration:none;
	text-shadow:0px 1px 0px #528ecc;
}
-->
</style>
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
<h5 align="center" class="style3"><u>View Detail <font color="#FF0000"></font> </u></h5>
 
<div style="width:870px;height:auto;float:left;margin:15px;margin-left:150px;border:#74BA43 0px solid;border-radius:4px;">
   <table width="850" border="1" align="center" style="border:#285C40 1px groove;border-radius:2px;border-collapse:collapse" id="gview">
    <tr>
       <td width="30" height="34"> <div align="center"><span class="style87">Sno</span></div> </td>
       <td width="72"> <div align="center"><span class="style87">Category</span></div> </td>
	    <td width="196"> <div align="center"><span class="style87">Product </span></div> </td>
       <td width="196"> <div align="center"><span class="style87">Quantity </span></div> </td>
       <td width="97"> <div align="center"><span class="style87">Remove</span></div> </td>
     </tr>
	 
	  <?php
	  $sql=mysql_query("select * from  tbldemo ");
	  $i=0;
	 while($r = mysql_fetch_array($sql))
	 {
	 $i++;
	 ?>
	 
    <tr>
      <td height="34"><?php echo $i;?></td>
      <td><?php echo $r['category'];?></td>
      <td><?php echo $r['product'];?></td>
      <td><?php echo $r['quantity'];?></td>
	  <td><a href="del.php?id=<?php echo $r['id'];?>&consname=<?php echo $consname;?>" onclick="return('Are You Sure?')"><input name="submit" type="submit" id="d1" value="Remove" class="myButton112"/></a></td>
    </tr>
	<?php
	}
	?>
	
  </table>
    
	<p>&nbsp;</p>
  <table width="870" border="0">
  <tr>
    <td width="326">&nbsp;</td>
    <td width="137"><div align="center">
      <a href="admin.php?id=despatch1&consname=<?php echo $consname;?>"><input name="submit" type="button" id="d1" value="Add New" class="myButton11"/></a>
    </div></td>
    <td width="126"><div align="center">
      <a href="despatch5.php?consname=<?php echo $consname;?>"><input name="cncl" type="button" value="Generate GDN"  class="myButton11" /></a>
    </div></td>
    <td width="263">&nbsp;</td>
  </tr>
</table>

</div>