<?php
$sno = $_GET['sno'];
?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>Machinery Management </li>
        </ul>
    </div>
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <a href="admin.php?id=calibrationeq2&sno=<?php echo $sno; ?>"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

                    <h4 class="card-title mb-3">Machinery Management</h4>



                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>

                                    <th scope="col">Calibration</th>
                                    <th scope="col">Calibration Date</th>
                                    <th scope="col">Calibration Due Date</th>
                                    <th scope="col">Frequency</th>
                                    <th scope="col">Certification No.</th>
                                    <th scope="col">Calibration By</th>
                                    <th scope="col">Calibration Report</th>




                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = mysqli_query($con, "SELECT * FROM `tblcalbhistory` WHERE `vid` = '$sno' and `status`='Inactive'");
                                $i = 0;
                                while ($row = mysqli_fetch_array($sql)) {
                                    $i++;
                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $i; ?></th>
                                        <td><?php echo $row['clabi']; ?></td>
                                        <td><?php echo date('d-m-Y', strtotime($row['caldate'])); ?></td>
                                        <td><?php echo date('d-m-Y', strtotime($row['caldue'])); ?></td>
                                        <td><?php echo $row['frequency']; ?></td>
                                        <td><?php if(isset($row['certno'])&& !empty($row['certno'])) {echo $row['certno'];}?></td>
                                        <td><?php echo $row['user']; ?> </td>

                                        <td> <a href=" upl1/<?php echo $row['calfile']; ?>" target="_blank" class="btn btn-primary">View</a></td>



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