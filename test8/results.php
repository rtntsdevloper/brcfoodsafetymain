<?php
// ================= Survey results (admin / manager) =================
require_once __DIR__ . '/includes/auth.php';
$u = require_role('admin', 'manager');
$page = 'results';
$pdo = db();

$rounds = $pdo->query("SELECT * FROM survey_rounds ORDER BY opens_on DESC")->fetchAll();
$sites  = $pdo->query("SELECT * FROM sites ORDER BY name")->fetchAll();

$roundId = (int)($_GET['round'] ?? ($rounds[0]['id'] ?? 0));
$siteId  = isset($_GET['site']) && $_GET['site'] !== '' ? (int)$_GET['site'] : null;
// managers restricted to their own site if one is assigned
if ($u['role'] === 'manager' && $u['site_id']) { $siteId = $u['site_id']; }

$siteSql = $siteId ? ' AND r.site_id = ' . (int)$siteId : '';

// per-question stats
$qstats = $pdo->prepare(
  "SELECT qs.id, qs.qtext, qs.sort_order, d.name AS dim,
          st.avg_score, COALESCE(st.n, 0) AS n,
          COALESCE(st.low_n, 0) AS low_n, COALESCE(st.high_n, 0) AS high_n
   FROM questions qs
   LEFT JOIN dimensions d ON d.id = qs.dimension_id
   LEFT JOIN (
     SELECT a.question_id, AVG(a.score) AS avg_score, COUNT(*) AS n,
            SUM(a.score<=2) AS low_n, SUM(a.score>=4) AS high_n
     FROM answers a
     JOIN responses r ON r.id = a.response_id
     WHERE r.round_id = ? $siteSql AND a.score IS NOT NULL
     GROUP BY a.question_id
   ) st ON st.question_id = qs.id
   WHERE qs.qtype='likert'
   ORDER BY qs.sort_order");
$qstats->execute([$roundId]);
$qrows = $qstats->fetchAll();

// dimension stats
$dstats = $pdo->prepare(
  "SELECT d.name, st.avg_score, COALESCE(st.n, 0) AS n
   FROM dimensions d
   LEFT JOIN (
     SELECT qs.dimension_id, AVG(a.score) AS avg_score, COUNT(a.id) AS n
     FROM questions qs
     JOIN answers a ON a.question_id = qs.id AND a.score IS NOT NULL
     JOIN responses r ON r.id = a.response_id
     WHERE r.round_id = ? $siteSql AND qs.qtype = 'likert'
     GROUP BY qs.dimension_id
   ) st ON st.dimension_id = d.id
   ORDER BY d.sort_order");
$dstats->execute([$roundId]);
$drows = $dstats->fetchAll();

// department breakdown with anonymity suppression
$dept = $pdo->prepare(
  "SELECT dp.name, COUNT(DISTINCT r.id) AS n, AVG(a.score) AS avg_score
   FROM departments dp
   JOIN responses r ON r.department_id = dp.id AND r.round_id = ? $siteSql
   JOIN answers a ON a.response_id = r.id AND a.score IS NOT NULL
   GROUP BY dp.id, dp.name ORDER BY dp.name");
$dept->execute([$roundId]);
$deptRows = $dept->fetchAll();

// free-text comments (only shown to admin; shuffled to avoid order identification)
$comments = [];
if ($u['role'] === 'admin') {
    $c = $pdo->prepare(
      "SELECT qs.qtext, a.comment
       FROM answers a
       JOIN questions qs ON qs.id = a.question_id AND qs.qtype='text'
       JOIN responses r ON r.id = a.response_id AND r.round_id = ? $siteSql
       WHERE a.comment IS NOT NULL AND a.comment <> ''");
    $c->execute([$roundId]);
    $comments = $c->fetchAll();
    shuffle($comments);
}

$respCount = 0;
$rc = $pdo->prepare("SELECT COUNT(*) FROM responses r WHERE r.round_id = ? $siteSql");
$rc->execute([$roundId]);
$respCount = (int)$rc->fetchColumn();

function scoreClass($v) { if ($v === null) return ''; return $v < 3.0 ? 'score-low' : ($v >= 4.0 ? 'score-good' : ''); }
include __DIR__ . '/includes/header.php';
?>
<h1>Survey Results</h1>
<p class="sub">Aggregated, anonymous results. Groups with fewer than <?= (int)MIN_GROUP_SIZE ?> respondents are suppressed.</p>

<div class="panel">
  <form method="get" action="results.php" style="display:flex;gap:16px;align-items:flex-end;flex-wrap:wrap">
    <div style="min-width:260px">
      <label>Survey round</label>
      <select name="round" onchange="this.form.submit()">
        <?php foreach ($rounds as $r): ?>
          <option value="<?= (int)$r['id'] ?>" <?= $r['id'] == $roundId ? 'selected' : '' ?>><?= e($r['title']) ?> (<?= e($r['status']) ?>)</option>
        <?php endforeach; ?>
      </select>
    </div>
    <?php if ($u['role'] === 'admin'): ?>
    <div style="min-width:220px">
      <label>Site</label>
      <select name="site" onchange="this.form.submit()">
        <option value="">All sites</option>
        <?php foreach ($sites as $s): ?>
          <option value="<?= (int)$s['id'] ?>" <?= $siteId == $s['id'] ? 'selected' : '' ?>><?= e($s['name']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <?php endif; ?>
    <div class="sub" style="margin:0 0 8px">Responses in view: <strong><?= $respCount ?></strong></div>
  </form>
</div>

<div class="panel">
  <h2>Scores by dimension</h2>
  <?php foreach ($drows as $d): $v = $d['avg_score'] !== null ? (float)$d['avg_score'] : null; ?>
    <div class="bar-row">
      <div class="bar-label"><?= e($d['name']) ?></div>
      <div class="bar-track"><div class="bar-fill" style="width:<?= $v !== null ? round($v/5*100) : 0 ?>%"></div></div>
      <div class="bar-val <?= scoreClass($v) ?>"><?= $v !== null ? number_format($v,2) : '—' ?></div>
    </div>
  <?php endforeach; ?>
</div>

<div class="panel">
  <h2>Per-question results</h2>
  <table class="data">
    <tr><th>#</th><th>Question</th><th>Dimension</th><th>Mean</th><th>n</th><th>% scoring 1–2</th><th>% scoring 4–5</th></tr>
    <?php foreach ($qrows as $i => $q):
      $v = $q['avg_score'] !== null ? (float)$q['avg_score'] : null;
      $n = (int)$q['n']; ?>
    <tr>
      <td><?= $i+1 ?></td>
      <td><?= e($q['qtext']) ?></td>
      <td><?= e($q['dim'] ?? '—') ?></td>
      <td class="<?= scoreClass($v) ?>"><?= $v !== null ? number_format($v,2) : '—' ?></td>
      <td><?= $n ?></td>
      <td><?= $n ? round(100*(int)$q['low_n']/$n) . '%' : '—' ?></td>
      <td><?= $n ? round(100*(int)$q['high_n']/$n) . '%' : '—' ?></td>
    </tr>
    <?php endforeach; ?>
  </table>
</div>

<div class="panel">
  <h2>Department breakdown<?= $siteId ? '' : ' (all sites)' ?></h2>
  <table class="data">
    <tr><th>Department</th><th>Respondents</th><th>Mean score</th></tr>
    <?php foreach ($deptRows as $d): $n = (int)$d['n']; ?>
    <tr>
      <td><?= e($d['name']) ?></td>
      <?php if ($n < MIN_GROUP_SIZE): ?>
        <td colspan="2"><em>Suppressed — fewer than <?= (int)MIN_GROUP_SIZE ?> respondents (anonymity protection)</em></td>
      <?php else: ?>
        <td><?= $n ?></td>
        <td class="<?= scoreClass((float)$d['avg_score']) ?>"><?= number_format((float)$d['avg_score'],2) ?></td>
      <?php endif; ?>
    </tr>
    <?php endforeach; ?>
    <?php if (!$deptRows): ?><tr><td colspan="3">No responses yet.</td></tr><?php endif; ?>
  </table>
</div>

<?php if ($u['role'] === 'admin'): ?>
<div class="panel">
  <h2>Free-text comments (admin only, randomised order)</h2>
  <?php if (!$comments): ?><p class="sub">No comments in this view.</p>
  <?php else: ?>
    <table class="data">
      <tr><th>Question</th><th>Comment</th></tr>
      <?php foreach ($comments as $c): ?>
        <tr><td style="width:32%"><?= e($c['qtext']) ?></td><td><?= e($c['comment']) ?></td></tr>
      <?php endforeach; ?>
    </table>
  <?php endif; ?>
</div>
<?php endif; ?>
<?php include __DIR__ . '/includes/footer.php'; ?>
