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

                    <a href="admin.php?id=calibrationeq"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

                    <?php
                    if($access=='Admin')
                    {
                    ?>
                       <a href="admin.php?id=calibrationeq3&sno=<?= $sno ?>"><button class="btn btn-primary" style="float:right; margin-left:15px">Previous Record</button></a>
                    <?php
                    }
                    ?>

                    <h4 class="card-title mb-3">Equipment Management</h4>
                    <?php
                   

                    $sql = mysqli_query($con, "select * from tblequipment where id='$sno'");
                    $row = mysqli_fetch_array($sql);
                    ?>


                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">

                            <tbody>
                                <tr>
                                    <th scope="col">Equipment Code</th>
                                    <td><?php echo $row['code']; ?></td>
                                </tr>
                                <tr>
                                    <th scope="col">Make</th>
                                    <td><?php echo $row['make']; ?></td>
                                </tr>
                                <tr>
                                    <th scope="col">Equipment Name</th>
                                    <td><?php echo $row['name']; ?></td>
                                </tr>
                                <tr>
                                    <th scope="col">Is equipment being services Internally or Externally?</th>
                                    <td><?php echo $row['service']; ?></td>
                                </tr>
                                <tr>
                                    <th scope="col">Site</th>
                                    <td><?php echo $row['site']; ?></td>
                                </tr>
                                <tr>
                                    <th scope="col">Location</th>
                                    <td><?php echo $row['location']; ?></td>
                                </tr>
                                <tr>
                                    <th scope="col">Frequency</th>
                                    <td><?php echo $row['frequency']; ?></td>
                                </tr>


                            </tbody>
                        </table>

                        <h3 align="center" style="color:#009999"> Calibration Detail</h3>
                        <table id="data-table-basic" class="table table-striped">
                            <tbody>
                                <?php
                                $sqll = mysqli_query($con, "select * from tblcalbhistory where vid='$sno'");
                                $sqll2 = mysqli_fetch_array($sqll);
                                $i = 0;
                                ?>
                                <tr>
                                    <th scope="col">Calibration Date</th>
                                    <td><?php echo $sqll2['caldate'];?></td>
                                </tr>
                                <tr>
                                    <th scope="col">Calibration Due Date</th>
                                    <td><?php echo $sqll2['caldue'];?></td>
                                </tr>
                                 <tr>
                                    <th scope="col">Frequency</th>
                                    <td><?php echo $sqll2['frequency'];?></td>
                                </tr>
                                   <tr>
                                    <th scope="col">Certification No.</th>
                                    <td><?php if(isset($sqll2['certno'])&& !empty($sqll2['certno'])) {echo $sqll2['certno'];}?></td>
                                </tr>
                                <tr>
                                    <th scope="col">Calibration File</th>
                                    <td><?php if(isset($sqll2['calfile'])&& !empty($sqll2['calfile'])){
                                        ?>
                                        <a href="upl1/<?php echo $sqll2['calfile']; ?>" target="_blank" class="btn btn-info">View File</a>
                                        <?php
                                    }?></td>
                                   
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>