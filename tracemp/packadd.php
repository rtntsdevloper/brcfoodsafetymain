<?php
$pid = $_GET['bid'];

$pdn  = "select * from tbllabel where id='$pid'";
$pdn1 = mysqli_query($con, $pdn);
$pdn2 = mysqli_fetch_array($pdn1);
$grnpx  = $pdn2['prdbatch'];
$prodend = $pdn2['prodid'];

?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>Packaging and Label Check</li>
        </ul>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h3 style="float:left;">Add Packaging and Label</h3>
                <a href="admin.php?id=package"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

                <!-- <div class="card-title">Add Defrost Record</div> -->


                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data" action="">
                    <div class="form-row mt-5">


                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip01">Total Packs Produced</label>
                            <input class="form-control" id="validationTooltip01" type="text" required="required" name="tproduce" />
                            <div class="invalid-tooltip">
                                Please provide a valid date.

                            </div>
                        </div>



                        <div class="col-md-4 mb-3 pl-5">
                            <label for="validationTooltip01">Is Product Finished Completely?</label>
                            <div class="input-group mb-3">

                                <input type="radio" name="prdweight" value="Yes" required> Yes
                                <input type="radio" name="prdweight" value="No" class="ml-3" required> No
                            </div>

                            <div class="invalid-tooltip">
                                Please provide a valid date.

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip01">Packaging End Weight</label>
                            <div class="input-group mb-3">

                                <input type="number" class="form-control" id="weight" name="packweight" required>
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Kg</span>
                                </div>
                            </div>

                            <div class="invalid-tooltip">
                                Please provide a valid date.

                            </div>
                        </div>
                        <div class="col-md-6 mb-3 pl-3">
                            <label for="validationTooltip01">Is Label checked?</label>
                            <br>
                            <input type="radio" name="label_checked" value="Yes" required> Yes
                            <input type="radio" name="label_checked" value="No" required> No
                            <div class="invalid-tooltip">
                                Please provide a valid date.

                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12">
                            <label for="cc-exp" class="control-label mb-1">Any Additional Batch Used</label>
                            <select name="adbatch" class="form-control" id="dspq">
                                <option>-- Please Select --</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>


                    </div>





                    </br>
                    <button class="btn btn-primary" type="submit" name="submit">Submit </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php

if (isset($_POST['submit'])) {
    $tproduce = $_POST['tproduce'];
    $pname = $_POST['prdweight'];
    $pdate = $_POST['packweight'];
    $label = $_POST['label_checked'];

    $adbatch = $_POST['adbatch'];
    

    $sql = "UPDATE `tbllabel` SET `tproduce`='$tproduce',`label_checked`='$label',`prodend`='$pname',`packend`='$pdate',`produceleft`='$tproduce',`adbatch`='$adbatch' WHERE id='$pid'";
    
    $qs = mysqli_query($con, $sql);

    $prodsql = "UPDATE `tblgrn1` SET `leftqty`='$pdate' WHERE grn='$grnpx'";
  
    $prodsql1 = mysqli_query($con, $prodsql);


    if ($qs && $prodsql1) {
        
        if ($adbatch == "Yes") {
            
            echo "<script>window.location.href='admin.php?id=packadd2&pid=".$pid."&fid=".$prodend."';</script>";
        } else {
            echo "<script>window.location.href='admin.php?id=package';</script>";
        }
    }



}


?>