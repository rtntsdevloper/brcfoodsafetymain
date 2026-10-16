<?php 
session_start();
$user=$_SESSION['user'];
include 'connection.php';
				
$sno=$_POST['sno'];
   
$sql=mysqli_query($con,"select * from audit where id='$sno'");
$row=mysqli_fetch_array($sql);

$name=$row['auditor'];
require('tcpdf/tcpdf.php');


// create new PDF document
class MYPDF extends TCPDF 
{
private $longTableHeader = '';
private $longTableFooter = '';

    public function Header() 
	{
		$myPageWidth = $this->getPageWidth();
$myPageHeight = $this->getPageHeight();

// Find the middle of the page and adjust.
$myX = ( $myPageWidth / 2 )-70 ;
$myY = ( $myPageHeight / 2 ) -60;

// Set the transparency of the text to really light


        // set bacground image
        $img_file = "images/op.jpg";
        $this->Image($img_file, $myX, $myY, 150,60,'', '', '', false, 100, '', false, false, 0);
	$this->SetFont('centurygothic', '',10);
      $this->writeHTML($this->longTableHeader);
      }
  
    public function setLongTableHeader($html)
   {
     $this->longTableHeader = $html;
   }


   
	 public function Footer() 
	  {
	  $this->SetFont('centurygothic', '',8);
       $this->writeHTML($this->longTableFooter);
	    $this->SetY(-10);
       
        $this->Cell(320, 5, 'PAGE '.$this->getAliasNumPage().' OF '.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	    
		 
     }
	public function setLongTableFooter($html) {
$this->longTableFooter = $html;
}
}

//$fontname = TCPDF_FONTS::addTTFfont('tcpdf/Century Gothic.ttf', 'TrueTypeUnicode', '', 96);

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->SetMargins(PDF_MARGIN_LEFT, 35, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM-10);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}


$pdf->SetFont('centurygothic', '',10);
$pdf->AddPage('P', 'LETTER');
$pdf->SetXY(15,5);


$tblheder=<<<EOD

<table border="1"  width="100%"  cellpadding="10">
  <tr>
  <td width="180" style="text-align:center"><img  src="images/fsato.png" align="center" style="width:150px; "/></td>
  <td width="300" style="text-align:center; padding-top: 30px; font-size:20px;color:#1F3864; font-weight:bold">FSATO Inspection Services </td>
  <td width="180" style="text-align:center;font-size:15px; margin-top:15px;">Forms & Formats </td>
  </tr>
</table>

EOD;
$pdf->writeHTML($tblheder, true, false, true, false, '');
$pdf->setLongTableHeader($tblheder);



$footer=<<<EOD

<table border="1"  width="100%" border="0.5" cellpadding="3">
  <tr>
  <td style="text-align:center">FSATO-IS FM 6.1-06</td>
  <td style="text-align:center; padding-top:15px;">Issue No. 02</td>
  <td style="text-align:center; padding-top:15px;">Approved by CMD</td>
  <td style="text-align:center; padding-top:15px;"></td>
  </tr>
</table>
EOD;
$pdf->setLongTableFooter($footer);
$pdf->SetFont('centurygothic', 'B',14);

$pdf->SetXY(80,35);
$pdf->Write(0, "QUALITY AUDIT", '', '0', '0', true, 'C', false, false, 0);

$pdf->SetXY(15,50);

$pdf->SetFont('centurygothic', '',10);

$tbl_header = '<style>
table
{
   border-spacing: 0;
}
tr
{
   padding: 3px 0;
}

th
 {
   color: #000000;
   font-size: 14px;
   padding-bottom: 4px;
   padding-left: 8px;
   padding-top: 5px;
  
}
td {
   
   font-size: 12px;
   color: #000000;
   padding: 3px 7px 2px;
  
}
</style>
<table id="gallerytab" width="800" cellspacing="0" cellpadding="7" border="1">';
$tbl_footer = '</table>';

$newdate1 = date("d-m-Y", strtotime($row['auditdate']));  


$tbl6=<<<EOD
<table width="650" border="0" style="font-weight:bold; font-size:14px " cellpadding="3" cellspacing="7">
   
  <tr>
    <td>1.1 Name of the Auditor: $row[auditor]</td>
  </tr>
  <tr>
    <td>1.2 Name of the Applicant: $row[fbo]</td>
  </tr>
  <tr>
    <td>1.3 Client reference number: $row[uid] </td>
	
  </tr>
<tr>
   
	<td align="right"> Date of Audit: $newdate1 </td>
  </tr>
 
EOD;
$pdf->writeHTML($tbl6, true, false, true, false, '');


 $tbl16 = '';
$tbl16 .= '
  <tr nobr="true">
    <td width="50" style="font-weight:bold" >S.NO</td>
    <td  width="200" style="font-weight:bold">Requirements</td>
    <td width="200" style="font-weight:bold">Compliant/Non-Compliant </td>
    <td width="200" style="font-weight:bold">Remarks</td>
  </tr>';
  
 $sk=mysqli_query($con,"select * from tblapplication1 where sno='$sno' and name='internalaudit' order by qid asc");
 $i=0;
  while($rt=mysqli_fetch_array($sk))
  {
  $i++;
 
  
   $tbl16 .= '<tr nobr="true">
    <td  >'.$i.'</td>
    <td  width="200">'.$rt['ques'].'</td>';
	if($rt['ans']=="")
	{
	 $tbl16 .=' <td width="200" >Not Applicable</td>';
	}
	else
	{
   $tbl16 .=' <td width="200" >'.$rt['ans'].'</td>';
	}
  $tbl16 .= ' <td  width="200">'.$rt['status'].'</td>
  </tr>';
}
  
$pdf->writeHTML($tbl_header . $tbl16 . $tbl_footer, true, false, false, false, '');

$stf=mysqli_query($con,"select * from tblstaff where firstname='$user'");
$stf1=mysqli_fetch_array($stf);


 $skk=mysqli_query($con,"select * from tblapplication1 where sno='$sno' and name='internalaudit'");
 $skk1=mysqli_fetch_array($skk);

$dtt=date("d-M-Y",strtotime($skk1['date']));

$tbl7=<<<EOD
<table width="650" border="0" style="font-weight:bold; font-size:14px " cellpadding="3" cellspacing="5">
   <tr>
    <td style="font-weight:bold" >Audit Findings:</td>
  </tr>
 
  <tr>
    <td>   $skk1[status1]</td>
    
  </tr>
 
  <tr>
    <td  style="font-weight:bold" >Any requirement for trainings:</td>
  </tr>
  
  <tr>
    <td>   $skk1[status2]</td>
  </tr>
 
  <tr>
    <td>Signature Of $stf1[desg]</td>
  </tr>
  
  <tr>
    <td><img src="images/$stf1[img]" width="100"  /></td>
  </tr>  
  
  <tr>
    <td>$dtt</td>
  </tr>
  
  <tr>
    <td >FSATO-IS  </td>
  </tr>
  
EOD;
$pdf->writeHTML($tbl7, true, false, true, false, '');


$str = preg_replace('/[^A-Za-z0-9_-]/','', $row['uid']);

 $pdf->Output($_SERVER['DOCUMENT_ROOT']."upl1/".$str."-Internal Audit.pdf","F");
					?>
					
					
				<script language="javascript">
				window.open('admin.php?id=viewfbodetail1&sno=<?php echo $sno;?>','_self');
				</script>