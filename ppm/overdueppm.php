<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>Machinery Management</li>
        </ul>
    </div>
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <a href="admin.php?id=ppmdash">
                        <button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button>
                    </a>

                    <h4 class="card-title mb-3">Machinery Management - Overdue</h4>

                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">S No.</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Equipment Name</th>
                                    <th scope="col">Equipment Code</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                               $curentxm = date('Y-m');

                                $sql = mysqli_query($con, "SELECT * FROM `tblequipment1` WHERE status1='waiting' and request='' AND DATE_FORMAT(date, '%Y-%m') < '$curentxm' Order By id DESC ");

                        
                                $i = 1;
                                while ($row = mysqli_fetch_assoc($sql)) {
                                    $eid = $row['eid'];
                                    $sq = mysqli_query($con, "SELECT * FROM `tblequipment` WHERE id='$eid'");
                                    $row1 = mysqli_fetch_assoc($sq);
                                ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
                                        <td><?php echo $row1['name']; ?></td>
                                        <td><?php echo $row1['code']; ?></td>
                                        <td>
                                            <a href="admin.php?id=overdueppm" class="badge badge-danger" style="font-size:12px;">Overdue</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
