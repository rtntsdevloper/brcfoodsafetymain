<?php
include 'connection.php';
$sno = $_GET['sno'];
$sid = $_GET['sid'];
$date = $_GET['date'];
?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href=""></a></li>
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=weightcontrol2&sno=<?php echo $sno ?>&date=<?php echo $date ?>">
                    <button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button>
                </a>

                <div class="card-title">WEIGHT CONTROL CHECKS</div>

                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Finish Time</label>
                            <input class="form-control" id="validationTooltip01" type="time" required name="end" />
                            <div class="invalid-tooltip">
                                Please provide a valid time.
                            </div>
                        </div>
                    </div>
                    <br>
                    <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['submit'])) {
    $end = $_POST['end'];
    // echo "UPDATE `weightcontrol1` SET `end`=' $end'  where  id=$sid and sno='$sno' ";die;
    $update = mysqli_query($con, "UPDATE `weightcontrol1` SET `end`=' $end'  where  id=$sid and sno='$sno' ");

    if ($update) {
        echo "<script>window.location.href='admin.php?id=weightcontrolsign&sno=$sno&sid=$sid&date=$date'</script>";
    }
}
?>