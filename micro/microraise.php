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

              <!-- Row 2: Any other reason -->
              <div class="form-row">
                <div class="form-col col-md-12">
                  <label class="form-label">Any Other Reason / Details</label>
                  <textarea class="form-control" rows="3" name="reason"
                    placeholder="Describe any additional context or reason..."></textarea>
                </div>
              </div>

              <div class="form-row">
                <div class="col-md-6">
                  <div class="form-row">
                    <div class="form-col col-md-12">
                      <label class="form-label">Frequency</label>
                      <input class="form-control" name="freq" placeholder="Type Frequency">
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-row">
                    <div class="form-col col-md-12">
                      <label class="form-label">Location</label>
                      <input class="form-control" name="location" placeholder="Type Location Here">
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-row">
                    <div class="form-col col-md-12">
                      <label class="form-label">Next Testing Month</label>
                      <select class="form-control" name="nextmonth">
                        <option value="">Select Month</option>
                        <option value="January">January</option>
                        <option value="February">February</option>
                        <option value="March">March</option>
                        <option value="April">April</option>
                        <option value="May">May</option>
                        <option value="June">June</option>
                        <option value="July">July</option>
                        <option value="August">August</option>
                        <option value="September">September</option>
                        <option value="October">October</option>
                        <option value="November">November</option>
                        <option value="December">December</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-row">
                    <div class="form-col col-md-12">
                      <label class="form-label">Next Testing Date</label>
                      <input class="form-control" name="nextdate" type="date" placeholder="Next Testing Date">
                    </div>
                  </div>
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
        $(document).ready(function () {
          function toggleConditionalSection() {
            var selectedValue = $('#reasonSelect').val();
            if (selectedValue === 'missed testing' || selectedValue === 'others') {
              $('#conditionalSection').show();
            } else {
              $('#conditionalSection').hide();
            }
          }

          toggleConditionalSection();

          $('#reasonSelect').on('change', function () {
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

        // 1) Insert justification row
        $insert = mysqli_query($con, "INSERT INTO `tbl_microtrending1`(`eid`, `attempt_on`, `user`, `status`, `category`, `reason`, `caction`, `paction`, `rca`) VALUES ('$mid','$dtime','$user','Justified','$category','$reason','$caction','$paction','$rca')");
        $insertxid = mysqli_insert_id($con);

        // 2) If user picked a Next Testing Month → create a new row in tbl_microtrending
        $nextMonth = isset($_POST['nextmonth']) ? trim($_POST['nextmonth']) : '';
        $nextDate  = isset($_POST['nextdate'])  ? trim($_POST['nextdate'])  : '';

        if (!empty($nextMonth)) {
          // Convert month name → number
          $monthNum   = date('m', strtotime($nextMonth));  // "July" → "07"
          $yearNow    = date('Y');
          $newAdmonth = $yearNow . '-' . $monthNum;        // "2026-07"
          $monthValue = (int)$monthNum;                    // "07" → 7 (for the `month` column)

          // Copy fields from the current row
          $sid   = mysqli_real_escape_string($con, $currentRow['sid']);
          $midx  = mysqli_real_escape_string($con, $currentRow['mid']);
          $userx = mysqli_real_escape_string($con, $currentRow['user']);
          $yearx = mysqli_real_escape_string($con, $currentRow['year']);
          $freqx = mysqli_real_escape_string($con, $currentRow['frequency']);

          // Insert new month row with `month` and `admonth` both set
          // print_r("INSERT INTO `tbl_microtrending`
          //     (`sid`, `mid`, `user`, `admonth`, `month`, `status`, `fstatus`, `year`, `frequency`)
          //     VALUES ('$sid', '$midx', '$userx', '$newAdmonth', '$monthValue', '', '', '$yearx', '$freqx')");die;
          mysqli_query($con, "INSERT INTO `tbl_microtrending`
              (`sid`, `mid`, `user`, `admonth`, `month`, `status`, `fstatus`, `year`, `frequency`)
              VALUES ('$sid', '$midx', '$userx', '$newAdmonth', '$monthValue', '', '', '$yearx', '$freqx')");
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