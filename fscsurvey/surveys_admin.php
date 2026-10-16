<?php
// ================= Manage survey rounds (admin) =================
require_once __DIR__ . '/includes/auth.php';
$u = require_role('admin');
csrf_check();
$page = 'surveys_admin';
$msg = ''; $err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'create') {
        $title = trim($_POST['title'] ?? '');
        $rtype = $_POST['rtype'] === 'pulse' ? 'pulse' : 'annual';
        $opens = $_POST['opens_on'] ?? '';
        $closes = $_POST['closes_on'] ?? '';
        if ($title === '' || !$opens || !$closes || $closes < $opens) {
            $err = 'Provide a title and a valid open/close date range.';
        } else {
            db_query(
                'INSERT INTO survey_rounds (title, rtype, opens_on, closes_on, status) VALUES (' .
                db_val(mb_substr($title, 0, 120)) . ',' . db_val($rtype) . ',' . db_val($opens) . ',' . db_val($closes) . ', "draft")'
            );
            $roundId = db_insert_id();
            // copy headcounts submitted with the form
            foreach ($_POST['headcount'] ?? [] as $sid => $hc) {
                if ((int)$hc > 0) {
                    db_query(
                        'INSERT INTO site_headcount (site_id, round_id, headcount) VALUES (' .
                        db_val((int)$sid) . ',' . db_val($roundId) . ',' . db_val((int)$hc) . ')'
                    );
                }
            }
            $msg = 'Survey round created as draft.';
        }
    }

    if ($action === 'setstatus') {
        $status = $_POST['status'] ?? '';
        if (in_array($status, ['draft','open','closed'], true)) {
            // only one round open at a time
            if ($status === 'open') {
                db_query("UPDATE survey_rounds SET status='closed' WHERE status='open'");
            }
            db_query('UPDATE survey_rounds SET status = ' . db_val($status) . ' WHERE id = ' . db_val((int)($_POST['round_id'] ?? 0)));
            $msg = 'Round status updated.';
        }
    }
}

$rounds = db_select(
  "SELECT sr.*, (SELECT COUNT(*) FROM responses r WHERE r.round_id = sr.id) AS resp_count
   FROM survey_rounds sr ORDER BY sr.opens_on DESC");
$sites = db_select('SELECT * FROM sites ORDER BY name');

include __DIR__ . '/includes/header.php';
?>
<h1>Manage Survey Rounds</h1>
<p class="sub">Annual survey: all 25 questions + free text. Pulse: same instrument, shorter window (per SOP-FSC-002 keep pulses to ~1 week). Opening a round automatically closes any other open round.</p>

<?php if ($msg): ?><div class="alert ok"><?= e($msg) ?></div><?php endif; ?>
<?php if ($err): ?><div class="alert err"><?= e($err) ?></div><?php endif; ?>

<table class="data">
  <tr><th>Title</th><th>Type</th><th>Opens</th><th>Closes</th><th>Status</th><th>Responses</th><th>Actions</th></tr>
  <?php foreach ($rounds as $r): ?>
  <tr>
    <td><?= e($r['title']) ?></td>
    <td><?= e($r['rtype']) ?></td>
    <td><?= e($r['opens_on']) ?></td>
    <td><?= e($r['closes_on']) ?></td>
    <td><span class="badge <?= $r['status']==='open' ? 'b-completed' : ($r['status']==='draft' ? 'b-open' : 'b-in_progress') ?>"><?= e($r['status']) ?></span></td>
    <td><?= (int)$r['resp_count'] ?></td>
    <td>
      <form method="post" action="surveys_admin.php" style="display:flex;gap:6px">
        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
        <input type="hidden" name="action" value="setstatus">
        <input type="hidden" name="round_id" value="<?= (int)$r['id'] ?>">
        <?php if ($r['status'] !== 'open'): ?><button class="btn small" name="status" value="open">Open</button><?php endif; ?>
        <?php if ($r['status'] === 'open'): ?><button class="btn small secondary" name="status" value="closed">Close</button><?php endif; ?>
      </form>
    </td>
  </tr>
  <?php endforeach; ?>
</table>

<div class="panel" style="margin-top:22px">
  <h2>Create a new round</h2>
  <form method="post" action="surveys_admin.php">
    <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
    <input type="hidden" name="action" value="create">
    <div class="grid2">
      <div>
        <label>Title *</label><input type="text" name="title" required maxlength="120" placeholder="e.g. 2027 Annual Culture Survey">
        <label>Type</label>
        <select name="rtype"><option value="annual">Annual (full)</option><option value="pulse">Pulse (quarterly)</option></select>
        <label>Opens on *</label><input type="date" name="opens_on" required>
        <label>Closes on *</label><input type="date" name="closes_on" required>
      </div>
      <div>
        <h2 style="margin-top:0">Headcount per site (for participation %)</h2>
        <?php foreach ($sites as $s): ?>
          <label><?= e($s['name']) ?></label>
          <input type="text" name="headcount[<?= (int)$s['id'] ?>]" placeholder="e.g. 180" pattern="[0-9]*">
        <?php endforeach; ?>
      </div>
    </div>
    <button class="btn" type="submit">Create draft round</button>
  </form>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
