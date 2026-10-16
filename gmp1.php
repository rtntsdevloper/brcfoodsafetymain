<?php
include 'connection.php';
$sno=$_GET['sno'];

$sql=mysqli_query($con,"select * from tblgmpaudit2 where id='$sno'");
$row=mysqli_fetch_array($sql);

$ghj=mysqli_query($con,"select * from tblauditsection where id='$row[audit]'");
$ghj1=mysqli_fetch_array($ghj);	


$sh=mysqli_query($con,"select * from tblauditor where id='$row[auditor]'");
                                                $hj=mysqli_fetch_array($sh);
											
											
											    $sh13=mysqli_query($con,"select * from tblauditee where id='$row[auditee]'");
                                                $hj13=mysqli_fetch_array($sh13);
											
											
												
												
$name=$ghj1['name'];

$dt=date("d-m-Y", strtotime($row['date']));  

require('tcpdf/tcpdf.php');
class MYPDF extends TCPDF {

        public function Header() {
	
        $image_file = 'images/1.png';
		
        $this->Image($image_file, 15, 5, 40, '', 'png', '', 'T', false, 200, '', false, false, 0, false, false, false);
		
		
		$this->SetFont('courier', '', 20);
				$this->SetXY(80,2);
		$this->Write(30,'GMP Audit Report', '', 0, '30', true, 0, false, false, 0);
		
        
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
$pdf->Write(0, "Date created:$dt", '', '0', '0', true, 'C', false, false, 0);
$pdf->SetXY(15,47);
$pdf->Write(0, "Auditor: $hj[name]", '', '0', '0', true, 'C', false, false, 0);
$pdf->SetXY(15,54);
$pdf->Write(0, "Auditee:$hj13[name]", '', '0', '0', true, 'C', false, false, 0);
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

$gh=mysqli_query($con,"select * from tblauditsection2 where sid='$row[audit]'");
while($row1=mysqli_fetch_array($gh))
{
	
	$gh1=mysqli_query($con,"select * from tblgmpaudit3 where qid='$row1[id]' and sno='$sno'");
    $rows=mysqli_fetch_array($gh1);


									
$tbl1 .= '
  <tr nobr="true"> 
      <td width="120" >Question</td>
       <td  width="500" >'.$rows['ques'].'</td>
   </tr>';
   
   
     if($rows['ans']=="Compliant")
	{
	$tbl1 .= '<tr nobr="true"> 
	 <td width="120">Answer</td>
       <td  width="500" style="color:green">'.$rows['ans'].'</td>
   </tr>
   <tr nobr="true"> 
	 <td width="120"  >Comment</td>
       <td  width="500" style="color:green">'.$rows['cmnt'].'</td>
   </tr>
   ';
   }
   if($rows['ans']=="Major")
	{
	$tbl1 .= '<tr nobr="true"> 
	 <td width="120">Answer</td>
       <td  width="500" style="color:red">'.$rows['ans'].'</td>
   </tr>
   <tr nobr="true"> 
	 <td width="120"  >Comment</td>
       <td  width="500" style="color:red">'.$rows['cmnt'].'</td>
   </tr>
   ';
   }
    if($rows['ans']=="Minor")
	{
	$tbl1 .= '<tr nobr="true"> 
	 <td width="120">Answer</td>
       <td  width="500" style="color:orange">'.$rows['ans'].'</td>
   </tr>
   <tr nobr="true"> 
	 <td width="120"  >Comment</td>
       <td  width="500" style="color:orange">'.$rows['cmnt'].'</td>
   </tr>';
   }
   
   
	
  if($rows['img']!="" )
  {
   $string = $rows['img'];
$tags1 = explode(';' , $string);

  foreach($tags1 as $key1)
  {
  $info = new SplFileInfo($key1);
  $tpe=$info->getExtension();
  
  if($tpe=="jpg" || $tpe=="jpeg" || $tpe=="png" || $tpe=="PNG")
  {

$tbl1 .= '  <tr nobr="true">
    <td width="120">Image</td>
	
    <td width="500"><img src="auditpic/'.$key1.'" height="300"  width="300">
	</td>
  </tr>';
  }
  }
}
	
 
}
 
$pdf->writeHTML($tbl_header . $tbl1 . $tbl_footer, true, false, false, false, '');

$pdf->Output("upl1/".$name.".pdf","F");



?>
<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Home</a></li>
                        <li>Audit Details </li>
                    </ul>
                </div>
				  <div class="row mb-12">
                    <div class="col-md-12 mb-12">
                        <div class="card text-left">
                            <div class="card-body">
							
							
							<a href="admin.php?id=gmp"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							
							
							<a href="upl1/<?php echo $name;?>.pdf" target="_blank"><button class="btn btn-warning" style="float:right; margin-left:15px">View Report</button></a>
                             <h4 class="card-title mb-3">Audit Detail</h4>
								
                              
								
                                <div class="table-responsive">
                                    <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                       <thead>
					       <th width="5">Sno</th>
						   <th width="10">Test Name </th>
	                       <th width="15">Auditee</th>
	                       <th width="20">Auditor</th>
	                       <th width="10">Date</th>
							<th width="10">Question</th>
							<th width="10">Ans</th>
							<th width="10">Comment</th>
							
							</thead>
	                        <tbody>
 <?php
$sql=mysqli_query($con,"select * from tblgmpaudit2 where id='$sno'");
$row=mysqli_fetch_array($sql);

									  $gh2=mysqli_query($con,"select * from tblauditsection2 where sid='$row[audit]'");
									  $n=0;
while($row2=mysqli_fetch_array($gh2))
{
	
	$gh3=mysqli_query($con,"select * from tblgmpaudit3 where qid='$row2[id]' and sno='$sno'");
    $row3=mysqli_fetch_array($gh3);


									
									
									  $n++;
									  ?> 
					  <tr>
                      <td>  <div align="center"> <?php echo $n;?> </div> </td>
					  <td>  <?php echo $name;?>  </td>
                      <td>  <?php echo $hj['name'];?>     </td>
                      <td> <?php echo $hj13['name'];?></td>
					   <td><?php echo $dt;?></td>
                       <td><?php echo $row2['ques'];?></td>
					   <td><?php echo $row3['ans'];?></td>
					   <td><?php echo $row3['cmnt'];?></td>
                      
					    <?php
					     }
					     ?>
					  
	                                        
	               </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>