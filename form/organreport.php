<?php
include 'connection.php';
require_once('tcpdf/tcpdf.php');

$from = $_GET['from'];
$to = $_GET['to'];

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
        if (file_exists($this->logo1Path)) {
            $this->Image($this->logo1Path, 15, 7, 16, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }

        // Add logo 2 (right)
        if (file_exists($this->logo2Path)) {
            $this->Image($this->logo2Path, 260, 7, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }

        // Main title
        $this->SetFont('courier', 'B', 17);
        $this->SetTextColor(0, 51, 102);
        $this->SetXY(12, 12);
        $this->Cell(0, 0, 'WEEKLY PRODUCTION ORGANOLEPTIC ASSESSMENT RECORD', 0, 1, 'C');

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

        // Custom footer HTML if set
        if (!empty($this->footerHTML)) {
            $this->SetY(-21);
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

// Create new PDF document using custom MYPDF class
$pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator('Your Company');
$pdf->SetAuthor('Weekly production organoleptic');
$pdf->SetTitle('Weekly production organoleptic');
$pdf->SetSubject('Weekly production organoleptic');
$pdf->SetKeywords('Weekly production organoleptic');

// Set default monospaced font
$pdf->SetDefaultMonospacedFont('courier');

// Set margins
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

// Add a page
$pdf->AddPage();
$pdf->SetY(40);


// Table header - EXACT same structure as your working web view
$html = '<table border="1" cellpadding="4" cellspacing="0" style="font-size:8px;">
    <thead>
        <tr>
            <th width="5%"  style="text-align:center; ">S No.</th>
            <th width="10%" style="text-align:center; ">Date</th>
            <th width="15%" style="text-align:center; ">Product Name/Batch Details</th>
            <th width="10%" style="text-align:center; ">Conducted By</th>
            <th width="15%">Appearance</th>
            <th width="15%">Aroma</th>
            <th width="15%">Texture</th>
            <th width="15%">Flavor</th>
        </tr>
     
    </thead>
    <tbody>';

$sq1 = mysqli_query($con, "SELECT * FROM tblorgan WHERE date BETWEEN '$from' AND '$to' ORDER BY date DESC");
$i = 1;
$total_records = 0;

while ($row1 = mysqli_fetch_assoc($sq1)) {
    $total_records++;

    // Color coding
    if ($row1['appearance'] == 3) {
        $bg = 'green';
    } else if ($row1['appearance'] == 2) {
        $bg = 'orange';
    } else {
        $bg = 'red';
    }

    if ($row1['aroma'] == 3) {
        $bg1 = 'green';
    } else if ($row1['aroma'] == 2) {
        $bg1 = 'orange';
    } else {
        $bg1 = 'red';
    }

    if ($row1['texture'] == 3) {
        $bg2 = 'green';
    } else if ($row1['texture'] == 2) {
        $bg2 = 'orange';
    } else {
        $bg2 = 'red';
    }

    if ($row1['flavour'] == 3) {
        $bg3 = 'green';
    } else if ($row1['flavour'] == 2) {
        $bg3 = 'orange';
    } else {
        $bg3 = 'red';
    }

    // First Row - Scores (EXACT match to your working code)
    $html .= '<tr>';
    $html .= '<td  width="5%" rowspan="2" style=" text-align:center;">' . $i++ . '</td>';
    $html .= '<td  width="10%" rowspan="2" style=" text-align:center;">' . date('d-m-Y', strtotime($row1['date'])) . '</td>';
    $html .= '<td  width="15%" rowspan="2" style=""><b>Product Name:</b> ' . htmlspecialchars($row1['product']) . '<br><b>Batch Code:</b> ' . htmlspecialchars($row1['details']) . '</td>';
    $html .= '<td  width="10%" rowspan="2" style=" text-align:center;">' . htmlspecialchars($row1['conducted']) . '</td>';

    // Appearance Score
    $html .= '<td  width="15%" style="background-color:' . $bg . '; color:white; font-weight:bold; text-align:center;">' . $row1['appearance'] . '</td>';
    // Empty placeholder

    // Aroma Score
    $html .= '<td  width="15%" style="background-color:' . $bg1 . '; color:white; font-weight:bold; text-align:center;">' . $row1['aroma'] . '</td>';


    // Texture Score
    $html .= '<td  width="15%" style="background-color:' . $bg2 . '; color:white; font-weight:bold; text-align:center;">' . $row1['texture'] . '</td>';

    // Flavor Score
    $html .= '<td  width="15%" style="background-color:' . $bg3 . '; color:white; font-weight:bold; text-align:center;">' . $row1['flavour'] . '</td>';


    $html .= '</tr>';

    // Second Row - Corrective Actions (EXACT match to your working code)
    $html .= '<tr style="background-color:#f9f9f9;">';

    // Appearance Corrective Action
    if (!empty($row1['appearance1'])) {


        $html .= '<td style="text-align:left;"><b>Corrective:</b> ' . $row1['appearance1'] . '</td>';
    } else {
        $html .= '<td></td>';
    }
    // Aroma Corrective Action
    if (!empty($row1['aroma1'])) {
        $html .= '<td style="text-align:left;"><b>Corrective:</b> ' . $row1['aroma1'] . '</td>';
    } else {
        $html .= '<td></td>';
    }

    // Texture Corrective Action
    if (!empty($row1['texture1'])) {
        $html .= '<td style="text-align:left;"><b>Corrective:</b> ' . $row1['texture1'] . '</td>';
    } else {
        $html .= '<td></td>';
    }
    // Flavor Corrective Action
    if (!empty($row1['flavour1'])) {
        $html .= '<td style="text-align:left;"><b>Corrective:</b> ' . $row1['flavour1'] . '</td>';
    } else {
        $html .= '<td></td>';
    }

    $html .= '</tr>';
}

if ($total_records == 0) {
    $html .= '<tr><td colspan="20" style="text-align:center; padding:20px;">No records found for the selected date range.</td></tr>';
}

$html .= '</tbody>
</table>';

// Add record count
$html .= '<table width="100%" cellpadding="4" style="margin-top:10px;">
    <tr>
        <td style="text-align:left;">Total Records: <strong>' . $total_records . '</strong></td>
        <td style="text-align:right;">Generated on: ' . date('d-m-Y H:i:s') . '</td>
    </tr>
</table>';

$pdf->writeHTML($html, true, false, true, false, '');

// Output PDF
$filename = "Weekly_Organoleptic_Report_" . date('Y-m-d') . ".pdf";
$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "finemed/upl1/" . $filename, "F");
?>

<iframe src="upl1/<?php echo $filename; ?>" frameborder="0" width="100%;" height="600px"></iframe>