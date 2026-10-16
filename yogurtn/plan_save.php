<?php
/* AJAX save for plan.php · POST JSON {friday:'YYYY-MM-DD', items:[{product_id,batch,...}]}
 * Row for each (week_friday, product_id) is UPDATED if it already exists;
 * INSERTed only the first time. Nothing is deleted.
 * Needs the UNIQUE KEY on (week_friday, product_id) — already created by plan.sql.
 * batch=0 is still saved (as 0), so clearing a value updates it.
 *
 * ★ NEW columns saved (plan.php adds them to the table automatically):
 *   tank_am, tank_pm, finish_time, batch_code, best_before,
 *   actual_filling, op_total, manual_fields */
include "../connection.php";
header('Content-Type: application/json');

$in     = json_decode(file_get_contents('php://input'), true);
$friday = isset($in['friday']) ? $in['friday'] : '';
$items  = isset($in['items']) && is_array($in['items']) ? $in['items'] : null;

if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $friday) || !strtotime($friday) || $items === null) {
    echo json_encode(array('ok' => false, 'msg' => 'Bad request — missing/invalid date or items'));
    exit;
}

/* snap to that week's Friday (same rule as plan.php) */
$ts  = strtotime($friday);
$dow = (int) date('N', $ts);
$fri = ($dow <= 5) ? strtotime('+' . (5 - $dow) . ' days', $ts)
                   : strtotime('+' . (12 - $dow) . ' days', $ts);
$friday = date('Y-m-d', $fri);
$friday = mysqli_real_escape_string($con, $friday);

$ok   = true;
$err  = '';
$seen = array();

/* every saved numeric column (besides week_friday/product_id) */
$cols = array('batch', 'cream', 'smp', 'milk', 'fruit', 'total',
              'op_stock', 'target_pks', 'required_pks',
              'req_pots', 'req_lids', 'req_foil', 'req_trays',
              'stock_pots', 'stock_lids', 'stock_foil', 'stock_trays',
              'more_pots', 'more_lids', 'more_foil', 'more_trays', 'culture_total_g',
              'actual_filling', 'op_total');                       // ★ NEW
/* text columns => max length */
$txt  = array('culture1_g' => 30, 'culture2_g' => 30, 'culture3_g' => 30,
              'tank_am' => 20, 'tank_pm' => 20, 'batch_code' => 20,   // ★ NEW
              'manual_fields' => 255);                                // ★ NEW (cells typed by hand)

foreach ($items as $it) {
    $p = isset($it['product_id']) ? (int) $it['product_id'] : 0;
    if ($p <= 0 || isset($seen[$p])) continue;
    $seen[$p] = 1;

    $vals = array();
    $set  = array();
    foreach ($cols as $c) {
        $v = isset($it[$c]) ? (float) $it[$c] : 0;
        $vals[] = $v;
        $set[]  = "$c=$v";
    }
    $names = $cols;
    foreach ($txt as $c => $max) {
        $v = isset($it[$c]) ? "'" . mysqli_real_escape_string($con, substr((string) $it[$c], 0, $max)) . "'" : "''";
        $names[] = $c;
        $vals[]  = $v;
        $set[]   = "$c=$v";
    }

    /* ★ NEW — date / time columns: empty or invalid → NULL */
    $d = isset($it['best_before']) ? (string) $it['best_before'] : '';
    $v = preg_match('/^\d{4}-\d{2}-\d{2}$/', $d) ? "'$d'" : 'NULL';
    $names[] = 'best_before'; $vals[] = $v; $set[] = "best_before=$v";

    $t = isset($it['finish_time']) ? (string) $it['finish_time'] : '';
    $v = preg_match('/^\d{1,2}:\d{2}(:\d{2})?$/', $t) ? "'$t'" : 'NULL';
    $names[] = 'finish_time'; $vals[] = $v; $set[] = "finish_time=$v";

    $r_ok = mysqli_query($con, "INSERT INTO yogurt_plan (week_friday, product_id, " . implode(',', $names) . ")
                                VALUES ('$friday', $p, " . implode(',', $vals) . ")
                                ON DUPLICATE KEY UPDATE " . implode(',', $set));
    if (!$r_ok) { $ok = false; $err = mysqli_error($con); }
}

if ($ok) {
    echo json_encode(array('ok' => true));
} else {
    echo json_encode(array('ok' => false, 'msg' => 'DB error: ' . $err));
}