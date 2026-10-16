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
                    <a href="admin.php?id=addsectiontabs"><button class="btn btn-danger" style="float:right">Add New</button></a>
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
                                $sql1 = mysqli_query($con, "select * from addtest1 ");

                                $i = 0;
                                while ($sect = mysqli_fetch_array($sql1)) {


                                    if ($sect['statusc'] == 'Yes') {
                                ?>
                                        <tr>
                                            <th scope="row"><?php echo $i; ?></th>
                                            <td>Section <?php echo $sect['testid']; ?></td>
                                            <td><?php echo $sect['subject']; ?></td>

                                            <td>
                                                <?php
                                                if (!empty($sect['tabs'])) { ?>
                                                    <a href="admin.php?id=sectiontabsadd&sno=<?php echo $sect['id']; ?>&change=1" class="btn btn-primary">Update Tabs</a>
                                                <?php

                                                } else {
                                                ?>
                                                    <a href="admin.php?id=sectiontabsadd&sno=<?php echo $sect['id']; ?>&change=1" class="btn btn-success">Add Tabs</a>
                                                <?php
                                                }

                                                ?>

                                            </td>

                                        </tr>
                                        <?php
                                    } else {
                                        $sql = mysqli_query($con, "SELECT * FROM `subtest` where tid='$sect[id]'");

                                        foreach ($sql as $row) {


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

                                            </tr>
                                <?php
                                        }
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>