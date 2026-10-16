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
                <a href="admin.php?id=weightcontrol"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

                <div class="card-title">WEIGHT CONTROL CHECKS</div>


                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Date</label>
                            <input class="form-control" id="validationTooltip01" type="date" required="required" name="date" />
                            <div class="invalid-tooltip">
                                Please provide a valid first name.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Min Net Weight</label>
                            <input type="text" name="netweight" id="" class="form-control">
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Min Gross Weight</label>
                            <input type="text" name="grossweight" id="" class="form-control">
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>




                    </div>
                    </br>
                    <button class="btn btn-primary" type="submit" name="submit">Submit </button>
            </div>


        </div>




        </form>
    </div>
</div>
</div>

<?php

if (isset($_POST['submit'])) {

    $date = $_POST['date'];
    $netweight = $_POST['netweight'];
    $grossweight = $_POST['grossweight'];

    // echo "INSERT INTO `weightcontrol`(`date`, `netweight`, `grossweight`) VALUES ('$date','$netweight','$grossweight' )";die;

    $insert = mysqli_query($con, "INSERT INTO `weightcontrol`(`date`, `netweight`, `grossweight`) VALUES ('$date','$netweight','$grossweight' )");

    if ($insert) {
        echo "<script>window.location.href='admin.php?id=weightcontrol'</script>";
    }
}


?>