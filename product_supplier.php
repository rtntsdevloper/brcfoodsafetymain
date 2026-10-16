<?php
// $r=mysqli_query($con,"select * from attempt where username='$_SESSION[uname]'");
// $num=mysqli_num_rows($r);
// echo $num;

?>

<div class="main-content">
    <div class="breadcrumb">

       <ul>
            <li><a href="">Home</a></li>
            <li>Customer Management </li>
        </ul>
    </div>
    <div class="container " style="margin-top:100px;">
        <div class="row mb-12">
            <div class="col-md-12 mb-12">
                <div class="card text-left">
                    <div class="card-body">

                        <a href="admin.php?id=1"><button class="btn btn-success"
                                style="float:right; margin-left:15px">Go Back</button></a>


                        <a href="admin.php?id=addcustomer"><button class="btn btn-danger"
                                style="float:right">Add New</button></a>
                        <h4 class="card-title mb-3">Customer Detail</h4>
                        <!-- <p>List of staff</p> -->

                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered" id="zero_configuration_table"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sno</th>
                                        <th>Name</th>
                                        <th>Contact</th>
                                        <th>Address</th>
                                        <th>Edit</th>


                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = mysqli_query($con, "select * from tblcustomer");



                                    $i = 0;
                                   
                                    while ($y = mysqli_fetch_array($sql)) {
                                        $i++;

                                        ?>
                                        <tr>
                                            <th scope="row"><?php echo $y['id']; ?></th>
                                            <td><?php echo $y['name']; ?></td>
                                            <td><?php echo $y['contact']; ?></td>
                                            <td><?php echo $y['adr']; ?></td>
                                            <td>
                                                    <a href="admin.php?id=editcustomer&sno=<?php echo  $y['id'];?>"><button class="btn btn-success" type="button"><i class="fa fa-pencil"></i></button></a>
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