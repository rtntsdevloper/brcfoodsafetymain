<?php
include 'connection.php';
?>


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
                <a href="admin.php?id=mldetect1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

                <div class="card-title">Wastage Record
                </div>


                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Date</label>
                            <input class="form-control" id="validationTooltip01" type="date" required="required" name="idate" />
                            <div class="invalid-tooltip">
                                Please provide a valid first name.

                            </div>
                        </div>
                         <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Area</label>
                            <input type="text" name="area" id="" class="form-control">
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Type of Waste</label>
                          <select name="type" id="" class="form-control">
                            <option value="">Select</option>
                            <option value="Ingredient">Ingredient</option>
                            <option value="Products">Products</option>
                            <option value="Packaging Material">Packaging Material</option>
                          </select>
                            <div class="invalid-tooltip">
                                Please fill the field.
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Name of Product/Packaging/Ingredient</label>
                            <input type="text" name="name" id="" class="form-control">
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Batch No./BB/UB No.</label>
                            <input class="form-control" id="validationTooltip02" type="text" placeholder="name" name="batch" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Quantity</label>
                            <input class="form-control" id="validationTooltip02" type="text" placeholder="name" name="qty" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                          <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Reason for Wastage</label>
                            <input class="form-control" id="validationTooltip02" type="text" placeholder="name" name="reason" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                 

                  
                        
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip04">Action Taken</label>
                            <input name="action" type="text" class="form-control" id="validationTooltip05" required="required" />
                            <div class="invalid-tooltip">
                                Please fill the field.
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip04">Action Taken By</label>
                            <input name="actionby" type="text" class="form-control" id="validationTooltip05" required="required" />
                            <div class="invalid-tooltip">
                                Please fill the field.
                            </div>
                        </div>
                   
                     </div>
            </div>

        </div>



        </br>
        <button class="btn btn-primary" type="submit" name="submit">Submit </button>
        </form>
    </div>
</div>
</div>

<?php

if (isset($_POST['submit'])) {

    $date = $_POST['idate'];
    $type = $_POST['type'];
    $name = $_POST['name'];
    $batch = $_POST['batch'];
    $qty = $_POST['qty'];
    $reason = $_POST['reason'];
    $action = $_POST['action'];
    $actionby = $_POST['actionby'];
    $adate = date('Y-m-d H:i:s');
    $area = $_POST['area'];

    $nrk = mysqli_query($con,"select * from `tbl_wastage` ");
					$nrk1 = mysqli_num_rows($nrk);
					$nrkn = $nrk1 + 1;

					$record = "WST".date('Ymd').$nrkn;



    $sq = "INSERT INTO `tbl_wastage`(`date`, `type`, `name`, `batch`, `qty`, `action`, `actionby`, `reason`, `cdate`, `user`, `wcode`, `area`) VALUES ('$date','$type','$name','$batch','$qty','$action','$actionby','$reason','$adate','$user','$record','$area')";
    $result = mysqli_query($con, $sq);

     if ($result) {
       
        echo '<script> window.location.href = "admin.php?id=wastage";</script>';
    }
}

?>