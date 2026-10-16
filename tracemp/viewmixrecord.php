<?php
$sno = $_GET['fid'];
$sql = mysqli_query($con, "select * from tblflavourmix where id='$sno'");
$row = mysqli_fetch_array($sql);



$date = date('d-m-Y', strtotime($row['date']));
$ubdate = date('d-m-Y', strtotime($row['useby1']));
$batchcode = $row['batch'];
$prodname = $row['productname'];
$tqty = $row['totalqty'];
$stw = $row['flavourtotal'];
if (!empty($row['flavourleft'])) {
    $enw = $row['flavourleft'] . "Kg";
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
        $this->Image($image_file1, 245, 4, 39, '', 'PNG', '', 'T', false, 200, '', false, false, 0, false, false, false);
        $this->SetFont('centurygothic', '', 20);

        $this->SetXY(95, 0);
        $this->Write(20, 'Flavour Mixing Record', '', 0, '0', true, 0, false, false, 0);
    }

    public function Footer()
    {
        $this->SetFont('centurygothic', '', 8);
        $this->writeHTML($this->longTableFooter);
        $this->SetY(-10);

        $this->Cell(450, 5, 'Printed: ' . date('d-m-Y H:i A'), 0, false, 'C', 0, '', 0, false, 'T', 'M');
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
$pdf->AddPage('L', 'A4');


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
<table id="gallerytab" width="1000" cellspacing="0" cellpadding="4" border="1">
  ';
$tbl_footer = '</table>';
$tbl7 = '';
$tbl7 .= '
					<tr><td width="350"><label style="color:#0000CC">Production Date: </label></td><td width="650">' . $date . '</td></tr>
										<tr><td><label style="color:#0000CC">Batchcode:</label></td><td>' . $batchcode . '</td></tr>
										<tr><td><label style="color:#0000CC">Product Name:</label> </td><td>' . $prodname . '</td></tr>
										<tr><td><label style="color:#0000CC">Product Quantity:</label></td><td>' . $tqty . 'Kg</td></tr>
                                        <tr><td><label style="color:#0000CC">Use By/ Best Before:</label></td><td>' . $useby . '</td></tr>
                                          <tr><td><label style="color:#0000CC">Flavour Start Weight:</label></td><td>' . $stw . 'Kg</td></tr>
                                           <tr><td><label style="color:#0000CC">Flavour End Weight:</label></td><td>' . $enw .  '</td></tr>';


$pdf->writeHTML($tbl_header . $tbl7 . $tbl_footer, true, false, false, false, '');


$pdf->SetXY(5, 110);
$pdf->SetFont('centurygothic', '', 11);

$tbl8 = '';
$tbl8 .= ' <tr>
										    <th width="10%">Sno.</th>
										    <th width="30%">Product</th>
											 <th width="18%">Total Weight</th>
                                             <th width="22%">GRN No./Batchcode</th>
                                            <th width="20%">GRN Use By / Best Before</th>
                                            
											
											
											
                                        </tr>
										';
$upit = mysqli_query($con, "SELECT * FROM `tblflavourmix1` WHERE batch='$batchcode' and mark ='P'");
$i = 0;
while ($row1 = mysqli_fetch_array($upit)) {
    $ggpid = $row1['pid'];
    $ggpcode = $row1['grncode'];

    $ptrb = mysqli_query($con, "SELECT * FROM `tblfryinfo` WHERE batchcode ='$ggpcode'");
    $ptrb1 = mysqli_fetch_array($ptrb);

    $ppgdate = date('d-m-Y', strtotime($ptrb1['useby']));
    $ingredient = 'Fried Potato';

    $i++;


    $tbl8 .= '
 <tr nobr="true">
										<td width="10%">' . $i . '</td>
										 <td width="30%">' . $ingredient . '</td>
										  <td width="18%">' . $row1['qty'] . ' Kg</td>
                                           <td width="22%">' . $ggpcode . '</td>
										  <td width="20%">' . $ppgdate . '</td>
                                          
										   
                                          </tr>';
}

$upit1 = mysqli_query($con, "SELECT * FROM `tblflavourmix1` WHERE batch='$batchcode' and mark ='F'");

while ($row11 = mysqli_fetch_array($upit1)) {
    $ggpid = $row11['pid'];
    $ggpcode = $row11['grncode'];

    $rpruq = mysqli_query($con, "SELECT * FROM `tblrawmaterial` WHERE id ='$ggpid'");
    $rpruq1 = mysqli_fetch_array($rpruq);
    $ingredient = $rpruq1['pname'];




    $ptrb1 = mysqli_query($con, "SELECT * FROM `tblgrn1` WHERE grn ='$ggpcode'");
    $ptrb11 = mysqli_fetch_array($ptrb1);

    $ppgdate = date('d-m-Y', strtotime($ptrb11['useby']));


    $i++;


    $tbl8 .= '
 <tr nobr="true">
										<td width="10%">' . $i . '</td>
										 <td width="30%">' . $ingredient . '</td>
										  <td width="18%">' . $row11['qty'] . ' Kg</td>
                                           <td width="22%">' . $ggpcode . '</td>
										  <td width="20%">' . $ppgdate . '</td>
                                        
										   
                                          </tr>';
}


$pdf->writeHTML($tbl_header . $tbl8 . $tbl_footer, true, false, false, false, '');




$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "brcfoodsafety/upl1/" . $row['batch'] . "-Fryinfo.pdf", "F");
?>
















<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Dashboard</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#!">Home / Flavour Mixing Record</a></li>
                </ul>

            </div>
        </div>
    </div>
</div>

<div class="col-xl-12" style="margin-bottom:20px">

    <a href="admin.php?id=fryrecord"><button type="submit" class="btn  btn-danger" style="float:right;">Go Back</button></a>

    <a href="upl1/<?php echo $row['batch']; ?>-Fryinfo.pdf" target="_blank"><button type="submit" class="btn  btn-warning" style="float:right;margin-right:20px">View Report</button></a>
</div>




<div class="col-xl-12">
    <div class="card">
        <div class="card-header">
            <h4 style="color:#990000">Flavour Mixing Record</h4>

        </div>


        <div class="card-body table-border-style">
            <div class="table-responsive">
                <table class="table table-striped">

                    <thead>

                        <tr>
                            <th colspan="5"><label style="color:#0000CC">Date: </label> <?php echo $date; ?> , <label style="color:#0000CC">Batchcode:</label> <?php echo $batchcode; ?> , <label style="color:#0000CC">Product Name : </label> <?php echo $prodname; ?> , <label style="color:#0000CC">Total Quantity:</label> <?php echo $tqty; ?>Kg , <label style="color:#0000CC">Use By: </label> <?php echo $ubdate; ?></th>
                        </tr>





                    </thead>



                    <thead>
                        <tr>
                            <th></th>
                            <th>Ingredient</th>
                            <th>Quantity</th>
                            <th>GRN No./Batchcode</th>
                            <th>Use By/Best Before</th>



                        </tr>
                    </thead>
                    <tbody>




                        <?php

                        $sql1 = mysqli_query($con, "SELECT * FROM `tblflavourmix1` WHERE batch='$batchcode'");
                        $i = 1;
                        foreach ($sql1 as $row1) {
                            $gpid = $row1['pid'];
                            $grn = $row1['grncode'];

                            if ($row1['mark'] == 'F') {
                                $pruq = mysqli_query($con, "SELECT * FROM `tblrawmaterial` WHERE id ='$gpid'");
                                $pruq1 = mysqli_fetch_array($pruq);
                                $prodname = $pruq1['pname'];

                                $ubd = mysqli_query($con, "SELECT * FROM `tblgrn1` WHERE grn ='$grn'");
                                $ubd1 = mysqli_fetch_array($ubd);
                                $ubdate = $ubd1['useby'];
                                $btchc = $ubd1['batchcode'];
                                
                            } elseif ($row1['mark'] == 'P') {
                                $prodname = 'Fried Potato';
                                $ubd = mysqli_query($con, "SELECT * FROM `tblfryinfo` WHERE batchcode ='$grn'");
                                $ubd1 = mysqli_fetch_array($ubd);
                                $ubdate = $ubd1['useby'];
                            }
                       



                        ?>

                            <?php




                            ?>


                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo  $prodname; ?></td>
                                <td><?php echo $row1['qty']; ?></td>
                                <td><?php echo $grn; ?> <?php if(!empty($btchc)) {?> <span style="color:#990000"> ( <?php echo $btchc; ?> )</span> <?php }?></td>
                                <td>
                                    <?php echo date('d-m-Y', strtotime($ubdate));

                                    ?>
                                </td>



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