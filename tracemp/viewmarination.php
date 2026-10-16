<?php
$sno = $_GET['sno'];
$sql = mysqli_query($con, "select * from tblpusage where id='$sno'");
$row = mysqli_fetch_array($sql);

$sql1 = mysqli_query($con, "select * from tblrawmaterial where id='$row[name]'");
$rows = mysqli_fetch_array($sql1);

$date = date('d-m-Y', strtotime($row['date']));
$udate = date('d-m-Y', strtotime($row['useby1']));

$name = $rows['pname'];
$qty = $row['quantity'];
$batchcode = $row['batchcode'];

if(!empty($row['wastage'])){
    $wqty = $row['wastage']."Kg";
}
else{
    $wqty = "";
}


$useby = date('d-m-Y', strtotime($row['useby1']));
?>

<?php
require('tcpdf/tcpdf.php');
ini_set('max_execution_time', 300);


// create new PDF document
class MYPDF extends TCPDF
{

    private $longTableFooter = '';

    public function Header()
    {
        $image_file = 'images/1.png';
        $image_file1 = 'images/rtnts.png';
        $this->Image($image_file, 5, 5, 25, '', 'PNG', '', 'T', false, 200, '', false, false, 0, false, false, false);
        $this->Image($image_file1, 165, 4, 39, '', 'PNG', '', 'T', false, 200, '', false, false, 0, false, false, false);
        $this->SetFont('centurygothic', '', 20);

        $this->SetXY(53, 0);
        $this->Write(20, 'Daily Potato Usage Record', '', 0, '0', true, 0, false, false, 0);
    }

    public function Footer()
    {
        $this->SetFont('centurygothic', '', 8);
        $this->writeHTML($this->longTableFooter);
        $this->SetY(-10);

        $this->Cell(320, 5, 'Printed: ' . date('d-m-Y H:i A'), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
    public function setLongTableFooter($html)
    {
        $this->longTableFooter = $html;
    }
}

$pdf = new MYPDF('P', 'mm', 'A4', true, 'UTF-8', false);

$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->SetMargins(PDF_MARGIN_LEFT, 35, PDF_MARGIN_RIGHT);

$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
    $pdf->setLanguageArray($l);
}
$pdf->AddPage('P', 'A4');


$footer = <<<EOD

<table border="1"  width="100%" border="0.5" cellpadding="3">
  <tr>
  <td style="text-align:center">Version: 01 </td>
  <td style="text-align:center; padding-top:15px;">Issue Date. 12/09/24</td>
  <td style="text-align:center; padding-top:15px;">Approved by: Paramvir S. Deol</td>
  <td style="text-align:center; padding-top:15px;"></td>
  </tr>
</table>
EOD;
$pdf->setLongTableFooter($footer);



$pdf->SetFont('centurygothic', '', 15);


$pdf->SetXY(5, 30);
$pdf->SetFont('centurygothic', '', 12);

$tbl_header = '<style>
table {
   
   border-spacing: 0;
}
tr {
   
}

th {
      background-color:#F0F0F0;
   color: #000000;
   font-weight:bold;
}
td {
  
  text-align:justify;
   color: #000000;
}
</style>
<table id="gallerytab" width="700" cellspacing="0" cellpadding="4" border="1">
  ';
$tbl_footer = '</table>';
$tbl7 = '';
$tbl7 .= '<tr><td width="250"><label style="color:#0000CC">Product Name: </label></td><td width="450">' . $name . '</td></tr>
					<tr><td width="250"><label style="color:#0000CC">Production Date: </label></td><td width="450">' . $date . '</td></tr>
										<tr><td><label style="color:#0000CC">Batchcode:</label></td><td>' . $batchcode . '</td></tr>
										<tr><td><label style="color:#0000CC">Use By:</label> </td><td>' . $udate . '</td></tr>
										<tr><td><label style="color:#0000CC">Total Quantity:</label></td><td>' . $qty . ' Kg</td></tr>
                                        <tr><td><label style="color:#0000CC">Total Wastage:</label></td><td>' . $wqty . '</td></tr>
										<tr><td><label style="color:#0000CC">Checks Carried Out By:</label></td><td>' . $row['user'] . ' </td></tr>';


$pdf->writeHTML($tbl_header . $tbl7 . $tbl_footer, true, false, false, false, '');


$pdf->SetXY(5, 90);
$pdf->SetFont('centurygothic', '', 11);

$tbl8 = '';
$tbl8 .= ' <tr>
										    <th width="10%">Sno.</th>
										    <th width="25%">Product</th>
											 <th width="15%">Total Weight</th>
                                             <th width="22%">GRN No.</th>
                                            <th width="28%">GRN Use By / Best Before</th>
											
											
											
                                        </tr>
										';
$upit = mysqli_query($con, "SELECT * FROM `tblpusage1` WHERE batch='$batchcode'");
$i = 0;
while ($row1 = mysqli_fetch_array($upit)) {
    $ggpid = $row1['pid'];
    $ggrn = $row1['grncode'];

    $ppruq = mysqli_query($con, "SELECT * FROM `tblrawmaterial` WHERE id ='$ggpid'");
    $ppruq1 = mysqli_fetch_array($ppruq);
    $pprodname = $ppruq1['pname'];
    $ggruq = mysqli_query($con, "SELECT * FROM `tblgrn1` WHERE grn='$ggrn'");
    $ggruq1 = mysqli_fetch_array($ggruq);
    $ggdate = $ggruq1['useby'];
    $ggdate1 = date('d-m-Y', strtotime($ggdate));
    $i++;


    $tbl8 .= '
 <tr nobr="true">
										<td width="10%">' . $i . '</td>
										 <td width="25%">' . $pprodname . '</td>
										  <td width="15%">' . $row1['qty'] . ' Kg</td>
                                           <td width="22%">' . $ggrn . '</td>
										  <td width="28%">' . $ggdate1 . '</td>
										   
                                          </tr>';
}

$pdf->writeHTML($tbl_header . $tbl8 . $tbl_footer, true, false, false, false, '');




$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "brcfoodsafety/upl1/" . $row['batchcode'] . "-Production.pdf", "F");
?>
















<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Dashboard</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#!">Home / Daily Potato Usage</a></li>
                </ul>

            </div>
        </div>
    </div>
</div>

<div class="col-xl-12" style="margin-bottom:20px">

    <a href="admin.php?id=potatousage"><button type="submit" class="btn  btn-danger" style="float:right;">Go Back</button></a>

    <a href="upl1/<?php echo $row['batchcode']; ?>-Production.pdf" target="_blank"><button type="submit" class="btn  btn-warning" style="float:right;margin-right:20px">View Report</button></a>
</div>




<div class="col-xl-12">
    <div class="card">
        <div class="card-header">
            <h4 style="color:#990000"><?php echo $name; ?></h4>
            <h5 style="color:#FF0000">Used By: <?php echo $useby; ?></h5>
        </div>


        <div class="card-body table-border-style">
            <div class="table-responsive">
                <table class="table table-striped">

                    <thead>

                        <tr>
                            <th colspan="5"><label style="color:#0000CC">Date: </label> <?php echo $date; ?>, <label style="color:#0000CC">Batchcode:</label> <?php echo $batchcode; ?>, <label style="color:#0000CC">Name:</label> <?php echo $name; ?>, <label style="color:#0000CC">Quantity:</label> <?php echo $qty; ?> </th>
                        </tr>





                    </thead>



                    <thead>
                        <tr>
                            <th></th>
                            <th>Ingredient</th>
                            <th>Quantity</th>
                            <th>GRN Code (Batchcode)</th>
                            <th>GRN Use By / Best Before</th>


                        </tr>
                    </thead>
                    <tbody>




                        <?php

                        $sql1 = mysqli_query($con, "SELECT * FROM `tblpusage1` WHERE batch='$batchcode'");
                        $i = 1;
                        foreach ($sql1 as $row1) {
                            $gpid = $row1['pid'];
                            $grn = $row1['grncode'];

                            $pruq = mysqli_query($con, "SELECT * FROM `tblrawmaterial` WHERE id ='$gpid'");
                            $pruq1 = mysqli_fetch_array($pruq);
                            $prodname = $pruq1['pname'];
                            $gruq = mysqli_query($con, "SELECT * FROM `tblgrn1` WHERE grn='$grn'");
                            $gruq1 = mysqli_fetch_array($gruq);
                            $gdate = $gruq1['useby'];
                            $gdate1 = date('d-m-Y', strtotime($gdate))
                        ?>

                            <?php




                            ?>


                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo  $prodname; ?></td>
                                <td><?php echo $row1['qty']; ?></td>
                                <td><?php echo $grn; ?></td>
                                <td><?php echo $gdate1; ?></td>

                            </tr>
                        <?php
                            $i++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>