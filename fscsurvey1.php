<?php
// ================= Anonymous culture survey =================
include('connection.php'); // Fixed: removed leading slash

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
    function e($str) {
        return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
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
        $token = isset($_SESSION['csrf_token']) ? $_SESSION['csrf_token'] : '';
        if (!isset($_POST['csrf']) || $_POST['csrf'] !== $token) {
            die('CSRF token validation failed.');
        }
    }
}

// Get current user from session
$u = isset($_SESSION['user']) ? $_SESSION['user'] : (isset($_SESSION['access']) ? $_SESSION['access'] : null);

if (is_array($u)) {
    $userId = isset($u['id']) ? (int)$u['id'] : 0;
    $userRole = isset($u['role']) ? strtolower($u['role']) : 'guest';
    $userName = isset($u['full_name']) ? $u['full_name'] : (isset($u['username']) ? $u['username'] : '');
} else {
    $userId = 0;
    $userRole = strtolower((string)$u);
    $userName = '';
}

$page = 'survey';
$msg = '';
$err = '';
$redirect = false;

// Get open round - REMOVED debug echo
$round = null;
$res = mysqli_query($con, "SELECT * FROM survey_rounds WHERE status='open' AND opens_on <= CURDATE() AND closes_on >= CURDATE() ORDER BY opens_on DESC LIMIT 1");
if ($res && mysqli_num_rows($res) > 0) {
    $round = mysqli_fetch_assoc($res);
}

// Get sites
$sites = array();
$res = mysqli_query($con, "SELECT * FROM sites ORDER BY name");
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $sites[] = $row;
    }
}

// Get departments
$departments = array();
$res = mysqli_query($con, "SELECT * FROM departments ORDER BY name");
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $departments[] = $row;
    }
}

// Get questions
$questions = array();
$res = mysqli_query($con, "SELECT q.*, d.name AS dim FROM questions q LEFT JOIN dimensions d ON d.id=q.dimension_id WHERE q.active=1 ORDER BY q.sort_order");
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $questions[] = $row;
    }
}

// Handle POST submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $round) {
    csrf_check();

    $siteId = isset($_POST['site_id']) ? (int)$_POST['site_id'] : 0;
    $deptId = isset($_POST['department_id']) ? (int)$_POST['department_id'] : 0;
    $shift = isset($_POST['shift']) ? $_POST['shift'] : '';
    $validShift = in_array($shift, array('Days', 'Nights', 'Weekend', 'Rotating'), true);

    $missing = false;
    foreach ($questions as $q) {
        if ($q['qtype'] === 'likert') {
            $v = isset($_POST['q' . $q['id']]) ? $_POST['q' . $q['id']] : '';
            if (!in_array($v, array('1', '2', '3', '4', '5'), true)) {
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

        $sql = "INSERT INTO responses (round_id, site_id, department_id, shift) VALUES ($roundId, $siteId, $deptId, '$shiftEsc')";
        $ok = $ok && mysqli_query($con, $sql);

        if ($ok) {
            $respId = mysqli_insert_id($con);
            foreach ($questions as $q) {
                $qId = (int)$q['id'];
                if ($q['qtype'] === 'likert') {
                    $score = isset($_POST['q' . $q['id']]) ? (int)$_POST['q' . $q['id']] : 0;
                    if ($score >= 1 && $score <= 5) {
                        $sql2 = "INSERT INTO answers (response_id, question_id, score) VALUES ($respId, $qId, $score)";
                        $ok = $ok && mysqli_query($con, $sql2);
                    }
                } else {
                    $c = isset($_POST['q' . $q['id']]) ? trim($_POST['q' . $q['id']]) : '';
                    if ($c !== '') {
                        $cEsc = mysqli_real_escape_string($con, mb_substr($c, 0, 2000));
                        $sql2 = "INSERT INTO answers (response_id, question_id, comment) VALUES ($respId, $qId, '$cEsc')";
                        $ok = $ok && mysqli_query($con, $sql2);
                    }
                }
                if (!$ok) break;
            }
        }

        if ($ok) {
            mysqli_commit($con);
            $msg = 'Thank you — your anonymous response has been recorded.';
            $redirect = true;
        } else {
            mysqli_rollback($con);
            $err = 'Something went wrong saving your response. Please try again.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FSC Survey Management System</title>
    <link rel="stylesheet" href="fscsurvey/assets/style.css">
    <style>
        :root {
            --navy: #1B3A7B;
            --silver: #C8CDD5;
            --slate: #F1F4F8;
            --dark: #1A1A2E;
            --muted: #6B7A99;
            --white: #fff;
            --red: #B3261E;
            --amber: #B45309;
            --green: #1E7B34;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0
        }

        body {
            font-family: "Century Gothic", CenturyGothic, "Avenir Next", Avenir, AppleGothic, sans-serif;
            background: var(--slate);
            color: var(--dark);
            font-size: 14px
        }

        header {
            background: var(--navy);
            color: #fff;
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 10px 22px
        }

        header img {
            height: 44px;
            background: #fff;
            border-radius: 6px;
            padding: 3px
        }

        header .t {
            font-size: 17px;
            font-weight: bold;
            letter-spacing: .5px
        }

        header .u {
            margin-left: auto;
            font-size: 12px;
            color: var(--silver)
        }

        header .u a {
            color: #fff;
            text-decoration: underline
        }

        nav {
            background: #162F68;
            padding: 0 14px;
            display: flex;
            flex-wrap: wrap
        }

        nav a {
            color: var(--silver);
            text-decoration: none;
            padding: 10px 13px;
            font-size: 13px
        }

        nav a:hover {
            background: var(--navy);
            color: #fff
        }

        nav a.on {
            background: var(--slate);
            color: var(--navy);
            font-weight: bold;
            border-radius: 6px 6px 0 0
        }

        main {
            width: 100%;
            padding: 20px 22px;
            margin: 0 auto
        }

        h1 {
            color: var(--navy);
            font-size: 21px;
            margin-bottom: 4px
        }

        .sub {
            color: var(--muted);
            font-size: 12px;
            margin-bottom: 16px
        }

        .panel {
            background: #fff;
            border: 1px solid var(--silver);
            border-radius: 10px;
            padding: 16px;
            margin-bottom: 18px
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 10px
        }

        label {
            display: block;
            font-size: 12px;
            color: var(--muted);
            margin-bottom: 2px
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 7px;
            border: 1px solid var(--silver);
            border-radius: 6px;
            font-family: inherit;
            font-size: 13px;
            background: #fff;
            color: var(--dark)
        }

        textarea {
            min-height: 60px
        }

        button,
        .btn {
            background: var(--navy);
            color: #fff;
            border: 0;
            border-radius: 6px;
            padding: 8px 16px;
            font-family: inherit;
            font-size: 13px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-top: 8px
        }

        button:hover,
        .btn:hover {
            background: #162F68
        }

        .msg {
            background: #E8F5EC;
            border: 1px solid var(--green);
            color: var(--green);
            padding: 9px 12px;
            border-radius: 8px;
            margin-bottom: 14px
        }

        .err {
            background: #FBEAEA;
            border: 1px solid var(--red);
            color: var(--red);
            padding: 9px 12px;
            border-radius: 8px;
            margin-bottom: 14px
        }

        .info {
            background: #E3F2FD;
            border: 1px solid var(--navy);
            color: var(--navy);
            padding: 9px 12px;
            border-radius: 8px;
            margin-bottom: 14px
        }

        .q-block {
            background: #fff;
            border: 1px solid var(--silver);
            border-radius: 10px;
            padding: 14px;
            margin-bottom: 12px
        }

        .q-dim {
            font-size: 11px;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .5px
        }

        .q-text {
            font-weight: bold;
            margin: 6px 0
        }

        .likert {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
            margin-top: 8px
        }

        .likert label {
            display: flex;
            align-items: center;
            gap: 4px;
            cursor: pointer;
            white-space: nowrap;
            font-weight: normal
        }

        .likert input[type="radio"] {
            width: auto;
            margin-right: 2px
        }

        .redirect-msg {
            text-align: center;
            margin-top: 10px;
            color: var(--muted);
            font-size: 13px;
        }

        footer {
            color: var(--muted);
            font-size: 11px;
            text-align: center;
            padding: 18px
        }

        @media (max-width: 768px) {
            .likert {
                flex-direction: column;
                gap: 6px
            }
            .likert label {
                white-space: normal
            }
        }
    </style>
</head>

<body>

    <header>

        <img src="images/1.png" alt="Logo" onerror="this.style.display='none'">
        <span class="t">FSC Survey Management System</span>
        
    </header>

    

    <main>
        <h1>Food Safety Culture Survey</h1>

        <?php if (!$round): ?>
            <div class="info">There is no survey open at the moment. Please check back later.</div>
        <?php else: ?>
            <p class="sub"><strong><?php echo e($round['title']); ?></strong> — open until <?php echo e($round['closes_on']); ?>.
                Your answers are <strong>anonymous</strong>: we record only your site, department and shift, never your name.
                Results for groups smaller than <?php echo (int)MIN_GROUP_SIZE; ?> people are never shown.</p>

            <?php if ($msg): ?>
                <div class="msg"><?php echo e($msg); ?></div>
                <?php if ($redirect): ?>
                    <div class="redirect-msg">You will be redirected shortly...</div>
                    <script>
                        setTimeout(function() {
                            window.location.href = 'index.php';
                        }, 4000);
                    </script>
                <?php endif; ?>
            <?php endif; ?>
            
            <?php if ($err): ?><div class="err"><?php echo e($err); ?></div><?php endif; ?>

            <?php if (!$msg): ?>
                <form method="post" action="">
                    <input type="hidden" name="csrf" value="<?php echo e(csrf_token()); ?>">

                    <div class="panel">
                        <h2>About you (for grouping only)</h2>
                        <div class="grid">
                            <div>
                                <label>Site *</label>
                                <select name="site_id" required>
                                    <option value="">— select —</option>
                                    <?php foreach ($sites as $s): ?>
                                        <option value="<?php echo (int)$s['id']; ?>"><?php echo e($s['name']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <label>Department *</label>
                                <select name="department_id" required>
                                    <option value="">— select —</option>
                                    <?php foreach ($departments as $d): ?>
                                        <option value="<?php echo (int)$d['id']; ?>"><?php echo e($d['name']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <label>Shift *</label>
                                <select name="shift" required>
                                    <option value="">— select —</option>
                                    <option value="Days">Days</option>
                                    <option value="Nights">Nights</option>
                                    <option value="Weekend">Weekend</option>
                                    <option value="Rotating">Rotating</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <?php if (empty($questions)): ?>
                        <div class="info">No questions available for this survey.</div>
                    <?php else: ?>
                        <?php foreach ($questions as $i => $q): ?>
                            <div class="q-block">
                                <div class="q-dim">
                                    <?php 
                                    $dimName = isset($q['dim']) && $q['dim'] ? $q['dim'] : 'Your comments';
                                    echo e($dimName);
                                    ?>
                                </div>
                                <div class="q-text"><?php echo ($i + 1); ?>. <?php echo e($q['qtext']); ?></div>

                                <?php if ($q['qtype'] === 'likert'): ?>
                                    <div class="likert">
                                        <?php
                                        $lbls = array(
                                            1 => 'Strongly disagree',
                                            2 => 'Disagree',
                                            3 => 'Neutral',
                                            4 => 'Agree',
                                            5 => 'Strongly agree'
                                        );
                                        foreach ($lbls as $v => $l): ?>
                                            <label>
                                                <input type="radio" name="q<?php echo (int)$q['id']; ?>" value="<?php echo $v; ?>" required>
                                                <?php echo $v; ?> — <?php echo e($l); ?>
                                            </label>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <textarea name="q<?php echo (int)$q['id']; ?>" maxlength="2000" placeholder="Optional — your words, no names please"></textarea>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <button class="btn" type="submit">Submit anonymous response</button>
                </form>
            <?php endif; ?>
        <?php endif; ?>
    </main>

    <footer>
        RTNTS Global — Food Safety Culture Portal · Supports BRCGS Issue 9 (Cl. 1.1.2), FSSC 22000 V6 (Req. 2.5.8), Reg (EC) 852/2004 Ch. XIa, FDA FSMA · Survey responses are anonymous
    </footer>

</body>

</html>