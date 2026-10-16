<?php
// ================= Manage survey rounds (admin) =================
include('connection.php');

// Start session if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Helper functions
if (!function_exists('e')) {
    function e($str) {
        return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('csrf_token')) {
    function csrf_token() {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
}

if (!function_exists('csrf_check')) {
    function csrf_check() {
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

// // Check if user is admin
// if (($u['role'] ?? '') !== 'admin') {
//     die('Access denied. Admin privileges required.');
// }

$page = 'surveys_admin';
$msg = '';
$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $action = isset($_POST['action']) ? $_POST['action'] : '';

    if ($action === 'create') {
        $title = isset($_POST['title']) ? trim($_POST['title']) : '';
        $rtype = isset($_POST['rtype']) && $_POST['rtype'] === 'pulse' ? 'pulse' : 'annual';
        $opens = isset($_POST['opens_on']) ? $_POST['opens_on'] : '';
        $closes = isset($_POST['closes_on']) ? $_POST['closes_on'] : '';
        
        if ($title === '' || !$opens || !$closes || $closes < $opens) {
            $err = 'Provide a title and a valid open/close date range.';
        } else {
            $titleEsc = mysqli_real_escape_string($con, mb_substr($title, 0, 120));
            $rtypeEsc = mysqli_real_escape_string($con, $rtype);
            $opensEsc = mysqli_real_escape_string($con, $opens);
            $closesEsc = mysqli_real_escape_string($con, $closes);

            $sql = "INSERT INTO survey_rounds (title, rtype, opens_on, closes_on, status)
                    VALUES ('$titleEsc', '$rtypeEsc', '$opensEsc', '$closesEsc', 'draft')";
            
            if (mysqli_query($con, $sql)) {
                $roundId = mysqli_insert_id($con);
                
                // copy headcounts submitted with the form
                $headcounts = isset($_POST['headcount']) ? $_POST['headcount'] : [];
                if (is_array($headcounts)) {
                    foreach ($headcounts as $sid => $hc) {
                        if ((int)$hc > 0) {
                            $sidInt = (int)$sid;
                            $hcInt = (int)$hc;
                            $hcSql = "INSERT INTO site_headcount (site_id, round_id, headcount) VALUES ($sidInt, $roundId, $hcInt)";
                            mysqli_query($con, $hcSql);
                        }
                    }
                }
                $msg = 'Survey round created as draft.';
            } else {
                $err = 'Error creating round: ' . mysqli_error($con);
            }
        }
    }

    if ($action === 'setstatus') {
        $status = isset($_POST['status']) ? $_POST['status'] : '';
        $roundId = isset($_POST['round_id']) ? (int)$_POST['round_id'] : 0;
        
        if ($roundId > 0 && in_array($status, ['draft', 'open', 'closed'], true)) {
            // only one round open at a time
            if ($status === 'open') {
                mysqli_query($con, "UPDATE survey_rounds SET status='closed' WHERE status='open'");
            }
            $statusEsc = mysqli_real_escape_string($con, $status);
            $sql = "UPDATE survey_rounds SET status = '$statusEsc' WHERE id = $roundId";
            if (mysqli_query($con, $sql)) {
                $msg = 'Round status updated.';
            } else {
                $err = 'Error updating status: ' . mysqli_error($con);
            }
        } else {
            $err = 'Invalid status or round ID.';
        }
    }
}

// Get rounds
$rounds = [];

$sql = "SELECT sr.*, (SELECT COUNT(*) FROM responses r WHERE r.round_id = sr.id) AS resp_count
        FROM survey_rounds sr ORDER BY sr.opens_on DESC";
$res = mysqli_query($con, $sql);
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $rounds[] = $row;
    }
}

// Get sites
$sites = [];
$res = mysqli_query($con, "SELECT * FROM sites ORDER BY name");
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $sites[] = $row;
    }
}

// include __DIR__ . '/includes/header.php';
?>
<h1>Manage Survey Rounds</h1>
<p class="sub">Annual survey: all 25 questions + free text. Pulse: same instrument, shorter window (per SOP-FSC-002 keep pulses to ~1 week). Opening a round automatically closes any other open round.</p>

<?php if ($msg): ?><div class="alert ok"><?= e($msg) ?></div><?php endif; ?>
<?php if ($err): ?><div class="alert err"><?= e($err) ?></div><?php endif; ?>

<?php if (empty($rounds)): ?>
    <p class="sub">No survey rounds created yet.</p>
<?php else: ?>
    <table class="data">
        <tr>
            <th>Title</th>
            <th>Type</th>
            <th>Opens</th>
            <th>Closes</th>
            <th>Status</th>
            <th>Responses</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($rounds as $r): ?>
        <tr>
            <td><?= e($r['title'] ?? 'Untitled') ?></td>
            <td><?= e($r['rtype'] ?? 'annual') ?></td>
            <td><?= e($r['opens_on'] ?? '—') ?></td>
            <td><?= e($r['closes_on'] ?? '—') ?></td>
            <td>
                <span class="badge <?= ($r['status'] ?? '') === 'open' ? 'b-completed' : (($r['status'] ?? '') === 'draft' ? 'b-open' : 'b-in_progress') ?>">
                    <?= e($r['status'] ?? 'draft') ?>
                </span>
            </td>
            <td><?= isset($r['resp_count']) ? (int)$r['resp_count'] : 0 ?></td>
            <td>
                <form method="post" action="" style="display:flex;gap:6px">
                    <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                    <input type="hidden" name="action" value="setstatus">
                    <input type="hidden" name="round_id" value="<?= (int)$r['id'] ?>">
                    <?php if (($r['status'] ?? '') !== 'open'): ?>
                        <button class="btn small" name="status" value="open">Open</button>
                    <?php endif; ?>
                    <?php if (($r['status'] ?? '') === 'open'): ?>
                        <button class="btn small secondary" name="status" value="closed">Close</button>
                    <?php endif; ?>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<div class="panel" style="margin-top:22px">
    <h2>Create a new round</h2>
    <form method="post" action="">
        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
        <input type="hidden" name="action" value="create">
        <div class="grid2">
            <div>
                <label>Title *</label>
                <input type="text" name="title" required maxlength="120" placeholder="e.g. 2027 Annual Culture Survey">
                
                <label>Type</label>
                <select name="rtype">
                    <option value="annual">Annual (full)</option>
                    <option value="pulse">Pulse (quarterly)</option>
                </select>
                
                <label>Opens on *</label>
                <input type="date" name="opens_on" required>
                
                <label>Closes on *</label>
                <input type="date" name="closes_on" required>
            </div>
            <div>
                <h2 style="margin-top:0">Headcount per site (for participation %)</h2>
                <?php if (empty($sites)): ?>
                    <p class="sub">No sites defined yet.</p>
                <?php else: ?>
                    <?php foreach ($sites as $s): ?>
                        <label><?= e($s['name'] ?? 'Unnamed Site') ?></label>
                        <input type="text" name="headcount[<?= (int)$s['id'] ?>]" placeholder="e.g. 180" pattern="[0-9]*">
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <button class="btn" type="submit">Create draft round</button>
    </form>
</div>
<!-- <?php include __DIR__ . '/includes/footer.php'; ?> -->