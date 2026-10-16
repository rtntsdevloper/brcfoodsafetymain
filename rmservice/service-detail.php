<?php
include 'connection.php';
$sql1 = mysqli_query($con, "SELECT * FROM `tblrawsupplier` WHERE risk !='Pending' and suptype !='Raw Material Supplier'");









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

$fdate = "01" . date('-m-Y');

$footer = <<<EOD

<table border="1" width="1000" border="0.5" cellpadding="3">
  <tr>
  <td style="text-align:center">Updated On: $fdate </td>
  <td style="text-align:center; padding-top:15px;">Updated By: Bijal Chauhan</td>
  <td style="text-align:center; padding-top:15px;">Approved by: Paramvir S. Deol</td>
 
  </tr>
</table>
EOD;
$pdf->setLongTableFooter($footer);


// $pdf->Write(0, 'Example of PieSector() method.');


// Continue with the rest of your PDF generation code...
$pdf->SetXY(0, 6);
$tble11 = <<<EOD
<table width="1200" border="0"  >
<tr>
<td width ="30"></td>
<td width="150"><img src="images/1.png"  height="60" style='float:center;'></td>
<td width="690" style="font-size:30px; text-align:center;">Service/Packaging Supplier Risk Assesment</td>
<td width="330"><img src="images/rtnts.png"  height="60" style='float:center;'></td>
</tr>
</table>
EOD;
$pdf->writeHTML($tble11, true, false, true, false, '');
$pdf->setLongTableHeader($tble11);




$query = "SELECT * FROM `tblrawsupplier` WHERE risk !='Pending' ";
$result = mysqli_query($con, $query);
$i = 1;
$green = 0;
$red = 0;
$yellow = 0;

while ($row = mysqli_fetch_array($result)) {
  if ($row['risk'] >= 4 && $row['risk'] <= 6) {
    $green += 1;
  } elseif ($row['risk'] >= 7 && $row['risk'] <= 9) {
    $yellow += 1;
  } elseif ($row['risk'] > 9) {
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
$x = 32;
$y = 35;
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
  $pdf->Text($x - 9, $yLabelPos - 1.5, $percentage . "%");
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
  $pdf->Rect($x + 15, $y + $height - $barHeight, $barWidth, $barHeight, 'F', array(), $color);


  $x += $barWidth + $barSpacing;
}

$pdf->Text(72, 105, 'Overall Risk Associated');


$pdf->SetTextColor(255, 255, 255);
$pdf->SetXY(170, 50);
$tble9 = <<<EOD
<table width="400" cellpadding="5"  border="1" >
<tr style="background-color:#B0C4DE;">

<td width ="40"></td>
<th width="185"  style="color:black;font-size: 16px;">Overall Risk  
</th>
<th width="185"  style="color:black;font-size: 16px;">Overall Score
</th>
</tr>

<tr>

<td width ="40"><div style="background-color:green;"></div></td>
<td width="185"  style="color:black;font-size: 13px;"> Low  
</td>
<td width="185"  style="color:black;font-size: 13px;"> 5 - 9
</td>

</tr>
<tr>

<td width ="40"><div style="background-color:orange;"></div></td>
<td width="185"  style="color:black;font-size: 13px;">Medium  
</td>
<td width="185"  style="color:black;font-size: 13px;"> 10 - 13
</td>

</tr>

<tr>
<td width ="40"><div style="background-color:firebrick;"></div></td>
<td width="185" style="color:black; font-size: 13px;"> High
</td>
<td width="185" style="color:black; font-size: 13px;"> 13+
</td>

</tr>
</table>
EOD;
$pdf->writeHTML($tble9, true, false, true, false);









$pdf->SetXY(25, 112);
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



$pdf->SetFont('century gothic', '', 9);
$pdf->SetXY(20, 140);
$tble11 = <<<EOD
<table width="100%" cellspacing="0" cellpadding="4" border="1" style="text-align: center;color:black">
                                        <thead>
                                            <tr>
                                                <th>Risk Associated</th>
                                                <th>Third party certification</th>
                                                <th>Inherent Risk</th>
                                                <th>Performance history (Past Quality issues)</th>
                                                <th>Volumes Supplied</th>
                
                                            </tr>
                                        </thead>
                                        <tr style="background-color: #99ff99;">
                                            <th>1 (Low)</th>
                                            <td>BRC or Equivalnet</td>
                                            <td>Low</td>
                                            <td>Good</td>
                                            <td>Low</td>
                                           

                                        </tr>
                                        <tr style="background-color: #FFBF00;">
                                            <th>2 (Medium)</th>
                                            <td>Salsa or Equivalnet</td>
                                            <td>Medium</td>
                                            <td>Acceptable</td>
                                            <td>Medium</td>
                                            

                                        </tr>
                                        <tr style="background-color: #FF7F7F;">
                                            <th>3 (High)</th>
                                            <td>No certification</td>
                                            <td>High</td>
                                            <td>Poor</td>
                                            <td>High</td>
                                            

                                        </tr>

                                    </table>



EOD;
$pdf->writeHTML($tble11, true, false, true, false);

$pdf->AddPage();
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


<table id="gallerytab" width="1000" cellspacing="0" cellpadding="4" border="0" >
  ';

$tbl_footer = '</table>';

$tbl7 = '';
$tbl7 .= '

    <tr class="text-center">
                    <th width="40">SR No.</th>
                    <th width="160">Supplier Name</th>
                    <th width="160">Third Party certification</th>
                    <th width="160">Inherent Risk</th>
                    <th width="160">Performance history (Past Quality issues)</th>
                    <th width="160">Volumes supplied</th>
                    <th width="160">Overall Risk Score</th>
                  </tr>

  <tbody>
  
  ';
$i = 0;

foreach ($sql1 as $row) {
  $i++;
  $supplier = $row['supname'];

  $q = $row['riskd'];
  $q1 = explode(';', $q);
  $vuscore = $row['risk'];


  $tbl7 .= '
    <tr nobr="true">
    <td width ="40">' . $i . '</td>
    <td width ="160" style="word-wrap: break-word; text-align:center;white-space: pre-wrap;">' . $supplier . '</td>
   
    
    ';



  foreach ($q1 as $des) {
    $tbl7 .= '
      <td width="160" style="  background-color:' .
      ($des == 1 ? '#99ff99' : ($des == 2  ? '#FFBF00' : '#FF7F7F')) .
      '; font-size:17px; color:black; ">' . $des . '</td>
      ';
  }


  $tbl7 .= '
      <td width="160" style="  background-color:' .
    ($vuscore >= 4 && $vuscore <= 6 ? '#00B74A' : ($vuscore >= 7 && $vuscore <= 9 ? 'orange' : 'firebrick')) .
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
$filename = "service-supplier-risk-assesment"; // Sanitize the GRN number

$filePath = $_SERVER['DOCUMENT_ROOT'] . "finemed/rmservice/docs/pdfs/" . $filename . ".pdf";

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
      <li>Raw Supplier</li>
      <li>Risk Assesment Result</li>
    </ul>
  </div>
  <div class="container-fluid " style="margin-top:100px;">
    <div class="row mb-12">
      <div class="col-md-12 mb-12">
        <div class="card text-left">
          <div class="card-body">
            <h3 class="text-primary">Service/Packaging Supplier Risk Assesment</h3>
            <div class="row">
              <div class="col-md-12" style="display: flex; justify-content: right;">

                <a href="rmservice/docs/pdfs/<?php echo $filename; ?>.pdf" target="_blank"><button class="btn btn-primary mb-3"
                    style="float:right; margin-left:15px">View Report</button></a>
                <a href="admin.php?id=knowledge"><button class="btn btn-info mb-3"
                    style="float:right; margin-left:15px">Horizon Scanning</button></a>
                <a href="admin.php?id=foodfraud"><button class="btn btn-info mb-3"
                    style="float:right; margin-left:15px">Food Fraud Adulteration</button></a>
                <a href="admin.php?id=supplier-management"><button class="btn btn-success mb-3"
                    style="float:right; margin-left:15px">Go Back</button></a>

              </div>
            </div>



            <br>
            <div class="row">
              <div class="col-md-12 " style="display: flex; justify-content: center;">

                <div class="btn-group my-5" role="group" aria-label="Basic example">
                  <a href="admin.php?id=supplier-detail" class="btn  <?php echo $_GET['id'] == 'supplier-detail' ? 'btn-primary' : 'btn-secondary'; ?>">Raw Material Supplier</a>
                  <a href="admin.php?id=service-detail" class="btn <?php echo $_GET['id'] == 'service-detail' ? 'btn-primary' : 'btn-secondary';; ?>">Service/Packaging Supplier</a>
                </div>

              </div>
            </div>
            <!-- <p>List of staff</p> -->

            <div class="table-responsive">
              <table class="display table  table-bordered" id="zero_configuration_table" style="width:100%">
                <thead>
                  <tr class="text-center">
                     <th width="40">SR No.</th>
                    <th width="160">Supplier Name</th>
                    <th width="160">Third Party certification</th>
                    <th width="160">Inherent Risk</th>
                    <th width="160">Performance history (Past Quality issues)</th>
                    <th width="160">Volumes supplied</th>
                    <th width="160">Overall Risk Score</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $risk = mysqli_query($con, "SELECT * FROM `tblrawsupplier`  where status='Active' and suptype !='Raw Material Supplier'");
                  $num = 0;
                  foreach ($risk as $pro) {
                    $num++;
                    $sid = $pro['supid'];



                  ?>
                    <tr>
                      <td width="48"><?php echo $num; ?></td>
                      <td width="160"><?php echo $pro['supname']; ?></td>

                      <?php
                      if ($pro['risk'] == 'Pending') {
                      ?>
                        <td width="160" colspan="6" style="text-align: center;color:navy;background-color:#B2FFFF;font-size:18px;">Pending</td>

                        <?php
                      } else {
                        $rd = explode(';', $pro['riskd']);
                        foreach ($rd as $r1) {
                        ?>
                          <td width="160" style="font-size:18px;color:navy"><?php echo $r1; ?></td>

                        <?php
                        }
                        ?>



                        <td width="48" style="background-color: <?php if ($pro['risk'] >= 4 && $pro['risk'] <= 6) {
                                                                  echo "#00B74A";
                                                                } elseif ($pro['risk'] >= 7 && $pro['risk'] <= 9) {
                                                                  echo "#FFBF00";
                                                                } elseif ($pro['risk'] > 9) {
                                                                  echo "firebrick";
                                                                }

                                                                ?> ; color:aliceblue ; font-size:18px;"><?php echo $pro['risk']; ?></td>



                    </tr>











                <?php

                      }
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