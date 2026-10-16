<?php
include 'connection.php';
//product nd date wise

$prodid=$_GET['prodid'];
$date=$_GET['date'];



$sql=mysqli_query($con,"select t1.pname, t1.uom, t2.*, t3.*, SUM(t3.box) AS c1,SUM(t3.qty) AS s1, t4.grnno,t4.po,t4.date AS dt,t4.id AS tid,t4.user from tblproduct t1, tblsupplier t2, tblgrn t3 , tblgrnno t4 where t1.id=t3.product and t2.supid=t3.supplier and t3.grncode=t4.grnno and t3.cdate='$date' and t3.product='$prodid' group by t3.product");
$row=mysqli_fetch_array($sql);


$pdate=date('d-m-Y', strtotime($date));




require('tcpdf/tcpdf.php');
ini_set('max_execution_time', 300);
// create new PDF document
class MYPDF extends TCPDF {

    public function Header() {
       $image_file = 'images/hbh.png';
        $this->Image($image_file, 130, 2, 30, '', 'PNG', '', 'T', false, 200, '', false, false, 0, false, false, false);
     
        
    }

    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('centurygothic', 'I', 8);
        $this->Cell(20, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
		      
    }
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 003');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

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

$pdf->SetFont('centurygothic', 'B', 10);


$pdf->AddPage('L');
$pdf->SetXY(125,30);
$pdf->Write(0, "GOODS RECIEVED NOTE", '', '0', '0', true, 'C', false, false, 0);




$pdf->SetFont('centurygothic', '',12);

$pdf->SetXY(5,38);


$tble7=<<<EOD
<table width="800" border="0" style="font-weight:bold; font-size:12px " cellpadding="2">
 
 <tr>
    <td >Date : $pdate</td></tr>
 
	<tr> <td >Product : $row[pname]</td></tr>
  
  </table>
EOD;
$pdf->writeHTML($tble7, true, false, true, false, '');

$pdf->SetFont('centurygothic', '',10);


$pdf->SetXY(5,50);

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
   text-align: left;
}
td {
  
    border: 1px solid #000000;
   color: #000000;
}
</style>
<table id="gallerytab" width="1200" cellspacing="0" cellpadding="4" border="0">
  ';
	
$tbl_footer = '</table>';

$tbl7 = '';
$tbl7 .= '
  <tr>
    <th width="50" >SNo</th>
    <th width="200" >Supplier</th>
    <th width="80" >Box</th>
	 <th width="80" >P&deg;C</th>
	  <th width="80" >V&deg;C</th>
	   <th width="80" >Qty</th>
	    <th width="100" >Kill Date</th>
		 <th width="160" >Use By / Best Before </th>
		   <th width="140" >GRN</th>
  </tr>';
  
  $tb=0;
  $sql5=mysqli_query($con,"select t1.pname, t1.uom, t2.*, t3.*, SUM(t3.box) AS c1,SUM(t3.qty) AS s1, t4.grnno,t4.po,t4.date AS dt,t4.id AS tid,t4.user from tblproduct t1, tblsupplier t2, tblgrn t3 , tblgrnno t4 where t1.id=t3.product and t2.supid=t3.supplier and t3.grncode=t4.grnno and t3.cdate='$date' and t3.product='$prodid' group by t3.product");
$i=0;
while($row5=mysqli_fetch_array($sql5))
{
  $i++;
 
  
$ub="";
$bb="";

if($row5['bestbefore']!="")
{
$bb=date('d-m-Y',strtotime($row5['bestbefore']));
}

if($row5['useby']!="")
{
$ub=date('d-m-Y',strtotime($row5['useby']));
}

  $tbl7 .= ' <tr>
    <td  >'.$i.'</td>
    <td  >'.$row5['supname'].'</td>
    <td >'.$row5['c1'].'</td>
	 <td >'.$row5['ptemp'].'&deg;C</td>
	  <td >'.$row5['vtemp'].'&deg;C</td>
	   <td  >'.$row5['c1'].' '.$row5['uom'].'</td>
	    <td  >'.date('d-m-Y',strtotime($row5['killdate'])).'</td>
		 <td >'.$ub.' '.$bb.'</td>
		
		   <td >'.$row5['grn'].'</td>
  </tr>
  ';
  }
  
  $pdf->writeHTML($tbl_header . $tbl7 . $tbl_footer, true, false, false, false, '');

 $x1=mysqli_query($con,"select SUM(box) AS cnt from tblgrn where grncode!='' and product='$prodid' and cdate='$date'");
 $y1  = mysqli_fetch_array($x1);
    $num1=$y1['cnt'];




$tble7=<<<EOD
<table width="1070" border="0" style="font-weight:bold; font-size:12px " cellpadding="2">
   <tr>
    <td width="870"><div align="right">Total Trays:</div></td>
    <td width="100">$num1</td>
  </tr>
 
  
  </table>
EOD;
$pdf->writeHTML($tble7, true, false, true, false, '');
ob_clean();
$pdf->Output("pdf/".$row['pname']."-".$date.".pdf","F");
?>
<iframe width="100%" height="900" src="pdf/<?php echo $row['pname'];?>-<?php echo $date;?>.pdf"></iframe>