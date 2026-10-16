<?php
/* ============================================================
   FOOD STOCK — GOODS IN / GOODS OUT (static, no JS)
   Replace the arrays with your queries, e.g.:
     $goods_in  = $conn->query("SELECT item, qty, unit, supplier, date_in
                                FROM goods_in ORDER BY date_in DESC")->fetch_all(MYSQLI_ASSOC);
     $goods_out = $conn->query("SELECT item, qty, unit, issued_to, date_out
                                FROM goods_out ORDER BY date_out DESC")->fetch_all(MYSQLI_ASSOC);
   ============================================================ */

 $goods_in = [
  ['item'=>'Fresh Carrots',    'qty'=>45,  'unit'=>'kg',      'supplier'=>'GreenFarm Organics',  'date'=>date('Y-m-d', strtotime('-1 day'))],
  ['item'=>'Whole Wheat Bread','qty'=>24,  'unit'=>'loaves',  'supplier'=>'Sunrise Bakery',      'date'=>date('Y-m-d', strtotime('-1 day'))],
  ['item'=>'Cheddar Cheese',   'qty'=>60,  'unit'=>'packs',   'supplier'=>'DairyBest Farms',     'date'=>date('Y-m-d', strtotime('-2 days'))],
  ['item'=>'Chicken Breast',   'qty'=>30,  'unit'=>'kg',      'supplier'=>'Prime Meats Co.',     'date'=>date('Y-m-d', strtotime('-3 days'))],
  ['item'=>'Orange Juice',     'qty'=>100, 'unit'=>'bottles', 'supplier'=>'FreshSip Beverages',  'date'=>date('Y-m-d', strtotime('-4 days'))],
  ['item'=>'Basmati Rice',     'qty'=>250, 'unit'=>'kg',      'supplier'=>'Golden Grain Traders','date'=>date('Y-m-d', strtotime('-6 days'))],
  ['item'=>'Strawberries',     'qty'=>60,  'unit'=>'punnets', 'supplier'=>'Berry Hill Farms',    'date'=>date('Y-m-d', strtotime('-7 days'))],
];

 $goods_out = [
  ['item'=>'Fresh Carrots',    'qty'=>12, 'unit'=>'kg',      'issued_to'=>'Main Kitchen',   'date'=>date('Y-m-d', strtotime('-1 day'))],
  ['item'=>'Whole Wheat Bread','qty'=>10, 'unit'=>'loaves',  'issued_to'=>'Cafeteria',      'date'=>date('Y-m-d', strtotime('-1 day'))],
  ['item'=>'Chicken Breast',   'qty'=>15, 'unit'=>'kg',      'issued_to'=>'Main Kitchen',   'date'=>date('Y-m-d', strtotime('-2 days'))],
  ['item'=>'Cheddar Cheese',   'qty'=>8,  'unit'=>'packs',   'issued_to'=>'Sandwich Bar',   'date'=>date('Y-m-d', strtotime('-2 days'))],
  ['item'=>'Orange Juice',     'qty'=>24, 'unit'=>'bottles', 'issued_to'=>'Cafeteria',      'date'=>date('Y-m-d', strtotime('-3 days'))],
  ['item'=>'Basmati Rice',     'qty'=>50, 'unit'=>'kg',      'issued_to'=>'Main Kitchen',   'date'=>date('Y-m-d', strtotime('-5 days'))],
];

/* ---------- helpers ---------- */
function fs_e($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function fs_qty($n){
  return rtrim(rtrim(number_format((float)$n, 2, '.', ''), '0'), '.');
}
function fs_date_html($date){
  $t = strtotime($date);
  return date('j M', $t) . ' <span class="fs-yr">' . date('Y', $t) . '</span>';
}
function fs_total_qty($rows){
  $t = 0;
  foreach ($rows as $r) $t += (float)$r['qty'];
  return $t;
}
?>
<style>
    /* ============================================================
       BLUE THEME — edit these 4 lines to recolor everything
       ============================================================ */
    :root{
        --a:#1e88e5;      /* main blue        */
        --ad:#0d47a1;     /* deep blue        */
        --soft:#e3f2fd;   /* pale blue wash   */
        --line:#bbdefb;   /* borders          */
        --in:#2e7d32;     /* goods-in edge    */
        --inbg:#e8f5e9;
        --out:#e65100;    /* goods-out edge   */
        --outbg:#fff3e0;
    }

    /* ============================================================
       LAYOUT — side by side on wide screens, stacked on mobile
       ============================================================ */
    .fs-duo {
        display: grid;
        grid-template-columns: 1fr;
        gap: 22px;
        max-width: 100%;
    }

    @media (min-width: 1150px) {
        .fs-duo { grid-template-columns: 1fr 1fr; }
    }

    /* ============================================================
       CARD
       ============================================================ */
    .fs-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 18px rgba(13,71,161,.10);
        overflow: hidden;
        min-width: 0;                    /* lets the card shrink inside the grid */
    }

    .fs-cardhead {
        background: linear-gradient(135deg, var(--a), var(--ad));
        color: #fff;
        padding: 13px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        flex-wrap: wrap;
    }

    .fs-cardhead h2 {
        margin: 0;
        font-size: clamp(.92rem, 2.6vw, 1.1rem);
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 9px;
    }

    .fs-chip {
        font-size: .58rem;
        font-weight: 800;
        letter-spacing: 1.2px;
        padding: 3px 8px 2px;
        border-radius: 50px;
        color: #fff;
    }

    .fs-chip.in  { background: var(--in); }
    .fs-chip.out { background: var(--out); }

    .fs-cardhead span.fs-meta {
        font-size: .7rem;
        text-transform: uppercase;
        letter-spacing: .6px;
        opacity: .9;
        font-weight: 600;
    }

    /* ============================================================
       TABLE — fixed layout + fluid type = fits any width
       ============================================================ */
    .fs-table {
        width: 100%;
        table-layout: fixed;
        border-collapse: collapse;
        -webkit-text-size-adjust: 100%;
    }

    .fs-table thead th {
        background: #fff;
        color: #78909c;
        font-size: clamp(.54rem, 1.9vw, .68rem);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .5px;
        text-align: left;
        padding: clamp(8px, 2.4vw, 14px) clamp(6px, 1.8vw, 14px);
        border-bottom: 2px solid var(--line);
    }

    .fs-table tbody td,
    .fs-table tfoot td {
        padding: clamp(8px, 2.6vw, 14px) clamp(6px, 1.8vw, 14px);
        border-bottom: 1px solid #eef4fb;
        font-size: clamp(.74rem, 2.5vw, .92rem);
        color: #37474f;
        vertical-align: middle;
        overflow-wrap: anywhere;
        word-break: break-word;
        line-height: 1.35;
    }

    .fs-table tbody tr:last-child td { border-bottom: none; }

    /* direction edge: green for in, orange for out */
    .fs-card.fs-in  .fs-table tbody td:first-child { border-left: 4px solid var(--in); }
    .fs-card.fs-out .fs-table tbody td:first-child { border-left: 4px solid var(--out); }

    .fs-table tbody tr:nth-child(even) { background: #f7faff; }
    .fs-table tbody tr:hover { background: var(--soft); }

    .fs-tname { font-weight: 700; color: #263238; }

    .fs-qty { font-weight: 700; color: #263238; white-space: nowrap; }
    .fs-qty small {
        font-weight: 500;
        font-size: .72em;
        color: #90a4ae;
        text-transform: uppercase;
        letter-spacing: .3px;
    }

    /* total row */
    .fs-table tfoot td {
        background: #f2f7fd;
        border-top: 2px solid var(--line);
        border-bottom: none;
        font-weight: 800;
        color: var(--ad);
    }
    .fs-table tfoot td small {
        font-weight: 600;
        font-size: .68em;
        color: #78909c;
        text-transform: uppercase;
        letter-spacing: .4px;
    }
    .fs-table tfoot .fs-qty { color: var(--ad); }

    /* ============================================================
       PROGRESSIVE SLIMMING — pure CSS, no JS
       ============================================================ */

    /* small phones: hide the year in dates ("12 Jun") */
    @media (max-width: 520px) {
        .fs-yr { display: none; }
        .fs-table thead th { letter-spacing: 0; }
    }

    @media (max-width: 768px) {
        .fs-cardhead { padding: 12px 14px; }
    }
</style>

<div class="fs-duo">

    <!-- ==================== GOODS IN ==================== -->
    <div class="fs-card fs-in">
        <div class="fs-cardhead">
            <h2><span class="fs-chip in">IN</span> Goods In <span class="fs-meta">· received</span></h2>
            <span class="fs-meta"><?= count($goods_in) ?> entries</span>
        </div>

        <table class="fs-table">
            <colgroup>
                <col style="width:34%">
                <col style="width:18%">
                <col style="width:26%">
                <col style="width:22%">
            </colgroup>
            <thead>
                <tr>
                    <th scope="col">Product</th>
                    <th scope="col">Qty in</th>
                    <th scope="col">Supplier</th>
                    <th scope="col">Date in</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($goods_in as $r): ?>
                <tr>
                    <td class="fs-tname"><?= fs_e($r['item']) ?></td>
                    <td><span class="fs-qty">+<?= fs_qty($r['qty']) ?> <small><?= fs_e($r['unit']) ?></small></span></td>
                    <td><?= fs_e($r['supplier']) ?></td>
                    <td><?= fs_date_html($r['date']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td>Total received</td>
                    <td><span class="fs-qty">+<?= fs_qty(fs_total_qty($goods_in)) ?></span></td>
                    <td colspan="2"><small><?= count($goods_in) ?> deliveries</small></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- ==================== GOODS OUT ==================== -->
    <div class="fs-card fs-out">
        <div class="fs-cardhead">
            <h2><span class="fs-chip out">OUT</span> Goods Out <span class="fs-meta">· issued</span></h2>
            <span class="fs-meta"><?= count($goods_out) ?> entries</span>
        </div>

        <table class="fs-table">
            <colgroup>
                <col style="width:34%">
                <col style="width:18%">
                <col style="width:26%">
                <col style="width:22%">
            </colgroup>
            <thead>
                <tr>
                    <th scope="col">Product</th>
                    <th scope="col">Qty out</th>
                    <th scope="col">Issued to</th>
                    <th scope="col">Date out</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($goods_out as $r): ?>
                <tr>
                    <td class="fs-tname"><?= fs_e($r['item']) ?></td>
                    <td><span class="fs-qty">−<?= fs_qty($r['qty']) ?> <small><?= fs_e($r['unit']) ?></small></span></td>
                    <td><?= fs_e($r['issued_to']) ?></td>
                    <td><?= fs_date_html($r['date']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td>Total issued</td>
                    <td><span class="fs-qty">−<?= fs_qty(fs_total_qty($goods_out)) ?></span></td>
                    <td colspan="2"><small><?= count($goods_out) ?> issues</small></td>
                </tr>
            </tfoot>
        </table>
    </div>

</div>