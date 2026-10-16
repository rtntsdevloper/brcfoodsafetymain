<?php
include 'connection.php';
require_once('tcpdf/tcpdf.php');

$dtv = $_GET['dt'];
$ac = $_GET['ac'];
$pid = $_GET['tid'];
$dt = date("d-m-Y", strtotime($dtv));

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

        // Add logo 1 (left) if exists
        if (file_exists($this->logo1Path)) {
            $this->Image($this->logo1Path, 15, 7, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }

        // Add logo 2 (right) if exists
        if (file_exists($this->logo2Path)) {
            $this->Image($this->logo2Path, 255, 7, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }

        // Main title
        $this->SetFont('courier', 'B', 22);
        $this->SetTextColor(0, 51, 102);
        $this->SetXY(12, 12);
        $this->Cell(0, 0, 'Weekly Scale Calibration Record', 0, 1, 'C');

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
$pdf->SetTitle('Scale Calibration Record');
$pdf->SetSubject('Scale Calibration');
$pdf->SetKeywords('Scale, calibration, record');

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(15, 30, 15);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(20);
$pdf->SetAutoPageBreak(TRUE, 25);

$footerContent = <<<EOD
<table  cellpadding="5" border="1" >
    <tr>
        <td width="50%"  >REC 6.4 001 Weekly Scales Calibration Check Record v1</td> 
        <td width="20%" >Version:01</td> 
         <td width="30%" >Created by: Bijal Chauhan</td>
        
    </tr>
     <tr>
        <td width="50%" style=  colspan="2">Reason for change: New Form</td>
        <td width="20%" style= >Issue date: 17/04/25</td> 
        <td width="30%" style= >Authorised by: Paramvir s. Deol</td>
        
    </tr>
</table>
EOD;

$pdf->setFooterHTML($footerContent);

// Add a page
$pdf->AddPage();
$pdf->SetY(40);

// Prepare SQL query (consider using prepared statements)
$sql1 = mysqli_query($con, "SELECT * FROM tblscalee where date ='$dtv' and pid='$pid'");

// First page table
$html = '<table border="1" cellpadding="4" width="100%">';
$html .= '<tr>
    <td style="color:rgba(0, 51, 102); text-align:center;" colspan="10">Scale Record</td>
</tr>
<tr>
    <td colspan="10">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td width="60%" style="vertical-align:top;">
                    Place the standard weights across the defined points as below:<br><br>
                    • 1,2,3,4 are the 4 corners of the scale and 5 is in the center.<br>
                    • Place the readings in the column against the reference weights.<br>
                    • If there is any deviation found, inform the manager.
                </td>
                <td width="40%" style="text-align:center; vertical-align:top;">
                    <img src="precord/scalep.png" width="150">
                </td>
            </tr>
        </table>
    </td>
</tr>

<tr style="font-weight:bold; color:black; text-align:center;">
    <th width="10%" rowspan="2">Date</th>
    <th width="10%" rowspan="2">Scale Serial No.</th>
    <th width="10%" rowspan="2">Area</th>
    <th width="10%" rowspan="2">Calibration Tested by</th>
    <th width="10%" rowspan="2">Ref. Weight</th>
    <th width="50%" colspan="5">Testing Points</th>
    
</tr>
<tr style="font-weight:bold;">
<th>1</th>
<th>2</th>
<th>3</th>
<th>4</th>
<th>5</th>
</tr>';
while ($row = mysqli_fetch_assoc($sql1)) {
    // Explode the comma-separated values into arrays
    $fifty = explode(",", $row['50g']);
    $one = explode(",", $row['100g']);
    $two = explode(",", $row['200g']);

    // Ensure we have exactly 5 values for each (fill with empty string if needed)
    // $fifty = array_pad($fifty, 5, '');
    // $one = array_pad($one, 5, '');
    // $two = array_pad($two, 5, '');

    $html .= '<tr nobr="true">
        <td rowspan="3" width="10%">' . $row['date'] . '</td>
        <td rowspan="3" width="10%">' . $row['scale'] . '</td>
        <td rowspan="3" width="10%">' . $row['area'] . '</td>
        <td rowspan="3" width="10%">' . $row['calibration'] . '</td>
        <td width="10%">50g</td>
        <td width="10%">' . $fifty[0] . 'g</td>
        <td width="10%">' . $fifty[1] . 'g</td>
        <td width="10%">' . $fifty[2] . 'g</td>
        <td width="10%">' . $fifty[3] . 'g</td>
        <td width="10%">' . $fifty[4] . 'g</td>
    </tr>
    <tr>
        <td width="10%">100g</td>
        <td width="10%">' . $one[0] . 'g</td>
        <td width="10%">' . $one[1] . 'g</td>
        <td width="10%">' . $one[2] . 'g</td>
        <td width="10%">' . $one[3] . 'g</td>
        <td width="10%">' . $one[4] . 'g</td>
    </tr>
    <tr>
        <td width="10%">200g</td>
        <td width="10%">' . $two[0] . 'g</td>
        <td width="10%">' . $two[1] . 'g</td>
        <td width="10%">' . $two[2] . 'g</td>
        <td width="10%">' . $two[3] . 'g</td>
        <td width="10%">' . $two[4] . 'g</td>
    </tr>';
}
// Close first table
$html .= '</table>';

// Write first page HTML to PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Add new page

$pdf->Ln(15);
// Second page table
$sql2 = mysqli_query($con, "SELECT * FROM tblscalee where date ='$dtv' and pid='$pid'");
$html2 = '<table border="1" width="100%" cellspacing="0" cellpadding="5">
    <tr>
        <th style="text-align:center; font-weight:bold;"  width="10%">Scale Serial No.</th>
        <th width="90%" style="text-align:center; font-weight:bold;">Comment</th>
    </tr>';

// Loop through each row in the result set
while ($row1 = mysqli_fetch_assoc($sql2)) {
    $html2 .= '<tr border="1">
        <td>' . $row1['scale'] . '</td>
        <td>' . $row1['comment'] . '</td>
    </tr>';
}

$html2 .= '</table>';


// Write second page HTML to PDF
$pdf->writeHTML($html2, true, false, true, false, '');

$html8 = "";
if ($ac == '2') {
    $html8 .= '
<p style="color:red; text-align:center">Not Verified Yet!</p>';
} elseif ($ac == '1') {
    $vrq = mysqli_query($con, "SELECT distinct vdate,sign FROM `tblscalee` WHERE date='$dtv' and status='Verified' and pid ='$pid'");
    $vrq1 = mysqli_fetch_assoc($vrq);
    $vsign = $vrq1['sign'];
    $vdate = $vrq1['vdate'];

    $html8 .= '
    <table border="1" width="100%"   cellpadding="5">
        <tr nobr="true">
            <th style="text-align:center; width:50%;">
                <img src="precord/sign/' . $vsign . '" alt="Signature" width="90" height="30" />
                <br>
                <strong>Verified By</strong>
            </th>
            <th style="text-align:justify; font-weight:bold; width:50%;justify-item:center; ">
            
                <strong> <br> Date :</strong> ' . htmlspecialchars($vdate) . '
            </th>
        </tr>
    </table>
';
}


$pdf->writeHTML($html8, true, false, true, false, '');
// Output PDF
$outputPath = $_SERVER['DOCUMENT_ROOT'] . "/brcfoodsafety/upl1/Scale_record_" . $dtv . "_" . $pid . ".pdf";
$pdf->Output($outputPath, "F");

// Check if file was created
if (file_exists($outputPath)) {
    echo '<iframe src="upl1/Scale_record_' . $dtv . '_' . $pid . '.pdf" frameborder="0" width="100%" height="650px"></iframe>';
} else {
    echo '<p style="color:red;">Error: Could not generate PDF file. Please check server permissions.</p>';
}



if ($ac == '2') { ?>
    <div class="row mt-3">
        <div class="col-md-4"></div>
        <div class="col-md-4"> <a href="admin.php?id=scalesign1&dtv=<?php echo $dtv; ?>&tid=<?php echo $pid; ?>" target="_blank" rel="noopener noreferrer" class="btn bg-info text-white form-control text-center mt-3">Next</a></div>
        <div class="col-md-4"></div>
    </div>
<?php
} ?>