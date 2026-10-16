<?php
// ============================================================
// RTNTS FSC Portal — one-time installation check
// Open this page in your browser AFTER editing config.php.
// DELETE THIS FILE once everything shows OK.
// ============================================================
error_reporting(E_ALL);
ini_set('display_errors', '1');

$checks = [];

// 1. PHP version
$checks[] = ['PHP version ' . PHP_VERSION . ' (need 7.4+)', version_compare(PHP_VERSION, '7.4.0', '>=')];

// 2. PDO MySQL extension
$checks[] = ['PDO MySQL extension loaded', extension_loaded('pdo_mysql')];

// 3. config.php present
$cfgOk = file_exists(__DIR__ . '/config.php');
$checks[] = ['config.php found', $cfgOk];

// 4. Database connection + tables
$dbOk = false; $tblMsg = 'skipped (no DB connection)'; $tblOk = false; $adminOk = false; $adminMsg = 'skipped';
if ($cfgOk) {
    require_once __DIR__ . '/config.php';
    try {
        $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASS,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        $dbOk = true;
        $need = ['sites','departments','dimensions','users','questions','survey_rounds','responses','answers','tasks','plan_phases','plan_steps','site_headcount'];
        $have = $pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);
        $missing = array_diff($need, $have);
        $tblOk = count($missing) === 0;
        $tblMsg = $tblOk ? 'all ' . count($need) . ' tables present' : 'MISSING: ' . implode(', ', $missing) . ' — import database/schema_cpanel.sql in phpMyAdmin';
        $q = $pdo->query("SELECT COUNT(*) FROM users WHERE role='admin' AND active=1")->fetchColumn();
        $adminOk = $q > 0;
        $adminMsg = $adminOk ? $q . ' active admin user(s)' : 'no active admin user found';
    } catch (Throwable $e) {
        $tblMsg = 'connection failed: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . ' — check DB_HOST/DB_NAME/DB_USER/DB_PASS in config.php';
    }
}
$checks[] = ['Database connection (' . (defined('DB_NAME') ? htmlspecialchars(DB_NAME, ENT_QUOTES, 'UTF-8') : '?') . ')', $dbOk];
$checks[] = ['Tables: ' . $tblMsg, $tblOk];
$checks[] = ['Admin account: ' . $adminMsg, $adminOk];

// 5. Sessions writable
$sessOk = @session_start();
$checks[] = ['PHP sessions working', (bool)$sessOk];

$allOk = array_reduce($checks, fn($c, $x) => $c && $x[1], true);
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="utf-8"><title>FSC Portal — Install Check</title>
<style>
body{font-family:"Century Gothic",sans-serif;background:#F1F4F8;color:#1A1A2E;max-width:760px;margin:40px auto;padding:0 16px}
h1{color:#1B3A7B}.item{background:#fff;border:1px solid #C8CDD5;border-radius:10px;padding:12px 18px;margin:10px 0;display:flex;gap:12px;align-items:center}
.ok{color:#1E7B45;font-weight:bold}.fail{color:#A33333;font-weight:bold}
.banner{border-radius:10px;padding:14px 18px;font-weight:bold;margin:18px 0}
.banner.good{background:#E4F2E9;color:#1E7B45;border:1px solid #1E7B45}
.banner.bad{background:#F7E6E6;color:#A33333;border:1px solid #A33333}
a{color:#1B3A7B}
</style></head>
<body>
<h1>Food Safety Culture Portal — Installation Check</h1>
<?php foreach ($checks as [$label, $ok]): ?>
  <div class="item"><span class="<?= $ok ? 'ok' : 'fail' ?>"><?= $ok ? '&#10004; OK' : '&#10008; FAIL' ?></span> <span><?= $label ?></span></div>
<?php endforeach; ?>
<?php if ($allOk): ?>
  <div class="banner good">Everything looks good. <a href="login.php">Go to the login page</a> — sign in as <strong>admin / ChangeMe123!</strong>, change the password immediately (Users &rarr; Reset), then <strong>delete this file (install_check.php) from the server</strong>.</div>
<?php else: ?>
  <div class="banner bad">Fix the items marked FAIL above, then reload this page.</div>
<?php endif; ?>
</body>
</html>
