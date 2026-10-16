<div class="row mb-12">
    <div class="col-md-12 mb-12">
        <div class="card text-left">
            <div class="card-body">

                <a href="admin.php?id=viewallreport"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

                <a href="admin.php?id=storein"><button class="btn btn-info" style="float:right; margin-left:15px">Add New</button></a>




                <h4 class="card-title mb-3">Store In</h4>


                <div class="row">




                    <div class="table-responsive" id="basket">
                        <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Date</th>
                                    <th>GRN No</th>
                                    <th>Storage Type</th>




                                </tr>
                            </thead>
                            <tbody>


                                <?php
                                $date = date('Y-m-d');
                                $sql = mysqli_query($con, "SELECT * FROM `tbl_store`");
                                $i = 0;
                                while ($row = mysqli_fetch_array($sql)) {
                                    $i++;
                                ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo date('d-m-Y', strtotime($row['udate'])); ?></td>

                                        <td><?php echo $row['grn']; ?></td>

                                        <td><?php echo $row['store']; ?></td>



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