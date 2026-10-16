<?php
include 'connection.php';
require_once('tcpdf/tcpdf.php');
$date = $_GET['pid'];
// Get current date


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
        file_exists($this->logo1Path);
        $this->Image($this->logo1Path, 15, 7, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        // Add logo 2 (right)
        file_exists($this->logo2Path);
        $this->Image($this->logo2Path, 255, 7, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        // Main title
        $this->SetFont('courier', 'B', 22);
        $this->SetTextColor(0, 51, 102);
        $this->SetXY(12, 12);
        $this->Cell(0, 0, 'PACKAGING AND LABEL CHECK SHEET', 0, 1, 'C');

        // Header line
        $this->SetLineWidth(0.5);
        $this->SetDrawColor(0, 102, 204);
        $this->Line(15, 28, 280, 28);
    }

    public function Footer()
    {
        $this->SetY(-29);
        $this->SetFont('courier', '', 10);
        $this->SetTextColor(0, 0, 0);

        // Footer line
        $this->SetLineWidth(0.2);
        $this->SetDrawColor(204, 204, 204);
        $this->Line(15, $this->GetY(), 280, $this->GetY());

        // Custom footer HTML if set
        if (!empty($this->footerHTML)) {
            $this->SetY(-26);
            $this->writeHTML($this->footerHTML, true, false, true, false, '');
        } else {
            // Default footer text
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
$pdf->SetCreator('RTNTS');
$pdf->SetAuthor('Record');
$pdf->SetTitle('Packaging and Label Check Sheet');
$pdf->SetSubject('Packaging and Label Check Sheet');
$pdf->SetKeywords('Probe, calibration');

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(15, 30, 15);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(20);
$pdf->SetAutoPageBreak(TRUE, 25);

$footerContent = <<<EOD
<table border="1" cellpadding="5">
<tr>
<td>REC 3.7.3a Packaging and Label Check Sheet</td>
<td>Issue Number: 01</td>
<td>Created by: Usama</td>
</tr>
<tr>
<td>Reason for change: New Document</td>
<td>Issue date: 01/07/2024</td>
<td>Authorised by: Paramvir S. Deol</td>
</tr>
  
</table>
EOD;
$pdf->setFooterHTML($footerContent);

// Add a page
$pdf->AddPage();
$pdf->SetY(40);

// Add date and name at the top
$pdf->SetFont('helvetica', '', 12);


$pdf->Ln(10); // Add some space after the date and name

$pd = mysqli_query($con, "SELECT * FROM tbllabel where id='$date'");
$pd2 = mysqli_fetch_array($pd);
if (!empty($pd2['prodend'])) {
    $prend = $pd2['prodend'] . "Kg";
}
if (!empty($pd2['packend'])) {
    $pckend = $pd2['packend'] . "Kg";
}


$html1 = '<table border="1" cellpadding="5" style="text-align:center; width:100%; font-size:small;">';
$html1 .= '<tr><td colspan="8" style="color:rgba(0, 51, 102); font-weight:bold; text-align:center; font-size:14px;">Product and Packaging Record</td></tr>';
$html1 .= '<tr >
    <th width="15%"  style="font-weight:bold;">Packaging Batch</th>
    <td width="20%">' . $pd2['recordid'] . '</td>
    <th width="18%"  style="font-weight:bold;">Product Used Batch</th>
    <td width="15%">' . $pd2['prodbatch'] . '</td>
    <th width="20%" style="font-weight:bold;">Product Start Quantity</th>
    <td width="12%">' . $pd2['prdweight'] . 'Kg</td>
   
</tr><tr >
    <th width="15%" style="font-weight:bold;">Product End Quantity</th>
    <td width="20%">' . $prend. '</td>
    <th width="18%"  style="font-weight:bold;">Packaging Start Quantity</th>
    <td width="15%">' . $pd2['packweight'] . 'Kg</td>
    <th width="20%" style="font-weight:bold;">Packaging End Quantity</th>
    <td width="12%">' . $pckend . '</td>
   
</tr>';
$html1 .= '</table>';
// Write HTML to PDF
$pdf->writeHTML($html1, true, false, true, false, '');










$query = "SELECT * FROM tbllabel where id='$date'";

$sql1 = mysqli_query($con, $query);

// Start HTML table

$html = '<table border="1" cellpadding="5" style="text-align:center; width:100%; font-size:small;">';
$html .= '<tr><td colspan="8" style="color:rgba(0, 51, 102); font-weight:bold; text-align:center; font-size:14px;">Packaging and Label</td></tr>';
$html .= '<tr style="font-weight:bold;">
    <th width="10%">Date</th>
    <th width="10%">Product Name</th>
    <th width="10%" >Production Date</th>
    <th width="10%">Size of Packaging</th>
    <th width="10%">Batch code of Packaging</th>
    <th width="12%">Is Previous Packaging Removed from the Line?</th>
    <th width="10%">Total Packs Produced</th>
    <th width="10%">Best Before Date</th>
     <th width="9%">Is label checked?</th>
      <th width="9%">OP Sign</th>
</tr>';

while ($row = mysqli_fetch_assoc($sql1)) {
    $html .= '<tr>
       <td>' . date('d-m-y', strtotime($row['date'])) . '</td>
        <td>' . $row['pname'] . '</td>
        <td>' . date('d-m-y', strtotime($row['pdate'])) . '</td>
        <td>' . $row['size'] . 'g</td>
        <td>' . $row['batchcode'] . '</td>
        <td>' . $row['rline'] . '</td>
        <td>' . $row['tproduce'] . '</td>
         <td>' . date('d-m-y', strtotime($row['bbdate'])) . '</td>
        <td>' . $row['label_checked'] . '</td>
        <td><img src="tracemp/sign/' . $row['sign'] . '.png" width="120" height="40"></td>
    </tr>';
}








$html .= '</table>';
// Write HTML to PDF
$pdf->writeHTML($html, true, false, true, false, '');



$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "/brcfoodsafety/upl1/probe_record_.pdf", "F");
?>
<iframe src="upl1/probe_record_.pdf" frameborder="0" width="100%" height="600px"></iframe>