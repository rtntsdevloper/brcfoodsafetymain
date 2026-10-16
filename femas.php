<?php
/**
 * Scrape key sections from the AIC homepage.
 * Source: https://www.agindustries.org.uk/
 * Save as: C:\xampp\htdocs\aic.php
 * Open:    http://localhost/aic.php
 *
 * NOTE: Light, personal-use scraping. Check AIC's Terms of Use before publishing.
 */

// ============================================================
// CONFIGURATION
// ============================================================
$targetUrl = 'https://www.agindustries.org.uk/';

// ============================================================
// FETCH FUNCTION
// ============================================================
function fetchHtml($url)
{
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL            => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_TIMEOUT        => 30,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_USERAGENT      => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) ' .
                                  'AppleWebKit/537.36 (KHTML, like Gecko) ' .
                                  'Chrome/120.0.0.0 Safari/537.36',
        CURLOPT_HTTPHEADER     => [
            'Accept: text/html,application/xhtml+xml',
            'Accept-Language: en-GB,en;q=0.9',
        ],
    ]);
    $html = curl_exec($ch);
    if (curl_errno($ch)) {
        $err = curl_error($ch);
        curl_close($ch);
        return ['success' => false, 'error' => $err];
    }
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($code < 200 || $code >= 300) {
        return ['success' => false, 'error' => "HTTP $code"];
    }
    return ['success' => true, 'html' => $html];
}

// ============================================================
// PARSE FUNCTION — extract block titles + links
// ============================================================
function extractBlocks($html)
{
    $items = [];
    libxml_use_internal_errors(true);
    $dom = new DOMDocument();
    $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));

    $xpath = new DOMXPath($dom);

    // AIC uses <h3> for section headings like "Hot topics", "Latest News"
    // and card titles inside those sections. Grab all <h3> and <a> combos.
    $nodes = $xpath->query('//h3 | //h4');

    foreach ($nodes as $node) {
        $title = trim($node->textContent);
        if ($title === '' || mb_strlen($title) < 3) continue;

        $link = '';
        // Look for a link inside the same parent
        $parent = $node->parentNode;
        if ($parent) {
            $a = $parent->getElementsByTagName('a');
            if ($a->length > 0) {
                $link = $a->item(0)->getAttribute('href');
            }
        }

        $items[] = ['title' => $title, 'link' => $link];
    }

    // Deduplicate
    $seen = [];
    $unique = [];
    foreach ($items as $i) {
        if (isset($seen[$i['title']])) continue;
        $seen[$i['title']] = true;
        $unique[] = $i;
    }

    return array_slice($unique, 0, 30);
}

// ============================================================
// EXECUTE
// ============================================================
$result = fetchHtml($targetUrl);

$items = [];
if ($result['success']) {
    $items = extractBlocks($result['html']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AIC Scraper</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>body { background:#eef2f7; padding:30px 0; }</style>
</head>
<body>
<div class="container">

    <h1 class="text-center mb-4">AIC Homepage Scraper</h1>

    <?php if (!$result['success']): ?>
        <div class="alert alert-danger">
            <strong>Error:</strong> <?= htmlspecialchars($result['error']) ?>
        </div>
    <?php elseif (empty($items)): ?>
        <div class="alert alert-warning">
            Fetched OK, but no matching headings found. AIC may use
            different HTML structure than expected.
        </div>
    <?php else: ?>

        <p class="text-muted text-center">
            Found <strong><?= count($items) ?></strong> headings
        </p>

        <div class="row g-3">
            <?php foreach ($items as $it): ?>
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <h6 class="card-title mb-1">
                                <?= htmlspecialchars($it['title']) ?>
                            </h6>
                            <?php if (!empty($it['link'])): ?>
                                <?php
                                $full = $it['link'];
                                if (strpos($full, 'http') !== 0) {
                                    $full = 'https://www.agindustries.org.uk' .
                                            (strpos($full, '/') === 0 ? '' : '/') . $full;
                                }
                                ?>
                                <a class="btn btn-sm btn-outline-primary"
                                   target="_blank"
                                   href="<?= htmlspecialchars($full) ?>">
                                    Open
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>

</div>

</body>
</html>