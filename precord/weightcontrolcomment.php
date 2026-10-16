<?php
$sno = $_GET['sno'];
$date = $_GET['date'];
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
                <a href="admin.php?id=weightcontrol1&date=<?php echo $date; ?>"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

                <div class="card-title">WEIGHT CONTROL CHECKS</div>


                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Average Product Weight</label>
                            <input class="form-control" id="validationTooltip01" type="text" required="required" name="pweight" />
                            <div class="invalid-tooltip">
                                Please provide a valid first name.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Giveaway</label>
                            <input class="form-control" id="validationTooltip01" type="text" required="required" name="give" />
                            <div class="invalid-tooltip">
                                Please provide a valid first name.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Comment</label>
                            <textarea name="comment" class="form-control"></textarea>
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

<?php
if (isset($_POST['submit'])) {
    $comment = $_POST['comment'];
    $give = $_POST['give'];
    $pweight = $_POST['pweight'];


    // echo "UPDATE `weightcontrol` SET `comment`=' $comment',`give`='$give'  where  id=$sno and date='$date' ";die;
    $update = mysqli_query($con, "UPDATE `weightcontrol` SET `comment`=' $comment',`give`='$give',`average`='$pweight'  where  id=$sno and date='$date' ");

    if ($update) {
        echo "<script>window.location.href='admin.php?id=weightcontrol1&date=$date'</script>";
    }
}
?>