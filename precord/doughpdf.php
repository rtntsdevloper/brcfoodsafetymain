<?php
include 'connection.php';
require_once('tcpdf/tcpdf.php');
$cdate = $_GET['date'];

class MYPDF extends TCPDF {
    private $logo1Path = 'images/1.png';
    private $logo2Path = 'images/rtnts.png';
    private $footerHTML = '';

    public function Header() {
        $this->SetFillColor(255, 255, 255);
        $this->Rect(0, 0, $this->getPageWidth(), 30, 'F');

        if (file_exists($this->logo1Path)) {
            $this->Image($this->logo1Path, 15, 7, 20, '', 'PNG');
        }
        if (file_exists($this->logo2Path)) {
            $this->Image($this->logo2Path, 255, 7, 25, '', 'PNG');
        }

        $this->SetFont('courier', 'B', 20);
        $this->SetTextColor(0, 51, 102);
        $this->SetXY(12, 12);
        $this->Cell(0, 0, 'DAILY DOUGH WEIGHT CHECK', 0, 1, 'C');

        $this->SetLineWidth(0.5);
        $this->SetDrawColor(0, 102, 204);
        $this->Line(15, 28, 280, 28);
    }

    public function Footer() {
        $this->SetY(-29);
        $this->SetFont('courier', '', 10);
        $this->SetTextColor(0, 0, 0);

        $this->SetLineWidth(0.2);
        $this->SetDrawColor(204, 204, 204);
        $this->Line(15, $this->GetY(), 280, $this->GetY());

        if (!empty($this->footerHTML)) {
            $this->SetY(-26);
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
$pdf->SetCreator('Your Company');
$pdf->SetAuthor('Record');
$pdf->SetTitle('Dough Weight');
$pdf->SetSubject('Dough Weight Check');
$pdf->SetKeywords('Dough, Weight');
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(15, 30, 15);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(20);
$pdf->SetAutoPageBreak(TRUE, 25);

$footerContent = '<table border="1" cellpadding="5">'
    . '<tr>'
    . '<td>Date Issued: 29/09/2016</td>'
    . '<td style="text-align:center;">Doc Ref: REC-6.1-009</td>'
    . '<td>Author: Mahesh Prajapati</td>'
    . '</tr>'
    . '<tr>'
    . '<td>Version No: 2</td>'
    . '<td style="text-align:center;">Page 1 of 1</td>'
    . '<td>Authorised By: Paramvir S. Deol </td>'
    . '</tr>'
    . '</table>';
$pdf->setFooterHTML($footerContent);
/// Query main dough records
$query = mysqli_query($con, "SELECT * FROM `tbldough` WHERE date ='$cdate' ORDER BY id DESC");

while ($row = mysqli_fetch_assoc($query)) {
    // Get product name
    $sd2 = mysqli_query($con, "SELECT * FROM tblmarination WHERE batchcode='$row[product]'");
    $sd3 = mysqli_fetch_array($sd2);

    $sd = mysqli_query($con, "SELECT * FROM tblrecipe WHERE id='$sd3[name]'");
    $sd1 = mysqli_fetch_array($sd);

    // New page per tbldough record
    $pdf->AddPage();
    $pdf->SetY(40);
    $pdf->SetFont('helvetica', 'B', 14);

    // Heading
    $pdf->Cell(0, 10, 'Date: ' . date('d/m/Y', strtotime($row['date'])), 0, 1, 'L');
    $pdf->Cell(0, 10, 'Product Name: ' . $sd1['name'], 0, 1, 'L');
    $pdf->Cell(0, 10, 'Batch Code: ' . $row['product'], 0, 1, 'L');
    $pdf->Ln(5);

    $html = '<table border="1" cellpadding="5" style="text-align:center; width:100%;">';
    $html .= '<tr style="font-weight:bold;">
        <th width="10%">S.No.</th>
        <th width="22%">Time</th>
        <th width="22%">Weight</th>
        <th width="22%">Add By</th>
        <th width="24%">Sign</th>
    </tr>';

    $sno = 1;

    $html .= '<tr>';
    $html .= '<td>' . $sno++ . '</td>';
    $html .= '<td>' . $row['time'] . '</td>';
    $html .= '<td>' . $row['dough'] . '</td>';
    $html .= '<td>' . $row['addby'] . '</td>';
    $html .= '<td><img src="precord/sign/' . $row['sign'] . '.png" width="120" height="30"></td>';
    $html .= '</tr>';

    $sq = mysqli_query($con, "SELECT * FROM `dough1` WHERE sid = $row[id]");
    while ($data = mysqli_fetch_assoc($sq)) {
        $html .= '<tr>';
        $html .= '<td>' . $sno++ . '</td>';
        $html .= '<td>' . $data['stime'] . '</td>';
        $html .= '<td>' . $data['dough'] . '</td>';
        $html .= '<td>' . $data['addby'] . '</td>';
        $html .= '<td><img src="precord/sign/' . $data['sign'] . '.png" width="120" height="30"></td>';
        $html .= '</tr>';
    }

    $html .= '</table>';

    $pdf->writeHTML($html, true, false, true, false, '');
}


$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "finemed/upl1/Dough_weight_.pdf", "F");
?>
<iframe src="upl1/Dough_weight_.pdf" frameborder="0" width="100%" height="600px"></iframe>
