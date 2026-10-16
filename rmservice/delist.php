<?php

$view = $_GET['view'];
$status = $_GET['status'];

if (isset($_POST['submit'])) {
    $nhdate = $_POST['nhdate'];
    if ($status == 'Active') {
        $kist = mysqli_query($con, "UPDATE tblrawsupplier SET `status`='Delisted' WHERE supid='$view'");
        $inst = mysqli_query($con, "INSERT INTO `tbldelist`(`pid`,`type`,`status`,`rdate`) VALUES ('$view','SUP','Delisted','$nhdate')");
    } else {
        $kist = mysqli_query($con, "UPDATE tblrawsupplier SET `status`='Active' WHERE supid='$view'");
        $inst = mysqli_query($con, "INSERT INTO `tbldelist`(`pid`,`type`,`status`,`rdate`) VALUES ('$view','SUP','Listed','$nhdate')");
    }
    if ($kist && $inst) {
        echo "<script>
         document.location.href='admin.php?id=supplier-management';
         </script>";
    } else {
    }
}
?>


<div class="row mb-12 ">
    <div class="col-md-12 ">
        <div class="card text-left ml-5" style="margin-top:8%;">
            <div class="card-body">

                <a href="admin.php?id=question"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>




                <h4 class="card-title mb-3">Supplier List/Delist</h4>


                <!-- <div class="row ml-5"> -->





                <form class="needs-validation my-5" novalidate="novalidate" method="post" action=""
                    enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="col-md-6">

                            <label for="validationTooltip01">Date</label>
                            <input type="date" name="nhdate" id="" class="form-control">
                        </div>
                        <div class="col-md-12 mt-5">
                            <input type="submit"  name="submit" class="btn btn-primary">
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>