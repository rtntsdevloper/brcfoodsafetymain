<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"></h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>Complaint Management </li>
        </ul>
    </div>
    <div class="row mb-12 mt-5">
        <div class="col-md-12 col-sm-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    
                    <a href="admin.php?id=1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                    <a href="admin.php?id=complaint-analysis"><button class="btn btn-success" style="float:right; margin-left:15px">Raw Material & Packaging Supplier KPI</button></a>
                    <a href="admin.php?id=service-analysis"><button class="btn btn-success" style="float:right; margin-left:15px">Service Supplier KPI</button></a>

                    <h4 class="card-title mb-3">Supplier Monitoring</h4>

                    <p>List of complaints</p>

                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Refno</th>
                                    <th scope="col">Supplier</th>
                                    <th scope="col">Issue</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">View</th>


                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = mysqli_query($con, "select * from tblsuppliercomplaint order by date ASC");
                                $i = 0;
                                while ($row = mysqli_fetch_array($sql)) {
                                    $i++;
                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $i; ?></th>
                                        <td><?php echo $row['refno']; ?> </td>
                                        <td><?php echo $row['supplier']; ?> </td>
                                        <td><?php echo $row['issue']; ?></td>
                                        <td>
                                            <?php
                                            if ($row['status'] == "waiting") {
                                            ?>
                                                <button class="btn btn-danger" type="button"><?php echo $row['status']; ?></button>
                                            <?php
                                            } else {
                                            ?>

                                                <button class="btn btn-success" type="button"><?php echo $row['status']; ?></button>
                                            <?php
                                            }
                                            ?>
                                        </td>

                                        <td>
                                            <a href="admin.php?id=viewsuppliercomplaint&sno=<?php echo $row['id']; ?>">
                                                <button class="btn btn-warning" type="button"><i class="fa fa-eye"></i></button>
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
    </div>
</div>