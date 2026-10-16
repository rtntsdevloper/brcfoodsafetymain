<?php
include 'connection.php';
$bid = $_GET['bid'];
$pid = $_GET['tid'];
?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>Add Blast Chiller Log</li>
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=sauce&tid=<?php echo $pid; ?>"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

                <?php
                $sq = mysqli_query($con, "SELECT * FROM tblhot where id=$bid");
                $row = mysqli_fetch_assoc($sq);
                ?>

                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data" action="">
                    <div class="form-row mt-5">
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Date</label>
                            <input class="form-control" id="validationTooltip01" type="date" required="required" name="date" value="<?php echo $row['date']; ?>" readonly />
                            <div class="invalid-tooltip">
                                Please provide a valid date.
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Product Name</label>
                            <input class="form-control" id="validationTooltip02" type="text" placeholder="" name="product" value="<?php echo $row['product']; ?>"  readonly />
                            <div class="invalid-tooltip">
                                Please fill the field.
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Batch Code</label>
                            <input class="form-control" id="validationTooltip02" type="text" placeholder="" value="<?php echo $row['batchcode']; ?>" name="batchcode"  readonly />
                            <div class="invalid-tooltip">
                                Please fill the field.
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Start Time</label>
                            <input class="form-control" id="validationTooltip02" type="time" placeholder="" value="<?php echo $row['time']; ?>" name="time"  readonly />
                            <div class="invalid-tooltip">
                                Please fill the field.
                            </div>
                        </div>

                       <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Product Temp (>82C)</label>
                             <div class="input-group mb-2">
 
                                <input type="number" class="form-control" id="inlineFormInputGroup" name="ptemp" value="<?php echo $row['ptemp'];  ?>" placeholder="temperature"  readonly>
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><sup>o</sup>C</div>
                                </div>
                            </div>
                        </div>
                         </div>
                         <div class="form-row mt-3">
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Finish Time</label>
                            <input class="form-control" id="validationTooltip02" type="time" placeholder="" name="time1" required />
                            <div class="invalid-tooltip">
                                Please fill the field.
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Product Temp (>82C)</label>
                             <div class="input-group mb-2">
 
                                <input type="number" class="form-control" id="inlineFormInputGroup" name="ptemp1" placeholder="temperature" required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><sup>o</sup>C</div>
                                </div>
                            </div>
                        </div>
                   </div>
                    <div class="p-2" style="border: 1px solid gray; border-radius:5px;">
                            <h5 style="color: red;"> <b>Sauce Hot filling core temp must be >82°C or above. </b> </h5>
                        </div>
                    <button class="btn btn-primary mt-2" type="submit" name="submit">Save & Next</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['submit'])) {
    $sccp = $_POST['time1'];
    $tccp = $_POST['ptemp1'];

    // Debugging: Check what values are being received
    error_log("Updating record $bid with time1: $sccp, ptemp1: $tccp");

    $pk = mysqli_query($con, "SELECT * FROM `tblhot`");
    $pk1 = mysqli_num_rows($pk);
    $pk2 = $pk1 + 1;
    $record = "sac00" . $pk2;

    $sql = "UPDATE tblhot SET time1='$sccp', ptemp1='$tccp', recordid='$record' WHERE id='$bid'";
    
    if (mysqli_query($con, $sql)) {
        if (mysqli_affected_rows($con) > 0) {
            echo "<script>window.location.href='admin.php?id=hotsign&rid=".$record. "&tid=" . $pid . "';</script>";
        } else {
            echo "<script>alert('No rows were updated. Check if the ID exists.');</script>";
        }
    } else {
        echo "<script>alert('Error updating record: " . mysqli_error($con) . "');</script>";
    }
}
?>