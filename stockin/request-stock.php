<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.default.min.css">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

<style>
  :root {
    --a: #42a5f5;
    --ad: #1976d2;
    --soft: #e3f2fd;
    --line: #bbdefb;
    --rgb: 25, 118, 210;
    --danger-bg: #ffebee;
    --danger: #c62828;
  }

  .fsp {
    background: linear-gradient(180deg, #fff8f0, #fef3e6);
    font-family: 'Segoe UI', Roboto, system-ui, sans-serif;
    padding: 16px;
    color: #3d2b1f;
    min-height: 100vh;
    line-height: 1.45;
    margin-bottom: 50px;
  }

  .fsp * {
    box-sizing: border-box;
  }

  .fsp a {
    text-decoration: none;
  }

  .fsp input,
  .fsp select,
  .fsp textarea {
    font-size: 16px !important;
  }

  /* ================= HEADER ================= */
  .fs-head {
    background: linear-gradient(135deg, var(--a), var(--ad));
    color: #fff;
    padding: 20px 24px;
    border-radius: 18px;
    box-shadow: 0 10px 24px rgba(var(--rgb), .25);
    margin-bottom: 24px;
    position: relative;
    overflow: hidden;
  }

  .fs-head::before {
    content: "";
    position: absolute;
    top: -40px;
    right: -40px;
    width: 170px;
    height: 170px;
    background: rgba(255, 255, 255, .08);
    border-radius: 50%;
  }

  .fs-head::after {
    content: "";
    position: absolute;
    bottom: -60px;
    left: -30px;
    width: 140px;
    height: 140px;
    background: rgba(255, 255, 255, .06);
    border-radius: 50%;
  }

  .fs-topbar {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 18px;
    position: relative;
    z-index: 1;
  }

  .fs-chip-group {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
  }

  .fs-chip {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    color: #fff;
    background: rgba(255, 255, 255, .18);
    border: 1px solid rgba(255, 255, 255, .25);
    border-radius: 50px;
    padding: 7px 14px;
    font-size: .82rem;
    font-weight: 600;
    transition: background .2s, transform .2s;
  }

  .fs-chip:hover {
    color: #fff;
    background: rgba(255, 255, 255, .32);
    transform: translateY(-1px);
  }

  .fs-chip .fs-pulse {
    background: #fff;
    color: var(--ad);
    border-radius: 50px;
    padding: 1px 9px;
    font-size: .78rem;
    font-weight: 700;
    margin-left: 2px;
  }

  .fs-title-row {
    display: flex;
    align-items: center;
    gap: 14px;
    position: relative;
    z-index: 1;
  }

  .fs-icon-box {
    width: 52px;
    height: 52px;
    flex-shrink: 0;
    background: rgba(255, 255, 255, .18);
    border: 1px solid rgba(255, 255, 255, .3);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
  }

  .fs-head h1 {
    font-weight: 700;
    font-size: 1.45rem;
    margin: 0;
    color: #fff;
  }

  .fs-head p {
    opacity: .92;
    margin: 2px 0 0;
    font-size: .88rem;
  }

  /* ================= FORM CARD ================= */
  .fs-form {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 6px 24px rgba(var(--rgb), .1);
    padding: 24px;
    border-top: 5px solid var(--a);
  }

  .fs-form h4 {
    font-weight: 700;
    font-size: 1.2rem;
    color: var(--ad);
    margin: 0 0 4px;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .fs-lead {
    color: #8d6e63;
    font-size: .9rem;
    margin: 0 0 20px;
  }

  .fs-section-title {
    font-size: 1.02rem;
    color: var(--ad);
    font-weight: 700;
    margin: 0 0 16px;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .fs-section-title::after {
    content: "";
    flex: 1;
    height: 1px;
    background: var(--line);
  }

  .fs-mini-pill {
    background: var(--soft);
    color: var(--ad);
    border-radius: 50px;
    padding: 1px 11px;
    font-size: .75rem;
    font-weight: 700;
  }

  .fs-field {
    margin-bottom: 16px;
  }

  .fs-field label {
    display: block;
    font-weight: 600;
    font-size: .85rem;
    color: #5d4037;
    margin-bottom: 6px;
  }

  .fs-field label i {
    color: var(--a);
    margin-right: 5px;
  }

  .fs-input,
  .fs-select {
    display: block;
    width: 100%;
    border: 1px solid var(--line);
    border-radius: 10px;
    padding: 12px 14px;
    font: inherit;
    color: #3d2b1f;
    background: #fff;
    transition: all .15s;
    min-height: 44px;
  }

  .fs-input:focus,
  .fs-select:focus {
    outline: 0;
    border-color: var(--a);
    box-shadow: 0 0 0 3px rgba(var(--rgb), .15);
  }

  .fs-info {
    background: var(--soft);
    border-left: 4px solid var(--a);
    border-radius: 10px;
    padding: 14px 16px;
    margin-bottom: 22px;
    font-size: .88rem;
    color: var(--ad);
    display: flex;
    gap: 10px;
  }

  .fs-info i {
    font-size: 1.1rem;
    margin-top: 2px;
    flex-shrink: 0;
  }

  /* ================= BUTTONS ================= */
  .fs-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    border: 0;
    border-radius: 50px;
    padding: 12px 20px;
    font: inherit;
    font-size: .9rem;
    font-weight: 600;
    cursor: pointer;
    transition: all .2s;
    color: #fff;
    min-height: 44px;
  }

  .fs-btn:active {
    transform: scale(0.98);
  }

  /* Primary submit — gradient + count pill */
  .fs-main {
    background: linear-gradient(135deg, var(--a), var(--ad));
    box-shadow: 0 5px 14px rgba(var(--rgb), .3);
    font-size: .95rem;
    padding: 13px 20px;
  }

  .fs-main:hover {
    filter: brightness(.93);
    box-shadow: 0 8px 20px rgba(var(--rgb), .4);
  }

  .fs-count-pill {
    background: rgba(255, 255, 255, .25);
    border-radius: 50px;
    padding: 2px 11px;
    font-size: .8rem;
    font-weight: 700;
  }

  /* Ghost / reset */
  .fs-ghost {
    background: #fff;
    color: #90a4ae;
    border: 1px solid var(--line);
    min-width: 90px;
  }

  .fs-ghost:hover {
    background: #f5f5f5;
    color: #607d8b;
  }

  /* Dashed add-row button */
  .fs-add-row {
    background: transparent;
    border: 2px dashed var(--a);
    border-radius: 12px;
    color: var(--ad);
    width: 100%;
    justify-content: center;
    margin: 4px 0 20px;
    padding: 13px;
    font-weight: 700;
  }

  .fs-add-row:hover {
    background: var(--soft);
    border-style: solid;
    transform: none;
  }

  .fs-add-row i {
    font-size: 1.05rem;
  }

  /* Circular row delete button */
  .btn-remove-row {
    width: 32px;
    height: 32px;
    border: 0;
    border-radius: 9px;
    background: var(--danger-bg);
    color: var(--danger);
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: .9rem;
    transition: all .2s;
    flex-shrink: 0;
  }

  .btn-remove-row:hover {
    background: #ffcdd2;
    transform: scale(1.08);
  }

  .btn-remove-row:disabled {
    opacity: .35;
    cursor: not-allowed;
    transform: none;
  }

  /* ================= PRODUCT ROWS ================= */
  .product-row {
    background: #f8fbff;
    border: 1px solid var(--line);
    border-radius: 14px;
    padding: 14px;
    margin-bottom: 12px;
    position: relative;
    transition: border-color .25s, box-shadow .25s;
    animation: slideIn .3s ease-out;
  }

  .product-row:hover {
    border-color: var(--a);
    box-shadow: 0 4px 14px rgba(var(--rgb), .1);
  }

  .product-row.removing {
    animation: slideOut .25s ease-in forwards;
    overflow: hidden;
  }

  .pr-head {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 10px;
  }

  .pr-num {
    width: 24px;
    height: 24px;
    background: var(--soft);
    color: var(--ad);
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: .78rem;
    font-weight: 700;
    flex-shrink: 0;
  }

  .pr-label {
    font-size: .78rem;
    font-weight: 700;
    color: #8d6e63;
    text-transform: uppercase;
    letter-spacing: .4px;
    flex: 1;
  }

  @keyframes slideIn {
    from {
      opacity: 0;
      transform: translateY(-10px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  @keyframes slideOut {
    from {
      opacity: 1;
      transform: translateX(0);
      max-height: 300px;
    }

    to {
      opacity: 0;
      transform: translateX(20px);
      max-height: 0;
      padding: 0;
      margin: 0;
      border: 0;
    }
  }

  /* ================= FOOTER ================= */
  .fs-foot {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-top: 8px;
  }

  .fs-summary {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    background: var(--soft);
    border: 1px solid var(--line);
    border-radius: 12px;
    padding: 10px 16px;
    font-size: .85rem;
    color: var(--ad);
    font-weight: 600;
  }

  .fs-foot-btns {
    display: flex;
    gap: 10px;
  }

  .fs-foot-btns .fs-main {
    flex: 1;
  }

  /* TomSelect tweaks */
  .ts-wrapper {
    width: 100% !important;
  }

  .ts-control {
    min-height: 44px;
    display: flex;
    align-items: center;
    border-radius: 10px !important;
    border: 1px solid var(--line) !important;
  }

  .ts-control:focus {
    border-color: var(--a) !important;
    box-shadow: 0 0 0 3px rgba(var(--rgb), .15) !important;
  }

  /* ================= RESPONSIVE ================= */
  @media (max-width: 768px) {
    .fsp {
      padding: 12px;
    }

    .fs-head {
      padding: 16px;
    }

    .fs-topbar {
      margin-bottom: 14px;
    }

    .fs-title-row {
      gap: 10px;
    }

    .fs-icon-box {
      width: 44px;
      height: 44px;
      font-size: 1.2rem;
    }

    .fs-head h1 {
      font-size: 1.25rem;
    }

    .fs-form {
      padding: 20px 16px;
    }

    .fs-info {
      flex-direction: column;
      gap: 8px;
    }
  }

  @media (max-width: 576px) {
    .fs-head h1 {
      font-size: 1.15rem;
    }

    .fs-head p {
      font-size: .8rem;
    }

    .fs-chip {
      font-size: .75rem;
      padding: 6px 11px;
    }

    .product-row {
      padding: 12px;
    }

    .fs-field {
      margin-bottom: 12px;
    }

    /* Sticky action footer for long forms */
    .fs-foot {
      position: sticky;
      bottom: 10px;
      z-index: 20;
      background: rgba(255, 255, 255, .92);
      backdrop-filter: blur(8px);
      border: 1px solid var(--line);
      border-radius: 14px;
      padding: 10px;
      box-shadow: 0 -4px 20px rgba(var(--rgb), .12);
    }

    .fs-summary {
      font-size: .78rem;
      padding: 8px 12px;
    }
  }
</style>

<div class="fsp fs-blue">
  <div class="fs-wrap">

    <!-- ========== HEADER ========== -->
    <div class="fs-head">
      <div class="fs-topbar">
        <a class="fs-chip" href="admin.php?id=1">
          <i class="bi bi-arrow-left"></i> Back to Stock
        </a>
        <div class="fs-chip-group">
          <a class="fs-chip" href="admin.php?id=request-flow">
            <i class="bi bi-clock-history"></i> History
          </a>

          <a class="fs-chip" href="admin.php?id=recieved-request">
            <i class="bi bi-stopwatch"></i> Stock Take in <span class="fs-pulse">
              <?php

              echo mysqli_num_rows(mysqli_query($con, "SELECT * FROM `stock_request` WHERE rstatus='Issued'"));

              ?>
            </span>
          </a>
        </div>
      </div>

      <div class="fs-title-row">
        <div class="fs-icon-box"><i class="bi bi-send-fill"></i></div>
        <div>
          <h1>Raise Stock Request</h1>
          <p><i class="bi bi-info-circle"></i> Request multiple food products from the store team in one go</p>
        </div>
      </div>
    </div>

    <!-- ========== FORM ========== -->
    <div class="fs-form">
      <h4><i class="bi bi-card-checklist"></i> New Stock Request</h4>
      <p class="fs-lead">Fill in the request details and add all required products below.</p>

      <div class="fs-info">
        <i class="bi bi-lightbulb"></i>
        <div><strong>Tip:</strong> You can add multiple products to a single request. Double-check quantities and units before submitting.</div>
      </div>

      <form id="stockRequestForm" method="POST">

        <!-- Section: Request Details -->
        <div class="fs-section-title"><i class="bi bi-calendar-event"></i> Request Details</div>

        <div class="row g-3">
          <div class="col-12 col-md-6">
            <div class="fs-field">
              <label><i class="bi bi-calendar-check"></i> Required By</label>
              <input name="required_date" id="need" type="date" class="fs-input" value="<?php echo date('Y-m-d'); ?>" required>
            </div>
          </div>
        </div>

        <!-- Section: Products -->
        <div class="fs-section-title">
          <i class="bi bi-basket"></i> Products to Request
          <span class="fs-mini-pill" id="headCount">1</span>
        </div>

        <div id="product-rows-container"></div>

        <button type="button" id="add-product-btn" class="fs-btn fs-add-row">
          <i class="bi bi-plus-circle-fill"></i> Add Another Product
        </button>

        <!-- Footer: summary + actions -->
        <div class="fs-foot">
          <div class="fs-summary">
            <span><i class="bi bi-basket2-fill"></i> <span id="rowCount">1</span> product(s) in this request</span>
            <span><i class="bi bi-calendar3"></i> <span id="summaryDate">—</span></span>
          </div>
          <div class="fs-foot-btns">
            <button type="button" id="reset-form-btn" class="fs-btn fs-ghost">
              <i class="bi bi-arrow-counterclockwise"></i> Reset
            </button>
            <button type="submit" name="btn" class="fs-btn fs-main">
              <i class="bi bi-send-fill"></i> Submit Request <span class="fs-count-pill" id="submitCount">1</span>
            </button>
          </div>
        </div>

      </form>
    </div>
  </div>
</div>

<!-- ========== ROW TEMPLATE ========== -->
<template id="product-row-template">
  <div class="product-row">
    <div class="pr-head">
      <span class="pr-num">1</span>
      <span class="pr-label">Product details</span>
      <button type="button" class="btn-remove-row" title="Remove this product">
        <i class="bi bi-trash-fill"></i>
      </button>
    </div>

    <div class="row g-2">
      <!-- Food Item -->
      <div class="col-12 col-md-7">
        <div class="fs-field mb-0">
          <label class="small"><i class="bi bi-egg-fried"></i> Food Item</label>
          <select name="product_id[]" class="fs-select product-select" required>
            <option value="">--select--</option>
            <?php
            $supq = mysqli_query($con, "SELECT pname, id FROM `tblrawmaterial` ORDER BY pname ASC");
            if ($supq) {
              foreach ($supq as $supdata) {
                echo '<option value="' . htmlspecialchars($supdata['id']) . '">' . htmlspecialchars($supdata['pname']) . '</option>';
              }
            }
            ?>
          </select>
        </div>
      </div>

      <!-- Qty -->
      <div class="col-6 col-md-2">
        <div class="fs-field mb-0">
          <label class="small"><i class="bi bi-123"></i> Qty</label>
          <input type="number" name="qty[]" step="0.01" min="0" inputmode="decimal" class="fs-input" placeholder="0" required>
        </div>
      </div>

      <!-- Unit -->
      <div class="col-6 col-md-3">
        <div class="fs-field mb-0">
          <label class="small"><i class="bi bi-rulers"></i> Unit</label>
          <select name="unit[]" class="fs-input" required>
            <option value="">--</option>
            <option value="kg">kg</option>
            <option value="ltr">ltr</option>
            <option value="pcs">pcs</option>
          </select>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('product-rows-container');
    const template = document.getElementById('product-row-template');
    const dateInput = document.getElementById('need');
    let rowCount = 0;

    function addRow() {
      const clone = template.content.cloneNode(true);
      const row = clone.querySelector('.product-row');
      const select = row.querySelector('.product-select');

      select.id = 'product_select_' + rowCount++;
      container.appendChild(row);

      new TomSelect('#' + select.id, {
        create: false,
        maxOptions: null,
        placeholder: '--select--',
        dropdownParent: 'body'
      });

      syncCounts();
    }

    // Remove with animation (event delegation)
    container.addEventListener('click', function(e) {
      const removeBtn = e.target.closest('.btn-remove-row');
      if (!removeBtn || removeBtn.disabled) return;

      const row = removeBtn.closest('.product-row');
      row.classList.add('removing');

      setTimeout(() => {
        const select = row.querySelector('.product-select');
        if (select && select.tomselect) select.tomselect.destroy();
        row.remove();
        syncCounts();
      }, 250);
    });

    // Renumber rows + update all counters + toggle delete buttons
    function syncCounts() {
      const rows = container.querySelectorAll('.product-row:not(.removing)');
      const single = rows.length === 1;

      rows.forEach((row, idx) => {
        row.querySelector('.pr-num').textContent = idx + 1;
        const btn = row.querySelector('.btn-remove-row');
        btn.disabled = single;
        btn.title = single ? 'At least one product is required' : 'Remove this product';
      });

      document.getElementById('headCount').textContent = rows.length;
      document.getElementById('submitCount').textContent = rows.length;
      document.getElementById('rowCount').textContent = rows.length;
    }

    // Live date preview in summary bar
    function syncDate() {
      const el = document.getElementById('summaryDate');
      if (!dateInput.value) {
        el.textContent = '—';
        return;
      }
      const d = new Date(dateInput.value + 'T00:00:00');
      el.textContent = isNaN(d) ? '—' :
        d.toLocaleDateString('en-GB', {
          day: '2-digit',
          month: 'short',
          year: 'numeric'
        });
    }
    dateInput.addEventListener('change', syncDate);
    syncDate();

    // Reset whole form back to one empty row
    document.getElementById('reset-form-btn').addEventListener('click', function() {
      if (!confirm('Clear all products and start over?')) return;
      container.querySelectorAll('.product-row').forEach(row => {
        const select = row.querySelector('.product-select');
        if (select && select.tomselect) select.tomselect.destroy();
        row.remove();
      });
      document.getElementById('stockRequestForm').reset();
      syncDate();
      addRow();
    });

    addRow();
    document.getElementById('add-product-btn').addEventListener('click', addRow);

    dateInput.setAttribute('min', new Date().toISOString().split('T')[0]);
  });
</script>

<?php
if (isset($_POST['btn'])) {
  $required_date = $_POST['required_date'];
  $product_id = $_POST['product_id'];
  $qty = $_POST['qty'];
  $unit = $_POST['unit'];
  $date = $required_date;

  $ubatch = 'REQ' . date('YmdH') . rand(111, 999);
  $datenx = date('d-m-Y H:i');
  $result = false;

  foreach ($product_id as $key => $value) {
    $prodid  = $value;
    $qtyy    = $qty[$key];
    $unitt   = $unit[$key];

    $prdqr  = mysqli_query($con, "SELECT pname FROM `tblrawmaterial` WHERE id = '$prodid'");
    $prdrow = mysqli_fetch_assoc($prdqr);
    $prodname = $prdrow['pname'];

    $sql = "INSERT INTO `stock_request`(`prodid`, `product`, `qty`, `uom`, `date`, `updatedon`, `updateby`, `recordid`)
            VALUES ('$prodid','$prodname','$qtyy','$unitt','$date','$date','$datenx','$ubatch')";
    $result = mysqli_query($con, $sql);
  }

  if ($result) {
    echo "<script>window.location.href = 'admin.php?id=request-flow&sucess=1'</script>";
  } else {
    echo "<script>window.location.href = 'admin.php?id=request-flow&sucess=x'</script>";
  }
}
?>