<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user'] == "") {
?>
    <script>
        window.open('../index.php', '_self');
    </script>
<?php
} else {
    $user = $_SESSION['user'];
    $access = $_SESSION['access'];
    $headingname = $_SESSION['headingname'];
    $tabs = $_SESSION['tabs'];
}
include "../connection.php";

$action = isset($_GET['action']) ? $_GET['action'] : '';

/* ★ NEW — "Report" column: each line links to the report page you already made.
 * Change the id below to your report page's id (same style as yogurtmccp / yogurtmlabel). */
$reportPageId = 'yogurtreport';

/* ★ NEW — trays column: yogurt_records.target_pks (= batch ÷ (kg × packs)).
 * Added automatically if it is not in the table yet. */
$tcol = mysqli_query($con, "SHOW COLUMNS FROM `yogurt_records` LIKE 'target_pks'");
if ($tcol && mysqli_num_rows($tcol) == 0)
    mysqli_query($con, "ALTER TABLE `yogurt_records` ADD COLUMN `target_pks` DECIMAL(10,2) NOT NULL DEFAULT 0");


/* ================================================================
 * BLOCK 2 ▸ AJAX — SAVE SHEET  (?action=save)
 * Row for each product+date already exists (created on first open,
 * BLOCK 4.2 below), so save only UPDATES it — never delete+insert.
 * INSERT ... ON DUPLICATE KEY UPDATE covers a brand-new product too
 * (needs the unique key on rdate+product_id — see yogurt_records_unique.sql).
 * Formula columns always recalc in the browser (Excel-like), so only
 * typed columns are stored.
 * ================================================================ */
if ($action === 'save') {
    header('Content-Type: application/json');

    $in = json_decode(file_get_contents('php://input'), true);
    $date = mysqli_real_escape_string($con, isset($in['date']) ? $in['date'] : '');
    if (!$date) {
        echo json_encode(['ok' => false]);
        exit;
    }
    /* ★ NEW — never save into a future date */
    if ($date > date('Y-m-d')) {
        echo json_encode(['ok' => false, 'msg' => 'Future dates are not allowed']);
        exit;
    }

    $cols = [
        'product_id',
        'page_no',
        'description',
        'kg',
        'pks',
        'op_stock',
        'batch',
        'cream',
        'smp',
        'milk',
        'fruit',
        'tank_no',
        'ready_time',
        'finish_time',
        'ccp',
        'weight',
        'actual_filling',
        'cust1',
        'cust2',
        'cust3',
        'cust4',
        'cust5',
        'adj',
        'op_pots',
        'op_lids',
        'op_foil',
        'op_trays',
        'used_pots',
        'used_lids',
        'used_foil',
        'used_trays',
        'culture1_g',
        'culture2_g',
        'culture3_g',
        'culture_total_g',
        'target_pks'
    ];

    $nums = [
        'product_id',
        'page_no',
        'op_stock',
        'batch',
        'cream',
        'smp',
        'milk',
        'fruit',
        'ccp_done',
        'weight_done',
        'actual_filling',
        'cust1',
        'cust2',
        'cust3',
        'cust4',
        'cust5',
        'adj',
        'op_pots',
        'op_lids',
        'op_foil',
        'op_trays',
        'used_pots',
        'used_lids',
        'used_foil',
        'used_trays',
        'culture_total_g',
        'target_pks'
    ];

    /* ★ CHANGED — UPDATE the existing row for (rdate, product_id); INSERT only
     * if that row doesn't exist yet. Nothing is deleted any more.
     * Needs a UNIQUE KEY on (rdate, product_id) — see yogurt_records_unique.sql */
    foreach ($in['rows'] as $r) {
        $vals = [];
        foreach ($cols as $c) {
            $v = isset($r[$c]) ? $r[$c] : '';
            $vals[] = in_array($c, $nums)
                ? (float) $v
                : "'" . mysqli_real_escape_string($con, (string) $v) . "'";
        }
        $set = [];
        foreach ($cols as $ci => $c) {
            if ($c === 'product_id')
                continue;               // key column — never overwritten
            $set[] = "$c=" . $vals[$ci];
        }
        $ok = mysqli_query($con, "INSERT INTO yogurt_records (rdate," . implode(',', $cols) . ")
                            VALUES ('$date'," . implode(',', $vals) . ")
                            ON DUPLICATE KEY UPDATE " . implode(',', $set));
        if (!$ok) {
            echo json_encode(['ok' => false, 'msg' => 'Database error — run yogurt_records_unique.sql']);
            exit;
        }
    }
    echo json_encode(['ok' => true]);
    exit;
}


/* ================================================================
 * BLOCK 3 ▸ AJAX — PREVIOUS DAY  (?action=prev&date=YYYY-MM-DD)
 * Returns previous sheet's closing stock + packaging per product,
 * so the browser can copy them into today's opening cells.
 * ================================================================ */
/* ★ NEW — a product-row counts as "produced / used" on a day when it has ANY figures:
 * batch, filling, goods-out, adjustment, opening or packaging numbers.
 * A completely empty row (product not made, nothing sent, nothing in stock) is SKIPPED,
 * so every product carries forward from ITS OWN last production day.
 * (A day with only goods-out still counts, otherwise those sales would be lost from stock.) */
function activeRowSql($a)
{
    $f = [
        'batch',
        'actual_filling',
        'cust1',
        'cust2',
        'cust3',
        'cust4',
        'cust5',
        'adj',
        'op_stock',
        'op_pots',
        'op_lids',
        'op_foil',
        'op_trays',
        'used_pots',
        'used_lids',
        'used_foil',
        'used_trays'
    ];
    $c = [];
    foreach ($f as $k)
        $c[] = "COALESCE($a.$k,0) <> 0";
    return '(' . implode(' OR ', $c) . ')';
}

if ($action === 'prev') {
    header('Content-Type: application/json');

    $date = mysqli_real_escape_string($con, isset($_GET['date']) ? $_GET['date'] : '');

    /* ★ CHANGED — last production day is found PER PRODUCT (not one common previous sheet) */
    $q = mysqli_query($con, "SELECT r.*
        FROM yogurt_records r
        JOIN (SELECT x.product_id, MAX(x.rdate) d
              FROM yogurt_records x
              WHERE x.rdate < '$date' AND " . activeRowSql('x') . "
              GROUP BY x.product_id) lp
          ON lp.product_id = r.product_id AND lp.d = r.rdate");
    if (!$q || !mysqli_num_rows($q)) {
        echo json_encode(['ok' => false]);
        exit;
    }
    $p = ['d' => ''];
    $out = [];
    while ($r = mysqli_fetch_assoc($q)) {
        if ($r['rdate'] > $p['d'])
            $p['d'] = $r['rdate'];              // latest source date (shown in the message)
        $gt = $r['cust1'] + $r['cust2'] + $r['cust3'] + $r['cust4'] + $r['cust5'];
        $out[$r['product_id']] = [
            'stock' => ($r['op_stock'] + $r['actual_filling']) - $gt + $r['adj'],
            'pots' => $r['op_pots'] - $r['used_pots'],
            'lids' => $r['op_lids'] - $r['used_lids'],
            'foil' => $r['op_foil'] - $r['used_foil'],
            'trays' => $r['op_trays'] - $r['used_trays'],
        ];
    }
    echo json_encode(['ok' => true, 'date' => $p['d'], 'rows' => $out]);
    exit;
}


/* ================================================================
 * BLOCK 4 ▸ PAGE LOAD — prepare data for the requested date
 * ================================================================ */

/* --- 4.0 ★ NEW — auto-link the 110g VLF flavours to their base yogurt ---
 * Safe on every page load (not on save / carry-forward calls):
 *   1. adds yogurt1.base_id only if the column is missing
 *   2. sets base_id = 22 (VLF Fruit Yogurt 110g x 12) for ids 58-61, but ONLY where
 *      base_id is still empty — a link you change by hand is never overwritten.
 *      58 = VLF Strawberry 110g · 59 = Raspberry · 60 = Cherry · 61 = Peach        */
$bcol = mysqli_query($con, "SHOW COLUMNS FROM `yogurt1` LIKE 'base_id'");
if ($bcol && mysqli_num_rows($bcol) == 0)
    mysqli_query($con, "ALTER TABLE `yogurt1` ADD COLUMN `base_id` INT NULL DEFAULT NULL");
mysqli_query($con, "UPDATE `yogurt1` SET `base_id` = 22
                    WHERE `id` IN (58, 59, 60, 61) AND `base_id` IS NULL");

/* --- 4.1 validate date (default = today) --- */
$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date) || !strtotime($date))
    $date = date('Y-m-d');

/* ★ NEW — no future dates: anything after today is pulled back to today */
if ($date > date('Y-m-d'))
    $date = date('Y-m-d');

/* --- 4.2 first open of this date → auto-create one row per product --- */
$chk = mysqli_fetch_assoc(mysqli_query(
    $con,
    "SELECT COUNT(*) c FROM yogurt_records WHERE rdate='$date'"
));
if (!$chk['c']) {
    mysqli_query($con, "INSERT INTO yogurt_records (rdate,product_id,page_no,description,kg,pks)
        SELECT '$date', id, page_no, description, kg, pks
        FROM yogurt1 ORDER BY page_no, sort_order, id");
}

/* ★ CHANGED — AUTO CARRY FORWARD (no weekday rule, no age limit)
 * Runs every time a date is opened, and fills ONLY product rows that are still completely
 * EMPTY (a brand-new sheet, or a sheet that was opened earlier before its data existed).
 * Rows that already have any figures are never touched.
 * Each product takes its OWN last production day — however old it is (a week, a month …).
 * Saturday / Sunday carry forward too, so nothing stops at the weekend.
 * Closing formula is the same as ?action=prev above. */
mysqli_query($con, "UPDATE yogurt_records n
    JOIN (SELECT x.product_id, MAX(x.rdate) d
          FROM yogurt_records x
          WHERE x.rdate < '$date' AND " . activeRowSql('x') . "
          GROUP BY x.product_id) lp ON lp.product_id = n.product_id
    JOIN yogurt_records p ON p.product_id = lp.product_id AND p.rdate = lp.d
    SET n.op_stock = (COALESCE(p.op_stock,0) + COALESCE(p.actual_filling,0))
                     - (COALESCE(p.cust1,0) + COALESCE(p.cust2,0) + COALESCE(p.cust3,0)
                        + COALESCE(p.cust4,0) + COALESCE(p.cust5,0)) + COALESCE(p.adj,0),
        n.op_pots  = ROUND(COALESCE(p.op_pots,0)  - COALESCE(p.used_pots,0)),
        n.op_lids  = ROUND(COALESCE(p.op_lids,0)  - COALESCE(p.used_lids,0)),
        n.op_foil  = ROUND(COALESCE(p.op_foil,0)  - COALESCE(p.used_foil,0)),
        n.op_trays = ROUND(COALESCE(p.op_trays,0) - COALESCE(p.used_trays,0))
    WHERE n.rdate = '$date' AND NOT " . activeRowSql('n'));

/* --- 4.3 fetch rows joined with recipe % from product master --- */
$rows = [];
$q = mysqli_query($con, "SELECT r.*, y.base_id, y.cream_pct, y.smp_pct, y.fruit_pct, y.cultures,
               y.culture1, y.culture2, y.culture3
        FROM yogurt_records r
        LEFT JOIN yogurt1 y ON y.id = r.product_id
        WHERE r.rdate='$date' ORDER BY r.id");
while ($r = mysqli_fetch_assoc($q))
    $rows[] = $r;

/* "70% L901=> 70g" → name part (read-only) + grams part (editable, saved).
 * If nothing is saved yet, the grams default to the part after "=>" */
function cparts($t)
{
    $t = (string) $t;
    /* name part = everything up to and including the sign (=> or -),
     * grams part = the trailing number + g.  "YC470 - 60g" -> ["YC470 -","60g"] */
    if (preg_match('/^(.*?)(\d+(?:\.\d+)?\s*g)\s*$/i', $t, $m))
        return array(trim($m[1]), str_replace(' ', '', trim($m[2])));
    return array(trim($t), '');
}
foreach ($rows as $k => $r) {
    foreach ([1, 2, 3] as $c) {
        $cur = isset($r["culture{$c}_g"]) ? trim($r["culture{$c}_g"]) : '';
        $rows[$k]["culture{$c}_g"] = ($cur !== '') ? $cur : cparts($r["culture$c"])[1];
    }
}

/* --- 4.4 header info — same rules as the Excel file --- */
$day = date('l d M Y', strtotime($date));
$batch = date('ymd', strtotime($date));                 // Batch No = YYMMDD
$bb = date('d/m/y', strtotime($date . ' +30 days'));   // Best Before = +30 days

/* --- 4.5 ★ NEW — Friday WEEKLY plan (mysqli, read-only) ---
 * One plan per week, made on the Friday before (Mon = -3 days … Fri = -7 days).
 * The same weekly plan is shown above every day Mon–Fri of that week.
 * Cream / SMP / Milk / Fruit use the SAME recipe rules as the sheet.   */
$isWeekday = (date('N', strtotime($date)) <= 5);
$planFriday = date('Y-m-d', strtotime($date . ' -' . (date('N', strtotime($date)) + 2) . ' days'));
$planRows = [];
$planErr = false;
$planTot = ['batch' => 0, 'cream' => 0, 'smp' => 0, 'milk' => 0, 'fruit' => 0, 'total' => 0, 'pks' => 0];
if ($isWeekday) {
    $wf = mysqli_real_escape_string($con, $planFriday);
    $ps = mysqli_query($con, "SELECT p.product_id, p.batch, y.description, y.kg, y.pks,
                                     y.cream_pct, y.smp_pct, y.fruit_pct,
                                     y.culture1, y.culture2, y.culture3
                              FROM yogurt_plan p
                              JOIN yogurt1 y ON y.id = p.product_id
                              WHERE p.week_friday='$wf' AND p.batch > 0
                              ORDER BY y.page_no, y.sort_order, y.id");
    if (!$ps) {
        $planErr = true;      // plan table missing → sheet still opens normally
    } else {
        while ($p = mysqli_fetch_assoc($ps)) {
            $b = (float) $p['batch'];
            $p['cream'] = round($b * $p['cream_pct'] / 100, 2);
            $p['smp'] = round($b * $p['smp_pct'] / 100, 2);
            $p['fruit'] = round($b * $p['fruit_pct'] / 100, 2);
            $p['milk'] = round($b - $p['cream'] - $p['smp'], 2);
            $p['total'] = round($p['cream'] + $p['smp'] + $p['milk'] + $p['fruit'], 2);
            $kg = (float) $p['kg'];
            $p['tpks'] = $kg ? round($p['total'] / $kg, 2) : 0;
            $planRows[] = $p;
            $planTot['batch'] += $b;
            $planTot['cream'] += $p['cream'];
            $planTot['smp'] += $p['smp'];
            $planTot['milk'] += $p['milk'];
            $planTot['fruit'] += $p['fruit'];
            $planTot['total'] += $p['total'];
            $planTot['pks'] += $p['tpks'];
        }
    }
}
/** trim 12.50 → 12.5 · 0 → '' */
function pf($v)
{
    return $v ? rtrim(rtrim(number_format($v, 2, '.', ''), '0'), '.') : '';
}


/* ================================================================
 * BLOCK 5 ▸ PHP HELPERS
 * ================================================================ */

/** HTML-escape any value before printing (XSS-safe). */
function h($s)
{
    return htmlspecialchars((string) $s, ENT_QUOTES);
}

/** One <td> with an <input>. fz1/fz2 = frozen column classes. */
function inc($i, $k, $v, $cls = 'in')
{
    if ($cls == 'time') {
        return "<td class='in'><input type='time' class='ci' data-i='$i' data-k='$k' value=\"" . h($v) . "\"></td>";
    } else {
        return "<td class='$cls'><input class='ci' data-i='$i' data-k='$k' value=\"" . h($v) . "\"></td>";
    }
}


function totalRow($label, $p, $grand = false)
{
    $pre = $grand ? 'g_' : 'p' . $p . '_';
    $c = [];
    $c[] = "<td class='rn'></td>";
    $c[] = "<td id='{$pre}op_stock' class='fz1'></td>";
    $c[] = "<td colspan='3' class='lbl fz2'>$label</td>";
    $c[] = "<td id='{$pre}batch'></td>";
    foreach (['cream', 'smp', 'milk', 'fruit'] as $k)
        $c[] = "<td id='{$pre}{$k}'></td>";
    $c[] = "<td colspan='10'></td>";                       // Tank / Ready / Finish + 3 cultures × (name + grams) (no totals)
    foreach (['total', 'target_pks', 'actual_filling', 'stock_cs'] as $k)
        $c[] = "<td id='{$pre}{$k}'></td>";
    $c[] = "<td colspan='4'></td>";                       // CCP + Label + Weight check + Report (no totals)
    $c[] = "<td colspan='2' class='sep-go'></td>";
    foreach (['cust1', 'cust2', 'cust3', 'cust4', 'cust5', 'go_total', 'adj', 'closing_stock'] as $k)
        $c[] = "<td id='{$pre}{$k}'></td>";
    $c[] = "<td id='{$pre}op_pots' class='sep-pk'></td>";
    foreach (['op_lids', 'op_foil', 'op_trays'] as $k)
        $c[] = "<td id='{$pre}{$k}'></td>";
    $c[] = "<td></td>";
    foreach (
        [
            'used_pots',
            'used_lids',
            'used_foil',
            'used_trays',
            'cl_pots',
            'cl_lids',
            'cl_foil',
            'cl_trays'
        ] as $k
    )
        $c[] = "<td id='{$pre}{$k}'></td>";
    return "<tr class='trow" . ($grand ? ' grand' : '') . "'>" . implode('', $c) . "</tr>";
}

/* ── column widths (45 cols) ─────────────────────────────────────
 * ★ CHANGED: we now also compute the TOTAL width → used as the
 *   table's min-width. Result: table always fills the card when
 *   there is room, and scrolls left↔right only when overflowing. */
$widths = [
    /* #  OpStk Desc  Kg  Pks Batch | Crm SMP Milk Frt | Tank Ready Finish | Culture1 Culture2 Culture3 | Ttl Pks Fill OPStk | CCP Weight */
    /* GDesc  Kg | Southall Kosher DFarm SLon Watson Ttl Adj Stk */
    /* P L F T | Product Name | usedP L F T | closeP L F T */
    36,
    64,
    240,
    46,
    44,
    70,
    80,
    66,
    66,
    66,
    100,
    130,
    130,
    110,
    70,
    110,
    70,
    110,
    70,
    90,
    66,
    66,
    100,
    80,
    170,
    170,
    170,
    90,
    240,
    50,
    76,
    76,
    76,
    76,
    76,
    64,
    60,
    66,
    56,
    56,
    56,
    56,
    240,
    56,
    56,
    56,
    56,
    56,
    56,
    56,
    56
];
$tableMin = array_sum($widths);          // ★ natural (minimum) table width in px

$colgroup = '<colgroup>';
foreach ($widths as $w)
    $colgroup .= "<col style='width:{$w}px'>";
$colgroup .= '</colgroup>';
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>🥣 Yogurt Production Records — <?= h($date) ?></title>

    <style>
        /* ================================================================
 * BLOCK 6 ▸ CSS — DESIGN + LAYOUT
 * ================================================================ */

        /* ---------- 6.1 palette & base ----------
 * html + body LOCKED to device height, page itself never scrolls. */
        :root {
            --g: #217346;
            --g-dark: #164a2d;
            --g-soft: #e8f4ec;
            --blue: #1e88e5;
            --amber: #f59e0b;
            --bd: #d5ded8;
            --bd2: #b9c8bf;
            --txt: #22312a;

            /* ★ CHANGED — frozen-pane offsets + header height now live in
     * CSS variables. Real values are measured by JS (syncSticky)
     * so the frozen columns stay aligned even when the table
     * stretches on wide screens. These are only fallbacks.        */
            --off1: 36px;
            /* left edge of Op/Stk column  */
            --off2: 92px;
            /* left edge of Description    */
            --h1h: 34px;
            /* height of banner header row */
        }

        * {
            box-sizing: border-box
        }

        html,
        body {
            height: 100%;
            /* exactly device height */
            margin: 0;
            overflow: hidden;
            /* no page scrollbar */
        }

        body {
            display: flex;
            flex-direction: column;
            /* header → toolbar → legend → table */
            font: 12.5px "Segoe UI", Calibri, Arial, sans-serif;
            color: var(--txt);
            background: #eef2ee;
        }

        /* ---------- 6.2 top header ---------- */
        .top {
            flex: 0 0 auto;
            display: flex;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
            padding: 12px 18px;
            color: #fff;
            background: linear-gradient(135deg, #0e4d2c 0%, #217346 55%, #2f9e67 100%);
            box-shadow: 0 3px 14px rgba(13, 60, 35, .35);
        }

        .logo {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            font-size: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, .16);
            border: 1px solid rgba(255, 255, 255, .28);
        }

        .top h1 {
            margin: 0;
            font-size: 18px;
            letter-spacing: .3px
        }

        .top .sub {
            font-size: 11.5px;
            opacity: .85;
            margin-top: 2px
        }

        .top .spacer {
            flex: 1
        }

        .pill {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: rgba(255, 255, 255, .14);
            border: 1px solid rgba(255, 255, 255, .26);
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 12.5px;
            line-height: 1.3;
        }

        .pill small {
            font-size: 9px;
            opacity: .8;
            text-transform: uppercase;
            letter-spacing: .8px
        }

        /* ---------- 6.3 toolbar ---------- */
        .toolbar {
            flex: 0 0 auto;
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            padding: 8px 14px;
            background: rgba(255, 255, 255, .92);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid var(--bd);
        }

        .navbtn {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            border: 1px solid var(--bd2);
            background: #fff;
            cursor: pointer;
            font-size: 13px;
            color: var(--g-dark);
            transition: all .15s;
        }

        .navbtn:hover {
            background: var(--g-soft);
            border-color: var(--g)
        }

        .dinput {
            height: 30px;
            border: 1px solid var(--bd2);
            border-radius: 8px;
            padding: 0 8px;
            font: inherit;
            color: var(--txt);
            outline: 0;
        }

        .dinput:focus {
            border-color: var(--g);
            box-shadow: 0 0 0 3px rgba(33, 115, 70, .15)
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 8px;
            cursor: pointer;
            border: 1px solid var(--bd2);
            background: #fff;
            color: #254b38;
            font: 600 12.5px "Segoe UI", Calibri, Arial;
            transition: all .15s;
            white-space: nowrap;
        }

        .btn:hover {
            background: var(--g-soft);
            border-color: var(--g);
            color: var(--g-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(33, 115, 70, .18);
        }

        .btn:active {
            transform: translateY(0)
        }

        .btn-save {
            background: linear-gradient(135deg, #217346, #2f9e67);
            color: #fff;
            border-color: transparent;
        }

        .btn-save:hover {
            background: linear-gradient(135deg, #1a5e39, #278b59);
            color: #fff
        }

        /* live KPI stats */
        .stats {
            display: flex;
            gap: 8px;
            margin-left: auto
        }

        .stat {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: #f4f9f5;
            border: 1px solid var(--bd);
            border-radius: 10px;
            padding: 3px 12px;
            min-width: 74px;
            line-height: 1.25;
        }

        .stat small {
            font-size: 9px;
            color: #6a7d71;
            text-transform: uppercase;
            letter-spacing: .5px
        }

        .stat b {
            font-size: 13px;
            color: var(--g-dark)
        }

        #st {
            font-size: 11.5px;
            color: #5a6b60;
            min-width: 110px
        }

        #st.dirty {
            color: #c76a00;
            font-weight: 700;
            animation: pulse 1s infinite
        }

        @keyframes pulse {
            50% {
                opacity: .4
            }
        }

        /* ---------- 6.4 legend ---------- */
        .legend {
            flex: 0 0 auto;
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
            padding: 5px 16px;
            font-size: 11px;
            color: #5a6b60;
            background: #f7faf7;
            border-bottom: 1px solid var(--bd);
        }

        .chip {
            display: inline-flex;
            align-items: center;
            gap: 5px
        }

        .chip i {
            width: 13px;
            height: 13px;
            border-radius: 3px;
            border: 1px solid #b9c8bf;
            display: inline-block;
        }

        .legend kbd {
            background: #fff;
            border: 1px solid var(--bd2);
            border-bottom-width: 2px;
            border-radius: 4px;
            padding: 0 5px;
            font: 600 10px monospace;
            color: #33463b;
        }

        .legend .hint {
            margin-left: auto
        }

        /* ---------- 6.4b ★ NEW — Friday plan strip (above the sheet) ---------- */
        .plan {
            flex: 0 0 auto;
            margin: 8px 20px 0;
            background: #fff;
            border: 1px solid var(--bd);
            border-radius: 12px;
            box-shadow: 0 2px 16px rgba(20, 50, 35, .08);
            overflow: hidden;
        }

        .plan summary {
            cursor: pointer;
            list-style: none;
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            padding: 6px 14px;
            color: #fff;
            font-weight: 600;
            font-size: 12.5px;
            letter-spacing: .3px;
            background: linear-gradient(180deg, #268152, #1d6741);
        }

        .plan summary::-webkit-details-marker {
            display: none
        }

        .plan summary .sp {
            flex: 1
        }

        .plan summary .note {
            font-weight: 400;
            font-size: 11.5px;
            opacity: .9
        }

        .plan summary .btn {
            padding: 3px 10px;
            font-size: 11.5px;
            text-decoration: none
        }

        .plan .pbody {
            max-height: 26vh;
            overflow: auto
        }

        /* fixed column widths (colgroup) → Description can never float/shift */
        .plan table {
            table-layout: fixed;
            width: 100%
        }

        /* frozen # and Description (own offsets: # column = 36px wide) */
        .plan td.prn,
        .plan th.prn {
            position: sticky;
            left: 0;
            z-index: 4;
            background: #eef3ef;
            color: #9aa89f;
            font-size: 10.5px;
            font-weight: 600;
        }

        .plan td.pdesc,
        .plan th.pdesc {
            position: sticky;
            left: 36px;
            z-index: 4;
            text-align: left;
            border-right: 2px solid var(--bd2);
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .plan td.pdesc {
            background: #fbfdfc;
            font-weight: 500;
            color: #20332a
        }

        .plan th.prn,
        .plan th.pdesc {
            z-index: 6;
            background: linear-gradient(180deg, #eaf5ee, #d9ebdf);
        }

        .plan .trow td.prn,
        .plan .trow td.pdesc {
            background: linear-gradient(180deg, #d3e9da, #c2e0cc);
        }

        .plan th {
            position: sticky;
            top: 0;
            z-index: 2;
            background: linear-gradient(180deg, #eaf5ee, #d9ebdf);
            color: #1d4b30;
            font-size: 11px;
            font-weight: 600;
            height: 26px;
            border-bottom: 2px solid var(--g);
        }

        .plan td.desc {
            text-align: left
        }

        .plan .empty {
            padding: 12px 16px;
            color: #6a7d71;
            font-size: 12px
        }

        @media (max-width: 640px) {
            .plan {
                margin: 6px 8px 0
            }
        }

        @media print {
            .plan {
                margin: 0 0 6px;
                border-radius: 0;
                box-shadow: none
            }

            .plan .pbody {
                max-height: none;
                overflow: visible
            }

            .plan summary .btn {
                display: none
            }
        }

        /* ---------- 6.5 table area — THE ONLY SCROLL CONTAINER ----------
 * ★ CHANGED: .wrap now has LEFT/RIGHT PADDING (20px) so the card
 *      never touches the screen edges — that's your side space.
 * .wrap  flex:1 + min-height:0 → card shrinks, scrolls inside.
 * .card  overflow:auto → scrolls left↔right ONLY when the table
 *        is wider than the available space (min-width on table). */
        .wrap {
            flex: 1 1 auto;
            /* fill ALL remaining height */
            min-height: 0;
            /* CRITICAL for inner scrolling */
            padding: 10px 20px;
            /* ★ side space: left & right  */
            display: flex;
        }

        .card {
            flex: 1;
            overflow: auto;
            /* ← all scrolling happens here */
            overscroll-behavior: contain;
            background: #fff;
            border: 1px solid var(--bd);
            border-radius: 12px;
            box-shadow: 0 2px 16px rgba(20, 50, 35, .08);
        }

        /* pretty scrollbars */
        .card::-webkit-scrollbar {
            width: 10px;
            height: 12px
        }

        .card::-webkit-scrollbar-thumb {
            background: #b9cec2;
            border-radius: 6px;
            border: 2px solid #fff
        }

        .card::-webkit-scrollbar-thumb:hover {
            background: #8fb49e
        }

        .card::-webkit-scrollbar-track {
            background: #f0f4f1
        }

        .card::-webkit-scrollbar-corner {
            background: #f0f4f1
        }

        /* ---------- 6.6 the grid ----------
 * ★ CHANGED: width:100% — table FILLS the card on wide screens
 *      (columns stretch a little, looks full & tidy).
 *      min-width (inline, from PHP = sum of columns) guarantees
 *      the table never gets crushed → when the screen is narrow,
 *      it simply SCROLLS left↔right inside .card.               */
        table {
            border-collapse: separate;
            border-spacing: 0;
            table-layout: fixed;
            width: 100%;
            /* ★ fill available width  */
            /* min-width is set inline on <table> by PHP            */
        }

        th,
        td {
            border-right: 1px solid var(--bd);
            border-bottom: 1px solid var(--bd);
            height: 26px;
            padding: 0 4px;
            text-align: center;
            white-space: nowrap;
            overflow: hidden;
            font-size: 12px;
        }

        /* header row 1 — green banner (sticky inside .card) */
        tr.h1 th {
            position: sticky;
            top: 0;
            z-index: 8;
            background: linear-gradient(180deg, #268152, #1d6741);
            color: #fff;
            font-size: 12.5px;
            height: var(--h1h, 34px);
        }

        tr.h1 th.crn {
            left: 0;
            z-index: 9
        }

        /* header row 2 — column titles (sticky, section-coloured)
 * ★ CHANGED: top/left now read from CSS vars (JS keeps them true) */
        tr.h2 th {
            position: sticky;
            top: var(--h1h, 34px);
            z-index: 6;
            background: linear-gradient(180deg, #eaf5ee, #d9ebdf);
            color: #1d4b30;
            font-size: 11px;
            font-weight: 600;
            height: 30px;
            border-bottom: 2px solid var(--g);
        }

        tr.h2 th.fz1 {
            left: var(--off1, 36px);
            z-index: 7
        }

        tr.h2 th.fz2 {
            left: var(--off2, 92px);
            z-index: 7
        }

        tr.h2 th.sec-go {
            background: linear-gradient(180deg, #e9f2fc, #d7e7f8);
            color: #0d47a1;
            border-bottom-color: var(--blue);
        }

        tr.h2 th.sec-pk {
            background: linear-gradient(180deg, #fef4e2, #fce8c8);
            color: #8a5200;
            border-bottom-color: var(--amber);
        }

        /* frozen body columns — ★ offsets from CSS vars (JS-synced) */
        td.rn {
            position: sticky;
            left: 0;
            z-index: 4;
            background: #eef3ef;
            color: #9aa89f;
            font-size: 10.5px;
            font-weight: 600
        }

        td.fz1 {
            position: sticky;
            left: var(--off1, 36px);
            z-index: 4;
            background: #fff;
            border-right: 2px solid var(--bd2)
        }

        td.fz2 {
            position: sticky;
            left: var(--off2, 92px);
            z-index: 4;
            border-right: 2px solid var(--bd2)
        }

        /* section dividers */
        .sep-go {
            border-left: 3px solid var(--blue) !important
        }

        .sep-pk {
            border-left: 3px solid var(--amber) !important
        }

        /* ---------- 6.7 cell colours (Excel language) ---------- */
        td.in {
            background: #fff
        }

        /* type here        */
        td.semi {
            background: #eef5ff
        }

        /* auto + editable  */
        td.calc {
            background: #fffae6;
            font-weight: 600;
            color: #6b5200
        }

        /* formula          */
        td.mir {
            background: #f6f8f7;
            color: #8a9790;
            font-style: italic;
            font-size: 11px
        }

        td.ro {
            background: #f2f4f3;
            color: #55605a
        }

        td.desc {
            text-align: left;
            font-weight: 500;
            color: #20332a;
            background: #fbfdfc
        }

        .ci {
            width: 100%;
            height: 24px;
            border: 0;
            background: transparent;
            text-align: center;
            font: inherit;
            color: #1b3a29;
            outline: 0;
        }

        .ci:focus {
            box-shadow: inset 0 0 0 2px var(--g);
            background: #fff;
            border-radius: 2px
        }

        tr.row-focus td {
            background-image: linear-gradient(rgba(33, 115, 70, .06), rgba(33, 115, 70, .06));
        }

        tr.row-focus td.rn {
            box-shadow: inset 3px 0 0 var(--g)
        }

        tbody tr:hover td {
            background-color: #f4faf6
        }

        /* ★ NEW — CCP / Weight check cells: ✔ Completed  |  Attempt Check button */
        td.chk {
            white-space: nowrap;
            background: #fff
        }

        td.chk.done {
            background: #e3f4e8
        }

        td.chk .okb {
            color: var(--g-dark);
            font-weight: 700;
            font-size: 11.5px
        }

        .btn-att {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 6px;
            background: #fef4e2;
            border: 1px solid var(--amber);
            color: #8a5200;
            font-weight: 600;
            font-size: 11px;
            text-decoration: none;
            transition: all .15s
        }

        .btn-comp {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 6px;
            background: #1d4b30;

            color: #fff;
            font-weight: 600;
            font-size: 11px;
            text-decoration: none;
            transition: all .15s
        }

        .btn-wait {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 6px;
            background: #b96e0bff;
            border: 1px solid var(--amber);
            color: #fbfcf9ff;
            font-weight: 600;
            font-size: 11px;
            text-decoration: none;
            transition: all .15s;
        }

        .btn-rep {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 6px;
            background: #e8f1fc;
            border: 1px solid #1565c0;
            color: #0d47a1;
            font-weight: 600;
            font-size: 11px;
            text-decoration: none;
            transition: all .15s
        }

        .btn-rep:hover {
            background: #1565c0;
            color: #fff
        }

        .btn-att:hover {
            background: var(--amber);
            color: #fff
        }

        .btn-wait:hover {
            background: var(--amber);
            color: #fff
        }

        .btn-comp:hover {
            background: var(--g);
            color: #fff
        }

        /* ---------- 6.8 negatives + totals ---------- */
        .neg {
            color: #d32f2f !important;
            font-weight: 800
        }

        .trow td {
            background: linear-gradient(180deg, #e8f3ec, #dceee3);
            font-weight: 700;
            color: #14432a;
            height: 28px;
        }

        .trow td.fz1,
        .trow td.fz2 {
            background: linear-gradient(180deg, #e8f3ec, #dceee3);
        }

        .trow .lbl {
            text-align: left;
            padding-left: 10px;
            letter-spacing: .3px
        }

        .trow.grand td {
            background: linear-gradient(180deg, #d3e9da, #c2e0cc);
            font-size: 12.5px;
            border-top: 3px double var(--g);
        }

        /* ---------- 6.9 toasts ---------- */
        #toasts {
            position: fixed;
            right: 18px;
            bottom: 18px;
            z-index: 999;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .toast {
            padding: 10px 18px;
            border-radius: 10px;
            color: #fff;
            font-size: 12.5px;
            box-shadow: 0 8px 22px rgba(0, 0, 0, .28);
            opacity: 0;
            transform: translateY(14px);
            transition: all .28s;
        }

        .toast.show {
            opacity: 1;
            transform: translateY(0)
        }

        .toast.ok {
            background: linear-gradient(135deg, #1e7e4a, #2f9e67)
        }

        .toast.err {
            background: linear-gradient(135deg, #c62828, #e53935)
        }

        /* ---------- 6.10 responsive chrome ----------
 * ★ side padding shrinks on small screens so the table keeps
 *   maximum room, but never disappears completely.            */
        @media (max-height: 720px) {

            /* short laptop screens */
            .top {
                padding: 7px 12px
            }

            .top .sub {
                display: none
            }

            .legend .hint {
                display: none
            }

            .wrap {
                padding-top: 6px;
                padding-bottom: 6px
            }
        }

        @media (max-width: 1024px) {

            /* tablets */
            .stats {
                display: none
            }

            .top .pill {
                padding: 2px 10px;
                font-size: 11px
            }

            .wrap {
                padding-left: 12px;
                padding-right: 12px
            }

            /* less side space */
        }

        @media (max-width: 640px) {

            /* phones */
            .top h1 {
                font-size: 14px
            }

            .legend {
                display: none
            }

            .btn {
                padding: 5px 10px
            }

            .wrap {
                padding: 6px 8px
            }

            /* minimal side space */
        }

        /* ---------- 6.11 print — unlock height, compact full sheet ---------- */
        @media print {

            html,
            body {
                height: auto;
                overflow: visible;
                display: block
            }

            /* undo lock */
            .top,
            .toolbar,
            .legend,
            #toasts {
                display: none !important
            }

            body {
                background: #fff
            }

            .wrap {
                display: block;
                padding: 0;
                flex: none
            }

            .card {
                overflow: visible;
                flex: none;
                border: 0;
                border-radius: 0;
                box-shadow: none
            }

            th,
            td {
                position: static !important;
                font-size: 8.5px;
                height: auto
            }

            td.desc {
                min-width: 120px
            }

            /* ★ print: natural width only + slight zoom so the wide
     *      table fits an A3 landscape page                    */
            table {
                width: auto !important;
                min-width: 0 !important;
                zoom: .62
            }
        }

        @page {
            size: A3 landscape;
            margin: 8mm
        }
    </style>
</head>

<body>

    <?php /* ================================================================
      * BLOCK 7 ▸ PAGE CHROME — header / toolbar / legend
      * ================================================================ */ ?>

    <!-- brand header with live info pills -->
    <header class="top">
        <div class="logo">🥣</div>
        <div>
            <h1>Yogurt Production Records</h1>
            <div class="sub">Marshwood Farm Limited · Production Sheet</div>
        </div>
        <div class="spacer"></div>
        <div class="pill"><small>Date</small><?= h($day) ?></div>
        <div class="pill"><small>Batch No.</small><?= $batch ?></div>
        <div class="pill"><small>Best Before</small><?= $bb ?></div>
        <a href="../admin.php?id=yogurt" class="pill"
            style="text-decoration:none; color:#fff; font-weight:600; padding:6px 16px; display:inline-flex; align-items:center;">Go
            Back</a>
    </header>

    <!-- toolbar: date navigation · actions · live KPIs -->
    <div class="toolbar">
        <button class="navbtn" title="Previous day" onclick="stepDate(-1)">◀</button>
        <input class="dinput" type="date" value="<?= h($date) ?>" max="<?= date('Y-m-d') ?>" onchange="gotoDate(this.value)">
        <button class="navbtn" title="Next day" onclick="stepDate(1)"
            <?= $date >= date('Y-m-d') ? 'disabled style="opacity:.35;cursor:not-allowed"' : '' ?>>▶</button>

        <button class="btn" onclick="carry()" title="Copy previous day's closing stock to opening">⟲
            Carry&nbsp;Forward</button>
        <button class="btn btn-save" onclick="save()" title="Ctrl+S">💾 Save</button>
        <button class="btn" onclick="window.print()">🖨 Print</button>
        <button class="btn" onclick="exportExcel()" title="Download this page's tables as an Excel file">📥 Save as Excel</button>
        <a class="btn" href="plan.php?date=<?= h($isWeekday ? $planFriday : $date) ?>" style="text-decoration:none"
            title="Friday planning page">📋 Weekly Plan</a>

        <div class="stats">
            <span class="stat"><small>Planned</small> <b id="kpi_total">0</b></span>
            <span class="stat"><small>Despatch</small> <b id="kpi_go">0</b></span>
            <span class="stat"><small>Closing Stock</small><b id="kpi_stock">0</b></span>
        </div>
        <span id="st"></span>
    </div>

    <!-- legend: colour language + keyboard hints -->
    <div class="legend">
        <span class="chip"><i style="background:#fff"></i>you type</span>
        <span class="chip"><i style="background:#eef5ff"></i>auto-filled (editable)</span>
        <span class="chip"><i style="background:#fffae6"></i>formula (calculated)</span>
        <span class="chip"><i style="background:#f2f4f3"></i>locked</span>
        <span class="chip"><i style="background:#d7e7f8"></i>Goods-Out</span>
        <span class="chip"><i style="background:#fce8c8"></i>Packaging</span>
        <span class="hint"><kbd>Enter</kbd> move down · <kbd>↑↓</kbd> navigate · <kbd>Ctrl+S</kbd> save</span>
    </div>

    <?php /* ================================================================
      * BLOCK 7b ★ NEW ▸ FRIDAY PLAN for this day (shown above the sheet)
      * ================================================================ */ ?>
    <?php if ($isWeekday): ?>
        <details class="plan" open>
            <summary>
                <span>📋 Weekly Plan — week of <?= h(date('d M', strtotime($planFriday . ' +3 days'))) ?> to
                    <?= h(date('d M', strtotime($planFriday . ' +7 days'))) ?></span>
                <span class="sp"></span>
                <span class="note">Planned on Friday <?= h(date('d M Y', strtotime($planFriday))) ?></span>
                <a class="btn" href="plan.php?date=<?= h($planFriday) ?>" onclick="event.stopPropagation()">✎ Edit Plan</a>
            </summary>
            <div class="pbody">
                <?php if ($planErr): ?>
                    <div class="empty">⚠ Plan table not found — run <b>plan.sql</b> once in your database.</div>
                <?php elseif (!$planRows): ?>
                    <div class="empty">No weekly plan saved yet — add it on the Friday planning page (✎ Edit Plan).</div>
                <?php else: ?>
                    <table style="min-width: 1580px">
                        <colgroup>
                            <col style="width:36px">
                            <col style="width:270px">
                            <col style="width:50px">
                            <col style="width:44px">
                            <col style="width:90px">
                            <col style="width:90px">
                            <col style="width:90px">
                            <col style="width:90px">
                            <col style="width:90px">
                            <col style="width:90px">
                            <col style="width:90px">
                            <col style="width:170px">
                            <col style="width:170px">
                            <col style="width:170px">
                        </colgroup>
                        <thead>
                            <tr>
                                <th class="prn">#</th>
                                <th class="pdesc">Description</th>
                                <th>Kg</th>
                                <th>Pks</th>
                                <th>Batch Ltr</th>
                                <th>Cream</th>
                                <th>SMP</th>
                                <th>Milk</th>
                                <th>Fruit</th>
                                <th>Total</th>
                                <th>Target Pks</th>
                                <th>Culture 1</th>
                                <th>Culture 2</th>
                                <th>Culture 3</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($planRows as $n => $p): ?>
                                <tr class="prow">
                                    <td class="prn"><?= $n + 1 ?></td>
                                    <td class="pdesc" title="<?= h($p['description']) ?>"><?= h($p['description']) ?></td>
                                    <td class="ro"><?= h($p['kg']) ?></td>
                                    <td class="ro"><?= h($p['pks']) ?></td>
                                    <td class="calc"><?= pf($p['batch']) ?></td>
                                    <td class="semi"><?= pf($p['cream']) ?></td>
                                    <td class="semi"><?= pf($p['smp']) ?></td>
                                    <td class="semi"><?= pf($p['milk']) ?></td>
                                    <td class="semi"><?= pf($p['fruit']) ?></td>
                                    <td class="calc"><?= pf($p['total']) ?></td>
                                    <td class="calc"><?= pf($p['tpks']) ?></td>
                                    <td class="ro"><?= h($p['culture1']) ?></td>
                                    <td class="ro"><?= h($p['culture2']) ?></td>
                                    <td class="ro"><?= h($p['culture3']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr class="trow grand">
                                <td class="prn"></td>
                                <td class="lbl pdesc">TOTAL PLANNED</td>
                                <td></td>
                                <td></td>
                                <td><?= pf($planTot['batch']) ?></td>
                                <td><?= pf($planTot['cream']) ?></td>
                                <td><?= pf($planTot['smp']) ?></td>
                                <td><?= pf($planTot['milk']) ?></td>
                                <td><?= pf($planTot['fruit']) ?></td>
                                <td><?= pf($planTot['total']) ?></td>
                                <td><?= pf($planTot['pks']) ?></td>
                                <td colspan="3"></td>
                            </tr>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </details>
    <?php endif; ?>

    <?php /* ================================================================
      * BLOCK 8 ▸ THE EXCEL-STYLE TABLE
      * 37 columns · frozen panes · page totals · grand total
      * Lives inside .card — the ONLY element that scrolls.
      * ================================================================ */ ?>
    <div class="wrap">
        <div class="card">
            <table style="min-width: <?= $tableMin ?>px"> <!-- ★ never shrinks below this → scrolls instead -->
                <?= $colgroup ?>

                <thead>
                    <!-- row 1 : three section banners -->
                    <tr class="h1">
                        <th rowspan="2">#</th>
                        <th colspan="27">Quantities for Yogurt Production</th>
                        <th colspan="10" class="sep-go">Daily Goods-Out Record Sheet (C/S)</th>
                        <th colspan="13" class="sep-pk">Packaging Material Stock</th>
                    </tr>

                    <!-- row 2 : column titles (fz = frozen, sec = section colour) -->
                    <tr class="h2">
                        <th class="fz1">Op/Stk</th>
                        <th class="fz2">Description</th>
                        <th>Kg</th>
                        <th>Pks</th>
                        <th>Batch</th>
                        <th>Cream</th>
                        <th>SMP</th>

                        <th>Fruit</th>
                        <th>Milk</th>
                        <th>Tank No</th>
                        <th>Ready Time</th>
                        <th>Finish Time</th>
                        <th>Culture 1</th>
                        <th>Qty (g)</th>
                        <th>Culture 2</th>
                        <th>Qty (g)</th>
                        <th>Culture 3</th>
                        <th>Qty (g)</th>
                        <th>Culture Total (g)</th>
                        <th>Total</th>
                        <th>Tray</th>
                        <th>Actual Filling</th>
                        <th>O/P Stock</th>
                        <th>CCP Checks</th>
                        <th>Label Check</th>
                        <th>Weight Check</th>
                        <th>Report</th>


                        <th class="sec-go sep-go">Description</th>
                        <th class="sec-go">Kg</th>
                        <th class="sec-go">Southall</th>
                        <th class="sec-go">Kosher</th>
                        <th class="sec-go">D Farm</th>
                        <th class="sec-go">S Lon</th>
                        <th class="sec-go">Watson</th>
                        <th class="sec-go">Total</th>
                        <th class="sec-go">Adj.</th>
                        <th class="sec-go">Stock</th>

                        <th class="sec-pk sep-pk" title="Pots">P</th>
                        <th class="sec-pk" title="Lids">L</th>
                        <th class="sec-pk" title="Foil">F</th>
                        <th class="sec-pk" title="Trays">T</th>
                        <th class="sec-pk">Product Name</th>
                        <th class="sec-pk" title="Pots">P</th>
                        <th class="sec-pk" title="Lids">L</th>
                        <th class="sec-pk" title="Foil">F</th>
                        <th class="sec-pk" title="Trays">T</th>
                        <th class="sec-pk" title="Pots">P</th>
                        <th class="sec-pk" title="Lids">L</th>
                        <th class="sec-pk" title="Foil">F</th>
                        <th class="sec-pk" title="Trays">T</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    /* one <tr> per product; TOTAL row injected at each page change,
                     * plus one GRAND TOTAL at the end */
                    $last = null;
                    foreach ($rows as $i => $r):
                        if ($last !== null && $r['page_no'] != $last)
                            echo totalRow('TOTAL — Page ' . $last, $last);
                        $last = $r['page_no'];
                    ?>
                        <tr class="prow">
                            <!-- left frozen block -->
                            <td class="rn"><?= $i + 1 ?></td>
                            <?= inc($i, 'op_stock', $r['op_stock'], 'in fz1') ?>
                            <td class="ro desc fz2"
                                title="Cultures: <?= h(implode(' / ', array_filter([$r['culture1'], $r['culture2'], $r['culture3']]))) ?>">
                                <?= h($r['description']) ?>
                            </td>

                            <!-- planning section (green) -->
                            <td class="ro"><input type="hidden" id="f_kg_<?= $i ?>" value="<?= h($r['kg']) ?>"><?= h($r['kg']) ?>
                            </td>
                            <td class="ro"><input type="hidden" id="f_pks_<?= $i ?>" value="<?= h($r['pks']) ?>"><?= h($r['pks']) ?>
                            </td>
                            <td class="in"><input type="text" class="ci bprx" data-i="<?= $i ?>" data-k="batch"
                                    value="<?= h($r['batch']) ?>" onchange="jako(<?= $i ?>,this.value)" id="f_batch_<?= $i ?>"></td>


                            <td class="in"><input class="ci" data-i="<?= $i ?>" data-k="cream" value="<?= h($r['cream']) ?>" id="f_cream_<?= $i ?>" oninput="milkqty(<?= $i ?>)"></td>


                            <td class="in"><input class="ci" data-i="<?= $i ?>" data-k="smp" value="<?= h($r['smp']) ?>" id="f_smp_<?= $i ?>" oninput="milkqty(<?= $i ?>)"></td>

                            <td class="in"><input class="ci" data-i="<?= $i ?>" data-k="fruit" value="<?= h($r['fruit']) ?>" id="f_fruit_<?= $i ?>" oninput="milkqty(<?= $i ?>)"></td>
                            <td class="in"><input class="ci" data-i="<?= $i ?>" data-k="milk" value="<?= h($r['milk']) ?>" id="f_milk_<?= $i ?>"></td>

                            <?= inc($i, 'tank_no', isset($r['tank_no']) ? $r['tank_no'] : '') ?>
                            <?= inc($i, 'ready_time', isset($r['ready_time']) ? $r['ready_time'] : '', 'time') ?>
                            <?= inc($i, 'finish_time', isset($r['finish_time']) ? $r['finish_time'] : '', 'time') ?>
                            <td class="ro"><?= h(cparts($r['culture1'])[0]) ?></td>
                            <?= inc($i, 'culture1_g', $r['culture1_g']) ?>
                            <td class="ro"><?= h(cparts($r['culture2'])[0]) ?></td>
                            <?= inc($i, 'culture2_g', $r['culture2_g']) ?>
                            <td class="ro"><?= h(cparts($r['culture3'])[0]) ?></td>
                            <?= inc($i, 'culture3_g', $r['culture3_g']) ?>
                            <td class="calc" id="f_ctot_<?= $i ?>"></td>
                            <td class="calc" id="f_total_<?= $i ?>"></td>
                            <td class="calc" id="f_target_pks_<?= $i ?>"></td>
                            <?= inc($i, 'actual_filling', $r['actual_filling']) ?>
                            <td class="calc" id="f_stock_cs_<?= $i ?>"></td>

                            <?php
                            if (intval($r['batch']) > 0) {
                                $bact = "block";
                            } else {
                                $bact = "none";
                            }


                            ?>

                            <td>
                                <div id="ccp<?= $i ?>" style="display:<?= $bact; ?>"><?php
                                                                                        if ($r['ccp'] == 'done') {
                                                                                            echo "<a class='btn-comp' href='../admin.php?id=yogurtmccp&rid=" . $r['id'] . "' title='Open check page'>✔ Completed</a>";
                                                                                        } else if ($r['ccp'] == 'waiting') {
                                                                                            echo "<a class='btn-wait' href='../admin.php?id=yogurtmccp&rid=" . $r['id'] . "' title='Open check page'>Attempt Another Checks</a>";
                                                                                        } else {
                                                                                            echo "<a class='btn-att' href='../admin.php?id=yogurtmccp&rid=" . $r['id'] . "' title='Open check page'>Attempt Check</a>";
                                                                                        }

                                                                                        ?></div>
                            </td>
                            <td>
                                <div id="wlbl<?= $i ?>" style="display:<?= $bact; ?>"><?php
                                                                                        if ($r['label'] == 'done') {
                                                                                            echo "<a class='btn-comp' href='../admin.php?id=yogurtmccp&rid=" . $r['id'] . "' title='Open check page'>✔ Completed</a>";
                                                                                        } else if ($r['label'] == 'waiting') {
                                                                                            echo "<a class='btn-wait' href='../admin.php?id=yogurtmlabel&rid=$r[id]' title='Open  check page'>Attempt Another Checks</a>";
                                                                                        } else {
                                                                                            echo "<a class='btn-att' href='../admin.php?id=yogurtmlabel&rid=$r[id]' title='Open  check page'>Attempt Check</a>";
                                                                                        }

                                                                                        ?></div>
                            </td>
                            <td>
                                <div id="wchk<?= $i ?>" style="display:<?= $bact; ?>"><?php
                                                                                        if ($r['weight'] == 'done') {
                                                                                            echo "<a class='btn-comp' href='../admin.php?id=yogurtmccp&rid=" . $r['id'] . "' title='Open check page'>✔ Completed</a>";
                                                                                        } else if ($r['weight'] == 'waiting') {
                                                                                            echo "<a class='btn-wait' href='../admin.php?id=yogurtmweight&rid=$r[id]' title='Open  check page'>Attempt Another Checks</a>";
                                                                                        } else {
                                                                                            echo "<a class='btn-att' href='../admin.php?id=yogurtmweight&rid=$r[id]' title='Open  check page'>Attempt Check</a>";
                                                                                        }

                                                                                        ?></div>
                            </td>






                            <!-- ★ NEW — Report column (opens the existing report page for this line) -->
                            <td>
                                <a class="btn-rep" href="../admin.php?id=yogurtmpdf&rid=<?= (int) $r['id'] ?>"
                                    title="Open report for this line">📄 Report</a>
                            </td>

                            <!-- goods-out section (blue) -->
                            <td class="mir sep-go" id="f_godesc_<?= $i ?>"></td>
                            <td class="mir" id="f_gokg_<?= $i ?>"></td>
                            <?= inc($i, 'cust1', $r['cust1']) ?> <?= inc($i, 'cust2', $r['cust2']) ?>
                            <?= inc($i, 'cust3', $r['cust3']) ?> <?= inc($i, 'cust4', $r['cust4']) ?>
                            <?= inc($i, 'cust5', $r['cust5']) ?>
                            <td class="calc" id="f_go_total_<?= $i ?>"></td>
                            <?= inc($i, 'adj', $r['adj']) ?>
                            <td class="calc" id="f_closing_stock_<?= $i ?>"></td>

                            <!-- packaging section (amber) -->
                            <?= inc($i, 'op_pots', $r['op_pots'], 'in sep-pk') ?>
                            <?= inc($i, 'op_lids', $r['op_lids']) ?>
                            <?= inc($i, 'op_foil', $r['op_foil']) ?>
                            <?= inc($i, 'op_trays', $r['op_trays']) ?>
                            <td class="mir" id="f_pkname_<?= $i ?>"></td>
                            <?= inc($i, 'used_pots', $r['used_pots'], 'semi') ?>
                            <?= inc($i, 'used_lids', $r['used_lids'], 'semi') ?>
                            <?= inc($i, 'used_foil', $r['used_foil'], 'semi') ?>
                            <?= inc($i, 'used_trays', $r['used_trays'], 'semi') ?>
                            <td class="calc" id="f_cl_pots_<?= $i ?>"></td>
                            <td class="calc" id="f_cl_lids_<?= $i ?>"></td>
                            <td class="calc" id="f_cl_foil_<?= $i ?>"></td>
                            <td class="calc" id="f_cl_trays_<?= $i ?>"></td>
                        </tr>
                    <?php endforeach;

                    if ($last !== null)
                        echo totalRow('TOTAL — Page ' . $last, $last);
                    echo totalRow('GRAND TOTAL', 0, true);
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- toast stack -->
    <div id="toasts"></div>

    <!-- SheetJS — builds the .xlsx file in the browser -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>


    <script>
        /* ================================================================
         * BLOCK 9 ▸ JS — DATA & HELPERS
         * ================================================================ */
        var DATE = <?= json_encode($date) ?>;
        var TODAY = <?= json_encode(date('Y-m-d')) ?>; // ★ NEW — latest date allowed
        var ROWS = <?= json_encode($rows) ?>;

        function num(v) {
            var x = parseFloat(v);
            return isNaN(x) ? 0 : x;
        }

        function r2(v) {
            return Math.round(v * 100) / 100;
        }

        function fmt(v) {
            v = r2(v);
            return v % 1 ? v.toFixed(2) : String(Math.round(v));
        }

        function setc(id, v) {
            var c = document.getElementById(id);
            if (c) {
                c.textContent = fmt(v);
                c.classList.toggle('neg', v < 0);
            }
        }

        function setStatus(t, cls) {
            var el = document.getElementById('st');
            el.textContent = t;
            el.className = cls || '';
        }

        function toast(msg, ok) {
            var t = document.createElement('div');
            t.className = 'toast ' + (ok ? 'ok' : 'err');
            t.textContent = msg;
            document.getElementById('toasts').appendChild(t);
            setTimeout(function() {
                t.classList.add('show');
            }, 10);
            setTimeout(function() {
                t.classList.remove('show');
                setTimeout(function() {
                    t.remove();
                }, 300);
            }, 2800);
        }

        var SUMK = ['op_stock', 'batch', 'cream', 'smp', 'milk', 'fruit', 'total', 'target_pks',
            'actual_filling', 'stock_cs', 'cust1', 'cust2', 'cust3', 'cust4', 'cust5',
            'go_total', 'adj', 'closing_stock', 'op_pots', 'op_lids', 'op_foil', 'op_trays',
            'used_pots', 'used_lids', 'used_foil', 'used_trays',
            'cl_pots', 'cl_lids', 'cl_foil', 'cl_trays'
        ];


        /* ================================================================
         * BLOCK 10 ▸ JS — EXCEL FORMULAS
         * Total        = Cream + SMP + Milk + Fruit
         * Pks target   = Total ÷ Kg
         * O/P Stock    = Op/Stk + Actual Filling
         * Despatch Ttl = 5 customers
         * Stock        = O/P − Despatch + Adj
         * Pkg Closing  = Opening − Used
         * ================================================================ */
        function milkqty(i) {
            var fmilk = document.getElementById('f_milk_' + i);

            var fcream = parseFloat(document.getElementById('f_cream_' + i).value) || 0;
            var fsmp = parseFloat(document.getElementById('f_smp_' + i).value) || 0;
            var ffruit = parseFloat(document.getElementById('f_fruit_' + i).value) || 0;
            var fbatch = parseFloat(document.getElementById('f_batch_' + i).value) || 0;

            var totalmilk = r2(fbatch - (fcream + fsmp + ffruit));

            fmilk.value = totalmilk; // show it in the box
            ROWS[i].milk = totalmilk; // ★ this is what gets saved to the DB

            calcRow(i); // refresh Total, Pks target, etc.
            calcTotals(); // refresh the footer totals
            markDirty(); // trigger auto-save
        }


        function calcRow(i) {
            var r = ROWS[i];
            r.total = r2(num(r.cream) + num(r.smp) + num(r.milk) + num(r.fruit));
            /* culture total = sum of the 3 grams cells (70g + 25g → 95) */
            r.culture_total_g = r2(num(r.culture1_g) + num(r.culture2_g) + num(r.culture3_g));
            var ce = document.getElementById('f_ctot_' + i);
            if (ce) ce.textContent = r.culture_total_g ? fmt(r.culture_total_g) : '';
            /* TRAYS = batch ÷ (kg × packs)   — f_kg_ and f_pks_ → f_target_pks_ */
            var kgEl = document.getElementById('f_kg_' + i),
                pksEl = document.getElementById('f_pks_' + i);
            var kgV = parseFloat(kgEl ? kgEl.value : r.kg),
                pksV = parseFloat(pksEl ? pksEl.value : r.pks);
            r.target_pks = (num(r.batch) > 0 && kgV > 0 && pksV > 0) ?
                Math.ceil(num(r.batch) / (kgV * pksV)) : 0;
            r.stock_cs = r2(num(r.op_stock) + num(r.actual_filling));
            r.go_total = r2(num(r.cust1) + num(r.cust2) + num(r.cust3) + num(r.cust4) + num(r.cust5));
            r.closing_stock = r2(num(r.stock_cs) - num(r.go_total) + num(r.adj));

            ['pots', 'lids', 'foil', 'trays'].forEach(function(m) {
                r['cl_' + m] = Math.round(num(r['op_' + m]) - num(r['used_' + m]));
                setc('f_cl_' + m + '_' + i, r['cl_' + m]);
            });
            setc('f_total_' + i, r.total);
            setc('f_target_pks_' + i, r.target_pks);

            setc('f_stock_cs_' + i, r.stock_cs);
            setc('f_go_total_' + i, r.go_total);
            setc('f_closing_stock_' + i, r.closing_stock);

            document.getElementById('f_godesc_' + i).textContent = r.description || '';
            document.getElementById('f_gokg_' + i).textContent = r.kg || '';
            document.getElementById('f_pkname_' + i).textContent = r.description || '';
        }

        /* Cream/SMP/Fruit = Batch × %   ·   Milk = Batch − Cream − SMP */
        function applyRecipe(i) {
            var r = ROWS[i],
                b = num(r.batch);
            r.cream = r2(b * num(r.cream_pct) / 100);
            r.smp = r2(b * num(r.smp_pct) / 100);
            r.fruit = r2(b * num(r.fruit_pct) / 100);
            r.milk = r2(b - r.cream - r.smp);
            ['cream', 'smp', 'milk', 'fruit'].forEach(function(k) {
                if (INP[i][k]) INP[i][k].value = r[k];
            });
        }

        /* ★ NEW — base yogurt batch from its linked flavours.
         * Rows whose yogurt1.base_id points at a base (58 Strawberry, 59 Raspberry,
         * 60 Cherry, 61 Peach → base 22 "VLF Fruit Yogurt 110g x 12"):
         *   sum  = Batch58 + Batch59 + Batch60 + Batch61
         *   base Batch = sum − 16% of sum
         * Runs whenever any one of the linked rows' Batch changes. */
        var BASE_PCT = 16;

        function syncBase(i) {
            var bid = +ROWS[i].base_id;
            if (!(bid > 0)) return; // not a linked row
            var sum = 0,
                bi = -1;
            ROWS.forEach(function(r, j) {
                if (+r.base_id === bid) sum += num(r.batch);
                if (+r.product_id === bid) bi = j;
            });
            if (bi < 0) return; // base row not on this sheet
            var v = r2(sum - (sum * BASE_PCT / 100)); // sum minus 16% of sum
            ROWS[bi].batch = v;
            if (INP[bi] && INP[bi].batch) INP[bi].batch.value = v;
            applyRecipe(bi); // cream/SMP/milk/fruit follow the new batch
            calcRow(bi);
            jako(bi, v); // show/hide its check buttons
        }

        /* page totals + grand total + KPIs */
        function calcTotals() {
            var P = {},
                G = {};
            SUMK.forEach(function(k) {
                G[k] = 0;
            });

            ROWS.forEach(function(r) {
                var p = r.page_no || 1;
                P[p] = P[p] || {};
                SUMK.forEach(function(k) {
                    P[p][k] = (P[p][k] || 0) + num(r[k]);
                    G[k] += num(r[k]);
                });
            });
            Object.keys(P).forEach(function(p) {
                SUMK.forEach(function(k) {
                    var c = document.getElementById('p' + p + '_' + k);
                    if (c) {
                        c.textContent = fmt(P[p][k]);
                        c.classList.toggle('neg', P[p][k] < 0);
                    }
                });
            });
            SUMK.forEach(function(k) {
                var c = document.getElementById('g_' + k);
                if (c) {
                    c.textContent = fmt(G[k]);
                    c.classList.toggle('neg', G[k] < 0);
                }
            });
            document.getElementById('kpi_total').textContent = fmt(G.total);
            document.getElementById('kpi_go').textContent = fmt(G.go_total);
            document.getElementById('kpi_stock').textContent = fmt(G.closing_stock);
        }


        /* ================================================================
         * BLOCK 11 ▸ JS — INPUTS & KEYBOARD (Excel-like feel)
         * ================================================================ */
        var INP = {},
            saveT = null,
            dirtyFlag = false;

        document.querySelectorAll('.ci').forEach(function(inp) {
            var i = inp.dataset.i,
                k = inp.dataset.k;
            INP[i] = INP[i] || {};
            INP[i][k] = inp;

            inp.addEventListener('input', function() {
                ROWS[i][k] = inp.value;

                if (k == 'batch') {
                    applyRecipe(i);
                    syncBase(i); // ★ NEW — update the base row's batch
                }

                if (k == 'actual_filling') {
                    ROWS[i].used_pots = inp.value;
                    ROWS[i].used_lids = inp.value;
                    if (INP[i].used_pots) INP[i].used_pots.value = inp.value;
                    if (INP[i].used_lids) INP[i].used_lids.value = inp.value;
                }
                calcRow(i);
                calcTotals();
                markDirty();
            });

            inp.addEventListener('focus', function() {
                inp.select();
                var tr = inp.closest('tr');
                if (tr) tr.classList.add('row-focus');
            });
            inp.addEventListener('blur', function() {
                var tr = inp.closest('tr');
                if (tr) tr.classList.remove('row-focus');
            });

            inp.addEventListener('keydown', function(e) {
                if (e.key == 'Enter' || e.key == 'ArrowDown') {
                    e.preventDefault();
                    if (INP[+i + 1] && INP[+i + 1][k]) INP[+i + 1][k].focus();
                }
                if (e.key == 'ArrowUp') {
                    e.preventDefault();
                    if (INP[i - 1] && INP[i - 1][k]) INP[i - 1][k].focus();
                }
            });
        });

        function jako(a, b) {
            const ccp = document.getElementById('ccp' + a);
            const wchk = document.getElementById('wchk' + a);
            const wlbl = document.getElementById('wlbl' + a);

            /* check buttons only show when batch > 0 (trays are calculated in calcRow) */
            if (b > 0) {
                ccp.style.display = "block";
                wchk.style.display = "block";
                wlbl.style.display = "block";
            } else {
                ccp.style.display = "none";
                wchk.style.display = "none";
                wlbl.style.display = "none";
            }
        }

        /* date navigation with unsaved guard */
        function gotoDate(d) {
            if (!d) return;
            /* ★ NEW — future dates are blocked */
            if (d > TODAY) {
                if (typeof toast === 'function') toast('Future dates are not allowed', 'err');
                var di = document.querySelector('.dinput');
                if (di) di.value = DATE;
                return;
            }
            if (dirtyFlag && !confirm('You have unsaved changes.\nLeave anyway?')) return;
            location.href = '?date=' + d;
        }

        function stepDate(n) {
            var d = new Date(DATE);
            d.setDate(d.getDate() + n);
            gotoDate(d.toISOString().slice(0, 10));
        }


        /* ================================================================
         * BLOCK 12 ▸ JS — AJAX (auto-save + carry forward)
         * ================================================================ */
        function markDirty() {
            dirtyFlag = true;
            setStatus('● unsaved changes…', 'dirty');
            clearTimeout(saveT);
            saveT = setTimeout(save, 2000);
        }

        function save() {
            clearTimeout(saveT);
            setStatus('Saving…');
            fetch('?action=save', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        date: DATE,
                        rows: ROWS
                    })
                })
                .then(function(r) {
                    return r.json();
                })
                .then(function(j) {
                    if (j.ok) {
                        dirtyFlag = false;
                        setStatus('✓ Saved ' + new Date().toLocaleTimeString());
                        toast('💾 Sheet saved successfully', true);


                    } else {
                        setStatus('⚠ Save failed');
                        toast('⚠ Save failed — please retry', false);
                    }
                })
                .catch(function() {
                    setStatus('⚠ Save failed');
                    toast('⚠ Network error while saving', false);
                });
        }

        function carry() {
            fetch('?action=prev&date=' + DATE)
                .then(function(r) {
                    return r.json();
                })
                .then(function(j) {
                    if (!j.ok) {
                        toast('No previous saved sheet found', false);
                        return;
                    }
                    if (!confirm('Copy each product\'s closing stock & packaging from its last production day\n(latest: ' + j.date + ')\ninto today\'s opening stock?')) return;

                    ROWS.forEach(function(r, i) {
                        var p = j.rows[r.product_id];
                        if (!p) return;
                        r.op_stock = p.stock;
                        r.op_pots = p.pots;
                        r.op_lids = p.lids;
                        r.op_foil = p.foil;
                        r.op_trays = p.trays;
                        ['op_stock', 'op_pots', 'op_lids', 'op_foil', 'op_trays'].forEach(function(k) {
                            if (INP[i][k]) INP[i][k].value = r[k];
                        });
                        calcRow(i);
                    });
                    calcTotals();
                    markDirty();
                    toast('⟲ Opening stock copied from ' + j.date, true);
                });
        }


        /* ================================================================
         * BLOCK 12b ★ NEW ▸ JS — SAVE AS EXCEL (.xlsx)
         * Exports exactly what is on screen: typed values, formula results,
         * page totals, grand total, CCP / Label / Weight status, and the
         * Weekly Plan table (2nd sheet). Runs fully in the browser.
         * ================================================================ */
        var COLW = <?= json_encode($widths) ?>; // column widths (px) from PHP

        /** Copy a live <table> and turn every <input> into plain text. */
        function tableForExcel(live) {
            var copy = live.cloneNode(true);
            var colg = copy.querySelector('colgroup');
            if (colg) colg.remove();

            /* inputs: read the LIVE value (clone order == live order) */
            var liveIn = live.querySelectorAll('input');
            copy.querySelectorAll('input').forEach(function(el, n) {
                el.replaceWith(document.createTextNode(liveIn[n] ? liveIn[n].value : ''));
            });

            /* CCP / Label / Weight buttons → status words; hidden ones → empty */
            copy.querySelectorAll('td > div[id^="ccp"], td > div[id^="wlbl"], td > div[id^="wchk"]').forEach(function(d) {
                var txt = '';
                if (d.style.display !== 'none') {
                    if (d.querySelector('.btn-comp')) txt = 'Completed';
                    else if (d.querySelector('.btn-wait')) txt = 'Waiting';
                    else if (d.querySelector('.btn-att')) txt = 'Pending';
                }
                d.replaceWith(document.createTextNode(txt));
            });
            return copy;
        }

        /** numeric-looking text → real numbers so Excel can add them up */
        function numberise(ws) {
            Object.keys(ws).forEach(function(a) {
                if (a[0] === '!') return;
                var c = ws[a];
                if (c.t === 's' && /^-?\d+(\.\d+)?$/.test(String(c.v).trim())) {
                    c.t = 'n';
                    c.v = Number(c.v);
                    delete c.w;
                }
            });
        }

        /* ================================================================
         * ★ CHANGED exportExcel() —
         *   1. Exports ONLY the production table (weekly plan excluded)
         *   2. Header rows are BOLD + coloured so they stand out in Excel
         * ================================================================ */
        function exportExcel() {

            /* 1 ▸ production table only — it lives inside .card */
            const src = document.querySelector('.card table');
            if (!src) {
                if (typeof toast === 'function') toast('Nothing to export', 'err');
                return;
            }

            const t = src.cloneNode(true); // work on a copy

            /* 2 ▸ every <input> → its current value as plain text */
            t.querySelectorAll('input').forEach(inp => {
                const td = inp.closest('td');
                if (td) td.textContent = inp.value;
            });

            /* 3 ▸ remove action buttons/links (CCP "Attempt Check" etc.) */
            t.querySelectorAll('button, .btn-att, .btn-comp, .btn-wait, .btn-rep').forEach(el => el.remove());

            /* 4 ▸ helper — paint a cell with inline styles (Excel reads these) */
            const paint = (td, bg, col, bold, left) => {
                td.style.backgroundColor = bg;
                td.style.color = col;
                td.style.fontWeight = bold ? 'bold' : 'normal';
                td.style.textAlign = left ? 'left' : 'center';
                td.style.border = '1px solid #9ab3a4';
                td.style.verticalAlign = 'middle';
            };

            /* 5 ▸ HEADERS — bold + background colour ★ */
            t.querySelectorAll('tr.h1 th') // top banner row
                .forEach(th => paint(th, '#1d6741', '#ffffff', true));

            t.querySelectorAll('tr.h2 th').forEach(th => { // column title row
                if (th.classList.contains('sec-go')) paint(th, '#d7e7f8', '#0d47a1', true); // goods-out = blue
                else if (th.classList.contains('sec-pk')) paint(th, '#fce8c8', '#8a5200', true); // packaging = amber
                else paint(th, '#d9ebdf', '#1d4b30', true); // production = green
            });

            /* 6 ▸ body cells — keep the colour language of the web sheet */
            t.querySelectorAll('tbody td').forEach(td => {
                if (td.closest('tr.trow')) return; // totals handled below
                if (td.classList.contains('rn')) paint(td, '#eef3ef', '#9aa89f', true);
                else if (td.classList.contains('desc')) paint(td, '#fbfdfc', '#20332a', false, true);
                else paint(td, '#ffffff', '#22312a', false);
            });

            /* 7 ▸ TOTAL rows — bold, green / darker green for grand total */
            t.querySelectorAll('tr.trow td').forEach(td => {
                const grand = td.closest('tr').classList.contains('grand');
                paint(td, grand ? '#c2e0cc' : '#dceee3', '#14432a', true,
                    td.classList.contains('lbl'));
            });

            /* 8 ▸ wrap in an Excel-compatible HTML document */
            const html =
                '<html xmlns:x="urn:schemas-microsoft-com:office:excel">' +
                '<head><meta charset="utf-8">' +
                '<!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets>' +
                '<x:ExcelWorksheet><x:Name>Production</x:Name>' +
                '<x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions>' +
                '</x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]-->' +
                '<style>table{border-collapse:collapse}' +
                'td,th{padding:2px 4px;font-family:Calibri,Arial,sans-serif;font-size:11px}' +
                '</style></head><body>' +
                '<table border="1">' + t.innerHTML + '</table>' +
                '</body></html>';

            /* 9 ▸ download as .xls */
            const d = (document.querySelector('input[type="date"]') || {}).value || 'sheet';
            const blob = new Blob(['\ufeff' + html], {
                type: 'application/vnd.ms-excel;charset=utf-8'
            });
            const a = document.createElement('a');
            a.href = URL.createObjectURL(blob);
            a.download = 'Yogurt_Production_' + d + '.xls';
            document.body.appendChild(a);
            a.click();
            a.remove();
            setTimeout(() => URL.revokeObjectURL(a.href), 4000);

            if (typeof toast === 'function') toast('Excel saved — production table only');
        }


        /* ================================================================
         * BLOCK 13 ▸ JS — INIT + RESPONSIVE STICKY SYNC
         * ================================================================ */
        ROWS.forEach(function(r, i) {
            calcRow(i);
        }); // first paint of formulas
        calcTotals();

        /* ── ★ NEW — syncSticky() ────────────────────────────────────────
         * Because the table now STRETCHES to fill wide screens (width:100%),
         * the frozen-column offsets can no longer be hardcoded (36px / 92px).
         * So we MEASURE the real positions of the Op/Stk and Description
         * cells and write them into CSS variables. Runs on load, resize,
         * orientation change and after fonts load → frozen panes stay
         * perfectly aligned at every screen size.                          */
        function syncSticky() {
            /* ★ scoped to the MAIN sheet (.wrap) — the plan strip above has its own table */
            var tr = document.querySelector('.wrap tbody tr'); // first data row
            var th = document.querySelector('.wrap tr.h1 th'); // banner header cell
            if (!tr || !th) return;

            var s = document.documentElement.style;
            /* Widths of the cells before each frozen column. offsetWidth is not
             * affected by scrolling or sticky movement (getBoundingClientRect is). */
            var off1 = tr.cells[0].offsetWidth; // "#" column
            var off2 = off1 + tr.cells[1].offsetWidth; // + Op/Stk column
            s.setProperty('--off1', off1 + 'px');
            s.setProperty('--off2', off2 + 'px');
            s.setProperty('--h1h', th.offsetHeight + 'px'); // banner row height
        }

        syncSticky(); // initial measure
        window.addEventListener('resize', syncSticky); // re-measure on resize
        window.addEventListener('orientationchange', function() { // and on rotate
            setTimeout(syncSticky, 150);
        });
        if (document.fonts && document.fonts.ready) // font swap can
            document.fonts.ready.then(syncSticky); // change widths

        /* Ctrl+S = save */
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() == 's') {
                e.preventDefault();
                save();
            }
        });

        /* warn before leaving with unsaved edits */
        window.addEventListener('beforeunload', function(e) {
            if (dirtyFlag) {
                e.preventDefault();
                e.returnValue = '';
            }
        });
    </script>
</body>

</html>