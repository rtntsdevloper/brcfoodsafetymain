<?php
$sno = $_GET['sno'];


$tid = $_GET['tid'];
$sq2 = mysqli_query($con, "select * from dailychecks where id='$tid'");
$qu2 = mysqli_fetch_array($sq2);
$tname = $qu2['name'];


$sql1 = mysqli_query($con, "select * from dailycheckss where id='$sno'");
$roww = mysqli_fetch_array($sql1);

$gh = mysqli_query($con, "select * from dailychecks where id='$roww[name]'");
$gh1 = mysqli_fetch_array($gh);
$test = $gh1['name'];

$sql = mysqli_query($con, "select * from dailychecks2 where cid='$sno'");
$row = mysqli_fetch_array($sql);
$date = $row['date'];



$dt = date("d-m-Y", strtotime($roww['date']));

require('tcpdf/tcpdf.php');

class MYPDF extends TCPDF
{
    private $longTableFooter = '';
    public function Header()
    {




        $image_file = 'images/1.png';
        $image_file1 = 'images/rtnts.png';

        $this->Image($image_file, 15, 5, 20, '', 'png', '', 'T', false, 200, '', false, false, 0, false, false, false);
        $this->Image($image_file1, 170, 5, 35, '', 'png', '', 'T', false, 200, '', false, false, 0, false, false, false);

        $this->SetFont('courier', '', 20);
        $this->SetXY(60, 2);
        $this->Write(25, 'Evening Checks Report', '', 0, '30', true, 0, false, false, 0);
    }
    public function Footer()
    {
        $this->SetFont('courier', '', 8);
        $this->writeHTML($this->longTableFooter);
        $this->SetY(-10);

        $this->Cell(310, 5, 'Printed: ' . date('d-m-Y H:i A'), 0, false, 'C', 0, '', 0, false, 'T', 'M');
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

$pdf->AddPage('P', 'LETTER');

$footer = <<<EOD

<table border="1"  width="100%" border="0.5" cellpadding="3">
  <tr>
  <td style="text-align:center" width="15%">Version: 01 </td>
  <td style="text-align:center; padding-top:15px;" width="25%">Issue Date. 12/09/24</td>
  <td style="text-align:center; padding-top:15px;" width="28%">Approved by: Paramvir S. Deol</td>
  <td style="text-align:center; padding-top:15px;" width="32%"></td>
  </tr>
</table>
EOD;
$pdf->setLongTableFooter($footer);


$pdf->SetFont('courier', '', 14);
$pdf->SetXY(15, 40);
$pdf->Write(0, "Date created:$dt", '', '0', '0', true, 'C', false, false, 0);
$pdf->SetXY(15, 47);
$pdf->Write(0, "$test", '', '0', '0', true, 'C', false, false, 0);
$pdf->SetXY(15, 54);
$pdf->Write(0, "Attempt By:$roww[user]", '', '0', '0', true, 'C', false, false, 0);
$pdf->SetXY(15, 70);


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
   color:blue;
}


</style>
<table id="gallerytab" width="100%" cellspacing="0" cellpadding="3" border="0.2">';
$tbl_footer = '</table>';


$tbl1 = '';

$ghf1 = mysqli_query($con, "select distinct section from dailychecks3 where cid='$sno'");
while ($rowsf1 = mysqli_fetch_array($ghf1)) {

    $tbl1 .= '
  <tr nobr="true"> 
      <td width="620" style="text-align:center;color:blue;font-size:18px" >Section: ' . $rowsf1['section'] . '</td>
     
   </tr>
   ';

    $ghf = mysqli_query($con, "select * from dailychecks3 where cid='$sno'");
    while ($rowsf = mysqli_fetch_array($ghf)) {



        $tbl1 .= '
  <tr nobr="true"> 
      <td width="120" >Question</td>
       <td  width="500" >' . $rowsf['ques'] . '</td>
   </tr>
   
	<tr nobr="true"> 
	 <td width="120">Answer</td>
       <td  width="500" style="color:green">' . $rowsf['ans'] . '</td>
   </tr>';
        if ($rowsf['cmnt'] != "") {
            $tbl1 .= ' <tr nobr="true"> 
	 <td width="120"  >Comment</td>
       <td  width="500" style="color:green">' . $rowsf['cmnt'] . '</td>
   </tr>';
        }
        if ($rowsf['pic'] != "") {
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




$pdf->Output("upl1/" . $date . "-Closing Checks.pdf", "F");



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

                    <?php
                    if (isset($_GET['sxid'])) {
                    ?>
                        <a href="admin.php?id=dailycal&sid=<?php echo $_GET['sxid']; ?>"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                    <?php
                    } else {
                    ?>

                        <a href="admin.php?id=dailychecks&tid=<?php echo $tid; ?>"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                    <?php
                    }


                    ?>

                    <a href="upl1/<?php echo $date; ?>-Closing Checks.pdf" target="_blank"><button class="btn btn-warning" style="float:right; margin-left:15px">View Report</button></a>
                    <h4 class="card-title mb-3"><?php echo $tname; ?></h4>



                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
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
                                $sql = mysqli_query($con, "select * from dailychecks3 where cid='$sno'");
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
                                        <td> <?php echo $row2['ans']; ?></td>
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