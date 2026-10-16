<?php
session_start();
$portallink=$_SESSION['portallink'];
date_default_timezone_set('Europe/London');
include 'connection.php';

   $sno=$_GET['rid'];
    $sid=$_GET['sid'];
	 $tid=$_GET['sno'];

$date=date("Y-m-d");





$sq2=mysqli_query($con,"select * from tblroster where id='$sno' ");
$sq3=mysqli_fetch_array($sq2);


$auditee=mysqli_query($con,"select * from tblauditee where id='$sq3[auditee]'");
                  $auditee1=mysqli_fetch_array($auditee);
				  
				  
				   $auditor=mysqli_query($con,"select * from tblauditor where id='$sq3[auditor]'");
                  $auditor1=mysqli_fetch_array($auditor);
				  
				  $total3=mysqli_query($con,"select * FROM addtest1 where testid='$sq3[tid]'");
				  $addtest=mysqli_fetch_array($total3);
				  
				  
				   $total2=mysqli_query($con,"select * FROM subtest where sid='$sq3[sid]' and tid='$sq3[tid]'");
				   $subtest=mysqli_fetch_array($total2);
				   
				   
				   

 $sql1=mysqli_query($con,"select * from saveaudit where sno='$sno' and ans=''");
 $match1=mysqli_num_rows($sql1);

if($match1>=1)
{
?>
<script>
window.open('admin.php?id=audit1&sno=<?php echo $tid;?>&sid=<?php echo $sid;?>&rid=<?php echo $sno;?>&msg=1','_self');
</script>

<?php
}
else
{

$sql=mysqli_query($con,"select * from saveaudit where sno='$sno' and (status='Rejected' || status='waiting') ");
$match=mysqli_num_rows($sql);

if($match<=0)
{
 $jk=mysqli_query($con,"update tblroster set status='Done',auditdate='$date',status1='Done',bgcolor='#669900' where id='$sno'");
}

else
{
$jk=mysqli_query($con,"update tblroster set auditdate='$date' , status='In Progress', bgcolor='#FFCC00', status1='In Progress' where id='$sno'");

}


if(($date!='' || $date!='0000-00-00') && ($match['ans'] =='Minor'|| $match['ans'] =='Major'))
{
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
    <td height="30" colspan="2" style="background-color:#84C1F1;border-bottom:1px solid #016ABC;font-family:Candara">Section : '.$addtest['testid'].'- '.$addtest['subject'].'</td>
    </tr>
	<tr>
    <td height="30" colspan="2" style="background-color:#84C1F1;border-bottom:1px solid #016ABC;font-family:Candara">Sub-Section : '.$subtest['id'].'- '.$subtest['subtest'].'</td>
    </tr>
	
    <tr>
    <td height="30" colspan="2" style="background-color:#84C1F1;border-bottom:1px solid #016ABC;font-family:Candara">Audit Date : '.date('d-m-Y',strtotime($date)).'</td>
    </tr>
	<tr>
    <td height="30" colspan="2" style="background-color:#84C1F1;border-bottom:1px solid #016ABC;font-family:Candara">Auditor : '.$auditor1['name'].'</td>
	</tr>
	<tr>
    <td height="30" colspan="2" style="background-color:#84C1F1;border-bottom:1px solid #016ABC;font-family:Candara">Auditee: '.$auditee1['name'].'</td>
	</tr>
	<tr>
	  <td height="30" colspan="2"  style="background-color:#84C1F1;border-bottom:1px solid #016ABC;font-family:Candara">Total NC: '.$match.'</td>
  </tr>
  
  <tr>
	  <td height="30" colspan="2"  style="background-color:#84C1F1;border-bottom:1px solid #016ABC;font-family:Candara;color:bleue"><a href="'.$portallink.'internalauditnc.php/?sno='.$sno.'">Click Here</a></td>
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
		
		$mail->Subject = "INTERNAL AUDIT DETAIL";
		 
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







<script>
window.open('admin.php?id=auditdetail','_self');
</script>
<?php
}
?>