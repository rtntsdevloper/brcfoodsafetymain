<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="admin.php?id=1">Home</a></li>
            <li>Metal Detectable Stationary Check </li>
        </ul>
    </div>
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <a href="admin.php?id=precord"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                    <a href="admin.php?id=dist_mixingadd"><button class="btn btn-danger" style="float:right">Add Record </button></a>

                    <h4 class="card-title mb-3">Distibution and Mixing Record</h4>

                    <p>List of Record</p>



                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Date</th>
                                    <th>Product Name</th>
                                    <th scope="col">Recipe no.</th>
                                    <th>Pasteurisation (CCP)</th>
                                    <th>Filtration(CCP)</th>
                                    <th>Homogenisation</th>
                                    <th>Cooling (CCP)</th>
                                    <th>Verification</th>
                                    <th scope="col">View</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = mysqli_query($con, " select * from `dist_mixrecord` ");
                                $i = 0;
                                while ($row = mysqli_fetch_array($sql)) {
                                    $i++;
                                ?>
                                    <tr>

                                        <th scope="row"><?php echo $i; ?></th>
                                        <td><?php echo date('d-m-Y', strtotime($row['mdate'])); ?></td>
                                        <td><?php echo $row['pname']; ?></td>
                                        <td><?php echo $row['recnumb']; ?></td>
                                        <td>
                                            <?php if (isset($row['peststart']) && !empty($row['peststart'])) {
                                                $cxid = $row['peststart'];

                                                if ($row['pestend'] == 'done') {
                                            ?>
                                                    <button class="btn btn-success">Completed</button>
                                                <?php
                                                } else {
                                                ?>
                                                    <a href="admin.php?id=dist_pest1&tid=<?= $row['id'] ?>&cid=<?= $cxid ?>" class="btn btn-warning">Add Cooking End Details</a>
                                                <?php
                                                }
                                                ?>

                                            <?php

                                            } else {
                                            ?>
                                                <a href="admin.php?id=dist_pest&tid=<?= $row['id'] ?>" class="btn btn-warning">Add Cooking Start Details</a>
                                            <?php
                                            }

                                            ?>

                                        </td>
                                        <td>
                                            <?php if (isset($row['filtstart']) && !empty($row['filtstart'])) {
                                                $cxid = $row['filtstart'];

                                                if ($row['filtend'] == 'done') {
                                            ?>
                                                    <button class="btn btn-success">Completed</button>
                                                <?php
                                                } else {
                                                ?>
                                                    <a href="admin.php?id=dist_filter1&tid=<?= $row['id'] ?>&cid=<?= $cxid ?>" class="btn btn-warning">Add Filtration End Details</a>
                                                <?php
                                                }
                                                ?>

                                            <?php

                                            } else {
                                            ?>
                                                <a href="admin.php?id=dist_filter&tid=<?= $row['id'] ?>" class="btn btn-warning">Add Filtration Start Details</a>
                                            <?php
                                            }

                                            ?>
                                        </td>
                                        <td>
                                            <?php if (isset($row['homo']) && !empty($row['homo'])) { ?>
                                                <button class="btn btn-success">Completed</button>

                                            <?php
                                            } else {
                                            ?>
                                                <a href="admin.php?id=dist_homo&tid=<?= $row['id'] ?>" class="btn btn-warning">Add Homogenisation Details</a>
                                            <?php
                                            }
                                            ?>



                                        </td>
                                        <td>
                                            <?php if (isset($row['cool']) && $row['cool'] == 'done') { ?>
                                                <button class="btn btn-success">Completed</button>

                                            <?php
                                            } else {
                                            ?>
                                                <a href="admin.php?id=dist_cooling&tid=<?= $row['id'] ?>" class="btn btn-warning">Add Cooling Details</a>
                                            <?php
                                            }
                                            ?>



                                        </td>
                                        <td>
                                            <?php
                                            if ($row['pestend'] == 'done' && $row['filtend'] == 'done' && $row['homo'] == 'done' && $row['cool'] == 'done') {
                                                if (!empty($row['managesign'])) {
                                            ?>
                                                    <button class="btn btn-success">Verified</button>
                                                <?php
                                                } else {
                                                ?>
                                                    <a href="admin.php?id=dist_mixverify&rid=<?= $row['id'] ?>" class="btn btn-warning"> Verify Signature</a>
                                            <?php
                                                }
                                            }

                                            ?>

                                        </td>

                                        <td><a href="admin.php?id=dist_mixreport&wcode=<?php echo $row['id']; ?>"><button class="btn btn-primary">View</button></a></td>
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