<div class="main-content">
  <div class="breadcrumb">
    <h1 class="mr-2"><?php echo $headingname; ?></h1>
    <ul>
      <li><a href="">Home</a></li>
      <li>Add Metal Detection Checks</li>
    </ul>
  </div>



  <div class="row mb-12">
    <div class="col-md-12 mb-12">
      <div class="card text-left">
        <div class="card-body">

          <a href="admin.php?id=metaldetect"> <button class="btn btn-info"
              style="float:right; margin-left:15px">Go Back</button></a>
          <h4 class="card-title mb-3">Daily Metal Detection Checks</h4>

          <form class="needs-validation" novalidate="novalidate" method="post" action="" enctype="multipart/form-data">

            <div class="form-row">
              <div class="col-md-4">
                <label for="validationTooltip01">Date/Time</label>
                <input class="form-control" id="validationTooltip01" type="datetime-local" required="required"
                  name="date" />
                <div class="invalid-tooltip">
                  Please fill the field.
                </div>
              </div>
              <div class="col-md-4">
                <label for="validationTooltip02">Select Product</label>
                <select class="form-control" name="pname" id="pnameSelect" required onchange="updateBatchCode()">
                  <option value="">Please Select</option>
                  <?php
                  $products = [];
                  $sqli = mysqli_query($con, "select * from tblflavourmix where metal !='done' order by date DESC");
                  while ($row = mysqli_fetch_array($sqli)) {
                    $products[$row['id']] = $row['batch'];
                    ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $row['productname']; ?></option>
                    <?php
                  }
                  ?>
                </select>
                <div class="invalid-tooltip">
                  Please fill the field.
                </div>
              </div>
              <div class="col-md-4">
                <label for="validationTooltip02">Product Batchcode</label>
                <input type="text" class="form-control" name="product" id="batchCodeInput" required readonly>
                <div class="invalid-tooltip">
                  Please fill the field.
                </div>
              </div>
              <script>
                // Map product IDs to batch codes
                var productBatchMap = <?php echo json_encode($products); ?>;
                function updateBatchCode() {
                  var productId = document.getElementById('pnameSelect').value;
                  document.getElementById('batchCodeInput').value = productBatchMap[productId] || '';
                }
              </script>
              <div class="col-md-4">
                <label for="validationTooltip02">Shift </label>

                <input type="test" class="form-control" name="shift" />
                <div class="invalid-tooltip">
                  Please fill the field.

                </div>
              </div>
              <div class="col-md-4">
                <label for="validationTooltip02">Supervisor / Manager </label>

                <input type="test" class="form-control" name="manager" />
                <div class="invalid-tooltip">
                  Please fill the field.

                </div>
              </div>
              <div class="col-md-4">
                <label for="validationTooltip02">Test Time</label>

                <input type="time" class="form-control" name="testtime" />
                <div class="invalid-tooltip">
                  Please fill the field.

                </div>
              </div>

              <div class="col-md-4">
                <label for="validationTooltip02">Test Type</label>
                <select class="form-control" id="testtype" required="required" name="testtype">
                  <option value="">Please Select</option>
                  <option value="Beginning">Start of Shift</option>
                  <option value="Beginning">Beginning of Shift</option>
                  <option value="Every Hour">Every Hour</option>

                  <option value="End of Shift">End of Shift</option>
                  <option value="End of Product">End of Product</option>

                </select>
                <div class="invalid-tooltip">
                  Please fill the field.
                </div>
              </div>
              <div class="col-md-12">
                <div class="row my-5">
                  <!-- Ferrous Section -->
                  <div class="col-md-4">
                    <fieldset class="border p-3 rounded">
                      <legend class="w-auto px-2">Ferrous</legend>

                      <div class="mb-3">
                        <label for="ferrousSize" class="form-label">Metal Size</label>
                        <input type="text" class="form-control" id="ferrousSize" name="metal1"  />
                        <div class="invalid-tooltip">Please fill the field.</div>
                      </div>

                      <div class="mb-3">
                        <label for="ferrousPass" class="form-label">Pass</label>
                        <select class="form-control" required="required" name="pass1">
                          <option value="">Please Select</option>
                          <option value="Yes">Yes</option>
                          <option value="No">No</option>
                        </select>





                        <!-- <input type="text" class="form-control" id="ferrousPass" name="pass1" required /> -->
                        <div class="invalid-tooltip">Please fill the field.</div>
                      </div>
                    </fieldset>
                  </div>

                  <!-- Non-Ferrous Section -->
                  <div class="col-md-4">
                    <fieldset class="border p-3 rounded">
                      <legend class="w-auto px-2">Non-Ferrous</legend>

                      <div class="mb-3">
                        <label for="nonFerrousSize" class="form-label">Metal Size</label>
                        <input type="text" class="form-control" id="nonFerrousSize" name="metal2"  />
                        <div class="invalid-tooltip">Please fill the field.</div>
                      </div>

                      <div class="mb-3">
                        <label for="nonFerrousPass" class="form-label">Pass</label>
                          <select class="form-control"  required="required" name="pass2">
                          <option value="">Please Select</option>
                          <option value="Yes">Yes</option>
                          <option value="No">No</option>
                        </select>
                        <div class="invalid-tooltip">Please fill the field.</div>
                      </div>
                    </fieldset>
                  </div>

                  <!-- Stainless Steel Section -->

                  <div class="col-md-4">
                    <fieldset class="border p-3 rounded">
                      <legend class="w-auto px-2">Stainless Steel</legend>

                      <div class="mb-3">
                        <label for="stainlessSize" class="form-label">Metal Size</label>
                        <input type="text" class="form-control" id="stainlessSize" name="metal3"  />
                        <div class="invalid-tooltip">Please fill the field.</div>
                      </div>

                      <div class="mb-3">
                        <label for="stainlessPass" class="form-label">Pass</label>
                          <select class="form-control"  required="required" name="pass3">
                          <option value="">Please Select</option>
                          <option value="Yes">Yes</option>
                          <option value="No">No</option>
                        </select>
                        <div class="invalid-tooltip">Please fill the field.</div>
                      </div>
                    </fieldset>
                  </div>
                </div>

              </div>






              <div class="col-md-6">
                <label for="validationTooltip02">Comments </label>
                <textarea class="form-control" name="cmnt" required></textarea>
                <div class="invalid-tooltip">
                  Please fill the field.
                </div>
              </div>


              <div class="col-md-6">
                <label for="validationTooltip02">Checked By</label>
                <input class="form-control" id="name" name="user" required>
                <div class="invalid-tooltip">
                  Please fill the field.
                </div>
              </div>


            </div>







            <br />


            <br />
            <button class="btn btn-primary" type="submit" name="submit">Submit </button>
          </form>
        </div>


      </div>
    </div>
  </div>
</div>
<?php
if (isset($_POST['submit'])) {
  $date = $_POST['date'];
  $pname = $_POST['pname'];
  $product = $_POST['product'];
  $pname = $_POST['pname'];

  $testtime = $_POST['testtime'];
  $testtype = $_POST['testtype'];
  $shift = $_POST['shift'];
  $cmnt = $_POST['cmnt'];
  $manager = $_POST['manager'];


  $metal1 = $_POST['metal1'];
  $metal2 = $_POST['metal2'];
  $metal3 = $_POST['metal3'];
  $size1 = $_POST['pass1'];
  $size2 = $_POST['pass2'];
  $size3 = $_POST['pass3'];



  $user = $_POST['user'];

// print_r("update tblflavourmix set metal='done' where batchcode='$product'");die;
  // print_r( "INSERT INTO tblmetal (datetime,pname,productbatch,testtime,testtype,cmnt,user,metal1,metal2,metal3,pass1,pass2,pass3) VALUES ('$date', '$pname','$product','$testtime','$testtype','$cmnt','$user','$metal1','$metal2','$metal3','$size1','$size2','$size3')");
  $sql = mysqli_query($con, "INSERT INTO tblmetaldetect (datetime,pname,productbatch,testtime,testtype,cmnt,user,metal1,metal2,metal3,pass1,pass2,pass3,shift,cmnt1) VALUES ('$date', '$pname','$product','$testtime','$testtype','$cmnt','$user','$metal1','$metal2','$metal3','$size1','$size2','$size3','$shift','$manager')");

  $sql1 = mysqli_query($con, "update tblflavourmix set metal='done' where batch='$product'");
  ?>
  <script language="javascript">
    window.open('admin.php?id=metaldate', '_self');
  </script>
  <?php
}
?>