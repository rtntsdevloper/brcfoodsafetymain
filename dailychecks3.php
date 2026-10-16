<?php
include 'connection.php';
$sno = $_GET['sno'];

$tid = $_GET['tid'];
$sq2 = mysqli_query($con, "select * from dailychecks where id='$tid'");
$qu2 = mysqli_fetch_array($sq2);
$tname = $qu2['name'];


$sql1 = mysqli_query($con, "select * from dailycheckss where id='$sno'");
$roww = mysqli_fetch_array($sql1);
if (isset($roww['verifysign']) && !empty($roww['verifysign'])) {
    $sign = $roww['verifysign'] . ".png";
} else {
    $sign = "Blank.jpg";
}

if (isset($roww['msign']) && !empty($roww['msign'])) {
    $msign = $roww['msign'] . ".png";
} else {
    $msign = "Blank.jpg";
}

$gh = mysqli_query($con, "select * from dailychecks where id='$roww[name]'");
$gh1 = mysqli_fetch_array($gh);
$test = $gh1['name'];

$sql = mysqli_query($con, "select * from dailychecks2 where cid='$sno'");
$row = mysqli_fetch_array($sql);
$date = $row['date'];




$dt = date("d-m-Y", strtotime($roww['date']));
$tm = date("H:i", strtotime($roww['time']));

require('tcpdf/tcpdf.php');

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

        $this->Image($image_file, 15, 5, 20, '', 'png', '', 'T', false, 200, '', false, false, 0, false, false, false);
        $this->Image($image_file1, 170, 5, 35, '', 'png', '', 'T', false, 200, '', false, false, 0, false, false, false);

        $this->SetFont('courier', '', 20);
        $this->SetXY(70, 2);
        $this->Write(25, 'Daily Checks Report', '', 0, '30', true, 0, false, false, 0);
    }


    public function Footer()
    {
        // Set position at 25 mm from bottom
        $this->SetY(-25);

        // Set font
        $this->SetFont('courier', '', 9);

        // Footer content with improved styling
        $footerContent = '
        <table border="0.1" cellpadding="4">
            <tr>
                <td width="33%">Issue date: ' . htmlspecialchars($this->footerData['issuedate']) . '</td>
                  <td width="33%"  style="text-align:center;" rowspan="2">Page ' . $this->getAliasNumPage() . ' of ' . $this->getAliasNbPages() . '</td>
                <td width="33%">Author: ' . htmlspecialchars($this->footerData['author']) . '</td>
            </tr>
            <tr>
            
<td width="33%" >Version: ' . htmlspecialchars($this->footerData['version']) . '</td>
             
                <td width="33%" >Authorised by: ' . htmlspecialchars($this->footerData['authorisedby']) . '</td>
            </tr>
            <tr>
                <td  width="33%" >Reason for Change: ' . htmlspecialchars($this->footerData['reason']) . '</td>
               
                <td width="66%" colspan="2" >Print on: ' . date('d/m/Y H:i') . '</td>
            </tr>
        </table>';

        $this->writeHTML($footerContent, true, false, true, false, '');
    }
}

$qsp = mysqli_query($con, "SELECT * FROM `tblformcontrol` WHERE id='2'");
$qsp1 = mysqli_fetch_array($qsp);

// Prepare footer data
$qspdate = $qsp1['issuedate'];
$footerData = [
    'issuedate' => $qsp1['issuedate'],
    'docref' => $qsp1['docref'], // Fallback value
    'author' => $qsp1['author'],
    'authorisedby' => $qsp1['authoriesby'],
    'version' => $qsp1['version'],
    'refno' => $qsp1['refno'],
    'reason' => $qsp1['reason']
];
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', $footerData);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);


$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->SetAutoPageBreak(TRUE, 30);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
    $pdf->setLanguageArray($l);
}


$pdf->AddPage('P', 'A4');
$pdf->SetMargins(10, 45, 10, 10);
// $pdf->WriteHTMLCell(0, 0, 60, $pdf->GetY(), $image_file, 0, 1);

$pdf->SetFont('courier', '', 14);
$pdf->SetXY(15, 40);
$pdf->Write(0, "Date:$dt $tm", '', '0', '0', true, 'C', false, false, 0);
$pdf->SetXY(15, 47);
// $pdf->Write(0, "Time:$tm", '', '0', '0', true, 'C', false, false, 0);
// $pdf->SetXY(15, 54);



$pdf->Write(0, "$tname", '', '0', '0', true, 'C', false, false, 0);
$pdf->SetXY(15, 55);
$pdf->Write(0, "Attempted By:$roww[ename]", '', '0', '0', true, 'C', false, false, 0);
$pdf->SetXY(15, 75);
$pdf->SetFont('centurygothic', '', 20);





$pdf->SetXY(10, 30);


$pdf->SetFont('courier', '', 11);
$tbl_header = '<style>
table {
   
   border-radius: 1px;
   
}
tr {
   padding: 3px 0;
}

th {
      background-color:#F0F0F0;
   color: #000000;
  
   font-size: 14px;
  
   padding-bottom: 4px;
   padding-left: 8px;
   padding-top: 5px;
   text-align: left;
}
td {
  
 
   font-size: 15px;
   color: #000000;
   padding: 3px 7px 2px;
}
</style>
<table id="gallerytab" width="50%" cellspacing="0" cellpadding="5" border="0.1">
  ';

$tbl_footer = '</table>';
$pdf->SetXY(15, 65);

$tbl1 = '';

$ghf1 = mysqli_query($con, "select distinct section from dailychecks2 where cid='$sno'");
while ($rowsf1 = mysqli_fetch_array($ghf1)) {

    $tbl1 .= '
  <tr nobr="true"> 
      <td width="620" style="text-align:center;color:blue;font-size:18px" >Section: ' . htmlspecialchars($rowsf1['section'], ENT_QUOTES, 'UTF-8')
        . '</td>
     
   </tr>
   ';
    $inc = 0;
    $ghf = mysqli_query($con, "select * from dailychecks2 where cid='$sno' and section='" . $rowsf1['section'] . "'");
    while ($rowsf = mysqli_fetch_array($ghf)) {
        $inc++;



        $tbl1 .= '<tr >
    <td width="120">Question ' . $inc . ' </td>
    <td width="500">' . $rowsf['ques'] . '</td>
</tr>';

        $tbl1 .= '<tr nobr="true"><td width="120">Answer</td><td width="500">';

        if (!empty($rowsf['input'])) {
            if ($tid == 5) {
                $inputVal = (int) $rowsf['input'];
                if ($inputVal) {
                    if ($inputVal > 10) {
                        $tbl1 .= $inputVal . '<p  style="color:red;">Fail</p>';
                    } else {
                        $tbl1 .= $inputVal . '<p  style="color:green;">Pass</p>';
                    }
                }
            } else {
                $tbl1 .= $rowsf['input'];
            }
        }

        if (!empty($rowsf['answer'])) {
            $tbl1 .= $rowsf['answer'];
        } elseif (!empty($rowsf['dateinput'])) {
            $dtinput = str_replace('T', ' ', $rowsf['dateinput']);
            $dtinput = date('d-m-Y H:i', strtotime($dtinput));
            $tbl1 .= $dtinput;
        } else {
            $tbl1 .= $rowsf['ans'];
        }

        $tbl1 .= '</td></tr>';


        // Close the row

        if ($rowsf['cmnt'] != "") {
            $tbl1 .= '<tr nobr="true"> 
	 <td width="120"  >Comment</td>
       <td  width="500" style="color:green">' . $rowsf['cmnt'] . '</td>
   </tr>';
        }
        $pics = !empty($rowsf['pic']) ? json_decode($rowsf['pic'], true) : [];
        if (!empty($pics) && is_array($pics)) {
            foreach ($pics as $pic) {
                if (!empty($pic)) {
                    $tbl1 .= '
  <tr nobr="true"> 
      <td width="120" ></td>
       <td  width="500" ><img src="upl1/' .$pic. '" width="100"></td>
   </tr>
';
                }
            }
        } elseif (!empty($rowsf['pic'])) {
            $tbl1 .= '
  <tr nobr="true"> 
      <td width="120" ></td>
       <td  width="500" ><img src="upl1/' . $rowsf['pic'] . '" width="100"></td>
   </tr>
';
        }
    }
}
$pdf->writeHTML($tbl_header . $tbl1 . $tbl_footer, true, false, false, false, '');

if (($tid == 7) || ($tid == 8) || ($tid == 9)) {
    $tbl3 = '';


    $tbl3 .= '
  

   <tr nobr="true" > 
      <td  width="620" style="color:red;">After CIP cleaning, take water sample for pH test.<br>
       pH meter reading should be between 7.00pH-8.00pH. If pH reading is outside this range, inform Production
Manager and re-rinse and rechecked.</td>
       
   </tr>
   ';


    $pdf->writeHTML($tbl_header . $tbl3 . $tbl_footer, true, false, false, false, '');
}
// $pdf->SetXY(10, -20);
$tbl2 = '';
if (isset($sign) && !empty($sign)) {
    $tbl2 .= '
  <tr nobr="true" > 
      <td width="120" >Signature</td>
       <td  width="500" ><img src="upl1/' . $sign . '" width="100"></td>
       
   </tr>
   ';
} else {
    $tbl2 .= '
  <tr nobr="true" > 
      <td width="120" >Signature</td>
       <td  width="500" ></td>
       
   </tr>
   ';
}

if (isset($roww['msign']) && !empty($roww['msign'])) {
    $tbl2 .= '
  <tr nobr="true"> 
     
        <td width="120" >Manager Signature</td>
       <td  width="500" ><img src="upl1/' . $msign . '" width="100"></td>
   </tr>

   ';
}
$pdf->writeHTML($tbl_header . $tbl2 . $tbl_footer, true, false, false, false, '');









$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "/upl1/Dailychecks" . $tid . $date . ".pdf", "F");

// require_once('PHPExcel/PHPExcel.php');

// $objPHPExcel = new PHPExcel();
// $sheet = $objPHPExcel->setActiveSheetIndex(0);

// // Set portrait orientation
// $sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);

// // Get all sections and questions in ascending order (globally)
// $orderedQuestions = array();
// $ghf_questions = mysqli_query($con, "SELECT section, ques FROM dailychecks2 WHERE cid='$sno' ORDER BY id ASC");
// while ($row_question = mysqli_fetch_array($ghf_questions)) {
//     $orderedQuestions[] = array(
//         'section' => $row_question['section'],
//         'question' => $row_question['ques']
//     );
// }

// // Set headers in order
// $col = 0;
// foreach ($orderedQuestions as $sq) {
//     $header = $sq['section'] . " - " . $sq['question'];
//     $sheet->setCellValueByColumnAndRow($col, 1, $header);
//     $col++;
// }

// // Add additional headers
// $additionalHeaders = array('Comment', 'Date', 'Verified By');
// foreach ($additionalHeaders as $header) {
//     $sheet->setCellValueByColumnAndRow($col, 1, $header);
//     $col++;
// }

// // Fetch and organize data (sorted by section and question)
// $rowNum = 2;
// $ghf_data = mysqli_query($con, "SELECT * FROM dailychecks2 WHERE cid='$sno' ORDER BY section, ques");
// $currentRecord = array();

// while ($rowsf = mysqli_fetch_array($ghf_data)) {
//     $key = $rowsf['section'] . " - " . $rowsf['ques'];

//     // Determine answer
//     $answer = '';
//     if (!empty($rowsf['input'])) {
//         $answer = $rowsf['input'];
//     } elseif (!empty($rowsf['answer'])) {
//         $answer = $rowsf['answer'];
//     } elseif (!empty($rowsf['dateinput'])) {
//         $dtinput = str_replace('T', ' ', $rowsf['dateinput']);
//         $answer = date('d-m-Y H:i', strtotime($dtinput));
//     } else {
//         $answer = $rowsf['ans'];
//     }

//     $currentRecord[$key] = $answer;
//     $currentRecord['cmnt'] = $rowsf['cmnt'];
//     $currentRecord['dt'] = $dt;
//     $currentRecord['ename'] = $roww['ename'];
// }

// // Write the organized data to Excel
// if (!empty($currentRecord)) {
//     $col = 0;
//     foreach ($orderedQuestions as $sq) {
//         $key = $sq['section'] . " - " . $sq['question'];
//         $sheet->setCellValueByColumnAndRow($col, $rowNum, $currentRecord[$key] ?? '');
//         $col++;
//     }

//     // Add additional data
//     $sheet->setCellValueByColumnAndRow($col++, $rowNum, $currentRecord['cmnt'] ?? '');
//     $sheet->setCellValueByColumnAndRow($col++, $rowNum, $currentRecord['dt'] ?? '');
//     $sheet->setCellValueByColumnAndRow($col, $rowNum, $currentRecord['ename'] ?? '');
// }

// // Style headers
// $headerStyle = $sheet->getStyle('A1:' . $sheet->getHighestColumn() . '1');
// $headerStyle->getFont()->setBold(true);
// $headerStyle->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

// // Auto-size columns
// for ($col = 0; $col < count($orderedQuestions) + count($additionalHeaders); $col++) {
//     $sheet->getColumnDimensionByColumn($col)->setAutoSize(true);
// }

// // Save Excel file
// $excelFileName = "dailychecks_" . $sno . "_" . date('Y-m-d') . ".xlsx";
// $excelFilePath = $_SERVER['DOCUMENT_ROOT'] . "jaspreet/brcfoodsafety/upl1/" . $excelFileName;
// $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
// $objWriter->save($excelFilePath);
?>
<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>Daily Checks </li>
        </ul>
    </div>
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">


                    <a href="admin.php?id=dailychecks&tid=<?php echo $tid; ?>"><button class="btn btn-success"
                            style="float:right; margin-left:15px">Go Back</button></a>

                    <?php $name = "upl1/Dailychecks" . $tid . $date . ".pdf"; ?>
                    <a href="<?php echo $name; ?>" target="_blank"><button class="btn btn-warning"
                            style="float:right; margin-left:15px">View Report</button></a>
                    <!-- <a href="admin.php?id=dailychecks1&tid=<?php echo $tid ?>&cid=<?php echo $sno ?>"
                        target="_blank"><button class="btn btn-info"
                            style="float:right; margin-left:15px">Edit</button></a> -->
                    <h4 class="card-title mb-3"><?php echo $tname; ?></h4>



                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="zero_configuration_table"
                            style="width:100%">
                            <thead>
                                <th width="5">Sno</th>
                                <th width="10">Date</th>
                                <th width="10"> Name </th>
                                <th width="15">Question</th>
                                <th width="20">Answer</th>

                                <th width="10">Comment</th>

                            </thead>
                            <tbody>
                                <?php
                                $sql = mysqli_query($con, "select * from dailychecks2 where cid='$sno'");
                                $n = 0;
                                while ($row2 = mysqli_fetch_array($sql)) {

                                    $n++;

                                    ?>
                                    <tr>
                                        <td>
                                            <div align="center"> <?php echo $n; ?> </div>
                                        </td>
                                        <td> <?php echo $dt; ?> </td>
                                        <td> <?php echo $tname; ?> </td>
                                        <td> <?php echo $row2['ques']; ?> </td>
                                        <td>
                                            <?php
                                            if ($tid == 5) {
                                                if ((int) $row2['input']) {
                                                    if ((int) $row2['input'] < 10) {
                                                        echo $row2['input'] . '<p class="text-success">Pass</p>';
                                                    } else {
                                                        echo $row2['input'] . '<p class="text-danger">Fail</p>';
                                                    }
                                                }
                                            } else {
                                                $t = '';

                                                // Prioritize 'answer' > 'dateinput' > 'input'
                                                if (!empty($row2['answer'])) {
                                                    $t = $row2['answer'];
                                                } elseif (!empty($row2['dateinput'])) {
                                                    $dtinput = str_replace('T', ' ', $row2['dateinput']);
                                                    $t = date('d-m-Y H:i', strtotime($dtinput));
                                                } elseif (!empty($row2['input'])) {
                                                    $t = $row2['input'];
                                                } elseif (!empty($row2['ans'])) {
                                                    $t = $row2['ans'];
                                                }

                                                // Output answer text
                                                echo htmlspecialchars($t);

                                                // Output image link if exists
                                        
                                                // Decode the JSON stored in $row2['pic']
                                                $pics = !empty($row2['pic']) ? json_decode($row2['pic'], true) : [];

                                                // If decoding failed or it's a plain string (old format), treat it as a single file
                                                if (!is_array($pics) && !empty($row2['pic'])) {
                                                    $pics = [$row2['pic']];
                                                }

                                                if (!empty($pics)) {
                                                    foreach ($pics as $file) {
                                                        $file = htmlspecialchars($file);
                                                        echo '<a target="_blank" href="upl1/' . $file . '">' . $file . '</a><br>';
                                                    }
                                                }

                                            }

                                            ?>
                                        </td>
                                        <td><?php echo $row2['cmnt']; ?></td>

                                        <?php
                                }
                                ?>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>