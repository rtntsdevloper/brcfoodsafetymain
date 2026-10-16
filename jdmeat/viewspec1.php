

<?php
ini_set('max_execution_time', 600);
ini_set('memory_limit','-1');


$sno=$_GET['pid'];

$sql=mysqli_query($con,"select * from tblproduct1 where prodid='$sno' ");
$row=mysqli_fetch_array($sql);

$sql5=mysqli_query($con,"select * from tblproduct1 where prodid='$sno' ");
$row5=mysqli_fetch_array($sql5);


$pingre = $row['ingre'];


$str = ['/\bcrustaceans\b/u','/\bCrustaceans\b/u','/\beggs\b/u','/\bEggs\b/u','/\bWheat\b/u','/\bEgg\b/u','/\bMilk\b/u','/\bCrustacean\b/u','/\bFish\b/u','/\bCelery\b/u','/\bMolluscs\b/u','/\bSulphites\b/u','/\bNuts\b/u','/\bSoya\b/u','/\bwheat\b/u','/\begg\b/u','/\bmilk\b/u','/\bMILK\b/u','/\bcrustacean\b/u','/\bfish\b/u','/\bcelery\b/u','/\bmolluscs\b/u','/\bsulphites\b/u','/\bnuts\b/u','/\bsoya\b/u'];
$rplc =['<b>crustaceans</b>','<b>Crustaceans</b>','<b>eggs</b>','<b>Eggs</b>','<b>Wheat</b>','<b>Egg</b>','<b>Milk</b>','<b>Crustacean</b>','<b>Fish</b>','<b>Celery</b>','<b>Molluscs</b>','<b>Sulphites</b>','<b>Nuts</b>','<b>Soya</b>','<b>wheat</b>','<b>egg</b>','<b>milk</b>','<b>MILK</b>','<b>crustacean</b>','<b>fish</b>','<b>celery</b>','<b>molluscs</b>','<b>sulphites</b>','<b>nuts</b>','<b>soya</b>'];

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
    <td  valign="top">Product Description </td>
    <td  valign="top">$row[descc]</td>
  </tr>
 
   <tr nobr="true">
    <td  valign="top">DiSotto Foods Product Code</td>
    <td  valign="top">$row[prodcode]</td>
  </tr>
  
   <tr nobr="true">
    <td  valign="top">Net Volume (litres):</td>
    <td  valign="top">$row[weight]</td>
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




$html4 = <<<EOF
<table border="1"  width="100%" border="0.5" cellpadding="3">
  <tr nobr="true">
    <td colspan="2" valign="top" bgcolor="#F5EA03" style="color:#000000" >ORGANOLEPTIC CHARACTERISTICS </td>
  </tr>
   <tr nobr="true">
    <td  valign="top">Visual Appearance / Colour</td>
    <td  valign="top">$row[colour]</td>
  </tr>
  <tr nobr="true">
    <td  valign="top">Smell / Aroma</td>
    <td  valign="top">$row[smell]</td>
  </tr>
  <tr nobr="true">
    <td  valign="top">Texture</td>
    <td  valign="top">$row[texture]</td>
  </tr>
 
   <tr nobr="true">
    <td  valign="top">Flavour</td>
    <td  valign="top">$row[flavour]</td>
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



$tbl2 = '';

$tbl2.='
<table border="1"  width="100%" border="0.5" cellpadding="3">
 <tr nobr="true">
    <td colspan="2" valign="top" bgcolor="#F5EA03" style="color:#000000">NUTRITIONAL DATA per 100g</td>
  </tr>';
   $sq2=mysqli_query($con,"select t1.*,t2.*  from tblproductdetail t1, tblsaveans1 t2  where t1.pid='$sno' and t1.sid='7' and t2.sno=t1.id");
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




$tbl3 = '';

$tbl3.='
<table border="1"  width="100%" border="0.5" cellpadding="3">
 <tr nobr="true" >
    <td colspan="4" valign="top" bgcolor="#F5EA03" style="color:#000000">ALLERGEN INFORMATION</td>
  </tr>
  
   <tr nobr="true">
    <td width="150" ><strong>Type</strong></td>
    <td width="100"  style="text-align:center"><strong>Contained in the Product</strong></td>
    <td width="100" style="text-align:center"><strong>Cross Contamin</strong></td>
	<td width="100" style="text-align:center"><strong>Used in the factory</strong></td>
	<td width="187" style="text-align:center"><strong>Source</strong></td>
  </tr>
  ';
   $sq3=mysqli_query($con,"select t1.*,t2.*  from tblproductdetail t1, tblsaveans1 t2  where t1.pid='$sno' and t1.sid='8' and t2.sno=t1.id");
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
    <td  colspan="4"><strong> * wheat, barley, rye, oat, spelt and kamut.** such as prawns, lobster and crab *** Almonds, hazelnuts, walnuts, brazil nuts, cashews, pecans, pistachios  and macadamia nuts. **** at levels above 10mg per kg or per litre </strong></td>
  </tr>
  </table>';
$pdf->writeHTML($tbl3, true, false, true, false, '');

$tbl4 = '';
$tbl4.='
<table border="1"  width="100%" border="0.5" cellpadding="3">
 <tr nobr="true">
    <td colspan="3" valign="top" bgcolor="#F5EA03" style="color:#000000">SUITABLE FOR</td>
  </tr>
  <tr nobr="true">
    <td width="338" ><strong></strong></td>
    <td width="150"  style="text-align:center"><strong>Yes</strong></td>
    <td width="150" style="text-align:center"><strong>No</strong></td>
  </tr>';
  
   $sq4=mysqli_query($con,"select t1.*,t2.*  from tblproductdetail t1, tblsaveans1 t2  where t1.pid='$sno' and t1.sid='9' and t2.sno=t1.id");
  while($row3=mysqli_fetch_array($sq4))
  {  
  $string3 = $row3['ans'];
        $tags3 = explode(';' , $string3);
  
 $tbl4.='<tr nobr="true">
    <td>'.$row3['ques'].'</td>
    <td style="text-align:center">'.$tags3[0].'</td>
    <td style="text-align:center">'.$tags3[1].'</td>
  </tr>
     ';
  }
  $tbl4.=' </table>';
$pdf->writeHTML($tbl4, true, false, true, false, '');


 $tbl5 = '';
$tbl5.='
<table border="1"  width="100%" border="0.5" cellpadding="3">
 <tr nobr="true">
    <td colspan="4" valign="top" bgcolor="#F5EA03" style="color:#000000">MICROBIOLOGICAL STANDARDS</td>
  </tr>
  
   <tr nobr="true">			
    <td width="238" valign="top"><strong>Test</strong></td>
    <td  width="100" valign="top"><strong>Target Level</strong></td>
	<td width="100" valign="top"><strong>Reject Level</strong></td>
    <td   width="200" valign="top"><strong>Testing </strong></td>
  </tr>
  ';
   $sq5=mysqli_query($con,"select t1.*,t2.*  from tblproductdetail t1, tblsaveans1 t2  where t1.pid='$sno' and t1.sid='10' and t2.sno=t1.id");
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

$rep=str_replace('&le;','<',$row['storage']);

$tbl9 = '';
$tbl9.='
<table border="1"  width="100%" border="0.5" cellpadding="3">
 <tr nobr="true">
    <td colspan="2" valign="top" bgcolor="#F5EA03" style="color:#000000">PRODUCT STORAGE / SHELF LIFE/LABELLING</td>
  </tr>

<tr nobr="true">
    <td valign="top">Product Shelf-life </td>
	<td valign="top">'.$row['shelflife'].'</td>
  </tr>
  <tr nobr="true">
    <td valign="top">Storage</td>
	<td valign="top">'.$row['storage'].'</td>
  </tr>

</table>';
  

$pdf->writeHTML($tbl9, true, false, true, false, '');




$tbl8 = '';
$tbl8.='
<table border="1"  width="100%" border="0.5" cellpadding="3">
 <tr nobr="true">
    <td colspan="2" valign="top" bgcolor="#F5EA03" style="color:#000000">PACKAGING</td>
  </tr>
  ';
   $sq8=mysqli_query($con,"select t1.*,t2.*  from tblproductdetail t1, tblsaveans1 t2  where t1.pid='$sno' and t1.sid='15' and t2.sno=t1.id");
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
    <td colspan="2" valign="top" bgcolor="#F5EA03" style="color:#000000">Agreed on behalf of Disotto</td>
  </tr>

 <tr nobr="true">
    <td  valign="top">Signature</td>
    <td   valign="top"></td>
  </tr>
  <tr nobr="true">
    <td  valign="top">Print Name</td>
    <td   valign="top"> </td>
  </tr>
  <tr nobr="true">
    <td  valign="top">Position</td>
    <td  valign="top">Technical Coordinator</td>
  </tr>
  <tr nobr="true">
    <td  valign="top">Date</td>
    <td valign="top"></td>
	</tr>
	
    <tr nobr="true">
	<td  valign="top">Issue No</td>
    <td  valign="top"></td>
  </tr>
  
 
</table>';
  

$pdf->writeHTML($tbl12, true, false, true, false, '');




$str = preg_replace('/[^A-Za-z0-9_-]/','', $row['prodname']);
$pdf->lastPage();
ob_clean();
// $pdf->Output($_SERVER['DOCUMENT_ROOT'] . "pdf/".$str."-Specifiation.pdf","F"); //online
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