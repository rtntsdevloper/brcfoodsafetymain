<?php
include 'connection.php';
$selectedDate = $_GET['date'] ?? '';
$formattedDate = date("d/m/Y", strtotime($selectedDate));
$pid = $_GET['tid'];

?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"> List of Entries : <?php echo $formattedDate; ?></h1>
        <ul>
           
        </ul>
    </div>
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">
                    <a href="admin.php?id=ovendate&tid=<?php echo $pid;  ?>"><button class="btn btn-success float-right mt-3 mr-2 ml-1">Back</button></a>
                    <!-- <a href="admin.php?"><button class="btn btn-danger float-right mt-3 mr-1 ml-1">Verify</button></a> -->
                    <a href="admin.php?id=ovenpdf&date=<?php echo $selectedDate; ?>&tid=<?php echo $pid;  ?>" class="btn btn-warning mt-3 mb-3 float-right">
                        View Record
                    </a>

                    <!-- Table (Same Design as prob.php) -->
                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered text-center" id="zero_configuration_table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Product</th>
                                    <th>Start Time</th>
                                    <th>Oven Temp</th>
                                    <th>Finish Time</th>
                                    <th>Oven Temp</th>
                                    <th>Core Temp after Baking</th>
                                    <th>Quantity</th>
                                    <th>Verify</th>

                                </tr>

                            </thead>
                            <tbody>
                                <?php
                                $query = mysqli_query($con, "SELECT * FROM tbloven WHERE date='$selectedDate' and pid = '$pid'");
                                $i = 0;
                                while ($row = mysqli_fetch_assoc($query)) {
                                    $formattedDate = date("d/m/Y", strtotime($row['date']));
                                    $i++;
                                ?>

                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $formattedDate; ?></td>
                                        <td><?php echo $row['product']; ?></td>
                                        <td><?php echo $row['time']; ?></td>
                                        <td><?php echo $row['otemp']; ?><sup>o</sup>C</td>

                                    <?php
                                    // First set of fields (sccp and tccp)
                                    $firstSetEmpty = empty($row['ftime']) || empty($row['otemp1']);

                                    if ($firstSetEmpty) {
                                        // Show Attempt button for first set
                                        echo '<td colspan="2" class="text-center align-middle">';
                                        echo '<a href="admin.php?id=ovenform1&bid=' . $row['id'] . '&tid=' . $pid . ' ">';
                                        echo '<button class="btn btn-success">Attempt</button>';
                                        echo '</a>';
                                        echo '</td>';
                                    } else {
                                        // Show completed first set values
                                        echo '<td>' . $row['ftime'] . '</td>';
                                        echo '<td>' . $row['otemp1'] . '<sup>o</sup>C</td>';
                                    }

                                    // Second set of fields (eccp and etccp)
                                    $secondSetEmpty = empty($row['core']) || empty($row['qty']);

                                    if ($secondSetEmpty) {
                                        echo '<td colspan="2" class="text-center align-middle">';

                                        if ($firstSetEmpty) {
                                            // Show Pending button (disabled state) if first set is incomplete
                                            echo '<button class="btn btn-danger" disabled>Pending</button>';
                                        } else {
                                            // Show Attempt button if first set is complete
                                            echo '<a href="admin.php?id=ovenform2&bid=' . $row['id'] . '&tid=' . $pid . '">';
                                            echo '<button class="btn btn-primary">Attempt</button>';
                                            echo '</a>';
                                        }


                                        echo '</td>';
                                    } else {

                                        echo '<td>' . $row['core'] . '<sup>o</sup>C</td>';
                                        echo '<td>' . $row['qty'] . '</td>';
                                    }
                                   
                                     if ($secondSetEmpty) {
                                        // Show Pending button (disabled state) if first set is incomplete
                                        echo '<td><button class="btn btn-danger" disabled>Pending</button></td>';
                                    } elseif (!empty($row['verify'])) {
                                        echo '<td><button class="btn btn-success disabled">Verified</button></td>';
                                    } else {
                                        echo '<td><a href="admin.php?id=ovenverify&bid=' . $row['id'] . '&tid=' . $pid . '"><button class="btn btn-danger">Verify</button></a></td>';
                                    }
                                   
                                    
                                }
                              

                                    ?>

                                    </tr>


                            </tbody>
                        </table>
                    </div>

                    <!-- Generate PDF Button -->

                </div>
            </div>
        </div>
    </div>
</div>