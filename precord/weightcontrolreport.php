<?php
include 'connection.php';
$date = $_GET['date'];

require_once('tcpdf/tcpdf.php');

class MYPDF extends TCPDF
{
    private $logo1Path = 'images/logo1.png';
    private $logo2Path = 'images/rtnts.png';
    private $footerHTML = '';

    public function Header()
    {
        $this->SetFillColor(255, 255, 255);
        $this->Rect(0, 0, $this->getPageWidth(), 30, 'F');

        if (file_exists($this->logo1Path)) {
            $this->Image($this->logo1Path, 15, 7, 16, '', 'PNG');
        }
        if (file_exists($this->logo2Path)) {
            $this->Image($this->logo2Path, 260, 7, 25, '', 'PNG');
        }

        $this->SetFont('courier', 'B', 17);
        $this->SetTextColor(0, 51, 102);
        $this->SetXY(12, 12);
        $this->Cell(0, 0, 'WEIGHT CONTROL CHECKS REPORT', 0, 1, 'C');

        $this->SetLineWidth(0.5);
        $this->SetDrawColor(0, 102, 204);
        $this->Line(15, 28, 285, 28);
    }

    public function Footer()
    {
        $this->SetY(-20);
        $this->SetFont('courier', '', 8);
        $this->SetTextColor(0, 0, 0);

        if (!empty($this->footerHTML)) {
            $this->SetY(-21);
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

// Create PDF
$pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetDefaultMonospacedFont('courier');
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


$thead = '<table border="0" cellpadding="5" cellspacing="0" style="font-size:12px;">
    <thead>
        <tr>
            <th><b>Date : ' . date('d-m-Y', strtotime($date)) . '</b></th>
        </tr>
        
    </thead>
</table>';

$pdf->writeHTML($thead, true, false, true, false, '');
$sql = mysqli_query($con, "SELECT * FROM `weightcontrol` WHERE date='$date' ");

while ($row = mysqli_fetch_assoc($sql)) {
    $html = '<table border="1" cellpadding="5" cellspacing="0" style="font-size:12px; margin-bottom:20px;">
        <thead>
            <tr>
                <th width="42%"><b>Min Net Weight</b></th>
                <td width="15%">' . $row['netweight'] . '</td>
                <th width="34%"><b>Min Gross Weight</b></th>
                <td width="9%">' . $row['grossweight'] . '</td>
            </tr>
            <tr>
                <th width="10%"><b>Product</b></th>   
                <th width="10%"><b>Code</b></th>
                <th width="7%"><b>Size (L)</b></th>
                <th width="15%"><b>Target Overrun %</b></th>
                <th width="15%"><b>Actual Overrun %</b></th>   
                <th width="13%"><b>Reject Below Min Weight</b></th>
                <th width="10%"><b>Start Time</b></th>
                <th width="11%"><b>Finish Time</b></th>
                <th width="9%"><b>Sign</b></th>
            </tr>
        </thead>
        <tbody>';

    $sno = $row['id'];

    $sq = mysqli_query($con, "SELECT * FROM `weightcontrol1` WHERE sno='$sno' ");
    while ($data = mysqli_fetch_assoc($sq)) {
        $html .= '<tr>
            <td width="10%">' . $data['product'] . '</td>   
            <td width="10%">' . $data['code'] . '</td>
            <td width="7%">' . $data['size'] . '</td>
            <td width="15%">' . $data['target'] . '</td>
            <td width="15%">' . $data['actual'] . '</td>   
            <td width="13%">' . $data['reject'] . '</td>
            <td width="10%">' . $data['start'] . '</td>
            <td width="11%">' . $data['end'] . '</td>
            <td width="9%"><img src="precord/sign/' . $data['sign'] . '.png" alt=""></td>
        </tr>';
    }
        $html .= '<tr>
        <td width="42%">Average Product Weight: '.$row['average'].' </td>
        <td width="28%">Giveaway : '.$row['give'].' </td>
        <td width="30%">Comment :'.$row['comment'].' </td>

    
    
        </tr>';


    $html .= '</tbody>
    </table>';

    // Output to PDF
    $pdf->writeHTML($html, true, false, true, false, '');
}











// Save PDF
$filename = "weightcontrol_report_" . $date . ".pdf";
$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "/finemed/upl1/" . $filename, "F");
?>


<div class="container-fluid my-4 d-flex justify-content-end">
    <!-- Go Back Button aligned right -->
    <a href="admin.php?id=weightcontrol1&date=<?php echo htmlspecialchars($date); ?>" 
       class="btn btn-success btn-sm">
       Go Back
    </a>
</div>

<!-- Embedded PDF Viewer -->
<div class="embed-responsive embed-responsive-4by3 border rounded">
    <iframe src="upl1/<?php echo htmlspecialchars($filename); ?>"
            class="embed-responsive-item"
            frameborder="0"
            style="width:100%; height:600px;">
    </iframe>
</div>
