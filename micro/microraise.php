<?php
$mid = $_GET['mid'];

// Fetch current record so we can copy its columns into the new month row
$currentQ = mysqli_query($con, "SELECT * FROM `tbl_microtrending` WHERE id='$mid'");
$currentRow = mysqli_fetch_assoc($currentQ);
?>

<div class="container-fluid">

  <div class="main-content">
    <div class="breadcrumb">
      <h1 class="mr-2"><?php echo $headingname; ?></h1>
      <ul>
        <li><a href="">Micro Trending</a></li>
        <li>Justification</li>
      </ul>
    </div>

    <div class="container-fluid">

      <div class="col-md-12 mt-5 mb-5">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="card-title">Add Justification</div>
              </div>
              <div class="col-md-6">
                <a href="admin.php?id=microtrending" class="btn btn-success" style="float: right;">Go Back</a>
              </div>
            </div>

            <form id="justificationForm" method="post">

              <!-- Row 1: Date & Time + Reason Category -->
              <div class="form-row">
                <div class="form-col col-md-6">
                  <label class="form-label">Date &amp; Time <span class="required">*</span></label>
                  <input type="datetime-local" class="form-control" name="dtime" required>
                </div>

                <div class="form-col col-md-6">
                  <label class="form-label">Reason Category <span class="required">*</span></label>
                  <select class="form-control" id="reasonSelect" name="category" required>
                    <option value="" disabled selected>Select Reason</option>
                    <option value="equipment not in use">Equipment/Machine Not In Use</option>
                    <option value="no production">No Production</option>
                    <option value="missed testing">Missed Testing</option>
                    <option value="others">Others</option>
                  </select>
                </div>
              </div>
              <!-- Conditional section -->
              <div id="conditionalSection" class="conditional-section" style="display: none;">
                <hr style="border:none; border-top:1px solid #e6ebf0; margin: 8px 0 22px;">

                <div class="form-row">
                  <div class="form-col col-md-6">
                    <label class="form-label">Corrective Action</label>
                    <textarea class="form-control" rows="2" name="caction"
                      placeholder="Describe the corrective action taken or planned..."></textarea>
                  </div>

                  <div class="form-col col-md-6">
                    <label class="form-label">RCA (Root Cause Analysis)</label>
                    <textarea class="form-control" rows="2" name="rca"
                      placeholder="Enter root cause analysis findings..."></textarea>
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-col col-md-12">
                    <label class="form-label">Preventive Action</label>
                    <textarea class="form-control" rows="2" name="paction"
                      placeholder="Describe preventive measures to avoid recurrence..."></textarea>
                  </div>
                </div>
              </div>

              <!-- Row 2: Any other reason -->
              <div class="form-row">
                <div class="form-col col-md-12">
                  <label class="form-label">Any Other Reason / Details</label>
                  <textarea class="form-control" rows="3" name="reason"
                    placeholder="Describe any additional context or reason..."></textarea>
                </div>
              </div>
              <hr>
              <div class="form-row">
                <div class="col-md-6">
                  <div class="form-row">
                    <div class="form-col col-md-12">
                      <label class="form-label">Will micro testing be required in the upcoming months?</label>
                      <select class="form-control" name="upcoming" required onchange="toggleUpcoming(this.value)">
                        <option value="">Select Option</option>
                        <option value="Yes">Yes</option>
                        <option value="N/A">N/A</option>

                      </select>
                    </div>
                  </div>
                </div>
              </div>

              <script>
                function toggleUpcoming(value) {
                  if (value === 'Yes') {
                    document.getElementById('nextpid').classList.remove('d-none');
                  } else {
                    document.getElementById('nextpid').classList.add('d-none');
                  }
                }
              </script>
              <div class="form-row mt-3 d-none" id="nextpid">


                <div class="form-col col-md-6">
                  <label class="form-label">Next Testing Month</label>
                  <select class="form-control" name="nextmonth">
                    <option value="">Select Month</option>
                    <option value="01">January</option>
                    <option value="02">February</option>
                    <option value="03">March</option>
                    <option value="04">April</option>
                    <option value="05">May</option>
                    <option value="06">June</option>
                    <option value="07">July</option>
                    <option value="08">August</option>
                    <option value="09">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                  </select>
                </div>

                <div class="form-col col-md-6">
                  <label class="form-label">Next Testing Year</label>
                  <select class="form-control" name="nextyear">
                    <option value="">Select Year</option>
                    <?php
                    $currentYear = date('Y');
                    for ($i = $currentYear; $i <= $currentYear + 1; $i++) {
                      echo '<option value="' . $i . '">' . $i . '</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>



              <!-- Footer -->
              <div class="form-footer mt-2">
                <button type="submit" class="btn btn-primary" name="submit">Submit Report</button>
              </div>

            </form>
          </div>
        </div>
      </div>

      <script src="https://code.jquery.com/jquery-3.6.0.min.js">
      </script>

      <script>
        $(document).ready(function() {
          function toggleConditionalSection() {
            var selectedValue = $('#reasonSelect').val();
            if (selectedValue === 'missed testing' || selectedValue === 'others') {
              $('#conditionalSection').show();
            } else {
              $('#conditionalSection').hide();
            }
          }

          toggleConditionalSection();

          $('#reasonSelect').on('change', function() {
            toggleConditionalSection();
          });
        });
      </script>

      <?php
      if (isset($_POST['submit'])) {
        $dtime    = mysqli_real_escape_string($con, $_POST['dtime']);
        $category = mysqli_real_escape_string($con, $_POST['category']);
        $reason   = mysqli_real_escape_string($con, $_POST['reason']);
        $caction  = mysqli_real_escape_string($con, $_POST['caction']);
        $rca      = mysqli_real_escape_string($con, $_POST['rca']);
        $paction  = mysqli_real_escape_string($con, $_POST['paction']);
        $upcoming = mysqli_real_escape_string($con, $_POST['upcoming']);
        $nextmonth = mysqli_real_escape_string($con, $_POST['nextmonth']);
        $nextyear = mysqli_real_escape_string($con, $_POST['nextyear']);


        $inscon = mysqli_query($con, "UPDATE `tbl_microtrending` SET `status`='Justified' WHERE id='$mid'");



        $nxsid = $currentRow['sid'];
        $nxmid = $currentRow['mid'];
        $frequency = $currentRow['frequency'];

        if (!empty($nextmonth) && !empty($nextyear)) {
          $admonth = $nextyear . "-" . $nextmonth;
        } else {
          $admonth = "";
        }

        // 1) Insert justification row
        $insert = mysqli_query($con, "INSERT INTO `tbl_microtrending1`(`eid`, `attempt_on`, `user`, `status`, `category`, `reason`, `caction`, `paction`, `rca`,`remark`,`month`, `reportno`) VALUES ('$mid','$dtime','$user','Justified','$category','$reason','$caction','$paction','$rca','$upcoming','$admonth','Main')");
        $insertxid = mysqli_insert_id($con);



        $checkx = mysqli_query($con, "SELECT * FROM `tbl_microtrending` WHERE sid ='$nxsid' and admonth='$admonth'");

        $checkxn = mysqli_num_rows($checkx);
        if ($checkxn == 0  && $upcoming == 'Yes') {
          $checkqx = mysqli_query($con, "INSERT INTO `tbl_microtrending`(`sid`, `mid`, `month`, `assign_on`, `user`, `year`, `frequency`, `admonth`) VALUES ('$nxsid','$nxmid','$nextmonth','$dtime','$user','$nextyear','$frequency','$admonth')");
        }


        // 3) Redirect as before
        if ($insert) {
      ?>
          <script>
            window.location.href = "admin.php?id=microsign&mid=<?php echo $insertxid; ?>&mid1=<?php echo $mid; ?>";
          </script>
      <?php
        }
      }
      ?>