<?php
// $r=mysqli_query($con,"select * from attempt where username='$_SESSION[uname]'");
// $num=mysqli_num_rows($r);
// echo $num;

?>

<div class="main-content">
    <div class="breadcrumb">

        <ul>
            <li><a href="">Home</a></li>
            <li>Monthly Management Attendee</li>
        </ul>
    </div>
    <div class="container-fluid " style="margin-top:50px;">
        <div class="row mb-12">
            <div class="col-md-12 mb-12">
                <div class="card text-left">
                    <div class="card-body">

                        <a href="admin.php?id=monthly_review"><button class="btn btn-primary mb-3"
                                style="float:right; margin-left:15px">Go Back</button></a>


                        <a href="admin.php?id=meeting_attendee_add"><button class="btn btn-success ml-3 mb-3"
                                style="float:right">Add</button></a>
                        <h4 class="card-title mb-3">Monthly Management Attendee</h4>
                        <!-- <p>List of staff</p> -->

                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered" id="zero_configuration_table"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sr. no</th>
                                        <th>Name</th>
                                        <th>Designation</th>
                                        <th>Edit</th>
                                        
                                        


                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = mysqli_query($con, "SELECT * FROM `tbl_mmmattende`");



                                    $i = 0;
                                    // while (($y = mysqli_fetch_array($sql))&&(($z = mysqli_fetch_array($sql2))))  {
                                    while ($y = mysqli_fetch_array($sql)) {
                                        $i++;

                                    ?>
                                        <tr>
                                            <th scope="row"><?php echo $i; ?></th>
                                            <!-- <td ></td> -->
                                           


                                            <td><?php echo $y['name']; ?></td>
                                            <td><?php echo $y['designation']; ?></td>
                                             <td><a href="admin.php?id=meeting_attendee_edit&an=<?php echo $y['id']; ?>" class="btn btn-primary">Edit</a></td>
                                           
                                          
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