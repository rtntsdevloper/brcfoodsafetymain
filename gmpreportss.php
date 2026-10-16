<?php
include 'connection.php';
ini_set('max_execution_time', 600);
ini_set('memory_limit', '-1');
require('tcpdf/tcpdf.php');

$sno = $_GET['sno'];

$sql2 = mysqli_query($con, "select * from tblgmpaudit2 where id='$sno' ");
$row2 = mysqli_fetch_array($sql2);
$tid = $row2['audit'];
$sid = $row2['sid'];

$auditdate = date("d-m-Y", strtotime($row2['date']));

$auditee = mysqli_query($con, "select * from tblauditee where id='$row2[auditee]'");
$auditee1 = mysqli_fetch_array($auditee);





$auditor = mysqli_query($con, "select * from tblauditor where id='$row2[auditor]'");
$auditor1 = mysqli_fetch_array($auditor);

$total3 = mysqli_query($con, "select * FROM tblauditsection where id='$tid'");
$addtest = mysqli_fetch_array($total3);


$total2 = mysqli_query($con, "select * FROM tblauditsection1 where sid='$tid' and id='$sid'");
$subtest = mysqli_fetch_array($total2);


$total = mysqli_query($con, "SELECT * FROM tblauditsection2 where sid='$tid' and ssid='$sid'");
$subtest1 = mysqli_fetch_array($total);

$total1 = mysqli_num_rows($total);






$ns = mysqli_query($con, "SELECT * FROM tblgmpaudit3 where sno='$sno'  and ans='Not Applicable'");
$ns1 = mysqli_num_rows($ns);

$total1 = $total1 - $ns1;





 $psatis = mysqli_query($con, "SELECT * FROM tblgmpaudit3 where sno='$sno' and  ans='Satisfactory'");
  $psatis1 = mysqli_num_rows($psatis);
  $psatis2 = round($psatis1 / $total1 * 100);


  $punsatis = mysqli_query($con, "SELECT * FROM tblgmpaudit3 where sno='$sno' and  ans='Unsatisfactory'");
  $punsatis1 = mysqli_num_rows($punsatis);
  $punsatis2 = round($punsatis1 / $total1 * 100);
  
  $img="1s.png";

if($psatis2>=100 && $psatis2<=95)
{
$img="5s.png";
}
else if($psatis2>=90 && $psatis2<=94)
{
$img="4s.png";
}
else if($psatis2>=85 && $psatis2<=89)
{
$img="3s.png";
}
else if($psatis2>=80 && $psatis2<=84)
{
$img="2s.png";
}
else if($psatis2>=0 && $psatis2<=83)
{
$img="1s.png";
}


class MYPDF extends TCPDF
{

  public function Header()
  {
    $this->Rect(0, 0, $this->getPageWidth(),    $this->getPageHeight(), 'F', '', $fill_color = array(248, 248, 248));

    $image_file = 'images/1.png';
    $image_file1 = 'images/rtnts.png';

    $this->Image($image_file, 15, 1, 25, '', 'png', '', 'T', false, 200, '', false, false, 0, false, false, false);
    $this->Image($image_file1, 230, 4, 39, '', 'PNG', '', 'T', false, 200, '', false, false, 0, false, false, false);

    $this->SetFont('centurygothic', '', 20);

    $this->SetXY(17, 25);
  }
  public function Footer()
  {
    $this->SetY(-10);
    $this->SetFont('centurygothic', 'I', 8);
    $this->Cell(20, 5, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    $this->Cell(230, 5, date("d/m/Y "), 0, false, 'R', 0, '', 0, false, 'T', 'M');
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


$pdf->AddPage('L', 'LETTER');
$pdf->SetMargins(15, 45, 10, 10);
// $pdf->WriteHTMLCell(0, 0, 60, $pdf->GetY(), $image_file, 0, 1);

$pdf->SetFont('centurygothic', '', 30);


// GMP audit pie chart

  $xc = 220;
$yc = 145;
$r = 23;
$t2 = 0;
$n = 0;

if ($psatis2 != 0) {
    $n = $n + 1;
}

if ($punsatis2 != 0) {
    $n = $n + 1;
}

$totalpercent = $psatis2 + $punsatis2;

if ($totalpercent < 100) {
    $t1 = 100 - $totalpercent;
    $t2 = $t1 / $n;
}

if ($punsatis2 != 0) {
    $punsatis2 = $punsatis2 + $t2;
}

if ($psatis2 != 0) {
    $psatis2 = $psatis2 + $t2;
}

$apsatis = $psatis2 / 100 * 100;
$apunsatis = $punsatis2 / 100 * 100;

$astatis = $psatis2 / 100 * 360;
$aunstatis = $punsatis2 / 100 * 360;

$finalcontrol = $astatis + $aunstatis;

$pdf->SetFillColor(155, 202, 0);
$pdf->PieSector($xc, $yc, $r, 0, $astatis, 'FD', false, 0, 2);

$pdf->SetFillColor(255, 0, 0);
$pdf->PieSector($xc, $yc, $r, $astatis, $finalcontrol, 'FD', false, 0, 2);

$pdf->SetFillColor(0, 0, 0);
$pdf->PieSector($xc, $yc, $r, $finalcontrol, 360, 'FD', false, 0, 2);


$pdf->SetXY(75, 7);
 $headpage = strtoupper($addtest['name']);
 
$tble = <<<EOD
<table width="450" border="0" style="font-family:calibri; TEXT-ALIGN:CENTER;border-top-left-radius: 10px;" cellpadding="8"  >
  <tr>
    <td style="background-color:#B3EEFF;border-left-radius: 10px; font-size:20px">$headpage REPORT </td>
  </tr>
</table>
EOD;

$pdf->writeHTML($tble, true, false, true, false, '');

$tbl_header = '<style>
table {
   
   border-radius: 10px;
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
  
 
   font-size: 15px;
   color: #000000;
   padding: 3px 7px 2px;
}
</style>
<table id="gallerytab" width="100%" cellspacing="0" cellpadding="2" border="0">
  ';

$tbl_footer = '</table>';

// die;
$pdf->SetXY(5, 40);

$tbl8 = '';
$tbl8 .= '<table bgcolor="white" width="500">
  <tr>
    <td><table width="500" border="0" cellspacing="10" cellpadding="8">
      <tr style="background-color:#D4EEFF;font-size:25px;text-align:center;font-weight:bold">
        <td >Audit Date </td>
        <td>' . $auditdate . '</td>
      </tr>
      <tr style="background-color:#D4EEFF;font-size:25px;text-align:center;font-weight:bold">
        <td>Name Of Auditor </td>
        <td>' . $auditor1['name'] . '
        </td>
      </tr>
      <tr style="background-color:#D4EEFF;font-size:25px;text-align:center;font-weight:bold">
        <td>Name Of Auditee</td>
        <td> ' . $auditee1['name'] . '</td>
      </tr>
     
	 <tr style="background-color:#D4EEFF;font-size:25px;text-align:center;font-weight:bold">
        <td>Audit Scope</td>
        <td>'.$subtest['name'].'</td>
      </tr>
	  
      <tr style="background-color:#D4EEFF;font-size:25px;text-align:left;font-weight:bold">
        <td colspan="2">Audit Criteria : ' . $addtest['name'] . '</td>
        </tr>
		
    
    </table></td>
  </tr> </table>';

$pdf->writeHTML($tbl_header . $tbl8 . $tbl_footer, true, false, false, false, '');

$pdf->SetXY(160, 40);
 $tbl8 = '';
  $tbl8 .= '<table bgcolor="white"  width="350"cellspacing="7" cellpadding="7">
  <tr>
    <td><table   width="340" border="0" cellspacing="7" cellpadding="7">
      <tr bgcolor="#FAF3EB" >
        <td >&nbsp;</td>
        <td style="font-size:13px;text-align:center;font-weight:bold">No. of findings </td>
        <td style="font-size:13px;text-align:center;font-weight:bold">%</td>
      </tr>
      <tr bgcolor="#FAF3EB" >
        <td bgcolor="#FF0001" style="font-size:12px;text-align:center;font-weight:bold">Unsatisfactory</td>
        <td style="font-size:15px;text-align:center;font-weight:bold">' . $punsatis1 . '</td>
        <td style="font-size:15px;text-align:center;font-weight:bold">' . $apunsatis . '%</td>
      </tr>
      <tr bgcolor="#FAF3EB" >
        <td bgcolor="#9BCA00" style="font-size:12px;text-align:center;font-weight:bold">satisfactory</td>
        <td style="font-size:15px;text-align:center;font-weight:bold">' . $psatis1 . '</td>
        <td style="font-size:15px;text-align:center;font-weight:bold">' . $apsatis . '%</td>
      </tr>

    </table></td>
  </tr>
</table>';


$pdf->writeHTML($tbl_header . $tbl8 . $tbl_footer, true, false, false, false, '');


$pdf->AddPage('L', 'LETTER');

$pdf->SetXY(0, 30);
$tbl8 = '';
$tbl8 .= '';

$pdf->writeHTML($tbl_header . $tbl8 . $tbl_footer, true, false, false, false, '');

$pdf->SetFont('centurygothic', '', 12);

$tble5 = "";
$tble5 .= '
<h1 style="text-align:center; margin:20px 0px; font-size:32px;">Non Conformance Summary Sheet</h1>
<table width="100%" cellpadding="5"  border="1" style="text-align:center " >
<thead>
<tr style=" background-color:#D4EEFF; font:size:15px;">
<th width="57" style="font-size:19px;"> S.No</th>
<th width="260" style="font-size:19px;">Details</th>
<th width="300" style="font-size:19px;">Finding</th>
<th width="140" style="font-size:19px;">Category</th>
<th width="140" style="font-size:19px;">Closure Date</th>
</tr></thead>';



$sqd = mysqli_query($con, "select t1.*,t2.qid from tblauditsection2 t1, tblgmpaudit3 t2 where t1.sid='$tid' and t1.ssid='$sid' and  t2.qid=t1.id and t2.sno='$sno'");

$u = 0;
foreach ($sqd as $sdt) {
 
  $sqd1 = mysqli_query($con, "select * from tblgmpaudit3 where sno='$sno' and qid='$sdt[id]'");
  $sdt1 = mysqli_fetch_array($sqd1);

  $sqd2 = mysqli_query($con, "select * from tblaction1 where sno='$sdt1[id]'");
  $sdt2 = mysqli_fetch_array($sqd2);
  // print_r($sdt2);
  // print_r("select * from tblaction1 where sno='$sdt1[id]'");


  if (isset($sdt["ques"]))
   {
    $ncq = $sdt["ques"];
  }
  if (isset($sdt1["action"]))
   {
    $nca = $sdt1["action"];
  }
  if (isset($sdt1["ans"])) 
  {
    if ($sdt1["ans"] != "Satisfactory")
	 {
      $nccat = $sdt1["ans"];
    }
    
  }
  if ($sdt2["date1"]!= "0000-00-00") 
  {
    $ncdte = $sdt2["date1"];
  } 
  else
  {
    $ncadte='';
  }

  if ($sdt1["ans"] != "Satisfactory") 
  {
 $u++;
  $tble5 .= '
<tr nobr ="true" >

<td width="57">' . $u . '</td>
<td width="260">' . $ncq . '</td>
<td width="300">' . $nca . '</td>
<td width="140">' . $nccat . '</td>
<td width="140">' . $ncdte . '</td>

</tr>
';
}

}

$tble5 .= '</table>';


$pdf->writeHTML($tble5, true, false, true, false);



$pdf->AddPage('L', 'LETTER');

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
  
   font-size: 18px;
  
   padding-bottom: 4px;
   padding-left: 8px;
   padding-top: 5px;
   text-align: left;
}
td {
  
 
   font-size: 18px;
   color: #000000;
   padding: 3px 7px 2px;
}
</style>

<table id="gallerytab" width="100%" cellspacing="0" cellpadding="7" border="1">
  ';

$tbl_footer = '</table>';
$tbl7 = '';

$sq2 = mysqli_query($con, "select t1.*,t2.qid from tblauditsection2 t1, tblgmpaudit3 t2 where t1.sid='$tid' and t1.ssid='$sid' and  t2.qid=t1.id and t2.sno='$sno' and t2.ans!='Not Applicable'");

$u = 0;
while ($row2 = mysqli_fetch_array($sq2)) 
{
  $u++;
  $sql3 = mysqli_query($con, "select * from tblgmpaudit3 where sno='$sno' and qid='$row2[id]'");
  $row3 = mysqli_fetch_array($sql3);
  

  $ques = mysqli_real_escape_string($con, $row2['ques']);

  $tbl7 .= '
  
  <tr nobr="true">
    <td width="250" style="background-color:#D4EEFF">Question ' . $u . '</td>
    <td width="650" style="background-color:#D4EEFF">' . $ques . '</td>
  </tr>
  ';
  if ($row3['ans'] == "Unsatisfactory") 
  {
    $stcolor = '#FF8800';
  } 
  else if ($row3['ans'] == "Satisfactory") 
  {
    $stcolor = '#9BCA00';
  }

  
  $tbl7 .= '
  <tr nobr="true">
    <td>Status</td>
    <td style="color:' . $stcolor .'">' . $row3['ans'] . '</td></tr>';

if($row3['cmnt']!="")
{
    $tbl7 .= ' <tr nobr="true">
    <td>Remarks</td>
    <td>' . $row3['cmnt'] . '</td></tr>';
}




  if ($row3['action'] != "") 
  {
    $tbl7 .= '
	 <tr nobr="true">
	 <td>Action Required</td>
     <td> ' . $row3['action'] . '</td>
	</tr>';
  }
  if ($row3['deliver'] != "" && $row3['ans']!= "Satisfactory") 
  {
    $tbl7 .= '<tr nobr="true">
	  <td>Completion date agreed</td>
     <td>' . date('d-m-Y', strtotime($row3['deliver'])) . '</td>
	</tr>';
  }


  if ($row3['img'] != "")
   {
    $string = $row3['img'];
    $tags1 = explode(';', $string);
    foreach ($tags1 as $key1) {
      $info5 = new SplFileInfo($key1);
      $tpe1 = $info5->getExtension();
      if ($tpe1 != "") 
	  {
        if ($tpe1 == "jpg" || $tpe1 == "jpeg" || $tpe1 == "png" || $tpe1 == "PNG") 
		{

          $tbl7 .= '<tr nobr="true">
    <td>Supporting documents</td>
    <td><img src="auditpic/' . $key1 . '" height="300"  width="300"></td>
  </tr>';
        } 
		else
		 {
          $tbl7 .= '<tr nobr="true">
    <td>Supporting documents</td>
    <td><a href="' . $portallink . '../auditpic/' . $key1 . '" target="_blank">' . $key1 . '</a></td>
  </tr>';
        }
      }
    }
  }



  $sh6 = mysqli_query($con, "select * from tblaction1 where sno='$row3[id]'");
  while ($hj6 = mysqli_fetch_array($sh6))
   {
    $string1 = $hj6['comment'];
    

    $tbl7 .=  '
							
							<tr nobr="true">
						 <td >Evidence submit date	</td>
						 <td>' . date('d-m-Y', strtotime($hj6['date'])) . '</td>
						 </tr>
						 			
						 <tr nobr="true">
						 <td>Root Cause:</td>
						<td>' .$string1. '</td>
						 </tr>
						 
						 <tr nobr="true">
						 <td>Corrective Action:</td>
						 <td>' . $hj6['corrective'] . '</td>
						 </tr>
						 ';


    if ($hj6['img'] != "") {
      $file_name1 = $hj6['img'];
      $tpe11 = pathinfo($file_name1, PATHINFO_EXTENSION);
      if ($tpe11 != "") {
        if ($tpe11 == "jpg" || $tpe11 == "jpeg" || $tpe11 == "png" || $tpe11 == "PNG") {
          $tbl7 .= '<tr nobr="true">
    <td>Supporting documents</td>
    <td><img src="auditpic/' . $file_name1 . '" height="300"  width="300"></td>
  </tr>';
        } else {
          $tbl7 .= '<tr nobr="true">
    <td>Supporting documents</td>
    <td><a href="' . $portallink . '../auditpic/' . $file_name1 . '" target="_blank">' . $file_name1 . '</a></td>
  </tr>';
        }
      }
    }



    if ($hj6['date1'] != "0000-00-00") {
      $tbl7 .= ' <tr nobr="true">
						 <td >Evidence verification date	</td>
						 <td>' . date('d-m-Y', strtotime($hj6['date1'])) . '</td>
						 </tr>';
    }


    if ($hj6['ans'] != "") {
      $tbl7 .= '
						 <tr nobr="true">
						 <td>Auditor Response</td>';
      if ($hj6['ans'] == "Accepted") {
        $tbl7 .= '  <td style="color:green">' . $hj6['ans'] . '</td>';
      } else if ($hj6['ans'] == "Rejected") {
        $tbl7 .= '  <td style="color:red">' . $hj6['ans'] . '</td>';
      }
      $tbl7 .= '
						  </tr>
						 <tr nobr="true">
						 <td>Auditor Comment</td>
						 <td>' . $hj6['cmnt'] . '</td>
						 </tr>';
    }
  }
}

$pdf->writeHTML(utf8_encode($tbl_header . $tbl7 . $tbl_footer), true, false, true, false, '');
ob_clean();

 $pdf->Output($_SERVER['DOCUMENT_ROOT'] . "brcfoodsafety/gmpreport/".$sno."- Audit Report.pdf",'F');
 
 ?>
 
  <iframe src="gmpreport/<?php echo $sno;?>- Audit Report.pdf" width="100%"  height="100%">