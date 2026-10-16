<?php
include 'connection.php';

ini_set('max_execution_time', 600);
ini_set('memory_limit','-1');
session_start();
				
				$sno=$_GET['sno'];  
				  
				  $total=mysqli_query($con,"SELECT * FROM subtest1 where tid='$sno'");
$total1=mysqli_num_rows($total);

$complete=mysqli_query($con,"SELECT * FROM subtest1 where tid='$sno' and status='2'");
$complete1=mysqli_num_rows($complete);
$complete2=round($complete1/$total1*100);


$pending=mysqli_query($con,"SELECT * FROM subtest1 where tid='$sno' and status='0'");
$pending1=mysqli_num_rows($pending);
$pending2=round($pending1/$total1*100);

$progres=mysqli_query($con,"SELECT * FROM subtest1 where tid='$sno' and status='1'");
$progres1=mysqli_num_rows($progres);
$progres2=round($progres1/$total1*100);

$na=mysqli_query($con,"SELECT * FROM subtest1 where tid='$sno' and status='3'");
$na1=mysqli_num_rows($na);
 $na2=round($na1/$total1*100);

$ns=mysqli_query($con,"SELECT * FROM subtest1 where tid='$sno' and status='4'");
$ns1=mysqli_num_rows($ns);
$ns2=round($ns1/$total1*100);


require('tcpdf/tcpdf.php');

   class MYPDF extends TCPDF {

        public function Header() {
	
        $image_file = 'images/1.png';
	
        $this->Image($image_file, 15, 5, 40, '', 'png', '', 'T', false, 200, '', false, false, 0, false, false, false);
		
		
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
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, false, 'UTF-8', false);
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
$pdf->Write(15, "General Compliance Report", '', '0', '0', true, 'C', false, false, 0);


$xc = 50;
$yc =70;
$r = 20;

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

if($ns2!=0)
{
$n=$n+1;
}

$totalpercent=$complete2+$pending2+$progres2+$na2+$ns2;
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

if($ns2!=0)
{
$ns2=$ns2+$t2;
}


$tacritical2=$ns2/100*360;

$acritical2=$na2/100*360;
$amajor2=$pending2/100*360;
$aminor2=$progres2/100*360;
$acompliant2=$complete2/100*360;

$finalmajor=$amajor2+$acritical2;
$finalminor=$finalmajor+$aminor2;
$finalcompliant=$finalminor+$acompliant2;
$finalcontrol=$finalcompliant+$tacritical2;

//na
$pdf->SetFillColor(153, 153, 153);
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
$pdf->SetFillColor(204, 204, 204);

$pdf->PieSector($xc, $yc, $r, $finalcompliant, $finalcontrol, 'FD', false, 0, 2);

$pdf->SetFont('centurygothic', '',10);


$pdf->SetXY(100,50);

$tbl=<<<EOD

<table width="130" border="0" style="font-family:calibri;border:1px solid #000000;">
<tr nobr="true">
  <td width="5"></td>
    <td width="20" height="5"></td>
    <td width="170" height="5"></td>
  </tr>
 
   
  <tr nobr="true">
    <td width="5"></td>
    <td width="20" height="15"><div bgcolor="#CCCCCC" style="width:15px; height:15px; background:#25578F;margin-top:5px;"></div></td>
    <td width="170" height="15" style="padding:10px;margin-top:5px;">Not Started [$ns2%]</td>
   </tr>
   
    <tr nobr="true">
    <td width="5"></td>
    <td width="20" height="15"><div bgcolor="#999999" style="width:15px; height:15px; background:#CCCCCC;margin-top:5px;"></div></td>
    <td width="170" height="15" style="padding:10px;margin-top:5px;">Not Applicable [$na2%]</td>
   </tr>
   <tr nobr="true">
    <td width="5"></td>
    <td width="20" height="15"><div bgcolor="#D11F29" align="center" style="width:15px; height:15px; background:#D11F29"></div></td>
    <td width="170" height="15">Pending [$pending2%]</td>
   </tr>
   <tr nobr="true">
    <td width="5"></td>
    <td width="20" height="15"><div bgcolor="#F39F2C" align="center" style="width:15px; height:15px; background:#F39F2C"></div></td>
    <td width="170" height="15">In Progress [$progres2%]</td>
   </tr>
   <tr nobr="true">
    <td width="5"></td>
    <td width="20" height="15"><div bgcolor="#499943" align="center" style="width:15px; height:15px; background:#499943"></div></td>
    <td width="170" height="15">Completed [$complete2%]</td>
    </tr>
   </table>
EOD;

$pdf->writeHTML($tbl, true, false, true, false, '');


$pdf->SetFont('centurygothic', '',10);


$pdf->SetXY(15,100);



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
<table id="gallerytab" width="100%" cellspacing="0" cellpadding="7" border="0">
  ';
	
$tbl_footer = '</table>';


$tbl7 = '';

$sq=mysqli_query($con,"select * from addtest1 where testid='$sno'");
while($row=mysqli_fetch_array($sq))
{

$sq1=mysqli_query($con,"select * from subtest where tid='$row[testid]'");
$row1=mysqli_fetch_array($sq1);

$tbl7 .= '

<tr > <td style="color:#669900;font-size:16px">'.$row['testid'].'. '.$row['subject'].'</td></tr>

<tr ><td style="color:#669900;font-size:16px">'.$row1['sid'].'. '.$row1['subtest'].'</td></tr>
<tr ><td></td></tr>
<tr >

<table id="gallerytab" border="1" cellpadding="7">';


$tbl7 .= '<tr>
    <td width="100" style="background-color:#52AE32;color:white">Clause</td>
    <td width="500" style="background-color:#52AE32;color:white">Requirements</td>
  </tr>
  ';
  
$sq2=mysqli_query($con,"select * from subtest1 where tid='$sno'");
while($row2=mysqli_fetch_array($sq2))
{

$sql3=mysqli_query($con,"select * from tbldetail where tid='$row2[tid]' and sid='$row2[sid]' and fid='$row2[fid]' order by id desc limit 1");
$row3=mysqli_fetch_array($sql3);



$tbl7 .= '<tr nobr="true">
    <td width="100">'.$row2['fid'].'</td>
    <td width="500">'.$row2['clause'].'</td>
  </tr>
  ';
  if($row2['status']=="0")
  {
  $tbl7 .= '<tr>
    <td style="background-color:red">Pending</td>
    <td>Not Updated Yet</td>
  </tr>';
  }
  else if($row2['status']=="1")
  {
  $tbl7 .= '<tr>
    <td style="background-color:orange">In Progress</td>
    <td>Detail: '.$row3['detail'].' <br/><br/> Document: '.$row3['img'].' <br/><br/> Link if any: '.$row3['linkk'].' <br/> <br/>Updated on: 2 days before</td>
  </tr>';
  }
 else if($row2['status']=="2")
  {
  $tbl7 .= '<tr>
    <td style="background-color:green">Completed</td>
    <td>Detail: '.$row3['detail'].' <br/><br/> Document: '.$row3['img'].' <br/><br/> Link if any: '.$row3['linkk'].' <br/><br/> Updated on: 2 days before</td>
  </tr>';
  }
   else
  {
  $tbl7 .= '<tr>
    <td style="background-color:gray">Not Started</td>
    <td>Not Updated Yet</td>
  </tr>';
  }
  
  }
$tbl7 .= '
</table>
</tr>
';
  }
$pdf->writeHTML($tbl_header . $tbl7 . $tbl_footer, true, false, false, false, '');
$str = preg_replace('/[^A-Za-z0-9_-]/','', $sno);


 $pdf->Output("faga.pdf",'F');
      ?>
