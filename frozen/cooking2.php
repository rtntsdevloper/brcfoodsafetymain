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
                    <h4 class="card-title mb-3">Cooking Records</h4>

                    <form class="needs-validation" novalidate="novalidate" method="post" action="" enctype="multipart/form-data">

                        <div class="form-row">
                           

                             <div class="col-md-6"><br>
                                <label for="validationTooltip06">End Time</label>
                                <input type="time" id="validationTooltip06" name="endtime" class="form-control">
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
$batch=$_GET['batch'];
if (isset($_POST['submit'])) {
    $endtime=$_POST['endtime'];

    $sql = mysqli_query($con, "UPDATE `frozencooking` SET `endtime`='$endtime' WHERE productbatch='$batch' ");


?>
    <script language="javascript">
        window.open('admin.php?id=fcooking', '_self');
    </script>
<?php }
?>