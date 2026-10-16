<?php
include("connection.php");
require_once('tcpdf/tcpdf.php');

$sno =$_GET['sno'];

$sql = mysqli_query($con, "SELECT * FROM tblequipment1 WHERE id='$sno'");
$row = mysqli_fetch_array($sql);


$sql2 = mysqli_query($con, "SELECT * FROM tblequipment WHERE id='$row[eid]'");
$row2 = mysqli_fetch_array($sql2);

class MYPDF extends TCPDF
{
    private $logo1Path = 'images/1.png';
    private $logo2Path = 'images/rtnts.png';
    private $longTableFooter = '';

    public function Header()
    {
        $this->SetFillColor(255, 255, 255);
        $this->Rect(0, 0, $this->getPageWidth(), 30, 'F');

        if (file_exists($this->logo1Path)) {
            $this->Image($this->logo1Path, 15, 10, 28, '', '', '', 'T');
        }
        if (file_exists($this->logo2Path)) {
            $this->Image($this->logo2Path, 255, 7, 32, '', '', '', 'T');
        }

        $this->SetFont('Century Gothic', 'B', 22);
        $this->SetTextColor(0, 51, 102);
        $this->SetXY(12, 12);
        $this->Cell(0, 0, 'Planned Preventive Maintenance Report', 0, 1, 'C');

        $this->SetLineWidth(0.5);
        $this->SetDrawColor(0, 102, 204);
        $this->Line(15, 28, 280, 28);
    }

    public function Footer()
    {
        $this->SetFont('helvetica', '', 8);
        $this->SetY(-20);
        $this->writeHTML($this->longTableFooter);
    }

    public function setLongTableFooter($html)
    {
        $this->longTableFooter = $html;
    }
}

$pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator('Your Company');
$pdf->SetAuthor('Record');
$pdf->SetTitle('Planned Preventive Maintenance Report');
$pdf->SetSubject('PPM Report');
$pdf->SetMargins(15, 30, 15);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(20);
$pdf->SetAutoPageBreak(TRUE, 25);

$footer = '
<table width="100%" cellpadding="3" border="0.2" style="font-size:9px; border-color: #000000; color:black;">
<tr>
<td width="255">Issue date: </td>
<td width="240" align="center">Page ' . $pdf->getAliasNumPage() . ' / ' . $pdf->getAliasNbPages() . '</td>
<td width="255">Amended: </td>
</tr>
<tr>
<td width="255">Version No:</td>
<td width="240" align="center"></td>
<td width="255">Authorised by: </td>
</tr>
<tr>
<td width="750" colspan="2">Reason for Change: </td>
</tr>
</table>';

$pdf->setLongTableFooter($footer);
$pdf->AddPage();
$pdf->SetY(40);

$string2 = $row['checks'];
$tags2 = !empty($string2) ? explode(';', $string2) : ['', '', '', ''];



// Safety 2 Comment
if (!empty($row['safety2_reason'])) {
} // Set font
$pdf->SetFont('centurygothic', 'B', 12);

$pdf->Cell(0,  10, 'Date : ' . date("d-m-Y", strtotime($row['stime'])), 0, 1, 'L');

// Reset font for normal content
$pdf->SetFont('centurygothic', '', 14);
$pdf->SetTextColor(0, 0, 0);

// Equipment Information Table
$html = '<table border="1" cellpadding="4" width="100%" style="font-size:10px; font-family:century gothic;">
<style>

th{
background-color: #90EE90;
}
</style>
<tr><th width="30%">Equipment Code</th><td width="70%">' . htmlspecialchars($row2['code']) . '</td></tr>
<tr><th width="30%">Manufacturer</th><td width="70%">' . htmlspecialchars($row2['make']) . '</td></tr>
<tr><th width="30%">Model Number</th><td width="70%">' . htmlspecialchars($row2['model']) . '</td></tr>
<tr><th width="30%">Equipment Name</th><td width="70%">' . htmlspecialchars($row2['name']) . '</td></tr>
<tr><th width="30%">Service Type</th><td width="70%">' . htmlspecialchars($row2['service']) . '</td></tr>
<tr><th width="30%">Site</th><td width="70%">' . htmlspecialchars($row2['site']) . '</td></tr>
<tr><th width="30%">Location</th><td width="70%">' . htmlspecialchars($row2['location']) . '</td></tr>
<tr><th width="30%">Frequency</th><td width="70%">' . htmlspecialchars($row2['frequency']) . '</td></tr>
<tr><th width="30%">Responsible Person</th><td width="70%">' . htmlspecialchars($row2['rperson']) . '</td></tr>
</table>';
$pdf->writeHTML($html, true, false, true, false, '');

// Set fill color (light orange)
$pdf->SetFillColor(255, 200, 150);
$pdf->Cell(0, 10, 'Safety Checks & Maintenance', 0, 1, 'C', true);

$pdf->SetFont('centurygothic', '', 10);
$pdf->SetTextColor(0, 0, 0);


$htmls = '<br><br><table border="1" cellpadding="4" width="100%" style="font-size:10px; font-family:Century Gothic;">
<style>

th{
background-color: #90EE90;
}
</style>
<tr><th width="30%">1° Safety Check: (Maintenance work carried out and complete)</th><td width="70%">' . htmlspecialchars($tags2[0]) . '</td></tr>
<tr><th width="30%">2° Safety Check: (Any residual debris removed and cleared)</th><td width="70%">' . htmlspecialchars($tags2[1]) . ' (' . ($row['safety2_reason']) . ')' . '</td></tr>';


$htmls .= '    <tr><th width="30%">3° Safety Check: (Are tools and equipment used maintenance wiped cleaned and sanitized)</th><td width="70%">' . htmlspecialchars($tags2[2]) . '</td></tr>
<tr nobr="true"><th width="30%">4° Safety Check: (Equipment in good working order)</th><td width="70%">' . htmlspecialchars($tags2[3]) . '</td></tr>

<tr><th width="30%">Corrective </th><td width="70%">' . htmlspecialchars($row['description']) . '</td></tr>
<tr><th width="30%">Any Parts Replaced</th><td width="70%">' . htmlspecialchars($row['preplace']) . '</td></tr>';


$htmls .= '
<tr>
<th width="30%">Service Report</th>
<td width="70%">';

if (!empty($row['serviceimg'])) {
    $htmls .= '<a href="../upl1/' . htmlspecialchars($row['serviceimg']) . '" style="text-decoration:none;">View</a>';
} else {
    $htmls .= 'No file uploaded';
}

$htmls .= '</td></tr>
<tr>
<th width="30%">Supporting Documents</th>
<td width="70%">';

if (!empty($row['supdoc'])) {
    $htmls .= '<a href="../upl1/' . htmlspecialchars($row['supdoc']) . '" style="text-decoration:none;"> View</a>';
} else {
    $htmls .= 'No file uploaded';
}

$htmls .= '</td></tr>
</table>';

$pdf->writeHTML($htmls, true, false, true, false, '');

// Engineer Information Section
$hasEngineerInfo = !empty($row['engineer_type']) || !empty($row['visit_completed']) || !empty($row['corrective_reason']) || !empty($row['ename']);


$pdf->SetFont('centurygothic', 'B', 14);

// Set fill color (light orange)
$pdf->SetFillColor(255, 200, 150);
$pdf->Cell(0, 10, 'Engineer Information', 0, 1, 'C', true);

$pdf->SetFont('centurygothic', '', 10);
$pdf->SetTextColor(0, 0, 0);

if ($hasEngineerInfo) {


    $html_engineer = '<br><br>
<table border="1" cellpadding="4" width="100%" style="font-size:10px; font-family:century gothic;">
<style>

th{
background-color: #90EE90;
}
</style>
';

    if (!empty($row['ename'])) {
        $html_engineer .= '<tr nobr="true"><th width="30%">Engineer Name</th><td width="70%">' . htmlspecialchars($row['ename']) . '</td></tr>';
    }
    if (!empty($row['engineer_type'])) {
        $html_engineer .= '<tr nobr="true"><th width="30%">Is the engineer internal or external?</th><td width="70%">' . htmlspecialchars($row['engineer_type']) . '</td></tr>';
    }
    if (!empty($row['visit_completed'])) {
        $html_engineer .= '<tr nobr="true"><th width="30%">The person has completed visit before enter Production ?
</th><td width="70%">' . htmlspecialchars($row['visit_completed']) . '</td></tr>';
    }
    if (!empty($row['corrective_reason'])) {
        $html_engineer .= '<tr nobr="true"><th width="30%">Corrective Action</th><td width="70%">' . htmlspecialchars($row['corrective_reason']) . '</td></tr>';
    }

    $html_engineer .= '</table>';
    $pdf->writeHTML($html_engineer, true, false, true, false, '');
}

$pdf->SetFont('centurygothic', 'B', 14);

$pdf->SetFillColor(255, 200, 150);
$pdf->Cell(0, 10, 'Maintenance Details', 0, 1, 'C', true);

$pdf->SetFont('centurygothic', '', 10);
$pdf->SetTextColor(0, 0, 0);

    $html1 = '<br><br><table border="1" cellpadding="4" width="100%" style="font-size:10px; font-family:century gothic;">
    <style>

    th{
    background-color: #90EE90;
    }
    </style>
    <tr>
    <th width="25%">Due Production needs be stopped for this Maintenance ?</th>
    <td width="25%">' . htmlspecialchars($row['production']) . '</td>
    <th width="25%">How many hours production cannot be carried out ?</th>
    <td width="25%">' . (!empty($row['hours']) && ($row['production']) == 'Yes' ? htmlspecialchars($row['hours']) . ' hours' : '-') . '</td>
    </tr>
    <tr>
    <th width="25%">Maintenance Start Time</th>
    <td width="25%">' . (!empty($row['stime']) ? date("d-m-Y h:i:s a", strtotime($row['stime'])) : 'Not Set') . '</td>
    <th width="25%">Maintenance End Time</th>
    <td width="25%">' . (!empty($row['etime']) ? date("d-m-Y h:i:s a", strtotime($row['etime'])) : 'Not Set') . '</td>
    </tr>
    <tr>
    <th width="25%">Next Maintenance Date</th>
    <td width="25%">' . (!empty($row['nextdate']) ? date("d-m-Y", strtotime($row['nextdate'])) : 'Not Set') . '</td>
    <th width="25%">Task Completed By</th>
    <td width="25%">' . htmlspecialchars($row['completedby']) . '</td>
    </tr>
    </table>';

    $pdf->writeHTML($html1, true, false, true, false, '');

// Machine Verification Section
if (($row['mverify']) == 'done') {
    $vsql = mysqli_query($con, "SELECT * FROM `machineverify` WHERE sno='$sno' ");
    $vrow = mysqli_fetch_array($vsql);

    if ($vrow) {
        // Split the stored data
        $que_array = !empty($vrow['que']) ? explode(' ; ', $vrow['que']) : [];
        $comment_array = !empty($vrow['comment']) ? explode(' ; ', $vrow['comment']) : [];
        $img_array = !empty($vrow['img']) ? explode(' ; ', $vrow['img']) : [];

        // Define questions with full descriptions
        $questions = [
            'A' => 'Is the equipment operational and functioning as per specifications?',
            'B' => 'Have all safety systems and guards been verified and tested?',
            'C' => 'Is the product quality within acceptable parameters?',
            'D' => 'Has the work area been cleaned, sanitized and released?',
            'E' => 'Has the commissioning been approved by the responsible person?'
        ];

        $pdf->SetFont('centurygothic', 'B', 14);

        // Set fill color (light orange)
        $pdf->SetFillColor(255, 200, 150);
        $pdf->Cell(0, 10, 'Machine Verification Detail', 0, 1, 'C', true);

        $pdf->SetFont('centurygothic', '', 10);
        $pdf->SetTextColor(0, 0, 0);
        $html2 = '<br><br>
        <table border="1" cellpadding="4" width="100%" style="font-size:10px;font-family:Century Gothic;">
        <style>

        th{
        background-color: #90EE90;
        }
        </style>
        <tr style="background-color:#e6f2ff;">
        <th width="3%" style="text-align:center;">#</th>
        <th width="37%">Question</th>
        <th width="15%" style="text-align:center;">Answer</th>
        <th width="45%">Comment / Corrective Action</th>
        </tr>';

                $counter = 0;
                foreach ($questions as $alpha => $question) {
                    $answer = isset($que_array[$counter]) ? htmlspecialchars($que_array[$counter]) : 'Not Answered';
                    $comment = isset($comment_array[$counter]) ? htmlspecialchars($comment_array[$counter]) : '';
                    $image = isset($img_array[$counter]) ? htmlspecialchars($img_array[$counter]) : '';

                    $html2 .= '<tr nobr="true">
        <th width="3%" style="text-align:center; font-weight:bold;">' . $alpha . '.</th>
        <th width="37%">' . $question . '</th>
        <td width="15%" style="text-align:center;">' . $answer . '</td>
        <td width="45%">';

            if (!empty($comment)) {
                $html2 .= '<strong>Comment:</strong> ' . $comment . '<br>';
            }
            if (!empty($image)) {
                $image_path = 'upl1/' . $image;
                if (file_exists($image_path)) {
                    $html2 .= '<br><img src="' . $image_path . '" height="80" width="80"><br>';
                } else {
                    $html2 .= '<span style="color:red;">Image not found</span>';
                }
            }

            if (empty($comment) && empty($image)) {
                $html2 .= '';
            }

            $html2 .= '</td></tr>';
            $counter++;
        }

        $html2 .= '</table>';
        $pdf->writeHTML($html2, true, false, true, false, '');

        // Verification Signature
        $sign = '';
        if (!empty($vrow['sign'])) {
            $sign_path = 'sign/' . $vrow['sign'] . '.png';
            if (file_exists($sign_path)) {
                $sign = '<img src="' . $sign_path . '" height="50">';
            }
        }

            $html3 = '<table border="0" cellpadding="4" width="100%" style="font-size:10px; margin-top:10px;">
            <tr>
            <td width="80%"></td>
            <td width="20%" style="text-align:center;">' . $sign . '</td>
            </tr>
            <tr>
            <td width="80%"></td>
            <td width="20%" style="text-align:center; font-weight:bold;">Verified By: ' . htmlspecialchars($vrow['vname']) . '</td>
            </tr>

            </table>';

            $pdf->writeHTML($html3, true, false, true, false, '');
            }
            }

        $filename = "machine_update_$sno.pdf";
        $pdf->Output($_SERVER['DOCUMENT_ROOT'] . "finemed/upl1/$filename", "F");
        ?>

<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-12 d-flex justify-content-end">


            <?php
            $verify = mysqli_query($con, "SELECT * FROM `tblequipment1` WHERE id='$sno'");
            $verifyrow = mysqli_fetch_array($verify);

            if (empty($verifyrow['mverify'])) {
            ?>
                <a href="admin.php?id=machineverify&sno=<?php echo urlencode($sno); ?>"
                    class="btn btn-warning text-white m-1">Verify</a>
            <?php
            }
            ?>
            <a href="admin.php?id=ppm1&sno=<?php echo urlencode($sno); ?>" class="btn btn-success m-1">Go Back</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <iframe src="upl1/machine_update_<?php echo htmlspecialchars($sno); ?>.pdf" frameborder="0" width="100%" height="600px"></iframe>
        </div>
    </div>
</div>