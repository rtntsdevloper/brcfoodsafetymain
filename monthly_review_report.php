<?php
include 'connection.php';
ini_set('max_execution_time', 600);
ini_set('memory_limit', '-1');
require('tcpdf/tcpdf.php');

$sno = $_GET['sno'];
$sql = mysqli_query($con, "SELECT * FROM `tbl_meeting`where id = $sno");
$y = mysqli_fetch_array($sql);


    $qsp = mysqli_query($con,"SELECT * FROM `tblformcontrol` WHERE tabname ='MRM'");
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
        $this->Cell(190, 15, 'MONTHLY MANAGEMENT MEETING', 0, 1, 'C');
        $this->Image($image_file1, 230, 8, 39, '', 'PNG', '', 'T', false, 200, '', false, false, 0, false, false, false);
        $this->SetXY(17, 25);
    }

    public function Footer()
    {
        // Set position at 25 mm from bottom
        $this->SetY(-25);
        
        // Set font
        $this->SetFont('centurygothic', '', 9);
        
        // Footer content with improved styling
        $footerContent = '
     
        <table border="1" cellpadding="4">
            <tr>
                <td width="33%">Issue date: '.htmlspecialchars($this->footerData['issuedate']).'</td>
                <td width="33%" rowspan="2" style="text-align:center;" >Page '.$this->getAliasNumPage().' of '.$this->getAliasNbPages().'</td>
                <td width="33%">Author: '.htmlspecialchars($this->footerData['author']).'</td>
            </tr>
            <tr>
                <td width="33%">Version: 01</td>
                <td width="33%">Authorised by: '.htmlspecialchars($this->footerData['authorisedby']).'</td>
            </tr>
            <tr>
                <td  width="66%" colspan="2">Reason for Change: New form</td>
                <td width="33%">Print on: '.date('d/m/Y H:i').'</td>
            </tr>
        </table>';

        $this->writeHTML($footerContent, true, false, true, false, '');
    }
}

// Get footer data from database
$qsp = mysqli_query($con, "SELECT * FROM `tblformcontrol` WHERE tabname ='MRM'");
$qsp1 = mysqli_fetch_array($qsp);

// Prepare footer data
$qspdate = date('d/m/Y',strtotime($qsp1['issuedate']));
$footerData = [
    'issuedate' => $qspdate,
    'docref' => $qsp1['docref'] ?? 'REC 6.3.3', // Fallback value
    'author' => $qsp1['author'] ?? 'Bijal Chauhan',
    'authorisedby' => $qsp1['authorisedby'] ?? 'Paramvir S. Deol'
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





$pdf->SetXY(75, 7);


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
  
   font-size: 14px;
  
   padding-bottom: 4px;
   padding-left: 8px;
   padding-top: 5px;
   text-align: left;
}
td {
  
 
   font-size: 15px;
   color: #000000;
   padding: 3px 7px 2px;
}
</style>
<table id="gallerytab" width="50%" cellspacing="0" cellpadding="2" border="0">
  ';

$tbl_footer = '</table>';


// die;
$pdf->SetXY(5, 50);

$tbl8 = '';
$tbl8 .= '<table  width="900"  >
  <tr>
    <td>
    <table width="500" border="0" cellspacing="15" cellpadding="10" style="background-color:white;">
    <tr style="background-color:#D4EEFF;font-size:30px;text-align:center;font-weight:bold">
        <td colspan="2"><h1>Meeting Details</h1></td>
        
      </tr>
      <tr style="background-color:#D4EEFF;font-size:25px;text-align:center;font-weight:bold">
        <td >Meeting Date </td>
        <td>' . date('d-m-y', strtotime($y['mdate'])) . '</td>
      </tr>

      <tr style="background-color:#D4EEFF;font-size:25px;text-align:center;font-weight:bold">
        <td>Month Covered </td>
        <td>' . $y['mcover'] . '</td>
      </tr>
      
      <tr style="background-color:#D4EEFF;font-size:25px;text-align:center;font-weight:bold">
        <td>Meeting Time </td>
        <td>' . date('h:i a', strtotime($y['meetstart'])) . " - " . date('h:i a', strtotime($y['meetend'])) . '</td>
      </tr>
      <tr style="background-color:#D4EEFF;font-size:25px;text-align:center;font-weight:bold">
        <td>Meeting Location</td>
        <td>' . $y['meetlocation'] . '</td>
      </tr>


      <tr style="background-color:#D4EEFF;font-size:25px;text-align:center;font-weight:bold">
        <td>Minute Taken By</td>
        <td>' . $y['mntk'] . '</td>
      </tr>

      <tr style="background-color:#D4EEFF;font-size:25px;text-align:center;font-weight:bold">
        <td>Apologies</td>
        <td>' . $y['Apologies'] . '</td>
      </tr>
      </table>
      </td>
      
      
      </tr>
      
   </table>';

$pdf->writeHTML($tbl_header . $tbl8 . $tbl_footer, true, false, false, false, '');

$pdf->SetXY(160, 50);
$tbl12 = '';
$tbl12 .= '
<style>
table {
   
   border-radius: 10px;
   
}
tr {
   padding: 3px 0;
}

th {
      background-color:#F0F0F0;
   color: #000000;
  
   font-size: 14px;
  
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
<table id="gallerytab" width="50%"  height="700" cellpadding="0" border="0" style="background-color:white; ">

<table  width="400"  >
<tr>
  
    <td>
   
     <table width="380" border="0"  cellspacing="10" cellpadding="5" >
      <tr style="background-color:#D4EEFF;font-size:25px;text-align:center;font-weight:bold;padding:20px;">
      <td colspan="2"><h1>Attendees Detail</h1></td>
      
    </tr>
     ';

$empnm = explode(';', $y['attend']);
$desig = explode(';', $y['desig']);
foreach ($empnm as $key => $value) {
  $tbl12 .= '
      <tr style="background-color:#ADD8E6;font-size:25px;text-align:center;font-weight:bold;padding:20px;">
      <td >' . $value . '</td>
      
      <td>' . $desig[$key] . '</td>
      
    </tr>';
}


$tbl12 .= '

    
    
    </table>
    </td>
    </tr>
    
 </table>
 
 </table>';
$pdf->writeHTML($tbl12, true, false, false, false, '');

$pdf->AddPage('L', 'A4');

$tbl21 = '';
$tbl21 .= '
<h2 style="text-align:center;color:navy;"> Meeting Objectives</h2>
<style>
table {
   
   border-spacing: 0;
   
}
tr {
   padding: 3px 0;
}

th {
      background-color:#F0F0F0;
   color: navy;
  
   font-size: 20px;
   font-weight:bold;
  
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
   p{
   font-size: 18px;
   font-weight:bold;
    color:rgb(25, 128, 168);
}
</style>

<table id="gallerytab" width="100%"  cellpadding="7" border="1" style="background-color:white;" >
';




$y5 = $y['mcode'];
$mtd = mysqli_query($con, "SELECT * FROM `tbl_meeting1` WHERE meetcode ='$y5'");
$i = 0;
foreach ($mtd as $mbdata) {
  $i++;
  $tbl21 .= '
<tr nobr="true">
<td width="107"  style="text-align: center; vertical-align: middle;"><h2 >' . $i . '</h2></td>
<th width="865">' . $mbdata['question'] . '</th>
</tr>
<tr  nobr="true">
<td width="107"  style="text-align: center; vertical-align: middle;" rowspan ="4"><h2 ></h2></td>
<td width="865"><p>Discussion Summary : </p>' . $mbdata['discuss'] . ' </td>
</tr>

';

  $tbl21 .= '




<tr>

<td width="865"><p>Action Required : </p> ' . $mbdata['action'] . '</td>
</tr>
<tr>

<td width="865"><p>Time scale:</p> ' . $mbdata['scale'] . '</td>
</tr>
<tr>

<td width="865"><p>Responsible: </p> ' . $mbdata['response'] . '</td>
</tr>';

  if (!empty($mbdata['file'])) {

    $rawimg = explode(';', $mbdata['file']);

    foreach ($rawimg as $rkey => $rvalue) {

      $rextension = pathinfo($rvalue, PATHINFO_EXTENSION);
      if ($rextension == 'png' || $rextension == 'jpg' || $rextension == 'jpeg') {
        $tbl21 .= '
    <tr nobr="true" >
    <td width="107"  style="text-align: center; vertical-align: middle;"><h2 ></h2></td>
  
    <td width="830" >
      <div  style="padding: 10px;">
    <img src="mrm/' . $rvalue . '" alt="Image" />
    </div>
   
    </td>
    </tr>
   
    
    ';
      } else {
        $tbl21 .= '
    <tr  nobr="true">
    
    <td width="107"  style="text-align: center; vertical-align: middle;"><h2 >' . $i . '</h2></td>
<td width="830"  nobr="true">
     <div  style="padding: 10px;">
    <a href="' . $rvalue . '" target ="_blank" >' . $rvalue . '</a>
    </div>
    </td>
    </tr>
    
    
    ';
      }
    }
  }
}



$tbl21 .= '
</table>
';
$pdf->writeHTML($tbl21, true, false, true, false, '');






// Sanitize the filename
$filename = $y['mcover'] . "_monthly_Management_1meeting_" . $sno; // Sanitize the GRN number


$filePath = $_SERVER['DOCUMENT_ROOT'] . "brcfoodsafety/mrm/" . $filename . ".pdf";




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

            <a href="admin.php?id=monthly_review"><button class="btn btn-primary mb-3"
                style="float:right; margin-left:15px">Go Back</button></a>



            <h4 class="card-title mb-3">Monthly Management Meeting Report</h4>

            <div class="embed-responsive embed-responsive-4by3" style="height: 678px;">
              <iframe class="embed-responsive-item w-100 h-70" src="mrm/<?php echo $filename; ?>.pdf"
                allowfullscreen></iframe>
            </div>



          </div>
        </div>
      </div>
    </div>
  </div>