<?php
$mid = $_GET['mid'];







?>
<style>
    .hidden {
        display: none;
    }
</style>

<div class="container-fluid">

    <div class="main-content">
        <div class="breadcrumb">
            <h1 class="mr-2"><?php echo $headingname; ?></h1>
            <ul>
                <li><a href="">Micro Trending</a></li>
                <li>Attempt Micro Trending</li>
            </ul>
        </div>


        <div class="container-fluid">




            <div class="col-md-12 mt-5 mb-5">
                <div class="card">
                    <div class="card-body">


                        <div class="row">
                            <div class="col-md-6">
                                <div class="card-title">Attempt Micro Trending</div>
                            </div>
                            <div class="col-md-6">
                                 
                                <a href="admin.php?id=microview" class="btn btn-success ml-3" style="float: right;">Go Back</a>
                                <a href="admin.php?id=microraise&mid=<?php echo $mid; ?>" class="btn btn-info  ml-3" style="float: right;">Add Justification</a>
                            </div>
                        </div>
                        <form class="needs-validation" novalidate="novalidate" method="post" name="form2" action="" enctype="multipart/form-data">
                            <div class="form-row">
                                <div class="col-md-6 col-sm-12">
                                    <label for="validationTooltip01">Sampling Date</label>
                                    <input type="date" class="form-control" name="sampdate" required>
                                    <div class="invalid-tooltip">
                                        Please provide Sampling Date.
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 ">
                                    <label for="validationTooltip01">Sample Testing Date</label>
                                    <input class="form-control" id="validationTooltip01" type="date" placeholder="Sub-Section" required="required" name="samptest" />
                                    <div class="invalid-tooltip">
                                        Please provide Sample Testing Date.
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 mt-3">
                                    <label for="validationTooltip01">Date of issue</label>
                                    <input class="form-control" id="validationTooltip01" type="date" placeholder="Sample No." required="required" name="issuedate" />
                                    <div class="invalid-tooltip">
                                        Please provide Date of issue.
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 mt-3">
                                    <label for="validationTooltip01">Report No.</label>
                                    <input class="form-control" id="validationTooltip01" type="text" placeholder="Report no" required="required" name="report" />
                                    <div class="invalid-tooltip">
                                        Please provide Report No.
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-12 mt-3">
                                    <label for="validationTooltip01">Status</label>
                                    <select name="status" class="form-control" onchange="statusChanged(this.value)" required>
                                        <option disabled selected>Select Status</option>
                                        <option value="Pass">Pass</option>
                                        <option value="Fail">Fail</option>
                                    </select>


                                    <div class="invalid-tooltip">
                                        Please provide status.
                                    </div>
                                </div>
                                <script>
                                    function statusChanged(val) {
                                        console.log(val);
                                        const contain = document.getElementById('contain');
                                        if (val === "Fail") {
                                            contain.classList.remove('hidden');
                                        } else {
                                            contain.classList.add('hidden');
                                        }
                                    }
                                </script>

                                <div class="col-md-6 col-sm-12 mt-3">
                                    <label for="validationTooltip01">Upload Report</label>
                                    <input class="form-control" id="validationTooltip01" type="file" required="required" name="file" />
                                    <div class="invalid-tooltip">
                                        Please provide a valid name.
                                    </div>
                                </div>
                            </div>
                            <div class="row hidden" id="contain">
                                <div class="col-md-6 col-sm-12 mt-3">
                                    <label for="validationTooltip01">Corrective action taken</label>
                                    <textarea class="form-control" name="remark"></textarea>
                                    <div class="invalid-tooltip">
                                        Please provide a valid name.
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 mt-3">
                                    <label for="validationTooltip01">Is restesting shall be done as corrective action?</label>
                                    <select name="fstatus" id="" class="form-control">
                                        <option disabled selected>Select Status</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>


                                    <div class="invalid-tooltip">
                                        Please provide status.
                                    </div>
                                </div>

                            </div>


                            <br />

                            <button class="btn btn-primary" type="submit" name="submit">Submit </button>
                        </form>
                    </div>
                </div>
            </div>




            <?php

            if (isset($_POST['submit'])) {
                $sampdate = $_POST['sampdate'];
                $samptest = $_POST['samptest'];
                $issuedate = $_POST['issuedate'];
                $report = $_POST['report'];
                $status = $_POST['status'];
                $attempton = date('d-m-y h:i');
                $user = $_SESSION['user'];

                $fsatus = $_POST['fstatus'];

                $remark = $_POST['remark'];

                if (isset($_FILES['file']['name']) && !empty($_FILES['file']['name'])) {
                    $unique = "micro" . date('dmYhis');
                    $file = $unique . $_FILES['file']['name'];
                    $target = "micro/upload/" . $file;
                    if (move_uploaded_file($_FILES['file']['tmp_name'], $target)) {
                        $upfile = $file;
                    } else {
                        $upfile = "";
                    }
                } else {
                    $upfile = "";
                }
                $testm = mysqli_query($con, "select * from tbl_microtrending1 where eid='$mid'");
                $testmn = mysqli_num_rows($testm);
                if($testmn>0){
                    $retest = 'Yes';
                }else{
                    $retest ='';
                }



                $mstid = mysqli_query($con, "INSERT INTO `tbl_microtrending1`(`eid`, `attempt_on`, `user`,`sample`, `issue`, `testing`, `report`, `reportno`, `status`,`remark`,`fstatus`,`retest`) VALUES ('$mid','$attempton','$user','$sampdate','$issuedate','$samptest','$upfile','$report','$status','$remark','$fsatus','$retest')");

                $mstidq = mysqli_query($con, "update tbl_microtrending set status='$status',fstatus='$fsatus' where id='$mid'");
                if ($mstid) {
                    echo "<script>alert('Data Updated Successfully!');
                    window.location.href='admin?id=microtrending';</script>";
                }
            }
            ?>