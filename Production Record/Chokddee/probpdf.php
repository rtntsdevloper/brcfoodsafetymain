<?php
include 'connection.php';
require_once('tcpdf/tcpdf.php');
$date = $_GET['date'];

// Get current date
$currentDate = date("d/m/Y", strtotime($date));
$tid = $_GET['tid'];

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
        $this->Cell(0, 0, 'Weekly Probe Calibration', 0, 1, 'C');

        // Header line
        $this->SetLineWidth(0.5);
        $this->SetDrawColor(0, 102, 204);
        $this->Line(15, 28, 280, 28);
    }

    public function Footer()
    {
        $this->SetY(-22);
        $this->SetFont('courier', '', 10);
        $this->SetTextColor(0, 0, 0);

        // Footer line
        $this->SetLineWidth(0.2);
        $this->SetDrawColor(204, 204, 204);
        $this->Line(15, $this->GetY(), 280, $this->GetY());

        // Custom footer HTML if set
        if (!empty($this->footerHTML)) {
            $this->SetY(-18);
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
$pdf->SetTitle('Probe Calibration');
$pdf->SetSubject('Probe Calibration');
$pdf->SetKeywords('Probe, calibration');

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(15, 30, 15);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(20);
$pdf->SetAutoPageBreak(TRUE, 30);

$footerContent = <<<EOD
<table border="1" cellpadding="5">
    <tr>
        <td width="33%" style="text-align:center;">  REC 6.4.002 </td>
        <td  width="33%" style="text-align:center;">Issues number: 01</td>
        <td width="33%" style="text-align:center;">Created by: Bijal Chauhan</td>
    </tr>
    <tr>
        <td width="33%" style="text-align:center;">Reason for change: New document</td>
        <td width="33%" style="text-align:center;">Issue date: 13/06/2025</td>
        <td width="33%" style="text-align:center;">Authorised by: Paramvir S. Deol</td>
    </tr>
</table>
EOD;
$pdf->setFooterHTML($footerContent);

// Add a page
$pdf->AddPage();
$pdf->SetY(40);
$msql1 = mysqli_query($con, "SELECT distinct name FROM tblprob where date ='$date'and pid= '$tid'");
$msql2 = mysqli_fetch_array($msql1);
// Add date and name at the top
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(0, 0, 'Date: ' . $currentDate, 0, 0, 'L');
$pdf->Cell(0, 0, 'Name: '.$msql2['name'], 0, 0, 'R');
$pdf->Ln(10); // Add some space after the date and name

$sql1 = mysqli_query($con, "SELECT * FROM tblprob where date ='$date'and pid= '$tid'");

// Start HTML table
$html = '<table border="1" cellpadding="5" style="text-align:center; width:100%;">';

$html .= '<tr>
    <td colspan="7" style="color:rgba(0, 51, 102); font-weight:bold; text-align:center; font-size:14px;">
        Probe Calibration
    </td>
</tr>';

$html .= '<tr style="font-weight:bold;">
    <th rowspan="2" width="15%"><br><br><br><br>Thermometer Identification</th>
    <th rowspan="2" width="13%"><br><br><br><br>Thermometer Serial No.</th>
    <th rowspan="2" width="13%"><br><br><br><br>Area</th>
    <th colspan="2" width="25%">Thermometer Check ◦C (Hot Water)<br>Between 100ºC ± 1.0ºC</th>
    <th colspan="2" width="25%">Thermometer Check ◦C (Chill Water)<br>Between -5ºC-0ºC</th>
    <th width="9%" rowspan="2"><br><br><br>Checked by</th>
</tr >
<tr style="font-weight:bold;">
    <th width="12.5%">Reference Thermometer Temperature</th>
    <th width="12.5%">Area Prob Temperature</th>
    <th width="12.5%">Reference Thermometer Temperature</th>
    <th width="12.5%">Area Prob Temperature</th>
</tr>';

while ($row = mysqli_fetch_assoc($sql1)) {
    $html .= '<tr>
        <td>' . $row['tident'] . '</td>
        <td>' . $row['tserial'] . '</td>
        <td>' . $row['area'] . '</td>
        <td>' . $row['th1'] . '</td>
        <td>' . $row['th2'] . '</td>
        <td>' . $row['ch1'] . '</td>
        <td>' . $row['ch2'] . '</td>
        <td>' . $row['checked'] . '</td>
    </tr>';
}

$html .= '</table>';

// Write HTML to PDF
$pdf->writeHTML($html, true, false, true, false, '');
$html21 = "";
$html21 .= '<table border="1" cellpadding="10" width="100%">
    <tr>
        <td width="20%" style="font-weight:bold; color:red;">Corrective Actions:</td>
        <td width="80%">';
foreach ($sql1 as $sqldata) {

    if (!empty($sqldata['correct'])) {
        $html21 .= "<p><b>".$sqldata['tserial']." : </b>".$sqldata['correct']."</p>";
    }
}


$html21 .= '
        </td>
    </tr>
</table>';

// Write second page HTML to PDF
$pdf->writeHTML($html21, true, false, true, false, '');

$html2 = '<table border="1" cellpadding="10" width="100%">
    <tr>
        <td width="20%" style="font-weight:bold; color:red;">Corrective Actions:</td>
        <td width="80%"> If there is a greater difference between the unit and the reference thermometer than the acceptable tolerance, the thermometer must be removed and replaced with one that is working correctly (within tolerance).</td>
    </tr>
</table>';

// Write second page HTML to PDF
$pdf->writeHTML($html2, true, false, true, false, '');

$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "/brcfoodsafety/upl1/probe_record_".$date.$tid.".pdf", "F");
?>
<iframe src="upl1/probe_record_<?php echo $date.$tid;?>.pdf" frameborder="0" width="100%" height="600px"></iframe>