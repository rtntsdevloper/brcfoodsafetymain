<?php
$selectedDate = $_GET['date'];
$formattedDate = date("d/m/Y", strtotime($selectedDate));
$pid = $_GET['tid'];
?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="admin.php?id=1">Home</a></li>
            <li>Blast Chiller Log </li>
        </ul>
    </div>
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <?php
                    $sq = mysqli_query($con, "SELECT * FROM tblblast WHERE date='$selectedDate' and tid='$pid'");
                    $row = mysqli_fetch_assoc($sq);



                    echo '<a href="admin.php?id=blastdate&tid='.$pid.'"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>';
                    if (!empty($row['msign'])) {
                        echo '<a href="admin.php?id=blastpdf&ac=1&tid=' . $pid . '&bid='.$selectedDate.'"><button class="btn btn-warning mr-3" style="float:right">View Record</button></a>';
                    } else {
                        echo '<a href="admin.php?id=blastpdf&ac=2&tid=' . $pid . '&bid=' . $selectedDate . '"><button class="btn btn-info mr-3" style="float:right">Verify Report</button></a>';
                    }
                    ?>
                    <h4 class="card-title mb-3">Blast Chiller Log Record</h4>

                    <p>List of Blast Chiller Log for <?php echo $formattedDate; ?></p>

                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered text-center" id="zero_configuration_table" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col" rowspan="3" style="padding-bottom:60px;">#</th>
                                    <th scope="col" rowspan="3" style="padding-bottom:60px;">Date</th>
                                    <th scope="col" colspan="3">Product Detail</th>
                                    <th scope="col" colspan="8">Blast Chilling Limit < 5°C in 90 mins</th>
                                    <th scope="col" rowspan="3" style="padding-bottom:60px;">Verify</th>
                                    <th scope="col" rowspan="3" style="padding-bottom:60px;">Add By</th>
                                </tr>

                                <tr>
                                    <th scope="col" rowspan="2" class="pb-5">Product Name</th>
                                    <th scope="col" rowspan="2" class="pb-5">Time</th>
                                    <th scope="col" rowspan="2" class="pb-5">Quantity</th>
                                    <th scope="col" colspan="2">Blast Chiller</th>
                                    <th scope="col" colspan="2">Product</th>
                                    <th scope="col" colspan="2">Blast Chiller</th>
                                    <th scope="col" colspan="2">Product</th>
                                </tr>
                                <tr>
                                    <!-- Blast Chiller Initial -->
                                    <th scope="col">Start Time</th>
                                    <th scope="col">Temp</th>

                                    <!-- Product Initial -->
                                    <th scope="col">Start Time</th>
                                    <th>Temp</th>

                                    <!-- Blast Chiller Final -->
                                    <th scope="col">Finish Time</th>
                                    <th scope="col">Temp</th>

                                    <!-- Product Final -->
                                    <th scope="col">Finish Time</th>
                                    <th scope="col">Temp</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $query = mysqli_query($con, "SELECT * FROM tblblast WHERE date='$selectedDate' and tid='$pid'");
                                if (mysqli_num_rows($query) > 0) {
                                    $i = 1;
                                    while ($row = mysqli_fetch_assoc($query)) {
                                ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo date("d/m/Y", strtotime($row['date'])); ?></td>
                                            <td><?php echo $row['product']; ?></td>
                                            <td><?php echo $row['time']; ?></td>
                                            <td><?php echo $row['qty']; ?></td>
                                            <td><?php echo $row['th1']; ?></td>
                                            <td><?php echo $row['th2']; ?></td>
                                            <td><?php echo $row['ch1']; ?></td>
                                            <td><?php echo $row['ch2']; ?></td>

                                            <?php
                                            $emptyFields = empty($row['finishtime1']) &&
                                                empty($row['temp1']) &&
                                                empty($row['finishtime2']) &&
                                                empty($row['temp2']);

                                            if ($emptyFields) {
                                                // Show button spanning 5 columns
                                                echo '<td colspan="5" class="align-middle">';
                                                echo '<a href="admin.php?id=blastform2&bid=' . $row['id'] . '&tid=' . $pid . '"><button class="btn btn-success show-btn" data-id="' . $row['id'] . '">Attempt</button></a>';
                                                echo '</td>';
                                            } else {
                                                // Display all 5 fields if they have data
                                                echo '<td>' . $row['finishtime1'] . '</td>';
                                                echo '<td>' . $row['temp1'] . '</td>';
                                                echo '<td>' . $row['finishtime2'] . '</td>';
                                                echo '<td>' . $row['temp2'] . '</td>';

                                                // Check if the record is verified (assuming 'verify' field is not empty means verified)
                                                if (!empty($row['verify'])) {
                                                    echo '<td><button class="btn btn-success disabled">Verified</button></td>';
                                                } else {
                                                    echo '<td><a href="admin.php?id=verifysign&rid=' . $row['id'] . '&tid=' . $pid . '"><button class="btn btn-danger">Verify</button></a></td>';
                                                }
                                            }
                                            ?>
                                            <td><?php echo $row['addby']; ?></td>
                                        </tr>
                                <?php
                                    }
                                } else {
                                    echo '<tr><td colspan="16">No records found for selected date</td></tr>';
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