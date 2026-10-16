<?php
include 'connection.php';
$uid = $_GET['uid'];
$pid = $_GET['pid'];
require_once('tcpdf/tcpdf.php');

class MYPDF extends TCPDF
{
    private $logo1Path = 'images/logo1.png';
    private $logo2Path = 'images/rtnts.png';
    private $footerHTML = '';

    public function Header()
    {
        $this->SetFillColor(255, 255, 255);
        $this->Rect(0, 0, $this->getPageWidth(), 30, 'F');

        if (file_exists($this->logo1Path)) {
            $this->Image($this->logo1Path, 15, 7, 16, '', 'PNG');
        }
        if (file_exists($this->logo2Path)) {
            $this->Image($this->logo2Path, 260, 7, 25, '', 'PNG');
        }

        $this->SetFont('century gothic', 'B', 17);
        $this->SetTextColor(0, 51, 102);
        $this->SetXY(12, 12);
        $this->Cell(0, 0, 'Yogurt Production Report', 0, 1, 'C');

        $this->SetLineWidth(0.5);
        $this->SetDrawColor(0, 102, 204);
        $this->Line(15, 28, 285, 28);
    }

    public function Footer()
    {
        $this->SetY(-20);
        $this->SetFont('century gothic', '', 8);
        $this->SetTextColor(0, 0, 0);

        if (!empty($this->footerHTML)) {
            $this->SetY(-21);
            $this->writeHTML($this->footerHTML, true, false, true, false, '');
        } else {
            $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 0, 'C');
        }
    }

    public function setFooterHTML($html)
    {
        $this->footerHTML = $html;
    }
}



// Create PDF
$pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetDefaultMonospacedFont('century gothic');
$pdf->SetMargins(15, 30, 15);
$pdf->SetHeaderMargin(10);
$pdf->SetAutoPageBreak(TRUE, 25);

$footerContent = <<<EOD
<table border="1" cellpadding="4" width="102%" style="font-weight:bold;">
    <tr>
        <td width="33%" rowspan="2" style="text-align:left;">CD 67 Weekly Organoleptic assessment record</td>
        <td width="33%" style="text-align:center;">Issue: 1</td>
        <td width="33%" style="text-align:left;">Amended by: Bijal Chauhan</td>
    </tr>
    <tr>
        <td width="33%" style="text-align:center;">Issue Date: 24/11/16</td>
        <td width="33%" style="text-align:left;">Authorised by: James Pattison</td>
    </tr>
</table>
EOD;

$pdf->setFooterHTML($footerContent);
$pdf->AddPage();

// Fetch production info
$sql = mysqli_query($con, "SELECT * FROM `tblyogurtproduction` WHERE uid='$uid'");
$row = mysqli_fetch_array($sql);
$prod = $row['pname'];
$sq = mysqli_query($con, "SELECT * FROM `tblyogurt` WHERE id='$prod'");
$data = mysqli_fetch_array($sq);
$fur = $data['foruse'];
$total = $row['qty'];


$fur = (int)$fur;

 $kg  =(float)$data['kg'];
 $pks = round($data['pks']);

if ($fur == 1) {
    $fpks = $kg * $pks;
    $fpk1 = round($total * ($fpks / $pks));
} elseif ($fur == 2) {
    $fpk1 = round($total / ($kg * $pks));
} elseif ($fur == 3) {
    $fpk1 = round($total / ($kg * $pks));
} else {
    $fpk1 = round($total / $pks);
}



$pdf->SetY(40);

$tble = '<table>

<tr>
<th width="50%">Date : ' . date("m-d-Y", strtotime($row['date'])) . '</th>
<th width="50%">Batch No. : ' . date("Ymd", strtotime($row['date'])) . '</th>
</tr>

<tr>
<th>Use By Date : ' . date("Ymd", strtotime($row['date'])) . '</th>
</tr>
</table><br><br><br>


<table border="1" cellpadding="5" cellspacing="0" style="font-size:11px; width:90%;">
    <thead>
        <tr>
            <th width="20%" style="text-align:center; background-color:#2c3e50; color:white;">Product</th>
            <th width="8%" style="text-align:center; background-color:#2c3e50; color:white;">Batch</th>
            <th width="7%" style="text-align:center; background-color:#2c3e50; color:white;">Cream</th>
            <th width="7%" style="text-align:center; background-color:#2c3e50; color:white;">SMP</th>                                   
            <th width="7%" style="text-align:center; background-color:#2c3e50; color:white;">Milk</th>
            <th width="7%" style="text-align:center; background-color:#2c3e50; color:white;">Fruit</th>                                                                               
            <th width="6%" style="text-align:center; background-color:#2c3e50; color:white;">Start Time</th>
            <th width="8%" style="text-align:center; background-color:#2c3e50; color:white;">Finish Time</th>
            <th width="9%" style="text-align:center; background-color:#2c3e50; color:white;">Cututres</th>
            <th width="9%" style="text-align:center; background-color:#2c3e50; color:white;">Cututres</th>
            <th width="9%" style="text-align:center; background-color:#2c3e50; color:white;">Cututres</th>
            <th width="7%" style="text-align:center; background-color:#2c3e50; color:white;">Target Pks</th>
            <th width="7%" style="text-align:center; background-color:#2c3e50; color:white;">ACtual filling</th>



                </tr> 
                <thead>
                    <tbody>';

     $tble .= '<tr style="font-size:10px;">
                <td>' . $data['name'] . '</td>
                <td align="center">' . $row['qty'] . '</td>
                <td align="center">' . $row['cream'] . '</td>
                <td align="center">' . $row['smp'] . '</td>
                <td align="center">' . $row['milk'] . '</td>
                <td align="center">' . $row['fruit'] . '</td>
                <td align="center">' . $row['start'] . '</td> 
                <td align="center">' . $row['finish'] . '</td>
                <td align="center">' . $row['ct1'] . '</td>
                <td align="center">' . $row['ct2'] . '</td>
                <td align="center">' . $row['ct3'] . '</td>
                <td align="center">' . $fpk1 . '</td>
                <td></td>




                </tr> 
                </tbody>
                </table>
                ';
$pdf->writeHTML($tble, true, false, true, false, '');




$table = '<table border="1" cellpadding="5" cellspacing="0" style="font-size:12px;">
    <thead>
        <tr>
            <th width="20%" style="text-align:center; background-color:#2c3e50; color:white;">S.No</th>
            <th width="40%" style="text-align:center; background-color:#2c3e50; color:white;">Tank</th>
            <th width="40%" style="text-align:center; background-color:#2c3e50; color:white;">Quantity</th>
        </tr>
    </thead>
    <tbody>';

$sno = 1;       
$totalQty = 0;  

foreach($sql as $data1){
    $tanks = explode(';', $data1['tank']);
    $quantities = explode(';', $data1['addqty']);

    for ($i = 0; $i < count($tanks); $i++) {
        $currentTankId = $tanks[$i];
        $currentQty  = $quantities[$i];
        
        // FIX: Query to get tank name using the individual tank ID
        $tankname = mysqli_query($con, "SELECT * FROM `tbltank` WHERE id='$currentTankId'");
        
        if ($tankname && mysqli_num_rows($tankname) > 0) {
            $tankdata = mysqli_fetch_array($tankname);
            $tankDisplayName = $tankdata['tank'];
        } else {
            $tankDisplayName = $currentTankId; 
        }
        
        $table .= '<tr>
            <td width="20%" style="text-align:center;">'.$sno.'</td>
            <td width="40%" style="text-align:center;">'.$tankDisplayName.'</td>
            <td width="40%" style="text-align:center;">'.$currentQty.'</td>
        </tr>';

        $sno++;
        $totalQty += floatval($currentQty);
    }
}

// Add total row once at the end
$table .= '<tr>
    <td colspan="2" style="text-align:right; font-weight:bold;">Total</td>
    <td style="text-align:center; font-weight:bold;">'.$totalQty.'</td>
    </tr>';

$table .= '</tbody>
</table>';

// Output to PDF
$pdf->writeHTML($table, true, false, true, false, '');





// Save PDF
$filename = "yogurt_report_" . $uid . ".pdf";
$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "yogurt/upl1/" . $filename, "F");
?>

<div class="container-fluid my-4">
    <div class="card shadow-sm">
        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
            <h2 class="mb-0 text-white">📄 Yogurt Production Report</h2>
            <a href="admin.php?id=yogurtproduction" class="btn btn-success btn-sm">Go Back</a>
        </div>
        <div class="card-body">
            <!-- Action Buttons -->
            <div class="mb-3">
                <a href="upl1/<?php echo $filename; ?>" download class="btn btn-success mr-2">
                    ⬇️ Download PDF
                </a>
                <a href="upl1/<?php echo $filename; ?>" target="_blank" class="btn btn-primary">
                    📖 Open in New Tab
                </a>
            </div>

            <!-- Embedded PDF Viewer -->
            <div class="embed-responsive embed-responsive-4by3 border rounded">
                <iframe src="yogurt/upl1/<?php echo $filename; ?>"
                    class="embed-responsive-item"
                    frameborder="0">
                </iframe>
            </div>
        </div>
    </div>
</div>