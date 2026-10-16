<?php
/* ============================================================
   EFSA JOURNAL DASHBOARD (NO EMAIL ALERTS)
   ============================================================
   SETUP:
   1. Upload this file to your server.
   2. Ensure the folder is writable (for efsa_seen.json).
   3. Optional cron to refresh state hourly:
        0 * * * * php /path/to/this-file.php >/dev/null 2>&1
   ============================================================ */

$STATE_FILE = __DIR__ . '/efsa_seen.json';
$API_URL    = 'https://www.ebi.ac.uk/europepmc/webservices/rest/search?'
            . http_build_query([
                'query'      => 'JOURNAL:"EFSA Journal"',
                'format'     => 'json',
                'resultType' => 'core',
                'pageSize'   => 15,
                'sort'       => 'CITED desc',
              ]);

/* ============================================================
   FETCH ARTICLES (cURL with file_get_contents fallback)
   ============================================================ */
function fetchArticles($url) {
    $body = false;
    $code = 0;
    $err  = '';

    if (function_exists('curl_init')) {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS      => 3,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_USERAGENT      => 'EFSA-Reader/1.0 (+dashboard)',
            CURLOPT_HTTPHEADER     => ['Accept: application/json'],
        ]);
        $body = curl_exec($ch);
        $code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err  = curl_error($ch);
        curl_close($ch);
    }

    if ($body === false || $body === '') {
        // Fallback: file_get_contents (needs allow_url_fopen)
        $ctx = stream_context_create([
            'http' => [
                'method'        => 'GET',
                'timeout'       => 30,
                'header'        => "Accept: application/json\r\nUser-Agent: EFSA-Reader/1.0\r\n",
                'ignore_errors' => true,
            ],
            'ssl' => [
                'verify_peer'      => true,
                'verify_peer_name' => true,
            ],
        ]);
        $body = @file_get_contents($url, false, $ctx);
        if (isset($http_response_header[0]) && preg_match('#\s(\d{3})\s#', $http_response_header[0], $m)) {
            $code = (int) $m[1];
        }
        if ($body === false && $err === '') $err = 'Request failed';
    }

    if ($body === false) {
        return ['ok' => false, 'error' => $err ?: 'Network error'];
    }
    if ($code !== 0 && ($code < 200 || $code >= 300)) {
        return ['ok' => false, 'error' => "HTTP $code"];
    }

    $data = json_decode($body, true);
    if (!is_array($data) || !isset($data['resultList']['result'])) {
        return ['ok' => false, 'error' => 'Unexpected API response'];
    }

    return [
        'ok'    => true,
        'hits'  => $data['resultList']['result'],
        'total' => isset($data['hitCount']) ? (int) $data['hitCount'] : 0,
    ];
}

/* ============================================================
   STATE TRACKING
   ============================================================ */
function articleKey($a) {
    if (!empty($a['doi']))  return 'doi:'  . strtolower($a['doi']);
    if (!empty($a['id']))   return 'pmid:' . $a['id'];
    if (!empty($a['pmid'])) return 'pmid:' . $a['pmid'];
    return 'title:' . md5(isset($a['title']) ? $a['title'] : '');
}

function loadSeen($file) {
    if (!is_file($file)) return [];
    $raw = @file_get_contents($file);
    if ($raw === false) return [];
    $data = json_decode($raw, true);
    return is_array($data) ? $data : [];
}

function saveSeen($file, $ids) {
    if (count($ids) > 500) $ids = array_slice($ids, -500, null, true);
    @file_put_contents($file, json_encode($ids), LOCK_EX);
}

/* UTF-8 safe truncate (mbstring optional) */
function truncate($s, $len) {
    $s = (string) $s;
    if (function_exists('mb_strimwidth')) {
        return mb_strimwidth($s, 0, $len, '…', 'UTF-8');
    }
    if (function_exists('mb_substr') && function_exists('mb_strlen')) {
        return (mb_strlen($s, 'UTF-8') > $len) ? mb_substr($s, 0, $len, 'UTF-8') . '…' : $s;
    }
    return (strlen($s) > $len) ? substr($s, 0, $len) . '…' : $s;
}

/* ============================================================
   RUN
   ============================================================ */
$result       = fetchArticles($API_URL);
$alertMessage = null;
$alertType    = null;

if ($result['ok']) {
    $hits = $result['hits'];

    if (!empty($hits)) {
        $seen       = loadSeen($STATE_FILE);
        $isFirstRun = !is_file($STATE_FILE);
        $newOnes    = [];

        foreach ($hits as $a) {
            $key = articleKey($a);
            if (!isset($seen[$key])) $newOnes[] = $a;
            $seen[$key] = time();
        }

        if (!$isFirstRun && !empty($newOnes)) {
            $alertMessage = count($newOnes) . " new article(s) since last check.";
            $alertType    = 'success';
        } elseif ($isFirstRun) {
            $alertMessage = "First run: saved baseline of " . count($hits) . " articles.";
            $alertType    = 'success';
        }

        saveSeen($STATE_FILE, $seen);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>EFSA Journal · Article Dashboard</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Space+Grotesk:wght@500;600&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
:root{
  --bg:#f5f9fe; --surface:#fff; --primary:#0b4f6c; --primary-light:#1b6b93;
  --accent:#2d9596; --text:#0c2d3f; --muted:#5e7c8b; --border:#dde9f0;
  --shadow:0 10px 25px -5px rgba(0,40,60,.08),0 8px 10px -6px rgba(0,0,0,.02);
}
*{margin:0;padding:0;box-sizing:border-box}
body{background:var(--bg);font-family:'Inter',sans-serif;color:var(--text);padding:2rem 0;line-height:1.5}
.wrapper{max-width:1440px;margin:0 auto;padding:1.5rem 2rem}
.header{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1.25rem;
  margin-bottom:2.75rem;border-bottom:1px solid var(--border);padding-bottom:1.5rem}
.header-title{display:flex;align-items:center;gap:.8rem}
.header-title i{font-size:2.2rem;color:var(--accent);background:linear-gradient(145deg,#e1f0f2,#c8e2e6);
  padding:.7rem;border-radius:18px;box-shadow:0 6px 12px rgba(45,149,150,.15)}
.header-title h1{font-family:'Space Grotesk',sans-serif;font-weight:600;font-size:2rem;color:var(--primary);margin:0}
.badge{font-size:.9rem;font-weight:500;color:#fff;border-radius:40px;padding:.25rem .9rem;margin-left:.75rem;
  background:linear-gradient(135deg,#0b4f6c,#1e6f8f);box-shadow:0 4px 8px rgba(11,79,108,.2)}
.summary{background:var(--surface);border-radius:60px;padding:.7rem 1.6rem;box-shadow:var(--shadow);
  border:1px solid var(--border);font-weight:500;color:var(--primary);font-size:.95rem;
  display:flex;align-items:center;gap:.6rem}
.summary i{color:var(--accent)}
.grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(360px,1fr));gap:1.8rem;margin-top:.5rem}
.card{background:var(--surface);border-radius:18px;border:1px solid rgba(221,233,240,.7);
  padding:1.6rem;box-shadow:var(--shadow);transition:.2s;display:flex;flex-direction:column;height:100%;position:relative}
.card:hover{transform:translateY(-5px);box-shadow:0 25px 35px -10px rgba(11,79,108,.15);border-color:#b9d4e0}
.card::before{content:'';position:absolute;top:0;left:1.6rem;right:1.6rem;height:4px;
  background:linear-gradient(90deg,#2d9596,#5ab9b0,#8fcbc9);border-radius:0 0 6px 6px;opacity:.8}
.card-title{font-family:'Space Grotesk',sans-serif;font-weight:600;font-size:1.25rem;line-height:1.4;
  color:var(--primary);margin:0 0 .8rem 0;display:-webkit-box;-webkit-line-clamp:3;
  -webkit-box-orient:vertical;overflow:hidden}
.meta{font-size:.85rem;color:var(--muted);display:flex;flex-wrap:wrap;gap:.6rem 1rem;margin-bottom:1.2rem;
  border-left:3px solid #d1e4eb;padding-left:.9rem}
.meta-item{display:inline-flex;align-items:center;gap:.25rem;background:#f2f9fd;padding:.2rem .7rem;
  border-radius:30px;font-weight:500;color:#1a556b;font-size:.78rem}
.meta-item i{color:var(--accent);font-size:.8rem}
.abstract{font-size:.93rem;color:#1e4a5e;line-height:1.6;margin-bottom:1.5rem;flex-grow:1;
  background:#fafdff;padding:.9rem 1rem;border-radius:14px;border-left:3px solid #b6d9e7;
  display:-webkit-box;-webkit-line-clamp:4;-webkit-box-orient:vertical;overflow:hidden}
.btn{background:var(--primary);border:none;border-radius:40px;padding:.6rem 1.5rem;font-weight:600;
  font-size:.85rem;color:#fff;display:inline-flex;align-items:center;gap:.55rem;width:fit-content;
  transition:.2s;box-shadow:0 6px 12px -4px rgba(11,79,108,.25);text-decoration:none}
.btn:hover{background:var(--primary-light);color:#fff;transform:scale(1.02)}
.alert{padding:1rem 1.6rem;border-radius:16px;box-shadow:var(--shadow);margin-bottom:1.5rem;
  display:flex;align-items:center;gap:.8rem;font-size:.95rem;font-weight:500}
.alert i{font-size:1.4rem}
.alert-success{background:#f1fdf6;border-left:6px solid #2e9e5b;color:#1e7a44}
.alert-success i{color:#2e9e5b}
.alert-warning{background:#fffbf0;border-left:6px solid #d99a1e;color:#9a6a10}
.alert-warning i{color:#d99a1e}
.alert-error{background:#fff3f1;border-left:6px solid #d44c4c;color:#b33a3a}
.alert-error i{color:#d44c4c}
.empty{text-align:center;padding:4rem 2rem;background:#fff;border-radius:32px;box-shadow:var(--shadow);color:var(--muted)}
.empty i{font-size:3.5rem;color:#b9d4e0;margin-bottom:1.2rem;display:block}
@media(max-width:640px){.wrapper{padding:.8rem 1.2rem}.header-title h1{font-size:1.5rem}
  .header-title i{font-size:1.6rem;padding:.5rem}.grid{grid-template-columns:1fr}}
</style>
</head>
<body>
<div class="wrapper">

  <div class="header">
    <div class="header-title">
      <i class="fas fa-flask"></i>
      <h1>EFSA Journal <span class="badge">peer-reviewed</span></h1>
    </div>
    <div class="summary">
      <i class="fas fa-file-alt"></i>
      <span>
        <?php if ($result['ok']): ?>
          <?= count($result['hits']) ?> of <?= number_format($result['total']) ?> articles
        <?php else: ?>
          Error
        <?php endif; ?>
      </span>
    </div>
  </div>

  <?php if ($alertMessage): ?>
    <div class="alert alert-<?= htmlspecialchars($alertType) ?>">
      <i class="fas fa-<?= $alertType === 'success' ? 'circle-check' : 'triangle-exclamation' ?>"></i>
      <div><?= htmlspecialchars($alertMessage) ?></div>
    </div>
  <?php endif; ?>

  <?php if (!$result['ok']): ?>
    <div class="alert alert-error">
      <i class="fas fa-exclamation-triangle"></i>
      <div>
        <strong>Could not retrieve articles</strong><br>
        <?= htmlspecialchars($result['error']) ?>
      </div>
    </div>

  <?php elseif (empty($result['hits'])): ?>
    <div class="empty">
      <i class="fas fa-file-circle-question"></i>
      <h3>No articles found</h3>
      <p>Try again later.</p>
    </div>

  <?php else: ?>
    <div class="grid">
      <?php foreach ($result['hits'] as $a): ?>
        <div class="card">
          <h5 class="card-title"><?= htmlspecialchars(isset($a['title']) ? $a['title'] : 'Untitled') ?></h5>

          <div class="meta">
            <?php if (!empty($a['authorString'])): ?>
              <span class="meta-item">
                <i class="fas fa-user-pen"></i>
                <?= htmlspecialchars(truncate($a['authorString'], 50)) ?>
              </span>
            <?php endif; ?>
            <?php if (!empty($a['pubYear'])): ?>
              <span class="meta-item"><i class="far fa-calendar-alt"></i><?= htmlspecialchars($a['pubYear']) ?></span>
            <?php endif; ?>
            <?php if (!empty($a['citedByCount'])): ?>
              <span class="meta-item"><i class="fas fa-quote-right"></i><?= (int)$a['citedByCount'] ?> citations</span>
            <?php endif; ?>
          </div>

          <?php if (!empty($a['abstractText'])): ?>
            <div class="abstract">
              <?= htmlspecialchars(truncate(strip_tags($a['abstractText']), 320)) ?>
            </div>
          <?php else: ?>
            <div class="abstract" style="font-style:italic;color:#8ba3b0">No abstract available.</div>
          <?php endif; ?>

          <div style="margin-top:auto">
            <?php if (!empty($a['doi'])): ?>
              <a class="btn" target="_blank" rel="noopener" href="https://doi.org/<?= htmlspecialchars($a['doi']) ?>">
                <i class="fas fa-arrow-up-right-from-square"></i> Read article
              </a>
            <?php else: ?>
              <span style="color:#8ba3b0;font-size:.85rem;font-style:italic">DOI unavailable</span>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

</div>
</body>
</html>