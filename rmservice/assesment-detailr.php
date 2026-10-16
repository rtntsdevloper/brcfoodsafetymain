<?php
include 'connection.php';
$sql1 = mysqli_query($con, "SELECT * FROM `tblrawmaterial` WHERE risk !='Pending'");
// $row = mysqli_fetch_array($sql1);
// $rid = $row['id'];

// $sql1 = mysqli_query($con, "SELECT * FROM `tbl_service_supplier` WHERE id=$rid");
// $row1 = mysqli_fetch_array($sql1);









// D:\XAMPP\htdocs\star\vendor\tecnickcom\tcpdf\tcpdf.php
require('tcpdf/tcpdf.php');

ini_set('max_execution_time', 300);
// create new PDF document
class MYPDF extends TCPDF
{

  private $longTableHeader = '';

  public function Header()
  {
    $this->Rect(0, 0, $this->getPageWidth(),    $this->getPageHeight(), 'F', '', $fill_color = array(248, 255, 255));
    // $image_file = 'images/rtnts.png';
    // $this->Image($image_file, 10, 2, 30, '', 'PNG', '', 'T', false, 200, '', false, false, 0, false, false, false);

    //  $this->write1DBarcode('.$row2['grnno'], 'C39', '82', '13', '40', 8, 0.3,'', 'N');


    $this->writeHTML($this->longTableHeader);
  }
  public function setLongTableHeader($html)
  {

    $this->longTableHeader = $html;
  }
  public function Footer()
  {
    $this->SetFont('centurygothic', '', 8);
    $this->writeHTML($this->longTableFooter);
    $this->SetY(-10);

   
  }
  public function setLongTableFooter($html)
  {
    $this->longTableFooter = $html;
  }
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);

$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->SetMargins(5, 35, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);


$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);


$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
  require_once(dirname(__FILE__) . '/lang/eng.php');
  $pdf->setLanguageArray($l);
}

// $pdf->SetFont('Helvetica', 'B', 14);


$pdf->AddPage('L', 'A4');
// $pdf->SetFillColor(240, 248, 255);
// $pdf->Rect(0, 0, 297, 210, 'F');
$pdf->SetFont('century gothic', '', 9);



$footer = <<<EOD

<table border="1"  width="100%" border="0.5" cellpadding="3">
  <tr>
  <td style="text-align:center">Updated On: 04/10/2024 </td>
  <td style="text-align:center; padding-top:15px;">Updated By: Bijal Chauhan</td>
  <td style="text-align:center; padding-top:15px;">Approved by: Paramvir S. Deol</td>
 
  </tr>
</table>
EOD;
$pdf->setLongTableFooter($footer);


// $pdf->Write(0, 'Example of PieSector() method.');


// Continue with the rest of your PDF generation code...
$pdf->SetXY(0, 8);
$tble11 = <<<EOD
<table width="1200" border="0"  >
<tr>
<td width ="30"></td>
<td width="150"><img src="images/1.png" width="130"style='float:center;'></td>
<td width="690" style="font-size:32px;  padding-top:20px; text-align:center;">Risk Assesment</td>
</tr>
</table>
EOD;
$pdf->writeHTML($tble11, true, false, true, false, '');
$pdf->setLongTableHeader($tble11);



$query = "SELECT * FROM `tblrawmaterial` ";
$result = mysqli_query($con, $query);
$i = 1;
$green = 0;
$red = 0;


while ($row = mysqli_fetch_array($result)) {
  if ($row['risk'] >= 7 && $row['risk'] <= 14) {
    $green += 1;
  } elseif ($row['risk'] >= 15 && $row['risk'] <= 21) {
    $red += 1;
  }
}

$total = $green + $red;

$gp = round(($green / $total) * 100, 1);
$rp = round(($red / $total) * 100, 1);

$data = array(
  'High' => $rp,
  'Low' => $gp
);

// Calculate total percentage
$totalPercentage = array_sum($data);

// Set chart position and size
$x = 40;
$y = 38;
$width = 88;
$height = 55;

// Set bar width and spacing
$barWidth = 18;
$barSpacing = 20;

// Draw chart background with border
$pdf->Rect($x, $y, $width, $height, 'D', array(), array(200, 200, 200));


// Draw y-axis percentage labels
$yLabelStep = $height / 10; // 10 percentage steps
for ($i = 0; $i <= 10; $i++) {
  $percentage = $i * 10;
  $yLabelPos = $y + $height - ($i * $yLabelStep);

  // Draw a line for percentage indication
  if ($i % 1 == 0) { // Draw lines for 10%, 20%, ...
    $pdf->SetLineStyle(array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(128, 128, 128)));
    $pdf->Line($x, $yLabelPos, $x + $width, $yLabelPos);
  }

  $pdf->SetFont('Helvetica', '', 8);
  $pdf->Text($x - 9, $yLabelPos - 1.5, $percentage . "%");
}
// Set font for chart title
$pdf->SetFont('Helvetica', '', 9);

// Set font for chart title
$pdf->SetFont('Helvetica', '', 9);

foreach ($data as $label => $value) {
  // Calculate bar height
  $barHeight = ($value / $totalPercentage) * $height;

  // Set bar color
  if ($label == 'High') {
    $color = array(255, 0, 0); // Red
  } elseif ($label == 'Low') {
    $color = array(0, 183, 74); // Green
  }

  // Draw bar
  $pdf->Rect($x + 15, $y + $height - $barHeight, $barWidth, $barHeight, 'F', array(), $color);



  // Move to next bar position
  $x += $barWidth + $barSpacing;
}

// (angle, x, y)

// Print the text
$pdf->Text(62, 95, 'Overall Risk Associated');



//pie chart

// $xc = 150;
// $yc = 63;
// $r = 20;

// $blue_angle = ($red / $total) * 360;
// $green_angle = ($green / $total) * 360;

// $pdf->SetFillColor(255, 0, 0);
// $pdf->PieSector($xc, $yc, $r, 0, $blue_angle, 'FD', true, 0, 2);


// $pdf->SetFillColor(0, 183, 73);
// $pdf->PieSector($xc, $yc, $r, 0, $green_angle, 'FD', false, 0, 2);


// // write labels
// $pdf->SetTextColor(255, 255, 255);


// $pdf->SetXY(15, 47);


$pdf->SetXY(180, 37);
$tble9 = <<<EOD
<table width="240" cellpadding="5"  border="1" align="center" >
<tr style="background-color:#B0C4DE;">
<td width ="30"></td>
<th width="140"  style="color:black;font-size: 16px;">Overall Risk</th>
<th width="108"  style="color:black;font-size: 16px;">Score</th>
</tr>

<tr>
<td width ="30"><div style="background-color:#00B74A;"></div></td>
<td width="140"  style="color:black;font-size: 13px;"> Low  </td>
<td width="108"  style="color:black;font-size: 13px;">  7-14</td>
</tr>
<tr>
<td width ="30"><div style="background-color:red;"></div></td>
<td width="140" style="color:black; font-size: 13px;"> High</td>
<td width="108" style="color:black; font-size: 13px;"> 15-21</td>
</tr>

</table>






EOD;
$pdf->writeHTML($tble9, true, false, true, false);
$pdf->SetXY(180, 74);
$tble19 = <<<EOD
<table width="240" cellpadding="5"  border="1" align="center" >
<tr style="background-color:#B0C4DE;">
<td width ="30"></td>
<th width="140"  style="color:black;font-size: 16px;">Risk  Associated</th>
<th width="108"  style="color:black;font-size: 16px;">Score</th>
</tr>

<tr>
<td width ="30"><div style="background-color:#99ff99;;"></div></td>
<td width="140"  style="color:black;font-size: 13px;"> Low  </td>
<td width="108"  style="color:black;font-size: 13px;">  1</td>
</tr>
<tr>
<td width ="30"><div style="background-color:#FFBF00;"></div></td>
<td width="140" style="color:black; font-size: 13px;">Medium</td>
<td width="108" style="color:black; font-size: 13px;"> 2</td>
</tr>

<tr>
<td width ="30"><div style="background-color:#FF7F7F;"></div></td>
<td width="140" style="color:black; font-size: 13px;"> High</td>
<td width="108" style="color:black; font-size: 13px;"> 3</td>
</tr>

</table>
EOD;
$pdf->writeHTML($tble19, true, false, true, false);



$pdf->SetXY(39, 100);


$tble8 = <<<EOD

<table width="350" cellspacing ="5" style="border:2px solid black; padding-top:10px;">


<tr>
<td width ="40"><div style="background-color:red;"></div></td>
<td width="120" style="color:black; font-size:13px;"> High ($rp%)</td>

<td width ="40"><div style="background-color: #00B74A;"></div></td>
<td width="120"  style="color:black; font-size:13px;"> Low ($gp%)</td>

</tr>


</table>
EOD;
$pdf->writeHTML($tble8, true, false, true, false);











$pdf->SetFont('century gothic', '', 9);
$pdf->SetXY(4, 120);
$tbl_header = '


<style>
table {
   border-spacing: 0;
   margin-top:30px;
}
tr {
   padding: 3px 0;
}

th {
      background-color:#B0C4DE;
 border: 1px solid #000000;
   color: #000000;
   text-align: center;
}
td {
  word-break: break-word;
  white-space: normal;
    border: 1px solid #000000;
   color: #000000;
   text-align: center;
}
   tr:nth-child(even) { background-color:rgb(173, 173, 173); }
</style>


<table id="gallerytab" width="900" cellspacing="0" cellpadding="4" border="0" >
  ';

$tbl_footer = '</table>';

$tbl7 = '';
$tbl7 .= '

  <tr>
              <th width="35">Sr No.</th>
              <th width="56">Supplier Name</th>
              <th width="66">Product Name</th>
              <th width="56">Product Code</th>
              <th width="58">Allegerns</th>
              <th width="78">Phsical Status</th>
              <th width="78">Process Stage</th>
              <th width="77">Allergen Risk</th>
              <th width="77">Biological Risk</th>
              <th width="77">Foreign Body Risk</th>
              <th width="77">Chemical Risk</th>
              <th width="77">Risk to product Quality</th>
              <th width="77">Radiological Risk</th>
              <th width="77">Vulnerability Assessment</th>
              <th width="55">Overall Score</th>
  </tr>

  <tbody>
  
  ';
$i = 0;

foreach ($sql1 as $row) {
  $i++;
  $rid = $row['supid'];
  $sql = mysqli_query($con, "SELECT * FROM `tblrawsupplier` WHERE supid=$rid");
  $row1 = mysqli_fetch_array($sql);
  $supplier = $row1['supname'];

  $q = $row['riskdesc'];
  $q1 = explode(';', $q);

  $r = $row['riskassoc'];
  $r1 = explode(',', $r);

  $vuscore = $row['risk'];
  if (empty($row['riskall'])) {
    $allergn = 'None';
  } else {
    $allergn = $row['riskall'];
  }

  $tbl7 .= '
    <tr nobr="true">
    <td width ="35">' . $i . '</td>
    <td width ="56" style="word-wrap: break-word; text-align:center;white-space: pre-wrap;">' . $supplier . '</td>
    <td width ="66">' . $row['pname'] . '</td>
    <td width ="56">' . $row['pcode'] . '</td>
    <td width ="58">' . $allergn . '</td>
    
    ';

  foreach ($q1 as $occ) {
    $tbl7 .= '
      <td width="78">' . $occ . '</td>
      ';
  }

  foreach ($r1 as $des) {
    $tbl7 .= '
      <td width="77" style="  background-color:' .
      ($des == 1 ? '#99ff99' : ($des == 2  ? '#FFBF00' : '#FF7F7F')) .
      '; font-size:17px; color:black; ">' . $des . '</td>
      ';
  }
  $tbl7 .= '
      <td width="55" style="  background-color:' .
    ($vuscore >= 7 && $vuscore <= 14 ? '#00B74A' : ($vuscore >= 15 && $vuscore <= 21 ? 'red' : 'firebrick')) .
    '; font-size:17px; color:white; ">' . $vuscore . '</td>
    ';

  $tbl7 .= '</tr>
  ';
}
$tbl7 .= '
</tbody>

';
$pdf->writeHTML($tbl_header . $tbl7 . $tbl_footer, true, false, false, false, '');












// Sanitize the filename
$filename = "risk-assesment"; // Sanitize the GRN number

// Define the full path for the PDF
// $filePath = $_SERVER['DOCUMENT_ROOT'] . "rmservice/docs/pdfs/" . $filename . ".pdf";
$filePath = $_SERVER['DOCUMENT_ROOT'] . "brcfoodsafety/rmservice/docs/pdfs/" . $filename . ".pdf";
// echo $filePath; // Absolute path

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


<link rel="stylesheet" href="https://cdn.datatables.net/2.1.5/css/dataTables.bootstrap5.css">
<style>
  .limit {
    width: 200px;
  }
</style>


<div class="main-content">
  <div class="breadcrumb">

    <ul>
      <li><a href="">Home</a></li>
      <li>Raw Material</li>
      <li>Risk Assesment Result</li>
    </ul>
  </div>
  <div class="container-fluid " style="margin-top:100px;">
    <div class="row mb-12">
      <div class="col-md-12 mb-12">
        <div class="card text-left">
          <div class="card-body">
            <h3 class="text-primary">Risk Assesment</h3>

            <a href="admin.php?id=addrawmaterial"><button class="btn btn-primary mb-3"
                style="float:right; margin-left:15px">Go Back</button></a>
            <a href="rmservice/docs/pdfs/<?php echo $filename; ?>.pdf" target="_blank"><button class="btn btn-primary mb-3"
                style="float:right; margin-left:15px">View Report</button></a>
            <a href="admin.php?id=knowledge"><button class="btn btn-info mb-3"
                style="float:right; margin-left:15px">Horizon Scanning</button></a>
            <a href="admin.php?id=foodfraud"><button class="btn btn-info mb-3"
                style="float:right; margin-left:15px">Food Fraud Adulteration</button></a>

            <!-- <p>List of staff</p> -->

            <div class="table-responsive">
              <table class="display table  table-bordered" id="zero_configuration_table"
                style="width:100%">
                <thead>
                  <tr class="text-center">
                    <th width="48">SR No.</th>
                    <th width="48">Supplier Name</th>
                    <th width="48">Product Name</th>
                    <th width="48">Product Code</th>
                    <th width="120">Allegerns</th>
                    <th width="120">Phsical Status</th>
                    <th width="120">Process Stage</th>
                    <th width="83">Allergen Risk</th>
                    <th width="83">Biological Risk</th>
                    <th width="83">Foreign Body Risk</th>
                    <th width="83">Chemical Risk</th>
                    <th width="83">Risk to product Quality</th>
                    <th width="83">Radiological Risk</th>
                    <th width="83">Vulnerability Assessment</th>
                    <th width="83">Overall Score</th>

                  </tr>
                </thead>
                <tbody>
                  <?php
                  $risk = mysqli_query($con, "SELECT * FROM `tblrawmaterial` where status='Active'");
                  $num = 0;
                  foreach ($risk as $pro) {
                    $num++;
                    $sid = $pro['supid'];



                    $sp = mysqli_query($con, "SELECT * FROM `tblrawsupplier` WHERE supid='$sid'");
                    $sp1 = mysqli_fetch_assoc($sp);
                    $supname = $sp1['supname']; ?>
                    <tr>
                      <td width="48"><?php echo $num; ?></td>
                      <td width="48"><?php echo $supname; ?></td>
                      <td width="48"><?php echo $pro['pname']; ?></td>
                      <td width="48"><?php echo $pro['pcode']; ?></td>
                      <td width="48"><?php
                                      if (empty($pro['riskall'])) {
                                        $allergn = 'None';
                                      } else {
                                        $allergn = $pro['riskall'];
                                      }
                                      echo $allergn;

                                      ?></td>
                      <?php
                      $rd = explode(';', $pro['riskdesc']);
                      foreach ($rd as $r1) {
                      ?>
                        <td width="48"><?php echo $r1; ?></td>

                      <?php
                      }
                      ?>

                      <?php
                      $rd = explode(',', $pro['riskassoc']);
                      foreach ($rd as $v1) {
                      ?>
                        <td width="48" style="background-color:<?php
                                                                if ($v1 == 1) {
                                                                  echo '#99ff99';
                                                                } elseif ($v1 == 2) {
                                                                  echo '#FFBF00';
                                                                } elseif ($v1 == 3) {
                                                                  echo '#FF7F7F';
                                                                }


                                                                ?>" ; color:aliceblue ; font-size:18px;><?php echo $v1; ?></td>

                      <?php
                      }
                      ?>

                      <td width="48" style="background-color: <?php if ($pro['risk'] >= 15 && $pro['risk'] <= 21) {
                                                                echo "red";
                                                              } elseif ($pro['risk'] >= 7 && $pro['risk'] <= 14) {
                                                                echo "#00B74A";
                                                              }

                                                              ?> ; color:aliceblue ; font-size:18px;"><?php echo $pro['risk']; ?></td>



                    </tr>











                  <?php

                  }

                  ?>


                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Content wrapper -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script> -->
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.1.5/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.1.5/js/dataTables.bootstrap5.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
  // new DataTable('#example');
</script>