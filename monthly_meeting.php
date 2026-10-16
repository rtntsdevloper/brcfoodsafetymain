<?php
// $r=mysqli_query($con,"select * from attempt where username='$_SESSION[uname]'");
// $num=mysqli_num_rows($r);
// echo $num;

?>

<div class="main-content">
    <div class="breadcrumb">

        <ul>
            <li><a href="">Home</a></li>
            <li>Monthly Management Meeting</li>
        </ul>
    </div>
    <div class="container-fluid " style="margin-top:50px;">
        <div class="row mb-12">
            <div class="col-md-12 mb-12">
                <div class="card text-left">
                    <div class="card-body">

                        <a href="admin.php?id=1"><button class="btn btn-primary mb-3"
                                style="float:right; margin-left:15px">Go Back</button></a>

                         <a href="admin.php?id=meeting_attendee"><button class="btn btn-success ml-3 mb-3"
                                style="float:right">Add Meeting Attendees</button></a>
                        <a href="admin.php?id=monthly_review_add"><button class="btn btn-success ml-3 mb-3"
                                style="float:right">Add</button></a>
                        <h4 class="card-title mb-3">Monthly Management Meeting</h4>
                        <!-- <p>List of staff</p> -->

                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered" id="zero_configuration_table"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sr. no</th>
                                        <th>Date</th>
                                        <th>Attendees</th>
                                        <th>Minute taken</th>
                                        <th>Apologies</th>
                                        <th>View Report</th>
                                        


                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = mysqli_query($con, "SELECT * FROM `tbl_meeting`");



                                    $i = 0;
                                    // while (($y = mysqli_fetch_array($sql))&&(($z = mysqli_fetch_array($sql2))))  {
                                    while ($y = mysqli_fetch_array($sql)) {
                                        $i++;

                                    ?>
                                        <tr>
                                            <th scope="row"><?php echo $i; ?></th>
                                            <!-- <td ></td> -->
                                            <td><?php

                                                echo $y['mdate']; ?></td>
                                                 <td><?php
                                                 $empnm = explode(';', $y['attend']);
                                                 $desig = explode(';', $y['desig']); 
                                                 foreach($empnm as $key=>$value){

                                                    echo $value." ( ".$desig[$key]. ") <br>";
                                                 }?>


                                                 
                                                
                                                
                                                </td>
                                            <td><?php

                                                echo $y['mntk']; ?></td>

                                            
                                            <td><?php echo $y['Apologies']; ?></td>
                                           
                                            <td>
                                                <?php
                                                
                                                    echo ' <a href="admin.php?id=monthly_review_report&sno=' . $y["id"] . '"><button class="btn btn-success" type="button">Meeting Report</button></a>';
                                                
                                                ?>



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