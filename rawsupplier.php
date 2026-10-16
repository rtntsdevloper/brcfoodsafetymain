<?php
// $r=mysqli_query($con,"select * from attempt where username='$_SESSION[uname]'");
// $num=mysqli_num_rows($r);
// echo $num;

?>

<div class="main-content">
    <div class="breadcrumb">

        <ul>
            <li><a href="">Home</a></li>
            <li>Raw Material Supplier </li>
        </ul>
    </div>
    <div class="container " style="margin-top:100px;">
        <div class="row mb-12">
            <div class="col-md-12 mb-12">
                <div class="card text-left">
                    <div class="card-body">

                        <a href="admin.php?id=1"><button class="btn btn-success"
                                style="float:right; margin-left:15px">Go Back</button></a>


                        <a href="admin.php?id=addrawsupplier"><button class="btn btn-danger"
                                style="float:right">Add New</button></a>
                        <h4 class="card-title mb-3">Raw-Material Supplier</h4>
                        <!-- <p>List of staff</p> -->

                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered" id="zero_configuration_table"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <!-- <th>sup id</th> -->
                                        <th>Suppler Id</th>
                                        <th>Sagecode</th>
                                        <th>Supplier name</th>
                                        <th>Address</th>
                                        <th>City</th>
                                        <th>Contact</th>
                                        <th>Email</th>
                                        <th>Edit</th>



                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = mysqli_query($con, "select * from tblrawsupplier");




                                    //  echo $k['supid'];
                                    


                                    $i = 0;


                                    // $sql2 = "SELECT * from `supplier` where supid='$y[supname]'";
                                    
                                    // $sql2 = "SELECT * from `tblrawsupplier` where supid='$y[supname]' ";

                                    // $result2 = mysqli_query($con, $sql2);
                                    // $row2 = mysqli_fetch_assoc($result2);
                                    while ($y = mysqli_fetch_array($sql)) {
                                        $i++;

                                        ?>
                                        <tr>
                                            <th scope="row"><?php echo $y['supid']; ?></th>
                                            <td scope="row"><?php echo $y['sagecode']; ?></td>
                                            <td><?php echo $y['supname']; ?></td>
                                            <td><?php echo $y['address']; ?></td>
                                            <td><?php echo $y['city']; ?></td>
                                            <td><?php echo $y['contact']; ?></td>
                                            <td><?php echo $y['email']; ?></td>
                                            <td>
                                                <a href="admin.php?id=editrawsupplier&sno=<?php echo $y['supid']; ?>"><button
                                                        class="btn btn-success" type="button"><i
                                                            class="fa fa-pencil"></i></button></a>



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