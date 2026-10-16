<?php
include 'connection.php';
require_once('tcpdf/tcpdf.php');
$selectedDate = $_GET['date'] ?? '';
$formattedDate = date("d/m/Y", strtotime($selectedDate));
$pid = $_GET['eid'];
$ac = $_GET['ac'];

$sq = mysqli_query($con, "SELECT * FROM tblweight where id= '$pid'");
$row1 = mysqli_fetch_assoc($sq);
// $dt = date("d-m-Y", strtotime($roww['date']));



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
        $this->Cell(0, 0, 'DAILY WEIGHT CHECK ', 0, 1, 'C');

        // Header line
        $this->SetLineWidth(0.5);
        $this->SetDrawColor(0, 102, 204);
        $this->Line(15, 28, 280, 28);
    }

    public function Footer()
    {
        $this->SetY(-25);
        $this->SetFont('courier', '', 8);
        $this->SetTextColor(0, 0, 0);

        // Footer line
        $this->SetLineWidth(0.2);
        $this->SetDrawColor(204, 204, 204);
        $this->Line(15, $this->GetY(), 280, $this->GetY());

        // Custom footer HTML if set
        if (!empty($this->footerHTML)) {
            $this->SetY(-22);
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
$pdf->SetCreator('Your Company');
$pdf->SetAuthor('Record');
$pdf->SetTitle('Daily Weight Check ');
$pdf->SetSubject('Daily Weight Check ');
$pdf->SetKeywords('Delivery, report');

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
    
        <td width="33%" style="text-align:center;">   Issue date: 17/04/2025  </td>
        <td  width="33%" style="text-align:center;">Doc Ref: REC 6.3.3</td>
        <td width="33%" style="text-align:center;">Author: Bijal Chauhan</td> 
    </tr>
    
    <tr>
        <td width="33%" style="text-align:center;"> Version: 01 </td>
        <td  width="33%" style="text-align:center;">Page Page 1 of 1</td>
        <td width="33%" style="text-align:center;">Authorised by: Paramvir S. Deol</td> 
    </tr>
    <tr>
    <td width="99%">Reason for Change: New form</td>
    </tr>

</table>

EOD;

$pdf->setFooterHTML($footerContent);
// Add a page
$pdf->AddPage();
$pdf->SetY(40);

$sql1 = mysqli_query($con, "SELECT * FROM tblweight1 WHERE eid='$pid'");

$firstRow = mysqli_fetch_assoc($sql1);


mysqli_data_seek($sql1, 0);

$html = '<table border="1" cellpadding="4" width="100%">
    <tr>
        <td>Operator Name: ' . $row1['name'] . '</td>
        <td>Date: ' .date('d-m-Y', strtotime($row1['date']))   . '</td>
        <td>Machine Number: ' . $row1['serial'] . '</td>
    </tr>
     <tr>
        <td>Batchcode: ' . $row1['batch'] . '</td>
        <td>Use By : ' . date('d-m-Y', strtotime($row1['date']))  . '</td>
        
    </tr>
    <tr>
        <td width="757" colspan="10"><div align="center" style="color:rgba(0, 51, 102); font-weight:bold;">Report</div></td>
    </tr>
    <tr>
        <td colspan="10" style="color:red;">
          Average weight must not be less than declared weight. Stop the line if average weight drops below declared weight.
        </td>
    </tr>
    
    <tr style="font-weight:bold; color:black; text-align:center;">
        <th width="10%">Product</th>
        <th width="10%">Time</th>
        <th width="10%">Product tare Weight (g)</th>
        <th width="10%">Pack 1 Weight (g)</th>
        <th width="10%">Pack 2 Weight (g)</th>
        <th width="10%">Pack 3 Weight (g)</th>
        <th width="10%">Pack 4 Weight (g)</th>
        <th width="10%">Pack 5 Weight (g)</th>
        <th width="10%">Declare Weight (g)</th>
        <th width="10%">Signature</th>
    </tr>';

while ($row = mysqli_fetch_assoc($sql1)) {
    $html .= '
    <tr>
        <td>' . $row['product'] . '</td>
        <td>' . $row['time'] . '</td>
        <td>' . $row['packtare'] . '</td>
        <td>' . $row['pack1'] . '</td>
        <td>' . $row['pack2'] . '</td>
        <td>' . $row['pack3'] . '</td>
        <td>' . $row['pack4'] . '</td>
        <td>' . $row['pack5'] . '</td>
        <td>' . $row['declared'] . '</td>
        <td><img src="tracemp/sign/' . $row['sign'] . '.png" width="120" height="40"></td>
    </tr>';
}

$html .= '</table>';

// Write HTML to PDF
$pdf->writeHTML($html, true, false, true, false, '');


$mngsign = '<table  cellpadding="4" width="100%">
<tr>
<td></td>
<td></td>
<td style="text-align:center"><img src="tracemp/sign/' . $row1['mangersign'] . '.png" width="80"></td>
</tr>
<tr>
<td></td>
<td></td>
<td style="text-align:center">Manager Signature</td>
</tr>


</table>';
$pdf->writeHTML($mngsign, true, false, true, false, '');

$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "/brcfoodsafety/upl1/weight_record_" . $pid . ".pdf", "F");
?>
<iframe src="upl1/weight_record_<?php echo $pid; ?>.pdf" frameborder="0" width="100%" height="600px"></iframe>

<?php

if ($ac == '2') {
    echo '<a href="admin.php?id=mweight&date=' . $selectedDate . '&eid=' . $pid . '">
            <button class="btn btn-warning  w-100" >Verify Report</button>';
}

?>