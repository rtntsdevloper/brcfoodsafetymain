<?php
$sno = $_GET['sno'];

// Main production row
$row = null;
$sql = mysqli_query($con, "SELECT * FROM frozenproduction WHERE id='$sno'");
if ($sql && mysqli_num_rows($sql) > 0) {
    $row = mysqli_fetch_array($sql);
}


$date      = date('d-m-Y', strtotime($row['date']));
$batchcode = $row['batchcode'];
$product   = $row['product'];

if ($product == 2) {
    $productName = "Samosa";
} elseif ($product == 3) {
    $productName = "Spring Roll";
} else {
    $productName = "";
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
        $image_file  = 'images/1.png';
        $image_file1 = 'images/rtnts.png';
        $this->Image($image_file, 5, 5, 25, '', 'PNG', '', 'T', false, 200, '', false, false, 0, false, false, false);
        $this->Image($image_file1, 165, 4, 39, '', 'PNG', '', 'T', false, 200, '', false, false, 0, false, false, false);
        $this->SetFont('centurygothic', '', 20);

        $this->SetXY(65, 0);
        $this->Write(20, 'Production Record', '', 0, '10', true, 0, false, false, 0);
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
<table border="1" cellpadding="6" width="100%">
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
// $pdf->Write(15, $productName, '', '0', '0', true, 'C', false, false, 0);

$pdf->SetXY(5, 30);
$pdf->SetFont('centurygothic', '', 12);

$tbl_header = '<style>
table {
   border-spacing: 0;
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
    <tr><td><label style="color:#0000CC">Product:</label></td><td>' . $productName . '</td></tr>
    <tr><td><label style="color:#0000CC">Qty :</label></td><td>' . $row['qty'] . ' pcs</td></tr>   
    <tr><td><label style="color:#0000CC">Use By Date :</label></td><td>' .date('d-m-Y',strtotime($row['useby'])) . '</td></tr>';


$pdf->writeHTML($tbl_header . $tbl7 . $tbl_footer, true, false, false, false, '');

$pdf->SetXY(5, 78);

$tbl8 = '';
$tbl8 .= '<tr>
            <th>Sno</th>
            <th>Batch Code</th>
            <th>Ingredient</th>
            <th>Quantity</th>
            <th>Use By / Best Before</th>
          </tr>';

$i = 0;
$totalQty = 0;

$upit = mysqli_query($con, "SELECT * FROM frozenproduction1 WHERE mainid='$sno'");
while ($row1 = mysqli_fetch_array($upit)) {
    $i++;
    $totalQty += floatval($row1['qty']);

    $codeEsc = mysqli_real_escape_string($con, $row1['batchcode']);

    // Determine ingredient
    $chkDough = mysqli_query($con, "SELECT storagecode FROM frozenstorage WHERE storagecode='$codeEsc'");
    if ($chkDough && mysqli_num_rows($chkDough) > 0) {
        $ingredient = 'Dough';
    } else {
        if ($row1['product'] == 2) {
            $ingredient = 'Samosa Masala';
        } elseif ($row1['product'] == 3) {
            $ingredient = 'Spring Roll Masala';
        } else {
            $ingredient = 'Masala';
        }
    }

    if ($row1['useby'] == "" || $row1['useby'] == "0000-00-00") {
        $useby = "";
    } else {
        $useby = date('d-m-Y', strtotime($row1['useby']));
    }

    $tbl8 .= '
    <tr>
        <td>' . $i . '</td>
        <td>' . $row1['batchcode'] . '</td>
        <td>' . $ingredient . '</td>
        <td>' . $row1['qty'] . ' kg</td>
        <td>' . $useby . '</td>
    </tr>';
}

$pdf->writeHTML($tbl_header . $tbl8 . $tbl_footer, true, false, false, false, '');

$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "finemed/upl1/" . $batchcode . "-Production.pdf", "F");
?><?php
    $sno = mysqli_real_escape_string($con, $_GET['sno']);

    // Main production row
    $mainRow = null;
    $sql_main = mysqli_query($con, "SELECT * FROM `frozenproduction` WHERE id = '$sno'");
    if ($sql_main && mysqli_num_rows($sql_main) > 0) {
        $mainRow = mysqli_fetch_assoc($sql_main);
    }

    // Sub rows (batches used)
    $subRows = [];
    $sql_sub = mysqli_query($con, "SELECT * FROM `frozenproduction1` WHERE mainid = '$sno'");
    while ($r = mysqli_fetch_assoc($sql_sub)) {
        $subRows[] = $r;
    }

    // Product name
    $productName = '';
    if ($mainRow) {
        if ($mainRow['product'] == 2) {
            $productName = "Samosa";
        } elseif ($mainRow['product'] == 3) {
            $productName = "Spring Roll";
        }
    }
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
                    <li class="breadcrumb-item"><a href="#!">Home / Production Detail</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-12" style="margin-bottom:20px">

    <a href="admin.php?id=fproduction">
        <button type="button" class="btn btn-danger" style="float:right;">Go Back</button>
    </a>

    <?php if ($mainRow): ?>
        <a href="upl1/<?php echo htmlspecialchars($mainRow['batchcode']); ?>-Production.pdf" target="_blank">
            <button type="button" class="btn btn-warning" style="float:right;margin-right:20px">View Report</button>
        </a>
    <?php endif; ?>
</div>

<div class="col-xl-12">
    <div class="card">
        <div class="card-header">
            <h4 style="color:#990000"> Product : <?php echo htmlspecialchars($productName); ?> </h4>
        </div>

        <div class="card-body table-border-style">
            <div class="table-responsive">
                <table class="table table-striped">

                    <thead>
                        <tr>
                            <th colspan="5">
                                <label style="color:#0000CC">Date:</label> <?php echo $mainRow ? date('d-m-Y', strtotime($mainRow['date'])) : ''; ?>,
                                <label style="color:#0000CC">Batchcode:</label> <?php echo $mainRow ? htmlspecialchars($mainRow['batchcode']) : ''; ?>,
                                <label style="color:#0000CC">Product:</label> <?php echo htmlspecialchars($productName); ?>,
                                <label style="color:#0000CC">Qty :</label> <?php echo $mainRow['qty']; ?> pcs,
                                <label style="color:#0000CC">Use by Date :</label> <?php echo  date('d-m-Y',strtotime($mainRow['useby'])); ?>

                            </th>
                        </tr>
                    </thead>

                    <thead>
                        <tr>
                            <th>S No.</th>
                            <th>Batch Code</th>
                            <th>Ingredient</th>
                            <th>Quantity</th>
                            <th>Use By / Best Before</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php if (!empty($subRows)): ?>
                            <?php $i = 0;
                            foreach ($subRows as $row1): $i++; ?>
                                <?php
                                $codeEsc = mysqli_real_escape_string($con, $row1['batchcode']);
                                $ingredient = '';

                                // Check if batchcode belongs to frozenstorage (Dough)
                                $chkDough = mysqli_query($con, "SELECT storagecode FROM frozenstorage WHERE storagecode = '$codeEsc'");
                                if ($chkDough && mysqli_num_rows($chkDough) > 0) {
                                    $ingredient = 'Dough';
                                } else {
                                    // Otherwise it's from frozencooking (Masala)
                                    if ($row1['product'] == 2) {
                                        $ingredient = 'Samosa Masala';
                                    } elseif ($row1['product'] == 3) {
                                        $ingredient = 'Spring Roll Masala';
                                    } else {
                                        $ingredient = 'Masala';
                                    }
                                }
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo htmlspecialchars($row1['batchcode']); ?></td>
                                    <td><?php echo htmlspecialchars($ingredient); ?></td>
                                    <td><?php echo htmlspecialchars($row1['qty']); ?> kg</td>
                                    <td>
                                        <?php
                                        if (!empty($row1['useby'])) {
                                            echo date('d-m-Y', strtotime($row1['useby']));
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">No batch details found.</td>
                            </tr>
                        <?php endif; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>