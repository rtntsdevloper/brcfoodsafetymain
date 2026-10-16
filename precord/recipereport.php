<?php
include 'connection.php';
ini_set('max_execution_time', 600);
ini_set('memory_limit', '-1');
require('tcpdf/tcpdf.php');
$vid = $_GET['vid'];

$sqlnm = mysqli_query($con, "SELECT * FROM `recipedetail` WHERE id = $vid");
$rnm = mysqli_fetch_array($sqlnm);

$recordid = $rnm['recordid'];



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
    $this->Cell(210, 15, 'RECIPE REPORT', 0, 1, 'C');
    $this->Image($image_file1, 250, 8, 30, '', 'PNG', '', 'T', false, 200, '', false, false, 0, false, false, false);
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

$pdf->SetFont('centurygothic', '', 13);





$pdf->SetXY(10, 38);


$tbl1 = '


<table border="1" cellpadding="4" width="100%">
            <tr>
                <th width="25%"><b>Date</b></th>
                <td width="25%">' . date('d-m-Y', strtotime($rnm['date'])) . '</td>
                <th width="25%"><b>Product Name</b></th>
                <td width="25%">' . $rnm['fproduct'] . '</td>
            </tr>
             <tr>
                <th width="25%"><b>Start Time</b></th>
                <td width="25%">' . $rnm['starttime'] . '</td>
                <th width="25%"><b>End Time</b></th>
                <td width="25%">' . $rnm['endtime'] . '</td>
            </tr>
            <tr>
                <th width="25%">Temperature Before Cutting</th>
                <td width="25%"  >' . $rnm['tempbefore'] . '&deg;C</td>
                <th width="25%">Temperature After Cutting</th>
                <td width="25%">' . $rnm['tempafter'] . '&deg;C</td>
            </tr>
        </table>';

$pdf->writeHTML($tbl1, true, false, true, false, '');

$pdf->SetFont('centurygothic', '', 12);
$tbl2 = '';
$tbl2 .= '
<br>
<h2>Ingredients Details : </h2>
<table border="1" cellpadding="4" width="100%">
            <tr style="background-color: #e6e6e6;">
            <th width="10%">Sr No</th>
                <th width="20%">Ingredient/Product Name</th>
                <th width="18%">Allergen</th>
                <th width="18%">Batchcode</th>
                 <th width="16%">Quantity</th>
                 <th width="18%">UB/BB Date</th>
            </tr>
           
       ';

$td = 0;
$sqldx = mysqli_query($con, "SELECT * FROM `reciepedetail1` WHERE `vid` = '$vid'");
while ($rowdx = mysqli_fetch_array($sqldx)) {
  $td++;
  $tbl2 .= '<tr>
                <td width="10%">' . $td . '</td>
                <td width="20%">' . $rowdx['pname'] . '</td>
                <td width="18%">' . $rowdx['allergen'] . '</td>
                <td width="18%">' . $rowdx['batch'] . '</td>
                 <td width="16%">' . $rowdx['qty'] . 'Kg</td>
                 <td width="18%">' . $rowdx['useby'] . '</td>
            </tr>';
}

$tbl2 .= '</table>';

$pdf->writeHTML($tbl2, true, false, true, false, '');




$pdf->AddPage();
$tbl3 = '';

$tbl3 .= '
<h2>Output Product Details : </h2>
<table border="1" cellpadding="4" width="100%">
            <tr style="background-color: #e6e6e6;">
                <th width="20%">Product Name</th>
                <th width="20%">Allergen</th>
                <th width="20%">Batchcode</th>
                 <th width="20%">Quantity</th>
                 <th width="20%">UB/BB Date</th>
            </tr>
           
       ';

$tbl3 .= '<tr>
                <td width="20%">' . $rnm['opname'] . '</td>
                <td width="20%">' . $rnm['oallergen'] . '</td>
                <td width="20%">' . $rnm['obatch'] . '</td>
                 <td width="20%">' . $rnm['oqty'] . 'Kg</td>
                 <td width="20%">' . $rnm['obbdate'] . '</td>
            </tr>
            <tr>
                <td width="20%" style="background-color: #e6e6e6;">Waste</td>
                <td width="20%">' . $rnm['waste'] . '</td>
                <td width="20%" style="background-color: #e6e6e6;">Comment</td>
                 <td width="40%" colspan="2">' . $rnm['wastecmnt'] . '</td>
            </tr>';


$tbl3 .= '</table>';

$pdf->writeHTML($tbl3, true, false, true, false, '');


$tbl4 = '';

$tbl4 .= '
<table border="1" cellpadding="4" width="100%"> 
<tr style="background-color: #e6e6e6;">
                <th width="10%">Sno.</th>
                <th width="60%">Questions</th>
                <th width="30%">Answers</th>
                
            </tr>
       ';


$checksques = explode(';', $rnm['checksq']);
$checkans = explode(';', $rnm['checksans']);
foreach ($checksques as $key => $value) {
  $ixk = $key + 1;

  $tbl4 .= '<tr>
                <th width="10%">' . $ixk . '</th>
                <th width="60%">' . $value . '</th>
                <th width="30%">' . $checkans[$key] . '</th>
                
            </tr>
            ';
}

$tbl4 .= '</table>';

$pdf->writeHTML($tbl4, true, false, true, false, '');


$tbl5 = '';

$tbl5 .= '
<style>
th{
background-color: #e6e6e6;
      }

</style>
<table border="1" cellpadding="4" width="100%"> 
<tr>
                <th width="30%">Temperature of Freezer</th>
                <td width="30%">' . $rnm['tempfreeze'] . '&deg;C</td>
                <td width="40%" rowspan="3">Comments: </td>
                
            </tr>
            <tr>
                <th width="30%">Batchcode</th>
                <td width="30%">' . $rnm['tbatch'] . '</td>
                
            </tr>
            <tr>
                <th width="30%">Shelf Life</th>
                <td width="30%">' . $rnm['tshelf'] . '</td>
                
            </tr>
         
       ';






$tbl5 .= '</table>';

$pdf->writeHTML($tbl5, true, false, true, false, '');

$tbl6 = '
<style>
th{
background-color: #e6e6e6;
      }

</style>
<table border="1" cellpadding="4" width="100%"> 
<tr>
                <th width="50%">Previous Product Name</th>
                <td width="50%">' . $rnm['linepro'] . '</td>
                
                
            </tr>
            <tr>
                <th width="50%">Clean down carried out?</th>
                <td width="50%">' . $rnm['linecarry'] . '</td>
                
            </tr>
            <tr>
                <th width="50%">Line Manager Initials</th>
                <td width="50%">' . $rnm['linemanager'] . '</td>
                
            </tr>
         </table>
       ';






$pdf->writeHTML($tbl6, true, false, true, false, '');

$tbl7 = '';

$tbl7 .= '
<style>
th{
background-color: #e6e6e6;
      }

</style>
<table border="1" cellpadding="4" width="100%"> 
<tr>
                <th width="25%">Etrace Label No.</th>
                <td width="25%">' . $rnm['etracelabel'] . '</td>
                 <th width="25%">Quantity</th>
                <td width="25%">' . $rnm['etqty'] . '</td>
                
                
            </tr>
            <tr>
               <th width="25%">Packaging Date</th>
                <td width="25%">' . $rnm['epackdate'] . '</td>
                 <th width="25%">Product UB</th>
                <td width="25%">' . $rnm['epackub'] . '</td> 
                
            </tr>
            <tr>
               <th width="25%">Product Temperature</th>
                <td width="25%">' . $rnm['eprodtemp'] . '&deg;C</td>
                 <td width="50%" colspan="2"></td>
              
                
            </tr>
             <tr>
               <td width="50%" colspan="2">Start Label<br>
               <br>';

if (!empty($rnm['startlabel'])) {
  $tbl7 .= '<a href="' . $rnm['startlabel'] . '" target="_blank">
               <img src="precord/files/' . $rnm['startlabel'] . '" alt="" width="200" height="200">
               </a>';
}


$tbl7 .= '
               
               </td>
                 <td width="50%" colspan="2">End Label<br><br>';
if (!empty($rnm['endlabel'])) {
  $tbl7 .= '<a href="' . $rnm['endlabel'] . '" target="_blank">
               <img src="precord/files/' . $rnm['endlabel'] . '" alt="" width="200" height="200">
               </a>';
}

$lablused = str_replace(';', ',', $rnm['labelused']);
$tbl7 .= '
                 </td>
              
                
            </tr>
            <tr>
            <th width="25%" >Label Used</th>
            <td width="75%" >' . $lablused . '</td>
            </tr>
         </table>
       ';






$pdf->writeHTML($tbl7, true, false, true, false, '');




$pdf->AddPage();

$tbl8 = '
<style>
th{
background-color: #e6e6e6;
      }

</style>
<table border="1" cellpadding="4" width="100%"> 
<tr>
                <th width="25%">No. of Bags Produced :</th>
                <td width="25%">' . $rnm['bags'] . '</td>
                 <th width="25%">Weight/Volume Pack in each bag :</th>
                <td width="25%">' . $rnm['bageach'] . 'Kg</td>
                
            </tr>
            <tr>
            <th width="25%">Bag Batchcode :</th>
            <td width="25%">' . $rnm['bagbatch'] . '</td>
            <th width="25%">Total Number of Labels :</th>
            <td width="25%">' . $rnm['totallabelp'] . '</td>
            </tr>
             <tr>
            <th width="25%">Total Number of Labels Used including start & end labels :</th>
            <td width="25%">' . $rnm['totallabelu'] . '</td>
            <th width="25%">Labels Wasted :</th>
            <td width="25%">' . $rnm['totallabelw'] . '</td>
            </tr>


             <tr>
            <th width="25%">Start Label Check by :</th>
            <td width="25%">' . $rnm['startcheck'] . '</td>
            <th width="25%"> Time:</th>
            <td width="25%">' . $rnm['startctime'] . '</td>
            </tr>
             <tr>
            <th width="25%">Middle Label Check by:</th>
            <td width="25%">' . $rnm['middlecheck'] . '</td>
            <th width="25%"> Time:</th>
            <td width="25%">' . $rnm['middlectime'] . '</td>
            </tr>
             <tr>
            <th width="25%">End Label Check by:</th>
            <td width="25%">' . $rnm['endcheck'] . '</td>
            <th width="25%"> Time:</th>
            <td width="25%">' . $rnm['endctime'] . '</td>
            </tr>
           
           
         </table>
       ';
$pdf->writeHTML($tbl8, true, false, true, false, '');



$tbl9 = '';

if (!empty($rnm['opsign'])) {
  $tbl9 .= '
<style>
th{
background-color: #e6e6e6;
      }

</style>
<table border="1" cellpadding="4" width="100%"> 
<tr>
                <th width="50%">Operator Signature</th>
                <td width="50%"><img src="precord/sign/' . $rnm['opsign'] . '" alt="" width="200" height="70"></td>
                
                
            </tr>
           
         </table>
       ';
}

$pdf->writeHTML($tbl9, true, false, true, false, '');

$filePath = $_SERVER['DOCUMENT_ROOT'] . "finemed/precord/files/" . $recordid . ".pdf";




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

            <a href="admin.php?id=recipe"><button class="btn btn-primary mb-3"
                style="float:right; margin-left:15px">Go Back</button></a>



            <h4 class="card-title mb-3">Recipe Report</h4>

            <div class="embed-responsive embed-responsive-4by3" style="height: 678px;">
              <iframe class="embed-responsive-item w-100 h-70" src="precord/files/<?php echo $recordid; ?>.pdf"
                allowfullscreen></iframe>
            </div>



          </div>
        </div>
      </div>
    </div>
  </div>