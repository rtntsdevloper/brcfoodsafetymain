<?php
// $r=mysqli_query($con,"select * from attempt where username='$_SESSION[uname]'");
// $num=mysqli_num_rows($r);
// echo $num;

?>

<div class="main-content">
    <div class="breadcrumb">

        <ul>
            <li><a href="">Home</a></li>
            <li>Raw Material Management </li>
        </ul>
    </div>
    <div class="container-fluid " style="margin-top:50px;">
        <div class="row mb-12">
            <div class="col-md-12 mb-12">
                <div class="card text-left">
                    <div class="card-body">

                        <a href="admin.php?id=addrawmaterial"><button class="btn btn-success"
                                style="float:right; margin-left:15px">Go Back</button></a>




                        <h4 class="card-title mb-3">Raw Material Detail</h4>
                        <br>
                        <!-- <p>List of staff</p> -->
                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered" id="zero_configuration_table"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sr. no</th>
                                        <th>Product code</th>
                                        <th>Product name</th>
                                        <th>Supplier Name</th>
                                        <th>Details</th>
                                        <th>Front Label</th>
                                        <th>Back Label</th>
                                        <th>Outer Label</th>
                                        <th>Specifications</th>
                                        <th>View</th>


                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = mysqli_query($con, "select * from tblrawmaterial where status='Active'");



                                    $i = 0;
                                    // while (($y = mysqli_fetch_array($sql))&&(($z = mysqli_fetch_array($sql2))))  {
                                    while ($y = mysqli_fetch_array($sql)) {
                                        $i++;
                                        $sqid = $y['id'];
                                        $sqx = mysqli_query($con, "SELECT * FROM `tblrawdata` WHERE raw='$sqid'");
                                        if(mysqli_num_rows($sqx) > 0){
                                        $row = mysqli_fetch_array($sqx);
                                        $rowstatus = $row['status'];
                                        if(isset($row['frontlabel'])&& !empty($row['frontlabel'])){
                                            $fp = "Update label";
                                            $fpc = "btn btn-primary btn-sm";
                                        }else{
                                            $fp = "Upload label";
                                            $fpc = "btn btn-warning btn-sm";
                                        }
                                        if(isset($row['backlabel'])&& !empty($row['backlabel'])){
                                            $bp = "Update label";
                                            $bpc = "btn btn-primary btn-sm";
                                        }else{
                                            $bp = "Upload label";
                                            $bpc = "btn btn-warning btn-sm";
                                        }
                                        if(isset($row['outerlabel'])&& !empty($row['outerlabel'])){
                                            $op = "Update label";
                                            $opc = "btn btn-primary btn-sm";
                                        }else{
                                            $op = "Upload label";
                                            $opc = "btn btn-warning btn-sm";
                                        }
                                        if(isset($row['specification'])&& !empty($row['specification'])){
                                            $sp = "Update label";
                                            $spc = "btn btn-primary btn-sm";
                                        }else{
                                            $sp = "Upload label";
                                            $spc = "btn btn-warning btn-sm";
                                        }

                                        }else{
                                            $rowstatus = "";
                                            $fp = "Upload label";
                                            $fpc ="btn btn-warning btn-sm";
                                            $bp = "Upload label";
                                            $bpc ="btn btn-warning btn-sm";
                                            $op = "Upload label";
                                            $opc ="btn btn-warning btn-sm";
                                            $sp = "Upload label";
                                            $spc ="btn btn-warning btn-sm";
                                        }
                                        

                                    ?>
                                        <tr>
                                            <th scope="row"><?php echo $i; ?></th>
                                            <!-- <td ></td> -->
                                            <td><?php

                                                echo $y['pcode']; ?></td>
                                            <td><?php

                                                echo $y['pname']; ?></td>

                                            <td>
                                                <?php
                                                $supid = $y['supid'];
                                                $supl = mysqli_query($con, "SELECT * FROM tblrawsupplier WHERE supid=$supid");
                                                $row1 = mysqli_fetch_array($supl);
                                                echo $row1['supname'];
                                                ?>
                                            </td>
                                      
                                            <td>
                                                  <?php
                                          if($rowstatus == 'done'){
                                              
                                        ?>
                                         <a href="admin.php?id=rawmaterialdata5&rid=<?php echo $y['id']; ?>" class="btn btn-success btn-sm">Update Detail</a>
                                               
                                                <?php
                                                }else{
                                                ?>
                                                <a href="admin.php?id=rawmaterialdata3&rid=<?php echo $y['id']; ?>" class="btn btn-info btn-sm">Add Details</a>
                                                <?php
                                                }
                                                ?>
                                                
                                            </td>



                                            <td><a href="admin.php?id=rawmaterialdata1&rid=<?php echo $y['id']; ?>&spx=1" class="btn <?php echo $fpc; ?>"><?= $fp ?></a></td>
                                            <td><a href="admin.php?id=rawmaterialdata1&rid=<?php echo $y['id']; ?>&spx=2" class="btn <?php echo $bpc; ?>"><?= $bp ?></a></td>
                                            <td><a href="admin.php?id=rawmaterialdata1&rid=<?php echo $y['id']; ?>&spx=3" class="btn <?php echo $opc; ?>"><?= $op ?></a></td>
                                            <td><a href="admin.php?id=rawmaterialdata1&rid=<?php echo $y['id']; ?>&spx=4" class="btn <?php echo $spc; ?>"><?= $sp ?></a></td>
                                            <td><a href="admin.php?id=rawmaterialdata2&rid=<?php echo $y['id']; ?>" class="btn btn-info btn-sm">View</a></td>



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