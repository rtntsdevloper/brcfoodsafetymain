<?php
include 'connection.php';


?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="admin.php?id=1">Home</a></li>
        </ul>
    </div>
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">
                    <h3 class="float-left">Packaging and Label Check Sheet</h3>
                    <a href="admin.php?id=Prodrecord"><button class="btn btn-success float-right mt-3 mr-2 ml-1">Back</button></a>
                    <a href="admin.php?id=addpackage" class="btn btn-primary  mt-3 mb-3 float-right">
                        Add
                    </a>

                    <!-- Table (Same Design as prob.php) -->
                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered text-center" id="zero_configuration_table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>

                                    <th>Packaging Code</th>
                                    <th>Date</th>
                                    <th>Product Name</th>
                                    <th>Production Date</th>
                                    <th>Size of Packaging</th>
                                    <th>Batch code of Packaging</th>
                                    <th>Is Previous Packaging Removed from the Line?</th>
                                    <th>Best before date</th>
                                    <th>Total Packs Produced</th>
                                    <th>Is label checked?</th>
                                    <th>View Detail</th>


                                </tr>
                            </thead>
                            <tbody>

                                <?php

                                $sq = mysqli_query($con, "select * from tbllabel ");

                                while ($row = mysqli_fetch_assoc($sq)) {
                                    echo "<tr>";
                                    echo "<td>" . $row['id'] . "</td>";
                                    echo "<td>" . $row['recordid'] . "</td>";
                                    echo "<td>" . date('d-m-Y', strtotime($row['date'])) . "</td>";
                                    echo "<td>" . $row['pname'] . "</td>";
                                    echo "<td>" .  date('d-m-Y', strtotime($row['pdate'])) . "</td>";
                                    echo "<td>" . $row['size'] . "g</td>";
                                    echo "<td>" . $row['batchcode'] . "</td>";
                                    echo "<td>" . $row['rline'] . "</td>";
                                    echo "<td>" . $row['bbdate'] . "</td>";
                                    if ($row['tproduce'] == 0 && !empty('label_checked')) {
                                        echo "<td colspan='2'><a href='admin.php?id=packadd&bid=" . $row['id'] . "' class='btn btn-info'>Add Details</a></td>";
                                    } else {
                                        echo "<td>" . $row['tproduce'] . "</td>";
                                        echo "<td>" . $row['label_checked'] . "</td>";
                                    }
                                    echo '<td><a href="admin.php?id=packagepdf&pid='.$row['id'].'" class="btn btn-info">View Report</a> </td>';
                                    echo "</tr>";
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