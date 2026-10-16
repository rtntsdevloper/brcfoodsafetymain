<?php
if (isset($_GET['year'])) {
    $yr = $_GET['year'];
    $date = $yr . "-" . date("m") . "-01";
} else {
    $yr = date("Y");
    $date = $yr . "-" . date("m") . "-01";
}
$year = date("Y", strtotime($date));

$pre = $yr - 1;
$nxt = $yr + 1;

// Get current date for comparison
$current_date = date('Y-m-d');
?>

<script src="assets/style.css"></script>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Corrective Maintaince</a></li>
            <li>Detail</li>
        </ul>
    </div>

    <div class="col-md-12">
        <div class="card text-left">
            <div class="card-body">

                <a href="admin.php?id=1">
                    <button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button>
                </a>

                <a href="admin.php?id=ppmraise">
                    <button class="btn btn-primary" style="float:right; margin-left:15px">Raise Request</button>
                </a>
                <a href="admin.php?id=ppmtrendings">
                    <button class="btn btn-info" style="float:right; margin-left:15px">Trending</button>
                </a>
                <a href="admin.php?id=ppm&year=<?php echo $nxt; ?>">
                    <button class="btn btn-danger" style="float:right; margin-left:15px">Next Year</button>
                </a>
                <a href="admin.php?id=ppm&year=<?php echo $pre; ?>">
                    <button class="btn btn-danger" style="float:right; margin-left:15px">Previous Year</button>
                </a>

                <h4 class="card-title mb-2">Details</h4>
                <div class="row">
                    <link rel="stylesheet" href="assets/style.css">

                    <div class="row justify-content-center align-items-center" style="margin-top:20px">
                        <div class="table-responsive">
                            <div data-parse="1595877840000" id="calplaceholder">
                                <div class="cal-sectionDiv">
                                    <table class="table table-striped table-bordered">
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
                                            $sql = mysqli_query($con, "select * from tblequipment where ppmap='Yes' and status='Active'");
                                            $sno=1;
                                            while($row = mysqli_fetch_array($sql)){
                                            ?>
                                                <tr id="h16">
                                                    <td class="cal-usersheader" style="color:#fff; background-color:<?php echo $row['bgcolor']; ?>; padding: 0px;"><?php echo $sno++; ?></td>
                                                    <td colspan="31" style="color:#FFFFFF; background-color:<?php echo $row['bgcolor']; ?>;"><?php echo $row['name']; ?></td>
                                                </tr>

                                                <?php
                                                $sql1 = mysqli_query($con, "select * from tblequipment1 where eid='$row[id]' and year(date)='$year'");
                                                $i = 0;
                                                while ($row1 = mysqli_fetch_array($sql1)) {
                                                    $i++;
                                                ?>
                                                    <tr id="u1">
                                                        <td class="cal-userinfo">
                                                            <span>
                                                                <b style="text-decoration: underline"></b>
                                                                <span></span>
                                                            </span>
                                                            <div class="cal-usercounter">
                                                                <span class="cal-userbadge badge badge-light"></span>
                                                            </div>
                                                            <div class="cal-userarrows">
                                                                <i class="up mdi mdi-arrow-up-bold"></i>
                                                                <i class="down mdi mdi-arrow-down-bold"></i>
                                                            </div>
                                                        </td>

                                                        <?php
                                                        // FIXED: Month loop - don't modify $m inside the loop
                                                        for ($m = 1; $m <= 12; $m++) {
                                                            // Format month with leading zero
                                                            $month_padded = str_pad($m, 2, '0', STR_PAD_LEFT);
                                                        ?>
                                                            <td class="ui-droppable" data-date="1/7/2020" data-userid="1">

                                                                <?php
                                                                $sql2 = mysqli_query($con, "select * from tblequipment1 where eid='$row[id]' and month(date)='$month_padded' and year(date)='$year' and id='$row1[id]'");
                                                                $row2 = mysqli_fetch_array($sql2);
                                                                $match = mysqli_num_rows($sql2);
                                                                ?>
                                                                <?php
                                                                if ($match >= 1) {
                                                                    $sql3 = mysqli_query($con, "SELECT * FROM tblequipment1 WHERE eid='$row[id]' AND month(date)='$month_padded' AND year(date)='$year' AND status1='In Progress' AND id='$row1[id]'");
                                                                    $match1 = mysqli_num_rows($sql3);

                                                                    $sql4 = mysqli_query($con, "SELECT * FROM tblequipment1 WHERE eid='$row[id]' AND month(date)='$month_padded' AND year(date)='$year' AND status1='waiting' AND id='$row1[id]'");
                                                                    $match2 = mysqli_num_rows($sql4);

                                                                    $sql5 = mysqli_query($con, "SELECT * FROM tblequipment1 WHERE eid='$row[id]' AND month(date)='$month_padded' AND year(date)='$year' AND status1='Done' AND id='$row1[id]'");
                                                                    $match3 = mysqli_num_rows($sql5);

                                                                    $sql6 = mysqli_query($con, "SELECT * FROM tblequipment1 WHERE eid='$row[id]' AND month(date)='$month_padded' AND year(date)='$year' AND status1='Done' AND mverify='done' AND id='$row1[id]'");
                                                                    $match4 = mysqli_num_rows($sql6);

                                                                    if ($match1 >= 1) {
                                                                        // In Progress
                                                                ?>
                                                                        <div class="drag details ui-draggable ui-draggable-handle" style="border-left:5px solid rgb(255,204,0);position:relative;">
                                                                            <a href="admin.php?id=ppm1&sno=<?php echo $row1['id']; ?>">
                                                                                <h3 class="details-task" style="background:#FFCC00; color:#FFF">In Progress</h3>
                                                                            </a>
                                                                        </div>
                                                                        <?php
                                                                    } else if ($match2 >= 1) {
                                                                        // Waiting
                                                                        // FIXED: Compare with actual current date
                                                                        if ($row2['date'] >= $current_date) {
                                                                            $color = "#2473AB";
                                                                            $txt = "PPM Due";
                                                                            $bg = "36,115,171";
                                                                        } else {
                                                                            $color = "#C10000";
                                                                            $txt = "PPM Over Due";
                                                                            $bg = "193,0,0";
                                                                        }

                                                                        if ($row2['request'] == 'Yes') {
                                                                            $color = "#C10000";
                                                                            $txt = "Service Request";
                                                                            $bg = "193,0,0";
                                                                        ?>
                                                                            <div class="drag details ui-draggable ui-draggable-handle" style="border-left:5px solid rgb(<?php echo $bg; ?>);position:relative;">
                                                                                <a href="admin.php?id=raise1&sno=<?php echo $row1['id']; ?>&rid=<?php echo $row1['rid']; ?>">
                                                                                    <h3 class="details-task" style="background:<?php echo $color; ?>; color:#FFF"><?php echo $txt; ?></h3>
                                                                                </a>
                                                                            </div>
                                                                        <?php
                                                                        } else {
                                                                        ?>
                                                                            <div class="drag details ui-draggable ui-draggable-handle" style="border-left:5px solid rgb(<?php echo $bg; ?>);position:relative;">
                                                                                <a href="admin.php?id=ppm1&sno=<?php echo $row1['id']; ?>">
                                                                                    <h3 class="details-task" style="background:<?php echo $color; ?>; color:#FFF"><?php echo $txt; ?></h3>
                                                                                </a>
                                                                            </div>
                                                                        <?php
                                                                        }
                                                                    } else if ($match3 == $match) {
                                                                        // Done - Check verification status
                                                                        if ($row2['request'] == 'Yes' && $match4 >= 1) {
                                                                        ?>
                                                                            <div class="drag details ui-draggable ui-draggable-handle" style="border-left:5px solid rgb(47, 177, 47);position:relative;">
                                                                                <a href="admin.php?id=raise1&sno=<?php echo $row1['id']; ?>&rid=<?php echo $row1['rid']; ?>">
                                                                                    <h3 class="details-task" style="background: rgb(47, 177, 47); color:#FFF">Service Done</h3>
                                                                                </a>
                                                                            </div>
                                                                        <?php
                                                                        } else if ($row2['request'] == '' && $match4 >= 1) {
                                                                        ?>
                                                                            <div class="drag details ui-draggable ui-draggable-handle" style="border-left:5px solid rgb(102,153,0);position:relative;">
                                                                                <a href="admin.php?id=ppm1&sno=<?php echo $row1['id']; ?>">
                                                                                    <h3 class="details-task" style="background:#669900; color:#FFF">PPM Done</h3>
                                                                                </a>
                                                                            </div>
                                                                            <?php
                                                                        } else {
                                                                            if ($row2['request'] == 'Yes') {
                                                                            ?>
                                                                                <div class="drag details ui-draggable ui-draggable-handle" style="border-left:5px solid rgb(255, 166, 0);position:relative;">
                                                                                    <a href="admin.php?id=raise1&sno=<?php echo $row1['id']; ?>&rid=<?php echo $row1['rid']; ?>">
                                                                                        <h3 class="details-task" style="background: rgb(255, 166, 0); color:#FFF">Service Verification Pending</h3>
                                                                                    </a>
                                                                                </div>
                                                                            <?php
                                                                            } else {
                                                                            ?>
                                                                                <div class="drag details ui-draggable ui-draggable-handle" style="border-left:5px solid rgb(255,204,0);position:relative;">
                                                                                    <a href="admin.php?id=ppm1&sno=<?php echo $row1['id']; ?>">
                                                                                        <h3 class="details-task" style="background:#FFCC00; color:#FFF">PPM Verification Pending</h3>
                                                                                    </a>
                                                                                </div>
                                                                <?php
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                                ?>
                                                            </td>
                                                        <?php
                                                        }
                                                        ?>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>