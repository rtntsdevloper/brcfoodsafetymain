
  <?php
include 'connection.php';
ini_set('max_execution_time', 600);
ini_set('memory_limit','-1');

$month=$_GET['month'];
 $year=$_GET['year'];

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


// $ghy=mysqli_query($con,"select * from tblauditsection where name='GMP Audit'");
// $ghy1=mysqli_fetch_array($ghy);
	
//  $sid=$ghy1['id'];
		   

// $compliant11="";
// $major11="";
// $minor11="";

// $majorr=mysqli_query($con,"select t1.*,t2.* from tblroster t1, saveaudit t2 where t2.sno=t1.id and (t1.date BETWEEN '$date1' and '$date2') and t2.ans='Major'");
// $major11=mysqli_num_rows($majorr);


// $minorr=mysqli_query($con,"select t1.*,t2.* from tblroster t1, saveaudit t2 where t2.sno=t1.id and (t1.date BETWEEN '$date1' and '$date2') and t2.ans='Minor'");
// $minor11=mysqli_num_rows($minorr);


// $compliantr=mysqli_query($con,"select t1.*,t2.* from tblroster t1, saveaudit t2 where t2.sno=t1.id and (t1.date BETWEEN '$date1' and '$date2') and t2.ans='Compliant'");
// $compliant11=mysqli_num_rows($compliantr);

// $criticalr=mysqli_query($con,"select t1.*,t2.* from tblroster t1, saveaudit t2 where t2.sno=t1.id and (t1.date BETWEEN '$date1' and '$date2') and t2.ans='Critical'");
// $criticall=mysqli_num_rows($criticalr);



// $total1= $compliant11+$major11+$minor11+$criticall;

// $compliant2=$compliant11/$total1*100;
// $compliant22=round($compliant11/$total1*100);


// $major22=round($major11/$total1*100);
// $major2=$major11/$total1*100;

// $minor22=round($minor11/$total1*100);
// $minor2=$minor11/$total1*100;


// $critical22=round($criticall/$total1*100);
// $critical2=$criticall/$total1*100;




		   

// require('tcpdf/tcpdf.php');




// ini_set('max_execution_time', 300);
// // create new PDF document
// class MYPDF extends TCPDF {

//     public function Header() {
//        $image_file = 'images/1.png';
//         $this->Image($image_file, 10, 5, 30, '', 'PNG', '', 'T', false, 200, '', false, false, 0, false, false, false);
     
	 
// 	  $image_file1 = 'images/rtnts.png';
//         $this->Image($image_file1, 250, 5, 40, '', 'PNG', '', 'T', false, 200, '', false, false, 0, false, false, false);
        
//     }

//     public function Footer() {
//         $this->SetY(-15);
//         $this->SetFont('centurygothic', 'I', 8);
//         $this->Cell(25, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
		      
//     }
// }


// $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


// $pdf->SetCreator(PDF_CREATOR);

// $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
// $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// $pdf->SetMargins(10, 30, PDF_MARGIN_RIGHT);$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
// $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);


// $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);


// $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


// if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
//     require_once(dirname(__FILE__).'/lang/eng.php');
//     $pdf->setLanguageArray($l);
// }

// $pdf->SetFont('centurygothic', 'B', 12);

// $pdf->AddPage('L');
// $pdf->SetXY(135,8);
// $pdf->Write(0, "Internal System Audit - KPI", '', '0', '0', true, 'C', false, false, 0);
// $pdf->SetXY(120,19);
// $pdf->Write(0, "From: ". $d1." To: ".$d2 , '', '0', '0', true, 'C', false, false, 0);


// $pdf->SetFont('centurygothic', '',10);

// $pdf->SetXY(10,30);
// $html =
// '<div bgcolor="#63C315" style="width:950px; height:20px;font-size:16px;color:#000000">Non-Conformance Summary</div>';

// $pdf->writeHTML($html, true, false, true, false, '');



// $pdf->Write(0, "  ", '', '0', '0', true, 'C', false, false, 0);
// $xc =235;
// $yc = 80;
// $r = 20;

// $n=0;

// if($critical2!=0)
// {
// $n=$n+1;
// }


// if($major2!=0)
// {
// $n=$n+1;
// }

// if($minor2!=0)
// {
// $n=$n+1;
// }

// if($compliant2!=0)
// {
// $n=$n+1;
// }

// $totalpercent=$major2+$minor2+$compliant2+$critical2;
// if($totalpercent<100)
// {

// $t1=100-$totalpercent;
// $t2=$t1/$n;
// }
// if($critical2!=0)
// {
// $critical2=$critical2+$t2;
// }
// if($major2!=0)
// {
// $major2=$major2+$t2;
// }
// if($minor2!=0)
// {
// $minor2=$minor2+$t2;
// }

// if($compliant2!=0)
// {
// $compliant2=$compliant2+$t2;
// }

// $acritical2=$critical2/100*360;
// $amajor2=$major2/100*360;
// $aminor2=$minor2/100*360;
// $acompliant2=$compliant2/100*360;

// $finalmajor=$amajor2+$acritical2;
// $finalminor=$amajor2+$aminor2;
// $finalcompliant=$finalminor+$acompliant2;
// $finalcontrol=$finalcompliant+$finalmajor;



// $pdf->SetFillColor(37, 87, 143);
// $pdf->PieSector($xc, $yc, $r, 0, $acritical2, 'FD', false, 0, 2);


// $pdf->SetFillColor(209, 31, 41);
// $pdf->PieSector($xc, $yc, $r,  $acritical2, $finalmajor, 'FD', false, 0, 2);

// $pdf->SetFillColor(243, 159, 44);
// $pdf->PieSector($xc, $yc, $r, $finalmajor, $finalminor, 'FD', false, 0, 2);

// $pdf->SetFillColor(73, 153, 67);
// $pdf->PieSector($xc, $yc, $r, $finalminor, $finalcompliant, 'FD', false, 0, 2);


// $pdf->SetFillColor(209, 31, 41);
// $pdf->PieSector($xc, $yc, $r, $finalcompliant, $finalcontrol, 'FD', false, 0, 2);

// $pdf->SetXY(260,60);

// $tbl=<<<EOD

// <table width="90" border="0" style="font-family:calibri;border:1px solid #000000;">
// <tr nobr="true">
//   <td width="5"></td>
//     <td width="20" height="5"></td>
//     <td width="80" height="5"></td>
//   </tr>
 
   
//   <tr nobr="true">
//     <td width="5"></td>
//     <td width="20" height="15"><div bgcolor="#25578F" style="width:15px; height:15px; background:#25578F;margin-top:5px;"></div></td>
//     <td width="80" height="15" style="padding:10px;margin-top:5px;">Critical [$critical22%]</td>
//    </tr>
   
//    <tr nobr="true">
//     <td width="5"></td>
//     <td width="20" height="15"><div bgcolor="#D11F29" align="center" style="width:15px; height:15px; background:#D11F29"></div></td>
//     <td width="80" height="15">Major [$major22%]</td>
//    </tr>
//    <tr nobr="true">
//     <td width="5"></td>
//     <td width="20" height="15"><div bgcolor="#F39F2C" align="center" style="width:15px; height:15px; background:#F39F2C"></div></td>
//     <td width="80" height="15">Minor [$minor22%]</td>
//    </tr>
//    <tr nobr="true">
//     <td width="5"></td>
//     <td width="20" height="15"><div bgcolor="#499943" align="center" style="width:15px; height:15px; background:#499943"></div></td>
//     <td width="80" height="15">Compliant [$compliant22%]</td>
//     </tr>
//    </table>
// EOD;

// $pdf->writeHTML($tbl, true, false, true, false, '');



// $pdf->SetXY(10,40);



// $tbl_header = '<style>
// table {
   
//    border-spacing: 0;
// }
// tr {
//    padding: 3px 0;
//    text-align: center;
// }

// th {
//       background-color:#F0F0F0;
//  border: 1px solid #000000;
//    color: #000000;
//    text-align: center;
// }
// td {
  
//     border: 1px solid #000000;
//    color: #000000;
//    text-align: center;
// }
// </style>
// <table id="gallerytab" width="1200" cellspacing="0" cellpadding="4" border="0">
//   ';
	
// $tbl_footer = '</table>';

// $tbl7 = '';

//   $tbl7 .= '
// <thead>
//  <tr>
// 			  <th width="50">Sno</th> 
//               <th width="80">Date</th> 
// 			  <th width="250">Section</th>
             
// 			  <th width="70">Critical</th>
//               <th width="70">Minor</th>
//               <th width="70">Major</th>
//               <th width="80">Compliant</th>
			  
//             </tr> 
// 			</thead>';
  
// $sql0=mysqli_query($con,"select t1.subject as section,t2.*,t3.*,t2.id as sd,t2.tid AS tid, t2.date as auditdate , t4.name as auditor,t5.name as auditee from addtest1 t1, tblroster t2, saveaudit t3, tblauditor t4, tblauditee t5 where (t2.date BETWEEN '$date1' and '$date2') and t3.sno=t2.id and t1.testid=t2.tid group by t2.tid");
// $i=0;
// while($rows0=mysqli_fetch_array($sql0))
// {
//   $i++;
 
// $auditdate=date("d-m-Y",strtotime($rows0['auditdate']));

// $major=mysqli_query($con,"select * from saveaudit where ans='Major' and tid='$rows0[tid]'  and sno='$rows0[sd]'");
// $major1=mysqli_num_rows($major);


// $minor=mysqli_query($con,"select * from saveaudit where ans='Minor' and tid='$rows0[tid]'  and sno='$rows0[sd]'");
// $minor1=mysqli_num_rows($minor);


// $compliant=mysqli_query($con,"select * from saveaudit where ans='Compliant' and tid='$rows0[tid]'  and sno='$rows0[sd]'");
// $compliant1=mysqli_num_rows($compliant);



// $critical=mysqli_query($con,"select * from saveaudit where ans='Critical' and tid='$rows0[tid]'  and sno='$rows0[sd]'");
// $critical1=mysqli_num_rows($critical);

//  $tbl7 .= '<tbody>
//   <tr nobr="true">
//               <td width="50">'.$i.'</td>
//               <td width="80">'.$auditdate.'</td>
// 			  <td width="250">'.$rows0['section'].'</td>
             
// 			    <td width="70">'.$critical1.'</td>
// 			   <td width="70">'.$minor1.'</td>
//               <td width="70">'.$major1.'</td>
//               <td width="80">'.$compliant1.'</td>
             
//   </tr>
//   </tbody>
//   ';
//   }
// $pdf->writeHTML($tbl_header . $tbl7 . $tbl_footer, true, false, false, false, '');

// $pdf->SetXY(10,125);

// $tbl6 = '';

//   $tbl6 .= '
// <thead>
//  <tr>
// 			  <th width="50">Sno</th> 
//               <th width="80">Date</th> 
// 			  <th width="200">Section</th>
// 			  <th width="220">Sub-Section</th>
//               <th width="70">Auditor</th>
// 			  <th width="70">Auditee</th>
// 			  <th width="70">Critical</th>
//               <th width="70">Minor</th>
//               <th width="70">Major</th>
//               <th width="80">Compliant</th>
			  
//             </tr> 
// 			</thead>';
  
// $asql0=mysqli_query($con,"select t1.subject as section,t6.subtest as subsection,t2.*,t3.*,t2.sid as sid,t2.id AS sno, t2.date as auditdate , t4.name as auditor,t5.name as auditee from addtest1 t1, tblroster t2, saveaudit t3, tblauditor t4, tblauditee t5,subtest t6 where (t2.date BETWEEN '$date1' and '$date2') and t3.sno=t2.id  and t6.sid=t2.sid and t1.testid=t2.tid and t4.id=t2.auditor and t5.id=t2.auditee group by t2.sid,t2.auditor,t2.auditee");
// $i=0;
// while($arows0=mysqli_fetch_array($asql0))
// {
//   $i++;
 
// $aauditdate=date("d-m-Y",strtotime($arows0['auditdate']));

// $amajor=mysqli_query($con,"select * from saveaudit where ans='Major' and sid='$arows0[sid]' and sno='$arows0[sno]'");
// $amajor1=mysqli_num_rows($amajor);


// $aminor=mysqli_query($con,"select * from saveaudit where ans='Minor' and sid='$arows0[sid]'  and sno='$arows0[sno]'");
// $aminor1=mysqli_num_rows($aminor);


// $acompliant=mysqli_query($con,"select * from saveaudit where ans='Compliant' and sid='$arows0[sid]'  and sno='$arows0[sno]'");
// $acompliant1=mysqli_num_rows($acompliant);


// $acritical=mysqli_query($con,"select * from saveaudit where ans='Critical' and sid='$arows0[sid]'  and sno='$arows0[sno]'");
// $acritical1=mysqli_num_rows($acritical);

//  $tbl6 .= '<tbody>
//   <tr nobr="true">
//               <td width="50">'.$i.'</td>
//               <td width="80">'.$aauditdate.'</td>
// 			  <td width="200">'.$arows0['section'].'</td>
// 			  <td width="220">'.$arows0['subsection'].'</td>
//               <td width="70">'.$arows0['auditor'].'</td>
// 			   <td width="70">'.$arows0['auditee'].'</td>
// 			    <td width="70">'.$acritical1.'</td>
// 			   <td width="70">'.$aminor1.'</td>
//               <td width="70">'.$amajor1.'</td>
//               <td width="80">'.$acompliant1.'</td>
             
//   </tr>
//   </tbody>
//   ';
//   }
// $pdf->writeHTML($tbl_header . $tbl6 . $tbl_footer, true, false, false, false, '');


// $tbl8 = '';
// $tbl8 .= '
// <thead>
//  <tr>
// 			  <th width="990">TOP NON-CONFORMANCES</th> 
//             </tr> 
// 			</thead>';
 
//   $sql3=mysqli_query($con,"select t1.ans,t1.ques, count(t1.ques) AS total,t3.clause as questionn from saveaudit t1,tblroster t2, subtest1 t3 where (t2.date BETWEEN '$date1' and '$date2') and (t1.ans!='Compliant' and t1.ans!='Not Applicable' and ans!='')  and t1.sno=t2.id  and t3.fid=t1.fid group by t1.fid");
// $j=0;
// while($rows1=mysqli_fetch_array($sql3))
// {
//   $j++;
 
//  $question=mysqli_real_escape_string($con,$rows1['questionn']);


//   $tbl8 .= ' 
//   <tr nobr="true">
//               <td width="150" style="text-align: left;color:blue">Ques '.$j.'</td>
//               <td width="840" style="text-align: left;color:blue">'.$question.'</td>
//   </tr>';
  
//   $sql4=mysqli_query($con,"select t1.ans,count(*) as t3,t3.clause as question from saveaudit t1,tblroster t2, subtest1 t3 where t1.ques='$rows1[ques]' and (t1.ans!='Compliant' and t1.ans!='Not Applicable' and t1.ans!='') and (t2.date BETWEEN '$date1' and '$date2') and t1.sno=t2.id  and t3.fid=t1.fid group by t1.ans ORDER BY t3 DESC ");
// while($rows4=mysqli_fetch_array($sql4))
// {

//   $tbl8 .= ' <tr nobr="true">
//               <td width="150" style="text-align: left;color:red">Ans</td>
//               <td width="840" style="text-align: left;color:red">'.$rows4['ans'].'-('.$rows4['t3'].') </td>
//   </tr>';
  
//   $sq7=mysqli_query($con,"select t1.notes,t3.clause as question,t3.fid as fid from saveaudit t1,tblroster t2, subtest1 t3 where t1.ques='$rows1[ques]' and (t1.ans!='Compliant' and t1.ans!='Not Applicable' and t1.ans!='') and (t2.date BETWEEN '$date1' and '$date2') and t1.ans='$rows4[ans]' and t1.sno=t2.id  and t3.fid=t1.fid");
// while($rows7=mysqli_fetch_array($sq7))
// {
// $cmt=mysqli_real_escape_string($con,$rows7['notes']);

//  $tbl8 .= '
//   <tr nobr="true">
//               <td width="150" style="text-align: left;color:black">'.$rows7['fid'].'</td>
//               <td width="840" style="text-align: left;color:black">'.$cmt.'</td>
//   </tr>';
 
//  }
//  }}
 

// $pdf->writeHTML(utf8_encode($tbl_header . $tbl8 . $tbl_footer), true, false, true, false, '');





// $pdf->Output("brcfoodsafety/gmpreport/".$d1."-".$d2."-BRC Audits KPIS.pdf","F");


// ?>


<script language="javascript">
function cal()
{

 var month=document.getElementById('month').value;
 var year=document.getElementById('year').value;
 
 if (window.XMLHttpRequest)
  {
  xmlhttp=new XMLHttpRequest();
  $(".modalk").show();
  }
else
  {
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("des").innerHTML=xmlhttp.responseText;
	$(".modalk").hide();
    }
  }
xmlhttp.open("GET","brctrending1.php?month="+month+"&year="+year,true);
xmlhttp.send();
 
}
</script>

	 <div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Home</a></li>
                        <li>Auditor Management </li>
                    </ul>
					 </div>
					   <div class="card-body">
					    <div class="col-md-12">
                           <div class="page_title">
                                  <div class="row" >
	                 
											
				 <div class="col-md-3">
				  <div class="form-group label-floating">
				   <label class="control-label" id="error2">Select Month</label>
					<select name="month"  id="month"  class="form-control" required>
					<option value="">Please Select</option>
					<option value="01">January</option>
					<option value="02">February</option>
					<option value="03">March</option>
					<option value="04">April</option>
					<option value="05">May</option>
					<option value="06">June</option>
					<option value="07">July</option>
					<option value="08">August</option>
					<option value="09">September</option>
					<option value="10">October</option>
					<option value="11">November</option>
					<option value="12">December</option>
					</select>
												</div>
	                                        </div>
											
											
											<div class="col-md-3">
												<div class="form-group label-floating">
													<label class="control-label" id="error2">Enter Year</label>
					<input type="text" name="year" id="year" class="form-control" />
												</div>
	                                        </div>
							 
							 
							 
							 <div class="col-md-3">
												<div class="form-group label-floating">
												
												<br/>
													<button class="btn btn-danger" onclick="cal()">Select & Go</button>
												</div>
	                                        </div>  </div>  </div>  </div>  </div>
               
				
				
				
				
				
				  <div class="row mb-12" id="des">
                    <div class="col-md-12 mb-12">
                        <div class="card text-left">
                            <div class="card-body">
							
							 <a href="gmpreport/<?php echo $d1;?>-<?php echo $d2;?>-BRC Audits KPIS.pdf" target="_blank">
 <button class="btn btn-warning" style="float:right">View <?php echo date("F",strtotime($date1));?> Audit KPI</button></a>


                             <h4 class="card-title mb-3">Audit KPIS</h4>
							 
							 
							 
							 
							 

<div class="table-responsive">


<table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%"><thead>
 <thead>
 <tr>
			  <th >Sno</th> 
              <th >Date</th> 
			  <th>Section</th>
			  <th>Sub-Section</th>
              <th>Auditor</th>
			  <th>Auditee</th>
			  <th>Critical</th>
              <th>Minor</th>
              <th>Major</th>
              <th>Compliant</th>
			  
            </tr> 
			</thead>
			<tbody>

			<?php
  
$asql0=mysqli_query($con,"select t1.subject as section,t6.subtest as subsection,t2.*,t3.*,t2.sid as sid,t2.id AS sno, t2.date as auditdate , t4.name as auditor,t5.name as auditee from addtest1 t1, tblroster t2, saveaudit t3, tblauditor t4, tblauditee t5,subtest t6 where (t2.date BETWEEN '$date1' and '$date2') and t3.sno=t2.id  and t6.sid=t2.sid and t1.testid=t2.tid and t4.id=t2.auditor and t5.id=t2.auditee group by t2.sid,t2.auditor,t2.auditee");
$i=0;
while($arows0=mysqli_fetch_array($asql0))
{
  $i++;
 
$aauditdate=date("d-m-Y",strtotime($arows0['auditdate']));

$amajor=mysqli_query($con,"select * from saveaudit where ans='Major' and sid='$arows0[sid]' and sno='$arows0[sno]'");
$amajor1=mysqli_num_rows($amajor);


$aminor=mysqli_query($con,"select * from saveaudit where ans='Minor' and sid='$arows0[sid]'  and sno='$arows0[sno]'");
$aminor1=mysqli_num_rows($aminor);


$acompliant=mysqli_query($con,"select * from saveaudit where ans='Compliant' and sid='$arows0[sid]'  and sno='$arows0[sno]'");
$acompliant1=mysqli_num_rows($acompliant);


$acritical=mysqli_query($con,"select * from saveaudit where ans='Critical' and sid='$arows0[sid]' and sno='$arows0[sno]'");
$acritical1=mysqli_num_rows($acritical);

?>
  <tr nobr="true">
              <td><?php echo $arows0['sid']; ?></td>
              <td><?php echo $aauditdate;?></td>
			  <td><?php echo $arows0['section'];?></td>
			  <td><?php echo $arows0['subsection'];?></td>
              <td><?php echo $arows0['auditor'];?></td>
			   <td><?php echo $arows0['auditee'];?></td>
			    <td><?php echo $acritical1;?></td>
			   <td><?php echo $aminor1;?></td>
              <td><?php echo $amajor1;?></td>
              <td ><?php echo $acompliant1;?></td>
             
  </tr>
  
  <?php
  }
  ?>
  </tbody>
</table>





 </div></div></div></div>
	  <style>
    .canvasjs-chart-credit {
        display: none !important;
    }
</style>

