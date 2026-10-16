<?php
include 'connection.php';
require_once('tcpdf/tcpdf.php');
$dt = $_GET['date'];
$aid = $_GET['aid'];
$ac = $_GET['ac'];

// echo $dt. $aid. $ac ;die;



$range = isset($_GET['range']) ? $_GET['range'] : '';

                                if ($range == 'first') {
                                    // First half of the month (1–15)
                                    $sql = mysqli_query($con, "
        SELECT * FROM tblscales1 
        WHERE area='$aid' 
          AND DATE_FORMAT(date, '%Y-%m')='$dt' 
          AND DAY(date) BETWEEN 1 AND 15
        ORDER BY date ASC
    ");
                                } elseif ($range == 'second') {
                                    // Second half of the month (16–end)
                                    $sql = mysqli_query($con, "
        SELECT * FROM tblscales1 
        WHERE area='$aid' 
          AND DATE_FORMAT(date, '%Y-%m')='$dt' 
          AND DAY(date) > 15
        ORDER BY date ASC
    ");
                                } else {
                                    // Full month fallback
                                    $sql = mysqli_query($con, "
        SELECT * FROM tblscales1 
        WHERE area='$aid' 
          AND DATE_FORMAT(date, '%Y-%m')='$dt'
        ORDER BY date ASC
    ");
                                }

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
            $this->Image($this->logo1Path, 15, 7, 14, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }

        // Add logo 2 (right) if exists
        if (file_exists($this->logo2Path)) {
            $this->Image($this->logo2Path, 255, 7, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }

        // Main title
        $this->SetFont('courier', 'B', 22);
        $this->SetTextColor(0, 51, 102);
        $this->SetXY(12, 12);
        $this->Cell(0, 0, 'INTERNAL CALIBRATION LOG FOR SCALES ', 0, 1, 'C');

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
<table  cellpadding="5" >
    <tr>
        
        <td width="50%" style= "text-align:center;">Verified by:</td>
        <td width="50%" style= "text-align:center;" > Date: $dt </td> 
    </tr>
</table>
EOD;

$pdf->setFooterHTML($footerContent);

// Add a page
$pdf->AddPage();
$pdf->SetY(40);

// Prepare SQL query (consider using prepared statements)
$sq = mysqli_query($con, "SELECT * FROM tblscales1 where date1 = '$dt' and  area='$aid' ");
$row = mysqli_fetch_assoc($sq);
$query = mysqli_query($con, "SELECT * FROM tblscales WHERE id ='{$row['area']}'");
$i = 1;
$row1 = mysqli_fetch_assoc($query);



// First page table
$html = '<table border="1" cellpadding="4" width="100%">';
$html .= '<tr>
    <td style="color:rgba(0, 51, 102); text-align:center;" colspan="10">MONTHLY CALIBRATION</td>
</tr>
<tr>
    <td colspan="10">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td width="60%" style="vertical-align:top;">
                  Follow the diagram to take a weight reading from each of the five points on the weighing surface. <br><br>
                 Record the average weight of the five checks (g) on the internal calibration log for weighing scales document.
                </td>
                <td width="40%" style="text-align:center; vertical-align:top;">
                    <img src="images/scale.png" width="150">
                </td>
            </tr>
        </table>
    </td>
</tr>


<tr style="font-weight:bold; color:black; text-align:center;">
    <th width="10%" >Month</th>
    <th width="10%" >Scale No.  </th>
    <th width="35%" colspan="5">' . $row1['scale'] . '  </th>
    <th width="20%" colspan="2"> ';
if (!empty($row["image"])) {
    $html .= '<a href="../../../BRC/form/upl1/'.$row['image'].' "><img src="form/upl1/' . $row['image'] .'" alt="" style="height: 100px; width:120px;"></a>';
} else {
    $html .= 'Not Yet';
}


$html .= '</th>

    <th width="16%" rowspan="2">Corrective Actions</th>
    <th width="9%" rowspan="2">Sign</th>
    
</tr >
<tr style="font-weight:bold; text-align:center;">
<th>WC</th>
<th >Location</th>
<th colspan="5" style="text-align:center;">' . $row1['area'] . '</th>
<th>Avg.</th>
<th>Diff.</th>
</tr>';

while ($row = mysqli_fetch_assoc($sql)) {
    // Explode the comma-separated values into arrays
    $fifty = explode(",", $row['50g']);
    $one = explode(",", $row['100g']);
    $two = explode(",", $row['200g']);

    $sumfifty = array_sum($fifty) / count($fifty);
    $dfifty = (int) $sumfifty - 100;

    $sumone = array_sum($one) / count($one);
    $done = (int) $sumone - 1000;

    $sumtwo = array_sum($two) / count($two);
    $dtwo = (int) $sumtwo - 5000;



    $html .= '<tr style="text-align:center;">
       
    <td rowspan="3">' . date('d-m-Y', strtotime($row['date'])) . '</td>
       
        <td ><b>100g</b></td>
        <td >' . $fifty[0] . '</td>
        <td >' . $fifty[1] . '</td>
        <td >' . $fifty[2] . '</td>
        <td >' . $fifty[3] . '</td>
        <td >' . $fifty[4] . '</td>
        <td>' . $sumfifty . '</td>
        <td>' . $dfifty . '</td>
        <td rowspan="3">' . $row['corrective'] . '</td>
        <td rowspan="3"> <img src="form/sign/' . $row['sign'] . '.png" width="120" height="40"></td>
         
    </tr>
    <tr style="text-align:center;">
        <th><b>1kg</b></th>
        <td>' . $one[0] . '</td>
        <td>' . $one[1] . '</td>
        <td>' . $one[2] . '</td>
        <td>' . $one[3] . '</td>
        <td>' . $one[4] . '</td>
        <td>' . $sumone . '</td>
        <td>' . $done . '</td>
    </tr>
    <tr style="text-align:center;">
        <th><b>5kg</b></th>
        <td>' . $two[0] . '</td>
        <td>' . $two[1] . '</td>
        <td>' . $two[2] . '</td>
        <td>' . $two[3] . '</td>
        <td>' . $two[4] . '</td>
        <td>' . $sumtwo . '</td>
        <td>' . $dtwo . '</td>
    </tr>';
}

$html .= '</table>';


$pdf->writeHTML($html, true, false, true, false, '');


$pdf->SetY(200);
$html3 = '<table border="1" width="100%" cellspacing="0" cellpadding="5">
    <tr>
        <th style="text-align:center; font-weight:bold;"  width="45%" rowspan="3">Tolerance =  </th>
           <th style="text-align:center;"  width="45%"><b>100g</b> </th>
              <th style="text-align:center; "  width="10%">± 0.0 g </th>
        
    </tr>
    
     <tr>
       
           <th style="text-align:center; "  width="45%"><b>1kg</b> </th>
              <th style="text-align:center; "  width="10%">± 0.10 Kg </th>
        
    </tr>
    
     <tr>
        
           <th style="text-align:center; "  width="45%"><b>5kg</b> </th>
              <th style="text-align:center; "  width="10%">± 0.20 Kg </th>
        
    </tr>';




$html3 .= '</table>';



$pdf->writeHTML($html3, true, false, true, false, '');

// Output PDF
$outputPath = $_SERVER['DOCUMENT_ROOT'] . "/finemed/form/upl1/internal_scale_calibration_{$dt}_{$aid}.pdf";
$pdf->Output($outputPath, "F");

// Check if file was created
if (file_exists($outputPath)) {
    echo '<iframe src="form/upl1/internal_scale_calibration_'.$dt.'_'.$aid.'.pdf" frameborder="0" width="100%" height="600px"></iframe>';
} else {
    echo '<p style="color:red;">Error: Could not generate PDF file. Please check server permissions.</p>';
}

?>
<!-- <?php
        if ($ac == 2) {
            echo '<a href="admin.php?id=insign&aid=' . $aid . '&date=' . $dt . '"><button class="btn btn-warning w-100"> Verify Report </button></a>';
        }
        ?> -->