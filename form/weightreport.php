<?php
include("connection.php");
require_once('tcpdf/tcpdf.php');

$sno = $_GET['sno'];

class MYPDF extends TCPDF
{
    private $logo1Path = 'images/1.png';
    private $logo2Path = 'images/rtnts.png';
    private $longTableFooter = '';

    public function Header()
    {
        $this->SetFillColor(255, 255, 255);
        $this->Rect(0, 0, $this->getPageWidth(), 30, 'F');

        if (file_exists($this->logo1Path)) {
            $this->Image($this->logo1Path, 15, 7, 20, '', '', '', 'T');
        }
        if (file_exists($this->logo2Path)) {
            $this->Image($this->logo2Path, 255, 7, 30, '', '', '', 'T');
        }

        $this->SetFont('century gothic', 'B', 22);
        $this->SetTextColor(0, 51, 102);
        $this->SetXY(12, 12);
        $this->Cell(0, 0, 'DAILY WEIGHT CHECK', 0, 1, 'C');

        $this->SetLineWidth(0.5);
        $this->SetDrawColor(0, 102, 204);
        $this->Line(15, 28, 280, 28);
    }

    public function Footer()
    {
        $this->SetFont('helvetica', '', 8);
        $this->SetY(-20);
        $this->writeHTML($this->longTableFooter);
    }

    public function setLongTableFooter($html)
    {
        $this->longTableFooter = $html;
    }
}

$pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator('Your Company');
$pdf->SetAuthor('Record');
$pdf->SetTitle('Daily Weight Check');
$pdf->SetSubject('Daily Weight Check');
$pdf->SetMargins(15, 30, 15);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(20);
$pdf->SetAutoPageBreak(TRUE, 25);

$footer = '
<table width="100%" cellpadding="3" border="0.2" style="font-size:9px; border-color:#000000; color:black;">
    <tr>
        <td width="255">Issue date: 27/04/2026</td>
        <td width="240" align="center">Page ' . $pdf->getAliasNumPage() . ' / ' . $pdf->getAliasNbPages() . '</td>
        <td width="255">Amended: Bijal Chauhan</td>
    </tr>
    <tr>
        <td width="255">Version No:8</td>
        <td width="240" align="center">Doc Ref: QF6.3.3A</td>
        <td width="255">Authorised by: Mahesh Prajapati</td>
    </tr>
    <tr>
        <td width="750" colspan="2">Reason for Change: Form has been reviewed</td>
    </tr>
</table>';

$pdf->setLongTableFooter($footer);
$pdf->AddPage();
$pdf->SetY(40);

// Fetch Batch Header Info
// Fetch Batch Header Info
$sql1 = mysqli_query($con, "SELECT * FROM tblweight WHERE id='$sno'");
$row1 = mysqli_fetch_assoc($sql1);

// Start HTML table
$html = '<table border="1" cellpadding="4" width="100%" style="font-size:9px;">
    <tr>
        <td width="20%"><b>Date</b></td>
        <td width="15%">' . date('d-m-Y', strtotime($row1['date'])) . '</td>
        <td width="20%"><b>Best Before</b></td>
        <td width="15%">' . date('d-m-Y', strtotime($row1['bestdate'])) . '</td>
        <td width="15%"><b>Batch No</b></td>
        <td width="15%">' . $row1['batch'] . '</td>
    </tr>
    <tr>
        <th width="50%"><b>Product Size </b></th>
        <th width="50%"><b>Filling Machines</b></th>
    </tr>';

// Split product sizes and filling machines
$psizes   = explode(';', $row1['psize']);
$fillings = explode(';', $row1['filling']); // assuming stored similarly

// Loop through both arrays
$max = max(count($psizes), count($fillings));
for ($i = 0; $i < $max; $i++) {
    $size    = isset($psizes[$i]) ? $psizes[$i] : '';
    $filling = isset($fillings[$i]) ? $fillings[$i] : '';

    $html .= '<tr>
                <td>' . $size . '</td>
                <td>' . $filling . '</td>
              </tr>';
}

$html .= '</table>';

// Output to PDF
$pdf->writeHTML($html, true, false, true, false, '');



// Main Data Table Header
$html1 = '<table border="1" cellpadding="3" width="100%" style="font-size:9px; border-collapse:collapse;">
<thead>
<tr>
<th><b>Weight Scale Calibration</b></th>
<th> <b>Pass/Fail</b></th>
<th><b>Action</b></th>
</tr>
</thead> 
<tbody>';

$html1 .= ' <tr>
<td>' . $row1['scale'] . '</td>
<td>' . $row1['pass_fail'] . '</td>
<td>' . $row1['action'] . '</td>

</tr></tbody></table>';

$pdf->writeHTML($html1, true, false, true, false, '');

// Main Data Table Header
$html2 = '
<table border="1" cellpadding="3" width="100%" style="font-size:9px; border-collapse:collapse;">
    <tr style="font-weight:bold; text-align:center; background-color:#f0f0f0;">
        <th width="50%">Product Size (g)</th>
        <th width="50%">Tare Weight (Empty Bucket with Lid)</th>
    </tr>';


$prod = mysqli_query($con, "SELECT * FROM `tblweights` WHERE id='$sno'");

$pdata = mysqli_fetch_array($prod);
$sizes = explode(';', $pdata['size']);
$tares = explode(';', $pdata['tare']);



foreach ($sizes as $skey => $svalue) {
    $size_val = $svalue;
    $tare_val = $tares[$skey];

    $html2 .= '<tr>
            <td style="text-align:center;">' . $size_val . '</td>
            <td style="text-align:center;">' . $tare_val . '</td>
        </tr>';
}


$html2 .= '<tr>
<th width="100%" align="center">Carry out weight checks at start and end of production and every 30 mins </th>
</tr>

    <tr style="font-weight:bold; text-align:center; background-color:#f0f0f0;">
        <th width="15%">Product</th>
        <th width="12%">Product size</th>

        <th width="12%">Time</th>
        <th width="8%">Pot 1</th>
        <th width="8%">Pot 2</th>
        <th width="8%">Pot 3</th>
        <th width="8%">Pot 4</th>
        <th width="8%">Avg Wt</th>
        <th width="9%">Net Wt</th>
        <th width="12%">Signature</th>
    </tr>';

// Fetch Data Rows
$sql = mysqli_query($con, "SELECT * FROM tblweight1 WHERE sno='$sno'");
while ($rows = mysqli_fetch_assoc($sql)) {
    $sign = '';
    if (!empty($rows["sign"])) {
        $signPath = 'form/sign/' . $rows['sign'] . '.png';
        if (file_exists($signPath)) {
            $sign = '<img src="' . $signPath . '" alt="" width="100" height="35">';
        }
    }                  

    // // Safely handle missing columns (prevents PHP warnings)
    // $productsize = isset($rows['productsize']) ? $rows['productsize'] : '';
    // $fillingmachines = isset($rows['fillingmachines']) ? $rows['fillingmachines'] : '';
    // $weightscales = isset($rows['weightscales']) ? $rows['weightscales'] : '';

    $html2 .= '
    <tr style="text-align:center; font-size:8px;">
        <td>' . $rows['product'] . '</td>
                <td>' . $rows['productsize'] . '</td>

        <td>' . $rows['time'] . '</td>
        <td>' . $rows['pack1'] . '</td>
        <td>' . $rows['pack2'] . '</td>
        <td>' . $rows['pack3'] . '</td>
        <td>' . $rows['pack4'] . '</td>
        <td>' . $rows['avgweight'] . '</td>
        <td>' . $rows['netweight'] . '</td>
        <td>' . $sign . '</td>
    </tr>';
}
$html2 .= '</table>';

$pdf->writeHTML($html2, true, false, true, false, '');

// Manager Signature Section
$msign = '';
if (!empty($row1['msign'])) {
    $msignPath = 'form/sign/' . $row1['msign'] . '.png';
    if (file_exists($msignPath)) {
        $msign = '<img src="' . $msignPath . '" alt="" width="120" height="40">';
    }
}

$html1 = '
<table border="0" width="100%" style="font-size:12px; margin-top:20px;">
    <tr>
        <td width="60%"></td>
        <td width="40%" style="text-align:right;">' . $msign . '<br><br><b>Manager Signature:</b> ' . $row1['manager'] . '</td>
    </tr>
</table>';

$pdf->writeHTML($html1, true, false, true, false, '');

$filename = "weight_record_$sno.pdf";
$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "finemed/upl1/$filename", "F");
?>

<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-12 d-flex justify-content-end">
            <a href="admin.php?id=weight1&sno=<?php echo $sno; ?>" class="btn btn-success mt-3">Go Back</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <iframe src="upl1/weight_record_<?php echo $sno; ?>.pdf" frameborder="0" width="100%"
                height="600px"></iframe>
            <?php if (empty($row1['msign'])) { ?>
                <a href="admin.php?id=weightverify&sno=<?= $sno ?>" class="btn btn-warning text-white w-100">Verify</a>
            <?php } ?>
        </div>
    </div>
</div>