<?php
// ================= Culture plan task tracker =================
require_once __DIR__ . '/includes/auth.php';
$u = require_login();
csrf_check();
$page = 'tasks';
$pdo = db();
$msg = ''; $err = '';
$canManage = is_role('admin', 'manager');

// ---- actions ----
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'create' && $canManage) {
        $title = trim($_POST['title'] ?? '');
        if ($title === '') {
            $err = 'Task title is required.';
        } else {
            $stmt = $pdo->prepare(
              'INSERT INTO tasks (title, description, dimension_id, site_id, owner_user_id, owner_role, due_date, priority, effectiveness_measure, created_by)
               VALUES (?,?,?,?,?,?,?,?,?,?)');
            $stmt->execute([
                mb_substr($title, 0, 200),
                trim($_POST['description'] ?? '') ?: null,
                $_POST['dimension_id'] !== '' ? (int)$_POST['dimension_id'] : null,
                $_POST['site_id'] !== '' ? (int)$_POST['site_id'] : null,
                $_POST['owner_user_id'] !== '' ? (int)$_POST['owner_user_id'] : null,
                trim($_POST['owner_role'] ?? '') ?: null,
                $_POST['due_date'] !== '' ? $_POST['due_date'] : null,
                in_array($_POST['priority'] ?? '', ['low','medium','high'], true) ? $_POST['priority'] : 'medium',
                trim($_POST['effectiveness_measure'] ?? '') ?: null,
                $u['id'],
            ]);
            $msg = 'Task created.';
        }
    }

    if ($action === 'status') {
        $taskId = (int)($_POST['task_id'] ?? 0);
        $status = $_POST['status'] ?? '';
        if (in_array($status, ['open','in_progress','completed'], true)) {
            // employees may only update tasks assigned to them
            $t = $pdo->prepare('SELECT * FROM tasks WHERE id = ?');
            $t->execute([$taskId]);
            $task = $t->fetch();
            if ($task && ($canManage || (int)$task['owner_user_id'] === (int)$u['id'])) {
                $evidence = trim($_POST['evidence'] ?? '');
                $stmt = $pdo->prepare(
                  'UPDATE tasks SET status = ?, evidence = COALESCE(NULLIF(?, ""), evidence),
                   completed_at = CASE WHEN ? = "completed" THEN NOW() ELSE NULL END WHERE id = ?');
                $stmt->execute([$status, $evidence, $status, $taskId]);
                $msg = 'Task updated.';
            } else {
                $err = 'You can only update tasks assigned to you.';
            }
        }
    }

    if ($action === 'delete' && is_role('admin')) {
        $stmt = $pdo->prepare('DELETE FROM tasks WHERE id = ?');
        $stmt->execute([(int)($_POST['task_id'] ?? 0)]);
        $msg = 'Task deleted.';
    }
}

// ---- filters ----
$fStatus = $_GET['status'] ?? '';
$fSite = $_GET['site'] ?? '';
$fMine = isset($_GET['mine']);
$where = []; $params = [];
if (in_array($fStatus, ['open','in_progress','completed'], true)) { $where[] = 't.status = ?'; $params[] = $fStatus; }
if ($fStatus === 'overdue') { $where[] = "t.status <> 'completed' AND t.due_date IS NOT NULL AND t.due_date < CURDATE()"; }
if ($fSite !== '') { $where[] = '(t.site_id = ? OR t.site_id IS NULL)'; $params[] = (int)$fSite; }
if ($fMine) { $where[] = 't.owner_user_id = ?'; $params[] = $u['id']; }
$whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

$list = $pdo->prepare(
  "SELECT t.*, d.name AS dim, s.name AS site_name, us.full_name AS owner_name
   FROM tasks t
   LEFT JOIN dimensions d ON d.id = t.dimension_id
   LEFT JOIN sites s ON s.id = t.site_id
   LEFT JOIN users us ON us.id = t.owner_user_id
   $whereSql
   ORDER BY (t.status='completed'), t.due_date IS NULL, t.due_date");
$list->execute($params);
$tasks = $list->fetchAll();

$sites = $pdo->query('SELECT * FROM sites ORDER BY name')->fetchAll();
$dims  = $pdo->query('SELECT * FROM dimensions ORDER BY sort_order')->fetchAll();
$users = $canManage ? $pdo->query('SELECT id, full_name FROM users WHERE active=1 ORDER BY full_name')->fetchAll() : [];

include __DIR__ . '/includes/header.php';
?>
<h1>Culture Plan Tasks</h1>
<p class="sub">Every activity in the culture plan (FSC-PLAN-001 Section 7) is tracked here with its owner, due date, effectiveness measure and completion evidence — the audit trail for BRCGS 1.1.2 and FSSC 2.5.8.</p>

<?php if ($msg): ?><div class="alert ok"><?= e($msg) ?></div><?php endif; ?>
<?php if ($err): ?><div class="alert err"><?= e($err) ?></div><?php endif; ?>

<div class="panel">
  <form method="get" action="tasks.php" style="display:flex;gap:16px;align-items:flex-end;flex-wrap:wrap">
    <div><label>Status</label>
      <select name="status" onchange="this.form.submit()">
        <option value="">All</option>
        <option value="open" <?= $fStatus==='open'?'selected':'' ?>>Open</option>
        <option value="in_progress" <?= $fStatus==='in_progress'?'selected':'' ?>>In progress</option>
        <option value="completed" <?= $fStatus==='completed'?'selected':'' ?>>Completed</option>
        <option value="overdue" <?= $fStatus==='overdue'?'selected':'' ?>>Overdue</option>
      </select></div>
    <div><label>Site</label>
      <select name="site" onchange="this.form.submit()">
        <option value="">All / group</option>
        <?php foreach ($sites as $s): ?><option value="<?= (int)$s['id'] ?>" <?= $fSite!=='' && (int)$fSite===(int)$s['id']?'selected':'' ?>><?= e($s['name']) ?></option><?php endforeach; ?>
      </select></div>
    <label style="display:flex;align-items:center;gap:6px;margin:0 0 10px"><input type="checkbox" name="mine" value="1" <?= $fMine?'checked':'' ?> onchange="this.form.submit()"> My tasks only</label>
  </form>
</div>

<table class="data">
  <tr><th>Task</th><th>Dimension</th><th>Site</th><th>Owner</th><th>Due</th><th>Priority</th><th>Status</th><th>Actions</th></tr>
  <?php foreach ($tasks as $t):
    $overdue = $t['status'] !== 'completed' && $t['due_date'] && $t['due_date'] < date('Y-m-d');
    $canUpdate = $canManage || (int)$t['owner_user_id'] === (int)$u['id']; ?>
  <tr>
    <td>
      <strong><?= e($t['title']) ?></strong>
      <?php if ($t['description']): ?><br><span class="sub" style="margin:0"><?= e($t['description']) ?></span><?php endif; ?>
      <?php if ($t['effectiveness_measure']): ?><br><span class="sub" style="margin:0">Measure: <?= e($t['effectiveness_measure']) ?></span><?php endif; ?>
      <?php if ($t['evidence']): ?><br><span class="sub" style="margin:0">Evidence: <?= e($t['evidence']) ?></span><?php endif; ?>
    </td>
    <td><?= e($t['dim'] ?? '—') ?></td>
    <td><?= e($t['site_name'] ?? 'Group') ?></td>
    <td><?= e($t['owner_name'] ?? ($t['owner_role'] ?? '—')) ?></td>
    <td><?= e($t['due_date'] ?? '—') ?></td>
    <td><span class="badge b-<?= e($t['priority']) ?>"><?= e($t['priority']) ?></span></td>
    <td><span class="badge b-<?= $overdue ? 'overdue' : e($t['status']) ?>"><?= $overdue ? 'overdue' : e(str_replace('_',' ', $t['status'])) ?></span></td>
    <td>
      <?php if ($canUpdate): ?>
      <form method="post" action="tasks.php" style="display:flex;gap:6px;flex-direction:column;min-width:150px">
        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
        <input type="hidden" name="action" value="status">
        <input type="hidden" name="task_id" value="<?= (int)$t['id'] ?>">
        <select name="status">
          <option value="open" <?= $t['status']==='open'?'selected':'' ?>>Open</option>
          <option value="in_progress" <?= $t['status']==='in_progress'?'selected':'' ?>>In progress</option>
          <option value="completed" <?= $t['status']==='completed'?'selected':'' ?>>Completed</option>
        </select>
        <input type="text" name="evidence" placeholder="Completion evidence">
        <button class="btn small" type="submit">Update</button>
      </form>
      <?php if (is_role('admin')): ?>
      <form method="post" action="tasks.php" onsubmit="return confirm('Delete this task?')">
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
  <?php if (!$tasks): ?><tr><td colspan="8">No tasks match this filter.</td></tr><?php endif; ?>
</table>

<?php if ($canManage): ?>
<div class="panel" style="margin-top:22px">
  <h2>Add a task</h2>
  <form method="post" action="tasks.php">
    <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
    <input type="hidden" name="action" value="create">
    <div class="grid2">
      <div>
        <label>Title *</label><input type="text" name="title" required maxlength="200">
        <label>Description</label><textarea name="description"></textarea>
        <label>Effectiveness measure</label><input type="text" name="effectiveness_measure" maxlength="255" placeholder="How will you know it worked?">
      </div>
      <div>
        <label>GFSI dimension</label>
        <select name="dimension_id"><option value="">—</option>
          <?php foreach ($dims as $d): ?><option value="<?= (int)$d['id'] ?>"><?= e($d['name']) ?></option><?php endforeach; ?>
        </select>
        <label>Site</label>
        <select name="site_id"><option value="">Group-wide</option>
          <?php foreach ($sites as $s): ?><option value="<?= (int)$s['id'] ?>"><?= e($s['name']) ?></option><?php endforeach; ?>
        </select>
        <label>Assign to user</label>
        <select name="owner_user_id"><option value="">—</option>
          <?php foreach ($users as $us): ?><option value="<?= (int)$us['id'] ?>"><?= e($us['full_name']) ?></option><?php endforeach; ?>
        </select>
        <label>Or owner role (RACI label)</label><input type="text" name="owner_role" maxlength="80" placeholder="e.g. Site Directors">
        <label>Due date</label><input type="date" name="due_date">
        <label>Priority</label>
        <select name="priority"><option>medium</option><option>high</option><option>low</option></select>
      </div>
    </div>
    <button class="btn" type="submit">Create task</button>
  </form>
</div>
<?php endif; ?>
<?php include __DIR__ . '/includes/footer.php'; ?>
