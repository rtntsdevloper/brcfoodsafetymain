<?php
session_start();
 $user=$_SESSION['user'];
 
							$portallink=$_SESSION['portallink'];
							
							
include 'connection.php';




$sql=mysqli_query($con,"select * from tblgmpaudit3 where sno='$_GET[sno1]' and (status='Rejected' || status='waiting') ");
$match=mysqli_num_rows($sql);

if($match<=0)
{
 $sql2=mysqli_query($con,"select * from tblgmpaudit2 where id='$_GET[sno1]' ");
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
				   
				   
     require_once('PHPMailer/class.phpmailer.php');
      $mail = new PHPMailer();
    $body = '<HTML><BODY><CENTER>
    <table width="558" border="0" align="center" style="border:1px solid #016ABC;border-radius: 10px;box-shadow: 0 0 2px 0px  #016ABC;outline: none;">
     <tr>
    <td width="373" height="87">
	<img src="images/logo1.jpg" width="132" height="73" />	</td>
	
    <td width="373"><img src="images/rtnts.png" width="132" height="73" align="right" /></td>
    </tr>
	
	<tr>
    <td height="30" colspan="2" style="background-color:#84C1F1;border-bottom:1px solid #016ABC;font-family:Candara">NC CLOSED OFF DETAIL</td>
    </tr>
	
    <tr>
    <td height="30" colspan="2" style="background-color:#84C1F1;border-bottom:1px solid #016ABC;font-family:Candara">Audit Date : '.$auditdate.'</td>
    </tr>
	<tr>
    <td height="30" colspan="2" style="background-color:#84C1F1;border-bottom:1px solid #016ABC;font-family:Candara">Auditor : '.$auditor1['name'].'</td>
	</tr>
	<tr>
    <td height="30" colspan="2" style="background-color:#84C1F1;border-bottom:1px solid #016ABC;font-family:Candara">Auditee: '.$auditee1['name'].'</td>
	</tr>
	<tr>
	  <td height="30" colspan="2"  style="background-color:#84C1F1;border-bottom:1px solid #016ABC;font-family:Candara">Section: '.$addtest['id']. $addtest['name'].'</td>
  </tr>
	<tr>
	  <td height="30" colspan="2" style="background-color:#84C1F1;border-bottom:1px solid #016ABC;font-family:Candara">Sub-Section : '.$subtest['name'].'</td>
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
							  window.open('admin.php?id=gmpnc&sno=<?php echo $_GET['sno1'];?>','_self');
							   </script>