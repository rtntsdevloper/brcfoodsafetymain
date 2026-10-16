<?php


$date=$_POST['d1'];

if($date=="")
{
$date=date('Y-m-d');
}
else
{
$date=$_POST['d1'];
}


?>
<?php

require('tcpdf/tcpdf.php');
ini_set('max_execution_time', 300);


// create new PDF document
class MYPDF extends TCPDF 
{
private $longTableFooter = '';

     public function Header() 
	 { 
		 $image_file = 'images/1.png';
		$image_file1 = 'images/rtnts.png';
        $this->Image($image_file, 5, 5, 25, '', 'PNG', '', 'T', false, 200, '', false, false, 0, false, false, false);
		 $this->Image($image_file1, 165, 4, 39, '', 'PNG', '', 'T', false, 200, '', false, false, 0, false, false, false);
		$this->SetFont('centurygothic', '', 20);
		
		$this->SetXY(75,0);
		$this->Write(20,'Scale Calibration', '', 0, '10', true, 0, false, false, 0);
       
    }

    public function Footer() 
	  {
	  $this->SetFont('centurygothic', '',8);
       $this->writeHTML($this->longTableFooter);
	    $this->SetY(-10);
       
        $this->Cell(450, 5, 'Printed: '.date('d-m-Y H:i A'), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	    
		 
     }
	public function setLongTableFooter($html) {
$this->longTableFooter = $html;
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

$footer=<<<EOD

<table border="1"  width="100%" border="0.5" cellpadding="3">
  <tr>
  <td style="text-align:center">Version: 01 </td>
  <td style="text-align:center; padding-top:15px;">Issue Date. 12/09/24</td>
  <td style="text-align:center; padding-top:15px;">Approved by: Paramvir S. Deol</td>
  <td style="text-align:center; padding-top:15px;"></td>
  </tr>
</table>
EOD;
$pdf->setLongTableFooter($footer);


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
										    <th width="115">Date</th>
											<th width="75">Scale No</th>
											<th width="75">Weight</th>
											<th width="75">Left Top</th>
											<th width="75">Right Top</th>
											<th width="75">Left Bottom</th>
											<th width="75">Right Bottom</th>
											<th width="75">Centre</th>
                                        </tr>
										';
$upit = mysqli_query($con,"select * from tblscale where date(datetime)='$date' ORDER by date(datetime) DESC");
 $i=1;
while($row1=mysqli_fetch_array($upit))
{

                                              $str= explode(";",$row1['ans']);
								$tbl8 .= '
                                     <tr>
										 <td>'.$i.'</td>
										 <td>'.date('d-m-Y h:i A', strtotime($row1['date'])).'</td>
										  <td>Scale '.$row1['scale'].'</td>
                                          <td> '.$row1['testpiece'].' G</td>
										 <td>'.$str[0].'</td>
										 <td>'.$str[1].'</td>
										 <td>'.$str[2].'</td>
										 <td>'.$str[3].'</td>
										 <td>'.$str[4].'</td>
											
											 
											
                                          </tr>';
$i++;
}   
			   
	$pdf->writeHTML($tbl_header . $tbl8 . $tbl_footer, true, false, false, false, '');		   
			   



$pdf->Output("upl1/Scale Calibration.pdf","F");
?>

<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Scale Calibration</a></li>
                        <li>View Detail</li>
                    </ul>
                </div>
						
					<form name="form1" method="post" action="admin?id=scale&id2=<?php echo $_GET['id2'];?>">
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
							 <a href="upl1/Scale Calibration.pdf" target="_blank"><button class="btn btn-primary" style="float:right; margin-left:15px">View Report</button></a>
							 <a href="admin.php?id=scale1&id2=<?php echo $_GET['id2'];?>"><button class="btn btn-info" style="float:right; margin-left:15px">Add New</button></a>
						
							
                             <h4 class="card-title mb-3">Scale Calibration</h4>
								
                           
								 <div class="row">
                                    
									
									
								
								  <div class="table-responsive" id="basket"> 
                                     <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                     <thead>
                                        <tr>
										     <th></th>
										    <th>Date</th>
											<th>Scale No</th>
											<th>Weight</th>
											<th>Left Top</th>
											<th>Right Top</th>
											<th>Left Bottom</th>
											<th>Right Bottom</th>
											<th>Centre</th>
																						
                                        </tr>
                                    </thead>
                                    <tbody>
									
									
									<?php
									
									$sql=mysqli_query($con,"select * from tblscale where date(datetime)='$date' ORDER by date(datetime) DESC");
									$i=0;
									while($row=mysqli_fetch_array($sql))
									{
									$i++;
									
									$str= explode(";",$row['ans']);
									?>
                                     <tr>
										 <td><?php echo $i;?></td>
										 <td><?php echo date('d-m-Y h:i A', strtotime($row['date']));?></td>
										  <td>Scale <?php echo $row['scale'];?></td>
                                          <td> <?php echo $row['testpiece'];?> G</td>
										 <td><?php echo $str[0];?></td>
										 <td><?php echo $str[1];?></td>
										 <td><?php echo $str[2];?></td>
										 <td><?php echo $str[3];?></td>
										 <td><?php echo $str[4];?></td>
											
											 
											
                                          </tr>
										    <?php
										     }
										       ?>
										</tbody>
                                    </table>
									</div>
									</div>
									
									
									
									
									
                               </div></div></div></div>