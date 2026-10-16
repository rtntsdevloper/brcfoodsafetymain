<?php
$pid = $_GET['eid'];

$rnm = mysqli_query($con,"SELECT * FROM `pw_qmsmetal` WHERE id='$pid'");
$rnm1 = mysqli_fetch_array($rnm);




require('tcpdf/tcpdf.php');

class MYPDF extends TCPDF
{
    private $longTableFooter = '';


    public function Header()
    {

        $image_file = 'images/1.png';
        $image_file1 = 'images/rtnts.png';

        $this->Image($image_file, 15, 5, 20, '', 'png', '', 'T', false, 200, '', false, false, 0, false, false, false);
        $this->Image($image_file1, 255, 5, 28, '', 'png', '', 'T', false, 200, '', false, false, 0, false, false, false);

        $this->SetFont('courier', '', 18);
        $this->SetXY(57, 2);
        $this->Write(25, 'QMS Metal Detector Fail Safe Test(For Retail)', '', 0, '30', true, 0, false, false, 0);


        $this->Line(8, 25, 294, 25);
    }
    public function Footer()
    {

        $this->SetFont('courier', '', 8);
        $this->SetXY(8, -20);
        $this->writeHTML($this->longTableFooter);
    }
    public function setLongTableFooter($html)
    {
        $this->longTableFooter = $html;
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
$pdf->AddPage('L', 'A4');

$sqq = mysqli_query($con, "SELECT * FROM tblformcontrol WHERE id = 1");
$roww = mysqli_fetch_assoc($sqq);



$footer = <<<EOD

<table width="104%" cellpadding="4" border="0.2" style="font-size:11px;  border-color:#000000; color:black;">
    <tr>
        <td width="33%">Issue date: 07/07/2025</td>
        <td width="34%"  align="center">Rec- 2.10.3</td>
        <td width="33%">Author : Mahesh Prajpati</td>
    </tr>
    <tr>
        <td width="33%" >Version No: 04</td>
       <td width="34%"  align="center">Page {$pdf->getAliasNumPage()}/{$pdf->getAliasNbPages()}</td>
        <td width="33%" >Authorised By: Nishita Rai</td>
    </tr>
    <tr>
        <td width="100%" colspan="2" >Reason for change: Revised Document</td>
        
    </tr>
</table>
EOD;
$pdf->setLongTableFooter($footer);



$pdf->setxy(8, 30);
$pdf->SetFont('courier', '', 11);

$tbl_header = '<style>
table {
   border-collapse: collapse;
   border-spacing: 0;
   margin: 15px 10px;
   border: 1px solid #333333;
}
tr {
   padding: 3px 0;
}
th {
   background-color: #4a7ab5;
   color: white;
   font-weight: bold;
   padding: 6px 4px;
   border: 1px solid #333333;
   text-align: center;
   font-size: 15px;
}
td {
   padding: 5px 4px;
   border: 1px solid #999999;
}

</style>
';

$tbl1 = '';



$tbl1 .= '<table width="104%" cellspacing="0" cellpadding="3" border="1">
 
   <tr>
      <th width="6%">#</th>
      <th width="14%">Test</th>
      <th width="25%">Purpose of test</th>
      <th width="15%">Result</th>
      <th width="20%">Corrective Action</th>
      <th width="20%">Comment</th>
   </tr>';

$sql23 = mysqli_query($con, "SELECT * FROM `pw_qmsmetal1` where pid='$pid'");
$i = 0;

while ($row23 = mysqli_fetch_array($sql23)) {
    $i++;
    if ($row23['result'] == 'Pass') {
        $pcolor = 'green';
    } else {
        $pcolor = 'red';
    }


    $tbl1 .= '
        <tr nobr="true">
            <td width="6%" class="serial-cell" style="text-align:center;">' . $i . '</td>
            <td width="14%" style="text-align:center;">' . $row23['test'] . '</td>
            <td width="25%" class="document-cell" style="text-align:left;padding-left:8px;">' . $row23['ques'] . '</td>
            <td width="15%" class="date-cell" style="text-align:center;color:' . $pcolor . '">' . $row23['result'] . '</td>
            <td width="20%" style="text-align:center;">' . $row23['correct'] . '</td>
            <td width="20%" style="text-align:left;padding-left:8px;">' . $row23['cmnt'] . '</td>
        </tr>';
}



$tbl1 .= '</table>';


$pdf->writeHTML($tbl_header . $tbl1, true, false, false, false, '');

$pdf->setX(8);

$pdf->ln(30);
$opsign = '
<table cellpadding="4" width="100%" border="0">
    <tr>
        <td width="30%"><img src="paperwork/sign/'.$rnm1['completeby'].'.png" alt="" width="200" height="70"></td>
        <td width="30%"></td>
        <td width="40%"><img src="paperwork/sign/'.$rnm1['checkby'].'.png" alt="" width="200" height="70"></td>
    </tr>
    <tr>
        <th width="30%" align="left">Operator Signature</th>
        <td width="30%"></td>
        <th width="40%" align="left">Manager/Supervisor Signature</th>
    </tr>
    <tr>
        <th width="30%" align="left"></th>
        <td width="30%"></td>
        <td width="40%">Manager/Supervisor Name: '.$rnm1['checkname'].' </td>
    </tr>
</table>';

$pdf->writeHTML($opsign, true, false, false, false, '');









$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "finemed/paperwork/pdf/qmsmetal.pdf", "F");



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


                    <a href="admin.php?id=pw_qsmetal"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                    <h4 class="card-title mb-3">QMS Metal Detector Fail Safe Test Form (For Retail)</h4>
                    <iframe src="paperwork/pdf/qmsmetal.pdf" width="100%" height="800" class="mt-3"></iframe>
                </div>
            </div>
        </div>