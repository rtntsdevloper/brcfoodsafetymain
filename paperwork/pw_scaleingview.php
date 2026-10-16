<?php
$pid = $_GET['eid'];

$rnm = mysqli_query($con, "SELECT * FROM `pw_scaleing` WHERE id='$pid'");
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
        <td width="33%">Issue date: 16/07/2025</td>
        <td width="34%"  align="center">Rec- 2.10.2</td>
        <td width="33%">Author : Stacey Gibson</td>
    </tr>
    <tr>
        <td width="33%" >Version No: 01</td>
       <td width="34%"  align="center">Page {$pdf->getAliasNumPage()}/{$pdf->getAliasNbPages()}</td>
        <td width="33%" >Authorised By: Nishita Rai</td>
    </tr>
    <tr>
        <td width="100%" colspan="2" >Reason for change: New Document</td>
        
    </tr>
</table>
EOD;
$pdf->setLongTableFooter($footer);


$pdf->SetFont('courier', '', 14);
$pdf->SetXY(15, 40);
$pdf->Write(0, "Date: " . date('d-m-Y', strtotime($rnm1['date'])), '', '0', '0', true, 'C', false, false, 0);
$pdf->SetXY(170, 40);
$pdf->Write(0, "Batch Number of Blue Bag : $rnm1[bluebag]", '', '0', '0', true, 'C', false, false, 0);
$pdf->SetXY(15, 60);

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
 
   <th width="6%">S No.</th>
                                    <th width="14%">Date</th>
                                    <th width="25%">Ingredient</th>
                                    <th width="20%">Product Batch Number</th>
                                    <th width="20%">Best Before Date</th>
                                    <th width="15%">Quantity</th>
</tr>
';

$sql23 = mysqli_query($con, "SELECT * FROM `pw_scaleing1` where eid='$pid'");
$i = 0;

while ($row23 = mysqli_fetch_array($sql23)) {
    $i++;


    $tbl1 .= '
        <tr nobr="true" style="text-align:center;">
            <td width="6%" >' . $i . '</td>
            <td width="14%">' . date('d-m-Y', strtotime($rnm1['date'])) . '</td>
            <td width="25%" >' . $row23['ingname'] . '</td>
            <td width="20%" >' . $row23['batchno'] . '</td>
            <td width="20%" >' . $row23['bestbefore'] . '</td>
            <td width="15%" >' . $row23['quantity'] . '</td>
        </tr>';
}



$tbl1 .= '</table>';


$pdf->writeHTML($tbl_header . $tbl1, true, false, false, false, '');

$pdf->setX(8);

$pdf->ln(30);
$opsign = '';

$opsign .= '
<table cellpadding="4" width="100%" border="1">
    <tr>
        <td width="50%"><b>Supervisor Signature :</b>';

if (!empty($rnm1['supervisor'])) {

    $opsign .= '<img src="paperwork/sign/' . $rnm1['supervisor'] . '.png" alt="" width="200" height="70">';
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
        <th width="50%" align="left"><b>Supervisor Remark :</b>';
        $opsign .= $rnm1['sremark'];
        $opsign .= '</th>
        <td width="50%" align="left"><b>Manager Remark :</b>';
        $opsign .= $rnm1['mremark'];
        $opsign .= '</td>
    </tr>
   
</table>';

$pdf->writeHTML($opsign, true, false, false, false, '');









$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "finemed/paperwork/pdf/Scale_ing_" . $pid . ".pdf", "F");



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


                    <a href="admin.php?id=pw_scaleing"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                    <a href="admin.php?id=pw_scaleingadd1&eid=<?php echo $pid; ?>"><button class="btn btn-primary" style="float:right; margin-left:15px">Add New</button></a>
                    <a href="paperwork/pdf/Scale_ing_<?php echo $pid; ?>.pdf" target="_blank"><button class="btn btn-info" style="float:right; margin-left:15px">View Report</button></a>
                    <h4 class="card-title mb-3">QMS Scaling Ingredient Control Form</h4>
                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                            <thead>
                                <tr>

                                    <th scope="col">#</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Ingredient</th>
                                    <th scope="col">Product Batch Number</th>
                                    <th scope="col">Best Before Date</th>
                                    <th scope="col">Quantity</th>


                                    <!-- <th>View Report</th> -->

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = mysqli_query($con, "SELECT * FROM `pw_scaleing1` where eid='$pid'");
                                $i = 0;
                                while ($row = mysqli_fetch_array($sql)) {
                                    $i++;
                                ?>
                                    <tr>

                                        <th scope="row"><?php echo $i; ?></th>
                                        <td><?php echo date('d-m-Y', strtotime($rnm1['date'])); ?></td>
                                        <td><?php echo $row['ingname']; ?></td>
                                        <td><?php echo $row['batchno']; ?></td>
                                        <td><?php echo $row['bestbefore']; ?></td>
                                        <td><?php echo $row['quantity']; ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>