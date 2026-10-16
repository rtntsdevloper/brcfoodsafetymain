<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>Critical Issue </li>
        </ul>
    </div>
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">
                    <a href="admin.php?id=1"><button class="btn btn-success" style="float:right; margin-left:15px">Go
                            Back</button></a>
                    <!-- <a href="admin.php?id=complaint-trending"><button class="btn btn-primary"
                            style="float:right; margin-left:15px">Customer Complaint Trending</button></a> -->


                    <h4 class="card-title mb-3">Critcal Issue Non Conformance</h4>

                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="zero_configuration_table"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Ref No.</th>
                                    <th scope="col">Date of Critical Issue</th>
                                    <th scope="col">Site Visit</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">View</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include 'connection_psd.php';
                                
                                $sql = mysqli_query($pcon, "SELECT * FROM `criticalissues`   ORDER BY `date` DESC");
                                $i = 0;
                                while ($row = mysqli_fetch_array($sql)) {
                                    $i++;
                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $i; ?></th>
                                        <td><?php echo $row['ref']; ?> </td>
                                        <td><?php echo date('d-m-Y', strtotime($row['date'])); ?> </td>
                                        <td><?php echo $row['sitevisit']; ?> </td>
                                        <td><?php echo $row['status']; ?> </td>
                                        <td>
                                            <a href="admin.php?id=internal_detailview1&sno=<?php echo $row['id']; ?>">
                                                <button class="btn <?php if ($row['status'] == 'Completed') {
                                                                        echo 'btn-success';
                                                                    } else {
                                                                        echo 'btn-warning';
                                                                    } ?>"><i class="fa fa-eye"></i>
                                                </button>
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