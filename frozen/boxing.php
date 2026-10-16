<?php
include 'connection.php';
require('tcpdf/tcpdf.php');
ini_set('max_execution_time', 300);

$date = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['d1']) && $_POST['d1'] != '') {
    $date = $_POST['d1'];
}
$date = mysqli_real_escape_string($con, $date);

if ($date != "") {
    $sql_filter = "SELECT * FROM frozenboxing WHERE DATE(cdate)='$date' ORDER BY id DESC";
} else {
    $sql_filter = "SELECT * FROM frozenboxing ORDER BY id DESC";
}

$productMap = array('2' => 'Samosa', '3' => 'Spring Roll');

// Helper: get product name for a given batchcode
function getProductName($con, $batchcode, $productMap) {
    $bc = mysqli_real_escape_string($con, $batchcode);
    $q = mysqli_query($con, "SELECT product FROM frozenproduction WHERE batchcode='$bc' LIMIT 1");
    if ($q && mysqli_num_rows($q) > 0) {
        $r = mysqli_fetch_array($q);
        return isset($productMap[$r['product']]) ? $productMap[$r['product']] : $r['product'];
    }
    return '';
}

class MYPDF extends TCPDF
{
    private $longTableFooter = '';

    public function Header()
    {
        $image_file  = 'images/1.png';
        $image_file1 = 'images/rtnts.png';
        if (file_exists($image_file)) {
            $this->Image($image_file, 5, 5, 25, '', 'PNG');
        }
        if (file_exists($image_file1)) {
            $this->Image($image_file1, 245, 4, 39, '', 'PNG');
        }
        $this->SetFont('century gothic', 'B', 20);
        $this->SetXY(5, 0);
        $this->Write(20, 'Boxing Records', '', 0, 'C', true, 0, false, false, 0);
    }

    public function Footer()
    {
        $this->SetFont('century gothic', '', 8);
        $this->SetY(-30);
        if (!empty($this->longTableFooter)) {
            $this->writeHTML($this->longTableFooter, true, false, true, false, '');
        }
    }

    public function setLongTableFooter($html)
    {
        $this->longTableFooter = $html;
    }
}

$fileName = 'BOXING RECORDS.pdf';

$countCheck = mysqli_query($con, $sql_filter);
if ($countCheck && mysqli_num_rows($countCheck) > 0) {
    $pdf = new MYPDF('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetCreator('Your Company');
    $pdf->SetAuthor('Record');
    $pdf->SetTitle('Boxing Records');
    $pdf->SetSubject('Boxing Report');
    $pdf->SetKeywords('Boxing, Records');
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    $pdf->SetMargins(PDF_MARGIN_LEFT, 35, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(30);
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    $html = '
    <style>
      th { font-weight: bold; padding: 6px; }
    </style>
    <table cellpadding="6" border="1" width="100%">
      <tr>
        <th>Issue date:</th>
        <th align="center">Version : </th>
        <th>Author:</th>
      </tr>
      <tr>
        <th>Reason for change:</th>
        <th align="center">DOC REC No. : </th>
        <th>Authorised by: </th>
      </tr>
    </table>';
    $pdf->setLongTableFooter($html);

    $pdf->AddPage('L', 'A4');

    $tbl_header = '<style>
    table { border-spacing: 0; }
    th { background-color:#F0F0F0; border: 1px solid #000000; text-align: center; font-size: 12px; }
    td { border: 1px solid #000000; text-align: center; font-size: 11px; }
    </style>
    <table width="100%" cellspacing="0" cellpadding="4" border="0">
    <tr>
      <th width="4%">Sno</th>
      <th width="13%">Date</th>
      <th width="15%">Product Batchcode</th>
      <th width="12%">Product</th>
      <th width="15%">Box Batchcode</th>
      <th width="12%">Best Before</th>
      <th width="8%">Pack Per Box</th>
      <th width="9%">Total Box</th>
      <th width="12%">User</th>
    </tr>';
    $tbl_footer = '</table>';

    $tbl_body = '';
    $i = 1;

    $pdfQuery = mysqli_query($con, $sql_filter);
    while ($row = mysqli_fetch_array($pdfQuery)) {

        $productName = getProductName($con, $row['productbatch'], $productMap);

        $tbl_body .= '
        <tr>
          <td>' . $i . '</td>
          <td>' . date('d-m-Y h:i A', strtotime($row['cdate'])) . '</td>
          <td>' . $row['productbatch'] . '</td>
          <td>' . $productName . '</td>
          <td>' . $row['boxbatchcode'] . '</td>
          <td>' . (!empty($row['bestbefore']) ? date('d-m-Y', strtotime($row['bestbefore'])) : '') . '</td>
          <td>' . $row['pack'] . '</td>
          <td>' . $row['totalbox'] . '</td>
          <td>' . $row['user'] . '</td>
        </tr>';
        $i++;
    }

    $pdf->writeHTML($tbl_header . $tbl_body . $tbl_footer, true, false, false, false, '');
    $pdf->Output($_SERVER['DOCUMENT_ROOT'] . "finemed/upl1/" . $fileName, "F");
}
?>
<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Traceability</a></li>
            <li>View Detail</li>
        </ul>
    </div>

    <form name="form1" method="post" action="">
        <div class="row">
            <div class="col-4" style="margin:10px">
                <label for="d1" class="control-label mb-1" id="sd1">Select Date</label>
                <div class="input-group">
                    <input type="date" name="d1" id="d1" class="form-control" value="<?php echo htmlspecialchars($date); ?>" />
                </div>
            </div>
            <div class="col-2" style="margin:10px">
                <label class="control-label mb-1"></label>
                <div class="input-group">
                    <button type="submit" class="btn btn-info" style="float:right">
                        <i class="fa fa-list"></i> Select &amp; Go
                    </button>
                </div>
            </div>
        </div>
    </form>
    <br /><br />

    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <a href="admin.php?id=frozen"><button class="btn btn-success" style="float:right; margin-left:15px" type="button">Go Back</button></a>

                    <?php if ($countCheck && mysqli_num_rows($countCheck) > 0) { ?>
                        <a href="<?php echo 'upl1/' . $fileName; ?>" target="_blank"><button class="btn btn-primary" style="float:right; margin-left:15px" type="button">View Report</button></a>
                    <?php } ?>
                    <a href="admin.php?id=fboxing1"><button class="btn btn-info" style="float:right; margin-left:15px" type="button">Add New</button></a>

                    <h4 class="card-title mb-3">
                        Boxing Records
                        <?php if ($date != "") { ?>
                            <small style="font-size:14px;">(Filtered: <?php echo date('d-m-Y', strtotime($date)); ?>)</small>
                        <?php } else { ?>
                            <small style="font-size:14px;">(All Records)</small>
                        <?php } ?>
                    </h4>

                    <div class="row">
                        <div class="table-responsive" id="basket">
                            <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Date</th>
                                        <th>Product Batchcode</th>
                                        <th>Product</th>
                                        <th>Box Batchcode</th>
                                        <th>Best Before</th>
                                        <th>Pack Per Box</th>
                                        <th>Total Box</th>
                                        <th>User</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $tableQuery = mysqli_query($con, $sql_filter);
                                    if ($tableQuery && mysqli_num_rows($tableQuery) > 0) {
                                        $i = 0;
                                        while ($row = mysqli_fetch_array($tableQuery)) {
                                            $i++;
                                            $productName = getProductName($con, $row['productbatch'], $productMap);
                                    ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo date('d-m-Y h:i A', strtotime($row['cdate'])); ?></td>
                                                <td><?php echo $row['productbatch']; ?></td>
                                                <td><?php echo $productName; ?></td>
                                                <td><?php echo $row['boxbatchcode']; ?></td>
                                                <td><?php echo !empty($row['bestbefore']) ? date('d-m-Y', strtotime($row['bestbefore'])) : ''; ?></td>
                                                <td><?php echo $row['pack']; ?></td>
                                                <td><?php echo $row['totalbox']; ?></td>
                                                <td><?php echo $row['user']; ?></td>
                                            </tr>
                                    <?php
                                        }
                                    } else {
                                        echo '<tr><td colspan="9" style="text-align:center;">No records found.</td></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>