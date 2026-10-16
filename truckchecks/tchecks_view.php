<?php
$sno = $_GET['pro'];
$sq2 = mysqli_query($con, "select * from tbl_truckc where id='$sno'");
$qu2 = mysqli_fetch_array($sq2);








$dt = date("d-m-Y", strtotime($qu2['tdate']));
$tname = "Vehicle safety checks";

require('tcpdf/tcpdf.php');

class MYPDF extends TCPDF
{
  private $longTableFooter = '';


  public function Header()
  {

    $image_file = 'images/1.png';
    $image_file1 = 'images/rtnts.png';

    $this->Image($image_file, 15, 5, 20, '', 'png', '', 'T', false, 200, '', false, false, 0, false, false, false);
    $this->Image($image_file1, 170, 5, 35, '', 'png', '', 'T', false, 200, '', false, false, 0, false, false, false);

    $this->SetFont('courier', '', 20);
    $this->SetXY(43, 2);
    $this->Write(25, 'Vehicle safety checks Report', '', 0, '30', true, 0, false, false, 0);
  }
  public function Footer()
  {
    $this->SetFont('courier', '', 8);
    $this->writeHTML($this->longTableFooter);
    $this->SetY(-10);

    $this->Cell(328, 5, 'Printed: ' . date('d-m-Y H:i A'), 0, false, 'C', 0, '', 0, false, 'T', 'M');
  }
  public function setLongTableFooter($html)
  {
    $this->longTableFooter = $html;
  }
}
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, false, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);

$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
  require_once(dirname(__FILE__) . '/lang/eng.php');
  $pdf->setLanguageArray($l);
}

$pdf->AddPage('P', 'LETTER');
$footer = <<<EOD

<table border="1"  width="100%" border="0.5" cellpadding="3">
  <tr>
  <td style="text-align:center">Version: 02 </td>
  <td style="text-align:center; padding-top:15px;">Issue Date. 13/02/2022</td>
  <td style="text-align:center; padding-top:15px;">Approved by: Alex Fubini</td>
  <td style="text-align:center; padding-top:15px;"></td>
  </tr>
</table>
EOD;
$pdf->setLongTableFooter($footer);

$pdf->SetFont('courier', '', 14);
$pdf->SetXY(15, 40);
$pdf->Write(0, "Date created: $dt", '', '0', '0', true, 'C', false, false, 0);
$pdf->SetXY(15, 47);
$pdf->Write(0, "$tname", '', '0', '0', true, 'C', false, false, 0);
$pdf->SetXY(15, 54);
$pdf->Write(0, "Driver Name: $qu2[name]", '', '0', '0', true, 'C', false, false, 0);
$pdf->SetXY(15, 60);
$pdf->Write(0, "Vehicle Reg no.: $qu2[vehicle]", '', '0', '0', true, 'C', false, false, 0);
$pdf->SetXY(10, 80);


$pdf->SetFont('courier', '', 11);
$tblimg = "";
if($qu2['vehicle']=='RF25 PMX'){

$tblimg .= '<h3>Any anomalies found using the key letter as follow: D for any dents, S for any scratches, R for any rust,M for any missing part and N for no issue.</h3>
<br><br>
<table >
 <tr>
 <td width="20%"><img src="truckchecks/combo 12.jpg" alt="Signature" width="110" height="80"></td>
  <td width="20%"><img src="truckchecks/combo 14.jpg" alt="Signature" width="110" height="80"></td>
   <td width="30%"><img src="truckchecks/combo 13.jpg" alt="Signature" width="200" height="80"></td>
    <td width="30%"><img src="truckchecks/combo11.jpg" alt="Signature" width="200" height="80"></td>
 
 </tr>
 <tr style="text-align:center">
 <td width="20%" style="color:blue">(1)</td>
  <td width="20%" style="color:blue">(2)</td>
   <td width="30%" style="color:blue">(3)</td>
    <td width="30%" style="color:blue">(4)</td>
 
 </tr>
</table>';
}else{
$tblimg .= '

<table >
 <tr>
 <td width="20%"><img src="truckchecks/vauxhall-1.png" alt="Signature" width="110" height="80"></td>
  <td width="20%"><img src="truckchecks/vauxhall-2.png" alt="Signature" width="110" height="80"></td>
   <td width="30%"><img src="truckchecks/vauxhall-3.png" alt="Signature" width="200" height="80"></td>
    <td width="30%"><img src="truckchecks/vauxhall-4.png" alt="Signature" width="200" height="80"></td>
 
 </tr>
 <tr style="text-align:center">
 <td width="20%" style="color:blue">(1)</td>
  <td width="20%" style="color:blue">(2)</td>
   <td width="30%" style="color:blue">(3)</td>
    <td width="30%" style="color:blue">(4)</td>
 
 </tr>
</table>';
}
$pdf->writeHTML($tblimg, true, false, false, false, '');

$tbl_header = '<style>
table {
   border-collapse: collapse;
   border-spacing: 0;
   margin: 0 10px;
   border:0.5px solid #000000;
}
tr {
   padding: 1px 0;
}
th {
   padding: 1px 0;
   color:blue;
}

</style>
<table id="gallerytab" width="100%" cellspacing="0" cellpadding="3" border="0.2">

  <tr nobr="true"> 
      <td width="120" >Question</td>
       <td  width="500" >Any anomalies found on vehicle </td>
   </tr>
   
	<tr nobr="true"> 
	 <td width="120">Answer</td>
       <td  width="500" style="color:green">' . $qu2["tselct"] . '</td>
   </tr>
   <tr nobr="true"> 
	 <td width="120">Comment</td>
       <td  width="500" style="color:green">' . $qu2["cmnt"] . '</td>
   </tr>
   <tr nobr="true"> 
	 <td colspan="2"><b align="center">Additional checks</b></td>
       
   </tr>



';
$tbl_footer = '</table>';
$tbl1 = "";
$ans = $qu2['ansall'];
$ans1 = explode(';', $ans);
$a = 0;
$ghf = mysqli_query($con, "SELECT * FROM `tbl_truckques`");
while ($rowsf = mysqli_fetch_array($ghf)) {



  $tbl1 .= '
  <tr nobr="true"> 
      <td width="120" >Question</td>
       <td  width="500" >' . $rowsf['question'] . '</td>
   </tr>
   
	<tr nobr="true"> 
	 <td width="120">Answer</td>
       <td  width="500" style="color:green">' . $ans1[$a] . '</td>
   </tr>';


  $a++;
}


$pdf->writeHTML($tbl_header . $tbl1 . $tbl_footer, true, false, false, false, '');

$date = $dt . "_" . rand(111, 555);
// $pdf->Output($_SERVER['DOCUMENT_ROOT'] . "/truckchecks/pdf/" . $date . ".pdf", "F");  // online
$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "brcfoodsafety/truckchecks/pdf/".$date.".pdf","F");



?>

<div class="main-content">

  <div class="container-fluid " style="margin-top:20px;">
    <div class="row mb-12">
      <div class="col-md-12 mb-12">
        <div class="card text-left">
          <div class="card-body">

            <a href="admin.php?id=trcheck"><button class="btn btn-primary mb-3"
                style="float:right; margin-left:15px">Go Back</button></a>



            <h4 class="card-title mb-3">Vehicle safety checks Report</h4>

            <div class="embed-responsive embed-responsive-4by3" style="height: 678px;">
              <iframe class="embed-responsive-item w-100 h-70" src="truckchecks/pdf/<?php echo $date; ?>.pdf" allowfullscreen></iframe>
            </div>



          </div>
        </div>
      </div>
    </div>
  </div>