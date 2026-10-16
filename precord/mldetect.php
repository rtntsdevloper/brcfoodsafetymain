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

                <div class="card-title">Metal Detectable Stationary Record
                </div>


                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Delivery Date</label>
                            <input class="form-control" id="validationTooltip01" type="date" required="required" name="idate" />
                            <div class="invalid-tooltip">
                                Please provide a valid first name.

                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Issue To</label>
                            <input class="form-control" id="validationTooltip02" type="text" placeholder="name" name="issuenm" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Description</label>
                            <textarea name="desc" id="" class="form-control"></textarea>
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Issue By</label>
                            <input class="form-control" id="validationTooltip02" type="text" placeholder="name" name="issueby" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                 

                  
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip03">Is Used stationary retured?</label>
                            <select name="retured" id="return" class="form-control">
                                <option value="">Select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip04">Checked By</label>
                            <input name="checkedby" type="text" class="form-control" id="validationTooltip05" required="required" />
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
    $issuenm = $_POST['issuenm'];
    $desc = $_POST['desc'];
    $issueby = $_POST['issueby'];
    $retured = $_POST['retured'];
    $checkedby = $_POST['checkedby'];
    $adate = date('Y-m-d H:i:s');
 

    $nrk = mysqli_query($con,"select * from `tbl_stationary` ");
					$nrk1 = mysqli_num_rows($nrk);
					$nrkn = $nrk1 + 1;

					$record = "STR".date('Ymd').$nrkn;



    $sq = "INSERT INTO `tbl_stationary`(`issue`, `issueby`, `desc`, `return`, `checkby`, `issueon`, `adate`, `user`,`scode`) VALUES ('$issuenm','$issueby','$desc','$retured','$checkedby','$date','$adate','$user','$record')";
    $result = mysqli_query($con, $sq);

     if ($result) {
       
        echo '<script> window.location.href = "admin.php?id=ssign&rid=' . $record . '";</script>';
    }
}

?>