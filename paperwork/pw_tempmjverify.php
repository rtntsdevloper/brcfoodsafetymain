<?php

$pdate = $_GET['pdate'];
$signx = $_GET['signx'];
$rnm = mysqli_query($con, "SELECT * FROM `oven_temperature_monitoring` WHERE pdate='$pdate'");
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

        $this->SetFont('courier', '', 17);
        $this->SetXY(48, 2);
        $this->Write(25, 'Temperature Record Sheet for Oat Milk Jelly for Oven CCP', '', 0, '30', true, 0, false, false, 0);
       

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
        <td width="33%">Issue date: 18/03/2026</td>
        <td width="34%"  align="center">Doc Ref: PRO- 2.10.2.1</td>
        <td width="33%">Author: Nishan E</td>
    </tr>
    <tr>
        <td width="33%" >Version No: 03</td>
       <td width="34%"  align="center">Page {$pdf->getAliasNumPage()}/{$pdf->getAliasNbPages()}</td>
        <td width="33%" >Authorised By: Mahesh P</td>
    </tr>
    <tr>
        <td width="100%" colspan="2" >Reason for change: Reviewed</td>
        
    </tr>
</table>
EOD;
$pdf->setLongTableFooter($footer);



$pdf->SetXY(15, 40);

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



$tbl1 .= '

<br>

<table width="104%" cellspacing="0" cellpadding="3" border="1">
<tr>
 
   <th width="5%">S No.</th>
                                    
                                    <th width="10%">Date</th>
                                    <th width="10%">Tray No as per rack</th>
                                    <th width="10%">Starting Temp</th>
                                    <th width="10%">Oven Programme set temperature</th>
                                    <th width="11%">Time in Oven</th>
                                    <th width="16%">Time and TEMP 1 AFTER 1 hour (Min 80 deg c)</th>
                                    <th width="16%">Time and TEMP 2 AFTER temp 1 ANOTHER 10 MIN</th>
                                    <th width="12%">Sign</th>

</tr>
';

$sql23 = mysqli_query($con, "SELECT * FROM `oven_temperature_monitoring` WHERE pdate='$pdate'");
$i = 0;

while ($row23 = mysqli_fetch_array($sql23)) {
    $i++;


    $tbl1 .= '
        <tr nobr="true" style="text-align:center;">
            <td width="5%" >' . $i . '</td>
            <td width="10%">' . date('d-m-Y', strtotime($rnm1['pdate'])) . '</td>
            <td width="10%" >' . $row23['tray_no'] . '</td>
            <td width="10%" >' . $row23['starting_temp'].'<sup>o</sup>C</td>
            <td width="10%" >' . $row23['oven_programme_temp'].'<sup>o</sup>C</td>
            <td width="11%" >' . $row23['time_in_oven'] . '</td>
            <td width="16%" >' . $row23['temp1_time'] . ' / ' . $row23['temp1_value'].'<sup>o</sup>C</td>
            <td width="16%" >' . $row23['temp2_time'] . ' / ' . $row23['temp2_value'].'<sup>o</sup>C</td>
            <td width="12%" ><img src="paperwork/sign/' . $row23['sign'] . '.png" alt="" width="100" height="40"></td>
        </tr>';
}



$tbl1 .= '</table>';


$pdf->writeHTML($tbl_header . $tbl1, true, false, false, false, '');

$pdf->setX(8);

$pdf->ln(30);
$opsign = '';

$opsign .= '
<table cellpadding="4" width="104%" border="1">
    <tr>
        <td width="50%"><b>Operator Signature :</b>';

if (!empty($rnm1['operator'])) {

    $opsign .= '<img src="paperwork/sign/' . $rnm1['operator'] . '.png" alt="" width="200" height="70">';
}

$opsign .= ' </td>
        <td width="50%"><b>Manager Signature :</b>';

if (!empty($rnm1['manager'])) {
    $opsign .= '<img src="paperwork/sign/' . $rnm1['manager'] . '.png" alt="" width="200" height="70">';
}
$opsign .= '
</td>
    </tr>
    <tr>
        <th width="50%" align="left"><b>Operator Name :</b>';
        $opsign .= $rnm1['opname'];
        $opsign .= '</th>
        <td width="50%" align="left"><b>Manager Name :</b>';
        $opsign .= $rnm1['mname'];
        $opsign .= '</td>
    </tr>
   
</table>';

$pdf->writeHTML($opsign, true, false, false, false, '');









$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "finemed/paperwork/pdf/Oven_temp_" . $pdate . ".pdf", "F");



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


                    <a href="admin.php?id=pw_tempmj"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                  

                    <h4 class="card-title mb-3"> Oven Temperature Monitoring Form</h4>
                    <br><br>

                    <iframe src="paperwork/pdf/Oven_temp_<?php echo $pdate; ?>.pdf" frameborder="1" width="100%" height="600px"></iframe>
                    <br>
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4"> <a href="admin.php?id=pw_tempmjsign&pdate=<?php echo $pdate; ?>&signx=<?= $signx ?>" class="btn btn-success form-control">Verify</a> </div>
                        <div class="col-md-4">

                        </div>

                    </div>

                </div>
            </div>
        </div>