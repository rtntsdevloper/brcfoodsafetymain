<?php
include 'connection.php';
require('tcpdf/tcpdf.php');
ini_set('max_execution_time', 300);

// ---- Read filter date from POST ----
$date = '';
if (isset($_POST['d1']) && $_POST['d1'] != '') {
    $date = $_POST['d1'];
}
$date = mysqli_real_escape_string($con, $date);

// ---- Build filter query ----
if ($date != "") {
    $sql_filter = "SELECT * FROM frozenstorage WHERE DATE(datetime)='$date' ORDER BY datetime DESC";
} else {
    $sql_filter = "SELECT * FROM frozenstorage ORDER BY datetime DESC";
}

// ---- PDF class ----
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
        $this->SetFont('helvetica', 'B', 20);
        $this->SetXY(5, 0);
        $this->Write(20, 'Storage Records', '', 0, 'C', true, 0, false, false, 0);
    }

    public function Footer()
    {
        $this->SetFont('helvetica', '', 8);
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

$fileName = 'STORAGE RECORDS.pdf';

// ---- Generate PDF if there is at least one record ----
$countCheck = mysqli_query($con, $sql_filter);
if ($countCheck && mysqli_num_rows($countCheck) > 0) {
    $pdf = new MYPDF('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetCreator('Your Company');
    $pdf->SetAuthor('Record');
    $pdf->SetTitle('Storage Records');
    $pdf->SetSubject('Storage Report');
    $pdf->SetKeywords('Storage, Records');
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    $pdf->SetMargins(PDF_MARGIN_LEFT, 35, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(30);
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    $f = mysqli_query($con, "SELECT * FROM `tblformcontrol` WHERE tabname='Storage'");
    $f1 = mysqli_fetch_array($f);
    $issuedate = !empty($f1['issuedate']) ? date("d-m-Y", strtotime($f1['issuedate'])) : '';

    $html = '<style>
      th { font-weight: bold; padding: 6px; }
    </style>
    <table cellpadding="6" border="1" width="100%">
      <tr>
        <th>Issue date: ' . $issuedate . '</th>
        <th align="center">Version : ' . $f1['version'] . '</th>
        <th>Author: ' . $f1['author'] . '</th>
      </tr>
      <tr>
        <th>Reason for change: ' . $f1['reason'] . '</th>
        <th align="center">DOC REC No. : ' . $f1['docref'] . '</th>
        <th>Authorised by: ' . $f1['authoriesby'] . '</th>
      </tr>
    </table>';
    $pdf->setLongTableFooter($html);

    $pdf->AddPage('L', 'A4');

    $tbl_header = '<style>
    table { border-spacing: 0; }
    th {
      background-color:#F0F0F0;
      border: 1px solid #000000;
      text-align: center;
    }
    td {
      border: 1px solid #000000;
      text-align: center;
    }
    </style>
    <table width="100%" cellspacing="0" cellpadding="4" border="0">
    <tr>
      <th width="4%">Sno</th>
      <th width="9%">Date</th>
      <th width="13%">Batchcode</th>
      <th width="12%">Product</th>
      <th width="9%">Shelf Life</th>
      <th width="10%">Freezer No.</th>
      <th width="12%">Temperature</th>
      <th width="15%">Storage Batchcode</th>
      <th width="9%">Qty(kg)</th>
      <th width="10%">Checks By</th>
    </tr>';
    $tbl_footer = '</table>';

    $tbl_body = '';
    $i = 1;

    $pdfQuery = mysqli_query($con, $sql_filter);
    while ($row1 = mysqli_fetch_array($pdfQuery)) {
        $sd2 = mysqli_query($con, "SELECT * FROM frozenmarination WHERE batchcode='" . $row1['productbatch'] . "'");
        $sd3 = mysqli_fetch_array($sd2);

        $sd = mysqli_query($con, "SELECT * FROM frozenrecipe WHERE id='" . $sd3['name'] . "'");
        $sd1 = mysqli_fetch_array($sd);

        $tbl_body .= '
        <tr>
          <td>' . $i . '</td>
          <td>' . date('d-m-Y h:i A', strtotime($row1['datetime'])) . '</td>
          <td>' . $row1['productbatch'] . '</td>
          <td>' . $sd1['name'] . '</td>
          <td>' . (!empty($row1['shelflife']) ? date('d-m-Y', strtotime($row1['shelflife'])) : '') . '</td>
          <td>' . $row1['freezerno'] . '</td>
          <td>' . $row1['temp'] . ' °C </td>
          <td>' . $row1['storagecode'] . '</td>
          <td>' . $row1['nosheet'] . '</td>
          <td>' . $row1['user'] . '</td>
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
        <input type="hidden" name="id" value="fstorage" />
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
                    <a href="admin.php?id=faddstorage"><button class="btn btn-info" style="float:right; margin-left:15px" type="button">Add New</button></a>

                    <h4 class="card-title mb-3">
                        Storage Records
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
                                        <th>Batch Code</th>
                                        <th>Product</th>
                                        <th>Shelf Life</th>
                                        <th>Freezer No.</th>
                                        <th>Temperature</th>
                                        <th>Storage Batchcode</th>
                                        <th>Qty(kg)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $tableQuery = mysqli_query($con, $sql_filter);
                                    if ($tableQuery && mysqli_num_rows($tableQuery) > 0) {
                                        $i = 0;
                                        while ($row = mysqli_fetch_array($tableQuery)) {
                                            $i++;

                                            $sd2 = mysqli_query($con, "select * from frozenmarination where batchcode='$row[productbatch]'");
                                            $sd3 = mysqli_fetch_array($sd2);

                                            $sd = mysqli_query($con, "select * from frozenrecipe where id='$sd3[name]'");
                                            $sd1 = mysqli_fetch_array($sd);
                                    ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo date('d-m-Y h:i A', strtotime($row['datetime'])); ?></td>
                                                <td><?php echo $row['productbatch']; ?></td>
                                                <td><?php echo $sd1['name']; ?></td>
                                                <td><?php echo !empty($row['shelflife']) ? date('d-m-Y', strtotime($row['shelflife'])) : ''; ?></td>
                                                <td><?php echo $row['freezerno']; ?></td>
                                                <td><?php echo $row['temp']; ?>°C </td>
                                                <td><?php echo $row['storagecode']; ?></td>
                                                <td><?php echo $row['nosheet']; ?></td>
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