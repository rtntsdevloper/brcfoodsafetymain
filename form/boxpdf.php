<?php
$vdate = $_GET['vdate'];

require_once('tcpdf/tcpdf.php');

class MYPDF extends TCPDF {
    private $logo1Path = 'images/logo1.png';
    private $logo2Path = 'images/rtnts.png';
    private $footerHTML = '';

    public function Header() {
        $this->SetFillColor(255, 255, 255);
        $this->Rect(0, 0, $this->getPageWidth(), 30, 'F');

        if (file_exists($this->logo1Path)) {
            $this->Image($this->logo1Path, 15, 7, 23, '', 'PNG');
        }
        if (file_exists($this->logo2Path)) {
            $this->Image($this->logo2Path, 260, 7, 25, '', 'PNG');
        }

        $this->SetFont('courier', 'B', 16);
        $this->SetTextColor(0, 51, 102);
        $this->Cell(0, 0, 'Boxing Record', 0, 1, 'C');

        $this->SetLineWidth(0.5);
        $this->SetDrawColor(0, 102, 204);
        $this->Line(15, 28, 285, 28);
    }

    public function Footer() {
        $this->SetY(-20);
        $this->SetFont('courier', '', 8);
        $this->SetTextColor(0, 0, 0);

        $this->SetLineWidth(0.2);
        $this->SetDrawColor(204, 204, 204);
        $this->Line(15, $this->GetY(), 285, $this->GetY());

        if (!empty($this->footerHTML)) {
            $this->SetY(-15);
            $this->writeHTML($this->footerHTML, true, false, true, false, '');
        } else {
            $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, 0, 'C');
        }
    }

    public function setFooterHTML($html) {
        $this->footerHTML = $html;
    }
}

$pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetTitle('Boxing Record');
$pdf->SetMargins(15, 30, 15, 15);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(20);
$pdf->SetAutoPageBreak(TRUE, 25);

$footerContent = <<<EOD
<table border="1" cellpadding="4" width="102%">
    <tr>
        <td width="34%" style="text-align:center;">Issue to: </td>
        <td width="33%" rowspan="2" style="text-align:center;">REC 6.1.005</td>
        <td width="33%" style="text-align:center;">Author: Usama Mustafa</td>
    </tr>
    <tr>
        <td width="34%" style="text-align:center;">Version : 01</td>
        <td width="33%" style="text-align:center;">Authorised by: Paramvir S. Deol</td>
    </tr>
</table>
EOD;
$pdf->setFooterHTML($footerContent);

// Fetch all records for the date
$sql = mysqli_query($con, "SELECT * FROM `zendboxing` WHERE date='$vdate'");
while ($sqlx = mysqli_fetch_array($sql)) {
    $pdf->AddPage();
    $pdf->SetY(40);

    $sqldate = date('d-m-Y', strtotime($sqlx['date']));

    // Record details
    $basic = '
    <style>
    table{font-size:12px;}
    th{font-weight:bold;background-color:#e6e6e6;}
    </style>';

    $basic .= '<table border="1" cellpadding="3" width="100%">
        <tr>
            <th width="30%">Date</th><td width="20%">'.$sqldate.'</td>
            <th width="30%">Boxing Batch</th><td width="20%">'.$sqlx['boxbatch'].'</td>
        </tr>
        <tr>
            <th width="30%">Batch</th><td width="20%">'.$sqlx['batch'].'</td>
            <th width="30%">Total Boxes</th><td width="20%">'.$sqlx['totalb'].'</td>
        </tr>
        <tr>
            <th width="30%">Units in Each Box</th><td width="20%">'.$sqlx['eachbox'].'</td>
            <th width="30%">Total Units</th><td width="20%">'.$sqlx['totalsachet'].'</td>
        </tr>
    </table>';
    $pdf->writeHTML($basic, true, false, true, false, '');

    // Products list
    $html = '<table border="1" cellpadding="3" width="100%">
        <tr style="font-weight:bold;text-align:center;font-size:11px;background-color:#e6e6e6;">
            <th width="10%">#</th>
            <th width="35%">Product Name</th>
            <th width="35%">Production Batchcode</th>
            <th width="20%">Quantity Used</th>
        </tr>';

    $r = 0;
    $grnx = mysqli_query($con, "SELECT * FROM `zendboxing1` WHERE vid='".$sqlx['id']."'");
    while ($row = mysqli_fetch_array($grnx)) {
        $r++;
        $html .= '<tr style="text-align:center;font-size:small">
            <td>'.$r.'</td>
            <td>'.$row['prodname'].'</td>
            <td>'.$row['production'].'</td>
            <td>'.$row['qty'].'</td>
        </tr>';
    }
    $html .= '</table>';
    $pdf->writeHTML($html, true, false, true, false, '');
}

$pdfname = "BoxingRecord_".$vdate.".pdf";
$pdf->Output($_SERVER['DOCUMENT_ROOT']."/zendboxg/pdf/".$pdfname, "F");
?>

<a href="admin.php?id=zendbox1&vdate=<?php echo $vdate; ?>">
    <button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button>
</a>
<br>
<iframe src="zendboxg/pdf/<?= $pdfname ?>" frameborder="0" width="100%" height="600px"></iframe>
