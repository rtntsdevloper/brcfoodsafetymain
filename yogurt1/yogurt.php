<?php
include "../connection.php";

$action = isset($_GET['action']) ? $_GET['action'] : '';


/* ================================================================
 * BLOCK 2 ▸ AJAX — SAVE SHEET  (?action=save)
 * Delete-all + re-insert for that date. Only typed columns are
 * stored; formula columns always recalc in the browser (Excel-like).
 * ================================================================ */
if ($action === 'save') {
    header('Content-Type: application/json');

    $in = json_decode(file_get_contents('php://input'), true);
    $date = mysqli_real_escape_string($con, isset($in['date']) ? $in['date'] : '');
    if (!$date) {
        echo json_encode(['ok' => false]);
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
        'used_trays'
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
        'used_trays'
    ];

    mysqli_query($con, "DELETE FROM yogurt_records WHERE rdate='$date'");

    foreach ($in['rows'] as $r) {
        $vals = [];
        foreach ($cols as $c) {
            $v = isset($r[$c]) ? $r[$c] : '';
            $vals[] = in_array($c, $nums)
                ? (float) $v
                : "'" . mysqli_real_escape_string($con, (string) $v) . "'";
        }
        mysqli_query($con, "INSERT INTO yogurt_records (rdate," . implode(',', $cols) . ")
                            VALUES ('$date'," . implode(',', $vals) . ")");
    }
    echo json_encode(['ok' => true]);
    exit;
}


/* ================================================================
 * BLOCK 3 ▸ AJAX — PREVIOUS DAY  (?action=prev&date=YYYY-MM-DD)
 * Returns previous sheet's closing stock + packaging per product,
 * so the browser can copy them into today's opening cells.
 * ================================================================ */
if ($action === 'prev') {
    header('Content-Type: application/json');

    $date = mysqli_real_escape_string($con, isset($_GET['date']) ? $_GET['date'] : '');
    $p = mysqli_fetch_assoc(mysqli_query(
        $con,
        "SELECT MAX(rdate) d FROM yogurt_records WHERE rdate < '$date'"
    ));
    if (!$p['d']) {
        echo json_encode(['ok' => false]);
        exit;
    }

    $q = mysqli_query($con, "SELECT * FROM yogurt_records WHERE rdate='" . $p['d'] . "'");
    $out = [];
    while ($r = mysqli_fetch_assoc($q)) {
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

/* --- 4.1 validate date (default = today) --- */
$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date))
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

/* --- 4.3 fetch rows joined with recipe % from product master --- */
$rows = [];
$q = mysqli_query($con, "SELECT r.*, y.cream_pct, y.smp_pct, y.fruit_pct, y.cultures
        FROM yogurt_records r
        LEFT JOIN yogurt1 y ON y.id = r.product_id
        WHERE r.rdate='$date' ORDER BY r.id");
while ($r = mysqli_fetch_assoc($q))
    $rows[] = $r;

/* --- 4.4 header info — same rules as the Excel file --- */
$day = date('l d M Y', strtotime($date));
$batch = date('ymd', strtotime($date));                 // Batch No = YYMMDD
$bb = date('d/m/y', strtotime($date . ' +30 days'));   // Best Before = +30 days


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
    return "<td class='$cls'><input class='ci' data-i='$i' data-k='$k' value=\"" . h($v) . "\"></td>";
}

/** TOTAL / GRAND TOTAL row. ids: p{page}_{key} | g_{key} (JS fills them). */
function totalRow($label, $p, $grand = false)
{
    $pre = $grand ? 'g_' : 'p' . $p . '_';
    $c = [];
    $c[] = "<td class='rn'></td>";
    $c[] = "<td id='{$pre}op_stock' class='fz1'></td>";
    $c[] = "<td colspan='3' class='lbl fz2'>$label</td>";
    $c[] = "<td id='{$pre}batch'></td>";
    foreach (['cream', 'smp', 'milk', 'fruit', 'total', 'target_pks', 'actual_filling', 'stock_cs'] as $k)
        $c[] = "<td id='{$pre}{$k}'></td>";
    $c[] = "<td colspan='2' class='sep-go'></td>";
    foreach (['cust1', 'cust2', 'cust3', 'cust4', 'cust5', 'go_total', 'adj', 'closing_stock'] as $k)
        $c[] = "<td id='{$pre}{$k}'></td>";
    $c[] = "<td id='{$pre}op_pots' class='sep-pk'></td>";
    foreach (['op_lids', 'op_foil', 'op_trays'] as $k)
        $c[] = "<td id='{$pre}{$k}'></td>";
    $c[] = "<td></td>";
    foreach ([
        'used_pots',
        'used_lids',
        'used_foil',
        'used_trays',
        'cl_pots',
        'cl_lids',
        'cl_foil',
        'cl_trays'
    ] as $k)
        $c[] = "<td id='{$pre}{$k}'></td>";
    return "<tr class='trow" . ($grand ? ' grand' : '') . "'>" . implode('', $c) . "</tr>";
}

/* ── column widths (37 cols) ─────────────────────────────────────
 * ★ CHANGED: we now also compute the TOTAL width → used as the
 *   table's min-width. Result: table always fills the card when
 *   there is room, and scrolls left↔right only when overflowing. */
$widths = [
    /* #   OpStk Desc   Kg  Pks Batch | Crm SMP Milk Frt Ttl Pks Fill OPStk */
    36,
    56,
    185,
    46,
    40,
    58,
    56,
    56,
    56,
    56,
    56,
    52,
    62,
    58,
    /* GDescription Kg | c1  c2  c3  c4  c5  Ttl Adj Stk */
    150,
    44,
    56,
    56,
    56,
    56,
    56,
    54,
    50,
    56,
    /* P L F T | Name | uP uL uF uT | cP cL cF cT */
    46,
    46,
    46,
    46,
    140,
    46,
    46,
    46,
    46,
    46,
    46,
    46,
    46
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
    <title>🥛 Yogurt Production Records — <?= h($date) ?></title>

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
            letter-spacing: .4px;
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
    </header>

    <!-- toolbar: date navigation · actions · live KPIs -->
    <div class="toolbar">
        <button class="navbtn" title="Previous day" onclick="stepDate(-1)">◀</button>
        <input class="dinput" type="date" value="<?= h($date) ?>" onchange="gotoDate(this.value)">
        <button class="navbtn" title="Next day" onclick="stepDate(1)">▶</button>

        <button class="btn" onclick="carry()" title="Copy previous day's closing stock to opening">⟲
            Carry&nbsp;Forward</button>
        <button class="btn btn-save" onclick="save()" title="Ctrl+S">💾 Save</button>
        <button class="btn" onclick="window.print()">🖨 Print</button>

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
                        <th rowspan="2" class="crn">#</th>
                        <th colspan="13">Quantities for Yogurt Planning</th>
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
                        <th>Milk</th>
                        <th>Fruit</th>
                        <th>Total</th>
                        <th>Pks</th>
                        <th>Actual Filling</th>
                        <th>O/P Stock</th>

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
                            <td class="ro desc fz2" title="Cultures: <?= h($r['cultures']) ?>"><?= h($r['description']) ?>
                            </td>

                            <!-- planning section (green) -->
                            <td class="ro"><?= h($r['kg']) ?></td>
                            <td class="ro"><?= h($r['pks']) ?></td>
                            <?= inc($i, 'batch', $r['batch']) ?>
                            <?= inc($i, 'cream', $r['cream'], 'semi') ?>
                            <?= inc($i, 'smp', $r['smp'], 'semi') ?>
                            <?= inc($i, 'milk', $r['milk'], 'semi') ?>
                            <?= inc($i, 'fruit', $r['fruit'], 'semi') ?>
                            <td class="calc" id="f_total_<?= $i ?>"></td>
                            <td class="calc" id="f_target_pks_<?= $i ?>"></td>
                            <?= inc($i, 'actual_filling', $r['actual_filling']) ?>
                            <td class="calc" id="f_stock_cs_<?= $i ?>"></td>

                            <!-- goods-out section (blue) -->
                            <td class="mir sep-go" id="f_godesc_<?= $i ?>"></td>
                            <td class="mir" id="f_gokg_<?= $i ?>"></td>
                            <?= inc($i, 'cust1', $r['cust1']) ?>    <?= inc($i, 'cust2', $r['cust2']) ?>
                            <?= inc($i, 'cust3', $r['cust3']) ?>    <?= inc($i, 'cust4', $r['cust4']) ?>
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


    <script>
        /* ================================================================
         * BLOCK 9 ▸ JS — DATA & HELPERS
         * ================================================================ */
        var DATE = <?= json_encode($date) ?>;
        var ROWS = <?= json_encode($rows) ?>;

        function num(v) { var x = parseFloat(v); return isNaN(x) ? 0 : x; }
        function r2(v) { return Math.round(v * 100) / 100; }
        function fmt(v) { v = r2(v); return v % 1 ? v.toFixed(2) : String(Math.round(v)); }
        function setc(id, v) {
            var c = document.getElementById(id);
            if (c) { c.textContent = fmt(v); c.classList.toggle('neg', v < 0); }
        }
        function setStatus(t, cls) {
            var el = document.getElementById('st');
            el.textContent = t; el.className = cls || '';
        }
        function toast(msg, ok) {
            var t = document.createElement('div');
            t.className = 'toast ' + (ok ? 'ok' : 'err');
            t.textContent = msg;
            document.getElementById('toasts').appendChild(t);
            setTimeout(function () { t.classList.add('show'); }, 10);
            setTimeout(function () {
                t.classList.remove('show');
                setTimeout(function () { t.remove(); }, 300);
            }, 2800);
        }

        var SUMK = ['op_stock', 'batch', 'cream', 'smp', 'milk', 'fruit', 'total', 'target_pks',
            'actual_filling', 'stock_cs', 'cust1', 'cust2', 'cust3', 'cust4', 'cust5',
            'go_total', 'adj', 'closing_stock', 'op_pots', 'op_lids', 'op_foil', 'op_trays',
            'used_pots', 'used_lids', 'used_foil', 'used_trays',
            'cl_pots', 'cl_lids', 'cl_foil', 'cl_trays'];


        /* ================================================================
         * BLOCK 10 ▸ JS — EXCEL FORMULAS
         * Total        = Cream + SMP + Milk + Fruit
         * Pks target   = Total ÷ Kg
         * O/P Stock    = Op/Stk + Actual Filling
         * Despatch Ttl = 5 customers
         * Stock        = O/P − Despatch + Adj
         * Pkg Closing  = Opening − Used
         * ================================================================ */
        function calcRow(i) {
            var r = ROWS[i];
            r.total = r2(num(r.cream) + num(r.smp) + num(r.milk) + num(r.fruit));
            var kg = parseFloat(r.kg);
            r.target_pks = kg ? r2(num(r.total) / kg) : 0;
            r.stock_cs = r2(num(r.op_stock) + num(r.actual_filling));
            r.go_total = r2(num(r.cust1) + num(r.cust2) + num(r.cust3) + num(r.cust4) + num(r.cust5));
            r.closing_stock = r2(num(r.stock_cs) - num(r.go_total) + num(r.adj));

            ['pots', 'lids', 'foil', 'trays'].forEach(function (m) {
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
            var r = ROWS[i], b = num(r.batch);
            r.cream = r2(b * num(r.cream_pct) / 100);
            r.smp = r2(b * num(r.smp_pct) / 100);
            r.fruit = r2(b * num(r.fruit_pct) / 100);
            r.milk = r2(b - r.cream - r.smp);
            ['cream', 'smp', 'milk', 'fruit'].forEach(function (k) {
                if (INP[i][k]) INP[i][k].value = r[k];
            });
        }

        /* page totals + grand total + KPIs */
        function calcTotals() {
            var P = {}, G = {};
            SUMK.forEach(function (k) { G[k] = 0; });

            ROWS.forEach(function (r) {
                var p = r.page_no || 1;
                P[p] = P[p] || {};
                SUMK.forEach(function (k) {
                    P[p][k] = (P[p][k] || 0) + num(r[k]);
                    G[k] += num(r[k]);
                });
            });
            Object.keys(P).forEach(function (p) {
                SUMK.forEach(function (k) {
                    var c = document.getElementById('p' + p + '_' + k);
                    if (c) { c.textContent = fmt(P[p][k]); c.classList.toggle('neg', P[p][k] < 0); }
                });
            });
            SUMK.forEach(function (k) {
                var c = document.getElementById('g_' + k);
                if (c) { c.textContent = fmt(G[k]); c.classList.toggle('neg', G[k] < 0); }
            });
            document.getElementById('kpi_total').textContent = fmt(G.total);
            document.getElementById('kpi_go').textContent = fmt(G.go_total);
            document.getElementById('kpi_stock').textContent = fmt(G.closing_stock);
        }


        /* ================================================================
         * BLOCK 11 ▸ JS — INPUTS & KEYBOARD (Excel-like feel)
         * ================================================================ */
        var INP = {}, saveT = null, dirtyFlag = false;

        document.querySelectorAll('.ci').forEach(function (inp) {
            var i = inp.dataset.i, k = inp.dataset.k;
            INP[i] = INP[i] || {}; INP[i][k] = inp;

            inp.addEventListener('input', function () {
                ROWS[i][k] = inp.value;

                if (k == 'batch') applyRecipe(i);

                if (k == 'actual_filling') {
                    ROWS[i].used_pots = inp.value;
                    ROWS[i].used_lids = inp.value;
                    if (INP[i].used_pots) INP[i].used_pots.value = inp.value;
                    if (INP[i].used_lids) INP[i].used_lids.value = inp.value;
                }
                calcRow(i); calcTotals(); markDirty();
            });

            inp.addEventListener('focus', function () {
                inp.select();
                var tr = inp.closest('tr');
                if (tr) tr.classList.add('row-focus');
            });
            inp.addEventListener('blur', function () {
                var tr = inp.closest('tr');
                if (tr) tr.classList.remove('row-focus');
            });

            inp.addEventListener('keydown', function (e) {
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

        /* date navigation with unsaved guard */
        function gotoDate(d) {
            if (!d) return;
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
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ date: DATE, rows: ROWS })
            })
                .then(function (r) { return r.json(); })
                .then(function (j) {
                    if (j.ok) {
                        dirtyFlag = false;
                        setStatus('✓ Saved ' + new Date().toLocaleTimeString());
                        toast('💾 Sheet saved successfully', true);
                    } else {
                        setStatus('⚠ Save failed');
                        toast('⚠ Save failed — please retry', false);
                    }
                })
                .catch(function () {
                    setStatus('⚠ Save failed');
                    toast('⚠ Network error while saving', false);
                });
        }

        function carry() {
            fetch('?action=prev&date=' + DATE)
                .then(function (r) { return r.json(); })
                .then(function (j) {
                    if (!j.ok) { toast('No previous saved sheet found', false); return; }
                    if (!confirm('Copy closing stock from ' + j.date + '\ninto today\'s opening stock?')) return;

                    ROWS.forEach(function (r, i) {
                        var p = j.rows[r.product_id];
                        if (!p) return;
                        r.op_stock = p.stock; r.op_pots = p.pots;
                        r.op_lids = p.lids; r.op_foil = p.foil;
                        r.op_trays = p.trays;
                        ['op_stock', 'op_pots', 'op_lids', 'op_foil', 'op_trays'].forEach(function (k) {
                            if (INP[i][k]) INP[i][k].value = r[k];
                        });
                        calcRow(i);
                    });
                    calcTotals(); markDirty();
                    toast('⟲ Opening stock copied from ' + j.date, true);
                });
        }


        /* ================================================================
         * BLOCK 13 ▸ JS — INIT + RESPONSIVE STICKY SYNC
         * ================================================================ */
        ROWS.forEach(function (r, i) { calcRow(i); });   // first paint of formulas
        calcTotals();

        /* ── ★ NEW — syncSticky() ────────────────────────────────────────
         * Because the table now STRETCHES to fill wide screens (width:100%),
         * the frozen-column offsets can no longer be hardcoded (36px / 92px).
         * So we MEASURE the real positions of the Op/Stk and Description
         * cells and write them into CSS variables. Runs on load, resize,
         * orientation change and after fonts load → frozen panes stay
         * perfectly aligned at every screen size.                          */
        function syncSticky() {
            var tr = document.querySelector('tbody tr');   // first data row
            var th = document.querySelector('tr.h1 th');   // banner header cell
            var tbl = document.querySelector('table');
            if (!tr || !th || !tbl) return;

            var base = tbl.getBoundingClientRect().left;    // table's left edge
            var s = document.documentElement.style;

            /* Op/Stk cell (cells[1]) and Description cell (cells[2]) */
            s.setProperty('--off1', (tr.cells[1].getBoundingClientRect().left - base) + 'px');
            s.setProperty('--off2', (tr.cells[2].getBoundingClientRect().left - base) + 'px');
            s.setProperty('--h1h', th.offsetHeight + 'px');   // banner row height
        }

        syncSticky();                                       // initial measure
        window.addEventListener('resize', syncSticky);              // re-measure on resize
        window.addEventListener('orientationchange', function () {    // and on rotate
            setTimeout(syncSticky, 150);
        });
        if (document.fonts && document.fonts.ready)                 // font swap can
            document.fonts.ready.then(syncSticky);                  // change widths

        /* Ctrl+S = save */
        document.addEventListener('keydown', function (e) {
            if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() == 's') {
                e.preventDefault(); save();
            }
        });

        /* warn before leaving with unsaved edits */
        window.addEventListener('beforeunload', function (e) {
            if (dirtyFlag) { e.preventDefault(); e.returnValue = ''; }
        });
    </script>
</body>

</html>