<?php
include("connection.php");
require_once('tcpdf/tcpdf.php');

$sno = $_GET['sno'];

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
            $this->Image($this->logo1Path, 15, 10, 25, '', '', '', 'T');
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
$pdf->SetTitle('Daily Weight Check');
$pdf->SetSubject('Daily Weight Check');
$pdf->SetMargins(15, 30, 15);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(20);
$pdf->SetAutoPageBreak(TRUE, 25);

$footer = '
<table width="100%" cellpadding="3" border="0.2" style="font-size:9px; border-color:#000000; color:black;">
    <tr>
        <td width="255">Issue date: </td>
        <td width="240" align="center">Page ' . $pdf->getAliasNumPage() . ' / ' . $pdf->getAliasNbPages() . '</td>
        <td width="255">Amended: </td>
    </tr>
    <tr>
        <td width="255">Version No:</td>
        <td width="240" align="center">Doc Ref:</td>
        <td width="255">Authorised by:</td>
    </tr>
    <tr>
        <td width="750" colspan="2">Reason for Change: Form has been reviewed</td>
    </tr>
</table>';

$pdf->setLongTableFooter($footer);
$pdf->AddPage();
$pdf->SetY(40);

$string2 = $row['checks'];
$tags2 = explode(';', $string2);

$html = '<h4>Date :' . date("d-m-Y", strtotime($row['stime'])) . ' </h4>
<table border="1" cellpadding="4" width="100%" style="font-size:10px; font-family:century gothic;">
    <tr><th width="30%">Equipment Code</th><td width="70%">' . $row2['code'] . '</td></tr>
    <tr><th width="30%">Manufacturer</th><td width="70%">' . $row2['make'] . '</td></tr>
    <tr><th width="30%">Model Number</th><td width="70%">' . $row2['model'] . '</td></tr>
    <tr><th width="30%">Equipment Name</th><td width="70%">' . $row2['name'] . '</td></tr>
    <tr><th width="30%">Service Type</th><td width="70%">' . $row2['service'] . '</td></tr>
    <tr><th width="30%">Site</th><td width="70%">' . $row2['site'] . '</td></tr>
    <tr><th width="30%">Location</th><td width="70%">' . $row2['location'] . '</td></tr>
    <tr><th width="30%">Frequency</th><td width="70%">' . $row2['frequency'] . '</td></tr>
    <tr><th width="30%">Responsible Person</th><td width="70%">' . $row2['rperson'] . '</td></tr>
    <tr><th width="30%">1° Safety Check</th><td width="70%">' . $tags2[0] . '</td></tr>
    <tr><th width="30%">2° Safety Check</th><td width="70%">' . $tags2[1] . '</td></tr>
    <tr><th width="30%">3° Safety Check</th><td width="70%">' . $tags2[2] . '</td></tr>
    <tr><th width="30%">4° Safety Check</th><td width="70%">' . $tags2[3] . '</td></tr>
    <tr nobr="true"><th width="30%">Any Parts Replaced</th><td width="70%">' . $row['preplace'] . '</td></tr>
    <tr nobr="true"><th width="30%">PPM Job Description To be filled by Engineer</th><td width="70%">' . $row['description'] . '</td></tr>
    <tr nobr="true"><th width="30%">Service Report</th>
        <td width="70%">
            <a href="../upl1/' . $row['serviceimg'] . '" target="_blank" style="text-decoration:none;">
                <img src="upl1/' . $row['serviceimg'] . '" height="80" width="100">
            </a>
        </td>
    </tr>
    <tr nobr="true"><th width="30%">Supporting Documents</th>
        <td width="70%">
            <a href="../upl1/' . $row['supdoc'] . '" target="_blank" style="text-decoration:none;">
                <img src="upl1/' . $row['supdoc'] . '" height="80" width="100">
            </a>
        </td>
    </tr>
</table>';

$pdf->writeHTML($html, true, false, true, false, '');

$html1 = '<table border="1" cellpadding="4" width="100%" style="font-size:10px; font-family:century gothic;">
    <tr>
        <th width="25%">Engineer Name</th><td width="25%">' . $row['ename'] . '</td>
        <th width="25%">Production Stop Required</th><td width="25%">' . $row['production'] . '</td>
    </tr>
    <tr>
        <th width="25%">Start Time</th><td width="25%">' . date("d-m-Y h:i:s a", strtotime($row['stime'])) . '</td>
        <th width="25%">End Time</th><td width="25%">' . date("d-m-Y h:i:s a", strtotime($row['etime'])) . '</td>
    </tr>
    <tr>
        <th width="25%">Next Maintenance Date</th><td width="25%">' . date("d-m-Y", strtotime($row['nextdate'])) . '</td>
                        <th width="25%">Task Completed By</th><td width="25%">' . ($row['completedby']) . '</td>

    </tr>
</table>';

$pdf->writeHTML($html1, true, false, true, false, '');

if ($row['mverify'] == 'done') {
    $vsql = mysqli_query($con, "SELECT * FROM `machineverify` WHERE sno='$sno' ");
    $vrow = mysqli_fetch_array($vsql);

    // Split the stored data
    $que_array = explode(' ; ', $vrow['que']);
    $comment_array = explode(' ; ', $vrow['comment']);
    $img_array = explode(' ; ', $vrow['img']);

    // Define questions
    $questions = [
        'A' => 'Is the equipment operational?',
        'B' => 'Have the safety systems been verified?',
        'C' => 'Is the product quality acceptable?',
        'D' => 'Has the area been cleaned and released?',
        'E' => 'Has commissioning been approved?'
    ];

    $html2 = '<h3 style="font-family:Century Gothic;">Machine Verification Detail</h3>
    <table border="1" cellpadding="4" width="100%" style="font-size:10px;font-family:Century Gothic;">';

    $counter = 0;
    foreach ($questions as $alpha => $question) {
        $answer = isset($que_array[$counter]) ? $que_array[$counter] : 'Not Answered';
        $comment = isset($comment_array[$counter]) ? $comment_array[$counter] : '';
        $image = isset($img_array[$counter]) ? $img_array[$counter] : '';

        $html2 .= '<tr nobr="true">
            <td width="3%">' . $alpha . '.</td>
            <th width="37%">' . $question . '</th>
            <td width="20%">' . $answer . '</td>
            <td width="40%">';

        if (!empty($comment)) {
            $html2 .= '<strong>Corrective Action:</strong> ' . $comment . '<br>';
        }
        if (!empty($image)) {
            // Check if image file exists
            $image_path = 'upl1/' . $image;
            if (file_exists($image_path)) {
                $html2 .= '<br><img src="' . $image_path . '" height="80" width="80"><br>';
            } else {
                $html2 .= '<span style="color:red;">Image not found</span>';
            }
        }

        $html2 .= '</td>
        </tr>';
        $counter++;
    }

    $html2 .= '</table>';
    $pdf->writeHTML($html2, true, false, true, false, '');


    if (!empty($vrow['sign'])) {
        $sign = '<img src="sign/' . $vrow['sign'] . '.png" height="50">';
    } else {
        $sign = "";
    }
    $html3 = '<table border="0" cellpadding="4" width="100%" style="font-size:10px;">
    <tr>
    <td width="80%"></td>
    <td width:20%>' . $sign . '</td>
    </tr>
    <tr>
    <td width="80%"></td>
    <td width:20%>Verified By: ' . $vrow['vname'] . '</td>
    </tr>
    ';

    $html3 .= '</table>';
    $pdf->writeHTML($html3, true, false, true, false, '');
}

$filename = "machine_update_$sno.pdf";
$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "upl1/$filename", "F");
?>

<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-12 d-flex justify-content-end">
            <?php
            $verify = mysqli_query($con, "SELECT * FROM `tblequipment1` WHERE id='$sno'");
            $verifyrow = mysqli_fetch_array($verify);

            if (empty($verifyrow['mverify'])) {
            ?>
                <a href="admin.php?id=machineverify&sno=<?php echo $sno ?>" class="btn btn-warning m-1">Verify</a>

            <?php
            }
            ?>
            <a href="admin.php?id=ppm1&sno=<?php echo $sno; ?>" class="btn btn-success m-1">Go Back</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <iframe src="../upl1/machine_update_<?php echo $sno; ?>.pdf" frameborder="0" width="100%" height="600px"></iframe>


        </div>
    </div>
</div>