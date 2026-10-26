<?php
include 'connection.php';
ini_set('max_execution_time', 600);
ini_set('memory_limit', '-1');
require('tcpdf/tcpdf.php');

if (isset($_POST['submit'])) {
    $syear = $_POST['year'];
} else {
    $syear = date('Y');
}

// Get footer data from database


class MYPDF extends TCPDF
{
    private $footerData;

    public function __construct($orientation, $unit, $format, $unicode, $encoding, $footerData)
    {
        parent::__construct($orientation, $unit, $format, $unicode, $encoding);
        $this->footerData = $footerData;
    }

    public function Header()
    {
        $image_file = 'images/1.png';
        $image_file1 = 'images/rtnts.png';

        // Left Logo
        $this->Image($image_file, 15, 10, 25, '', 'png', '', 'T', false, 200, '', false, false, 0, false, false, false);

        // Header Title
        $this->SetFont('helvetica', 'B', 16);
        $this->SetTextColor(33, 37, 41);
        $this->SetXY(45, 15);
        $this->Cell(207, 10, 'Micro Testing Justification', 0, 1, 'C');

        // Right Logo (kept inside the right margin)
        $this->Image($image_file1, 252, 10, 30, '', 'PNG', '', 'T', false, 200, '', false, false, 0, false, false, false);

        // Header Line (accent colour)
        $this->SetDrawColor(57, 73, 171);
        $this->SetLineWidth(0.8);
        $this->Line(15, 28, 282, 28);
    }

    public function Footer()
    {
        // Footer Line
        $this->SetDrawColor(225, 228, 235);
        $this->SetLineWidth(0.3);
        $this->Line(15, 185, 282, 185);

        $this->SetY(-20);
        $this->SetFont('helvetica', '', 9);
        $this->SetTextColor(120, 125, 135);

        $footerContent = '
        <table width="100%" cellpadding="2" border="0">
            <tr>
                <td width="33%"><b>Issue date:</b> ' . htmlspecialchars($this->footerData['issuedate']) . '</td>
                <td width="34%" align="center" rowspan="2">Page ' . $this->getAliasNumPage() . ' of ' . $this->getAliasNbPages() . '</td>
                <td width="33%" align="right"><b>Author:</b> ' . htmlspecialchars($this->footerData['author']) . '</td>
            </tr>
            <tr>
                <td width="33%"><b>Version:</b> ' . htmlspecialchars($this->footerData['version']) . '</td>
                
                <td width="33%" align="right"><b>Authorised by:</b> ' . htmlspecialchars($this->footerData['authorisedby']) . '</td>
            </tr>
            <tr><td width="100%"><b>Reason : </b>' . htmlspecialchars($this->footerData['reason']) . '</td></tr>
        </table>';

        $this->writeHTML($footerContent, true, false, true, false, '');
    }
}

// Helper: signature image (or empty string if none)
function signImg($file)
{
    if (!empty($file)) {
        return '<img src="micro/sign/' . $file . '" width="40" height="40">';
    }
    return '';
}

// Prepare footer data
$qsp = mysqli_query($con, "SELECT * FROM `tblformcontrol` WHERE tabname ='Micro Testing Justification'");
$qsp1 = mysqli_fetch_array($qsp);
echo $qspdate = date('d/m/Y', strtotime($qsp1['issuedate']));
$footerData = [
    'issuedate' => $qspdate,
    'version' => $qsp1['version'],
    'author' => $qsp1['author'],
    'reason' => $qsp1['reason'],
    'authorisedby' => $qsp1['authoriesby']
];

// Initialize PDF
$pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', $footerData);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetMargins(15, 35, 15);   // set before AddPage so page 1 uses it
$pdf->SetHeaderMargin(15);
$pdf->SetFooterMargin(20);
$pdf->SetAutoPageBreak(TRUE, 25);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

$pdf->AddPage('L', 'A4');
$html = '';

// --- Main Content HTML ---
$html .= '
<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        background-color: #eef1ff;
        color: #3949ab;
        font-family: helvetica;
        font-size: 10px;
        font-weight: bold;
        text-align: left;
    }

    td {
        font-family: helvetica;
        font-size: 10px;
        color: #2b2f36;
        text-align: left;
    }

    .muted { color: #9aa0a6; }
    .yes   { color: #b45309; font-weight: bold; }
    .no    { color: #15803d; font-weight: bold; }
    .bold  { font-weight: bold; }

    .main-title {
        font-family: helvetica;
        font-size: 14px;
        font-weight: bold;
        color: #212529;
    }

    .section-title {
        font-family: helvetica;
        font-size: 12px;
        font-weight: bold;
        color: #3949ab;
    }
</style>

<div class="main-title">Micro Testing Review - ' . htmlspecialchars($syear) . '</div>
<br>
<div class="section-title">Justification of Micro Testing Not Conducted</div>
<br>
<table cellpadding="5" border="0.3" bordercolor="#d5daf0">
    <thead>
        <tr bgcolor="#eef1ff">
            <th width="4%"  valign="middle" align="center">S No.</th>
            <th width="8%"  valign="middle" align="left">Date</th>
            <th width="9%"  valign="middle" align="left">Section</th>
            <th width="10%" valign="middle" align="left">Sub-Section (Area)(Sample No.)</th>
            
            <th width="8%"  valign="middle" align="left">Category</th>
            <th width="11%" valign="middle" align="left">Reason / Details</th>
            <th width="9%"  valign="middle" align="left">Corrective Action</th>
            <th width="9%"  valign="middle" align="left">RCA</th>
            <th width="9%"  valign="middle" align="left">Preventive Action</th>
            <th width="8%"  valign="middle" align="left">Micro testing required in upcoming months?</th>
            <th width="8%"  valign="middle" align="left">Month</th>
            <th width="7%"  valign="middle" align="center">Signature</th>
        </tr>
    </thead>
    <tbody>';

$justtest = mysqli_query($con, "SELECT m1.*,s.name as sub,s1.area as sarea, s1.sampleno as sampleno,s.name as section FROM `tbl_microtrending1` as m1 join tbl_microtrending as m join tbl_micortrend as s join tbl_micortrend1 as s1 on m1.eid = m.id and m.sid = s1.id and m.mid = s.id WHERE m1.status ='justified' and reportno ='Main' and m1.attempt_on LIKE '$syear%' ORDER BY `m1`.`id` ASC");
$sno = 1;
foreach ($justtest as $mvalue) {

    if ($mvalue['category'] == 'other' || $mvalue['category'] == 'missed testing') {
        $ca = $mvalue['caction'];
        $rca = $mvalue['rca'];
        $pa = $mvalue['paction'];
    } else {
        $ca = 'N/A';
        $rca = 'N/A';
        $pa = 'N/A';
    }

    $html .= '
        <tr nobr="true" bgcolor="#ffffff">
            <td width="4%"  valign="top" align="center">' . $sno . '</td>
              <td width="8%"  valign="top">' . date('M d, Y', strtotime($mvalue['attempt_on'])) . '</td>
            <td width="9%"  valign="top" class="bold">' . $mvalue['section'] . '</td>
            <td width="10%" valign="top">' . $mvalue['sub'] . '<br>(' . $mvalue['sarea'] . ')<br>(' . $mvalue['sampleno'] . ')</td>
          
            <td width="8%"  valign="top">' . $mvalue['category'] . '</td>
            <td width="11%" valign="top">' . $mvalue['reason'] . '</td>
            <td width="9%"  valign="top">' . $ca . '</td>
            <td width="9%"  valign="top">' . $rca . '</td>
            <td width="9%"  valign="top">' . $pa . '</td>
            <td width="8%"  valign="top" class="' . $mvalue['remark'] . '">' . $mvalue['remark'] . '</td>
            <td width="8%"  valign="top">' . date('F Y', strtotime($mvalue['month'])) . '</td>
            <td width="7%"  valign="top" align="center">' . signImg($mvalue['sign']) . '</td>
        </tr>';
    $sno++;
}

$html .= '
    </tbody>
</table>

<br><br><br>
<div class="section-title">Justification For Retesting Not Conducted</div>
<br>
<table cellpadding="5" border="0.3" bordercolor="#d5daf0">
    <thead>
        <tr bgcolor="#eef1ff">
            <th width="5%"  valign="middle" align="center">S No.</th>
            <th width="15%" valign="middle" align="left">Date</th>
            <th width="15%" valign="middle" align="left">Section</th>
            <th width="25%" valign="middle" align="left">Sub-Section (Area)(Sample No.)</th>
            <th width="20%" valign="middle" align="left">Reason / Details</th>
            <th width="20%" valign="middle" align="center">Signature</th>
        </tr>
    </thead>
    <tbody>';

$retest = mysqli_query($con, "SELECT m1.*,s.name as sub,s1.area as sarea, s1.sampleno as sampleno,s.name as section FROM `tbl_microtrending1` as m1 join tbl_microtrending as m join tbl_micortrend as s join tbl_micortrend1 as s1 on m1.eid = m.id and m.sid = s1.id and m.mid = s.id WHERE m1.status ='justified' and reportno ='Retest' and  m1.attempt_on LIKE '$syear%' ORDER BY `m1`.`id` ASC");
$snox = 1;
foreach ($retest as $rvalue) {
    $html .= '
        <tr nobr="true" bgcolor="#ffffff">
            <td width="5%"  valign="top" align="center">' . $snox . '</td>
             <td width="15%" valign="top">' . date('M d, Y', strtotime($rvalue['attempt_on'])) . '</td>
            <td width="15%" valign="top" class="bold">' . $rvalue['section'] . '</td>
            <td width="25%" valign="top">' . $rvalue['sub'] . '<br>(' . $rvalue['sarea'] . ')<br>(' . $rvalue['sampleno'] . ')</td>
           
            <td width="20%" valign="top">' . $rvalue['reason'] . '</td>
            <td width="20%" valign="top" align="center">' . signImg($rvalue['sign']) . '</td>
        </tr>';
    $snox++;
}

$html .= '
    </tbody>
</table>
';

$pdf->SetXY(15, 35);
$pdf->writeHTML($html, true, false, true, false, '');

// Sanitize the filename
$y['mcover'] = "SampleCover";
$filename = "justification_report_" . $syear;

$filePath = $_SERVER['DOCUMENT_ROOT'] . "/micro/upload/" . $filename . ".pdf";

try {
    if (!file_exists(dirname($filePath))) {
        mkdir(dirname($filePath), 0755, true);
    }
    $pdf->Output($filePath, "F");
} catch (Exception $e) {
    echo "Error generating PDF: " . $e->getMessage();
}

?>

<div class="main-content">
    <div class="container-fluid" style="margin-top:20px;">
        <div class="row mb-12">
            <div class="col-md-12 mb-12">
                <div class="card text-left" style="border:0; border-radius:10px; box-shadow:0 2px 12px rgba(30,41,59,.08);">
                    <div class="card-body">
                        <a href="admin.php?id=microtrending">
                            <button class="btn btn-primary mb-3" style="float:right; margin-left:15px">Go Back</button>
                        </a>
                        <h4 class="card-title mb-3" style="font-weight:600;">Justification Report</h4>
                        <br>
                        <form method="post">
                            <div class="row">
                                <div class="col-md-4">
                                    <select name="year" id="year" class="form-control">
                                        <?php
                                        $cnyear = date('Y');
                                        for ($i = 2026; $i <= $cnyear; $i++) {
                                            if ($i == $syear) {
                                                echo '<option value="' . $i . '" selected>' . $i . '</option>';
                                            } else {
                                                echo '<option value="' . $i . '">' . $i . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-primary" name="submit">Submit</button>
                                </div>
                            </div>
                        </form>
                        <br>
                        <div class="embed-responsive embed-responsive-4by3" style="height: 678px; border:1px solid #e1e4eb; border-radius:8px; overflow:hidden;">
                            <iframe class="embed-responsive-item w-100 h-70" src="micro/upload/<?php echo $filename; ?>.pdf" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>