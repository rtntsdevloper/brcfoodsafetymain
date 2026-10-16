<?php
$batch = $_GET['batch'];



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
    $this->Image($image_file, 5, 5, 20, '', 'PNG', '', 'T', false, 200, '', false, false, 0, false, false, false);
    $this->Image($image_file1, 245, 4, 39, '', 'PNG', '', 'T', false, 200, '', false, false, 0, false, false, false);
    $this->SetFont('centurygothic', '', 20);

    $this->SetXY(105, 0);
    $this->Write(20, 'Packaging Records', '', 0, '10', true, 0, false, false, 0);
  }

  public function Footer()
  {
    $this->SetY(-16);
    $this->SetFont('centurygothic', '', 8);
    $this->writeHTML($this->longTableFooter);
  }
  public function setLongTableFooter($html)
  {
    $this->longTableFooter = $html;
  }
}

$pdf = new MYPDF('P', 'mm', 'A4', true, 'UTF-8', false);

$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->SetMargins(PDF_MARGIN_LEFT, 35, PDF_MARGIN_RIGHT);

$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
  require_once(dirname(__FILE__) . '/lang/eng.php');
  $pdf->setLanguageArray($l);
}
$pdf->AddPage('L', 'A4');

$footer = <<<EOD


<table border="1" cellpadding="6" width="100%" >
    <tr>
        <td width="33%">Issue date: 12/09/2024</td>
        <td width="34%">Ref No: 5.5.01 </td>
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



$pdf->SetFont('centurygothic', '', 8);

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
$pdf->SetXY(5, 30);

$tbl8 = '';
$tbl8 .= ' <tr>
										  <th width="60">Sno</th>
										   <th width="130">Date</th>
										   <th width="130">Batchcode</th>
                       <th width="120">Product Batchcode</th>
                                            <th width="140">Product</th>
										
											<th width="90">Top Film</th>
											<th width="90">Bottom Film</th>
											
											<th width="130">Packing Machines</th>
										
											<th width="130">Checks Carried Out By</th>
                                        </tr>
										';
$upit = mysqli_query($con, "select * from tblpacking where productbatch='$batch' ORDER BY datetime DESC");
$upitn = mysqli_num_rows($upit);
if ($upitn > 0) {
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
                         <td>'.$row1['packbatch'].'</td>
										 	 <td>' . $sd1['name'] . '</td>
											 
											 <td>' . $row1['packfilm'] . '</td>
											  <td>' . $row1['botfilm'] . '</td>
	
                                              <td>' . $row1['tray'] . '</td>


											 
										   <td>' . $row1['user'] . '</td>
                                          </tr>';
    $i++;
  }
} else {
  $tbl8 .= '
   <tr>
   <td colspan="8" style="text-align:center; color: #000000">No Data Available</td>
   </tr>
   ';
}
$pdf->writeHTML($tbl_header . $tbl8 . $tbl_footer, true, false, false, false, '');





$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "upl1/PACKAGING_RECORDS.pdf", "F");
?>





<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
  .stage-card {
    background: #ffffff;
    border: 1px solid #e5e8f0;
    border-radius: 18px;
    padding: 24px;
    transition: all .35s cubic-bezier(.4, 0, .2, 1);
    position: relative;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0, 0, 0, .03), 0 4px 16px -4px rgba(0, 0, 0, .04);
  }

  .stage-card:hover {
    border-color: rgba(234, 88, 12, .35);
    transform: translateY(-3px);
    box-shadow: 0 8px 32px -4px rgba(234, 88, 12, .1), 0 4px 16px -4px rgba(0, 0, 0, .06);
  }

  .stage-head {
    display: flex;
    align-items: center;
    gap: 14px;
    padding-bottom: 18px;
    margin-bottom: 18px;
    border-bottom: 1px solid #e5e8f0;
  }

  .stage-icon.cool-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: grid;
    place-items: center;
    font-size: 20px;
    flex-shrink: 0;
    background: linear-gradient(135deg, rgba(59, 130, 246, .12), rgba(59, 130, 246, .04));
    color: #3b82f6;
    border: 1px solid rgba(59, 130, 246, .18);
  }

  .stage-title {
    font-size: 16px;
    font-weight: 700;
    color: #1a1d2e;
  }

  .stage-sub {
    font-size: 11px;
    color: #8891a8;
    text-transform: uppercase;
    letter-spacing: 1.2px;
    margin-top: 2px;
  }

  .pdf-frame-wrap {
    border: 1px solid #e5e8f0;
    border-radius: 12px;
    overflow: hidden;
    background: #f7f8fc;
    position: relative;
  }

  .pdf-frame-wrap::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(59, 130, 246, .2), transparent);
    z-index: 1;
  }

  .pdf-frame-wrap iframe {
    width: 100%;
    height: 520px;
    display: block;
    border: none;
  }
</style>


<div class="animate-in delay-4">
  <div class="stage-card">
    <div class="stage-head">
      <div class="stage-icon cool-icon"><i class="bi bi-box-seam"></i></div>
      <div>
        <div class="stage-title">Packaging Report ( <?= $batch ?> )</div>
        <div class="stage-sub">Document Viewer</div>
      </div>
    </div>
    <div class="pdf-frame-wrap">
      <iframe src="<?php echo "upl1/PACKAGING_RECORDS.pdf"; ?>" frameborder="0"></iframe>
    </div>
  </div>
</div>