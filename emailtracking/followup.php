<?php

$em = $_GET['view'];

$sql = mysqli_query($con, "SELECT * FROM `tblemailtrack` WHERE id =$em");
$sqql = mysqli_fetch_array($sql);
?>

<div class="main-content">
    <div class="breadcrumb ">
        <!-- <h1 class="mr-2"><?php echo $headingname; ?></h1> -->
        <ul>
            <li><a href="">Home</a></li>
            <li>Email Tracking</li>
        </ul>
    </div>

    <div class="row mb-12 my-5">
        <div class="col-md-12 mb-12">
            <div class="card text-left" style="margin-top:1%;">
                <div class="card-body">
                    <h3>Email Follow up</h3>
                    <div class="row pr-4 mb-3" style="float:right">
                       
                        <a href="admin.php?id=email_comment&eid=<?php echo $em; ?>"><button class="btn btn-secondary" style="float:right; margin-left:15px">Comment</button></a>
                        <a href="admin.php?id=email_follow&eid=<?php echo $em; ?>"><button class="btn btn-info" style="float:right; margin-left:15px">Add Follow up</button></a>
                        <a href="admin.php?id=email_close&eid=<?php echo $em; ?>"><button class="btn btn-primary ml-3">Email Closeoff</button></a>
                         <a href="admin.php?id=email_tracking"><button class="btn btn-success" style=" margin-left:15px">Go Back</button></a>
                    </div>
                    <h4 class="card-title mb-3 text-primary">Ticket : #<?php echo $sqql['tcode']; ?></h4>
                    <div class="table-responsive" id="basket">
                        <table class=" table table-striped table-bordered" id="zero_configuration_table">
                            <thead>



                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Follow-up Method</th>
                                    <th>Attachment</th>



                                    <!-- <th>view</th> -->

                                </tr>
                            </thead>
                            <tbody>


                                <?php

                                $sql = mysqli_query($con, "SELECT * FROM `tblfollowup` WHERE eid =$em");

                                $i = 0;
                                while ($row = mysqli_fetch_array($sql)) {
                                    $i++;




                                ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo date('d-m-Y', strtotime($row['date'])) ?></td>
                                        <td><?php echo $row['method']; ?></td>



                                        <td> <a href="emailtracking/supdoc/<?php echo  $row['attach']  ?>" class="btn btn-primary">View Attachment</a></td>





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