<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>Sub-Section Tabs Management </li>
        </ul>
    </div>

    <style>
        .hidden {
            display: none;
        }
    </style>
    <?php
    $subsno = $_GET['subsno'];

    ?>
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <h4>Section <?php echo $subsno; ?> Tabs Management</h4>
                    <a href="admin.php?id=sectiontabsview" class="mb-3"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Sub-Section</th>
                                    <th scope="col">Action</th>




                                </tr>
                            </thead>
                            <tbody>
                                <?php



                                $sql = mysqli_query($con, "SELECT * FROM `subtest1` WHERE sid= '$subsno' ");
                                $i = 0;
                                foreach ($sql as $rowq) {

                                    if (!empty($rowq['ssid'])) {
                                        $secid = $rowq['ssid'];
                                    } else {
                                        $secid = $rowq['fid'];
                                    }




                                    $i++;
                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $i; ?></th>
                                        <td>Section <?php echo $secid; ?></td>


                                        <td>
                                            <?php
                                            if (!empty($rowq['tabs'])) { ?>
                                                <a href="admin.php?id=subsectabsadd&sno=<?php echo $rowq['id']; ?>" class="btn btn-primary">Update Tabs</a>
                                            <?php

                                            } else {
                                            ?>
                                                <a href="admin.php?id=subsectabsadd&sno=<?php echo $rowq['id']; ?>" class="btn btn-success">Add Tabs</a>
                                            <?php
                                            }

                                            ?>

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