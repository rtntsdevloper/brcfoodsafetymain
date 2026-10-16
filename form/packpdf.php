<?php
$vdate=$_GET["vdate"];
// $startdate = $_GET['startdate'];
// $enddate = $_GET['enddate'];

require_once('tcpdf/tcpdf.php');

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
        $this->Image($this->logo1Path, 15, 7, 23, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        // Add logo 2 (right)
        file_exists($this->logo2Path);
        $this->Image($this->logo2Path, 260, 7, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        // Main title
        $this->SetFont('courier', 'B', 16);
        $this->SetTextColor(0, 51, 102);
        $this->SetXY(12, 12);
        $this->Cell(0, 0, 'Coding Record', 0, 1, 'C');

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

        // Custom footer HTML if set
        if (!empty($this->footerHTML)) {
            $this->SetY(-15);
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
$pdf->SetCreator('GK');
$pdf->SetAuthor('PSD');
$pdf->SetTitle('PACKAGE CODING');
$pdf->SetSubject('PACKAGE CODING Record');
$pdf->SetKeywords('Wastage Record, report');

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(15, 30, 15, 15);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(20);
$pdf->SetAutoPageBreak(TRUE, 25);

$footerContent = <<<EOD
<table border="1" cellpadding="4" width="102%" >
    <tr>
        <td width="34%" style="text-align:center;">Issue to: 03/03/2026</td>
        <td width="33%" rowspan="2" style="text-align:center;">REC 6.1.002</td>
        <td width="33%" style="text-align:center;">Author: Usama Mustafa</td>
    </tr>
    <tr>
        <td width="34%" style="text-align:center;">Version : 01</td>
        <td width="33%" style="text-align:center;">Authorised by: Paramvir S. Deol</td>
    </tr>
</table>
EOD;

$pdf->setFooterHTML($footerContent);
// Add a page
$pdf->AddPage();

// Start building HTML table
$pdf->SetY(40);

$sql = mysqli_query($con, "SELECT * FROM `zendpackaging` WHERE sdate='$vdate' ");

$html = '<b>Date : '.date('d-m-Y',strtotime($vdate)).'</b>
<br><br></sdsbr><table border="1" cellpadding="4" width="100%">
    <tr style="font-weight:bold; color:black;text-align:center; font-size:small;background-color: #e6e6e6;">
        <th scope="col" width="5%">S No.</th>
        <th scope="col" width="15%">Packaging Batch</th>
        <th scope="col" width="10%">Date</th>
        <th scope="col" width="10%">SKU Batchcode</th>
        <th scope="col" width="10%">BBD</th>
        <th scope="col" width="20%">GRN (Batchcode)</th>
         <th scope="col" width="10%">Number of packaging coded</th>
        <th scope="col" width="10%">Is labelling correct as per packaging</th>
        <th scope="col" width="10%">Corrective Action(if applicable)</th>
    </tr>';
$r = 0;

while ($row = mysqli_fetch_array($sql)) {
    $grnid = $row['grnid']; // Contains comma-separated GRN IDs like "101,105,108"
    $batchcode = $row['batchcode']; // Contains comma-separated batch codes

    // Split comma-separated values into arrays
    $grn_ids = explode(',', $grnid);
    $batch_codes = explode(',', $batchcode);

    // Get all GRN details
    $grn_details = [];
    foreach ($grn_ids as $index => $gid) {
        $gid = trim($gid);
        if (!empty($gid)) {
            $grn_query = mysqli_query($con, "SELECT * FROM tblgrn1 WHERE id = '$gid'");
            $grn_data = mysqli_fetch_array($grn_query);
            if ($grn_data) {
                $batch_code_display = isset($batch_codes[$index]) ? trim($batch_codes[$index]) : $grn_data['batchcode'];
                // Add bullet point before each GRN for better readability
                $grn_details[] = '• ' . $grn_data['grn'].'('.$grn_data['batchcode'].')' ;
                // . ' (' .$grn_data['pno']. ')'
            }
        }
    }

    // Join all GRN details with line break
    $grn_display = implode('<br>', $grn_details);

    // Handle BBD date formatting
    $bbdate = !empty($row['bbdate']) && $row['bbdate'] != '0000-00-00' ? date('d-m-Y', strtotime($row['bbdate'])) : '';

    $r++;
    $html .= '<tr nobr="true" style="text-align:center; font-size:small">
        <td>' . $r . '</td>
        <td>' . $row['pbatch'] . '</td>
        <td>' . date('d-m-Y', strtotime($row['sdate'])) . '</td>
        <td>' . $row['batchcode'] . '</td>
        <td>' . $bbdate . '</td>
        <td style="text-align:left;">' . $grn_display . '</td>
         <td style="text-align:left;">' . $row['numpack'] . '</td>
        <td>' . $row['label'] . '</td>
        <td>' . ($row['action']) . '</td>
    </tr>';
}
 

// Close table
$html .= '</table>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdfname = "Pack_" . $startdate . "_" . $enddate . ".pdf";

$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "zendboxg/pdf/" . $pdfname, "F");

?>
<a href="admin.php?id=zenpack&vdate=<?php echo $vdate; ?>"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
<br>
<iframe src="zendboxg/pdf/<?= $pdfname ?>" frameborder="0" width="100%" height="600px"></iframe>