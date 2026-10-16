<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>Complaint Management </li>
        </ul>
    </div>
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">
                    <a href="admin.php?id=1"><button class="btn btn-success" style="float:right; margin-left:15px">Go
                            Back</button></a>
                    <a href="admin.php?id=complaint-trending"><button class="btn btn-primary"
                            style="float:right; margin-left:15px">Customer Complaint Trending</button></a>


                    <h4 class="card-title mb-3">Complaint Management</h4>

                    <p>Listt of complaints</p>

                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="zero_configuration_table"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Refno</th>
                                    <th scope="col">Date of Complaint</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Customer Name</th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Product Code</th>
                                    <th scope="col">Batch</th>
                                    <th scope="col">Issue</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">View</th>
                                    <th scope="col">Report</th>



                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = mysqli_query($con, "select * from tblnewcomplaint order by compdate DESC");
                                $i = 0;
                                while ($row = mysqli_fetch_array($sql)) {
                                    $i++;
                                    ?>
                                    <tr>
                                        <th scope="row"><?php echo $i; ?></th>
                                        <td><?php echo $row['refno']; ?> </td>
                                        <td><?php echo date('d-m-Y',strtotime( $row['compdate'])); ?> </td>
                                        <td><?php echo $row['category']; ?> </td>
                                        <td><?php echo $row['customer']; ?></td>
                                        <td><?php echo $row['product']; ?> </td>
                                        <td><?php echo $row['pcode']; ?> </td>
                                        <td><?php echo $row['batch']; ?></td>
                                        <td><?php echo $row['issue']; ?></td>
                                        <td>
                                            <?php
                                            if ($row['status'] == "waiting") {
                                                ?>
                                                <button class="btn btn-danger"
                                                    type="button"><?php echo $row['status']; ?></button>
                                                <?php
                                            } else {
                                                ?>

                                                <button class="btn btn-success"
                                                    type="button"><?php echo $row['status']; ?></button>
                                                <?php
                                            }
                                            ?>
                                        </td>

                                        <td>
                                            <a href="admin.php?id=viewcomplaintdetail&sno=<?php echo $row['id']; ?>">
                                                <button class="btn btn-warning" type="button"><i
                                                        class="fa fa-eye"></i></button>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="admin.php?id=complaintview&sno=<?php echo $row['id']; ?>">
                                                <button class="btn btn-info" type="button"><i
                                                        class="fa fa-file-pdf-o"></i></button>
                                            </a>
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