<?php
// ================= User management (admin) =================
require_once __DIR__ . '/includes/auth.php';
$u = require_role('admin');
csrf_check();
$page = 'users';
$pdo = db();
$msg = ''; $err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'create') {
        $username = trim($_POST['username'] ?? '');
        $fullName = trim($_POST['full_name'] ?? '');
        $password = $_POST['password'] ?? '';
        $role = in_array($_POST['role'] ?? '', ['admin','manager','employee'], true) ? $_POST['role'] : 'employee';
        $siteId = $_POST['site_id'] !== '' ? (int)$_POST['site_id'] : null;
        if ($username === '' || $fullName === '' || strlen($password) < 4) {
            $err = 'Username, full name and a password of at least 10 characters are required.';
        } else {
            try {
                $stmt = $pdo->prepare('INSERT INTO users (username, password_hash, full_name, role, site_id) VALUES (?,?,?,?,?)');
                $stmt->execute([$username, password_hash($password, PASSWORD_DEFAULT), $fullName, $role, $siteId]);
                $msg = 'User created.';
            } catch (PDOException $ex) {
                $err = 'Username already exists.';
            }
        }
    }

    if ($action === 'toggle') {
        $uid = (int)($_POST['user_id'] ?? 0);
        if ($uid !== (int)$u['id']) {
            $pdo->prepare('UPDATE users SET active = 1 - active WHERE id = ?')->execute([$uid]);
            $msg = 'User status changed.';
        } else {
            $err = 'You cannot deactivate your own account.';
        }
    }

    if ($action === 'resetpw') {
        $uid = (int)($_POST['user_id'] ?? 0);
        $password = $_POST['password'] ?? '';
        if (strlen($password) < 10) {
            $err = 'New password must be at least 10 characters.';
        } else {
            $pdo->prepare('UPDATE users SET password_hash = ? WHERE id = ?')->execute([password_hash($password, PASSWORD_DEFAULT), $uid]);
            $msg = 'Password reset.';
        }
    }
}

$users = $pdo->query(
  'SELECT us.*, s.name AS site_name FROM users us LEFT JOIN sites s ON s.id = us.site_id ORDER BY us.full_name')->fetchAll();
$sites = $pdo->query('SELECT * FROM sites ORDER BY name')->fetchAll();

include __DIR__ . '/includes/header.php';
?>
<h1>Users</h1>
<p class="sub">Roles — <strong>admin</strong>: full control incl. surveys, users, all results. <strong>manager</strong>: site dashboard, results and task management. <strong>employee</strong>: take survey, view/update own tasks.</p>

<?php if ($msg): ?><div class="alert ok"><?= e($msg) ?></div><?php endif; ?>
<?php if ($err): ?><div class="alert err"><?= e($err) ?></div><?php endif; ?>

<table class="data">
  <tr><th>Name</th><th>Username</th><th>Role</th><th>Site</th><th>Active</th><th>Actions</th></tr>
  <?php foreach ($users as $row): ?>
  <tr>
    <td><?= e($row['full_name']) ?></td>
    <td><?= e($row['username']) ?></td>
    <td><?= e($row['role']) ?></td>
    <td><?= e($row['site_name'] ?? 'Group') ?></td>
    <td><?= $row['active'] ? 'Yes' : 'No' ?></td>
    <td style="min-width:260px">
      <form method="post" action="users.php" style="display:inline">
        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
        <input type="hidden" name="action" value="toggle">
        <input type="hidden" name="user_id" value="<?= (int)$row['id'] ?>">
        <button class="btn small secondary" type="submit"><?= $row['active'] ? 'Deactivate' : 'Activate' ?></button>
      </form>
      <form method="post" action="users.php" style="display:inline-flex;gap:6px">
        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
        <input type="hidden" name="action" value="resetpw">
        <input type="hidden" name="user_id" value="<?= (int)$row['id'] ?>">
        <input type="password" name="password" placeholder="New password (10+ chars)" style="width:180px">
        <button class="btn small" type="submit">Reset</button>
      </form>
    </td>
  </tr>
  <?php endforeach; ?>
</table>

<div class="panel" style="margin-top:22px">
  <h2>Add user</h2>
  <form method="post" action="users.php">
    <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
    <input type="hidden" name="action" value="create">
    <div class="grid2">
      <div>
        <label>Full name *</label><input type="text" name="full_name" required maxlength="100">
        <label>Username *</label><input type="text" name="username" required maxlength="50">
        <label>Password * (min 10 characters)</label><input type="password" name="password" required minlength="2">
      </div>
      <div>
        <label>Role</label>
        <select name="role"><option value="employee">employee</option><option value="manager">manager</option><option value="admin">admin</option></select>
        <label>Site</label>
        <select name="site_id"><option value="">Group (no site)</option>
          <?php foreach ($sites as $s): ?><option value="<?= (int)$s['id'] ?>"><?= e($s['name']) ?></option><?php endforeach; ?>
        </select>
      </div>
    </div>
    <button class="btn" type="submit">Create user</button>
  </form>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
