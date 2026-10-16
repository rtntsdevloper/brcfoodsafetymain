<?php
$pro = $_GET['pro'];
$sid = $_GET['sid'];

$sqxl = mysqli_query($con,"SELECT * FROM `tblproduct1` WHERE `prodid` = '$pro'");
$sqxl1 = mysqli_fetch_array($sqxl);


$sqx = mysqli_query($con,"SELECT * FROM `product_specification` WHERE `id` = '$sid'");
$sqx1 = mysqli_fetch_array($sqx);




?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="main-content">
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left" style="margin-top:2%;">
                <div class="card-body">
                    <span style="float:left; font-size: 25px;">Specification List of <?php echo $sqx1['name']; ?> (<?php echo $sqxl1['prodname']; ?>)</span>

                    <a href="admin.php?id=productspec1&pro=<?php echo $pro; ?>"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                    <a href="admin.php?id=productspecadd&pro=<?php echo $pro; ?>&sid=<?php echo $sid; ?>"><button class="btn btn-success" style="float:right; margin-left:15px">Add Details</button></a>

                    <!-- <a href="admin.php?id=add_service_supplier_issues"><button class="btn btn-info" style="float:right; margin-left:15px">Add</button></a> -->



                    <h4 class="card-title mb-3"></h4>


                    <div class="row mt-5">





                        <div class="table-responsive" id="basket">
                            <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                <thead>

                                    <tr>
                                        <th>S.No</th>
                                        
                                        <th>Name</th>
                                        <th>Edit</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>


                                    <?php
                                    $q = "SELECT * FROM `save_specification` WHERE sid = '$sid' and pid='$pro'";
                                    $q1 = mysqli_query($con, $q);

                                    $i = 0;
                                    foreach ($q1 as $data) {
                                        $i++;



                                    ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                         
                                            <td><?php echo $data['name']; ?></td>
                                            <td><a href="admin.php?id=productspec3&prid=<?php echo $data['id']; ?>"><button class="btn btn-success">Edit</button></a></td>




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

