
<?php
$dt1 = $_GET['dte1'];
$dt2 = $_GET['dte2'];
$consid = $_GET['consid'];
$gdnno = $_GET['gdno'];
   include 'connection.php';
	$d = mysql_query("select * from tblconcession where consid='$consid'");
	while($e = mysql_fetch_array($d))
	{
	$consname = $e['consname'];
	}
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
<h5 align="center" class="style3"><u>  DETAIL OF ITEMS FOR DISPATCH NUMBER <font color="#FF0000"><?php echo $gdnno;?></font> </u></h5>
  <table width="643" border="0" align="center">
    <tr>
      <td width="416" height="30">&nbsp;</td>
      <td width="141"><div style="width:160px;height:23px;float:left;margin-left:0px;margin-bottom:0px;border:1px solid #74BA43;border-radius: 5px;box-shadow: 0 0 2px 1px  #285C40; background-color: #D4EDC3; font: Candara; font-size:18px;">
        <div align="left">
          <table width="160" >
            <tr>
              <td width="33"><div align="center"><span class="style84"><img src="../images/pdf-icon.png" width="19" height="19" /></span></div></td>
              <td width="113"><a href="pdf/cdespatch<?php echo $dt1; ?>-<?php echo $dt2;?>-<?php echo $gdnno;?>.pdf" download="download"><span class="style84"> Download Pdf </span></a></td>
            </tr>
          </table>
        </div>
      </div></td>
      <td width="19"><img src="../images/back_button.png" width="19" height="19"></td>
	 
      <td width="49"><div align="center"><span class="style4"><a href="admin.php?id=cdespatch1&dt1=<?php echo $dt1;?>&dt2=<?php echo $dt2;?>&s1=<?php echo $consid;?>" style="color:#000000">Back</a></span></div></td>
    </tr>
</table>
  <table class="TFtable" width="639" align="center" border="1" style="border: #006633 1px solid; border-collapse:collapse">
    <tr style="border: #006633 1px solid;">
      <td width="158" height="35" bgcolor="#9DCF9D" style="border-bottom:#006600 1px solid;border-right:#006600 1px solid"><div align="center" class="style1"><span class="style118">Item  n0 </span></div></td>
      <td width="220" bgcolor="#9DCF9D" style="border-bottom:#006600 1px solid;border-right:#006600 1px solid"><div align="center" class="style1">Product name </div></td>
      <td width="138" bgcolor="#9DCF9D" style="border-bottom:#006600 1px solid;border-right:#006600 1px solid"><div align="center" class="style1">Tray barcode </div></td>
      <td width="95" bgcolor="#9DCF9D" style="border-bottom:#006600 1px solid;"><div align="center" class="style1">Quantity</div></td>
    </tr>
    <?php
$dt1 = $_GET['dte1'];
$dt2 = $_GET['dte2'];
$consid = $_GET['consid'];
$gdnno = $_GET['gdno'];
 

 include 'connection.php';
   $sql = mysql_query("select * from tblgdnitems where gdnno='$gdnno'");
   $num = mysql_num_rows($sql);
   if($num <=0)
   {
   ?>
    <tr >
      <td height="39" colspan="4" style="font-family:Calibri;font-size:12px"><div align="center" class="style5">No Result Found ! </div></td>
    </tr>
    <?php
   }
   else
   {
 while($r = mysql_fetch_array($sql))
 {

	   ?>
    <tr >
      <td height="39" style="font-family:Calibri;font-size:12px"><div align="center"><span class="style1">
          <?php 
	  
	  echo $r['itemno'];?>
      </span></div></td>
      <td style="font-family:Calibri;font-size:12px"><div align="left" style="margin-left:15px;"><span class="style1">
          <?php 
	  $rt = mysql_query("select * from tblproduct where prodid='$r[prodid]'");
	  while($rt1 = mysql_fetch_array($rt))
	  echo $rt1['prodname'];?>
      </span></div></td>
      <td style="font-family:Calibri;font-size:12px"><div align="center"><span class="style1">
        <?php
	 
	   echo $r['traybarcode']?>
      </span></div></td>
      <td style="font-family:Calibri;font-size:12px"><div align="center"><span class="style1">
        <?php 
	  echo $r['qty'];?>
      </span></div></td>
    </tr>
    <?php
	   }}
	   ?>
  </table>
  <p>&nbsp;</p>

<?php
$date = date_create($dt1);
$dt11 = date_format($date, 'd-m-Y');
 $date1 = date_create($dt2);
$dt22 = date_format($date1, 'd-m-Y');


require('../tcpdf/tcpdf.php');
ini_set('max_execution_time', 300);
$upit = "select * from tblgdnitems where gdnno='$gdnno'";
$result = mysql_query($upit);

// create new PDF document
class MYPDF extends TCPDF {

    public function Header() {
       $image_file = '../images/image001.png';
        $this->Image($image_file, 90, 2, 30, '', 'PNG', '', 'T', false, 200, '', false, false, 0, false, false, false);
     
        
    }

    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(20, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
		      
    }
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 003');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);


$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);


$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

$pdf->SetFont('helvetica', 'B', 10);


$pdf->AddPage();
$pdf->SetXY(68,30);
$pdf->Write(0, 'CONCESSON - WISE DESPATCHES REPORT', '', 0, '30', true, 0, false, false, 0);
$pdf->SetFont('helvetica', '', 9);

$pdf->SetXY(88,40);
$pdf->Write(0, 'HBH FOODS', '', 0, '30', true, 0, false, false, 0);
$pdf->SetFont('helvetica', '', 7);

$pdf->SetXY(88,45);
$pdf->Write(0, 'Riverwalk Business Park, Riverwalk Rd', '', 0, '30', true, 0, false, false, 0);
$pdf->SetXY(88,48);
$pdf->Write(0, 'Enfield (London) - EN3 7QN', '', 0, '30', true, 0, false, false, 0);
$pdf->SetXY(88,51);
$pdf->Write(0, 'Tel: 020 8344 9780', '', 0, '30', true, 0, false, false, 0);
$pdf->SetXY(88,54);
$pdf->Write(0, 'Email: hbhfoods@hbsupplychain.co.uk', '', 0, '30', true, 0, false, false, 0);
$pdf->SetXY(88,57);
$pdf->Write(0, 'Website: www.hbsupplychain.co.uk', '', 0, '30', true, 0, false, false, 0);
$pdf->SetXY(40,70);
$pdf->Write(0, 'Despatch Number : '.$gdnno, '', 0, '30', true, 0, false, false, 0);
$pdf->SetXY(40,74);
$pdf->Write(0, 'Concession : '.$consname, '', 0, '30', true, 0, false, false, 0);
$pdf->SetXY(138,74);
$pdf->Write(0, 'Date : '.$dt11.' to '.$dt22, '', 0, '30', true, 0, false, false, 0);
$pdf->SetFont('helvetica', '', 1);
$pdf->SetXY(40,78);

$tbl_header = '<style>
table {
   border-collapse: collapse;
   border-spacing: 0;
   margin: 0 10px;
}
tr {
   padding: 3px 0;
}

th {
   background-color: #CCCCCC;
   border: 1px solid #000000;
   color: #333333;
   font-family: trebuchet MS;
   font-size: 11px;
   font-weight: bold;
   padding-bottom: 4px;
   padding-left: 8px;
   padding-top: 5px;
   text-align: left;
}
td {
   background-color: #EEEEEE;
   border: 1px solid #000000;
   font-size: 9px;
   color: #000000;
   padding: 3px 7px 2px;
}
</style>
<table id="gallerytab" width="950" cellspacing="0" cellpadding="7" border="0">
<tr style="border: #006633 1px solid;">
        
		<th width="110" ><div align="center"><span class="style118">Item no</span></div></th>
         <th width="150" ><div align="center"><span class="style118">Product name</span></div></th>
         <th width="110" ><div align="center"><span class="style118">Tray Barcode </span></div></th>
         <th width="110" ><div align="center"><span class="style118">Quantity </span></div></th>
         
       </tr>';
$tbl_footer = '</table>';
$tbl = '';

while ($row= mysql_fetch_assoc($result)) {
	$rt = mysql_query("select * from tblproduct where prodid='$row[prodid]'");
	  while($rt1 = mysql_fetch_array($rt))
	  {
	$pname =$rt1['prodname'];	
		}
		
		
		 

$tbl .= '
   <tr> 
     
       <td><div align="left">'.$row['itemno'].'</div></td>
       <td><div align="left">'.$pname.'</div></td>
       <td><div align="center">'.$row['traybarcode'].'</div></td>
       <td><div align="center">'.$row['qty'].'</div></td>
      
   </tr>
';
}

// output the HTML content
$pdf->writeHTML($tbl_header . $tbl . $tbl_footer, true, false, false, false, '');
//$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document

$pdf->Output("pdf/cdespatch".$dt1."-".$dt2."-".$gdnno.".pdf","F");
?>
