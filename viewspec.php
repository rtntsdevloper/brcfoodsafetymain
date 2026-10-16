<?php
ini_set('max_execution_time', 50000);
ini_set('memory_limit','-1');

require('tcpdf/tcpdf.php');


	
										$sno=$_GET['sno'];
										$sql=mysqli_query($con,"select * from tblproduct where id='$sno'");
										$row=mysqli_fetch_array($sql);
										$nuts=explode(';',$row['allergen']);
										

class MYPDF extends TCPDF {
private $longTableHeader = '';
       
	   public function Header() 
{
$this->SetX(15);
$this->SetFont('centurygothic', '',10);
 $this->writeHTML($this->longTableHeader);
} 
 public function setLongTableHeader($html)
   {
     $this->longTableHeader = $html;
   }

	    public function Footer()
	    {
        $this->SetY(-10);
        $this->SetFont('centurygothic', 'I', 8);
        $this->Cell(20, 5, 'Version Number: 2 ', 0, false, 'C', 0, '', 0, false, 'T', 'M');
		$this->Cell(270, 5, "Issue Date: 09/08/24", 0, false, 'C', 0, '', 0, false, 'T', 'M');

    }
	
    
}
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->SetMargins(PDF_MARGIN_LEFT, 30, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM-10);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

$pdf->AddPage();

$pdf->SetFont('centurygothic', '', 10);

$pdf->SetXY(15,5);
$tblheder=<<<EOD

<table border="1"  height="30" cellpadding="10">
  <tr >
    <td width="20%" style="text-align:center" >$row[prodcode]</td>
    <td width="60%" align="center">PRODUCT SPECIFICATION</td>
    <td width="20%" align="center"><img src="images/1.png" style="width:80px"></td>
  </tr>
</table>

EOD;
$pdf->writeHTML($tblheder, true, false, true, false, '');
$pdf->setLongTableHeader($tblheder);

$tbl_header2 = '<style>
table {
   border-collapse: collapse;
   border-spacing: 0;
   margin: 0 10px;
   border:0.5px solid #000000;
}
tr {
   padding: 1px 0;
}
th {
   padding: 1px 0;
  font-weight:bold;
  
   
}
td {
   padding: 1px 0;
  font-weight:100;
   
}
</style>
<table width="100%" cellspacing="0" cellpadding="3" border="0.2">';
$tbl_footer2 = '</table>';

$tbl2 .= '
 <tr nobr="true">
    <th>Product Id:</th>
    <td colspan="3">'.$row['prodid'].'</td>
  </tr>
  <tr nobr="true">
    <th>Product Code:</th>
    <td colspan="3">'.$row['prodcode'].'</td>
  </tr>
  <tr nobr="true">
    <th>Product Name:</th>
    <td colspan="3">'.$row['name'].'</td>
  </tr>
  <tr nobr="true">
    <th>Product Type:</th>
    <td colspan="3">'.$row['ptype'].'</td>
  </tr>
  <tr nobr="true">
    <th>Shelf Life:</th>
    <td colspan="3">'.$row['slife'].'</td>
  </tr>
  <tr nobr="true">
    <th>Product Claim:</th>
    <td colspan="3">'.$row['claim'].'</td>
  </tr>
  <tr nobr="true">
    <th colspan="4" >Product Ingredient:</th>
  </tr>
  <tr nobr="true">
    <td colspan="4">'.$row['ingre'].'</td>
    
  </tr>
  <tr nobr="true">
    <th colspan="4" style="text-align:center;">Nutrional Information:</th>
  </tr>
  <tr nobr="true">
    <th>Type</th>
    <td colspan="3">Per 100 g </td>
  </tr>
  <tr nobr="true">
    <th>Energy (KJ):</th>
    <td colspan="3">'.round($row['kj'],2).'</td>
  </tr>
  <tr nobr="true">
    <th>Energy (Kcal):</th>
    <td colspan="3">'.round($row['kcl'],2).'</td>
  </tr>
  <tr nobr="true">
    <th>Fat:</th>
    <td colspan="3">'.round($row['fat'],2).'</td>
  </tr>
  <tr nobr="true">
    <th>Of which Saturated:</th>
    <td colspan="3">'.round($row['saturate'],2).'</td>
  </tr>
  <tr nobr="true">
    <th>Carbohydrate:</th>
    <td colspan="3">'.round($row['carb'],2).'</td>
  </tr>
  <tr nobr="true">
    <th>Of which sugar:	</th>
    <td colspan="3">'.round($row['sugar'],2).'</td>
  </tr>
  <tr nobr="true">
    <th>Protein:</th>
    <td colspan="3">'.round($row['protein'],2).'</td>
  </tr>
  <tr nobr="true">
    <th>Salt:</th>
    <td colspan="3">'.round($row['salt'],2).'</td>
  </tr>
  <tr nobr="true">
    <th colspan="4" style="text-align:center;">Allergen Information : </th>
  </tr>
  <tr nobr="true">
    <th>Type</th>
    <th colspan="3">Present in the Product</th>
  </tr>
  <tr nobr="true">
    <th>TreeNuts:</th>
    <td colspan="3">'.$nuts[0].'</td>
  </tr>
  
  <tr nobr="true">
    <th>Celery:</th>
    <td colspan="3">'.$nuts[1].'</td>
  </tr>
  
 
  <tr nobr="true">
    <th>Crustaceans:</th>
    <td colspan="3">'.$nuts[2].'</td>
  </tr>
 
  <tr nobr="true">
    <th>Eggs:</th>
    <td colspan="3">'.$nuts[3].'</td>
  </tr>

  <tr nobr="true">
    <th>Fish:</th>
    <td colspan="3">'.$nuts[4].'</td>
  </tr>
 
  <tr nobr="true">
    <th>Gluten:</th>
    <td colspan="3">'.$nuts[5].'</td>
  </tr>
 
  <tr nobr="true">
    <th>Lupin:</th>
    <td colspan="3">'.$nuts[6].'</td>
  </tr>
 
  <tr nobr="true">
    <th>Milk:</th>
    <td colspan="3">'.$nuts[7].'</td>
  </tr>
 
  <tr nobr="true">
    <th>Molluscs:</th>
    <td colspan="3">'.$nuts[8].'</td>
  </tr>
 
  <tr nobr="true">
    <th>Mustard:</th>
    <td colspan="3">'.$nuts[9].'</td>
  </tr>
  
  <tr nobr="true">
    <th>Peanut:</th>
    <td colspan="3">'.$nuts[10].'</td>
  </tr>
  
  <tr nobr="true">
    <th>Sesame:</th>
    <td colspan="3">'.$nuts[11].'</td>
  </tr>
 
  <tr nobr="true">
    <th>Soya:</th>
    <td colspan="3">'.$nuts[12].'</td>
  </tr>
 
  <tr nobr="true">
    <th>Sulphites:</th>
    <td colspan="3">'.$nuts[13].'</td>
  </tr>
 
  <tr nobr="true">
    <th colspan="4" style="text-align:center;">Microbiological  Information : </th>
    </tr>
  <tr nobr="true">
    <td>&nbsp;</td>
    <td>Accept</td>
    <td>Reject</td>
    <td>Frequency</td>
  </tr>
  <tr nobr="true">
    <td>TVC (cfu/g)</td>
    <td>&lt;10,00,000</td>
    <td>&gt;10,00,000</td>
    <td>Annually</td>
  </tr>
  <tr nobr="true">
    <td>Moulds (cfu/g)</td>
    <td>&lt;100</td>
    <td>&gt;100</td>
    <td>Annually</td>
  </tr>
  <tr nobr="true">
    <td>Yeast (cfu/g)</td>
    <td>&lt;100</td>
    <td>&gt;100</td>
    <td>Annually</td>
  </tr>
  <tr nobr="true">
    <td>Enterobacteriaceae (Cfu/g)</td>
    <td>&lt;20</td>
    <td>&gt;100</td>
    <td>Annually</td>
  </tr>
  <tr nobr="true">
    <td>Staphylococcus (cfu/g)</td>
    <td>&lt;20</td>
    <td>&gt;100</td>
    <td>Annually</td>
  </tr>
  <tr nobr="true">
    <td>Bacillus cerurs (cfu/g)</td>
    <td>Absent</td>
    <td>Present</td>
    <td>Annually</td>
  </tr>
  <tr nobr="true">
    <td>Salmonella spp (per 25g)</td>
    <td>Absent</td>
    <td>Present</td>
    <td>Annually</td>
  </tr>
  <tr nobr="true">
    <td>E. coli (cfu/g)</td>
    <td>&lt;20</td>
    <td>&gt;100</td>
    <td>Annually</td>
  </tr>
  ';
     

$pdf->writeHTML($tbl_header2 . $tbl2 . $tbl_footer2, true, false, false, false, '');



$pdf->Output($_SERVER['DOCUMENT_ROOT']."brcfoodsafety/pdf/".$row['prodcode'].".pdf","F");
?>






<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Product Management</a></li>
                        <li>View Detail</li>
                    </ul>
                </div>
				
				
		
			       <div class="row mb-12">
                    <div class="col-md-12 mb-12">
                        <div class="card text-left">
                            <div class="card-body">
							<a href="pdf/<?php echo $row['prodcode'];?>.pdf" target="_blank"><button class="btn btn-warning" style="float:right; margin-left:15px">View Specification</button></a>
                           
							
                             <h4 class="card-title mb-3">View Specification</h4>
								
								 <div class="row">
                                    
									
									
								
								  <div class="table-responsive">
                                    
									
										 <table class="table dataTable-collapse" id="sales_table">
                                      <tr nobr="true">
    <td>Product Id:</td>
    <td colspan="3"><?php echo $row['prodid'];?></td>
  </tr>
  <tr nobr="true">
    <td>Product Code:</td>
    <td colspan="3"><?php echo $row['prodcode'];?></td>
  </tr>
  <tr nobr="true">
    <td>Product Name:</td>
    <td colspan="3"><?php echo $row['name'];?></td>
  </tr>
   <tr nobr="true">
    <td>Product Type :</td>
    <td colspan="3"><?php echo $row['ptype'];?></td>
  </tr>
   <tr nobr="true">
    <td>Shelf Life:</td>
    <td colspan="3"><?php echo $row['slife'];?></td>
  </tr>
  <tr nobr="true">
    <td>Product Claim:</td>
    <td colspan="3"><?php echo $row['claim'];?></td>
  </tr>
  <tr nobr="true">
    <td colspan="4">Product Ingredient:</td>
  </tr>
  <tr nobr="true">
    <td colspan="4"><?php echo $row['ingre'];?></td>
  </tr>
  <tr nobr="true">
    <td colspan="4">Nutrional Information:</td>
  </tr>
  <tr nobr="true">
    <td>Type</td>
    <td colspan="3">Per 100 g </td>
  </tr>
  <tr nobr="true">
    <td>Energy (KJ):</td>
    <td colspan="3"><?php echo round($row['kj'],2);?></td>
  </tr>
  <tr nobr="true">
    <td>Energy (Kcal):</td>
    <td colspan="3"><?php echo round($row['kcl'],2);?></td>
  </tr>
  <tr nobr="true">
    <td>Fat:</td>
    <td colspan="3"><?php echo round($row['fat'],2);?></td>
  </tr>
  <tr nobr="true">
    <td>Of which Saturated:</td>
    <td colspan="3"><?php echo round($row['saturate'],2);?></td>
  </tr>
  <tr nobr="true">
    <td>Carbohydrate:</td>
    <td colspan="3"><?php echo round($row['carb'],2);?></td>
  </tr>
  <tr nobr="true">
    <td>Of which sugar:	</td>
    <td colspan="3"><?php echo round($row['sugar'],2);?></td>
  </tr>
  <tr nobr="true">
    <td>Protein:</td>
    <td colspan="3"><?php echo round($row['protein'],2);?></td>
  </tr>
  <tr nobr="true">
    <td>Salt:</td>
    <td colspan="3"><?php echo round($row['salt'],2);?></td>
  </tr>
  <tr nobr="true">
    <td colspan="4">Allergen Information : </td>
  </tr>
  <tr nobr="true">
    <td>Type</td>
    <td colspan="3">Present in the Product</td>
  </tr>
  <tr nobr="true">
    <td>TreeNuts:</td>
    <td colspan="3"><?php echo $nuts[0];?></td>
  </tr>
  <tr nobr="true">
    <td>Celery:</td>
    <td colspan="3"><?php echo $nuts[1];?></td>
  </tr>
  
  <tr nobr="true">
    <td>Crustaceans:</td>
    <td colspan="3"><?php echo $nuts[2];?></td>
  </tr>
  <tr nobr="true">
    <td>Eggs:</td>
    <td colspan="3"><?php echo $nuts[3];?></td>
  </tr>
  <tr nobr="true">
    <td>Fish:</td>
    <td colspan="3"><?php echo $nuts[4];?></td>
  </tr>
  <tr nobr="true">
    <td>Gluten:</td>
    <td colspan="3"><?php echo $nuts[5];?></td>
  </tr>
  <tr nobr="true">
    <td>Lupin:</td>
    <td colspan="3"><?php echo $nuts[6];?></td>
  </tr>
  <tr nobr="true">
    <td>Milk:</td>
    <td colspan="3"><?php echo $nuts[7];?></td>
  </tr>
  <tr nobr="true">
    <td>Molluscs:</td>
    <td colspan="3"><?php echo $nuts[8];?></td>
  </tr>
  <tr nobr="true">
    <td>Mustard:</td>
    <td colspan="3"><?php echo $nuts[9];?></td>
  </tr>
  <tr nobr="true">
    <td>Peanut:</td>
    <td colspan="3"><?php echo $nuts[10];?></td>
  </tr>
  <tr nobr="true">
    <td>Sesame:</td>
    <td colspan="3"><?php echo $nuts[11];?></td>
  </tr>
  <tr nobr="true">
    <td>Soya:</td>
    <td colspan="3"><?php echo $nuts[12];?></td>
  </tr>
  <tr nobr="true">
    <td>Sulphites:</td>
    <td colspan="3"><?php echo $nuts[13];?></td>
  </tr>
  <tr nobr="true">
    <td colspan="4">Microbiological  Information : </td>
    </tr>
  <tr nobr="true">
    <td>&nbsp;</td>
    <td>Accept</td>
    <td>Reject</td>
    <td>Frequency</td>
  </tr>
  <tr nobr="true">
    <td>TVC (cfu/g)</td>
    <td>&lt;10,00,000</td>
    <td>&gt;10,00,000</td>
    <td>Annually</td>
  </tr>
  <tr nobr="true">
    <td>Moulds (cfu/g)</td>
    <td>&lt;100</td>
    <td>&gt;100</td>
    <td>Annually</td>
  </tr>
  <tr nobr="true">
    <td>Yeast (cfu/g)</td>
    <td>&lt;100</td>
    <td>&gt;100</td>
    <td>Annually</td>
  </tr>
  <tr nobr="true">
    <td>Enterobacteriaceae (Cfu/g)</td>
    <td>&lt;20</td>
    <td>&gt;100</td>
    <td>Annually</td>
  </tr>
  <tr nobr="true">
    <td>Staphylococcus (cfu/g)</td>
    <td>&lt;20</td>
    <td>&gt;100</td>
    <td>Annually</td>
  </tr>
  <tr nobr="true">
    <td>Bacillus cerurs (cfu/g)</td>
    <td>Absent</td>
    <td>Present</td>
    <td>Annually</td>
  </tr>
  <tr nobr="true">
    <td>Salmonella spp (per 25g)</td>
    <td>Absent</td>
    <td>Present</td>
    <td>Annually</td>
  </tr>
  <tr nobr="true">
    <td>E. coli (cfu/g)</td>
    <td>&lt;20</td>
    <td>&gt;100</td>
    <td>Annually</td>
  </tr>
                                    </table>
								</div></div></div></div></div></div></div>
								
							