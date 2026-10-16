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

                <div class="card-title">CCP - FILTRATION (500 micron filter to be in place and free from
damage) 
                </div>


                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="col-md-12">
                            <h2>Filter check(presence & integrity check)</h2>
                            <br>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">At Start-up</label>
                            <select name="filterstatus" id="filterstatus" class="form-control" required>
                                <option value="">Select</option>
                                <option value="Present&Intact">Present & Intact</option>
                                <option value="Absent or damaged">Absent or damaged</option>
                                
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Comments:(if foreign bodies or damage is found on the filter)</label>
                          <textarea name="filterremarks" id="filterremarks" class="form-control"></textarea>
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
   $startstatus = $_POST['filterstatus'];
   $startcmnt = $_POST['filterremarks'];
    
    

    $insert = mysqli_query($con, "INSERT INTO `dist_filter`(`tid`,`start`, `startcmnt`) VALUES ('$tid','$startstatus','$startcmnt')");
    $rowsid = mysqli_insert_id($con);
    $update = mysqli_query($con, "UPDATE `dist_mixrecord` SET `filtstart`='$rowsid' WHERE id ='$tid'");
    if ($insert) {
        echo "<script> window.location.href = 'admin.php?id=dist_filtsign&nid=1&rid=$rowsid'; </script>";
    } 
}



?>
