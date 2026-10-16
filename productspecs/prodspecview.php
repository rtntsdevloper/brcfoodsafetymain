<?php
ini_set('max_execution_time', 600);
ini_set('memory_limit', '-1');


$spo = $_GET['pro'];
$vrd = mysqli_query($con, "SELECT * FROM `save_specification3` WHERE `id` = '$spo' ");
$vrdrow = mysqli_fetch_array($vrd);

$sno = $vrdrow['pid'];

$sql = mysqli_query($con, "select * from tblproduct1 where prodid='$sno' ");
$row = mysqli_fetch_array($sql);

$sql5 = mysqli_query($con, "select * from tblproduct1 where prodid='$sno' ");
$row5 = mysqli_fetch_array($sql5);

$nxnm = $row5['nutname'];
$nxnm1 = explode(';', $nxnm);







require('tcpdf/tcpdf.php');
ob_start();


class MYPDF extends TCPDF
{
  public function Header()
  {
    $image_file = 'images/1.png';

    $this->Image($image_file, 15, 5, 25, '', 'png', '', 'T', false, 200, '', false, false, 0, false, false, false);

    $this->SetFont('century gothic', '', 20);

    $this->SetXY(70, 0);
    $this->Write(30, 'Product Specification', '', 0, '10', true, 0, false, false, 0);
  }

  public function Footer()
  {
    // Set position at 25 mm from bottom
    $this->SetY(-20);

    // Set font
    $this->SetFont('century gothic', '', 9);

    // Footer content with improved styling
    $footerContent = '
     
        <table border="1" cellpadding="4">
            <tr>
                <td width="34%">Issue date: ' . '</td>
                <td width="33%" rowspan="2" style="text-align:center;" >Page ' . $this->getAliasNumPage() . ' of ' . $this->getAliasNbPages() . '</td>
                <td width="33%">Author: </td>
            </tr>
            <tr>
                <td width="34%">Version: 01</td>
                <td width="33%">Authorised by: </td>
            </tr>
            <tr>
                <td  width="67%" colspan="2">Reason for Change: New form</td>
                <td width="33%">Print on: </td>
            </tr>
        </table>';

    $this->writeHTML($footerContent, true, false, true, false, '');
  }
}
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


$pdf->SetCreator(PDF_CREATOR);
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->SetMargins(PDF_MARGIN_LEFT, 37, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
  require_once(dirname(__FILE__) . '/lang/eng.php');
  $pdf->setLanguageArray($l);
}

// Get footer data from database
$qsp = mysqli_query($con, "SELECT * FROM `tblformcontrol` WHERE tabname ='MRM'");
$qsp1 = mysqli_fetch_array($qsp);

// Prepare footer data
$qspdate = date('d/m/Y', strtotime($qsp1['issuedate']));
$footerData = [
  'issuedate' => $qspdate,
  'docref' => $qsp1['docref'] ?? 'REC 6.3.3', // Fallback value
  'author' => $qsp1['author'] ?? 'Bijal Chauhan',
  'authorisedby' => $qsp1['authorisedby'] ?? 'Paramvir S. Deol'
];



$pdf->AddPage();


$pdf->SetFont('century gothic', '', 20);


$html1x = <<<EOF
<h2 align="center">Product Name : $vrdrow[prodname] </h2>
<br>
<br><br>
<br>
<table   width="100%"  cellpadding="3" align="center">


<tr nobr="true">
<td  colspan="2"><img src="product/$row[img]"  height="600" style="border:1px solid #000;"></td>
	 
</tr>
 
</table>
EOF;

// $pdf->writeHTML($html1x, true, false, true, false, '');

// $pdf->AddPage();
// output the HTML content


$pdf->SetFont('century gothic', '', 11, 'B');

$html1x = <<<EOF
<table border="1"  width="100%" border="0.5" cellpadding="3">
  <tr nobr="true">
    <td colspan="2" valign="top" bgcolor="#063970" style="color:#fff; font-size:20px;" >Product Information</td>
  </tr>
   <tr nobr="true">
    <th  valign="top">Product Name </th>
    <td  valign="top">$row[prodname]</td>
  </tr>
  

  <tr nobr="true">
    <th  valign="top">Product Weight  </th>
    <td  valign="top">$row[weight]</td>
  </tr>
  <tr nobr="true">
    <th  valign="top">Product Code  </th>
    <td  valign="top">$row[prodcode]</td>
  </tr>
   <tr nobr="true">
    <th  valign="top">Product Description </th>
    <td  valign="top">$row[descc]</td>
  </tr>
  
   <tr nobr="true">
    <th  valign="top">Marketing Text </th>
    <td  valign="top">$row[mark]</td>
  </tr>

</table>
EOF;

// output the HTML content
$pdf->writeHTML($html1x, true, false, true, false, '');


$pdf->SetFont('century gothic', '', 11, 'B');


$html1x = <<<EOF
<table border="1" width="100%" cellpadding="8" cellspacing="0">
  <thead>
    <tr>
      <th colspan="2" style=" font-size:18px; padding:8px; color:white;background-color: #063970; border:1px solid #000;">
        Product Images
      </th>
    </tr>
  </thead>
  <tbody>
    <tr nobr="true">
      <td valign="top">Finished product picture</td>
      <td valign="top"> <a href="productspecs/specpic/$vrdrow[finishpic]" target="_blank"> <img src="productspecs/specpic/$vrdrow[finishpic]" height="300"  style="border:1px solid #000;"></a></td>
    </tr>
    <tr nobr="true">
      <td valign="top">Packed product picture</td>
      <td valign="top"><a href="productspecs/specpic/$vrdrow[packpic]" target="_blank"><img src="productspecs/specpic/$vrdrow[packpic]" height="300"  style="border:1px solid #000;"></a></td>
    </tr>
    <tr nobr="true">
      <td valign="top">Outer case picture</td>
      <td valign="top"><a href="productspecs/specpic/$vrdrow[outerpic]" target="_blank"><img src="productspecs/specpic/$vrdrow[outerpic]" height="300"  style="border:1px solid #000;"></a></td>
    </tr>
  </tbody>
</table>
EOF;


// output the HTML content
$pdf->writeHTML($html1x, true, false, true, false, '');


$tbl6 = '';


$ingd = mysqli_query($con, "SELECT * FROM `save_specification4` WHERE pro='$spo' and sid='1'");
$ingdrow = mysqli_fetch_array($ingd);
$pingid = $ingdrow['spec'];

$pingql = mysqli_query($con, "SELECT * FROM `save_specification1`  WHERE `pxid` = '$pingid'");
$pingrow = mysqli_fetch_array($pingql);
$pingre = $pingrow['ans1'];



$pingre2 = preg_replace('/\*\*(.*?)\*\*/', '<b>$1</b>', $pingre);



$pdf->SetFont('courier', '', 11, 'B');
$html4 = <<<EOF

<table border="1"  width="100%" border="0.5" cellpadding="3">
  <tr nobr="true">
    <td colspan="2" valign="top" bgcolor="#063970" style="color: #fff; font-size:20px;" >Product Ingredient</td>
  </tr>
    <tr nobr="true">
    <td colspan="2" valign="top" style="font-size:16px;">$pingre2</td>
  </tr>
 
</table>
EOF;

// output the HTML content
$pdf->writeHTML($html4, true, false, true, false, '');


$pdf->SetFont('century gothic', '', 11, 'B');

$pdf->AddPage();


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

$tbl2 .= '
<table border="1"  width="100%" border="0.5" cellpadding="3">
 <tr nobr="true">
    <td colspan="3" valign="top" bgcolor="#063970" style="color:#fff; font-size:20px;">Nutritional Information Per 100g</td>
  </tr> <tr nobr="true">
    <td  valign="top" bgcolor="#B9D9EB" style="color:#000000" width="34%">Typical values</td>
    <td  valign="top" bgcolor="#B9D9EB" style="color:#000000" width="33%">' . $nxnm1[0] . '</td>
    <td  valign="top" bgcolor="#B9D9EB" style="color:#000000" width="33%">' . $nxnm1[1] . '</td>
  </tr>';

$nutrinx = mysqli_query($con, "SELECT * FROM `save_specification4` WHERE pro='$spo' and sid='2'");
$nutrinx1 = mysqli_fetch_array($nutrinx);
$nutrinxid = $nutrinx1['spec'];

$nutrin = mysqli_query($con, "SELECT * FROM `save_specification1`  WHERE `pxid` = '$nutrinxid'");



while ($row1 = mysqli_fetch_array($nutrin)) {
  $tbl2 .= ' <tr nobr="true">
    <th width="34%" >' . $row1['ques'] . '</th>
      <th width="33%" >' . $row1['ans1'] . '</th>
    <td width="33%">' . $row1['ans2'] . '</td>
  </tr>
 
';
}
$tbl2 .= ' </table>';


$pdf->writeHTML($tbl2, true, false, true, false, '');
$algnx = mysqli_query($con, "SELECT * FROM `save_specification4` WHERE pro='$spo' and sid='3'");
$algnx1 = mysqli_fetch_array($algnx);
$algnxid = $algnx1['spec'];

$algn = mysqli_query($con, "SELECT * FROM `save_specification1`  WHERE `pxid` = '$algnxid'");
$tbl3 = '';

$tbl3 .= '
<table border="1"  width="100%" border="0.5" cellpadding="5" align="center">
 <tr nobr="true" >
    <td colspan="3" valign="top" bgcolor="#063970" style="color:#fff; font-size:20px;" align="left">Allergen Information</td>
  </tr>
  
  
   <tr nobr="true" bgcolor="#B9D9EB">
    <td width="34%" ><strong>Type</strong></td>
    <td width="33%"  style="text-align:center"><strong>Used in the Product</strong></td>
    <td width="33%" style="text-align:center"><strong>Handle on Site</strong></td>
  </tr>
  ';

while ($row2 = mysqli_fetch_array($algn)) {




  $tbl3 .= ' 
   <tr nobr="true" >
    <td>' . $row2['ques'] . '</td>
	 <td>' . $row2['ans1'] . '</td>
	  <td>' . $row2['ans2'] . '</td>
	
  </tr>
';
}
$tbl3 .= '  <tr nobr="true">
    <td  colspan="4"><strong> * If presence &lt;10mg/kg, the presence of sulphites and Sulphur dioxide is not thus subjected has labelling </strong></td>
  </tr>
  </table>';
$pdf->writeHTML($tbl3, true, false, true, false, '');



$tbl4 = '';
$tbl4 .= '
<table border="1"  width="100%" border="0.5" cellpadding="3">
 <tr nobr="true">
    <td colspan="3" valign="top" bgcolor="#063970" style="color:#fff; font-size:20px;">Suitability Information</td>
  </tr>
  <tr nobr="true" bgcolor="#B9D9EB">
    <td width="338" ><strong></strong></td>
    <td width="150"  style="text-align:center"><strong>Yes</strong></td>
    <td width="150" style="text-align:center"><strong>No</strong></td>
  </tr>';
$sutix = mysqli_query($con, "SELECT * FROM `save_specification4` WHERE pro='$spo' and sid='4'");
$sutix1 = mysqli_fetch_array($sutix);
$sutixid = $sutix1['spec'];

$suti = mysqli_query($con, "SELECT * FROM `save_specification1`  WHERE `pxid` = '$sutixid'");
while ($row3 = mysqli_fetch_array($suti)) {
  $tbl4 .= '<tr nobr="true">
    <td>' . $row3['ques'] . '</td>
    <td style="text-align:center">';
  if ($row3['ans1'] == "Yes") {
    $tbl4 .= ' Yes';
  }
  $tbl4 .= ' </td>
    <td style="text-align:center">';
  if ($row3['ans1'] == "No") {
    $tbl4 .= ' No';
  }
  $tbl4 .= ' </td>
  </tr>
     ';
}
$tbl4 .= ' </table>';
$pdf->writeHTML($tbl4, true, false, true, false, '');







$tbl5 = '';
$tbl5 .= '
<table border="1"  width="100%" border="0.5" cellpadding="3">
 <tr nobr="true">
    <td colspan="4" valign="top" bgcolor="#063970" style="color:#fff; font-size:20px;">Microbiological Standard</td>
  </tr>
  
   <tr nobr="true" bgcolor="#B9D9EB">			
    <td width="238" valign="top"><strong>Test</strong></td>
    <td  width="130" valign="top"><strong>Target Level</strong></td>
	<td width="130" valign="top"><strong>Acceptable Level</strong></td>
    <td   width="140" valign="top"><strong>Frequency </strong></td>
  </tr>
  ';
$sutix = mysqli_query($con, "SELECT * FROM `save_specification4` WHERE pro='$spo' and sid='5'");
$sutix1 = mysqli_fetch_array($sutix);
$sutixid = $sutix1['spec'];
$sutiarr = str_replace(';', ',', $sutixid);

$suti = mysqli_query($con, "SELECT * FROM `save_specification_m`  WHERE `id` in ($sutiarr)");;
while ($row6 = mysqli_fetch_array($suti)) {




  $tbl5 .= '  <tr nobr="true">			
    <td valign="top">' . $row6['name'] . '</td>
    <td  valign="top">' . $row6['min'] . '</td>
	<td valign="top">' . $row6['max'] . '</td>
    <td  valign="top">' . $row6['freq'] . '</td>
  </tr>
';
}
$tbl5 .= ' </table>';


$pdf->writeHTML($tbl5, true, false, true, false, '');

$pdf->AddPage();
$tbl6 = '';
$packix = mysqli_query($con, "SELECT * FROM `save_specification4` WHERE pro='$spo' and sid='6'");
$packix1 = mysqli_fetch_array($packix);
$packixid = $packix1['spec'];
$packarr = explode(';', $packixid);

foreach ($packarr as $pack => $packv) {


  $packsg = mysqli_query($con, "SELECT * FROM `save_specification`  WHERE `id` = '$packv'");
  $packsg1 = mysqli_fetch_array($packsg);



  $tbl6 .= '
<table border="1"  width="100%" border="0.5" cellpadding="3">
 <tr nobr="true">
    <td colspan="2" valign="top" bgcolor="#063970" style="color:#fff;font-size:20px;" >' . $packsg1['name'] . '</td>
  </tr>
  ';

  $packdx = mysqli_query($con, "SELECT * FROM `save_specification1`  WHERE `pxid` = '$packv'");
  foreach ($packdx as $row7) {

    $tbl6 .= '<tr nobr="true">			
    <th width="35%" valign="top">' . $row7['ques'] . '</th>
    <td  width="65%" valign="top">' . $row7['ans1'] . '</td> </tr>';
  }
  $tbl6 .= ' </table><br><br>';
}


$pdf->writeHTML($tbl6, true, false, true, false, '');






$tbl9 = '';

$shelf = mysqli_query($con, "SELECT * FROM `save_specification4` WHERE pro='$spo' and sid='7'");
$shelf1 = mysqli_fetch_array($shelf);
$shelfid = $shelf1['spec'];

$shelfl = mysqli_query($con, "SELECT * FROM `save_specification1`  WHERE `pxid` = '$shelfid'");
$tbl9 .= '
<table border="1"  width="100%" border="0.5" cellpadding="3">
 <tr nobr="true">
    <td colspan="2" valign="top" bgcolor="#063970" style="color:#fff; font-size:20px;">Product Storage / Shelf life</td>
  </tr>
';
foreach ($shelfl as $shelfdata) {
  $tbl9 .= '
<tr nobr="true">
    <td valign="top">' . $shelfdata['ques'] . ' </td>
	<td valign="top">' . $shelfdata['ans1'] . '</td>
  </tr>
  ';
}


$tbl9 .= '
</table>';


$pdf->writeHTML($tbl9, true, false, true, false, '');





$tbl11 = '';

$frontf = mysqli_query($con, "SELECT * FROM `save_specification4` WHERE pro='$spo' and sid='8'");
$front1 = mysqli_fetch_array($frontf);
$frontid = $front1['spec'];

$frontl = mysqli_query($con, "SELECT * FROM `save_specification1`  WHERE `pxid` = '$frontid'");
$tbl11 .= '
<table border="1"  width="100%" border="0.5" cellpadding="3">
 <tr nobr="true">
    <td colspan="2" valign="top" bgcolor="#063970" style="color:#fff; font-size:20px;">Front of the pack</td>
  </tr>';
foreach ($frontl as $frontdata) {
  $tbl11 .= '
<tr nobr="true">
    <td valign="top">' . $frontdata['ques'] . '</td>
	<td valign="top">' . $frontdata['ans1'] . '</td>
  </tr>';
}

$tbl11 .= '
 
</table>';


$pdf->writeHTML($tbl11, true, false, true, false, '');
$pdf->AddPage();
$tbl111 = '';

$frontf = mysqli_query($con, "SELECT * FROM `save_specification4` WHERE pro='$spo' and sid='7'");
$front1 = mysqli_fetch_array($frontf);
$frontid = $front1['spec'];

$frontl = mysqli_query($con, "SELECT * FROM `save_specification1`  WHERE `pxid` = '$frontid'");
$tbl111 .= '
<table border="1"  width="100%" border="0.5" cellpadding="3">
 <tr nobr="true">
    <td colspan="2" valign="top" bgcolor="#063970" style="color:#fff; font-size:20px;">Organoleptic</td>
  </tr>

<tr nobr="true">
    <th valign="top" width="37%">Taste</th>
	<td valign="top" width="63%">' . $row5['taste'] . '</td>
  </tr>
  <tr nobr="true">
    <th valign="top">Texture</th>
	<td valign="top">' . $row5['texture'] . '</td>
  </tr>
  <tr nobr="true">
    <th valign="top">Aroma</th>
	<td valign="top">' . $row5['smell'] . '</td>
  </tr>
  <tr nobr="true">
    <th valign="top">Flavour</th>
	<td valign="top">' . $row5['flavour'] . '</td>
  </tr>


 
</table>';


$pdf->writeHTML($tbl111, true, false, true, false, '');

$tbl12 = '';
$tbl12 .= '
<table border="1"  width="100%" border="0.5" cellpadding="3">
 <tr nobr="true">
    <td colspan="2" valign="top" bgcolor="#063970" style="color:#fff; font-size:20px;">Supplier Confirmation</td>
  </tr>';

$nutrinx = mysqli_query($con, "SELECT * FROM `save_specification4` WHERE pro='$spo' and sid='9'");
$nutrinx1 = mysqli_fetch_array($nutrinx);
$nutrinxid = $nutrinx1['spec'];



$nutrin = mysqli_query($con, "SELECT * FROM `save_specification1`  WHERE `pxid` = '$nutrinxid'");


$mutriuser = $vrdrow['create'];


$suppuser = mysqli_query($con, "SELECT * FROM `tbladmin` WHERE name='$mutriuser'");
$suppuserx = mysqli_fetch_array($suppuser);

$supusersign = $suppuserx['sign'];

echo $aprove = $vrdrow['approveby'];
$aprove1 = mysqli_query($con, "SELECT * FROM `tbladmin` WHERE name='$aprove'");
$aprove2 = mysqli_fetch_array($aprove1);
$aproveimg = $aprove2['sign'];

$tbl12 .= '
  <tr nobr="true">
   <th width="37%" >Created By </th>
      <th width="63%">'.$mutriuser .'</th>
  </tr>
    <tr nobr="true">
   <th width="37%" >Job Title</th>
      <th width="63%" >'.$vrdrow['jobt'].'</th>
  </tr>
  <tr nobr="true">
   <th width="37%" >Signature</th>
      <th width="63%" ><img src="signature/' . $supusersign . '" height="80"></th>
  </tr>
  
  ';


while ($row1 = mysqli_fetch_array($nutrin)) {
  $tbl12 .= ' <tr nobr="true">
    <th width="37%" >' . $row1['ques'] . '</th>
      <th width="63%" >' . $row1['ans1'] . '</th>
  </tr>
 
';
}
if($vrdrow['status'] =='Accepted'){
$tbl12 .= '
  
 <tr nobr="true">
  <th width="37%" >Approved By</th>
      <th width="63%" >' . $vrdrow['approveby'] . '</th>
  </tr>
  <tr nobr="true">
   <th width="37%" >Signature</th>
      <th width="63%" ><img src="signature/' . $aproveimg . '" height="80"></th>
  </tr>
  <tr nobr="true">
   <th width="37%" >Date</th>
      <th width="63%" >' . date('d-m-Y', strtotime($vrdrow['apdate'])) . '</th>
  </tr>';
}else{
  $tbl12 .= '
  
 <tr nobr="true">
  <th width="37%" >Approved By</th>
      <th width="63%" ></th>
  </tr>
  <tr nobr="true">
   <th width="37%" >Signature</th>
      <th width="63%" ></th>
  </tr>
  <tr nobr="true">
   <th width="37%" >Date</th>
      <th width="63%" ></th>
  </tr>';
}

$tbl12 .= '
   
</table>';


$pdf->writeHTML($tbl12, true, false, true, false, '');




$str = preg_replace('/[^A-Za-z0-9_-]/', '', $row['prodname']);
$pdf->lastPage();
ob_clean();
$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "finemed/productspecs/pdf/" . $vrdrow['scode'] . "-ProdSpec.pdf", "F");
?>

<div class="container-fluid">
  <div class="row column_title">
    <div class="col-md-12">
      <div class="page_title">
        <h2><?php echo $row['prodname']; ?> (<?php echo $row['prodcode']; ?>)

          <a href="productspecs/pdf/<?php echo $vrdrow['scode']; ?>-ProdSpec.pdf" target="_blank" download=""><button class="btn btn-warning" style="float:right; margin-left:10px">Download Spec</button></a>


          <a href="admin.php?id=prodspec"><button class="btn btn-info" style="float:right">Go Back</button></a>


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
            <iframe src="productspecs/pdf/<?php echo $vrdrow['scode']; ?>-ProdSpec.pdf" width="100%" height="700"></iframe>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>