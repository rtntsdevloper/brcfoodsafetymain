<?php

require('tcpdf/tcpdf.php');
ini_set('max_execution_time', 300);


// create new PDF document
class MYPDF extends TCPDF 
{
     public function Header() 
	 { 
	 $image_file = 'images/1.png';
		$image_file1 = 'images/rtnts.png';
        $this->Image($image_file, 5, 5, 25, '', 'PNG', '', 'T', false, 200, '', false, false, 0, false, false, false);
		 $this->Image($image_file1, 165, 4, 39, '', 'PNG', '', 'T', false, 200, '', false, false, 0, false, false, false);
		$this->SetFont('centurygothic', '', 20);
		
		$this->SetXY(75,0);
		$this->Write(20,'Cooling Records', '', 0, '10', true, 0, false, false, 0);
       
    }

    public function Footer()
	 {
	}
}

$pdf = new MYPDF('P', 'mm', 'A4', true, 'UTF-8', false);

$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->SetMargins(PDF_MARGIN_LEFT, 35,PDF_MARGIN_RIGHT);

$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


if (@file_exists(dirname(__FILE__).'/lang/eng.php')) 
{
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}
$pdf->AddPage('P', 'A4');
$pdf->SetFont('centurygothic', '',8);

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
			  $pdf->SetXY(5,30);
			   
			   $tbl8='';
			 $tbl8 .= ' <tr>
										  <th width="70">Sno</th>
										    <th width="130">Date</th>
											 <th width="150">Batchcode</th>
                                            <th width="200">Product</th>
											<th width="150">Temperature</th>
                                        </tr>
										';
$upit = mysqli_query($con,"select * from tblcooling");
 $i=1;
while($row1=mysqli_fetch_array($upit))
{

$sd2=mysqli_query($con,"select * from tblmarination where batchcode='$row1[productbatch]'");
									$sd3=mysqli_fetch_array($sd2);
									
									$sd=mysqli_query($con,"select * from tblrecipe where id='$sd3[name]'");
									$sd1=mysqli_fetch_array($sd);


$tbl8 .= '
                                               <tr>
										   <td>'.$i.'</td>
										    <td>'. date('d-m-Y h:i', strtotime($row1['datetime'])).'</td>
										    <td>'.$row1['productbatch'].'</td>
											<td>'.$sd1['name'].'</td>
											 <td>'.$row1['temp'].'&deg;C</td>
										   
                                          </tr>';
$i++;
}   
			   
	$pdf->writeHTML($tbl_header . $tbl8 . $tbl_footer, true, false, false, false, '');		   
			   



$pdf->Output("upl1/COOLING.pdf","F");
?><div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Traceability</a></li>
                        <li>View Detail</li>
                    </ul>
                </div>
						
												
				
			       <div class="row mb-12">
                    <div class="col-md-12 mb-12">
                        <div class="card text-left">
                            <div class="card-body">
							
							<a href="admin.php?id=goods1&id2=<?php echo $_GET['id2'];?>"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							
							<a href="upl1/COOLING.pdf" target="_blank"><button class="btn btn-primary" style="float:right; margin-left:15px">View Report</button></a>
							
							
							 <a href="admin.php?id=cooling1&id2=<?php echo $_GET['id2'];?>"><button class="btn btn-info" style="float:right; margin-left:15px">Add New</button></a>
						
							
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
                                        </tr>
                                    </thead>
                                    <tbody>
									
									
									<?php
									$date=date('Y-m-d');
									$sql=mysqli_query($con,"select * from tblcooling");
									$i=0;
									while($row=mysqli_fetch_array($sql))
									{
									$i++;
									
									$sd2=mysqli_query($con,"select * from tblmarination where batchcode='$row[productbatch]'");
									$sd3=mysqli_fetch_array($sd2);
									
									$sd=mysqli_query($con,"select * from tblrecipe where id='$sd3[name]'");
									$sd1=mysqli_fetch_array($sd);
									?>
									
                                    <tr>
									<td><?php echo $i;?></td>
									<td><?php echo date('d-m-Y', strtotime($row['datetime']));?></td>
									<td><?php echo $row['productbatch'];?></td>
									<td><?php echo $sd1['name'];?></td>
									<td><?php echo $row['temp'];?>&deg;C</td>
                                    </tr>
									
									<?php
									 }
									?>
										</tbody>
                                    </table>
									</div>
									</div>
									
									
									
									
									
                               </div></div></div></div>