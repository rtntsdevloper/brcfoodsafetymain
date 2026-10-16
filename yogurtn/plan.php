<?php

include "../connection.php";      // same connection ($con) as yogurt.php


$NEWCOLS = array(
    'tank_am'        => "VARCHAR(20) NULL",
    'tank_pm'        => "VARCHAR(20) NULL",
    'finish_time'    => "TIME NULL",
    'batch_code'     => "VARCHAR(20) NULL",
    'best_before'    => "DATE NULL",
    'actual_filling' => "DECIMAL(12,2) NOT NULL DEFAULT 0",
    'op_total'       => "DECIMAL(12,2) NOT NULL DEFAULT 0",
    'manual_fields'  => "VARCHAR(255) NULL",     // list of cells typed by hand
);
foreach ($NEWCOLS as $col => $def) {
    $c = mysqli_query($con, "SHOW COLUMNS FROM yogurt_plan LIKE '$col'");
    if ($c && mysqli_num_rows($c) == 0)
        mysqli_query($con, "ALTER TABLE yogurt_plan ADD COLUMN `$col` $def");
}

/* --- 2. Friday of the chosen date (Sat/Sun → next Friday) --- */
$in = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $in) || !strtotime($in))
    $in = date('Y-m-d');
$ts  = strtotime($in);
$dow = (int) date('N', $ts);
$fri = ($dow <= 5) ? strtotime('+' . (5 - $dow) . ' days', $ts)
    : strtotime('+' . (12 - $dow) . ' days', $ts);
$friday  = date('Y-m-d', $fri);
$mon     = strtotime('+3 days', $fri);
$nextFri = strtotime('+7 days', $fri);

/* Excel header: Batch No. = yymmdd of the Friday · BB = Friday + 30 days */
$defBatchCode = date('ymd', $fri);
$defBestBefore = date('Y-m-d', strtotime('+30 days', $fri));

/* --- 3. products (with recipe %) + saved plan --- */
$products = array();
$q = mysqli_query($con, "SELECT id, page_no, description, kg, pks, cream_pct, smp_pct, fruit_pct,
                                culture1, culture2, culture3
                         FROM yogurt1 ORDER BY page_no, sort_order, id");
while ($r = mysqli_fetch_assoc($q))
    $products[] = $r;

$plan = array();      // saved batch per product
$cq   = array();      // saved grams text per product: $cq[id][1..3]
$sv   = array();      // whole saved row per product
$q = mysqli_query($con, "SELECT * FROM yogurt_plan WHERE week_friday='$friday'");
if ($q)
    while ($r = mysqli_fetch_assoc($q)) {
        $sv[$r['product_id']]   = $r;
        $plan[$r['product_id']] = (float) $r['batch'];
        $cq[$r['product_id']]   = array(1 => $r['culture1_g'], 2 => $r['culture2_g'], 3 => $r['culture3_g']);
    }

/* JS key → DB column (the cells that can be typed over) */
$MAP = array(
    'cream' => 'cream',
    'smp' => 'smp',
    'milk' => 'milk',
    'fruit' => 'fruit',
    'total' => 'total',
    'tpks' => 'target_pks',
    'optot' => 'op_total',
    'stk' => 'op_stock',
    'more' => 'required_pks',
    'rq_pots' => 'req_pots',
    'rq_lids' => 'req_lids',
    'rq_foil' => 'req_foil',
    'rq_trays' => 'req_trays',
    'st_pots' => 'stock_pots',
    'st_lids' => 'stock_lids',
    'st_foil' => 'stock_foil',
    'st_trays' => 'stock_trays',
    'mr_pots' => 'more_pots',
    'mr_lids' => 'more_lids',
    'mr_foil' => 'more_foil',
    'mr_trays' => 'more_trays',
);

/* --- 3b. packaging ratios (same as Excel "Daily Used Materials") ---
 * Excel: Pots / Lids / Foil = cases × packs-per-case  (400g & 1kg: ×6, 5kg+: ×1)
 *        Trays = 1 per case for the 6-pack products, none for 1-pack products.
 * "Pks" column of the product (packs per case) is used, so nothing to configure. */
$PER_PACK  = 1;      // pots + lids per pack
$FOIL_PACK = 1;      // foil per pack

/* --- 3c. latest saved production sheet up to the planning Friday:
 *     finished-goods closing stock + packaging closing stock per product --- */
$stock = array();
$stockDate = '';
$fq = mysqli_query($con, "SELECT MAX(rdate) d FROM yogurt_records WHERE rdate <= '$friday'");
if ($fq && ($fr = mysqli_fetch_assoc($fq)) && $fr['d']) {
    $stockDate = $fr['d'];
    $sq = mysqli_query($con, "SELECT * FROM yogurt_records WHERE rdate='" . $stockDate . "'");
    while ($r = mysqli_fetch_assoc($sq)) {
        $gt = $r['cust1'] + $r['cust2'] + $r['cust3'] + $r['cust4'] + $r['cust5'];
        $stock[$r['product_id']] = array(
            'stk'      => ($r['op_stock'] + $r['actual_filling']) - $gt + $r['adj'],
            'st_pots'  => $r['op_pots'] - $r['used_pots'],
            'st_lids'  => $r['op_lids'] - $r['used_lids'],
            'st_foil'  => $r['op_foil'] - $r['used_foil'],
            'st_trays' => $r['op_trays'] - $r['used_trays'],
        );
    }
}
foreach ($products as $k => $p) {
    $z = isset($stock[$p['id']]) ? $stock[$p['id']] : array('stk' => 0, 'st_pots' => 0, 'st_lids' => 0, 'st_foil' => 0, 'st_trays' => 0);
    $p = array_merge($p, $z);

    /* saved manual overrides + the new plain fields */
    $s = isset($sv[$p['id']]) ? $sv[$p['id']] : null;
    $manv = array();
    if ($s && !empty($s['manual_fields']))
        foreach (explode(',', $s['manual_fields']) as $mk)
            if (isset($MAP[$mk]) && isset($s[$MAP[$mk]]))
                $manv[$mk] = (float) $s[$MAP[$mk]];
    $p['manv']    = $manv;
    $p['tank_am'] = ($s && isset($s['tank_am'])) ? $s['tank_am'] : '';
    $p['tank_pm'] = ($s && isset($s['tank_pm'])) ? $s['tank_pm'] : '';
    $p['finish_time'] = ($s && !empty($s['finish_time'])) ? substr($s['finish_time'], 0, 5) : '';
    $p['batch_code']  = ($s && !empty($s['batch_code'])) ? $s['batch_code'] : $defBatchCode;
    $p['best_before'] = ($s && !empty($s['best_before']) && $s['best_before'] != '0000-00-00') ? $s['best_before'] : $defBestBefore;
    $p['af']          = ($s && isset($s['actual_filling'])) ? (float) $s['actual_filling'] : 0;
    $products[$k] = $p;
}

/* split "70% L901=> 70g" into [name part, grams part] */
function cparts($t)
{
    $t = (string) $t;
    /* name part = everything up to and including the sign (=> or -),
     * grams part = the trailing number + g.  "YC470 - 60g" -> ["YC470 -","60g"] */
    if (preg_match('/^(.*?)(\d+(?:\.\d+)?\s*g)\s*$/i', $t, $m))
        return array(trim($m[1]), str_replace(' ', '', trim($m[2])));
    return array(trim($t), '');
}

function h($s)
{
    return htmlspecialchars((string) $s, ENT_QUOTES);
}
function nz($v)
{
    return $v ? rtrim(rtrim(number_format($v, 2, '.', ''), '0'), '.') : '';
}

/* editable auto-calculated cell (value filled by JS) */
function ed($i, $k, $cls)
{
    return "<td class='$cls'><input class='ed' inputmode='decimal' data-i='$i' data-k='$k' id='f_{$k}_{$i}' title='Type to override · clear the box to go back to auto'></td>";
}
/* plain editable field saved as-is */
function pf($i, $f, $v, $type = 'text', $cls = 'in')
{
    $num = ($f == 'af') ? " inputmode='decimal'" : '';
    $tx  = ($f == 'af') ? '' : ' tx';
    return "<td class='$cls'><input class='ed pf$tx' type='$type'$num data-i='$i' data-f='$f' id='pf_{$f}_{$i}' value=\"" . h($v) . "\"></td>";
}

/* TOTAL row — ids p{page}_{key} / g_{key} are filled by JS */
function totalRow($label, $p, $grand = false)
{
    $pre = $grand ? 'g_' : 'p' . $p . '_';
    $c = "<td class='rn'></td><td colspan='3' class='lbl fz1'>$label</td>";
    foreach (array('batch', 'cream', 'smp', 'milk', 'fruit', 'total', 'tpks') as $k)
        $c .= "<td id='{$pre}{$k}'></td>";
    $c .= "<td colspan='10'></td>";                      // tank AM/PM + finish time + 3 cultures × (name + grams) + culture total
    foreach (array('af', 'optot', 'stk', 'more') as $k)
        $c .= "<td id='{$pre}{$k}'></td>";
    $c .= "<td colspan='2'></td>";                       // batch code + best before
    foreach (
        array(
            'rq_pots',
            'rq_lids',
            'rq_foil',
            'rq_trays',
            'st_pots',
            'st_lids',
            'st_foil',
            'st_trays',
            'mr_pots',
            'mr_lids',
            'mr_foil',
            'mr_trays'
        ) as $k
    )
        $c .= "<td id='{$pre}{$k}'></td>";
    return "<tr class='trow" . ($grand ? ' grand' : '') . "'>$c</tr>";
}

$widths = array(
    36,
    270,
    56,
    50,
    110,
    100,
    100,
    100,
    100,
    100,
    110,      // batch … target pks
    80,
    80,
    90,                             // tank AM, tank PM, finish time
    110,
    70,
    110,
    70,
    110,
    70,
    90,          // cultures
    90,
    90,                                 // actual filling, O/P stock
    90,
    100,                                // closing stock, more production
    100,
    120,                               // batch code, best before
    70,
    70,
    70,
    70,
    70,
    70,
    70,
    70,
    70,
    70,
    70,
    70
);
$tableMin = array_sum($widths);
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
    <title>📋 Weekly Plan — <?= h($friday) ?></title>
    <link rel="stylesheet" href="plan.css">
    <style>
        td.short {
            background: #fde2e2 !important;
            color: #b00020;
            font-weight: 700
        }

        td.short input.ed {
            color: #b00020;
            font-weight: 700
        }

        th.sep-red {
            background: #b00020 !important;
            color: #fff
        }

        /* editable cells */
        input.ed {
            width: 100%;
            box-sizing: border-box;
            border: 0;
            background: transparent;
            font: inherit;
            text-align: right;
            padding: 4px 6px;
            color: inherit;
            outline: 0
        }

        input.ed.tx {
            text-align: left
        }

        input.ed:focus {
            background: #fff;
            box-shadow: inset 0 0 0 2px #2d7ff9
        }

        input.ed.ovr {
            background: #fff3d6;
            box-shadow: inset 0 0 0 1.5px #f59e0b
        }

        input.ed.ovr:focus {
            background: #fff;
            box-shadow: inset 0 0 0 2px #f59e0b
        }
    </style>
</head>

<body>
    <header class="top">
        <div class="logo">📋</div>
        <div>
            <h1>Weekly Production Plan</h1>
            <div class="sub">Marshwood Farm Limited · Plan on Friday for next Monday – Friday</div>
        </div>
        <div class="spacer"></div>
        <div class="pill"><small>Planning Day</small><?= h(date('l d M Y', $fri)) ?></div>
        <div class="pill"><small>Production Week</small><?= h(date('d M', $mon)) ?> – <?= h(date('d M', $nextFri)) ?></div>
    </header>

    <div class="toolbar">
        <button class="navbtn" title="Previous week" onclick="stepDate(-7)">◀</button>
        <input class="dinput" type="date" value="<?= h($friday) ?>" onchange="gotoDate(this.value)">
        <button class="navbtn" title="Next week" onclick="stepDate(7)">▶</button>
        <button class="btn btn-save" onclick="save()" title="Ctrl+S">💾 Save Plan</button>
        <button class="btn" onclick="window.print()">🖨 Print</button>
        <a class="btn" href="yogurt.php?date=<?= h(date('Y-m-d')) ?>" style="text-decoration:none">🥣 Open Today Sheet</a>
        <div class="stats">
            <span class="stat"><small>Total Batch (Ltr)</small><b id="kpi_batch">0</b></span>
            <span class="stat"><small>Products</small><b id="kpi_prod">0</b></span>
        </div>
        <span id="st"></span>
    </div>

    <div class="legend">
        <span class="chip"><i style="background:#fff"></i>you type batch</span>
        <span class="chip"><i style="background:#eef5ff"></i>auto (from recipe %) — editable</span>
        <span class="chip"><i style="background:#fffae6"></i>formula (calculated) — editable</span>
        <span class="chip"><i style="background:#fff3d6;box-shadow:0 0 0 1px #f59e0b"></i>typed by you (clear box = back to auto)</span>
        <span class="chip"><i style="background:#fde2e2"></i>shortage (more required)</span>
        <span class="chip">Stock as of: <b><?= h($stockDate ?: "no sheet saved") ?></b></span>
        <span class="hint"><kbd>Enter</kbd> move down · <kbd>↑↓</kbd> navigate · <kbd>Ctrl+S</kbd> save</span>
    </div>

    <div class="wrap">
        <div class="card">
            <table style="min-width: <?= $tableMin ?>px">
                <?= $colgroup ?>
                <thead>
                    <tr class="h1">
                        <th rowspan="2" class="crn">#</th>
                        <th colspan="3">Product</th>
                        <th colspan="17" class="sep-go">Quantities for Yogurt Planning — Full Week</th>
                        <th colspan="2" class="sep-go">Sunday Loading</th>
                        <th colspan="2" class="sep-go">Finished Stock</th>
                        <th colspan="2" class="sep-go">Batch Code</th>
                        <th colspan="4" class="sep-go">Packaging Required</th>
                        <th colspan="4" class="sep-go">Packaging Closing Stock</th>
                        <th colspan="4" class="sep-go sep-red">Packaging MORE Required</th>
                    </tr>
                    <tr class="h2">
                        <th class="fz1">Description</th>
                        <th>Kg</th>
                        <th>Pks</th>
                        <th class="sec-go sep-go">Batch (Ltr)</th>
                        <th class="sec-go">Cream (Ltr)</th>
                        <th class="sec-go">SMP (Kg)</th>
                        <th class="sec-go">Milk (Ltr)</th>
                        <th class="sec-go">Fruit</th>
                        <th class="sec-go">Total</th>
                        <th class="sec-go">Target Pks</th>
                        <th>Tank AM</th>
                        <th>Tank PM</th>
                        <th>Finish Time</th>
                        <th>Culture 1</th>
                        <th>Qty (g)</th>
                        <th>Culture 2</th>
                        <th>Qty (g)</th>
                        <th>Culture 3</th>
                        <th>Qty (g)</th>
                        <th>Culture Total (g)</th>
                        <th class="sep-go">Actual Filling</th>
                        <th>O/P Stock</th>
                        <th class="sep-go">Closing Stock (Pks)</th>
                        <th>More Production (Pks)</th>
                        <th class="sep-go">Batch Code</th>
                        <th>Best Before</th>
                        <th class="sep-go" title="Pots">P</th>
                        <th title="Lids">L</th>
                        <th title="Foil">F</th>
                        <th title="Trays">T</th>
                        <th class="sep-go" title="Pots">P</th>
                        <th title="Lids">L</th>
                        <th title="Foil">F</th>
                        <th title="Trays">T</th>
                        <th class="sep-go" title="Pots">P</th>
                        <th title="Lids">L</th>
                        <th title="Foil">F</th>
                        <th title="Trays">T</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $last = null;
                    foreach ($products as $i => $p):
                        if ($last !== null && $p['page_no'] != $last)
                            echo totalRow('TOTAL — Page ' . $last, $last);
                        $last = $p['page_no'];
                        $b = isset($plan[$p['id']]) ? $plan[$p['id']] : 0;
                    ?>
                        <tr class="prow">
                            <td class="rn"><?= $i + 1 ?></td>
                            <td class="ro desc fz1"><?= h($p['description']) ?></td>
                            <td class="ro"><?= h($p['kg']) ?></td>
                            <td class="ro"><?= h($p['pks']) ?></td>
                            <td class="in sep-go"><input class="ci" inputmode="decimal" data-i="<?= $i ?>"
                                    value="<?= h(nz($b)) ?>"></td>
                            <?= ed($i, 'cream', 'semi') ?>
                            <?= ed($i, 'smp', 'semi') ?>
                            <?= ed($i, 'milk', 'semi') ?>
                            <?= ed($i, 'fruit', 'semi') ?>
                            <?= ed($i, 'total', 'calc') ?>
                            <?= ed($i, 'tpks', 'calc') ?>
                            <?= pf($i, 'tank_am', $p['tank_am']) ?>
                            <?= pf($i, 'tank_pm', $p['tank_pm']) ?>
                            <?= pf($i, 'finish_time', $p['finish_time'], 'time') ?>
                            <?php foreach (array(1, 2, 3) as $c):
                                $pt  = cparts($p['culture' . $c]);
                                $sg  = isset($cq[$p['id']][$c]) ? $cq[$p['id']][$c] : '';
                                $gv  = ($sg !== '' && $sg !== null) ? $sg : $pt[1];   // saved, else default from product 
                            ?>
                                <td class="ro"><?= h($pt[0]) ?></td>
                                <td class="in"><input class="cq" data-i="<?= $i ?>" data-c="<?= $c ?>" value="<?= h($gv) ?>"></td>
                            <?php endforeach; ?>
                            <td class="calc" id="f_ctot_<?= $i ?>"></td>
                            <?= pf($i, 'af', nz($p['af']), 'text', 'in sep-go') ?>
                            <?= ed($i, 'optot', 'calc') ?>
                            <?= ed($i, 'stk', 'calc sep-go') ?>
                            <?= ed($i, 'more', 'calc') ?>
                            <?= pf($i, 'batch_code', $p['batch_code'], 'text', 'in sep-go') ?>
                            <?= pf($i, 'best_before', $p['best_before'], 'date') ?>
                            <?php foreach (array('rq', 'st', 'mr') as $g)
                                foreach (array('pots', 'lids', 'foil', 'trays') as $m)
                                    echo ed($i, $g . '_' . $m, 'calc' . ($m == 'pots' ? ' sep-go' : '')); ?>
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

    <div id="toasts"></div>

    <script>
        var FRIDAY = <?= json_encode($friday) ?>;
        var ROWS = <?= json_encode($products) ?>; // id, page_no, kg, pks, cream_pct, smp_pct, fruit_pct …
        var INP = {},
            ED = {},
            CQ = {},
            saveT = null,
            dirtyFlag = false;
        var KEYS = ['batch', 'cream', 'smp', 'milk', 'fruit', 'total', 'tpks', 'af', 'optot', 'stk', 'more',
            'rq_pots', 'rq_lids', 'rq_foil', 'rq_trays', 'st_pots', 'st_lids', 'st_foil', 'st_trays',
            'mr_pots', 'mr_lids', 'mr_foil', 'mr_trays'
        ];
        /* cells that are auto-calculated but can be typed over */
        var EDK = KEYS.filter(function(k) {
            return k != 'batch' && k != 'af';
        });
        var PER_PACK = <?= json_encode($PER_PACK) ?>,
            FOIL_PACK = <?= json_encode($FOIL_PACK) ?>;
        var MATS = ['pots', 'lids', 'foil', 'trays'];

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

        /* use the typed value if the cell was overridden, otherwise the auto value */
        function ov(r, k, auto) {
            if (r.man[k]) return num(r[k]);
            r[k] = auto;
            return auto;
        }

        /* one row: Cream/SMP/Fruit = Batch × %  ·  Milk = Batch − Cream − SMP
         * Target Pks (cases) = Total ÷ (Kg × Pks)  — same as Excel and yogurt.php */
        function calcRow(i) {
            var r = ROWS[i],
                b = num(INP[i].value);
            r.batch = b;
            /* culture total = sum of the 3 grams cells (70g + 25g → 95) */
            r.culture_total_g = r2(num(cg(i, 1)) + num(cg(i, 2)) + num(cg(i, 3)));
            var ce = document.getElementById('f_ctot_' + i);
            if (ce) ce.textContent = r.culture_total_g ? fmt(r.culture_total_g) : '';
            r.af = ED['af_' + i] ? num(ED['af_' + i].value) : 0;

            ov(r, 'cream', r2(b * num(r.cream_pct) / 100));
            ov(r, 'smp', r2(b * num(r.smp_pct) / 100));
            ov(r, 'fruit', r2(b * num(r.fruit_pct) / 100));
            ov(r, 'milk', r2(b - r.cream - r.smp));
            ov(r, 'total', r2(r.cream + r.smp + r.milk + r.fruit));
            var kg = parseFloat(r.kg),
                pk = parseFloat(r.pks);
            ov(r, 'tpks', (kg > 0 && pk > 0) ? Math.ceil(r2(r.total / (kg * pk))) : 0);
            /* finished stock: closing stock from the last production sheet, then O/P = stock + actual filling */
            ov(r, 'stk', r.a_stk);
            ov(r, 'optot', r2(r.stk + r.af));
            ov(r, 'more', Math.max(0, r2(r.tpks - r.stk)));
            /* packaging required for the target cases (Excel "Daily Used Materials") */
            var ppc = pk > 0 ? pk : 1; // packs per case
            ov(r, 'rq_pots', Math.ceil(r.tpks * ppc * PER_PACK));
            ov(r, 'rq_lids', Math.ceil(r.tpks * ppc * PER_PACK));
            ov(r, 'rq_foil', Math.ceil(r.tpks * ppc * FOIL_PACK));
            ov(r, 'rq_trays', ppc > 1 ? Math.ceil(r.tpks) : 0);
            MATS.forEach(function(m) {
                ov(r, 'st_' + m, r['a_st_' + m]);
                ov(r, 'mr_' + m, b ? Math.max(0, r['rq_' + m] - r['st_' + m]) : 0);
            });
            EDK.forEach(function(k) {
                var c = ED[k + '_' + i];
                if (!c) return;
                var show = b || r.man[k] || k == 'stk' || k == 'optot' || k.indexOf('st_') == 0;
                if (document.activeElement !== c) c.value = show ? fmt(r[k]) : '';
                c.classList.toggle('ovr', !!r.man[k]);
                c.parentNode.classList.toggle('short', k.indexOf('mr_') == 0 && r[k] > 0);
            });
        }

        /* page totals + grand total + KPIs */
        function calcTotals() {
            var P = {},
                G = {},
                prods = 0;
            KEYS.forEach(function(k) {
                G[k] = 0;
            });
            ROWS.forEach(function(r) {
                var p = r.page_no || 1;
                P[p] = P[p] || {};
                KEYS.forEach(function(k) {
                    P[p][k] = (P[p][k] || 0) + num(r[k]);
                    G[k] += num(r[k]);
                });
                if (num(r.batch) > 0) prods++;
            });
            Object.keys(P).forEach(function(p) {
                KEYS.forEach(function(k) {
                    var c = document.getElementById('p' + p + '_' + k);
                    if (c) {
                        c.textContent = fmt(P[p][k]);
                        c.classList.toggle('short', k.indexOf('mr_') == 0 && P[p][k] > 0);
                    }
                });
            });
            KEYS.forEach(function(k) {
                var c = document.getElementById('g_' + k);
                c.textContent = fmt(G[k]);
                c.classList.toggle('short', k.indexOf('mr_') == 0 && G[k] > 0);
            });
            document.getElementById('kpi_batch').textContent = fmt(G.batch);
            document.getElementById('kpi_prod').textContent = prods;
        }

        /* per-row setup: saved overrides + auto sources */
        ROWS.forEach(function(r) {
            r.man = {};
            var mv = r.manv || {};
            Object.keys(mv).forEach(function(k) {
                r.man[k] = true;
                r[k] = num(mv[k]);
            });
            r.a_stk = num(r.stk);
            MATS.forEach(function(m) {
                r['a_st_' + m] = num(r['st_' + m]);
            });
        });

        /* batch input + keyboard */
        document.querySelectorAll('.ci').forEach(function(inp) {
            var i = inp.dataset.i;
            INP[i] = inp;
            inp.addEventListener('input', function() {
                calcRow(i);
                calcTotals();
                markDirty();
            });
            inp.addEventListener('focus', function() {
                inp.select();
                inp.closest('tr').classList.add('row-focus');
            });
            inp.addEventListener('blur', function() {
                inp.closest('tr').classList.remove('row-focus');
            });
            inp.addEventListener('keydown', function(e) {
                if (e.key == 'Enter' || e.key == 'ArrowDown') {
                    e.preventDefault();
                    if (INP[+i + 1]) INP[+i + 1].focus();
                }
                if (e.key == 'ArrowUp') {
                    e.preventDefault();
                    if (INP[i - 1]) INP[i - 1].focus();
                }
            });
        });

        /* editable cells: auto-calculated (data-k) and plain fields (data-f) */
        document.querySelectorAll('input.ed').forEach(function(inp) {
            var i = inp.dataset.i,
                isPF = !!inp.dataset.f,
                k = inp.dataset.k || inp.dataset.f;
            ED[k + '_' + i] = inp;
            inp.addEventListener('input', function() {
                var r = ROWS[i];
                if (!isPF) {
                    var v = inp.value.trim();
                    if (v === '') delete r.man[k]; // cleared → back to auto
                    else {
                        r.man[k] = true;
                        r[k] = num(v);
                    } // typed → manual override
                }
                calcRow(i);
                calcTotals();
                markDirty();
            });
            inp.addEventListener('focus', function() {
                if (inp.type == 'text') inp.select();
                inp.closest('tr').classList.add('row-focus');
            });
            inp.addEventListener('blur', function() {
                inp.closest('tr').classList.remove('row-focus');
                if (!isPF) {
                    calcRow(i);
                    calcTotals();
                }
            });
            inp.addEventListener('keydown', function(e) {
                var down = ED[k + '_' + (+i + 1)],
                    up = ED[k + '_' + (i - 1)];
                if (e.key == 'Enter' || (inp.type == 'text' && e.key == 'ArrowDown')) {
                    e.preventDefault();
                    if (down) down.focus();
                }
                if (inp.type == 'text' && e.key == 'ArrowUp') {
                    e.preventDefault();
                    if (up) up.focus();
                }
            });
        });

        /* culture quantity (grams) — editable, saved with the plan */
        document.querySelectorAll('.cq').forEach(function(inp) {
            var i = inp.dataset.i,
                c = inp.dataset.c;
            CQ[i + '_' + c] = inp;
            inp.addEventListener('input', function() {
                calcRow(i);
                calcTotals();
                markDirty();
            });
            inp.addEventListener('focus', function() {
                inp.select();
            });
            inp.addEventListener('keydown', function(e) {
                if (e.key == 'Enter' || e.key == 'ArrowDown') {
                    e.preventDefault();
                    var n = CQ[(+i + 1) + '_' + c];
                    if (n) n.focus();
                }
                if (e.key == 'ArrowUp') {
                    e.preventDefault();
                    var p = CQ[(i - 1) + '_' + c];
                    if (p) p.focus();
                }
            });
        });

        function cg(i, c) {
            return CQ[i + '_' + c] ? CQ[i + '_' + c].value : '';
        }

        function pv(i, f) {
            return ED[f + '_' + i] ? ED[f + '_' + i].value : '';
        }

        /* week navigation */
        function gotoDate(d) {
            if (!d) return;
            if (dirtyFlag && !confirm('You have unsaved changes.\nLeave anyway?')) return;
            location.href = '?date=' + d;
        }

        function stepDate(n) {
            var d = new Date(FRIDAY);
            d.setUTCDate(d.getUTCDate() + n);
            gotoDate(d.toISOString().slice(0, 10));
        }

        /* save (auto-save 2 s after typing) */
        function markDirty() {
            dirtyFlag = true;
            setStatus('● unsaved changes…', 'dirty');
            clearTimeout(saveT);
            saveT = setTimeout(save, 2000);
        }

        function save() {
            clearTimeout(saveT);
            setStatus('Saving…');
            /* send EVERY product (incl. 0) so clearing a value updates it to 0 */
            var items = [];
            ROWS.forEach(function(r, i) {
                calcRow(i);
                items.push({
                    product_id: r.id,
                    batch: num(INP[i].value),
                    culture_total_g: r.culture_total_g,
                    culture1_g: cg(i, 1),
                    culture2_g: cg(i, 2),
                    culture3_g: cg(i, 3),
                    cream: r.cream,
                    smp: r.smp,
                    milk: r.milk,
                    fruit: r.fruit,
                    total: r.total,
                    op_stock: r.stk,
                    target_pks: r.tpks,
                    required_pks: r.more,
                    req_pots: r.rq_pots,
                    req_lids: r.rq_lids,
                    req_foil: r.rq_foil,
                    req_trays: r.rq_trays,
                    stock_pots: r.st_pots,
                    stock_lids: r.st_lids,
                    stock_foil: r.st_foil,
                    stock_trays: r.st_trays,
                    more_pots: r.mr_pots,
                    more_lids: r.mr_lids,
                    more_foil: r.mr_foil,
                    more_trays: r.mr_trays,
                    /* ★ new fields */
                    tank_am: pv(i, 'tank_am'),
                    tank_pm: pv(i, 'tank_pm'),
                    finish_time: pv(i, 'finish_time'),
                    batch_code: pv(i, 'batch_code'),
                    best_before: pv(i, 'best_before'),
                    actual_filling: r.af,
                    op_total: r.optot,
                    manual_fields: Object.keys(r.man).join(',')
                });
            });
            fetch('plan_save', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        friday: FRIDAY,
                        items: items
                    })
                })
                .then(function(r) {
                    return r.json();
                })
                .then(function(j) {
                    if (j.ok) {
                        dirtyFlag = false;
                        setStatus('✓ Saved ' + new Date().toLocaleTimeString());
                        toast('💾 Plan saved successfully', true);
                    } else {
                        setStatus('⚠ Save failed');
                        toast('⚠ ' + (j.msg || 'Save failed — please retry'), false);
                    }
                })
                .catch(function() {
                    setStatus('⚠ Save failed');
                    toast('⚠ Network error while saving', false);
                });
        }

        ROWS.forEach(function(r, i) {
            calcRow(i);
        });
        calcTotals();

        /* frozen Description column (same technique as yogurt.php) */
        function syncSticky() {
            var tr = document.querySelector('.wrap tbody tr');
            var th = document.querySelector('.wrap tr.h1 th');
            if (!tr || !th) return;
            var s = document.documentElement.style;
            s.setProperty('--off1', tr.cells[0].offsetWidth + 'px'); // "#" column width
            s.setProperty('--h1h', th.offsetHeight + 'px');
        }
        syncSticky();
        window.addEventListener('resize', syncSticky);
        if (document.fonts && document.fonts.ready) document.fonts.ready.then(syncSticky);

        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() == 's') {
                e.preventDefault();
                save();
            }
        });
        window.addEventListener('beforeunload', function(e) {
            if (dirtyFlag) {
                e.preventDefault();
                e.returnValue = '';
            }
        });
    </script>
</body>

</html>