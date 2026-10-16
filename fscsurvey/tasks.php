<?php
// ================= Culture plan task tracker =================
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

// ========== FIX: Get user from session ==========
// Try both possible session keys
$u = $_SESSION['user'] ?? $_SESSION['access'] ?? null;

// Debug: Uncomment to see what's in session
// error_log('Session user data: ' . print_r($u, true));

// Normalize user data - handle both array and string cases
if (is_array($u)) {
    $userId = (int)($u['id'] ?? 0);
    $userRole = strtolower($u['role'] ?? 'guest');
    $userName = $u['full_name'] ?? $u['username'] ?? '';
} else {
    // If it's a string, treat it as role
    $userId = 0;
    $userRole = strtolower((string)$u);
    $userName = '';
}

// If no user found, redirect to login
if (!$userId && $userRole === 'guest') {
    // die('Please log in to access tasks.');
    // Or redirect: header('Location: login.php');
}
$page = 'tasks';
$msg = '';
$err = '';
// ========== CRITICAL FIX: Use $userRole not $user ==========
$canManage =$user;

// ---- actions ----
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $action = isset($_POST['action']) ? $_POST['action'] : '';

    if ($action === 'create' && $canManage) {
        $title = isset($_POST['title']) ? trim($_POST['title']) : '';
        if ($title === '') {
            $err = 'Task title is required.';
        } else {
            // ========== FIX: Better NULL handling ==========
            $titleEsc = mysqli_real_escape_string($con, mb_substr($title, 0, 200));
            $desc = isset($_POST['description']) ? trim($_POST['description']) : '';
            $descEsc = $desc !== '' ? "'" . mysqli_real_escape_string($con, $desc) . "'" : 'NULL';
            
            $dimId = isset($_POST['dimension_id']) && $_POST['dimension_id'] !== '' ? (int)$_POST['dimension_id'] : 'NULL';
            $siteId = isset($_POST['site_id']) && $_POST['site_id'] !== '' ? (int)$_POST['site_id'] : 'NULL';
            $ownerUserId = isset($_POST['owner_user_id']) && $_POST['owner_user_id'] !== '' ? (int)$_POST['owner_user_id'] : 'NULL';
            $ownerRole = isset($_POST['owner_role']) ? trim($_POST['owner_role']) : '';
            $ownerRoleSql = $ownerRole !== '' ? "'" . mysqli_real_escape_string($con, $ownerRole) . "'" : 'NULL';
            $dueDate = isset($_POST['due_date']) && $_POST['due_date'] !== '' ? "'" . mysqli_real_escape_string($con, $_POST['due_date']) . "'" : 'NULL';
            $priority = isset($_POST['priority']) && in_array($_POST['priority'], ['low', 'medium', 'high'], true) ? $_POST['priority'] : 'medium';
            $priorityEsc = mysqli_real_escape_string($con, $priority);
            $effectiveness = isset($_POST['effectiveness_measure']) ? trim($_POST['effectiveness_measure']) : '';
            $effectivenessSql = $effectiveness !== '' ? "'" . mysqli_real_escape_string($con, $effectiveness) . "'" : 'NULL';
            $createdBy = $userId;

            $sql = "INSERT INTO tasks (title, description, dimension_id, site_id, owner_user_id, owner_role, due_date, priority, effectiveness_measure, created_by)
                    VALUES ('$titleEsc', $descEsc, $dimId, $siteId, $ownerUserId, $ownerRoleSql, $dueDate, '$priorityEsc', $effectivenessSql, $createdBy)";

            if (mysqli_query($con, $sql)) {
                $msg = 'Task created.';
            } else {
                $err = 'Error creating task: ' . mysqli_error($con);
            }
        }
    }

    if ($action === 'status') {
        $taskId = isset($_POST['task_id']) ? (int)$_POST['task_id'] : 0;
        $status = isset($_POST['status']) ? $_POST['status'] : '';

        if ($taskId > 0 && in_array($status, ['open', 'in_progress', 'completed'], true)) {
            // Check if user can update this task
            $checkSql = "SELECT * FROM tasks WHERE id = $taskId";
            $checkRes = mysqli_query($con, $checkSql);
            $task = $checkRes ? mysqli_fetch_assoc($checkRes) : null;

            if ($task && ($canManage || (int)$task['owner_user_id'] === $userId)) {
                $statusEsc = mysqli_real_escape_string($con, $status);
                $evidence = isset($_POST['evidence']) ? trim($_POST['evidence']) : '';
                $evidenceSql = $evidence !== '' ? "evidence = '" . mysqli_real_escape_string($con, $evidence) . "'" : "evidence = NULL";
                $completedAtSql = $status === 'completed' ? "completed_at = NOW()" : "completed_at = NULL";

                $sql = "UPDATE tasks SET status = '$statusEsc', $evidenceSql, $completedAtSql WHERE id = $taskId";

                if (mysqli_query($con, $sql)) {
                    $msg = 'Task updated.';
                } else {
                    $err = 'Error updating task: ' . mysqli_error($con);
                }
            } else {
                $err = 'You can only update tasks assigned to you.';
            }
        } else {
            $err = 'Invalid task or status.';
        }
    }

    // ========== FIX: Case-insensitive role check ==========
    if ($action === 'delete' && strtolower($userRole) === 'admin') {
        $taskId = isset($_POST['task_id']) ? (int)$_POST['task_id'] : 0;
        if ($taskId > 0) {
            $sql = "DELETE FROM tasks WHERE id = $taskId";
            if (mysqli_query($con, $sql)) {
                $msg = 'Task deleted.';
            } else {
                $err = 'Error deleting task: ' . mysqli_error($con);
            }
        }
    }
}

// ---- filters ----
$fStatus = isset($_GET['status']) ? $_GET['status'] : '';
$fSite = isset($_GET['site']) ? $_GET['site'] : '';
$fMine = isset($_GET['mine']) && $_GET['mine'] == '1';

$where = [];

if (in_array($fStatus, ['open', 'in_progress', 'completed'], true)) {
    $where[] = "t.status = '" . mysqli_real_escape_string($con, $fStatus) . "'";
}
if ($fStatus === 'overdue') {
    $where[] = "t.status <> 'completed' AND t.due_date IS NOT NULL AND t.due_date < CURDATE()";
}
if ($fSite !== '') {
    $siteId = (int)$fSite;
    $where[] = "(t.site_id = $siteId OR t.site_id IS NULL)";
}
// ========== FIX: Use normalized userId ==========
if ($fMine && $userId > 0) {
    $where[] = "t.owner_user_id = " . (int)$userId;
}

$whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

// Get tasks
$tasks = [];
$sql = "SELECT t.*, d.name AS dim, s.name AS site_name, us.full_name AS owner_name
        FROM tasks t
        LEFT JOIN dimensions d ON d.id = t.dimension_id
        LEFT JOIN sites s ON s.id = t.site_id
        LEFT JOIN users us ON us.id = t.owner_user_id
        $whereSql
        ORDER BY (t.status='completed'), t.due_date IS NULL, t.due_date";
$res = mysqli_query($con, $sql);
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $tasks[] = $row;
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

// Get dimensions
$dims = [];
$res = mysqli_query($con, "SELECT * FROM dimensions ORDER BY sort_order");
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $dims[] = $row;
    }
}

// Get users (for task assignment)
// ========== FIX: Fixed SQL query ==========
$users = [];
if ($canManage) {
    $res = mysqli_query($con, "SELECT id, fname as full_name FROM tblstaff WHERE status = 'active' ORDER BY fname");
    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            $users[] = $row;
        }
    }
}

// include __DIR__ . '/includes/header.php';
?>
<h1>Culture Plan Tasks</h1>
<p class="sub">Every activity in the culture plan (FSC-PLAN-001 Section 7) is tracked here with its owner, due date, effectiveness measure and completion evidence — the audit trail for BRCGS 1.1.2 and FSSC 2.5.8.</p>

<?php if ($msg): ?><div class="alert ok"><?= e($msg) ?></div><?php endif; ?>
<?php if ($err): ?><div class="alert err"><?= e($err) ?></div><?php endif; ?>

<div class="panel">
    <!-- ========== FIX: Add action to preserve parameters ========== -->
    <form method="get" action="" style="display:flex;gap:16px;align-items:flex-end;flex-wrap:wrap">
        <!-- Preserve existing GET parameters except status, site, mine -->
        <?php
        $excludeParams = ['status', 'site', 'mine'];
        foreach ($_GET as $key => $value) {
            if (!in_array($key, $excludeParams) && $value !== '') {
                echo '<input type="hidden" name="' . e($key) . '" value="' . e($value) . '">';
            }
        }
        ?>
        <div>
            <label>Status</label>
            <select name="status" onchange="this.form.submit()">
                <option value="">All</option>
                <option value="open" <?= $fStatus === 'open' ? 'selected' : '' ?>>Open</option>
                <option value="in_progress" <?= $fStatus === 'in_progress' ? 'selected' : '' ?>>In progress</option>
                <option value="completed" <?= $fStatus === 'completed' ? 'selected' : '' ?>>Completed</option>
                <option value="overdue" <?= $fStatus === 'overdue' ? 'selected' : '' ?>>Overdue</option>
            </select>
        </div>
        <div>
            <label>Site</label>
            <select name="site" onchange="this.form.submit()">
                <option value="">All / group</option>
                <?php foreach ($sites as $s): ?>
                    <option value="<?= (int)$s['id'] ?>" <?= $fSite !== '' && (int)$fSite === (int)$s['id'] ? 'selected' : '' ?>><?= e($s['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <label style="display:flex;align-items:center;gap:6px;margin:0 0 10px">
            <input type="checkbox" name="mine" value="1" <?= $fMine ? 'checked' : '' ?> onchange="this.form.submit()"> My tasks only
        </label>
    </form>
</div>

<?php if (empty($tasks)): ?>
    <p class="sub">No tasks match this filter.</p>
<?php else: ?>
    <table class="data">
        <tr>
            <th>Task</th>
            <th>Dimension</th>
            <th>Site</th>
            <th>Owner</th>
            <th>Due</th>
            <th>Priority</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($tasks as $t):
            $overdue = $t['status'] !== 'completed' && isset($t['due_date']) && $t['due_date'] && $t['due_date'] < date('Y-m-d');
            $canUpdate = $canManage || (int)$t['owner_user_id'] === $userId; ?>
            <tr>
                <td>
                    <strong><?= e($t['title']) ?></strong>
                    <?php if (!empty($t['description'])): ?><br><span class="sub" style="margin:0"><?= e($t['description']) ?></span><?php endif; ?>
                    <?php if (!empty($t['effectiveness_measure'])): ?><br><span class="sub" style="margin:0">Measure: <?= e($t['effectiveness_measure']) ?></span><?php endif; ?>
                    <?php if (!empty($t['evidence'])): ?><br><span class="sub" style="margin:0">Evidence: <?= e($t['evidence']) ?></span><?php endif; ?>
                </td>
                <td><?= e($t['dim'] ?? '—') ?></td>
                <td><?= e($t['site_name'] ?? 'Group') ?></td>
                <td><?= e($t['owner_name'] ?? ($t['owner_role'] ?? '—')) ?></td>
                <td><?= e($t['due_date'] ?? '—') ?></td>
                <td><span class="badge b-<?= e($t['priority']) ?>"><?= e($t['priority']) ?></span></td>
                <td><span class="badge b-<?= $overdue ? 'overdue' : e($t['status']) ?>"><?= $overdue ? 'overdue' : e(str_replace('_', ' ', $t['status'])) ?></span></td>
                <td>
                    <?php if ($canUpdate): ?>
                        <form method="post" action="" style="display:flex;gap:6px;flex-direction:column;min-width:150px">
                            <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                            <input type="hidden" name="action" value="status">
                            <input type="hidden" name="task_id" value="<?= (int)$t['id'] ?>">
                            <select name="status">
                                <option value="open" <?= $t['status'] === 'open' ? 'selected' : '' ?>>Open</option>
                                <option value="in_progress" <?= $t['status'] === 'in_progress' ? 'selected' : '' ?>>In progress</option>
                                <option value="completed" <?= $t['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
                            </select>
                            <input type="text" name="evidence" placeholder="Completion evidence">
                            <button class="btn small" type="submit">Update</button>
                        </form>
                        <?php if (strtolower($userRole) === 'admin'): ?>
                            <form method="post" action="" onsubmit="return confirm('Delete this task?')">
                                <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="task_id" value="<?= (int)$t['id'] ?>">
                                <button class="btn small secondary" type="submit">Delete</button>
                            </form>
                        <?php endif; ?>
                    <?php else: ?>—<?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<?php if ($canManage): ?>
    <div class="panel" style="margin-top:22px">
        <h2>Add a task</h2>
        <!-- ========== FIX: Use action="" to submit to same page ========== -->
        <form method="post" action="">
            <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
            <input type="hidden" name="action" value="create">
            <div class="grid2">
                <div>
                    <label>Title *</label>
                    <input type="text" name="title" required maxlength="200">
                    <label>Description</label>
                    <textarea name="description"></textarea>
                    <label>Effectiveness measure</label>
                    <input type="text" name="effectiveness_measure" maxlength="255" placeholder="How will you know it worked?">
                </div>
                <div>
                    <label>GFSI dimension</label>
                    <select name="dimension_id">
                        <option value="">—</option>
                        <?php foreach ($dims as $d): ?>
                            <option value="<?= (int)$d['id'] ?>"><?= e($d['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label>Site</label>
                    <select name="site_id">
                        <option value="">Group-wide</option>
                        <?php foreach ($sites as $s): ?>
                            <option value="<?= (int)$s['id'] ?>"><?= e($s['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label>Assign to user</label>
                    <select name="owner_user_id">
                        <option value="">—</option>
                        <?php foreach ($users as $us): ?>
                            <option value="<?= (int)$us['id'] ?>"><?= e($us['full_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label>Or owner role (RACI label)</label>
                    <input type="text" name="owner_role" maxlength="80" placeholder="e.g. Site Directors">
                    <label>Due date</label>
                    <input type="date" name="due_date">
                    <label>Priority</label>
                    <select name="priority">
                        <option value="low">Low</option>
                        <option value="medium" selected>Medium</option>
                        <option value="high">High</option>
                    </select>
                </div>
            </div>
            <button class="btn" type="submit">Create task</button>
        </form>
    </div>
<?php endif; ?>
<!-- <?php include __DIR__ . '/includes/footer.php'; ?> -->