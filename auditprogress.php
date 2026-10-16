<?php
ini_set('max_execution_time', 600);
ini_set('memory_limit','-1');
				
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

   class MYPDF extends TCPDF 
   {
        public function Header() 
		{
	
        $image_file = 'images/1.png';
	
        $this->Image($image_file, 15, 5, 20, '', 'png', '', 'T', false, 200, '', false, false, 0, false, false, false);
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


//$pdf->SetCreator(PDF_CREATOR);
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->SetMargins(PDF_MARGIN_LEFT, 35, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


if (@file_exists(dirname(__FILE__).'/lang/eng.php')) 
{
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
else{$t2=0;}
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
td 
{
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


$dte=date('d-m-Y',strtotime($row3['date']));


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
    <td>Detail: '.$row3['detail'].' <br/><br/> Document: '.$row3['img'].' <br/><br/> Link if any: '.$row3['linkk'].' <br/> <br/>Updated on: '.$dte.'</td>
  </tr>';
  }
 else if($row2['status']=="2")
  {
  $tbl7 .= '<tr>
    <td style="background-color:green">Completed</td>
    <td>Detail: '.$row3['detail'].' <br/><br/> Document: '.$row3['img'].' <br/><br/> Link if any: '.$row3['linkk'].' <br/><br/> Updated on: '.$dte.'</td>
  </tr>';
  }
   else if($row2['status']=="3")
  {
  $tbl7 .= '<tr>
    <td style="background-color:gray">Not Applicable</td>
   <td>Not Applicable</td>
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

// $pdf->Output($_SERVER['DOCUMENT_ROOT']."upl1/".$sno."-General Compliance.pdf",'F');  //online
 $pdf->Output($_SERVER['DOCUMENT_ROOT']."brcfoodsafety/upl1/".$sno."-General Compliance.pdf",'F');
 
      ?>








      
	<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Home</a></li>
                        <li>BRC Compliance</li>
                    </ul>
                </div>
		
                        <div class="card text-left">
                            <div class="card-body">
							<a href="admin.php?id=1#audits"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							
                                <h4 class="card-title mb-2">Requirements</h4>
                               
                                <div class="row">
                              
                        <div class="card text-left">
						
                            <div class="card-body">
                               <p >Each main section or subsection of the requirements in the Standard begins with a statement of intent. This sets
out the expected outcome of compliance with the requirements of that section. This forms part of the audit and
all companies must comply with the statements of intent.</p>
								
								<a href="upl1/<?php echo $sno;?>-General Compliance.pdf" target="_blank">
								<button class="btn btn-info" style="float:right; margin-left:15px">View Report</button></a>
		<ul class="nav nav-tabs" id="dropdwonTab" role="tablist">
		  <!--------compliance---------->
		  
		  
	  <li class="nav-item dropdown active">
	  <a class="nav-link dropdown-toggle active" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Select Section</a>
                 <div class="dropdown-menu">
				 <?php
				 $sql21=mysqli_query($con,"select * from addtest1");
				 while($row21=mysqli_fetch_array($sql21))
				 {
				?>
				
				 <a class="dropdown-item " id="dropdown1-tab<?php echo $row2['testid'];?>" href="admin.php?id=auditprogress&sno=<?php echo $row21['testid'];?>">
				 <?php echo $row21['subject'];?> 
				 </a>
				 
				 <?php
				 }
				 ?>
				 </div>
                                    </li>
									<!--------complinace end---------->
									<!--------original---------->
                                </ul>
								
								<!--------original end---------->
                                <div class="tab-content" id="myTabContent">
   
    <?php
	 $sql23=mysqli_query($con,"select * from addtest1 where testid='$_GET[sno]'");
	  while($row23=mysqli_fetch_array($sql23))
	  {
							
	  $sql21=mysqli_query($con,"select * from subtest where tid='$row23[testid]'");
	  $row21=mysqli_fetch_array($sql21);
	
	 ?>
							
   <div class="tab-pane active" id="dropdown1<?php echo $row23['testid'];?>" role="tabpanel" aria-labelledby="dropdown1-tab<?php echo $row23['testid'];?>" aria-expanded="true">
   <div class="ul-widget-s6__items">
	
	
	 <div class="ul-widget-s6__item"><span class="ul-widget-s6__badge">
                                                        <p class="badge-dot-warning ul-widget6__dot"></p>
                                                    </span><p class="ul-widget-s6__text"><?php echo $row23['subject'];?>
													
													<span class="badge badge-pill badge-primary m-2"><?php echo $row23['testid'];?></span>
													
													
													</p><span class="ul-widget-s6__time"><?php echo $row23['testid'];?></span></div>
	
	<div class="ul-widget-s6__item"><span class="ul-widget-s6__badge">
                                                        <p class="badge-dot-info ul-widget6__dot"></p>
                                                    </span>
							<p class="ul-widget-s6__text"><?php echo $row21['subtest'];?><span class="badge badge-pill badge-warning m-2"><?php echo $row21['sid'];?></span> </p>
							
							<span class="ul-widget-s6__time">1.1</span></div>								
<?php
$sql=mysqli_query($con,"select * from subtest1 where tid='$row23[testid]'");
while($row=mysqli_fetch_array($sql))
{

$tyu=mysqli_query($con,"select * from tblcmp where tid='$row23[testid]' and sid='$row[sid]'");
							 $yes=mysqli_num_rows($tyu);
										 $gh=mysqli_fetch_array($tyu);
										
										//$tyu1=mysqli_query($con,"select * from tblcmp where tid='$row2[tid]' and sid='$row2[sid]' and ssid='$row2[fid]'");
										//$no=mysqli_num_rows($tyu1);
										
										 $totalyes=round($yes*100/$mtch);
										//$totalno=round($no*100/$mtch);
									
									$datetime1 = new DateTime(date('Y-m-d'));
$datetime2 = new DateTime($gh['date']);
$interval = $datetime1->diff($datetime2);
 $interval->format('%a');					
 
?>
<?php
if($row['status']=="1")
{
?>
<div class="ul-widget-s6__item">
<span class="ul-widget-s6__badge">  <p class="badge-dot-warning ul-widget6__dot"></p></span>
<p class="ul-widget-s6__text"><?php echo $row['fid'];?><span class="badge badge-pill badge-warning m-2">In process</span></p>
<span class="ul-widget-s6__time">Updated <?php echo  $interval->format('%a');?> day ago</span>
 </div>
 <?php
 }
 else if($row['status']=="0")
{
?>
<div class="ul-widget-s6__item">
<span class="ul-widget-s6__badge">  <p class="badge-dot-danger ul-widget6__dot"></p></span>
<p class="ul-widget-s6__text"><?php echo $row['fid'];?><span class="badge badge-pill badge-danger m-2">Pending </span></p>
<span class="ul-widget-s6__time">Not updated yet</span>
 </div>
<?php
}
else if($row['status']=="2")
{
?>
<div class="ul-widget-s6__item">
<span class="ul-widget-s6__badge">  <p class="badge-dot-success ul-widget6__dot"></p></span>
<p class="ul-widget-s6__text"><?php echo $row['fid'];?><span class="badge badge-pill badge-success m-2">Done </span></p>
<span class="ul-widget-s6__time">Updated <?php echo $interval->format('%a');?> day ago</span>
 </div>

<?php
}
else if($row['status']=="3")
{
?>
<div class="ul-widget-s6__item">
<span class="ul-widget-s6__badge">  <p class="badge-dot-light ul-widget6__dot"></p></span>
<p class="ul-widget-s6__text"><?php echo $row['fid'];?><span class="badge badge-pill badge-light m-2">Not Applicable </span></p>
<span class="ul-widget-s6__time">Not Applicable</span>
 </div>

<?php
}

else
{
?>
<div class="ul-widget-s6__item">
<span class="ul-widget-s6__badge">  <p class="badge-dot-light ul-widget6__dot"></p></span>
<p class="ul-widget-s6__text"><?php echo $row['fid'];?><span class="badge badge-pill badge-light m-2">Not Started </span></p>
<span class="ul-widget-s6__time">Not Started </span>
 </div>

<?php
}
?>
 <?php
 }
 ?>					 
										  </p>
                                    </div>
                            </div> 
						<?php
							}
							?> 
   
   
                           <?php
				           $sql23=mysqli_query($con,"select * from addtest1");
							while($row23=mysqli_fetch_array($sql23))
							{
							
							  $sql21=mysqli_query($con,"select * from subtest where tid='$row23[testid]'");
							$row21=mysqli_fetch_array($sql21);
							?>
							
   <div class="tab-pane fade" id="dropdown1<?php echo $row23['testid'];?>" role="tabpanel" aria-labelledby="dropdown1-tab<?php echo $row23['testid'];?>" aria-expanded="true">
                                     <div class="ul-widget-s6__items">
	
	
	 <div class="ul-widget-s6__item"><span class="ul-widget-s6__badge">
                                                        <p class="badge-dot-warning ul-widget6__dot"></p>
                                                    </span><p class="ul-widget-s6__text"><?php echo $row23['subject'];?>
													
													<span class="badge badge-pill badge-primary m-2">1</span>
													
													
													</p><span class="ul-widget-s6__time"><?php echo $row23['testid'];?></span></div>
	
	<div class="ul-widget-s6__item"><span class="ul-widget-s6__badge">
                                                        <p class="badge-dot-info ul-widget6__dot"></p>
                                                    </span>
							<p class="ul-widget-s6__text"><?php echo $row21['subtest'];?><span class="badge badge-pill badge-warning m-2"><?php echo $row21['sid'];?></span> </p>
							
							
							
							<span class="ul-widget-s6__time">1.1</span></div>								
<?php
$sql=mysqli_query($con,"select * from subtest1 where tid='$row23[testid]'");
while($row=mysqli_fetch_array($sql))
{
$tyu=mysqli_query($con,"select * from tblcmp where tid='$row23[testid]' and sid='$row[sid]'");
	 $yes=mysqli_num_rows($tyu);
	 $gh=mysqli_fetch_array($tyu);
										
	//$tyu1=mysqli_query($con,"select * from tblcmp where tid='$row2[tid]' and sid='$row2[sid]' and ssid='$row2[fid]'");
	//$no=mysqli_num_rows($tyu1);
										
    $totalyes=round($yes*100/$mtch);
 	//$totalno=round($no*100/$mtch);
									
  $datetime1 = new DateTime(date('Y-m-d'));
  $datetime2 = new DateTime($gh['date']);
  $interval = $datetime1->diff($datetime2);
  $interval->format('%a');					
 
 ?>
<?php
if($row['status']=="1")
{
?>
<div class="ul-widget-s6__item">
<span class="ul-widget-s6__badge">  <p class="badge-dot-warning ul-widget6__dot"></p></span>
<p class="ul-widget-s6__text"><?php echo $row['fid'];?><span class="badge badge-pill badge-warning m-2">In process</span></p>
<span class="ul-widget-s6__time">Updated <?php echo  $interval->format('%a');?> day ago</span>
 </div>
 <?php
 }
 else if($row['status']=="0")
{
?>
<div class="ul-widget-s6__item">
<span class="ul-widget-s6__badge">  <p class="badge-dot-danger ul-widget6__dot"></p></span>
<p class="ul-widget-s6__text"><?php echo $row['fid'];?><span class="badge badge-pill badge-danger m-2">Pending </span></p>
<span class="ul-widget-s6__time">Not updated yet</span>
 </div>
<?php
}
else if($row['status']=="2")
{
?>
<div class="ul-widget-s6__item">
<span class="ul-widget-s6__badge">  <p class="badge-dot-success ul-widget6__dot"></p></span>
<p class="ul-widget-s6__text"><?php echo $row['fid'];?><span class="badge badge-pill badge-success m-2">Done </span></p>
<span class="ul-widget-s6__time">Updated <?php echo  $interval->format('%a');?> day ago</span>
 </div>
<?php
}
else
{
?>
<div class="ul-widget-s6__item">
<span class="ul-widget-s6__badge">  <p class="badge-dot-light ul-widget6__dot"></p></span>
<p class="ul-widget-s6__text"><?php echo $row['fid'];?><span class="badge badge-pill badge-light m-2">Not Started </span></p>
<span class="ul-widget-s6__time">Not updated yet</span>
 </div>

<?php
}
?>
 <?php
 }
 ?>
  </p>
 </div>
</div>
 <?php
 }
 ?>
 
  </div></div>
								  </div>
								 </div>
                           
							
							
                        </div>
                    </div>
				
                   
					
					
					
                                   