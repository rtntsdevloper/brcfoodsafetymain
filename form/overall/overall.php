<?php
include('connection.php');

if (isset($_GET['year'])) {
    $curyear = $_GET['year'];
} else {
    $curyear = date("Y");
}

$pre = $curyear - 1;
$nxt = $curyear + 1;

?><div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>Overall</li>
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=over">
                    <button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button>
                </a>
                <a href="admin.php?id=overalladd">
                    <button class="btn btn-danger" style="float:right; margin-left:15px">Add New</button>
                </a>
                <a href="admin.php?id=overall&year=<?php echo $nxt; ?>">
                    <button class="btn btn-danger" style="float:right; margin-left:15px">Next Year</button>
                </a>
                <a href="admin.php?id=overall&year=<?php echo $pre; ?>">
                    <button class="btn btn-danger" style="float:right; margin-left:15px">Previous Year</button>
                </a>

                <div class="card-title">Overall Status <?php echo $curyear; ?></div>

                <div class="table-responsive mt-5">
                    <table class="table table-bordered table-striped">
                        <thead class="cal-thead">
                            <tr>
                                <th class="cal-toprow" colspan="2">Key Performance Indicators</th>
                                <th class="cal-toprow"></th>
                                <th class="cal-toprow" colspan="13"></th>
                            </tr>
                            <tr>
                                <th class="cal-toprow" style="width:140px;"></th>
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
                            foreach ($sql as $data) {
                                $sid = $data['id'];
                            ?>
                                <tr>
                                    <td style="background-color: ;"><?php echo $data['name'] ?></td>
                                    <td style="background-color: #5af15a ;"><?php echo $data['target'] ?></td>
                                    <td style="background-color:  #FFBF00  ;"><?php echo $data['acceptable'] ?></td>
                                    <td style="background-color: #F08080 ;"><?php echo $data['action'] ?></td>
                                    <?php
                                    $colorMap = [
                                        'red'   => '#F08080',
                                        'yellow'  => '#FFBF00',
                                        'green' => '#5af15a',
                                    ];
                                    for ($i = 1; $i <= 12; $i++) {
                                        $ix = str_pad($i, 2, "0", STR_PAD_LEFT);
                                        $sql1 = mysqli_query($con, "SELECT * FROM `tbl_overall` 
                                                                    WHERE month ='$ix' 
                                                                      AND year='$curyear' 
                                                                      AND sid = '$sid' ");
                                        $sql1data = mysqli_fetch_array($sql1);
                                        $sql1n = mysqli_num_rows($sql1);
                                        if ($sql1n > 0) {
                                            $cellColorName = $sql1data['color'];
                                            if (isset($colorMap[$cellColorName])) {
                                                $cellColorHex = $colorMap[$cellColorName];  
                                            } else {
                                                $cellColorHex = $cellColorName;
                                            }
                                    ?>
                                            <td style="background-color: <?php echo $cellColorHex; ?>;">
                                                <?php echo $sql1data['dvalue']; ?>
                                            </td>
                                        <?php
                                        } else {
                                        ?>
                                            <td></td>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tr>
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