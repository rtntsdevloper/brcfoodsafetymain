<?php


require('tcpdf/tcpdf.php');

class MYPDF extends TCPDF
{
    private $longTableFooter = '';
    public function Header()
    {




        $image_file = 'images/1.png';
        $image_file1 = 'images/rtnts.png';

        $this->Image($image_file, 15, 5, 20, '', 'png', '', 'T', false, 200, '', false, false, 0, false, false, false);
        $this->Image($image_file1, 225, 5, 35, '', 'png', '', 'T', false, 200, '', false, false, 0, false, false, false);

        $this->SetFont('courier', '', 20);
        $this->SetXY(90, 2);
        $this->Write(25, 'Calibration Report', '', 0, '30', true, 0, false, false, 0);
    }
   public function Footer()
  {
    $this->SetY(-20);
    $this->SetFont('courier', '', 10);
    $this->SetTextColor(0, 0, 0);

    // Footer line

    // Custom footer HTML if set
    if (!empty($this->footerHTML)) {
      $this->SetY(-20);
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
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, false, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);

$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
    $pdf->setLanguageArray($l);
}

$pdf->AddPage('L', 'LETTER');


$sqq = mysqli_query($con, "SELECT * FROM tblformcontrol WHERE id = '1'");
$roww = mysqli_fetch_assoc($sqq);
// Assuming 'issue_date' and 'authorised_by' are columns in your table
if (!empty($roww['issuedate']) && $roww['issuedate'] != '0000-00-00') {
  $issueDate = date('d/m/Y', strtotime($roww['issuedate']));
} else {
  $issueDate = '';
}
$pageNum = $pdf->getAliasNumPage();
$pageTotal = $pdf->getAliasNbPages(); // This will not resolve correctly

$footerContent = <<<EOD
<table border="1" cellpadding="5" width="100%">
    <tr>
        <td width="38%">Issue date: {$issueDate}</td>
        <td width="26%">Version No: {$roww['version']}</td>
        <td width="36%">Prepared by: {$roww['author']}</td>
    </tr>
    <tr>
        <td width="38%">Reason for change: {$roww['reason']}</td>
        <td width="26%">Page No: {$pageNum} of {$pageTotal}</td>
        <td width="36%">Authorised by: {$roww['authoriesby']}</td>
    </tr>
</table>
EOD;

$pdf->setFooterHTML($footerContent);
// GMP audit pie chart



$pdf->SetXY(15, 45);
$pdf->Line(15, 25, 263, 25);

$pdf->SetFont('courier', '', 11);

$tbl_header = '<style>
table {
   border-collapse: collapse;
   border-spacing: 0;
   margin: 0 10px;
   border:0.5px solid #000000;
}
tr {
   padding: 1px 0;
}
th {
   padding: 1px 0;
   color:black;
   font-weight:bold;
}


</style>
<table id="gallerytab" width="100%" cellspacing="0" cellpadding="3" border="0.2" align="center">



';
$tbl_footer = '</table>';


$tbl1 = '';
$tbl1 .= '
 <tr nobr="true" style="background-color:aliceblue;"> 
         <th scope="col" style="width:5%">#</th>
                                    <th scope="col" style="width:11%">Equipment</th>
                                    <th scope="col" style="width:11%">Location</th>
                                    <th scope="col" style="width:11%">Calibration</th>
                                    <th scope="col" style="width:13%">Calibration Date</th>
                                    <th scope="col" style="width:13%">Calibration Due Date</th>
                                    <th scope="col" style="width:10%">Frequency</th>
                                    <th scope="col" style="width:13%">Certification No.</th>
                                    <th scope="col" style="width:13%">Calibration Report</th>
   </tr>

';

$sql = mysqli_query($con, "select * from tblequipment where calbap='Yes' and status='Active'");

$i = 0;
while ($roweq = mysqli_fetch_array($sql)) {
    $sno = $roweq['id'];
    $sqleq = mysqli_query($con, "SELECT * FROM `tblcalbhistory` WHERE `vid` = '$sno' and `status`='Active'");
    $row = mysqli_fetch_array($sqleq);
    $i++;

    $tbl1 .= '
  <tr nobr="true"> 
   <td  >' . $i . '</td>
         <td  >' . $roweq['name'] . '</td>
       <td  >' . $roweq['location'] . '</td>
       <td  >' . $row['clabi'] . '</td>
       <td >' . date('d-m-Y', strtotime($row['caldate'])) . '</td>
       <td  >' . date('d-m-Y', strtotime($row['caldue'])) . '</td>
       <td >' . $row['frequency'] . '</td>
       <td >' . $row['certno'] . '</td>
       <td >';

    if (isset($row['calfile']) && !empty($row['calfile'])) {
        $tbl1 .= '<a href="upl1/' . $row['calfile'] . '" target="_blank">View Report</a>';
    } else {
        $tbl1 .= '';
    }

    $tbl1 .= '</td>
   </tr>
';
}

$pdf->writeHTML($tbl_header . $tbl1 . $tbl_footer, true, false, false, false, '');





$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "finemed/upl1/Equipment_Calibration_Report.pdf", "F");



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


                    <a href="admin.php?id=dailyrawview&sno=<?php echo $sno; ?>"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

                    <h4 class="card-title mb-3">Product Checks Report</h4>

                    <iframe src="upl1/Equipment_Calibration_Report.pdf" width="100%" height="500px">

                    </iframe>



                </div>
            </div>
        </div>