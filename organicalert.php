<?php
/* ============================================================
   OF&G NEWS SCRAPER — SIMPLE WORKING VERSION
   ============================================================
   If the main page uses JavaScript to load news, this tries:
   1. Common RSS/feed URLs
   2. Common JSON API endpoints
   3. Smarter HTML scraping (finds <article>, <h2><a>, etc.)
   ============================================================ */

$TARGET = 'https://ofgorganic.org/news-and-events';

/* ---------- Fetch any URL ---------- */
function fetch($url) {
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL            => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_TIMEOUT        => 20,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_USERAGENT      => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) ' .
                                  'AppleWebKit/537.36 (KHTML, like Gecko) ' .
                                  'Chrome/120.0.0.0 Safari/537.36',
        CURLOPT_HTTPHEADER     => ['Accept: text/html,application/xhtml+xml,application/xml,application/json'],
    ]);
    $body = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $err  = curl_error($ch);
    curl_close($ch);

    if ($body === false) return ['ok' => false, 'error' => $err, 'code' => 0];
    return ['ok' => $code >= 200 && $code < 300, 'body' => $body, 'code' => $code];
}

/* ---------- Try RSS/feed URLs ---------- */
function tryFeeds($base) {
    $candidates = [
        $base . '/feed',
        $base . '/rss',
        $base . '/news-and-events/feed',
        $base . '/news/feed',
        $base . '/rss.xml',
        $base . '/feed.xml',
    ];

    foreach ($candidates as $url) {
        $r = fetch($url);
        if (!$r['ok'] || empty($r['body'])) continue;

        // Is it XML/RSS?
        if (stripos($r['body'], '<rss') !== false || stripos($r['body'], '<feed') !== false) {
            $items = parseRss($r['body']);
            if ($items) return ['source' => $url, 'items' => $items];
        }
        // Is it JSON?
        $json = json_decode($r['body'], true);
        if (is_array($json)) {
            $items = parseJson($json);
            if ($items) return ['source' => $url, 'items' => $items];
        }
    }
    return null;
}

/* ---------- Parse RSS/Atom ---------- */
function parseRss($xml) {
    libxml_use_internal_errors(true);
    $doc = simplexml_load_string($xml);
    if (!$doc) return [];

    $items = [];
    // RSS 2.0
    if (isset($doc->channel->item)) {
        foreach ($doc->channel->item as $item) {
            $items[] = [
                'title' => trim((string)$item->title),
                'link'  => trim((string)$item->link),
                'date'  => trim((string)$item->pubDate),
            ];
        }
    }
    // Atom
    elseif (isset($doc->entry)) {
        foreach ($doc->entry as $entry) {
            $link = '';
            foreach ($entry->link as $l) {
                if ((string)$l['rel'] === 'alternate' || !isset($l['rel'])) {
                    $link = (string)$l['href'];
                    break;
                }
            }
            $items[] = [
                'title' => trim((string)$entry->title),
                'link'  => $link,
                'date'  => trim((string)$entry->updated),
            ];
        }
    }
    return $items;
}

/* ---------- Parse JSON (generic) ---------- */
function parseJson($data) {
    $items = [];
    $walk = function ($node) use (&$walk, &$items) {
        if (!is_array($node)) return;
        if (isset($node['title']) && isset($node['url'])) {
            $items[] = [
                'title' => $node['title'],
                'link'  => $node['url'],
                'date'  => $node['date'] ?? $node['published'] ?? '',
            ];
        } elseif (isset($node['title']) && isset($node['link'])) {
            $items[] = [
                'title' => $node['title'],
                'link'  => is_array($node['link']) ? ($node['link']['url'] ?? '') : $node['link'],
                'date'  => $node['date'] ?? '',
            ];
        }
        foreach ($node as $v) if (is_array($v)) $walk($v);
    };
    $walk($data);
    return $items;
}

/* ---------- Smarter HTML scraping ---------- */
function scrapeHtml($html, $base) {
    libxml_use_internal_errors(true);
    $dom = new DOMDocument();
    $dom->loadHTML('<?xml encoding="UTF-8">' . $html);
    $xpath = new DOMXPath($dom);

    $items = [];
    $seen  = [];

    // Look for links whose href contains /news/ or /article/
    foreach ($xpath->query('//a[@href]') as $a) {
        $href  = trim($a->getAttribute('href'));
        $title = trim(preg_replace('/\s+/', ' ', $a->textContent));

        if (strlen($title) < 15) continue;
        if (!preg_match('#/(news|article|blog|story|press)/#i', $href)) continue;
        if (stripos($href, 'news-and-events') !== false && strpos($href, '/news-and-events/') === false) continue;

        // Skip nav/menu links
        if (preg_match('/^(Home|News|Events|About|Contact|Login|Register|Menu)$/i', $title)) continue;

        if (strpos($href, 'http') !== 0) {
            $href = rtrim($base, '/') . '/' . ltrim($href, '/');
        }

        $key = md5($title);
        if (isset($seen[$key])) continue;
        $seen[$key] = true;

        $items[] = ['title' => $title, 'link' => $href, 'date' => ''];
    }

    return array_slice($items, 0, 20);
}

/* ============================================================
   RUN
   ============================================================ */
$items  = [];
$source = 'none';
$debug  = [];

// 1. Try feeds/JSON first (most reliable)
$feed = tryFeeds('https://ofgorganic.org');
if ($feed) {
    $items  = $feed['items'];
    $source = 'feed: ' . $feed['source'];
    $debug[] = "Found " . count($items) . " items from feed";
}

// 2. Fall back to scraping the main page
if (empty($items)) {
    $r = fetch($TARGET);
    if ($r['ok']) {
        $items = scrapeHtml($r['body'], 'https://ofgorganic.org');
        $source = 'html scrape (' . number_format(strlen($r['body'])) . ' bytes)';
        $debug[] = "Scraped " . count($items) . " items from HTML";
    } else {
        $debug[] = "Fetch failed: " . $r['error'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>OF&G · News & Events</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Space+Grotesk:wght@500;600&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
:root{
  --bg:#f7fbfa; --surface:#fff; --primary:#1a8f7a; --primary-dark:#0f6b5c;
  --primary-light:#4fb8a3; --accent:#f2795b; --text:#1e3b36; --muted:#8ba69e;
  --border:#d7e9e3; --shadow:0 10px 30px -8px rgba(26,143,122,.12);
}
*{margin:0;padding:0;box-sizing:border-box}
body{background:linear-gradient(135deg,#f7fbfa,#eef7f4 50%,#fafffe);font-family:'Inter',sans-serif;
  color:var(--text);padding:2.5rem 1.5rem;min-height:100vh;line-height:1.55}
.wrap{max-width:1340px;margin:0 auto}
.header{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1.5rem;
  margin-bottom:2.5rem;padding-bottom:1.8rem;border-bottom:2px solid var(--border);position:relative}
.header::after{content:'';position:absolute;bottom:-2px;left:0;width:90px;height:3px;
  background:linear-gradient(90deg,var(--primary),var(--accent));border-radius:4px}
.header-left{display:flex;align-items:center;gap:1.1rem}
.header-icon{font-size:2rem;color:#fff;background:linear-gradient(145deg,var(--primary),var(--primary-light));
  width:64px;height:64px;border-radius:18px;display:inline-flex;align-items:center;justify-content:center;
  box-shadow:0 8px 20px -6px rgba(26,143,122,.4);flex-shrink:0}
.header h1{font-family:'Space Grotesk',sans-serif;font-weight:600;font-size:1.85rem;color:var(--text);margin:0}
.header .sub{font-size:.85rem;color:var(--muted);margin-top:.35rem}
.badge{background:var(--surface);border-radius:50px;padding:.7rem 1.7rem;border:1.5px solid var(--border);
  font-weight:600;color:var(--primary-dark);display:flex;align-items:center;gap:.65rem;font-size:.88rem;
  box-shadow:var(--shadow)}
.badge i{color:var(--accent)}
.diag{background:var(--surface);border-radius:16px;border:1.5px solid var(--border);padding:1.4rem 1.6rem;
  box-shadow:var(--shadow);margin-bottom:2rem;font-size:.85rem;color:var(--muted)}
.diag strong{color:var(--primary-dark);display:block;margin-bottom:.5rem;font-family:'Space Grotesk',sans-serif}
.diag code{background:rgba(26,143,122,.1);color:var(--primary-dark);padding:.15rem .45rem;border-radius:5px;
  font-size:.8rem;font-family:monospace}
.grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(340px,1fr));gap:1.6rem}
.card{background:var(--surface);border-radius:16px;border:1.5px solid var(--border);padding:1.7rem;
  box-shadow:var(--shadow);transition:.25s;display:flex;flex-direction:column;height:100%;position:relative;
  overflow:hidden}
.card::before{content:'';position:absolute;top:0;left:0;width:100%;height:4px;
  background:linear-gradient(90deg,var(--primary-light),var(--primary),var(--accent));opacity:.75}
.card:hover{transform:translateY(-5px);box-shadow:0 22px 40px -12px rgba(26,143,122,.25);border-color:var(--primary-light)}
.card h5{font-family:'Space Grotesk',sans-serif;font-weight:600;font-size:1.12rem;line-height:1.42;
  color:var(--text);margin:0 0 1.1rem 0;display:flex;gap:.7rem}
.card h5 i{color:var(--primary);font-size:.9rem;margin-top:.22rem;flex-shrink:0}
.btn{background:linear-gradient(135deg,var(--primary),var(--primary-dark));border:none;border-radius:50px;
  padding:.68rem 1.65rem;font-weight:600;font-size:.8rem;color:#fff;display:inline-flex;align-items:center;
  gap:.6rem;width:fit-content;transition:.22s;box-shadow:0 6px 18px -6px rgba(26,143,122,.5);
  text-decoration:none;margin-top:auto;cursor:pointer}
.btn:hover{background:linear-gradient(135deg,var(--primary-dark),#0a5548);color:#fff;transform:translateY(-1px)}
.btn i{font-size:.7rem;transition:transform .2s}
.btn:hover i{transform:translateX(3px)}
.alert{background:#fff9f4;border-left:5px solid var(--accent);border-radius:14px;padding:1.6rem 1.8rem;
  box-shadow:var(--shadow);color:#7a5a3e;display:flex;gap:1.2rem;font-size:.95rem;border:1px solid #fae6d4}
.alert i{font-size:1.8rem;color:var(--accent);flex-shrink:0}
.alert strong{display:block;color:var(--text);margin-bottom:.35rem;font-size:1rem}
.alert ul{margin:.6rem 0 0 0;padding-left:1.2rem;font-size:.85rem}
.alert li{margin-bottom:.35rem}
.alert code{background:rgba(26,143,122,.1);color:var(--primary-dark);padding:.15rem .45rem;
  border-radius:5px;font-size:.82rem;font-family:monospace}
.footnote{margin-top:3rem;text-align:center;font-size:.75rem;color:var(--muted);border-top:1px solid var(--border);
  padding-top:2rem;display:flex;align-items:center;justify-content:center;gap:.7rem}
.footnote i{font-size:.65rem;color:var(--primary-light)}
@media(max-width:640px){body{padding:1.5rem 1rem}.header h1{font-size:1.5rem}.grid{grid-template-columns:1fr}}
</style>
</head>
<body>
<div class="wrap">

  <div class="header">
    <div class="header-left">
      <div class="header-icon"><i class="fas fa-newspaper"></i></div>
      <div>
        <h1>OF&G News</h1>
        <div class="sub">organic farmers &amp; growers · news &amp; events</div>
      </div>
    </div>
    <div class="badge">
      <i class="fas fa-list-check"></i>
      <span><?= count($items) ?> items</span>
    </div>
  </div>

  <div class="diag">
    <strong><i class="fas fa-stethoscope"></i> Diagnostic</strong>
    Source: <code><?= htmlspecialchars($source) ?></code><br>
    <?php foreach ($debug as $d): ?>
      · <?= htmlspecialchars($d) ?><br>
    <?php endforeach; ?>
  </div>

  <?php if (empty($items)): ?>
    <div class="alert">
      <i class="fas fa-search"></i>
      <div>
        <strong>No news items found</strong>
        <p>OF&G's page likely loads news via JavaScript, so plain HTML scraping can't see them.
           This scraper tried RSS feeds, JSON endpoints, and HTML parsing.</p>
        <p><strong>Best fix:</strong> Use their official feed if available. Check the page source
           (<kbd>Ctrl+U</kbd>) for a <code>&lt;link rel="alternate" type="application/rss+xml"&gt;</code> tag,
           or inspect the Network tab (<kbd>F12</kbd>) for the JSON URL the page calls.</p>
        <p>Once you find the real feed URL, add it to the <code>$candidates</code> array in <code>tryFeeds()</code>.</p>
      </div>
    </div>
  <?php else: ?>
    <div class="grid">
      <?php foreach ($items as $it): ?>
        <div class="card">
          <h5><i class="fas fa-newspaper"></i> <?= htmlspecialchars($it['title']) ?></h5>
          <a class="btn" target="_blank" rel="noopener" href="<?= htmlspecialchars($it['link']) ?>">
            <i class="fas fa-arrow-up-right-from-square"></i> Read article
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <div class="footnote">
    <i class="fas fa-leaf"></i> data from ofgorganic.org <i class="fas fa-leaf"></i>
  </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>