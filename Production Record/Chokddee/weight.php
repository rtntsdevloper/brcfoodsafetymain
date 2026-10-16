<?php
include 'connection.php';
$pid = $_GET['eid'];
$vstr = mysqli_query($con, "SELECT * FROM `tblweight1` WHERE id = '$pid'");
$vstr1 = mysqli_fetch_array($vstr);
$pid = $vstr1['pid'];
 $selectedDate = date('d/m/Y',strtotime($vstr1['date']));
?>


<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <h2 class="mr-2">Entries for <?php echo $selectedDate; ?></h2>

    </div>
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <a href="weightdate&tid=19"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                    <a href="admin.php?id=addweight&eid=<?php echo $pid;  ?>"><button class="btn btn-danger mr-=2" style="float:right">Add Details</button></a>



                    <?php
                    // 1. First check if there are any records
                    $check = mysqli_query($con, "SELECT mangersign FROM tblweight1 WHERE id='$pid'");
                    $data = mysqli_fetch_assoc($check);

                    // 2. Simple if-else to show the right button
                    if (empty($data['mangersign'])) {
                        // Show Verify button if no signature
                        echo '<a href="admin.php?id=weightpdf&ac=2&&eid=' . $pid . '">
            <button class="btn btn-warning mr-3" style="float:right">Verify Report</button>
          </a>';
                    } else {
                        // Show View button if signature exists
                        echo '<a href="admin.php?id=weightpdf&ac=1&eid=' . $pid . '">
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
                                    <th scope="col">Pack 1 Weight(g)</th>
                                    <th scope="col">Pack 2 Weight(g)</th>
                                    <th scope="col">Pack 3 Weight(g)</th>
                                    <th scope="col">Pack 4 Weight(g)</th>
                                    <th scope="col">Pack 5 Weight(g)</th>
                                    <th scope="col">Declared Weight (g) </th>
                                    <th scope="col">Add By</th>
                                </tr>

                            </thead>
                            <tbody>
                                <?php

                                $sq = mysqli_query($con, "SELECT * FROM tblweight where eid='$pid'");
                                $i = 1;

                                while ($row = mysqli_fetch_assoc($sq)) {
                                ?><tr>
                                        <td><?php echo $i;  ?></td>

                                        <td><?php echo $row['product']; ?>
                                        </td>
                                        <td><?php echo $row['time']; ?>
                                        </td>
                                        <td><?php echo $row['packtare']; ?>g
                                        </td>
                                        <td><?php echo $row['pack1']; ?>g
                                        </td>
                                        <td><?php echo $row['pack2']; ?>g
                                        </td>
                                        <td><?php echo $row['pack3']; ?>g
                                        </td>
                                        <td><?php echo $row['pack4']; ?>g
                                        </td>
                                        <td><?php echo $row['pack5']; ?>g
                                        </td>
                                        <td><?php echo $row['declared'];?>g
                                        </td>
                                        <td><?php echo $row['addby']; ?>
                                        </td>




                                    </tr>
                                <?php
                            $i++;
                            } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>