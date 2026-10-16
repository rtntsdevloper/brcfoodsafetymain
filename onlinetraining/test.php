
    <?php
    session_start();
    $staffid="57";
	
	$curdate=date('Y-m-d');
	
	$d1=date('dmy');
    include '../connection.php';
	
	$sqll=mysqli_query($con,"select * from tblstaff where id='$staffid'");
	$rows=mysqli_fetch_array($sqll);

	$firstname = $rows['fname'];
    $lastname = $rows['lname'];
	$username1 = $rows['uname'];
	$email = $rows['email'];
	 
    $tid="2";
	$name=ucfirst($rows['fname'])." ".ucfirst($rows['lname']);
	 
	$image=$rows['img'];
	 
	$sq1=mysqli_query($con,"select * from tblonlinetraining where id='$tid'");
	$r2=mysqli_fetch_array($sq1);
	$bar=$r2['tag'];
	$testname=$r2['name'];
	$scoree=$r2['score'];
	$passscore=$r2['pass'];
	
	
	$sq=mysqli_query($con,"select * from tblresult");
	$barcode=$bar.$d1.$staffid.$tid;
	
	$sc=mysqli_query($con,"select * from user_anss where correctans=yourans and testid='$tid' and uid='$staffid'");
	$score=mysqli_num_rows($sc);
	
	$wrong=$scoree-$score;
	
      if($score >= $passscore)
      {
          $reslt = "Pass";
		    require('../tcpdf/tcpdf.php');
       $pdf = new TCPDF();
        $pdf->AddPage();	
          $pdf->SetAutoPageBreak(TRUE, 0);	
        date_default_timezone_set('Europe/London');
        $date = date("Y-m-d");
$style1 = array(
    'border' => 0,
    'vpadding' => 'auto',
    'hpadding' => 'auto',
    'fgcolor' => array(0,0,0),
    'bgcolor' => false, //array(255,255,255)
    'module_width' => 1, // width of a single module in points
    'module_height' => 1 // height of a single module in points
);

  //$cncat=$rows['batchcode'];
  
  $pdf->Image("../HY.jpg",0,0,1242,1700);	

    $pdf->SetFont('ebrima', '', 22);
$pdf->SetXY(10,136);
$pdf->Write(0,$name, '10', 0, '20', true, 0, false, false, 0);

$pdf->Image("../student/".$image,150,110,30);

$pdf->SetFont('ebrima', '',16);
$pdf->SetXY(32,173.6);
$pdf->Write(0, date("d-F-Y", strtotime($curdate)), '10', 0, '20', true, 0, false, false, 0);
$pdf->SetFont('ebrima', '', 13);
$pdf->SetFont('ebrima', '', 13);
$pdf->SetXY(57,221.3);
$pdf->Write(0,date("d-F-Y", strtotime($curdate)), '10', 0, '20', true, 0, false, false, 0);
$pdf->SetXY(51,232);
$pdf->Write(0, $barcode, '10', 0, '20', true, 0, false, false, 0);

$pdf->SetFont('ebrima', '', 13);
$pdf->SetXY(118,243);
$newEndingDate = date("d-F-Y", strtotime(date("d-F-Y", strtotime($curdate)) . " + 2 year"));
$pdf->Write(0, $newEndingDate, '6', 0, '20', true, 0, false, false, 0);
$pdf->SetTextColor(14,95,150);
$pdf->SetFont('ebrima', '', 20);
$pdf->SetXY(9,165);
$pdf->Write(0, "", '10', 0, '20', true, 0, false, false, 0);
$pdf->SetFont('ebrima', '', 20);
$pdf->SetXY(7,154);
$pdf->SetXY(13,285);

$pdf->Image("../cpd.jpg",105,264,45);

$pdf->write1DBarcode($barcode, 'C39', '5', '275', '40', 13, 0.3, $style1, 'N');

					   
 		 $pdf->Output("../MyPDF/".$name."-".$barcode."-".$curdate.".pdf", "F");	
		 
		 require_once('../PHPMailer/class.phpmailer.php');

	$mail = new PHPMailer();
	$body = '<HTML><BODY><CENTER>

  <table width="558" border="0" align="center" style="border:1px solid #016ABC;border-radius: 10px;box-shadow: 0 0 2px 0px  #016ABC;outline: none;">
  <tr>
    <td height="87"><img src="../images/logo1.png" width="132" height="75" /></td>
    <td height="87">&nbsp;</td>
    <td height="87"><img src="../images/rtnts.png" width="109" height="75" align="left" /></td>
  </tr>
  <tr>
    <td height="23" colspan="3" style="background-color: #84C1F1;border-bottom:1px solid #016ABC;font-family:Candara">&nbsp;</td>
  </tr>
  <tr>
    <td height="23" colspan="3" >&nbsp;</td>
  </tr>
  
  <tr>
    <td width="107" height="89">&nbsp;</td>
    <td width="320">
	<table width="315" border="0"  style="border:1px solid #016ABC;border-radius: 10px;box-shadow: 0 0 2px 0px  #016ABC;outline: none;">
      <tr>
        <td height="24" colspan="2" style="border-bottom:1px solid #016ABC;font-family:Candara" ><div align="center">Result Detail</div></td>
      </tr>
      <tr>
        <td width="157" height="44" style="font-family:Candara;border-right:1px solid #016ABC;"><div align="center">User Name :</div></td>
        <td width="146" style="font-family:Candara;color:#666666"><div align="center">'.$name.'</div></td>
      </tr>
      <tr>
        <td width="157" height="44" style="font-family:Candara;border-right:1px solid #016ABC;"><div align="center">Test Name :</div></td>
        <td width="146" style="font-family:Candara;color:#666666"><div align="center">'.$r2['name'].'</div></td>
      </tr>
      <tr>
        <td height="44" style="font-family:Candara;border-right:1px solid #016ABC;"><div align="center">Total Question :</div></td>
        <td height="44" style="font-family:Candara;color:#666666"><div align="center">'.$scoree.'</div></td>
      </tr>
      <tr>
        <td height="43" style="font-family:Candara;border-right:1px solid #016ABC;"><div align="center">Correct Answer :</div></td>
        <td height="43" style="font-family:Candara;color:#666666"><div align="center">'.$score.'</div></td>
      </tr>
      <tr>
        <td height="48" style="font-family:Candara;border-right:1px solid #016ABC;"><div align="center">Wrong Answer : </div></td>
        <td height="48" style="font-family:Candara;color:#666666"><div align="center">'.$wrong.'</div></td>
      </tr>
      <tr>
        <td height="48" style="font-family:Candara;border-right:1px solid #016ABC;"><div align="center">Result : </div></td>
        <td height="48" style="font-family:Candara;color:#666666"><div align="center">'.$reslt.'</div></td>
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
</table></CENTER></BODY>
</HTML>'; 
	 $mail->SetFrom("techsupport@rebits.co.uk", "Rebits");
	      $mail->AddReplyTo("techsupport@rebits.co.uk", "Rebits");
		  $mail->AddBcc("reports@rtnts.com","Admin");
 	     //$mail->AddAddress("psdeol@rebits.co.uk", "Paramvir");
		    // $mail->AddAddress("mahesh@rtnts.co.uk", "Mahesh");
			  //$mail->AddAddress("technical@hbhm.rtnts.com", "technical@hbhm.rtnts.com");
	      $mail->AddBcc("mamta@rebits.co.in", "mamta");
		  $mail->AddAddress($email, $email);
		  
	 $mail->Subject = "Result Detail";
	  $mail->MsgHTML($body);
    	$mail->AddAttachment("../MyPDF/".$name."-".$barcode."-".$curdate.".pdf");
	
      }
      else
      {
         $reslt = "Fail";
		 require_once('../PHPMailer/class.phpmailer.php');

	$mail = new PHPMailer();
	$body = '<HTML><BODY><CENTER>

  <table width="558" border="0" align="center" style="border:1px solid #016ABC;border-radius: 10px;box-shadow: 0 0 2px 0px  #016ABC;outline: none;">
  <tr>
    <td height="87"><img src="../images/logo1.png" width="132" height="75" /></td>
    <td height="87">&nbsp;</td>
    <td height="87"><img src="../images/rtnts.png" width="109" height="75" align="left" /></td>
  </tr>
  <tr>
    <td height="23" colspan="3" style="background-color: #84C1F1;border-bottom:1px solid #016ABC;font-family:Candara">&nbsp;</td>
  </tr>
  <tr>
    <td height="23" colspan="3" >&nbsp;</td>
  </tr>
  
  <tr>
    <td width="107" height="89">&nbsp;</td>
    <td width="320">
	<table width="315" border="0"  style="border:1px solid #016ABC;border-radius: 10px;box-shadow: 0 0 2px 0px  #016ABC;outline: none;">
      <tr>
        <td height="24" colspan="2" style="border-bottom:1px solid #016ABC;font-family:Candara" ><div align="center">Result Detail</div></td>
      </tr>
      <tr>
        <td width="157" height="44" style="font-family:Candara;border-right:1px solid #016ABC;"><div align="center">User Name :</div></td>
        <td width="146" style="font-family:Candara;color:#666666"><div align="center">'.$name.'</div></td>
      </tr>
      <tr>
        <td width="157" height="44" style="font-family:Candara;border-right:1px solid #016ABC;"><div align="center">Test Name :</div></td>
        <td width="146" style="font-family:Candara;color:#666666"><div align="center">'.$r2['name'].'</div></td>
      </tr>
      <tr>
        <td height="44" style="font-family:Candara;border-right:1px solid #016ABC;"><div align="center">Total Question :</div></td>
        <td height="44" style="font-family:Candara;color:#666666"><div align="center">'.$scoree.'</div></td>
      </tr>
      <tr>
        <td height="43" style="font-family:Candara;border-right:1px solid #016ABC;"><div align="center">Correct Answer :</div></td>
        <td height="43" style="font-family:Candara;color:#666666"><div align="center">'.$score.'</div></td>
      </tr>
      <tr>
        <td height="48" style="font-family:Candara;border-right:1px solid #016ABC;"><div align="center">Wrong Answer : </div></td>
        <td height="48" style="font-family:Candara;color:#666666"><div align="center">'.$wrong.'</div></td>
      </tr>
      <tr>
        <td height="48" style="font-family:Candara;border-right:1px solid #016ABC;"><div align="center">Result : </div></td>
        <td height="48" style="font-family:Candara;color:#666666"><div align="center">'.$reslt.'</div></td>
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
</table></CENTER></BODY>
</HTML>'; 
	 $mail->SetFrom("techsupport@rebits.co.uk", "Rebits");
	      $mail->AddReplyTo("techsupport@rebits.co.uk", "Rebits");
		 $mail->AddBcc("reports@rtnts.com","Admin");
 	    // $mail->AddAddress("psdeol@rebits.co.uk", "Paramvir");
		  //   $mail->AddAddress("mahesh@rtnts.co.uk", "Mahesh");
			//  $mail->AddAddress("technical@hbhm.rtnts.com", "technical@hbhm.rtnts.com");
			  
	      $mail->AddBcc("mamta@rebits.co.in", "mamta");
	   $mail->AddAddress($email, $email);
	 $mail->Subject = "Result Detail";
	  $mail->MsgHTML($body);
      }
	  
  $end = date('Y-m-d', strtotime('+2 years'));
  $date=date('Y-m-d');

   $sql=mysqli_query($con,"select * from tblresult where tid='$tid' AND staffid='$staffid' AND curdate='$date'");
 
     $z=mysqli_query($con,"insert into tblresult(tid,staffid,score,result,batchcode,nextdate,curdate)values('$tid','$staffid','$score','$reslt','$barcode','$end','$date')")or die(mysqli_error());
?>
    <script language="javascript">
 // window.open('admin.php?id=1','_self');
    </script>