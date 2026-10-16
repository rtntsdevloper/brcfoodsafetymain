<?php
include 'connection.php';
require_once('tcpdf/tcpdf.php');

$from = $_GET['from'];
$to = $_GET['to'];
$month = $_GET['month']; // Get month parameter

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
        $this->Image($this->logo1Path, 15, 7, 19, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        // Add logo 2 (right)
        file_exists($this->logo2Path);
        $this->Image($this->logo2Path, 260, 7, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);


        // Main title
        $this->SetFont('courier', 'B', 17);
        $this->SetTextColor(0, 51, 102);
        $this->SetXY(12, 12);
        $this->Cell(0, 0, 'Millers Magnet Cleaning Record', 0, 1, 'C');

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
        // $this->Line(15, $this->GetY(), 285, $this->GetY());

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
$pdf->SetAuthor('Magnet Record');
$pdf->SetTitle('Magnet Record');
$pdf->SetSubject('Magnet Record');
$pdf->SetKeywords('Magnet ,Record');

// Set default monospaced font
$pdf->SetDefaultMonospacedFont('courier');

$footerHTML = <<<EOD
<table border="1" cellpadding="4" width="100%" style="font-weight:bold;">
    <tr>
     <td width="33%" style="text-align:center;">Revision No: 15</td>
        <td width="33%" style="text-align:center;">ISSUE DATE - 04-08-2025</td>
        <td width="33%" rowspan="2" style="text-align:center;">AUTHORISED BY - JORDAN MILLS</td>
       
    </tr>
   
</table>
EOD;
 
// ✅ Use the setter method you defined
$pdf->setFooterHTML($footerHTML);

// Set margins
$pdf->SetMargins(15, 30, 15);
$pdf->SetHeaderMargin(10);

$pdf->SetAutoPageBreak(TRUE, 25);


// Add a page
$pdf->AddPage();
$pdf->SetY(40);

// $pdf->Output('', '');
$html1 = '<table border="1" cellpadding="4" style="font-size:9px;">
   <tr style="text-align:center; font-weight:bold;">
   <th width="5%">S No.</th>
   <th width="10%">Date</th>     
   <th width="20%">Magnet Name</th>
   <th width="10%">Frequency</th>
        <th width="10%">Any Findings</th>
        <th width="10%">Reported To</th>
        <th width="10%">Carried out by</th>
        <th width="25%">Corrective Actions</th>
      
   </tr>';

// Add month filter to SQL query
$sq1 = mysqli_query($con, "SELECT * FROM tblmagnate where date BETWEEN '$from' AND '$to' AND MONTH(date) = '$month'");

// initialize sum
$i = 1;
while ($row1 = mysqli_fetch_assoc($sq1)) {
    if ($row1['magnet'] == 'Intake Pit Magnet') {
        $frequency = 'Daily';
    } else {
        $frequency = 'Once in Week';
    }
    $html1 .= '<tr style="text-align:center; font-size:9px;">
    <td>' . $i++ . '</td>
    <td>' . date('d-m-Y', strtotime($row1['date'])) . '</td>
       
        <td>' . $row1['magnet'] . '</td>
        <td>' . $frequency . '</td>
        <td>' . $row1['findings'] . '</td>
        <td>' . $row1['report'] . '</td>
        <td>' . $row1['carried'] . '</td>
        <td>' . $row1['corrective'] . '</td>
       
    </tr>';
}
$html1 .= '</table>';

$pdf->writeHTML($html1, true, false, true, false, '');

$sq3 = mysqli_query($con, "SELECT * FROM tblmagnate where date BETWEEN '$from' AND '$to'");
$row5 = mysqli_fetch_assoc($sq3);

$html2 = '';
$html2 .= '<table>
<tr>
<th width="90%"></th>
<th width="10%"><img src="mill/sign/' . $row5['verify'] . '.png" height="40px" width="60px" /></th>
</tr>

<tr>
<th width="90%"></th>
<th width="10%">Signature</th>
</tr>
</table>';
$pdf->writeHTML($html2, true, false, true, false, '');

// Generate filename with month
$filename = 'Magnet_Cleaning' . date('F_Y', mktime(0, 0, 0, $month, 1)) . '_' . date('d-m-Y', strtotime($from)) . '_to_' . date('d-m-Y', strtotime($to)) . '.pdf';


$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "/brc/upl1/" . $filename, "F");
?>

<iframe src="upl1/<?php echo $filename; ?>" frameborder="0" width="100%;" height="600px"></iframe>

<?php
$vid = $_GET['vid'];
if ($vid == 2) {

    echo '<a href="mill/masign.php?from='.$from.'&to='.$to.'&vid=1"><button class="btn btn-warning w-100">Not Verified</button></a>';
}
?>