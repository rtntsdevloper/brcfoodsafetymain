    <?php

//  $year=$_POST['year'];
$year='';

if($year=="")
{
$year=date("Y");
}

          $date1=$year."-01-01";
          $date2=$year."-12-31";
		  
		  
		  
		  
		  
		  
    $sq=mysqli_query($con,"select distinct name  from competency3  where (cdate BETWEEN '$date1' and '$date2')  GROUP by name,qid");
    $row=mysqli_fetch_array($sq);
    $totalstudent=mysqli_num_rows($sq);
	
	$sq1=mysqli_query($con,"select distinct correct  from competency");
    $row1=mysqli_fetch_array($sq1);
    $section=mysqli_num_rows($sq1);
	
	$sq2=mysqli_query($con,"select *  from competency");
    $row2=mysqli_fetch_array($sq2);
    $question=mysqli_num_rows($sq2);
	
	

require('tcpdf/tcpdf.php');
// create new PDF document

class MYPDF extends TCPDF 
{
 
		  
private $longTableFooter = '';


  public function Header() 
	{
	
	    $image_file = 'images/1.png';
		$image_file1 = 'images/rtnts.png';
        $this->Image($image_file, 15, 5, 20, '', 'PNG', '', 'T', false, 200, '', false, false, 0, false, false, false);
		 $this->Image($image_file1, 183, 4, 30, '', 'PNG', '', 'T', false, 200, '', false, false, 0, false, false, false);
		$this->SetFont('nunitolight', '', 20);
		
		$this->SetXY(75,0);
		$this->Write(25,'FSC SURVEY TRENDING', '', 0, '10', true, 0, false, false, 0);
		
	
  }
  

   
	 public function Footer() 
	  {
	  $this->SetFont('nunitolight', '',8);
       $this->writeHTML($this->longTableFooter);
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

$pdf->SetMargins(PDF_MARGIN_LEFT, 35,PDF_MARGIN_RIGHT);

$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);




if (@file_exists(dirname(__FILE__).'/lang/eng.php')) 
{
   require_once(dirname(__FILE__).'/lang/eng.php');
  
   $pdf->setLanguageArray($l);
}

$pdf->AddPage();
$pdf->SetFont('nunitolight', '', 12);

$pdf->SetFont('nunitolight', '', 11);
$tbl_header = '<style>
table {
   
   border-spacing: 0;
}
tr {
 
}

th {
      background-color:#F0F0F0;
 border-bottom: 1px solid #000000;
   color: #000000;
  
   font-size: 14px;
  
   padding-bottom: 4px;
 
   text-align: left;
}
td 
{
  background-color: #FFFFFF;
   font-size: 12px;
   color: #000000;
}
</style>
<table id="gallerytab" width="950" cellspacing="0"  border="0">';
$tbl_footer = '</table>';

$a=mysqli_query($con,"select * from competency3 where correct='Leadership and vision' and status=1 and (cdate BETWEEN '$date1' and '$date2')  GROUP by name,qid");
$a1=mysqli_num_rows($a);
echo $a1;

$aa=mysqli_query($con,"select * from competency where correct='Leadership and vision' ");
$aa1=mysqli_num_rows($aa);

$totalmatch=$aa1*5*$totalstudent;


$totalpass1=$aa1*5*$totalstudent;
$totalfail1=$a1*5;

$tf1=$totalpass1-$totalfail1;

$totalpass=$aa1*5*$totalstudent;
$totalfail=$a1*5;

$totalpass=round($totalpass/$totalmatch*100);
$totalfail=round($totalfail/$totalmatch*100);

$xc = 195;
$yc = 115;
$r = 15;

$n=0;

if($totalfail!=0)
{
$n=$n+1;
}

if($totalpass!=0)
{
$n=$n+1;
}

$totalpercent=$totalfail+$totalpass;
if($totalpercent<100)
{

$t1=100-$totalpercent;
$t2=$t1/$n;

}

if(!isset($t2)){
  $t2 =0;
}



if($totalfail!=0)
{
$totalfail=$totalfail+$t2;
}

if($totalpass!=0)
{
$totalpass=$totalpass+$t2;
}

$acritical2=$totalfail/100*360;
$amajor2=$totalpass/100*360;

$finalmajor=$acritical2+$amajor2;


$pdf->SetFillColor(255,0,0);
$pdf->PieSector($xc, $yc, $r, 0, $amajor2, 'FD', false, 0, 2);

$pdf->SetFillColor(138,214,105);
$pdf->PieSector($xc, $yc, $r, $amajor2,$finalmajor, 'FD', false, 0, 2);


$pdf->SetXY(165,132);

$tbll=<<<EOD

<table width="280" border="0" style="border:1px solid #000000; font-size:12px" cellpadding="2">

<tr nobr="true">
  <td width="5"></td>
    <td ></td>
    <td ></td>

  </tr>
  
   
  <tr nobr="true">
    <td ></td>
    <td width="40"><div bgcolor="#8AD669" style="width:15px;  background:#8AD669;"></div></td>
    <td  width="150">Satisfactory [$totalfail1]</td>
   </tr>
   
   <tr nobr="true">
    <td></td>
    <td width="40"><div bgcolor="#FA0000" style="width:15px; background:#FA0000;"></div></td>
    <td width="150" >Unsatisfactory[$tf1] </td>
   </tr>
  
   </table>
EOD;

$pdf->writeHTML($tbll, true, false, true, false, '');


$ap=mysqli_query($con,"select *  from competency3 where correct='Workplace' and status=1 and (cdate BETWEEN '$date1' and '$date2')  GROUP by name,qid");
$a1p=mysqli_num_rows($ap);

$aap=mysqli_query($con,"select *  from competency where correct='Workplace'");
$aa1p=mysqli_num_rows($aap);

$totalmatchp=$aa1p*5*$totalstudent;

$totalpass1p=$aa1p*5*$totalstudent;
$totalfail1p=$a1p*5;

$tf2=$totalpass1p-$totalfail1p;


$totalpassp=$aa1p*5*$totalstudent;
$totalfailp=$a1p*5;

$totalpassp=round($totalpassp/$totalmatchp*100);
$totalfailp=round($totalfailp/$totalmatchp*100);


$xcp = 195;
$ycp = 174;
$rp = 10;

$np=0;


if($totalfailp!=0)
{
$np=$np+1;
}

if($totalpassp!=0)
{
$np=$np+1;
}



$totalpercentp=$totalfailp+$totalpassp;
if($totalpercentp<100)
{

$t1p=100-$totalpercentp;
$t2p=$t1p/$np;
}
if(!isset($t2p)){
  $t2p=0;
}

if($totalfailp!=0)
{
$totalfailp=$totalfailp+$t2p;
}

if($totalpassp!=0)
{
$totalpassp=$totalpassp+$t2p;
}

$acritical2p=$totalfailp/100*360;
$amajor2p=$totalpassp/100*360;

$finalmajorp=$acritical2p+$amajor2p;


$pdf->SetFillColor(255,128,0);
$pdf->PieSector($xcp, $ycp, $rp, 0, $amajor2p, 'FD', false, 0, 2);

$pdf->SetFillColor(214,218,35);
$pdf->PieSector($xcp, $ycp, $rp, $amajor2p,$finalmajorp, 'FD', false, 0, 2);


$pdf->SetXY(165,187);

$tbllp=<<<EOD

<table width="280" border="0" style="border:1px solid #000000; font-size:9px;">

<tr nobr="true">
  <td width="5"></td>
    <td ></td>
    <td ></td>
  </tr>
 
   
  <tr nobr="true">
    <td ></td>
    <td width="40" ><div bgcolor="#D6DA23" style="width:15px;  background:#D6DA23;"></div></td>
    <td  width="150"> Satisfactory [$totalfail1p]</td>
   </tr>
   
   
    <tr nobr="true">
    <td></td>
    <td width="40"><div bgcolor="#FF8000" style="width:15px; background:#FA0000;"></div></td>
    <td width="150" > Unsatisfactory [$tf2] </td>
   </tr>
  
   </table>
EOD;

$pdf->writeHTML($tbllp, true, false, true, false, '');


$ja=mysqli_query($con,"select * from competency3 where correct='Staff Knowledge and Actions' and status=1 and (cdate BETWEEN '$date1' and '$date2')  GROUP by name,qid");
$ja1=mysqli_num_rows($ja);

$jaa=mysqli_query($con,"select * from competency where correct='Staff Knowledge and Actions'");
$jaa1=mysqli_num_rows($jaa);

$jtotalmatch=$jaa1*5*$totalstudent;

$jtotalpass1=$jaa1*5*$totalstudent;
$jtotalfail1=$ja1*5;

$tf3=$jtotalpass1-$jtotalfail1;

$jtotalpass=$jaa1*5*$totalstudent;
$jtotalfail=$ja1*5;

$jtotalpass=round($jtotalpass/$jtotalmatch*100);
$jtotalfail=round($jtotalfail/$jtotalmatch*100);


$jxc = 195;
$jyc = 217;
$jr = 10;

$jn=0;


if($jtotalfail!=0)
{
$jn=$jn+1;
}

if($jtotalpass!=0)
{
$jn=$jn+1;
}



$jtotalpercent=$jtotalfail+$jtotalpass;
if($jtotalpercent<100)
{

$jt1=100-$jtotalpercent;
$jt2=$jt1/$jn;
}
if(!isset($jt2)){
  $jt2 =0;
}
if($jtotalfail!=0)
{
$jtotalfail=$jtotalfail+$jt2;
}

if($jtotalpass!=0)
{
$jtotalpass=$jtotalpass+$jt2;
}



$jacritical2=$jtotalfail/100*360;
$jamajor2=$jtotalpass/100*360;

$jfinalmajor=$jacritical2+$jamajor2;


$pdf->SetFillColor(245,234,3);
$pdf->PieSector($jxc, $jyc, $jr, 0, $jamajor2, 'FD', false, 0, 2);

$pdf->SetFillColor(0,128,192);
$pdf->PieSector($jxc, $jyc, $jr, $jamajor2,$jfinalmajor, 'FD', false, 0, 2);


$pdf->SetXY(165,229);

$jtbll=<<<EOD

<table width="280" border="0" style="border:1px solid #000000; font-size:9px" cellpadding="2">

<tr nobr="true">
  <td width="5"></td>
    <td ></td>
    <td ></td>
  </tr>
  
   
  <tr nobr="true">
    <td ></td>
    <td width="40" ><div bgcolor="#0080C0" style="width:15px; background:#0080C0;"></div></td>
    <td  width="150">Satisfactory [$jtotalfail1]</td>
   </tr>
   <tr nobr="true">
    <td></td>
    <td width="40"><div bgcolor="#F5EA03" style="width:15px;  background:#F5EA03;"></div></td>
    <td width="150" >Unsatisfactory[$tf3] </td>
   </tr>
  
   </table>
EOD;

$pdf->writeHTML($jtbll, true, false, true, false, '');


$tbl_header = '<style>
table 
{
   border-spacing: 0;
}
tr 
{
   padding: 3px 0;
}

th 
{ background-color: #EAEAEA;
   
  border: 1px solid #000000;
   color: #000000;
 
   text-align: left;
}
td {
  background-color:#FFFFFF;
   border: 1px solid #000000;
   font-size: 12px;
   color: #000000;
   text-align: center;
}
</style>
<table id="gallerytab" width="730" cellspacing="0" cellpadding="5" border="0" >
';
$tbl_footer = '</table>';
		
		
$pdf->SetXY(15,25);
		 
$tbl = '';	 
$tbl.= '
   
      <tr>
        <th >Total section</th>
        <td >'.$section.'</td>
      </tr>
      <tr>
        <th>Total no of questions</th>
        <td>'.$question.'</td>
      </tr>
	  <tr>
        <th>Total no of questionnaires received</th>
        <td>'.$totalstudent.'</td>
      </tr>
     </table>';
	 
	 $pdf->writeHTML(utf8_encode($tbl_header . $tbl . $tbl_footer), true, false, true, false, '');
	
	
	$pdf->SetXY(15,55);
	
	
	$tbl2 = '';	 
		 
 $tbl2.= '
         <tr>
        <th >Sections</th>
        <th>Score per question</th>
        <th>Allocated Total score of questionnaires</th>
		<th>Total staff completed questionnaires</th>
        <th>Score received as per completed</th>
         </tr>';
	  
	      
	       $sq1=mysqli_query($con,"select distinct correct  from competency");
           while($row1=mysqli_fetch_array($sq1))
	        {
		     $query=mysqli_query($con,"select * from competency where correct='$row1[correct]'");
		     $query1=mysqli_num_rows($query)*5;
		    
		     $sq6=mysqli_query($con,"select * from competency3 where correct='$row1[correct]' and status=1 and (cdate BETWEEN '$date1' and '$date2')  GROUP by name,qid");
			 $sq7=mysqli_num_rows($sq6);
             
			 $match7=$sq7*5;
	           
             $tbl2.= ' <tr >
              <td > '.$row1['correct'].' </td>
              <td> 5 </td>
              <td>'. $query1.'</td>
			  <td>'. $totalstudent.'</td>
              <td>'.$match7.'</td>
              </tr>';
      
	           }
	         
           $tbl2.= ' </table>';
		   
		    $pdf->writeHTML(utf8_encode($tbl_header . $tbl2 . $tbl_footer), true, false, true, false, '');



$pdf->SetXY(12,100);
		$tbl3 = '';	 
		 
 
		   $tbl3.= '
		    <table width="500" cellspacing="0" cellpadding="4" border="0" >
            <tr>
             <th>Leadership and vision</th>
             <th>Score per question</th>
             <th>Total score of question</th>
             <th>Score received as per completed</th>
           </tr>';
		   
			 $sq13=mysqli_query($con,"select * from competency where correct='Leadership and vision'");
             while($row1=mysqli_fetch_array($sq13))
	         {
			 
		     $sq6=mysqli_query($con,"select distinct name from competency3 where qid='$row1[id]' and status=1 and (cdate BETWEEN '$date1' and '$date2')  GROUP by name,qid");
			 $sq8=mysqli_num_rows($sq6);
			 $matchs=$sq8*5;
			 $total=$totalstudent*5;
			
			$tbl3.= ' <tr>
              <td >'.$row1['id'].'</td>
              <td> 5 </td>
               <td>'.$total.'</td>
              <td>'. $matchs.'</td>
              
</tr>';

}
	  $tbl3.= ' </table>';
            

		$pdf->writeHTML(utf8_encode($tbl_header . $tbl3 . $tbl_footer), true, false, true, false, '');
		
	
	
	$pdf->SetXY(12,165);
		$tbl4 = '';	 
		 
 
		   $tbl4.= '
		    <table width="500" cellspacing="0" cellpadding="4" border="0" >
            <tr>
             <th>Workplace</th>
             <th>Score per question</th>
             <th>Total score of question</th>
             <th>Score received as per completed</th>
           </tr>';
		   
			 $sq139=mysqli_query($con,"select * from competency where correct='Workplace'");
             while($row19=mysqli_fetch_array($sq139))
	         {
			 
		     $sq69=mysqli_query($con,"select distinct name from competency3 where qid='$row19[id]' and status=1 and (cdate BETWEEN '$date1' and '$date2')  GROUP by name,qid");
			 $sq89=mysqli_num_rows($sq69);
			 $matchs9=$sq89*5;
			 $total=$totalstudent*5;
			
			$tbl4.= ' <tr>
              <td >'.$row19['id'].'</td>
              <td> 5 </td>
               <td>'.$total.'</td>
              <td>'. $matchs9.'</td>
              
</tr>';

}
	  $tbl4.= ' </table>';
            

		$pdf->writeHTML(utf8_encode($tbl_header . $tbl4 . $tbl_footer), true, false, true, false, '');
		
		
			
			$pdf->SetXY(12,210);
		$tbl5 = '';	 
		 
 
		   $tbl5.= '
		    <table width="500" cellspacing="0" cellpadding="4" border="0" >
            <tr>
             <th>Staff Knowledge and Actions</th>
             <th>Score per question</th>
             <th>Total score of question</th>
             <th>Score received as per completed</th>
           </tr>';
		   
			 $sq17=mysqli_query($con,"select * from competency where correct='Staff Knowledge and Actions'");
             while($row7=mysqli_fetch_array($sq17))
	         {
			 
		     $sq7=mysqli_query($con,"select distinct name from competency3 where qid='$row7[id]' and status=1 and (cdate BETWEEN '$date1' and '$date2')  GROUP by name,qid");
			 $sq77=mysqli_num_rows($sq7);
			 $matchs7=$sq77*5;
			 $total=$totalstudent*5;
			
			$tbl5.= ' <tr>
              <td >'.$row7['id'].'</td>
              <td> 5 </td>
               <td>'.$total.'</td>
              <td>'. $matchs7.'</td>
              
</tr>';

}
	  $tbl5.= ' </table>';
            
		$pdf->writeHTML(utf8_encode($tbl_header . $tbl5 . $tbl_footer), true, false, true, false, '');
		

$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "brcfoodsafety/upl1/FSCSURVEY-TRENDING.pdf","F");		 
		 
?>

	 <div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Home</a></li>
                        <li>FSCSURVEY TRENDING </li>
                    </ul>
					 </div>
					   <div class="card-body">
					    <div class="col-md-12">
                           <div class="page_title">
                                <form name="form1" method="post" action="admin?id=fscsurveytrendings"> 
								<div class="row" >
	                 
			
											
											
											<div class="col-md-3">
												<div class="form-group label-floating">
													<label class="control-label" id="error2">Enter Year</label>
					<input type="text" name="year" id="year" class="form-control" />
												</div>
	                                        </div>
							 
							 
							 
							 <div class="col-md-3">
												<div class="form-group label-floating">
												
												<br/>
													<button class="btn btn-danger" type="submit">Select & Go</button>
												</div>
	                                        </div>  </div>  </div>  </div>  </div>
               
				
				</form>
				
				
				
				  <div class="row mb-12" id="des">
                    <div class="col-md-12 mb-12">
                        <div class="card text-left">
                            <div class="card-body">
							
							 <a href="upl1/FSCSURVEY-TRENDING.pdf" target="_blank">
 <button class="btn btn-warning" style="float:right">View Report</button></a>

</br></br>
                             
 
 
							  <div class="col-lg-12 col-md-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="card-title">Food Safety Culture Questionnaire</div>
                                <div id="echartBar" style="height: 300px;"></div>
                            </div>
                        </div>
                    </div>
				<div class="content">
                              <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
            <tr>
              <td colspan="5" ><div align="center" class="style1">Section 1: Leadership and vision</div></td>
             
            </tr>
            <tr>
             <td >Sno</td>
            
             <td >Question</td>
              <td>Option A</td>
			   <td>Option B</td>
			    <td>Option C</td>
           </tr>
		   <?php
		   include 'connection.php';
		   $df=mysqli_query($con,"select * from competency where correct='Leadership and vision'");
		   $i=0;
		   while($df2=mysqli_fetch_array($df))
		   {
		   $i++;
		   
		   $ghy=mysqli_query($con,"select * from competency3 where qid='$df2[id]' and ans='$df2[ansa]' and (cdate BETWEEN '$date1' and '$date2')  GROUP by name,qid");
		   $ghy1=mysqli_num_rows($ghy);
		   
		     $ghh=mysqli_query($con,"select * from competency3 where qid='$df2[id]' and ans='$df2[ansb]' and (cdate BETWEEN '$date1' and '$date2')  GROUP by name,qid");
		   $ghh1=mysqli_num_rows($ghh);
		   
		     $ghhh=mysqli_query($con,"select * from competency3 where qid='$df2[id]' and ans='$df2[ansc]' and (cdate BETWEEN '$date1' and '$date2')  GROUP by name,qid");
		   $ghhh1=mysqli_num_rows($ghhh);
		   ?>
		    <tr>
             <td ><?php echo $i;?></td>
          
             <td><?php echo $df2['ques'];?></td>
             <td ><?php echo $ghy1;?></td>
			 <td ><?php echo $ghh1;?></td>
			 <td ><?php echo $ghhh1;?></td>
           </tr>
		   <?php
		   }
		   ?>
		   </table>
		   
		   
		   
		   
                            </div>
							
							
							     <div class="content">
                              <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
            <tr>
              <td colspan="5" ><div align="center" class="style1">Section 2: Workplace</div></td>
             
            </tr>
            <tr>
             <td >Sno</td>
            
             <td >Question</td>
              <td>Option A</td>
			   <td>Option B</td>
			    <td>Option C</td>
           </tr>
		   <?php
		   include 'connection.php';
		   $df=mysqli_query($con,"select * from competency where correct='Workplace'");
		   $i=0;
		   while($df2=mysqli_fetch_array($df))
		   {
		   $i++;
		   
		   $ghy=mysqli_query($con,"select * from competency3 where qid='$df2[id]' and ans='$df2[ansa]' and (cdate BETWEEN '$date1' and '$date2')  GROUP by name,qid");
		   $ghy1=mysqli_num_rows($ghy);
		   
		     $ghh=mysqli_query($con,"select * from competency3 where qid='$df2[id]' and ans='$df2[ansb]' and (cdate BETWEEN '$date1' and '$date2')  GROUP by name,qid");
		   $ghh1=mysqli_num_rows($ghh);
		   
		     $ghhh=mysqli_query($con,"select * from competency3 where qid='$df2[id]' and ans='$df2[ansc]' and (cdate BETWEEN '$date1' and '$date2')  GROUP by name,qid");
		   $ghhh1=mysqli_num_rows($ghhh);
		   ?>
		    <tr>
             <td ><?php echo $i;?></td>
          
             <td><?php echo $df2['ques'];?></td>
             <td ><?php echo $ghy1;?></td>
			 <td ><?php echo $ghh1;?></td>
			 <td ><?php echo $ghhh1;?></td>
           </tr>
		   <?php
		   }
		   ?>
		   </table>
		   
		   
		   
		   
                            </div>
							
							
							  <div class="content">
                              <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
            <tr>
              <td colspan="5" ><div align="center" class="style1">Section 3: Staff Knowledge and Actions</div></td>
              
           
            </tr>
            <tr>
             <td>Sno</td>
            
             <td >Question</td>
              <td>Option A</td>
			   <td>Option B</td>
			    <td>Option C</td>
           </tr>
		   <?php
		   include 'connection.php';
		   $df=mysqli_query($con,"select * from competency where correct='Staff Knowledge and Actions'");
		   $i=0;
		   while($df2=mysqli_fetch_array($df))
		   {
		   $i++;
		   
		   $ghy=mysqli_query($con,"select * from competency3 where qid='$df2[id]' and ans='$df2[ansa]' and (cdate BETWEEN '$date1' and '$date2')  GROUP by name,qid");
		   $ghy1=mysqli_num_rows($ghy);
		   
		     $ghh=mysqli_query($con,"select * from competency3 where qid='$df2[id]' and ans='$df2[ansb]' and (cdate BETWEEN '$date1' and '$date2')  GROUP by name,qid");
		   $ghh1=mysqli_num_rows($ghh);
		   
		     $ghhh=mysqli_query($con,"select * from competency3 where qid='$df2[id]' and ans='$df2[ansc]' and (cdate BETWEEN '$date1' and '$date2')  GROUP by name,qid");
		   $ghhh1=mysqli_num_rows($ghhh);
		   ?>
		    <tr>
             <td ><?php echo $i;?></td>
          
             <td><?php echo $df2['ques'];?></td>
             <td ><?php echo $ghy1;?></td>
			 <td ><?php echo $ghh1;?></td>
			 <td ><?php echo $ghhh1;?></td>
           </tr>
		   <?php
		   }
		   ?>
		   </table>
		   
		   
		   
		   
                            </div>
					
					</div></div></div>
	    <script src="dist-assets/js/plugins/echarts.min.js"></script>
   <script language="javascript">
   "use strict";
   

$(document).ready(function () {
  // Chart in Dashboard version 1
  var echartElemBar = document.getElementById('echartBar');

  if (echartElemBar) {
    var echartBar = echarts.init(echartElemBar);
    echartBar.setOption({
      legend: {
        borderRadius: 0,
        orient: 'horizontal',
        x: 'right',
        data: ['Allocated total score of questionnaires', 'Score received as per questionnaires']
      },
      grid: {
        left: '8px',
        right: '8px',
        bottom: '0',
        containLabel: true
      },
      tooltip: {
        show: true,
        backgroundColor: 'rgba(0, 0, 0, .8)'
      },
      xAxis: [{
        type: 'category',
        data: ['Leadership and vision', 'Workplace', 'Staff Knowledge and Actions'],
        axisTick: {
          alignWithLabel: true
        },
        splitLine: {
          show: false
        },
        axisLine: {
          show: true
        }
      }],
      yAxis: [{
        type: 'value',
        axisLabel: {
          formatter: '{value}'
        },
        min: 0,
        max: <?php echo $totalpass1;?>,
        interval: 25000,
        axisLine: {
          show: false
        },
        splitLine: {
          show: true,
          interval: 'auto'
        }
      }],
      series: [{
        name: 'Allocated total score of questionnaires',
        data: [<?php echo $totalpass1;?>, <?php echo $totalpass1p;?>,<?php echo $jtotalpass1;?>],
        label: {
          show: false,
          color: '#0168c1'
        },
        type: 'bar',
        barGap: 0,
        color: '#bcbbdd',
        smooth: true,
        itemStyle: {
          emphasis: {
            shadowBlur: 10,
            shadowOffsetX: 0,
            shadowOffsetY: -2,
            shadowColor: 'rgba(0, 0, 0, 0.3)'
          }
        }
      }, {
        name: 'Score received as per questionnaires',
        data: [<?php echo $totalfail1;?>, <?php echo $totalfail1p;?>,<?php echo $jtotalfail1;?>],
        label: {
          show: false,
          color: '#639'
        },
        type: 'bar',
        color: '#7569b3',
        smooth: true,
        itemStyle: {
          emphasis: {
            shadowBlur: 10,
            shadowOffsetX: 0,
            shadowOffsetY: -2,
            shadowColor: 'rgba(0, 0, 0, 0.3)'
          }
        }
      }]
    });
    $(window).on('resize', function () {
      setTimeout(function () {
        echartBar.resize();
      }, 500);
    });
  } // Chart in Dashboard version 1
 

});
</script>
