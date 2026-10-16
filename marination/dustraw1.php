

<div class="main-content">
    <div class="breadcrumb">
        
        
    </div>
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <a href="admin.php?id=wastage"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                    <a href="admin.php?id=dustraw"><button class="btn btn-warning mr-3" style="float:right">Add Dusting Record</button></a>
                    </a>

                    <h4 class="card-title mb-3">Dusting Flour Record</h4>

                    <p>List of Record</p>

                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                            <thead>
                                <tr>

                                    <th scope="col">#</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Dusting Batch</th>
                                    <th scope="col">GRN</th>
                                    <th scope="col">Batch No.</th>
                                    <th scope="col">Used Qty</th>
                                    



                                    <!-- <th>View Report</th> -->

                                </tr>
                            </thead>
                            <tbody>
                                <?php 


                                $sql = mysqli_query($con, "select * from  `tbl_dustingrecord`");
                                $i = 0;
                                while ($row = mysqli_fetch_array($sql)) {

                                    $grn = $row['grn'];
                                    $sq1 = mysqli_query($con, "select * from  `tblgrn1` where id='$grn'");
                                    $row1 = mysqli_fetch_array($sq1);
                                    $grncode = $row1['grn'];
                                    
                                    
                                    $i++;
                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $i; ?></th>
                                         <td><?php echo date('d-m-Y',strtotime($row['datec'])); ?></td>
                                        <td><?php echo $row['dustid']; ?></td>
                                        <td><?php echo $grncode; ?></td>
                                        <td><?php echo $row['batch']; ?> </td>
                                          <td><?php echo $row['usedqty']; ?>Kg </td>
                                       
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