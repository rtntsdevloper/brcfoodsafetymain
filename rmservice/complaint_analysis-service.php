<?php

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

// $pdf->SetFont('Helvetica', 'B', 14);


$pdf->AddPage('L', 'A4');
$pdf->SetFont('century gothic', '', 9);







// $pdf->Write(0, 'Example of PieSector() method.');


// Continue with the rest of your PDF generation code...
$pdf->SetXY(0, 8);
$tble11 = <<<EOD
<table width="1200" border="0"  >
<tr>
<td width ="30"></td>
<td width="150"><img src="images/1.png" width="130"style='float:center;'></td>
<td width="690" style="font-size:32px;  padding-top:20px; text-align:center;">Service Supplier KPI</td>
<td width="330"><img src="images/rtnts.png" width="130"style='float:center;'></td>
</tr>
</table>
EOD;
$pdf->writeHTML($tble11, true, false, true, false, '');
$pdf->setLongTableHeader($tble11);

if (isset($_GET['dmonth'])) {
    $cyear = date("Y", strtotime($_GET['dmonth']));
} else {
    $cyear = date("Y");
}

$riskstr = '' . $cyear . '-01,' . $cyear . '-02,' . $cyear . '-03,' . $cyear . '-04,' . $cyear . '-05,' . $cyear . '-06,' . $cyear . '-07,' . $cyear . '-08,' . $cyear . '-09,' . $cyear . '-10,' . $cyear . '-11,' . $cyear . '-12';

$compraw = explode(',', $riskstr);








$spl = mysqli_query($con, "SELECT * FROM `tblrawsupplier` WHERE suptype = 'Service Supplier'");
if (isset($_GET['dmonth'])) {
    $mvalue1 = date('Y-m', strtotime($_GET['dmonth']));
} else {
    $mvalue1 = date('Y-m');
}
$mvalue1 = trim($mvalue1);


// Loop through suppliers and calculate total complaints
while ($sprl = mysqli_fetch_assoc($spl)) {
    $supnm = $sprl['supname'];
    $total_complaints = 0;


    $stmt = mysqli_query($con, "SELECT COUNT(*) AS total_complaints FROM tblsuppliercomplaint WHERE DATE_FORMAT(date, '%Y-%m') = '$mvalue1' AND supplier = '$supnm' ");
    $nsm = mysqli_num_rows($stmt);
    $nsd = mysqli_fetch_assoc($stmt);
    if ($nsm == 0) {
        $total = 0;
    } else {
        $total = $nsd['total_complaints'];
    }
    $total_complaints += $total;

    $data[$supnm] = $total_complaints;
    $colm[$supnm] = array(rand(0, 255), rand(12, 255), rand(25, 255));
}

// Prepare data for the bar graph


// Calculate total percentage


$totalPercentage = array_sum($data);
if (empty($totalPercentage)) {
    $mx = 0;
} else {
    $mx = max($data);
}



$cnm = count($data);



// Set chart position and size
$x = 15;
$y = 38;
$width = 270;
$height = 80;

// Draw chart background with border
$pdf->Rect($x, $y, $width, $height, 'D', array(), array(200, 200, 200));

// Set font for chart title
$pdf->SetFont('Helvetica', '', 9);

// Draw bars for each risk level
// 10 percentage steps
$yLabelStep = $height / 4;
$mcb = $mx / 4; // 10 percentage steps
for ($i = 0; $i <= 4; $i++) {
    $percentage = $i * $mcb;
    $yLabelPos = $y + $height - ($i * $yLabelStep);

    // Draw a line for percentage indication
    if ($i % 1 == 0) { // Draw lines for 10%, 20%, ...
        $pdf->SetLineStyle(array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(128, 128, 128)));
        $pdf->Line($x, $yLabelPos, $x + $width, $yLabelPos);
    }

    $pdf->SetFont('Helvetica', '', 8);
    $pdf->Text($x - 7, $yLabelPos - 1.5, $percentage);
}

foreach ($data as $label => $value) {
    if ($mx == 0) {
        $barHeight = 0;
    } else {
        $barHeight = ($value / $mx) * $height;
    }

    $color = $colm[$label];

    $pdf->Rect($x + 2, $y + $height - $barHeight, $width / $cnm - 3, $barHeight, 'F', array(), $color);

    $x += $width / $cnm;
}

$pdf->StartTransform();
$pdf->Rotate(90, 100, 100); // Rotate 90 degrees around the point (100,100)
$pdf->SetFont('century gothic', '', 11);
// Print the text
$pdf->Text(100, 3, 'Number of complaints');

// Stop the transformation
$pdf->StopTransform();

$pdf->SetFont('century gothic', '', 11);
$pdf->Text(140, 120, "Suppliers");

$pdf->SetXY(6, 128);
$pdf->SetFont('century gothic', '', 9);

$tbl29 = '';

$tbl29 .= '
  <table  width ="1010" cellpadding ="5" style="border: 2px solid black; ">
  <tr width ="1010" style="font-size:17px; color:navy; text-align:center"> 
  <td  style="font-size:20px; color:navy; text-align:center"> Monthly KPI <span  style="font-size:17px; color:blue; " > ' . date('M-Y', strtotime($mvalue1)) . '</span></td>
  
  </tr>
  <tr nobr="true" >
  ';
$ki = 0;

foreach ($data as $keys => $valuem) {
    $ki++;

    $comp = $valuem;
    $colorc = $colm[$keys];
    $colorc = implode(',', $colorc);


    $tbl29 .= '
        <td width="25"><div style="background-color:RGB(' . $colorc . ')"></div></td>
        <td width ="90">' . $keys . '</td>
       ';
    if ($ki % 9 == 0) {
        $tbl29 .= '
        </tr>
        <tr nobr="true">
        ';
    }
}




$tbl29 .= '
 </tr>
</table>';
$pdf->writeHTML($tbl29, true, false, true, false, '');




// monthly bar chart end













$pdf->AddPage('L', 'A4');
$pdf->SetFont('century gothic', '', 9);

$pdf->SetXY(5, 40);
$pdf->SetFont('century gothic', '', 10);

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
      background-color:#F0F0F0;
 border: 1px solid #000000;
   color: #000000;
   text-align: center;
}
td {
  
    border: 1px solid #000000;
   color: #000000;
   text-align: center;
}
</style>



<table id="gallerytab" width="900" cellspacing="0" cellpadding="2" border="0" >
  ';

$tbl_footer = '</table>';










$tbl7 = "";

$tbl7 .= '<tr>
<th width="60">Sr No.</th>
<th width="104">Supplier Name</th>
<th width="100">Basis of Approval</th>

';
foreach ($compraw as $th) {
    $drv = date('M-Y', strtotime($th));


    $tbl7 .= '
<th width="63">' . $drv . '</th>';
}
$tbl7 .= '
  </tr>

  <tbody>
  
  ';

$i = 0;


$spl = mysqli_query($con, "SELECT * FROM `tblrawsupplier` WHERE suptype = 'Service Supplier'");
$i = 0;
foreach ($spl as $sprl) {
    $i++;
    $supnm = $sprl['supname'];
    $tbl7 .= '<tr nobr="true">
    <td>' . $i . '</td>
    <td>' . $supnm . '</td>
    <td>' . $sprl["approval"] . '</td>
    ';
    foreach ($compraw as $key1 => $value1) {

        $sup1 = mysqli_query($con, " SELECT 
                          supplier, 
                          DATE_FORMAT(date, '%Y-%m') AS complaint_month,
                          COUNT(*) AS total_complaints
                      FROM 
                          tblsuppliercomplaint
                      WHERE 
                          DATE_FORMAT(date, '%Y-%m') = '$value1'
                          AND supplier = '$supnm'
                      GROUP BY 
                          supplier, complaint_month;
                   ");
        $cmpdt = mysqli_fetch_array($sup1);
        $count = mysqli_num_rows($sup1);  //get count row in query
        //  echo $count;
        if ($count == 0) {
            $total = 0;
        } else {
            $total = $cmpdt['total_complaints'];
        }
        $tbl7 .= '
                    <td width="63">' . $total . '</td>';
    }
    $tbl7 .= '</tr>
  ';
}



$tbl7 .= '
</tbody>

';
$pdf->writeHTML($tbl_header . $tbl7 . $tbl_footer, true, false, false, false, '');

















// Sanitize the filename
$filename = "service-complaint"; // Sanitize the GRN number

// Define the full path for the PDF
$filePath = $_SERVER['DOCUMENT_ROOT'] . "brcfoodsafety/rmservice/docs/complaint/" . $filename . ".pdf";
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




<!-- tcpdf end -->




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
            <li>Supplier Monitoring</li>
            <li>Service Supplier KPI</li>
        </ul>
    </div>
    <div class="container-fluid " style="margin-top:100px;">
        <div class="row mb-12">
            <div class="col-md-12 col-sm-12 mb-12">
                <div class="card text-left">
                    <div class="card-body">

                        <h3 class="text-primary">Service Supplier KPI</h3>

                        <div class="row">
                            <div class="col-md-5 col-lg-7 sm-6">
                                <select id="datayear">
                                    <?php
                                    $dtyear = $_GET['dyear'];
                                    if (isset($dtyear)) {
                                        echo '<option value="' . $dtyear . '">' . $dtyear . '</option>';
                                    }

                                    $result = "SELECT YEAR(date) AS complaint_year FROM tblsuppliercomplaint GROUP BY complaint_year";
                                    $result1 = mysqli_query($con, $result); // corrected variable name
                                    foreach ($result1 as $dyear) { ?>
                                        <option value="<?php echo $dyear['complaint_year']; ?>"><?php echo $dyear['complaint_year']; ?></option>
                                    <?php }
                                    ?>
                                </select>
                                <script>
                                    $('#datayear').on('change', function() {
                                        var selectedValue = $(this).val();


                                        window.open('admin?id=service-analysis&dyear=' + selectedValue, '_self');
                                    });
                                </script>


                            </div>

                            <div class="col-md-4 col-lg-3 col-sm-6 " class="input-group">

                                <select id="datamonth" class="text-right; form-control">
                                    <?php
                                    $dtyear = $_GET['dmonth'];
                                    if (isset($dtyear)) {
                                        echo '<option value="' . $dtyear . '">' . date('M-Y', strtotime($dtyear)) . '</option>';
                                    } else {
                                        echo '<option value=""> Select Month for Report</option>';
                                    }

                                    $result = "SELECT CONCAT(YEAR(date), '-', MONTH(date)) AS complaint_month FROM tblsuppliercomplaint GROUP BY YEAR(date), MONTH(date) ORDER BY complaint_month DESC;";
                                    $result1 = mysqli_query($con, $result); // corrected variable name
                                    foreach ($result1 as $dyear) { ?>
                                        <option value="<?php echo $dyear['complaint_month']; ?>"><?php echo date('M-Y', strtotime($dyear['complaint_month'])); ?></option>
                                    <?php }
                                    ?>
                                </select>

                                <script>
                                    $('#datamonth').on('change', function() {
                                        var selectedValue = $(this).val();


                                        window.open('admin?id=service-analysis&dmonth=' + selectedValue, '_self');
                                    });
                                </script>


                            </div>
                            <div class="col-md-3 col-lg-2 col-sm-12">
                                <a href="admin.php?id=manage-complaint"><button class="btn btn-primary mb-3"
                                        style="float:right; margin-left:15px">Go Back</button></a>
                                <a href="rmservice/docs/complaint/service-complaint.pdf" target="_blank" class="btn btn-primary mb-3" style="float:right; margin-left:15px">View Report</a>

                            </div>









                        </div>













                        <!-- <p>List of staff</p> -->

                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered" id="zero_configuration_table"
                                style="width:100%">
                                <thead>
                                    <tr class="text-center">
                                        <th width="28">SR No.</th>
                                        <th width="48">Supplier Name</th>
                                        <th width="48">Basis of Aproval</th>

                                        <?php
                                        if (isset($_GET['dyear'])) {
                                            $cyear = $_GET['dyear'];
                                        } else {
                                            $cyear = date("Y");
                                        }



                                        $riskstr = '' . $cyear . '-01,' . $cyear . '-02,' . $cyear . '-03,' . $cyear . '-04,' . $cyear . '-05,' . $cyear . '-06,' . $cyear . '-07,' . $cyear . '-08,' . $cyear . '-09,' . $cyear . '-10,' . $cyear . '-11,' . $cyear . '-12';




                                        $riskarr = explode(',', $riskstr);
                                        foreach ($riskarr as $key => $value) {
                                            $dateString = $value;
                                            $timestamp = strtotime($dateString); // Prepend a day to make it a valid date
                                            $formattedDate = date("M Y", $timestamp); // Format the timestamp to "Nov 2024"

                                        ?>

                                            <th width="48"><?php
                                                            echo $formattedDate; ?></th>
                                        <?php
                                        }
                                        ?>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php


                                    $sp = mysqli_query($con, "SELECT * FROM `tblrawsupplier` WHERE suptype = 'Service Supplier'");
                                    $i = 0;
                                    foreach ($sp as $spr) {
                                        $i++;
                                        $supnm = $spr['supname']; ?>
                                        <tr>
                                            <td width="28"><?php echo $i; ?></td>
                                            <td width="48"><?php echo $spr['supname']; ?></td>
                                            <td width="48"><?php echo $spr['approval']; ?></td>



                                            <?php
                                            foreach ($riskarr as $key1 => $value1) {

                                                $sup1 = mysqli_query($con, " SELECT 
                            supplier, 
                            DATE_FORMAT(date, '%Y-%m') AS complaint_month,
                            COUNT(*) AS total_complaints
                        FROM 
                            tblsuppliercomplaint
                        WHERE 
                            DATE_FORMAT(date, '%Y-%m') = '$value1'
                            AND supplier = '$supnm'
                        GROUP BY 
                            supplier, complaint_month;
                     ");
                                                $cmpdt = mysqli_fetch_array($sup1);
                                                $count = mysqli_num_rows($sup1);  //get count row in query
                                                //  echo $count;
                                                if ($count == 0) {
                                                    $totalcomp = 0;
                                                } else {
                                                    $totalcomp = $cmpdt['total_complaints'];
                                                }


                                            ?>
                                                <td width="48"><?php echo $totalcomp; ?></td>





                                            <?php

                                            }
                                            ?>
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


<style>
    .canvasjs-chart-credit {
        display: none !important;
    }
</style>



<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>

<div id="chartContainer" style="height: 370px; width: 100%; margin: 10% 0% ; overflow:scroll"></div>

<script>
    window.onload = function() {
        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            exportEnabled: true,
            title: {
                text: "Service Supplier KPI"
            },
            subtitles: [{

            }],
            data: [
                <?php
                $sp = mysqli_query($con, "SELECT * FROM `tblrawsupplier` WHERE suptype = 'Service Supplier'");
                foreach ($sp as $spr) {
                    $supnm = $spr['supname']; ?> {
                        type: "column",
                        name: "<?php echo $supnm; ?>",
                        legendText: "<?php echo $supnm; ?>",
                        showInLegend: "true",
                        dataPoints: [
                            <?php

                            $riskarr = explode(',', $riskstr);
                            foreach ($riskarr as $key1 => $value1) {
                                $sup1 = mysqli_query($con, " SELECT 
                  supplier, 
                  DATE_FORMAT(date, '%Y-%m') AS complaint_month,
                  COUNT(*) AS total_complaints
                FROM 
                 tblsuppliercomplaint
                WHERE 
                  DATE_FORMAT(date, '%Y-%m') = '$value1'
                  AND supplier = '$supnm'
                GROUP BY 
                  supplier, complaint_month;
              ");
                                $cmpdt = mysqli_fetch_array($sup1);
                                $count = mysqli_num_rows($sup1);  //get count row in query
                                //  echo $count;
                                if ($count == 0) {
                                    $totalcomp = 0;
                                } else {
                                    $totalcomp = $cmpdt['total_complaints'];
                                }
                            ?> {
                                    y: <?php echo $totalcomp; ?>,
                                    label: "<?php echo $value1; ?>"
                                },
                            <?php
                            }
                            ?>
                        ]
                    },
                <?php
                }
                ?>
            ]
        });
        chart.render();

        chart.render();
        var chartImage = chart.toDataURL();
        $.ajax({
            type: "POST",
            url: "generate-pdf.php",
            data: {
                chartImage: chartImage
            }
        });
    }
</script>