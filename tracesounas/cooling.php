<?php
include 'connection.php';
require('tcpdf/tcpdf.php');
ini_set('max_execution_time', 300);

$date = $_POST['d1'];
if ($date == "") {
    $date = date('Y-m-d');
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
        $this->SetFont('Century Gothic', 'B', 20); // safer built-in font
        $this->SetXY(1, 5);
        $this->Write(20, 'Cooling Records', '', 0, 'C', true, 0, false, false, 0);
    } 

    public function Footer() {
        $this->SetFont('helvetica', '', 8);

        // Move footer content up a bit
        $this->SetY(-25);
        if (!empty($this->longTableFooter)) {
            $this->writeHTML($this->longTableFooter);
        }

        // Printed date slightly above bottom
        $this->SetY(-12);
        // $this->Cell(0, 5, 'Printed: ' . date('d-m-Y H:i A'), 0, 0, 'C');
    }

    public function setLongTableFooter($html) {
        $this->longTableFooter = $html;
    }
}

$pdf = new MYPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator('Your Company');
$pdf->SetAuthor('Record');
$pdf->SetTitle('Cooling Records');
$pdf->SetSubject('Cooling Report');
$pdf->SetKeywords('Cooling, Records');
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(PDF_MARGIN_LEFT, 35, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

$pdf->AddPage('L', 'A4');

// Fetch form control data
$f = mysqli_query($con, "SELECT * FROM `tblformcontrol` WHERE tabname='Cooling'");
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
</table>
';

// Apply footer
$pdf->setLongTableFooter($html);

$pdf->SetFont('centurygothic', '', 10);
$pdf->Write(2, "Note: The temperature of the product should be less than 25°C");

$tbl_header = '<style>
table {
   border-spacing: 0;
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
<table id="gallerytab" width="800" cellspacing="0" cellpadding="4" border="0">
  ';

$tbl_footer = '</table>';
$pdf->SetXY(5, 43);

$tbl8 = '';
$tbl8 .= ' <tr>
										  <th width="70">Sno</th>
										    <th width="180">Date</th>
											 <th width="130">Batchcode</th>
                                            <th width="200">Product</th>
											<th width="130">Temperature</th>
											<th width="150">Cooling Spirals </th>
											<th width="150">Checks Carried Out By</th>
                                        </tr>
										';
$upit = mysqli_query($con, "select * from tblcooling where date(datetime)='$date' ORDER by date(datetime) DESC");
$i = 1;
while ($row1 = mysqli_fetch_array($upit)) {

	$sd2 = mysqli_query($con, "select * from tblmarination where batchcode='$row1[productbatch]'");
	$sd3 = mysqli_fetch_array($sd2);

	$sd = mysqli_query($con, "select * from tblrecipe where id='$sd3[name]'");
	$sd1 = mysqli_fetch_array($sd);


	$tbl8 .= '
                                               <tr>
										   <td>' . $i . '</td>
										    <td>' . date('d-m-Y h:i A', strtotime($row1['datetime'])) . '</td>
										    <td>' . $row1['productbatch'] . '</td>
											<td>' . $sd1['name'] . '</td>
											 <td>' . $row1['temp'] . '&deg;C</td>
											  <td>' . $row1['tray'] . '</td>
											 <td>' . $row1['user'] . '</td>
										   
                                          </tr>';
	$i++;
}

$pdf->writeHTML($tbl_header . $tbl8 . $tbl_footer, true, false, false, false, '');




$pdf->Output("upl1/COOLING.pdf", "F");
?><div class="main-content">
	<div class="breadcrumb">
		<h1 class="mr-2"><?php echo $headingname; ?></h1>
		<ul>
			<li><a href="">Traceability</a></li>
			<li>View Detail</li>
		</ul>
	</div>
	<form name="form1" method="post" action="admin?id=cooling&id2=<?php echo $_GET['id2']; ?>">
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

					<a href="upl1/COOLING.pdf" target="_blank"><button class="btn btn-primary" style="float:right; margin-left:15px">View Report</button></a>


					<a href="admin.php?id=cooling1&id2=<?php echo $_GET['id2']; ?>"><button class="btn btn-info" style="float:right; margin-left:15px">Add New</button></a>


					<h4 class="card-title mb-3">Cooling Records</h4>


					<div class="row">




						<div class="table-responsive" id="basket">
							<table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
								<thead>
									<tr>
										<th></th>
										<th>Date</th>
										<th>Batch Code</th>
										<th>Product</th>
										<th>Temperature</th>
										<th>Cooling Spirals</th>
									</tr>
								</thead>
								<tbody>


									<?php

									$sql = mysqli_query($con, "select * from tblcooling where date(datetime)='$date' ORDER by date(datetime) DESC");
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
											<td><?php echo $row['temp']; ?>&deg;C</td>
											<td><?php echo $row['tray']; ?></td>
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