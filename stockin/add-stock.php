<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
  .fsp {
    --a: #ff7043;
    --ad: #e64a19;
    --soft: #fff3e0;
    --line: #ffe0b2;
    --rgb: 230, 74, 25;
    background: linear-gradient(180deg, #fff8f0, #fef3e6);
    font-family: 'Segoe UI', Roboto, system-ui, sans-serif;
    padding: 16px;
    color: #3d2b1f;
    min-height: 100vh;
    line-height: 1.45
  }

  .fsp * {
    box-sizing: border-box
  }

  .fsp a {
    text-decoration: none
  }

  .fsp.fs-orange {
    --a: #ff7043;
    --ad: #e64a19;
    --soft: #fff3e0;
    --line: #ffe0b2;
    --rgb: 230, 74, 25
  }

  .fsp.fs-green {
    --a: #66bb6a;
    --ad: #2e7d32;
    --soft: #e8f5e9;
    --line: #c8e6c9;
    --rgb: 46, 125, 50
  }

  .fsp.fs-amber {
    --a: #ffb300;
    --ad: #e65100;
    --soft: #fff8e1;
    --line: #ffecb3;
    --rgb: 230, 81, 0
  }

  .fsp.fs-blue {
    --a: #42a5f5;
    --ad: #1976d2;
    --soft: #e3f2fd;
    --line: #bbdefb;
    --rgb: 25, 118, 210
  }

  .fsp.fs-purple {
    --a: #ab47bc;
    --ad: #7b1fa2;
    --soft: #f3e5f5;
    --line: #e1bee7;
    --rgb: 123, 31, 162
  }

  .fs-k-fresh {
    --c: #2e7d32;
    --bg: #e8f5e9
  }

  .fs-k-soon {
    --c: #d84315;
    --bg: #fff0e6
  }

  .fs-k-low {
    --c: #8a5a00;
    --bg: #fff4d1
  }

  .fs-k-expired {
    --c: #c62828;
    --bg: #ffebee
  }

  .fs-k-out {
    --c: #546e7a;
    --bg: #eceff1
  }

  .fs-head {
    background: linear-gradient(135deg, var(--a), var(--ad));
    color: #fff;
    padding: 22px 26px;
    border-radius: 18px;
    box-shadow: 0 10px 24px rgba(var(--rgb), .25);
    margin-bottom: 24px;
    position: relative;
    overflow: hidden
  }

  .fs-head::before {
    content: "";
    position: absolute;
    top: -40px;
    right: -40px;
    width: 160px;
    height: 160px;
    background: rgba(255, 255, 255, .08);
    border-radius: 50%
  }

  .fs-head::after {
    content: "";
    position: absolute;
    bottom: -60px;
    left: -30px;
    width: 140px;
    height: 140px;
    background: rgba(255, 255, 255, .06);
    border-radius: 50%
  }

  .fs-head>* {
    position: relative;
    z-index: 1
  }

  .fs-head h1 {
    font-weight: 700;
    font-size: 1.7rem;
    margin: 0 0 4px;
    display: flex;
    align-items: center;
    gap: 12px;
    color: #fff
  }

  .fs-head p {
    opacity: .92;
    margin: 0;
    font-size: .95rem
  }

  .fs-back {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #fff;
    background: rgba(255, 255, 255, .2);
    border-radius: 50px;
    padding: 6px 16px;
    font-size: .85rem;
    font-weight: 600;
    margin-bottom: 12px
  }

  .fs-back:hover {
    color: #fff;
    background: rgba(255, 255, 255, .32)
  }

  .fs-hb.add {
    background: #43a047;
    color: #fff
  }

  .fs-hb.add:hover {
    background: #2e7d32;
    color: #fff
  }

  .fs-hb.conf {
    background: #ffca28;
    color: #4e342e
  }

  .fs-hb.conf:hover {
    background: #ffb300;
    color: #3e2723
  }

  .fs-hb.req {
    background: #fff;
    color: #d84315
  }

  .fs-hb.req:hover {
    background: #fff3e0;
    color: #bf360c
  }

  .fs-tab.on {
    background: var(--a);
    border-color: var(--a);
    color: #fff;
    box-shadow: 0 4px 12px rgba(var(--rgb), .3)
  }

  .fs-tab:hover:not(.on) {
    background: var(--soft)
  }

  .fs-input {
    display: block;
    width: 100%;
    border: 1px solid var(--line);
    border-radius: 10px;
    padding: 11px 14px;
    font: inherit;
    font-size: .95rem;
    color: #3d2b1f;
    background: #fff;
    transition: all .15s
  }

  .fs-input:focus {
    outline: 0;
    border-color: var(--a);
    box-shadow: 0 0 0 3px rgba(var(--rgb), .15)
  }

  .fs-input[readonly] {
    background: var(--soft)
  }

  /* ===== Tom Select, styled like .fs-input ===== */
  .ts-wrapper.fs-select {
    width: 100%;
    padding: 0;
    border: 0;
  }

  .fs-select .ts-control {
    display: flex;
    align-items: center;
    width: 100%;
    min-height: 0;
    border: 1px solid var(--line);
    border-radius: 10px;
    padding: 11px 14px;
    font: inherit;
    font-size: .95rem;
    color: #3d2b1f;
    background: #fff;
    box-shadow: none;
    transition: all .15s;
  }

  .fs-select .ts-control input {
    font: inherit;
    font-size: .95rem;
    color: #3d2b1f;
  }

  .fs-select .ts-control input::placeholder {
    color: #9a8b80;
  }

  /* focus */
  .fs-select.focus .ts-control,
  .fs-select.dropdown-active .ts-control {
    outline: 0;
    border-color: var(--a);
    box-shadow: 0 0 0 3px rgba(var(--rgb), .15);
  }

  /* disabled / readonly look */
  .fs-select.disabled .ts-control,
  .fs-select.locked .ts-control {
    background: var(--soft);
    opacity: 1;
  }

  /* arrow */
  .fs-select.single .ts-control::after {
    border-color: #8a7566 transparent transparent transparent;
    right: 14px;
  }

  .fs-select.single.dropdown-active .ts-control::after {
    border-color: transparent transparent var(--a) transparent;
  }

  /* dropdown list */
  .fs-select .ts-dropdown {
    margin-top: 6px;
    border: 1px solid var(--line);
    border-radius: 10px;
    background: #fff;
    box-shadow: 0 10px 24px rgba(0, 0, 0, .10);
    overflow: hidden;
    font: inherit;
    font-size: .95rem;
    color: #3d2b1f;
    z-index: 1000;
  }

  .fs-select .ts-dropdown .option {
    padding: 10px 14px;
  }

  .fs-select .ts-dropdown .option.active,
  .fs-select .ts-dropdown .option:hover {
    background: rgba(var(--rgb), .12);
    color: #3d2b1f;
  }

  .fs-select .ts-dropdown .option.selected {
    background: var(--a);
    color: #fff;
  }

  .fs-select .ts-dropdown .no-results {
    padding: 10px 14px;
    color: #9a8b80;
  }

  .fs-pill {
    font-weight: 600;
    padding: 6px 14px;
    border-radius: 50px;
    font-size: .75rem;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    white-space: nowrap;
    background: var(--bg, var(--soft));
    color: var(--c, var(--ad))
  }

  .fs-di {
    display: flex;
    flex-direction: column;
    gap: 3px
  }

  .fs-dl {
    font-size: .68rem;
    text-transform: uppercase;
    letter-spacing: .5px;
    color: #a1887f;
    font-weight: 700
  }

  .fs-dl i {
    color: var(--a);
    margin-right: 4px
  }

  .fs-dv {
    font-size: .95rem;
    font-weight: 700;
    color: #4e342e
  }

  .fs-dv small {
    font-weight: 500;
    font-size: .78rem;
    color: #a1887f
  }

  .fs-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    border: 0;
    border-radius: 50px;
    padding: 8px 20px;
    font: inherit;
    font-size: .85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all .2s;
    color: #fff
  }

  .fs-btn:hover {
    transform: translateY(-2px);
    color: #fff
  }

  .fs-main {
    background: var(--ad);
    padding: 12px 30px;
    font-size: .95rem;
    box-shadow: 0 5px 14px rgba(var(--rgb), .25)
  }

  .fs-main:hover {
    filter: brightness(.88);
    box-shadow: 0 10px 22px rgba(var(--rgb), .35)
  }

  .fs-ghost {
    background: #efebe9;
    color: #5d4037;
    padding: 11px 26px;
    font-size: .95rem;
    font-weight: 500
  }

  .fs-ghost:hover {
    background: #d7ccc8;
    color: #3e2723
  }

  .fs-foot {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    gap: 10px;
    margin: 22px 0
  }

  .fs-av.bad {
    color: #c62828
  }

  .fs-form {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 6px 24px rgba(var(--rgb), .1);
    padding: 28px 26px;
    border-top: 5px solid var(--a)
  }

  .fs-form h4 {
    font-weight: 700;
    font-size: 1.3rem;
    color: var(--ad);
    margin: 0 0 6px;
    display: flex;
    align-items: center;
    gap: 10px
  }

  .fs-lead {
    color: #8d6e63;
    font-size: .9rem;
    margin: 0 0 22px
  }

  .fs-field {
    margin-bottom: 18px
  }

  .fs-field label {
    display: block;
    font-weight: 600;
    font-size: .85rem;
    color: #5d4037;
    margin-bottom: 6px
  }

  .fs-field label i {
    color: var(--a);
    margin-right: 5px
  }

  .fs-field .fs-av {
    display: block;
    margin: 4px 0 0
  }

  .fs-success.on {
    display: flex
  }

  .fs-ri {
    background: #fff;
    border-radius: 12px;
    padding: 14px 16px;
    margin-bottom: 10px;
    border-left: 4px solid var(--c, var(--a));
    box-shadow: 0 3px 10px rgba(var(--rgb), .06);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px
  }

  .fs-rn {
    font-weight: 700;
    color: var(--ad);
    font-size: .95rem
  }

  .fs-rn i {
    margin-right: 8px;
    color: var(--c, var(--ad))
  }

  .fs-rn small {
    color: #8d6e63;
    font-weight: 500
  }

  .fs-meta {
    font-size: .78rem;
    color: #8d6e63;
    display: flex;
    gap: 14px;
    flex-wrap: wrap;
    margin-top: 4px
  }

  .fs-meta i {
    color: var(--a);
    margin-right: 4px
  }

  .fs-toast {
    position: fixed;
    bottom: 24px;
    right: 24px;
    background: #fff;
    color: #3d2b1f;
    border-radius: 12px;
    padding: 14px 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, .15);
    display: flex;
    align-items: center;
    gap: 12px;
    z-index: 9999;
    transform: translateY(100px);
    opacity: 0;
    transition: all .3s;
    border-left: 4px solid #43a047;
    max-width: 340px;
    font-family: 'Segoe UI', Roboto, system-ui, sans-serif
  }

  .fs-toast.on {
    transform: translateY(0);
    opacity: 1
  }

  .fs-toast i {
    font-size: 1.2rem;
    color: #43a047
  }

  .fs-toast.bad {
    border-left-color: #e53935
  }

  .fs-toast.bad i {
    color: #e53935
  }

  .fs-wrap .row {
    --bs-gutter-x: 16px;
    margin-left: -8px;
    margin-right: -8px
  }

  .fs-wrap .row>* {
    padding-left: 8px;
    padding-right: 8px
  }

  .fs-di,
  .fs-ct {
    min-width: 0
  }

  .fs-dv,
  .fs-title,
  .fs-sub {
    overflow-wrap: anywhere
  }

  .fs-btn {
    min-height: 40px
  }

  @media(max-width:992px) {
    .fs-det {
      grid-template-columns: repeat(2, 1fr)
    }
  }

  @media(max-width:768px) {
    .fsp {
      padding: 12px
    }

    .fs-head {
      padding: 20px 18px;
      text-align: center
    }

    .fs-head h1 {
      font-size: 1.35rem;
      justify-content: center;
      flex-direction: column;
      gap: 8px
    }

    .fs-top {
      justify-content: center
    }

    .fs-acts {
      width: 100%
    }

    .fs-hb {
      flex: 1 1 calc(50% - 8px);
      justify-content: center
    }

    .fs-det.three {
      grid-template-columns: repeat(2, 1fr)
    }

    .fs-form {
      padding: 20px 16px
    }

    .fs-foot {
      flex-direction: column-reverse
    }

    .fs-main,
    .fs-ghost {
      width: 100%;
      justify-content: center
    }

    .fs-row {
      justify-content: flex-start
    }
  }

  @media(max-width:640px) {
    .fs-stats {
      grid-template-columns: 1fr
    }
  }

  @media(max-width:576px) {
    .fs-head h1 {
      font-size: 1.25rem
    }

    .fs-acts {
      display: grid;
      grid-template-columns: 1fr 1fr
    }

    .fs-hb {
      padding: 10px 8px;
      font-size: .8rem;
      gap: 6px
    }

    .fs-tab {
      padding: 7px 14px;
      font-size: .78rem
    }

    .fs-card {
      padding: 16px
    }

    .fs-input,
    .fs-qty {
      font-size: 16px
    }

    .fs-row .fs-btn {
      flex: 1 1 calc(50% - 5px);
      justify-content: center
    }

    .fs-row .fs-ok {
      flex: 1 1 100%
    }

    .fs-av {
      flex: 1 1 100%;
      margin-right: 0
    }

    .fs-row .fs-qty {
      flex: 1 1 80px;
      width: auto
    }

    .fs-toast {
      left: 12px;
      right: 12px;
      bottom: 12px;
      max-width: none
    }

    .fs-pill {
      font-size: .72rem
    }
  }

  @media(max-width:340px) {
    .fs-acts {
      grid-template-columns: 1fr
    }

    .fs-det,
    .fs-det.two,
    .fs-det.three {
      grid-template-columns: 1fr
    }
  }

  @media(hover:none) {
    .fs-card:hover {
      transform: none
    }

    .fs-hb:hover,
    .fs-btn:hover {
      transform: none
    }
  }
</style>

<div class="fsp fs-green">
  <div class="fs-wrap ">
    <div class="fs-head"><a class="fs-back" href="admin.php?id=stockdetail"><i class="bi bi-arrow-left"></i> Back to
        stock</a>
      <h1><i class="bi bi-plus-circle"></i> Add Food Stock in Store</h1>
      <p><i class="bi bi-info-circle"></i> Enter the delivery details, then confirm the received quantity</p>
    </div>
    <div class="fs-form">
      <h4><i class="bi bi-card-checklist"></i> New Stock Entry</h4>
      <p class="fs-lead">Fill in the food item details below. The entry goes to Confirm Stock before it appears in the
        store.</p>
      <form id="f" method="post">
        <div class="row">
          <div class="col-md-6">
            <div class="fs-field">
              <label><i class="bi bi-calendar-x"></i> Date</label>
              <input name="date" id="date" type="date" class="fs-input" value="<?= date('Y-m-d') ?>" required>
            </div>
          </div>


          <div class="col-md-6">
            <div class="fs-field">
              <label><i class="bi bi-truck"></i> Supplier Name</label>
              <select id="supplier" name="supplier" required class="fs-input" onchange="getproducts(this.value);">
                <option value="">Select supplier...</option>
                <?php
                $supq = mysqli_query($con, "SELECT supname,supid FROM `tblrawsupplier` order by supname asc");

                foreach ($supq as $supdata) {
                ?>
                  <option value="<?= $supdata['supid'] ?>"><?= $supdata['supname'] ?></option>
                <?php
                }

                ?>


              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="fs-field">
              <label><i class="bi bi-egg-fried"></i>Product Name</label>

              <select id="product" name="product" required class="fs-input">
                <option value=''>Select product...</option>

              </select>
            </div>
          </div>


          <script>
            function getproducts(val) {
              let supplier_id = val;
              let product_id = document.getElementById("product");

              // Loading option
              product_id.innerHTML = "<option value=''>Loading...</option>";

              const xmlhttp = new XMLHttpRequest();

              xmlhttp.onload = function() {
                // AJAX success
                product_id.innerHTML = "<option value=''>Select product...</option>" + this.responseText;
                product_id.dispatchEvent(new Event('change'));
              };

              xmlhttp.open("GET", "stockin/stockproduct.php?supid=" + supplier_id, true);
              xmlhttp.send();


            }
          </script>

          <div class="col-md-6">
            <div class="fs-field"><label><i class="bi bi-123"></i> Quantity</label><input name="qty" type="number"
                min="1" class="fs-input" placeholder="0" required></div>
          </div>
          <div class="col-md-6">
            <div class="fs-field"><label><i class="bi bi-rulers"></i> Unit</label>
              <select name="unit" class="fs-input" required>
                <option value=''>Select unit...</option>
                <option value="kg">kg</option>
                <option value="ltr">ltr</option>
                <option value="pcs">pcs</option>

              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="fs-field"><label><i class="bi bi-upc-scan"></i> Batch Code</label>
              <input name="batch" class="fs-input" placeholder="e.g. VEG-2201" required>
            </div>
          </div>
          <div class="col-md-6">
            <div class="fs-field"><label><i class="bi bi-upc-scan"></i> Expiry Type</label>
              <select name="ubtype" id="ubtype" onchange="changeexp();" class="fs-input" required>
                <option value="">Select Expiry Type</option>
                <option value="UB">UB(Use By)</option>
                <option value="BB">BB(Best Before)</option>
                <option value="N/A">N/A</option>
              </select>
            </div>
          </div>
          <script>
            function changeexp() {
              var ubtype = document.getElementById("ubtype").value;
              if (ubtype == "N/A") {
                document.getElementById("exp").value = "";
                document.getElementById("exp").readOnly = true;
              } else {
                document.getElementById("exp").readOnly = false;
                document.getElementById("exp").required = true;
              }
            }
          </script>
          <div class="col-md-6">
            <div class="fs-field"><label><i class="bi bi-calendar-x"></i> Expiry Date</label>
              <input name="expiry"
                id="exp" type="date" class="fs-input" readonly>
            </div>
          </div>

          <div class="col-md-6">
























          </div>
        </div>
        <div class="fs-foot">
          <button class="fs-btn fs-main" type="submit" name="add"><i class="bi bi-save"></i> Add to Confirm List</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php


if (isset($_POST['add'])) {
  $supplier = $_POST['supplier'];

  $supr = mysqli_query($con, "SELECT supname,supid FROM `tblrawsupplier` where supid = '$supplier'");
  $suprn = mysqli_fetch_array($supr);
  $sname = $suprn['supname'];
  //product
  $product = $_POST['product'];
  $rawdatar = mysqli_query($con, "SELECT pname,id FROM `tblrawmaterial` WHERE id='$product'");
  $rdatan = mysqli_fetch_array($rawdatar);
  $pname = $rdatan['pname'];



  //
  $qty = $_POST['qty'];
  $unit = $_POST['unit'];
  $batch = $_POST['batch'];
  $ubtype = $_POST['ubtype'];
  if ($ubtype == 'N/A') {
    $expiry = '0000-00-00';
  } else {
    $expiry = $_POST['expiry'];
  }
  $date = $_POST['date'];

  $datexn = date('Y-m-d H:i:s');




  $stockadd = mysqli_query($con, "INSERT INTO `stock_in`(`date`, `pname`, `supname`, `unitm`, `created_at`, `add_on`, `add_by`,`useby`,`batchcode`, `prodid`, `storedqty`, `confirm`, `storedleftqty`,`actualqty`, `goodqty`, `ubtype`, `tranfer`) VALUES ('$date','$pname','$sname','$unit','$datexn','$datexn','$user','$expiry','$batch','$product','$qty','Yes','$qty','$qty','$qty','$ubtype','Direct')");
  if ($stockadd) {
     $recordid = "IN" . date('Ymdhi') . rand(100, 999);
       $newins = mysqli_query($con, "INSERT INTO `stock_trans`( `qty`, `transby`, `transon`, `recorid`,`unitm`,type,prodid) VALUES ('$qty','$user','$datexn','$recordid','$unit','IN','$product')");
    echo "<script>window.location.href='admin.php?id=stockdetail&sucess=1';</script>";
  }
}


?>