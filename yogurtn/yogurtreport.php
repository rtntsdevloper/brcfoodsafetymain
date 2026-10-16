<?php
/* ================================================================
 * yogurtreport.php ▸ PDF PRODUCTION REPORT (TCPDF)
 * Same MYPDF header/footer style as before, but now shows EVERY
 * field that appears on that product's row in yogurt.php — nothing
 * left out. One PDF per record:
 *   yogurtreport.php?id=123   ← id = yogurt_records.id, same key
 *                                yogurt.php's CCP/Weight links use.
 * ================================================================ */
include "../connection.php";
require_once('tcpdf/tcpdf.php');

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0)
    die('Missing or invalid id.');

$q = mysqli_query($con, "SELECT r.*, y.description, y.kg, y.pks,
                                y.culture1, y.culture2, y.culture3
                         FROM yogurt_records r
                         JOIN yogurt1 y ON y.id = r.product_id
                         WHERE r.id=$id");
$row = mysqli_fetch_assoc($q);
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
$labelDone = (isset($row['label']) && $row['label'] == 'done');
$weightDone = (isset($row['weight']) && $row['weight'] == 'done');

$batchNo = date('ymd', strtotime($row['rdate']));
$bestBefore = date('d/m/y', strtotime($row['rdate'] . ' +30 days'));

/* ---------- MYPDF: repeating header/footer (same as before) ---------- */
class MYPDF extends TCPDF
{
    private $logo1Path = 'images/logo1.png';
    private $logo2Path = 'images/rtnts.png';
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
        <th ' . $th . '>Tray</th>
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
        <td ' . $td . '>' . esc($row['culture1']) . '</td>
        <td ' . $td . '>' . esc($row['culture2']) . '</td>
        <td ' . $td . '>' . esc($row['culture3']) . '</td>
        <td ' . $td . ' style="font-weight:bold;">' . pf($total) . '</td>
        <td ' . $td . ' style="font-weight:bold;">' . pf($targetPks) . '</td>
        <td ' . $td . '>' . pf($row['actual_filling']) . '</td>
        <td ' . $td . ' style="font-weight:bold;">' . pf($opStock2) . '</td>
    </tr>
</table>';
$pdf->writeHTML($tble, true, false, true, false, '');

/* ================================================================
 * SECTION 2 ▸ Checks — CCP Checks, Label Check & Weight Check
 * ================================================================ */
$htmlc1 = '
<table border="1" cellpadding="4" cellspacing="0" style="font-size:10px; width:100%;">
    <tr>
        <td colspan="3" style="text-align:left; background-color:#1e88e5; color:white; font-weight:bold;">
            Checks
        </td>
    </tr>
    <tr style="background-color:#f2f2f2; font-weight:bold;">
        <th width="34%" style="text-align:center;">CCP Checks</th>
        <th width="33%" style="text-align:center;">Label Check</th>
        <th width="33%" style="text-align:center;">Weight Check</th>
    </tr>
    <tr>
        <td align="center" style="color:' . ($ccpDone ? '#2e8b57' : '#c76a00') . '; font-weight:bold;">'
    . ($ccpDone ? '✔ Completed' : 'Pending') . '</td>
        <td align="center" style="color:' . ($labelDone ? '#2e8b57' : '#c76a00') . '; font-weight:bold;">'
    . ($labelDone ? '✔ Completed' : 'Pending') . '</td>
        <td align="center" style="color:' . ($weightDone ? '#2e8b57' : '#c76a00') . '; font-weight:bold;">'
    . ($weightDone ? '✔ Completed' : 'Pending') . '</td>
    </tr>
</table>';
$pdf->writeHTML($htmlc1, true, false, true, false, '');

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
 * ★ Must match the iframe path below ("yogurtn/pdf/…") — if "yogurtn" is a
 * typo for "yogurt", fix it here AND in the iframe src further down. */
$saveDir = __DIR__ . '/yogurtn/pdf/';
$saveUrl = 'yogurtn/pdf/';
if (!is_dir($saveDir))
    mkdir($saveDir, 0755, true);

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

        body {
            margin: 0;
            min-height: 100vh;
            font: 13px "Segoe UI", Calibri, Arial, sans-serif;
            color: var(--txt);
            background: #eef2ee;
            padding: 20px;
        }

        .card {
            max-width: 1100px;
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
            <a href="yogurt.php?date=<?= urlencode($row['rdate']) ?>" class="btn">← Go Back</a>
        </div>
        <div class="card-body">
            <div class="pdf-frame">
                <iframe src="yogurtn/pdf/<?= $filename ?>"></iframe>
            </div>
        </div>
    </div>
</body>

</html>
