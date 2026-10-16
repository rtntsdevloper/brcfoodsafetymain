<?php

$sno = $_GET['tid'];

?>

<div class="main-content">



    <div class="col-md-12">
        <div class="card">
            <div class="card-body">

                <a href="admin.php?id=package"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

                <div class="card-title">Verify</div>


                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data" action="">
                    <div class="form-row mt-5">



                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip01">Corrective Action(if any)</label>
                            
                                <textarea name="cmnt" id="" class="form-control"></textarea>
                                
                         

                            <div class="invalid-tooltip">
                                Please provide a valid date.

                            </div>
                        </div>


                    </div>

                    </br>
                    <button class="btn btn-primary" type="submit" name="submit">Verify & Sign</button>
                </form>
            </div>
        </div>
    </div>

    <?php

    if (isset($_POST['submit'])) {
        $tproduce = $_POST['cmnt'];
        // print_r("UPDATE tblmetaldetect` SET `comment`='$tproduce' WHERE DATE_FORMAT(datetime, '%Y-%m-%d')='$sno'");die;

        $sql = mysqli_query($con, "UPDATE tblmetaldetect SET `comment`='$tproduce' WHERE id='$sno'");

        if ($sql) {

            echo "<script>window.location.href='admin.php?id=metalsign&sno=" . $sno . "';</script>";
        } else {
            echo "<script>alert('Error adding record: " . mysqli_error($con) . "');</script>";
        }
    }


    ?>