
							
							<?php
							session_start();
							$portallink=$_SESSION['portallink'];
						
						include 'connection.php';	
						
						$msg=$_GET['msg'];
						$sno=$_GET['sno'];
						 $sno1=$_GET['sno1'];
							 
	
		
		$sql=mysqli_query($con,"select * from saveaudit where sno='$sno1' and status='waiting' ");
       $match=mysqli_num_rows($sql);


		
		?>
		
		<?php
		if($match<=0)
		{
		
		$sq2=mysqli_query($con,"select * from tblroster where id='$sno1' ");
$sq3=mysqli_fetch_array($sq2);


$auditee=mysqli_query($con,"select * from tblauditee where id='$sq3[auditee]'");
                  $auditee1=mysqli_fetch_array($auditee);
				  
				  
				   $auditor=mysqli_query($con,"select * from tblauditor where id='$sq3[auditor]'");
                  $auditor1=mysqli_fetch_array($auditor);
				  
				  $total3=mysqli_query($con,"select * FROM addtest1 where testid='$sq3[tid]'");
				  $addtest=mysqli_fetch_array($total3);
				  
				  
				   $total2=mysqli_query($con,"select * FROM subtest where sid='$sq3[sid]' and tid='$sq3[tid]'");
				   $subtest=mysqli_fetch_array($total2);
				   
		
		require_once('PHPMailer/class.phpmailer.php');
      $mail = new PHPMailer();
    $body = '<HTML><BODY><CENTER>
    <table width="558" border="0" align="center" style="border:1px solid #016ABC;border-radius: 10px;box-shadow: 0 0 2px 0px  #016ABC;outline: none;">
     <tr>
    <td width="373" height="87">
	<img src="images/1.png" width="132" height="73" />	</td>
	
    <td width="373"><img src="images/rtnts.png" width="132" height="73" align="right" /></td>
    </tr>
	
	<tr>
    <td height="30" colspan="2" style="background-color:#84C1F1;border-bottom:1px solid #016ABC;font-family:Candara">NC CLOSED OFF DETAILs</td>
    </tr>
	<tr>
    <td height="30" colspan="2" style="background-color:#84C1F1;border-bottom:1px solid #016ABC;font-family:Candara">Section : '.$addtest['testid'].'- '.$addtest['subject'].'</td>
    </tr>
	<tr>
    <td height="30" colspan="2" style="background-color:#84C1F1;border-bottom:1px solid #016ABC;font-family:Candara">Sub-Section : '.$subtest['sid'].'- '.$subtest['subtest'].'</td>
    </tr>
	
    <tr>
    <td height="30" colspan="2" style="background-color:#84C1F1;border-bottom:1px solid #016ABC;font-family:Candara">Audit Date : '.date('d-m-Y',strtotime($sq3['auditdate'])).'</td>
    </tr>
	<tr>
    <td height="30" colspan="2" style="background-color:#84C1F1;border-bottom:1px solid #016ABC;font-family:Candara">Auditor : '.$auditor1['name'].'</td>
	</tr>
	<tr>
    <td height="30" colspan="2" style="background-color:#84C1F1;border-bottom:1px solid #016ABC;font-family:Candara">Auditee: '.$auditee1['name'].'</td>
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
		
		$mail->Subject = "INTERNAL AUDIT CLOSED OFF DETAIL";
		 
	    $mail->MsgHTML($body);
	   
	    //$mail->AddAttachment("upl/".$date."-".$gh['concession']."-".$gh['username']."-".$depty.".pdf");
	    if(!$mail->Send())
	    {
	    echo "Mailer Error: " . $mail->ErrorInfo;
	    } 
	    else 
    	{
	    }
		
		
		
}
?>




<?php
if($msg==2)
		{
		
		$sq2=mysqli_query($con,"select * from tblroster where id='$sno1' ");
$sq3=mysqli_fetch_array($sq2);


$auditee=mysqli_query($con,"select * from tblauditee where id='$sq3[auditee]'");
                  $auditee1=mysqli_fetch_array($auditee);
				  
				  
				   $auditor=mysqli_query($con,"select * from tblauditor where id='$sq3[auditor]'");
                  $auditor1=mysqli_fetch_array($auditor);
				  
				  $total3=mysqli_query($con,"select * FROM addtest1 where testid='$sq3[tid]'");
				  $addtest=mysqli_fetch_array($total3);
				  
				  
				   $total2=mysqli_query($con,"select * FROM subtest where sid='$sq3[sid]' and tid='$sq3[tid]'");
				   $subtest=mysqli_fetch_array($total2);
				   
		
		require_once('PHPMailer/class.phpmailer.php');
      $mail = new PHPMailer();
    $body = '<HTML><BODY><CENTER>
    <table width="558" border="0" align="center" style="border:1px solid #016ABC;border-radius: 10px;box-shadow: 0 0 2px 0px  #016ABC;outline: none;">
     <tr>
    <td width="373" height="87">
	<img src="images/1.png" width="132" height="73" />	</td>
	
    <td width="373"><img src="images/rtnts.png" width="132" height="73" align="right" /></td>
    </tr>
	
	<tr>
    <td height="30" colspan="2" style="background-color:#84C1F1;border-bottom:1px solid #016ABC;font-family:Candara">NC DETAIL CHECKED BY AUDITOR</td>
    </tr>
	<tr>
    <td height="30" colspan="2" style="background-color:#84C1F1;border-bottom:1px solid #016ABC;font-family:Candara">Section : '.$addtest['testid'].'- '.$addtest['subject'].'</td>
    </tr>
	<tr>
    <td height="30" colspan="2" style="background-color:#84C1F1;border-bottom:1px solid #016ABC;font-family:Candara">Sub-Section : '.$subtest['sid'].'- '.$subtest['subtest'].'</td>
    </tr>
	
    <tr>
    <td height="30" colspan="2" style="background-color:#84C1F1;border-bottom:1px solid #016ABC;font-family:Candara">Audit Date : '.date('d-m-Y',strtotime($sq3['auditdate'])).'</td>
    </tr>
	<tr>
    <td height="30" colspan="2" style="background-color:#84C1F1;border-bottom:1px solid #016ABC;font-family:Candara">Auditor : '.$auditor1['name'].'</td>
	</tr>
	<tr>
    <td height="30" colspan="2" style="background-color:#84C1F1;border-bottom:1px solid #016ABC;font-family:Candara">Auditee: '.$auditee1['name'].'</td>
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
		
		$mail->Subject = "INTERNAL AUDIT CLOSED OFF DETAIL";
		 
	    $mail->MsgHTML($body);
	   
	    //$mail->AddAttachment("upl/".$date."-".$gh['concession']."-".$gh['username']."-".$depty.".pdf");
	    if(!$mail->Send())
	    {
	    echo "Mailer Error: " . $mail->ErrorInfo;
	    } 
	    else 
    	{
	    }
		
		
		
}
?>
		
		
							   <script language="javascript">
							window.open('ncview2.php?sno=<?php echo $_GET['sno1'];?>','_self');
							   </script>