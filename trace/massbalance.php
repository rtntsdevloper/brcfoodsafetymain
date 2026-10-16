<?php
$mid = $_GET['mid'];
$quert = mysqli_query($con, "SELECT r.pname,g.grncode as grncode, g.qty as rqty ,g.leftqty, s.supname, g.date as gooddate, g.useby as guseby, g.batchcode as gcode FROM `tblrawsupplier` as s JOIN `tblrawmaterial` as r JOIN `tblgrn1` as g ON g.product = r.id AND g.supplier = s.supid WHERE g.id='$mid'");
$quert1 = mysqli_fetch_assoc($quert);



?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
<style>
  :root {
    --bg: #f4f6fb;
    --bg-2: #eef1f8;
    --bg-3: #e8ecf4;
    --panel: #ffffff;
    --panel-hover: #fafbfe;
    --panel-2: #f7f8fc;
    --border: #e5e8f0;
    --border-light: #dce0ea;
    --border-glow: rgba(234, 88, 12, .35);
    --fg: #1a1d2e;
    --fg-dim: #4a5068;
    --muted: #8891a8;
    --accent: #ea580c;
    --accent-2: #f97316;
    --accent-deep: #c2410c;
    --accent-glow: rgba(234, 88, 12, .08);
    --accent-glow-strong: rgba(234, 88, 12, .18);
    --ok: #16a34a;
    --ok-bg: #f0fdf4;
    --ok-border: #bbf7d0;
    --warn: #ca8a04;
    --warn-bg: #fefce8;
    --warn-border: #fde68a;
    --bad: #dc2626;
    --bad-bg: #fef2f2;
    --bad-border: #fecaca;
    --info: #2563eb;
    --info-bg: #eff6ff;
    --info-border: #bfdbfe;
  }

  body {
    background: var(--bg);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  .topbar {
    background: var(--panel);
    padding: 14px 30px;
    border-bottom: 1px solid var(--border);
    box-shadow: 0 4px 20px -10px rgba(26, 29, 46, 0.08);
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: sticky;
    top: 0;
    z-index: 1020;
  }

  .topbar-left {
    display: flex;
    align-items: center;
    gap: 14px;
  }

  .topbar-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: linear-gradient(135deg, var(--accent), var(--accent-deep));
    display: grid;
    place-items: center;
    color: #fff;
    font-size: 22px;
    box-shadow: 0 6px 16px -4px rgba(234, 88, 12, 0.4);
    flex-shrink: 0;
  }

  .topbar h5 {
    margin: 0;
    font-weight: 700;
    color: var(--fg);
    font-size: 1.15rem;
    letter-spacing: -0.2px;
    display: flex;
    flex-direction: column;
  }

  .topbar h5 small {
    font-size: 12px;
    font-weight: 500;
    color: var(--muted);
    margin-top: 2px;
  }

  .btn-back-custom {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 9px 20px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 13.5px;
    color: var(--fg-dim);
    background: var(--panel);
    border: 1.5px solid var(--border);
    text-decoration: none !important;
    transition: all 0.2s ease;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
  }

  .btn-back-custom:hover {
    background: var(--accent-glow);
    border-color: var(--accent);
    color: var(--accent);
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(234, 88, 12, 0.15);
  }

  .main-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 20px;
  }

  /* ===== SUMMARY CARDS (with new color scheme) ===== */
  .summary-section {
    margin: 24px 0 30px 0;
  }

  .summary-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
  }

  .summary-card {
    background: var(--panel);
    border-radius: 14px;
    padding: 20px 22px 18px 22px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
    transition: all 0.25s ease;
    border-left: 4px solid var(--accent);
    display: flex;
    flex-direction: column;
  }

  .summary-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 28px var(--accent-glow-strong);
    background: var(--panel-hover);
    border-left-color: var(--accent-deep);
  }

  /* Individual card accents using your palette */
  .summary-card.card-date {
    border-left-color: var(--info);
  }

  .summary-card.card-date:hover {
    border-left-color: #1d4ed8;
  }

  .summary-card.card-batch {
    border-left-color: var(--accent);
  }

  .summary-card.card-batch:hover {
    border-left-color: var(--accent-deep);
  }

  .summary-card.card-qty {
    border-left-color: var(--ok);
  }

  .summary-card.card-qty:hover {
    border-left-color: #15803d;
  }

  .summary-card.card-delivery {
    border-left-color: var(--warn);
  }

  .summary-card.card-delivery:hover {
    border-left-color: #a16207;
  }

  .summary-card .card-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 6px;
  }

  .summary-card .label {
    font-size: 13px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    color: var(--muted);
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .summary-card .icon-circle {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    color: white;
    flex-shrink: 0;
  }

  /* Icon backgrounds using your color scheme */
  .card-date .icon-circle {
    background: var(--info);
  }

  .card-batch .icon-circle {
    background: var(--accent);
  }

  .card-qty .icon-circle {
    background: var(--ok);
  }

  .card-delivery .icon-circle {
    background: var(--warn);
  }

  .summary-card .value {
    font-size: 22px;
    font-weight: 700;
    color: var(--fg);
    margin: 4px 0 2px 0;
    line-height: 1.3;
    word-break: break-word;
  }

  .summary-card .value .batch-highlight {
    color: var(--accent);
    font-weight: 800;
  }

  .summary-card .sub-text {
    font-size: 13px;
    color: var(--muted);
    margin-top: 2px;
  }

  /* Responsive */
  @media (max-width: 992px) {
    .summary-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  @media (max-width: 576px) {
    .summary-grid {
      grid-template-columns: 1fr;
    }
  }

  /* ===== ORIGINAL TABLE (unchanged) ===== */
  .table-list-wrap {
    background: var(--panel);
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    padding: 0 20px 20px 20px;
    border: 1px solid var(--border-light);
  }

  #zero_configuration_table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 8px;
  }

  #zero_configuration_table thead th {
    background: var(--bg-2);
    color: var(--fg-dim);
    font-weight: 600;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 14px 16px;
    border: none;
    white-space: nowrap;
  }

  #zero_configuration_table tbody tr {
    background: var(--panel);
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
  }

  #zero_configuration_table tbody tr:hover {
    background: var(--panel-hover);
    transform: scale(1.003);
    box-shadow: 0 4px 14px var(--accent-glow);
  }

  #zero_configuration_table tbody td {
    padding: 14px 16px;
    border: none;
    vertical-align: middle;
    font-size: 14px;
    color: var(--fg);
  }

  #zero_configuration_table tbody td:first-child {
    font-weight: 700;
    color: var(--accent);
    font-size: 14px;
  }

  .badge-status {
    display: inline-block;
    padding: 5px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: capitalize;
  }

  .badge-waiting {
    background: var(--warn-bg);
    color: var(--warn);
    border: 1px solid var(--warn-border);
  }

  .badge-completed {
    background: var(--ok-bg);
    color: var(--ok);
    border: 1px solid var(--ok-border);
  }

  .badge-in-progress {
    background: var(--info-bg);
    color: var(--info);
    border: 1px solid var(--info-border);
  }

  .empty-state {
    text-align: center;
    padding: 50px 20px !important;
    color: var(--muted);
  }

  .empty-state i {
    font-size: 48px;
    color: var(--border-light);
    display: block;
    margin-bottom: 12px;
  }

  .empty-state h6 {
    font-weight: 600;
    color: var(--fg-dim);
    margin-bottom: 4px;
  }

  .empty-state div {
    font-size: 14px;
  }

  @media (max-width: 768px) {
    .topbar {
      padding: 14px 18px;
    }

    .topbar h5 {
      font-size: 16px;
    }

    #zero_configuration_table tbody td,
    #zero_configuration_table thead th {
      padding: 10px 12px;
      font-size: 13px;
    }
  }
</style>


<header class="topbar">
  <div class="topbar-left">
    <div class="topbar-icon">
      <i class="bi bi-clipboard2-pulse"></i>
    </div>
    <div>
      <h5>
        Mass of Goods In Batchcode In Production
        <?php if (!empty($quert1)): ?>
          <small>
            Batch: <span
              style="color:var(--accent); font-weight:700;"><?= htmlspecialchars($quert1['gcode']) ?></span>
            <?php if (!empty($quert1['pname'])): ?>
              &bull; Raw Material : <span style="font-weight:600;"><?= htmlspecialchars($quert1['pname']) ?></span>
            <?php endif; ?>
          </small>
        <?php endif; ?>
      </h5>
    </div>
  </div>
  <!-- <a href="javascript:history.back()" class="btn-back-custom">
    <i class="bi bi-arrow-left"></i> Back
  </a> -->
</header>

<div class="main-container">

  <!-- =================================================== -->
  <!-- SUMMARY CARDS (Date, Batchcode, Qty, Delivery)      -->
  <!-- =================================================== -->
  <?php


  ?>
  <section class="summary-section">
    <div class="summary-grid">

      <!-- Date Card -->
      <div class="summary-card card-date">
        <div class="card-top">
          <span class="label"><i class="bi bi-calendar3"></i> Date</span>
          <span class="icon-circle"><i class="bi bi-calendar-week"></i></span>
        </div>
        <div class="value"><?= $quert1['gooddate'] ?></div>

      </div>
      <div class="summary-card card-delivery">
        <div class="card-top">
          <span class="label"><i class="bi bi-building-fill"></i> Supplier</span>
          <span class="icon-circle"><i class="bi bi-building-fill"></i></span>
        </div>
        <div class="value"><?= $quert1['supname'] ?></div>

      </div>

      <!-- Batch Code Card -->
      <div class="summary-card card-batch">
        <div class="card-top">
          <span class="label"><i class="bi bi-upc-scan"></i> Goods In Batch Code</span>
          <span class="icon-circle"><i class="bi bi-upc-scan"></i></span>
        </div>
        <div class="value"><span class="batch-highlight"><?= $quert1['gcode'] ?></span></div>

      </div>

      <!-- Quantity Card -->
      <div class="summary-card card-qty">
        <div class="card-top">
          <span class="label"><i class="bi bi-box-seam"></i> Total Received Quantity</span>
          <span class="icon-circle"><i class="bi bi-box"></i></span>
        </div>
        <div class="value"><?= $quert1['rqty'] ?></div>
      </div>

      <!-- Delivery Date Card -->

      <div class="summary-card card-qty">
        <div class="card-top">
          <span class="label"><i class="bi bi-box-seam"></i> Total Left Quantity</span>
          <span class="icon-circle"><i class="bi bi-box"></i></span>
        </div>
        <div class="value"><?= $quert1['leftqty'] ?></div>
      </div>
      <div class="summary-card card-batch">
        <div class="card-top">
          <span class="label"><i class="bi bi-calendar3"></i>Use By Date</span>
          <span class="icon-circle"><i class="bi bi-calendar-week"></i></span>
        </div>
        <div class="value"><?= $quert1['guseby'] ?></div>

      </div>

    </div>
  </section>
  <?php

  ?>

  <!-- =================================================== -->
  <!-- ORIGINAL TABLE (exactly as provided, unchanged)     -->
  <!-- =================================================== -->
  <section id="listView">
    <div class="table-list-wrap py-4">
      <div style="overflow-x: auto;">
        <table class="table table-hover mb-0" id="zero_configuration_table">
          <thead>
            <tr>
              <th width="80">S No.</th>
              <th>Date</th>
              <th>Batch Code</th>
              <th>Total Quantity Used</th>

            </tr>
          </thead>
          <tbody>
            <?php


            $mass = mysqli_query($con, "SELECT m1.* ,m.date FROM `tblmarination1` as m1 join tblmarination as m on m.batchcode = m1.batchcode WHERE m1.grnid ='$mid' and totalqty !=''");
            $massd = mysqli_num_rows($mass);
            $ix = 0;
            if ($massd == 0) {
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
              while ($rw = mysqli_fetch_array($mass)) {
                $ix++;


                ?>
                <tr>
                  <td style="font-weight:700; color:var(--accent); font-size:14px;"><?= $ix ?></td>
                  <td style="font-weight:700; font-size:15px; color: var(--fg);">
                    <?= date('d-m-Y', strtotime($rw['date'])) ?>
                  </td>
                  <td style="font-size:15px; color: var(--muted);"><?= htmlspecialchars($rw['batchcode']) ?></td>
                  <td style="font-size:14px; color: var(--muted); white-space: nowrap;">
                    <?= $rw['totalqty'] . $rw['qty1']; ?>
                  </td>

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