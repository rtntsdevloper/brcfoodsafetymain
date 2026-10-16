<?php
include 'connection.php';
require('tcpdf/tcpdf.php');
ini_set('max_execution_time', 300);
$ac = $_GET['ac'];
$batch = $_GET['batch'];

if ($_GET['date']) {
    $date = $_GET['date'];

} else {
    $date = date('Y-m-d');
}

// create new PDF document
class MYPDF extends TCPDF
{
    private $longTableFooter = '';

    public function Header()
    {
        $image_file = 'images/1.png';
        $image_file1 = 'images/rtnts.png';
        if (file_exists($image_file)) {
            $this->Image($image_file, 5, 5, 25, '', 'PNG');
        }
        if (file_exists($image_file1)) {
            $this->Image($image_file1, 245, 4, 39, '', 'PNG');
        }
        $this->SetFont('centurygothic', '', 20);
        $this->SetXY(5, 10);
        $this->Write(10, 'Daily Metal Detection', '', 0, 'C', true, 0, false, false, 0);
    }

    public function Footer()
    {
        $this->SetFont('centurygothic', '', 8);

        // Move footer table higher (about 30mm from bottom)
        $this->SetY(-30);
        if (!empty($this->longTableFooter)) {
            $this->writeHTML($this->longTableFooter, true, false, true, false, '');
        }

        // Printed line at bottom
        $this->SetY(-12);
        // $this->Cell(0, 5, 'Printed: ' . date('d-m-Y H:i A') . ' | Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 0, 'C');
    }

    public function setLongTableFooter($html)
    {
        $this->longTableFooter = $html;
    }
}

$pdf = new MYPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(40); // reserve enough space for footer
$pdf->SetMargins(PDF_MARGIN_LEFT, 35, PDF_MARGIN_RIGHT);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
    $pdf->setLanguageArray($l);
}
$pdf->AddPage('L', 'A4');

$f = mysqli_query($con, "SELECT * FROM `tblformcontrol` WHERE tabname='Metal'");
$f1 = mysqli_fetch_array($f);

$issuedate = !empty($f1['issuedate']) ? date("d-m-Y", strtotime($f1['issuedate'])) : '';

// Footer HTML
$html = '
<table cellpadding="6" border="1" width="100%">
  <tr>
    <th>Issue date: ' . $issuedate . '</th>
    <th align="center">Version : ' . $f1['version'] . '</th>
    <th>Author: ' . $f1['author'] . '</th>
  </tr>
  <tr>
    <th>Reason for change: ' . $f1['reason'] . '</th>
    <th align="center">DOC REC No. : ' . $f1['refno'] . '</th>
    <th>Authorised by: ' . $f1['authoriesby'] . '</th>
  </tr>
</table>';

$pdf->setLongTableFooter($html);

$pdf->SetFont('centurygothic', '', 8);

// ✅ Fixed table widths to fit inside page
$tbl_header = '<style>
table { border-spacing: 0; }
th {
  background-color:#F0F0F0;
  border: 1px solid #000000;
  text-align: center;
}
td {
  border: 1px solid #000000;
  text-align: left;
}
</style>
<table width="100%" cellspacing="0" cellpadding="4" border="0">
<tr>
  <th width="6%">Sno</th>
  <th width="12%">Date</th>
  <th width="12%">Batchcode</th>
  <th width="10%">Product</th>
  <th width="10%">Test Type</th>
  <th width="15%">Is correct packaging film being used?</th>
  
  <th width="15%">Any correction needed?</th>
  <th width="5%">Gas</th>
  <th width="15%">Checks carried out by</th>
</tr>';
$tbl_footer = '</table>';
$tbl_body = '';
$i = 1;

$upit = mysqli_query($con, "SELECT * FROM tblmetal WHERE DATE(datetime)='$date' AND productbatch='$batch' ORDER BY datetime DESC");
while ($row1 = mysqli_fetch_array($upit)) {
    // Get recipe name
    $sd2 = mysqli_query($con, "SELECT * FROM tblmarination WHERE batchcode='" . $row1['productbatch'] . "'");
    $sd3 = mysqli_fetch_array($sd2);

    $sd = mysqli_query($con, "SELECT * FROM tblrecipe WHERE id='" . $sd3['name'] . "'");
    $sd1 = mysqli_fetch_array($sd);

    // Get questions for this testtype
    $ques = mysqli_query($con, "SELECT * FROM tblques2 WHERE status='" . mysqli_real_escape_string($con, $row1['testtype']) . "'");
    $tags = explode(';', $row1['ans']);
    $tagss = explode(';', $row1['cmnt']);

    // Build Q&A block with left-aligned text
   // Build Q&A block with left-aligned text
$qaBlock = "<table border='1' cellpadding='0' cellspacing='0' width='100%'>
              <tr style='background-color:#f5f5f5;text-align:left;'>
                <td width='10%' align='left'><b>Question</b></td>
                <td width='90%' align='left'><b>Answer</b></td>
                <td width='90%' align='left'><b>Comment</b></td>
              </tr>";
$tagIndex = 0;
$cmntindex = 0;
while ($que = mysqli_fetch_assoc($ques)) {
    $q = $que['ques'];
    $answer = isset($tags[$tagIndex]) ? $tags[$tagIndex] : '';
    $cmnt = isset($tagss[$cmntindex]) ? $tagss[$cmntindex] : '';
    $qaBlock .= "
      <tr>
        <td align='left'>$q</td>
        <td align='left'><span style='color:green'>$answer</span></td>
        <td align='left'><span style='color:green'>$cmnt</span></td>
      </tr>";
    $tagIndex++;
    $cmntindex++;
}
$qaBlock .= "</table>";

    // Main row with attributes + embedded Q&A
    $tbl_body .= '
    <tr>
      <td>' . $i . '</td>
      <td>' . date('d-m-Y h:i A', strtotime($row1['datetime'])) . '</td>
      <td>' . $row1['productbatch'] . '</td>
      <td>' . $sd1['name'] . '</td>
      <td>' . $row1['testtype'] . '</td>
      <td>' . $row1['pack1'] . '</td>
      <td>' . $row1['pack2'] . '</td>
      <td>' . $row1['gas'] . '</td>
      <td>' . $row1['user'] . '</td>
    </tr>
    <tr>
      <td colspan="9">' . $qaBlock . '</td>
    </tr>';
    $i++;
}

$pdf->writeHTML($tbl_header . $tbl_body . $tbl_footer, true, false, false, false, '');







$html8 = "";
if ($ac == '2') {
    $html8 .= '
<p style="color:red; text-align:center">Not Verified Yet!</p>';
} elseif ($ac == '1') {
    // print_r("SELECT distinct vdate,sign FROM `tblscalee` WHERE tid='$tid' and status='Verified'");
    $vrq = mysqli_query($con, "SELECT distinct vdate,sign FROM `tblmetal` WHERE DATE(datetime)='$date' and status='Verified' and productbatch='$batch'");
    $vrq1 = mysqli_fetch_assoc($vrq);
    $vsign = $vrq1['sign'];
    $vdate = $vrq1['vdate'];

    $html8 .= '
    <table border="1" width="100%"   cellpadding="5">
        <tr nobr="true">
            <th style="text-align:center; width:50%;">
                <img src="tracesounas/img/' . $vsign . '" alt="Signature" width="90" height="30" />
                <br>
                <strong>Verified By</strong>
            </th>
            <th style="text-align:justify; font-weight:bold; width:50%;justify-item:center; ">
            
                <strong> <br> Date :</strong> ' . htmlspecialchars($vdate) . '
            </th>
        </tr>
    </table>
';
}


$pdf->writeHTML($html8, true, false, true, false, '');

$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "/upl1/METAL.pdf", "F");
?>


<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Traceability</a></li>
            <li>View Detail</li>
        </ul>
    </div>

    </br></br>


    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <a href="admin.php?id=metal&id2=<?php echo $_GET['id2']; ?>"><button class="btn btn-success"
                            style="float:right; margin-left:15px">Go Back</button></a>





                    <h4 class="card-title mb-3">Daily Metal Detection & Labelling Checks</h4>


                    <div class="row">

                        <iframe src="upl1/METAL.pdf" width="100%" height="500px"></iframe>


                    </div>





                </div>
            </div>
        </div>
    </div>


    <?php
    if ($ac == '2') {


        $tid = $date;


        ?>


        <script language="javascript">
            jQuery(document).ready(function ($) {
                // Store the window width
                var windowWidth = $(window).width();
                // Resize Event
                $(window).resize(function () {

                    // Check window width has actually changed and it's not just iOS triggering a resize event on scroll
                    if ($(window).width() != windowWidth) {

                        // Update the window width for next time
                        windowWidth = $(window).width();

                        // Do stuff here

                    }

                    // Otherwise do nothing

                });

            });
        </script>
        <style>
            .kbw-signature {
                width: 400px;
                height: 200px;
            }

            #signature canvas {
                width: 100% !important;
                height: auto;
            }

            .kbw-signature1 {
                width: 400px;
                height: 200px;
            }

            #signature1 canvas {
                width: 100% !important;
                height: auto;
            }

            .container {
                margin-left: 420px;

            }
        </style>



        <script src="../dist-assets/js/plugins/jquery-3.3.1.min.js"></script>
        <script src="../dist-assets/js/plugins/bootstrap.bundle.min.js"></script>
        <script src="../dist-assets/js/plugins/perfect-scrollbar.min.js"></script>
        <script src="../dist-assets/js/scripts/script.min.js"></script>
        <script src="../dist-assets/js/scripts/sidebar.large.script.min.js"></script>
        <script src="../dist-assets/js/plugins/echarts.min.js"></script>
        <script src="../dist-assets/js/scripts/echart.options.min.js"></script>
        <script src="../dist-assets/js/plugins/datatables.min.js"></script>
        <script src="../dist-assets/js/scripts/form.validation.script.min.js"></script>
        <script src="../dist-assets/js/scripts/dashboard.v1.script.min.js"></script>
        <script src="../dist-assets/js/plugins/sweetalert2.min.js"></script>




        <script type="text/javascript" src="../assets/js/jquery.min.js"></script>
        <script type="text/javascript" src="../assets/js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="../assets/js/jquery.signature.min.js"></script>
        <script type="text/javascript" src="../assets/js/jquery.signature.js"></script>
        <link rel="stylesheet" type="text/css" href="../assets/js/jquery.signature.css">
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>





        <div class="main-content-wrap sidenav-open d-flex flex-column">
            <div class="container-fluid ">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body p-5">
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <h3 style="color:#FF0000"> Signature</h3>
                                    <form id="uploadForm3" method="post" action="">
                                        <input type="text" hidden name="tid" value="<?php echo $tid; ?>">

                                        <div id="res" style="color:red; font-size:20px"></div>
                                        <br>
                                        <div id="signature"></div>
                                        <br />
                                        <br>
                                        <button id="clear" class="btn btn-warning">Clear Signature</button>
                                        <button class="btn btn-success" id="Submit" type="submit"
                                            style="margin-left:20px">Signature & Verify</button>

                                        <textarea id="sigpad" name="signature_image" style="display: none"></textarea>

                                    </form>


                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <script type="text/javascript">
            // alert(hii);
            var signature = $('#signature').signature({ syncField: '#sigpad', syncFormat: 'PNG' });
            $('#clear').click(function (e) {
                e.preventDefault();
                signature.signature('clear');
                $("#sigpad").val('');
            });
        </script>


        <script type="text/javascript">
            $(document).ready(function (g) {


                $("#uploadForm3").on('submit', (function (g) {
                    // $("#loading").show();
                    g.preventDefault();
                    $.ajax({
                        url: "tracesounas/metalsign",
                        type: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (data) {

                            $("#res").html(data);


                            if (data == "") {
                                $("#res").html('<span style="color:red;">Signature not verified.<span>');

                            }
                            else {

                                var id2 = "<?php echo $_GET['id2']; ?>";
                                // later in success:
                                window.location.href = "admin.php?id=metal&id2=" + id2;




                            }


                        },
                        error: function () {
                            alert("Signature not verified.");
                        }
                    });
                }));
            });
        </script>

    <?php } ?>