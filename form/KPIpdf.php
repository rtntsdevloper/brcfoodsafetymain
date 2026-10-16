<?php

include('connection.php');


require('tcpdf/tcpdf.php');




if (isset($_POST['search'])) {



    $yearnow = $_POST['syear'];

    $monthn = $_POST['smonth'] . "-" . $yearnow;
    $monthnows = date("F - Y", strtotime($monthn));
    $monthfile = date("Y-m", strtotime($monthn));
    //    echo $monthnow;

} else {
    $yearnow = date('Y', strtotime('last month'));
    $monthnows = date('F - Y', strtotime('first day of last month'));
    $monthfile = date("Y-m", strtotime('first day of last month'));
}


$date1 = $yearnow . "-01-01";
$date2 = $yearnow . "-12-31";

$daten = date('Y');
$daten1 = date('Y', strtotime('last year'));
$daten2 = date('Y', strtotime('next year'));

$datenx = date('m-Y');

if ($datenx >= "09-" . $daten) {
    $datem = $daten . "-09-01";
    $datem1 = $daten2 . "-03-01";
} else {
    $datem = $daten1 . "-09-01";
    $datem1 = $daten . "-03-01";
}



class MYPDF extends TCPDF
{
    private $logo1Path = 'images/1.png';
    private $logo2Path = 'images/rtnts.png';
    private $footerHTML = '';
    private $longTableFooter = '';

    public function Header()
    {
        $img_file = 'images/bgpdf.jpg';
        // Get page width and height
        $page_width = $this->getPageWidth() + 100;
        $page_height = $this->getPageHeight() + 20;
        // Set the background image
        $this->Image($img_file, 0, 0, $page_width, $page_height, '', '', '', false, 300, '', false, false, 0);

        // $img_file = 'images/bgpdf.jpg';
        // // Get page width and height
        // 

        // $this->Image($img_file, 0, 0, $page_width, $page_height, '', '', 'C', false, 300, '', false, false, 0);


        $this->SetFillColor(255,255,255);
        $this->Rect(0, 0, $this->getPageWidth(), 25, 'F');
        if (file_exists($this->logo1Path)) {
            $this->Image($this->logo1Path, 15, 5, 28, '18', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }
        if (file_exists($this->logo2Path)) {
            $this->Image($this->logo2Path, 260, 5, 28, '18', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }

        // Title
        $this->AddFont('centurygothic', '', 'centurygothic.php');
        $this->SetFont('centurygothic', 'B',24);
        
        $this->SettextColor(0, 51, 102);
        $monthText = date("F - Y", strtotime('last month')); // or pass $monthnows from outside
        $this->SetXY(16, 8);
        $this->Cell(0, 10,  "Monthly KPI's " . $monthText. " ", 0, 1, 'C'); 
    }


    public function Footer()
    {

        $this->SetFillColor(255,255,255); // Light 
        // Draw a filled rectangle for the footer
        $this->Rect(0, $this->getPageHeight() - 25, $this->getPageWidth(), 25, 'F');

        $this->SetFont('centurygothic', '', 12);
        $this->SetTextColor(0, 51, 102);
        $this->SetXY(20, -20);
        $this->writeHTML($this->longTableFooter);
    }

    public function setLongTableFooter($html)
    {
        $this->longTableFooter = $html;
    }
}

// Create PDF in LANDSCAPE orientation
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);

$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->SetMargins(0, 0, 0);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);


$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);


$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
    $pdf->setLanguageArray($l);
}


$pdf->AddPage('L', 'A4');



///////////////////////////////////////// Page 1 ///////////////////////////////////////////////////////////////



$pdf->setY(51);
$pdf->SetFont('centurygothic', 'B', 50);
$pdf->SetTextColor(0, 51, 102);
$pdf->Write(0, "MONTHLY KPI's", '', 0, 'C', true, 0, false, false, 0);

$pdf->setY(75);
$pdf->SetFont('centurygothic', 'B', 50);
$pdf->SetTextColor(0, 51, 102);
$pdf->Write(0, $monthnows, '', 0, 'C', true, 0, false, false, 0);

$p = mysqli_query($con, "SELECT * FROM `tblportal` ");
$portal = mysqli_fetch_array($p);

$pdf->setY(105);

$pdf->SetFont('centurygothic', 'B', 60);
$pdf->SetTextColor(0, 51, 102);
$pdf->Write(0, $portal['name'], '', 0, 'C', true, 0, false, false, 0);


$pdf->setY(180);
$f = mysqli_query($con, "SELECT * FROM `tblformcontrol` where tabname='KPI' ");
$f1 = mysqli_fetch_array($f);

$issuedate = date("d-m-Y", strtotime($f1['issuedate']));
$pdf->SetFont('centurygothic', 'B', 12);
$pdf->SetTextColor(0, 51, 102);
$html = '
<style>
  th {
    font-weight: bold;
    padding: 6px;
  }
  .right {
    text-align: right;
  }
  .left {
    text-align: left;
  }
</style>

<table cellpadding="6" width="100%"  >
  <tr>
    <th >Issue date: ' . $issuedate . '</th>
    <th align="center">Version : ' . $f1['version'] . '</th>
    <th>Author: ' . $f1['author'] . '</th>
  </tr>

  <tr>
  <th >Reason for change: ' . $f1['reason'] . '</th>
    <th></th>

  <th>Authorised by: ' . $f1['authoriesby'] . '</th>
</tr>

</table>
';


$pdf->setLongTableFooter($html);



////////////////////////////////////////////////// Page 2 //////////////////////////////////////////////////////

$pdf->AddPage();


$pdf->setY(28);
$pdf->SetFont('centurygothic', 'B', 22);
$pdf->SetTextColor(0, 51, 102);
$pdf->Write(0, 'Management Review Meeting', '', 0, 'C', true, 0, false, false, 0);

$pdf->setXY(6, 40);
$pdf->SetFont('centurygothic', 'B', 14);
$pdf->SetTextColor(0, 0, 102);

$tableHTML = "";
$tableHTML .= '<style>
    table {
        border-collapse: collapse;
        border-spacing: 0;
        margin: 0;
        border: 0.5px solid #201e1eff;
        width: 98%;
        background-color: #fff;
        color: #2980b9;


    }
    tr {
        padding: 1px 0; 
    }

    .section-header {
        background: linear-gradient(to right, #3498db, #2980b9);
        color: white;
        font-weight: bold;
        text-align: center;
        font-size: 12px;
    }
    .question-row td {
        padding: 4px;
        vertical-align: top;
    }
</style>
<table cellpadding="8" border="1" style="text-align:center;">
    <thead>
            <tr>
            <th style="text-align:left;">Month</th>
            <th>Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>';


for ($i = 1; $i <= 12; $i++) {
 $month = date('F', strtotime("$yearnow-$i-01"));
    $month1 = date('Y-m', strtotime("$yearnow-$i-01"));
    $meetdata = mysqli_query($con, "SELECT *
FROM tbl_meeting
WHERE DATE_FORMAT(mdate, '%Y-%m') = '$month1'; ");
    $meetdata1 = mysqli_fetch_array($meetdata);

    if (!empty($meetdata1['mdate'])) {
        $date = date("d-M-Y", strtotime($meetdata1['mdate']));
    } else {
        $date = "";
    }


    $meetn = mysqli_num_rows($meetdata);
    if ($meetn > 0) {
        $tableHTML .= '<tr nobr="true">
            <td style="text-align:left;">' . $month . '</td>
            <td>' . $date . '</td>
            <td>Conducted</td>
            <td>Completed</td>
        </tr>';
    } else {
        $tableHTML .= '<tr nobr="true">
            <td style="text-align:left;">' . $month . '</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>';
    }
}

$tableHTML .= ' </tbody>
                </table> ';

$pdf->writeHTML($tableHTML, true, false, true, false, '');



////////////////////////////////////////////// Page 3 ////////////////////////////////////////////////////////////

$pdf->AddPage();

$pdf->setY(30);
$pdf->SetFont('centurygothic', 'B', 22);
$pdf->SetTextColor(0, 51, 102);
$pdf->Write(0, 'Internal Audit Status ', '', 0, 'C', true, 0, false, false, 0);

$query = "SELECT DATE_FORMAT(date, '%Y-%m') as month, 
                 SUM(status = 'done') as done, 
                 SUM(status = 'due') as due, 
                 SUM(status = 'In Progress') as inprogress
          FROM `tblroster` 
          WHERE YEAR(date) = '$yearnow' 
          GROUP BY DATE_FORMAT(date, '%Y-%m')
          ORDER BY month";
$result = mysqli_query($con, $query);

// Prepare data with all months
$monthlyData = [];
for ($m = 1; $m <= 12; $m++) {
    $monthKey = date('Y-m', strtotime("$yearnow-$m-01"));
    $monthlyData[$monthKey] = ['done' => 0, 'due' => 0, 'inprogress' => 0];
}

// Overwrite with actual data
while ($row = mysqli_fetch_array($result)) {
    $monthlyData[$row['month']] = [
        'done' => (int) $row['done'],
        'due' => (int) $row['due'],
        'inprogress' => (int) $row['inprogress']
    ];
}

// Totals
$totalDone = 0;
$totalDue = 0;
$totalInProgress = 0;
foreach ($monthlyData as $monthKey => $data) {
    $totalDone += $data['done'];
    $totalDue += $data['due'];
    $totalInProgress += $data['inprogress'];
}

// Chart dimensions
$x = 20;
$y = 55;
$width = 250;
$height = 100;
$barWidth = 2;
$barSpacing = 7;

// Dynamic Y-axis range
$maxCount = 0;
foreach ($monthlyData as $data) {
    $monthMax = max($data['done'], $data['due'], $data['inprogress']);
    if ($monthMax > $maxCount) {
        $maxCount = $monthMax;
    }
}

// Add buffer (10%) and minimum range
$maxCount = ceil($maxCount * 1.1);
if ($maxCount < 28) {
    $maxCount = 28;
}

// Decide number of steps (grid lines)
$steps = 7;
$yLabelStep = $height / $steps;
$stepValue = ceil($maxCount / $steps);

// Draw chart background
$pdf->Rect($x, $y, $width, $height, 'D');

// Draw Y-axis grid and labels
for ($i = 0; $i <= $steps; $i++) {
    $countValue = $i * $stepValue;
    $yLabelPos = $y + $height - ($i * $yLabelStep);

    $pdf->SetLineStyle(['width' => 0.2, 'color' => [128, 128, 128]]);
    $pdf->Line($x, $yLabelPos, $x + $width, $yLabelPos);

    $pdf->SetFont('centurygothic', 'B', 9);
    $pdf->Text($x - 8, $yLabelPos - 2, $countValue);
}

// Draw bars
$currentX = $x + 20;
foreach ($monthlyData as $month => $data) {
    $doneHeight = ($data['done'] / $maxCount) * $height;
    $dueHeight = ($data['due'] / $maxCount) * $height;
    $inprogressHeight = ($data['inprogress'] / $maxCount) * $height;

    // Done (green)
    $pdf->SetFillColor(0, 128, 0);
    $pdf->Rect($currentX, $y + $height - $doneHeight, $barWidth, $doneHeight, 'F');
    $pdf->SetFont('centurygothic', 'B', 9);
    $pdf->Text($currentX - 1, $y + $height - $doneHeight - 5, $data['done']);

    // Due (blue)
    $pdf->SetFillColor(0, 0, 255);
    $pdf->Rect($currentX + $barWidth + 1, $y + $height - $dueHeight, $barWidth, $dueHeight, 'F');
    $pdf->Text($currentX + $barWidth, $y + $height - $dueHeight - 5, $data['due']);

    // In Progress (orange)
    $pdf->SetFillColor(255, 165, 0);
    $pdf->Rect($currentX + ($barWidth * 2) + 2, $y + $height - $inprogressHeight, $barWidth, $inprogressHeight, 'F');
    $pdf->Text($currentX + ($barWidth * 2) + 1, $y + $height - $inprogressHeight - 5, $data['inprogress']);

    // Month label
    $pdf->SetFont('centurygothic', '', 9);
    $monthLabel = date('F', strtotime($month));
    $pdf->Text($currentX - 3, $y + $height + 3, $monthLabel);

    $currentX += 4 * ($barWidth + 1) + $barSpacing;
}

// Legend
$pdf->SetFont('centurygothic', 'B', 9);

// Done
$pdf->SetFillColor(0, 128, 0);
$pdf->Rect($x + 60, 170, 5, 5, 'F');
$pdf->Text($x + 67, 171, 'Done : ' . $totalDone);

// Due
$pdf->SetFillColor(0, 0, 255);
$pdf->Rect($x + 110, 170, 5, 5, 'F');
$pdf->Text($x + 117, 171, 'Due : ' . $totalDue);

// In Progress
$pdf->SetFillColor(255, 165, 0);
$pdf->Rect($x + 160, 170, 5, 5, 'F');
$pdf->Text($x + 167, 171, 'In Progress : ' . $totalInProgress);



//////////////////////////////////////////////// Page 4 //////////////////////////////////////////////////////

$pdf->AddPage();
$pdf->setY(28);
$pdf->SetFont('centurygothic', 'B', 22);
$pdf->SetTextColor(0, 51, 102);
$pdf->Write(0, ' Internal Audit Non-Conformance', '', 0, 'C', true, 0, false, false, 0);

// Step 1: Create full month list
$fullMonths = array();
$fullMonthCloseoff = array(); // Initialize closeoff data array
for ($m = 1; $m <= 12; $m++) {
    $monthKey = date('Y-m', strtotime("$yearnow-$m-01"));
    $fullMonths[$monthKey] = array('Minor' => 0, 'Major' => 0);
    $fullMonthCloseoff[$monthKey] = array('Minor' => 0, 'Major' => 0); // Initialize closeoff data
}

// Step 2: Fetch data
$query1 = "SELECT DATE_FORMAT(s2.date, '%Y-%m') as month, 
                  SUM(s1.ans = 'Minor') as Minor, 
                  SUM(s1.ans = 'Major') as Major
           FROM `saveaudit` as s1 join tblroster as s2 on s1.sno = s2.id
           WHERE YEAR(s2.date) = '$yearnow'
           GROUP BY DATE_FORMAT(s2.date, '%Y-%m')
           ORDER BY month";

$result1 = mysqli_query($con, $query1);

// Step 2: Fetch closeoff data
$queryx1 = "SELECT DATE_FORMAT(s2.date, '%Y-%m') as month, 
                  SUM(s1.ans = 'Minor') as Minor, 
                  SUM(s1.ans = 'Major') as Major
           FROM `saveaudit` as s1 join tblroster as s2 on s1.sno = s2.id
           WHERE YEAR(s2.date) = '$yearnow' and s1.status='Accepted'
           GROUP BY DATE_FORMAT(s2.date, '%Y-%m')
           ORDER BY month
           ";


$resultx1 = mysqli_query($con, $queryx1);

// Step 3: Merge results into full month list
$maxCount = 0;
$totalMinor = 0;
$totalMajor = 0;

while ($row1 = mysqli_fetch_array($result1)) {
    $month = $row1['month'];
    $fullMonths[$month]['Minor'] = $row1['Minor'];
    $fullMonths[$month]['Major'] = $row1['Major'];
    $maxCount = max($maxCount, $row1['Minor'], $row1['Major']);
    $totalMinor += $row1['Minor'];
    $totalMajor += $row1['Major'];
}

$totalMinorCloseoff = 0;
$totalMajorCloseoff = 0;
while ($rowx1 = mysqli_fetch_array($resultx1)) {
    $monthx = $rowx1['month'];
    $fullMonthCloseoff[$monthx]['Minor'] = $rowx1['Minor'];
    $fullMonthCloseoff[$monthx]['Major'] = $rowx1['Major'];

    $totalMinorCloseoff += $rowx1['Minor'];
    $totalMajorCloseoff += $rowx1['Major'];
}

if ($maxCount <= 30) {
    $maxCount = 30;
} else {
    $maxCount = $maxCount;
}
// Step 4: Chart setup
$x = 20;
$y = 60;
$width = 250;
$height = 90;   // slightly reduced so chart + legend fit on one page
$barWidth = 2;
$barSpacing = 12;

// Chart background
$pdf->Rect($x, $y, $width, $height, 'D', array(), array(200, 200, 200));

// Y-axis
$yLabelStep = $height / 10;
$labelInterval = ceil($maxCount / 10);

for ($i = 0; $i <= 10; $i++) {
    $countValue = $i * $labelInterval;
    $yLabelPos = $y + $height - ($i * $yLabelStep);

    $pdf->SetLineStyle(array('width' => 0.2, 'color' => array(128, 128, 128)));
    $pdf->Line($x, $yLabelPos, $x + $width, $yLabelPos);

    $pdf->SetFont('centurygothic', 'B', 9);
    $pdf->Text($x - 8, $yLabelPos - 2, $countValue);
}

// Draw bars and month names
$barX = $x + 10;
foreach ($fullMonths as $monthKey => $data) {
    // Get closeoff data
    $minorCloseoff = $fullMonthCloseoff[$monthKey]['Minor'];
    $majorCloseoff = $fullMonthCloseoff[$monthKey]['Major'];

    // Calculate bar heights
    $minorHeight = ($data['Minor'] / $maxCount) * $height;
    $majorHeight = ($data['Major'] / $maxCount) * $height;
    $minorHeightCloseoff = ($minorCloseoff / $maxCount) * $height;
    $majorHeightCloseoff = ($majorCloseoff / $maxCount) * $height;

    // Minor bars
    $minorBarX = $barX;
    $minorCloseoffBarX = $minorBarX + $barWidth + 2;

    // Minor - Total (Orange)
    $pdf->SetFillColor(255, 165, 0);
    $pdf->Rect($minorBarX, $y + $height - $minorHeight, $barWidth, $minorHeight, 'F');

    // Minor - Closeoff (Dark Green)
    $pdf->SetFillColor(0, 128, 0);
    $pdf->Rect($minorCloseoffBarX, $y + $height - $minorHeightCloseoff, $barWidth, $minorHeightCloseoff, 'F');

    // Major bars (positioned after Minor group with spacing)
    $majorBarX = $minorCloseoffBarX + $barWidth + $groupSpacing;
    $majorCloseoffBarX = $majorBarX + $barWidth + 2;

    // Major - Total (Red)
    $pdf->SetFillColor(255, 0, 0);
    $pdf->Rect($majorBarX, $y + $height - $majorHeight, $barWidth, $majorHeight, 'F');

    // Major - Closeoff (Blue for distinction)
    $pdf->SetFillColor(0, 0, 255);
    $pdf->Rect($majorCloseoffBarX, $y + $height - $majorHeightCloseoff, $barWidth, $majorHeightCloseoff, 'F');

    // Display count values above bars
    $pdf->SetFont('centurygothic', 'B', 8);
    $pdf->setTextColor(0, 51, 102);

    if ($data['Minor'] > 0) {
        $pdf->Text($minorBarX - 1, $y + $height - $minorHeight - 5, $data['Minor']);
    }

    if ($minorCloseoff > 0) {
        $pdf->Text($minorCloseoffBarX - 1, $y + $height - $minorHeightCloseoff - 5, $minorCloseoff);
    }

    if ($data['Major'] > 0) {
        $pdf->Text($majorBarX - 1, $y + $height - $majorHeight - 5, $data['Major']);
    }

    if ($majorCloseoff > 0) {
        $pdf->Text($majorCloseoffBarX - 1, $y + $height - $majorHeightCloseoff - 5, $majorCloseoff);
    }

    // Month label (shortened for better fit)
    $monthName = DateTime::createFromFormat('Y-m', $monthKey)->format('F');
    $pdf->SetFont('centurygothic', '', 8);
    $pdf->Text($barX - 2, $y + $height + 4, $monthName);

    // Move to next month group
    $barX += ($barWidth * 4) + $barSpacing + $groupSpacing;
}
// Title and legend
$pdf->SetFont('centurygothic', 'B', 9);

// Minor group
$pdf->SetFillColor(255, 165, 0);
$pdf->Rect($x + 60, $y + $height + 15, 4, 4, 'F');
$pdf->Text($x + 66, $y + $height + 15, 'Minor : ' . $totalMinor);

$pdf->SetFillColor(0, 128, 0);
$pdf->Rect($x + 60, $y + $height + 22, 4, 4, 'F');
$pdf->Text($x + 66, $y + $height + 22, 'Minor Closeoff: ' . $totalMinorCloseoff);

// Major group
$pdf->SetFillColor(255, 0, 0);
$pdf->Rect($x + 148, $y + $height + 15, 4, 4, 'F');
$pdf->Text($x + 156, $y + $height + 15, 'Major : ' . $totalMajor);

$pdf->SetFillColor(0, 128, 0);
$pdf->Rect($x + 148, $y + $height + 22, 4, 4, 'F');
$pdf->Text($x + 156, $y + $height + 22, 'Major Closeoff : ' . $totalMajorCloseoff);



/////////////////////////////////////////////////////// Page 5 /////////////////////////////////////////////////

$pdf->AddPage();

$pdf->setY(28);
$pdf->SetFont('centurygothic', 'B', 22);
$pdf->SetTextColor(0, 51, 102);
$pdf->Write(0, 'Food Safety Culture Questionaires ', '', 0, 'C', true, 0, false, false, 0);

// Table food safety questionaries
$pdf->setXY(9, 50);
$pdf->SetFont('centurygothic', 'B', 12);
$pdf->SetTextColor(0, 0, 102);


$tableHTML5 = "";
$tableHTML5 .= '<style>
    table {
        border-collapse: collapse;
        border-spacing: 0;
        margin: 0;
        width: 60%;
        color: #2980b9;
        border:2px solid white;
        background-color:white;
    }
        th{
        font-size:15px;
        font-weight:bold;
        }
       
        td{
        font-size:14px;
        }
        
</style>

<table cellpadding="5" border="1" width="100%" align="center">
    <thead>
            <tr>
            <th width="20%">Selection</th>
            <th width="13%">Score Per Question</th>
            <th width="20%">Allocated Total Score of Questionnaire</th>
            <th width="22%">Total staff completed Questionnaire</th>
            <th width="22%">Score received as per completed</th>
        </tr>
        
    </thead>
    <tbody>';

$sq = mysqli_query($con, "select distinct name  from competency3  where (cdate BETWEEN '$datem' and '$datem1')  GROUP by name,qid");
$row = mysqli_fetch_array($sq);
$totalstudent = mysqli_num_rows($sq);

$sql = mysqli_query($con, "select distinct correct  from competency");
$datacompchart = array();
$datacompchartl = array();
$datacompchartt = array();
foreach ($sql as $que) {
    $query = mysqli_query($con, "select * from competency where correct='$que[correct]'");
    $query1 = mysqli_num_rows($query) * 5;


    $sql1 = mysqli_query($con, "select * from competency3 where correct='$que[correct]' and status=1 and (cdate BETWEEN '$datem' and '$datem1')  GROUP by name,qid");
    $sql2 = mysqli_num_rows($sql1);



    $match7 = $sql2 * 5;

    $datacompchart[$que['correct']] = $match7; //result

    $totalpx = $query1 * $totalstudent;  //total marks
    $totalpxleft = $totalpx - $match7; //difference

    $datacompchartl[$que['correct']] = $totalpxleft;

    $datacompchartt[$que['correct']] = $totalpx;


    $tableHTML5 .= ' <tr >
              <td width="20%">' . $que['correct'] . '</td>
              <td width="13%">5</td>
              <td width="20%">' . $query1 . '</td>
              <td width="22%">' . $totalstudent . '</td>
              <td width="22%">' . $match7 . '</td>
              </tr>';
}

$tableHTML5 .= '</tbody>
                </table>';


$pdf->writeHTML($tableHTML5, true, false, true, false, '');



//pie chart

$pdf->SetXY(400, 447);
$pci = 0;

foreach ($datacompchart as $key => $value) {
    $green = $value;
    $red = $datacompchartl[$key];
    $total = $datacompchartt[$key];

    $margin = 80;              // set margin between charts (pixels)
    $nextloc = $pci * $margin; // use margin instead of fixed 50
    $xc = 70 + $nextloc;       // move horizontally
    $yc = 130;                  // keep constant vertical position
    $r = 25;


    $blue_angle = ($red / $total) * 360;
    $green_angle = ($green / $total) * 360;

    $pdf->SetFont('centurygothic', '', 8);

    // Write text


    $pdf->SetFillColor(255, 0, 0);
    $pdf->PieSector($xc, $yc, $r, 0, $blue_angle, 'FD', true, 0, 2);

    $pdf->SetFillColor(0, 183, 73);
    $pdf->PieSector($xc, $yc, $r, 0, $green_angle, 'FD', false, 0, 2);
    $pdf->SetTextColor(0, 0, 0); // Set text color (black)
    $pdf->SetFont('centurygothic', 'B', 10); // Set font and size


    $pdf->setTextColor(0, 51, 102);
    $pdf->Text($xc - 14, $yc + 30, $key); // chart heading


    // Dark Blue: (0, 51, 102)

    // Red: (255, 0, 0)

    // Green: (0, 128, 0)

    // Blue: (0, 0, 255)

    // Black: (0, 0, 0)

    // White: (255, 255, 255)

    // Write text at center of pie

    $pdf->setTextColor(0, 128, 0);
    $label = "Satisfactory: $green";        // Example label
    $pdf->Text($xc - 12, $yc + 40, $label);   // label below chart


    $pdf->setTextColor(255, 0, 0);
    $label1 = "Unsatisfactory: $red";      // Example label
    $pdf->Text($xc - 12, $yc + 46, $label1);  // another label beside it

    $pci++;
}
////////////////////////////////////////////////////////////////////////////////////////////////////
 
// $pdf->AddPage();
 
// $pdf->setY(30);
// $pdf->SetFont('centurygothic', 'B', 22);
// $pdf->SetTextColor(0, 51, 102);
// $pdf->Write(0, ' Supervisor Meetings', '', 0, 'C', true, 0, false, false, 0);
 
// // Get last month and year separately
// $monthnow = date("M", strtotime("last month"));
// $yearnow = date("Y", strtotime("last month"));
// $currentYearLabel = date("F Y", strtotime("last month"));
 
// // Correct SQL query
// $sqls = mysqli_query($con, "SELECT * FROM `tbl_supervisor`
//     WHERE year = '$yearnow' AND month = '$monthnow' ");
 
// $data = mysqli_fetch_assoc($sqls);
// $pdf->setFillColor(0, 51, 102);
// $pdf->RoundedRect(200, 50, 70, 13, 3, '1111', 'F');
// $pdf->SetXY(215, 50);
// $pdf->SetFont('centurygothic', 'B', 16);
// $pdf->SetTextColor(255, 255, 255);
// $pdf->Cell(40, 13, 'Supervisor Meetings', 0, 0, 'C');
 
// // Target
// $pdf->setFillColor(0, 51, 102);
// $pdf->SetXY(168, 65);
// $pdf->SetFont('centurygothic', 'B', 16);
// $pdf->SetTextColor(0, 51, 102);
// $pdf->Cell(40, 13, $data['target'], 0, 0, 'C');
 
// $pdf->RoundedRect(170, 75, 35, 10, 3, '1111', 'F');
// $pdf->SetXY(170, 75);
// $pdf->SetFont('centurygothic', 'B', 12);
// $pdf->SetTextColor(255, 255, 255);
// $pdf->Cell(35, 10, 'Targeted', 0, 0, 'C');
 
// // Conducted
// $pdf->setFillColor(0, 51, 102);
// $pdf->SetXY(210, 65);
// $pdf->SetFont('centurygothic', 'B', 16);
// $pdf->SetTextColor(0, 51, 102);
// $pdf->Cell(40, 13, $data['conduct'], 0, 0, 'C');
 
// $pdf->RoundedRect(213, 75, 35, 10, 3, '1111', 'F');
// $pdf->SetXY(213, 75);
// $pdf->SetFont('centurygothic', 'B', 12);
// $pdf->SetTextColor(255, 255, 255);
// $pdf->Cell(35, 10, 'Conducted', 0, 0, 'C');
 
// // Not Conducted
// $pdf->setFillColor(0, 51, 102);
// $pdf->SetXY(252, 65);
// $pdf->SetFont('centurygothic', 'B', 16);
// $pdf->SetTextColor(0, 51, 102);
// $pdf->Cell(40, 13, $data['notconduct'], 0, 0, 'C');
 
// $pdf->RoundedRect(255, 75, 38, 10, 3, '1111', 'F');
// $pdf->SetXY(256, 75);
// $pdf->SetFont('centurygothic', 'B', 12);
// $pdf->SetTextColor(255, 255, 255);
// $pdf->Cell(35, 10, 'Not Conducted', 0, 0, 'C');
 
// // Chart dimensions
// $x = 20;
// $y = 100;
// $width = 130;
// $height = 70;
 
// // Bar settings
// $barWidth = 2;   // wider bars for visibility
// $barSpacing = 40; // spacing between bars
 
// // Extract values from database
// $target = (int) $data['target'];
// $conduct = (int) $data['conduct'];
// $notconduct = (int) $data['notconduct'];
 
// // Decide maximum Y value based on data (rounded up to nearest even)
// $yMax = max($target, $conduct, $notconduct);
// if ($yMax < 2)
//     $yMax = 2;
// if ($yMax % 2 !== 0)
//     $yMax++; // force even
 
// // Draw chart background
// $pdf->Rect($x, $y, $width, $height, 'D');
 
// // --- Y-axis labels: even numbers only ---
// $pdf->SetTextColor(0, 51, 102);
// $pdf->SetFont('centurygothic', 'B', 9);
 
// for ($tick = 0; $tick <= $yMax; $tick += 2) {
//     $yLabelPos = $y + $height - ($tick / $yMax) * $height;
 
//     // grid line
//     $pdf->SetLineStyle(['width' => 0.2, 'color' => [200, 200, 200]]);
//     $pdf->Line($x, $yLabelPos, $x + $width, $yLabelPos);
 
//     // label
//     $pdf->Text($x - 8, $yLabelPos - 2, $tick);
// }
 
// $pdf->SetFont('centurygothic', 'B', 9);
// $barHeight = ($target / $yMax) * $height;
// $pdf->SetFillColor(0, 0, 255);
// $pdf->Rect($x + 20, $y + $height - $barHeight, $barWidth, $barHeight, 'F');
// $pdf->Text($x + 16, $y + $height + 5, 'Target');
// $pdf->Text($x + 19, $y + $height - $barHeight - 5, $target);
 
// // Conducted (green)
// $barHeight = ($conduct / $yMax) * $height;
// $pdf->SetFillColor(0, 128, 0);
// $pdf->Rect($x + 20 + $barSpacing, $y + $height - $barHeight, $barWidth, $barHeight, 'F');
// $pdf->Text($x + 12 + $barSpacing, $y + $height + 5, 'Conducted');
// $pdf->Text($x + 19 + $barSpacing, $y + $height - $barHeight - 5, $conduct);
 
// // Not Conducted (orange)
// $barHeight = ($notconduct / $yMax) * $height;
// $pdf->SetFillColor(255, 165, 0);
// $pdf->Rect($x + 20 + 2 * $barSpacing, $y + $height - $barHeight, $barWidth, $barHeight, 'F');
// $pdf->Text($x + 12 + 2 * $barSpacing, $y + $height + 5, 'Not Conducted');
// $pdf->Text($x + 19 + 2 * $barSpacing, $y + $height - $barHeight - 5, $notconduct);
 
 
 
 
// //legend
 
// $pdf->setFillColor(0, 0, 255);
// $pdf->RoundedRect(200, 102, 50, 10, 3, '1111', 'F');
// $pdf->SetXY(207, 102);
// $pdf->SetFont('centurygothic', 'B', 12);
// $pdf->SetTextColor(255, 255, 255);
// $pdf->Cell(35, 10, 'Target', 0, 0, 'C');
 
// $pdf->setFillColor(0, 128, 0);
// $pdf->RoundedRect(200, 122, 50, 10, 3, '1111', 'F');
// $pdf->SetXY(208, 122);
// $pdf->SetFont('centurygothic', 'B', 12);
// $pdf->SetTextColor(255, 255, 255);
// $pdf->Cell(35, 10, 'Conducted', 0, 0, 'C');
 
// $pdf->setFillColor(255, 165, 0);
// $pdf->RoundedRect(200, 142, 50, 10, 3, '1111', 'F');
// $pdf->SetXY(207, 142);
// $pdf->SetFont('centurygothic', 'B', 12);
// $pdf->SetTextColor(255, 255, 255);
// $pdf->Cell(35, 10, 'Not Conducted', 0, 0, 'C');
 
 



/////////////////////////////////////////////// Page 7 /////////////////////////////////////////////////////

$pdf->AddPage();

$pdf->setY(30);
$pdf->SetFont('centurygothic', 'B', 22);
$pdf->SetTextColor(0, 51, 102);
$pdf->Write(0, 'HACCP Training', '', 0, 'C', true, 0, false, false, 0);

// Query results
$sqlh = mysqli_query($con, "SELECT * FROM tblstaff WHERE haccp = 'Yes' AND status = 'Active'");
$totalh = mysqli_num_rows($sqlh);

$doccurrent = date('Y-m-d');
$completeh = 0;

foreach ($sqlh as $sqdata) {
    $hcuserid = $sqdata['id'];
    $hcpcert = mysqli_query($con, "SELECT * FROM tblstaffcert 
                                   WHERE user = '$hcuserid' AND type = 'HACCP' 
                                   ORDER BY id DESC LIMIT 1");
    $hcpcert1 = mysqli_fetch_assoc($hcpcert);
    if ($hcpcert1 && $hcpcert1['certdate'] > $doccurrent) {
        $completeh++;
    }
}

$pendingh = $totalh - $completeh;

// Chart dimensions
$x = 20;
$y = 100;
$width = 130;
$height = 70;
$barWidth = 2;
$barSpacing = 40;

// Decide maximum Y value
$yMax = max($totalh, $completeh, $pendingh);
if ($yMax < 2)
    $yMax = 2;
if ($yMax % 2 !== 0)
    $yMax++;

// Draw chart background
$pdf->Rect($x, $y, $width, $height, 'D');

// Y-axis labels
$pdf->SetTextColor(0, 51, 102);
$pdf->SetFont('centurygothic', 'B', 9);
for ($tick = 0; $tick <= $yMax; $tick += 2) {
    $yLabelPos = $y + $height - ($tick / $yMax) * $height;
    $pdf->SetLineStyle(['width' => 0.2, 'color' => [200, 200, 200]]);
    $pdf->Line($x, $yLabelPos, $x + $width, $yLabelPos);
    $pdf->Text($x - 8, $yLabelPos - 2, $tick);
}

// --- Bars ---
// Total Staff (blue)
$barHeight = ($totalh / $yMax) * $height;
$pdf->SetFillColor(0, 0, 255);
$pdf->Rect($x + 20, $y + $height - $barHeight, $barWidth, $barHeight, 'F');
$pdf->Text($x + 15, $y + $height + 5, 'Total');
$pdf->Text($x + 19, $y + $height - $barHeight - 5, $totalh);

// Completed (green)
$barHeight = ($completeh / $yMax) * $height;
$pdf->SetFillColor(0, 128, 0);
$pdf->Rect($x + 20 + $barSpacing, $y + $height - $barHeight, $barWidth, $barHeight, 'F');
$pdf->Text($x + 15 + $barSpacing, $y + $height + 5, 'Completed');
$pdf->Text($x + 19 + $barSpacing, $y + $height - $barHeight - 5, $completeh);

// Pending (orange)
$barHeight = ($pendingh / $yMax) * $height;
$pdf->SetFillColor(255, 165, 0);
$pdf->Rect($x + 20 + 2 * $barSpacing, $y + $height - $barHeight, $barWidth, $barHeight, 'F');
$pdf->Text($x + 15 + 2 * $barSpacing, $y + $height + 5, 'Pending');
$pdf->Text($x + 19 + 2 * $barSpacing, $y + $height - $barHeight - 5, $pendingh);



$pdf->setFillColor(0, 51, 102);
$pdf->RoundedRect(200, 50, 35, 13, 3, '1111', 'F');
$pdf->SetXY(198, 50);
$pdf->SetFont('centurygothic', 'B', 16);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(40, 13, 'Status', 0, 0, 'C');


$pdf->setFillColor(0, 51, 102);
$pdf->SetXY(155, 64);
$pdf->SetFont('centurygothic', 'B', 16);
$pdf->SetTextColor(0, 51, 102);
$pdf->Cell(40, 13, $totalh, 0, 0, 'C');

$pdf->RoundedRect(155, 75, 35, 10, 3, '1111', 'F');
$pdf->SetXY(155, 75);
$pdf->SetFont('centurygothic', 'B', 12);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(35, 10, 'Total Staff', 0, 0, 'C');


$pdf->setFillColor(0, 51, 102);
$pdf->SetXY(202, 64);
$pdf->SetFont('centurygothic', 'B', 16);
$pdf->SetTextColor(0, 51, 102);
$pdf->Cell(40, 13, $completeh, 0, 0, 'C');

$pdf->RoundedRect(195, 75, 50, 10, 3, '1111', 'F');
$pdf->SetXY(202, 75);
$pdf->SetFont('centurygothic', 'B', 12);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(35, 10, 'Training Completed', 0, 0, 'C');


$pdf->setFillColor(0, 51, 102);
$pdf->SetXY(254, 64);
$pdf->SetFont('centurygothic', 'B', 16);
$pdf->SetTextColor(0, 51, 102);
$pdf->Cell(40, 13, $pendingh, 0, 0, 'C');

$pdf->RoundedRect(250, 75, 43, 10, 3, '1111', 'F');
$pdf->SetXY(254, 75);
$pdf->SetFont('centurygothic', 'B', 12);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(35, 10, 'Training Pending', 0, 0, 'C');




$pdf->setFillColor(0, 0, 255);
$pdf->RoundedRect(200, 112, 48, 12, 3, '1111', 'F');
$pdf->SetXY(207, 114);
$pdf->SetFont('centurygothic', 'B', 12);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(30, 8, 'Total Staff', 0, 0, 'C');

$pdf->setFillColor(0, 128, 0);
$pdf->RoundedRect(200, 132, 48, 12, 3, '1111', 'F');
$pdf->SetXY(207, 134);
$pdf->SetFont('centurygothic', 'B', 12);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(35, 8, 'Training Completed', 0, 0, 'C');

$pdf->setFillColor(255, 165, 0);
$pdf->RoundedRect(200, 152, 48, 12, 3, '1111', 'F');
$pdf->SetXY(207, 154);
$pdf->SetFont('centurygothic', 'B', 12);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(35, 8, 'Training Pending', 0, 0, 'C');









// //////////////////////////////////////////////////  Page 8 ////////////////////////////////////////////////////////////

$pdf->AddPage();

// Query //


$pdf->setY(30);
$pdf->SetFont('centurygothic', 'B', 22);
$pdf->SetTextColor(0, 51, 102);
$pdf->Write(0, 'Internal Auditor Training', '', 0, 'C', true, 0, false, false, 0);

$totalauditor = mysqli_query($con, "SELECT * from tblauditor where status='Active'");

$totalaud = mysqli_num_rows($totalauditor);

$staffa = mysqli_query($con, "SELECT COUNT(CASE WHEN status = 'Active' THEN 1 END) AS Training_Complete
    FROM tblauditor WHERE  expiredon > CURRENT_DATE");

$staffa1 = mysqli_fetch_array($staffa);

$staffaa = mysqli_query($con, "SELECT  
        COUNT(case WHEN status = 'Active' THEN 1 END) AS Training_Pending
    FROM tblauditor
    WHERE  expiredon < CURRENT_DATE");
$staffaa1 = mysqli_fetch_array($staffaa);

$pendinga = (int) $staffa1['Training_Complete'];
$completea = (int) $staffaa1['Training_Pending'];
$totala = $totalaud;

$pdf->setFillColor(0, 51, 102);
$pdf->RoundedRect(200, 45, 35, 13, 3, '1111', 'F');
$pdf->SetXY(198, 45);
$pdf->SetFont('centurygothic', 'B', 16);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(40, 13, 'Status', 0, 0, 'C');


$pdf->SetXY(155, 65);
$pdf->SetFont('centurygothic', 'B', 16);
$pdf->SetTextColor(0, 51, 102);
$pdf->Cell(35, 10, '' . $totala, 0, 0, 'C');

$pdf->setFillColor(0, 51, 102);
$pdf->RoundedRect(155, 74, 35, 10, 3, '1111', 'F');
$pdf->SetXY(155, 74);
$pdf->SetFont('centurygothic', 'B', 12);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(35, 10, 'Total Auditor', 0, 0, 'C');


$pdf->SetXY(200, 65);
$pdf->SetTextColor(0, 51, 102);
$pdf->SetFont('centurygothic', 'B', 16);
$pdf->Cell(35, 10, '' . $completea, 0, 0, 'C');

$pdf->setFillColor(0, 51, 102);
$pdf->RoundedRect(195, 74, 50, 10, 3, '1111', 'F');
$pdf->SetXY(202, 74);
$pdf->SetFont('centurygothic', 'B', 12);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(35, 10, 'Training Completed', 0, 0, 'C');

$pdf->SetXY(255, 65);
$pdf->SetTextColor(0, 51, 102);
$pdf->SetFont('centurygothic', 'B', 16);
$pdf->Cell(35, 10, '' . $pendinga, 0, 0, 'C');

$pdf->setFillColor(0, 51, 102);
$pdf->RoundedRect(250, 74, 43, 10, 3, '1111', 'F');
$pdf->SetXY(254, 74);
$pdf->SetFont('centurygothic', 'B', 12);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(35, 10, 'Training Pending', 0, 0, 'C');
// Chart dimensions
$x = 20;
$y = 95;
$width = 130;
$height = 70;

// Bar settings
$barWidth = 2; // wider bars for visibility
$gap = 30;

// Draw chart background
$pdf->Rect($x, $y, $width, $height, 'D');

// Determine max count for scaling
$maxCount = max($totala, $completea, $pendinga);
if ($maxCount <= 30) {
    $maxCount = 30;
}

// --- Y-axis labels dynamic based on maxCount ---
$pdf->SetTextColor(0, 51, 102);
$pdf->SetFont('centurygothic', 'B', 8);

$step = ceil($maxCount / 10); // divide into 10 steps
for ($tick = 0; $tick <= $maxCount; $tick += $step) {
    $yLabelPos = $y + $height - ($tick / $maxCount) * $height;

    // grid line
    $pdf->SetLineStyle(array('width' => 0.2, 'color' => array(128, 128, 128)));
    $pdf->Line($x, $yLabelPos, $x + $width, $yLabelPos);

    // label
    $pdf->Text($x - 8, $yLabelPos - 2, $tick);
}

// --- Bars --- //
$pdf->SetFont('centurygothic', 'B', 9);

// Training total (blue)
$barHeight = ($totala / $maxCount) * $height;
$pdf->SetFillColor(0, 0, 255);
$pdf->Rect($x + $gap, $y + $height - $barHeight, $barWidth, $barHeight, 'F');
$pdf->Text($x + $gap, $y + $height + 5, 'Total');
$pdf->Text($x + $gap - 1, $y + $height - $barHeight - 5, $totala);

// Training Completed (green)
$barHeight = ($completea / $maxCount) * $height;
$pdf->SetFillColor(0, 128, 0);
$pdf->Rect($x + $gap * 2, $y + $height - $barHeight, $barWidth, $barHeight, 'F');
$pdf->Text($x + $gap * 2, $y + $height + 5, 'Complete');
$pdf->Text($x + $gap * 2 - 1, $y + $height - $barHeight - 5, $completea);

// Training Pending (orange)
$barHeight = ($pendinga / $maxCount) * $height;
$pdf->SetFillColor(255, 165, 0);
$pdf->Rect($x + $gap * 3, $y + $height - $barHeight, $barWidth, $barHeight, 'F');
$pdf->Text($x + $gap * 3, $y + $height + 5, 'Pending');
$pdf->Text($x + $gap * 3 - 1, $y + $height - $barHeight - 5, $pendinga);




// Legend


$pdf->setFillColor(0, 0, 255);
$pdf->RoundedRect(200, 102, 50, 10, 3, '1111', 'F');
$pdf->SetXY(207, 102);
$pdf->SetFont('centurygothic', 'B', 12);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(35, 10, 'Total Auditor', 0, 0, 'C');

$pdf->setFillColor(0, 128, 0);
$pdf->RoundedRect(200, 122, 50, 10, 3, '1111', 'F');
$pdf->SetXY(208, 122);
$pdf->SetFont('centurygothic', 'B', 12);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(35, 10, 'Training Completed', 0, 0, 'C');

$pdf->setFillColor(255, 165, 0);
$pdf->RoundedRect(200, 142, 50, 10, 3, '1111', 'F');
$pdf->SetXY(207, 142);
$pdf->SetFont('centurygothic', 'B', 12);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(35, 10, ' Training Pending', 0, 0, 'C');


////////////////////////////////////////////////////// Page 9 ///////////////////////////////////////////////////

$pdf->AddPage();

$pdf->setY(30);
$pdf->SetFont('centurygothic', 'B', 22);
$pdf->SetTextColor(0, 51, 102);
$pdf->Write(0, 'Food Safety Level 2 Training', '', 0, 'C', true, 0, false, false, 0);


/// Query results
$sqlf = mysqli_query($con, "SELECT * FROM tblstaff WHERE lvl2 = 'Yes' AND status = 'Active'");
$totalf = mysqli_num_rows($sqlf);

$doccurrent = date('Y-m-d');
$completef = 0;

foreach ($sqlf as $sqldataf) {
    $fcuserid = $sqldataf['id']; // FIXED variable name
    $fcpcert = mysqli_query($con, "SELECT * FROM tblstaffcert 
                                   WHERE user = '$fcuserid' AND type = 'Level2' 
                                   ORDER BY id DESC LIMIT 1");
    $fcpcert1 = mysqli_fetch_assoc($fcpcert);
    if ($fcpcert1 && $fcpcert1['certdate'] > $doccurrent) { // FIXED variable name
        $completef++;
    }
}

$pendingf = $totalf - $completef;

// Chart dimensions
$x = 20;
$y = 100;
$width = 130;
$height = 70;
$barWidth = 2;   // wider bars
$barSpacing = 40; // spacing between bars

// Decide maximum Y value
$yMax = max($totalf, $completef, $pendingf);
if ($yMax < 2)
    $yMax = 2;
if ($yMax % 2 !== 0)
    $yMax++;

// Draw chart background
$pdf->Rect($x, $y, $width, $height, 'D');

// Y-axis labels
$pdf->SetTextColor(0, 51, 102);
$pdf->SetFont('centurygothic', 'B', 9);
for ($tick = 0; $tick <= $yMax; $tick += 2) {
    $yLabelPos = $y + $height - ($tick / $yMax) * $height;
    $pdf->SetLineStyle(['width' => 0.2, 'color' => [200, 200, 200]]);
    $pdf->Line($x, $yLabelPos, $x + $width, $yLabelPos);
    $pdf->Text($x - 8, $yLabelPos - 2, $tick);
}

// --- Bars ---
// Total Staff (blue)
$barHeight = ($totalf / $yMax) * $height;
$pdf->SetFillColor(0, 0, 255);
$pdf->Rect($x + 20, $y + $height - $barHeight, $barWidth, $barHeight, 'F');
$pdf->Text($x + 15, $y + $height + 5, 'Total');
$pdf->Text($x + 19, $y + $height - $barHeight - 5, $totalf);

// Completed (green)
$barHeight = ($completef / $yMax) * $height;
$pdf->SetFillColor(0, 128, 0);
$pdf->Rect($x + 20 + $barSpacing, $y + $height - $barHeight, $barWidth, $barHeight, 'F');
$pdf->Text($x + 15 + $barSpacing, $y + $height + 5, 'Completed');
$pdf->Text($x + 19 + $barSpacing, $y + $height - $barHeight - 5, $completef);

// Pending (orange)
$barHeight = ($pendingf / $yMax) * $height;
$pdf->SetFillColor(255, 165, 0);
$pdf->Rect($x + 20 + 2 * $barSpacing, $y + $height - $barHeight, $barWidth, $barHeight, 'F');
$pdf->Text($x + 15 + 2 * $barSpacing, $y + $height + 5, 'Pending');
$pdf->Text($x + 19 + 2 * $barSpacing, $y + $height - $barHeight - 5, $pendingf);




$pdf->setFillColor(0, 0, 255);
$pdf->RoundedRect(200, 112, 48, 12, 3, '1111', 'F');
$pdf->SetXY(207, 114);
$pdf->SetFont('centurygothic', 'B', 12);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(30, 8, 'Total Staff', 0, 0, 'C');

$pdf->setFillColor(0, 128, 0);
$pdf->RoundedRect(200, 132, 48, 12, 3, '1111', 'F');
$pdf->SetXY(207, 134);
$pdf->SetFont('centurygothic', 'B', 12);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(35, 8, 'Training Completed', 0, 0, 'C');

$pdf->setFillColor(255, 165, 0);
$pdf->RoundedRect(200, 152, 48, 12, 3, '1111', 'F');
$pdf->SetXY(207, 154);
$pdf->SetFont('centurygothic', 'B', 12);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(35, 8, 'Training Pending', 0, 0, 'C');







$pdf->setFillColor(0, 51, 102);
$pdf->RoundedRect(200, 50, 35, 13, 3, '1111', 'F');
$pdf->SetXY(198, 50);
$pdf->SetFont('centurygothic', 'B', 16);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(40, 13, 'Status', 0, 0, 'C');

$pdf->SetXY(155, 65);
$pdf->SetTextColor(0, 51, 102);
$pdf->Cell(35, 10, $totalf, 0, 0, 'C');

$pdf->setFillColor(0, 51, 102);
$pdf->RoundedRect(155, 75, 35, 10, 3, '1111', 'F');
$pdf->SetXY(155, 75);
$pdf->SetFont('centurygothic', 'B', 12);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(35, 10, 'Total Staff', 0, 0, 'C');


$pdf->SetXY(202, 65);
$pdf->SetTextColor(0, 51, 102);
$pdf->SetFont('centurygothic', 'B', 16);

$pdf->Cell(35, 10, $completef, 0, 0, 'C');

$pdf->SetTextColor(0, 51, 102);
$pdf->RoundedRect(195, 75, 50, 10, 3, '1111', 'F');
$pdf->SetXY(202, 75);
$pdf->SetFont('centurygothic', 'B', 12);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(35, 10, 'Training Completed', 0, 0, 'C');


$pdf->SetXY(254, 65);
$pdf->SetTextColor(0, 51, 102);
$pdf->SetFont('centurygothic', 'B', 16);

$pdf->Cell(35, 10, $pendingf, 0, 0, 'C');

$pdf->setFillColor(0, 51, 102);
$pdf->RoundedRect(250, 75, 43, 10, 3, '1111', 'F');
$pdf->SetXY(254, 75);
$pdf->SetFont('centurygothic', 'B', 12);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(35, 10, 'Training Pending', 0, 0, 'C');




///////////////////////////////////////////////// Page 10 /////////////////////////////////////////////////////

$pdf->AddPage();

$pdf->setY(30);
$pdf->SetFont('centurygothic', 'B', 22);
$pdf->SetTextColor(0, 51, 102);
$pdf->Write(0, 'Procedure Training', '', 0, 'C', true, 0, false, false, 0);

// Query results
$sqlp = mysqli_query($con, "SELECT * FROM tblstaff WHERE procedur='Yes' AND status='Active'");
$totalp = mysqli_num_rows($sqlp);

$doccurrent = date('Y-m-d');
$completep = 0;

while ($sqldatap = mysqli_fetch_assoc($sqlp)) {
    $pcuserid = $sqldatap['id'];
    $pcpcert = mysqli_query($con, "SELECT * FROM tblstaffcert 
        WHERE user = '$pcuserid' AND type = 'Procedure' 
        ORDER BY id DESC LIMIT 1");

    $pcpcert1 = mysqli_fetch_assoc($pcpcert);
    if ($pcpcert1 && $pcpcert1['certdate'] > $doccurrent) {
        $completep++;
    }
}

$pendingp = $totalp - $completep;


// Chart dimensions
$x = 20;
$y = 100;
$width = 130;
$height = 70;
$barWidth = 2;   // wider bars
$barSpacing = 40; // spacing between bars

// Decide maximum Y value
$yMax = max($totalp, $completep, $pendingp);
if ($yMax < 2)
    $yMax = 2;
if ($yMax % 2 !== 0)
    $yMax++;

// Draw chart background
$pdf->Rect($x, $y, $width, $height, 'D');

// Y-axis labels
$pdf->SetTextColor(0, 51, 102);
$pdf->SetFont('centurygothic', 'B', 9);
for ($tick = 0; $tick <= $yMax; $tick += 2) {
    $yLabelPos = $y + $height - ($tick / $yMax) * $height;
    $pdf->SetLineStyle(['width' => 0.2, 'color' => [200, 200, 200]]);
    $pdf->Line($x, $yLabelPos, $x + $width, $yLabelPos);
    $pdf->Text($x - 8, $yLabelPos - 2, $tick); // adjusted position
}

// --- Bars ---
// Total Staff (blue)
$barHeight = ($totalp / $yMax) * $height;
$pdf->SetFillColor(0, 0, 255);
$pdf->Rect($x + 20, $y + $height - $barHeight, $barWidth, $barHeight, 'F');
$pdf->Text($x + 15, $y + $height + 3, 'Total');
$pdf->Text($x + 19, $y + $height - $barHeight - 5, $totalp);

// Completed (green)
$barHeight = ($completep / $yMax) * $height;
$pdf->SetFillColor(0, 128, 0);
$pdf->Rect($x + 20 + $barSpacing, $y + $height - $barHeight, $barWidth, $barHeight, 'F');
$pdf->Text($x + 15 + $barSpacing, $y + $height + 3, 'Completed');
$pdf->Text($x + 19 + $barSpacing, $y + $height - $barHeight - 5, $completep);

// Pending (orange)
$barHeight = ($pendingp / $yMax) * $height;
$pdf->SetFillColor(255, 165, 0);
$pdf->Rect($x + 20 + 2 * $barSpacing, $y + $height - $barHeight, $barWidth, $barHeight, 'F');
$pdf->Text($x + 15 + 2 * $barSpacing, $y + $height + 3, 'Pending');
$pdf->Text($x + 19 + 2 * $barSpacing, $y + $height - $barHeight - 5, $pendingp);




$pdf->setFillColor(0, 51, 102);
$pdf->RoundedRect(200, 50, 35, 13, 3, '1111', 'F');
$pdf->SetXY(198, 50);
$pdf->SetFont('centurygothic', 'B', 16);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(40, 13, 'Status', 0, 0, 'C');

$pdf->setFillColor(0, 51, 102);
$pdf->RoundedRect(155, 75, 35, 10, 3, '1111', 'F');
$pdf->SetXY(155, 75);
$pdf->SetFont('centurygothic', 'B', 12);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(35, 10, 'Total Staff', 0, 0, 'C');

$pdf->SetFont('centurygothic', 'B', 16);
$pdf->setTextColor(0, 51, 102);
$pdf->SetXY(155, 65);
$pdf->Cell(35, 10, $totalp, 0, 0, 'C');


$pdf->setFillColor(0, 51, 102);
$pdf->RoundedRect(195, 75, 50, 10, 3, '1111', 'F');
$pdf->SetXY(202, 75);
$pdf->SetFont('centurygothic', 'B', 12);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(35, 10, 'Training Completed', 0, 0, 'C');
$pdf->SetFont('centurygothic', 'B', 16);
$pdf->setTextColor(0, 51, 102);
$pdf->SetXY(202, 65);
$pdf->Cell(35, 10, $completep, 0, 0, 'C');

$pdf->setFillColor(0, 51, 102);
$pdf->RoundedRect(250, 75, 43, 10, 3, '1111', 'F');
$pdf->SetXY(254, 75);
$pdf->SetFont('centurygothic', 'B', 12);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(35, 10, 'Training Pending', 0, 0, 'C');
$pdf->SetFont('centurygothic', 'B', 16);
$pdf->setTextColor(0, 51, 102);
$pdf->SetXY(254, 65);
$pdf->Cell(35, 10, $pendingp, 0, 0, 'C');


$pdf->setFillColor(0, 0, 255);
$pdf->RoundedRect(200, 112, 48, 12, 3, '1111', 'F');
$pdf->SetXY(207, 114);
$pdf->SetFont('centurygothic', 'B', 12);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(30, 8, 'Total Staff', 0, 0, 'C');

$pdf->setFillColor(0, 128, 0);
$pdf->RoundedRect(200, 132, 48, 12, 3, '1111', 'F');
$pdf->SetXY(207, 134);
$pdf->SetFont('centurygothic', 'B', 12);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(35, 8, 'Training Completed', 0, 0, 'C');

$pdf->setFillColor(255, 165, 0);
$pdf->RoundedRect(200, 152, 48, 12, 3, '1111', 'F');
$pdf->SetXY(207, 154);
$pdf->SetFont('centurygothic', 'B', 12);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(35, 8, 'Training Pending', 0, 0, 'C');





////////////////////////////////////////////// Page 11-16 //////////////////////////////////////////////////////////////

// $stvb = mysqli_query($con, 'select * from tbl_micortrend');

// foreach ($stvb as $stvbtrend) {

//     $swabname = $stvbtrend['name'];
//     $swabid = $stvbtrend['id'];

//     $pdf->AddPage();

//     $pdf->setY(30);
//     $pdf->SetFont('centurygothic', 'B', 22);
//     $pdf->SetTextColor(0, 51, 102);
//     $pdf->Write(0, 'Micro Trending', '', 0, 'C', true, 0, false, false, 0);

//     $pdf->setY(40);
//     $pdf->SetFont('centurygothic', 'B', 18);
//     $pdf->SetTextColor(0, 51, 102);
//     $pdf->Write(0, $swabname, '', 0, 'C', true, 0, false, false, 0);

//     $swabdata = [];
//     for ($i = 1; $i <= 12; $i++) {
//         if ($i < 10) {
//             $iy = "0" . $i;
//         } else {
//             $iy = $i;
//         }

//         $swabmonth = $yearnow . '-' . $iy;

//         $querye = mysqli_query($con, "SELECT t1.name,
//         SUM(CASE WHEN t3.status = 'Pass' THEN 1 ELSE 0 END) AS cpass,
//         SUM(CASE WHEN t3.status = 'Fail' THEN 1 ELSE 0 END) AS cfail
//         FROM tbl_micortrend AS t1 JOIN tbl_microtrending AS t2 ON t1.id = t2.mid
//         JOIN tbl_microtrending1 AS t3 ON t2.id = t3.eid
//         WHERE DATE_FORMAT(t3.sample, '%Y-%m') = '$swabmonth' and t1.id ='$swabid'
//         GROUP BY t1.name");

//         $querye1 = mysqli_fetch_array($querye);
//         if (isset($querye1['cpass']) && !empty($querye1['cpass'])) {
//             $envpass = $querye1['cpass'];
//         } else {
//             $envpass = 0;
//         }

//         if (isset($querye1['cfail']) && !empty($querye1['cfail'])) {
//             $envfail = $querye1['cfail'];
//         } else {
//             $envfail = 0;
//         }

//         $swabdata[] = [
//             'month' => $swabmonth,
//             'cpass' => $envpass,
//             'cfail' => $envfail
//         ];
//     }

//     $totalPass = 0;
//     $totalFail = 0;

//     // Merge totals across all months
//     foreach ($swabdata as $row) {
//         $totalPass += (int) $row['cpass'];
//         $totalFail += (int) $row['cfail'];
//         $maxCount = max($maxCount, $row['cpass'], $row['cfail']);
//     }
//     if ($maxCount <= 30) {
//         $maxCount = 30;
//     } else {
//         $maxCount = $maxCount;
//     }

//     $x = 20;
//     $y = 50;
//     $width = 250;
//     $height = 100;
//     $barWidth = 2;
//     $barSpacing = 12;

//     // Draw chart background
//     $pdf->Rect($x, $y, $width, $height, 'D');

//     // Draw Y-axis grid and labels dynamically
//     $steps = 10;
//     $yLabelStep = $height / $steps;
//     $valueStep = ceil($maxCount / $steps);

//     $pdf->SetFont('centurygothic', 'B', 9);
//     for ($i = 0; $i <= $steps; $i++) {
//         $countValue = $i * $valueStep;
//         $yLabelPos = $y + $height - ($i * $yLabelStep);

//         $pdf->SetLineStyle(['width' => 0.2, 'color' => [128, 128, 128]]);
//         $pdf->Line($x, $yLabelPos, $x + $width, $yLabelPos);

//         $pdf->Text($x - 8, $yLabelPos - 2, $countValue);
//     }

//     // Draw bars for each month 
//     $currentX = $x + 10;
//     $pdf->SetFont('centurygothic', 'B', 9);

//     foreach ($swabdata as $row) {
//         $cpassHeight = ($row['cpass'] / $maxCount) * $height;
//         $cfailHeight = ($row['cfail'] / $maxCount) * $height;

//         // Pass (green)
//         $pdf->SetFillColor(0, 128, 0);
//         $pdf->Rect($currentX, $y + $height - $cpassHeight, $barWidth, $cpassHeight, 'F');
//         $pdf->Text($currentX - 1, $y + $height - $cpassHeight - 5, $row['cpass']);

//         // Fail (red)
//         $pdf->SetFillColor(255, 0, 0);
//         $pdf->Rect($currentX + $barWidth + 2, $y + $height - $cfailHeight, $barWidth, $cfailHeight, 'F');
//         $pdf->Text($currentX + $barWidth + 2, $y + $height - $cfailHeight - 5, $row['cfail']);

//         // Label (month) centered under group
//         $mcggy = date('F', strtotime($row['month']));
//         $groupWidth = 2 * ($barWidth + 2); // only 2 bars per group
//         $pdf->Text($currentX - 4, $y + $height + 3, $mcggy);

//         // Move to next group
//         $currentX += $groupWidth + $barSpacing;
//     }
//     // Legend (optional)
//     $legendX = $x;
//     $legendY = $y + $height + 20;
//     $pdf->SetFont('centurygothic', 'B', 9);

//     $pdf->SetFillColor(0, 128, 0);
//     $pdf->Rect($legendX + 30, $legendY, 5, 5, 'F');
//     $pdf->Text($legendX + 36, $legendY + 1, $swabname . ' Negative : ' . $totalPass);

//     $pdf->SetFillColor(255, 0, 0);
//     $pdf->Rect($legendX + 134, $legendY, 5, 5, 'F');
//     $pdf->Text($legendX + 140, $legendY + 1, $swabname . ' Postive : ' . $totalFail);
// }



/////////////////////////////////////////////// Page 17 //////////////////////////////////////////////////////


$pdf->AddPage();

$pdf->setY(30);
$pdf->SetFont('centurygothic', 'B', 25);
$pdf->SetTextColor(0, 51, 102);
$pdf->Write(0, 'Pest Control Trending', '', 0, 'C', true, 0, false, false, 0);

$pdf->Write(0, 'Inside Pest', '', 0, 'C', true, 0, false, false, 0);


$yearnow = date('Y', strtotime('last month'));

// Step 1: Query grouped by month and pest_type
$monthlyData = [];
$pestTypes = [];
$pstq = mysqli_query($con, "SELECT pest_cover FROM `tb_pestagency` WHERE status='Active'");
$pstq1 = mysqli_fetch_array($pstq);
$pstq2 = explode(';', $pstq1['pest_cover']);

foreach ($pstq2 as $pstqdata => $pestv) {

    for ($iq = 1; $iq <= 12; $iq++) {
        if ($iq < 10) {
            $iq = '0' . $iq;
        } else {
            $iq = $iq;
        }

        $sqlp = mysqli_query($con, "SELECT MONTH(date_incidence) AS month,
           
           SUM(pest_num) AS total_pests
    FROM tb_pest
    WHERE found='inside'
      AND YEAR(date_incidence) = '$yearnow'AND pest_type ='$pestv' AND MONTH(date_incidence) = '$iq'
    
");

        $rowp = mysqli_fetch_array($sqlp);


        $m = $rowp['month'];
        $type = $pestv;
        $monthlyData[$m][$type] = $rowp['total_pests'];

        if (!in_array($type, $pestTypes)) {
            $pestTypes[] = $type;
        }
    }
}


// Store data in array structure

// Step 2: Chart setup
$x = 8;          // Starting X position of chart
$y = 60;          // Starting Y position of chart
$width = 285;     // Width of chart area
$height = 90;    // Height of chart area
$barWidth = 2;
$barSpacing = 23; // Spacing between bars for each month

// Find maximum value for scaling the chart
$maxCount = 0;
foreach ($monthlyData as $month => $types) {
    foreach ($types as $val) {
        if ($val > $maxCount)
            $maxCount = $val;
    }
}
$maxCount = $maxCount ?: 10; // Ensure at least 10 for scaling

// Round up to next even number for better Y-axis labels
if ($maxCount % 2 != 0) {
    $maxCount++;
}

// Draw chart border
$pdf->Rect($x, $y, $width, $height, 'D');

// Draw Y-axis grid lines and labels (even numbers only)
for ($val = 0; $val <= $maxCount; $val++) {
    $yLabelPos = $y + $height - ($val / $maxCount * $height);

    // Draw horizontal grid line
    $pdf->SetLineStyle(['width' => 0.1, 'color' => [128, 128, 128]]);
    $pdf->Line($x, $yLabelPos, $x + $width, $yLabelPos);

    // Draw Y-axis label
    $pdf->SetFont('century gothic', 'B', 9);
    $pdf->Text($x - 6, $yLabelPos - 1.5, $val);
}

// Step 3: Assign colors for each pest type
$baseColors = [
    [255, 0, 0],      // red
    [255, 165, 0],    // orange
    [0, 128, 0],      // green
    [0, 0, 255],      // blue
    [128, 0, 128],    // purple

    [255, 255, 0],    // yellow
    [0, 255, 255],    // cyan
    [255, 192, 203],  // pink
    [165, 42, 42],    // brown
    [0, 0, 0],        // black

    [128, 128, 128],  // gray
    [255, 215, 0],    // gold
    [173, 216, 230],  // light blue
    [0, 100, 0],      // dark green
    [255, 20, 147],   // deep pink

    [75, 0, 130],     // indigo
    [240, 230, 140],  // khaki
    [255, 69, 0],     // red-orange
    [46, 139, 87],    // sea green
    [70, 130, 180],   // steel blue
];


$colors = [];
$colorIndex = 0;
foreach ($pestTypes as $type) {

    $colors[$type] = $baseColors[$colorIndex % count($baseColors)];
    $colorIndex++;
}
// Step 4: Draw bar chart
$totalPerPest = []; // Array to store totals for each pest type
$barWidth = 2;     // Width of each bar

$currentX = $x + 10; // Starting X position for first bar

// Loop through each month (1 to 12)
for ($i = 1; $i <= 12; $i++) {
    $monthTotal = 0; // Total pests for this month

    // Draw bars for each pest type in this month
    $barX = $currentX;
    foreach ($pestTypes as $type) {

        if (isset($monthlyData[$i][$type]) && !empty($monthlyData[$i][$type])) {
            $value = $monthlyData[$i][$type];
        } else {
            $value = 0;
        }


        // Add to pest type total
        if (!isset($totalPerPest[$type])) {
            $totalPerPest[$type] = 0;
        }
        $totalPerPest[$type] += $value;

        // Calculate bar height (0 if no data)
        $barHeight = ($value / $maxCount) * $height;
        $barY = $y + $height - $barHeight;

        // Set color and draw bar (always, even if height = 0)
        $color = $colors[$type];
        $pdf->SetFillColor($color[0], $color[1], $color[2]);
        $pdf->Rect($barX, $barY, $barWidth, $barHeight, 'F');

        // Label value on top of bar (show 0 if no data)
        $pdf->SetFont('century gothic', 'B', 9);
        if ($value == 0) {
            $pdf->Text($barX - 1, $barY - 5, '');
        } else {
            $pdf->Text($barX - 1, $barY - 5, $value);
        }

        $barX += $barWidth + 2; // Move to next bar position
    }

    // Draw month label below bars
    $pdf->SetFont('century gothic', '', 9);
    $monthLabel = date(' F ', strtotime("$yearnow-$i-01")); //  F(using 'F' full name month 'M' half name month)
    $pdf->Text($currentX + 3, $y + $height + 4, $monthLabel);
    $monthLabel;
    $currentX += $barSpacing; // Move to next month position
}



// Step 5: Draw legend with totals
$pdf->SetFont('centurygothic', 'B', 10);
$legendX = $x-10;
$legendY = $y + $height + 12; // Position below chart


$itemsPerRow = 5; // Items per row in legend
$itemWidth = 55; // Width per legend item
$currentLegendX = $legendX;
$currentLegendY = $legendY;
$itemCount = 0;


foreach ($totalPerPest as $type => $total) {
    if ($itemCount >= $itemsPerRow) {
        $currentLegendX = $legendX;
        $currentLegendY += 8; // Move to next row
        $itemCount = 0;
    }

    $color = $colors[$type];
    $pdf->SetFillColor($color[0], $color[1], $color[2]);
    $pdf->Rect($currentLegendX +15, $currentLegendY, 5, 5, 'F');

    // Write the label + value next to the box
    $label = ucfirst($type) . ': ' . $total;
    $pdf->Text($currentLegendX + 22, $currentLegendY, $label);

    $currentLegendX += $itemWidth;
    $itemCount++;
}


/////////////////////////////////////////////////////// Page 18 /////////////////////////////////////////////

$pdf->AddPage();

$pdf->setY(30);
$pdf->SetFont('centurygothic', 'B', 22);
$pdf->SetTextColor(0, 51, 102);
$pdf->Write(0, 'Pest Control Trending', '', 0, 'C', true, 0, false, false, 0);

$pdf->Write(0, 'Outside Pest', '', 0, 'C', true, 0, false, false, 0);


$yearnow = date('Y', strtotime('last month'));

// Step 1: Query grouped by month and pest_type
$monthlyData = [];
$pestTypes = [];
$pstq = mysqli_query($con, "SELECT pest_cover FROM `tb_pestagency` WHERE status='Active'");
$pstq1 = mysqli_fetch_array($pstq);
$pstq2 = explode(';', $pstq1['pest_cover']);

foreach ($pstq2 as $pstqdata => $pestv) {

    for ($iq = 1; $iq <= 12; $iq++) {
        if ($iq < 10) {
            $iq = '0' . $iq;
        } else {
            $iq = $iq;
        }

        $sqlp = mysqli_query($con, "SELECT MONTH(date_incidence) AS month,
           
           SUM(pest_num) AS total_pests
    FROM tb_pest
    WHERE found='outside'
      AND YEAR(date_incidence) = '$yearnow'AND pest_type ='$pestv' AND MONTH(date_incidence) = '$iq'
    
");

        $rowp = mysqli_fetch_array($sqlp);


        $m = $rowp['month'];
        $type = $pestv;
        $monthlyData[$m][$type] = $rowp['total_pests'];

        if (!in_array($type, $pestTypes)) {
            $pestTypes[] = $type;
        }
    }
}
// Step 2: Chart setup
$x = 8;          // Starting X position of chart
$y = 60;          // Starting Y position of chart
$width = 285;     // Width of chart area
$height = 90;    // Height of chart area
$barWidth = 2;
$barSpacing = 23; // Spacing between bars for each month

// Find maximum value for scaling the chart
$maxCount = 0;
foreach ($monthlyData as $month => $types) {
    foreach ($types as $val) {
        if ($val > $maxCount)
            $maxCount = $val;
    }
}
$maxCount = $maxCount ?: 10; // Ensure at least 10 for scaling

// Round up to next even number for better Y-axis labels
if ($maxCount % 2 != 0) {
    $maxCount++;
}

// Draw chart border
$pdf->Rect($x, $y, $width, $height, 'D');

// Draw Y-axis grid lines and labels (even numbers only)
for ($val = 0; $val <= $maxCount; $val += 2) {
    $yLabelPos = $y + $height - ($val / $maxCount * $height);

    // Draw horizontal grid line
    $pdf->SetLineStyle(['width' => 0.1, 'color' => [128, 128, 128]]);
    $pdf->Line($x, $yLabelPos, $x + $width, $yLabelPos);

    // Draw Y-axis label
    $pdf->SetFont('centurygothic', 'B', 9);
    $pdf->Text($x - 6, $yLabelPos - 2, $val);
}

// Step 3: Assign colors for each pest type
$baseColors = [
    [255, 0, 0],      // red
    [255, 165, 0],    // orange
    [0, 128, 0],      // green
    [0, 0, 255],      // blue
    [128, 0, 128],    // purple

    [255, 255, 0],    // yellow
    [0, 255, 255],    // cyan
    [255, 192, 203],  // pink
    [165, 42, 42],    // brown
    [0, 0, 0],        // black

    [128, 128, 128],  // gray
    [255, 215, 0],    // gold
    [173, 216, 230],  // light blue
    [0, 100, 0],      // dark green
    [255, 20, 147],   // deep pink

    [75, 0, 130],     // indigo
    [240, 230, 140],  // khaki
    [255, 69, 0],     // red-orange
    [46, 139, 87],    // sea green
    [70, 130, 180],   // steel blue
];


$colors = [];
$colorIndex = 0;
foreach ($pestTypes as $type) {
    $colors[$type] = $baseColors[$colorIndex % count($baseColors)];
    $colorIndex++;
}
// Step 4: Draw bar chart
$totalPerPest = []; // Array to store totals for each pest type
$barWidth = 2;     // Width of each bar
$currentX = $x + 10; // Starting X position for first bar

// Loop through each month (1 to 12)
for ($i = 1; $i <= 12; $i++) {
    $monthTotal = 0; // Total pests for this month

    // Draw bars for each pest type in this month
    $barX = $currentX;
    foreach ($pestTypes as $type) {

        if (isset($monthlyData[$i][$type]) && !empty($monthlyData[$i][$type])) {
            $value = $monthlyData[$i][$type];
        } else {
            $value = 0;
        }

        // Add to pest type total
        if (!isset($totalPerPest[$type])) {
            $totalPerPest[$type] = 0;
        }
        $totalPerPest[$type] += $value;

        // Calculate bar height (0 if no data)
        $barHeight = ($value / $maxCount) * $height;
        $barY = $y + $height - $barHeight;

        // Set color and draw bar (always, even if height = 0)
        $color = $colors[$type];
        $pdf->SetFillColor($color[0], $color[1], $color[2]);
        $pdf->Rect($barX, $barY, $barWidth, $barHeight, 'F');

        // Label value on top of bar (show 0 if no data)
        $pdf->SetFont('centurygothic', 'B', 9);
        if ($value == 0) {
            $pdf->Text($barX - 1, $barY - 5, '');
        } else {
            $pdf->Text($barX - 1, $barY - 5, $value);
        }

        $barX += $barWidth + 2; // Move to next bar position
    }

    // Draw month label below bars
    $pdf->SetFont('centurygothic', '', 9);
    $monthLabel = date('F', strtotime("$yearnow-$i-01"));
    $pdf->Text($currentX, $y + $height + 4, $monthLabel);

    $currentX += $barSpacing; // Move to next month position
}




// Step 5: Draw legend with totals
$pdf->SetFont('centurygothic', 'B', 10);
$legendX = $x-10;
$legendY = $y + $height + 12; // Position below chart


$itemsPerRow = 5; // Items per row in legend
$itemWidth = 55; // Width per legend item
$currentLegendX = $legendX;
$currentLegendY = $legendY;
$itemCount = 0;


foreach ($totalPerPest as $type => $total) {
    if ($itemCount >= $itemsPerRow) {
        $currentLegendX = $legendX;
        $currentLegendY += 8; // Move to next row
        $itemCount = 0;
    }

    $color = $colors[$type];
    $pdf->SetFillColor($color[0], $color[1], $color[2]);
    $pdf->Rect($currentLegendX +15, $currentLegendY, 5, 5, 'F');

    // Write the label + value next to the box
    $label = ucfirst($type) . ': ' . $total;
    $pdf->Text($currentLegendX + 22, $currentLegendY, $label);

    $currentLegendX += $itemWidth;
    $itemCount++;
}

/////////////////////////////////////////////////// Pest visit/////////////////////////////////////////////

$pdf->AddPage();
$pdf->setY(30);
$pdf->SetFont('centurygothic', 'B', 22);
$pdf->SetTextColor(0, 51, 102);
$pdf->Write(0, 'Pest Control Visit', '', 0, 'C', true, 0, false, false, 0);



// Get data from database
$data = [];
$year = date('Y', strtotime('last month'));

// Get all categories
$catq = mysqli_query($con, "SELECT * FROM `tb_pestagency` WHERE status ='Active'");
$catq2 = mysqli_fetch_array($catq);
$catdata = explode(';', $catq2['services']);

$categories = [];
$pestTypes = [];

foreach ($catdata as $cadata => $catvalue) {
    $category = $catvalue;
    $categories[] = $category;
    $pestTypes[] = $category;

    $data[$category] = [];

    for ($m = 1; $m <= 12; $m++) {
        $monthkey = date('Y-m', strtotime("$year-$m-01"));
        $query = "SELECT DATE_FORMAT(date, '%Y-%m') AS month,
                         
                         COUNT(*) AS count
                  FROM `tb_visit`
                  WHERE DATE_FORMAT(date, '%Y-%m') = '$monthkey' 
                  AND visittype='$category'";

        $result = mysqli_query($con, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $data[$category][$m] = $row['count'];
        } else {
            $data[$category][$m] = 0;
        }
    }
}

$x = 8;       // X position of chart
$y = 50;       // Y position of chart
$width = 285;  // Width of chart
$height = 100; // Height of chart
$barSpacing = 23; // Spacing between month groups

$maxCount = 0;
foreach ($data as $category => $monthData) {
    foreach ($monthData as $count) {
        if ($count > $maxCount) {
            $maxCount = $count;
        }
    }
}

// Round up to nearest even number for grid
$maxCount = ceil($maxCount / 2) * 2;
if ($maxCount < 2) $maxCount = 10; // Minimum scale

// Step 1: Draw chart border
$pdf->Rect($x, $y, $width, $height, 'D');

// Step 2: Draw Y-axis grid lines and labels (even numbers only)
for ($val = 0; $val <= $maxCount; $val += 2) {
    $yLabelPos = $y + $height - ($val / $maxCount * $height);

    // Draw horizontal grid line
    $pdf->SetLineStyle(['width' => 0.1, 'color' => [128, 128, 128]]);
    $pdf->Line($x, $yLabelPos, $x + $width, $yLabelPos);

    // Draw Y-axis label
    $pdf->SetFont('centurygothic', 'B', 9);
    $pdf->Text($x - 6, $yLabelPos - 2, $val);
}

// Step 3: Assign colors for each category
$baseColors = [
    [255, 0, 0],    // red
    [255, 165, 0],  // orange
    [0, 128, 0],    // green
    [0, 0, 255],    // blue
    [128, 0, 128],  // purple
    [0, 128, 128],  // teal
    [255, 192, 203], // pink
    [165, 42, 42],   // brown
];

$colors = [];
$colorIndex = 0;
foreach ($pestTypes as $type) {
    $colors[$type] = $baseColors[$colorIndex % count($baseColors)];
    $colorIndex++;
}

// Step 4: Draw bar chart
$totalPerPest = []; // Array to store totals for each category
$barWidth = 2;     // Width of each bar
$currentX = $x + 10; // Starting X position for first bar

// Loop through each month (1 to 12)
for ($i = 1; $i <= 12; $i++) {
    $monthTotal = 0; // Total complaints for this month

    // Draw bars for each category in this month
    $barX = $currentX;
    foreach ($pestTypes as $type) {
        // Get value from $data array
        $value = isset($data[$type][$i]) ? $data[$type][$i] : 0;

        // Add to category total
        if (!isset($totalPerPest[$type])) {
            $totalPerPest[$type] = 0;
        }
        $totalPerPest[$type] += $value;

        // Calculate bar height (0 if no data)
        $barHeight = ($value / $maxCount) * $height;
        $barY = $y + $height - $barHeight;

        // Set color and draw bar (always, even if height = 0)
        $color = $colors[$type];
        $pdf->SetFillColor($color[0], $color[1], $color[2]);
        $pdf->Rect($barX, $barY, $barWidth, $barHeight, 'F');

        // Label value on top of bar (show 0 if no data)
        $pdf->SetFont('centurygothic', 'B', 9);
        if ($value == 0) {
            $pdf->Text($barX - 1, $barY - 5, '');
        } else {
            $pdf->Text($barX - 1, $barY - 5, $value);
        }

        $barX += $barWidth + 2; // Move to next bar position
    }

    // Draw month label below bars
    $pdf->SetFont('centurygothic', '', 9);
    $monthLabel = date('F', strtotime("$year-$i-01")); // Short month name
    $monthTextWidth = $pdf->GetStringWidth($monthLabel);
    $pdf->Text(
        $currentX + ($barWidth * count($pestTypes) / 2) - ($monthTextWidth / 2),
        $y + $height + 4,
        $monthLabel
    );

    // After updating $currentX with $barSpacing
    $currentX += $barSpacing;
    // // Draw vertical separator line at the end of this month group 

    // $pdf->SetDrawColor(200, 200, 200); // light gray 
    // $pdf->Line($currentX, $y, $currentX, $y + $height);


}
// Step 5: Draw legend with totals
$pdf->SetFont('centurygothic', 'B', 10);
$legendX = $x;
$legendY = $y + $height + 20; // Position below chart


$itemsPerRow = 4; // Items per row in legend
$itemWidth = 70; // Width per legend item
$currentLegendX = $legendX;
$currentLegendY = $legendY;
$itemCount = 0;


foreach ($totalPerPest as $type => $total) {
    if ($itemCount >= $itemsPerRow) {
        $currentLegendX = $legendX;
        $currentLegendY += 8; // Move to next row
        $itemCount = 0;
    }

    $color = $colors[$type];
    $pdf->SetFillColor($color[0], $color[1], $color[2]);
    $pdf->Rect($currentLegendX + 20, $currentLegendY, 5, 5, 'F');

    // Write the label + value next to the box
    $label = ucfirst($type) . ': ' . $total;
    $pdf->Text($currentLegendX + 27, $currentLegendY, $label);

    $currentLegendX += $itemWidth;
    $itemCount++;
}

////////////////////////////////////////////// Page 19 /////////////////////////////////////////////////////////

$pdf->AddPage();

// Title
$pdf->setY(15);
$pdf->SetFont('centurygothic', 'B', 18);
$pdf->SetTextColor(0, 51, 102);
// Add chart title
$pdf->SetFont('centurygothic', 'B', 20, 'C');
$pdf->Text($x + 110, $y - 20, "Complaint Trending");


// Get data from database
$data = [];
$year = date('Y', strtotime('last month'));

// Get all categories
$catq = mysqli_query($con, "SELECT * FROM `tblcategory`");
$categories = [];
$pestTypes = []; // For chart compatibility

while ($catdata = mysqli_fetch_assoc($catq)) {
    $category = $catdata['name'];
    $categories[] = $category;
    $pestTypes[] = $category; // Same array for chart

    // Initialize data structure
    $data[$category] = [];

    // Get monthly counts for this category
    for ($m = 1; $m <= 12; $m++) {
        $monthkey = date('Y-m', strtotime("$year-$m-01"));

        if ($monthkey <= $monthfile) {
            $query = "SELECT DATE_FORMAT(compdate, '%Y-%m') AS month,
                         category,
                         COUNT(*) AS count
                  FROM tblnewcomplaint
                  WHERE DATE_FORMAT(compdate, '%Y-%m') = '$monthkey'
                  AND category='$category'";

            $result = mysqli_query($con, $query);
            $resultnum = mysqli_num_rows($result);
        } else {
            $resultnum = 0;
        }
        if ($resultnum > 0) {
            $row = mysqli_fetch_assoc($result);
            $data[$category][$m] = $row['count']; // Use month number as key
        } else {
            $data[$category][$m] = 0;
        }
    }
}

// Chart 
$x = 10;
$width = 280;
$height = 100;
$numCategories = count($pestTypes);
$barWidth = 2;
$barGap = 0.5;
$monthGroupWidth = $numCategories * ($barWidth + $barGap);
$totalMonthsWidth = $monthGroupWidth * 12;
$totalGapsBetweenMonths = 11 * 3;
$totalChartWidth = $totalMonthsWidth + $totalGapsBetweenMonths;

// Adjust spacing to fit within width
$availableWidth = $width - 20; // Leave margins
$spacingPerMonth = $availableWidth / 12;
$monthGroupWidth = $spacingPerMonth - 2;
$barWidth = max(1, floor(($monthGroupWidth - (($numCategories - 1) * $barGap)) / $numCategories));

// Find maximum count for scaling
$maxCount = 0;
foreach ($data as $category => $monthData) {
    foreach ($monthData as $count) {
        if ($count > $maxCount) {
            $maxCount = $count;
        }
    }
}

// Round up to nearest even number for grid
$maxCount = ceil($maxCount / 2) * 2;
if ($maxCount < 2)
    $maxCount = 10; // Minimum scale

// Step 1: Draw chart border
$pdf->Rect($x, $y, $width, $height, 'D');

// Step 2: Draw Y-axis grid lines and labels (even numbers only)
for ($val = 0; $val <= $maxCount; $val += 2) {
    $yLabelPos = $y + $height - ($val / $maxCount * $height);

    // Draw horizontal grid line
    $pdf->SetLineStyle(['width' => 0.1, 'color' => [128, 128, 128]]);
    $pdf->Line($x, $yLabelPos, $x + $width, $yLabelPos);

    // Draw Y-axis label
    $pdf->SetFont('centurygothic', 'B', 9); // Smaller font
    $pdf->Text($x - 5, $yLabelPos - 2, $val);
}

// Step 3: Assign colors for each category
$baseColors = [
    [255, 0, 0],      // red
    [255, 165, 0],    // orange
    [0, 128, 0],      // green
    [0, 0, 255],      // blue
    [128, 0, 128],    // purple
    [0, 128, 128],    // teal
    [255, 192, 203],  // pink
    [165, 42, 42],    // brown
    [0, 255, 255],    // cyan
    [75, 0, 130],     // indigo
    [255, 20, 147],   // deep pink
    [0, 255, 127],    // spring green
    [255, 215, 0],    // gold
    [173, 216, 230],  // light blue
    [240, 230, 140],  // khaki
    [255, 105, 180],  // hot pink
    [46, 139, 87],    // sea green
    [210, 105, 30],   // chocolate
    [192, 192, 192],  // silver
];

$colors = [];
$colorIndex = 0;
foreach ($pestTypes as $type) {
    $colors[$type] = $baseColors[$colorIndex % count($baseColors)];
    $colorIndex++;
}

$totalPerPest = [];
$currentX = $x + 8;

for ($i = 1; $i <= 12; $i++) {
    $monthStartX = $currentX;
    $barX = $monthStartX;

    foreach ($pestTypes as $type) {
        if (isset($data[$type][$i])) {
            $value = $data[$type][$i];
        } else {
            $value = 0;
        }

        if (!isset($totalPerPest[$type])) {
            $totalPerPest[$type] = 0;
        }
        $totalPerPest[$type] += $value;

        if ($maxCount > 0) {
            $barHeight = ($value / $maxCount) * $height;
        } else {
            $barHeight = 0;
        }
        $barY = $y + $height - $barHeight;

        if ($barHeight > 0) {
            $color = $colors[$type];
            $pdf->SetFillColor($color[0], $color[1], $color[2]);
            $pdf->Rect($barX, $barY, $barWidth, $barHeight, 'F');
        }

        $pdf->SetFont('centurygothic', 'B', 9);
        if ($value > 0 && $barHeight > 8) {
            $pdf->Text($barX - 1, $barY - 4, $value);
        }

        $barX += $barWidth + $barGap;
    }

    $pdf->SetFont('centurygothic', 'B', 9);
    $monthLabel = date('F', strtotime("$year-$i-01"));
    $monthLabelX = $monthStartX; // Position at the left edge of the month group
    $pdf->Text($monthLabelX, $y + $height + 3, $monthLabel);

    $currentX += $monthGroupWidth + 3;
}

$pdf->SetFont('centurygothic', 'B', 9);
$legendX = $x;
$legendY = $y + $height + 18;

$itemsPerRow = floor($width / 45);
if ($itemsPerRow < 2)
    $itemsPerRow = 2;
if ($itemsPerRow > 5)
    $itemsPerRow = 5;

$itemWidth = floor($width / $itemsPerRow);
$currentLegendX = $legendX;
$currentLegendY = $legendY;
$itemCount = 0;

foreach ($totalPerPest as $type => $total) {
    if ($itemCount >= $itemsPerRow) {
        $currentLegendX = $legendX;
        $currentLegendY += 6;
        $itemCount = 0;
    }

    $color = $colors[$type];
    $pdf->SetFillColor($color[0], $color[1], $color[2]);
    $pdf->Rect($currentLegendX, $currentLegendY, 3, 3, 'F');
    if (strlen($type) > 12) {
        $shortType = $type;
    } else {
        $shortType = $type;
    }
    $label = $shortType . ': ' . $total;
    $pdf->Text($currentLegendX + 5, $currentLegendY, $label);

    $currentLegendX += $itemWidth;
    $itemCount++;
}

$pdf->SetY($legendY + 15);


////////////////////////////////////////// Page 20 /////////////////////////////////////////////////////////////

$pdf->AddPage();

$pdf->setY(30);
$pdf->SetFont('centurygothic', 'B', 22);
$pdf->SetTextColor(0, 51, 102);
$pdf->Write(0, 'Service Supplier Performance Monitoring', '', 0, 'C', true, 0, false, false, 0);
$yearnow = date('Y', strtotime('last month'));
// Query actual data
$querys = "SELECT DATE_FORMAT(date, '%Y-%m') as month, 
                 count(*) as Done ,
                 SUM(status = 'waiting') as waiting
          FROM `tblsuppliercomplaint`
          WHERE YEAR(date) = '$yearnow' and suptype ='Raw Material Supplier'
          GROUP BY DATE_FORMAT(date, '%Y-%m') 
          ORDER BY month";

$results = mysqli_query($con, $querys);

// Initialize all months with zero values
$monthlyData = [];
for ($m = 1; $m <= 12; $m++) {
    $monthKey = date('Y-m', strtotime("$yearnow-$m-01"));
    $monthlyData[$monthKey] = ['Done' => 0, 'waiting' => 0];
}

// Overwrite with actual data
while ($row = mysqli_fetch_assoc($results)) {
    $monthlyData[$row['month']] = [
        'Done' => (int) $row['Done'],
        'waiting' => (int) $row['waiting']
    ];
}

// Calculate totals
$totalDone = 0;
$totalWaiting = 0;

foreach ($monthlyData as $monthKey => $data) {
    $totalDone += $data['Done'];
    $totalWaiting += $data['waiting'];
}
// Sort months

ksort($monthlyData);

// Chart dimensions
$x = 20;
$y = 50;
$width = 250;
$height = 100;
$barWidth = 2;
$barSpacing = 10;

// Fixed Y-axis range
$maxCount = 14;
$yLabelStep = $height / 7;

// Draw chart background
$pdf->Rect($x, $y, $width, $height, 'D');

// Draw Y-axis grid and labels
for ($i = 0; $i <= 7; $i++) {
    $countValue = $i * 2;
    $yLabelPos = $y + $height - ($i * $yLabelStep);

    $pdf->SetLineStyle(['width' => 0.2, 'color' => [128, 128, 128]]);
    $pdf->Line($x, $yLabelPos, $x + $width, $yLabelPos);

    $pdf->SetFont('centurygothic', 'B', 9);
    $pdf->Text($x - 8, $yLabelPos - 1.5, $countValue);
}

// Draw bars
$currentX = $x + 20;
foreach ($monthlyData as $month => $data) {
    $doneHeight = ($data['Done'] / $maxCount) * $height;
    $waitingHeight = ($data['waiting'] / $maxCount) * $height;

    // Done (green)
    $pdf->SetFillColor(0, 128, 0);
    $pdf->Rect($currentX, $y + $height - $doneHeight, $barWidth, $doneHeight, 'F');
    $pdf->SetFont('centurygothic', 'B', 9);

    // ALWAYS show the value (even when 0)
    $pdf->Text($currentX - 1, $y + $height - $doneHeight - 5, $data['Done']);

    // Waiting (blue)
    $pdf->SetFillColor(0, 0, 255);
    $pdf->Rect($currentX + $barWidth + 1, $y + $height - $waitingHeight, $barWidth, $waitingHeight, 'F');

    // ALWAYS show the value (even when 0)
    $pdf->Text($currentX + $barWidth, $y + $height - $waitingHeight - 5, $data['waiting']);

    // Month label
    $pdf->SetFont('centurygothic', '', 9);
    $monthLabel = date('F', strtotime($month));
    $pdf->Text($currentX - 4, $y + $height + 3, $monthLabel);

    $currentX += 3 * ($barWidth + 1) + $barSpacing;
}

// Legend
$pdf->SetFont('centurygothic', 'B', 9);
$pdf->SetFillColor(0, 128, 0);
$pdf->Rect($x + 70, 170, 5, 5, 'F');
$pdf->Text($x + 77, 171, 'Total Supplier NC: ' . $totalDone);

$pdf->SetFillColor(0, 0, 255);
$pdf->Rect($x + 120, 170, 5, 5, 'F');
$pdf->Text($x + 127, 171, 'NC Close-off Pending : ' . $totalWaiting);


///////////////////////////////////////////// Page 21  /////////////////////////////////////////////////////////////////

$pdf->AddPage();

$pdf->setY(30);
$pdf->SetFont('centurygothic', 'B', 22);
$pdf->SetTextColor(0, 51, 102);
$pdf->Write(0, 'Raw Material Supplier Performance Monitoring', '', 0, 'C', true, 0, false, false, 0);
$yearnow = date('Y', strtotime('last month'));
// Query actual data
$querys = "SELECT DATE_FORMAT(date, '%Y-%m') as month, 
                 count(*) as Done ,
                 SUM(status = 'waiting') as waiting
          FROM `tblsuppliercomplaint`
          WHERE YEAR(date) = '$yearnow' and suptype ='Raw Material Supplier'
          GROUP BY DATE_FORMAT(date, '%Y-%m') 
          ORDER BY month";

$results = mysqli_query($con, $querys);

// Initialize all months with zero values
$monthlyData = [];
for ($m = 1; $m <= 12; $m++) {
    $monthKey = date('Y-m', strtotime("$yearnow-$m-01"));
    $monthlyData[$monthKey] = ['Done' => 0, 'waiting' => 0];
}

// Overwrite with actual data
while ($row = mysqli_fetch_assoc($results)) {
    $monthlyData[$row['month']] = [
        'Done' => (int) $row['Done'],
        'waiting' => (int) $row['waiting']
    ];
}

// Calculate totals
$totalDone = 0;
$totalWaiting = 0;

foreach ($monthlyData as $monthKey => $data) {
    $totalDone += $data['Done'];
    $totalWaiting += $data['waiting'];
}

// Sort months
ksort($monthlyData);

// Chart dimensions
$x = 20;
$y = 50;
$width = 250;
$height = 100;
$barWidth = 2;
$barSpacing = 10;

// Fixed Y-axis range
$maxCount = 14;
$yLabelStep = $height / 7;

// Draw chart background
$pdf->Rect($x, $y, $width, $height, 'D');

// Draw Y-axis grid and labels
for ($i = 0; $i <= 7; $i++) {
    $countValue = $i * 2;
    $yLabelPos = $y + $height - ($i * $yLabelStep);

    $pdf->SetLineStyle(['width' => 0.2, 'color' => [128, 128, 128]]);
    $pdf->Line($x, $yLabelPos, $x + $width, $yLabelPos);

    $pdf->SetFont('centurygothic', 'B', 9);
    $pdf->Text($x - 8, $yLabelPos - 2, $countValue);
}

// Draw bars
$currentX = $x + 20;
foreach ($monthlyData as $month => $data) {
    $doneHeight = ($data['Done'] / $maxCount) * $height;
    $waitingHeight = ($data['waiting'] / $maxCount) * $height;

    // Done (green)
    $pdf->SetFillColor(0, 128, 0);
    $pdf->Rect($currentX, $y + $height - $doneHeight, $barWidth, $doneHeight, 'F');
    $pdf->SetFont('centurygothic', 'B', 9);

    // ALWAYS show the value (even when 0) - REMOVED THE CONDITION
    $pdf->Text($currentX - 1, $y + $height - $doneHeight - 5, $data['Done']);

    // Waiting (blue)
    $pdf->SetFillColor(0, 0, 255);
    $pdf->Rect($currentX + $barWidth + 1, $y + $height - $waitingHeight, $barWidth, $waitingHeight, 'F');

    // ALWAYS show the value (even when 0) - REMOVED THE CONDITION
    $pdf->Text($currentX + $barWidth, $y + $height - $waitingHeight - 5, $data['waiting']);

    // Month label
    $pdf->SetFont('centurygothic', '', 9);
    $monthLabel = date('F', strtotime($month));
    $pdf->Text($currentX - 4, $y + $height + 3, $monthLabel);

    $currentX += 3 * ($barWidth + 1) + $barSpacing;
}

// Legend
$pdf->SetFont('centurygothic', 'B', 9);
$pdf->SetFillColor(0, 128, 0);
$pdf->Rect($x + 70, 170, 5, 5, 'F');
$pdf->Text($x + 77, 171, 'Total Supplier NC: ' . $totalDone);

$pdf->SetFillColor(0, 0, 255);
$pdf->Rect($x + 120, 170, 5, 5, 'F');
$pdf->Text($x + 127, 171, 'NC Close-off Pending : ' . $totalWaiting);

/////////////////////////////////////////////// Page 22 ///////////////////////////////////////////////////////////////


$pdf->AddPage();
$lastmnn = date('Y-m', strtotime('last month'));
$pdf->setY(30);
$pdf->SetFont('centurygothic', 'B', 22);
$pdf->SetTextColor(0, 51, 102);
$lastname = date('F Y', strtotime($lastmnn));
$pdf->Write(0, 'GMP Trending (' . $lastname . ')', '', 0, 'C', true, 0, false, false, 0);

$date1 = $lastmnn . "-01";
$date2 = $lastmnn . "-31";

// Get audit id
$ghy = mysqli_query($con, "SELECT * FROM tblauditsection WHERE name='Monthly GMP Audit' || name='SITE STANDARD Monthly GMP Audit'");
$ghy1 = mysqli_fetch_array($ghy);
$sid = $ghy1['id'];

// Get sections audited in date range
$sql0 = mysqli_query($con, "
   SELECT
    t2.auditsection1 AS section,
    SUM(CASE WHEN t3.ans = 'Major' THEN 1 ELSE 0 END) AS major_count,
    SUM(CASE WHEN t3.ans = 'Minor' THEN 1 ELSE 0 END) AS minor_count,
    SUM(CASE WHEN t3.ans = 'Major' AND t2.status = 'Accepted' THEN 1 ELSE 0 END) AS major_closeoff,
    SUM(CASE WHEN t3.ans = 'Minor' AND t2.status = 'Accepted' THEN 1 ELSE 0 END) AS minor_closeoff
FROM tblgmpaudit2 AS t2
JOIN tblgmpaudit3 AS t3
    ON t3.sno = t2.id
WHERE t2.date BETWEEN '$date1' AND '$date2'
  AND t2.audit = '$sid'
GROUP BY t2.auditsection1
ORDER BY t2.auditsection1;
");
 
$chartData = [];
 
while ($rows0 = mysqli_fetch_array($sql0)) {
   
    $chartData[] = [
        'section' => $rows0['section'],
        'major' => $rows0['major_count'],
        'minor' => $rows0['minor_count'],
        'majorCloseOff' => $rows0['major_closeoff'],
        'minorCloseOff' => $rows0['minor_closeoff']
    ];
}


// Chart setup
$x = 10;
$y = 60;
$width = 280;
$height = 100;
$barWidth = 2;
$barSpacing =23;
 
// Find max count for scaling + totals
$maxCount = 0;
$totalMinor = $totalMajor = $totalMinorCloseoff = $totalMajorCloseoff = 0;
foreach ($chartData as $d) {

    $maxCount = max($maxCount, $d['minor'], $d['major'], $d['minorCloseOff'], $d['majorCloseOff']);
    $totalMinor += $d['minor'];
    $totalMajor += $d['major'];
    $totalMinorCloseoff += $d['minorCloseOff'];
    $totalMajorCloseoff += $d['majorCloseOff'];
}
if ($maxCount < 30) {
    $maxCount = 30;
}

// Chart background
$pdf->Rect($x, $y, $width, $height, 'D', array(), array(200, 200, 200));

// Y-axis
$steps = 10;
$yLabelStep = $height / $steps;
$labelInterval = ceil($maxCount / $steps);

for ($i = 0; $i <= $steps; $i++) {
    $countValue = $i * $labelInterval;
    $yLabelPos = $y + $height - ($i * $yLabelStep);

    $pdf->SetLineStyle(array('width' => 0.2, 'color' => array(128, 128, 128)));
    $pdf->Line($x, $yLabelPos, $x + $width, $yLabelPos);

    $pdf->SetFont('centurygothic', 'B', 9);
    $pdf->Text($x - 8, $yLabelPos - 2, $countValue);
}

// Draw bars per section
$barX = $x + 10;
foreach ($chartData as $data) {
    $minorHeight = ($data['minor'] / ($labelInterval * 10)) * $height;
    $majorHeight = ($data['major'] / ($labelInterval * 10)) * $height;
    $minorCloseHeight = ($data['minorCloseOff'] / ($labelInterval * 10)) * $height;
    $majorCloseHeight = ($data['majorCloseOff'] / ($labelInterval * 10)) * $height;

    // Minor bar
    $pdf->SetFillColor(255, 165, 0);
    $pdf->Rect($barX, $y + $height - $minorHeight, $barWidth, $minorHeight, 'F');
    $pdf->SetFont('centurygothic', '', 9);
    $pdf->Text($barX - 1, $y + $height - $minorHeight - 5, $data['minor']);

    // Minor Closeoff bar
    $pdf->SetFillColor(0, 128, 0);
    $pdf->Rect($barX + $barWidth + 2, $y + $height - $minorCloseHeight, $barWidth, $minorCloseHeight, 'F');
    $pdf->Text($barX + $barWidth + 1, $y + $height - $minorCloseHeight - 5, $data['minorCloseOff']);

    // Major bar
    $pdf->SetFillColor(255, 0, 0);
    $pdf->Rect($barX + ($barWidth * 2) + 4, $y + $height - $majorHeight, $barWidth, $majorHeight, 'F');
    $pdf->Text($barX + ($barWidth * 2) + 3, $y + $height - $majorHeight - 5, $data['major']);

    // Major Closeoff bar
    $pdf->SetFillColor(0, 100, 0);
    $pdf->Rect($barX + ($barWidth * 3) + 6, $y + $height - $majorCloseHeight, $barWidth, $majorCloseHeight, 'F');
    $pdf->Text($barX + ($barWidth * 3) + 5, $y + $height - $majorCloseHeight - 5, $data['majorCloseOff']);

    // Section label
    $pdf->SetFont('centurygothic', 'B', 9);
    $pdf->Text($barX - 2, $y + $height + 4, $data['section']);

    $barX += ($barWidth * 4) + $barSpacing;
}
 
// Legend
$pdf->SetFont('centurygothic', 'B', 9);

// Minor group
$pdf->SetFillColor(255, 165, 0);
$pdf->Rect($x + 60, 170, 4, 4, 'F');
$pdf->Text($x + 66, 170, 'Minor : ' . $totalMinor);

$pdf->SetFillColor(0, 128, 0);
$pdf->Rect($x + 60, 177, 4, 4, 'F');
$pdf->Text($x + 66, 177, 'Minor Closeoff: ' . $totalMinorCloseoff);

// Major group
$pdf->SetFillColor(255, 0, 0);
$pdf->Rect($x + 148, 170, 4, 4, 'F');
$pdf->Text($x + 156, 170, 'Major : ' . $totalMajor);

$pdf->SetFillColor(0, 100, 0);
$pdf->Rect($x + 148, 177, 4, 4, 'F');
$pdf->Text($x + 156, 177, 'Major Closeoff : ' . $totalMajorCloseoff);



//////////////////////////


$pdf->AddPage();
$pdf->setY(30);
$pdf->SetFont('centurygothic', 'B', 22);
$pdf->SetTextColor(0, 51, 102);
$pdf->Write(0, 'GMP Trending', '', 0, 'C', true, 0, false, false, 0);

// Build chart data for each month of 2025
$ghy = mysqli_query($con, "SELECT * FROM tblauditsection WHERE name='Monthly GMP Audit' || name='SITE STANDARD Monthly GMP Audit'");
$ghy1 = mysqli_fetch_array($ghy);
$sid = $ghy1['id'];
$chartData = [];
for ($month = 1; $month <= 12; $month++) {
    $monthStr = str_pad($month, 2, '0', STR_PAD_LEFT);
    $dateFilter = "$yearnow-$monthStr"; // YYYY-MM
 
 
    if($dateFilter <= $monthfile){
       
   
    // print_r($dateFilter);
    // Count Major NCs
 
    $major = mysqli_num_rows(mysqli_query(
        $con,
        "SELECT *
    FROM tblauditsection1 t1
    JOIN tblgmpaudit2 t2 ON t1.id = t2.sid
    JOIN tblgmpaudit3 t3 ON t3.sno = t2.id
    WHERE  DATE_FORMAT(date, '%Y-%m')='$dateFilter'
      AND t2.audit = '$sid' and t3.ans='Major'
"
    ));
 
 
    $minor = mysqli_num_rows(mysqli_query(
        $con,
        "SELECT *
    FROM tblauditsection1 t1
    JOIN tblgmpaudit2 t2 ON t1.id = t2.sid
    JOIN tblgmpaudit3 t3 ON t3.sno = t2.id
    WHERE  DATE_FORMAT(date, '%Y-%m')='$dateFilter'
      AND t2.audit = '$sid' and t3.ans='Minor'"
    ));
 
    // Count Closed Major NCs
    $majorClose = mysqli_num_rows(mysqli_query(
        $con,
        "SELECT *
    FROM tblauditsection1 t1
    JOIN tblgmpaudit2 t2 ON t1.id = t2.sid
    JOIN tblgmpaudit3 t3 ON t3.sno = t2.id
    WHERE  DATE_FORMAT(date, '%Y-%m')='$dateFilter'
      AND t2.audit = '$sid' and t3.ans='Major' and t3.status='Accepted'"
 
    ));
 
    // Count Closed Minor NCs
    $minorClose = mysqli_num_rows(mysqli_query(
        $con,
        "SELECT *
    FROM tblauditsection1 t1
    JOIN tblgmpaudit2 t2 ON t1.id = t2.sid
    JOIN tblgmpaudit3 t3 ON t3.sno = t2.id
    WHERE  DATE_FORMAT(date, '%Y-%m')='$dateFilter'
      AND t2.audit = '$sid' and t3.ans='Minor' and t3.status='Accepted'"
    ));
    }else{
        $major = 0;
        $minor = 0;
        $majorClose = 0;
        $minorClose = 0;
    }
 
 
 
    $chartData[] = [
        'month' => date("F", mktime(0, 0, 0, $month, 1, $yearnow)),
        'major' => $major,
        'minor' => $minor,
        'majorCloseOff' => $majorClose,
        'minorCloseOff' => $minorClose
    ];
}
// Chart setup
$x = 10;
$y = 60;
$width = 280;
$height = 100;
$barWidth = 2;
$barSpacing = 15;

// Find max count for scaling + totals
$maxCount = 0;
$totalMinor = $totalMajor = $totalMinorCloseoff = $totalMajorCloseoff = 0;
foreach ($chartData as $d) {
    $maxCount = max($maxCount, $d['minor'], $d['major'], $d['minorCloseOff'], $d['majorCloseOff']);
    $totalMinor += $d['minor'];
    $totalMajor += $d['major'];
    $totalMinorCloseoff += $d['minorCloseOff'];
    $totalMajorCloseoff += $d['majorCloseOff'];
}
if ($maxCount < 2)
    $maxCount = 2;

// Chart background
$pdf->Rect($x, $y, $width, $height, 'D', array(), array(200, 200, 200));

// Y-axis
$yLabelStep = $height / 5;
$labelInterval = ceil($maxCount / 5);

for ($i = 0; $i <= 5; $i++) {
    $countValue = $i * $labelInterval;
    $yLabelPos = $y + $height - ($i * $yLabelStep);

    $pdf->SetLineStyle(array('width' => 0.2, 'color' => array(128, 128, 128)));
    $pdf->Line($x, $yLabelPos, $x + $width, $yLabelPos);

    $pdf->SetFont('centurygothic', 'B', 9);
    $pdf->Text($x - 8, $yLabelPos - 2, $countValue);
}

// Draw bars per month
$barX = $x + 5;
foreach ($chartData as $data) {
    $minorHeight = ($data['minor'] / ($labelInterval * 5)) * $height;
    $majorHeight = ($data['major'] / ($labelInterval * 5)) * $height;
    $minorCloseHeight = ($data['minorCloseOff'] / ($labelInterval * 5)) * $height;
    $majorCloseHeight = ($data['majorCloseOff'] / ($labelInterval * 5)) * $height;

    // Minor bar
    $pdf->SetFillColor(255, 165, 0);
    $pdf->Rect($barX, $y + $height - $minorHeight, $barWidth, $minorHeight, 'F');
    $pdf->SetFont('centurygothic', '', 9);
    $pdf->Text($barX - 1, $y + $height - $minorHeight - 4, $data['minor']);

    // Minor Closeoff bar
    $pdf->SetFillColor(0, 128, 0);
    $pdf->Rect($barX + $barWidth + 2, $y + $height - $minorCloseHeight, $barWidth, $minorCloseHeight, 'F');
    $pdf->Text($barX + $barWidth + 1, $y + $height - $minorCloseHeight - 4, $data['minorCloseOff']);

    // Major bar
    $pdf->SetFillColor(255, 0, 0);
    $pdf->Rect($barX + ($barWidth * 2) + 4, $y + $height - $majorHeight, $barWidth, $majorHeight, 'F');
    $pdf->Text($barX + ($barWidth * 2) + 3, $y + $height - $majorHeight - 4, $data['major']);

    // Major Closeoff bar
    $pdf->SetFillColor(0, 100, 0);
    $pdf->Rect($barX + ($barWidth * 3) + 6, $y + $height - $majorCloseHeight, $barWidth, $majorCloseHeight, 'F');
    $pdf->Text($barX + ($barWidth * 3) + 5, $y + $height - $majorCloseHeight - 4, $data['majorCloseOff']);

    // Month label
    $pdf->SetFont('centurygothic', 'B', 9);
    $pdf->Text($barX - 2, $y + $height + 4, $data['month']);

    $barX += ($barWidth * 4) + $barSpacing;
}

// Legend
$pdf->SetFont('centurygothic', 'B', 9);

// Minor group
$pdf->SetFillColor(255, 165, 0);
$pdf->Rect($x + 60, 170, 4, 4, 'F');
$pdf->Text($x + 66, 170, 'Minor : ' . $totalMinor);

$pdf->SetFillColor(0, 128, 0);
$pdf->Rect($x + 60, 177, 4, 4, 'F');
$pdf->Text($x + 66, 177, 'Minor Closeoff: ' . $totalMinorCloseoff);
// Major group
$pdf->SetFillColor(255, 0, 0);
$pdf->Rect($x + 148, 170, 4, 4, 'F');
$pdf->Text($x + 156, 170, 'Major : ' . $totalMajor);

$pdf->SetFillColor(0, 100, 0);
$pdf->Rect($x + 148, 177, 4, 4, 'F');
$pdf->Text($x + 156, 177, 'Major Closeoff : ' . $totalMajorCloseoff);







////////////////////////////////////////////////////////////


$pdf->AddPage();

// Header Section
$pdf->setY(30);
$pdf->SetFont('centurygothic', 'B', 22);
$pdf->SetTextColor(0, 51, 102);
$pdf->Cell(0, 10, 'Overall Status', 0, 1, 'C');

$pdf->setXY(7, 45);

$tableover = '<style>
    table {
        border-collapse: collapse;
        font-size: 15px;
    }
    th, td {
        border: 1px solid #000;
        background-color: #fff;
    }
    thead th {
        background-color: #3498db;
        color: #fff;
        font-weight: bold;
    }
    tbody td {
        background-color: #f9f9f9;
    }
</style>

<table cellpadding="2" style="font-size:17px;" >
    <thead>
        <tr>
            <th style="width: 310px; text-align:center;">Key Performance Indicators</th>
            <th style="width: 120px;"></th>
            <th style="width: 572px;"></th>
        </tr>
        <tr>
            <th style="width: 230px;"></th>
            <th style="width: 80px; text-align:center;">Target</th>
            <th style="width: 120px; text-align:center;">Acceptable</th>
            <th style="width: 80px; text-align:center;">Action</th>
            <th style="width: 41px; text-align:center">Jan</th>
            <th style="width: 41px; text-align:center">Feb</th>
            <th style="width: 41px; text-align:center">Mar</th>
            <th style="width: 41px; text-align:center">Apr</th>
            <th style="width: 41px; text-align:center">May</th>
            <th style="width: 41px; text-align:center">Jun</th>
            <th style="width: 41px; text-align:center">Jul</th>
            <th style="width: 41px; text-align:center">Aug</th>
            <th style="width: 41px; text-align:center">Sep</th>
            <th style="width: 41px; text-align:center">Oct</th>
            <th style="width: 41px; text-align:center">Nov</th>
            <th style="width: 41px; text-align:center">Dec</th>
        </tr>
    </thead>';

$tableover .= '<tbody>';


$sql = mysqli_query($con, "SELECT * FROM `tbl_overname` LIMIT 11");
foreach ($sql as $data) {
    $sid = $data['id'];

    // Start row
    $tableover .= '<tr nobr="true">';
    $tableover .= '<td style="width: 230px;">' . $data['name'] . '</td>';
    $tableover .= '<td style="width: 80px; text-align:center; background-color: #5af15a;">' . $data['target'] . '</td>';
    $tableover .= '<td style="width: 120px; text-align:center; background-color: #FFBF00; ">' . $data['acceptable'] . '</td>';
    $tableover .= '<td style="width: 80px; text-align:center; background-color: #F08080;">' . $data['action'] . '</td>';

    $colorMap = [
        'red'   => '#F08080',
        'yellow'  => '#FFBF00',
        'green' => '#5af15a',
    ];
    for ($i = 1; $i <= 12; $i++) {
        $ix = str_pad($i, 2, "0", STR_PAD_LEFT);

        $sql1 = mysqli_query($con, "SELECT dvalue, color 
                                    FROM `tbl_overall` 
                                    WHERE month = '$ix' 
                                      AND year = '$yearnow' 
                                      AND sid = '$sid'");

        if (mysqli_num_rows($sql1) > 0) {
            $sql1data = mysqli_fetch_array($sql1);
            $cellColorName = $sql1data['color'];

            if (isset($colorMap[$cellColorName])) {
                $cellColorHex = $colorMap[$cellColorName];
            } else {
                $cellColorHex = $cellColorName;
            }

            $tableover .= '<td style="width:41px; text-align:center; background-color:'
                . $cellColorHex . ';">'
                . $sql1data['dvalue'] . '</td>';
        } else {
            $tableover .= '<td style="width:41px; text-align:center;">-</td>';
        }
    }

    // Close row
    $tableover .= '</tr>';
}

$tableover .= '</tbody></table>';

$pdf->writeHTML($tableover, true, false, true, false, '');


//////////////////////////////////////////////// Page 24 /////////////////////////////////////////////////////


$pdf->AddPage();

// Header Section
$pdf->setY(30);
$pdf->SetFont('centurygothic', 'B', 22);
$pdf->SetTextColor(0, 51, 102);
$pdf->Cell(0, 10, 'Overall Status', 0, 1, 'C');

$pdf->setXY(7, 45);

$tableover = '<style>
    table {
        border-collapse: collapse;
        font-size: 15px;
    }
    th, td {
        border: 1px solid #000;
        background-color: #fff;
    }
    thead th {
        background-color: #3498db;
        color: #fff;
        font-weight: bold;
    }
    tbody td {
        background-color: #f9f9f9;
    }
</style>

<table cellpadding="2" style="font-size:17px;" >
    <thead>
        <tr>
            <th style="width: 310px; text-align:center;">Key Performance Indicators</th>
            <th style="width: 120px;"></th>
            <th style="width: 572px;"></th>
        </tr>
        <tr>
            <th style="width: 230px;"></th>
            <th style="width: 80px; text-align:center;">Target</th>
            <th style="width: 120px; text-align:center;">Acceptable</th>
            <th style="width: 80px; text-align:center;">Action</th>
            <th style="width: 41px; text-align:center">Jan</th>
            <th style="width: 41px; text-align:center">Feb</th>
            <th style="width: 41px; text-align:center">Mar</th>
            <th style="width: 41px; text-align:center">Apr</th>
            <th style="width: 41px; text-align:center">May</th>
            <th style="width: 41px; text-align:center">Jun</th>
            <th style="width: 41px; text-align:center">Jul</th>
            <th style="width: 41px; text-align:center">Aug</th>
            <th style="width: 41px; text-align:center">Sep</th>
            <th style="width: 41px; text-align:center">Oct</th>
            <th style="width: 41px; text-align:center">Nov</th>
            <th style="width: 41px; text-align:center">Dec</th>
        </tr>
    </thead>';

$tableover .= '<tbody>';

$curyear = date('Y');
$sql = mysqli_query($con, "SELECT * FROM `tbl_overname` LIMIT 11,14");
foreach ($sql as $data) {
    $sid = $data['id'];
    // Start row
    $tableover .= '<tr nobr="true">';
    $tableover .= '<td style="width: 230px;">' . $data['name'] . '</td>';
    $tableover .= '<td style="width: 80px; text-align:center; background-color: #5af15a ;">' . $data['target'] . '</td>';
    $tableover .= '<td style="width: 120px; text-align:center; background-color: #FFBF00 ">' . $data['acceptable'] . '</td>';
    $tableover .= '<td style="width: 80px; text-align:center; background-color: #F08080;">' . $data['action'] . '</td>';

    $colorMap = [
        'red'   => '#F08080',
        'yellow'  => '#FFBF00',
        'green' => '#5af15a',
    ];

    for ($i = 1; $i <= 12; $i++) {
        $ix = str_pad($i, 2, "0", STR_PAD_LEFT);

        $sql1 = mysqli_query($con, "SELECT dvalue, color 
                                    FROM `tbl_overall` 
                                    WHERE month = '$ix' 
                                      AND year = '$yearnow' 
                                      AND sid = '$sid'");

        if (mysqli_num_rows($sql1) > 0) {
            $sql1data = mysqli_fetch_array($sql1);
            $cellColorName = $sql1data['color'];

            if (isset($colorMap[$cellColorName])) {
                $cellColorHex = $colorMap[$cellColorName];
            } else {
                $cellColorHex = $cellColorName;
            }

            $tableover .= '<td style="width:41px; text-align:center; background-color:'
                . $cellColorHex . ';">'
                . $sql1data['dvalue'] . '</td>';
        } else {
            $tableover .= '<td style="width:41px; text-align:center;">-</td>';
        }
    }

    // Close row
    $tableover .= '</tr>';
}

$tableover .= '</tbody></table>';

$pdf->writeHTML($tableover, true, false, true, false, '');

/////////////////////////////////////////////// Page 25 /////////////////////////////////////////////////////



// Define the relative path for the PDF
$path = "kpi/KPI_Reports_" . $monthnows . ".pdf";

// Use $_SERVER['DOCUMENT_ROOT'] to get the absolute path
$fullPath = $_SERVER['DOCUMENT_ROOT'] .  $path;


$mnxc = date('Y-m', strtotime('last month'));
if ((!(file_exists($path)) && $mnxc == $monthfile)
    || (file_exists($path) && $mnxc == $monthfile)
) {
    $pdf->Output($fullPath, "F");
}





?>

<div class="main-content">
    <div class="container-fluid ">
        <div class="main-content">
            <div class="container-fluid " style="margin-top:20px;">
                <div class="row mb-12">
                    <div class="col-md-12 ">
                        <div class="card text-left">
                            <div class="card-body">
                                <a href="admin.php?id=1" class="btn btn-success mb-3 float-right">Go back</a>
                                <?php
                                $currentYear = date("Y", strtotime('last month'));
                                $startYear = $currentYear - 2;
                                $endYear = $currentYear + 1;

                                // default last month
                                $lastMonth = date("F", strtotime("first day of previous month"));
                                ?>

                                <form action="" method="post" name="frm">
                                    <input type="hidden" name="id" value="KPI">
                                    <div class="row">

                                        <!-- Month Dropdown -->
                                        <div class="col-md-4">
                                            <select name="smonth" class="form-control" required>
                                                <option value="" disabled>Select month</option>
                                                <?php
                                                $months = [
                                                    "January",
                                                    "February",
                                                    "March",
                                                    "April",
                                                    "May",
                                                    "June",
                                                    "July",
                                                    "August",
                                                    "September",
                                                    "October",
                                                    "November",
                                                    "December"
                                                ];

                                                foreach ($months as $m) {
                                                    if ((isset($_POST['smonth']) && $_POST['smonth'] == $m) || (!isset($_POST['smonth']) && $m == $lastMonth)) {
                                                        echo "<option value='$m' selected>$m</option>";
                                                    } else {
                                                        echo "<option value='$m'>$m</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <!-- Year Dropdown -->
                                        <div class="col-md-4">
                                            <select name="syear" class="form-control" required>
                                                <option value="" disabled>Select year</option>
                                                <?php
                                                for ($y = $startYear; $y <= $endYear; $y++) {
                                                    if ((isset($_POST['syear']) && $_POST['syear'] == $y) || (!isset($_POST['syear']) && $y == $currentYear)) {
                                                        echo "<option value='$y' selected>$y</option>";
                                                    } else {
                                                        echo "<option value='$y'>$y</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <input type="submit" class="btn btn-primary" name="search" value="search">

                                    </div>
                                </form>

                                <div class="embed-responsive embed-responsive" style="height:700px; width:100%;">
                                    <iframe class="embed-responsive-item" style="height:100%; width:100%;"
                                        src="kpi/KPI_Reports_<?php echo $monthnows; ?>.pdf"
                                        allowfullscreen></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>