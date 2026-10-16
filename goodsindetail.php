 <?php
include 'connection.php';
$sno=$_GET['sno'];
$sql1=mysqli_query($con,"select * from tblgrnno where id='$sno'");
$rs=mysqli_fetch_array($sql1);


$qry1=mysqli_query($con,"select t1.*,t2.*, t3.*,t1.date As d1,t1.img AS tid,t3.product AS productname from tblgrnno t1, tblgrnno1 t2, tblticcosupplier t3 where t1.id='$sno' and t2.grn=t1.grnno and t3.id=t2.product");
$qry=mysqli_fetch_array($qry1);

$num1=mysqli_num_rows($qry1);

$tr=mysqli_query($con,"select * from tblgrn where id='$rs[cid]'");
$tr1=mysqli_fetch_array($tr);




require('tcpdf/tcpdf.php');

ini_set('max_execution_time', 300);
// create new PDF document
class MYPDF extends TCPDF { 

private $longTableHeader = '';

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
    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('centurygothic', 'I', 8);
        $this->Cell(25, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
		      
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
$pdf->SetXY(75,10);
//$pdf->Write(0, "GOODS RECIEVED NOTE", '', '0', '0', true, 'C', false, false, 0);
//$pdf->write1DBarcode($row2[grnno], 'C39', 'fromleft', 'from top', 'width', height, 0.3,'', 'N');
//$pdf->write1DBarcode($row2['grnno'], 'C39', '82', '13', '40', 8, 0.3,'', 'N');

$pdf->SetFont('centurygothic', 'B', 11);

$htmll ="";
$params = $pdf->serializeTCPDFtagParameters(array($rs['grnno'], 'C39', '83', '13', '40', 8, 0.3,'', 'N'));
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
<td >GOODS RECIEVED NOTE</td>
</tr>
<tr>
<td >$htmll </td>
</tr>

<tr>
<td >$rs[grnno]</td>
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

$pdf->SetXY(5,5);


  
$tble8=<<<EOD
<table width="750" border="0" style="font-weight:bold; font-size:12px " cellpadding="2">
  <tr >
    <td width="490"></td>
    <td width="230">SUPPLIER</td>
  </tr>
 <tr >
    <td width="490"></td>
    <td width="230">$qry[adr1]</td>
  </tr>
  <tr>
    <td></td>
    <td>$qry[adr2]</td>
  </tr>
  <tr>
    <td></td>
    <td>$qry[adr3]</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>$qry[adr4]</td>
  </tr>
 
  </table>
EOD;
$pdf->writeHTML($tble8, true, false, true, false, '');





$pdf->SetXY(5,35);

$tble7=<<<EOD
<table width="800" border="0" style="font-weight:bold; font-size:12px " cellpadding="2">
 
 <tr >
    <td width="520">Goods Recieved Note No : $rs[grnno]</td>
    
  </tr>
  <tr>
    <td>Document No : $qry[docnum]</td>
    
  </tr>
  <tr>
    <td>Date:$qry[orderdate] </td>
   
  </tr>
  <tr>
    <td>Vehicle Registration No: $tr1[trucknumber]</td>
  
  </tr>
   <tr>
    <td>&nbsp;</td>
   
  </tr>
  </table>
EOD;
$pdf->writeHTML($tble7, true, false, true, false, '');

$pdf->SetFont('centurygothic', '',8);




$pdf->SetXY(5,65);



 $string = $tr1['ans'];
$tags = explode(';' , $string);

  

$tble9=<<<EOD
<table width="750" border="1" cellpadding="6">
  <tr >
    <td width="350">Is it clean & tidy? <span style="font-size:13px;color:green"> $tags[0]</span></td>
    <td width="350">Are there any spillages/strong odours?: <span style="font-size:13px;color:green"> $tags[1] </span></td>
  </tr>

  <tr >
    <td width="350">Any pest evidence ? <span style="font-size:13px;color:green"> $tags[2] </span> </td>
    <td width="350">Any contamination risk (opened product/pack)? <span style="font-size:13px;color:green"> $tags[3] </span></td>
  </tr>
 
 
 
  </table>
EOD;
$pdf->writeHTML($tble9, true, false, true, false, '');



$pdf->SetXY(5,85);


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
    <th width="50"  >SNo</th>
    <th  width="100">Date</th>
    <th  width="100">Supplier Code</th>
	  <th  width="125">Supplier Name</th>
	   <th  width="100">Product Code</th>
	    <th width="125" >Product</th>
		 <th width="100" >Quantity</th>
		  
  </tr>
  </thead>
  ';
  $sql2=mysqli_query($con,"select t1.*,t2.*, t3.*,t1.date As d1,t1.img AS tid,t3.product AS productname from tblgrnno t1, tblgrnno1 t2, tblticcosupplier t3 where t1.id='$sno' and t2.grn=t1.grnno and t3.id=t2.product");

$i=0;
while($row5=mysqli_fetch_array($sql2))
{
  $i++;
											
  $tbl7 .= '
  <tbody>
  <tr nobr="true">
  
    <td width="50">'.$i.'</td>
	  <td width="100">'.date('d-m-Y', strtotime($row5['d1'])).'</td>
	 <td width="100">'.$row5['suppcode'].'</td>
	  <td width="125">'.$row5['adr1'].'</td>
	   <td width="100">'.$row5['pcode'].'</td>
	    <td width="125">'.$row5['productname'].'</td>
		 <td width="100">'.$row5['qty'].'</td>
		
   
  </tr>
  </tbody>
  ';
  }
  
  $pdf->writeHTML($tbl_header . $tbl7 . $tbl_footer, true, false, false, false, '');


$tble7=<<<EOD
<table width="700" border="0"  cellpadding="2">
   <tr>
    <td width="500">P&deg;C (Product Temperature): $tr1[ptemp]</td>
    <td width="200">Total Trays: $num1</td> 

  </tr>
  <tr>
    <td>V&deg;C (Vehicle Temperature):$tr1[vtemp]</td>
    <td>Received By: $tr1[user]</td>
  </tr>
  
  </table>
EOD;
$pdf->writeHTML($tble7, true, false, true, false, '');

$pdf->Output("pdf/".$rs['grnno'].".pdf","F");

?>






<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Goods In Management</a></li>
                        <li>View Detail</li>
                    </ul>
                </div>
				
												
												
				
			       <div class="row mb-12">
                    <div class="col-md-12 mb-12">
                        <div class="card text-left">
                            <div class="card-body">
							
							<a href="admin.php?id=goodsin"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							
							 <a href="pdf/<?php echo $rs['grnno'];?>.pdf" target="_blank"><button class="btn btn-info" style="float:right; margin-left:15px">Download Report</button></a>
							
                             <h4 class="card-title mb-3"><strong class="card-title" style="color:#FF0000; font-size:16px">GRN NO : <?php echo $rs['grnno'];?></strong></h4>
								
                           
								 <div class="row">
                                    
									
									
								
								  <div class="table-responsive">
                                     <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                     <thead>
                                        <tr>
										<th></th>
										    <th>Date</th>
											<th>Supplier Code</th>
											<th>Supplier</th>
                                           	<th>Product Code</th>
											<th>Product </th>
											
											<th>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
									
								$sql3=mysqli_query($con,"select t1.*,t2.*, t3.*,t1.date As d1,t1.img AS tid,t3.product AS productname from tblgrnno t1, tblgrnno1 t2, tblticcosupplier t3 where t1.id='$sno' and t2.grn=t1.grnno and t3.id=t2.product");

									$i=0;
									while($row1=mysqli_fetch_array($sql3))
									{
									$i++;
									
								
									?>
                                        <tr>
										<td><?php echo $i;?></td>
										 <td><?php echo date('d-m-Y', strtotime($row1['d1']));?></td>
                                            <td><?php echo $row1['suppcode'];?></td>
											<td><?php echo $row1['adr1'];?></td>
											<td><?php echo $row1['pcode'];?></td>
											<td><?php echo $row1['productname'];?></td>
											
											<td><?php echo $row1['qty'];?></td>
											
											
                                          </tr>
										    <?php
										     }
										?>
										</tbody>
                                    </table>
									</div>
									</div>
									
									
									
									
									
                               </div></div></div></div>