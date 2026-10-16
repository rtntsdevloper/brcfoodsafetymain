<?php
include 'connection.php';
$date = $_GET['date'];
$aid = $_GET['aid'];

$mnthdate = date('M Y', strtotime($date));

?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2">Entries for <?php echo $mnthdate; ?></h1>

    </div>
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">
                    <h3 class="float-left">Internal Calibration Log For Scales </h3>
              <a href="admin.php?id=internaldate&tid=4"><button class="btn btn-success float-right  mr-2 ml-2">Back</button></a>
                    <?php
                    $sq1 = mysqli_query($con, "SELECT * FROM tblscales1 where area='$aid' and date1='$date'");
                    $roww =  mysqli_fetch_assoc($sq1);
                    if (empty($roww['corrective'])) {
      echo '<a href="admin.php?id=internalpdf&ac=1&date=' . $date . '&aid=' . $aid . '&range=' . $_GET['range'] . '">
                             <button class="btn btn-primary float-right">View Report</button></a>';
                        echo '<a href="admin.php?id=update1&date=' . $date . '&aid=' . $aid . '&range=' . $_GET['range'] . '"><button class="btn btn-danger float-right mr-2">Corrective Action</button>
                        </a>';
                    } else {

                        echo '<a href="admin.php?id=internalpdf&ac=1&date=' . $date . '&aid=' . $aid . '&range=' . $_GET['range'] . '">
                             <button class="btn btn-primary float-right">View Report</button></a>';
                    }
                    ?>

                    <?php
                    $sq = mysqli_query($con, "SELECT * FROM tblscales1 where area='$aid'");
                    $row = mysqli_fetch_assoc($sq);
                    ?>
                    <?php
                    $query = mysqli_query($con, "SELECT * FROM tblscales WHERE id ='{$row['area']}'");
                    $i = 1;
                    $row1 = mysqli_fetch_assoc($query)
                    ?>

                    <!-- <input type="text" class="form-control w-100" value="<?php echo $row1['area'];  ?>"> -->

                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered text-center" id="zero_configuration_table" style="width:100%">


                            <thead>

                                <tr>
                                    <th rowspan="2"> # </th>
                                    <th>Month <br> <?php echo $mnthdate; ?></th>
                                    <th>Scale S.NO<sup>o</sup> <br><span style="font-size:15px;">→</span> </th>
                                    <th colspan="7"><?php echo $row['scale']; ?></th>

                                </tr>

                                <tr>

                                    <th rowspan="3">WC</th>
                                    <th>Location</th>
                                    <th colspan="5"><?php echo $row1['area']; ?></th>
                                    <th> Average</th>
                                    <th>Difference</th>

                                </tr>

                            </thead>
                            <tbody>
                                <?php
                                $range = isset($_GET['range']) ? $_GET['range'] : '';

                                if ($range == 'first') {
                                    // First half of the month (1–15)
                                    $sql = mysqli_query($con, "SELECT * FROM tblscales1  WHERE area='$aid' AND DATE_FORMAT(date, '%Y-%m')='$date' 
                                    AND DAY(date) BETWEEN 1 AND 15 ORDER BY date ASC");
                                } elseif ($range == 'second') {
                                    // Second half of the month (16–end)
                                    $sql = mysqli_query($con, "SELECT * FROM tblscales1 WHERE area='$aid' 
                                    AND DATE_FORMAT(date, '%Y-%m')='$date' AND DAY(date) > 15  ORDER BY date ASC");
                                } else {
                                    // Full month fallback
                                    $sql = mysqli_query($con, "SELECT * FROM tblscales1 WHERE area='$aid' AND DATE_FORMAT(date, '%Y-%m')='$date'
                                    ORDER BY date ASC");
                                }

                                $i = 0;
                                while ($row2 = mysqli_fetch_array($sql)) {
                                    $i++;

                                    // Explode the comma-separated values back into arrays
                                    $fifty = explode(",", $row2['50g']);
                                    $one = explode(",", $row2['100g']);
                                    $two = explode(",", $row2['200g']);

                                    $sumfifty = array_sum($fifty) / count($fifty);
                                    $dfifty = (int)$sumfifty - 100;

                                    $sumone = array_sum($one) / count($one);
                                    $done = (int)$sumone - 1000;

                                    $sumtwo = array_sum($two) / count($two);
                                    $dtwo = (int)$sumtwo - 5000;
                                ?>

                                    <tr>
                                        <td rowspan="3"><?php echo $i; ?></td>

                                        <td rowspan="3"><?php echo date('d-m-y', strtotime($row2['date']));  ?></td>
                                        <th>100g</th>
                                        <?php foreach ($fifty as $value): ?>
                                            <td><?php echo $value; ?>(g)</td>
                                        <?php endforeach; ?>
                                        <td> <?php echo $sumfifty; ?>(g)</td>
                                        <td> <?php echo $dfifty; ?>(g)</td>
                                    </tr>
                                    <tr>
                                        <th>1kg</th>
                                        <?php foreach ($one as $value): ?>
                                            <td><?php echo $value; ?>(g)</td>
                                        <?php endforeach; ?>
                                        <td> <?php echo $sumone; ?>(g)</td>
                                        <td> <?php echo $done; ?>(g)</td>
                                    </tr>

                                    <tr>
                                        <th>5kg</th>
                                        <?php foreach ($two as $value): ?>
                                            <td><?php echo $value; ?>(g)</td>
                                        <?php endforeach; ?>
                                        <td> <?php echo $sumtwo; ?>(g)</td>
                                        <td> <?php echo $dtwo; ?>(g)</td>
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
</div>