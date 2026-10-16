<?php
$sid = $_GET['sid'];

$sidd1 = mysqli_query($con, "select * from dailychecks where status1='Weekly' and status ='second'");

?>
<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>Daily Checks</li>
        </ul>
    </div>
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <a href="admin.php?id=dailychecksdetail"><button class="btn btn-success" style="float:right; margin-left:15px; margin-bottom:10px">Go Back</button></a>

                    <a href="admin.php?id=viewdailychecks&sid=<?php echo $sid; ?>"><button class="btn btn-success" style="float:right; margin-left:15px;margin-bottom:10px">Attempt New</button></a>




                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Date</th>
                                    <th>Verified By</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $start_date = date('Y-m-d', strtotime('last Friday'));
                                $end_date = date('Y-m-d', strtotime('today'));
                                $i = 0;
                                foreach ($sidd1 as $sdata) {
                                   $sdatid = $sdata['id'];
                                    $sql = mysqli_query($con, "SELECT * FROM `dailycheckss` WHERE name='$sdatid' and date between '$start_date' and '$end_date'");

                                    while ($row = mysqli_fetch_array($sql)) {

                                        $gh = mysqli_query($con, "select * from dailychecks where id='$row[name]'");
                                        $gh1 = mysqli_fetch_array($gh);
                                       

                                            $i++;
                                ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $gh1['name']; ?></td>
                                                <td><?php echo date("d-m-Y", strtotime($row['date'])); ?></td>

                                                <td>
                                                    <?php
                                                    if (!empty($row['verifysign'])) {
                                                    ?>
                                                        <img src="upl1/<?php echo $row['verifysign']; ?>.png" alt="" height="60" width="80">

                                                    <?php

                                                    } else {
                                                    ?>
                                                        <p class="text-danger">Not Verified!</p>
                                                    <?php
                                                    } ?>
                                                </td>



                                            </tr>
                                <?php
                                        }
                                    }
                                
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>