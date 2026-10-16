<?php
ini_set('max_execution_time', 600);
ini_set('memory_limit','-1');
	require('tcpdf/tcpdf.php');
			
				$sno=$_GET['sno']; 
				  
				$sql2=mysqli_query($con,"select * from tblgmpaudit2 where id='$sno' ");
				$row2=mysqli_fetch_array($sql2);
				$tid=$row2['audit'];
				$sid=$row2['sid']; 
				
				$auditdate=date("d-m-Y", strtotime($row2['date']));
				 
				  $auditee=mysqli_query($con,"select * from tblauditee where id='$row2[auditee]'");
                  $auditee1=mysqli_fetch_array($auditee);
				  
				  
				   $auditor=mysqli_query($con,"select * from tblauditor where id='$row2[auditor]'");
                  $auditor1=mysqli_fetch_array($auditor);
				  
				  $total3=mysqli_query($con,"select * FROM tblauditsection where id='$tid'");
				  $addtest=mysqli_fetch_array($total3);
				  
				  
				   $total2=mysqli_query($con,"select * FROM tblauditsection1 where sid='$tid' and id='$sid'");
				   $subtest=mysqli_fetch_array($total2);
				  
				  
				  $total=mysqli_query($con,"SELECT * FROM tblauditsection2 where sid='$tid' and ssid='$sid'");
				  $subtest1=mysqli_fetch_array($total);
				  
                           $total1=mysqli_num_rows($total);
						   
						   
						   
		if($addtest['name']=="GMP Audit" || $addtest['name']=="GHP Audit")
		{
						   
$ns=mysqli_query($con,"SELECT * FROM tblgmpaudit3 where sno='$sno'  and ans='Not Applicable'");
$ns1=mysqli_num_rows($ns);


$total1=$total1-$ns1;

$complete=mysqli_query($con,"SELECT * FROM tblgmpaudit3 where sno='$sno' and ans='Compliant'");
$complete1=mysqli_num_rows($complete);
 $complete2=round($complete1/$total1*100);
 
$pending=mysqli_query($con,"SELECT * FROM tblgmpaudit3 where sno='$sno' and  ans='Major'");
$pending1=mysqli_num_rows($pending);
$pending2=round($pending1/$total1*100);

$progres=mysqli_query($con,"SELECT * FROM tblgmpaudit3 where sno='$sno' and ans='Minor'");
$progres1=mysqli_num_rows($progres);
$progres2=round($progres1/$total1*100);

   $na=mysqli_query($con,"SELECT * FROM  tblgmpaudit3 where sno='$sno' and ans='Critical'");
  $na1=mysqli_num_rows($na);
  $na2=round($na1/$total1*100);


   class MYPDF extends TCPDF {

        public function Header() {
	
        $image_file = 'images/1.png';
		  $image_file1 = 'images/rtnts.png';
	
        $this->Image($image_file, 15, 5, 25, '', 'png', '', 'T', false, 200, '', false, false, 0, false, false, false);
		   $this->Image($image_file1, 170, 5, 35, '', 'png', '', 'T', false, 200, '', false, false, 0, false, false, false);
		
		$this->SetFont('centurygothic', '', 18);
				$this->SetXY(17,25);
   
        
    }
	    public function Footer()
	    {
        $this->SetY(-10);
        $this->SetFont('centurygothic', 'I', 8);
        $this->Cell(20, 5, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
		$this->Cell(270, 5, date("d/m/Y "), 0, false, 'C', 0, '', 0, false, 'T', 'M');

    }
    
}
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->SetMargins(PDF_MARGIN_LEFT, 35, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

$pdf->AddPage('P', 'LETTER');

$pdf->SetFont('centurygothic', '',20);
$pdf->SetXY(15,30);
$pdf->Write(15, "Audit Report", '', '0', '0', true, 'C', false, false, 0);

$xc = 50;
$yc =130;
$r = 20;
$t2 = 0;
$n=0;
if($complete2!=0)
{
$n=$n+1;
}

if($pending2!=0)
{
$n=$n+1;
}

if($progres2!=0)
{
$n=$n+1;
}

if($na2!=0)
{
$n=$n+1;
}



$totalpercent=$complete2+$pending2+$progres2+$na2;
if($totalpercent<100)
{

$t1=100-$totalpercent;
$t2=$t1/$n;
}
if($complete2!=0)
{
$complete2=$complete2+$t2;
}
if($pending2!=0)
{
$pending2=$pending2+$t2;
}

if($progres2!=0)
{
$progres2=$progres2+$t2;
}
if($na2!=0)
{
$na2=$na2+$t2;
}

$acritical2=$na2/100*360;
$amajor2=$pending2/100*360;
$aminor2=$progres2/100*360;
$acompliant2=$complete2/100*360;

$finalmajor=$amajor2+$acritical2;
$finalminor=$finalmajor+$aminor2;
$finalcompliant=$finalminor+$acompliant2;
$finalcontrol=$finalcompliant+$acritical2;

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

$pdf->SetFont('centurygothic', '',10);


$pdf->SetXY(100,100);

$tbl=<<<EOD

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


$pdf->SetFont('centurygothic', '',10);


$pdf->SetXY(15,50);

$tble=<<<EOD

<table width="100%" border="1" style="font-family:calibri;" cellpadding="5" >
 
  <tr>
    <td width="100">Audit Date </td>
    <td width="550">$auditdate</td>
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
    <td>$addtest[id]. $addtest[name]</td>
  </tr>
  <tr>
    <td>Sub-Section</td>
    <td>$subtest[name]</td>
  </tr>

</table>
EOD;

$pdf->writeHTML($tble, true, false, true, false, '');



$pdf->SetXY(15,160);

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
    <td width="150" style="background-color:#52AE32;color:white">Sno</td>
    <td width="500" style="background-color:#52AE32;color:white">Question</td>
  </tr>
  ';
  
$sq2=mysqli_query($con,"select * from tblauditsection2 where sid='$tid' and ssid='$sid'");
$u=0;
while($row2=mysqli_fetch_array($sq2))
{
$u++;
$sql3=mysqli_query($con,"select * from tblgmpaudit3 where sno='$sno' and qid='$row2[id]'");
$row3=mysqli_fetch_array($sql3);


$ques=mysqli_real_escape_string($con,$row2['ques']);

$tbl7 .= '<tr nobr="true">
    <td width="150">Question '.$u.'</td>
    <td width="500">'.$ques.'</td>
  </tr>
  ';

  $tbl7 .= '
  <tr nobr="true">
    <td>Answer</td>';
	if($row3['ans']=="Compliant")
	{
	if($row3['cmnt']!="")
	{
    $tbl7 .= '<td style="color:green">'.$row3['ans'].'-' .$row3['cmnt'].'</td>';
	}
	else
	{
	 $tbl7 .= '<td style="color:green">'.$row3['ans'].'</td>';
	}
	}
	else if($row3['ans']=="Not Applicable")
	{
	if($row3['cmnt']!="")
	{
    $tbl7 .= '<td>'.$row3['ans'].'-' .$row3['cmnt'].'</td>';
	}
	else
	{
	 $tbl7 .= '<td>'.$row3['ans'].'</td>';
	}
	}
	else if($row3['ans']=="Major")
	{
	if($row3['cmnt']!="")
	{
    $tbl7 .= '<td style="color:red">'.$row3['ans'].'-' .$row3['cmnt'].'</td>';
	}
	else
	{
	 $tbl7 .= '<td style="color:red">'.$row3['ans'].'</td>';
	}
	}
	else if($row3['ans']=="Minor")
	{
	if($row3['cmnt']!="")
	{
    $tbl7 .= '<td style="color:orange">'.$row3['ans'].'-' .$row3['cmnt'].'</td>';
	}
	else
	{
	 $tbl7 .= '<td style="color:orange">'.$row3['ans'].'</td>';
	}
	}
	else if($row3['ans']=="Critical")
	{
	if($row3['cmnt']!="")
	{
    $tbl7 .= '<td style="color:#0080C0">'.$row3['ans'].'-' .$row3['cmnt'].'</td>';
	}
	else
	{
	 $tbl7 .= '<td style="color:#0080C0">'.$row3['ans'].'</td>';
	}
	}
	
  $tbl7 .= '</tr>';
  
  if($row3['action']!="")
	{
	 $tbl7 .= '
	 <tr nobr="true">
	 <td>Action Required</td>
     <td> '.$row3['action'].'</td>
	</tr>';
	}
	if($row3['deliver']!="" && $row3['ans']!="Compliant")
	{
	 $tbl7 .= '<tr nobr="true">
	  <td>Completion date agreed</td>
     <td>'.date('d-m-Y', strtotime($row3['deliver'])).'</td>
	</tr>
	';
	}
  
  
  if($row3['img']!="")
  {
   $string = $row3['img'];
$tags1 = explode(';' , $string);
foreach($tags1 as $key1)
  {
   $info5= new SplFileInfo($key1);
  $tpe1=$info5->getExtension();
  if( $tpe1!="")
  {
  if($tpe1=="jpg" || $tpe1=="jpeg" || $tpe1=="png" || $tpe1=="PNG")
    {
  
   $tbl7 .= '<tr nobr="true">
    <td>Supporting documents</td>
    <td><img src="auditpic/'.$key1.'" height="300"  width="300"></td>
  </tr>';
  }
  else
  {
  $tbl7 .= '<tr nobr="true">
    <td>Supporting documents</td>
    <td><a href="'.$portallink.'auditpic/'.$key1.'" target="_blank">'.$key1.'</a></td>
  </tr>';
  }
  }
  }
  }
  
 
 
  $sh6=mysqli_query($con,"select * from tblaction1 where sno='$row3[id]'");
  while($hj6=mysqli_fetch_array($sh6))
	{
	$tbl7 .=	'
							
							<tr>
						 <td >Evidence submit date	</td>
						 <td>'. date('d-m-Y',strtotime($hj6['date'])).'</td>
						 </tr>
						 			
						 <tr>
						 <td>Auditee Comment:</td>
						 <td>'. $hj6['comment'].'</td>
						 </tr>
						 
						 <tr>
						 <td>Corrective Action:</td>
						 <td>'. $hj6['corrective'].'</td>
						 </tr>
						 ';
								
								
	if($hj6['img']!="")
  {
   $file_name1 = $hj6['img'];
  $tpe11 = pathinfo($file_name1, PATHINFO_EXTENSION);
  if( $tpe11!="")
  {
  if($tpe11=="jpg" || $tpe11=="jpeg" || $tpe11=="png" || $tpe11=="PNG" )
    {
   $tbl7 .= '<tr nobr="true">
    <td>Supporting documents</td>
    <td><img src="auditpic/'.$file_name1.'" height="300"  width="300"></td>
  </tr>';
  }
  else 
  {
  $tbl7.= '<tr nobr="true">
    <td>Supporting documents</td>
    <td><a href="'.$portallink.'auditpic/'.$file_name1.'" target="_blank">'.$file_name1.'</a></td>
  </tr>';
  }
  }
  }
  				
						
						 
						 if($hj6['date1']!="0000-00-00")
						 {
						 $tbl7 .= ' <tr>
						 <td >Evidence verification date	</td>
						 <td>'. date('d-m-Y',strtotime($hj6['date1'])).'</td>
						 </tr>';
						 }
						 
						 
						 if($hj6['ans']!="")
						 {
						 $tbl7 .= '
						 <tr>
						 <td>Auditor Response</td>';
						 if($hj6['ans']=="Accepted")
						 {
						 $tbl7 .= '  <td style="color:green">'.$hj6['ans'].'</td>';
						 }
						 else if($hj6['ans']=="Rejected")
						 {
						 $tbl7 .= '  <td style="color:red">'.$hj6['ans'].'</td>';
						 }
						 $tbl7 .= '
						  </tr>
						 <tr>
						 <td>Auditor Comment</td>
						 <td>'.$hj6['cmnt'].'</td>
						 </tr>';
						 }


					
												
									}
  }


  


$pdf->writeHTML(utf8_encode($tbl_header . $tbl7 . $tbl_footer), true, false, true, false, '');
}


else 
{
$complete=mysqli_query($con,"SELECT * FROM tblgmpaudit3 where sno='$sno' and ans='Satisfactory'");
$complete1=mysqli_num_rows($complete);
 $complete2=round($complete1/$total1*100);
 
$pending=mysqli_query($con,"SELECT * FROM tblgmpaudit3 where sno='$sno' and  ans='Unsatisfactory'");
$pending1=mysqli_num_rows($pending);
$pending2=round($pending1/$total1*100);



   class MYPDF extends TCPDF {

        public function Header() {
	
        $image_file = 'images/1.png';
		  $image_file1 = 'images/rtnts.png';
	
        $this->Image($image_file, 15, 5, 30, '', 'png', '', 'T', false, 200, '', false, false, 0, false, false, false);
		   $this->Image($image_file1, 170, 5, 35, '', 'png', '', 'T', false, 200, '', false, false, 0, false, false, false);
		
		$this->SetFont('centurygothic', '', 18);
				$this->SetXY(17,25);
   
        
    }
	    public function Footer()
	    {
        $this->SetY(-10);
        $this->SetFont('centurygothic', 'I', 8);
        $this->Cell(20, 5, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
		$this->Cell(270, 5, date("d/m/Y "), 0, false, 'C', 0, '', 0, false, 'T', 'M');

    }
    
}
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->SetMargins(PDF_MARGIN_LEFT, 35, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

$pdf->AddPage('P', 'LETTER');



$pdf->SetFont('centurygothic', '',20);

$pdf->SetXY(15,30);
$pdf->Write(15, "Audit Report", '', '0', '0', true, 'C', false, false, 0);



$xc = 50;
$yc =130;
$r = 20;
$t2 = 0;
$n=0;
if($complete2!=0)
{
$n=$n+1;
}

if($pending2!=0)
{
$n=$n+1;
}





$totalpercent=$complete2+$pending2;
if($totalpercent<100)
{

$t1=100-$totalpercent;
$t2=$t1/$n;
}
if($complete2!=0)
{
$complete2=$complete2+$t2;
}
if($pending2!=0)
{
$pending2=$pending2+$t2;
}


$acritical2=$complete2/100*360;
$amajor2=$pending2/100*360;

$finalmajor=$amajor2+$acritical2;
$finalminor=$finalmajor+amajor2;

//na
$pdf->SetFillColor(73, 153, 67);
$pdf->PieSector($xc, $yc, $r, 0, $acritical2, 'FD', false, 0, 2);

//pnding
$pdf->SetFillColor(209, 31, 41);
$pdf->PieSector($xc, $yc, $r, $acritical2, $finalmajor, 'FD', false, 0, 2);

//progress
$pdf->SetFillColor(73, 153, 67);
$pdf->PieSector($xc, $yc, $r, $finalmajor, $finalminor, 'FD', false, 0, 2);


$pdf->SetFont('centurygothic', '',10);


$pdf->SetXY(100,120);

$tbl=<<<EOD

<table width="130" border="0" style="font-family:calibri;border:1px solid #000000;">
<tr nobr="true">
  <td width="5"></td>
    <td width="20" height="5"></td>
    <td width="170" height="5"></td>
  </tr>
 
   
   
   <tr nobr="true">
    <td width="5"></td>
    <td width="20" height="15"><div bgcolor="#D11F29" align="center" style="width:15px; height:15px; background:#D11F29"></div></td>
    <td width="170" height="15">Unsatisfactory [$pending2%]</td>
   </tr>
   <tr nobr="true">
    <td width="5"></td>
    <td width="20" height="15"><div bgcolor="#499943" align="center" style="width:15px; height:15px; background:#499943"></div></td>
    <td width="170" height="15">Satisfactory [$complete2%]</td>
    </tr>
   </table>
EOD;

$pdf->writeHTML($tbl, true, false, true, false, '');


$pdf->SetFont('centurygothic', '',10);


$pdf->SetXY(15,50);

$tble=<<<EOD

<table width="100%" border="1" style="font-family:calibri;" cellpadding="5" >
 
  <tr>
    <td width="100">Audit Date </td>
    <td width="550">$auditdate</td>
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
    <td>$addtest[id]. $addtest[name]</td>
  </tr>
  <tr>
    <td>Sub-Section</td>
    <td>$subtest[name]</td>
  </tr>

</table>
EOD;

$pdf->writeHTML($tble, true, false, true, false, '');



$pdf->SetXY(15,160);

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
    <td width="150" style="background-color:#52AE32;color:white">Sno</td>
    <td width="500" style="background-color:#52AE32;color:white">Question</td>
  </tr>
  ';
  
$sq2=mysqli_query($con,"select * from tblauditsection2 where sid='$tid' and ssid='$sid'");
$u=0;
while($row2=mysqli_fetch_array($sq2))
{
$u++;
$sql3=mysqli_query($con,"select * from tblgmpaudit3 where sno='$sno' and qid='$row2[id]'");
$row3=mysqli_fetch_array($sql3);


$ques=mysqli_real_escape_string($con,$row2['ques']);

$tbl7 .= '<tr nobr="true">
    <td width="150">Question '.$u.'</td>
    <td width="500">'.$ques.'</td>
  </tr>
  ';

  $tbl7 .= '
  <tr nobr="true">
    <td>Answer</td>';
	if($row3['ans']=="Satisfactory")
	{
	if($row3['cmnt']!="")
	{
    $tbl7 .= '<td style="color:green">'.$row3['ans'].'-' .$row3['cmnt'].'</td>';
	}
	else
	{
	 $tbl7 .= '<td style="color:green">'.$row3['ans'].'</td>';
	}
	}
	else if($row3['ans']=="Unsatisfactory")
	{
	if($row3['cmnt']!="")
	{
    $tbl7 .= '<td style="color:red">'.$row3['ans'].'-' .$row3['cmnt'].'</td>';
	}
	else
	{
	 $tbl7 .= '<td style="color:red">'.$row3['ans'].'</td>';
	}
	}
	
	
  $tbl7 .= '</tr>';
  
  if($row3['action']!="")
	{
	 $tbl7 .= '
	 <tr nobr="true">
	 <td>Action Required</td>
     <td> '.$row3['action'].'</td>
	</tr>';
	}
	if($row3['deliver']!="" && $row3['ans']!="Compliant")
	{
	 $tbl7 .= '<tr nobr="true">
	  <td>Completion date agreed</td>
     <td>'.date('d-m-Y', strtotime($row3['deliver'])).'</td>
	</tr>
	';
	}
  
  
  if($row3['img']!="")
  {
   $string = $row3['img'];
$tags1 = explode(';' , $string);
foreach($tags1 as $key1)
  {
   $info5= new SplFileInfo($key1);
  $tpe1=$info5->getExtension();
  if( $tpe1!="")
  {
  if($tpe1=="jpg" || $tpe1=="jpeg" || $tpe1=="png" || $tpe1=="PNG")
    {
  
   $tbl7 .= '<tr nobr="true">
    <td>Supporting documents</td>
    <td><img src="auditpic/'.$key1.'" height="300"  width="300"></td>
  </tr>';
  }
  else
  {
  $tbl7 .= '<tr nobr="true">
    <td>Supporting documents</td>
    <td><a href="'.$portallink.'auditpic/'.$key1.'" target="_blank">'.$key1.'</a></td>
  </tr>';
  }
  }
  }
  }
  
 
 
  $sh6=mysqli_query($con,"select * from tblaction1 where sno='$row3[id]'");
  while($hj6=mysqli_fetch_array($sh6))
	{
	$tbl7 .=	'
							
							<tr>
						 <td >Evidence submit date	</td>
						 <td>'. date('d-m-Y',strtotime($hj6['date'])).'</td>
						 </tr>
						 			
						 <tr>
						 <td>Auditee Comment:</td>
						 <td>'. $hj6['comment'].'</td>
						 </tr>
						 
						 <tr>
						 <td>Corrective Action:</td>
						 <td>'. $hj6['corrective'].'</td>
						 </tr>
						 ';
								
								
	if($hj6['img']!="")
  {
   $file_name1 = $hj6['img'];
  $tpe11 = pathinfo($file_name1, PATHINFO_EXTENSION);
  if( $tpe11!="")
  {
  if($tpe11=="jpg" || $tpe11=="jpeg" || $tpe11=="png" || $tpe11=="PNG" )
    {
   $tbl7 .= '<tr nobr="true">
    <td>Supporting documents</td>
    <td><img src="auditpic/'.$file_name1.'" height="300"  width="300"></td>
  </tr>';
  }
  else 
  {
  $tbl7.= '<tr nobr="true">
    <td>Supporting documents</td>
    <td><a href="'.$portallink.'auditpic/'.$file_name1.'" target="_blank">'.$file_name1.'</a></td>
  </tr>';
  }
  }
  }
  				
						
						 
						 if($hj6['date1']!="0000-00-00")
						 {
						 $tbl7 .= ' <tr>
						 <td >Evidence verification date	</td>
						 <td>'. date('d-m-Y',strtotime($hj6['date1'])).'</td>
						 </tr>';
						 }
						 
						 
						 if($hj6['ans']!="")
						 {
						 $tbl7 .= '
						 <tr>
						 <td>Auditor Response</td>';
						 if($hj6['ans']=="Accepted")
						 {
						 $tbl7 .= '  <td style="color:green">'.$hj6['ans'].'</td>';
						 }
						 else if($hj6['ans']=="Rejected")
						 {
						 $tbl7 .= '  <td style="color:red">'.$hj6['ans'].'</td>';
						 }
						 $tbl7 .= '
						  </tr>
						 <tr>
						 <td>Auditor Comment</td>
						 <td>'.$hj6['cmnt'].'</td>
						 </tr>';
						 }

												
									}
  }

$pdf->writeHTML(utf8_encode($tbl_header . $tbl7 . $tbl_footer), true, false, true, false, '');
}


 $pdf->Output("gmpreport/".$sno."-Audit Report.pdf",'F');
      ?>


<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Audit Management</a></li>
                        <li>View Detail</li>
                    </ul>
                </div>
				<?php
				$sno=$_GET['sno'];
				?>
			
				
			       <div class="row mb-12">
                    <div class="col-md-12 mb-12">
                        <div class="card text-left">
                            <div class="card-body">
							
							
							<a href="gmpreports1.php?sno=<?php echo $sno;?>" target="_blank"><button class="btn btn-danger" style="float:right; margin-left:15px">NC Report</button></a>
							
							
							
							<a href="gmpreports.php?sno=<?php echo $sno;?>" target="_blank"><button class="btn btn-success" style="float:right; margin-left:15px">View Report</button></a>
							
							
							
                             <h4 class="card-title mb-3">View Detail</h4>
								
                           
								 <div class="row">
                                    
									
									
								
								  <div class="table-responsive">
                                     <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
												<th scope="col">Date</th>
                                                <th scope="col">Auditor</th>
												 <th scope="col">Subject</th>
												 <th scope="col">Question</th>
												 <th scope="col">Ans</th>
												 <th scope="col">Status</th>
                                                 <th scope="col">Action</th>
												
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										$df=mysqli_query($con,"select * from tblgmpaudit2 where id='$sno'");
										$gh=mysqli_fetch_array($df);
										
										$sh1=mysqli_query($con,"select * from tblgmpaudit3 where  sno='$sno'");
										$i=0;
                                        while($hj1=mysqli_fetch_array($sh1))
										{
										$i++;
										?>
                                            <tr>
                                                <th scope="row"><?php echo $i;?></th>
                                                <td><?php echo date("d-m-Y", strtotime($gh['date']));?></td>
                                               <td><?php echo $auditor1['name'];?> </td>
                                                <td> <?php echo  $subtest['name']; ?> </td>
												 <td> <?php echo $hj1['ques'] ;?>   </td>
												 <td> <?php echo $hj1['ans'] ;?>   </td>
											   
											     <td> 
												 <?php 
												 if($hj1['status']=="closedoff")
												 {
												 echo "Evidence is submitted";
												 }
												 else
												 {
												  echo $hj1['status'];
												 }
												 
												 ?>  
												 </td>
                                                <td>
												<?php
												if($hj1['ans']=="Compliant" || $hj1['ans']=="Not Applicable")
												{
												}
												else
												{
												?>
      <a href="admin.php?id=gmpnc1&sno=<?php echo $hj1['id'];?>&sno1=<?php echo $_GET['sno'];?>"><button class="btn btn-info" type="button"><i class="fa fa-eye"></i></button></a>
                                                   <?php
												   }
												   ?>
                                                </td>
                                            </tr>
                                           <?php
										   }
										   ?>
                                        </tbody>
                                    </table>
									</div>
									</div>
									
									
									
									
									
                               </div></div></div></div>