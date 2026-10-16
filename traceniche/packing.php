<!-- <?php
include 'connection.php';
require('tcpdf/tcpdf.php');
ini_set('max_execution_time', 300);

$date = $_POST['d1'];

if ($date == "") {
    $datex1 = date('Y-m-d', strtotime('first day of this month'));
    $datex2 = date('Y-m-d', strtotime('last day of this month'));
    $upit = mysqli_query($con, "SELECT * FROM tblpacking WHERE date BETWEEN '$datex1' AND '$datex2' ORDER BY DATE(datetime) DESC");
} else {
    $date = $_POST['d1'];
    $upit = mysqli_query($con, "SELECT * FROM tblpacking WHERE DATE(datetime)='$date' ORDER BY DATE(datetime) DESC");
}

// create new PDF document
class MYPDF extends TCPDF {
    private $longTableFooter = '';

    public function Header() {
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
        $this->Write(20, 'Packaging Records', '', 0, 'C', true, 0, false, false, 0);
    }

    public function Footer() {
        $this->SetFont('helvetica', '', 8);

        // Footer table ~30mm from bottom
        $this->SetY(-30);
        if (!empty($this->longTableFooter)) {
            $this->writeHTML($this->longTableFooter, true, false, true, false, '');
        }


    }

    public function setLongTableFooter($html) {
        $this->longTableFooter = $html;
    }
}

$pdf = new MYPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator('Your Company');
$pdf->SetAuthor('Record');
$pdf->SetTitle('Packaging Records');
$pdf->SetSubject('Packaging Report');
$pdf->SetKeywords('Packaging, Records');
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(PDF_MARGIN_LEFT, 35, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(40); // reserve enough space for footer
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

$pdf->AddPage('L', 'A4');

// Fetch form control data
$f = mysqli_query($con, "SELECT * FROM `tblformcontrol` WHERE tabname='Packaging'");
$f1 = mysqli_fetch_array($f);
$issuedate = !empty($f1['issuedate']) ? date("d-m-Y", strtotime($f1['issuedate'])) : '';

// Footer HTML
$html = '
<style>
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
    <th align="center">DOC REC No. : ' . $f1['refno'] . '</th>
    <th>Authorised by: ' . $f1['authoriesby'] . '</th>
  </tr>
</table>';
$pdf->setLongTableFooter($html);

// Table header
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
  <th width="50">Sno</th>
  <th width="120">Date</th>
  <th width="120">Batchcode</th>
  <th width="120">Product</th>
  <th width="80">Gas %</th>
  <th width="100">Top Film</th>
  <th width="100">Bottom Film</th>
  <th width="120">Packing Machines</th>
  <th width="100">Checks By</th>
</tr>';
$tbl_footer = '</table>';

$tbl_body = '';
$i = 1;
while ($row1 = mysqli_fetch_array($upit)) {
    $sd2 = mysqli_query($con, "SELECT * FROM tblmarination WHERE batchcode='" . $row1['productbatch'] . "'");
    $sd3 = mysqli_fetch_array($sd2);

    $sd = mysqli_query($con, "SELECT * FROM tblrecipe WHERE id='" . $sd3['name'] . "'");
    $sd1 = mysqli_fetch_array($sd);

    $tbl_body .= '
    <tr>
      <td>' . $i . '</td>
      <td>' . date('d-m-Y h:i A', strtotime($row1['datetime'])) . '</td>
      <td>' . $row1['productbatch'] . '</td>
      <td>' . $sd1['name'] . '</td>
      <td>' . $row1['gas'] . '%</td>
      <td>' . $row1['packfilm'] . '</td>
      <td>' . $row1['botfilm'] . '</td>
      <td>' . $row1['tray'] . '</td>
      <td>' . $row1['user'] . '</td>
    </tr>';
    $i++;
}

$pdf->writeHTML($tbl_header . $tbl_body . $tbl_footer, true, false, false, false, '');
$pdf->Output("upl1/PACKAGING RECORDS.pdf", "F");
?> -->



<div class="main-content">
	<div class="breadcrumb">
		<h1 class="mr-2"><?php echo $headingname; ?></h1>
		<ul>
			<li><a href="">Traceability</a></li>
			<li>View Detail</li>
		</ul>
	</div>

	<form name="form1" method="post" action="admin?id=packing&id2=<?php echo $_GET['id2']; ?>">
		<div class="row">


			<div class="col-4" style="margin:10px">
				<label for="cc-exp" class="control-label mb-1" id="sd1">Select Date</label>
				<div class="input-group">

					<input type="date" name="d1" id="d1" class="form-control" required />
				</div>
			</div>



			<div class="col-2" style="margin:10px">
				<label for="cc-exp" class="control-label mb-1"></label>
				<div class="input-group">
					<button type="submit" class="btn btn-info" style="float:right" onclick="return cal();">
						<li class="fa fa-list"></li> Select & Go
					</button>
				</div>
			</div>

		</div>
	</form>
	</br></br>



	<div class="row mb-12">
		<div class="col-md-12 mb-12">
			<div class="card text-left">
				<div class="card-body">

					<a href="admin.php?id=goods1&id2=<?php echo $_GET['id2']; ?>"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
					<a href="upl1/PACKAGING RECORDS.pdf" target="_blank"><button class="btn btn-primary" style="float:right; margin-left:15px">View Report</button></a>
					<a href="admin.php?id=packing1&id2=<?php echo $_GET['id2']; ?>"><button class="btn btn-info" style="float:right; margin-left:15px">Add New</button></a>


					<h4 class="card-title mb-3">Packaging Records</h4>


					<div class="row">




						<div class="table-responsive" id="basket">
							<table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
								<thead>
									<tr>
										<th></th>
										<th>Date</th>
										<th>Batch Code</th>
										<th>Product</th>
										<th>Gas Percentage</th>
										<th>Top Film</th>
										<th>Bottom Film</th>
										<th>Packing Machines </th>
										<th>Photo</th>

									</tr>
								</thead>
								<tbody>


									<?php

									$sql = mysqli_query($con, "select * from tblpacking where date(datetime)='$date' ORDER by date(datetime) DESC");
									$i = 0;
									while ($row = mysqli_fetch_array($sql)) {
										$i++;

										$sd2 = mysqli_query($con, "select * from tblmarination where batchcode='$row[productbatch]'");
										$sd3 = mysqli_fetch_array($sd2);

										$sd = mysqli_query($con, "select * from tblrecipe where id='$sd3[name]'");
										$sd1 = mysqli_fetch_array($sd);

									?>
										<tr>
											<td><?php echo $i; ?></td>
											<td><?php echo date('d-m-Y h:i A', strtotime($row['datetime'])); ?></td>
											<td><?php echo $row['productbatch']; ?></td>
											<td><?php echo $sd1['name']; ?></td>
											<td><?php echo $row['gas']; ?>%</td>
											<td><?php echo $row['packfilm']; ?></td>
											<td><?php echo $row['botfilm']; ?></td>
											<td><?php echo $row['tray']; ?></td>
											<td><img src="<?php echo $_GET['id2']; ?>/img/<?php echo $row['img']; ?>" width="70" />

											</td>
										</tr>

									<?php
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