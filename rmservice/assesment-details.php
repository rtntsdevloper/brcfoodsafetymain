<?php
include 'connection.php';
$sql1 = mysqli_query($con, "SELECT * FROM `tblrawmaterial` WHERE vulner !='Pending'");
// $row = mysqli_fetch_array($sql1);
// $rid = $row['id'];

// $sql1 = mysqli_query($conn, "SELECT * FROM `tbl_service_supplier` WHERE id=$rid");
// $row1 = mysqli_fetch_array($sql1);







require('tcpdf/tcpdf.php');

ini_set('max_execution_time', 300);
// create new PDF document
class MYPDF extends TCPDF
{

  private $longTableHeader = '';

  public function Header()
  {
    $this->Rect(0, 0, $this->getPageWidth(),    $this->getPageHeight(), 'F', '', $fill_color = array(248, 255, 255));
    $this->writeHTML($this->longTableHeader);
  }
  public function setLongTableHeader($html)
  {
    $this->longTableHeader = $html;
  }
  public function Footer()
  {
    $this->SetY(-15);
    // $this->SetFont('Helvetica', 'I', 8);
    $this->Cell(25, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    $timestamp = date('d-m-Y '); // Page number  
    $footerContent = $timestamp; // Print footer content
    $this->Cell(0, 10, $footerContent, 0, false, 'R', 0, '', 0, false, 'T', 'M');
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




$pdf->AddPage('L', 'A4');
$pdf->SetFont('century gothic', '', 9);



$pdf->SetXY(0, 8);
$tble11 = <<<EOD
<table width="1200" border="0"  >
<tr>
<td width ="30"></td>
<td width="310"><img src="images/1.png" width="130"></td>
<td width="545" style="font-size:32px;  padding-top:20px;">Vulnerability Assesment</td>
<td width="255"><img src="images/rtnts.png" width="130"></td>
</tr>
</table>
EOD;
$pdf->writeHTML($tble11, true, false, true, false);
$pdf->setLongTableHeader($tble11);




$query = "SELECT * FROM `tblrawmaterial` ";
$result = mysqli_query($con, $query);
$i = 1;
$green = 0;
$red = 0;
$yellow = 0;

while ($row = mysqli_fetch_array($result)) {
  if ($row['vulner'] <= 20) {
    $green += 1;
  } elseif ($row['vulner'] >= 21 && $row['vulner'] <= 40) {
    $yellow += 1;
  } elseif ($row['vulner'] > 40) {
    $red += 1;
  }
}

$total = $green + $red + $yellow;

$gp = round(($green / $total) * 100, 1);
$rp = round(($red / $total) * 100, 1);
$yp = round(($yellow / $total) * 100, 1);




// bar graph start




$data = array(
  'High' => $rp,
  'Medium' => $yp,
  'Low' => $gp
);

// Calculate total percentage
$totalPercentage = array_sum($data);

// Set chart position and size
$x = 35;
$y = 32;
$width = 110;
$height = 70;

// Set bar width and spacing
$barWidth = 16;
$barSpacing = 16;

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
  $pdf->Text($x - 9, $yLabelPos-1.5, $percentage."%");
}
// Set font for chart title
$pdf->SetFont('Helvetica', '', 9);

foreach ($data as $label => $value) {
  // Calculate bar height
  $barHeight = ($value / $totalPercentage) * $height;

  // Set bar color
  if ($label == 'High') {
      $color = array(255, 0, 0); // Red
  } elseif ($label == 'Medium') {
      $color = array(255, 165, 0); // Orange
  } elseif ($label == 'Low') {
      $color = array(0, 183, 74); // Green
  }

  // Draw bar
  $pdf->Rect($x+15, $y + $height - $barHeight, $barWidth, $barHeight, 'F', array(), $color);

  // Draw bar label with percentage
  // $pdf->SetFont('Helvetica', '', 10);
  // $pdf->Text($x + $barWidth / 2 - strlen($label) * 2, $y + $height + 10,$label);

  // Move to next bar position
  $x += $barWidth + $barSpacing;
}

$pdf->Text(72, 105, 'Overall Risk Associated');

// bar graph end









// Define data

// $xc = 155;
// $yc = 63;
// $r = 25;

// $query = "SELECT * FROM `tblrawmaterial` ";
// $result = mysqli_query($con, $query);
// $i = 1;
// $green = 0;
// $red = 0;
// $yellow = 0;

// while ($row = mysqli_fetch_array($result)) {
//   if ($row['vulner'] <= 20) {
//     $green += 1;
//   } elseif ($row['vulner'] >= 21 && $row['vulner'] <= 40) {
//     $yellow += 1;
//   } elseif ($row['vulner'] > 40) {
//     $red += 1;
//   }
// }

// $total = $green + $red + $yellow;

// $gp = round(($green / $total) * 100, 1);
// $rp = round(($red / $total) * 100, 1);
// $yp = round(($yellow / $total) * 100, 1);

// $blue_angle =  ($red / $total) * 360;
// $green_angle = ($green / $total) * 360;
// $yellow_angle = ($yellow / $total) * 360;

// $pdf->SetFillColor(255, 0, 0);
// $pdf->PieSector($xc, $yc, $r, $blue_angle, 0, 'FD', true, 0, 2);


// $pdf->SetFillColor(255, 174, 66);
// $pdf->PieSector($xc, $yc, $r, 0, $yellow_angle, 'FD', true, 0, 2);


// $pdf->SetFillColor(0, 183, 74);
// $pdf->PieSector($xc, $yc, $r, 0, $green_angle, 'FD', false, 0, 2);


// write labels


$pdf->SetTextColor(255, 255, 255);
$pdf->SetXY(190, 48);
$tble9 = <<<EOD
<table width="240" cellpadding="5"  border="1" >
<tr style="background-color:#B0C4DE;">

<td width ="25"></td>
<th width="120"  style="color:black;font-size: 16px;">Overall Risk  
</th>
<th width="120"  style="color:black;font-size: 16px;">Overall Score
</th>
</tr>

<tr>

<td width ="25"><div style="background-color:green;"></div></td>
<td width="120"  style="color:black;font-size: 13px;"> Low  
</td>
<td width="120"  style="color:black;font-size: 13px;"> 0 - 20
</td>

</tr>
<tr>

<td width ="25"><div style="background-color:orange;"></div></td>
<td width="120"  style="color:black;font-size: 13px;">Medium  
</td>
<td width="120"  style="color:black;font-size: 13px;"> 21 - 40
</td>

</tr>

<tr>
<td width ="25"><div style="background-color:firebrick;"></div></td>
<td width="120" style="color:black; font-size: 13px;"> High
</td>
<td width="120" style="color:black; font-size: 13px;"> 40+
</td>

</tr>
</table>
EOD;
$pdf->writeHTML($tble9, true, false, true, false);









$pdf->SetXY(28,112);
$tble8 = <<<EOD

<table width="500" cellspacing ="5" style="border:2px solid black; padding-top:4px;">


<tr>

<td width ="25"><div style="background-color:red;"></div></td>
<td width="95" style="color:black;font-size: 13px;"> High ($rp%)</td>

<td width ="25"><div style="background-color:#ffae42;"></div></td>
<td width="120"  style="color:black;font-size: 13px;"> Medium ($yp%)</td>

<td width ="25"><div style="background-color:#00B74A;"></div></td>
<td width="95"  style="color:black;font-size: 13px;"> Low ($gp%)</td>

</tr>
</table>
EOD;
$pdf->writeHTML($tble8, true, false, true, false);


$pdf->SetXY(2, 135);
$pdf->SetFont('century gothic', '', 8);
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
   color: black;
   text-align: center;
}
td {
  
    border: 1px solid #000000;
    word-break: break-word;
 
   color: #000000;
   text-align: center;
}
   .rotated-text {
  transform: rotate(90deg); /* Rotates the text 90 degrees */
  transform-origin: left top; /* Adjusts the origin point of the rotation */
}

</style>


<table id="gallerytab" width="900" cellspacing="0" cellpadding="2" border="0" >
  ';

$tbl_footer = '</table>';

$tbl7 = '';
$tbl7 .= '

  <tr>
              <th width="25">Sr No.</th>
              <th width="48">Supplier Name</th>
              <th width="48">Product Name</th>
              <th width="45">Product Code</th>
              <th width="66" class= "rotated-text">Ingredient Fraud History</th>
              <th width="66">Economic factor</th>
              <th width="66">Geographic origins</th>
              <th width="66">Complexity of supply chain</th>
              <th width="66">Ease of access to materials</th>
              <th width="66">Nature of the material</th>
              <th width="66">Cost of materials</th>
              <th width="61">Supply chain confidence</th>
              <th width="61" align="center">Supplier relationship</th>
              <th width="61">Supplier history</th>
              <th width="61">Availability of materials</th>
              <th width="61">Ingredient testing methods</th>
              <th width="61">Existing controls</th>
              <th width="42">Overall Score</th>
  </tr>

  <tbody>
  
  ';
$i = 0;
foreach ($sql1 as $row) {
  $i++;
  $rid = $row['supid'];
  $sql = mysqli_query($con, "SELECT * FROM `tblrawsupplier` WHERE supid=$rid");
  $row1 = mysqli_fetch_array($sql);

  $q = $row['vulnerocc'];
  $q1 = explode(',', $q);

  $r = $row['vulnerdet'];
  $r1 = explode(',', $r);

  $vuscore = $row['vulner'];

  $tbl7 .= '
    <tr nobr="true">
    <td width ="25">' . $i . '</td>
    <td width ="48">' . $row1['supname'] . '</td>
   <td width="48">' . $row['pname'] . '</td>
    <td width ="45">' . $row['pcode'] . '</td>
    
    ';

  foreach ($q1 as $occ) {
    $tbl7 .= '
      <td width="66">' . $occ . '</td>
      ';
  }

  foreach ($r1 as $des) {
    $tbl7 .= '
      <td width="61">' . $des . '</td>
      ';
  }

  $tbl7 .= '
      <td width="42" style="  background-color:' .
    ($vuscore < 20 ? 'green' : ($vuscore >= 21 && $vuscore <= 40 ? 'orange' : 'firebrick')) .
    '; font-size:15px; color:white; ">' . $vuscore . '</td>
    ';

  $tbl7 .= '</tr>
  ';
}
$tbl7 .= '
</tbody>

';
$pdf->writeHTML($tbl_header . $tbl7 . $tbl_footer, true, false, false, false, '');
// var_dump($tbl_header, $tbl7, $tbl_footer);


// Sanitize the filename
$filename = "vulnerbility-assesment"; // Sanitize the GRN number

// Define the full path for the PDF
$filePath = $_SERVER['DOCUMENT_ROOT'] . "rmservice/docs/pdfs/" . $filename . ".pdf";

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
      <li>Vulnerbility Assesment</li>
    </ul>
  </div>
  <div class="container-fluid " style="margin-top:100px;">
    <div class="row mb-12">
      <div class="col-md-12 mb-12">
        <div class="card text-left">
          <div class="card-body">
            <h3>Vulnerability Assesment</h3>
            <a href="admin.php?id=rawmaterial"><button class="btn btn-primary mb-3"
                style="float:right; margin-left:15px">Go Back</button></a>
            <a href="rmservice/docs/pdfs/<?php echo $filename; ?>.pdf" target="_blank"><button class="btn btn-primary mb-3"
                style="float:right; margin-left:15px">View Report</button></a>
                <a href="admin.php?id=knowledge"><button class="btn btn-info mb-3"
                style="float:right; margin-left:15px">Horizon Scanning</button></a>
            <a href="admin.php?id=foodfraud"><button class="btn btn-info mb-3"
                style="float:right; margin-left:15px">Food Fraud Adulteration</button></a>

            <!-- <p>List of staff</p> -->

            <div class="table-responsive">
              <table class="display table table-striped table-bordered" id="zero_configuration_table"
                style="width:100%">
                <thead>
                  <tr class="text-center">
                    <th width="48">SR No.</th>
                    <th width="48">Supplier Name</th>
                    <th width="48">Product Name</th>
                    <th width="48">Product Code</th>
                    <th width="32">Ingredient Fraud History</th>
                    <th width="32">Economic factor</th>
                    <th width="32">Geographic origins</th>
                    <th width="32">Complexity of supply chain</th>
                    <th width="32">Ease of access to materials</th>
                    <th width="32">Nature of the material</th>
                    <th width="32">Cost of materials</th>
                    <th width="32">Supply chain confidence</th>
                    <th width="32">Supplier relationship</th>
                    <th width="32">Supplier history</th>
                    <th width="32">Availability of materials</th>
                    <th width="32">Ingredient testing methods</th>
                    <th width="32">Existing controls</th>
                    <th width="32">Overall Score</th>

                  </tr>
                </thead>
                <tbody>
                  <?php
                  $risk = mysqli_query($con, "SELECT * FROM `tblrawmaterial`");
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
                      <?php
                      $rd = explode(',', $pro['vulnerocc']);
                      foreach ($rd as $r1) {
                      ?>
                        <td width="46"><?php echo $r1; ?></td>

                      <?php
                      }
                      ?>

                      <?php
                      $rd = explode(',', $pro['vulnerdet']);
                      foreach ($rd as $v1) {
                      ?>
                        <td width="32"><?php echo $v1; ?></td>

                      <?php
                      }
                      ?>
                      <td width="32" style="background-color: <?php if ($pro['vulner'] < 20) {
                                                                echo "#00B74A";
                                                              } elseif ($pro['vulner'] >= 21 && $pro['vulner'] <= 40) {
                                                                echo "orange";
                                                              } elseif ($pro > 40) {
                                                                echo "red";
                                                              }
                                                              ?> ; color:aliceblue ; font-size:18px;"><?php echo $pro['vulner']; ?></td>



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