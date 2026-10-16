<?php
$sno = $_GET['sno'];

$sq2 = mysqli_query($con, "SELECT * FROM `tbl_dailyrecord` where id='$sno'");
$qu2 = mysqli_fetch_array($sq2);





$dtnx = date("d-m-Y", strtotime($qu2['cdate']));
$dtname = $qu2['name'];
$dth = date("d-m-Y H:i:s");

require('tcpdf/tcpdf.php');

class MYPDF extends TCPDF
{
    private $longTableFooter = '';
    public function Header()
    {




        $image_file = 'images/1.png';
        $image_file1 = 'images/rtnts.png';

        $this->Image($image_file, 15, 5, 20, '', 'png', '', 'T', false, 200, '', false, false, 0, false, false, false);
        $this->Image($image_file1, 220, 5, 35, '', 'png', '', 'T', false, 200, '', false, false, 0, false, false, false);

        $this->SetFont('courier', '', 20);
        $this->SetXY(80, 2);
        $this->Write(25, 'Products Checks Report', '', 0, '30', true, 0, false, false, 0);
    }
    public function Footer()
    {
        $this->SetFont('courier', '', 8);
        $this->SetY(-20);
        $this->writeHTML($this->longTableFooter);
    }
    public function setLongTableFooter($html)
    {
        $this->longTableFooter = $html;
    }
}
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, false, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);

$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
    $pdf->setLanguageArray($l);
}

$pdf->AddPage('L', 'LETTER');

$footer = <<<EOD

<table width="100%" cellpadding="4" border="0.2" style="font-size:11px;  border-color:#000000; color:black;">
    <tr>
        <td width="220">Issue date: 14/07/2025</td>
        <td width="230">Doc Ref : REC 6.1.003</td>
        <td width="220">Prepared by: Bijal Chauhan</td>
    </tr>
    <tr>
        <td width="220" >Version No: 1</td>
       <td width="230" >Page {$pdf->getAliasNumPage()}/{$pdf->getAliasNbPages()}</td>


        <td width="220" >Approved By: Paramvir S. Deol</td>
    </tr>
    <tr>
        <td width="450" colspan="2" >Reason for change: New Document.</td>
        <td width="220" >Print On: $dth </td>
    </tr>
</table>
EOD;
$pdf->setLongTableFooter($footer);


$pdf->SetFont('courier', '', 14);
$pdf->SetXY(15, 30);
$pdf->Write(0, "Date created:$dtnx", '', '0', '0', true, 'C', false, false, 0);
$pdf->SetXY(15, 37);
$pdf->Write(0, "Attempt By:$dtname", '', '0', '0', true, 'C', false, false, 0);
$pdf->SetXY(15, 65);
$pdf->Line(15, 55, 263, 55);

$pdf->SetFont('courier', '', 11);

$tbl_header = '<style>
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
   color:blue;
}


</style>
<table id="gallerytab" width="100%" cellspacing="0" cellpadding="3" border="0.2">



';
$tbl_footer = '</table>';


$tbl1 = '';
$tbl1 .= '
 <tr nobr="true" style="background-color:aliceblue;"> 
      <th>Product Name </th>
     <th>Quantity from last day</th>
     <th>Quantity received today</th>
      <th>Quantity sold today</th>
       <th>Quantity wasted today</th>
       	 <th>Quantity remaining in stock</th>
         <th>Remark if any</th>
   </tr>

';

$ghf1 = mysqli_query($con, "SELECT * FROM `tbl_dailyrecord1` where mid='$sno'");
while ($rowsf1 = mysqli_fetch_array($ghf1)) {

    $tbl1 .= '
  <tr nobr="true"> 
         <td style="color:black;font-size:18px" >' . $rowsf1['pname'] . '</td>
       <td  >' . $rowsf1['lastqnty'] . ' ' . $rowsf1['uom'] . '</td>
       <td  >' . $rowsf1['totalquantity'] . ' ' . $rowsf1['uom'] . '</td>
       <td >' . $rowsf1['quantitysale'] . ' ' . $rowsf1['uom'] . '</td>
       <td  >' . $rowsf1['quantitywaste'] . ' ' . $rowsf1['uom'] . '</td>
       <td >' . $rowsf1['quantityleft'] . ' ' . $rowsf1['uom'] . '</td>
       <td >' . $rowsf1['cmnt'] . '</td>
   </tr>
';
}

$pdf->writeHTML($tbl_header . $tbl1 . $tbl_footer, true, false, false, false, '');





$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "finemed/upl1/" . $dtnx . "-Products_Checks.pdf", "F");



?>
<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>Daily Checks </li>
        </ul>
    </div>
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">


                    <a href="admin.php?id=dailyrawview&sno=<?php echo $sno; ?>"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

                    <h4 class="card-title mb-3">Product Checks Report</h4>

                    <iframe src="upl1/<?php echo $dtnx; ?>-Products_Checks.pdf" width="100%" height="500px">

                    </iframe>



                </div>
            </div>
        </div>