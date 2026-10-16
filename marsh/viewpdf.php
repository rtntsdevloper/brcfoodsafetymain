<?php
include 'connection.php';
require_once('tcpdf/tcpdf.php');

if (isset($_GET['sid']) && !empty($_GET['sid'])) {
    $sid = $_GET['sid'];
}
if (isset($_GET['spid']) && !empty($_GET['spid'])) {
    $sid = $_GET['spid'];
}
$from_date = $_GET['from_date'];
$to_date = $_GET['to_date'];

if (isset($_GET['sid']) && !empty($_GET['sid'])) {
    $sid = $_GET['sid'];

    $sq = mysqli_query($con, "SELECT * FROM dailychecks WHERE id ='$sid'");
} elseif (isset($_GET['spid']) && !empty($_GET['spid'])) {
    $spid = $_GET['spid'];
    $sq = mysqli_query($con, "SELECT * FROM dailychecks WHERE sid ='$spid' and status !='first'");
}
$roww = mysqli_fetch_assoc($sq);
$name = $roww['name'];

$formattedFromDate = date("d/m/Y", strtotime($from_date));
$formattedToDate = date("d/m/Y", strtotime($to_date));

function getDateRange($start, $end)
{
    $dates = [];
    $current = strtotime($start);
    $end = strtotime($end);
    while ($current <= $end) {
        $dates[] = date('Y-m-d', $current);
        $current = strtotime('+1 day', $current);
    }
    return $dates;
}
$dateRange = getDateRange($from_date, $to_date);

class MYPDF extends TCPDF
{
    private $logo1Path = 'images/logo1.png';
    private $logo2Path = 'images/rtnts.png';
    private $footerHTML = '';

    public function Header()
    {
        $this->SetFillColor(255, 255, 255);
        $this->Rect(0, 0, $this->getPageWidth(), 30, 'F');

        if (file_exists($this->logo1Path)) {
            $this->Image($this->logo1Path, 15, 7, 25, '', 'PNG');
        }

        if (file_exists($this->logo2Path)) {
            $this->Image($this->logo2Path, 255, 7, 25, '', 'PNG');
        }

        $this->SetFont('century gothic', 'B', 22);
        $this->SetTextColor(0, 51, 102);
        $this->SetXY(12, 12);
        $this->Cell(0, 0, 'DAILY CHECKS KPI', 0, 1, 'C');

        $this->SetLineWidth(0.5);
        $this->SetDrawColor(0, 102, 204);
        $this->Line(15, 28, 280, 28);
    }

    public function Footer()
    {
        $this->SetY(-28);
        $this->SetFont('courier', '', 10);
        $this->SetTextColor(0, 0, 0);

        if (!empty($this->footerHTML)) {
            $this->SetY(-25);
            $this->writeHTML($this->footerHTML, true, false, true, false, '');
        } else {
            $this->Cell(0, 25, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 0, 'C');
        }
    }

    public function setFooterHTML($html)
    {
        $this->footerHTML = $html;
    }
}

$pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator('Your Company');
$pdf->SetAuthor('Record');
$pdf->SetTitle('Daily Record');
$pdf->SetSubject('Daily Record');
$pdf->SetKeywords('Daily Record');
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(15, 30, 15);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(20);
$pdf->SetAutoPageBreak(TRUE, 25);

$names = [];
$showClosing = [];

if (isset($_GET['sid']) && !empty($_GET['sid'])) {
    $sid = $_GET['sid'];

    $sq1 = mysqli_query($con, "SELECT * FROM dailychecks WHERE id ='$sid'");
} elseif (isset($_GET['spid']) && !empty($_GET['spid'])) {
    $spid = $_GET['spid'];
    $sq1 = mysqli_query($con, "SELECT * FROM dailychecks WHERE sid ='$spid' and status !='first'");
}
while ($roww = mysqli_fetch_array($sq1)) {
    $names[] = $roww;
    $showClosing[$roww['id']] = strtolower($roww['close']) === 'yes';
}

$chunkSize = 5;
$nameChunks = array_chunk($names, $chunkSize);

foreach ($nameChunks as $nameGroup) {
    $html = '<h2 style="text-align:center; font-family:century gothic;">Daily Checks Report of (' . $name . ') from ' . $formattedFromDate . ' to ' . $formattedToDate . '</h2>';
    $html .= '<table border="1" cellpadding="4" cellspacing="0" width="100%" style="font-size:11px; text-align:center; font-family:century gothic;">';

    // Table headers
    $html .= '<thead><tr style="background-color:#f2f2f2;"><th><b>Date</b></th>';
    foreach ($nameGroup as $roww) {
        $colspan = $showClosing[$roww['id']] ? 3 : 2;
        $html .= '<th colspan="' . $colspan . '"><b>' . $roww['name'] . '</b></th>';
    }
    $html .= '</tr><tr style="background-color:#f9f9f9;"><th></th>';
    foreach ($nameGroup as $roww) {
        $html .= '<th><b>Startup Checks</b></th><th><b>Verified by</b></th>';
        if ($showClosing[$roww['id']]) {
            $html .= '<th><b>Closing Checks</b></th>';
        }
    }
    $html .= '</tr></thead><tbody>';

    // Table rows
    foreach ($dateRange as $date) {
        $html .= '<tr><td>' . date('d-m-Y', strtotime($date)) . '</td>';
        foreach ($nameGroup as $roww) {
            $checkDate = mysqli_query($con, "SELECT * FROM dailycheckss WHERE name = '" . $roww['id'] . "' AND date = '$date'");
            if (mysqli_num_rows($checkDate) > 0) {
                $checkRow = mysqli_fetch_assoc($checkDate);
                $startup = !empty($checkRow['user']) ? '<font color="green">' . $checkRow['user'] . '</font>' : '<font color="red">Not Checked</font>';
                $startupVerified = !empty($checkRow['verifyby']) ? '<font color="green">Verified</font>' : '<font color="red">Not Verified</font>';
                $closing = !empty($checkRow['name1']) ? '<font color="green">Checked</font>' : '<font color="red">Not Checked</font>';
            } else {
                $startup = '<font color="red">Not Checked</font>';
                $startupVerified = '<font color="red">Not Verified</font>';
                $closing = '<font color="red">Not Checked</font>';
            }

            $html .= '<td>' . $startup . '</td><td>' . $startupVerified . '</td>';
            if ($showClosing[$roww['id']]) {
                $html .= '<td>' . $closing . '</td>';
            }
        }
        $html .= '</tr>';
    }

    $html .= '</tbody></table>';

    $pdf->AddPage();
    $pdf->writeHTML($html, true, false, true, false, '');
}

$filenameFrom = str_replace('/', '-', $formattedFromDate);
$filenameTo = str_replace('/', '-', $formattedToDate);
$pdfPath = $_SERVER['DOCUMENT_ROOT'] . "upl1/daily_checks_report" . $filenameFrom . "_" . $filenameTo . ".pdf";
$pdf->Output($pdfPath, "F");
?>

<iframe src="upl1/daily_checks_report<?php echo $filenameFrom . '_' . $filenameTo; ?>.pdf" frameborder="0" width="100%" height="600px"></iframe>