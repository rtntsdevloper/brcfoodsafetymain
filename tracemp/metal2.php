<?php
$sno = $_GET['sno'];
include 'connection.php';
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
		$this->Write(20, 'Metal Detection Record', '', 0, '0', true, 0, false, false, 0);
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
  <td style="text-align:center; padding-top:15px;">Issue Date. 10/11/2023</td>
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
$pdf->SetXY(10, 30);

$tbl8 = '';

$upit = mysqli_query($con, "select * from tblmetaldetect  where id=$sno");
$i = 1;
while ($row1 = mysqli_fetch_array($upit)) {

	$sd2 = mysqli_query($con, "select * from tblflavourmix where batch='$row1[productbatch]'");
	$sd3 = mysqli_fetch_array($sd2);

	$tbl8 .= '
					<tr><td width="350"><label style="color:#0000CC">Date</label></td><td width="600">' . date('d-m-Y h:i A', strtotime($row1['datetime'])) . '</td></tr>
										<tr><td><label style="color:#0000CC">Shift</label></td><td>' . $row1['shift'] . '</td></tr>
										<tr><td><label style="color:#0000CC">Supervisor / Manager</label></td><td>' . $row1['cmnt1'] . '</td></tr>
										<tr><td><label style="color:#0000CC">Product Batch</label> </td><td>' . $row1['productbatch'] . '</td></tr>
										<tr><td><label style="color:#0000CC">Product Name</label> </td><td>' . $sd3['productname'] . '</td></tr>
										<tr><td><label style="color:#0000CC">Supervisor</label></td><td>' . $row1['user'] . '</td></tr>
										<tr><td><label style="color:#0000CC">Test time</label></td><td>' . $row1['testtime'] . '</td></tr>
										<tr><td><label style="color:#0000CC">Test Type</label></td><td>' . $row1['testtype'] . '</td></tr>
                                        
                                         ';



	$i++;
}
$pdf->writeHTML($tbl_header . $tbl8 . $tbl_footer, true, false, false, false, '');
$pdf->SetXY(10, 100);
// $pdf->SetFont('centurygothic', '', 11);

$tbl9 = '';
$tbl9 .= ' <tr  width="300" style="text-align:center;" >
										
											   <th width="5%" rowspan="2">Sno</th>
										  

                                           
											 <th width="20%" colspan="2">Ferious </th>
											 
											<th width="20%" colspan="2">Non-Ferious </th>
										
											<th width="20%" colspan="2">Stainless Steel </th>
											
									
										    
											<th width="10%" rowspan="2">Checked by</th>
											<th width="20%" rowspan="2">Comments</th>
											
											
                                        </tr>
										';
$tbl9 .= ' <tr  width="320" >
										

										  

                                           
											 <th width="10%">Metal Size</th>
											 <th width="10%"> Pass</th>
											<th width="10%">Metal Size</th>
											<th width="10%"> Pass</th>
											<th width="10%"> Metal Size</th>
											<th width="10%"> Pass</th>
									
										    
											
											
                                        </tr>
										';
$upit = mysqli_query($con, "select * from tblmetaldetect where id=$sno");
$i = 1;
while ($row1 = mysqli_fetch_array($upit)) {

	$sd2 = mysqli_query($con, "select * from tblflavourmix where batch='$row1[productbatch]'");
	$sd3 = mysqli_fetch_array($sd2);




	$tbl9 .= '
                                               <tr>
										   <td>' . $i . '</td>
										   
										 
											 <td>' . $row1['metal1'] . '</td>
											 <td>' . $row1['pass1'] . '</td>
											 <td>' . $row1['metal2'] . '</td>
											 <td>' . $row1['pass2'] . '</td>
										 
											
											 <td>' . $row1['metal3'] . '</td>
											 <td>' . $row1['pass3'] . '</td>
											 <td>' . $row1['user'] . '</td>
											 <td>' . $row1['cmnt'] . '</td>
										   
                                          </tr>';
	$i++;
}
$pdf->writeHTML($tbl_header . $tbl9 . $tbl_footer, true, false, false, false, '');
$tbl18 = '';

$upite = mysqli_query($con, "select * from tblmetaldetect  where id=$sno");
$rows = mysqli_fetch_array($upite);

if(!empty($rows['sign']))
{

$tbl18 .= '
<table border="1"  width="100%" border="0.5" cellpadding="3">
					<tr>
					<td width="60%"><b>CCP: </b>End of Shift supervisor/manager verification signoff to condirm that metal detection has been met (raise critical and urgent non-conformance if failed to meet or report )</td>
										<th width="20%"  style="font-weight:bold;">Signature</th>
										<td width="20%"><img src="tracemp/sign/'.$rows['sign'].'.png" width="100"  ></td>
										</tr>
										</table>
										
                                        
                                         ';
}

$pdf->writeHTML($tbl18, true, false, false, false, '');




$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "/brcfoodsafety/upl1/METAL.pdf", "F");
?>
<!-- <td><a href="upl1/METAL.pdf" target="_blank"><button class="btn btn-primary"
							style="float:right; margin-left:15px">View Report</button></a></td> -->
<iframe src="upl1/METAL.pdf" frameborder="0" width="100%"
	height="600px"></iframe>