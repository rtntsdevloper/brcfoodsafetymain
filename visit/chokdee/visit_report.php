<?php

include 'connection.php';
$visit = $_GET['visit'];

$qs = mysqli_query($con, "SELECT * FROM `visit` WHERE visitcode='$visit'");
$qs1 = mysqli_fetch_array($qs);
$name = $qs1['name'];
$date = $qs1['date'];
$vdate = $qs1['vtime'];
$date1 = date('d-m-Y', strtotime($date));
$random = $qs1['correct'];
$signk = $qs1['sign'];
$org = $qs1['org'];
$reason = $qs1['reason'];
$vehicle = $qs1['register'];
$datec = date('d-m-Y H:i:s');




require('tcpdf/tcpdf.php');
class MYPDF extends TCPDF
{
  private $watermarkPath = 'images/watermark.png';
  private $logo1Path = 'images/1.png';
  private $logo2Path = 'images/rtnts.png';
  private $footerHTML = '';

  public function Header()
  {
    // Set header background
    $this->SetFillColor(245, 245, 255);
    $this->Rect(0, 0, $this->getPageWidth(), 30, 'F');

    // Add logos
    if (file_exists($this->logo1Path)) {
      $this->Image($this->logo1Path, 10, 6, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    }
    if (file_exists($this->logo2Path)) {
      $this->Image($this->logo2Path, 170, 7, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    }

    // Title
    $this->SetFont('courier', 'B', 16);
    $this->SetTextColor(0, 51, 102);
    $this->SetXY(0, 12);
    $this->Cell(0, 0, 'VISITORS QUESTIONNAIRE', 0, 1, 'C');

    // Subtitle
    $this->SetFont('courier', 'I', 10);
    $this->SetTextColor(102, 102, 102);
    $this->SetXY(0, 20);

    // Header line
    $this->SetLineWidth(0.5);
    $this->SetDrawColor(0, 102, 204); // Blue color
    $this->Line(15, 28, 195, 28); // Draw the line



  }
  public function setFooterHTML($html)
  {
    $this->footerHTML = $html;
  }

  public function addWatermark()
  {
    if (file_exists($this->watermarkPath)) {
      $this->SetAlpha(0.1);
      $this->Image($this->watermarkPath, 50, 100, 100, 100, '', '', '', false, 300, '', false, false, 0);
      $this->SetAlpha(1);
    }
  }






  public function Footer()
  {
    $this->SetFont('courier', '', 10);
    if (!empty($this->footerHTML)) {
      $this->SetY(-22);
      $this->writeHTML($this->footerHTML, true, false, true, false, '');
    }
  }
}
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, false, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Paramvir S. Deol');
$pdf->SetTitle('Visitor Questionnaire');
$pdf->SetSubject('Visitor Questionnair');
$pdf->SetKeywords('PDF, Visitor Questionnaire, Report');

$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->SetMargins(PDF_MARGIN_LEFT, 35, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
  require_once(dirname(__FILE__) . '/lang/eng.php');
  $pdf->setLanguageArray($l);
}

$pdf->AddPage();
$pdf->SetFont('century gothic', '', 14);

// Draw the rounded rectangle (with internal padding)
$rectX = 15;
$rectY = $pdf->GetY() + 5;
$rectWidth = 175;
$rectHeight = 42;
$cornerRadius = 3;
$rectY = $pdf->GetY() + 2;
$pdf->SetFillColor(255, 255, 255);
$pdf->SetDrawColor(212, 148, 4);
$pdf->SetLineWidth(0.5);
$pdf->RoundedRect($rectX, $rectY, $rectWidth, $rectHeight, $cornerRadius, '1111', 'DF');

// Add content with proper internal padding
$textX = $rectX + 2;
$textY = $rectY + 2;
$pdf->SetXY($textX, $textY);
if (!empty($qs1['pic'])) {
  // $visitpic = "upl1/".$qs1['pic'];
} else {
  //$visitpic="";
}
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('courier', 'B', 13);
$pdf->SetXY(145, 40); // Set position
//$pdf->Image($visitpic, '', '', 40, 30, '', '', '', false, 300);
$pdf->SetXY(15, 40);
$pdf->Cell(0, 6, " Date of visit:  $date1 $vdate", 0, 1);

$pdf->SetFont('courier', 'B', 13);
$pdf->SetXY(15, 48);
$pdf->Cell(0, 6, " Reason for visit: $reason", 0, 1);

$pdf->SetFont('courier', 'B', 13);
$pdf->SetXY(15, 56);
$pdf->Cell(0, 6, " Name: $name", 0, 1);

$pdf->SetFont('courier', 'B', 13);
$pdf->SetXY(15, 64);
$pdf->Cell(0, 6, " Organisation: $org", 0, 1);
$pdf->SetXY(15, 72);
$pdf->Cell(0, 6, " Vehicle No : $vehicle", 0, 1);
$pdf->SetXY(15, 80);







// $pdf->AddPage();
// $pdf->SetFont('courier', '', 14);
// $pdf->SetXY(15, 40);
// $pdf->Write(0, "Date of visit: $date", '', '0', '0', true, 'C', false, false, 0);
// $pdf->SetXY(15, 47);
// $pdf->Write(0, "Reason for visit: $reason", '', '0', '0', true, 'C', false, false, 0);
// $pdf->SetXY(15, 54);
// $pdf->Write(0, "Name: $name", '', '0', '0', true, 'C', false, false, 0);
// $pdf->SetXY(15, 60);
// $pdf->Write(0, "Orginisation: $img", '', '0', '0', true, 'C', false, false, 0);
// $pdf->SetXY(15, 75);
$pdf->SetFont('courier', '', 20);
$footerContent = <<<EOD
<table width="100%" cellpadding="4" border="0.2" style="font-size:11px;  border-color:#000000; color:navy;">
    <tr>
        <td width="37.5%">Issue date: 14/07/2025</td>
        <td width="27%">Doc Ref : Rec 7.3.2</td>
        <td width="33%">Author: Mahesh Prajapati</td>
    </tr>
    <tr>
        <td width="37.5%" >Version No: 2</td>
       <td width="27%" >Page {$pdf->getAliasNumPage()}/{$pdf->getAliasNbPages()}</td>


        <td width="33%" >Approved By: Paramvir S. Deol</td>
    </tr>
    <tr>
        <td width="97.5%" >Reason for change: Reviewed Document.</td>
      
    </tr>
</table>
EOD;


$pdf->setFooterHTML($footerContent);

$pdf->SetFont('courier', '', 11);

$rectY = $pdf->GetY() + 10;

$pdf->SetXY($rectX, $rectY + 10);
$tbl_header = '<style>
table {
   border-collapse: collapse;
   border-spacing: 0;
   margin: 0 10px;
   border:0.5px solid #000000;
  width:100%;
}
tr {
   padding: 1px 0;
}


</style>
<table id="gallerytab" width="100%" cellspacing="0" cellpadding="3" border="0.2">';
$tbl_footer = '</table>';


$tbl1 = '';


$tbl1 .= '
  <tr> 
      
       <td width="620" style="color:rgba(0, 51, 102); font-weight:bold; Background-color:#f8f4fc;"><div align="center">Part-1 Hygiene Questionnaire</div></td>
   </tr>
 ';
$i = 0;
$sql1 = mysqli_query($con, "select * from saveques where vcode ='$visit'");
while ($row = mysqli_fetch_array($sql1)) {

  $k = $i + 1;

  $tbl1 .= '
  <tr> 
      <td width="120" style="color:rgba(0, 51, 102); font-weight:bold;">Question:' . $k . '</td>
       <td  width="500" style="color:black;  " >' . $row['ques'] . '</td>
   </tr>';

  $tbl1 .= '
    <tr>
        <td width="120"  style="color:rgba(0, 51, 102); font-weight:bold;">Answer</td>
       <td  width="500" style="color:Green">' . $row['ans'] . '</td>
   
</tr>';

  if ($row['cmnt'] !== "") {
    $tbl1 .= '
	<tr> 
	 <td width="120" style="color:green" >Comment</td>
       <td  width="500" style="color:green">' . $row['cmnt'] . '</td>
   </tr>';
  }

  $i++;
}




$pdf->writeHTML($tbl_header . $tbl1 . $tbl_footer, true, false, false, false, '');


$tblsign = '';
$tblsign = '
<br>
<br>
<table id="gallerytab" width="100%" >
  <tr> 
    <td width="400" style="color:blue"></td>
       <td width="220" ><img src="signature/' . $signk . '.png" alt="Signature" width="200" height="70"></td>
       
       </tr> 
       <tr>
        <td width="400" ></td>
        <td  width="220" style="color:navy;">Visitor Signature</td>
       </tr>

   
</table>


';
$pdf->writeHTML($tblsign, true, false, false, false, '');


$tbldetail = "";
$tbldetail .= '
<h3 >Part 2 - HYGIENE RULES FOR THIS PRODUCTION SITE</h3>

					<ol>
									<li>No smoking, eating, or drinking is allowed within any of the production areas.</li>
									<li>Site is a gluten free production facility.</li>
									<li>Personal medicines areNOT allowed in any production area.</li>
									<li>Always wash your hands when entering the production area.</li>
									<li>Fingernails must be short, clean and no false nails, nail varnish or nail art allowed.</li>
									<li>Avoid touching your hair, face, nose, and mouth whilst in the production area.</li>
									<li>No food is allowed on in the production areas which contain the following allergens: cereals containing gluten, milk, soya, egg, mustard, crustaceans, molluscs, sulphites, fish, lupin, sesame, celery, nuts, and peanuts.</li>
									<li>Before entering any production area you must remove outdoor clothing and wear P.P.E. issued by Doughlicious</li>
									<li>All jewellery MUST be removed before entering any production areas, this includes: watches, earrings, rings (plain wedding bands are allowed), bracelets, bangles, necklaces, rings & studs in exposed parts of the body such as noses and eyebrows.</li>
									<li>Any cuts, boils or grazes must be covered with a business-issued only blue metal detectable plaster.</li>
									<li>Do not cough or sneeze near or over food.</li>
									<li>Site is a gluten free production site therefore any gluten is not allowed in the factory or the storage area.</li>
									<li>White coat, blue hairnet and green mobcap, white boots are for High care area and blue coat/high viz, blue hairnet and blue mobcap, blue over shoes are for low risk area. Please follow double handwash in high care area.</li>
									<li>Please declare any medical condition that site needs to know in the event of any emergency.</li>
									<li>Please show your ID to the host as site follows no ID no Entry rule.</li>

								</ol>
							
';

$pdf->writeHTML($tbldetail, true, false, false, false, '');


$tblsignl = '';
$tblsignl = '
<br>
<br>
<table id="gallerytab" width="100%" >
  <tr> 
    <td width="400" style="color:blue"></td>
       <td width="220" ><img src="signature/' . $signk . '.png" alt="Signature" width="200" height="70"></td>
       
       </tr> 
       <tr>
        <td width="400" ></td>
        <td  width="220" style="color:navy;">Visitor Signature</td>
       </tr>

   
</table>


';
$pdf->writeHTML($tblsignl, true, false, false, false, '');

$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "upl1/" . date('d-m-Y', strtotime($date))  . "-" . $name . ".pdf", "F");

?>



<link rel="stylesheet" href="	https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css">
















<?php
date_default_timezone_set("Europe/London");
include 'connection.php';
?>
<!DOCTYPE html>
<html lang="en" dir="">

<head>
  <meta charset="ISO-8859-1">
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title> RTNTS - Web Portal </title>
  <link rel="shortcut icon" href="favicon.ico">
  <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
  <link href="dist-assets/css/themes/lite-purple.min.css" rel="stylesheet" />
  <link href="dist-assets/css/plugins/perfect-scrollbar.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="dist-assets/css/plugins/sweetalert2.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="dist-assets/js/plugins/jquery-3.3.1.min.js"></script>
  <script src="dist-assets/js/plugins/bootstrap.bundle.min.js"></script>
  <script src="dist-assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="dist-assets/js/scripts/script.min.js"></script>
  <script src="dist-assets/js/scripts/sidebar.large.script.min.js"></script>
  <script src="dist-assets/js/plugins/echarts.min.js"></script>
  <script src="dist-assets/js/scripts/echart.options.min.js"></script>
  <script src="dist-assets/js/plugins/datatables.min.js"></script>
  <script src="dist-assets/js/scripts/form.validation.script.min.js"></script>
  <script src="dist-assets/js/scripts/dashboard.v1.script.min.js"></script>
  <script src="dist-assets/js/plugins/sweetalert2.min.js"></script>

  <link rel="stylesheet" type="text/css" href="assets/reset.css">

  <script type='text/javascript'>
    function refreshCaptcha() {
      var img = document.images['captchaimg'];
      img.src = img.src.substring(0, img.src.lastIndexOf("?")) + "?rand=" + Math.random() * 1000;
    }
  </script>

</head>

<body class="text-left">
  <div class="app-admin-wrap layout-sidebar-large">
    <div class="main-header">

      <img src="images/logo1.png" alt="" width="70" style="margin-left:20px">
      <div class="menu-toggle">
        <div></div>
        <div></div>
        <div></div>
      </div>
      <div class="d-flex align-items-center">
        <!-- Mega menu -->
        <div class="dropdown mega-menu d-none d-md-block">
          Regal Technical and Training Solutions Limited </div>
        <!-- / Mega menu -->
      </div>
      <div style="margin: auto"></div>
      <div class="header-part-right">
        <!-- Full screen toggle -->
        <i class="fa fa-arrows" data-fullscreen></i>
        <!-- Grid menu Dropdown -->

        <!-- Notificaiton -->

        <!-- Notificaiton End -->
        <!-- User avatar dropdown -->
        <div class="dropdown">

        </div>
      </div>
    </div>

    <div class="side-content-wrap">
      <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar="" data-suppress-scroll-x="true">
        <ul class="navigation-left">
          <li class="nav-item"><a class="nav-item-hold" href=""> <i class="fa fa-bank"
                style="font-size:34px"></i><span class="nav-text">Dashboard</span></a>
            <div class="triangle"></div>
          </li>

        </ul>
      </div>

      <div class="sidebar-overlay"></div>
    </div>
    <!-- =============== Left side End ================-->
    <div class="main-content-wrap sidenav-open d-flex flex-column">
      <div class="main-content">

        <div class="container-fluid " style="margin-top:20px;">
          <div class="row mb-12">
            <div class="col-md-12 ">
              <div class="card text-left">
                <div class="card-body">





                  <h4 class="card-title mb-3">Visitor Report</h4>

                  <div class="embed-responsive embed-responsive-4by3" style="height: 1008px; width: 100%;">
                    <iframe class="embed-responsive-item " style="height: 700px; width: 100%;" src="upl1/<?php echo date('d-m-Y', strtotime($date)) . '-' . $name; ?>.pdf" allowfullscreen></iframe>
                  </div>



                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>