<?php


$sno = $_GET['sno'];
$sql = mysqli_query($con, "select * from tblmarination where batchcode='$sno'");
$row = mysqli_fetch_array($sql);


$sql1 = mysqli_query($con, "select * from tblrecipe where id='$row[name]'");
$rows = mysqli_fetch_array($sql1);

$date = date('d-m-Y', strtotime($row['date']));
$udate = date('d-m-Y', strtotime($row['useby1']));

$name = $rows['name'];
$qty = $row['quantity'];
$batchcode = $row['batchcode'];


//per batch

$perb = intval($qty) /80;


//

$useby = date('d-m-Y', strtotime($row['useby1']));
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
        $this->Image($image_file, 5, 5, 20, '', 'PNG', '', 'T', false, 200, '', false, false, 0, false, false, false);
        $this->Image($image_file1, 165, 4, 39, '', 'PNG', '', 'T', false, 200, '', false, false, 0, false, false, false);
        $this->SetFont('centurygothic', '', 20);

        $this->SetXY(65, 0);
        $this->Write(20, 'Mixing Record', '', 0, '10', true, 0, false, false, 0);

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
$pdf->AddPage('P', 'A4');


$footer = <<<EOD

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



$pdf->SetFont('centurygothic', '', 15);

$pdf->SetXY(65, 10);
$pdf->Write(15, $name, '', '0', '0', true, 'C', false, false, 0);

$pdf->SetXY(5, 30);
$pdf->SetFont('centurygothic', '', 12);

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
$tbl7 = '';
$tbl7 .= '
					<tr><td width="250"><label style="color:#0000CC">Production Date: </label></td><td width="450">' . $date . '</td></tr>
										<tr><td><label style="color:#0000CC">Batchcode:</label></td><td>' . $batchcode . '</td></tr>
										<tr><td><label style="color:#0000CC">Use By:</label> </td><td>' . $udate . '</td></tr>
										<tr><td><label style="color:#0000CC">Quantity:</label></td><td>' . $qty . ' Kg</td></tr>
                                        <tr><td><label style="color:#0000CC">Number of Batches:</label></td><td>' . $perb . '</td></tr>
										<tr><td><label style="color:#0000CC">Checks Carried Out By:</label></td><td>' . $row['user'] . ' </td></tr>';


$pdf->writeHTML($tbl_header . $tbl7 . $tbl_footer, true, false, false, false, '');


$pdf->SetXY(5, 80);


$tbl8 = '';
$tbl8 .= ' <tr>
										    <th>Sno</th>
										    <th>Ingredient</th>
											 <th>Total Weight</th>
                                            <th>Use By / Best Before</th>
											
											
											
                                        </tr>
										<tr>
										<th>1</th>
										    <th>Water</th>
											 <th>' . $row['water'] . '</th>
                                            <th></th>
											
											
                                        </tr>';
$upit = mysqli_query($con, "select * from tblmarination1 where batchcode='$batchcode'");

$i = 1;
while ($row1 = mysqli_fetch_array($upit)) {
    $i++;

    if ($row1['useby'] == "") {
        $useby = "";
    } else {
        $useby = date('d-m-Y', strtotime($row1['useby']));
    }

    $tbl8 .= '
 <tr>
										<td>' . $i . '</td>
										 <td>' . $row1['product'] . '</td>
										  <td>' . $row1['totalqty'] . ' ' . $row1['qty1'] . '</td>
										  <td>' . $useby . '</td>
										   
                                          </tr>';
}


$pdf->writeHTML($tbl_header . $tbl8 . $tbl_footer, true, false, false, false, '');




$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "upl1/" . $row['batchcode'] . "-Production.pdf", "F");
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
        color: #df5d07ff;
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
            <div class="stage-icon cool-icon"><i class="bi bi-file-earmark-richtext-fill"></i></div>
            <div>
                <div class="stage-title">Recipe Report ( <?= $sno ?> )</div>
                <div class="stage-sub">Document Viewer</div>
            </div>
        </div>
        <div class="pdf-frame-wrap">
            <iframe src="<?php echo "upl1/" . $row['batchcode'] . "-Production.pdf"; ?>" frameborder="0"></iframe>
        </div>
    </div>
</div>