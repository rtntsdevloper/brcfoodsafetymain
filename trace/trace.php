<?php
if (isset($_GET['create'])) {
  $create = $_GET['create'];
  $creation = "&create=" . $create;
} else {
  $create = "";
  $creation = "";
}

if ($create == '1') {
  $sql = "SELECT * FROM `tblmarination` WHERE confirm !='Waiting' ORDER BY date DESC";
} else {
  $sql = "SELECT * FROM `tblmarination` WHERE status ='Done' ORDER BY date DESC";
}
$tbdata = mysqli_query($con, $sql);
$rbdta = mysqli_num_rows($tbdata);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ProdTrack — Batch Production Record System</title>

  <!-- Bootstrap 4 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

  <style>
    :root {
      --bg: #f1f5f9;
      --panel: #ffffff;
      --panel-2: #f8fafc;
      --border: #e2e8f0;
      --border-dark: #cbd5e1;
      --fg: #0f172a;
      --muted: #64748b;
      --accent: #ea580c;
      --accent-2: #d97706;
      --accent-light: #fff7ed;
      --ok: #16a34a;
      --warn: #ca8a04;
      --bad: #dc2626;
      --info: #0284c7;
    }

    * {
      box-sizing: border-box;
    }

    /* Century Gothic as default font globally */
    html,
    body {
      background: var(--bg);
      color: var(--fg);
      font-family: "Century Gothic", "CenturyGothic", "AppleGothic", "Avant Garde", "Futura", sans-serif;
      margin: 0;
      padding: 0;
    }

    body {
      background: radial-gradient(1200px 600px at 80% -10%, rgba(234, 88, 12, .06), transparent 60%), var(--bg);
      min-height: 100vh;
    }

    body::before {
      content: "";
      position: fixed;
      inset: 0;
      pointer-events: none;
      z-index: 0;
      background-image: linear-gradient(rgba(15, 23, 42, .025) 1px, transparent 1px), linear-gradient(90deg, rgba(15, 23, 42, .025) 1px, transparent 1px);
      background-size: 48px 48px;
    }

    button,
    input,
    select,
    textarea,
    table,
    th,
    td,
    span,
    div,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
      font-family: inherit !important;
    }

    /* Header */
    .topbar {
      background: rgba(255, 255, 255, .95);
      border-bottom: 1px solid var(--border);
      backdrop-filter: blur(10px);
      box-shadow: 0 4px 20px -12px rgba(15, 23, 42, .1);
      position: sticky;
      top: 0;
      z-index: 1020;
      padding: 18px 32px;
    }

    .topbar h5 {
      margin: 0;
      font-weight: 700;
      color: var(--fg);
      font-size: 1.25rem;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    /* Full Width Layout */
    .main-container {
      position: relative;
      z-index: 1;
      padding: 32px;
      width: 100%;
      max-width: 100%;
    }

    /* Search Forms Panel */
    .search-panel {
      background: var(--panel);
      border: 1px solid var(--border);
      border-radius: 16px;
      box-shadow: 0 10px 40px -20px rgba(15, 23, 42, .15);
      padding: 24px;
      margin-bottom: 24px;
    }

    .form-controls-row {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      align-items: flex-end;
    }

    .form-group-custom {
      flex: 1;
      min-width: 250px;
    }

    .form-label-custom {
      display: block;
      color: var(--muted);
      font-size: 11px;
      letter-spacing: 1px;
      text-transform: uppercase;
      font-weight: 700;
      margin-bottom: 8px;
    }

    .form-input-custom {
      width: 100%;
      background: var(--panel-2);
      border: 1px solid var(--border-dark);
      color: var(--fg);
      font-size: 14px;
      padding: 12px 16px;
      border-radius: 8px;
      transition: all 0.2s ease;
    }

    .form-input-custom:focus {
      outline: none;
      border-color: var(--accent);
      box-shadow: 0 0 0 3px rgba(234, 88, 12, .15);
      background: #fff;
    }

    .btn-search-custom {
      background: linear-gradient(135deg, var(--accent), var(--accent-2));
      color: #fff;
      font-weight: 700;
      border: none;
      padding: 12px 28px;
      border-radius: 8px;
      box-shadow: 0 8px 24px -8px rgba(234, 88, 12, .5);
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      height: 44px;
      transition: all 0.2s ease;
    }

    .btn-search-custom:hover {
      transform: translateY(-1px);
      box-shadow: 0 12px 28px -8px rgba(234, 88, 12, .6);
      color: #fff;
      text-decoration: none;
    }

    .btn-clear-custom {
      background: transparent;
      color: var(--muted);
      font-weight: 600;
      border: 1px solid var(--border-dark);
      padding: 12px 20px;
      border-radius: 8px;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      height: 44px;
      transition: all 0.2s ease;
      text-decoration: none;
    }

    .btn-clear-custom:hover {
      border-color: var(--bad);
      color: var(--bad);
      text-decoration: none;
    }

    /* Table Styling */
    .table-list-wrap {
      background: var(--panel);
      border: 1px solid var(--border);
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 10px 40px -20px rgba(15, 23, 42, .15);
    }

    .table {
      margin-bottom: 0;
      width: 100%;
      border-collapse: collapse;
    }

    .table thead th {
      background: var(--panel-2);
      color: var(--muted);
      text-transform: uppercase;
      font-size: 12px;
      letter-spacing: 1px;
      font-weight: 700;
      border-bottom: 2px solid var(--border-dark);
      padding: 18px 24px;
      text-align: left;
      white-space: nowrap;
    }

    .table tbody td {
      padding: 18px 24px;
      vertical-align: middle;
      border-bottom: 1px solid var(--border);
      font-size: 15px;
      color: var(--fg);
      transition: all 0.2s ease;
    }

    .table tbody tr {
      cursor: pointer;
      transition: all 0.2s ease;
    }

    .table tbody tr:hover {
      background: var(--accent-light);
    }

    .table tbody tr:hover td:first-child {
      box-shadow: inset 4px 0 0 var(--accent);
    }

    .table tbody tr:last-child td {
      border-bottom: none;
    }

    /* Badges */
    .badge-status {
      font-size: 11px;
      font-weight: 700;
      padding: 6px 14px;
      border-radius: 20px;
      letter-spacing: .5px;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      text-transform: uppercase;
    }

    .badge-status::before {
      content: "";
      width: 6px;
      height: 6px;
      border-radius: 50%;
      display: inline-block;
    }

    .badge-completed {
      background: #dcfce7;
      color: #16a34a;
      border: 1px solid #86efac;
    }

    .badge-completed::before {
      background: #16a34a;
    }

    .badge-waiting {
      background: #fef9c3;
      color: #ca8a04;
      border: 1px solid #fde047;
    }

    .badge-waiting::before {
      background: #ca8a04;
    }

    .badge-in-progress {
      background: #e0f2fe;
      color: #0284c7;
      border: 1px solid #7dd3fc;
    }

    .badge-in-progress::before {
      background: #0284c7;
    }

    .empty-state {
      text-align: center;
      padding: 80px 20px;
      color: var(--muted);
    }

    .empty-state i {
      font-size: 56px;
      color: var(--border-dark);
      margin-bottom: 16px;
      display: block;
    }

    .empty-state h6 {
      color: var(--muted);
      font-weight: 600;
      font-size: 18px;
    }
  </style>
</head>

<body>

  <!-- Top bar -->
  <header class="topbar">
    <h5><i class="bi bi-clipboard2-pulse" style="color: var(--accent);"></i> Batch Production Record System</h5>
  </header>

  <div class="main-container">

    <!-- Two Form Direct Search Panel -->


    <!-- Full Width Attractive Table -->
    <section id="listView">
      <div class="table-list-wrap py-4">
        <div style="overflow-x: auto;">
          <table class="table table-hover mb-0" id="zero_configuration_table">
            <thead>
              <tr>
                <th width="80">S No.</th>
                <th>Batch ID</th>
                <th>Product</th>
                <th>Date</th>
                <?php
                if ($create != '1') {
                  ?>
                  <th>Status</th>
                  <?php
                }
                ?>
              </tr>
            </thead>
            <tbody>
              <?php
              $ix = 0;

              if ($rbdta == 0) {
                ?>
                <tr>
                  <td colspan="5" class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <h6>No batches found</h6>
                    <div>Try adjusting your search filters.</div>
                  </td>
                </tr>
                <?php
              } else {
                while ($rw = mysqli_fetch_array($tbdata)) {
                  $ix++;

                  if ($rw['confirm'] == 'Waiting') {
                    $cls = "waiting";
                  } elseif ($rw['confirm'] == 'Completed') {
                    $cls = "completed";
                  } else {
                    $cls = "in-progress";
                  }

                  $pname = $rw['name'];
                  $prodname = '-';



                  // Fetch Product Name safely
                  $prod = mysqli_query($con, "SELECT * FROM `tblrecipe` WHERE id = '$pname'");
                  if ($prod1 = mysqli_fetch_assoc($prod)) {
                    $prodname = $prod1['name'];
                  }
                  ?>
                  <tr onclick="window.location.href='admin.php?id=trace1&batch=<?= $rw['id'] . $creation; ?>'">
                    <td style="font-weight:700; color:var(--accent); font-size:14px;"><?= $ix ?></td>
                    <td style="font-weight:700; font-size:15px; color: var(--fg);"><?= htmlspecialchars($rw['batchcode']) ?>
                    </td>
                    <td style="font-size:15px; color: var(--muted);"><?= htmlspecialchars($prodname) ?></td>
                    <td style="font-size:14px; color: var(--muted); white-space: nowrap;">
                      <?= date('d F Y', strtotime($rw['date'])); ?>
                    </td>
                    <?php
                    if ($create != '1') {
                      ?>
                      <td>
                        <span class="badge-status badge-<?= $cls ?>">
                          <?= htmlspecialchars($rw['confirm']) ?>
                        </span>
                      </td>
                      <?php
                    }
                    ?>
                  </tr>
                  <?php
                }
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </section>

  </div>