<?php
/* DIRECT VIEW — fetches APIs live, no database at all */

error_reporting(0);
set_time_limit(120);

function http_get($url) {
    $ch = curl_init($url);
    curl_setopt_array($ch, array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 25,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_USERAGENT      => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => 0,
    ));
    $body = curl_exec($ch);
    curl_close($ch);
    return $body;
}
function v($a, $k, $d = '') { return (is_array($a) && isset($a[$k]) && $a[$k] !== '') ? $a[$k] : $d; }

 $alerts = array();
 $errors = array();

/* ---- FSA ---- */
 $b = http_get('https://data.food.gov.uk/food-alerts/id.json?_limit=100');
 $d = json_decode($b, true);
if (is_array($d) && isset($d['items'])) {
    foreach ($d['items'] as $i) {
        $p = v($i, 'problemType');
        $alerts[] = array(
            'source'   => 'FSA',
            'title'    => v($i, 'title', 'FSA alert'),
            'desc'     => v($i, 'riskStatement', $p),
            'severity' => (stripos($p, 'allerg') !== false) ? 'high' : 'medium',
            'date'     => v($i, 'created') ? date('Y-m-d', strtotime($i['created'])) : '',
            'url'      => v($i, 'alertURL'),
        );
    }
} else { $errors[] = 'FSA failed'; }
  
/* ---- FDA ---- */
 $b = http_get('https://api.fda.gov/food/enforcement.json?limit=100');
 $d = json_decode($b, true);
if (is_array($d) && isset($d['results'])) {
    foreach ($d['results'] as $i) {
        $c = v($i, 'classification');
        $sev = 'info';
        if ($c === 'Class I') $sev = 'critical';
        elseif ($c === 'Class II') $sev = 'high';
        elseif ($c === 'Class III') $sev = 'medium';
        $dt = '';
        if (v($i, 'report_date')) {
            $dd = DateTime::createFromFormat('Ymd', (string)$i['report_date']);
            if ($dd) $dt = $dd->format('Y-m-d');
        }
        $alerts[] = array(
            'source'   => 'FDA',
            'title'    => v($i, 'product_description', 'FDA recall'),
            'desc'     => v($i, 'reason_for_recall'),
            'severity' => $sev,
            'date'     => $dt,
            'url'      => 'https://www.fda.gov/safety/recalls-market-withdrawals-safety-alerts',
        );
    }
} else { $errors[] = 'FDA failed'; }

/* ---- EFSA ---- */
 $b = http_get('https://efsa.onlinelibrary.wiley.com/action/showFeed?type=etoc&feed=rss&jc=18314732');
 $xml = $b ? @simplexml_load_string($b) : false;
if ($xml !== false) {
    $items = array();
    if (isset($xml->channel->item)) { foreach ($xml->channel->item as $x) $items[] = $x; }
    elseif (isset($xml->entry))     { foreach ($xml->entry as $x) $items[] = $x; }
    foreach ($items as $i) {
        $link = (string)$i->link;
        if ($link === '' && isset($i->link['href'])) $link = (string)$i->link['href'];
        $dt = '';
        if (!empty($i->pubDate)) $dt = date('Y-m-d', strtotime((string)$i->pubDate));
        $alerts[] = array(
            'source'   => 'EFSA',
            'title'    => (string)$i->title,
            'desc'     => trim(strip_tags((string)$i->description)),
            'severity' => 'info',
            'date'     => $dt,
            'url'      => $link,
        );
    }
} else { $errors[] = 'EFSA failed (feed blocked?)'; }

/* newest first */
usort($alerts, function($a, $b){ return strcmp($b['date'], $a['date']); });
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Food Safety Alerts (Live)</title>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
<style>
    body { font-family: Arial; margin: 20px; }
    .badge { padding:3px 10px; border-radius:12px; color:#fff; font-size:12px; }
    .critical { background:#c0392b; } .high { background:#e67e22; }
    .medium { background:#f1c40f; color:#333; } .info { background:#95a5a6; }
    .err { color:#c0392b; font-size:13px; }
</style>
</head>
<body>
<h2>Food Safety Alerts <small style="color:#777">(live, no database)</small></h2>

<?php if ($errors) {
    echo '<div class="err">Note: ' . implode(' | ', $errors) . '</div>';
} ?>
<div style="font-size:13px;color:#555">Total alerts: <?php echo count($alerts); ?> — loaded <?php echo date('H:i:s'); ?></div>

<table id="t" class="display" style="width:100%">
    <thead><tr>
        <th>Source</th><th>Severity</th><th>Title</th>
        <th>Description</th><th>Date</th><th>Link</th>
    </tr></thead>
    <tbody>
    <?php foreach ($alerts as $a) { ?>
        <tr>
            <td><?php echo $a['source']; ?></td>
            <td><span class="badge <?php echo $a['severity']; ?>"><?php echo $a['severity']; ?></span></td>
            <td><?php echo htmlspecialchars(mb_substr($a['title'], 0, 120)); ?></td>
            <td><?php echo htmlspecialchars(mb_substr($a['desc'], 0, 180)); ?></td>
            <td><?php echo $a['date']; ?></td>
            <td><?php echo $a['url'] ? '<a href="' . htmlspecialchars($a['url']) . '" target="_blank">Open</a>' : ''; ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script>
 $(document).ready(function(){
    $('#t').DataTable({ pageLength: 25, order: [[4,'desc']] });
});
</script>
</body>
</html>