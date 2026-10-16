<?php
// ================= User management (admin) =================
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

// // Check if user is admin
// if ($u['role'] !== 'admin') {
//     die('Access denied. Admin privileges required.');
// }

$page = 'users';
$msg = '';
$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $action = isset($_POST['action']) ? $_POST['action'] : '';

    if ($action === 'create') {
        $username = isset($_POST['username']) ? trim($_POST['username']) : '';
        $fullName = isset($_POST['full_name']) ? trim($_POST['full_name']) : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $role = isset($_POST['role']) && in_array($_POST['role'], ['admin', 'manager', 'employee'], true) ? $_POST['role'] : 'employee';
        $siteId = isset($_POST['site_id']) && $_POST['site_id'] !== '' ? (int)$_POST['site_id'] : null;

        if ($username === '' || $fullName === '' || strlen($password) < 10) {
            $err = 'Username, full name and a password of at least 10 characters are required.';
        } else {
            $usernameEsc = mysqli_real_escape_string($con, $username);
            $fullNameEsc = mysqli_real_escape_string($con, $fullName);
            $roleEsc = mysqli_real_escape_string($con, $role);
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $hashEsc = mysqli_real_escape_string($con, $hash);
            $siteIdSql = $siteId === null ? 'NULL' : (int)$siteId;

            $sql = "INSERT INTO users (username, password_hash, full_name, role, site_id)
                    VALUES ('$usernameEsc', '$hashEsc', '$fullNameEsc', '$roleEsc', $siteIdSql)";

            if (mysqli_query($con, $sql) === false) {
                if (mysqli_errno($con) === 1062) {
                    $err = 'Username already exists.';
                } else {
                    $err = 'Could not create user: ' . mysqli_error($con);
                }
            } else {
                $msg = 'User created.';
            }
        }
    }

    if ($action === 'toggle') {
        $uid = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;
        if ($uid === 0) {
            $err = 'Invalid user ID.';
        } elseif ($uid === (int)$u) {
            $err = 'You cannot deactivate your own account.';
        } else {
            $sql = "UPDATE users SET active = 1 - active WHERE id = " . (int)$uid;
            if (mysqli_query($con, $sql) === false) {
                $err = 'Failed to update user status: ' . mysqli_error($con);
            } else {
                $msg = 'User status changed.';
            }
        }
    }

    if ($action === 'resetpw') {
        $uid = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        if ($uid === 0) {
            $err = 'Invalid user ID.';
        } elseif (strlen($password) < 10) {
            $err = 'New password must be at least 10 characters.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $hashEsc = mysqli_real_escape_string($con, $hash);

            $checkSql = "SELECT id FROM users WHERE id = " . (int)$uid;
            $checkRes = mysqli_query($con, $checkSql);
            if ($checkRes && mysqli_num_rows($checkRes) === 0) {
                $err = 'User not found.';
            } else {
                $sql = "UPDATE users SET password_hash = '$hashEsc' WHERE id = " . (int)$uid;
                if (mysqli_query($con, $sql) === false) {
                    $err = 'Failed to reset password: ' . mysqli_error($con);
                } else {
                    $msg = 'Password reset.';
                }
            }
        }
    }
}

// Get users
$users = [];
$sql = "SELECT us.*, s.name AS site_name FROM users us LEFT JOIN sites s ON s.id = us.site_id ORDER BY us.full_name";
$res = mysqli_query($con, $sql);
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $users[] = $row;
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
<h1>Users</h1>
<p class="sub">Roles — <strong>admin</strong>: full control incl. surveys, users, all results. <strong>manager</strong>: site dashboard, results and task management. <strong>employee</strong>: take survey, view/update own tasks.</p>

<?php if ($msg): ?><div class="alert ok"><?= e($msg) ?></div><?php endif; ?>
<?php if ($err): ?><div class="alert err"><?= e($err) ?></div><?php endif; ?>

<?php if (empty($users)): ?>
    <p class="sub">No users found.</p>
<?php else: ?>
    <table class="data">
        <tr>
            <th>Name</th>
            <th>Username</th>
            <th>Role</th>
            <th>Site</th>
            <th>Active</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($users as $row): ?>
            <tr>
                <td><?= e($row['full_name'] ?? '') ?></td>
                <td><?= e($row['username'] ?? '') ?></td>
                <td><?= e($row['role'] ?? 'employee') ?></td>
                <td><?= e($row['site_name'] ?? 'Group') ?></td>
                <td><?= isset($row['active']) && $row['active'] ? 'Yes' : 'No' ?></td>
                <td style="min-width:260px">
                    <?php if ((int)$row['id'] !== (int)$u): ?>
                        <form method="post" action="" style="display:inline">
                            <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                            <input type="hidden" name="action" value="toggle">
                            <input type="hidden" name="user_id" value="<?= (int)$row['id'] ?>">
                            <button class="btn small secondary" type="submit"><?= isset($row['active']) && $row['active'] ? 'Deactivate' : 'Activate' ?></button>
                        </form>
                    <?php else: ?>
                        <span class="badge">Current user</span>
                    <?php endif; ?>

                    <form method="post" action="" style="display:inline-flex;gap:6px">
                        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                        <input type="hidden" name="action" value="resetpw">
                        <input type="hidden" name="user_id" value="<?= (int)$row['id'] ?>">
                        <input type="password" name="password" placeholder="New password (10+ chars)" style="width:180px" minlength="10" required>
                        <button class="btn small" type="submit">Reset</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<div class="panel" style="margin-top:22px">
    <h2>Add user</h2>
    <form method="post" action="">
        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
        <input type="hidden" name="action" value="create">
        <div class="grid2">
            <div>
                <label>Full name *</label>
                <input type="text" name="full_name" required maxlength="100">

                <label>Username *</label>
                <input type="text" name="username" required maxlength="50">

                <label>Password * (min 10 characters)</label>
                <input type="password" name="password" required minlength="10">
            </div>
            <div>
                <label>Role</label>
                <select name="role">
                    <option value="employee">employee</option>
                    <option value="manager">manager</option>
                    <option value="admin">admin</option>
                </select>

                <label>Site</label>
                <select name="site_id">
                    <option value="">Group (no site)</option>
                    <?php foreach ($sites as $s): ?>
                        <option value="<?= (int)$s['id'] ?>"><?= e($s['name'] ?? 'Unnamed') ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <button class="btn" type="submit">Create user</button>
    </form>
</div>
<!-- <?php include __DIR__ . '/includes/footer.php'; ?> -->