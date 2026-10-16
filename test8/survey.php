<?php
// ================= Anonymous culture survey =================
require_once __DIR__ . '/includes/auth.php';
$u = require_login();
csrf_check();
$page = 'survey';
$pdo = db();
$msg = ''; $err = ''; 
$round = $pdo->query("SELECT * FROM survey_rounds WHERE status='open' AND opens_on <= CURDATE() AND closes_on >= CURDATE() ORDER BY opens_on DESC LIMIT 1")->fetch();
$sites = $pdo->query("SELECT * FROM sites ORDER BY name")->fetchAll();
$departments = $pdo->query("SELECT * FROM departments ORDER BY name")->fetchAll();
$questions = $pdo->query("SELECT q.*, d.name AS dim FROM questions q LEFT JOIN dimensions d ON d.id=q.dimension_id WHERE q.active=1 ORDER BY q.sort_order")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $round) {
    $siteId = (int)($_POST['site_id'] ?? 0);
    $deptId = (int)($_POST['department_id'] ?? 0);
    $shift  = $_POST['shift'] ?? '';
    $validShift = in_array($shift, ['Days','Nights','Weekend','Rotating'], true);
    // validate all likert questions answered
    $missing = false;
    foreach ($questions as $q) {
        if ($q['qtype'] === 'likert') {
            $v = $_POST['q' . $q['id']] ?? '';
            if (!in_array($v, ['1','2','3','4','5'], true)) { $missing = true; break; }
        }
    }
    if (!$siteId || !$deptId || !$validShift) {
        $err = 'Please select your site, department and shift.';
    } elseif ($missing) {
        $err = 'Please answer every scored question before submitting.';
    } else {
        try {
            $pdo->beginTransaction();
            $stmt = $pdo->prepare('INSERT INTO responses (round_id, site_id, department_id, shift) VALUES (?,?,?,?)');
            $stmt->execute([(int)$round['id'], $siteId, $deptId, $shift]);
            $respId = (int)$pdo->lastInsertId();
            $ansL = $pdo->prepare('INSERT INTO answers (response_id, question_id, score) VALUES (?,?,?)');
            $ansT = $pdo->prepare('INSERT INTO answers (response_id, question_id, comment) VALUES (?,?,?)');
            foreach ($questions as $q) {
                if ($q['qtype'] === 'likert') {
                    $ansL->execute([$respId, (int)$q['id'], (int)$_POST['q' . $q['id']]]);
                } else {
                    $c = trim($_POST['q' . $q['id']] ?? '');
                    if ($c !== '') $ansT->execute([$respId, (int)$q['id'], mb_substr($c, 0, 2000)]);
                }
            }
            $pdo->commit();
            $msg = 'Thank you — your anonymous response has been recorded.';
        } catch (Throwable $ex) {
            $pdo->rollBack();
            $err = 'Something went wrong saving your response. Please try again.';
        }
    }
}
include __DIR__ . '/includes/header.php';
?>
<h1>Food Safety Culture Survey</h1>
<?php if (!$round): ?>
  <div class="alert info">There is no survey open at the moment. Please check back later.</div>
<?php else: ?>
<p class="sub"><strong><?= e($round['title']) ?></strong> — open until <?= e($round['closes_on']) ?>.
Your answers are <strong>anonymous</strong>: we record only your site, department and shift, never your name.
Results for groups smaller than <?= (int)MIN_GROUP_SIZE ?> people are never shown.</p>

<?php if ($msg): ?><div class="alert ok"><?= e($msg) ?></div><?php endif; ?>
<?php if ($err): ?><div class="alert err"><?= e($err) ?></div><?php endif; ?>

<?php if (!$msg): ?>
<form method="post" action="survey.php">
  <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
  <div class="panel">
    <h2>About you (for grouping only)</h2>
    <div class="grid2">
      <div>
        <label>Site</label>
        <select name="site_id" required>
          <option value="">— select —</option>
          <?php foreach ($sites as $s): ?><option value="<?= (int)$s['id'] ?>"><?= e($s['name']) ?></option><?php endforeach; ?>
        </select>
      </div>
      <div>
        <label>Department</label>
        <select name="department_id" required>
          <option value="">— select —</option>
          <?php foreach ($departments as $d): ?><option value="<?= (int)$d['id'] ?>"><?= e($d['name']) ?></option><?php endforeach; ?>
        </select>
      </div>
    </div>
    <label>Shift</label>
    <select name="shift" required>
      <option value="">— select —</option>
      <option>Days</option><option>Nights</option><option>Weekend</option><option>Rotating</option>
    </select>
  </div>

  <?php foreach ($questions as $i => $q): ?>
    <div class="q-block">
      <div class="q-dim"><?= e($q['dim'] ?? 'Your comments') ?></div>
      <div class="q-text"><?= ($i+1) ?>. <?= e($q['qtext']) ?></div>
      <?php if ($q['qtype'] === 'likert'): ?>
        <div class="likert">
          <?php $lbls = [1=>'Strongly disagree',2=>'Disagree',3=>'Neutral',4=>'Agree',5=>'Strongly agree'];
          foreach ($lbls as $v => $l): ?>
            <label><input type="radio" name="q<?= (int)$q['id'] ?>" value="<?= $v ?>" required> <?= $v ?> — <?= e($l) ?></label>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <textarea name="q<?= (int)$q['id'] ?>" maxlength="2000" placeholder="Optional — your words, no names please"></textarea>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>

  <button class="btn" type="submit">Submit anonymous response</button>
</form>
<?php endif; ?>
<?php endif; ?>
<?php include __DIR__ . '/includes/footer.php'; ?>
