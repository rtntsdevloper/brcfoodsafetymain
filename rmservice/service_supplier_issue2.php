
<div class="main-content">
    <div class="breadcrumb ">
        <!-- <h1 class="mr-2"><?php echo $headingname; ?></h1> -->
        <ul class="mt-5">
            <li><a href="">BARE POPCORN TASTE PANEL Management</a></li>
            <li>View Detail</li>
        </ul>
    </div>

    <div class="row mb-12 my-5">
        <div class="col-md-12 mb-12">
            <div class="card  text-left">
                <div class="card-header">
                                    <a href="admin.php?id=1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                
                                    <a href="admin.php?id=add_service_supplier_issues"><button class="btn btn-info" style="float:right; margin-left:15px">Add</button></a>
                                    </div>
                <div class="card-body">                


                    <h4 class="card-title mb-3"></h4>


                    <div class="row">




                        <div class="table-responsive" id="basket">
                            <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                <thead>
                                    <tr>
                                    <th></th>

                                    <th colspan="3">Service Supplier Details</th>
                                        <th colspan="13"> Performance ( Good - No NC , Medium - 1 NC per month , Poor - >1 NC)</th>
                                        


                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Supplier Name</th>
                                        <th>Services Provided </th>
                                        <th>Approved Criteria </th>
                                        <th>Jan-24 </th>
                                        <th>Feb-24 </th>
                                        <th>Mar-24 </th>
                                        <th>Apr-24 </th>
                                        <th>May-24 </th>
                                        <th>June-24 </th>
                                        <th>July-24 </th>
                                        <th>Aug-24 </th>
                                        <th>Sep-24 </th>
                                        <th>Oct-24 </th>
                                        <th>Nov-24 </th>
                                        <th>Dec-24 </th>

                                        <!-- <th>view</th> -->

                                    </tr>
                                </thead>
                                <tbody>


                                    <?php
                                    
                                    $sql = mysqli_query($con, "select * from `tblservice_supplier_issue1`");
                                    $i = 0;
                                    while ($row = mysqli_fetch_array($sql)) {
                                        $i++;
                                        $date = $row['date'];
                                        $id = $row['id'];


                                    ?>
                                        <tr>
                                            <td><?php echo $row['id']; ?></td>
                                            <td>Bako North Western limited</td>


                                          
                                            <td><?php echo $date; ?></td>
                                            <td><?php echo $date; ?></td>
                                            <td><?php echo $date; ?></td>
                                            <td><?php echo $date; ?></td>
                                            <td><?php echo $date; ?></td>
                                            <td><?php echo $date; ?></td>
                                            <td><?php echo $date; ?></td>
                                            <td><?php echo $date; ?></td>
                                            <td><?php echo $date; ?></td>
                                            <td><?php echo $date; ?></td>
                                            <td><?php echo $date; ?></td>
                                            <td><?php echo $date; ?></td>
                                            <td><?php echo $date; ?></td>
                                            <!-- <td> <a href="admin.php?id=factory_tour1&user_id=<?php echo $row['user_id']; ?>&sno=<?php echo $row['sno']; ?>"><button class="btn btn-info">view</button></a> -->

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