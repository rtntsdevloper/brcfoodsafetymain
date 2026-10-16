<?php

$bid = $_GET['bid'];
$sql = mysqli_query($con,"SELECT * FROM `save_specification_m` WHERE `id`='$bid'");
$data = mysqli_fetch_array($sql);


?>
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
                                    <input type="text" name="sectname" id="" class="form-control" required value="<?php echo $data['name']; ?>">

                                </div>
                                 <div class="col-md-6">
                                    <label for="validationTooltip01">Minimum Limit</label>
                                    <input type="text" name="miniumlimit" id="" class="form-control" required value="<?php echo $data['min']; ?>">

                                </div>
                                 <div class="col-md-6">
                                    <label for="validationTooltip01">Maximum Limit</label>
                                    <input type="text" name="maximumlimit" id="" class="form-control" required value="<?php echo $data['max']; ?>">

                                </div>
                                 <div class="col-md-6">
                                    <label for="validationTooltip01">Frequency</label>
                                    <input type="text" name="frequency" id="" class="form-control" required value="<?php echo $data['freq']; ?>">

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
    $sectname = $_POST['sectname'];
    $miniumlimit = $_POST['miniumlimit'];
    $maximumlimit = $_POST['maximumlimit'];
    $frequency = $_POST['frequency'];

    $sql1 = mysqli_query($con, "UPDATE `save_specification_m` SET `name`='$sectname', `min`='$miniumlimit', `max`='$maximumlimit', `freq`='$frequency' WHERE `id`='$bid'");

    if($sql1){
        ?>
<script>
    
    window.location.href="admin.php?id=microbio";
</script>
        <?php
    }

}
    


?>