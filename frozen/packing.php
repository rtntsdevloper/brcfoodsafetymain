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
    $sql_filter = "SELECT * FROM frozenpacking WHERE DATE(datetime)='$date' ORDER BY id DESC";
} else {
    $sql_filter = "SELECT * FROM frozenpacking ORDER BY id DESC";
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
        $this->Write(20, 'Packing Records', '', 0, 'C', true, 0, false, false, 0);
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

$fileName = 'PACKING RECORDS.pdf';

$countCheck = mysqli_query($con, $sql_filter);
if ($countCheck && mysqli_num_rows($countCheck) > 0) {
    $pdf = new MYPDF('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetCreator('Your Company');
    $pdf->SetAuthor('Record');
    $pdf->SetTitle('Packing Records');
    $pdf->SetSubject('Packing Report');
    $pdf->SetKeywords('Packing, Records');
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
      <th width="14%">Product Batchcode</th>
      <th width="13%">Product</th>
      <th width="12%">Packing Batchcode</th>
      <th width="11%">Shelf Life</th>
      <th width="9%">Qty(pcs)</th>
      <th width="10%">Labelling</th>
      <th width="14%">Image</th>
    </tr>';
    $tbl_footer = '</table>';

    $tbl_body = '';
    $i = 1;

    $productMap = array('2' => 'Samosa', '3' => 'Spring Roll');

    $pdfQuery = mysqli_query($con, $sql_filter);
    while ($row = mysqli_fetch_array($pdfQuery)) {

        $checkQ = mysqli_query($con, "SELECT product FROM frozenproduction 
                                      WHERE batchcode='" . $row['productbatch'] . "' 
                                      AND packing='done'");
        if (mysqli_num_rows($checkQ) == 0) {
            continue;
        }
        $prodR = mysqli_fetch_array($checkQ);
        $productId = $prodR['product'];
        $productName = isset($productMap[$productId]) ? $productMap[$productId] : $productId;

        $imageHtml = '';
        if (!empty($row['img'])) {
            $imageHtml = '<a href="../upl1/' . $row['img'] . '" target="_blank"><img src="upl1/' . $row['img'] . '" height="50" width="70"></a>';
        }

        $tbl_body .= '
        <tr>
          <td>' . $i . '</td>
          <td>' . date('d-m-Y h:i A', strtotime($row['datetime'])) . '</td>
          <td>' . $row['productbatch'] . '</td>
          <td>' . $productName . '</td>
          <td>' . $row['packbatch'] . '</td>
          <td>' . (!empty($row['shelflife']) ? date('d-m-Y', strtotime($row['shelflife'])) : '') . '</td>
          <td>' . $row['qty'] . '</td>
          <td>' . $row['labeling'] . '</td>
          <td>' . $imageHtml . '</td>
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
                    <a href="admin.php?id=fpacking1"><button class="btn btn-info" style="float:right; margin-left:15px" type="button">Add New</button></a>

                    <h4 class="card-title mb-3">
                        Packing Records
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
                                        <th>Packing Batchcode</th>
                                        <th>Shelf Life</th>
                                        <th>Qty(pcs)</th>
                                        <th>Is the Labelling Correct?</th>
                                        <th>Image</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $productMap = array('2' => 'Samosa', '3' => 'Spring Roll');

                                    $tableQuery = mysqli_query($con, $sql_filter);
                                    if ($tableQuery && mysqli_num_rows($tableQuery) > 0) {
                                        $i = 0;
                                        while ($row = mysqli_fetch_array($tableQuery)) {

                                            $checkQ = mysqli_query($con, "SELECT product FROM frozenproduction 
                                                                          WHERE batchcode='" . $row['productbatch'] . "' 
                                                                          AND packing='done'");
                                            if (mysqli_num_rows($checkQ) == 0) {
                                                continue;
                                            }
                                            $i++;
                                            $prodR = mysqli_fetch_array($checkQ);
                                            $productId = $prodR['product'];
                                            $productName = isset($productMap[$productId]) ? $productMap[$productId] : $productId;

                                            if (!empty($row['img'])) {
                                                $image = '<a href="upl1/' . $row['img'] . '" target="_blank"><img src="upl1/' . $row['img'] . '" alt="" height="80" width="100"></a>';
                                            } else {
                                                $image = '';
                                            }
                                    ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo date('d-m-Y h:i A', strtotime($row['datetime'])); ?></td>
                                                <td><?php echo $row['productbatch']; ?></td>
                                                <td><?php echo $productName; ?></td>
                                                <td><?php echo $row['packbatch']; ?></td>
                                                <td><?php echo !empty($row['shelflife']) ? date('d-m-Y', strtotime($row['shelflife'])) : ''; ?></td>
                                                <td><?php echo $row['qty']; ?></td>
                                                <td><?php echo $row['labeling']; ?></td>
                                                <td><?php echo $image; ?></td>
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