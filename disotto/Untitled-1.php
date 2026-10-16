<?php
ini_set('max_execution_time', 600);
ini_set('memory_limit','-1');


$sno=$_GET['pid'];

$sql=mysqli_query($con,"select * from tblproduct1 where prodid='$sno' ");
$row=mysqli_fetch_array($sql);

$sql5=mysqli_query($con,"select * from tblproduct1 where prodid='$sno' ");
$row5=mysqli_fetch_array($sql5);


$pingre = $row['ingre'];


$str = ['/\bcrustaceans\b/u','/\bCrustaceans\b/u','/\beggs\b/u','/\bEggs\b/u','/\bWheat\b/u','/\bEgg\b/u','/\bMilk\b/u','/\bCrustacean\b/u','/\bFish\b/u','/\bCelery\b/u','/\bMolluscs\b/u','/\bSulphites\b/u','/\bNuts\b/u','/\bSoya\b/u','/\bwheat\b/u','/\begg\b/u','/\bmilk\b/u','/\bcrustacean\b/u','/\bfish\b/u','/\bcelery\b/u','/\bmolluscs\b/u','/\bsulphites\b/u','/\bnuts\b/u','/\bsoya\b/u'];
$rplc =['<b>crustaceans</b>','<b>Crustaceans</b>','<b>eggs</b>','<b>Eggs</b>','<b>Wheat</b>','<b>Egg</b>','<b>Milk</b>','<b>Crustacean</b>','<b>Fish</b>','<b>Celery</b>','<b>Molluscs</b>','<b>Sulphites</b>','<b>Nuts</b>','<b>Soya</b>','<b>wheat</b>','<b>egg</b>','<b>milk</b>','<b>crustacean</b>','<b>fish</b>','<b>celery</b>','<b>molluscs</b>','<b>sulphites</b>','<b>nuts</b>','<b>soya</b>'];

$pingre= preg_replace($str,$rplc,$pingre);


require('tcpdf/tcpdf.php');
ob_start();


         class MYPDF extends TCPDF {
        public function Header() 
		{
		 $image_file = 'images/1.png';
		
        $this->Image($image_file, 15, 5, 25, '', 'png', '', 'T', false, 200, '', false, false, 0, false, false, false);
		
		$this->SetFont('courier', '', 20);
		
		$this->SetXY(70,0);
		$this->Write(30,'Product Specification', '', 0, '10', true, 0, false, false, 0);
         } 
		 
	    public function Footer()
	    {
        $this->SetY(-10);
        $this->SetFont('courier', '', 8);
        $this->Cell(20, 5, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
		$this->Cell(270, 5, 'Printed on: '.date("d/m/Y "), 0, false, 'C', 0, '', 0, false, 'T', 'M');

    }
    
}
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


$pdf->SetCreator(PDF_CREATOR);
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->SetMargins(PDF_MARGIN_LEFT, 37, PDF_MARGIN_RIGHT);$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}   
$pdf->AddPage();

 $pdf->SetFont('courier', '', 11, 'B');

$html4 = <<<EOF
<table border="1"  width="100%" border="0.5" cellpadding="3">
  <tr nobr="true">
    <td colspan="2" valign="top" bgcolor="#F5EA03" style="color:#000000" >Product Information</td>
  </tr>
   <tr nobr="true">
    <td  valign="top">Product Name </td>
    <td  valign="top">$row[prodname]</td>
  </tr>
  

  <tr nobr="true">
    <td  valign="top">Product Weight  </td>
    <td  valign="top">$row[weight]</td>
  </tr>
  <tr nobr="true">
    <td  valign="top">Product Code  </td>
    <td  valign="top">$row[prodcode]</td>
  </tr>
  <tr nobr="true">
    <td  valign="top">Product Description </td>
    <td  valign="top">$row[descc]</td>
  </tr>
 
   <tr nobr="true">
    <td  valign="top">Identification Mark: $row[imark]</td>
    <td  valign="top">Barcode: $row[barcode]</td>
  </tr>
 
</table>
EOF;

// output the HTML content
$pdf->writeHTML($html4, true, false, true, false, '');







$html4 = <<<EOF
<table border="1"  width="100%" border="0.5" cellpadding="3">
  <tr nobr="true">
    <td colspan="2" valign="top" bgcolor="#F5EA03" style="color:#000000" >Product Ingredient</td>
  </tr>
    <tr nobr="true">
    <td colspan="2" valign="top">$pingre</td>
  </tr>
 
</table>
EOF;

// output the HTML content
$pdf->writeHTML($html4, true, false, true, false, '');



if($row['img']!="")
{
$html5 = <<<EOF
<table border="1"  width="100%" border="0.5" cellpadding="3">
  <tr nobr="true">
    <td colspan="2" valign="top" bgcolor="#F5EA03" style="color:#000000" >Product Image</td>
  </tr>
  
 <tr nobr="true">
    <td  colspan="2"><img src="productimg/$row[img]" width="300" height="300"></td>
	 
  </tr>
 
  
</table>
EOF;

// output the HTML content
$pdf->writeHTML($html5, true, false, true, false, '');

}

$tbl_header = '<style>
table {
   
   border-spacing: 0;
}
tr {
   padding: 3px 0;
   text-align: center;
}

th {
      background-color:#F0F0F0;
   color: #000000;
   text-align: center;
}
td {
  
   color: #000000;
   text-align: center;
}
</style>
<table id="gallerytab"  cellspacing="0" cellpadding="4" border="0">
  ';
	
$tbl_footer = '</table>';

$tbl21 = '';

$tbl21.='
<table border="1"  width="100%" border="0.5" cellpadding="3">
 <tr nobr="true">
    <td colspan="2" valign="top" bgcolor="#F5EA03" style="color:#000000">Country Of Origin of the Raw Ingredients</td>
  </tr>';
   $sq2=mysqli_query($con,"select t1.*,t2.*  from tblproductdetail t1, tblsaveans1 t2  where t1.pid='$sno' and t1.sid='12' and t2.sno=t1.id");
  while($row1=mysqli_fetch_array($sq2))
  {  
$tbl21.=' <tr nobr="true">
    <th width="200" >'.$row1['ques'].'</th>
    <td width="438">'.str_replace('<','&lt;' ,$row1['cmnt']).'</td>
  </tr>
 
';
  }
  $tbl21.=' </table>';
  

$pdf->writeHTML($tbl21, true, false, true, false, '');


$tbl3 = '';

$tbl3.='
<table border="1"  width="100%" border="0.5" cellpadding="3">
 <tr nobr="true" >
    <td colspan="4" valign="top" bgcolor="#F5EA03" style="color:#000000">Allergens and Intolerance</td>
  </tr>
  
   <tr nobr="true">
    <td width="150" ><strong>Type</strong></td>
    <td width="100"  style="text-align:center"><strong>Contained in the Product</strong></td>
    <td width="100" style="text-align:center"><strong>Cross Contamin</strong></td>
	<td width="100" style="text-align:center"><strong>Used in the factory</strong></td>
	<td width="187" style="text-align:center"><strong>Source</strong></td>
  </tr>
  ';
   $sq3=mysqli_query($con,"select t1.*,t2.*  from tblproductdetail t1, tblsaveans1 t2  where t1.pid='$sno' and t1.sid='9' and t2.sno=t1.id");
  while($row2=mysqli_fetch_array($sq3))
  {  
  
  $string2 = $row2['ans'];
        $tags2 = explode(';' , $string2);
		
		$ans="";
		$ans1="";
		$ans2="";
		if($tags2[0]=="Contained in the Product")
		{
		$ans='Yes';
		}
		if($tags2[1]=="Cross Contamin")
		{
		$ans1='Yes';
		}
		if($tags2[2]=="Used in the factory")
		{
		$ans2='Yes';
		}
		
		
$tbl3.=' 
   <tr nobr="true">
    <td>'.$row2['ques'].'</td>
	 <td>'.$ans.'</td>
	  <td>'.$ans1.'</td>
	   <td>'.$ans2.'</td>
	<td style="text-align:center">'.str_replace('<','&lt;' ,$row2['cmnt']).'</td>
  </tr>
';
  }
  $tbl3.='  <tr nobr="true">
    <td  colspan="4"><strong> *Produced in a factory that handles Milk </strong></td>
  </tr>
  </table>';
$pdf->writeHTML($tbl3, true, false, true, false, '');

$tbl4 = '';
$tbl4.='
<table border="1"  width="100%" border="0.5" cellpadding="3">
 <tr nobr="true">
    <td colspan="3" valign="top" bgcolor="#F5EA03" style="color:#000000">Suitability Information</td>
  </tr>
  <tr nobr="true">
    <td width="338" ><strong></strong></td>
    <td width="150"  style="text-align:center"><strong>Yes</strong></td>
    <td width="150" style="text-align:center"><strong>No</strong></td>
  </tr>';
  
   $sq4=mysqli_query($con,"select t1.*,t2.*  from tblproductdetail t1, tblsaveans1 t2  where t1.pid='$sno' and t1.sid='10' and t2.sno=t1.id");
  while($row3=mysqli_fetch_array($sq4))
  {  
 $tbl4.='<tr nobr="true">
    <td>'.$row3['ques'].'</td>
    <td style="text-align:center">';
	if($row3['ans']=="Yes")
	{
	$tbl4.=' Yes';
	}
	$tbl4.=' </td>
    <td style="text-align:center">';
	if($row3['ans']=="No")
	{
	$tbl4.=' No';
	}
	$tbl4.=' </td>
  </tr>
     ';
  }
  $tbl4.=' </table>';
$pdf->writeHTML($tbl4, true, false, true, false, '');

 $tbl2 = '';

$tbl2.='
<table border="1"  width="100%" border="0.5" cellpadding="3">
 <tr nobr="true">
    <td colspan="2" valign="top" bgcolor="#F5EA03" style="color:#000000">Nutritional Information</td>
  </tr>';
   $sq2=mysqli_query($con,"select t1.*,t2.*  from tblproductdetail t1, tblsaveans1 t2  where t1.pid='$sno' and t1.sid='8' and t2.sno=t1.id");
  while($row1=mysqli_fetch_array($sq2))
  {  
$tbl2.=' <tr nobr="true">
    <th width="200" >'.$row1['ques'].'</th>
    <td width="438">'.str_replace('<','&lt;' ,$row1['ans']).'</td>
  </tr>
 
';
  }
  $tbl2.=' </table>';
  

$pdf->writeHTML($tbl2, true, false, true, false, '');


$tbl9 = '';

$tbl9.='
<table border="1"  width="100%" border="0.5" cellpadding="3">
 <tr nobr="true" >
    <td colspan="4" valign="top" bgcolor="#F5EA03" style="color:#000000">Physical & Chemical Analysis</td>
  </tr>
  
   <tr nobr="true">
    <td width="338" ><strong></strong></td>
    <td width="150"  style="text-align:center"><strong>Unit</strong></td>
    <td width="150" style="text-align:center"><strong>Target</strong></td>
	
  </tr>
  ';
   $sq3=mysqli_query($con,"select t1.*,t2.*  from tblproductdetail t1, tblsaveans1 t2  where t1.pid='$sno' and t1.sid='13' and t2.sno=t1.id");
  while($row2=mysqli_fetch_array($sq3))
  {  
   $string3 = $row2['ans'];
        $tags3 = explode(';' , $string3);
		
$tbl9.=' 
  
   <tr nobr="true">
    <td>'.$row2['ques'].'</td>
    <td style="text-align:center">'.str_replace('<','&lt;' ,$tags3['0']).'</td>
	<td style="text-align:center">'.str_replace('<','&lt;' ,$tags3['1']).'</td>
  </tr>
';
  }
  $tbl9.='</table>';
$pdf->writeHTML($tbl9, true, false, true, false, '');



 $tbl5 = '';
$tbl5.='
<table border="1"  width="100%" border="0.5" cellpadding="3">
 <tr nobr="true">
    <td colspan="4" valign="top" bgcolor="#F5EA03" style="color:#000000">Microbiological Standard</td>
  </tr>
  
   <tr nobr="true">			
    <td width="238" valign="top"><strong>Test</strong></td>
    <td  width="100" valign="top"><strong>Target Level</strong></td>
	<td width="100" valign="top"><strong>Reject Level</strong></td>
    <td   width="200" valign="top"><strong>Testing </strong></td>
  </tr>
  ';
   $sq5=mysqli_query($con,"select t1.*,t2.*  from tblproductdetail t1, tblsaveans1 t2  where t1.pid='$sno' and t1.sid='11' and t2.sno=t1.id");
  while($row6=mysqli_fetch_array($sq5))
  {  
  $string = $row6['ans'];
        $tags1 = explode(';' , $string);
		
		
		
$tbl5.='  <tr nobr="true">			
    <td valign="top">'.$row6['ques'].'</td>
    <td  valign="top">'.str_replace('<','&lt;' ,$tags1[0]).'</td>
	<td valign="top">'.str_replace('<','&lt;' ,$tags1[1]).'</td>
    <td  valign="top">'.str_replace('<','&lt;' ,$row6['cmnt']).'</td>
  </tr>
';
  }
  $tbl5.=' </table>';
  

$pdf->writeHTML($tbl5, true, false, true, false, '');


 $tbl6 = '';
$tbl6.='
<table border="1"  width="100%" border="0.5" cellpadding="3">
 <tr nobr="true">
    <td colspan="3" valign="top" bgcolor="#F5EA03" style="color:#000000">Primary Packaging Information</td>
  </tr>
  ';
   $sq6=mysqli_query($con,"select t1.*,t2.*  from tblproductdetail t1, tblsaveans1 t2  where t1.pid='$sno' and t1.sid='14' and t2.sno=t1.id");
  while($row7=mysqli_fetch_array($sq6))
  {  
  
$tbl6.='<tr nobr="true">			
    <td valign="top">'.$row7['ques'].'</td>
    <td  valign="top">'.str_replace('<','&lt;' ,$row7['cmnt']).'</td>';
	if($row7['pic']!='')
	{
	$tbl6.='<td  rowspan="5">
	
	<img src="marshwood/productdoc/'.$row7['pic'].'" height="170"  width="240"></td>';
	}
	$tbl6.='
	
  </tr>

';
  }
  $tbl6.=' </table>';
  

$pdf->writeHTML($tbl6, true, false, true, false, '');



 $tbl7 = '';
$tbl7.='
<table border="1"  width="100%" border="0.5" cellpadding="3">
 <tr nobr="true">
    <td colspan="3" valign="top" bgcolor="#F5EA03" style="color:#000000">Outer Packaging Information</td>
  </tr>
  ';
   $sq7=mysqli_query($con,"select t1.*,t2.*  from tblproductdetail t1, tblsaveans1 t2  where t1.pid='$sno' and t1.sid='15' and t2.sno=t1.id");
  while($row8=mysqli_fetch_array($sq7))
  {  
		
$tbl7.='  <tr nobr="true">			
    <td valign="top">'.$row8['ques'].'</td>
    <td  valign="top">'.str_replace('<','&lt;' ,$row8['cmnt']).'</td>';
	
	 if($row8['pic']!='')
	{
	$tbl7.='<td  rowspan="7">
	
	<img src="marshwood/productdoc/'.$row8['pic'].'" height="170"  width="240"></td>';
	}
	$tbl7.='
	
  </tr>

';
  
  }
  $tbl7.=' </table>';
  

$pdf->writeHTML($tbl7, true, false, true, false, '');


$tbl8 = '';
$tbl8.='
<table border="1"  width="100%" border="0.5" cellpadding="3">
 <tr nobr="true">
    <td colspan="2" valign="top" bgcolor="#F5EA03" style="color:#000000">Pallet Information</td>
  </tr>
  ';
   $sq8=mysqli_query($con,"select t1.*,t2.*  from tblproductdetail t1, tblsaveans1 t2  where t1.pid='$sno' and t1.sid='16' and t2.sno=t1.id");
  while($row9=mysqli_fetch_array($sq8))
  {  
		
$tbl8.='  <tr nobr="true">			
    <td valign="top">'.$row9['ques'].'</td>
    <td  valign="top">'.str_replace('<','&lt;' ,$row9['cmnt']).'</td>
  </tr>
';
  }
  $tbl8.=' </table>';
  

$pdf->writeHTML($tbl8, true, false, true, false, '');


$tbl9 = '';
$tbl9.='
<table border="1"  width="100%" border="0.5" cellpadding="3">
 <tr nobr="true">
    <td colspan="2" valign="top" bgcolor="#F5EA03" style="color:#000000">Shelf Life/ Best Before</td>
  </tr>

<tr nobr="true">
    <td valign="top">Recommended Shelf life </td>
	<td valign="top">'.$row['shelflife'].'</td>
  </tr>
  <tr nobr="true">
    <td valign="top">Minimum Shelf life on Delivery</td>
	<td valign="top">'.$row['mslife'].'</td>
  </tr>
  <tr nobr="true">
    <td valign="top">Once Opened</td>
	<td valign="top">'.$row['opened'].'</td>
  </tr>
</table>';
  

$pdf->writeHTML($tbl9, true, false, true, false, '');


$tbl10 = '';
$tbl10.='
<table border="1"  width="100%" border="0.5" cellpadding="3">
 <tr nobr="true">
    <td colspan="2" valign="top" bgcolor="#F5EA03" style="color:#000000">Weight </td>
  </tr>

<tr nobr="true">
    <td valign="top">Net Weight</td>
	<td valign="top">'.$row['weight'].'</td>
  </tr>
  <tr nobr="true">
    <td valign="top">Packaging method</td>
	<td valign="top">Average Weight System</td>
  </tr>
 
</table>';
  

$pdf->writeHTML($tbl10, true, false, true, false, '');



$tbl11 = '';
$tbl11.='
<table border="1"  width="100%" border="0.5" cellpadding="3">
 <tr nobr="true">
    <td colspan="2" valign="top" bgcolor="#F5EA03" style="color:#000000">Storage Conditions and Condition of use </td>
  </tr>

<tr nobr="true">
    <td valign="top">Storage</td>
	<td valign="top">1 . '.$row['storage'].'  <br/> 2.	DO NOT FREEZE</td>
  </tr>
 
</table>';
  

$pdf->writeHTML($tbl12, true, false, true, false, '');

$tbl12 = '';
$tbl12.='
<table border="1"  width="100%" border="0.5" cellpadding="3">
 <tr nobr="true">
    <td colspan="2" valign="top" bgcolor="#F5EA03" style="color:#000000">Supplier Confirmation</td>
  </tr>

 <tr nobr="true">
    <td  valign="top">Created by</td>
    <td   valign="top">Bijal Chauhan</td>
  </tr>
  <tr nobr="true">
    <td  valign="top">Signature</td>
    <td   valign="top">Bijal Chauhan </td>
  </tr>
  <tr nobr="true">
    <td  valign="top">Date</td>
    <td  valign="top">Technical Coordinator</td>
  </tr>
  <tr nobr="true">
    <td  valign="top">Job Title</td>
    <td  valign="top">Technical Coordinator</td>
  </tr>
  <tr nobr="true">
    <td  valign="top">Issue Date</td>
    <td valign="top">09/08/2024</td>
	</tr>
	
    <tr nobr="true">
	<td  valign="top">Issue No</td>
    <td  valign="top">6</td>
  </tr>
  
  <tr nobr="true">
    <td  valign="top">Reason for Amendment</td>
    <td   valign="top">Micro Limits have been reviewed.</td>
  </tr>
  <tr nobr="true">
    <td  valign="top">Approved by (Name)</td>
    <td   valign="top"></td>
  </tr>
  <tr nobr="true">
    <td  valign="top">Approved by (Signature)</td>
    <td   valign="top"></td>
  </tr>
  <tr nobr="true">
    <td  valign="top">Approved on</td>
    <td   valign="top"></td>
  </tr>
   
</table>';
  

$pdf->writeHTML($tbl12, true, false, true, false, '');




$str = preg_replace('/[^A-Za-z0-9_-]/','', $row['prodname']);
$pdf->lastPage();
ob_clean();
 $pdf->Output($_SERVER['DOCUMENT_ROOT'] . "brcfoodsafety/pdf/".$str."-Specifiation.pdf","F");
 ?>   
   
   <div class="container-fluid">
                     <div class="row column_title">
                        <div class="col-md-12">
                           <div class="page_title">
                              <h2><?php echo $row['prodname'];?> (<?php echo $row['prodcode'];?>)
							  
							   <a href="pdf/<?php echo $str;?>-Specifiation.pdf"  target="_blank"><button class="btn btn-warning" style="float:right; margin-left:10px">Download Spec</button></a>
							   
							   
							      <a href="admin.php?id=1"><button class="btn btn-info" style="float:right">Go Back</button></a>
								  
								 
							  </h2>
                           </div>
                        </div>
                     </div>
					 
                     <!-- row -->
                   <div class="card">
				   <div class="col-12"> 
				   <div class="full graph_head">
	  
		<div class="row">
		<div class="col-12"> 
		<iframe src="pdf/<?php echo $str;?>-Specifiation.pdf" width="100%" height="600"></iframe>
	    </div>
 </div></div></div></div></div>