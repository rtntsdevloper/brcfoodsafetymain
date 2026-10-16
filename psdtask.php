<?php
$sno = 15;

if (isset($_GET['year'])) {
    $taskyear = $_GET['year'];
} else {
    $taskyear = date('Y');
}
if (isset($_GET['month'])) {
    $taskmonth = $_GET['month'];
} else {
    $taskmonth = date('m');
}

$tmonth = $taskmonth . '-' . $taskyear;






$sqli = mysqli_query($pcon, "SELECT *
FROM tbltask
WHERE customer = '$sno'
   AND DATE_FORMAT(tdate, '%m-%Y') = '$tmonth';
");
$total = mysqli_num_rows($sqli);

if ($total <= 0) {
    $new1 = 0;
    $new = 0;
    $progress1 = 0;
    $progress = 0;
    $notstart1 = 0;
    $notstart = 0;
    $done1 = 0;
    $done = 0;
} else {

    $sql2 = mysqli_query($pcon, "select * from tbltask where status='In Progress'  and customer='$sno' AND DATE_FORMAT(tdate, '%m-%Y') = '$tmonth' ");
    $progress = mysqli_num_rows($sql2);
    $progress1 = round($progress / $total * 100);


    $sql3 = mysqli_query($pcon, "SELECT * FROM tbltask WHERE (status = 'Not Started' OR status = 'Not Assign' OR status = 'New') AND customer = '$sno'AND DATE_FORMAT(tdate, '%m-%Y') = '$tmonth'; ");
    $notstart = mysqli_num_rows($sql3);
    $notstart1 = round($notstart / $total * 100);

    $sql4 = mysqli_query($pcon, "select * from tbltask where status='Done'  and customer='$sno' AND DATE_FORMAT(tdate, '%m-%Y') = '$tmonth'");
    $done = mysqli_num_rows($sql4);
    $done1 = round($done / $total * 100);
}


?>

<div class="main-content">
    <div class="breadcrumb">

        <ul>
            <li><a href="">Home</a></li>
            <li>Task Management</li>
        </ul>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <div class="container-fluid ">
                <div class="form-row">

                    <div class="form-group col-md-4 col-sm-12">
                        <label for="inputEmail4" class="fs-2">Select Month</label>

                        <select id="month" class="form-control">
                            <option value="01" <?php if ($taskmonth == '01') echo "selected"; ?>>January</option>
                            <option value="02" <?php if ($taskmonth == '02') echo "selected"; ?>>February</option>
                            <option value="03" <?php if ($taskmonth == '03') echo "selected"; ?>>March</option>
                            <option value="04" <?php if ($taskmonth == '04') echo "selected"; ?>>April</option>
                            <option value="05" <?php if ($taskmonth == '05') echo "selected"; ?>>May</option>
                            <option value="06" <?php if ($taskmonth == '06') echo "selected"; ?>>June</option>
                            <option value="07" <?php if ($taskmonth == '07') echo "selected"; ?>>July</option>
                            <option value="08" <?php if ($taskmonth == '08') echo "selected"; ?>>August</option>
                            <option value="09" <?php if ($taskmonth == '09') echo "selected"; ?>>September</option>
                            <option value="10" <?php if ($taskmonth == '10') echo "selected"; ?>>October</option>
                            <option value="11" <?php if ($taskmonth == '11') echo "selected"; ?>>November</option>
                            <option value="12" <?php if ($taskmonth == '12') echo "selected"; ?>>December</option>
                        </select>

                    </div>

                    <div class="form-group col-md-4 col-sm-12">
                        <label for="inputPassword4">Select Year</label>
                        <select id="year" name="month" class="form-control">
                            <option value="<?php echo $taskyear; ?>"><?php echo $taskyear; ?></option>
                            <?php
                            $yr = "SELECT DISTINCT YEAR(tdate) AS year FROM tbltask ORDER BY year";
                            $yr1 = mysqli_query($pcon, $yr);
                            foreach ($yr1 as $ydata) {
                            ?>
                                <option value="<?php echo $ydata['year']; ?>"><?php echo $ydata['year']; ?></option>
                            <?php
                            }

                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-4 col-sm-6">
                        <button type="button" class="btn btn-primary px-5 mt-4" onclick="getdata()"> <i class="fa fa-search"></i> Search</button>
                    </div>

                </div>
            </div>

        </div>
    </div>
    <script>
        function getdata() {
            const month = document.getElementById('month').value;
            const year = document.getElementById('year').value;

            window.open("admin.php?id=psdtaskview&year=" + year + "&month=" + month, '_self');

        }
    </script>

    <div class="card">

        <div class="card-header d-flex justify-content-between bg-white">
            <div class="header-title">
                <h4 class="card-title">Overview Progress</h4>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="row">
                <div class="col-md-6 col-lg-3 ">
                    <div class="card card-block card-stretch card-height pb-2">
                        <div class="card-body">
                            <div class="top-block d-flex align-items-center justify-content-between">
                                <h5>Total Task</h5>
                                <span class="badge badge-primary">Total</span>
                            </div>
                            <br>
                            <h3><?php echo $total; ?></h3>


                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card card-block card-stretch card-height">
                        <div class="card-body">
                            <div class="top-block d-flex align-items-center justify-content-between">
                                <h5>In Progress</h5>
                                <span class="badge badge-warning">In Progress</span>
                            </div>
                            <h3><span class="counter"><?php echo $progress; ?></span></h3>
                            <div class="d-flex align-items-center justify-content-between mt-1">
                                <p class="mb-0">Total Progress</p>
                                <span class="text-warning"><?php echo $progress1; ?>%</span>
                            </div>
                            <div class="iq-progress-bar bg-warning-light mt-2">
                                <span class="bg-warning iq-progress progress-1" data-percent="<?php echo $progress1; ?>"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card card-block card-stretch card-height">
                        <div class="card-body">
                            <div class="top-block d-flex align-items-center justify-content-between">
                                <h5>Not Started</h5>
                                <span class="badge badge-danger">Not Started</span>
                            </div>
                            <h3><span class="counter"><?php echo $notstart; ?></span></h3>
                            <div class="d-flex align-items-center justify-content-between mt-1">
                                <p class="mb-0">Total Progress</p>
                                <span class="text-danger"><?php echo $notstart1; ?>%</span>
                            </div>
                            <div class="iq-progress-bar bg-danger-light mt-2">
                                <span class="bg-danger iq-progress progress-1" data-percent="<?php echo $notstart1; ?>"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card card-block card-stretch card-height">
                        <div class="card-body">
                            <div class="top-block d-flex align-items-center justify-content-between">
                                <h5>Completed</h5>
                                <span class="badge badge-success">Completed</span>
                            </div>
                            <h3><span class="counter"><?php echo $done; ?></span></h3>
                            <div class="d-flex align-items-center justify-content-between mt-1">
                                <p class="mb-0">Total Progress</p>
                                <span class="text-success"><?php echo $done1; ?>%</span>
                            </div>
                            <div class="iq-progress-bar bg-success-light mt-2">
                                <span class="bg-success iq-progress progress-1" data-percent="<?php echo $done1; ?>"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <div class="card-body mt-3">
            <h3>Tracker</h3>

            <br><br>
            <table class="table">
                <tr>
                    <th>S no.</th>
                    <th>Projects</th>
                    <th>Total Task</th>
                    <th>Task Pending</th>
                    <th>Task Completed</th>
                    <th>Progress By Task</th>
                </tr>
                <tbody class="table-group-divider">
                    <?php
                    $i = 1;
                    if (isset($_GET['catg']) && !empty($_GET['catg'])) {
                        $proj = $_GET['catg'];
                        $sq = mysqli_query($pcon, "select distinct project from tbltask where customer='15' AND DATE_FORMAT(tdate, '%m-%Y') = '$tmonth' and project ='$proj'");
                    } else {
                        $sq = mysqli_query($pcon, "select distinct project from tbltask where customer='15' AND DATE_FORMAT(tdate, '%m-%Y') = '$tmonth'  ");
                    }
                    while ($datarows = mysqli_fetch_array($sq)) {

                        $sq1 = mysqli_query($pcon, "select * from tblproject where id='$datarows[project]' ");
                        $rows1 = mysqli_fetch_array($sq1);

                        $tstotal = mysqli_query($pcon, "SELECT * from tbltask where  customer='$sno' and project='$datarows[project]' AND DATE_FORMAT(tdate, '%m-%Y') = '$tmonth'");
                        $tasktotal = mysqli_num_rows($tstotal);



                        // print_r("SELECT * FROM tbltask WHERE (status = 'Not Started' OR status='In Progress'  OR status = 'Not Assign' OR status = 'New') AND customer = '$sno' AND project='$datarows[project]");
                        $sqlpro = mysqli_query($pcon, "SELECT * FROM tbltask WHERE (status = 'Not Started' OR status='In Progress'  OR status = 'Not Assign' OR status = 'New') AND customer = '$sno' AND project='$datarows[project]' AND DATE_FORMAT(tdate, '%m-%Y') = '$tmonth'");
                        $tprogress = mysqli_num_rows($sqlpro);

                        $sqldone = mysqli_query($pcon, "SELECT * from tbltask where status='Done' AND customer = '$sno' AND project='$datarows[project]' AND DATE_FORMAT(tdate, '%m-%Y') = '$tmonth'");
                        $tdone = mysqli_num_rows($sqldone);
                        if ($tdone > 0) {
                            $rdone1 = round($tdone / $tasktotal * 100);
                        } else {
                            $rdone1 = 0;
                        }


                    ?>

                        <tr>
                            <th><?php echo $i; ?></th>
                            <th><?php echo $rows1['name']; ?></th>
                            <th class="text-primary"><?php echo $tasktotal; ?></th>
                            <th class="text-warning"><?php echo $tprogress; ?></th>
                            <th class="text-success"><?php echo $tdone; ?></th>
                            <th>
                                <div class="progress mt-3">
                                    <div class="progress-bar bg-info <?php if ($rdone1 == 0) {
                                                                            echo "text-info";
                                                                        } ?>" role="progressbar" style="width: <?php echo  $rdone1; ?>%" aria-valuenow="<?php echo $rdone1; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $rdone1; ?>%</div>
                                </div>
                            </th>
                        </tr>
                    <?php
                        $i++;
                    }
                    ?>
                </tbody>
            </table>



        </div>
    </div>
</div>


<div class="container-fluid " style="margin-top:50px;">
    <div class="row mb-12"></div>
    <div class="col-lg-12 mb-5">
        <div class="card text-left">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-11 col-sm-12">
                        <h2 class="mb-5 ml-3 text-primary d-inline">Task Management</h3>
                    </div>
                   
                    <div class="col-md-1 col-sm-6"> <a href="admin.php?id=1"><button class="btn btn-success"
                                style="float:right; margin-left:15px">Go Back</button></a></div>
                </div>




                <div class="table-responsive mt-3">
                    <table class="display table table-striped table-bordered " id="zero_configuration_table"
                        style="width:100%">
                        <thead>
                            <tr class="ligth">
                                <th></th>
                                <th>Assigned On</th>
                                <th>Customer</th>
                                <!-- <th>Task Allocated By</th> -->
                                <!-- <th>Assigned To</th> -->
                                <th>Title</th>
                                <th>Due Date</th>

                                <th>Priority</th>
                                <!-- <th>Est.Hours</th> -->
                                <th> Last Updated on</th>
                                <th>Status</th>
                                <th>Completion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php


                            $sql = mysqli_query($pcon, "SELECT * FROM `tbltask` WHERE customer =15 AND DATE_FORMAT(tdate, '%m-%Y') = '$tmonth' order by tdate DESC ");

                            $i = 0;
                            while ($row = mysqli_fetch_array($sql)) {
                                $i++;

                                $sql1 = mysqli_query($pcon, "select * from tblcustomer where  id='$row[customer]'");
                                $row1 = mysqli_fetch_array($sql1);

                                $sql2 = mysqli_query($pcon, "select * from tbllogin where  id='$row[assignto]'");
                                $row2 = mysqli_fetch_array($sql2);


                                $datetime1 = new DateTime(date('Y-m-d'));
                                $datetime2 = new DateTime(date('Y-m-d', strtotime($row['tdate'])));
                                $interval = $datetime1->diff($datetime2);
                                $interval->format('%a');
                                $k = $interval->format('%a');


                                $datetime3 = strtotime($row['startdate']);
                                $datetime4 = strtotime($row['enddate']);

                                $secs = $datetime4 - $datetime3; // == <seconds between the two times>
                                // $days = round($secs / 86400, 0);
                                $days = round($secs / (8 * 3600), 0);


                            ?>
                                <tr>
                                    <td><?php echo $i; ?> </td>
                                    <td><?php echo date('d-m-Y', strtotime($row['tdate'])); ?></td>
                                    <td> <a href="#" class='modalButton' data-target="#new-task-modal1" data-toggle="modal" data-qid='<?php echo $row['id']; ?>'>
                                            <?php echo $row1['name']; ?></a></td>
                                    <!-- <td><?php echo $row['assignfrom']; ?></td>
                                         <td><?php if (isset($row2['name'])) {
                                                    echo $row2['name'];
                                                } ?></td> -->
                                    <td><?php echo $row['title']; ?></td>
                                    <td><?php echo date('d-m-Y', strtotime($row['enddate'])); ?></td>

                                    <td>
                                        <?php
                                        if ($row['ptype'] == "Low") {
                                        ?>
                                            <button type="button" class="btn btn-success rounded-pill mt-2" style="padding: 5px 23px;"><?php echo $row['ptype']; ?></button>
                                        <?php
                                        } else if ($row['ptype'] == "Medium") {
                                        ?>
                                            <button type="button" class="btn btn-warning rounded-pill mt-2"><?php echo $row['ptype']; ?></button>
                                        <?php
                                        } else  if ($row['ptype'] == "High") {
                                        ?>
                                            <button type="button" class="btn btn-danger rounded-pill mt-2" style="padding: 5px 21px;"><?php echo $row['ptype']; ?></button>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                    <!-- <td><?php echo $days; ?> hrs</td> -->
                                    <!-- <td>Updated <?php if ($k < 365) {
                                                            echo $k . " days";
                                                        } else {
                                                            $p = $k / 365;
                                                            $p1 = floor($p);

                                                            $p2 = $k % 365;

                                                            if ($p2 == 0) {
                                                                echo $p1 . " years";
                                                            } else {
                                                                echo $p1 . " years " . $p2 . " days";
                                                            }
                                                        }; ?> ago</td> -->

                                    <td>
                                        <?php echo date('d-m-Y', strtotime($row['updateon'])) ?>
                                    </td>
                                    <td>
                                        <?php if ($row['status'] == 'In Progress') {
                                        ?>
                                            <button type="button" class="btn btn-outline-warning btn-white rounded-pill mt-2">
                                                <?php echo $row['status']; ?>
                                            </button>

                                        <?php
                                        } elseif ($row['status'] == 'Done') {
                                        ?>
                                            <button type="button" class="btn btn-outline-success btn-white rounded-pill mt-2 " style="padding: 5px 28px;">
                                                <?php echo $row['status']; ?>
                                            </button>
                                        <?php
                                        } elseif ($row['status'] == 'New') {
                                        ?>
                                            <button type="button" class="btn  btn-outline-primary  rounded-pill mt-2" style="padding: 5px 32px;">
                                                <?php echo $row['status']; ?>
                                            </button>

                                        <?php
                                        } else {
                                        ?>
                                            <button type="button" class="btn btn-outline-danger btn-white rounded-pill mt-2">
                                                <?php echo $row['status']; ?>
                                            </button>

                                        <?php
                                        }
                                        ?>


                                    </td>
                                    <td>
                                        <?php
                                        if ($row['status'] == 'Done') {
                                        ?>
                                            <div class="progress mt-3">
                                                <div class="progress-bar bg-success " role="progressbar" style="width: <?php echo $row['progress']; ?>%" aria-valuenow="<?php echo $row['progress']; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $row['progress']; ?>%</div>
                                            </div>
                                        <?php
                                        } elseif ($row['status'] == 'In Progress') {
                                        ?>
                                            <div class="progress mt-3">
                                                <div class="progress-bar bg-warning text-dark" role="progressbar" style="width: <?php echo $row['progress']; ?>%" aria-valuenow="<?php echo $row['progress']; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $row['progress']; ?>%</div>
                                            </div>
                                        <?php
                                        } else {
                                            echo $row['progress'] . "%";
                                        } ?>




                                    </td>
                                </tr>




                            <?php
                            }
                            ?>
                            </tfoot>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
</div>