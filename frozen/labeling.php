<?php
include 'connection.php';
require('tcpdf/tcpdf.php');
ini_set('max_execution_time', 300);

$vdate = isset($_POST['d1']) ? trim($_POST['d1']) : '';

if ($vdate != "") {
    $sql_filter = "SELECT * FROM `frozenlabeling` WHERE DATE(dates)='$vdate' ORDER BY dates DESC";
} else {
    $sql_filter = "SELECT * FROM `frozenlabeling` ORDER BY dates DESC";
}

class MYPDF extends TCPDF
{
    private $longTableFooter = '';

    public function Header()
    {
        $image_file  = 'images/1.png';
        $image_file1 = 'images/rtnts.png';
        if (file_exists($image_file)) {
            $this->Image($image_file, 10, 8, 25, '', 'PNG');
        }
        if (file_exists($image_file1)) {
            $this->Image($image_file1, 250, 8, 35, '', 'PNG');
        }
        $this->SetFont('helvetica', 'B', 18);
        $this->SetY(15);
        $this->Cell(0, 10, 'Labelling & Sealing Records', 0, 1, 'C');
    }

    public function Footer()
    {
        $this->SetFont('helvetica', '', 8);
        $this->SetY(-25);
        if (!empty($this->longTableFooter)) {
            $this->writeHTML($this->longTableFooter, true, false, true, false, '');
        }
    }

    public function setLongTableFooter($html)
    {
        $this->longTableFooter = $html;
    }
}

$fileName = 'LABELLING RECORDS.pdf';

$countCheck = mysqli_query($con, $sql_filter);

if ($countCheck && mysqli_num_rows($countCheck) > 0) {

    $pdf = new MYPDF('L', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetCreator('Your Company');
    $pdf->SetAuthor('Record');
    $pdf->SetTitle('Labelling & Sealing Records');
    $pdf->SetSubject('Labelling Report');
    $pdf->SetKeywords('Labelling, Sealing, Records');
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    $pdf->SetMargins(10, 35, 10);
    $pdf->SetHeaderMargin(5);
    $pdf->SetFooterMargin(25);
    $pdf->SetAutoPageBreak(TRUE, 30);
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    $f  = mysqli_query($con, "SELECT * FROM `tblformcontrol` WHERE tabname='Labelling'");
    $f1 = mysqli_fetch_array($f);
    $issuedate = !empty($f1['issuedate']) ? date("d-m-Y", strtotime($f1['issuedate'])) : '';

    $html = '
    <style>
      th { font-weight: bold; padding: 5px; font-size: 9px; }
    </style>
    <table cellpadding="5" border="1" width="100%">
      <tr>
        <th width="33%">Issue date: ' . $issuedate . '</th>
        <th width="34%" align="center">Version : ' . $f1['version'] . '</th>
        <th width="33%">Author: ' . $f1['author'] . '</th>
      </tr>
      <tr>
        <th width="33%">Reason for change: ' . $f1['reason'] . '</th>
        <th width="34%" align="center">DOC REC No. : ' . $f1['docref'] . '</th>
        <th width="33%">Authorised by: ' . $f1['authoriesby'] . '</th>
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
      font-size: 10px;
      padding: 5px;
    }
    td {
      border: 1px solid #000000;
      text-align: center;
      font-size: 9px;
      padding: 4px;
    }
    </style>
    <table width="100%" cellspacing="0" cellpadding="4" border="0">
    <tr>
      <th width="4%">Sno</th>
      <th width="10%">Date</th>
      <th width="13%">Production Batch</th>
      <th width="13%">Pouches Sealed Properly?</th>
      <th width="13%">Labelling Correct?</th>
      <th width="13%">Batch Code &amp; BBD Printed?</th>
      <th width="17%">Comments</th>
      <th width="9%">Updated By</th>
      <th width="11%">Updated On</th>
    </tr>';
    $tbl_footer = '</table>';

    $tbl_body = '';
    $i = 1;

    $pdfQuery = mysqli_query($con, $sql_filter);
    while ($row1 = mysqli_fetch_array($pdfQuery)) {

        $tbl_body .= '
        <tr>
          <td>' . $i . '</td>
          <td>' . date('d-m-Y', strtotime($row1['dates'])) . '</td>
          <td>' . $row1['productbatch'] . '</td>
          <td>' . $row1['sealed'] . '</td>
          <td>' . $row1['labelling'] . '</td>
          <td>' . $row1['print'] . '</td>
          <td>' . $row1['comments'] . '</td>
          <td>' . $row1['user'] . '</td>
          <td>' . date('d-m-Y h:i:s', strtotime($row1['cdate'])) . '</td>
        </tr>';

        if ($i == 1) {
            $fileName = $row1['productbatch'] . '_LABELLING RECORDS.pdf';
        }
        $i++;
    }

    $pdf->writeHTML($tbl_header . $tbl_body . $tbl_footer, true, false, false, false, '');
    $pdf->Output($_SERVER['DOCUMENT_ROOT'] . "finemed/upl1/" . $fileName, "F");
}
?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2">Labelling &amp; Sealing Record</h1>
        <ul>
            <li><a href="">Traceability</a></li>
            <li>View Detail</li>
        </ul>
    </div>

    <form name="form1" method="post" action="admin?id=flabeling&id2=<?php echo $_GET['id2']; ?>">
        <div class="row">
            <div class="col-4" style="margin:10px">
                <label for="d1" class="control-label mb-1">Select Date</label>
                <div class="input-group">
                    <input type="date" name="d1" id="d1" class="form-control" value="<?php echo $vdate; ?>" />
                </div>
            </div>
            <div class="col-2" style="margin:10px">
                <label class="control-label mb-1"></label>
                <div class="input-group">
                    <button type="submit" class="btn btn-info" style="float:right">
                        <li class="fa fa-list"></li> Select &amp; Go
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

                    <a href="admin.php?id=frozen">
                        <button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button>
                    </a>

                    <?php if ($countCheck && mysqli_num_rows($countCheck) > 0) { ?>
                        <a href="<?php echo 'upl1/' . $fileName; ?>" target="_blank">
                            <button class="btn btn-warning ml-3" style="float:right; margin-left:15px">View Report</button>
                        </a>
                    <?php } ?>

                    <a href="admin.php?id=flabeling1&id2=<?php echo $_GET['id2']; ?>">
                        <button class="btn btn-danger" style="float:right">Add Labelling</button>
                    </a>

                    <h4 class="card-title mb-3">
                        Labelling &amp; Sealing Record
                        <?php if ($vdate != "") { ?>
                            <small style="font-size:14px;">(Filtered: <?php echo date('d-m-Y', strtotime($vdate)); ?>)</small>
                        <?php } else { ?>
                            <small style="font-size:14px;">(All Records)</small>
                        <?php } ?>
                    </h4>

                    <p>List of Record</p>

                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Production Batch</th>
                                    <th>Is the Pouches Sealed Properly?</th>
                                    <th>Is labelling correct on packet?</th>
                                    <th>Is batch code &amp; BBD printed adequately?</th>
                                    <th>Comments (if applicable)</th>
                                    <th>Updated By</th>
                                    <th>Updated On</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $tableQuery = mysqli_query($con, $sql_filter);
                            $i = 1;
                            if ($tableQuery && mysqli_num_rows($tableQuery) > 0) {
                                while ($row = mysqli_fetch_array($tableQuery)) {
                            ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo date('d-m-Y', strtotime($row['dates'])); ?></td>
                                    <td><?php echo $row['productbatch']; ?></td>
                                    <td><?php echo $row['sealed']; ?></td>
                                    <td><?php echo $row['labelling']; ?></td>
                                    <td><?php echo $row['print']; ?></td>
                                    <td><?php echo $row['comments']; ?></td>
                                    <td><?php echo $row['user']; ?></td>
                                    <td><?php echo date('d-m-Y h:i:s', strtotime($row['cdate'])); ?></td>
                                </tr>
                            <?php
                                    $i++;
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