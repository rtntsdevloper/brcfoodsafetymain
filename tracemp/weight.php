<?php
include 'connection.php';
$pid = $_GET['eid'];

   $check = mysqli_query($con, "SELECT * FROM tblweight WHERE id='$pid'");
                    $data = mysqli_fetch_array($check);
                    $selectedDate = $data['date'];

                    $formattedDate = date('d-m-Y',strtotime($selectedDate ));

?>


<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <h2 class="mr-2">Entries for <?php echo $formattedDate; ?></h2>

    </div>
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <a href="admin.php?id=record"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                    <a href="admin.php?id=weightcheckadd2&eid=<?php echo $pid;?>"><button class="btn btn-danger mr-=2" style="float:right">Add Details</button></a>



                    <?php
                    // 1. First check if there are any records
                 ;

                    // 2. Simple if-else to show the right button
                    if (empty($data['mangersign'])) {
                        // Show Verify button if no signature
                        echo '<a href="admin.php?id=weightpdf&ac=2&date=' . $selectedDate . '&eid=' . $pid . '">
            <button class="btn btn-warning mr-3" style="float:right">Verify Report</button>
          </a>';
                    } else {
                        // Show View button if signature exists
                        echo '<a href="admin.php?id=weightpdf&ac=1&date=' . $selectedDate . '&eid=' . $pid . '">
            <button class="btn btn-info mr-3" style="float:right">View Report</button>
          </a>';
                    }
                    ?>
                    <h4 class="card-title mb-3">Daily Weight Check Records</h4>


                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered text-center" id="zero_configuration_table" style="width:100%">
                            <thead>

                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Time </th>
                                    <th scope="col">Pack tare Weight(g)</th>
                                    <th scope="col">Pack 1 Weight</th>
                                    <th scope="col">Pack 2 Weight</th>
                                    <th scope="col">Pack 3 Weight</th>
                                    <th scope="col">Pack 4 Weight</th>
                                    <th scope="col">Pack 5 Weight</th>
                                    <th scope="col">Declared Weight (g) </th>
                                    <th scope="col">Sign</th>
                                </tr>

                            </thead>
                            <tbody>
                                <?php

                                $sq = mysqli_query($con, "SELECT * FROM tblweight1 where eid='$pid'");
                                $i = 0;

                                while ($row = mysqli_fetch_assoc($sq)) {
                                     $i++;
                                ?><tr>
                                        <td><?php echo $i;  ?></td>

                                        <td><?php echo $row['product']; ?>
                                        </td>
                                        <td><?php echo $row['time']; ?>
                                        </td>
                                        <td><?php echo $row['packtare']; ?>
                                        </td>
                                        <td><?php echo $row['pack1']; ?>
                                        </td>
                                        <td><?php echo $row['pack2']; ?>
                                        </td>
                                        <td><?php echo $row['pack3']; ?>
                                        </td>
                                        <td><?php echo $row['pack4']; ?>
                                        </td>
                                        <td><?php echo $row['pack5']; ?>
                                        </td>
                                        <td><?php echo $row['declared']; ?>
                                        </td>
                                        <td><img src="tracemp/sign/<?php echo $row['sign']; ?>.png" width="100">
                                        </td>




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