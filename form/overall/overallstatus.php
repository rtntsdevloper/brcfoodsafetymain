<?php
include('connection.php');

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
?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Over all</a></li>
            <li>status</li>
        </ul>
    </div>

    <div class="col-md-12">
        <div class="card text-left">
            <div class="card-body">

                <a href="admin.php?id=over">
                    <button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button>
                </a>

                <a href="admin.php?id=overallstatus&year=<?php echo $nxt; ?>">
                    <button class="btn btn-danger" style="float:right; margin-left:15px">Next Year</button>
                </a>
                <a href="admin.php?id=overallstatus&year=<?php echo $pre; ?>">
                    <button class="btn btn-danger" style="float:right; margin-left:15px">Previous Year</button>
                </a>

                <h4 class="card-title mb-2">Details</h4>

                <div class="table-responsive mt-5">
                    <table class="table table-bordered table-striped">
                        <thead class="cal-thead">
                            <tr>
                                <th class="cal-toprow" colspan="2">Key Performance Indicators</th>
                                <th class="cal-toprow"></th>
                                <th class="cal-toprow" colspan="13"></th>


                            </tr>

                            <tr>
                                <th class="cal-toprow" style="width:140px;"> </th>

                                <th class="cal-toprow">Target</th>
                                <th class="cal-toprow">Acceptable</th>
                                <th class="cal-toprow">Action</th>
                                <th class="cal-toprow">Jan</th>
                                <th class="cal-toprow">Feb</th>
                                <th class="cal-toprow">Mar</th>
                                <th class="cal-toprow">Apr</th>
                                <th class="cal-toprow">May</th>
                                <th class="cal-toprow">Jun</th>
                                <th class="cal-toprow">Jul</th>
                                <th class="cal-toprow">Aug</th>
                                <th class="cal-toprow">Sep</th>
                                <th class="cal-toprow">Oct</th>
                                <th class="cal-toprow">Nov</th>
                                <th class="cal-toprow">Dec</th>
                            </tr>

                        </thead>
                        <tbody class="cal-tbody">
                            <?php

                            $sql = mysqli_query($con, "SELECT * FROM `tbl_overname` ");

                            $sql1 = mysqli_query($con, "SELECT * FROM  `tbl_overall` ");
                            // foreach ($sql1 as $data1) {

                            foreach ($sql as $data) {
                                ?>

                                <tr>
                                    <td><?php echo $data['name'] ?></td>
                                    <td><?php echo $data['target'] ?></td>
                                    <td><?php echo $data['acceptable'] ?></td>
                                    <td><?php echo $data['action'] ?></td>
                                    <td><?php echo $data1['dvalue'] ?></td>
                                    



                                </tr>
                            <?php } //} ?>
                        </tbody>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>