<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>Section Tabs Management </li>
        </ul>
    </div>
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <a href="admin.php?id=1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

                    <h4 class="card-title mb-3">Section Tabs Management</h4>


                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Sub-Section</th>
                                    <th scope="col">Sub-Section Name</th>
                                    <th scope="col">Action</th>




                                </tr>
                            </thead>
                            <tbody>
                                <?php



                                $sql = mysqli_query($con, "SELECT distinct sid FROM `subtest` ");
                                $i = 0;
                                foreach ($sql as $rowq) {
                                    $rid = $rowq['sid'];

                                    $qh = mysqli_query($con, "SELECT * FROM `subtest` WHERE sid ='$rid'");
                                    $row = mysqli_fetch_array($qh);



                                    $i++;
                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $i; ?></th>
                                        <td>Section <?php echo $row['sid']; ?></td>
                                        <td><?php echo $row['subtest']; ?></td>

                                        <td>
                                            <?php
                                            if (!empty($row['tabs'])) { ?>
                                                <a href="admin.php?id=sectiontabsadd&sno=<?php echo $row['id']; ?>" class="btn btn-primary">Update Tabs</a>
                                            <?php

                                            } else {
                                            ?>
                                                <a href="admin.php?id=sectiontabsadd&sno=<?php echo $row['id']; ?>" class="btn btn-success">Add Tabs</a>
                                            <?php
                                            }

                                            ?>

                                        </td>
                                        <td>
                                            <a href="admin.php?id=subsectabsview&subsno=<?php echo $row['sid']; ?>" class="btn btn-secondary">Sub-Section Tabs</a>
                                        </td>

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