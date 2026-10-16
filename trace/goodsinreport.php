<?php
$snox = $_GET['sno'];
$sql1 = mysqli_query($con, "select t1.pname, t1.uom, t2.*, t3.*, SUM(t3.box) AS c1,SUM(t3.qty) AS s1, t4.grnno,t4.ans,t4.po,t4.cdate AS dt,t4.user from tblrawmaterial t1, tblrawsupplier t2, tblgrn1 t3 , tblgrnno2 t4 where t1.id=t3.product and t2.supid=t3.supplier and t3.grncode=t4.grnno and t4.id='$snox' group by t3.product");
$row2 = mysqli_fetch_array($sql1);



$date = date('d-m-Y h:m:s', strtotime($row2['dt']));



require('tcpdf/tcpdf.php');

ini_set('max_execution_time', 300);
// create new PDF document
class MYPDF extends TCPDF
{

  private $longTableHeader = '';
  private $longTableFooter = '';

  public function Header()
  {

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
    $this->SetY(-16);
    $this->SetFont('centurygothic', '', 8);
    $this->writeHTML($this->longTableFooter);




  }
  public function setLongTableFooter($html)
  {
    $this->longTableFooter = $html;
  }
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);

$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->SetMargins(5, 35, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);


$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);


$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
  require_once(dirname(__FILE__) . '/lang/eng.php');
  $pdf->setLanguageArray($l);
}

$pdf->SetFont('centurygothic', 'B', 14);


$pdf->AddPage();

$footer = <<<EOD


<table border="1" cellpadding="6" width="100%" >
    <tr>
        <td width="33%">Issue date: 12/09/2024</td>
        <td width="34%">Ref No:3.5.1  </td>
        <td width="33%">Author : Usama Mustafa</td>
    </tr>
    <tr>
        <td width="33%">Version No: 01</td>
        <td width="34%">Reason for change: New Document</td>
        <td width="33%">Authorised by: Paramvir Singh Deol</td>
    </tr>

</table>
EOD;
$pdf->setLongTableFooter($footer);



$pdf->SetXY(75, 10);
//$pdf->Write(0, "GOODS RECIEVED NOTE", '', '0', '0', true, 'C', false, false, 0);
//$pdf->write1DBarcode($row2[grnno], 'C39', 'fromleft', 'from top', 'width', height, 0.3,'', 'N');
//$pdf->write1DBarcode($row2['grnno'], 'C39', '82', '13', '40', 8, 0.3,'', 'N');

$pdf->SetFont('centurygothic', 'B', 11);

$htmll = "";
$params = $pdf->serializeTCPDFtagParameters(array($row2['grnno'], 'C39', '83', '13', '40', 8, 0.3, '', 'N'));
$htmll .= '<tcpdf method="write1DBarcode" params="' . $params . '" />';

$pdf->SetXY(5, 5);
$tble11 = <<<EOD
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

$pdf->SetFont('centurygothic', '', 12);

$pdf->SetXY(5, 5);



$tble8 = <<<EOD
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


$pdf->SetXY(5, 35);

$tble7 = <<<EOD
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

$pdf->SetFont('centurygothic', '', 8);




$pdf->SetXY(5, 55);



$string = $row2['ans'];
$tags = explode(';', $string);



$tble9 = <<<EOD
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



$pdf->SetXY(5, 75);


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
    <th width="150" >Product Description</th>
    <th width="80" >Box</th>
	   <th width="80" >Total Quantity</th>
		 <th width="90" >Use By / Best Before</th>
		  <th width="70" >Batchcode</th>
		    <th width="90" >Product Temperature</th>
		   <th width="100" >GRN</th>
  </tr>
  </thead>
  ';
$sql2 = mysqli_query($con, "select t1.pname, t1.uom, t2.*, t3.*, t3.useby AS ub, t3.killdate AS killd , t3.box AS c1,t3.qty AS s1, t4.grnno,t4.po,t4.cdate AS dt,t4.user from tblrawmaterial t1, tblrawsupplier t2, tblgrn1 t3 , tblgrnno2 t4 where t1.id=t3.product and t2.supid=t3.supplier and t3.grncode=t4.grnno and t4.id='$_GET[sno]'");

$i = 0;
while ($row5 = mysqli_fetch_array($sql2)) {
  $i++;
  $ub = "";
  $bb = "";

  if ($row5['ub'] == "" || $row5['ub'] == "0000-00-00" || $row5['ub'] == "N/A") {
    $ub = "N/A";
  } else {
    $ub = date('d-m-Y', strtotime($row5['ub']));
  }

  if ($row5['killd'] == "" || $row5['killd'] == "0000-00-00" || $row5['killd'] == "N/A") {
    $killdate = "N/A";
  } else {
    $killdate = $row5['killd'];
  }

  if ($row5['ptemp'] == "N/A") {
    $ptemp = "N/A";
  } else {
    $ptemp = $row5['ptemp'] . '&deg;C';
  }

  if ($row5['uomm'] == "undefined" || $row5['uomm'] == "") {
    $uomm = "";
  } else {
    $uomm = $row5['uomm'] . ":";
  }
  if ($row5['vtemp'] == "") {
    $vtemp = "N/A";
  } else {
    $vtemp = $row5['vtemp'] . '&deg;C';
  }

  $tbl7 .= '
  <tbody>
  <tr nobr="true">
    <td  width="40" >' . $i . '</td>
    <td  width="150" >' . $row5['pname'] . '</td>
    <td width="80">' . $row5['c1'] . '</td>
	
	   <td  width="80">' . $row5['s1'] . ' ' . $row5['uom'] . '</td>
		 <td width="90">' . $uomm . '  ' . $ub . '</td>
		  <td width="70">' . $row5['batchcode'] . '</td>
		  <td width="90">' . $killdate . '</td>
		
		   <td width="100">' . $row5['grn'] . '</td>
  </tr>
  </tbody>
  ';

}

$pdf->writeHTML($tbl_header . $tbl7 . $tbl_footer, true, false, false, false, '');

$x1 = mysqli_query($con, "select SUM(box) AS cnt from tblgrn1 where grncode='$row2[grnno]'");
$y1 = mysqli_fetch_array($x1);
$num1 = $y1['cnt'];



$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "pdf/Goods_" . $row2['grnno'] . ".pdf", "F");
?>





<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
  .stage-card {
    background: #ffffff;
    border: 1px solid #e5e8f0;
    border-radius: 18px;
    padding: 24px;
    transition: all .35s cubic-bezier(.4, 0, .2, 1);
    position: relative;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0, 0, 0, .03), 0 4px 16px -4px rgba(0, 0, 0, .04);
  }

  .stage-card:hover {
    border-color: rgba(234, 88, 12, .35);
    transform: translateY(-3px);
    box-shadow: 0 8px 32px -4px rgba(234, 88, 12, .1), 0 4px 16px -4px rgba(0, 0, 0, .06);
  }

  .stage-head {
    display: flex;
    align-items: center;
    gap: 14px;
    padding-bottom: 18px;
    margin-bottom: 18px;
    border-bottom: 1px solid #e5e8f0;
  }

  .stage-icon.cool-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: grid;
    place-items: center;
    font-size: 20px;
    flex-shrink: 0;
    background: linear-gradient(135deg, rgba(59, 130, 246, .12), rgba(59, 130, 246, .04));
    color: #1a5204ff;
    border: 1px solid rgba(59, 130, 246, .18);
  }

  .stage-title {
    font-size: 16px;
    font-weight: 700;
    color: #1a1d2e;
  }

  .stage-sub {
    font-size: 11px;
    color: #8891a8;
    text-transform: uppercase;
    letter-spacing: 1.2px;
    margin-top: 2px;
  }

  .pdf-frame-wrap {
    border: 1px solid #e5e8f0;
    border-radius: 12px;
    overflow: hidden;
    background: #f7f8fc;
    position: relative;
  }

  .pdf-frame-wrap::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(59, 130, 246, .2), transparent);
    z-index: 1;
  }

  .pdf-frame-wrap iframe {
    width: 100%;
    height: 520px;
    display: block;
    border: none;
  }
</style>


<div class="animate-in delay-4">
  <div class="stage-card">
    <div class="stage-head">
      <div class="stage-icon cool-icon"><i class="bi bi-file-text"></i></div>
      <div>
        <div class="stage-title">Goods In Record</div>
        <div class="stage-sub">Document Viewer</div>
      </div>
    </div>
    <div class="pdf-frame-wrap">
      <iframe src="<?php echo "pdf/Goods_" . $row2['grnno'] . ".pdf"; ?>" frameborder="0"></iframe>
    </div>
  </div>
</div>