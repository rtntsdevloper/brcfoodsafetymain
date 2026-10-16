<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Email Management</a></li>
            <li>Add Email</li>
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=trcheck"><button class="btn btn-success"
                        style="float:right; margin-left:15px">Go Back</button></a>

                <div class="card-title"> Add Vehicle daily safety checks </div>

                <form class="needs-validation" novalidate="novalidate" method="post" action=""
                    enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Driver name</label>
                            <input class="form-control" id="validationTooltip01" type="text" placeholder="Name"
                                required="required" name="dname" />
                            <div class="invalid-tooltip">
                                Please provide a valid driver name.

                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Vehicle reg. No</label>
                            <input class="form-control" id="validationTooltip01" type="text" placeholder="Vehicle reg No."
                                required="required" name="vehicle" />
                            <div class="invalid-tooltip">
                                Please provide a Vehicle reg. No.

                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Date</label>
                            <input class="form-control" id="validationTooltip01" type="date" placeholder="Name"
                                required="required" name="tdate" />
                            <div class="invalid-tooltip">
                                Please provide a date

                            </div>
                        </div>
                        <div class="col-md-12 mb-3 col-sm-6 ">
                            <div class="row text-center">
                                <div class="col-md-4">
                                    <img src="truckchecks/img1.jpg" class="img-fluid" style="height:200px;" alt=""><br>
                                    (1)
                                </div>
                                <div class="col-md-2">
                                    <img src="truckchecks/img2.png" class="img-fluid" style="height:200px;" alt=""><br>
                                    (2)
                                </div>
                                <div class="col-md-4">
                                    <img src="truckchecks/img3.jpg" class="img-fluid" style="height:200px;" alt=""><br>
                                    (3)
                                </div>
                                <div class="col-md-2">
                                    <img src="truckchecks/img4.jpg" class="img-fluid" style="height:200px;" alt=""><br>
                                    (4)
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <h5 class="text-center">Please Select from below any anomalies found using the key letter as
                                        follow:
                                        <span class="text-primary">D</span> for any dents, <span
                                            class="text-primary">S</span>
                                        for any scratches, <span class="text-primary">R</span> for any rust,<span
                                            class="text-primary">M</span> for any missing part and <span
                                            class="text-primary">N</span> for no issue.
                                    </h5>
                                </div>
                                <div class="col-md-2"></div>
                            </div>

                        </div>
                        <div class="col-md-3 col-sm-2"></div>
                        <div class="col-md-6 col-sm-8 text-center">
                            <input id="validationTooltip01" type="radio" placeholder="Name" required="required"
                                name="tdname" value="D" />
                            D
                            <input id="validationTooltip01" class="ml-3" type="radio" placeholder="Name"
                                required="required" name="tdname" value="S"/> S

                            <input id="validationTooltip01" class="ml-3" type="radio" placeholder="Name"
                                required="required" name="tdname" value="R" /> R
                            <input id="validationTooltip01" class="ml-3" type="radio" placeholder="Name"
                                required="required" name="tdname" value="M"/> M
                                <!-- <br> -->
                                 <input id="validationTooltip01" class="ml-3" type="radio" placeholder="Name"
                                required="required" name="tdname" value="M"/> N

                                <textarea name="tdcomment" id="" class="form-control mt-4" placeholder="enter comment here"></textarea>


                        </div>
                        <div class="col-md-3 col-sm-2"></div>

                    </div>
                    <div class="row my-5">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <h3>Additional checks</h3>
                        </div>
                        <div class="col-md-3"></div>
                    </div>

                    <div class="form-row mx-5">
                        <?php
                        $trques = mysqli_query($con, "SELECT * FROM `tbl_truckques`");
                        $t = 1;
                        foreach ($trques as $tdata) {

                            ?>

                            <div class="col-md-4 mb-3 col-sm-6">
                                <label for="validationTooltip01"><?php echo $t . " )  " . $tdata['question']; ?></label>
                            </div>
                            <div class="col-md-8 col-sm-6">
                                <input id="validationTooltip01" type="radio" placeholder="Name" required="required"
                                    name="ques<?php echo $tdata['id']; ?>" value="Yes" /> Yes
                                <input id="validationTooltip01" class="ml-3" type="radio" placeholder="Name"
                                    required="required" name="ques<?php echo $tdata['id']; ?>" value="No" /> No

                            </div>

                            <?php
                            $t++;
                        } ?>


                    </div>


                    <button class="btn btn-primary" type="submit" name="submit">Submit </button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php
if (isset($_POST['submit'])) {
    $name = $_POST['dname'];
    $vehicle = $_POST['vehicle'];
    $tdate = $_POST['tdate'];
    $tdname = $_POST['tdname'];
    $tdcomment = $_POST['tdcomment'];

    $user = $_SESSION['user'];

    $tans = array();
    
    foreach($trques as $tpdata){
        $tans[$tpdata['id']] = $_POST['ques'.$tpdata['id']];
    }
  $ans = implode(';',$tans);
  $sql = "INSERT INTO `tbl_truckc`(`name`, `vehicle`, `tdate`, `cmnt`, `tselct`, `ansall`,sign) 
  VALUES ('$name','$vehicle','$tdate','$tdcomment','$tdname','$ans','$user')";
//   print_r($sql);die;

    $sql1 = mysqli_query($con, $sql);
    if($sql1){
        ?>
         <script>
             document.location.href='admin.php?id=trcheck';
         </script>
        <?php
    }
        
    
}
?>