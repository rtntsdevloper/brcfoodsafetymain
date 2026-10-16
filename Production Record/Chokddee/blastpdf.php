<?php
include 'connection.php';
require_once('tcpdf/tcpdf.php');
$pid=$_GET['tid'];
$ac=$_GET['ac'];
$bid=$_GET['bid'];
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
        $this->Cell(0, 0, ' BLAST CHILLER LOG', 0, 1, 'C');

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
$pdf->SetTitle('Blast Chiller Log');
$pdf->SetSubject('Blast Chiller Log');
$pdf->SetKeywords('Blast, Record');

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
        <td width="33%" style="text-align:center;">  REC 6.1.002 </td>
        <td  width="33%" style="text-align:center;">Issue date: 17/04/2025</td>
        <td width="33%" style="text-align:center;">Created by: Bijal Chauhan</td> 
    </tr>
    <tr>
        <td width="33%" style="text-align:center;">Reason for change: New Form</td>
        <td width="33%" style="text-align:center;">Issues number: 01</td>
        <td width="33%" style="text-align:center;">Authorised by: Paramvir S. Deol</td>
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

$sql1 = mysqli_query($con, "SELECT * FROM tblblast where tid='$pid' And date='$bid' ORDER BY Date desc");

// Start HTML table
$html = '<table border="1" cellpadding="5" style="text-align:center; width:100%; font-size:9px;">';

$html .= '<tr>
    <td colspan="13" style="color:rgba(0, 51, 102); font-weight:bold; text-align:center; font-size:14px;">
        Blast Chiller
    </td>
</tr>';

$html .= '<tr style="font-weight:bold;">
    <th rowspan="3" width="10%"><br><br><br>Date</th>
    <th colspan="3" width="30%">Product Detail</th>
    <th colspan="8" width="40%">Blast Chilling Limit &lt;5C in 90 mins</th>
    <th rowspan="3" width="10%"><br><br><br>Staff Sign</th>
    <th width="10%" rowspan="3"><br><br><br>Verify</th>
</tr>

<tr style="font-weight:bold;">
    <th rowspan="2">Product Name</th>
    <th rowspan="2">Time</th>
    <th rowspan="2">Quantity</th>
    <th colspan="2">Blast Chiller</th>
    <th colspan="2">Product</th>
    <th colspan="2">Blast Chiller</th>
    <th colspan="2">Product</th>
</tr>

<tr style="font-weight:bold;">
    <th>Start Time</th>
    <th>Temp</th>
    <th>Time</th>
    <th>Temp</th>
    <th>Finish Time</th>
    <th>Temp</th>
    <th>Finish Time</th>
    <th>Temp</th>
</tr>';


   while ($row = mysqli_fetch_assoc($sql1)) {
    $dtty = date('d-m-Y',strtotime($row['date']));
    $html .=
        '<tr style="page-break-inside: avoid;">
    <td>' . $dtty . '</td>
    <td>' . $row['product'] . '</td>
    <td>' . $row['time'] . '</td>
    <td>' . $row['qty'] . '</td>
    <td>' . $row['th1'] . '</td>
    <td>' . $row['th2'] . '</td>
    <td>' . $row['ch1'] . '</td>
    <td>' . $row['ch2'] . '</td>
    <td>' . $row['finishtime1'] . '</td>
    <td>' . $row['temp1'] . '</td>
    <td>' . $row['finishtime2'] . '</td>
    <td>' . $row['temp2'] . '</td>
    <td><img src="precord/sign/'.$row['sign'].'.png" width="120" height="40"></td>';
    
    // Check if verify field is empty
    if (!empty($row['verify'])) {
        $html .= '<td><img src="precord/sign/'.$row['verify'].'.png" width="120" height="40"></td>';
    } else {
        $html .= '<td style="color:red;">Not Verified</td>';
    }
    
    
    $html .= '</tr>';
}


$html .= '</table>';
$pdf->writeHTML($html, true, false, true, false, '');

$html8 = "";
if ($ac == '2') {
    $html8 .= '
<p style="color:red; text-align:center">Not Verified Yet!</p>';
} elseif ($ac == '1') {
    $vrq = mysqli_query($con, "SELECT distinct msign FROM `tblblast` WHERE date='$bid' and tid ='$pid'");

    $vrq1 = mysqli_fetch_array($vrq);
    $vsign = $vrq1['msign'];
   
    $html8 .= '
    <table border="1" width="100%"   cellpadding="5">
        <tr nobr="true">
            <th style="text-align:center; width:20%;">
                <strong>Manager Signature : </strong>
            </th>
             <th style="text-align:center; width:20%;">
                <img src="precord/sign/' . $vsign . '.png" alt="Signature" width="90" height="30" />
                
            </th>
          
        </tr>
    </table>
';
}


$pdf->writeHTML($html8, true, false, true, false, '');

$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "/brcfoodsafety/upl1/blast_record_".$pid.".pdf", "F");
?>
<iframe src="upl1/blast_record_<?php echo $pid;?>.pdf" frameborder="0" width="100%" height="600px"></iframe>


<?php 

if($ac == '2'){
   echo '
   <div class="row">
   <div class="col-md-4"></div>
   <div class="col-md-4"><a href="admin.php?id=verifyreport&tid=' . $pid . '&bid=' . $bid . '"><button class="btn btn-info w-100">Verify Report</button></a></div>
   <div class="col-md-4"></div></div>
   ';
}

?>