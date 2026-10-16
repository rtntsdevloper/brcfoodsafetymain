<?php
include 'connection.php';
$selectedDate = $_GET['date'] ?? '';
$formattedDate = date("d/m/Y", strtotime($selectedDate));
require_once('tcpdf/tcpdf.php');
$tid = $_GET['tid'];

// Get current date
$currentDate = date("d/m/Y");

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
        $this->Cell(0, 0, 'Sauce Cooking Temperature Log (CCP1)', 0, 1, 'C');

        // Header line
        $this->SetLineWidth(0.5);
        $this->SetDrawColor(0, 102, 204);
        $this->Line(15, 28, 280, 28);
    }

    public function Footer()
    {
        $this->SetY(-28);
        $this->SetFont('courier', '', 10);
        $this->SetTextColor(0, 0, 0);

        // Footer line
        $this->SetLineWidth(0.2);
        $this->SetDrawColor(204, 204, 204);
        $this->Line(15, $this->GetY(), 280, $this->GetY());

        // Custom footer HTML if set
        if (!empty($this->footerHTML)) {
            $this->SetY(-25);
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
$pdf->SetTitle('Sauce Record');
$pdf->SetSubject('Sace Record');
$pdf->SetKeywords('Sace Record, Sace Record');

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
        <td width="33%" style="text-align:center;">Issue date: 17/04/2025</td>
        <td  width="33%" rowspan="2" style="text-align:center;">DOC Ref: REC 6.1.003</td>
        <td width="33%" style="text-align:center;">Prepared by: Bijal Chauhan</td> 
    </tr>
    <tr>
        <td width="33%" style="text-align:center;">Version: 01</td>
       
        <td width="33%" style="text-align:center;">Authorised by: Paramvir S. Deol</td>
    </tr>

    <tr>
    <td width="99%">Reason for change: New document</td>
    </tr>
</table>
EOD;
$pdf->setFooterHTML($footerContent);

// Add a page
$pdf->AddPage();
$pdf->SetY(40);

// // Add date and name at the top
// $pdf->SetFont('helvetica', '', 12);
// $pdf->Cell(0, 0, 'Date: ' . $currentDate, 0, 0, 'L');
// $pdf->Cell(0, 0, 'Name: ', 0, 0, 'R');
// $pdf->Ln(10); // Add some space after the date and name

$sql1 = mysqli_query($con, "SELECT * FROM tblsauce WHERE date='$selectedDate' and pid ='$tid'");

// Start HTML table
$html = '<table border="1" cellpadding="5" style="text-align:center; width:100%;">';

$html .= '<tr>
    <td colspan="7" style="color:rgba(0, 51, 102); font-weight:bold; text-align:center; font-size:14px;">
    Sauce Cooking Temperature Record
    </td>
    
</tr>';

$html .= '<tr style="font-weight:bold;">
   <th width="6%">Date</th>
   <th width="8%">Product</th>
   <th width="8%">Batch Code</th>
   <th width = "10%"> Cooking Time Start</th>
   <th width= "12%">Actual Start time of CCP</th>
   <th width width= "15%">Actual Temperature of CCP at start time</th>
    <th width = "15%">Actual End time of CCP</th>
    <th width="14%">Actual Temperature of CCP at End time</th>
    <th width="5%">Sign</th>
    <th width="7%">Verify</th>

</tr>';

while($row = mysqli_fetch_assoc($sql1)) {
    $html .= '<tr>
        <td>'. $row['date'] .'</td>
        <td>'. $row['product'] .'</td>
        <td>'. $row['batchcode'] .'</td>
        <td>'. $row['cooking'] .'</td>
        <td>'. $row['sccp'] .'</td>
        <td>'. $row['tccp'] .'</td>
        <td>'. $row['eccp'] .'</td>
        <td>' . $row['etccp'] . '</td>
        <td> <img src="precord/sign/'.$row['sign'].'.png" width="120" height="40"></td>';

        if (!empty($row['verify'])) {
        $html .= '<td><img src="precord/sign/'.$row['verify'].'.png" width="120" height="40"></td>';
    } else {
        $html .= '<td style="color:red;">Not Verified</td>';
    }
    
    $html .= '</tr>';

}

$html .= '</table>';

// Write HTML to PDF
$pdf->writeHTML($html, true, false, true, false, '');

$html2 = '<table border="1" cellpadding="10" width="100%">
    <tr>
        
        <td width="100%" color="red">Core temp must be 90°C for 10 minutes or above or the equivalent to. The temperature must be monitored for 10 minutes.</td>
    </tr>
</table>';

// Write second page HTML to PDF
$pdf->writeHTML($html2, true, false, true, false, '');

$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "/brcfoodsafety/upl1/sauce_record_".$selectedDate.$tid.".pdf", "F");
?>
<iframe src="upl1/sauce_record_<?php echo $selectedDate.$tid;?>.pdf" frameborder="0" width="100%" height="600px"></iframe>



