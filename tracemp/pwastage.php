  <?php
    $sno = $_GET['wid'];
    $sqlt = mysqli_query($con, "select * from tblpusage where id='$sno'");
    $rowt = mysqli_fetch_array($sqlt);

    ?>

  <div class="page-header">
      <div class="page-block">
          <div class="row align-items-center">
              <div class="col-md-12">
                  <div class="page-header-title">
                      <h5 class="m-b-10">Dashboard</h5>
                  </div>
                  <ul class="breadcrumb">
                      <li class="breadcrumb-item"><a href="#!">Home / Potato Usage Record - (Add Wastage) </a></li>
                  </ul>

              </div>
          </div>
      </div>
  </div>

  <div class="col-xl-12" style="margin-bottom:20px">

      <a href="admin.php?id=addpusage"><button type="submit" class="btn  btn-danger" style="float:right;">Go Back</button></a>

  </div>









  <div class="col-sm-12">
      <div class="card">

          <div class="card-body">
              <h4 style="color:#3399FF">Add Product Wastage</h4>





              <form name="form1" method="post" action="" enctype="multipart/form-data">
                  <div class="row">
                      <div class="col-md-12">

                          <div class="col-6 mt-2">
                              <label for="cc-exp" class="control-label mb-1">Batch </label>
                              <div class="input-group">
                                  <input type="text" class="form-control" value="<?php echo $rowt['batchcode']; ?>" readonly />

                              </div>
                          </div>



                          <div class="col-6 mt-3">
                              <label for="cc-exp" class="control-label mb-1"> Total Quantity (In Kg) </label>
                              <div class="input-group">
                                  <input type="number" name="tqty" id="udate" class="form-control" value="<?php echo $rowt['quantity']; ?>" readonly />

                              </div>
                          </div>



                          <div class="col-6 mt-3">
                              <label for="cc-exp" class="control-label mb-1"> Enter Wastage Quantity (In KG)</label>
                              <div class="input-group">



                                  <input type="number" name="qty" class="form-control" id="wqty" placeholder="Enter in kg" step="0.001" required />
                              </div>
                          </div>

                          <div class="col-6">
                              <label for="cc-exp" class="control-label mb-1"></label>
                              <div class="input-group">

                                  <button class="btn btn-info" type="submit" name="submit">Add Wastage</button>
                              </div>
                          </div>
                          <br />

                      </div>
              </form>
          </div>
      </div>
  </div>

  <?php

    if (isset($_POST['submit'])) {
        $tqty = $_POST['tqty'];

        $waste = $_POST['qty'];

        $leftqty = $tqty - $waste;

        $qury = mysqli_query($con, "UPDATE `tblpusage` SET `qtyleft`='$leftqty',`wastage`='$waste' WHERE id='$sno'");
        if ($qury) {

    ?>
          <script language="javascript">
              window.open('admin.php?id=potatousage', '_self')
          </script>
  <?php
        }
    }
    ?>