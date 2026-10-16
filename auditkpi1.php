 <?php
include 'connection.php';
ini_set('max_execution_time', 600);
ini_set('memory_limit','-1');

 $month=date("m");
$year=date("Y");

if($month=="")
{
$month=date("m");
}

if($year=="")
{
$year=date("Y");
}

         $date1=$year."-".$month."-01";
         $date2=date("Y-m-t", strtotime($date1));
		 $d1=date("d-m-Y",strtotime($date1));
		 $d2=date("d-m-Y",strtotime($date2));
		 $mnth=date("F",strtotime($date1));

require('tcpdf/tcpdf.php');

$total=mysqli_query($con,"SELECT t1.*,t2.id,t2.position,t2.concession FROM  comment t1, audit t2 WHERE  t2.date BETWEEN '$date1' and '$date2' AND (t1.userans!='Not applicable' AND t1.userans!='Not Applicable' AND t1.userans!='') and t2.position='rtntsstaff' and t1.auditsno=t2.id and t2.status!=''");
$total1=mysqli_num_rows($total);

$compliant=mysqli_query($con,"SELECT t1.*,t2.id,t2.position,t2.concession FROM  comment t1, audit t2 WHERE  t2.date BETWEEN '$date1' and '$date2' AND t1.userans='Compliant' and t2.position='rtntsstaff' and t1.auditsno=t2.id and t2.status!=''");
$compliant1=mysqli_num_rows($compliant);
$compliant2=$compliant1/$total1*100;
$compliant22=round($compliant1/$total1*100);

$major=mysqli_query($con,"SELECT t1.*,t2.id,t2.position,t2.concession FROM  comment t1, audit t2 WHERE  t2.date BETWEEN '$date1' and '$date2' AND t1.userans='Major' and t2.position='rtntsstaff' and t1.auditsno=t2.id and t2.status!=''");
$major1=mysqli_num_rows($major);
$major22=round($major1/$total1*100);
$major2=$major1/$total1*100;

$minor=mysqli_query($con,"SELECT t1.*,t2.id,t2.position,t2.concession FROM  comment t1, audit t2 WHERE  t2.date BETWEEN '$date1' and '$date2' AND t1.userans='Minor' and t2.position='rtntsstaff' and t1.auditsno=t2.id and t2.status!=''");
$minor1=mysqli_num_rows($minor);
$minor22=round($minor1/$total1*100);
$minor2=$minor1/$total1*100;

$critical=mysqli_query($con,"SELECT t1.*,t2.id,t2.position,t2.concession FROM  comment t1, audit t2 WHERE  t2.date BETWEEN '$date1' and '$date2' AND t1.userans='Critical' and t2.position='rtntsstaff' and t1.auditsno=t2.id and t2.status!=''");
$critical1=mysqli_num_rows($critical);
$critical22=round($critical1/$total1*100);
$critical2=$critical1/$total1*100;

$acritical=mysqli_query($con,"SELECT t1.*,t2.id,t2.position,t2.concession FROM  comment t1, audit t2 WHERE  t2.date BETWEEN '$date1' and '$date2' AND t1.userans='Critical Closure Point' and t2.position='rtntsstaff' and t1.auditsno=t2.id and t2.status!=''");
$acritical1=mysqli_num_rows($acritical);
$acritical22=round($acritical1/$total1*100);
$aacritical2=$acritical1/$total1*100;


$totalhygiene=mysqli_query($con,"SELECT  t1.*,t2.id,t2.position,t2.concession FROM  comment t1, audit t2 WHERE   t2.date BETWEEN '$date1' and '$date2' AND t1.testname='Operational Pre-Requisites' AND  t1.userans!='Not applicable' and t2.position='rtntsstaff' and t1.auditsno=t2.id and t2.status!=''");
$totalhygiene1=mysqli_num_rows($totalhygiene);

$hygienecompliant=mysqli_query($con,"SELECT  t1.*,t2.id,t2.position,t2.concession FROM  comment t1, audit t2 WHERE   t2.date BETWEEN '$date1' and '$date2' AND t1.userans='Compliant' AND t1.testname='Operational Pre-Requisites' and t2.position='rtntsstaff' and t1.auditsno=t2.id and t2.status!='' ");
$hygienecompliant1=mysqli_num_rows($hygienecompliant);

$hygienemajor=mysqli_query($con,"SELECT t1.*,t2.id,t2.position,t2.concession FROM  comment t1, audit t2 WHERE  t2.date BETWEEN '$date1' and '$date2' AND t1.userans='Major' AND t1.testname='Operational Pre-Requisites' and t2.position='rtntsstaff' and t1.auditsno=t2.id and t2.status!='' ");
$hygienemajor1=mysqli_num_rows($hygienemajor);

$hygieneminor=mysqli_query($con,"SELECT  t1.*,t2.id,t2.position,t2.concession FROM  comment t1, audit t2 WHERE   t2.date BETWEEN '$date1' and '$date2' AND t1.userans='Minor' AND t1.testname='Operational Pre-Requisites' and t2.position='rtntsstaff' and t1.auditsno=t2.id and t2.status!=''");
$hygieneminor1=mysqli_num_rows($hygieneminor);

$hygienecritical=mysqli_query($con,"SELECT  t1.*,t2.id,t2.position,t2.concession FROM  comment t1, audit t2 WHERE   t2.date BETWEEN '$date1' and '$date2' AND t1.userans='Critical' AND t1.testname='Operational Pre-Requisites' and t2.position='rtntsstaff' and t1.auditsno=t2.id and t2.status!='' ");
$hygienecritical1=mysqli_num_rows($hygienecritical);


$hygienecontrol=mysqli_query($con,"SELECT  t1.*,t2.id,t2.position,t2.concession FROM  comment t1, audit t2 WHERE   t2.date BETWEEN '$date1' and '$date2' AND t1.userans='Critical Closure Point' AND t1.testname='Operational Pre-Requisites' and t2.position='rtntsstaff' and t1.auditsno=t2.id and t2.status!='' ");
$hygienecontrol=mysqli_num_rows($hygienecontrol);

$hygienecontrol1=mysqli_query($con,"SELECT  t1.*,t2.id,t2.position,t2.concession FROM  comment t1, audit t2 WHERE   t2.date BETWEEN '$date1' and '$date2' AND t1.userans='Critical Closure Point' AND t1.testname='Training and Confidence in Management' and t2.position='rtntsstaff' and t1.auditsno=t2.id and t2.status!=''");
$hygienecontrol1=mysqli_num_rows($hygienecontrol1);


$hygienecontrol2=mysqli_query($con,"SELECT  t1.*,t2.id,t2.position,t2.concession FROM  comment t1, audit t2 WHERE   t2.date BETWEEN '$date1' and '$date2' AND t1.userans='Critical Closure Point' AND t1.testname='Food Safety' and t2.position='rtntsstaff' and t1.auditsno=t2.id and t2.status!=''");
$hygienecontrol2=mysqli_num_rows($hygienecontrol2);


$hygienecontrol3=mysqli_query($con,"SELECT t1.*,t2.id,t2.position,t2.concession FROM  comment t1, audit t2 WHERE  t2.date BETWEEN '$date1' and '$date2' AND t1.userans='Critical Closure Point' AND t1.testname='Product Handling' and t2.position='rtntsstaff' and t1.auditsno=t2.id and t2.status!='' ");
$hygienecontrol3=mysqli_num_rows($hygienecontrol3);

$hygienecontrol4=mysqli_query($con,"SELECT  t1.*,t2.id,t2.position,t2.concession FROM  comment t1, audit t2 WHERE t2.date BETWEEN '$date1' and '$date2' AND t1.userans='Critical Closure Point' AND t1.testname='Fire, Health and Safety' and t2.position='rtntsstaff' and t1.auditsno=t2.id and t2.status!=''");
$hygienecontrol4=mysqli_num_rows($hygienecontrol4);

$totaladmin=mysqli_query($con,"SELECT t1.*,t2.id,t2.position,t2.concession FROM  comment t1, audit t2 WHERE  t2.date BETWEEN '$date1' and '$date2' AND t1.testname='Training and Confidence in Management' AND t1.userans!='Not applicable' and t2.position='rtntsstaff' and t1.auditsno=t2.id and t2.status!=''");
$totaladmin1=mysqli_num_rows($totaladmin);

$admincompliant=mysqli_query($con,"SELECT  t1.*,t2.id,t2.position,t2.concession FROM  comment t1, audit t2 WHERE  t2.date BETWEEN '$date1' and '$date2' AND t1.userans='Compliant' AND t1.testname='Training and Confidence in Management' and t2.position='rtntsstaff' and t1.auditsno=t2.id and t2.status!=''");
$admincompliant1=mysqli_num_rows($admincompliant);

$adminmajor=mysqli_query($con,"SELECT t1.*,t2.id,t2.position,t2.concession FROM  comment t1, audit t2 WHERE t2.date BETWEEN '$date1' and '$date2' AND t1.userans='Major' AND t1.testname='Training and Confidence in Management' and t2.position='rtntsstaff' and t1.auditsno=t2.id and t2.status!=''");
$adminmajor1=mysqli_num_rows($adminmajor);


$adminminor=mysqli_query($con,"SELECT  t1.*,t2.id,t2.position,t2.concession FROM  comment t1, audit t2 WHERE t2.date BETWEEN '$date1' and '$date2' AND t1.userans='Minor' AND t1.testname='Training and Confidence in Management' and t2.position='rtntsstaff' and t1.auditsno=t2.id and t2.status!=''");
$adminminor1=mysqli_num_rows($adminminor);

$admincritical=mysqli_query($con,"SELECT t1.*,t2.id,t2.position,t2.concession FROM  comment t1, audit t2 WHERE  t2.date BETWEEN '$date1' and '$date2' AND t1.userans='Critical' AND t1.testname='Training and Confidence in Management' and t2.position='rtntsstaff' and t1.auditsno=t2.id and t2.status!='' ");
$admincritical1=mysqli_num_rows($admincritical);

$totalfood=mysqli_query($con,"SELECT t1.*,t2.id,t2.position,t2.concession FROM  comment t1, audit t2  WHERE t2.date BETWEEN '$date1' and '$date2' AND t1.testname='Food Safety' AND t1.userans!='Not applicable' and t2.position='rtntsstaff' and t1.auditsno=t2.id and t2.status!=''");
$totalfood1=mysqli_num_rows($totalfood);

$foodcompliant=mysqli_query($con,"SELECT t1.*,t2.id,t2.position,t2.concession FROM  comment t1, audit t2  WHERE  t2.date BETWEEN '$date1' and '$date2' AND t1.userans='Compliant' AND t1.testname='Food Safety' and t2.position='rtntsstaff' and t1.auditsno=t2.id and t2.status!=''");
$foodcompliant1=mysqli_num_rows($foodcompliant);

$foodmajor=mysqli_query($con,"SELECT t1.*,t2.id,t2.position,t2.concession FROM  comment t1, audit t2  WHERE  t2.date BETWEEN '$date1' and '$date2' AND t1.userans='Major' AND t1.testname='Food Safety' and t2.position='rtntsstaff' and t1.auditsno=t2.id and t2.status!=''");
$foodmajor1=mysqli_num_rows($foodmajor);

$foodminor=mysqli_query($con,"SELECT t1.*,t2.id,t2.position,t2.concession FROM  comment t1, audit t2  WHERE  t2.date BETWEEN '$date1' and '$date2' AND t1.userans='Minor' AND t1.testname='Food Safety' and t2.position='rtntsstaff' and t1.auditsno=t2.id and t2.status!=''");
$foodminor1=mysqli_num_rows($foodminor);

$foodcritical=mysqli_query($con,"SELECT t1.*,t2.id,t2.position,t2.concession FROM  comment t1, audit t2  WHERE  t2.date BETWEEN '$date1' and '$date2' AND t1.userans='Critical' AND t1. testname='Food Safety' and t2.position='rtntsstaff' and t1.auditsno=t2.id and t2.status!=''");
$foodcritical1=mysqli_num_rows($foodcritical);





$totalope=mysqli_query($con,"SELECT t1.*,t2.id,t2.position,t2.concession FROM  comment t1, audit t2  WHERE  t2.date BETWEEN '$date1' and '$date2' AND t1.testname='Product Handling' AND t1.userans!='Not applicable' and t2.position='rtntsstaff' and t1.auditsno=t2.id and t2.status!=''");
$totalope1=mysqli_num_rows($totalope);

$opecompliant=mysqli_query($con,"SELECT t1.*,t2.id,t2.position,t2.concession FROM  comment t1, audit t2  WHERE t2.date BETWEEN '$date1' and '$date2' AND t1.userans='Compliant' AND t1.testname='Product Handling' and t2.position='rtntsstaff' and t1.auditsno=t2.id and t2.status!=''");
$opecompliant1=mysqli_num_rows($opecompliant);

$opemajor=mysqli_query($con,"SELECT t1.*,t2.id,t2.position,t2.concession FROM  comment t1, audit t2  WHERE t2.date BETWEEN '$date1' and '$date2' AND t1.userans='Major' AND t1.testname='Product Handling' and t2.position='rtntsstaff' and t1.auditsno=t2.id and t2.status!=''");
$opemajor1=mysqli_num_rows($opemajor);

$opeminor=mysqli_query($con,"SELECT t1.*,t2.id,t2.position,t2.concession FROM  comment t1, audit t2  WHERE  t2.date BETWEEN '$date1' and '$date2' AND t1.userans='Minor' AND t1.testname='Product Handling' and t2.position='rtntsstaff' and t1.auditsno=t2.id and t2.status!=''");
$opeminor1=mysqli_num_rows($opeminor);

$opecritical=mysqli_query($con,"SELECT t1.*,t2.id,t2.position,t2.concession FROM  comment t1, audit t2  WHERE  t2.date BETWEEN '$date1' and '$date2' AND t1.userans='Critical' 
AND t1.testname='Product Handling' and t2.position='rtntsstaff' and t1.auditsno=t2.id and t2.status!=''");
$opecritical1=mysqli_num_rows($opecritical);

$totalhs=mysqli_query($con,"SELECT t1.*,t2.id,t2.position,t2.concession FROM  comment t1, audit t2  WHERE  t2.date BETWEEN '$date1' and '$date2' AND t1.testname='Fire, Health and Safety'  AND t1.userans!='Not applicable' and t2.position='rtntsstaff' and t1.auditsno=t2.id and t2.status!=''");
$totalhs1=mysqli_num_rows($totalhs);

$hscompliant=mysqli_query($con,"SELECT t1.*,t2.id,t2.position,t2.concession FROM  comment t1, audit t2  WHERE  t2.date BETWEEN '$date1' and '$date2' AND t1.userans='Compliant' AND t1.testname='Fire, Health and Safety' and t2.position='rtntsstaff' and t1.auditsno=t2.id and t2.status!=''");
$hscompliant1=mysqli_num_rows($hscompliant);

$hsmajor=mysqli_query($con,"SELECT t1.*,t2.id,t2.position,t2.concession FROM  comment t1, audit t2  WHERE  t2.date BETWEEN '$date1' and '$date2' AND t1.userans='Major' AND t1.testname='Fire, Health and Safety' and t2.position='rtntsstaff' and t1.auditsno=t2.id and t2.status!=''");
$hsmajor1=mysqli_num_rows($hsmajor);

$hsminor=mysqli_query($con,"SELECT t1.*,t2.id,t2.position,t2.concession FROM  comment t1, audit t2  WHERE  t2.date BETWEEN '$date1' and '$date2' AND t1.userans='Minor' AND t1.testname='Fire, Health and Safety' and t2.position='rtntsstaff' and t1.auditsno=t2.id and t2.status!='' ");
$hsminor1=mysqli_num_rows($hsminor);

$hscritical=mysqli_query($con,"SELECT t1.*,t2.id,t2.position,t2.concession FROM  comment t1, audit t2  WHERE  t2.date BETWEEN '$date1' and '$date2' AND t1.userans='Critical' AND t1.testname='Fire, Health and Safety' and t2.position='rtntsstaff' and t1.auditsno=t2.id and t2.status!='' ");
$hscritical1=mysqli_num_rows($hscritical);

$upit = mysqli_query($con,"SELECT t1.*,t2.id,t2.position,t2.concession FROM  comment t1, audit t2  WHERE  t2.date BETWEEN '$date1' and '$date2' AND (t1.userans!='Not applicable') and t2.position='rtntsstaff' and t1.auditsno=t2.id and t2.status!=''");
$h11=mysqli_num_rows($upit);

$upit1 = mysqli_query($con,"SELECT distinct testname from comment WHERE  date BETWEEN '$date1' and '$date2'");
$result = mysqli_fetch_array($upit1);

$comp="Non-Compliant";

  $totalfood11=$hygienecontrol2+$foodcritical1+$foodmajor1+$foodminor1+$foodcompliant1;
  $totaladmin11=$hygienecontrol1+$admincritical1+$adminmajor1+$adminminor1+$admincompliant1;
  $totalhygiene11=$hygienecontrol+$hygienecritical1+$hygienemajor1+$hygieneminor1+$hygienecompliant1;
  $totalope11=$hygienecontrol3+$opecritical1+$opemajor1+$opeminor1+$opecompliant1;



ini_set('max_execution_time', 300);
// create new PDF document
class MYPDF extends TCPDF {

    public function Header() {
       $image_file = 'images/1.png';
        $this->Image($image_file, 10, 5, 30, '', 'png', '', 'T', false, 200, '', false, false, 0, false, false, false);
     
	 
	
    }

    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('centurygothic', 'I', 8);
        $this->Cell(25, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
		      
    }
}


$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);

$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->SetMargins(10, 30, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);


$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);


$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

$pdf->SetFont('centurygothic', 'B', 12);


$pdf->AddPage('L');
$pdf->SetXY(125,8);
$pdf->Write(0, "GMP AUDIT KPI", '', '0', '0', true, 'C', false, false, 0);
$pdf->SetXY(120,19);
$pdf->Write(0, "From: ". $d1." To: ".$d2 , '', '0', '0', true, 'C', false, false, 0);


$pdf->SetFont('centurygothic', '',10);

$pdf->SetXY(10,30);
$html =
'<div bgcolor="#63C315" style="width:950px; height:20px;font-size:16px;color:#000000">Non-Conformance Summary</div>';

$pdf->writeHTML($html, true, false, true, false, '');





$pdf->Write(0, "  ", '', '0', '0', true, 'C', false, false, 0);
$xc =220;
$yc = 68;
$r = 20;

$n=0;
if($critical2!=0)
{
$n=$n+1;
}

if($aacritical2!=0)
{
$n=$n+1;
}

if($major2!=0)
{
$n=$n+1;
}

if($minor2!=0)
{
$n=$n+1;
}

if($compliant2!=0)
{
$n=$n+1;
}

$totalpercent=$aacritical2+$critical2+$major2+$minor2+$compliant2;
if($totalpercent<100)
{

$t1=100-$totalpercent;
$t2=$t1/$n;
}
if($critical2!=0)
{
$critical2=$critical2+$t2;
}
if($aacritical2!=0)
{
$aacritical2=$aacritical2+$t2;
}

if($major2!=0)
{
$major2=$major2+$t2;
}
if($minor2!=0)
{
$minor2=$minor2+$t2;
}

if($compliant2!=0)
{
$compliant2=$compliant2+$t2;
}

$tacritical2=$aacritical2/100*360;
$acritical2=$critical2/100*360;
$amajor2=$major2/100*360;
$aminor2=$minor2/100*360;
$acompliant2=$compliant2/100*360;

$finalmajor=$amajor2+$acritical2;
$finalminor=$finalmajor+$aminor2;
$finalcompliant=$finalminor+$acompliant2;
$finalcontrol=$finalcompliant+$tacritical2;


$pdf->SetFillColor(37, 87, 143);
$pdf->PieSector($xc, $yc, $r, 0, $acritical2, 'FD', false, 0, 2);

$pdf->SetFillColor(209, 31, 41);
$pdf->PieSector($xc, $yc, $r, $acritical2, $finalmajor, 'FD', false, 0, 2);

$pdf->SetFillColor(243, 159, 44);
$pdf->PieSector($xc, $yc, $r, $finalmajor, $finalminor, 'FD', false, 0, 2);

$pdf->SetFillColor(73, 153, 67);
$pdf->PieSector($xc, $yc, $r, $finalminor, $finalcompliant, 'FD', false, 0, 2);


$pdf->SetFillColor(185, 122, 87);
$pdf->PieSector($xc, $yc, $r, $finalcompliant, $finalcontrol, 'FD', false, 0, 2);

$pdf->SetXY(250,40);

$tbl=<<<EOD

<table width="90" border="0" style="font-family:calibri;border:1px solid #000000;">
<tr nobr="true">
  <td width="5"></td>
    <td width="20" height="5"></td>
    <td width="80" height="5"></td>
  </tr>
  <tr nobr="true">
    <td width="5"></td>
    <td width="20" height="15"><div bgcolor="#B97A57" style="width:15px; height:15px; background:#B97A57;margin-top:5px;"></div></td>
    <td width="80" height="15" style="padding:10px;margin-top:5px;">Critical Closure Point [$acritical22%]</td>
   </tr>
   
  <tr nobr="true">
    <td width="5"></td>
    <td width="20" height="15"><div bgcolor="#25578F" style="width:15px; height:15px; background:#25578F;margin-top:5px;"></div></td>
    <td width="80" height="15" style="padding:10px;margin-top:5px;">Critical [$critical22%]</td>
   </tr>
   <tr nobr="true">
    <td width="5"></td>
    <td width="20" height="15"><div bgcolor="#D11F29" align="center" style="width:15px; height:15px; background:#D11F29"></div></td>
    <td width="80" height="15">Major [$major22%]</td>
   </tr>
   <tr nobr="true">
    <td width="5"></td>
    <td width="20" height="15"><div bgcolor="#F39F2C" align="center" style="width:15px; height:15px; background:#F39F2C"></div></td>
    <td width="80" height="15">Minor [$minor22%]</td>
   </tr>
   <tr nobr="true">
    <td width="5"></td>
    <td width="20" height="15"><div bgcolor="#499943" align="center" style="width:15px; height:15px; background:#499943"></div></td>
    <td width="80" height="15">Compliant [$compliant22%]</td>
    </tr>
   </table>
EOD;

$pdf->writeHTML($tbl, true, false, true, false, '');

$pdf->SetXY(10,40);

$tbl = '';

$tbl .= '
<table width="517" border="1" style="color:#000000">
    <tr nobr="true">
     <td width="180" height="30" style="margin-left:10px;"> Section </td>
     <td width="90" align="center"> Critical </td>
     <td width="90" align="center"> Major </td>
     <td width="90" align="center"> Minor </td>
     <td width="90" align="center"> Compliant </td>
 </tr>
  ';

 
  $query=mysqli_query($con,"select distinct sid from tblgmpaudit2");
  while($query1=mysqli_fetch_array($query))
  {
  
  $query2=mysqli_query($con,"select * from tblauditsection1 where id='$query1[sid]'");
  $query3=mysqli_fetch_array($query2);
 
 
 
  $query=mysqli_query($con,"SELECT pz.id, pz.sid, COUNT(f.ans) AS major FROM tblgmpaudit2 pz INNER JOIN tblgmpaudit3 f ON pz.id = f.sno and f.ans='Major' where pz.sid='$ghj1[sid]'     GROUP BY pz.sid");
   $query1=mysqli_fetch_array($query);
   
    
$tbl .= '
 <tr nobr="true">
    <td height="32"> '.$query3['name'].'></td>
	<td align="center">'.$sn.'</td>
   <td align="center"> '.$query1['major'].'</td>
    <td align="center">6</td>
    <td align="center">0</td>
	<td align="center">0</td>
    
  </tr>';
 
  }
  
$tbl .= '
</table>';

$pdf->writeHTML($tbl, true, false, true, false, '');

$pdf->SetXY(10,100);





$tbl_header = '<style>
table {
   
   border-spacing: 0;
}
tr {
   padding: 3px 0;
   text-align: center;
}

th {
      background-color:#F0F0F0;
 border: 1px solid #000000;
   color: #000000;
   text-align: center;
}
td {
  
    border: 1px solid #000000;
   color: #000000;
   text-align: center;
}
</style>
<table id="gallerytab" width="1200" cellspacing="0" cellpadding="4" border="0">';
	
$tbl_footer = '</table>';
$tbl7 = '';
$tbl7 .= '
<thead>
 <tr>
			  <th width="50">Sno</th> 
              <th width="100">Date</th> 
			  <th width="125">Auditor</th>
              <th width="110">Auditee</th>
			    <th width="70">Critical</th>
              <th width="70">Minor</th>
              <th width="70">Major</th>
              <th width="70">Compliant</th>
		
            </tr> 
			</thead>';
  
  
 
$sql0=mysqli_query($con,"select * from tblgmpaudit2 where  (date BETWEEN '$date1' and '$date2') ");
$i=0;
  while($rows=mysqli_fetch_array($sql0))
{
  $i++;
  
  $auditor=mysqli_query($con,"SELECT * from tblauditor where id='$rows[auditor]' ");
  $auditor1=mysqli_fetch_array($auditor);
  
    $auditee=mysqli_query($con,"SELECT * from tblauditee where id='$rows[auditee]'");
  $auditee1=mysqli_fetch_array($auditee);

  
  $c1=mysqli_query($con,"SELECT COUNT(*) AS compliant from tblgmpaudit3 where ans='Compliant' and sno='$rows[id]'");
  $c2=mysqli_fetch_array($c1);
  
   $ma1=mysqli_query($con,"SELECT COUNT(*) AS major from tblgmpaudit3 where ans='Major' and sno='$rows[id]'");
  $ma2=mysqli_fetch_array($ma1);
  
  
   $mi1=mysqli_query($con,"SELECT COUNT(*) AS minor from tblgmpaudit3 where ans='Minor' and sno='$rows[id]'");
  $mi2=mysqli_fetch_array($mi1);
  
  
   $ca1=mysqli_query($con,"SELECT COUNT(*) AS critical from tblgmpaudit3 where ans='Critical' and sno='$rows[id]'");
  $ca2=mysqli_fetch_array($ca1);
  
  $color="black";
  
 
  
 $sum = $c2['compliant']+$ma2['major']+$mi2['minor']+$na2['na'];
     $sum1 = $c2['compliant'];
	 
$totalsum=round( $sum1/$sum*100,0);
 
  $auditdate=date("d-m-Y",strtotime($rows['date']));
  
  $result="";
  
 $tbl7 .= '  <tbody>
  <tr nobr="true">
              <td width="50" style="color:'.$color.'">'.$rows['id'].'</td>
              <td width="100" style="color:'.$color.'">'.$auditdate.'</td>
			  <td width="125" style="color:'.$color.'">'.$auditor1['name'].'</td>
              <td width="110" style="color:'.$color.'">'.$auditee1['name'].'</td>
			    <td width="70" style="color:'.$color.'">'.$ca2['critical'].'</td>
			   <td width="70" style="color:'.$color.'">'.$ma2['major'].'</td>
              <td width="70" style="color:'.$color.'">'.$mi2['minor'].'</td>
              <td width="70" style="color:'.$color.'">'.$c2['compliant'].'</td>
			  
  </tr>
  </tbody>
  ';


  }
$pdf->writeHTML($tbl_header . $tbl7 . $tbl_footer, true, false, false, false, '');




$tbl8 = '';
$tbl8 .= '
<thead>
 <tr>
		
			  <th width="990">TOP NON-CONFORMANCES</th> 
            </tr> 
			</thead>';
  
 
  $sql3=mysqli_query($con,"select t1.sno,t1.ques, count(t1.ques) AS total from tblgmpaudit3 t1,tblgmpaudit2 t2 where (t2.date BETWEEN '$date1' and '$date2') and (t1.ans!='Compliant' and t1.ans!='Not Applicable' and ans!='') and t1.sno=t2.id  group by t1.ques DESC LIMIT 5");
$j=0;
while($rows1=mysqli_fetch_array($sql3))
{
  $j++;
 
 

  $tbl8 .= ' 
  <tr nobr="true">
              <td width="150" style="text-align: left;color:blue">Ques '.$j.'</td>
              <td width="840" style="text-align: left;color:blue">'.$rows1['ques'].'</td>
  </tr>';
  
  $sql4=mysqli_query($con,"select t1.ans,count(*) as t3 from tblgmpaudit3 t1, tblgmpaudit2 t2 where t1.ques='$rows1[ques]' and (t1.ans!='Compliant' and t1.ans!='Not Applicable' and t1.ans!='') and (t2.date BETWEEN '$date1' and '$date2')  and t1.sno=t2.id  group by ans ORDER BY t3 DESC ");
while($rows4=mysqli_fetch_array($sql4))
{

  $tbl8 .= '
   <tr nobr="true">
   <td width="150" style="text-align: left;color:red">Ans</td>
   <td width="840" style="text-align: left;color:red">'.$rows4['ans'].'-('.$rows4['t3'].') </td>
  </tr>';
  
  $sq7=mysqli_query($con,"select t1.cmnt  from tblgmpaudit3 t1, tblgmpaudit2 t2 where t1.ques='$rows1[ques]' and (t1.ans!='Compliant' and t1.ans!='Not Applicable' and t1.ans!='') and (t2.date BETWEEN '$date1' and '$date2') and t1.ans='$rows4[ans]'  and t1.sno=t2.id");
while($rows7=mysqli_fetch_array($sq7))
{
$cmt=mysqli_real_escape_string($con,$rows7['cmnt']);

 $tbl8 .= '
  <tr nobr="true">
              <td width="150" style="text-align: left;color:black"></td>
              <td width="840" style="text-align: left;color:black">'.$cmt.'</td>
  </tr>';
 
 }
 }}
 

$pdf->writeHTML(utf8_encode($tbl_header . $tbl8 . $tbl_footer), true, false, true, false, '');

$pdf->Output("MyPDF/".$d1."-".$d2."-GMP AUDIT KPI.pdf","F");


?>

	