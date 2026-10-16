
<div class="main-content">

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Add Specification </div>
                        <a href="admin.php?id=microbio"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

                        <form name="form1" class="needs-validation" novalidate="novalidate" method="post" action="" enctype="multipart/form-data">
                            <div class="form-row">




                                <div class="col-md-6">
                                    <label for="validationTooltip01">Name</label>
                                    <input type="text" name="sectname" id="" class="form-control" required>

                                </div>
                                 <div class="col-md-6">
                                    <label for="validationTooltip01">Minimum Limit</label>
                                    <input type="text" name="miniumlimit" id="" class="form-control" required>

                                </div>
                                 <div class="col-md-6">
                                    <label for="validationTooltip01">Maximum Limit</label>
                                    <input type="text" name="maximumlimit" id="" class="form-control" required>

                                </div>
                                 <div class="col-md-6">
                                    <label for="validationTooltip01">Frequency</label>
                                    <input type="text" name="frequency" id="" class="form-control" required>

                                </div>


                            </div>



                            <br />

                            <button class="btn btn-success" type="submit" name="submit">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['submit'])) {
    $sectname = htmlspecialchars($_POST['sectname']);
    $miniumlimit = htmlspecialchars($_POST['miniumlimit']);
    $maximumlimit = htmlspecialchars($_POST['maximumlimit']);
    $frequency = htmlspecialchars($_POST['frequency']);

    $sql1 = mysqli_query($con,"INSERT INTO `save_specification_m`(`name`, `min`, `max`, `freq`) VALUES ('$sectname','$miniumlimit','$maximumlimit','$frequency')");

    if($sql1){
        ?>
<script>
    
    window.location.href="admin.php?id=microbio";
</script>
        <?php
    }

}
    


?>