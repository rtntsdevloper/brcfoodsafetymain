<?php
$dtc = $_GET['dt'];

$tid = $_GET['tid'];

$pqx = mysqli_query($con, "SELECT * FROM `tblscalee` WHERE date='$dtc' AND pid= $tid AND status ='Verified'");
$pqxn = mysqli_num_rows($pqx);


?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>Weekly Scale Calibration </li>
        </ul>
    </div>
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <a href="admin.php?id=scale&tid=<?php echo $tid; ?>"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

                    <?php if ($pqxn > 0) { ?>
                        <a href="admin.php?id=scalepdf&dt=<?php echo $dtc; ?>&ac=1&tid=<?php echo $tid; ?>"><button class="btn btn-warning mr-3" style="float:right">View Record</button></a>
                    <?php } else {
                    ?>
                        <a href="admin.php?id=scalepdf&dt=<?php echo $dtc; ?>&ac=2&tid=<?php echo $tid; ?>"><button class="btn btn-warning mr-3" style="float:right">Veify Record</button></a>
                    <?php
                    }
                    ?>


                    <h4 class="card-title mb-3">Scale Record</h4>

                    <!-- <p>List of Dispatch</p> -->

                    <div class="table-responsive mt-5">
                        <table class="display table table-striped table-bordered text-center" id="zero_configuration_table" style="width:100%">
                            <thead>

                                <!-- <tr>
                                    <th colspan="11" style="color: red; text-align:center;">Chilled meat and meat prep +4°C; Raw meat & meat prep +4°C
                                        Frozen food -15°C; Frozen raw meat & meat prep -18°C </th>
                                </tr> -->

                                <tr>
                                    <th scope="col" rowspan="2" class="pb-5">#</th>
                                    <th scope="col" rowspan="2" class="pb-5">Date</th>
                                    <th scope="col" rowspan="2" class="pb-5">Scale Serial No.</th>
                                    <th scope="col" rowspan="2" class="pb-5">Area</th>
                                    <th scope="col" rowspan="2" class="pb-5">Calibration Tested by</th>
                                    <th scope="col" rowspan="2" class="pb-5">Ref. Weight</th>
                                    <th scope="col" colspan="5" class="">Total Points</th>

                                </tr>
                                <tr>
                                    <th>1</th>
                                    <th>2</th>
                                    <th>3</th>
                                    <th>4</th>
                                    <th>5</th>
                                </tr>

                            </thead>
                            <tbody>
                                <?php

                                $sql = mysqli_query($con, "SELECT * FROM `tblscalee` where date ='$dtc' and pid='$tid'");
                                $i = 0;
                                while ($row = mysqli_fetch_array($sql)) {
                                    $i++;

                                    // Explode the comma-separated values back into arrays
                                    $fifty = explode(",", $row['50g']);

                                    $one = explode(",", $row['100g']);
                                    $two = explode(",", $row['200g']);
                                ?>
                                    <tr>
                                        <td rowspan="3"><?php echo $i; ?></td>
                                        <td rowspan="3"><?php echo date('d-m-Y',strtotime($row['date'])); ?></td>
                                        <td rowspan="3"><?php echo $row['scale'] ?></td>
                                        <td rowspan="3"><?php echo $row['area']; ?></td>
                                        <td rowspan="3"><?php echo $row['calibration']; ?></td>
                                        <td>50g</td>
                                        <?php foreach ($fifty as $value) { ?>
                                            <td><?php echo $value; ?>g</td>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <td>100g</td>
                                        <?php foreach ($one as $value1): ?>
                                            <td><?php echo $value1; ?>g</td>
                                        <?php endforeach; ?>
                                    </tr>
                                    <tr>
                                        <td>200g</td>
                                        <?php foreach ($two as $value2): ?>
                                            <td><?php echo $value2; ?>g</td>
                                        <?php endforeach; ?>
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