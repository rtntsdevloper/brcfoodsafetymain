<?php
$sno=$_GET['sno'];
$sno1=$_GET['sno1'];
$staffid=$_GET['staffid'];
$sq=mysqli_query($con,"select * from tblprocedure where id='$sno'");
$gh=mysqli_fetch_array($sq);

$sq1=mysqli_query($con,"select * from tblmodule1 where id='$gh[module]'");
$gh1=mysqli_fetch_array($sq1);


$sq12=mysqli_query($con,"select * from tbldept1 where id='$gh[dept]'");
$gh2=mysqli_fetch_array($sq12);


$hj=mysqli_query($con,"select * from tblproceduretraining1 where id='$sno1'");
$hj1=mysqli_fetch_array($hj);


$hj2=mysqli_query($con,"select * from tblstaff where id='$staffid'");
$hj3=mysqli_fetch_array($hj2);


$pro=mysqli_query($con,"select * from tblproceduretraining where id='$hj1[pid]'");
$pro1=mysqli_fetch_array($pro);

$hj21=mysqli_query($con,"select * from tblauditor where name='$pro1[auditor]'");
$hj31=mysqli_fetch_array($hj21);

$imgg=$hj31['userimg'];

$hj22=mysqli_query($con,"select * from tblresult1 where staffid='$staffid' and tid='$sno' order by sno desc limit 1");
$hj32=mysqli_fetch_array($hj22);



?>
					<div class="container-fluid">
                     <div class="row">
                        <div class="col-md-12">
                           <div class="page_title">
                              <h2>Procedure Management
							  
							  <a href="admin.php?id=procedure"><button class="btn btn-info" style="float:right">Go Back</button></a>
							  </h2>
							     
                           </div>
                        </div>
                     </div>
                     <!-- row -->
                 	<div class="row" style="margin:10px"><div class="col-md-4"></div>
					<div class="col-md-8">
					
					
					</div></div>
				   
					<div class="row">
                        <div class="col-md-4">
                           <div class="full white_shd">
                              <div class="full graph_head">
                               Module : <?php echo $gh1['name'];?>
							   <br/>
							    Department : <?php echo $gh2['dept'];?>
							   <br/>
							   							  
							    Section Name: <?php echo $gh['name'];?>
							   <br/>
							Date: <?php echo date('d-m-Y',strtotime($gh['date']));?>
							<br/>
							Version: <?php echo $gh['version'];?>
							
							</br/>
		      


                              </div>
                           
                           </div>
                        </div>
						
						<div class="col-md-8">
                           <div class="full white_shd">
                              <div class="full graph_head">
			 <?php
		    
require('tcpdf/tcpdf.php');
ini_set('max_execution_time', 300);
//$sq=mysqli_query($con,"select * from test");
//while($row=mysqli_fetch_array($sq))
//{

 //$date = strtotime($row['date1']);
   //    $newdate = date('d-m-Y',strtotime("+1 year",$date));
//$name="uploads/".$row['pic'].".jpeg";



class MYPDF extends TCPDF 
{


  public function Header() 
	{
}
   
	 public function Footer() 
	  {
	  $this->SetFont('centurygothic', '',8);
     
	    $this->SetY(-10);
          $this->Cell(320, 5, 'PAGE '.$this->getAliasNumPage().' OF '.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	    
       
		 
     }
	


}
$pdf = new MYPDF('P', 'mm', array(285, 235), true, 'UTF-8', false);

$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->SetMargins(PDF_MARGIN_LEFT, 25,PDF_MARGIN_RIGHT);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


if (@file_exists(dirname(__FILE__).'/lang/eng.php')) 
{
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}



$pdf->AddPage();
$pdf->SetFont('centurygothic', '',20);  
$pdf->SetXY(15,8);
$pdf->Cell(0,10,"Internal Training Record",0,1,'C');



$pdf->SetFont('centurygothic', '',10);                
 $pdf->SetXY(15,30);

$tbl_header = '<style>
table 
{
   border-spacing: 0;
}
tr 
{
}

th 
{
   background-color:#FFFFFF;
  border-bottom: 1px solid #000000;
   color: #000000;
   font-size: 28px;
   text-align: center;
   padding-bottom: 4px;
   padding-left: 8px;
   padding-top: 5px;
}
td {
   border-bottom: 1px solid #000000;
   font-size: 15px;
   color: #000000;
}
</style>
<table id="gallerytab" width="700" cellspacing="0" cellpadding="5" border="0" >
';
$tbl_footer = '</table>';
$tbl = '';

$dt=date('d-m-Y', strtotime($gh['date']));
$dt1=date('d-m-Y', strtotime($pro1['date']));


$tbl.= ' 
  <tr>
    <td>Procedure:</td>
    <td>'. $gh['name'].'</td>
  </tr>
  <tr>
    <td>Version No:</td>
    <td>'.$gh['version'].'</td>
  </tr>
  <tr>
    <td>Issue date:</td>
    <td>'.$dt.'</td>
  </tr>
  
  <tr>
    <td>Score:</td>
    <td>'.$hj32['score'].'/5</td>
  </tr>
  
   <tr>
    <td>Result:</td>
    <td>'.$hj32['result'].'</td>
  </tr>
  
  <tr>
    <td><p>Department:</p></td>
    <td>'.$gh2['dept'].'</td>
  </tr>
  
  <tr>
    <td>Trainee  Name:</td>
    <td>'.$hj3['fname'].'  '.$hj3['lname'].'</td>
  </tr>
  
  <tr>
    <td><img src="student/'.$hj3['img'].'" width="100"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Training  date:</td>
    <td>'.$dt1.'</td>
  </tr>
  <tr>
    <td>Duration </td>
    <td>2 Hours</td>
  </tr>
  <tr>
    <td>Signature  of Trainee </td>
    <td><img src="signature/'.$hj1['sign'].'.png" width="100"></td>
  </tr>
  <tr>
    <td>Trainer:</td>
    <td>'.$pro1['auditor'].'</td>
  </tr>
  <tr>
    <td><img src="auditordoc/'.$imgg.'" width="100"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Signature  of Trainer </td>
    <td><img src="signature/'.$hj31['signature'].'" width="100"></td>
  </tr>';

$pdf->writeHTML(utf8_encode($tbl_header . $tbl . $tbl_footer), true, false, true, false, '');


$pdf->Output($_SERVER['DOCUMENT_ROOT'] ."finemed/MyPDF/".$sno1.".pdf","F");

?>

              <object data="MyPDF/<?php echo $sno1;?>.pdf" type="application/pdf" width="100%" height="1200px"></object>
              
			
			  
					 
                              </div>
                           </div>
						   
						</div>
					   
                               </div> 
							
							
							
							
							
							 <!-- The Modal -->
							 
							