<?php
$id = $_GET['sno'];
include 'connection.php';
$sql1 = mysqli_query($con, "SELECT * FROM `tblrawmaterial` WHERE id=$id");
$row = mysqli_fetch_array($sql1);
$rid = $row['supid'];

$sql1 = mysqli_query($con, "SELECT * FROM tblrawsupplier WHERE supid=$rid");
$row1 = mysqli_fetch_array($sql1);









// D:\XAMPP\htdocs\star\vendor\tecnickcom\tcpdf\tcpdf.php
require('tcpdf/tcpdf.php');

ini_set('max_execution_time', 300);
// create new PDF document
class MYPDF extends TCPDF
{

  private $longTableHeader = '';

  public function Header()
  {

    // $image_file = 'images/rtnts.png';
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
    $this->SetY(-15);
    // $this->SetFont('Helvetica', 'I', 8);
    $this->Cell(25, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
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

// $pdf->SetFont('Helvetica', 'B', 14);


$pdf->AddPage('L', 'A4');
$pdf->SetFont('century gothic', '', 12);

$pdf->SetXY(0, 8);
$tble11 = <<<EOD
<table width="1150" border="0"  >
<tr>
<td width="30"></td>
<td width="150"><img src="images/logo1.png" width="130"></td>
<td width="692" style="font-size:32px;  ; text-align:center;">Product Assesment Details </td>
<td width="150"><img src="images/rtnts.png" width="130"></td>
<td width="30"></td>
</tr>
</table>
EOD;
$pdf->writeHTML($tble11, true, false, true, false, '');
$pdf->setLongTableHeader($tble11);






$pdf->SetFont('century gothic', '', 12);
$pdf->SetXY(5, 40);
$tble11 = <<<EOD


<table width= "100%">
<tr>
<td width="10"></td>
<td width="520"></td>
</tr>
<tr>
 <td width="300">
 <table width="800" border="0" style="font-weight:bold; font-size:12px " cellpadding="2">
                  
                    <tr>
                      <th width="150" style="font-size:17px; color:black;" >Supplier Name : </th>
                      <td width="300"  style="font-size:15px;color:black;">$row1[supname]</td>
                    </tr>
                  <tr>
                    <th width="150" style="font-size:17px; color:black;">Product Name : </th>
                    <td width="300" style="font-size:15px;color:black;">$row[pname]</td>
                  </tr>
                  <tr>
                    <th width="150" style="font-size:17px; color:black;">Product Code :   </th>
                    <td width="300" style="font-size:15px;color:black;"> $row[pcode]</td>
                  </tr>
                    
        </table>
    
 
 </td>
  <td width="300">
  
  </td>
   <td width="300">
   <table width="800" border="0" style="font-weight:bold; font-size:12px " cellpadding="2">
                  
                    <tr width="520">
                      <th width="270" style="font-size:17px; color:black;" >Vulnerbility Assesment Score : </th>
                      <td width="180" style="font-size:15px;color:black;">$row[vulner]</td>
                    </tr>
                  <tr width="520">
                      <th width="270" style="font-size:17px; color:black;">Risk Assesment Score : </th>
                      <td width="180" style="font-size:15px; color:black;">$row[risk]</td>
                    </tr>
                    
                    <tr>
                      <td>&nbsp;</td>
                    
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    
                    </tr>
        </table>
   </td>
</tr>


</table>

EOD;
$pdf->writeHTML($tble11, true, false, true, false, '');
$pdf->setLongTableHeader($tble11);




// Correctly call write1DBarcode with numeric values







$pdf->SetFont('Helvetica', '', 10);





$pdf->SetXY(2, 77);










$tbl_header = '<style>
table {
   border-spacing: 0;
   margin-top:30px;
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
<h2>Vulnerability Assesment</h2>

<table id="gallerytab" width="900" cellspacing="0" cellpadding="4" border="0" >
  ';

$tbl_footer = '</table>';

$tbl7 = '';
$tbl7 .= '
<thead >
  <tr>
    <th width="72" >Ingredient Fraud History</th>
    <th width="72" >Economic factor</th>
    <th width="72" >Geographic origins</th>
	   <th width="72" >Complexity of supply chain</th>
		 <th width="72" >Ease of access to materials</th>
		<th width="72" >Nature of the material</th>
       <th width="72" >Cost of materials</th> 
       <th width="74" >Supply chain confidence</th>
      <th width="74" >Supplier relationship</th>
       <th width="74" >Supplier history</th> 
       <th width="74" >Availability of materials</th>
       <th width="74" >Ingredient testing methods</th>
       <th width="74" >Existing controls</th>
       <th width="75" >Overall Score</th>
  </tr>
  </thead>
  <tbody>
  <tr>
  ';

$q = $row['vulnerocc'];
$q1 = explode(',', $q);
// print_r($q1);

foreach ($q1 as $key) {
  $tbl7 .= '

    <td width="72">' . $key . '</td>
   ';
}

$r = $row['vulnerdet'];
$r1 = explode(',', $r);
// print_r($r1);

foreach ($r1 as $val) {
  $tbl7 .= '

    <td  width="74">' . $val . '</td>
   ';
}

$vuscore = $row['vulner'];
$tbl7 .= '
   <td  width="75"  height ="30" style="  background-color:' .
  ($vuscore < 20 ? 'green' : ($vuscore >= 21 && $vuscore <= 40 ? '#ffae42' : 'Red')) .
  '; font-size:17px; color:white; " >' . $vuscore . '</td>
  </tr>
  </tbody>
  ';

$pdf->writeHTML($tbl_header . $tbl7 . $tbl_footer, true, false, false, false, '');





$pdf->SetFont('century gothic', '', 10);





$pdf->SetXY(2, 120);










$tbl_header = '<style>
table {
   border-spacing: 0;
   margin-top:30px;
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
<h2>Risk Assesment</h2>

<table id="gallerytab" width="900" cellspacing="0" cellpadding="4" border="0" >
  ';

$tbl_footer = '</table>';

$tbl6 = '';
$tbl6 .= '
<thead >
  <tr>
    <th width="120" >Allegerns</th>
    <th width="120" >Phsical Status</th>
    <th width="120" >Process Stage</th>
	   <th width="83" >Allergen Risk</th>
		 <th width="83" >Biological Risk</th>
		<th width="83" >Foreign Body Risk</th>
       <th width="83" >Chemical Risk</th> 
       <th width="83" >Risk to product Quality</th>
      <th width="83" >Radiological Risk</th>
       <th width="83" >Vulnerability Assessment</th> 
        <th width="83" >Overall Score</th> 
       
  </tr>
  </thead>
  <tbody>
  <tr>
  <td  width="120" >' . $row["riskall"] . '</td>
  ';

$q = $row['riskdesc'];
$q1 = explode(';', $q);
// print_r($q1);

foreach ($q1 as $key) {
  $tbl6 .= '

    <td width="120">' . $key . '</td>
   ';
}

$r = $row['riskassoc'];
$r1 = explode(',', $r);
// print_r($r1);

foreach ($r1 as $val) {
  $tbl6 .= '

    <td  width="83">' . $val . '</td>
   ';
}

$vuscore = $row['risk'];
$tbl6 .= '
   <td  width="83"  height ="30" style="background-color:' .
  ($vuscore < 20 ? 'green' : ($vuscore >= 21 && $vuscore <= 40 ? 'yellow' : 'Red')) .
  '; color:white; font-size:17px;" >' . $vuscore . '</td>
  </tr>
  </tbody>
  ';

$pdf->writeHTML($tbl_header . $tbl6 . $tbl_footer, true, false, false, false, '');















// Sanitize the filename
$filename = "Product" . $row['id']; // Sanitize the GRN number

// Define the full path for the PDF
$filePath = $_SERVER['DOCUMENT_ROOT'] . "upl1/" . $filename . ".pdf";
// echo $filePath; // Absolute path

// Attempt to generate the PDF
try {
  // Ensure the directory exists
  if (!file_exists(dirname($filePath))) {
    mkdir(dirname($filePath), 0755, true); // Create the directory if it doesn't exist
  }

  // Output the PDF to the specified path
  $pdf->Output($filePath, "F");
} catch (Exception $e) {
  echo "Error generating PDF: " . $e->getMessage();
}

?>

<!-- 
include 'connection.php';
$sql1 = mysqli_query($con, "SELECT * FROM tblgrn1 LEFT JOIN tblgrnno2 ON tblgrn1.supplier = tblgrnno2.supid;");
$row2 = mysqli_fetch_array($sql1);
// $date = date('d-m-Y h:m:s', strtotime($row2['dt']));

$supplier = $row2['supid'];
$supplier = mysqli_query($con, "SELECT * FROM `tblrawsupplier` WHERE `supid` = '$supplier'");
$supname = mysqli_fetch_assoc($supplier);

$i = 1;
?> -->
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.5/css/dataTables.bootstrap5.css">
<style>
  .limit {
    width: 200px;
  }
</style>
<div class="main-content">
  <div class="breadcrumb">

    <ul>
      <li><a href="">Home</a></li>
      <li> Assesment Details  </li>
    </ul>
  </div>
  <div class="container-fluid " style="margin-top:100px;">
    <div class="row mb-12">
      <div class="col-md-12 mb-12">
        <div class="card text-left">
          <div class="card-body">

            <a href="admin.php?id=addrawmaterial"><button class="btn btn-primary mb-3"
                style="float:right; margin-left:15px">Go Back</button></a>
            <a href="../upl1/<?php echo $filename; ?>.pdf" target="_blank"><button class="btn btn-primary mb-3"
                style="float:right; margin-left:15px">View Report</button></a>

            <!-- <p>List of staff</p> -->

            <div class="table-responsive">
              <table class="display table table-striped table-bordered" id="zero_configuration_table"
                style="width:100%">
                <thead>
                  <tr>
                    <th>Product code</th>
                    <th>Product name</th>
                    <!-- <th>Image</th> -->
                    <th>Supplier Name</th>
                    <!-- <th>ingredients</th> -->
                    <th>Vulnerability Assesment</th>
                    <th>Risk Assesment</th>


                  </tr>
                </thead>
                <tbody>
                  <tr class="text-center">
                    <td><?php echo $row['pcode'] ?></td>
                    <td><?php echo $row['pname'] ?></td>
                    <td><?php echo $row1['supname'] ?></td>
                    <td><?php echo $row['vulner'] ?></td>
                    <td><?php echo $row['risk'] ?></td>
                  </tr>


                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Content wrapper -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.bootstrap5.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>
      // new DataTable('#example');
    </script>