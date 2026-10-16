<?php
require('tcpdf/tcpdf.php');
// Make sure this file contains your database connection

ini_set('max_execution_time', 800);
ini_set('memory_limit', '-1');

// Validate and sanitize inputs
$cdate = isset($_GET['cdate']) ? mysqli_real_escape_string($con, $_GET['cdate']) : '';
$sid = isset($_GET['sid']) ? (int)$_GET['sid'] : 0;
$tid = isset($_GET['tid']) ? (int)$_GET['tid'] : 0;
$sxid = isset($_GET['sxid']) ? (int)$_GET['sxid'] : 0;
$headingname = isset($headingname) ? $headingname : 'Daily Checks Report';

if (!$cdate || !$sid) {
    die('Error: Missing required parameters (cdate and sid)');
}

// Validate date format
$timestamp = strtotime($cdate);
if (!$timestamp) {
    die('Error: Invalid date format');
}
$dt = date('d-m-Y', $timestamp);

class MYPDF extends TCPDF
{
    private $longTableFooter = '';

    public function Header()
    {
        $image_file = 'images/1.png';
        $image_file1 = 'images/rtnts.png';

        // Check if images exist
        if (file_exists($image_file)) {
            $this->Image($image_file, 15, 5, 20, '', 'png', '', 'T', false, 200, '', false, false, 0, false, false, false);
        }
        if (file_exists($image_file1)) {
            $this->Image($image_file1, 170, 5, 35, '', 'png', '', 'T', false, 200, '', false, false, 0, false, false, false);
        }

        $this->SetFont('courier', '', 20);
        $this->SetXY(20, 2);
        $this->Cell(0, 25, 'Daily Checks Report', 0, 1, 'C');
    }

    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('courier', '', 8);
        if (!empty($this->longTableFooter)) {
            $this->writeHTML($this->longTableFooter, true, false, true, false, '');
        }
        $this->SetY(-17);
        $this->Cell(0, 10, 'Printed: ' . date('d-m-Y H:i A'), 0, 0, 'R');
    }

    public function setLongTableFooter($html)
    {
        $this->longTableFooter = $html;
    }
}

// Initialize PDF
$pdf = new MYPDF('P', 'mm', 'LETTER', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Daily Checks System');
$pdf->SetTitle('Daily Checks Report');
$pdf->SetSubject('Daily Checks Report');

$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->SetMargins(15, 30, 15);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(15);
$pdf->SetAutoPageBreak(TRUE, 20);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Set font
$pdf->SetFont('courier', '', 11);

// Set language if available
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// Set footer HTML
$footer = <<<EOD
<table border="1" width="100%" cellpadding="3" style="border-collapse: collapse;">
  <tr>
    <td style="text-align:center" width="15%">Version: 01</td>
    <td style="text-align:center;" width="25%">Issue Date: 12/09/24</td>
    <td style="text-align:center;" width="28%">Approved by: Paramvir S. Deol</td>
    <td style="text-align:center;" width="32%">&nbsp;</td>
  </tr>
</table>
EOD;
$pdf->setLongTableFooter($footer);

// Function to render question-answer sections
function renderSection($pdf, $con, $sno, $dt, $txname, $ename, $tableName)
{
    $pdf->AddPage();

    // Header information for the page
    $pdf->SetFont('courier', '', 14);
    $pdf->SetY(40);
    $pdf->Cell(0, 6, "Date: $dt", 0, 1, 'L');
    $pdf->Cell(0, 6, "$txname", 0, 1, 'L');
    $pdf->Cell(0, 6, "Attempted By: $ename", 0, 1, 'L');
    $pdf->Ln(10);

    $pdf->SetFont('courier', '', 11);

    // Start building HTML table
    $tbl_header = '<style>
    table {
        border-collapse: collapse;
        width: 100%;
        margin-bottom: 10px;
    }
    td {
        border: 0.5px solid #000000;
        padding: 5px;
        vertical-align: top;
    }
    .section-title {
        background-color: #f0f0f0;
        font-weight: bold;
        color: blue;
        font-size: 14px;
        text-align: center;
    }
    .question-label {
        font-weight: bold;
        width: 20%;
        background-color: #f9f9f9;
    }
         .question-content {
        width: 80%;
        
    }
    .answer-label {
        font-weight: bold;
        width: 20%;
        background-color: #f9f9f9;
    }
    .answer-content {
        color: green;
        width: 80%;
    }
    </style>';

    $tbl_header .= '<table cellspacing="0" cellpadding="5">';

    // Get distinct sections
    $sectionQuery = "SELECT DISTINCT section FROM $tableName WHERE cid = $sno ORDER BY section";
    $sections = mysqli_query($con, $sectionQuery);

    if (!$sections || mysqli_num_rows($sections) == 0) {
        return;
    }

    $tableContent = '';

    while ($sectionRow = mysqli_fetch_array($sections)) {
        // Section header
        $tableContent .= '<tr>
            <td colspan="2" class="section-title">
                <strong>Section: ' . htmlspecialchars($sectionRow['section']) . '</strong>
             </td>
         </tr>';

        // Get questions for this section
        $questionsQuery = "SELECT * FROM $tableName WHERE cid = $sno AND section = '" . mysqli_real_escape_string($con, $sectionRow['section']) . "' ORDER BY id";
        $questions = mysqli_query($con, $questionsQuery);

        while ($row = mysqli_fetch_array($questions)) {
            // Question row
            $tableContent .= '<tr>
                <td class="question-label"><strong>Question:</strong></td>
                <td class="question-content">' . htmlspecialchars($row['ques']) . '</td>
             </tr>';

            // Answer row
            $tableContent .= '<tr>
                <td class="answer-label"><strong>Answer:</strong></td>
                <td class="answer-content">';

            if (!empty($row['input'])) {
                $tableContent .= htmlspecialchars($row['input']);
            } elseif (!empty($row['answer'])) {
                $tableContent .= htmlspecialchars($row['answer']);
            } elseif (!empty($row['dateinput'])) {
                $tableContent .= htmlspecialchars($row['dateinput']);
            } else {
                $tableContent .= htmlspecialchars($row['ans']);
            }
            $tableContent .= '</td>
             </tr>';

            // Comment row if exists
            if (!empty($row['cmnt'])) {
                $tableContent .= '<tr>
                    <td class="question-label"><strong>Comment:</strong></td>
                    <td style="color:green;">' . htmlspecialchars($row['cmnt']) . '</td>
                 </tr>';
            }

            // Image row if exists
            if (!empty($row['pic']) && file_exists('upl1/' . $row['pic'])) {
                $tableContent .= '<tr>
                    <td>&nbsp;</td>
                    <td><img src="upl1/' . htmlspecialchars($row['pic']) . '" width="150" /></td>
                 </tr>';
            }

            // Add spacing between questions
            $tableContent .= '<tr><td colspan="2" style="border: none; height: 5px;"></td></tr>';
        }
    }

    $tableContent .= '</table>';

    // Write the HTML content
    $pdf->writeHTML($tbl_header . $tableContent, true, false, true, false, '');
}
// Array to collect all table IDs
$allTableIds = array();

// Main query to get daily checks
if ($sid == 2) {
    $sqlx = mysqli_query($con, "SELECT * FROM `dailychecks` WHERE sid = $sid and status='third'");
    $vxcx = 0;
    foreach ($sqlx as $sqlx1) {
        $spxid = $sqlx1['dpid'];


        $sql = mysqli_query($con, "SELECT * FROM dailychecks WHERE status='second' AND sid = $spxid order by name");
        $hasContent = false;
        $firstPage = true;


        foreach ($sql as $sql21) {
            $spid = $sql21['id'];
            $txname = $sql21['name'];
            $close = $sql21['close'];
            $open = $sql21['open'];

            // Check if daily checks exist for this date and name
            $checkQuery = "SELECT * FROM dailycheckss WHERE date = '$cdate' AND name = '$spid' and verifysign=''";

            $checkResult = mysqli_query($con, $checkQuery);
            $checkCount = mysqli_num_rows($checkResult);

            if ($checkCount > 0) {
                $vxcx++;
                $checkData = mysqli_fetch_array($checkResult);
                $sno = $checkData['id'];
                $ename = isset($checkData['ename']) ? $checkData['ename'] : 'Unknown';

                // Collect all table IDs
                $allTableIds[] = array(
                    'dailychecks_id' => $spid,
                    'dailycheckss_id' => $sno,
                    'dailychecks2_table' => 'dailychecks2',
                    'dailychecks3_table' => !empty($checkData['name1']) ? 'dailychecks3' : null,
                    'name' => $txname,
                    'date' => $cdate,
                    'attempted_by' => $ename
                );

                // Add new page if not first section
                if (!$firstPage) {
                    // $pdf->AddPage();
                }
                $firstPage = false;

                // Render sections from dailychecks2
                renderSection($pdf, $con, $sno, $dt, $txname, $ename, 'dailychecks2');

                // Render additional sections from dailychecks3 if name1 exists
                if (!empty($checkData['name1'])) {
                    // $pdf->AddPage();
                    renderSection($pdf, $con, $sno, $dt, $txname, $ename, 'dailychecks3');
                }
            }
        }
    }
} else {
    $query = "SELECT * FROM dailychecks WHERE sid = '$sid' and status='second'";
    $sql = mysqli_query($con, $query);
    $hasContent = false;
    $firstPage = true;

    $vxcx = 0;
    foreach ($sql as $sql21) {
        $spid = $sql21['id'];
        $txname = $sql21['name'];
        $close = $sql21['close'];
        $open = $sql21['open'];

        // Check if daily checks exist for this date and name
        $checkQuery = "SELECT * FROM dailycheckss WHERE date = '$cdate' AND name = '$spid' and verifysign=''";
        // print_r($checkQuery);echo"<br>";
        $checkResult = mysqli_query($con, $checkQuery);
        $checkCount = mysqli_num_rows($checkResult);

        if ($checkCount > 0) {
            $vxcx++;
            $hasContent = true;
            $checkData = mysqli_fetch_array($checkResult);
            $sno = $checkData['id'];
            $ename = isset($checkData['ename']) ? $checkData['ename'] : 'Unknown';

            // Collect all table IDs
            $allTableIds[] = array(
                'dailychecks_id' => $spid,
                'dailycheckss_id' => $sno,
                'dailychecks2_table' => 'dailychecks2',
                'dailychecks3_table' => !empty($checkData['name1']) ? 'dailychecks3' : null,
                'name' => $txname,
                'date' => $cdate,
                'attempted_by' => $ename
            );

            // Add new page if not first section
            if (!$firstPage) {
                // $pdf->AddPage();
            }
            $firstPage = false;

            // Render sections from dailychecks2
            renderSection($pdf, $con, $sno, $dt, $txname, $ename, 'dailychecks2');

            // Render additional sections from dailychecks3 if name1 exists
            if (!empty($checkData['name1'])) {
                // $pdf->AddPage();
                renderSection($pdf, $con, $sno, $dt, $txname, $ename, 'dailychecks3');
            }
        }
    }
}




// Ensure upload directory exists
$uploadDir = $_SERVER['DOCUMENT_ROOT'] . "/finemed/dailycal/pdf/";
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Generate safe filename
$safeSid = (int)$sid;
$safeDate = preg_replace('/[^a-zA-Z0-9_-]/', '', $cdate);
$filename = "Merge_report_{$safeSid}_{$safeDate}.pdf";
$filepath = $uploadDir . $filename;

// Save PDF
$pdf->Output($filepath, "F");

// Verify PDF was created
if (!file_exists($filepath)) {
    die('Error: Failed to generate PDF file.');
}


$_SESSION['all_table_ids'] = $allTableIds;

$dailychecksid = implode(",", array_column($allTableIds, 'dailychecks_id'));
$dailycheckssid = implode(",", array_column($allTableIds, 'dailycheckss_id'));



?>


<div class="main-content">
    <div class="breadcrumb">
        <h1><?php echo htmlspecialchars($headingname); ?></h1>
        <ul>
            <li><a href="#">Home</a></li>
            <li>Daily Checks</li>
        </ul>
    </div>

    <div class="card">
        <div class="card-body">
            <h3>Checks Report For <?php echo $cdate; ?></h3>
            <div class="button-container">
                <a href="admin.php?id=dailycal&sid=<?php echo $sid; ?>">
                    <button class="btn btn-success mb-3" style="float: right;">← Go Back</button>
                </a>
            </div>
            <?php if ($vxcx == 0) {
            ?>

                <h3 style="margin-top: 20px; color: red; text-align: center; font-size: 20px;">No Checks Pending for Verification</h3>
            <?php
            } else {
            ?>


                <?php if (file_exists($filepath)): ?>
                    <iframe src="upl1/<?php echo urlencode($filename); ?>" width="100%" height="600px">
                        Your browser does not support PDF viewing.
                        <a href="upl1/<?php echo urlencode($filename); ?>">Download the PDF</a>
                    </iframe>
                <?php else: ?>
                    <div class="alert alert-danger">
                        PDF file not found. Please try generating again.
                    </div>
                <?php endif; ?>

                <div class="clearfix"></div>

                <div class="form" style="margin-top: 20px;">
                    <form action="" method="post">
                        <input type="hidden" name="dailychecksid" value="<?php echo $dailychecksid; ?>">
                        <input type="hidden" name="dailycheckssid" value="<?php echo $dailycheckssid; ?>">
                        <input type="hidden" name="cdate" value="<?php echo $cdate; ?>">
                        <input type="hidden" name="sid" value="<?php echo $sid; ?>">
                        <button type="submit" class="btn btn-primary" target="_blank" name="verify">Next & Verify →</button>
                    </form>
                </div>


            <?php
            }

            ?>

        </div>
    </div>
</div>
<?php 
if (isset($_POST['verify'])) {
    $dailychecksid = $_POST['dailychecksid'];
    $dailycheckssid = $_POST['dailycheckssid'];
    $cdate = $_POST['cdate'];
    $sid = $_POST['sid'];

    $sqll = mysqli_query($con, "INSERT INTO `tbldailyverify`(`checkid`, `checkssid`, `cdate`) VALUES ('$dailychecksid','$dailycheckssid','$cdate')");
    $sqllid = mysqli_insert_id($con);


    echo "<script> window.location.href = 'admin.php?id=mergesign&sno=$sqllid&sxid=$sid';</script>";
}



?>