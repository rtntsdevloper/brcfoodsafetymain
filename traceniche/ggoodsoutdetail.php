
				 
				  
<?php
$sno=$_GET['sno'];
$sql4=mysqli_query($con,"select * from tblgdn where id='$sno'");
$sql5=mysqli_fetch_array($sql4);


$sql6=mysqli_query($con,"select * from tblcustomer where id='$sql5[customer]'");
$sql7=mysqli_fetch_array($sql6);

?>
 <?php


$date= date('d-m-Y', strtotime($sql5['cdate']));

require('tcpdf/tcpdf.php');

ini_set('max_execution_time', 300);
// create new PDF document
class MYPDF extends TCPDF { 

private $longTableHeader = '';

private $longTableFooter = '';

    public function Header() {



      // $image_file = 'images/hbh.png';
       // $this->Image($image_file, 10, 2, 30, '', 'PNG', '', 'T', false, 200, '', false, false, 0, false, false, false);
	   
	 //  $this->write1DBarcode('.$row2['grnno'], 'C39', '82', '13', '40', 8, 0.3,'', 'N');

	   
     $this->writeHTML($this->longTableHeader);
        
    }
 public function setLongTableHeader($html)
   {
     $this->longTableHeader = $html;
   }
   public function Footer() 
	  {
	  $this->SetFont('centurygothic', '',8);
       $this->writeHTML($this->longTableFooter);
	    $this->SetY(-10);
       
        $this->Cell(328, 5, 'Printed: '.date('d-m-Y H:i A'), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	    
		 
     }
	public function setLongTableFooter($html) {
$this->longTableFooter = $html;
}
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);

$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->SetMargins(5, 35, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);


$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);


$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

$pdf->SetFont('centurygothic', 'B', 14);


$pdf->AddPage();


$footer=<<<EOD

<table border="1"  width="100%" border="0.5" cellpadding="3">
  <tr>
  <td style="text-align:center">Version: 01 </td>
  <td style="text-align:center; padding-top:15px;">Issue Date. 12/09/24</td>
  <td style="text-align:center; padding-top:15px;">Approved by: Paramvir S. Deol</td>
  <td style="text-align:center; padding-top:15px;"></td>
  </tr>
</table>
EOD;
$pdf->setLongTableFooter($footer);



$pdf->SetXY(75,10);
//$pdf->Write(0, "GOODS RECIEVED NOTE", '', '0', '0', true, 'C', false, false, 0);
//$pdf->write1DBarcode($row2[grnno], 'C39', 'fromleft', 'from top', 'width', height, 0.3,'', 'N');
//$pdf->write1DBarcode($row2['grnno'], 'C39', '82', '13', '40', 8, 0.3,'', 'N');

$pdf->SetFont('centurygothic', 'B', 11);

$htmll ="";
$params = $pdf->serializeTCPDFtagParameters(array($sql5['gdn'], 'C39', '83', '13', '40', 8, 0.3,'', 'N'));
$htmll .= '<tcpdf method="write1DBarcode" params="'.$params.'" />';

$pdf->SetXY(5,5);
$tble11=<<<EOD
<table width="481" border="0"  >
<tr>
<td width="250"><img src="images/1.png" width="100"></td>
<td width="250">

<table border="1" >
<tr> 
<td width="198">
<table border="0"  style="text-align:center" >

<tr>
<td >GOODS DESPATCH NOTE</td>
</tr>
<tr>
<td >$htmll </td>
</tr>

<tr>
<td>$sql5[gdn]</td>
</tr>
</table>

</td>
</tr>

</table>

</td>
</tr>
</table>
EOD;
$pdf->writeHTML($tble11, true, false, true, false, '');
$pdf->setLongTableHeader($tble11);

$pdf->SetFont('centurygothic', '',12);

$pdf->SetXY(5,35);

$tble7=<<<EOD
<table width="800" border="0" style="font-weight:bold; font-size:12px " cellpadding="2">
 
  <tr>
    <td width="520">Goods Despatch Note No : $sql5[gdn] </td>
  </tr>
 
  <tr>
    <td>Date:$date </td>
   
  </tr>

  </table>
EOD;
$pdf->writeHTML($tble7, true, false, true, false, '');

$pdf->SetFont('centurygothic', '',8);




$pdf->SetXY(5,55);



$string = $sql5['ques'];
$tags = explode(';' , $string);

  

$tble9=<<<EOD
<table width="750" border="1" cellpadding="6">
  <tr>
    <td width="350">Is it clean & tidy? <span style="font-size:13px;color:green"> $tags[0]</span></td>
    <td width="350">Are there any spillages/strong odours?: <span style="font-size:13px;color:green"> $tags[1] </span></td>
  </tr>

  <tr>
    <td width="350">Any pest evidence ? <span style="font-size:13px;color:green"> $tags[2] </span> </td>
    <td width="350">Any contamination risk (opened product/pack)? <span style="font-size:13px;color:green"> $tags[3] </span></td>
  </tr>
 
 
 
  </table>
EOD;
$pdf->writeHTML($tble9, true, false, true, false, '');



$pdf->SetXY(5,75);


$tbl_header = '<style>
table {
   border-spacing: 0;
}
tr {
   padding: 3px 0;
}

th {
      background-color:#F0F0F0;
 border: 1px solid #000000;
   color: #000000;
   text-align: center;
}
td {
  
    border: 1px solid #000000;
   color: #000000;
   text-align: center;
}
</style>
<table id="gallerytab" width="800" cellspacing="0" cellpadding="4" border="0">
  ';
	
$tbl_footer = '</table>';

$tbl7 = '';
$tbl7 .= '
<thead>
  <tr>
    <th width="40">Sno</th>
	 <th width="70">Date</th>
	 <th width="70">Customer</th>
	  <th width="70">Brand</th>
	   <th width="150" >Product</th>
		 <th width="80" >Quantity</th>
		    <th width="80" >Use By</th>
		   <th width="120" >GDN Batchcode</th>
  </tr>
  </thead>
  ';
  $sql2=mysqli_query($con,"select t1.cid, t1.prodname AS pname, t2.name as custname, t3.*,t3.cdate AS cdte, t4.*, t4.qty AS c1 ,t4.id as sno1 ,t5.name as bname from tblgoodsoutproduct t1, tblcustomer t2, tblgdn t3 , tblgdn1 t4,tblbrand t5 where t1.id=t4.product and t2.id=t3.customer and t3.gdn=t4.gdn  and t3.id='$sno' and t5.id=t4.brandname");

$i=0;
while($row5=mysqli_fetch_array($sql2))
{
  $i++;
							
	$ub=date('d-m-Y', strtotime($row5['cdte']));
			$ub1=date('d-m-Y', strtotime($row5['useby']));									
						
  $tbl7 .= '
  <tbody>
  <tr nobr="true">
    <td  width="40" >'.$i.'</td>
	<td  width="70" >'.$ub.'</td>
	  <td  width="70">'.$row5['custname'].'</td>
	    <td  width="70">'.$row5['bname'].'</td>
	   <td  width="150">'.$row5['pname'].'</td>
		 <td width="80">'.$row5['c1'].'</td>
		 <td width="80">'.$ub1.'</td>
		   <td width="120">'.$row5['batchcode'].'</td>
  </tr>
  </tbody>
  ';
  }
  
  $pdf->writeHTML($tbl_header . $tbl7 . $tbl_footer, true, false, false, false, '');


$pdf->Output("pdf/".$sql5['gdn']."-GDN.pdf","F");

?>
<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Goods Out Management</a></li>
                        <li>View Detail</li>
                    </ul>
                </div>
				
			       <div class="row mb-12">
                    <div class="col-md-12 mb-12">
                        <div class="card text-left">
                            <div class="card-body">
				<a href="admin.php?id=goodsoutt&id2=<?php echo $_GET['id2'];?>"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
				   <a href="pdf/<?php echo $sql5['gdn'];?>-GDN.pdf" target="_blank"><button class="btn btn-info" style="float:right; margin-left:15px">Download Report</button></a>
                             <h4 class="card-title mb-3"><strong class="card-title" style="color:#FF0000; font-size:16px">GDN NO : <?php echo $sql5['gdn'];?></strong></h4>
								
                           
								 <div class="row">
                                    
									
									
								
								  <div class="table-responsive">
                                     <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                        <thead>
                                        <tr>
										<th></th>
										    <th>Date</th>
											<th>Customer</th>
											<th>Brand</th>
                                           	<th>Product</th>
											<th>Quantity</th>
											 <th> Use By </th>
											 <th> GDN Batchcode </th>
											  <th> Edit </th>
											
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
									$sno=$_GET['sno'];
								$sql3=mysqli_query($con,"select t1.cid, t1.prodname AS pname, t2.name as custname, t3.*,t3.cdate AS cdte, t4.*, t4.qty AS c1 ,t4.id as sno1 ,t5.name as bname from tblgoodsoutproduct t1, tblcustomer t2, tblgdn t3 , tblgdn1 t4,tblbrand t5 where t1.id=t4.product and t2.id=t3.customer and t3.gdn=t4.gdn  and t3.id='$sno' and t5.id=t4.brandname");

									$i=0;
									while($row1=mysqli_fetch_array($sql3))
									{
									$i++;
									
									

									?>
                                        <tr>
										<td><?php echo $i;?></td>
										 <td><?php echo date('d-m-Y', strtotime($row1['cdte']));?></td>
										 <td><?php echo $row1['custname'];?></td>
										 <td><?php echo $row1['bname'];?></td>
										<td><?php echo $row1['pname'];?></td>
											<td><?php echo $row1['c1'];?></td>
											<td><?php echo date('d-m-Y',strtotime($row1['useby']));?></td>
											<td><?php echo $row1['batchcode'];?></td>
											
											<td><a href="admin.php?id=goodsoutedit&sno1=<?php echo $row1['sno1'];?>&sno=<?php echo $sno;?>"><button class="btn btn-danger">Edit</button></a></td>
                                          </tr>
										    <?php
										     }
										?>
										</tbody>
                                    </table>
									</div>
									</div>
									
									
									
									
									
                               </div></div></div></div>