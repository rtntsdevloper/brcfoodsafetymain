<?php
include 'connection.php';
$date = $_POST['d1'];
if ($date == "") {
    $date = date('Y-m-d');
}

require('tcpdf/tcpdf.php');
ini_set('max_execution_time', 300);

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
        $this->SetFont('centurygothic', '', 20);
        $this->SetXY(30, 6);
        $this->Write(20, 'Boxing Records', '', 0, 'C', true, 0, false, false, 0);
    }

    public function Footer() {
        $this->SetFont('centurygothic', '', 8);

        // Footer table higher
        $this->SetY(-30);
        if (!empty($this->longTableFooter)) {
            $this->writeHTML($this->longTableFooter, true, false, true, false, '');
        }

        // Printed line at bottom
        $this->SetY(-12);
        // $this->Cell(0, 5, 'Printed: ' . date('d-m-Y H:i A') . 
        //     ' | Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 0, 'C');
    }

    public function setLongTableFooter($html) {
        $this->longTableFooter = $html;
    }
}

$pdf = new MYPDF('L', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(35, 30, 35);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(40);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

$pdf->AddPage();

$f = mysqli_query($con, "SELECT * FROM `tblformcontrol` WHERE tabname='Boxing'");
$f1 = mysqli_fetch_array($f);
$issuedate = !empty($f1['issuedate']) ? date("d-m-Y", strtotime($f1['issuedate'])) : '';

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

$tbl_header = '<style>
th { background-color:#F0F0F0; border:1px solid #000; text-align:center; }
td { border:1px solid #000; text-align:center; }
</style>
<table width="100%" cellspacing="0" cellpadding="4" border="0">
<tr>
  <th width="6%">Sno</th>
  <th width="10%">Date</th>
  <th width="15%">Product</th>
  <th width="15%">Box Batchcode</th>
  <th width="10%">Product Code</th>
  <th width="10%">Product</th>
  <th width="8%">Best Before</th>
  <th width="8%">Total Box</th>
  <th width="8%">Packs/Box</th>
  <th width="12%">Checks By</th>
</tr>';
$tbl_footer = '</table>';

$tbl_body = '';
$i = 1;

$upit = mysqli_query($con, "SELECT * FROM tblboxing WHERE DATE(datetime)='$date' ORDER BY datetime DESC");
while ($row1 = mysqli_fetch_array($upit)) {
    $sd2 = mysqli_query($con, "SELECT * FROM tblmarination WHERE batchcode='" . $row1['productbatch'] . "'");
    $sd3 = mysqli_fetch_array($sd2);

    $sd = mysqli_query($con, "SELECT * FROM tblrecipe WHERE id='" . $row1['sno'] . "'");
    $sd1 = mysqli_fetch_array($sd);

    $sd2 = mysqli_query($con, "SELECT * FROM tblrecipe WHERE id='" . $sd3['name'] . "'");
    $sd3 = mysqli_fetch_array($sd2);

    $tbl_body .= '
    <tr>
      <td>' . $i . '</td>
      <td>' . date('d-m-Y h:i A', strtotime($row1['datetime'])) . '</td>
      <td>' . $sd1['name'] . '</td>
      <td>' . $row1['boxbatchcode'] . '</td>
      <td>' . $row1['productbatch'] . '</td>
      <td>' . $sd3['name'] . '</td>
      <td>' . $row1['bestbefore'] . '</td>
      <td>' . $row1['totalbox'] . '</td>
      <td>' . $row1['img'] . '</td>
      <td>' . $row1['user'] . '</td>
    </tr>';
    $i++;
}

$pdf->writeHTML($tbl_header . $tbl_body . $tbl_footer, true, false, false, false, '');
$pdf->Output("upl1/BOXING RECORDS.pdf", "F");
?>


<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Traceability</a></li>
                        <li>View Detail</li>
                    </ul>
                </div>
						
					<form name="form1" method="post" action="admin?id=boxing&id2=<?php echo $_GET['id2'];?>">
						<div class="row" >
				
				
		                                           <div class="col-4" style="margin:10px">
                                                        <label for="cc-exp" class="control-label mb-1" id="sd1">Select Date</label>
														 <div class="input-group">
														 
                                                        <input type="date" name="d1"  id="d1" class="form-control" required />
                                                    </div> </div>
													
													
												       	
													<div class="col-2" style="margin:10px">
                                                        <label for="cc-exp" class="control-label mb-1"></label>
														 <div class="input-group">
														  <button type="submit" class="btn btn-info" style="float:right" onclick="return cal();"><li class="fa fa-list"></li> Select & Go</button>
													</div></div>
													
													</div>
													</form>
												</br></br>							
				
			       <div class="row mb-12">
                    <div class="col-md-12 mb-12">
                        <div class="card text-left">
                            <div class="card-body">
							
							<a href="admin.php?id=goods1&id2=<?php echo $_GET['id2'];?>"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							 <a href="upl1/BOXING RECORDS.pdf" target="_blank"><button class="btn btn-primary" style="float:right; margin-left:15px">View Report</button></a>
							 <a href="admin.php?id=boxingg&id2=<?php echo $_GET['id2'];?>"><button class="btn btn-info" style="float:right; margin-left:15px">Add New</button></a>
						
							
                             <h4 class="card-title mb-3">Boxing Records</h4>
								
                           
								 <div class="row">
                                    
									
									
								
								  <div class="table-responsive" id="basket"> 
                                     <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                     <thead>
                                        <tr>
										     <th></th>
										    <th>Date</th>
											<th>Box Name</th>
											<th>Box Batch Code</th>
											<th>Product Batch Code</th>
											<th>Product</th>
											<th>Best Before</th>
											<th>Total Box</th>
																						
                                        </tr>
                                    </thead>
                                    <tbody>
									
									
									<?php
									
									$sql=mysqli_query($con,"select * from tblboxing where date(datetime)='$date' ORDER by date(datetime) DESC");
									$i=0;
									while($row=mysqli_fetch_array($sql))
									{
									$i++;
									
									$sd2=mysqli_query($con,"select * from tblmarination where batchcode='$row[productbatch]'");
									$sd3=mysqli_fetch_array($sd2);
									
									$sd=mysqli_query($con,"select * from tblrecipe where id='$row[sno]'");
									$sd1=mysqli_fetch_array($sd);
									
									$sd2=mysqli_query($con,"select * from tblrecipe where id='$sd3[name]'");
									$sd3=mysqli_fetch_array($sd2);
									
									?>
                                     <tr>
										 <td><?php echo $i;?></td>
										 <td><?php echo date('d-m-Y h:i A', strtotime($row['datetime']));?></td>
										  <td><?php echo $sd1['name'];?></td>
                                          <td><?php echo $row['boxbatchcode'];?></td>
										 <td><?php echo $row['productbatch'];?></td>
											<td><?php echo $sd3['name'];?></td>
											
											 <td><?php echo $row['bestbefore'];?></td>
											 <td><?php echo $row['totalbox'];?></td>
											 
											
                                          </tr>
										    <?php
										     }
										       ?>
										</tbody>
                                    </table>
									</div>
									</div>
									
									
									
									
									
                               </div></div></div></div>