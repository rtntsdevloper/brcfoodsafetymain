<?php 
$sno=$_GET['sno'];
$sql=mysqli_query($con,"select * from tblmarination where id='$sno'");
$row=mysqli_fetch_array($sql);

$sql1=mysqli_query($con,"select * from tblrecipe where id='$row[name]'");
$rows=mysqli_fetch_array($sql1);
											
	$date= date('d-m-Y', strtotime($row['date']));
	$udate= date('d-m-Y', strtotime($row['useby1']));
	
	$name=$rows['name'];
	$qty=$row['quantity'];
	$batchcode=$row['batchcode'];
	
 $useby= date('d-m-Y', strtotime($row['useby1']));
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
		
		$this->SetXY(65,0);
		$this->Write(20,'Mixing Record', '', 0, '10', true, 0, false, false, 0);
       
    }

   public function Footer() 
	  {$this->SetY(-16);
	  $this->SetFont('centurygothic', '',8);
       $this->writeHTML($this->longTableFooter);
	    
       
      
		 
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


<table border="1" cellpadding="6" width="100%" >
    <tr>
        <td width="33%">Issue date: 12/09/2024</td>
        <td width="34%">Ref No: 6.1.01 </td>
        <td width="33%">Author : Usama Mustafa</td>
    </tr>
    <tr>
        <td width="33%">Version No: 01</td>
        <td width="34%">Reason for change: New Document</td>
        <td width="33%">Authorised by: Paramvir Singh Deol</td>
    </tr>

</table>
EOD;
$pdf->setLongTableFooter($footer);



$pdf->SetFont('centurygothic', '',15);

$pdf->SetXY(65,10);
$pdf->Write(15,$name, '', '0', '0', true, 'C', false, false, 0);

$pdf->SetXY(5,30);
$pdf->SetFont('centurygothic', '',12);

$tbl_header = '<style>
table {
   
   border-spacing: 0;
}
tr {
   
}

th {
      background-color:#F0F0F0;
   color: #000000;
   font-weight:bold;
}
td {
  
  text-align:justify;
   color: #000000;
}
</style>
<table id="gallerytab" width="700" cellspacing="0" cellpadding="4" border="1">
  ';
$tbl_footer = '</table>';
$tbl7='';
$tbl7 .= '
					<tr><td width="250"><label style="color:#0000CC">Production Date: </label></td><td width="450">'.$date.'</td></tr>
										<tr><td><label style="color:#0000CC">Batchcode:</label></td><td>'.$batchcode.'</td></tr>
										<tr><td><label style="color:#0000CC">Use By:</label> </td><td>'.$udate.'</td></tr>
										<tr><td><label style="color:#0000CC">Quantity:</label></td><td>'.$qty.' Kg</td></tr>
										<tr><td><label style="color:#0000CC">Checks Carried Out By:</label></td><td>'.$row['user'].' </td></tr>';
										
								
			   $pdf->writeHTML($tbl_header . $tbl7 . $tbl_footer, true, false, false, false, '');
			  
			  
			  $pdf->SetXY(5,80);
			  
			   
			   $tbl8='';
			 $tbl8 .= ' <tr>
										    <th>Sno</th>
										    <th>Ingredient</th>
											 <th>Total Weight</th>
                                            <th>Use By / Best Before</th>
											
											
											
                                        </tr>
										<tr>
										<th>1</th>
										    <th>Water</th>
											 <th>'.$row['water'].'</th>
                                            <th></th>
											
											
                                        </tr>';
			$upit = mysqli_query($con,"select * from tblmarination1 where batchcode='$batchcode'");
 $i=1;
while($row1=mysqli_fetch_array($upit))
{
$i++;

if($row1['useby']=="")
{
$useby="";
}
else
{
$useby=date('d-m-Y',strtotime($row1['useby']));
}

$tbl8 .= '
 <tr>
										<td>'.$i.'</td>
										 <td>'.$row1['product'].'</td>
										  <td>'.$row1['totalqty'].' '.$row1['qty1'].'</td>
										  <td>'.$useby.'</td>
										   
                                          </tr>';
}   

			   
	$pdf->writeHTML($tbl_header . $tbl8 . $tbl_footer, true, false, false, false, '');		   
			   



$pdf->Output("upl1/".$row['batchcode']."-Production.pdf","F");
?>



  <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Dashboard</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="admin.php?id=1"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Home /  Production Detail </a></li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
		
		<div  class="col-xl-12" style="margin-bottom:20px">
		
		<a href="admin.php?id=marination&id2=<?php echo $_GET['id2'];?>"><button type="submit" class="btn  btn-danger" style="float:right;">Go Back</button></a>
		
		<a href="upl1/<?php echo $row['batchcode'];?>-Production.pdf" target="_blank"><button type="submit" class="btn  btn-warning" style="float:right;margin-right:20px">View Report</button></a>
		</div>
		
		
		

 <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 style="color:#990000"><?php echo $name;?></h4>
                        <h5 style="color:#FF0000">Used By: <?php echo $udate;?></h5>
                    </div>
					
					
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table table-striped">
							
							 <thead>
							 
                                        <tr>
										<th colspan="5"><label style="color:#0000CC">Date: </label> <?php echo $date;?>, <label style="color:#0000CC">Batchcode:</label> <?php echo $batchcode;?>, <label style="color:#0000CC">Name:</label> <?php echo $name;?>, <label style="color:#0000CC">Quantity:</label> <?php echo $qty;?>
                                        </tr>
										
											
										
										
										
                                    </thead>
									
									
									
                                <thead>
                                        <tr>
										<th></th>
										    <th>Ingredient</th>
											 <th>Quantity</th>
                                            <th>Use By / Best Before</th>
											
											
                                        </tr>
                                    </thead>
                                    <tbody>
									
									<tr>
										<td>1</td>
										    <td>Water</td>
											 <td><?php echo $row['water'];?></td>
                                            <td></td>
											
											
                                        </tr>
										
										
									<?php
								
									$sql1=mysqli_query($con,"select * from tblmarination1 where batchcode='$batchcode'");
									$i=1;
									while($row1=mysqli_fetch_array($sql1))
									{
									$i++;
									?>
									
									<?php
								


if($row1['useby1']=="")
{
$useby="";
}
else
{
$useby=date('d-m-Y',strtotime($row1['useby1']));
}
?>

									
                                        <tr>
										<td><?php echo $i;?></td>
										 <td><?php echo $row1['product'];?></td>
										  <td><?php echo $row1['totalqty'];?> <?php echo $row1['qty1'];?></td>
										  <td><?php echo $row1['useby'];?></td>
										   
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