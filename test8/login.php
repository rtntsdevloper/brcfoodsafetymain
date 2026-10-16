<?php
require_once __DIR__ . '/includes/auth.php';
csrf_check();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $stmt = db()->prepare('SELECT * FROM users WHERE username = ? AND active = 1' );
    $stmt->execute([$username]);
    $row = $stmt->fetch();
    if ($row ) {
        session_regenerate_id(true);
        $_SESSION['user'] = [
            'id' => (int)$row['id'],
            'username' => $row['username'],
            'full_name' => $row['full_name'],
            'role' => $row['role'],
            'site_id' => $row['site_id'] !== null ? (int)$row['site_id'] : null,
        ];
        header('Location: index.php');
        exit;
    }
    $error = 'Invalid username or password.';
}
// if (current_user()) { header('Location: index.php'); exit; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Log in — <?= e(APP_NAME) ?></title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="login-box">
  <div style="font-weight:bold;color:#1B3A7B;font-size:26px;letter-spacing:2px;">RTNTS GLOBAL</div>
  <h1><?= e(APP_NAME) ?></h1>
  <p class="sub">Sign in to continue</p>
  <?php if (isset($_GET['timeout'])): ?><div class="alert info">Session expired — please sign in again.</div><?php endif; ?>
  <?php if ($error): ?><div class="alert err"><?= e($error) ?></div><?php endif; ?>
  <form method="post" action="login.php">
    <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
    <label>Username</label>
    <input type="text" name="username" required autofocus>
    <label>Password</label>
    <input type="password" name="password" required>
    <button class="btn" style="width:100%" type="submit">Sign in</button>
  </form>
</div>
</body>
</html>
