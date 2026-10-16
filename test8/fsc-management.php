<?php
// ============ CONFIGURATION - ADD THIS SECTION ============
// Define constants
define('APP_NAME', 'Food Safety Culture');
define('APP_COMPANY', 'RTNTS GLOBAL');

// Database configuration
$host = 'localhost'; // or your database host
$database = 'your_database_name';
$username = 'your_username';
$password = 'your_password';

// Helper function for HTML escaping
function e($string) {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

// ============ SESSION & USER AUTHENTICATION ============
session_start();
$u = $_SESSION['user'] ?? null; // Assuming user is stored in session
$page = 'dashboard'; // or determine from $_GET

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("PDO Connection failed: " . $e->getMessage());
}

$round = $pdo->query("SELECT * FROM survey_rounds WHERE status='open' ORDER BY opens_on DESC LIMIT 1")->fetch();
if (!$round) {
    $round = $pdo->query("SELECT * FROM survey_rounds ORDER BY closes_on DESC LIMIT 1")->fetch();
}
$roundId = $round ? (int)$round['id'] : 0;

// KPI: participation
$totalResponses = 0;
$totalHeadcount = 0;
$participation = null;
$siteLabels = [];
$sitePart = [];
$siteScores = [];
if ($roundId) {
    $rows = $pdo->prepare(
        "SELECT s.id, s.name,
            COALESCE(h.headcount,0) AS headcount,
            (SELECT COUNT(*) FROM responses r WHERE r.round_id=? AND r.site_id=s.id) AS resp
        FROM sites s
        LEFT JOIN site_headcount h ON h.site_id=s.id AND h.round_id=?"
    );
    $rows->execute([$roundId, $roundId]);
    foreach ($rows->fetchAll() as $r) {
        $totalResponses += (int)$r['resp'];
        $totalHeadcount += (int)$r['headcount'];
        $siteLabels[] = $r['name'];
        $sitePart[] = $r['headcount'] > 0 ? round(100 * $r['resp'] / $r['headcount'], 1) : 0;
        $s = $pdo->prepare(
            "SELECT AVG(a.score) FROM answers a
            JOIN responses r ON r.id=a.response_id
            WHERE r.round_id=? AND r.site_id=? AND a.score IS NOT NULL"
        );
        $s->execute([$roundId, (int)$r['id']]);
        $v = $s->fetchColumn();
        $siteScores[] = $v !== null ? round((float)$v, 2) : 0;
    }
    if ($totalHeadcount > 0) $participation = round(100 * $totalResponses / $totalHeadcount, 1);
}

// Mean score by dimension
$dimLabels = [];
$dimScores = [];
if ($roundId) {
    $q = $pdo->prepare(
        "SELECT d.name, st.avg_score
        FROM dimensions d
        LEFT JOIN (
            SELECT qs.dimension_id, AVG(a.score) AS avg_score
            FROM questions qs
            JOIN answers a ON a.question_id = qs.id AND a.score IS NOT NULL
            JOIN responses r ON r.id = a.response_id
            WHERE r.round_id = ? AND qs.qtype = 'likert'
            GROUP BY qs.dimension_id
        ) st ON st.dimension_id = d.id
        ORDER BY d.sort_order"
    );
    $q->execute([$roundId]);
    foreach ($q->fetchAll() as $r) {
        $dimLabels[] = $r['name'];
        $dimScores[] = $r['avg_score'] !== null ? round((float)$r['avg_score'], 2) : 0;
    }
}

$groupMean = null;
if ($roundId) {
    $s = $pdo->prepare("SELECT AVG(a.score) FROM answers a JOIN responses r ON r.id=a.response_id WHERE r.round_id=? AND a.score IS NOT NULL");
    $s->execute([$roundId]);
    $v = $s->fetchColumn();
    $groupMean = $v !== null ? round((float)$v, 2) : null;
}

// Task KPIs
$taskCounts = $pdo->query(
    "SELECT
        SUM(status='open') AS open_c,
        SUM(status='in_progress') AS prog_c,
        SUM(status='completed') AS done_c,
        SUM(status<>'completed' AND due_date IS NOT NULL AND due_date < CURDATE()) AS overdue_c
    FROM tasks"
)->fetch();

// Roadmap progress
$roadmap = $pdo->query(
    "SELECT COUNT(*) AS total, SUM(status='completed') AS done FROM plan_steps"
)->fetch();
$roadmapPct = ($roadmap && $roadmap['total'] > 0) ? round(100 * $roadmap['done'] / $roadmap['total']) : 0;

// What's next: top 6 upcoming or overdue open tasks
$nextTasks = $pdo->query(
    "SELECT t.*, d.name AS dim, s.name AS site_name, us.full_name AS owner_name
    FROM tasks t
    LEFT JOIN dimensions d ON d.id=t.dimension_id
    LEFT JOIN sites s ON s.id=t.site_id
    LEFT JOIN users us ON us.id=t.owner_user_id
    WHERE t.status <> 'completed'
    ORDER BY t.due_date IS NULL, t.due_date
    LIMIT 6"
)->fetchAll();

// Low-scoring questions (<3.0)
$lowQs = [];
if ($roundId) {
    $q = $pdo->prepare(
        "SELECT qs.qtext, d.name AS dim, AVG(a.score) AS avg_score, COUNT(a.id) AS n
        FROM questions qs
        LEFT JOIN dimensions d ON d.id=qs.dimension_id
        JOIN answers a ON a.question_id=qs.id AND a.score IS NOT NULL
        JOIN responses r ON r.id=a.response_id AND r.round_id=?
        WHERE qs.qtype='likert'
        GROUP BY qs.id, qs.qtext, d.name
        HAVING AVG(a.score) < 3.0
        ORDER BY avg_score ASC"
    );
    $q->execute([$roundId]);
    $lowQs = $q->fetchAll();
}

function navlink(string $href, string $id, string $label, string $page): string {
    $cls = $id === $page ? 'link active' : 'link';
    return '<a class="' . $cls . '" href="' . $href . '">' . $label . '</a>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e(APP_NAME) ?> — <?= e(APP_COMPANY) ?></title>
<link rel="stylesheet" href="assets/style.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
</head>
<body>
<nav class="nav">
    <span class="brand">RTNTS GLOBAL <span class="dot">·</span> FSC PORTAL</span>
    <?php if ($u): ?>
        <?= navlink('index.php', 'dashboard', 'Dashboard', $page) ?>
        <?= navlink('survey.php', 'survey', 'Take Survey', $page) ?>
        <?php if (in_array($u['role'], ['admin','manager'])): ?>
            <?= navlink('results.php', 'results', 'Survey Results', $page) ?>
        <?php endif; ?>
        <?= navlink('tasks.php', 'tasks', 'Tasks', $page) ?>
        <?= navlink('roadmap.php', 'roadmap', 'Roadmap', $page) ?>
        <?php if ($u['role'] === 'admin'): ?>
            <?= navlink('surveys_admin.php', 'surveys_admin', 'Manage Surveys', $page) ?>
            <?= navlink('users.php', 'users', 'Users', $page) ?>
        <?php endif; ?>
    <?php endif; ?>
    <span class="spacer"></span>
    <?php if ($u): ?>
        <span class="userbox"><?= e($u['full_name']) ?> (<?= e($u['role']) ?>)
        <a href="logout.php">Log out</a></span>
    <?php endif; ?>
</nav>
<div class="wrap">
<div class="hero">
    <div class="hero-main">
        <h1>Food Safety Culture Dashboard</h1>
        <p class="sub"><?= $round ? e($round['title']) . ' · ' . e($round['status']) . ' · closes ' . e($round['closes_on']) : 'No survey round configured yet.' ?></p>
        <span class="chip">BRCGS 9 · Cl. 1.1.2</span>
        <span class="chip">FSSC 22000 V6 · 2.5.8</span>
        <span class="chip">852/2004 Ch. XIa</span>
        <span class="chip">FDA FSMA</span>
    </div>
    <div class="ring-wrap">
        <div class="ring" style="--p: <?= (float)($participation ?? 0) ?>">
            <div>
                <div>
                    <div class="val"><?= $participation !== null ? e((string)$participation) . '%' : '—' ?></div>
                    <div class="cap">participation<br>target 75%</div>
                </div>
            </div>
        </div>
        <div class="ring" style="--p: <?= $groupMean !== null ? (float)$groupMean / 5 * 100 : 0 ?>">
            <div>
                <div>
                    <div class="val"><?= $groupMean !== null ? e((string)$groupMean) : '—' ?></div>
                    <div class="cap">mean score<br>target 4.0</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="cards">
    <div class="card">
        <div class="icon">&#128202;</div>
        <div class="kpi"><?= e((string)$totalResponses) ?></div>
        <div class="lbl">Responses this round</div>
    </div>
    <div class="card accent-green">
        <div class="icon">&#9989;</div>
        <div class="kpi"><?= e((string)($taskCounts['done_c'] ?? 0)) ?></div>
        <div class="lbl">Culture tasks completed</div>
    </div>
    <div class="card">
        <div class="icon">&#128296;</div>
        <div class="kpi"><?= e((string)(($taskCounts['open_c'] ?? 0) + ($taskCounts['prog_c'] ?? 0))) ?></div>
        <div class="lbl">Tasks open / in progress</div>
    </div>
    <div class="card <?= ($taskCounts['overdue_c'] ?? 0) > 0 ? 'accent-red' : 'accent-green' ?>">
        <div class="icon">&#9200;</div>
        <div class="kpi"><?= e((string)($taskCounts['overdue_c'] ?? 0)) ?></div>
        <div class="lbl">Overdue tasks</div>
    </div>
    <div class="card accent-amber">
        <div class="icon">&#128506;</div>
        <div class="kpi"><?= $roadmapPct ?>%</div>
        <div class="lbl">Roadmap steps complete · <a href="roadmap.php">view roadmap</a></div>
    </div>
</div>

<div class="grid2">
    <div class="panel">
        <h2>Mean score by GFSI dimension</h2>
        <canvas id="dimChart" height="230"></canvas>
    </div>
    <div class="panel">
        <h2>Site comparison — score &amp; participation</h2>
        <canvas id="siteChart" height="230"></canvas>
    </div>
</div>

<div class="grid2">
    <div class="panel">
        <h2>Task status</h2>
        <canvas id="taskChart" height="220"></canvas>
    </div>
    <div class="panel">
        <h2>What's next — nearest due activities</h2>
        <table class="data">
            <tr>
                <th>Task</th>
                <th>Owner</th>
                <th>Due</th>
                <th>Status</th>
            </tr>
            <?php foreach ($nextTasks as $t):
                $overdue = $t['due_date'] && $t['due_date'] < date('Y-m-d'); ?>
                <tr>
                    <td><strong><?= e($t['title']) ?></strong><?php if ($t['dim']): ?><br><span class="sub" style="margin:0"><?= e($t['dim']) ?></span><?php endif; ?></td>
                    <td><?= e($t['owner_name'] ?? ($t['owner_role'] ?? '—')) ?></td>
                    <td><?= e($t['due_date'] ?? '—') ?></td>
                    <td><span class="badge b-<?= $overdue ? 'overdue' : e($t['status']) ?>"><?= $overdue ? 'overdue' : e(str_replace('_', ' ', $t['status'])) ?></span></td>
                </tr>
            <?php endforeach; ?>
            <?php if (!$nextTasks): ?><tr>
                <td colspan="4">Nothing outstanding — nice work.</td>
            </tr><?php endif; ?>
        </table>
        <a class="btn small" style="margin-top:12px" href="tasks.php">Open task tracker</a>
        <a class="btn small secondary" style="margin-top:12px" href="roadmap.php">Full roadmap</a>
    </div>
</div>

<div class="panel">
    <h2>Questions scoring below 3.0 — mandatory action (SOP-FSC-002)</h2>
    <?php if (!$lowQs): ?>
        <p class="sub" style="margin:0">None — no question currently averages below 3.0 in this round.</p>
    <?php else: ?>
        <table class="data">
            <tr>
                <th>Question</th>
                <th>Dimension</th>
                <th>Mean</th>
                <th>Responses</th>
            </tr>
            <?php foreach ($lowQs as $r): ?>
                <tr>
                    <td><?= e($r['qtext']) ?></td>
                    <td><?= e($r['dim'] ?? '—') ?></td>
                    <td class="score-low"><?= e(number_format((float)$r['avg_score'], 2)) ?></td>
                    <td><?= e((string)$r['n']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>

<script>
    // Check if canvas elements exist before creating charts
    const dimCanvas = document.getElementById('dimChart');
    const siteCanvas = document.getElementById('siteChart');
    const taskCanvas = document.getElementById('taskChart');

    const NAVY = '#1B3A7B',
        BRIGHT = '#2B55B0',
        SILVER = '#C8CDD5',
        AMBER = '#F59E0B',
        GREEN = '#1E7B45',
        RED = '#A33333';

    if (dimCanvas) {
        new Chart(dimCanvas, {
            type: 'radar',
            data: {
                labels: <?= json_encode($dimLabels) ?>,
                datasets: [{
                    label: 'Mean score',
                    data: <?= json_encode($dimScores) ?>,
                    backgroundColor: 'rgba(27,58,123,0.22)',
                    borderColor: NAVY,
                    borderWidth: 2,
                    pointBackgroundColor: AMBER,
                    pointRadius: 4
                },
                {
                    label: 'Target (4.0)',
                    data: <?= json_encode(array_fill(0, count($dimLabels), 4)) ?>,
                    borderColor: AMBER,
                    borderDash: [6, 4],
                    pointRadius: 0,
                    backgroundColor: 'transparent'
                }]
            },
            options: {
                scales: {
                    r: {
                        min: 0,
                        max: 5,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    }

    if (siteCanvas) {
        new Chart(siteCanvas, {
            type: 'bar',
            data: {
                labels: <?= json_encode($siteLabels) ?>,
                datasets: [{
                    label: 'Mean score (/5)',
                    data: <?= json_encode($siteScores) ?>,
                    backgroundColor: NAVY,
                    borderRadius: 8,
                    yAxisID: 'y'
                },
                {
                    label: 'Participation %',
                    data: <?= json_encode($sitePart) ?>,
                    backgroundColor: AMBER,
                    borderRadius: 8,
                    yAxisID: 'y1'
                }]
            },
            options: {
                scales: {
                    y: {
                        min: 0,
                        max: 5,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Score'
                        }
                    },
                    y1: {
                        min: 0,
                        max: 100,
                        position: 'right',
                        grid: {
                            drawOnChartArea: false
                        },
                        title: {
                            display: true,
                            text: '%'
                        }
                    }
                }
            }
        });
    }

    if (taskCanvas) {
        new Chart(taskCanvas, {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'In progress', 'Open', 'Overdue'],
                datasets: [{
                    data: [
                        <?= (int)($taskCounts['done_c'] ?? 0) ?>,
                        <?= (int)($taskCounts['prog_c'] ?? 0) ?>,
                        <?= max(0, (int)($taskCounts['open_c'] ?? 0) - (int)($taskCounts['overdue_c'] ?? 0)) ?>,
                        <?= (int)($taskCounts['overdue_c'] ?? 0) ?>
                    ],
                    backgroundColor: [GREEN, BRIGHT, SILVER, RED],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                cutout: '62%',
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        });
    }
</script>
<?php
// Check if footer file exists before including
$footerFile = __DIR__ . '/includes/footer.php';
if (file_exists($footerFile)) {
    include $footerFile;
} else {
    echo '<div style="text-align:center;padding:20px;color:#999;font-size:12px;">© ' . date('Y') . ' ' . APP_COMPANY . ' - Food Safety Culture Program</div>';
}
?>
</body>
</html><?php
// ============ CONFIGURATION - ADD THIS SECTION ============
// Define constants
define('APP_NAME', 'Food Safety Culture');
define('APP_COMPANY', 'RTNTS GLOBAL');

// Database configuration
$host = 'localhost'; // or your database host
$database = 'your_database_name';
$username = 'your_username';
$password = 'your_password';



// ============ SESSION & USER AUTHENTICATION ============
session_start();
$u = $_SESSION['user'] ?? null; // Assuming user is stored in session
$page = 'dashboard'; // or determine from $_GET

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("PDO Connection failed: " . $e->getMessage());
}

$round = $pdo->query("SELECT * FROM survey_rounds WHERE status='open' ORDER BY opens_on DESC LIMIT 1")->fetch();
if (!$round) {
    $round = $pdo->query("SELECT * FROM survey_rounds ORDER BY closes_on DESC LIMIT 1")->fetch();
}
$roundId = $round ? (int)$round['id'] : 0;

// KPI: participation
$totalResponses = 0;
$totalHeadcount = 0;
$participation = null;
$siteLabels = [];
$sitePart = [];
$siteScores = [];
if ($roundId) {
    $rows = $pdo->prepare(
        "SELECT s.id, s.name,
            COALESCE(h.headcount,0) AS headcount,
            (SELECT COUNT(*) FROM responses r WHERE r.round_id=? AND r.site_id=s.id) AS resp
        FROM sites s
        LEFT JOIN site_headcount h ON h.site_id=s.id AND h.round_id=?"
    );
    $rows->execute([$roundId, $roundId]);
    foreach ($rows->fetchAll() as $r) {
        $totalResponses += (int)$r['resp'];
        $totalHeadcount += (int)$r['headcount'];
        $siteLabels[] = $r['name'];
        $sitePart[] = $r['headcount'] > 0 ? round(100 * $r['resp'] / $r['headcount'], 1) : 0;
        $s = $pdo->prepare(
            "SELECT AVG(a.score) FROM answers a
            JOIN responses r ON r.id=a.response_id
            WHERE r.round_id=? AND r.site_id=? AND a.score IS NOT NULL"
        );
        $s->execute([$roundId, (int)$r['id']]);
        $v = $s->fetchColumn();
        $siteScores[] = $v !== null ? round((float)$v, 2) : 0;
    }
    if ($totalHeadcount > 0) $participation = round(100 * $totalResponses / $totalHeadcount, 1);
}

// Mean score by dimension
$dimLabels = [];
$dimScores = [];
if ($roundId) {
    $q = $pdo->prepare(
        "SELECT d.name, st.avg_score
        FROM dimensions d
        LEFT JOIN (
            SELECT qs.dimension_id, AVG(a.score) AS avg_score
            FROM questions qs
            JOIN answers a ON a.question_id = qs.id AND a.score IS NOT NULL
            JOIN responses r ON r.id = a.response_id
            WHERE r.round_id = ? AND qs.qtype = 'likert'
            GROUP BY qs.dimension_id
        ) st ON st.dimension_id = d.id
        ORDER BY d.sort_order"
    );
    $q->execute([$roundId]);
    foreach ($q->fetchAll() as $r) {
        $dimLabels[] = $r['name'];
        $dimScores[] = $r['avg_score'] !== null ? round((float)$r['avg_score'], 2) : 0;
    }
}

$groupMean = null;
if ($roundId) {
    $s = $pdo->prepare("SELECT AVG(a.score) FROM answers a JOIN responses r ON r.id=a.response_id WHERE r.round_id=? AND a.score IS NOT NULL");
    $s->execute([$roundId]);
    $v = $s->fetchColumn();
    $groupMean = $v !== null ? round((float)$v, 2) : null;
}

// Task KPIs
$taskCounts = $pdo->query(
    "SELECT
        SUM(status='open') AS open_c,
        SUM(status='in_progress') AS prog_c,
        SUM(status='completed') AS done_c,
        SUM(status<>'completed' AND due_date IS NOT NULL AND due_date < CURDATE()) AS overdue_c
    FROM tasks"
)->fetch();

// Roadmap progress
$roadmap = $pdo->query(
    "SELECT COUNT(*) AS total, SUM(status='completed') AS done FROM plan_steps"
)->fetch();
$roadmapPct = ($roadmap && $roadmap['total'] > 0) ? round(100 * $roadmap['done'] / $roadmap['total']) : 0;

// What's next: top 6 upcoming or overdue open tasks
$nextTasks = $pdo->query(
    "SELECT t.*, d.name AS dim, s.name AS site_name, us.full_name AS owner_name
    FROM tasks t
    LEFT JOIN dimensions d ON d.id=t.dimension_id
    LEFT JOIN sites s ON s.id=t.site_id
    LEFT JOIN users us ON us.id=t.owner_user_id
    WHERE t.status <> 'completed'
    ORDER BY t.due_date IS NULL, t.due_date
    LIMIT 6"
)->fetchAll();

// Low-scoring questions (<3.0)
$lowQs = [];
if ($roundId) {
    $q = $pdo->prepare(
        "SELECT qs.qtext, d.name AS dim, AVG(a.score) AS avg_score, COUNT(a.id) AS n
        FROM questions qs
        LEFT JOIN dimensions d ON d.id=qs.dimension_id
        JOIN answers a ON a.question_id=qs.id AND a.score IS NOT NULL
        JOIN responses r ON r.id=a.response_id AND r.round_id=?
        WHERE qs.qtype='likert'
        GROUP BY qs.id, qs.qtext, d.name
        HAVING AVG(a.score) < 3.0
        ORDER BY avg_score ASC"
    );
    $q->execute([$roundId]);
    $lowQs = $q->fetchAll();
}

function navlink(string $href, string $id, string $label, string $page): string {
    $cls = $id === $page ? 'link active' : 'link';
    return '<a class="' . $cls . '" href="' . $href . '">' . $label . '</a>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e(APP_NAME) ?> — <?= e(APP_COMPANY) ?></title>
<link rel="stylesheet" href="assets/style.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
</head>
<body>
<nav class="nav">
    <span class="brand">RTNTS GLOBAL <span class="dot">·</span> FSC PORTAL</span>
    <?php if ($u): ?>
        <?= navlink('index.php', 'dashboard', 'Dashboard', $page) ?>
        <?= navlink('survey.php', 'survey', 'Take Survey', $page) ?>
        <?php if (in_array($u['role'], ['admin','manager'])): ?>
            <?= navlink('results.php', 'results', 'Survey Results', $page) ?>
        <?php endif; ?>
        <?= navlink('tasks.php', 'tasks', 'Tasks', $page) ?>
        <?= navlink('roadmap.php', 'roadmap', 'Roadmap', $page) ?>
        <?php if ($u['role'] === 'admin'): ?>
            <?= navlink('surveys_admin.php', 'surveys_admin', 'Manage Surveys', $page) ?>
            <?= navlink('users.php', 'users', 'Users', $page) ?>
        <?php endif; ?>
    <?php endif; ?>
    <span class="spacer"></span>
    <?php if ($u): ?>
        <span class="userbox"><?= e($u['full_name']) ?> (<?= e($u['role']) ?>)
        <a href="logout.php">Log out</a></span>
    <?php endif; ?>
</nav>
<div class="wrap">
<div class="hero">
    <div class="hero-main">
        <h1>Food Safety Culture Dashboard</h1>
        <p class="sub"><?= $round ? e($round['title']) . ' · ' . e($round['status']) . ' · closes ' . e($round['closes_on']) : 'No survey round configured yet.' ?></p>
        <span class="chip">BRCGS 9 · Cl. 1.1.2</span>
        <span class="chip">FSSC 22000 V6 · 2.5.8</span>
        <span class="chip">852/2004 Ch. XIa</span>
        <span class="chip">FDA FSMA</span>
    </div>
    <div class="ring-wrap">
        <div class="ring" style="--p: <?= (float)($participation ?? 0) ?>">
            <div>
                <div>
                    <div class="val"><?= $participation !== null ? e((string)$participation) . '%' : '—' ?></div>
                    <div class="cap">participation<br>target 75%</div>
                </div>
            </div>
        </div>
        <div class="ring" style="--p: <?= $groupMean !== null ? (float)$groupMean / 5 * 100 : 0 ?>">
            <div>
                <div>
                    <div class="val"><?= $groupMean !== null ? e((string)$groupMean) : '—' ?></div>
                    <div class="cap">mean score<br>target 4.0</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="cards">
    <div class="card">
        <div class="icon">&#128202;</div>
        <div class="kpi"><?= e((string)$totalResponses) ?></div>
        <div class="lbl">Responses this round</div>
    </div>
    <div class="card accent-green">
        <div class="icon">&#9989;</div>
        <div class="kpi"><?= e((string)($taskCounts['done_c'] ?? 0)) ?></div>
        <div class="lbl">Culture tasks completed</div>
    </div>
    <div class="card">
        <div class="icon">&#128296;</div>
        <div class="kpi"><?= e((string)(($taskCounts['open_c'] ?? 0) + ($taskCounts['prog_c'] ?? 0))) ?></div>
        <div class="lbl">Tasks open / in progress</div>
    </div>
    <div class="card <?= ($taskCounts['overdue_c'] ?? 0) > 0 ? 'accent-red' : 'accent-green' ?>">
        <div class="icon">&#9200;</div>
        <div class="kpi"><?= e((string)($taskCounts['overdue_c'] ?? 0)) ?></div>
        <div class="lbl">Overdue tasks</div>
    </div>
    <div class="card accent-amber">
        <div class="icon">&#128506;</div>
        <div class="kpi"><?= $roadmapPct ?>%</div>
        <div class="lbl">Roadmap steps complete · <a href="roadmap.php">view roadmap</a></div>
    </div>
</div>

<div class="grid2">
    <div class="panel">
        <h2>Mean score by GFSI dimension</h2>
        <canvas id="dimChart" height="230"></canvas>
    </div>
    <div class="panel">
        <h2>Site comparison — score &amp; participation</h2>
        <canvas id="siteChart" height="230"></canvas>
    </div>
</div>

<div class="grid2">
    <div class="panel">
        <h2>Task status</h2>
        <canvas id="taskChart" height="220"></canvas>
    </div>
    <div class="panel">
        <h2>What's next — nearest due activities</h2>
        <table class="data">
            <tr>
                <th>Task</th>
                <th>Owner</th>
                <th>Due</th>
                <th>Status</th>
            </tr>
            <?php foreach ($nextTasks as $t):
                $overdue = $t['due_date'] && $t['due_date'] < date('Y-m-d'); ?>
                <tr>
                    <td><strong><?= e($t['title']) ?></strong><?php if ($t['dim']): ?><br><span class="sub" style="margin:0"><?= e($t['dim']) ?></span><?php endif; ?></td>
                    <td><?= e($t['owner_name'] ?? ($t['owner_role'] ?? '—')) ?></td>
                    <td><?= e($t['due_date'] ?? '—') ?></td>
                    <td><span class="badge b-<?= $overdue ? 'overdue' : e($t['status']) ?>"><?= $overdue ? 'overdue' : e(str_replace('_', ' ', $t['status'])) ?></span></td>
                </tr>
            <?php endforeach; ?>
            <?php if (!$nextTasks): ?><tr>
                <td colspan="4">Nothing outstanding — nice work.</td>
            </tr><?php endif; ?>
        </table>
        <a class="btn small" style="margin-top:12px" href="tasks.php">Open task tracker</a>
        <a class="btn small secondary" style="margin-top:12px" href="roadmap.php">Full roadmap</a>
    </div>
</div>

<div class="panel">
    <h2>Questions scoring below 3.0 — mandatory action (SOP-FSC-002)</h2>
    <?php if (!$lowQs): ?>
        <p class="sub" style="margin:0">None — no question currently averages below 3.0 in this round.</p>
    <?php else: ?>
        <table class="data">
            <tr>
                <th>Question</th>
                <th>Dimension</th>
                <th>Mean</th>
                <th>Responses</th>
            </tr>
            <?php foreach ($lowQs as $r): ?>
                <tr>
                    <td><?= e($r['qtext']) ?></td>
                    <td><?= e($r['dim'] ?? '—') ?></td>
                    <td class="score-low"><?= e(number_format((float)$r['avg_score'], 2)) ?></td>
                    <td><?= e((string)$r['n']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>

<script>
    // Check if canvas elements exist before creating charts
    const dimCanvas = document.getElementById('dimChart');
    const siteCanvas = document.getElementById('siteChart');
    const taskCanvas = document.getElementById('taskChart');

    const NAVY = '#1B3A7B',
        BRIGHT = '#2B55B0',
        SILVER = '#C8CDD5',
        AMBER = '#F59E0B',
        GREEN = '#1E7B45',
        RED = '#A33333';

    if (dimCanvas) {
        new Chart(dimCanvas, {
            type: 'radar',
            data: {
                labels: <?= json_encode($dimLabels) ?>,
                datasets: [{
                    label: 'Mean score',
                    data: <?= json_encode($dimScores) ?>,
                    backgroundColor: 'rgba(27,58,123,0.22)',
                    borderColor: NAVY,
                    borderWidth: 2,
                    pointBackgroundColor: AMBER,
                    pointRadius: 4
                },
                {
                    label: 'Target (4.0)',
                    data: <?= json_encode(array_fill(0, count($dimLabels), 4)) ?>,
                    borderColor: AMBER,
                    borderDash: [6, 4],
                    pointRadius: 0,
                    backgroundColor: 'transparent'
                }]
            },
            options: {
                scales: {
                    r: {
                        min: 0,
                        max: 5,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    }

    if (siteCanvas) {
        new Chart(siteCanvas, {
            type: 'bar',
            data: {
                labels: <?= json_encode($siteLabels) ?>,
                datasets: [{
                    label: 'Mean score (/5)',
                    data: <?= json_encode($siteScores) ?>,
                    backgroundColor: NAVY,
                    borderRadius: 8,
                    yAxisID: 'y'
                },
                {
                    label: 'Participation %',
                    data: <?= json_encode($sitePart) ?>,
                    backgroundColor: AMBER,
                    borderRadius: 8,
                    yAxisID: 'y1'
                }]
            },
            options: {
                scales: {
                    y: {
                        min: 0,
                        max: 5,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Score'
                        }
                    },
                    y1: {
                        min: 0,
                        max: 100,
                        position: 'right',
                        grid: {
                            drawOnChartArea: false
                        },
                        title: {
                            display: true,
                            text: '%'
                        }
                    }
                }
            }
        });
    }

    if (taskCanvas) {
        new Chart(taskCanvas, {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'In progress', 'Open', 'Overdue'],
                datasets: [{
                    data: [
                        <?= (int)($taskCounts['done_c'] ?? 0) ?>,
                        <?= (int)($taskCounts['prog_c'] ?? 0) ?>,
                        <?= max(0, (int)($taskCounts['open_c'] ?? 0) - (int)($taskCounts['overdue_c'] ?? 0)) ?>,
                        <?= (int)($taskCounts['overdue_c'] ?? 0) ?>
                    ],
                    backgroundColor: [GREEN, BRIGHT, SILVER, RED],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                cutout: '62%',
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        });
    }
</script>
<?php
// Check if footer file exists before including
$footerFile = __DIR__ . '/includes/footer.php';
if (file_exists($footerFile)) {
    include $footerFile;
} else {
    echo '<div style="text-align:center;padding:20px;color:#999;font-size:12px;">© ' . date('Y') . ' ' . APP_COMPANY . ' - Food Safety Culture Program</div>';
}
?>
</body>
</html><?php
// ============ CONFIGURATION - ADD THIS SECTION ============
// Define constants
define('APP_NAME', 'Food Safety Culture');
define('APP_COMPANY', 'RTNTS GLOBAL');

// Database configuration
$host = 'localhost'; // or your database host
$database = 'your_database_name';
$username = 'your_username';
$password = 'your_password';

// Helper function for HTML escaping
function e($string) {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

// ============ SESSION & USER AUTHENTICATION ============
session_start();
$u = $_SESSION['user'] ?? null; // Assuming user is stored in session
$page = 'dashboard'; // or determine from $_GET

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("PDO Connection failed: " . $e->getMessage());
}

$round = $pdo->query("SELECT * FROM survey_rounds WHERE status='open' ORDER BY opens_on DESC LIMIT 1")->fetch();
if (!$round) {
    $round = $pdo->query("SELECT * FROM survey_rounds ORDER BY closes_on DESC LIMIT 1")->fetch();
}
$roundId = $round ? (int)$round['id'] : 0;

// KPI: participation
$totalResponses = 0;
$totalHeadcount = 0;
$participation = null;
$siteLabels = [];
$sitePart = [];
$siteScores = [];
if ($roundId) {
    $rows = $pdo->prepare(
        "SELECT s.id, s.name,
            COALESCE(h.headcount,0) AS headcount,
            (SELECT COUNT(*) FROM responses r WHERE r.round_id=? AND r.site_id=s.id) AS resp
        FROM sites s
        LEFT JOIN site_headcount h ON h.site_id=s.id AND h.round_id=?"
    );
    $rows->execute([$roundId, $roundId]);
    foreach ($rows->fetchAll() as $r) {
        $totalResponses += (int)$r['resp'];
        $totalHeadcount += (int)$r['headcount'];
        $siteLabels[] = $r['name'];
        $sitePart[] = $r['headcount'] > 0 ? round(100 * $r['resp'] / $r['headcount'], 1) : 0;
        $s = $pdo->prepare(
            "SELECT AVG(a.score) FROM answers a
            JOIN responses r ON r.id=a.response_id
            WHERE r.round_id=? AND r.site_id=? AND a.score IS NOT NULL"
        );
        $s->execute([$roundId, (int)$r['id']]);
        $v = $s->fetchColumn();
        $siteScores[] = $v !== null ? round((float)$v, 2) : 0;
    }
    if ($totalHeadcount > 0) $participation = round(100 * $totalResponses / $totalHeadcount, 1);
}

// Mean score by dimension
$dimLabels = [];
$dimScores = [];
if ($roundId) {
    $q = $pdo->prepare(
        "SELECT d.name, st.avg_score
        FROM dimensions d
        LEFT JOIN (
            SELECT qs.dimension_id, AVG(a.score) AS avg_score
            FROM questions qs
            JOIN answers a ON a.question_id = qs.id AND a.score IS NOT NULL
            JOIN responses r ON r.id = a.response_id
            WHERE r.round_id = ? AND qs.qtype = 'likert'
            GROUP BY qs.dimension_id
        ) st ON st.dimension_id = d.id
        ORDER BY d.sort_order"
    );
    $q->execute([$roundId]);
    foreach ($q->fetchAll() as $r) {
        $dimLabels[] = $r['name'];
        $dimScores[] = $r['avg_score'] !== null ? round((float)$r['avg_score'], 2) : 0;
    }
}

$groupMean = null;
if ($roundId) {
    $s = $pdo->prepare("SELECT AVG(a.score) FROM answers a JOIN responses r ON r.id=a.response_id WHERE r.round_id=? AND a.score IS NOT NULL");
    $s->execute([$roundId]);
    $v = $s->fetchColumn();
    $groupMean = $v !== null ? round((float)$v, 2) : null;
}

// Task KPIs
$taskCounts = $pdo->query(
    "SELECT
        SUM(status='open') AS open_c,
        SUM(status='in_progress') AS prog_c,
        SUM(status='completed') AS done_c,
        SUM(status<>'completed' AND due_date IS NOT NULL AND due_date < CURDATE()) AS overdue_c
    FROM tasks"
)->fetch();

// Roadmap progress
$roadmap = $pdo->query(
    "SELECT COUNT(*) AS total, SUM(status='completed') AS done FROM plan_steps"
)->fetch();
$roadmapPct = ($roadmap && $roadmap['total'] > 0) ? round(100 * $roadmap['done'] / $roadmap['total']) : 0;

// What's next: top 6 upcoming or overdue open tasks
$nextTasks = $pdo->query(
    "SELECT t.*, d.name AS dim, s.name AS site_name, us.full_name AS owner_name
    FROM tasks t
    LEFT JOIN dimensions d ON d.id=t.dimension_id
    LEFT JOIN sites s ON s.id=t.site_id
    LEFT JOIN users us ON us.id=t.owner_user_id
    WHERE t.status <> 'completed'
    ORDER BY t.due_date IS NULL, t.due_date
    LIMIT 6"
)->fetchAll();

// Low-scoring questions (<3.0)
$lowQs = [];
if ($roundId) {
    $q = $pdo->prepare(
        "SELECT qs.qtext, d.name AS dim, AVG(a.score) AS avg_score, COUNT(a.id) AS n
        FROM questions qs
        LEFT JOIN dimensions d ON d.id=qs.dimension_id
        JOIN answers a ON a.question_id=qs.id AND a.score IS NOT NULL
        JOIN responses r ON r.id=a.response_id AND r.round_id=?
        WHERE qs.qtype='likert'
        GROUP BY qs.id, qs.qtext, d.name
        HAVING AVG(a.score) < 3.0
        ORDER BY avg_score ASC"
    );
    $q->execute([$roundId]);
    $lowQs = $q->fetchAll();
}

function navlink(string $href, string $id, string $label, string $page): string {
    $cls = $id === $page ? 'link active' : 'link';
    return '<a class="' . $cls . '" href="' . $href . '">' . $label . '</a>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e(APP_NAME) ?> — <?= e(APP_COMPANY) ?></title>
<link rel="stylesheet" href="assets/style.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
</head>
<body>
<nav class="nav">
    <span class="brand">RTNTS GLOBAL <span class="dot">·</span> FSC PORTAL</span>
    <?php if ($u): ?>
        <?= navlink('index.php', 'dashboard', 'Dashboard', $page) ?>
        <?= navlink('survey.php', 'survey', 'Take Survey', $page) ?>
        <?php if (in_array($u['role'], ['admin','manager'])): ?>
            <?= navlink('results.php', 'results', 'Survey Results', $page) ?>
        <?php endif; ?>
        <?= navlink('tasks.php', 'tasks', 'Tasks', $page) ?>
        <?= navlink('roadmap.php', 'roadmap', 'Roadmap', $page) ?>
        <?php if ($u['role'] === 'admin'): ?>
            <?= navlink('surveys_admin.php', 'surveys_admin', 'Manage Surveys', $page) ?>
            <?= navlink('users.php', 'users', 'Users', $page) ?>
        <?php endif; ?>
    <?php endif; ?>
    <span class="spacer"></span>
    <?php if ($u): ?>
        <span class="userbox"><?= e($u['full_name']) ?> (<?= e($u['role']) ?>)
        <a href="logout.php">Log out</a></span>
    <?php endif; ?>
</nav>
<div class="wrap">
<div class="hero">
    <div class="hero-main">
        <h1>Food Safety Culture Dashboard</h1>
        <p class="sub"><?= $round ? e($round['title']) . ' · ' . e($round['status']) . ' · closes ' . e($round['closes_on']) : 'No survey round configured yet.' ?></p>
        <span class="chip">BRCGS 9 · Cl. 1.1.2</span>
        <span class="chip">FSSC 22000 V6 · 2.5.8</span>
        <span class="chip">852/2004 Ch. XIa</span>
        <span class="chip">FDA FSMA</span>
    </div>
    <div class="ring-wrap">
        <div class="ring" style="--p: <?= (float)($participation ?? 0) ?>">
            <div>
                <div>
                    <div class="val"><?= $participation !== null ? e((string)$participation) . '%' : '—' ?></div>
                    <div class="cap">participation<br>target 75%</div>
                </div>
            </div>
        </div>
        <div class="ring" style="--p: <?= $groupMean !== null ? (float)$groupMean / 5 * 100 : 0 ?>">
            <div>
                <div>
                    <div class="val"><?= $groupMean !== null ? e((string)$groupMean) : '—' ?></div>
                    <div class="cap">mean score<br>target 4.0</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="cards">
    <div class="card">
        <div class="icon">&#128202;</div>
        <div class="kpi"><?= e((string)$totalResponses) ?></div>
        <div class="lbl">Responses this round</div>
    </div>
    <div class="card accent-green">
        <div class="icon">&#9989;</div>
        <div class="kpi"><?= e((string)($taskCounts['done_c'] ?? 0)) ?></div>
        <div class="lbl">Culture tasks completed</div>
    </div>
    <div class="card">
        <div class="icon">&#128296;</div>
        <div class="kpi"><?= e((string)(($taskCounts['open_c'] ?? 0) + ($taskCounts['prog_c'] ?? 0))) ?></div>
        <div class="lbl">Tasks open / in progress</div>
    </div>
    <div class="card <?= ($taskCounts['overdue_c'] ?? 0) > 0 ? 'accent-red' : 'accent-green' ?>">
        <div class="icon">&#9200;</div>
        <div class="kpi"><?= e((string)($taskCounts['overdue_c'] ?? 0)) ?></div>
        <div class="lbl">Overdue tasks</div>
    </div>
    <div class="card accent-amber">
        <div class="icon">&#128506;</div>
        <div class="kpi"><?= $roadmapPct ?>%</div>
        <div class="lbl">Roadmap steps complete · <a href="roadmap.php">view roadmap</a></div>
    </div>
</div>

<div class="grid2">
    <div class="panel">
        <h2>Mean score by GFSI dimension</h2>
        <canvas id="dimChart" height="230"></canvas>
    </div>
    <div class="panel">
        <h2>Site comparison — score &amp; participation</h2>
        <canvas id="siteChart" height="230"></canvas>
    </div>
</div>

<div class="grid2">
    <div class="panel">
        <h2>Task status</h2>
        <canvas id="taskChart" height="220"></canvas>
    </div>
    <div class="panel">
        <h2>What's next — nearest due activities</h2>
        <table class="data">
            <tr>
                <th>Task</th>
                <th>Owner</th>
                <th>Due</th>
                <th>Status</th>
            </tr>
            <?php foreach ($nextTasks as $t):
                $overdue = $t['due_date'] && $t['due_date'] < date('Y-m-d'); ?>
                <tr>
                    <td><strong><?= e($t['title']) ?></strong><?php if ($t['dim']): ?><br><span class="sub" style="margin:0"><?= e($t['dim']) ?></span><?php endif; ?></td>
                    <td><?= e($t['owner_name'] ?? ($t['owner_role'] ?? '—')) ?></td>
                    <td><?= e($t['due_date'] ?? '—') ?></td>
                    <td><span class="badge b-<?= $overdue ? 'overdue' : e($t['status']) ?>"><?= $overdue ? 'overdue' : e(str_replace('_', ' ', $t['status'])) ?></span></td>
                </tr>
            <?php endforeach; ?>
            <?php if (!$nextTasks): ?><tr>
                <td colspan="4">Nothing outstanding — nice work.</td>
            </tr><?php endif; ?>
        </table>
        <a class="btn small" style="margin-top:12px" href="tasks.php">Open task tracker</a>
        <a class="btn small secondary" style="margin-top:12px" href="roadmap.php">Full roadmap</a>
    </div>
</div>

<div class="panel">
    <h2>Questions scoring below 3.0 — mandatory action (SOP-FSC-002)</h2>
    <?php if (!$lowQs): ?>
        <p class="sub" style="margin:0">None — no question currently averages below 3.0 in this round.</p>
    <?php else: ?>
        <table class="data">
            <tr>
                <th>Question</th>
                <th>Dimension</th>
                <th>Mean</th>
                <th>Responses</th>
            </tr>
            <?php foreach ($lowQs as $r): ?>
                <tr>
                    <td><?= e($r['qtext']) ?></td>
                    <td><?= e($r['dim'] ?? '—') ?></td>
                    <td class="score-low"><?= e(number_format((float)$r['avg_score'], 2)) ?></td>
                    <td><?= e((string)$r['n']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>

<script>
    // Check if canvas elements exist before creating charts
    const dimCanvas = document.getElementById('dimChart');
    const siteCanvas = document.getElementById('siteChart');
    const taskCanvas = document.getElementById('taskChart');

    const NAVY = '#1B3A7B',
        BRIGHT = '#2B55B0',
        SILVER = '#C8CDD5',
        AMBER = '#F59E0B',
        GREEN = '#1E7B45',
        RED = '#A33333';

    if (dimCanvas) {
        new Chart(dimCanvas, {
            type: 'radar',
            data: {
                labels: <?= json_encode($dimLabels) ?>,
                datasets: [{
                    label: 'Mean score',
                    data: <?= json_encode($dimScores) ?>,
                    backgroundColor: 'rgba(27,58,123,0.22)',
                    borderColor: NAVY,
                    borderWidth: 2,
                    pointBackgroundColor: AMBER,
                    pointRadius: 4
                },
                {
                    label: 'Target (4.0)',
                    data: <?= json_encode(array_fill(0, count($dimLabels), 4)) ?>,
                    borderColor: AMBER,
                    borderDash: [6, 4],
                    pointRadius: 0,
                    backgroundColor: 'transparent'
                }]
            },
            options: {
                scales: {
                    r: {
                        min: 0,
                        max: 5,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    }

    if (siteCanvas) {
        new Chart(siteCanvas, {
            type: 'bar',
            data: {
                labels: <?= json_encode($siteLabels) ?>,
                datasets: [{
                    label: 'Mean score (/5)',
                    data: <?= json_encode($siteScores) ?>,
                    backgroundColor: NAVY,
                    borderRadius: 8,
                    yAxisID: 'y'
                },
                {
                    label: 'Participation %',
                    data: <?= json_encode($sitePart) ?>,
                    backgroundColor: AMBER,
                    borderRadius: 8,
                    yAxisID: 'y1'
                }]
            },
            options: {
                scales: {
                    y: {
                        min: 0,
                        max: 5,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Score'
                        }
                    },
                    y1: {
                        min: 0,
                        max: 100,
                        position: 'right',
                        grid: {
                            drawOnChartArea: false
                        },
                        title: {
                            display: true,
                            text: '%'
                        }
                    }
                }
            }
        });
    }

    if (taskCanvas) {
        new Chart(taskCanvas, {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'In progress', 'Open', 'Overdue'],
                datasets: [{
                    data: [
                        <?= (int)($taskCounts['done_c'] ?? 0) ?>,
                        <?= (int)($taskCounts['prog_c'] ?? 0) ?>,
                        <?= max(0, (int)($taskCounts['open_c'] ?? 0) - (int)($taskCounts['overdue_c'] ?? 0)) ?>,
                        <?= (int)($taskCounts['overdue_c'] ?? 0) ?>
                    ],
                    backgroundColor: [GREEN, BRIGHT, SILVER, RED],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                cutout: '62%',
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        });
    }
</script>
<?php
// Check if footer file exists before including
$footerFile = __DIR__ . '/includes/footer.php';
if (file_exists($footerFile)) {
    include $footerFile;
} else {
    echo '<div style="text-align:center;padding:20px;color:#999;font-size:12px;">© ' . date('Y') . ' ' . APP_COMPANY . ' - Food Safety Culture Program</div>';
}
?>
</body>
</html><?php
// ============ CONFIGURATION - ADD THIS SECTION ============
// Define constants
define('APP_NAME', 'Food Safety Culture');
define('APP_COMPANY', 'RTNTS GLOBAL');

// Database configuration
$host = 'localhost'; // or your database host
$database = 'your_database_name';
$username = 'your_username';
$password = 'your_password';

// Helper function for HTML escaping
function e($string) {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

// ============ SESSION & USER AUTHENTICATION ============
session_start();
$u = $_SESSION['user'] ?? null; // Assuming user is stored in session
$page = 'dashboard'; // or determine from $_GET

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("PDO Connection failed: " . $e->getMessage());
}

$round = $pdo->query("SELECT * FROM survey_rounds WHERE status='open' ORDER BY opens_on DESC LIMIT 1")->fetch();
if (!$round) {
    $round = $pdo->query("SELECT * FROM survey_rounds ORDER BY closes_on DESC LIMIT 1")->fetch();
}
$roundId = $round ? (int)$round['id'] : 0;

// KPI: participation
$totalResponses = 0;
$totalHeadcount = 0;
$participation = null;
$siteLabels = [];
$sitePart = [];
$siteScores = [];
if ($roundId) {
    $rows = $pdo->prepare(
        "SELECT s.id, s.name,
            COALESCE(h.headcount,0) AS headcount,
            (SELECT COUNT(*) FROM responses r WHERE r.round_id=? AND r.site_id=s.id) AS resp
        FROM sites s
        LEFT JOIN site_headcount h ON h.site_id=s.id AND h.round_id=?"
    );
    $rows->execute([$roundId, $roundId]);
    foreach ($rows->fetchAll() as $r) {
        $totalResponses += (int)$r['resp'];
        $totalHeadcount += (int)$r['headcount'];
        $siteLabels[] = $r['name'];
        $sitePart[] = $r['headcount'] > 0 ? round(100 * $r['resp'] / $r['headcount'], 1) : 0;
        $s = $pdo->prepare(
            "SELECT AVG(a.score) FROM answers a
            JOIN responses r ON r.id=a.response_id
            WHERE r.round_id=? AND r.site_id=? AND a.score IS NOT NULL"
        );
        $s->execute([$roundId, (int)$r['id']]);
        $v = $s->fetchColumn();
        $siteScores[] = $v !== null ? round((float)$v, 2) : 0;
    }
    if ($totalHeadcount > 0) $participation = round(100 * $totalResponses / $totalHeadcount, 1);
}

// Mean score by dimension
$dimLabels = [];
$dimScores = [];
if ($roundId) {
    $q = $pdo->prepare(
        "SELECT d.name, st.avg_score
        FROM dimensions d
        LEFT JOIN (
            SELECT qs.dimension_id, AVG(a.score) AS avg_score
            FROM questions qs
            JOIN answers a ON a.question_id = qs.id AND a.score IS NOT NULL
            JOIN responses r ON r.id = a.response_id
            WHERE r.round_id = ? AND qs.qtype = 'likert'
            GROUP BY qs.dimension_id
        ) st ON st.dimension_id = d.id
        ORDER BY d.sort_order"
    );
    $q->execute([$roundId]);
    foreach ($q->fetchAll() as $r) {
        $dimLabels[] = $r['name'];
        $dimScores[] = $r['avg_score'] !== null ? round((float)$r['avg_score'], 2) : 0;
    }
}

$groupMean = null;
if ($roundId) {
    $s = $pdo->prepare("SELECT AVG(a.score) FROM answers a JOIN responses r ON r.id=a.response_id WHERE r.round_id=? AND a.score IS NOT NULL");
    $s->execute([$roundId]);
    $v = $s->fetchColumn();
    $groupMean = $v !== null ? round((float)$v, 2) : null;
}

// Task KPIs
$taskCounts = $pdo->query(
    "SELECT
        SUM(status='open') AS open_c,
        SUM(status='in_progress') AS prog_c,
        SUM(status='completed') AS done_c,
        SUM(status<>'completed' AND due_date IS NOT NULL AND due_date < CURDATE()) AS overdue_c
    FROM tasks"
)->fetch();

// Roadmap progress
$roadmap = $pdo->query(
    "SELECT COUNT(*) AS total, SUM(status='completed') AS done FROM plan_steps"
)->fetch();
$roadmapPct = ($roadmap && $roadmap['total'] > 0) ? round(100 * $roadmap['done'] / $roadmap['total']) : 0;

// What's next: top 6 upcoming or overdue open tasks
$nextTasks = $pdo->query(
    "SELECT t.*, d.name AS dim, s.name AS site_name, us.full_name AS owner_name
    FROM tasks t
    LEFT JOIN dimensions d ON d.id=t.dimension_id
    LEFT JOIN sites s ON s.id=t.site_id
    LEFT JOIN users us ON us.id=t.owner_user_id
    WHERE t.status <> 'completed'
    ORDER BY t.due_date IS NULL, t.due_date
    LIMIT 6"
)->fetchAll();

// Low-scoring questions (<3.0)
$lowQs = [];
if ($roundId) {
    $q = $pdo->prepare(
        "SELECT qs.qtext, d.name AS dim, AVG(a.score) AS avg_score, COUNT(a.id) AS n
        FROM questions qs
        LEFT JOIN dimensions d ON d.id=qs.dimension_id
        JOIN answers a ON a.question_id=qs.id AND a.score IS NOT NULL
        JOIN responses r ON r.id=a.response_id AND r.round_id=?
        WHERE qs.qtype='likert'
        GROUP BY qs.id, qs.qtext, d.name
        HAVING AVG(a.score) < 3.0
        ORDER BY avg_score ASC"
    );
    $q->execute([$roundId]);
    $lowQs = $q->fetchAll();
}

function navlink(string $href, string $id, string $label, string $page): string {
    $cls = $id === $page ? 'link active' : 'link';
    return '<a class="' . $cls . '" href="' . $href . '">' . $label . '</a>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e(APP_NAME) ?> — <?= e(APP_COMPANY) ?></title>
<link rel="stylesheet" href="assets/style.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
</head>
<body>
<nav class="nav">
    <span class="brand">RTNTS GLOBAL <span class="dot">·</span> FSC PORTAL</span>
    <?php if ($u): ?>
        <?= navlink('index.php', 'dashboard', 'Dashboard', $page) ?>
        <?= navlink('survey.php', 'survey', 'Take Survey', $page) ?>
        <?php if (in_array($u['role'], ['admin','manager'])): ?>
            <?= navlink('results.php', 'results', 'Survey Results', $page) ?>
        <?php endif; ?>
        <?= navlink('tasks.php', 'tasks', 'Tasks', $page) ?>
        <?= navlink('roadmap.php', 'roadmap', 'Roadmap', $page) ?>
        <?php if ($u['role'] === 'admin'): ?>
            <?= navlink('surveys_admin.php', 'surveys_admin', 'Manage Surveys', $page) ?>
            <?= navlink('users.php', 'users', 'Users', $page) ?>
        <?php endif; ?>
    <?php endif; ?>
    <span class="spacer"></span>
    <?php if ($u): ?>
        <span class="userbox"><?= e($u['full_name']) ?> (<?= e($u['role']) ?>)
        <a href="logout.php">Log out</a></span>
    <?php endif; ?>
</nav>
<div class="wrap">
<div class="hero">
    <div class="hero-main">
        <h1>Food Safety Culture Dashboard</h1>
        <p class="sub"><?= $round ? e($round['title']) . ' · ' . e($round['status']) . ' · closes ' . e($round['closes_on']) : 'No survey round configured yet.' ?></p>
        <span class="chip">BRCGS 9 · Cl. 1.1.2</span>
        <span class="chip">FSSC 22000 V6 · 2.5.8</span>
        <span class="chip">852/2004 Ch. XIa</span>
        <span class="chip">FDA FSMA</span>
    </div>
    <div class="ring-wrap">
        <div class="ring" style="--p: <?= (float)($participation ?? 0) ?>">
            <div>
                <div>
                    <div class="val"><?= $participation !== null ? e((string)$participation) . '%' : '—' ?></div>
                    <div class="cap">participation<br>target 75%</div>
                </div>
            </div>
        </div>
        <div class="ring" style="--p: <?= $groupMean !== null ? (float)$groupMean / 5 * 100 : 0 ?>">
            <div>
                <div>
                    <div class="val"><?= $groupMean !== null ? e((string)$groupMean) : '—' ?></div>
                    <div class="cap">mean score<br>target 4.0</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="cards">
    <div class="card">
        <div class="icon">&#128202;</div>
        <div class="kpi"><?= e((string)$totalResponses) ?></div>
        <div class="lbl">Responses this round</div>
    </div>
    <div class="card accent-green">
        <div class="icon">&#9989;</div>
        <div class="kpi"><?= e((string)($taskCounts['done_c'] ?? 0)) ?></div>
        <div class="lbl">Culture tasks completed</div>
    </div>
    <div class="card">
        <div class="icon">&#128296;</div>
        <div class="kpi"><?= e((string)(($taskCounts['open_c'] ?? 0) + ($taskCounts['prog_c'] ?? 0))) ?></div>
        <div class="lbl">Tasks open / in progress</div>
    </div>
    <div class="card <?= ($taskCounts['overdue_c'] ?? 0) > 0 ? 'accent-red' : 'accent-green' ?>">
        <div class="icon">&#9200;</div>
        <div class="kpi"><?= e((string)($taskCounts['overdue_c'] ?? 0)) ?></div>
        <div class="lbl">Overdue tasks</div>
    </div>
    <div class="card accent-amber">
        <div class="icon">&#128506;</div>
        <div class="kpi"><?= $roadmapPct ?>%</div>
        <div class="lbl">Roadmap steps complete · <a href="roadmap.php">view roadmap</a></div>
    </div>
</div>

<div class="grid2">
    <div class="panel">
        <h2>Mean score by GFSI dimension</h2>
        <canvas id="dimChart" height="230"></canvas>
    </div>
    <div class="panel">
        <h2>Site comparison — score &amp; participation</h2>
        <canvas id="siteChart" height="230"></canvas>
    </div>
</div>

<div class="grid2">
    <div class="panel">
        <h2>Task status</h2>
        <canvas id="taskChart" height="220"></canvas>
    </div>
    <div class="panel">
        <h2>What's next — nearest due activities</h2>
        <table class="data">
            <tr>
                <th>Task</th>
                <th>Owner</th>
                <th>Due</th>
                <th>Status</th>
            </tr>
            <?php foreach ($nextTasks as $t):
                $overdue = $t['due_date'] && $t['due_date'] < date('Y-m-d'); ?>
                <tr>
                    <td><strong><?= e($t['title']) ?></strong><?php if ($t['dim']): ?><br><span class="sub" style="margin:0"><?= e($t['dim']) ?></span><?php endif; ?></td>
                    <td><?= e($t['owner_name'] ?? ($t['owner_role'] ?? '—')) ?></td>
                    <td><?= e($t['due_date'] ?? '—') ?></td>
                    <td><span class="badge b-<?= $overdue ? 'overdue' : e($t['status']) ?>"><?= $overdue ? 'overdue' : e(str_replace('_', ' ', $t['status'])) ?></span></td>
                </tr>
            <?php endforeach; ?>
            <?php if (!$nextTasks): ?><tr>
                <td colspan="4">Nothing outstanding — nice work.</td>
            </tr><?php endif; ?>
        </table>
        <a class="btn small" style="margin-top:12px" href="tasks.php">Open task tracker</a>
        <a class="btn small secondary" style="margin-top:12px" href="roadmap.php">Full roadmap</a>
    </div>
</div>

<div class="panel">
    <h2>Questions scoring below 3.0 — mandatory action (SOP-FSC-002)</h2>
    <?php if (!$lowQs): ?>
        <p class="sub" style="margin:0">None — no question currently averages below 3.0 in this round.</p>
    <?php else: ?>
        <table class="data">
            <tr>
                <th>Question</th>
                <th>Dimension</th>
                <th>Mean</th>
                <th>Responses</th>
            </tr>
            <?php foreach ($lowQs as $r): ?>
                <tr>
                    <td><?= e($r['qtext']) ?></td>
                    <td><?= e($r['dim'] ?? '—') ?></td>
                    <td class="score-low"><?= e(number_format((float)$r['avg_score'], 2)) ?></td>
                    <td><?= e((string)$r['n']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>

<script>
    // Check if canvas elements exist before creating charts
    const dimCanvas = document.getElementById('dimChart');
    const siteCanvas = document.getElementById('siteChart');
    const taskCanvas = document.getElementById('taskChart');

    const NAVY = '#1B3A7B',
        BRIGHT = '#2B55B0',
        SILVER = '#C8CDD5',
        AMBER = '#F59E0B',
        GREEN = '#1E7B45',
        RED = '#A33333';

    if (dimCanvas) {
        new Chart(dimCanvas, {
            type: 'radar',
            data: {
                labels: <?= json_encode($dimLabels) ?>,
                datasets: [{
                    label: 'Mean score',
                    data: <?= json_encode($dimScores) ?>,
                    backgroundColor: 'rgba(27,58,123,0.22)',
                    borderColor: NAVY,
                    borderWidth: 2,
                    pointBackgroundColor: AMBER,
                    pointRadius: 4
                },
                {
                    label: 'Target (4.0)',
                    data: <?= json_encode(array_fill(0, count($dimLabels), 4)) ?>,
                    borderColor: AMBER,
                    borderDash: [6, 4],
                    pointRadius: 0,
                    backgroundColor: 'transparent'
                }]
            },
            options: {
                scales: {
                    r: {
                        min: 0,
                        max: 5,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    }

    if (siteCanvas) {
        new Chart(siteCanvas, {
            type: 'bar',
            data: {
                labels: <?= json_encode($siteLabels) ?>,
                datasets: [{
                    label: 'Mean score (/5)',
                    data: <?= json_encode($siteScores) ?>,
                    backgroundColor: NAVY,
                    borderRadius: 8,
                    yAxisID: 'y'
                },
                {
                    label: 'Participation %',
                    data: <?= json_encode($sitePart) ?>,
                    backgroundColor: AMBER,
                    borderRadius: 8,
                    yAxisID: 'y1'
                }]
            },
            options: {
                scales: {
                    y: {
                        min: 0,
                        max: 5,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Score'
                        }
                    },
                    y1: {
                        min: 0,
                        max: 100,
                        position: 'right',
                        grid: {
                            drawOnChartArea: false
                        },
                        title: {
                            display: true,
                            text: '%'
                        }
                    }
                }
            }
        });
    }

    if (taskCanvas) {
        new Chart(taskCanvas, {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'In progress', 'Open', 'Overdue'],
                datasets: [{
                    data: [
                        <?= (int)($taskCounts['done_c'] ?? 0) ?>,
                        <?= (int)($taskCounts['prog_c'] ?? 0) ?>,
                        <?= max(0, (int)($taskCounts['open_c'] ?? 0) - (int)($taskCounts['overdue_c'] ?? 0)) ?>,
                        <?= (int)($taskCounts['overdue_c'] ?? 0) ?>
                    ],
                    backgroundColor: [GREEN, BRIGHT, SILVER, RED],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                cutout: '62%',
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        });
    }
</script>
<?php
// Check if footer file exists before including
$footerFile = __DIR__ . '/includes/footer.php';
if (file_exists($footerFile)) {
    include $footerFile;
} else {
    echo '<div style="text-align:center;padding:20px;color:#999;font-size:12px;">© ' . date('Y') . ' ' . APP_COMPANY . ' - Food Safety Culture Program</div>';
}
?>
</body>
</html>