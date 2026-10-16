 <?php

$sql1=mysqli_query($con,"select t1.pname, t1.uom, t2.*, t3.*, SUM(t3.box) AS c1,SUM(t3.qty) AS s1, t4.grnno,t4.ans,t4.po,t4.cdate AS dt,t4.user from tblrawmaterial t1, tblrawsupplier t2, tblgrn1 t3 , tblgrnno2 t4 where t1.id=t3.product and t2.supid=t3.supplier and t3.grncode=t4.grnno and t4.id='$_GET[sno]' group by t3.product");
$row2=mysqli_fetch_array($sql1);



$date= date('d-m-Y h:m:s', strtotime($row2['dt']));



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
$params = $pdf->serializeTCPDFtagParameters(array($row2['grnno'], 'C39', '83', '13', '40', 8, 0.3,'', 'N'));
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
<td>$row2[grnno]</td>
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
    <td width="230">$row2[supname]</td>
  </tr>
  <tr>
    <td></td>
    <td>$row2[address]</td>
  </tr>
  <tr>
    <td></td>
    <td>$row2[city]</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Tel: $row2[contact]</td>
  </tr>
   <tr>
    <td>&nbsp;</td>
    <td>Email: $row2[email]</td>
  </tr>
  </table>
EOD;
$pdf->writeHTML($tble8, true, false, true, false, '');


$pdf->SetXY(5,35);

$tble7=<<<EOD
<table width="800" border="0" style="font-weight:bold; font-size:12px " cellpadding="2">
 
  <tr>
    <td width="520">Goods Recieved Note No : $row2[grnno] </td>
  </tr>
  <tr>
    <td>PO No : $row2[po]</td>
    
  </tr>
  <tr>
    <td>Date:$date </td>
   
  </tr>
  <tr>
    <td>&nbsp;</td>
  
  </tr>
   <tr>
    <td>&nbsp;</td>
   
  </tr>
  </table>
EOD;
$pdf->writeHTML($tble7, true, false, true, false, '');

$pdf->SetFont('centurygothic', '',8);




$pdf->SetXY(5,55);



 $string = $row2['ans'];
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
    <th width="40" >SNo</th>
    <th width="180" >Product Description</th>
    <th width="80" >Box</th>
	   <th width="80" >Total Quantity</th>
		 <th width="100" >Use By / Best Before</th>
		    <th width="100" >Product Temperature</th>
		   <th width="120" >GRN</th>
  </tr>
  </thead>
  ';
  $sql2=mysqli_query($con,"select t1.pname, t1.uom, t2.*, t3.*, t3.useby AS ub, t3.killdate AS killd , t3.box AS c1,t3.qty AS s1, t4.grnno,t4.po,t4.cdate AS dt,t4.user from tblrawmaterial t1, tblrawsupplier t2, tblgrn1 t3 , tblgrnno2 t4 where t1.id=t3.product and t2.supid=t3.supplier and t3.grncode=t4.grnno and t4.id='$_GET[sno]'");

$i=0;
while($row5=mysqli_fetch_array($sql2))
{
  $i++;
$ub="";
$bb="";

if($row5['ub']=="" || $row5['ub']=="0000-00-00" || $row5['ub']=="N/A")
{
$ub="N/A";
}
else
{
$ub=date('d-m-Y',strtotime($row5['ub']));
}

if($row5['killd']=="" || $row5['killd']=="0000-00-00" || $row5['killd']=="N/A")
{
$killdate="N/A";
}
else
{
$killdate=$row5['killd'];
}

if($row5['ptemp']=="N/A")
{
$ptemp="N/A";
}
else
{
$ptemp=$row5['ptemp'].'&deg;C';
}

if($row5['uomm']=="undefined" || $row5['uomm']=="")
{
$uomm="";
}
else
{
$uomm=$row5['uomm'].":";
}
if($row5['vtemp']=="")
{
$vtemp="N/A";
}
else
{
$vtemp=$row5['vtemp'].'&deg;C';
}

  $tbl7 .= '
  <tbody>
  <tr nobr="true">
    <td  width="40" >'.$i.'</td>
    <td  width="180" >'.$row5['pname'].'</td>
    <td width="80">'.$row5['c1'].'</td>
	
	   <td  width="80">'.$row5['s1'].' '.$row5['uom'].'</td>
		 <td width="100">'.$uomm.'  '.$ub.'</td>
		 <td width="100">'.$killdate.'</td>
		   <td width="120">'.$row5['grn'].'</td>
  </tr>
  </tbody>
  ';
  }
  
  $pdf->writeHTML($tbl_header . $tbl7 . $tbl_footer, true, false, false, false, '');

 $x1=mysqli_query($con,"select SUM(box) AS cnt from tblgrn1 where grncode='$row2[grnno]'");
 $y1  = mysqli_fetch_array($x1);
    $num1=$y1['cnt'];





$pdf->Output($_SERVER['DOCUMENT_ROOT']."pdf/".$row2['grnno'].".pdf","F");


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
				 <a href="admin.php?id=goods"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
				 <a href="pdf/<?php echo $row2['grnno'];?>.pdf" target="_blank"><button class="btn btn-info" style="float:right; margin-left:15px">Download Report</button></a>
							 <a href="admin.php?id=1addnewgoods21&sno=<?php echo $_GET['sno'];?>"><button class="btn btn-warning" style="float:right; margin-left:15px">Add New</button></a>
                             <h4 class="card-title mb-3"><strong class="card-title" style="color:#FF0000; font-size:16px">
							 GRN NO : <?php echo $row2['grnno'];?> , Supplier: <?php echo $row2['supname'];?></strong></h4>
								
                           
								 <div class="row">
                                    
									
									
								
								  <div class="table-responsive">
                                     <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                        <thead>
                                        <tr>
										<th></th>
										    <th>Date</th>
                                           	<th>Product</th>
											<th>Product Temperature</th>
											<th>Boxes</th>
											<th>Qty</th>
											
											<th>UB/BB</th>
											<th>GRN CODE</th>
											
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
$sql3=mysqli_query($con,"select t1.pname, t1.uom, t2.*, t3.useby AS ub, t3.killdate AS killd, t3.*, t3.id as gid ,t3.box AS c1,t3.qty AS s1, t4.grnno,t4.po,t4.id AS tid, t4.cdate AS dt,t4.user from tblrawmaterial t1, tblrawsupplier t2, tblgrn1 t3 , tblgrnno2 t4 where t1.id=t3.product and t2.supid=t3.supplier and t3.grncode=t4.grnno and t4.id='$_GET[sno]' order by t3.id asc");
$i=0;
while($row1=mysqli_fetch_array($sql3))
{
									$i++;
									
									if($row1['ub']=="" || $row1['ub']=="0000-00-00" || $row1['ub']=="N/A" )
{
$ub="N/A";
}
else
{
$ub=date('d-m-Y',strtotime($row1['ub']));
}

if($row1['killd']=="" || $row1['killd']=="0000-00-00" || $row1['killd']=="N/A")
{
$killdate="N/A";
}
else
{
$killdate=$row1['killd'];
}

if($row1['uomm']=="undefined")
{
$uomm="";
}
else
{
$uomm=$row1['uomm'];
}

									?>
                                        <tr>
										<td><?php echo $i;?></td>
										 <td><?php echo date('d-m-Y', strtotime($row1['dt']));?></td>
										
										   
                                            
											<td>
											<?php 
											echo $row1['pname'];
											?>
											</td>
											<td><?php echo $killdate;?></td>
											<td><?php echo $row1['c1'];?></td>
											
											
											<td><?php echo $row1['s1'];?><?php echo $row1['uom'];?></td>
											
											<td><?php echo $uomm;?>: <?php echo $ub;?> (Batch: <?php echo $row1['batchcode'];?>)</td>
											<td><?php echo $row1['grn'];?></td>
											<td> 
											<a href="admin.php?id=goodseditdetail&sno=<?php echo $_GET['sno'];?>&gid=<?php echo $row1['gid'];?>"> 
											<button type="button" class="btn btn-danger btn-sm"> Edit </button></a>
											</td>
											
                                          </tr>
										    <?php
										     }
										?>
										</tbody>
                                    </table>
									</div>
									</div>
									
									
									
									
									
                               </div></div></div></div>