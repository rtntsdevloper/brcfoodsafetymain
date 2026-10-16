<?php
include 'connection.php';
$selectedDate = $_GET['date'] ?? '';
$formattedDate = date("d/m/Y", strtotime($selectedDate));
$pid = $_GET['tid'];

?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"> Entries for <?php echo $formattedDate; ?></h1>

    </div>
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">
                    <a href="admin.php?id=hotdate&tid=<?php echo $pid; ?>"><button class="btn btn-success float-right mt-3 mr-2 ml-1">Back</button></a>
                    <!-- <a href="admin.php?"><button class="btn btn-danger float-right mt-3 mr-1 ml-1">Verify</button></a> -->
                    <a href="admin.php?id=hotpdf&date=<?php echo $selectedDate; ?>&tid=<?php echo $pid; ?>" class="btn btn-warning mt-3 mb-3 float-right">
                        View Report
                    </a>

                    <!-- Table (Same Design as prob.php) -->
                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered text-center" id="zero_configuration_table" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Product </th>
                                    <th scope="col">Batch Code</th>
                                    <th scope="col">Start Time</th>
                                    <th scope="col">Product Temp( > 82C)</th>
                                    <th scope="col">Finish Time</th>
                                    <th scope="col"> Product Temp( > 82C)</th>
                                    <th scope="col">Add By</th>
                                    <th scope="col">Verify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = mysqli_query($con, "SELECT * FROM tblhot WHERE pid='$pid' and date='$selectedDate'");

                                $i = 0;
                                while ($row = mysqli_fetch_assoc($query)) {
                                    $formattedDate = date("d/m/Y", strtotime($row['date']));
                                    $i++;
                                ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $formattedDate; ?></td>
                                        <td><?php echo $row['product']; ?></td>
                                        <td><?php echo $row['batchcode']; ?></td>

                                        <?php
                                        // First set of fields (sccp and tccp)
                                        $firstSetEmpty = empty($row['time']) || empty($row['ptemp']);

                                        if ($firstSetEmpty) {
                                            // Show Attempt button for first set
                                            echo '<td colspan="2" class="text-center align-middle">';
                                            echo '<a href="admin.php?id=hotform1&bid=' . $row['id'] . '&tid=' . $pid . '">';
                                            echo '<button class="btn btn-success">Attempt</button>';
                                            echo '</a>';
                                            echo '</td>';
                                        } else {
                                            // Show completed first set values
                                            echo '<td>' . $row['time'] . '</td>';
                                            echo '<td>' . $row['ptemp'] . '<sup>o</sup>C</td>';
                                        }

                                        // Second set of fields (eccp and etccp)
                                        $secondSetEmpty = empty($row['time1']) || empty($row['ptemp1']);

                                        if ($secondSetEmpty) {
                                            echo '<td colspan="2" class="text-center align-middle">';

                                            if ($firstSetEmpty) {

                                                echo '<button class="btn btn-danger" disabled>Pending</button>';
                                            } else {

                                                echo '<a href="admin.php?id=hotform2&bid=' . $row['id'] . '&tid=' . $pid . '">';
                                                echo '<button class="btn btn-primary">Attempt</button>';
                                                echo '</a>';
                                            }

                                            echo '</td>';
                                        } else {

                                            echo '<td>' . $row['time1'] . '</td>';
                                            echo '<td>' . $row['ptemp1'] . '<sup>o</sup>C</td>';
                                        }
                                        echo '<td>' . $row['addby'] . '</td>';

                                        if ($secondSetEmpty) {

                                            echo '<td><button class="btn btn-danger disabled">Verify</button></td>';
                                        } elseif (!empty($row['verify'])) {

                                            echo '<td><button class="btn btn-success disabled">Verified</button></td>';
                                        } else {

                                            echo '<td><a href="admin.php?id=verify_hot&rid=' . $row['id'] . '&tid=' . $pid . '"><button class="btn btn-warning">Verify</button></a></td>';
                                        }

                                        ?>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
</div>