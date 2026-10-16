<?php
include 'connection.php';
require('tcpdf/tcpdf.php');

$tid = isset($_GET['tid']) ? $_GET['tid'] : 0;
$date1 = date('d-m-Y');

// Get main record
$result = mysqli_query($con, "SELECT * FROM tblmetal_detector_checks WHERE id = $tid");
$row = mysqli_fetch_assoc($result);

if(!$row) {
    header('Location: view_metal_checks.php');
    exit();
}

// Get test records
$tests = mysqli_query($con, "SELECT * FROM tblmetal_detector_tests WHERE check_id = $tid ORDER BY test_time");

class MYPDF extends TCPDF
{
    private $logo1Path = 'images/logo1.png';
    private $logo2Path = 'images/rtnts.png';
    private $footerHTML = '';

    public function Header()
    {
        // Set header background
        $this->SetFillColor(255, 255, 255);
        $this->Rect(0, 0, $this->getPageWidth(), 30, 'F');

        // Add logo 1 (left)
        if(file_exists($this->logo1Path)) {
            $this->Image($this->logo1Path, 15, 7, 25, '20', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }

        // Add logo 2 (right)
        if(file_exists($this->logo2Path)) {
            $this->Image($this->logo2Path, 260, 7, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }

        // Main title
        $this->SetFont('courier', 'B', 16);
        $this->SetTextColor(0, 51, 102);
        $this->SetXY(12, 12);
        $this->Cell(0, 0, 'METAL DETECTOR CHECK REPORT', 0, 1, 'C');

        // Header line
        $this->SetLineWidth(0.5);
        $this->SetDrawColor(0, 102, 204);
        $this->Line(15, 28, 285, 28);
    }

    public function Footer()
    {
        $this->SetY(-20);
        $this->SetFont('courier', '', 8);
        $this->SetTextColor(0, 0, 0);

        // Footer line
        $this->SetLineWidth(0.2);
        $this->SetDrawColor(204, 204, 204);
        $this->Line(15, $this->GetY(), 285, $this->GetY());

        if (!empty($this->footerHTML)) {
            $this->SetY(-15);
            $this->writeHTML($this->footerHTML, true, false, true, false, '');
        } else {
            $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 0, 'C');
        }
    }

    public function setFooterHTML($html)
    {
        $this->footerHTML = $html;
    }
}

// Create new PDF document
$pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator('Your Company');
$pdf->SetAuthor('Quality Control');
$pdf->SetTitle('Metal Detector Check Report');
$pdf->SetSubject('Metal Detector Checklist');
$pdf->SetKeywords('metal detector, checklist, report');

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(15, 30, 15, 15);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(20);
$pdf->SetAutoPageBreak(TRUE, 25);

// Footer content
$footerContent = <<<EOD
<table border="1" cellpadding="4" width="102%">

    <tr>
        <td width="33%">REC CD 37A</td>
        <td width="33%" style="text-align:center;" rowspan="2">Issue No: 18</td>
        <td width="33%">Issued Date: 06/01/2025</td>
    </tr>

    <tr>
        <td width="33%">Metal Detector Check Sheet</td>
        <td width="33%">Authorised by: M. Prajapati</td>
    </tr>
    
</table>
EOD;

$pdf->setFooterHTML($footerContent);
$pdf->AddPage();

// Start building HTML
$pdf->SetY(45);

// Title and Header Info
$html = '
<style>
    h3 { color: #003366; font-weight: bold; }
    .header-info { background: #f8f9fa; }
    .pass { color: green; font-weight: bold; }
    .fail { color: red; font-weight: bold; }
    .yes { color: green; font-weight: bold; }
    .no { color: red; font-weight: bold; }
</style>

<table border="1" cellpadding="6" width="100%" style="border-collapse: collapse;">
    <tr style="background-color: #003366; color: white; text-align:center;">
    <th width="33%">Report Date</th>
        <th width="33%">Record ID</th>
        <th width="34%">Line</th>
    </tr>

    <tr>
        <td align="center">' . date('d-m-Y', strtotime($row['check_date'])) . '</td>
        <td align="center">#' . $tid . '</td>
        <td align="center">Line ' . $row['line'] . '</td>
       
    </tr>
    
</table>

<br><br><br>

<h3>Basic Information</h3>
<table border="1" cellpadding="6" width="100%" style="border-collapse: collapse;">

    <tr>
        <th width="25%" style="background-color: #e9ecef;"><b>Operator Sign</b></th>
        <td width="25%">' . ($row['operator_sign'] ?: 'Not specified') . '</td>
        <th width="25%" style="background-color: #e9ecef;"><b>Verified by Technical</b></th>
        <td width="25%">' . ($row['verified_by'] ?: 'Not specified') . '</td>
    </tr>

</table>

<br><br><br>

<h3>Pre-start up Checks</h3>
<table border="1" cellpadding="6" width="100%" style="border-collapse: collapse;">
    <tr style="background-color: #e9ecef;">
        <th width="70%"><b>Check Item</b></th>
        <th width="30%"><b>Result</b></th>
    </tr>

    <tr>
        <td>1. Does the metal detector stop and alarm when air pressure is reduced?</td>
        <td align="center" class="' . strtolower($row['air_pressure_check']) . '">' . $row['air_pressure_check'] . '</td>
    </tr>

    <tr>
        <td>2. Does the reject arm fail-safe work correctly?</td>
        <td align="center" class="' . strtolower($row['reject_arm_check']) . '">' . $row['reject_arm_check'] . '</td>
    </tr>

    <tr>
        <td>3. Is the belt stop system working correctly?</td>
        <td align="center" class="' . strtolower($row['belt_stop_check']) . '">' . $row['belt_stop_check'] . '</td>
    </tr>
</table>

<br><br><br><br>
<h3>Test Records</h3>
<table border="1" cellpadding="5" width="100%" style="border-collapse: collapse;">
    <thead>
        <tr style="font-weight:bold; text-align:center;">
            <th >#</th>
            <th>Time</th>
            <th >Product Code</th>
            <th >Product Name</th>
            <th >Size</th>
            <th >R/S</th>
            <th >Test Stick</th>
            <th >Fe</th>
            <th >Non-Fe</th>
            <th>S/S</th>
            <th >Initial</th>
        </tr>
    </thead>
    <tbody>';

$j = 0;
while($test = mysqli_fetch_assoc($tests)) {
    $j++;
    $html .= '
        <tr>
            <td align="center">' . $j . '</td>
            <td align="center">' . $test['test_time'] . '</td>
            <td>' . $test['product_code'] . '</td>
            <td>' . $test['product_name'] . '</td>
            <td align="center">' . $test['product_size'] . '</td>
            <td align="center">' . $test['reject_action'] . '</td>
            <td>' . $test['test_stick'] . '</td>
            <td align="center" class="' . strtolower($test['fe_result']) . '">' . $test['fe_result'] . '</td>
            <td align="center" class="' . strtolower($test['non_fe_result']) . '">' . $test['non_fe_result'] . '</td>
            <td align="center" class="' . strtolower($test['ss_result']) . '">' . $test['ss_result'] . '</td>
            <td align="center">' . $test['initial'] . '</td>
        </tr>';
}

if($j == 0) {
    $html .= '<tr><td colspan="11" align="center">No test records found</td></tr>';
}

$html .= '
    </tbody>
</table>

<br>

<h3>Test Piece Size Reference</h3>
<table border="1" cellpadding="6" width="100%" style="border-collapse: collapse;">
    <thead>

        <tr>
            <th>Product Type</th>
            <th >Ferrous (mm)</th>
            <th >Non-ferrous (mm)</th>
            <th >Stainless steel (mm)</th>
        </tr>

    </thead>
    <tbody>

        <tr>
            <td>2L, 2.5L, 4L, 5L, 500ml, 125ml</td>
            <td align="center">2.5</td>
            <td align="center">3.0</td>
            <td align="center">4.77</td>
        </tr>

        <tr>
            <td>5L Bottles</td>
            <td align="center">2.5</td>
            <td align="center">3.0</td>
            <td align="center">4.77</td>
        </tr>

        <tr>
            <td>10L</td>
            <td align="center">3.5</td>
            <td align="center">4.0</td>
            <td align="center">4.77</td>
        </tr>
    </tbody>
</table>

<br>';

// Add comments if exists
if($row['comments']) {
    $html .= '
<h3>Comments</h3>
<table border="1" cellpadding="6" width="100%" style="border-collapse: collapse;">
    <tr>
        <td>' . nl2br($row['comments']) . '</td>
    </tr>
</table>
<br>';
}

// Procedure and Corrective Action
$html .= '
<h3>Procedure Reference</h3>
<table border="1" cellpadding="6" width="100%" style="border-collapse: collapse;">
    <tr>
        <td><strong>Procedure:</strong> Refer to Metal Detection Procedure OP47 and CCP signage OP48</td>
    </tr>
</table>

<br>

<h3>Corrective Action (if failure occurs)</h3>
<table border="1" cellpadding="6" width="100%" style="border-collapse: collapse;">
    <tr>
        <td>
            • Stop production & inform the Production Manager & Technical Manager<br>
            • Quarantine all product produced since last satisfactory check.
        </td>
    </tr>
</table>

<br><br>

';

$pdf->writeHTML($html, true, false, true, false, '');

// Output PDF
$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "finemed/upl1/metal_detector_report_" . $tid . ".pdf", "F");
?>

<!-- Display PDF in iframe -->
<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2">Metal Detector Report</h1>
        <ul>
            <li><a href="#">Quality Control</a></li>
            <li><a href="view_metal_checks.php">Metal Detector Record</a></li>
            <li>Report</li>
        </ul>
    </div>
    
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="view_metal_checks.php" class="btn btn-success" style="float:right; margin-left:15px">Go Back</a>
                <a href="upl1/metal_detector_report_<?php echo $tid; ?>.pdf" class="btn btn-primary" style="float:right; margin-right:10px" download>Download PDF</a>
                <div class="card-title">Metal Detector Check Report #<?php echo $tid; ?></div>
                
                <iframe src="upl1/metal_detector_report_<?php echo $tid; ?>.pdf" frameborder="0" width="100%" height="600px"></iframe>
            </div>
        </div>
    </div>
</div>

<style>
    .main-content { padding: 20px; }
    .breadcrumb { background: #f8f9fa; padding: 10px; margin-bottom: 20px; border-radius: 5px; }
    .breadcrumb h1 { display: inline-block; margin: 0; font-size: 24px; }
    .breadcrumb ul { float: right; list-style: none; margin: 0; padding: 0; }
    .breadcrumb ul li { display: inline-block; margin-left: 10px; }
    .card { border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    .card-title { font-size: 20px; font-weight: bold; margin-bottom: 20px; }
</style>











<!-- Signature Section -->
<!-- <table border="1" cellpadding="6" width="100%" style="border-collapse: collapse;">
    <tr style="background-color: #e9ecef;">
        <th width="50%">Checked By (Operator)</th>
        <th width="50%">Verified By (Technical)</th>
    </tr>

    <tr>
        <td align="center" height="50">
            <br><br>
            <hr width="80%">
            <small>' . ($row['operator_sign'] ?: '_________________') . '</small>
        </td>
        <td align="center" height="50">
            <br><br>
            <hr width="80%">
            <small>' . ($row['verified_by'] ?: '_________________') . '</small>
        </td>
    </tr>

    <tr>
        <td align="center"><small>Date: ' . date('d-m-Y', strtotime($row['check_date'])) . '</small></td>
        <td align="center"><small>Date: ' . date('d-m-Y') . '</small></td>
    </tr>
</table> -->