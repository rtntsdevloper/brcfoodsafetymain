<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
  body {
    background: #faf7f2;
    font-family: 'Segoe UI', Roboto, system-ui, sans-serif;
  }

  .fsp {
    --a: #ffb300;
    --ad: #e65100;
    --soft: #fff8e1;
    --line: #ffecb3;
    --rgb: 230, 81, 0;
  }

  /* ---------- header ---------- */
  .fs-head {
    background: linear-gradient(135deg, var(--a), var(--ad));
    color: #fff;
    padding: 22px 26px;
    border-radius: 18px;
    box-shadow: 0 10px 24px rgba(var(--rgb), .25);
    position: relative;
    overflow: hidden;
  }

  .fs-head::before {
    content: "";
    position: absolute;
    top: -40px;
    right: -40px;
    width: 160px;
    height: 160px;
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

  .fs-head>* {
    position: relative;
    z-index: 1;
  }

  .fs-head h1 {
    font-weight: 700;
    font-size: 1.7rem;
    margin: 0 0 4px;
    display: flex;
    align-items: center;
    gap: 12px;
    color: #fff;
  }

  .fs-head p {
    opacity: .92;
    margin: 0;
    font-size: .95rem;
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
    margin-bottom: 12px;
    text-decoration: none;
    transition: .2s;
  }

  .fs-back:hover {
    color: #fff;
    background: rgba(255, 255, 255, .32);
    text-decoration: none;
  }

  /* ---------- bootstrap card override ---------- */
  .fs-card {
    border: 0 !important;
    border-left: 5px solid var(--a) !important;
    border-radius: 16px !important;
    box-shadow: 0 4px 18px rgba(var(--rgb), .08);
    transition: all .22s;
  }

  .fs-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 28px rgba(var(--rgb), .15);
  }

  /* ---------- status pill ---------- */
  .fs-pill {
    font-weight: 600;
    padding: 6px 14px;
    border-radius: 50px;
    font-size: .75rem;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    white-space: nowrap;
    background: #fff4d1;
    color: #8a5a00;
  }

  /* ---------- icon box ---------- */
  .fs-ic {
    width: 50px;
    height: 50px;
    border-radius: 14px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    flex-shrink: 0;
  }

  /* ---------- title & sub ---------- */
  .fs-title {
    font-weight: 700;
    font-size: 1.12rem;
    margin: 0;
    color: #3d2b1f;
  }

  .fs-sub {
    font-size: .78rem;
    color: #8d6e63;
    margin-top: 2px;
  }

  .fs-sub i {
    color: var(--a);
    margin-right: 4px;
  }

  /* ---------- detail grid ---------- */
  .fs-det {
    border-top: 1px dashed var(--line);
    border-bottom: 1px dashed var(--line);
  }

  .fs-dl {
    font-size: .68rem;
    text-transform: uppercase;
    letter-spacing: .5px;
    color: #a1887f;
    font-weight: 700;
  }

  .fs-dl i {
    color: var(--a);
    margin-right: 4px;
  }

  .fs-dv {
    font-size: .95rem;
    font-weight: 700;
    color: #4e342e;
  }

  .fs-dv small {
    font-weight: 500;
    font-size: .78rem;
    color: #a1887f;
  }

  /* ---------- action row ---------- */
  .fs-lbl {
    font-size: .8rem;
    font-weight: 700;
    color: #5d4037;
  }

  .fs-unit {
    font-size: .8rem;
    color: #8d6e63;
  }

  .fs-qty {
    width: 90px;
    padding: 7px 10px;
    font-size: .85rem;
    border: 1px solid var(--line);
    border-radius: 10px;
    color: #3d2b1f;
    background: #fff;
    transition: all .15s;
  }

  .fs-qty:focus {
    outline: 0;
    border-color: var(--a);
    box-shadow: 0 0 0 3px rgba(var(--rgb), .15);
  }

  .fs-check {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: .85rem;
    font-weight: 600;
    cursor: pointer;
    color: #5d4037;
    margin-bottom: 0;
  }

  .fs-check input {
    width: 18px;
    height: 18px;
    accent-color: var(--ad);
    margin: 0;
  }

  /* ---------- buttons ---------- */
  .fs-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    border: 0;
    border-radius: 50px;
    padding: 8px 20px;
    font-size: .85rem;
    font-weight: 600;
    color: #fff;
    text-decoration: none;
  }

  .fs-btn:hover {
    color: #fff;
    text-decoration: none;
  }

  .fs-no {
    background: #e53935;
  }

  .fs-no:hover {
    background: #c62828;
  }

  .fs-main {
    background: var(--ad);
    padding: 12px 30px;
    font-size: .95rem;
    box-shadow: 0 5px 14px rgba(var(--rgb), .25);
  }

  .fs-main:hover {
    background: #bf360c;
  }

  .fs-ghost {
    background: #efebe9;
    color: #5d4037;
    padding: 11px 26px;
    font-size: .95rem;
    font-weight: 500;
  }

  .fs-ghost:hover {
    background: #d7ccc8;
    color: #3e2723;
  }

  .fs-empty-card {
    border: 0 !important;
    border-left: 5px solid var(--a) !important;
    border-radius: 16px !important;
    box-shadow: 0 4px 18px rgba(var(--rgb), .08);
  }

  .fs-empty {
    text-align: center;
    padding: 60px 24px;
  }

  .fs-empty i {
    display: block;
    font-size: 4rem;
    color: var(--line);
    margin-bottom: 20px;
  }

  .fs-empty h5 {
    font-weight: 700;
    color: #4e342e;
    margin-bottom: 8px;
  }

  .fs-empty p {
    color: #a1887f;
    margin-bottom: 24px;
    font-size: .95rem;
  }
</style>
</head>

<div class="container-fluid py-4">
  <div class="fsp mx-auto" style="max-width:1100px;">

    <!-- ========== HEADER ========== -->
    <div class="fs-head mb-4 ">
      <a class="fs-back" href="admin.php?id=stockdetail">
        <i class="bi bi-arrow-left"></i> Back to stock
      </a>
      <h1>
        <i class="bi bi-check-circle-fill"></i> Confirm Tranfer Stock
      </h1>
      <p>
        <i class="bi bi-clipboard-check"></i> Verify the received quantity, items and confirm
      </p>
    </div>

    <form method="post">
      <div id="list">

        <!-- item 1 : Fresh Carrots -->

        <?php
        $productid = mysqli_query($con, "SELECT * FROM `stock_in` WHERE confirm='Pending'");
        $productnm = mysqli_num_rows($productid);
        if ($productnm > 0) {

          foreach ($productid as $row) {
            $productname = $row['pname'];
            $supname = $row['supname'];
            $batchno = $row['batchcode'];
            $expirydate = $row['useby'];
            $grn = $row['grn'];
            $expectedquantity = $row['actualqty'];
            $unitm = $row['unitm'];

            $recid = $row['id'];
            $prodid = $row['prodid'];



        ?>
            <div class="card fs-card mb-3">
              <div class="card-body">
                <div class="d-flex flex-wrap justify-content-between align-items-start mb-3">
                  <div class="d-flex align-items-center">
                    <div class="fs-ic mr-3" style="background:#e8f5e9; color:#2e7d32;">
                      <i class="bi bi-box-seam-fill"></i>
                    </div>
                    <div>
                      <h5 class="fs-title"><?php echo $productname; ?></h5>
                      <div class="fs-sub"><i class="bi bi-building"></i> <?php echo $supname; ?></div>
                      <input type="hidden" value="<?php echo $recid; ?>" name="recid[]">
                      <input type="hidden" value="<?php echo $prodid; ?>" name="prodid[]">
                    </div>
                  </div>
                  <span class="fs-pill mt-2 mt-sm-0"><i class="bi bi-clock"></i> Awaiting check</span>
                </div>

                <div class="fs-det row py-3 mb-3 mx-0">
                  <div class="col-6 col-md-3 mb-2 mb-md-0">
                    <span class="fs-dl d-block"><i class="bi bi-upc-scan"></i> Batch Code</span>
                    <span class="fs-dv"><?php echo $batchno; ?></span>
                  </div>
                  <div class="col-6 col-md-3 mb-2 mb-md-0">
                    <span class="fs-dl d-block"><i class="bi bi-calendar-x"></i> Use By Date</span>
                    <span class="fs-dv"><?php echo $expirydate; ?></span>
                  </div>
                  <div class="col-6 col-md-3">
                    <span class="fs-dl d-block"><i class="bi bi-receipt"></i> GRN</span>
                    <span class="fs-dv"><?php echo $grn; ?></span>
                  </div>
                  <div class="col-6 col-md-3">
                    <span class="fs-dl d-block"><i class="bi bi-123"></i> Expected</span>
                    <span class="fs-dv"><?php echo $expectedquantity; ?> <small><?= $unitm ?></small></span>
                  </div>
                </div>

                <div class="d-flex flex-wrap gap-2 justify-content-end align-items-center">
                  <span class="fs-lbl mr-1">Received</span>
                  <input type="number" class="fs-qty mr-2" name="received[]" value="<?php echo $expectedquantity; ?>" min="" step="0.01" required>
                  <input type="hidden" name="unitm[]" value="<?= $unitm ?>">
                  <span class="fs-unit mr-3"><?= $unitm ?></span>
                  <label class="fs-check">
                    <input type="checkbox" name="confirm<?php echo $recid; ?>" value="Yes" checked> Confirm
                  </label>
                </div>
              </div>
            </div>
          <?php
          }
          ?>



          <!-- ========== FOOTER ========== -->
          <div class="d-flex flex-wrap justify-content-between align-items-center my-4">

            <button class="fs-btn fs-main mb-2 mb-sm-0" type="submit" name="submit">
              <i class="bi bi-check-all"></i> Confirm Selected Food Stock
            </button>
          </div>
        <?php
        } else {
        ?>
          <div class="card fs-empty-card mb-3">
            <div class="card-body fs-empty">
              <i class="bi bi-inbox"></i>
              <h5>Nothing waiting for confirmation</h5>
              <p>All Food Stock Confirmed and Updated</p>

            </div>
          </div>
        <?php
        }
        ?>
    </form>

  </div>
</div>



<?php

if (isset($_POST['submit'])) {



  $recid = $_POST['recid'];
  $received = $_POST['received'];
  $datenx = date('Y-m-d H:i:s');


  foreach ($recid as $key => $value) {
    $recid = $value;
    $received1 = $received[$key];
    $confirm1 = $_POST['confirm'.$value];
    $unitm1 = $_POST['unitm'][$key];
    $prodidx = $_POST['prodid'][$key];

    if ($confirm1 == 'Yes') {
      $qry = "UPDATE `stock_in` SET `storedqty`='$received1',`confirm`='$confirm1',`storedleftqty`='$received1',`confirmby`='$user',`confirmon`='$datenx' WHERE id='$recid'";
      $exec = mysqli_query($con, $qry);

       $recordid = "IN" . date('Ymdhi') . rand(100, 999);
       $newins = mysqli_query($con, "INSERT INTO `stock_trans`(`transid`, `qty`, `transby`, `transon`, `recorid`,`unitm`,type,prodid) VALUES ('$recid','$received1','$user','$datenx','$recordid','$unitm1','IN','$prodidx')");
    }
  }

  if ($exec) {
    echo "<script>window.location.href='admin.php?id=stockdetail&sucess=2';</script>";
  }else{
    echo "<script>window.location.href='admin.php?id=stockdetail&sucess=x';</script>";
  }
}


?>