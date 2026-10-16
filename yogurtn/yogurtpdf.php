<?php

require_once('tcpdf/tcpdf.php');

$id =$_GET['rid'] ;
if ($id <= 0)
    die('Missing or invalid id.');

$q = mysqli_query($con, "SELECT r.*, y.description, y.kg, y.pks,
                                y.culture1, y.culture2, y.culture3,r.rdate
                         FROM yogurt_records r
                         JOIN yogurt1 y ON y.id = r.product_id
                         WHERE r.id=$id");
$row = mysqli_fetch_assoc($q);
$rdate = $row['rdate'];

if (!$row)
    die('No production record found for id ' . $id . '.');

/* ---------- helpers ---------- */
function pf($v)
{
    $v = (float) $v;
    return $v ? rtrim(rtrim(number_format($v, 2, '.', ''), '0'), '.') : '0';
}
function esc($v)
{
    return htmlspecialchars((string) $v, ENT_QUOTES);
}

/**
 * Extracts and escapes culture name (Part 1), stripping trailing grams and separators.
 * Example: "YC470 - 60g" -> "YC470"
 *
 * @param mixed $t
 * @return string
 */
function cpart1($t)
{
    if (is_array($t)) {
        $t = isset($t[0]) ? (string)$t[0] : '';
    } else {
        $t = (string)$t;
    }

    if (preg_match('/^(.*?)(\d+(?:\.\d+)?\s*g)\s*$/i', $t, $m)) {
        return esc(rtrim($m[1]));
    }

    return esc(trim($t));
}
function checktg($t)
{
    $t = (string) $t;
    // Extract trailing grams, e.g. "60g" from "YC470 - 60g" -> " 60g."
    if (preg_match('/(\d+(?:\.\d+)?)\s*g\s*$/i', $t, $m)) {
        return ' ' . $m[1] . 'g.';
    }
    // If only a number was provided, e.g. "60" -> " 60g."
    if (is_numeric(trim($t))) {
        return ' ' . trim($t) . 'g.';
    }
    return '';
}

function chectg($t)
{
    return checktg($t);
}

/* ---------- same formulas as yogurt.php's JS (calcRow) ---------- */
$total = (float) $row['cream'] + (float) $row['smp'] + (float) $row['milk'] + (float) $row['fruit'];
$kg = (float) $row['kg'];
$targetPks = $kg ? $total / $kg : 0;
$opStock2 = (float) $row['op_stock'] + (float) $row['actual_filling'];   // O/P Stock
$goTotal = (float) $row['cust1'] + (float) $row['cust2'] + (float) $row['cust3']
    + (float) $row['cust4'] + (float) $row['cust5'];
$closingStock = $opStock2 - $goTotal + (float) $row['adj'];
$clPots = round((float) $row['op_pots'] - (float) $row['used_pots']);
$clLids = round((float) $row['op_lids'] - (float) $row['used_lids']);
$clFoil = round((float) $row['op_foil'] - (float) $row['used_foil']);
$clTrays = round((float) $row['op_trays'] - (float) $row['used_trays']);

$ccpDone = (isset($row['ccp']) && $row['ccp'] == 'done');
$weightDone = (isset($row['weight']) && $row['weight'] == 'done');

$batchNo = date('ymd', strtotime($row['rdate']));
$bestBefore = date('d/m/y', strtotime($row['rdate'] . ' +30 days'));

/* ---------- MYPDF: repeating header/footer (same as before) ---------- */
class MYPDF extends TCPDF
{
    private $logo1Path = '../images/logo1.png';
    private $logo2Path = '../images/rtnts.png';
    private $footerHTML = '';

    public function Header()
    {
        $this->SetFillColor(255, 255, 255);
        $this->Rect(0, 0, $this->getPageWidth(), 30, 'F');
        if (file_exists($this->logo1Path))
            $this->Image($this->logo1Path, 15, 7, 16, '', 'PNG');
        if (file_exists($this->logo2Path))
            $this->Image($this->logo2Path, 260, 7, 30, '', 'PNG');

        $this->SetFont('helvetica', 'B', 17);
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
        $this->SetFont('helvetica', '', 8);
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

/* ---------- create PDF ---------- */
$pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetMargins(15, 30, 15);
$pdf->SetHeaderMargin(10);
$pdf->SetAutoPageBreak(TRUE, 25);

$footerContent = <<<EOD
<table border="1" cellpadding="4" width="100%" style="font-weight:bold;">
    <tr>
        <td width="33%" rowspan="2" style="text-align:left;">Doc . </td>
        <td width="33%" style="text-align:center;">Issue: </td>
        <td width="33%" style="text-align:left;">Issued by: </td>
    </tr>
    <tr>
        <td width="33%" style="text-align:center;">Issue Date: </td>
        <td width="33%" style="text-align:left;">Authorised by: </td>
    </tr>
</table>
EOD;
$pdf->setFooterHTML($footerContent);
$pdf->AddPage();
$pdf->SetY(40);

$th = 'style="text-align:center; background-color:#2c3e50; color:white;"';   // header cell
$td = 'align="center"';

/* ================================================================
 * SECTION 1 ▸ Quantities for Yogurt Production
 * Every planning-side field from yogurt.php's row: Op/Stk, Description,
 * Kg, Pks, Batch, Cream, SMP, Milk, Fruit, Tank No, Ready/Finish Time,
 * Culture 1-3, Total, Target Pks, Actual Filling, O/P Stock.
 * ================================================================ */
$tble = '
<h4>Date : ' . date("d-m-Y", strtotime($row['rdate'])) . '   |   Batch No. : ' . $batchNo
    . '   |   Best Before : ' . $bestBefore . '</h4>
<h3 style="color:#2c3e50;">' . esc($row['description']) . '</h3>

<table border="1" cellpadding="4" cellspacing="0" style="font-size:9px; width:100%;">
    <tr>
        <td colspan="18" style="text-align:left; background-color:#217346; color:white; font-weight:bold;">
            Quantities for Yogurt Production
        </td>
    </tr>
    <tr>
        <th ' . $th . '>Op/Stk</th>
        <th ' . $th . '>Kg</th>
        <th ' . $th . '>Pks</th>
        <th ' . $th . '>Batch</th>
        <th ' . $th . '>Cream</th>
        <th ' . $th . '>SMP</th>
        <th ' . $th . '>Milk</th>
        <th ' . $th . '>Fruit</th>
        <th ' . $th . '>Tank No</th>
        <th ' . $th . '>Ready Time</th>
        <th ' . $th . '>Finish Time</th>
        <th ' . $th . '>Culture 1</th>
        <th ' . $th . '>Culture 2</th>
        <th ' . $th . '>Culture 3</th>
        <th ' . $th . '>Total</th>
        <th ' . $th . '>Target Pks</th>
        <th ' . $th . '>Actual Filling</th>
        <th ' . $th . '>O/P Stock</th>
    </tr>
    <tr>
        <td ' . $td . '>' . pf($row['op_stock']) . '</td>
        <td ' . $td . '>' . esc($row['kg']) . '</td>
        <td ' . $td . '>' . esc($row['pks']) . '</td>
        <td ' . $td . '>' . pf($row['batch']) . '</td>
        <td ' . $td . '>' . pf($row['cream']) . '</td>
        <td ' . $td . '>' . pf($row['smp']) . '</td>
        <td ' . $td . '>' . pf($row['milk']) . '</td>
        <td ' . $td . '>' . pf($row['fruit']) . '</td>
        <td ' . $td . '>' . esc($row['tank_no']) . '</td>
        <td ' . $td . '>' . esc($row['ready_time']) . '</td>
        <td ' . $td . '>' . esc($row['finish_time']) . '</td>
        <td ' . $td . '>' . cpart1($row['culture1']).checktg($row['culture1_g']). '</td>
        <td ' . $td . '>' . cpart1($row['culture2']).checktg($row['culture2_g']). '</td>
        <td ' . $td . '>' . cpart1($row['culture3']).checktg($row['culture3_g']). '</td>
        <td ' . $td . ' style="font-weight:bold;">' . pf($total) . '</td>
        <td ' . $td . ' style="font-weight:bold;">' . pf($targetPks) . '</td>
        <td ' . $td . '>' . pf($row['actual_filling']) . '</td>
        <td ' . $td . ' style="font-weight:bold;">' . pf($opStock2) . '</td>
    </tr>
</table>';
$pdf->writeHTML($tble, true, false, true, false, '');

/* ================================================================
 * SECTION 2 ▸ Checks — CCP Checks & Weight Check
 * ================================================================ */






$htmlc1 = '';

$htmlc1 .= '

<table border="1" cellpadding="5" cellspacing="0" style="font-size:11px; width:100%;">

    <tr nobr="true">

        <td colspan="3" style="text-align:left; background-color:#2c3e50; color:white; font-weight:bold;">

            CCP RECORD

        </td>

    </tr>

    <tr nobr="true" style="background-color:#f2f2f2; font-weight:bold;">

        <th width="20%" style="text-align:center;">S.No</th>

        <th width="30%" style="text-align:center;">Time</th>

        <th width="25%" style="text-align:center;">Temperature (C)</th>

        <th width="25%" style="text-align:center;">PH</th>

    </tr>';



$ccprow = mysqli_query($con, "SELECT * FROM `yogurt_ccp` WHERE eid='$id' ");

$ccprown = mysqli_num_rows($ccprow);





if ($ccprown > 0) {



    foreach ($ccprow as $ctk => $ctvalue) {



        $htmlc1 .= '

        <tr nobr="true">

            <td align="center">' . ($ctk + 1) . '</td>

            <td align="center">' . date("h:i A", strtotime($ctvalue['settime'])) . '</td>

            <td align="center" style="color:#2980b9; font-weight:bold;">' . number_format($ctvalue['tanktemp']) . '&deg;C</td>

            <td align="center" style="color:#2980b9; font-weight:bold;">' . number_format($ctvalue['ph']) . '</td>

        </tr>';

    }

} else {



    $htmlc1 .= '

        <tr nobr="true">

            <td colspan="4" align="center" style="color:#2980b9; font-weight:bold;">No CCP Record Yet</td>

        </tr>';

}

// add total row good mornin

$htmlc1 .= '

</table>';



$pdf->writeHTML($htmlc1, true, false, true, false, '');



$htmllabel = mysqli_query($con, "SELECT * FROM `yogurt_label` WHERE eid='$id' ");

$htmllabelrow = mysqli_fetch_array($htmllabel);

$htmllabelrowcount = mysqli_num_rows($htmllabel);



if ($htmllabelrowcount > 0) {

    $lbdate = $htmllabelrow['pdate'];

    $lbtime = $htmllabelrow['ptime'];

    $lbweight = $htmllabelrow['pweight'];

    $lbcheck1 = $htmllabelrow['lcheck'];

    $lbcheck2 = $htmllabelrow['removed'];

    $lboperator = $htmllabelrow['psign'];

} else {

    $lbdate = "";

    $lbtime = "";

    $lbweight = "";

    $lbcheck1 = "";

    $lbcheck2 = "";

    $lboperator = "";

}

$htmlp1 = '';

$htmlp1 .= '

<table border="1" cellpadding="5" cellspacing="0" style="font-size:11px; width:100%;">

    <tr nobr="true">

        <td colspan="3" style="text-align:left; background-color:#2c3e50; color:white; font-weight:bold;">

            Label & Coding Checks

        </td>

    </tr>

    <tr nobr="true" >

        <th width="20%" style="text-align:center;background-color:#f2f2f2; font-weight:bold;" >Date</th>

        <td width="30%">' . $lbdate . '</td>

        <th width="20%" style="text-align:center;background-color:#f2f2f2; font-weight:bold;">Time</th>

       <td width="30%">' . $lbtime . '</td>

      

    </tr>

    <tr nobr="true"> 

    <th width="20%" style="text-align:center;background-color:#f2f2f2; font-weight:bold;">Product Weight</th>

     <td width="30%">' . $lbweight . '</td>

    

        <th width="20%" style="text-align:center;background-color:#f2f2f2; font-weight:bold;">Is label information legible? (Y/N)</th>

         <td width="30%">' . $lbcheck1 . '</td>

        </tr>

        

        

        <tr nobr="true"> 

        <th width="20%" style="text-align:center;background-color:#f2f2f2; font-weight:bold;">Is previous packaging removed from the line? (Y/N)</th>

         <td width="30%">' . $lbcheck2 . '</td>

        <th width="20%" style="text-align:center;background-color:#f2f2f2; font-weight:bold;">Operator Signature</th>

         <td width="30%">';



if (!empty($lboperator)) {

    $htmlp1 .= '<img src="yogurt/sign/' . $lboperator . '" alt="" width="50" height="50">';

}



$htmlp1 .= '</td>

        </tr>';





// add 

$htmlp1 .= '

</table>';

$pdf->writeHTML($htmlp1, true, false, true, false, '');





//weight

$htmlw1 = '';

$htmlw1 .= '

<table border="1" cellpadding="4" cellspacing="0" style="font-size:10px; width:100%;">

    <thead>

        <tr nobr="true">

            <td colspan="9" style="text-align:left; background-color:#2c3e50; color:white; font-weight:bold;">

                Weight Check Record

            </td>

        </tr>

        <tr nobr="true">

            <td style="text-align:center; background-color:#f2f2f2; font-weight:bold; ">S.No</td>

            <td style="text-align:center; background-color:#f2f2f2; font-weight:bold; ">Time</td>

            <td style="text-align:center; background-color:#f2f2f2; font-weight:bold; ">Tare Weight (g)</td>

            <td style="text-align:center; background-color:#f2f2f2; font-weight:bold;">Weight pot 1 (g)</td>

            <td style="text-align:center; background-color:#f2f2f2; font-weight:bold; ">Weight pot 2 (g)</td>

            <td style="text-align:center; background-color:#f2f2f2; font-weight:bold; ">Weight pot 3 (g)</td>

            <td style="text-align:center; background-color:#f2f2f2; font-weight:bold; ">Weight pot 4 (g)</td>

            <td style="text-align:center; background-color:#f2f2f2; font-weight:bold;">Average Weight (g)</td>

            <td style="text-align:center; background-color:#f2f2f2; font-weight:bold;">Net Weight (g)</td>

        </tr>

    </thead>

    <tbody>';



$wcprow = mysqli_query($con, "SELECT * FROM `yogurtweight` WHERE eid='$id'");

$wcprown = mysqli_num_rows($wcprow);



if ($wcprown > 0) {

    $i = 1;

    foreach ($wcprow as $wtvalue) {

        $wctime = date('h:i A', strtotime($wtvalue['time']));



        $htmlw1 .= '

        <tr nobr="true">

            <td nobr="true" style="text-align:center;">' . $i . '</td>

            <td nobr="true" style="text-align:center;">' . $wctime . '</td>

            <td nobr="true" style="text-align:center;">' . $wtvalue['packtare'] . 'g</td>

            <td nobr="true" style="text-align:center;">' . $wtvalue['pack1'] . 'g</td>

            <td nobr="true" style="text-align:center;">' . $wtvalue['pack2'] . 'g</td>

            <td nobr="true" style="text-align:center;">' . $wtvalue['pack3'] . 'g</td>

            <td nobr="true" style="text-align:center;">' . $wtvalue['pack4'] . 'g</td>

            <td nobr="true" style="text-align:center;">' . $wtvalue['avgw'] . 'g</td>

            <td nobr="true" style="text-align:center;">' . $wtvalue['netw'] . 'g</td>

        </tr>';

        $i++;

    }

} else {

    $htmlw1 .= '

        <tr nobr="true">

            <td colspan="9" align="center" style="color:#2980b9; font-weight:bold;">No Weight Check Record Yet</td>

        </tr>';

}



$htmlw1 .= '

    </tbody>

</table>';



$pdf->writeHTML($htmlw1, true, false, true, false, '');



/* ================================================================
 * SECTION 3 ▸ Daily Goods-Out Record Sheet (C/S)
 * Every despatch field: 5 customers, despatch total, adjustment,
 * closing stock.
 * ================================================================ */
$html1 = '
<table border="1" cellpadding="4" cellspacing="0" style="font-size:10px; width:100%;">
    <tr>
        <td colspan="8" style="text-align:left; background-color:#1e88e5; color:white; font-weight:bold;">
            Daily Goods-Out Record Sheet (C/S)
        </td>
    </tr>
    <tr style="background-color:#f2f2f2; font-weight:bold;">
        <th style="text-align:center;">Southall</th>
        <th style="text-align:center;">Kosher</th>
        <th style="text-align:center;">D Farm</th>
        <th style="text-align:center;">S Lon</th>
        <th style="text-align:center;">Watson</th>
        <th style="text-align:center;">Total</th>
        <th style="text-align:center;">Adj.</th>
        <th style="text-align:center;">Stock</th>
    </tr>
    <tr>
        <td align="center">' . pf($row['cust1']) . '</td>
        <td align="center">' . pf($row['cust2']) . '</td>
        <td align="center">' . pf($row['cust3']) . '</td>
        <td align="center">' . pf($row['cust4']) . '</td>
        <td align="center">' . pf($row['cust5']) . '</td>
        <td align="center" style="font-weight:bold;">' . pf($goTotal) . '</td>
        <td align="center">' . pf($row['adj']) . '</td>
        <td align="center" style="font-weight:bold; color:#2980b9;">' . pf($closingStock) . '</td>
    </tr>
</table>';
$pdf->writeHTML($html1, true, false, true, false, '');

/* ================================================================
 * SECTION 4 ▸ Packaging Material Stock
 * Opening / Used / Closing for Pots, Lids, Foil, Trays.
 * ================================================================ */
$htmlp1 = '
<table border="1" cellpadding="4" cellspacing="0" style="font-size:10px; width:100%;">
    <tr>
        <td colspan="4" style="text-align:left; background-color:#f59e0b; color:white; font-weight:bold;">
            Packaging Material Stock
        </td>
    </tr>
    <tr style="background-color:#f2f2f2; font-weight:bold;">
        <th width="25%" style="text-align:center;">Material</th>
        <th width="25%" style="text-align:center;">Opening</th>
        <th width="25%" style="text-align:center;">Used</th>
        <th width="25%" style="text-align:center;">Closing</th>
    </tr>
    <tr>
        <td align="center">Pots</td><td align="center">' . pf($row['op_pots']) . '</td>
        <td align="center">' . pf($row['used_pots']) . '</td><td align="center">' . pf($clPots) . '</td>
    </tr>
    <tr>
        <td align="center">Lids</td><td align="center">' . pf($row['op_lids']) . '</td>
        <td align="center">' . pf($row['used_lids']) . '</td><td align="center">' . pf($clLids) . '</td>
    </tr>
    <tr>
        <td align="center">Foil</td><td align="center">' . pf($row['op_foil']) . '</td>
        <td align="center">' . pf($row['used_foil']) . '</td><td align="center">' . pf($clFoil) . '</td>
    </tr>
    <tr>
        <td align="center">Trays</td><td align="center">' . pf($row['op_trays']) . '</td>
        <td align="center">' . pf($row['used_trays']) . '</td><td align="center">' . pf($clTrays) . '</td>
    </tr>
</table>';
$pdf->writeHTML($htmlp1, true, false, true, false, '');

/* ---------- save to disk (mode "F"), then show a small viewer page ----------
 * ★ Adjust $saveDir / $saveUrl to match where this script actually lives. */
$saveDir = $_SERVER['DOCUMENT_ROOT']."/finemed/yogurtn/pdf/";

$filename = "yogurt_report_" . $id . ".pdf";
$pdf->Output($saveDir . $filename, "F");
?>
<!doctype html>
<html lang="en">
 
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Yogurt Production Report</title>
    <style>
        /* same palette as yogurt.php: green brand, soft grey page background */
        :root {
            --g: #217346;
            --g-dark: #164a2d;
            --g-soft: #e8f4ec;
            --bd: #d5ded8;
            --bd2: #b9c8bf;
            --txt: #22312a;
        }
 
        * { box-sizing: border-box }
 
      
 
        .card {
            width: 100%;
            margin: 0 auto;
            background: #fff;
            border: 1px solid var(--bd);
            border-radius: 14px;
            box-shadow: 0 2px 16px rgba(20, 50, 35, .1);
            overflow: hidden;
        }
 
        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 16px 22px;
            color: #fff;
            background: linear-gradient(135deg, #0e4d2c 0%, #217346 55%, #2f9e67 100%);
        }
 
        .card-header h2 {
            margin: 0;
            font-size: 18px;
            letter-spacing: .3px;
        }
 
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 16px;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, .5);
            background: rgba(255, 255, 255, .15);
            color: #fff;
            font: 600 12.5px "Segoe UI", Calibri, Arial;
            text-decoration: none;
            white-space: nowrap;
            transition: all .15s;
        }
 
        .btn:hover {
            background: rgba(255, 255, 255, .3);
        }
 
        .card-body { padding: 20px 22px }
 
        .pdf-frame {
            width: 100%;
            aspect-ratio: 4 / 3;
            border: 1px solid var(--bd);
            border-radius: 10px;
            overflow: hidden;
            background: #f7faf7;
        }
 
        .pdf-frame iframe {
            width: 100%;
            height: 100%;
            border: 0;
        }
    </style>
</head>
 
<body>
    <div class="card">
        <div class="card-header">
            <h2>📄 Yogurt Production Report</h2>
            <a href="yogurtn/yogurt.php?date=<?= $rdate ?>" class="btn">← Go Back</a>
        </div>
        <div class="card-body">
            <div class="pdf-frame">
                <iframe src="yogurtn/pdf/<?= $filename ?>"></iframe>
            </div>
        </div>
    </div>
</body>
 
</html>
 