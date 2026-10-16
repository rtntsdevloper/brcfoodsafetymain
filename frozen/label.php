
<?php
$vdate=$_GET["vdate"];
if (isset($_POST['filter'])) {

    $startdate = $_POST['startdate'];

    $enddate = $_POST['enddate'];

} else {

    $startdate = date('Y-m-d', strtotime('last monday'));

    $enddate = date('Y-m-d');

}



?>



<div class="main-content">

    <div class="breadcrumb">



        <ul>

            <li><a href="admin.php?id=1">Home</a></li>

            <li>Labelling & Sealing Record </li>

        </ul>

    </div>








    <div class="row mb-12">

        <div class="col-md-12 mb-12">

            <div class="card text-left">

                <div class="card-body">



                    <a href="admin.php?id=zendseal"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

                    <a href="admin.php?id=zendsealpdf&vdate=<?= $vdate ?>"><button class="btn btn-warning ml-3" style="float:right; margin-left:15px">View Report</button></a>

                    <!-- <a href="admin.php?id=zendsealadd"><button class="btn btn-danger" style="float:right">Add Labelling </button></a> -->





                    </a>







                    <h4 class="card-title mb-3">Labelling & Sealing Record</h4>



                    <p>List of Record</p>



                    <div class="table-responsive">

                        <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">

                            <thead>

                                <tr>

                                    <th scope="col">#</th>

                                    <th scope="col">Date</th>

                                    <th scope="col">Production Batch</th>

                                    <th scope="col">Is the Pouches Sealed Properly?</th>

                                    <th>Is labelling correct on packet?</th>

                                    <th>Is batch code & BBD printed adequately?</th>

                                    <th scope="col">Comments (if applicable)</th>

                                    <th scope="col">Updated By </th>

                                    <th scope="col">Updated On</th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php

                                $sql = mysqli_query($con, " select * from `zendseal` where dates='$vdate' ");

                                $i = 0;

                                while ($row = mysqli_fetch_array($sql)) {



                                    $grnid = $row['productbatch'];



                                    $grnx = mysqli_query($con, "SELECT * FROM `zendproduction` WHERE id = '$grnid'");

                                    $grnx1 = mysqli_fetch_array($grnx);

                                    $i++;

                                ?>

                                    <tr>



                                        <th scope="row"><?php echo $i; ?></th>

                                        <td><?php echo date('d-m-Y', strtotime($row['dates'])); ?></td>
<!-- <td><?php echo $grnx1['pbatch'] . '(' . $grnx1['skbatch'] . ')'; ?></td> -->
                                        <td><?php echo $grnx1['pbatch'] . '(' . $grnx1['batch'] . ')'; ?></td>



                                        <td><?php echo $row['sealed']; ?></td>

                                        <td><?php echo $row['labelling']; ?></td>

                                        <td><?php echo $row['print']; ?></td>

                                        <td><?php echo $row['batch']; ?></td>

                                        <td><?php echo $row['user']; ?></td>

                                        <td><?php echo date('d-m-y h:i:s',strtotime($row['cdate'])) ; ?></td>



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