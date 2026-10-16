<?php
include 'connection.php';
$bid = isset($_GET['bid']) ? $_GET['bid'] : 0;
$pid=$_GET['tid'];
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
                <a href="admin.php?id=blast"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

                <?php
                $sq = mysqli_query($con, "SELECT * FROM tblblast WHERE id = '$bid'");
                $row = mysqli_fetch_array($sq);
                ?>

                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data" action="">
                    <div class="form-row mt-5">
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Date</label>
                            <input class="form-control" id="validationTooltip01" type="date" required="required" name="date" readonly value="<?php echo $row['date']; ?>" />
                            <div class="invalid-tooltip">
                                Please provide a valid date.
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Product Name</label>
                            <input class="form-control" id="validationTooltip02" type="text" placeholder="" name="product" readonly required value="<?php echo $row['product']; ?>" />
                            <div class="invalid-tooltip">
                                Please fill the field.
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Time</label>
                            <input class="form-control" id="validationTooltip02" type="time" placeholder="" name="time" readonly required value="<?php echo $row['time']; ?>"/>
                            <div class="invalid-tooltip">
                                Please fill the field.
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip03">Quantity</label>
                            <input class="form-control" id="validationTooltip04" type="number" required="required" name="qty" readonly value="<?php echo $row['qty']; ?>" />
                            <div class="invalid-tooltip">
                                Please fill the field.
                            </div>
                        </div>
                    </div>
                    
                    <h4 class="mt-4">Start Time</h4>
                    <div class="form-row mt-2">
                        <div class="col-md-6">
                            <div class="heading-tab" data-target="sub-tabs-1" required>
                                <h6>Blast Chiller </h6>
                            </div>
                            <div class="sub-tabs" id="sub-tabs-1">
                                <label>Start Time</label>
                                <input name="th1" type="time" class="form-control" required value="<?php echo $row['th1']; ?>" readonly>

                                <label for="" class="mt-3">Temperature</label>
                                <div class="input-group mb-2 ">
 
                                <input type="number" class="form-control" id="inlineFormInputGroup" name="th2" placeholder="Temperature" readonly >
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><sup>o</sup>C</div>
                                </div>
                            </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="heading-tab" data-target="sub-tabs-2">
                                <h6> Product </h6>
                            </div>
                            <div class="sub-tabs" id="sub-tabs-2">
                                <label>Time</label>
                                <input name="ch1" type="time" class="form-control" required value="<?php echo $row['ch1']; ?>" readonly>

                                <label for="" class="mt-3">Temperature</label>
                                <div class="input-group mb-2 ">
 
                                <input type="number" class="form-control" id="inlineFormInputGroup" name="ch2" placeholder="Temperature" readonly >
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><sup>o</sup>C</div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>

                    <h4 class="mt-5">Finish Time</h4>

                    <div class="form-row mt-2">
                        <div class="col-md-6">
                            <div class="heading-tab" data-target="sub-tabs-1" required>
                                <h6>Blast Chiller </h6>
                            </div>
                            <div class="sub-tabs" id="sub-tabs-1">
                                <label>Finish Time</label>
                                <input name="finishtime1" type="time" class="form-control" required value="<?php echo isset($row['finishtime1']) ? $row['finishtime1'] : ''; ?>">

                                <label for="" class="mt-3">Temperature</label>
                                <div class="input-group mb-2 ">
 
                                <input type="number" class="form-control" id="inlineFormInputGroup" name="temp1" placeholder="Temperature" required >
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><sup>o</sup>C</div>
                                </div>
                            </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="heading-tab" data-target="sub-tabs-2">
                                <h6> Product </h6>
                            </div>
                            <div class="sub-tabs" id="sub-tabs-2">
                                <label>Finish Time</label>
                                <input name="finishtime2" type="time" class="form-control" required value="<?php echo isset($row['finishtime2']) ? $row['finishtime2'] : ''; ?>">

                                <label for="" class="mt-3">Temperature</label>
                                 <div class="input-group mb-2 ">
 
                                <input type="number" class="form-control" id="inlineFormInputGroup" name="temp2" placeholder="Temperature" required >
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><sup>o</sup>C</div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>


                    <style>
                        .heading-tab {
                            cursor: pointer;
                            padding: 10px;
                            background-color: #f8f9fa;
                            border: 1px solid #dee2e6;
                            border-radius: 4px;
                            margin-bottom: 5px;
                        }

                        .heading-tab h6 {
                            margin: 0;
                        }

                        .sub-tabs {
                            padding: 10px;
                            border: 1px solid #dee2e6;
                            border-top: none;
                            border-radius: 0 0 4px 4px;
                        }
                    </style>

                    <button class="btn btn-primary" type="submit" name="submit">Save & Next</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['submit'])) {
    $finishtime1 = $_POST['finishtime1'];
    $temp1 = $_POST['temp1'];
    $finishtime2 = $_POST['finishtime2'];
    $temp2 = $_POST['temp2'];

    $pk = mysqli_query($con,"SELECT * FROM `tblblast`");
    $pk1 = mysqli_num_rows($pk);
    $pk2 = $pk1+1;

    $record = "blast00".$pk2;

    $sql = "UPDATE tblblast SET 
            finishtime1 = '$finishtime1', 
            temp1 = '$temp1', 
            finishtime2 = '$finishtime2', 
            temp2 = '$temp2',
            recordid = '$record'
            WHERE id = '$bid'";

    if (mysqli_query($con, $sql)) {
        
   echo "<script>window.location.href='admin.php?id=blastsign&rid=" . $record . "&tid=" .$pid . "';</script>";
exit;
    } else {
        echo "<script>alert('Error updating record: " . mysqli_error($con) . "');</script>";
    }
}
?>