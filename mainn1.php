<?php

session_start();
							$portallink=$_SESSION['portallink'];
							
							
include 'connection.php';
 $name=$_POST['name'];
 $des=$_POST['des'];
 $img=$_FILES['img']['name'];

$sqlr1=mysqli_query($con,"select * from tbltraining where name='$name' and job='$des' and img='$img' ");
$match=mysqli_num_rows($sqlr1);
if($match<=0)
{
}
else
{
$sqlr=mysqli_query($con,"INSERT INTO tbltraining (name,job,img) VALUES ('$name', '$des', '$img')");
}


move_uploaded_file($_FILES['img']['tmp_name'],"upl1/".$img);

if(!empty($_POST['ques']))
 {
 for ($i=0; $i < count($_POST['ques']);$i++) 
 {
 
  $qid=$_POST['qid'][$i];
  $correct=$_POST['correct'][$i];
  $ques=mysqli_real_escape_string($con,$_POST['ques'][$i]);
  // print_r($ques);echo "<br>";
  $ans=mysqli_real_escape_string($con,$_POST['a'.$i]);
  $cmnt=$_POST['cmnt'.$i];
  $ansc=$_POST['ansc'][$i];
  $status=0;
  
  if($ans==$ansc)
  {
  $status=1;
  }
  else
  {
  $status=0;
  }
  
 $date=date("d-m-Y");
  $cdate=date("Y-m-d");
 
  $sql=mysqli_query($con,"insert into competency3(qid,ques,ans,cmnt,date,name,des,img,correct,status,cdate)values('$qid','$ques','$ans','$cmnt','$date','$name','$des','$img','$correct','$status','$cdate')");
 
 }
 }

 require('tcpdf/tcpdf.php');
class MYPDF extends TCPDF {

        public function Header() {
	
        $image_file = 'images/1.png';
		
        $this->Image($image_file, 15, 5, 25, '', 'png', '', 'T', false, 200, '', false, false, 0, false, false, false);
		
		$this->SetFont('courier', '', 20);
				$this->SetXY(100,2);
		$this->Write(30,'Survey', '', 0, '30', true, 0, false, false, 0);
		
   
        
    }
	    public function Footer()
	    {
        $this->SetY(-10);
        $this->SetFont('courier', 'I', 8);
        $this->Cell(20, 5, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
		$this->Cell(270, 5, date("d/m/Y "), 0, false, 'C', 0, '', 0, false, 'T', 'M');

    }
    
}
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, false, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 003');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

$pdf->AddPage();
$pdf->SetFont('courier', '', 14);
$pdf->SetXY(15,40);
$pdf->Write(0, "Date created: $date", '', '0', '0', true, 'C', false, false, 0);
$pdf->SetXY(15,47);
$pdf->Write(0, "Job Role: $des", '', '0', '0', true, 'C', false, false, 0);
$pdf->SetXY(15,54);
$pdf->Write(0, "Name: $name", '', '0', '0', true, 'C', false, false, 0);
$pdf->SetXY(15,70);


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



</style>
<table id="gallerytab" width="100%" cellspacing="0" cellpadding="3" border="0.2">';
$tbl_footer = '</table>';


$tbl1 = '';

$sf=mysqli_query($con,"select distinct correct from competency3 where date='$date' and name='$name' and des='$des'");
while($ro=mysqli_fetch_array($sf))
{
$tbl1 .= '
  <tr> 
      <td width="120" style="color:red"><div align="center">Section</div></td>
       <td width="500" style="color:red"><div align="center">'.$ro['correct'].'</div></td>
   </tr>
 ';
 $sql1=mysqli_query($con,"select * from competency3 where correct='$ro[correct]' and date='$date' and name='$name' and des='$des'");
 while($row=mysqli_fetch_array($sql1))
 {
										
$tbl1 .= '
  <tr> 
      <td width="120" style="color:blue">Question</td>
       <td  width="500" style="color:blue">'.$row['ques'].'</td>
   </tr>';
   print_r("select * from competency where ques='$row[ques]'");echo"<br>";
    $sql1s=mysqli_query($con,"select * from competency where ques='$row[ques]'");
										while($rows=mysqli_fetch_array($sql1s))
										{
$tbl1 .= '
 <tr> 
        <td width="120" style="color:#666666; text-align:center">a</td>
       <td  width="500" style="color:#666666">'.$rows['ansa'].'</td>
   </tr>
   <tr> 
        <td width="120" style="color:#666666;text-align:center">b</td>
       <td  width="500" style="color:#666666;">'.$rows['ansb'].'</td>
   </tr>
   <tr> 
        <td width="120" style="color:#666666;text-align:center">c</td>
       <td  width="500" style="color:#666666">'.$rows['ansc'].'</td>
   </tr>';
   }
   
    $tbl1 .= '<tr> 
	 <td width="120">Answer</td>
       <td  width="500">'.$row['ans'].'</td>
   </tr>';
   
   if($row['cmnt']!=="")
	{
	$tbl1 .= '
	<tr> 
	 <td width="120" style="color:green" >Comment</td>
       <td  width="500" style="color:green">'.$row['cmnt'].'</td>
   </tr>';
	}
 }
 }
 
$pdf->writeHTML($tbl_header . $tbl1 . $tbl_footer, true, false, false, false, '');

$pdf->Output("upl1/".$date."-".$name.".pdf","F");

 
 						  
	require_once('PHPMailer/class.phpmailer.php');

	$mail = new PHPMailer();
	$body = '<HTML><BODY><CENTER>

<table width="558" border="0" align="center" style="border:1px solid #016ABC;border-radius: 10px;box-shadow: 0 0 2px 0px  #016ABC;outline: none;">
  <tr>
    <td height="87" colspan="3"><img src="upl1/'.$img.'" width="90" height="75"></td>
    
    </tr>
  <tr>
    <td height="23" colspan="3" style="background-color: #84C1F1;border-bottom:1px solid #016ABC;font-family:Candara">&nbsp;</td>
  </tr>
  <tr>
    <td height="23" colspan="3" >&nbsp;</td>
  </tr>
  <tr>
    <td width="107" height="89">&nbsp;</td>
    <td width="320"><table width="315" border="0"  style="border:1px solid #016ABC;border-radius: 10px;box-shadow: 0 0 2px 0px  #016ABC;outline: none;">
      <tr>
        <td height="24" colspan="2" style="border-bottom:1px solid #016ABC;font-family:Candara" ><div align="center">SURVEY(Food Safety Culture Questionnaire)</div></td>
      </tr>
<tr>
        <td width="157" height="44" style="font-family:Candara;border-right:1px solid #016ABC;"><div align="center">Date :</div></td>
        <td width="146" style="font-family:Candara;color:#666666"><div align="center">'.$date.'</div></td>
      </tr>
      <tr>
        <td width="157" height="44" style="font-family:Candara;border-right:1px solid #016ABC;"><div align="center">Name :</div></td>
        <td width="146" style="font-family:Candara;color:#666666"><div align="center">'.$name.'</div></td>
      </tr>
      <tr>
        <td width="157" height="44" style="font-family:Candara;border-right:1px solid #016ABC;"><div align="center">Job Role :</div></td>
        <td width="146" style="font-family:Candara;color:#666666"><div align="center">'.$des.'</div></td>
      </tr>
     
    </table></td>
    <td width="109">&nbsp;</td>
  </tr>
  <tr>
    <td height="23" colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td height="23" colspan="3" style="background-color: #84C1F1;border-bottom:1px solid #016ABC;font-family:Candara">&nbsp;</td>
  </tr>
</table>
</CENTER></BODY>
</HTML>'; 


$mail->SetFrom("techsupport@rtnts.co.uk", "RTNTS");
	    $mail->AddReplyTo("techsupport@rtnts.co.uk", "RTNTS");
	
        $sql=mysqli_query($con,"select * from tblemail");
		while($row=mysqli_fetch_array($sql)) 
		{
		$email=$row['email'];
		$nme=$row['name'];
		$mail->AddAddress("$email",$nme);
		}
		$mail->AddBcc("email@rtnts.co.uk","Admin");
		
		$mail->Subject = "SURVEY(Food Safety Culture Questionnaire)";
	    $mail->MsgHTML($body);
		
	 // $mail->AddAttachment("upl1/".$date."-".$name.".pdf");
	    //$mail->AddAttachment("upl/".$date."-".$gh['concession']."-".$gh['username']."-".$depty.".pdf");
	    if(!$mail->Send())
	    {
	    echo "Mailer Error: " . $mail->ErrorInfo;
	    } 
	    else 
    	{
	    }	
		
		
 ?>
 
 <script language="javascript">
  alert("Thanks!");
window.open('index.php','_self');
 </script>
