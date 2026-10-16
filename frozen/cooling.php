<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Traceability</a></li>
            <li>View Detail</li>
        </ul>
    </div>

    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <a href="admin.php?id=fcooking"> <button class="btn btn-info" style="float:right; margin-left:15px" type="button">Go Back</button></a>
                    <h4 class="card-title mb-3">Cooling Records</h4>

                    <form class="needs-validation" novalidate="novalidate" method="post" action="" enctype="multipart/form-data">

                        <div class="form-row">

                            <div class="col-md-6"><br>
                                <label for="validationTooltip04">Freezer No.</label>
                                <input type="text" id="validationTooltip04" name="freezerno" class="form-control">
                                <div class="invalid-tooltip">
                                    Please fill the field.
                                </div>
                            </div>

                            <div class="col-md-6"><br>
                                <label for="validationTooltip05">Temperature of Freezer</label>

                                <div class="input-group mb-3">
                                    <input type="number" id="validationTooltip05" name="cooltemp" class="form-control" required>
                                    <span class="input-group-text" id="basic-addon2">°C</span>
                                </div>
                                <div class="invalid-tooltip">
                                    Please fill the field.
                                </div>
                            </div>

                        </div>

                        <br />
                        <button class="btn btn-primary" type="submit" name="submit">Submit </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>


<?php
$batch = $_GET['batch'];
if (isset($_POST['submit'])) {
    $freezerno = $_POST['freezerno'];

    $cooltemp = $_POST['cooltemp'];
    $sql = mysqli_query($con, "UPDATE `frozencooking` SET `cooltemp`='$cooltemp' , `freezerno`='$freezerno' WHERE productbatch='$batch' ");


?>
    <script language="javascript">
        window.open('admin.php?id=fcooking', '_self');
    </script>
<?php }
?>