<?php
$sno = $_POST['sno'];
date_default_timezone_set('Europe/London');

ini_set('max_execution_time', 600);
ini_set('memory_limit', '-1');

$sql2 = mysqli_query($con, "select * from tblroster where id='$sno'"); //8
$row2 = mysqli_fetch_array($sql2);

$tid = $row2['tid'];
$sid = $row2['sid'];

$auditdate = date("d-m-Y", strtotime($row2['auditdate']));


$auditee = mysqli_query($con, "select * from tblauditee where id='$row2[auditee]'"); // auditee 9
$auditee1 = mysqli_fetch_array($auditee);


$auditor = mysqli_query($con, "select * from tblauditor where id='$row2[auditor]'"); // auditor 8
$auditor1 = mysqli_fetch_array($auditor);

$auditor1['name'];

$total3 = mysqli_query($con, "select * FROM addtest1 where testid='$tid'"); // tid 1
$addtest = mysqli_fetch_array($total3);


$total2 = mysqli_query($con, "select * FROM subtest where tid='$tid' and sid='$sid'"); // sid 4.1
$subtest = mysqli_fetch_array($total2);


$total = mysqli_query($con, "SELECT * FROM subtest1 where tid='$row2[tid]' and sid='$row2[sid]'"); //
$subtest1 = mysqli_fetch_array($total);


$total1 = mysqli_num_rows($total); //1


$ns = mysqli_query($con, "SELECT * FROM saveaudit where sno='$sno'  and ans='Not Applicable'");
$ns1 = mysqli_num_rows($ns);


$total1 = $total1 - $ns1; //0

$complete = mysqli_query($con, "SELECT * FROM saveaudit where sno='$sno' and ans='Compliant'");
$complete1 = mysqli_num_rows($complete); //
if ($complete1 != 0) {
	$complete2 = round($complete1 / $total1 * 100);
} else {
	$complete2 = '0';
}


$pending = mysqli_query($con, "SELECT * FROM saveaudit where sno='$sno' and  ans='Major'");
$pending1 = mysqli_num_rows($pending);
$pending2 = $pending1 != 0 ? round($pending1 / $total1 * 100) : '0';

$progres = mysqli_query($con, "SELECT * FROM saveaudit where sno='$sno' and ans='Minor'");
$progres1 = mysqli_num_rows($progres);
$progres2 = $progres1 != 0 ? round($progres1 / $total1 * 100) : '0';

$na = mysqli_query($con, "SELECT * FROM  saveaudit where sno='$sno' and ans='Critical'");
$na1 = mysqli_num_rows($na);
$na2 = $na1 != 0 ? round($na1 / $total1 * 100) : ' 0';


require('tcpdf/tcpdf.php');

class MYPDF extends TCPDF
{

	public function Header()
	{

		$image_file = 'images/1.png';
		$image_file1 = 'images/rtnts.png';



		$this->Image($image_file, 25, 1, 25, '', 'png', '', 'T', false, 200, '', false, false, 0, false, false, false);
		$this->Image($image_file1, 170, 5, 35, '', 'png', '', 'T', false, 200, '', false, false, 0, false, false, false);

		$this->SetFont('centurygothic', '', 18);
		$this->SetXY(17, 25);
	}
	public function Footer()
	{
		$this->SetY(-10);
		$this->SetFont('centurygothic', 'I', 8);
		$this->Cell(20, 5, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
		$this->Cell(270, 5, date("d/m/Y "), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}
}
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->SetMargins(PDF_MARGIN_LEFT, 35, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
	require_once(dirname(__FILE__) . '/lang/eng.php');
	$pdf->setLanguageArray($l);
}

$pdf->AddPage('P', 'LETTER');
$pdf->SetMargins(15, 45, 10, 10);
// $pdf->WriteHTMLCell(0, 0, 60, $pdf->GetY(), $image_file, 0, 1);


$pdf->SetFont('centurygothic', '', 20);

$pdf->SetXY(15, 30);
$pdf->Write(15, "Audit Report", '', '0', '0', true, 'C', false, false, 0);



$xc = 50;
$yc = 130;
$r = 20;
$t2 = 0;
$n = 0;
if ($complete2 != 0) {
	$n = $n + 1;
}

if ($pending2 != 0) {
	$n = $n + 1;
}

if ($progres2 != 0) {
	$n = $n + 1;
}

if ($na2 != 0) {
	$n = $n + 1;
}



$totalpercent = $complete2 + $pending2 + $progres2 + $na2;

if ($totalpercent < 100) {
	$t1 = 100 - $totalpercent;

	// Check if $n is not zero before performing the division
	if ($n != 0) {
		$t2 = $t1 / $n;
	} else {
		// Handle the case where $n is zero
		$t2 = 0; // or some other default value

	}

	// Update the variables regardless of their previous values
	$complete2 += $t2; // This will add t2 to complete2
	$pending2 += $t2;  // This will add t2 to pending2
	$progres2 += $t2;  // This will add t2 to progres2
	$na2 += $t2;       // This will add t2 to na2
}




$acritical2 = $na2 / 100 * 360;
$amajor2 = $pending2 / 100 * 360;
$aminor2 = $progres2 / 100 * 360;
$acompliant2 = $complete2 / 100 * 360;

$finalmajor = $amajor2 + $acritical2;
$finalminor = $finalmajor + $aminor2;
$finalcompliant = $finalminor + $acompliant2;
$finalcontrol = $finalcompliant + $acritical2;

//na
$pdf->SetFillColor(0, 115, 170);
$pdf->PieSector($xc, $yc, $r, 0, $acritical2, 'FD', false, 0, 2);

//pnding
$pdf->SetFillColor(209, 31, 41);
$pdf->PieSector($xc, $yc, $r, $acritical2, $finalmajor, 'FD', false, 0, 2);

//progress
$pdf->SetFillColor(243, 159, 44);
$pdf->PieSector($xc, $yc, $r, $finalmajor, $finalminor, 'FD', false, 0, 2);

//complete
$pdf->SetFillColor(73, 153, 67);
$pdf->PieSector($xc, $yc, $r, $finalminor, $finalcompliant, 'FD', false, 0, 2);

//notstart
$pdf->SetFillColor(0, 115, 170);

$pdf->PieSector($xc, $yc, $r, $finalcompliant, $finalcontrol, 'FD', false, 0, 2);

$pdf->SetFont('centurygothic', '', 10);


$pdf->SetXY(100, 100);

$tbl = <<<EOD

<table width="130" border="0" style="font-family:calibri;border:1px solid #000000;">
<tr nobr="true">
  <td width="5"></td>
    <td width="20" height="5"></td>
    <td width="170" height="5"></td>
  </tr>
 
   
    <tr nobr="true">
    <td width="5"></td>
    <td width="20" height="15"><div bgcolor="#0073AA" style="width:15px; height:15px; background:#0073AA;margin-top:5px;"></div></td>
    <td width="170" height="15" style="padding:10px;margin-top:5px;">Critical[$na2%]</td>
   </tr>
   <tr nobr="true">
    <td width="5"></td>
    <td width="20" height="15"><div bgcolor="#D11F29" align="center" style="width:15px; height:15px; background:#D11F29"></div></td>
    <td width="170" height="15">Major [$pending2%]</td>
   </tr>
   <tr nobr="true">
    <td width="5"></td>
    <td width="20" height="15"><div bgcolor="#F39F2C" align="center" style="width:15px; height:15px; background:#F39F2C"></div></td>
    <td width="170" height="15">Minor [$progres2%]</td>
   </tr>
   <tr nobr="true">
    <td width="5"></td>
    <td width="20" height="15"><div bgcolor="#499943" align="center" style="width:15px; height:15px; background:#499943"></div></td>
    <td width="170" height="15">Compliant [$complete2%]</td>
    </tr>
	
   </table>
EOD;

$pdf->writeHTML($tbl, true, false, true, false, '');


$pdf->SetFont('centurygothic', '', 10);


$pdf->SetXY(15, 50);

$tble = <<<EOD

<table width="100%" border="1" style="font-family:calibri;" cellpadding="5" >
 
  <tr>
    <td width="100">Audit Date </td>
    <td width="550">Not Verified</td>
  </tr>
  <tr>
    <td>Auditor</td>
    <td>$auditor1[name]</td>
  </tr>
  <tr>
    <td>Auditee</td>
    <td>$auditee1[name]</td>
  </tr>
  <tr>
    <td>Section</td>
    <td>$addtest[testid]. $addtest[subject]</td>
  </tr>
  <tr>
    <td>Sub-Section</td>
    <td>$subtest[sid]. $subtest[subtest]</td>
  </tr>

</table>
EOD;

$pdf->writeHTML($tble, true, false, true, false, '');



$pdf->SetXY(15, 160);

$tbl_header = '<style>
table {
   
   border-spacing: 0;
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
  
 
   font-size: 12px;
   color: #000000;
   padding: 3px 7px 2px;
}
</style>
<table id="gallerytab" width="100%" cellspacing="0" cellpadding="7" border="1">
  ';

$tbl_footer = '</table>';


$tbl7 = '';

$tbl7 .= '<tr>
    <td width="150" style="background-color:#52AE32;color:white">Clause</td>
    <td width="500" style="background-color:#52AE32;color:white">Requirements</td>
  </tr>
  ';

$sq2 = mysqli_query($con, "select * from subtest1 where tid='$tid' and sid='$sid'");
while ($row2 = mysqli_fetch_array($sq2)) {
	if ($row2['ssid'] != "") {
		$fid = $row2['ssid'];
	} else {
		$fid = $row2['fid'];
	}
	$sql3 = mysqli_query($con, "select * from saveaudit where sno='$sno' and fid='$fid'");
	$row3 = mysqli_fetch_array($sql3);


	$ques = mysqli_real_escape_string($con, $row2['clause']);

	$tbl7 .= '<tr nobr="true">
    <td width="150">' . $row3['fid'] . '</td>
    <td width="500">' . $ques . '</td>
  </tr>
  ';

	$tbl7 .= '
  <tr nobr="true">
    <td>Answer</td>';
	if ($row3['ans'] == "Compliant") {
		if ($row3['notes'] != "") {
			$tbl7 .= '<td style="color:green">' . $row3['ans'] . '-' . $row3['notes'] . '</td>';
		} else {
			$tbl7 .= '<td style="color:green">' . $row3['ans'] . '</td>';
		}
	} else if ($row3['ans'] == "Not Applicable") {
		if ($row3['notes'] != "") {
			$tbl7 .= '<td>' . $row3['ans'] . '-' . $row3['notes'] . '</td>';
		} else {
			$tbl7 .= '<td>' . $row3['ans'] . '</td>';
		}
	} else if ($row3['ans'] == "Major") {
		if ($row3['notes'] != "") {
			$tbl7 .= '<td style="color:red">' . $row3['ans'] . '</td>';
		} else {
			$tbl7 .= '<td style="color:red">' . $row3['ans'] . '</td>';
		}
	} else if ($row3['ans'] == "Minor") {
		if ($row3['notes'] != "") {
			$tbl7 .= '<td style="color:orange">' . $row3['ans'] . '</td>';
		} else {
			$tbl7 .= '<td style="color:orange">' . $row3['ans'] . '</td>';
		}
	} else if ($row3['ans'] == "Critical") {
		if ($row3['notes'] != "") {
			$tbl7 .= '<td style="color:#0080C0">' . $row3['ans'] . '</td>';
		} else {
			$tbl7 .= '<td style="color:#0080C0">' . $row3['ans'] . '</td>';
		}
	}

	$tbl7 .= '</tr>';

	if ($row3['action'] != "" || $row3['title'] != "") {
		$tbl7 .= '
	 <tr nobr="true">
	 <td>NC raised by auditor</td>
     <td> ' . $row3['title'] . '</td>
	</tr>
	<tr nobr="true">
	  <td>Action Required</td>
     <td>' . $row3['action'] . '</td>
	</tr>
	
	<tr nobr="true">
	  <td>Completion date agreed</td>
     <td>' . date('d-m-Y', strtotime($row3['deliver'])) . '</td>
	</tr>
	';
	}


	if ($row3['document'] != "") {
		$string = $row3['document'];
		$tags1 = explode(';', $string);
		foreach ($tags1 as $key1) {
			$info5 = new SplFileInfo($key1);
			$tpe1 = $info5->getExtension();
			if ($tpe1 != "") {
				if ($tpe1 == "jpg" || $tpe1 == "jpeg" || $tpe1 == "png" || $tpe1 == "PNG") {

					$tbl7 .= '<tr nobr="true">
    <td>Supporting documents</td>
    <td><img src="documents/' . $key1 . '" height="300"  width="300"></td>
  </tr>';
				} else {
					$tbl7 .= '<tr nobr="true">
    <td>Supporting documents</td>
    <td><a href="' . $portallink . 'documents/' . $key1 . '" target="_blank">' . $key1 . '</a></td>
  </tr>';
				}
			}
		}
	}
	$sh62 = mysqli_query($con, "select * from tblaction where sno='$row3[id]'");
	$mchh = mysqli_num_rows($sh62);

	if ($mchh >= 1) {
		$tbl7 .= '<tr>
						 <td style="color:blue" colspan="2">Auditee response 	</td>
						 
						 </tr>';
	}

	$rts = mysqli_query($con, "select * from tblrootcause where sno='$row3[id]'");
	$mb = mysqli_num_rows($rts);
	if ($mb >= 1) {
		while ($rts1 = mysqli_fetch_array($rts)) {

			$tbl7 .=	'<tr>
						
						 <td style="color:blue" colspan="2" >Root Cause Analysis</td>
						 </tr><tr>
						 <td>Question 1 why? 	</td>
						 <td>' . $rts1['root1'] . '</td>
						 </tr><tr>
						 <td>Question 2 why?</td>
						 <td>' . $rts1['root2'] . '</td>
						 </tr>';
			if ($rts1['root3'] != "") {
				$tbl7 .=	'<tr>
						 <td>Question 3 why?</td>
						 <td>' . $rts1['root3'] . '</td>
						 </tr>';
			}
			if ($rts1['root4'] != "") {
				$tbl7 .=	' <tr>
						 <td>Question 4 why?</td>
						 <td>' . $rts1['root4'] . '</td>
						 </tr>';
			}

			if ($rts1['root5'] != "") {
				$tbl7 .=	' <tr>
						 <td>Question 5 why?</td>
						 <td>' . $rts1['root5'] . '</td>
						 </tr>
						 ';
			}
		}
	}

	$sh6 = mysqli_query($con, "select * from tblaction where sno='$row3[id]'");
	while ($hj6 = mysqli_fetch_array($sh6)) {
		$tbl7 .=	'
							
						 <tr>
						 <td >Evidence submitted on	</td>
						 <td>' . date('d-m-Y', strtotime($hj6['date'])) . '</td>
						 </tr>';



		if ($hj6['comment'] != "") {
			$tbl7 .=	' <tr>
						 <td>Auditee Comment:</td>
						 <td>' . $hj6['comment'] . '</td>
						 </tr>';
		}
		if ($hj6['corrective'] != "") {
			$tbl7 .=	' <tr>
						 <td>Corrective Action:</td>
						 <td>' . $hj6['corrective'] . '</td>
						 </tr>
						 
						 ';
		}
		if ($hj6['preventive'] != "") {
			$tbl7 .=	' <tr>
						 <td>Preventive Action:</td>
						 <td>' . $hj6['preventive'] . '</td>
						 </tr>
						 
						 ';
		}

		if ($hj6['img'] != "") {
			$file_name1 = $hj6['img'];
			$tpe11 = pathinfo($file_name1, PATHINFO_EXTENSION);
			if ($tpe11 != "") {
				if ($tpe11 == "jpg" || $tpe11 == "jpeg" || $tpe11 == "png" || $tpe11 == "PNG") {

					$tbl7 .= '<tr nobr="true">
    <td>Supporting documents</td>
    <td><img src="rootcause/' . $file_name1 . '" height="300"  width="300"></td>
  </tr>';
				} else {
					$tbl7 .= '<tr nobr="true">
    <td>Supporting documents</td>
    <td><a href="' . $portallink . 'rootcause/' . $file_name1 . '" target="_blank">' . $file_name1 . '</a></td>
  </tr>';
				}
			}
		}



		if ($hj6['date1'] != "0000-00-00") {
			$tbl7 .= ' <tr>
						 <td >Evidence verification date	</td>
						 <td>' . date('d-m-Y', strtotime($hj6['date1'])) . '</td>
						 </tr>';
		}


		if ($hj6['ans'] != "") {
			$tbl7 .= '
						 <tr>
						 <td>Auditor Response</td>';
			if ($hj6['ans'] == "Accepted") {
				$tbl7 .= '  <td style="color:green">' . $hj6['ans'] . '</td>';
			} else if ($hj6['ans'] == "Rejected") {
				$tbl7 .= '  <td style="color:red">' . $hj6['ans'] . '</td>';
			}
			$tbl7 .= '
						  </tr>
						 <tr>
						 <td>Auditor Comment</td>
						 <td>' . $hj6['cmnt'] . '</td>
						 </tr>';
		}
	}
}




$pdf->writeHTML($tbl_header . $tbl7 . $tbl_footer, true, false, false, false, '');




$tbl11 ='';

$tbl11 .= '
<table border="1" cellpadding="5">
<tr nobr ="true" >
<th width="130" style="padding-top:20px;">Auditor Signature : </th>
<td width="200"><img src ="auditordoc/'.$auditor1['sign'].'" height="40"  width="180"></td>
<th width="130">Auditee Signature : </th>
<td width="200"><img src ="auditordoc/'.$auditee1['sign'].'" height="40"  width="180"></td>
</tr>

</table>

';
$pdf->writeHTML( $tbl11, true, false, false, false, '');




// $pdf->writeHTML(utf8_encode($tbl_header . $tbl7 . $tbl_footer), true, false, false, false, '');



// $pdf->Output("upl1/" . $sno . "-Audit Report.pdf", 'F');


$filename = preg_replace('/[^a-zA-Z0-9_-]/', '_', $sno . "Audit Report");


$filePath = $_SERVER['DOCUMENT_ROOT'] . "/brcfoodsafety/fssc/pdf/" . $filename . ".pdf";


try {

	if (!file_exists(dirname($filePath))) {
		mkdir(dirname($filePath), 0755, true);
	}


	$pdf->Output($filePath, "F");
} catch (Exception $e) {
	echo "Error generating PDF: " . $e->getMessage();
}
?>


<div class="main-content">
	<div class="breadcrumb">
		<h1 class="mr-2"><?php echo $headingname; ?></h1>
		<ul>
			<li><a href="">Audit Management</a></li>
			<li>View Detail</li>
		</ul>
	</div>



	<div class="row mb-12">
		<div class="col-md-12 mb-12">
			<div class="card text-left">
				<div class="card-body">


					<a href="submitaudit.php?rid=<?php echo $sno; ?>&sno=<?php echo $tid; ?>&sid=<?php echo $sid; ?>" onclick="return confirm('Have you check all the Comments & Action Required if yes please submit ?')">
						<button class="btn btn-danger" type="button" style="float:right; margin-left:15px">Submit Audit</button></a>

					<a href="admin.php?id=audit1&rid=<?php echo $sno; ?>&sno=<?php echo $tid; ?>&sid=<?php echo $sid; ?>"><button class="btn btn-success" type="button" style="float:right; margin-left:15px">Edit Audit</button></a>


					<h4 class="card-title mb-3">View Detail</h4>


					<div class="col-md-12 mb-12">
						<iframe src="fssc/pdf/<?php echo $sno; ?>Audit_Report.pdf" height="800" width="100%">
					</div>





				</div>
			</div>
		</div>
	</div>