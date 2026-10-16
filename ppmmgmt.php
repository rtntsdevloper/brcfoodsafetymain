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

                    <a href="admin.php?id=1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                    <a href="admin.php?id=addppm"><button class="btn btn-danger" style="float:right">Add New</button></a>
                    <h4 class="card-title mb-3">Machinery Management</h4>



                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Manufacturer</th>
                                    <th scope="col">Code</th>
                                    <th scope="col">Site</th>
                                    <th scope="col">Location</th>
                                    <th scope="col">Service</th>
                                    <th scope="col">Supplier</th>
                                    <th scope="col">View</th>
                                    <th scope="col">Status</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = mysqli_query($con, "select * from tblequipment ");
                                $i = 0;
                                while ($row = mysqli_fetch_array($sql)) {
                                    $i++;
                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $i; ?></th>
                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php echo $row['make']; ?></td>
                                        <td><?php echo $row['code']; ?> </td>
                                        <td><?php echo $row['site']; ?> </td>
                                        <td><?php echo $row['location']; ?></td>
                                        <td><?php echo $row['service']; ?></td>
                                        <td><?php echo $row['sname']; ?></td>

                                        <td>
                                            <a href="admin.php?id=viewppm&sno=<?php echo $row['id']; ?>">
                                                <button class="btn btn-warning" type="button"><i class="fa fa-eye"></i></button>
                                            </a>
                                        </td>
                                        <td><a href="admin.php?id=calibrationeq4&sno=<?php echo $row['id']; ?>" class="btn 
                                                <?php if ($row['status'] == 'Active') {
                                                    echo 'btn-outline-success';
                                                } else {
                                                    echo 'btn-outline-danger';
                                                }
                                                ?>
                                                
                                                "><?php echo $row['status']; ?></a></td>
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