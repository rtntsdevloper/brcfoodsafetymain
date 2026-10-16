<?php

/**
 * alert.php
 * Cross-Device Compatible - Works on all servers, PHP 5.6+
 *
 * Sources:
 *   - FSA (UK Food Standards Agency)
 *   - openFDA Food Enforcement (US FDA)
 */

// ===== CONFIGURATION =====
$config = array(
  'timezone' => 'Europe/London',
  'memory_limit' => '512M',
  'max_execution_time' => 180,
  'socket_timeout' => 60,
  'curl_timeout' => 120,
  'curl_connect_timeout' => 20,
);

// ===== SET CONFIGURATION =====
if (function_exists('ini_set')) {
  ini_set('memory_limit', $config['memory_limit']);
  ini_set('max_execution_time', $config['max_execution_time']);
  ini_set('default_socket_timeout', $config['socket_timeout']);
  ini_set('allow_url_fopen', '1');
}

if (function_exists('set_time_limit')) {
  set_time_limit($config['max_execution_time']);
}

if (function_exists('date_default_timezone_set')) {
  date_default_timezone_set($config['timezone']);
}

// ===== POLYFILL FUNCTIONS =====
if (!function_exists('json_last_error_msg')) {
  function json_last_error_msg()
  {
    if (!function_exists('json_last_error'))
      return 'unknown error';
    switch (json_last_error()) {
      case JSON_ERROR_NONE:
        return 'No error';
      case JSON_ERROR_DEPTH:
        return 'Maximum stack depth exceeded';
      case JSON_ERROR_STATE_MISMATCH:
        return 'Underflow or modes mismatch';
      case JSON_ERROR_CTRL_CHAR:
        return 'Control character error';
      case JSON_ERROR_SYNTAX:
        return 'Syntax error';
      case JSON_ERROR_UTF8:
        return 'Malformed UTF-8 characters';
      default:
        return 'Unknown error';
    }
  }
}

if (!defined('ENT_HTML5')) {
  define('ENT_HTML5', 0);
}

if (!function_exists('mb_strlen')) {
  function mb_strlen($s, $enc = null)
  {
    return strlen($s);
  }
}
if (!function_exists('mb_substr')) {
  function mb_substr($s, $start, $len = null, $enc = null)
  {
    return ($len === null) ? substr($s, $start) : substr($s, $start, $len);
  }
}

// ===== FETCH DATA FUNCTION =====
function fetchData($url, &$error = null, $acceptOverride = null, &$httpCodeOut = null)
{
  global $config;

  $error = null;
  $httpCode = null;
  $response = false;
  $curlHttpError = false;

  if ($acceptOverride) {
    $acceptHeader = $acceptOverride;
  } else {
    $acceptHeader = "Accept: text/html,application/xhtml+xml,application/xml,application/json;q=0.9,*/*;q=0.8\r\n";
  }

  $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0 Safari/537.36';

  /* ---------- Attempt 1: cURL (primary) ---------- */
  if (function_exists('curl_init')) {
    $ch = curl_init($url);
    if ($ch !== false) {
      try {
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, $config['curl_timeout']);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $config['curl_connect_timeout']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          trim(str_replace("\r\n", '', $acceptHeader)),
          'Accept-Language: en-GB,en;q=0.9',
        ));

        if (defined('CURLOPT_ENCODING')) {
          curl_setopt($ch, CURLOPT_ENCODING, '');
        }
        if (defined('CURLOPT_IPRESOLVE') && defined('CURL_IPRESOLVE_V4')) {
          curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        }

        $curlResponse = curl_exec($ch);
        $curlErrno = curl_errno($ch);
        $curlErr = curl_error($ch);
        $curlCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($curlErrno) {
          $error = "cURL error (" . $curlErrno . "): " . $curlErr;
          $httpCode = $curlCode;
        } elseif ($curlCode >= 200 && $curlCode < 300 && $curlResponse !== false && $curlResponse !== '') {
          $response = $curlResponse;
          $httpCode = $curlCode;
          $error = null;
        } else {
          $curlHttpError = true;
          $httpCode = $curlCode;
          if ($curlCode > 0) {
            $error = "cURL got HTTP " . $curlCode;
          } else {
            $error = 'cURL returned empty body';
          }
        }
      } catch (Exception $e) {
        curl_close($ch);
        $error = "cURL exception: " . $e->getMessage();
      }
    } else {
      $error = 'curl_init failed';
    }
  }

  /* ---------- Attempt 2: file_get_contents (fallback) ---------- */
  if (($response === false || $response === '') && !$curlHttpError && ini_get('allow_url_fopen')) {
    try {
      $ctxOptions = array(
        'http' => array(
          'method' => 'GET',
          'timeout' => $config['socket_timeout'],
          'follow_location' => 1,
          'max_redirects' => 5,
          'header' => $acceptHeader . "Accept-Language: en-GB,en;q=0.9\r\n",
          'user_agent' => $userAgent,
          'ignore_errors' => true,
        ),
        'ssl' => array(
          'verify_peer' => true,
          'verify_peer_name' => true,
          'allow_self_signed' => false,
        ),
      );

      $context = stream_context_create($ctxOptions);
      $response = @file_get_contents($url, false, $context);

      $fgcCode = null;
      if (isset($http_response_header) && is_array($http_response_header)) {
        foreach ($http_response_header as $hdr) {
          if (preg_match('#^HTTP/\S+\s+(\d{3})#', $hdr, $m)) {
            $fgcCode = (int) $m[1];
            break;
          }
        }
      }

      if ($fgcCode !== null && ($fgcCode < 200 || $fgcCode >= 300)) {
        $response = false;
        if (!$error)
          $error = "file_get_contents got HTTP " . $fgcCode;
        if ($httpCode === null)
          $httpCode = $fgcCode;
      } elseif ($response === false) {
        if (!$error) {
          $error = 'file_get_contents failed';
        }
        if ($httpCode === null)
          $httpCode = $fgcCode;
      } else {
        if ($httpCode === null)
          $httpCode = $fgcCode;
        $error = null;
      }
    } catch (Exception $e) {
      $response = false;
      if (!$error)
        $error = "file_get_contents exception: " . $e->getMessage();
    }
  }

  if (($response === false || $response === null || $response === '') && !$error) {
    $error = 'Empty response';
  }

  $httpCodeOut = $httpCode;

  if ($response === false || $response === null || $response === '') {
    return false;
  }
  return $response;
}

// ===== SAFE JSON DECODE (PHP 5.6 compatible) =====
function safeJsonDecode($json, &$err = null)
{
  $err = null;
  if (!is_string($json) || $json === '') {
    $err = 'empty input';
    return null;
  }

  $data = json_decode($json, true);

  if ($data === null && function_exists('json_last_error') && json_last_error() !== JSON_ERROR_NONE) {
    $err = json_last_error_msg();
  }
  return $data;
}

// ===== DATE WINDOW (last full week: Mon–Sun, previous week) =====
$startOfWeek = date('Y-m-d', strtotime('monday this week -7 days'));
$endOfWeek = date('Y-m-d', strtotime('sunday this week -7 days'));


/* ============================================================
   FSA (UK Food Standards Agency)
   ============================================================ */
$apiUrl = "https://data.food.gov.uk/food-alerts/id.json?_limit=500&mineq-created=" . $startOfWeek . "&maxeq-created=" . $endOfWeek . "&_sort=-created";
$fsaError = null;
$fsaHttpCode = 0;
$fsaResponse = fetchData($apiUrl, $fsaError, null, $fsaHttpCode);

$fsaData = null;
if ($fsaResponse !== false) {
  $fsaData = safeJsonDecode($fsaResponse, $fsaJsonErr);
  if (!is_array($fsaData)) {
    $fsaData = array();
  }
}
$fsaItems = isset($fsaData['items']) && is_array($fsaData['items']) ? $fsaData['items'] : array();

function keepAllowedCategory($item)
{
  $cat = getAlertCategory($item);
  return ($cat === 'Allergen' || $cat === 'Recall');
}
$fsaItems = array_filter($fsaItems, 'keepAllowedCategory');
$fsaItems = array_values($fsaItems);

$fsaAllergenCount = 0;
$fsaRecallCount = 0;
foreach ($fsaItems as $item) {
  $cat = getAlertCategory($item);
  if ($cat === 'Allergen') {
    $fsaAllergenCount++;
  } elseif ($cat === 'Recall') {
    $fsaRecallCount++;
  }
}
$totalAlerts = count($fsaItems);
$classICount = $fsaRecallCount;
$actionRequired = $totalAlerts;
$nextIssue = date('M d, Y', strtotime('next monday'));


/* ============================================================
   openFDA Food Enforcement (US FDA)
   ============================================================
   Endpoint : https://api.fda.gov/food/enforcement.json
   Docs     : https://open.fda.gov/apis/food/enforcement/
   Notes    :
     - Date format in API is YYYYMMDD (no dashes).
     - Use search=report_date:[YYYYMMDD+TO+YYYYMMDD] for a date range.
     - Use limit=1000 (max allowed) to pull as many records as possible.
     - Sort by report_date:desc to get newest first.
     - No API key needed for basic use; add api_key=YOURKEY if rate-limited.
   ============================================================ */
$fdaStartCompact = str_replace('-', '', $startOfWeek); // 20250908
$fdaEndCompact = str_replace('-', '', $endOfWeek);   // 20250914

$fdaUrl = 'https://api.fda.gov/food/enforcement.json'
  . '?search=report_date:[' . $fdaStartCompact . '+TO+' . $fdaEndCompact . ']'
  . '&limit=1000'
  . '&sort=report_date:desc';

// Optional: add your API key here if you have one
// $fdaUrl .= '&api_key=YOUR_API_KEY_HERE';

$fdaError = null;
$fdaHttpCode = 0;
$fdaResponse = fetchData($fdaUrl, $fdaError, "Accept: application/json\r\n", $fdaHttpCode);

$fdaData = array();
$fdaJsonErr = null;
if ($fdaResponse !== false) {
  $fdaData = safeJsonDecode($fdaResponse, $fdaJsonErr);
  if (!is_array($fdaData)) {
    $fdaData = array();
  }
}

$fdaItems = array();
if (isset($fdaData['results']) && is_array($fdaData['results'])) {
  foreach ($fdaData['results'] as $r) {
    if (!is_array($r))
      continue;

    // Convert YYYYMMDD → YYYY-MM-DD for our internal comparison
    $rd = isset($r['report_date']) ? $r['report_date'] : '';
    $isoDate = (strlen($rd) === 8)
      ? substr($rd, 0, 4) . '-' . substr($rd, 4, 2) . '-' . substr($rd, 6, 2)
      : '';

    // Filter to our window (defensive — API already filtered, but just in case)
    if ($isoDate === '' || $isoDate < $startOfWeek || $isoDate > $endOfWeek)
      continue;

    $recallNo = isset($r['recall_number']) ? $r['recall_number'] : '';

    // Link to the FDA's main recalls page — stable, human-readable, always works.
    // The openFDA API does not expose a direct deep-link for individual food recalls.
    $deepLink = 'https://www.fda.gov/safety/recalls-market-withdrawals-safety-alerts';

    $firm = isset($r['recalling_firm']) ? $r['recalling_firm'] : '';
    $prod = isset($r['product_description']) ? $r['product_description'] : '';
    $title = trim($firm . (($firm !== '' && $prod !== '') ? ' — ' : '') . $prod);
    if ($title === '')
      $title = 'FDA Food Recall';

    $reason = isset($r['reason_for_recall']) ? $r['reason_for_recall'] : '';
    $desc = trim($reason);
    if ($desc === '')
      $desc = 'FDA food enforcement recall. Please refer to the official record.';

    $classification = isset($r['classification']) ? $r['classification'] : 'Class II';

    // Normalise into a consistent shape for the display layer
    $fdaItems[] = array(
      'field_recall_number' => $recallNo,
      'field_recall_date' => $isoDate,
      'field_recall_classification' => $classification,
      'field_title' => $title,
      'field_summary' => $desc,
      'field_recall_url' => $deepLink,
      'field_recall_reason' => array($reason),
      '_source' => 'FDA',
    );
  }
}

// Sort FDA items newest-first
if (!function_exists('fdaSortByDateDesc')) {
  function fdaSortByDateDesc($a, $b)
  {
    $da = isset($a['field_recall_date']) ? $a['field_recall_date'] : '';
    $db = isset($b['field_recall_date']) ? $b['field_recall_date'] : '';
    if ($da === $db)
      return 0;
    return ($da < $db) ? 1 : -1;
  }
}
usort($fdaItems, 'fdaSortByDateDesc');

$usTotal = count($fdaItems);
$usClassICount = 0;
$usClassIICount = 0;
$usClassIIICount = 0;
foreach ($fdaItems as $rec) {
  $cls = isset($rec['field_recall_classification']) ? trim($rec['field_recall_classification']) : '';
  if ($cls === 'Class I')
    $usClassICount++;
  elseif ($cls === 'Class II')
    $usClassIICount++;
  elseif ($cls === 'Class III')
    $usClassIIICount++;
}


/* ============================================================
   Helper functions — FSA
   ============================================================ */
function getAlertCategory($item)
{
  $typeStr = '';
  if (!empty($item['type']) && is_array($item['type'])) {
    $typeStr = strtolower(implode(' ', $item['type']));
  }
  $desc = '';
  if (!empty($item['problem']) && is_array($item['problem']) && !empty($item['problem'][0]['riskStatement'])) {
    $desc = strtolower($item['problem'][0]['riskStatement']);
  }
  $combined = $typeStr . ' ' . $desc;
  if (preg_match('/allergen|undeclared.*allergen|peanut|nut|milk|egg|soya|soy|wheat|gluten|shellfish|sesame|mustard|lupin|cereal.*gluten|tree nut/i', $combined))
    return 'Allergen';
  if (preg_match('/fraud|counterfeit|mislabel|adulterat|fake|substitute|unauthorised|illegal|false.*description|unapproved/i', $combined))
    return 'Food Fraud';
  if (preg_match('/recall|withdraw|prin|remov|return|contamination|salmonella|listeria|e\\. coli|glass|metal|plastic|chemical|pesticide|mycotoxin|mould|foreign.*body|pathogen|bacteria|virus|undeclared|misbranding/i', $combined))
    return 'Recall';
  return 'Other';
}

function getCountry($item)
{
  if (!empty($item['country'][0]['label'])) {
    return is_array($item['country'][0]['label']) ? $item['country'][0]['label'][0] : $item['country'][0]['label'];
  }
  return 'United Kingdom';
}

function getDescription($item)
{
  if (!empty($item['problem']) && is_array($item['problem']) && !empty($item['problem'][0]['description']))
    return $item['problem'][0]['description'];
  if (!empty($item['problem']) && is_array($item['problem']) && !empty($item['problem'][0]['riskStatement']))
    return $item['problem'][0]['riskStatement'];
  return 'Food safety alert issued. Please refer to official source.';
}

function getAlertDate($item)
{
  return !empty($item['created']) ? date('d M Y', strtotime($item['created'])) : date('d M Y');
}

function getAlertTitle($item)
{
  if (!empty($item['shortTitle']))
    return substr($item['shortTitle'], 0, 100);
  if (!empty($item['title']))
    return substr($item['title'], 0, 100);
  return 'Food Safety Alert';
}

function getAlertUrl($item)
{
  return isset($item['alertURL']) ? $item['alertURL'] : '#';
}


/* ============================================================
   Helper functions — FDA / US recalls
   ============================================================ */
function getUsSeverityKey($item)
{
  $cls = isset($item['field_recall_classification']) ? trim($item['field_recall_classification']) : '';
  if ($cls === 'Class I')
    return 'high';
  if ($cls === 'Class II')
    return 'med';
  return 'low';
}

function getUsClassLabel($item)
{
  $cls = isset($item['field_recall_classification']) ? trim($item['field_recall_classification']) : '';
  return $cls !== '' ? $cls : 'Recall';
}

function getUsTitle($item)
{
  $t = isset($item['field_title']) ? $item['field_title'] : 'Recall';
  $t = html_entity_decode($t, ENT_QUOTES, 'UTF-8');
  if (mb_strlen($t) > 120)
    return mb_substr($t, 0, 120) . '...';
  return $t;
}

function getUsDate($item)
{
  $d = isset($item['field_recall_date']) ? $item['field_recall_date'] : '';
  return $d !== '' ? date('d M Y', strtotime($d)) : date('d M Y');
}

function getUsDesc($item)
{
  $summary = isset($item['field_summary']) ? $item['field_summary'] : '';
  $text = strip_tags($summary);
  $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
  $text = preg_replace('/\s+/', ' ', $text);
  $text = trim($text);
  $text = preg_replace('/^WASHINGTON,?\s+[A-Z][a-z]+\.?\s+\d{1,2},?\s+\d{4}\s*,?\s*/i', '', $text);
  if (mb_strlen($text) > 150)
    $text = mb_substr($text, 0, 150) . '...';
  if ($text === '')
    $text = 'Recall issued. Please refer to the official notice.';
  return $text;
}

function getUsUrl($item)
{
  $u = isset($item['field_recall_url']) ? $item['field_recall_url'] : '#';
  if (strpos($u, 'http://') === 0)
    $u = 'https://' . substr($u, 7);
  return $u;
}


/* ============================================================
   Severity colour palette
   ============================================================ */
$sevColors = array(
  'high' => array('bg' => '#fef2f2', 'text' => '#dc2626', 'border' => '#fecaca', 'btn' => '#dc2626', 'btnHover' => '#b91c1c', 'label' => 'High'),
  'med' => array('bg' => '#fffbeb', 'text' => '#d97706', 'border' => '#fde68a', 'btn' => '#d97706', 'btnHover' => '#b45309', 'label' => 'Medium'),
  'low' => array('bg' => '#f7fee7', 'text' => '#65a30d', 'border' => '#d9f99d', 'btn' => '#65a30d', 'btnHover' => '#4d7c0f', 'label' => 'Low'),
);

function getSeverityKey($category)
{
  $map = array('Recall' => 'high', 'Allergen' => 'med', 'Food Fraud' => 'low', 'Other' => 'low');
  return isset($map[$category]) ? $map[$category] : 'low';
}


$startDisplay = date('F d, Y', strtotime($startOfWeek));
$endDisplay = date('F d, Y', strtotime($endOfWeek));
$companyName = "RTNTS";


/* ============================================================
   EMAIL BODY
   ============================================================ */
$body = '<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>FSA &amp; FDA Recalls Weekly Digest</title>
<!--[if mso]>
<style>
table {border-collapse:collapse;}
td,div,p,a,h1,h2,h3 {font-family:Arial,Helvetica,sans-serif !important;}
</style>
<![endif]-->
<style>
.btn-high:hover { background-color:#b91c1c !important; }
.btn-med:hover  { background-color:#b45309 !important; }
.btn-low:hover  { background-color:#4d7c0f !important; }
</style>
</head>
<body style="margin:0;padding:0;background-color:#eef1f5;font-family:Arial,Helvetica,sans-serif;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#eef1f5;border-collapse:collapse;">
<tr>
<td align="center" style="padding:24px 12px;">

<table role="presentation" width="700" cellpadding="0" cellspacing="0" border="0" style="width:900px;max-width:900px;background-color:#ffffff;font-family:Arial,Helvetica,sans-serif;border-collapse:collapse;">

  <tr>
    <td style="background-color:#0a1628;color:#ffffff;padding:14px 28px;font-size:12px;letter-spacing:.5px;">
      Food Safety Alerts &nbsp;&bull;&nbsp; Weekly Digest
    </td>
  </tr>

  <tr>
    <td style="background-color:#0a1628;color:#ffffff;padding:32px 28px 28px;">
      <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse;">
        <tr>
          <td style="font-size:16px;font-weight:bold;color:#ffffff;">' . htmlspecialchars($companyName) . ' <span style="color:#f97316;">WEEKLY</span></td>
        </tr>
      </table>
      <div style="font-size:28px;font-weight:bold;color:#ffffff;margin:18px 0 8px;line-height:1.2;">Food Safety Alerts <span style="color:#f97316;">you can\'t afford to miss.</span></div>
      <div style="font-size:14px;color:#cbd5e1;line-height:1.5;">Your curated weekly summary of food safety alerts from the UK Food Standards Agency and US Food &amp; Drug Administration — distilled, categorised, and ready to action.</div>
      <br>
      <table role="presentation" cellpadding="0" cellspacing="0" border="0" style="margin-top:24px;width:100%;border-collapse:collapse;">
        <tr>
          <td style="padding-right:20px;font-size:12px;color:#94a3b8;">Reporting period<br>
            <span style="display:inline-block;margin-top:4px;font-size:18px;font-weight:bold;color:#ffffff;">' . htmlspecialchars($startDisplay) . ' – ' . htmlspecialchars($endDisplay) . '</span>
          </td>
          <td style="padding-right:20px;font-size:12px;color:#94a3b8;">Total alerts<br>
            <span style="display:inline-block;margin-top:4px;font-size:18px;font-weight:bold;color:#ffffff;">' . htmlspecialchars($totalAlerts) . '</span>
          </td>
          <td style="padding-right:20px;font-size:12px;color:#94a3b8;">Action required<br>
            <span style="display:inline-block;margin-top:4px;font-size:18px;font-weight:bold;color:#f97316;">' . htmlspecialchars($actionRequired) . '</span>
          </td>
          <td style="font-size:12px;color:#94a3b8;">Next issue<br>
            <span style="display:inline-block;margin-top:4px;font-size:18px;font-weight:bold;color:#ffffff;">' . htmlspecialchars($nextIssue) . '</span>
          </td>
        </tr>
      </table>
    </td>
  </tr>

  <tr>
    <td style="padding:0;">
      <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse;">
        <tr>
          <td width="25%" align="center" style="padding:22px 6px;background-color:#ffffff;border-right:1px solid #e2e8f0;border-bottom:1px solid #e2e8f0;">
            <div style="font-size:30px;font-weight:bold;color:#0a1628;">' . htmlspecialchars($totalAlerts) . '</div>
            <div style="font-size:11px;color:#475569;text-transform:uppercase;letter-spacing:.5px;margin-top:4px;">FSA Alerts</div>
          </td>
          <td width="25%" align="center" style="padding:22px 6px;background-color:#ffffff;border-right:1px solid #e2e8f0;border-bottom:1px solid #e2e8f0;">
            <div style="font-size:30px;font-weight:bold;color:#d97706;">' . htmlspecialchars($fsaAllergenCount) . '</div>
            <div style="font-size:11px;color:#475569;text-transform:uppercase;letter-spacing:.5px;margin-top:4px;">Allergens</div>
          </td>
          <td width="25%" align="center" style="padding:22px 6px;background-color:#ffffff;border-right:1px solid #e2e8f0;border-bottom:1px solid #e2e8f0;">
            <div style="font-size:30px;font-weight:bold;color:#dc2626;">' . htmlspecialchars($classICount) . '</div>
            <div style="font-size:11px;color:#475569;text-transform:uppercase;letter-spacing:.5px;margin-top:4px;">Class I</div>
          </td>
          <td width="25%" align="center" style="padding:22px 6px;background-color:#ffffff;border-bottom:1px solid #e2e8f0;">
            <div style="font-size:30px;font-weight:bold;color:#dc2626;">' . htmlspecialchars($fsaRecallCount) . '</div>
            <div style="font-size:11px;color:#475569;text-transform:uppercase;letter-spacing:.5px;margin-top:4px;">Recalls</div>
          </td>
        </tr>
      </table>
    </td>
  </tr>

  <tr>
    <td style="padding:0;">
      <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse;">
        <tr>
          <td width="25%" align="center" style="padding:22px 6px;background-color:#f8fafc;border-right:1px solid #e2e8f0;border-bottom:1px solid #e2e8f0;">
            <div style="font-size:30px;font-weight:bold;color:#0a1628;">' . htmlspecialchars($usTotal) . '</div>
            <div style="font-size:11px;color:#475569;text-transform:uppercase;letter-spacing:.5px;margin-top:4px;">FDA Recalls</div>
          </td>
          <td width="25%" align="center" style="padding:22px 6px;background-color:#f8fafc;border-right:1px solid #e2e8f0;border-bottom:1px solid #e2e8f0;">
            <div style="font-size:30px;font-weight:bold;color:#dc2626;">' . htmlspecialchars($usClassICount) . '</div>
            <div style="font-size:11px;color:#475569;text-transform:uppercase;letter-spacing:.5px;margin-top:4px;">FDA Class I</div>
          </td>
          <td width="25%" align="center" style="padding:22px 6px;background-color:#f8fafc;border-right:1px solid #e2e8f0;border-bottom:1px solid #e2e8f0;">
            <div style="font-size:30px;font-weight:bold;color:#d97706;">' . htmlspecialchars($usClassIICount) . '</div>
            <div style="font-size:11px;color:#475569;text-transform:uppercase;letter-spacing:.5px;margin-top:4px;">FDA Class II</div>
          </td>
          <td width="25%" align="center" style="padding:22px 6px;background-color:#f8fafc;border-bottom:1px solid #e2e8f0;">
            <div style="font-size:30px;font-weight:bold;color:#65a30d;">' . htmlspecialchars($usClassIIICount) . '</div>
            <div style="font-size:11px;color:#475569;text-transform:uppercase;letter-spacing:.5px;margin-top:4px;">FDA Class III</div>
          </td>
        </tr>
      </table>
    </td>
  </tr>

  <tr>
    <td style="padding:26px 28px 6px;">
      <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse;">
        <tr>
          <td>
            <span style="background-color:#ecfdf5;color:#064e3b;font-size:11px;font-weight:bold;letter-spacing:.5px;padding:5px 10px;">FSA</span>
            <span style="font-size:18px;font-weight:bold;color:#0a1628;margin-left:8px;">Food Standards Agency &middot; United Kingdom</span>
          </td>
          <td align="right" style="font-size:13px;color:#475569;">' . htmlspecialchars(count($fsaItems)) . ' alerts</td>
        </tr>
      </table>
    </td>
  </tr>';

$fsaDisplay = array_slice($fsaItems, 0, 4);
if (empty($fsaDisplay)) {
  $body .= '
  <tr>
    <td style="padding:10px 28px 20px;">
      <p style="text-align:center;color:#475569;font-size:14px;padding:20px 0;margin:0;">No Allergen or Recall alerts in this period.</p>
    </td>
  </tr>';
} else {
  foreach ($fsaDisplay as $item) {
    $cat = getAlertCategory($item);
    $sevKey = getSeverityKey($cat);
    $sc = $sevColors[$sevKey];
    $desc = getDescription($item);
    if (strlen($desc) > 150)
      $desc = substr($desc, 0, 150) . '...';
    $btnClass = 'btn-' . $sevKey;
    $body .= '
  <tr>
    <td style="padding:0 28px 16px;">
      <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border:1px solid #e2e8f0;border-collapse:collapse;">
        <tr>
          <td width="4" style="background-color:' . $sc['text'] . ';font-size:1px;line-height:1px;">&nbsp;</td>
          <td style="padding:18px 20px;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse;">
              <tr>
                <td style="font-size:10px;font-weight:bold;color:#475569;text-transform:uppercase;letter-spacing:.5px;">' . htmlspecialchars($cat) . ' Alert</td>
                <td align="right">
                  <span style="background-color:' . $sc['bg'] . ';color:' . $sc['text'] . ';font-size:10px;font-weight:bold;letter-spacing:.5px;padding:4px 8px;border:1px solid ' . $sc['border'] . ';text-transform:uppercase;">' . $sc['label'] . '</span>
                </td>
              </tr>
            </table>
            <div style="font-size:16px;font-weight:bold;color:#0a1628;margin:8px 0 8px;line-height:1.35;">' . htmlspecialchars(getAlertTitle($item)) . '</div>
            <div style="font-size:12px;color:#475569;margin-bottom:10px;font-family:\'Courier New\',monospace;">' . htmlspecialchars(getAlertDate($item)) . ' &nbsp;&nbsp; ' . htmlspecialchars(getCountry($item)) . '</div>
            <div style="font-size:14px;color:#334155;line-height:1.55;margin-bottom:14px;">' . htmlspecialchars($desc) . '</div>
            <a href="' . htmlspecialchars(getAlertUrl($item)) . '" class="' . $btnClass . '" style="display:inline-block;background-color:' . $sc['btn'] . ';color:#ffffff;text-decoration:none;font-size:12px;font-weight:bold;padding:9px 16px;">View Notice &rarr;</a>
          </td>
        </tr>
      </table>
    </td>
  </tr>';
  }
}

$body .= '
  <tr>
    <td style="padding:26px 28px 6px;">
      <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse;">
        <tr>
          <td>
            <span style="background-color:#dbeafe;color:#1e3a8a;font-size:11px;font-weight:bold;letter-spacing:.5px;padding:5px 10px;">FDA</span>
            <span style="font-size:18px;font-weight:bold;color:#0a1628;margin-left:8px;">US Food &amp; Drug Administration &middot; United States</span>
          </td>
          <td align="right" style="font-size:13px;color:#475569;">' . htmlspecialchars($usTotal) . ' recalls</td>
        </tr>
      </table>
    </td>
  </tr>';

$usDisplay = array_slice($fdaItems, 0, 4);
if (empty($usDisplay)) {
  $body .= '
  <tr>
    <td style="padding:10px 28px 20px;">
      <p style="text-align:center;color:#475569;font-size:14px;padding:20px 0;margin:0;">No US recalls in this period.</p>
    </td>
  </tr>';
} else {
  foreach ($usDisplay as $item) {
    $sevKey = getUsSeverityKey($item);
    $sc = $sevColors[$sevKey];
    $desc = getUsDesc($item);
    $clsLabel = getUsClassLabel($item);
    $btnClass = 'btn-' . $sevKey;
    $body .= '
  <tr>
    <td style="padding:0 28px 16px;">
      <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border:1px solid #e2e8f0;border-collapse:collapse;">
        <tr>
          <td width="4" style="background-color:' . $sc['text'] . ';font-size:1px;line-height:1px;">&nbsp;</td>
          <td style="padding:18px 20px;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse;">
              <tr>
                <td style="font-size:10px;font-weight:bold;color:#475569;text-transform:uppercase;letter-spacing:.5px;">' . htmlspecialchars($clsLabel) . ' Recall</td>
                <td align="right">
                  <span style="background-color:' . $sc['bg'] . ';color:' . $sc['text'] . ';font-size:10px;font-weight:bold;letter-spacing:.5px;padding:4px 8px;border:1px solid ' . $sc['border'] . ';text-transform:uppercase;">' . $sc['label'] . '</span>
                </td>
              </tr>
            </table>
            <div style="font-size:16px;font-weight:bold;color:#0a1628;margin:8px 0 8px;line-height:1.35;">' . htmlspecialchars(getUsTitle($item)) . '</div>
            <div style="font-size:12px;color:#475569;margin-bottom:10px;font-family:\'Courier New\',monospace;">' . htmlspecialchars(getUsDate($item)) . ' &nbsp;&nbsp; United States</div>
            <div style="font-size:14px;color:#334155;line-height:1.55;margin-bottom:14px;">' . htmlspecialchars($desc) . '</div>
            <a href="' . htmlspecialchars(getUsUrl($item)) . '" class="' . $btnClass . '" style="display:inline-block;background-color:' . $sc['btn'] . ';color:#ffffff;text-decoration:none;font-size:12px;font-weight:bold;padding:9px 16px;">View Recall &rarr;</a>
          </td>
        </tr>
      </table>
    </td>
  </tr>';
  }
}

$body .= '
  <tr>
    <td style="padding:26px 28px 20px;background-color:#0a1628;">
      <div style="font-size:18px;font-weight:bold;color:#ffffff;margin-bottom:8px;">Weekly Recap — what to action now</div>
      <div style="border-bottom:2px solid #334155;margin-bottom:12px;"></div>
      <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse;">
        <tr>
          <td style="padding:4px 0;font-size:14px;color:#cbd5e1;line-height:1.6;">';

$bullets = array();

if ($fsaRecallCount > 0) {
  $bullets[] = '<strong style="color:#ffffff;">' . $fsaRecallCount . ' Class I recalls</strong> (FSA) require immediate consumer/patient notification — prioritise the affected products.';
}
if ($fsaAllergenCount > 0) {
  $bullets[] = '<strong style="color:#ffffff;">' . $fsaAllergenCount . ' undeclared allergen alerts</strong> (FSA) affect UK retail shelf stock — remove listed batches and update POS signage.';
}
$otherCount = $totalAlerts - $fsaAllergenCount - $fsaRecallCount;
if ($otherCount > 0) {
  $bullets[] = '<strong style="color:#ffffff;">' . $otherCount . ' other FSA alerts</strong> — review details and take appropriate action.';
}
if ($usClassICount > 0) {
  $bullets[] = '<strong style="color:#ffffff;">' . $usClassICount . ' FDA Class I recall' . ($usClassICount > 1 ? 's' : '') . '</strong> (FDA) — highest health risk; immediate review of affected product lines and distribution is recommended.';
}
if ($usTotal > 0) {
  $bulletText = '<strong style="color:#ffffff;">' . $usTotal . ' FDA recall' . ($usTotal > 1 ? 's' : '') . '</strong> issued this period (FDA)';
  if ($usClassIICount > 0 || $usClassIIICount > 0) {
    $bulletText .= ' (Class II: ' . $usClassIICount . ', Class III: ' . $usClassIIICount . ')';
  }
  $bulletText .= ' — confirm no affected stock is in your supply chain.';
  $bullets[] = $bulletText;
}
if ($totalAlerts == 0 && $usTotal == 0) {
  $bullets[] = 'No new alerts this week — continue with routine monitoring.';
}
foreach ($bullets as $bullet) {
  $body .= '<div style="padding:4px 0 4px 20px;text-indent:-14px;color:#cbd5e1;">&bull; ' . $bullet . '</div>';
}

$body .= '          </td>
        </tr>
      </table>
    </td>
  </tr>

  <tr>
    <td align="center" style="padding:26px 20px;font-size:12px;color:#94a3b8;line-height:1.6;">
      This digest is compiled from public FSA (UK) and openFDA (US) data for informational purposes only.<br>
      &copy; ' . date('Y') . ' ' . htmlspecialchars($companyName) . ' &middot; Food Safety Alerts
    </td>
  </tr>

</table>

</td>
</tr>
</table>
</body>
</html>';

echo $body;

require_once('PHPMailer/class.phpmailer.php');
$mail = new PHPMailer();
$mail->SetFrom("techsupport@rtnts.co.uk", "RTNTS");
$mail->AddReplyTo("techsupport@rtnts.co.uk", "RTNTS");
$mail->CharSet = 'UTF-8';
$mail->Encoding = 'base64';
$mail->isHTML(true);
$email = "RITZ2@rtnts.co.uk";
$nme = "IT Team";
$mail->AddAddress($email, $nme);
$mail->Subject = 'Weekly Food Safety Alerts - ' . $startDisplay . ' to ' . $endDisplay;
$mail->MsgHTML($body);
if (!$mail->Send()) { echo "Mailer Error: " . $mail->ErrorInfo; }
else { echo "Mail sent successfully!"; }

?>