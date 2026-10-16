<?php
include 'connection.php';
ini_set('max_execution_time', 600);
ini_set('memory_limit', '-1');
require('tcpdf/tcpdf.php');

$sno = $_GET['wcode'];
$sql = mysqli_query($con, "SELECT * FROM `dist_mixrecord` WHERE id='$sno'");
$mixr = mysqli_fetch_array($sql);

$mixdate = date('d/m/Y', strtotime($mixr['mdate']));
$pname = $mixr['pname'];
$pcode = $mixr['pcode'];
$recnumb = $mixr['recnumb'];
$pesttemp = $mixr['pestemp'];
$pesttime = $mixr['pestime'];
$hempress = $mixr['hempress'];





$qsp = mysqli_query($con, "SELECT * FROM `tblformcontrol` WHERE tabname ='MRM'");
$qsp1 = mysqli_fetch_array($qsp);

class MYPDF extends TCPDF
{
   private $footerData;

   public function __construct($orientation, $unit, $format, $unicode, $encoding, $footerData)
   {
      parent::__construct($orientation, $unit, $format, $unicode, $encoding);
      $this->footerData = $footerData;
   }

   public function Header()
   {
      $this->Rect(0, 0, $this->getPageWidth(), $this->getPageHeight(), 'F', '', $fill_color = array(248, 248, 248));

      $image_file = 'images/1.png';
      $image_file1 = 'images/rtnts.png';

      $this->Image($image_file, 15, 8, 25, '', 'png', '', 'T', false, 200, '', false, false, 0, false, false, false);
      $this->SetFont('centurygothic', 'B', 20);
      $this->Cell(190, 15, 'Record of mixes - cooking', 0, 1, 'C');
      $this->Image($image_file1, 245, 8, 35, '', 'PNG', '', 'T', false, 200, '', false, false, 0, false, false, false);
      $this->SetXY(5, 35);
      // Draw a horizontal line across the page
      $this->Line(10, 31, $this->getPageWidth() - 10, 31);
   }

   public function Footer()
   {
      // Set position at 25 mm from bottom
      $this->SetXY(9, -25);

      // Set font
      $this->SetFont('centurygothic', '', 9);

      // Footer content with improved styling
      $footerContent = '
     
        <table border="1" cellpadding="4">
            <tr>
                <td width="33%">Issue date: ' . htmlspecialchars($this->footerData['issuedate']) . '</td>
                <td width="33%" rowspan="2" style="text-align:center;" >Page ' . $this->getAliasNumPage() . ' of ' . $this->getAliasNbPages() . '</td>
                <td width="33%">Author: ' . htmlspecialchars($this->footerData['author']) . '</td>
            </tr>
            <tr>
                <td width="33%">Version: 01</td>
                <td width="33%">Authorised by: ' . htmlspecialchars($this->footerData['authorisedby']) . '</td>
            </tr>
            <tr>
                <td  width="66%" colspan="2">Reason for Change: New form</td>
                <td width="33%">Print on: ' . date('d/m/Y H:i') . '</td>
            </tr>
        </table>';

      $this->writeHTML($footerContent, true, false, true, false, '');
   }
}

// Get footer data from database
$qsp = mysqli_query($con, "SELECT * FROM `tblformcontrol` WHERE tabname ='MRM'");
$qsp1 = mysqli_fetch_array($qsp);

// Prepare footer data
$qspdate = date('d/m/Y', strtotime($qsp1['issuedate']));
$footerData = [
   'issuedate' => $qspdate,
   'docref' => $qsp1['docref'],
   'author' => $qsp1['author'],
   'authorisedby' => $qsp1['authoriesby']
];

// Initialize PDF with footer data
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', $footerData);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);


$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->SetAutoPageBreak(TRUE, 30);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
   require_once(dirname(__FILE__) . '/lang/eng.php');
   $pdf->setLanguageArray($l);
}


$pdf->AddPage('L', 'A4');
$pdf->SetMargins(10, 45, 10, 10);
// $pdf->WriteHTMLCell(0, 0, 60, $pdf->GetY(), $image_file, 0, 1);

$pdf->SetFont('centurygothic', '', 20);





$pdf->SetXY(65, 7);


$tbl_header = '<style>
table {
   
   border-radius: 10px;
   
}
tr {
   padding: 3px 0;
}

th {
      background-color:#F0F0F0;
   color: #000000;
  
   font-size: 15px;
  
   padding-bottom: 4px;
   padding-left: 8px;
   padding-top: 5px;
   text-align: left;
}
td {
  
 
   font-size: 14px;
   color: #000000;
   padding: 3px 7px 2px;
}
</style>
<table id="gallerytab" width="50%" cellspacing="0" cellpadding="2" border="0">
  ';

$tbl_footer = '</table>';


// die;
$pdf->SetXY(5, 45);

$tbl80 = '';
$tbl80 .= '
<table border="1" cellpadding="4" cellspacing="0">
<tr>
<th>Date</th>
   <td>' . $mixdate . '
</td>
<th>Product Name</th>
<td>' . $pname . '   
</td>

</tr>
<tr>
<th>Product Code</th>
   <td>' . $pcode . '
</td>
<th>Recipe No</th>
<td>' . $recnumb . '   
</td>

</tr>
<tr>
<th>Pesturisation time and temperature</th>
   <td>
   ' . $pesttemp . ' for ' . $pesttime . '
</td>
<th>Homogenisation Pressure</th>

<td>
   ' . $hempress . '   
</td>

</tr>

</table>


';

$pdf->writeHTML($tbl_header . $tbl80 . $tbl_footer, true, false, false, false, '');
$pdf->SetX(5);
$tbl81 = '';
$tbl81 .= '
<table border="1" cellpadding="4" cellspacing="0">
<tr style="background-color:#00BFFF; color:#000000">
<th width="5%" style="background-color:#00BFFF; color:#000000">
   Sno.
</th>
<th width="15%" style="background-color:#00BFFF; color:#000000">Code</th>
<th width="15%" style="background-color:#00BFFF; color:#000000">Ingredients</th>
<th width="10%" style="background-color:#00BFFF; color:#000000">Quantity (2000 ltrs)</th>
<th width="10%" style="background-color:#00BFFF; color:#000000">Quantity (1200 ltrs)</th>
<th width="10%" style="background-color:#00BFFF; color:#000000">Allergens</th>
<th width="10%" style="background-color:#00BFFF; color:#000000">Values</th>
<th width="15%" style="background-color:#00BFFF; color:#000000">Batch Number</th>
<th width="10%" style="background-color:#00BFFF; color:#000000">Best Before Date</th>
</tr>

';
$mixcr = mysqli_query($con, "SELECT * FROM `dist_mixrecord1` WHERE tid='$sno'");
$i = 0;
while ($mixcr1 = mysqli_fetch_array($mixcr)) {
   $i++;
   $tbl81 .= '
<tr>
 
    <td>' . $i . '</td>
    <td>' . $mixcr1['code'] . '</td>
    <td>' . $mixcr1['ingredient'] . '</td>
    <td>' . $mixcr1['quantity2'] . '</td>
    <td>' . $mixcr1['quantity12'] . '</td>
    <td>' . $mixcr1['allergen'] . '</td>
    <td>' . $mixcr1['value'] . '</td>
    <td>' . $mixcr1['batch'] . '</td>
    <td>' . $mixcr1['ubdate'] . '</td>
  
</tr>';
}
$tbl81 .= '</table>';




$pdf->writeHTML($tbl_header . $tbl81 . $tbl_footer, true, false, false, false, '');

$milktank = $mixr['milktank'];
$tankclean = $mixr['tankclean'];
$comments = $mixr['comment'];
$pdf->SetX(5);
$tbl82 = '';
$tbl82 .= '
<table border="1" cellpadding="4" cellspacing="0">
<tr>
<th>Milk into tank no :</th>
   <td>' . $milktank . '
</td>
<th>Tank Cleaned?</th>
<td>' . $tankclean . '   
</td>

</tr>
<tr>
<th>Operator Initial</th>
   <td>';
if (!empty($mixr['mixsign'])) {
   $tbl82 .= '<img src="precord/sign/' . $mixr['mixsign'] . '.png" alt="" height="30">';
}

$tbl82 .= '
</td>
<th>comments</th>
<td>' . $comments . '   
</td>

</tr>



</table>


';

$pdf->writeHTML($tbl_header . $tbl82 . $tbl_footer, true, false, false, false, '');


$pestsql = mysqli_query($con, "SELECT * FROM `dist_pestu`WHERE tid='$sno'");
$pestsql1 = mysqli_fetch_array($pestsql);




$tbl70 = '';
$tbl70 .= '
<table border="1" cellpadding="4" cellspacing="0">
<tr>
<th colspan="4" style="background-color:#f3a61f; color:#000000">CCP 1* - PASTEURISATION
<br>
(minimum 72<sup>o</sup>C for 10 minutes)</th>
</tr>
<tr>
<th>Cooking start time</th>
   <td>' . $pestsql1['cookstime'] . '
</td>
<th>CCP cooking temperature required (<sup>o</sup>C)</th>
<td>' . $pestsql1['cooktemp'] . '   
</td>

</tr>
<tr>
<th>Actual Start time of CCP</th>
   <td>' . $pestsql1['actualstime'] . '
</td>
<th>Actual Temperature of CCP at start time</th>
<td>' . $pestsql1['actualtemp'] .'   
</td>

</tr>
<tr>
<th>Actual End time of CCP</th>
   <td>
   ' . $pestsql1['actualetime'] . '
</td>
<th>Actual Temperature of CCP at End time</th>

<td>
   ' . $pestsql1['actualendt'] . '  
</td>

</tr>
<tr>
<th>Total time at CCP cooking temperature(minutes)</th>
   <td>
   ' . $pestsql1['totaltime'] . '
</td>
<th>Comments</th>
' . $pestsql1['cmnt'] . '
<td>
     
</td>

</tr>

</table>


';

$pdf->writeHTML($tbl_header . $tbl70 . $tbl_footer, true, false, false, false, '');



$filtsql = mysqli_query($con, "SELECT * FROM `dist_filter` WHERE tid='$sno'");
$filtsql1 = mysqli_fetch_array($filtsql);

$tbl60 = '';
$tbl60 .= '
<table border="1" cellpadding="4" cellspacing="0">
<tr>
<th colspan="4" style="background-color:#00BFFF; color:#000000">CCP 2* - FILTRATION
<br>
(500 micron filter to be in place and free from
damage)</th>
</tr>
<tr>
<td colspan="4" >Filter check
(presence & integrity check)</td>
</tr>


<tr>
<th>At start-up </th>
<td>' . $filtsql1['start'] . '
</td>


<th>Initials of
inspector:</th>
   <td>';
if (!empty($filtsql1['fsign'])) {
   $tbl60 .= '<img src="precord/sign/' . $filtsql1['fsign'] . '.png" alt="" height="30">';
}
$tbl60 .= '
</td>

</tr>
<tr>
<th>Comments:(if foreign bodies or damage is found on the fiter)</th>
   <td colspan="3">
   ' . $filtsql1['startcmnt'] . '
</td>
</tr>
<tr>
<th>At end of
production
</th>
   <td>
   ' . $filtsql1['end'] . '
</td>
<th>Initials of
inspector:</th>

 <td>';
if (!empty($filtsql1['fsign1'])) {
   $tbl60 .= '<img src="precord/sign/' . $filtsql1['fsign1'] . '.png" alt="" height="30">';
}
$tbl60 .= '
</td>

</tr>
<tr>
<th>Comments:(if foreign bodies or damage is found on the fiter)</th>
   <td colspan="3">
   ' . $filtsql1['endcmnt'] . '
</td>
<td>
     
</td>

</tr>

</table>


';

$pdf->writeHTML($tbl_header . $tbl60 . $tbl_footer, true, false, false, false, '');





$homsql = mysqli_query($con, "SELECT * FROM `dist_homogeniser` WHERE tid='$sno'");
$homsql1 = mysqli_fetch_array($homsql);



$tbl5 = '';
$tbl5 .= '
<table border="1" cellpadding="4" cellspacing="0">
<tr>
<th colspan="4" style="background-color:#f3a61f; color:#000000">HOMOGENISATION</th>
</tr>
<tr>
<th>Set pressure in homogeniser (PSI)</th>
   <td>' . $homsql1['homopres'] . '</td>
<th>Homogeniser start time</th>
<td>' . $homsql1['homotime'] . '</td>

</tr>
<tr>
<th>Comments</th>
   <td colspan="3">' . $homsql1['cmnt'] . '
</td>

</tr>


</table>


';

$pdf->writeHTML($tbl_header . $tbl5 . $tbl_footer, true, false, false, false, '');


$coolsql = mysqli_query($con, "SELECT * FROM `dist_cooling` WHERE tid='$sno'");
$coolsql1 = mysqli_fetch_array($coolsql);

$tbl40 = '';
$tbl40 .= '
<table border="1" cellpadding="4" cellspacing="0">
<tr>
<th colspan="4" style="background-color:#00BFFF; color:#000000">CCP 3* - COOLING<br>
(must be to 7°C or less within 90 minutes of homogenisation)</th>
</tr>



<tr>
<th>Pre-transfer cooling temperature</th>
<td>' . $coolsql1['ctemp'] . '
</td>


<th>Finish time for transfer to high
care tank</th>
   <td>' . $coolsql1['ftime'] . '</td>

</tr>
<tr>
<th>Total time from homogenisation to transfer</th>
   <td>' . $coolsql1['totaltime'] . '</td>
   <th>Comments</th>
   <td>' . $coolsql1['cmnt'] . '</td>
</tr>
<tr>
<th>Transfer to tank no :</th>
   <td>' . $coolsql1['transfer'] . '</td>
   <th>Operator Initials</th>
   <td>';
if (!empty($coolsql1['csign'])) {
   $tbl40 .= '<img src="precord/sign/' . $coolsql1['csign'] . '.png" alt="" height="30">';
}
$tbl40 .= '</td>
</tr>
</table>
';

$pdf->writeHTML($tbl_header . $tbl40 . $tbl_footer, true, false, false, false, '');


$tbl3 = '';
$tbl3 .= '
<table border="1" cellpadding="4" cellspacing="0">
<tr>
<th colspan="4" style="background-color:#f3a61f; color:#000000">CCP Checks</th>
</tr>



<tr>
<th>Is this product halal?</th>
<td>' . $coolsql1['halal'] . '</td>
<th>Previous product name</th>
<td>' . $coolsql1['product'] . '</td>
</tr>

<tr>
<th>Cleandown Carried Out?</th>
   <td>' . $coolsql1['clean'] . '</td>
   <th>Sign</th>
   <td>';
if (!empty($coolsql1['csign'])) {
   $tbl3 .= '<img src="precord/sign/' . $coolsql1['csign'] . '.png" alt="" height="30">';
}
$tbl3 .= '</td>
</tr>
</table>
';

$pdf->writeHTML($tbl_header . $tbl3 . $tbl_footer, true, false, false, false, '');

$tbl2 = '';
$tbl2 .= '
<table border="1" cellpadding="4" cellspacing="0">
<tr>
<th colspan="4" style="background-color:#00fa9a; color:#000000">Verification</th>
</tr>
<tr><th>Have all ccp followed correctly?</th>
   <td>' . $mixr['correct'] . '</td>
   <th>Sign</th>
   <td>';
if (!empty($mixr['managesign'])) {
   $tbl2 .= '<img src="precord/sign/' . $mixr['managesign'] . '.png" alt="" height="30">';
}
$tbl2 .= '</td>
</tr>
</table>
';

$pdf->writeHTML($tbl_header . $tbl2 . $tbl_footer, true, false, false, false, '');







// Sanitize the filename
$filename = "_monthly_Management_1meeting_" . $sno; // Sanitize the GRN number


$filePath = $_SERVER['DOCUMENT_ROOT'] . "finemed/upl1/" . $filename . ".pdf";




// Attempt to generate the PDF
try {
   // Ensure the directory exists
   if (!file_exists(dirname($filePath))) {
      mkdir(dirname($filePath), 0755, true); // Create the directory if it doesn't exist
   }

   // Output the PDF to the specified path
   $pdf->Output($filePath, "F");
} catch (Exception $e) {
   echo "Error generating PDF: " . $e->getMessage();
}

?>

<div class="main-content">

   <div class="container-fluid " style="margin-top:20px;">
      <div class="row mb-12">
         <div class="col-md-12 mb-12">
            <div class="card text-left">
               <div class="card-body">

                  <a href="admin.php?id=dist_mixing"><button class="btn btn-primary mb-3"
                        style="float:right; margin-left:15px">Go Back</button></a>



                  <h4 class="card-title mb-3">Mixes-cooking Report</h4>

                  <div class="embed-responsive embed-responsive-4by3" style="height: 678px;">
                     <iframe class="embed-responsive-item w-100 h-70" src="upl1/<?php echo $filename; ?>.pdf"
                        allowfullscreen></iframe>
                  </div>



               </div>
            </div>
         </div>
      </div>
   </div>