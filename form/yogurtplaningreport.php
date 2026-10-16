<?php
include 'connection.php';

$uid = $_GET['uid'];
require_once('tcpdf/tcpdf.php');

class MYPDF extends TCPDF {
    private $logo1Path = 'images/logo1.png';
    private $logo2Path = 'images/rtnts.png';
    private $footerHTML = '';

    public function Header() {
        $this->SetFillColor(255, 255, 255);
        $this->Rect(0, 0, $this->getPageWidth(), 30, 'F');

        if (file_exists($this->logo1Path)) {
            $this->Image($this->logo1Path, 15, 7, 16, '', 'PNG');
        }
        if (file_exists($this->logo2Path)) {
            $this->Image($this->logo2Path, 260, 7, 25, '', 'PNG');
        }

        $this->SetFont('Century gothic', 'B', 17);
        $this->SetTextColor(0, 51, 102);
        $this->SetXY(12, 12);
        $this->Cell(0, 0, 'Yogurt Planning Report', 0, 1, 'C');

        $this->SetLineWidth(0.5);
        $this->SetDrawColor(0, 102, 204);
        $this->Line(15, 28, 285, 28);
    }

    public function Footer() {
        $this->SetY(-20);
        $this->SetFont('Century gothic', '', 8);
        $this->SetTextColor(0, 0, 0);

        if (!empty($this->footerHTML)) {
            $this->SetY(-21);
            $this->writeHTML($this->footerHTML, true, false, true, false, '');
        } else {
            $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 0, 'C');
        }
    }

    public function setFooterHTML($html) {
        $this->footerHTML = $html;
    }
}

// Create PDF
$pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetDefaultMonospacedFont('Century gothic');
$pdf->SetMargins(15, 30, 15);
$pdf->SetHeaderMargin(10);
$pdf->SetAutoPageBreak(TRUE, 25);

$footerContent = <<<EOD
<table border="1" cellpadding="4" width="102%" style="font-weight:bold;">
    <tr>
        <td width="33%" rowspan="2" style="text-align:left;">CD 67 Weekly Organoleptic assessment record</td>
        <td width="33%" style="text-align:center;">Issue: 1</td>
        <td width="33%" style="text-align:left;">Amended by: Bijal Chauhan</td>
    </tr>
    <tr>
        <td width="33%" style="text-align:center;">Issue Date: 24/11/16</td>
        <td width="33%" style="text-align:left;">Authorised by: James Pattison</td>
    </tr>
</table>
EOD;

$pdf->setFooterHTML($footerContent);
$pdf->AddPage();

// Fetch product
$sql = mysqli_query($con,"SELECT * FROM `tblyogurt1` WHERE uid=$uid");
$row = mysqli_fetch_array($sql);
$prod = $row['ques'];

$sql1 = mysqli_query($con,"SELECT * FROM `tblyogurt` WHERE id=$prod");
$data1 = mysqli_fetch_array($sql1);
$pname = $data1['name'];

$pdf->SetY(40);

$tble = '
<h4>Date : ' . date("m-d-Y", strtotime($row['date'])) . '</h4>
<h4>Batch No. : ' . date("Ymd", strtotime($row['date'])) . '</h4>

<table border="1" cellpadding="5" cellspacing="0" style="font-size:11px; width:100%; text-align:center;">
    <thead>
        <tr style="background-color:#2c3e50; color:white;">
            <th width="20%">Product</th>
            <th width="9%">Batch</th>
            <th width="8%">Cream</th>
            <th width="8%">SMP</th>
            <th width="8%">Milk</th>
            <th width="8%">Fruit</th>
            
        </tr>
    </thead>
    <tbody>';
while ($rows = mysqli_fetch_array($sql)) {

    // Fetch product details from tblyogurt using ques as the ID
    $prodResult = mysqli_query($con, "SELECT * FROM `tblyogurt` WHERE id=" . (int)$rows['ques']);
    $prodData   = mysqli_fetch_array($prodResult);
    $pname      = $prodData['name'];

    // Build table row
    $tble .= '<tr nobr="true">
        <td width="20%">' . $pname . '</td>
        <td width="9%">' . $rows['batch'] . '</td>
        <td width="8%">' . $rows['cream'] . '</td>
        <td width="8%">' . $rows['smp'] . '</td>
        <td width="8%">' . $rows['milk'] . '</td>
        <td width="8%">' . $rows['fruit'] . '</td>
        
    </tr>';
}

$tble .= '</tbody></table>';

$pdf->writeHTML($tble, true, false, true, false, '');

// Save PDF
$filename = "yogurt_planning_report_".$uid.".pdf";
$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "finemed/form/upl1/" . $filename, "F");
?>

<div class="container-fluid my-4">
    <div class="card shadow-sm">
        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
            <h2 class="mb-0 text-white">📄 Yogurt Planning Report</h2>
            <a href="admin.php?id=yogurtPlanning_" class="btn btn-success btn-sm">Go Back</a>
        </div>
        <div class="card-body">
            <!-- Action Buttons -->
            <div class="mb-3">
                <a href="form/upl1/<?php echo $filename; ?>" download class="btn btn-success mr-2">⬇️ Download PDF</a>
                <a href="form/upl1/<?php echo $filename; ?>" target="_blank" class="btn btn-primary">📖 Open in New Tab</a>
            </div>
            <!-- Embedded PDF Viewer -->
            <div class="embed-responsive embed-responsive-4by3 border rounded">
                <iframe src="form/upl1/<?php echo $filename; ?>" class="embed-responsive-item" frameborder="0"></iframe>
            </div>
        </div>
    </div>
</div>
