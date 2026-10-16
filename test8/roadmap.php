<?php
// ================= Implementation roadmap / next steps =================
require_once __DIR__ . '/includes/auth.php';
$u = require_login();
csrf_check();
$page = 'roadmap';
$pdo = db();
$msg = '';
$canManage = is_role('admin', 'manager');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $canManage) {
    $stepId = (int)($_POST['step_id'] ?? 0);
    $status = $_POST['status'] ?? '';
    if (in_array($status, ['not_started','in_progress','completed'], true)) {
        $stmt = $pdo->prepare('UPDATE plan_steps SET status = ? WHERE id = ?');
        $stmt->execute([$status, $stepId]);
        $msg = 'Step updated.';
    }
}

$phases = $pdo->query('SELECT * FROM plan_phases ORDER BY sort_order')->fetchAll();
$stepsByPhase = [];
foreach ($pdo->query('SELECT * FROM plan_steps ORDER BY phase_id, sort_order') as $s) {
    $stepsByPhase[$s['phase_id']][] = $s;
}
include __DIR__ . '/includes/header.php';
?>
<h1>Implementation Roadmap — Detailed Next Steps</h1>
<p class="sub">The full delivery path for the Food Safety &amp; Quality Culture Plan (FSC-PLAN-001 §13). This portal is the <strong>single system of record</strong>: every step's status, evidence and resulting actions are kept and managed here — survey data in Results, actions in Tasks, and progress below.
<?= $canManage ? 'Update a step\'s status as work progresses; changes are timestamped.' : 'Statuses are maintained by your site management team.' ?></p>

<?php if ($msg): ?><div class="alert ok"><?= e($msg) ?></div><?php endif; ?>

<?php foreach ($phases as $ph):
    $steps = $stepsByPhase[$ph['id']] ?? [];
    $total = count($steps);
    $done = count(array_filter($steps, fn($s) => $s['status'] === 'completed'));
    $pct = $total ? round(100 * $done / $total) : 0; ?>
  <div class="phase <?= $pct === 100 ? 'done' : '' ?>">
    <div class="phase-head">
      <h2><?= e($ph['name']) ?></h2>
      <span class="timeframe"><?= e($ph['timeframe']) ?></span>
      <div class="phase-progress">
        <div class="bar-track"><div class="bar-fill" style="width:<?= $pct ?>%"></div></div>
        <span><?= $done ?>/<?= $total ?> · <?= $pct ?>%</span>
      </div>
    </div>
    <p class="sub" style="margin-bottom:8px"><?= e($ph['objective']) ?></p>

    <?php foreach ($steps as $s): ?>
      <div class="step">
        <div class="step-head">
          <span class="step-title"><?= e($s['title']) ?></span>
          <span class="badge b-<?= e($s['status']) ?>"><?= e(str_replace('_',' ', $s['status'])) ?></span>
          <span class="meta">Owner: <?= e($s['owner_role'] ?? '—') ?> · Timing: <?= e($s['due_label'] ?? '—') ?></span>
        </div>
        <?php if ($s['detail']): ?><div class="detail"><?= e($s['detail']) ?></div><?php endif; ?>
        <?php if ($s['deliverable']): ?><div class="deliverable"><strong>Deliverable / record:</strong> <?= e($s['deliverable']) ?></div><?php endif; ?>
        <?php if ($canManage): ?>
          <form method="post" action="roadmap.php" style="margin-top:8px;display:flex;gap:8px;align-items:center">
            <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
            <input type="hidden" name="step_id" value="<?= (int)$s['id'] ?>">
            <select name="status" style="width:auto">
              <option value="not_started" <?= $s['status']==='not_started'?'selected':'' ?>>Not started</option>
              <option value="in_progress" <?= $s['status']==='in_progress'?'selected':'' ?>>In progress</option>
              <option value="completed" <?= $s['status']==='completed'?'selected':'' ?>>Completed</option>
            </select>
            <button class="btn small" type="submit">Save</button>
          </form>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  </div>
<?php endforeach; ?>

<div class="panel">
  <h2>How the portal manages everything</h2>
  <table class="data">
    <tr><th>Information</th><th>Where it lives</th><th>Managed by</th></tr>
    <tr><td>Employee perception data (anonymous)</td><td>Take Survey → Results (with n&lt;5 suppression)</td><td>Admin opens/closes rounds</td></tr>
    <tr><td>Culture plan activities, actions &amp; evidence</td><td>Tasks (owners, due dates, effectiveness measures, evidence)</td><td>Admin &amp; managers; employees update their own</td></tr>
    <tr><td>Implementation progress &amp; next steps</td><td>This Roadmap (statuses, deliverables)</td><td>Admin &amp; managers</td></tr>
    <tr><td>KPIs for Steering Committee &amp; management review</td><td>Dashboard (participation, scores, task status, roadmap %)</td><td>Auto-calculated live</td></tr>
    <tr><td>People &amp; access</td><td>Users (roles: admin / manager / employee)</td><td>Admin</td></tr>
  </table>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
