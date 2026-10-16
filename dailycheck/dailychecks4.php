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
        $this->SetY(-20);
        $this->SetFont('courier', '', 8);
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

$pdf->AddPage('P', 'LETTER');

$footer = <<<EOD

<table border="1"  width="100%" border="0.5" cellpadding="3">
  <tr>
  <td style="text-align:center">Issue Date : 16/11/2024 </td>
  <td style="text-align:center; padding-top:15px;" rowspan="2">DOC Ref: REC 1.5.4.003</td>
  <td style="text-align:center; padding-top:15px;">Author : Bijal Chauhan</td>

  </tr>
   <tr>
  <td style="text-align:center">Version: 02 </td>
  <td style="text-align:center; padding-top:15px;">Authorised By : Mahesh Prajapati</td>
 
  </tr>
  <tr>
  <td  colspan="3">Reason For Change: Form has been reviewed as per SALSA Standard</td>
 
 
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
// $pdf->Write(0, "Time :$roww[ctime]", '', '0', '0', true, 'C', false, false, 0);
// $pdf->SetXY(15, 61);
$pdf->Write(0, "Checked By:$roww[cuser]", '', '0', '0', true, 'C', false, false, 0);
$pdf->SetXY(15, 75);

$pdf->SetFont('courier', 'B', 14);
$pdf->Write(0, "Daily closing checks. To be completed at the end of every day.", '', '0', '0', true, 'C', false, false, 0);
$pdf->SetXY(15, 98);


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
// print_r("select distinct section from dailychecks3 where cid='$sno' ");
$ghf1 = mysqli_query($con, "select distinct section from dailychecks3 where cid='$sno' ");
while ($rowsf1 = mysqli_fetch_array($ghf1)) {

    $tbl1 .= '
  <tr nobr="true"> 
      <td width="658" style="text-align:center;color:blue;font-size:18px" >Section: ' . $rowsf1['section'] . '</td>
     
   </tr>
   ';
// print_r("select * from dailychecks3 where cid='$sno' and section='$rowsf1[section]'");die;
    $ghf = mysqli_query($con, "select * from dailychecks3 where cid='$sno' and section='$rowsf1[section]'");
    while ($rowsf = mysqli_fetch_array($ghf)) {



        $tbl1 .= '
  <tr nobr="true"> 
      <td width="150" >Question</td>
       <td  width="508" >' . $rowsf['ques'] . '</td>
   </tr>
   
	<tr nobr="true"> 
	 <td width="150">Answer</td>
       <td  width="508" style="color:green">' . $rowsf['ans'] . '</td>
   </tr>';
        if ($rowsf['cmnt'] != "") {
            $tbl1 .= ' <tr nobr="true"> 
	 <td width="150"  >Comments/<br>Corrective Action</td>
       <td  width="508" style="color:green">' . $rowsf['cmnt'] . '</td>
   </tr>';
        }
        if ($rowsf['pic'] != "") {
            $tbl1 .= '
  <tr nobr="true"> 
      <td width="150" ></td>
       <td  width="508" ><img src="upl1/' . $rowsf['pic'] . '" width="100"></td>
   </tr>
';
        }
    }
}

$pdf->writeHTML($tbl_header . $tbl1 . $tbl_footer, true, false, false, false, '');

$pdf->ln(10);

if (!empty($roww['verify'])) {
    $mnsign = $roww['verify'];
    $vfname = $roww['verifyn'];
    $tblsign = '

<table border="1"  width="100%" border="0.5" cellpadding="3">
  <tr nobr="true">
  <td style="text-align:center" width="20%">Verified By</td>
  <td style="text-align:center" width="20%">' . $vfname . '</td>
  <td style="text-align:center" width="20%">Verification Signature</td>
  <td style="text-align:center; padding-top:15px;" width="40%"><img src="signature/' . $mnsign . '.png" width="120">
  </td>
  
  
  </tr>
</table>

';
    $pdf->writeHTML($tblsign, true, false, false, false, '');
}

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


                    <a href="admin.php?id=dailychecks&tid=<?php echo $tid; ?>"><button class="btn btn-success"
                            style="float:right; margin-left:15px">Go Back</button></a>


                    <a href="upl1/<?php echo $date; ?>-Closing Checks.pdf" target="_blank"><button
                            class="btn btn-warning" style="float:right; margin-left:15px">View Report</button></a>
                    <h4 class="card-title mb-3">Closing Checks</h4>



                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="zero_configuration_table"
                            style="width:100%">
                            <thead>
                                <th width="5">Sno</th>
                                <th width="15">Date</th>
                                <th width="15">Question</th>
                                <th width="20">Answer</th>
                                <th width="15">Comment</th>


                            </thead>
                            <tbody>
                                <?php
                                $sql = mysqli_query($con, "select * from dailychecks3 where cid='$sno' ");
                                $n = 0;
                                while ($row2 = mysqli_fetch_array($sql)) {

                                    $n++;

                                    ?>
                                    <tr>
                                        <td>
                                            <div align="center"> <?php echo $n; ?> </div>
                                        </td>
                                        <td> <?php echo $dt; ?> </td>
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