<?php 
//================= Dashboard =================
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

// Get current user from session
$u = $_SESSION['access'];

// if (!$u) {
//     $u = $GLOBALS['u'] ?? ['id' => 0, 'role' => 'guest'];
// }

// Check if user is logged in
// if (!isset($u['id']) || $u['id'] == 0) {
//     die('Please log in to access the dashboard.');
// }

$page = 'dashboard';

// Latest round (open preferred, else most recent)
$round = null;
$res = mysqli_query($con, "SELECT * FROM survey_rounds WHERE status='open' ORDER BY opens_on DESC LIMIT 1");
if ($res && mysqli_num_rows($res) > 0) {
    $round = mysqli_fetch_assoc($res);
}
if (!$round) {
    $res = mysqli_query($con, "SELECT * FROM survey_rounds ORDER BY closes_on DESC LIMIT 1");
    if ($res && mysqli_num_rows($res) > 0) {
        $round = mysqli_fetch_assoc($res);
    }
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
    $sql = "SELECT s.id, s.name,
                COALESCE(h.headcount,0) AS headcount,
                (SELECT COUNT(*) FROM responses r WHERE r.round_id = $roundId AND r.site_id=s.id) AS resp
            FROM sites s
            LEFT JOIN site_headcount h ON h.site_id=s.id AND h.round_id=$roundId";
    $res = mysqli_query($con, $sql);
    if ($res) {
        while ($r = mysqli_fetch_assoc($res)) {
            $totalResponses += (int)$r['resp'];
            $totalHeadcount += (int)$r['headcount'];
            $siteLabels[] = $r['name'];
            $sitePart[] = $r['headcount'] > 0 ? round(100 * $r['resp'] / $r['headcount'], 1) : 0;
            
            $siteId = (int)$r['id'];
            $sres = mysqli_query($con, 
                "SELECT AVG(a.score) FROM answers a
                 JOIN responses r ON r.id=a.response_id
                 WHERE r.round_id=$roundId AND r.site_id=$siteId AND a.score IS NOT NULL");
            $v = $sres ? mysqli_fetch_row($sres)[0] : null;
            $siteScores[] = $v !== null ? round((float)$v, 2) : 0;
        }
    }
    if ($totalHeadcount > 0) {
        $participation = round(100 * $totalResponses / $totalHeadcount, 1);
    }
}

// Mean score by dimension
$dimLabels = [];
$dimScores = [];
if ($roundId) {
    $sql = "SELECT d.name, st.avg_score
            FROM dimensions d
            LEFT JOIN (
                SELECT qs.dimension_id, AVG(a.score) AS avg_score
                FROM questions qs
                JOIN answers a ON a.question_id = qs.id AND a.score IS NOT NULL
                JOIN responses r ON r.id = a.response_id
                WHERE r.round_id = $roundId AND qs.qtype = 'likert'
                GROUP BY qs.dimension_id
            ) st ON st.dimension_id = d.id
            ORDER BY d.sort_order";
    $res = mysqli_query($con, $sql);
    if ($res) {
        while ($r = mysqli_fetch_assoc($res)) {
            $dimLabels[] = $r['name'];
            $dimScores[] = $r['avg_score'] !== null ? round((float)$r['avg_score'], 2) : 0;
        }
    }
}

// Group mean
$groupMean = null;
if ($roundId) {
    $res = mysqli_query($con, 
        "SELECT AVG(a.score) FROM answers a 
         JOIN responses r ON r.id=a.response_id 
         WHERE r.round_id=$roundId AND a.score IS NOT NULL");
    $v = $res ? mysqli_fetch_row($res)[0] : null;
    $groupMean = $v !== null ? round((float)$v, 2) : null;
}

// Task KPIs
$taskCounts = ['open_c' => 0, 'prog_c' => 0, 'done_c' => 0, 'overdue_c' => 0];
$res = mysqli_query($con,
    "SELECT
       SUM(CASE WHEN status='open' THEN 1 ELSE 0 END) AS open_c,
       SUM(CASE WHEN status='in_progress' THEN 1 ELSE 0 END) AS prog_c,
       SUM(CASE WHEN status='completed' THEN 1 ELSE 0 END) AS done_c,
       SUM(CASE WHEN status<>'completed' AND due_date IS NOT NULL AND due_date < CURDATE() THEN 1 ELSE 0 END) AS overdue_c
     FROM tasks");
if ($res) {
    $taskCounts = mysqli_fetch_assoc($res);
    if (!$taskCounts) $taskCounts = ['open_c' => 0, 'prog_c' => 0, 'done_c' => 0, 'overdue_c' => 0];
}

// Roadmap progress
$roadmapPct = 0;
$res = mysqli_query($con,
    "SELECT COUNT(*) AS total, SUM(CASE WHEN status='completed' THEN 1 ELSE 0 END) AS done FROM plan_steps");
if ($res) {
    $roadmap = mysqli_fetch_assoc($res);
    $roadmapPct = ($roadmap && $roadmap['total'] > 0) ? round(100 * $roadmap['done'] / $roadmap['total']) : 0;
}

// What's next: top 6 upcoming or overdue open tasks
$nextTasks = [];
$res = mysqli_query($con,
    "SELECT t.*, d.name AS dim, s.name AS site_name, us.full_name AS owner_name
     FROM tasks t
     LEFT JOIN dimensions d ON d.id=t.dimension_id
     LEFT JOIN sites s ON s.id=t.site_id
     LEFT JOIN users us ON us.id=t.owner_user_id
     WHERE t.status <> 'completed'
     ORDER BY t.due_date IS NULL, t.due_date
     LIMIT 6");
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $nextTasks[] = $row;
    }
}

// Low-scoring questions (<3.0)
$lowQs = [];
if ($roundId) {
    $sql = "SELECT qs.qtext, d.name AS dim, AVG(a.score) AS avg_score, COUNT(a.id) AS n
            FROM questions qs
            LEFT JOIN dimensions d ON d.id=qs.dimension_id
            JOIN answers a ON a.question_id=qs.id AND a.score IS NOT NULL
            JOIN responses r ON r.id=a.response_id AND r.round_id=$roundId
            WHERE qs.qtype='likert'
            GROUP BY qs.id, qs.qtext, d.name
            HAVING AVG(a.score) < 3.0
            ORDER BY avg_score ASC";
    $res = mysqli_query($con, $sql);
    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            $lowQs[] = $row;
        }
    }
}

// include __DIR__ . '/includes/header.php';
?>
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
            <div><div>
                <div class="val"><?= $participation !== null ? e((string)$participation) . '%' : '—' ?></div>
                <div class="cap">participation<br>target 75%</div>
            </div></div>
        </div>
        <div class="ring" style="--p: <?= $groupMean !== null ? (float)$groupMean / 5 * 100 : 0 ?>">
            <div><div>
                <div class="val"><?= $groupMean !== null ? e((string)$groupMean) : '—' ?></div>
                <div class="cap">mean score<br>target 4.0</div>
            </div></div>
        </div>
    </div>
</div>

<div class="cards">
    <div class="card"><div class="icon">&#128202;</div><div class="kpi"><?= e((string)$totalResponses) ?></div><div class="lbl">Responses this round</div></div>
    <div class="card accent-green"><div class="icon">&#9989;</div><div class="kpi"><?= e((string)($taskCounts['done_c'] ?? 0)) ?></div><div class="lbl">Culture tasks completed</div></div>
    <div class="card"><div class="icon">&#128296;</div><div class="kpi"><?= e((string)(($taskCounts['open_c'] ?? 0) + ($taskCounts['prog_c'] ?? 0))) ?></div><div class="lbl">Tasks open / in progress</div></div>
    <div class="card <?= ($taskCounts['overdue_c'] ?? 0) > 0 ? 'accent-red' : 'accent-green' ?>"><div class="icon">&#9200;</div><div class="kpi"><?= e((string)($taskCounts['overdue_c'] ?? 0)) ?></div><div class="lbl">Overdue tasks</div></div>
    <div class="card accent-amber"><div class="icon">&#128506;</div><div class="kpi"><?= $roadmapPct ?>%</div><div class="lbl">Roadmap steps complete · <a href="roadmap.php">view roadmap</a></div></div>
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
            <tr><th>Task</th><th>Owner</th><th>Due</th><th>Status</th></tr>
            <?php foreach ($nextTasks as $t):
                $overdue = isset($t['due_date']) && $t['due_date'] && $t['due_date'] < date('Y-m-d'); ?>
            <tr>
                <td><strong><?= e($t['title']) ?></strong><?php if ($t['dim'] ?? false): ?><br><span class="sub" style="margin:0"><?= e($t['dim']) ?></span><?php endif; ?></td>
                <td><?= e($t['owner_name'] ?? ($t['owner_role'] ?? '—')) ?></td>
                <td><?= e($t['due_date'] ?? '—') ?></td>
                <td><span class="badge b-<?= $overdue ? 'overdue' : e($t['status'] ?? '') ?>"><?= $overdue ? 'overdue' : e(str_replace('_',' ',$t['status'] ?? '')) ?></span></td>
            </tr>
            <?php endforeach; ?>
            <?php if (!$nextTasks): ?><tr><td colspan="4">Nothing outstanding — nice work.</td></tr><?php endif; ?>
        </table>
        <a class="btn small" style="margin-top:12px" href="admin?id=fscsurvey&id2=4">Open task tracker</a>
        <a class="btn small secondary" style="margin-top:12px" href="admin?id=fscsurvey&id2=5">Full roadmap</a>
    </div>
</div>

<div class="panel">
    <h2>Questions scoring below 3.0 — mandatory action (SOP-FSC-002)</h2>
    <?php if (!$lowQs): ?>
        <p class="sub" style="margin:0">None — no question currently averages below 3.0 in this round.</p>
    <?php else: ?>
        <table class="data">
            <tr><th>Question</th><th>Dimension</th><th>Mean</th><th>Responses</th></tr>
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const NAVY = '#1B3A7B', BRIGHT = '#2B55B0', SILVER = '#C8CDD5', AMBER = '#F59E0B', GREEN = '#1E7B45', RED = '#A33333';

// Dimension chart
const dimCtx = document.getElementById('dimChart');
if (dimCtx && <?= count($dimLabels) ?> > 0) {
    new Chart(dimCtx, {
        type: 'radar',
        data: {
            labels: <?= json_encode($dimLabels) ?>,
            datasets: [
                { label: 'Mean score', data: <?= json_encode($dimScores) ?>,
                    backgroundColor: 'rgba(27,58,123,0.22)', borderColor: NAVY, borderWidth: 2, pointBackgroundColor: AMBER, pointRadius: 4 },
                { label: 'Target (4.0)', data: <?= json_encode(array_fill(0, count($dimLabels), 4)) ?>,
                    borderColor: AMBER, borderDash: [6,4], pointRadius: 0, backgroundColor: 'transparent' }
            ]
        },
        options: { scales: { r: { min: 0, max: 5, ticks: { stepSize: 1 } } } }
    });
}

// Site chart
const siteCtx = document.getElementById('siteChart');
if (siteCtx && <?= count($siteLabels) ?> > 0) {
    new Chart(siteCtx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($siteLabels) ?>,
            datasets: [
                { label: 'Mean score (/5)', data: <?= json_encode($siteScores) ?>, backgroundColor: NAVY, borderRadius: 8, yAxisID: 'y' },
                { label: 'Participation %', data: <?= json_encode($sitePart) ?>, backgroundColor: AMBER, borderRadius: 8, yAxisID: 'y1' }
            ]
        },
        options: {
            scales: {
                y:  { min: 0, max: 5, position: 'left', title: { display: true, text: 'Score' } },
                y1: { min: 0, max: 100, position: 'right', grid: { drawOnChartArea: false }, title: { display: true, text: '%' } }
            }
        }
    });
}

// Task chart
const taskCtx = document.getElementById('taskChart');
if (taskCtx) {
    new Chart(taskCtx, {
        type: 'doughnut',
        data: {
            labels: ['Completed', 'In progress', 'Open', 'Overdue'],
            datasets: [{
                data: [<?= (int)($taskCounts['done_c'] ?? 0) ?>, <?= (int)($taskCounts['prog_c'] ?? 0) ?>,
                       <?= max(0, (int)($taskCounts['open_c'] ?? 0) - (int)($taskCounts['overdue_c'] ?? 0)) ?>, <?= (int)($taskCounts['overdue_c'] ?? 0) ?>],
                backgroundColor: [GREEN, BRIGHT, SILVER, RED],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: { cutout: '62%', plugins: { legend: { position: 'right' } } }
    });
}
</script>
<!-- <?php include __DIR__ . '/includes/footer.php'; ?> -->