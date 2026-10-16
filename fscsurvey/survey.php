<?php
// ================= Anonymous culture survey =================
include('connection.php');

// Start session if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define constants if not defined
if (!defined('MIN_GROUP_SIZE')) {
    define('MIN_GROUP_SIZE', 5);
}

// Helper functions
if (!function_exists('e')) {
    function e($str)
    {
        return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('csrf_token')) {
    function csrf_token()
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
}

if (!function_exists('csrf_check')) {
    function csrf_check()
    {
        if (!isset($_POST['csrf']) || $_POST['csrf'] !== ($_SESSION['csrf_token'] ?? '')) {
            die('CSRF token validation failed.');
        }
    }
}

// Get current user from session
$u = $_SESSION['user'];
// if (!$u) {
//     $u = $GLOBALS['u'] ?? ['id' => 0, 'role' => 'guest'];
// }

// // // Check if user is logged in
// // if (!isset($u['id']) || $u['id'] == 0) {
// //     die('Please log in to take the survey.');
// // }

$page = 'survey';
$msg = '';
$err = '';

// Get open round
$round = null;
$res = mysqli_query($con, "SELECT * FROM survey_rounds WHERE status='open' AND opens_on <= CURDATE() AND closes_on >= CURDATE() ORDER BY opens_on DESC LIMIT 1");
if ($res && mysqli_num_rows($res) > 0) {
    $round = mysqli_fetch_assoc($res);
}

// Get sites
$sites = [];
$res = mysqli_query($con, "SELECT * FROM sites ORDER BY name");
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $sites[] = $row;
    }
}

// Get departments
$departments = [];
$res = mysqli_query($con, "SELECT * FROM departments ORDER BY name");
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $departments[] = $row;
    }
}

// Get questions
$questions = [];
$res = mysqli_query($con, "SELECT q.*, d.name AS dim FROM questions q LEFT JOIN dimensions d ON d.id=q.dimension_id WHERE q.active=1 ORDER BY q.sort_order");
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $questions[] = $row;
    }
}

// Handle POST submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $round) {
    // CSRF check
    csrf_check();

    $siteId = isset($_POST['site_id']) ? (int)$_POST['site_id'] : 0;
    $deptId = isset($_POST['department_id']) ? (int)$_POST['department_id'] : 0;
    $shift = isset($_POST['shift']) ? $_POST['shift'] : '';
    $validShift = in_array($shift, ['Days', 'Nights', 'Weekend', 'Rotating'], true);

    // Validate all likert questions answered
    $missing = false;
    foreach ($questions as $q) {
        if ($q['qtype'] === 'likert') {
            $v = isset($_POST['q' . $q['id']]) ? $_POST['q' . $q['id']] : '';
            if (!in_array($v, ['1', '2', '3', '4', '5'], true)) {
                $missing = true;
                break;
            }
        }
    }

    if (!$siteId || !$deptId || !$validShift) {
        $err = 'Please select your site, department and shift.';
    } elseif ($missing) {
        $err = 'Please answer every scored question before submitting.';
    } else {
        $roundId = (int)$round['id'];
        $shiftEsc = mysqli_real_escape_string($con, $shift);

        mysqli_begin_transaction($con);
        $ok = true;

        // Insert response
        $ok = $ok && mysqli_query(
            $con,
            "INSERT INTO responses (round_id, site_id, department_id, shift) 
             VALUES ($roundId, $siteId, $deptId, '$shiftEsc')"
        );

        if ($ok) {
            $respId = mysqli_insert_id($con);
            foreach ($questions as $q) {
                $qId = (int)$q['id'];
                if ($q['qtype'] === 'likert') {
                    $score = isset($_POST['q' . $q['id']]) ? (int)$_POST['q' . $q['id']] : 0;
                    if ($score >= 1 && $score <= 5) {
                        $ok = $ok && mysqli_query(
                            $con,
                            "INSERT INTO answers (response_id, question_id, score) 
                             VALUES ($respId, $qId, $score)"
                        );
                    }
                } else {
                    $c = isset($_POST['q' . $q['id']]) ? trim($_POST['q' . $q['id']]) : '';
                    if ($c !== '') {
                        $cEsc = mysqli_real_escape_string($con, mb_substr($c, 0, 2000));
                        $ok = $ok && mysqli_query(
                            $con,
                            "INSERT INTO answers (response_id, question_id, comment) 
                             VALUES ($respId, $qId, '$cEsc')"
                        );
                    }
                }
                if (!$ok) break;
            }
        }

        if ($ok) {
            mysqli_commit($con);
            $msg = 'Thank you — your anonymous response has been recorded.';
        } else {
            mysqli_rollback($con);
            $err = 'Something went wrong saving your response. Please try again.';
        }
    }
}

// include __DIR__ . '/includes/header.php';
?>
<h1>Food Safety Culture Survey</h1>

<?php if (!$round): ?>
    <div class="alert info">There is no survey open at the moment. Please check back later.</div>
<?php else: ?>
    <p class="sub"><strong><?= e($round['title']) ?></strong> — open until <?= e($round['closes_on']) ?>.
        Your answers are <strong>anonymous</strong>: we record only your site, department and shift, never your name.
        Results for groups smaller than <?= (int)MIN_GROUP_SIZE ?> people are never shown.</p>

    <?php if ($msg): ?><div class="alert ok"><?= e($msg) ?></div><?php endif; ?>
    <?php if ($err): ?><div class="alert err"><?= e($err) ?></div><?php endif; ?>

    <?php if (!$msg): ?>
        <form method="post" action="">
            <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">

            <div class="panel">
                <h2>About you (for grouping only)</h2>
                <div class="grid2">
                    <div>
                        <label>Site *</label>
                        <select name="site_id" required>
                            <option value="">— select —</option>
                            <?php foreach ($sites as $s): ?>
                                <option value="<?= (int)$s['id'] ?>"><?= e($s['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label>Department *</label>
                        <select name="department_id" required>
                            <option value="">— select —</option>
                            <?php foreach ($departments as $d): ?>
                                <option value="<?= (int)$d['id'] ?>"><?= e($d['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <label>Shift *</label>
                <select name="shift" required>
                    <option value="">— select —</option>
                    <option value="Days">Days</option>
                    <option value="Nights">Nights</option>
                    <option value="Weekend">Weekend</option>
                    <option value="Rotating">Rotating</option>
                </select>
            </div>

            <?php foreach ($questions as $i => $q): ?>
                <div class="q-block">
                    <div class="q-dim"><?= e($q['dim'] ?? 'Your comments') ?></div>
                    <div class="q-text"><?= ($i + 1) ?>. <?= e($q['qtext']) ?></div>

                    <?php if ($q['qtype'] === 'likert'): ?>
                        <div class="likert" style="display:flex; gap:20px; flex-wrap:wrap; margin-top:8px;">
                            <?php
                            $lbls = [
                                1 => 'Strongly disagree',
                                2 => 'Disagree',
                                3 => 'Neutral',
                                4 => 'Agree',
                                5 => 'Strongly agree'
                            ];
                            foreach ($lbls as $v => $l): ?>
                                <label style="display:flex; align-items:center; gap:4px; cursor:pointer; white-space:nowrap;">
                                    <input type="radio" name="q<?= (int)$q['id'] ?>" value="<?= $v ?>" required>
                                    <?= $v ?> — <?= e($l) ?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <textarea name="q<?= (int)$q['id'] ?>" maxlength="2000" placeholder="Optional — your words, no names please"></textarea>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>

            <button class="btn" type="submit">Submit anonymous response</button>
        </form>
    <?php endif; ?>
<?php endif; ?>


<!-- <?php include __DIR__ . '/includes/footer.php'; ?> -->