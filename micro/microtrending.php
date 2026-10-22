  <?php

    $cyear = date("Y");


    if (isset($_GET['year'])) {

        $yr = $_GET['year'];


        if ($yr == $cyear) {
            $date = $yr . "-" . date("m") . "-01";
        } else {
            $date = $yr . "-01-01";
        }
    } else {
        $yr = date("Y");
        $date = $yr . "-" . date("m") . "-01";
    }
    $year = date("Y", strtotime($date));



    $pre = $yr - 1;
    $nxt = $yr + 1;




    ?>

  <script src="assets/style.css"></script>

  <div class="main-content">
      <div class="breadcrumb">
          <h1 class="mr-2"><?php echo $headingname; ?></h1>
          <ul>
              <li><a href="">Micro Trending Dashboard</a></li>
              <li>Detail</li>
          </ul>
      </div>

      <div class="col-md-12">
          <div class="card text-left">
              <div class="card-body">
                  <div class="row">
                      <div class="col-md-12">
                          <a href="admin.php?id=1">
                              <button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button>
                          </a> <a href="admin.php?id=microtrend">
                              <button class="btn btn-info" style="float:right; margin-left:15px">Trending</button>
                          </a>



                          <a href="admin.php?id=microtrending&year=<?php echo $nxt; ?>">
                              <button class="btn btn-danger" style="float:right; margin-left:15px">Next Year</button>
                          </a>
                          <a href="admin.php?id=microtrending&year=<?php echo $pre; ?>">
                              <button class="btn btn-danger" style="float:right; margin-left:15px">Previous Year</button>
                          </a>


                          <h4 class="card-title mb-2">Micro Trending</h4>
                      </div>
                  </div>


                  <div class="row" width="100%">
                      <link rel="stylesheet" href="assets/style.css">
                      <!-- partial:index.partial.html -->

                      <div class="row justify-content-center align-items-center" style="margin-top:20px">
                          <!-- DISPLAY USER SCHEDULER-->
                          <div class="table-responsive">
                              <div id="calplaceholder">
                                  <div class="cal-sectionDiv">
                                      <div class="col-md-12">
                                          <table class="table table-striped table-bordered" width="100%">
                                              <thead class="cal-thead">
                                                  <tr>
                                                      <th class="cal-viewmonth" id="changemonth">Year <?php echo $year; ?></th>
                                                      <th class="cal-toprow">Jan</th>
                                                      <th class="cal-toprow">Feb</th>
                                                      <th class="cal-toprow">Mar</th>
                                                      <th class="cal-toprow weekend">Apr</th>
                                                      <th class="cal-toprow weekend">May</th>
                                                      <th class="cal-toprow">June</th>
                                                      <th class="cal-toprow">July</th>
                                                      <th class="cal-toprow">Aug</th>
                                                      <th class="cal-toprow">Sep</th>
                                                      <th class="cal-toprow">Oct</th>
                                                      <th class="cal-toprow weekend">Nov</th>
                                                      <th class="cal-toprow weekend">Dec</th>
                                                  </tr>
                                              </thead>
                                              <tbody class="cal-tbody">
                                                  <?php

                                                    $sql = mysqli_query($con, "select * from tbl_micortrend");
                                                    $ik = 0;
                                                    while ($row = mysqli_fetch_array($sql)) {
                                                        $ik++;
                                                    ?>

                                                      <tr id="h16">
                                                          <td class="cal-usersheader" style="color:#fff; background-color:<?php echo "#389fe8"; ?>; padding: 0px;"><?php echo $ik; ?></td>
                                                          <td colspan="31" style="color:#FFFFFF; background-color:<?php echo "#389fe8"; ?>;"><?php echo $row['name']; ?></td>
                                                      </tr>

                                                      
                                                      <?php
                                                        $sql1 = mysqli_query($con, "select * from tbl_micortrend1 where sid='$row[id]'");
                                                        while ($row1 = mysqli_fetch_array($sql1)) {
                                                        ?>
                                                          <tr id="u1">
                                                              <td class="cal-userinfo">
                                                                  <span>
                                                                      <b>
                                                                          <?php

                                                                            echo $row1['name']." (".$row1['sampleno'].")";
                                                                            echo '<br>';
                                                                            echo 'Location: '.$row['name'].' ';
                                                                            ?>
                                                                      </b>
                                                                  </span>

                                                              </td>
                                                              <?php
                                                                for ($m = 01; $m <= 12; ++$m) {
                                                                    if ($m >= 1 && $m <= 9) {
                                                                        $mx = "0" . $m;
                                                                    } else {
                                                                        $mx = $m;
                                                                    }
                                                                ?>

                                                                  <td class="ui-droppable" data-date="1/7/2020" data-userid="1">

                                                                      <?php


                                                                        $tmonth = $yr . "-" . $mx;

                                                                        $tcheck = mysqli_query($con, "SELECT * FROM `tbl_microtrending` WHERE sid='$row1[id]' and mid='$row[id]' and admonth='$tmonth'");
                                                                        $tcheck1 = mysqli_num_rows($tcheck);
                                                                        if ($tcheck1 > 0) {

                                                                           while($tcheckq = mysqli_fetch_array($tcheck)){
                                                                            if ($tcheckq['month'] == $mx) {

                                                                           

                                                                                $tcheck1 = mysqli_num_rows($tcheck);
                                                                                $match1 = $tcheck1;



                                                                        ?>
                                                                              <?php



                                                                                if (empty($tcheckq['status'])) {

                                                                                    //in ptorgress
                                                                                    $cmonth = date('Y-m');
                                                                                    if ($cmonth > $tmonth) {
                                                                                        $colord = "#C10000";
                                                                                        $txtd = "Over Due";
                                                                                    } else {
                                                                                        $colord = "#FFCC00";
                                                                                        $txtd = "Pending";
                                                                                    }
                                                                                ?>

                                                                                  <div class="drag details ui-draggable ui-draggable-handle" data-taskid="13956" data-userid="1" style="border-left:5px solid <?php echo $colord; ?>;position:relative;">
                                                                                      <h2 class="details-task" style="background:<?php echo $colord; ?>; color: #FFF"><?php echo $txtd; ?></h3>
                                                                                          <div class="details-uren">
                                                                                              <a href="admin.php?id=microtattempt&mid=<?php echo $tcheckq['id']; ?>">Upload</a>
                                                                                          </div>
                                                                                  </div>
                                                                              <?php
                                                                                } else {
                                                                                    //in waiting
                                                                                    if ($tcheckq['status'] == 'Pass' ||($tcheckq['status'] == 'Fail' && $tcheckq['fstatus'] == 'No')) {
                                                                                        $color = "#136207";
                                                                                        $txt = "Done";
                                                                                        $bg = "36, 115, 171";
                                                                                    } else if ($tcheckq['status'] == 'Fail') {
                                                                                        $color = "#EE204D";
                                                                                        $txt = "Retest Pending";
                                                                                        $bg = "193,0,0";
                                                                                    }

                                                                                ?>

                                                                                  <div class="drag details ui-draggable ui-draggable-handle" data-taskid="13956" data-userid="1" style="border-left:5px solid rgb(<?php echo $bg; ?>);position:relative;">
                                                                                      <h2 class="details-task" style="background:<?php echo $color; ?>; color: #FFF"><?php echo $txt; ?></h3>
                                                                                          <div class="details-uren">
                                                                                              <a href="admin.php?id=microtrendingview&mid=<?php echo $tcheckq['id']; ?>"> View </a>
                                                                                          </div>
                                                                                  </div>
                                                                          <?php
                                                                                }
                                                                            }
                                                                           }
                                                                            ?>


                                                                  </td>
                                                          <?php
                                                                        }
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
                              </div>



                              <script src="assets/script.js"></script>


                          </div>
                      </div>
                  </div>
              </div>
          </div>