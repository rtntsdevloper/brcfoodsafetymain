<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href=""></a></li>
            <!-- <li>Add Auditor</li> -->
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">


            <div class="card-body">
                <a href="admin.php?id=dist_mixing"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

                <div class="card-title">Pestuerization Record (Minimum 72<sup>o</sup>C for 10 minutes) 
                </div>


                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Actual End time of CCP</label>
                            <input class="form-control" name="cooktime" type="time" required="required" name="cookstart" required="required"/>
                            <div class="invalid-tooltip">
                                Please provide a valid first name.

                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Actual Temperature of CCP at End time</label>
                            <div class="input-group mb-3">
                                <input type="number" step="0.01" name="cooktemp" id="disttime" class="form-control" required="required">
                                <div class="input-group-append">
                                    <span class="input-group-text"><sup>o</sup>C</span>
                                </div>
                            </div>
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                    
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Total time at CCP cooking temperature(minutes)</label>
                            <div class="input-group mb-3">
                                <input type="number" step="0.01" name="totaltime" id="acttemp" class="form-control" required="required">
                                <div class="input-group-append">
                                    <span class="input-group-text">Minutes</span>
                                </div>
                            </div>
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="validationTooltip02">Comment(if any)</label>
                            <textarea type="text" name="comment" id="comment" class="form-control"></textarea>
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>

                        </div>

                        </br>
                        </br>
                        <div class="col-md-12">
                            <button class="btn btn-primary" type="submit" name="btn">Submit data</button>
                        </div>




                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php

if (isset($_POST['btn'])) {
    $tid =$_GET['tid'];

    $cid =$_GET['cid'];
    $startuser = $_SESSION['user'];
    $cookstart = mysqli_real_escape_string($con, $_POST['cooktime']);
    $cooktemp = mysqli_real_escape_string($con, $_POST['cooktemp']);
    $totaltime =  $_POST['totaltime']." minutes";
    $comment = mysqli_real_escape_string($con, $_POST['comment']);
    $enduser = $_SESSION['user'];
    $update = date("Y-m-d H:i:s");

    

    $insert = mysqli_query($con, "UPDATE `dist_pestu` SET `actualetime`='$cookstart',`actualendt`='$cooktemp',`totaltime`='$totaltime',`cmnt`='$comment',`enduser`='$enduser',`uppdate`='$update' WHERE id='$cid'");
    $rowsid = mysqli_insert_id($con);
    $update = mysqli_query($con, "UPDATE `dist_mixrecord` SET `pestend`='done' WHERE id ='$tid'");
    if ($insert) {
        echo "<script> window.location.href = 'admin.php?id=dist_mixing'; </script>";
    } 
}



?>
