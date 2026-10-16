<?php
include('connection.php');
$id = $_GET['sno'];

if (isset($_POST['submit'])) {
    $month = $_POST['month'];   // e.g. "03"
    $year  = $_POST['year'];    // e.g. "2025"
    $value = $_POST['value'];   // array of values keyed by tbl_overname.id

    // Get month name from numeric month
    $mname = date('F', mktime(0, 0, 0, $month, 1, $year));

    // Loop through values and update each row by its id
    foreach ($value as $overnameId => $val) {
        $update = mysqli_query($con, "UPDATE `tbl_overall` 
            SET `month`='$month', 
                `year`='$year', 
                `mname`='$mname',  
                `dvalue`='$val'  
            WHERE id='$overnameId'");
    }

    if ($update) {
        echo "<script>alert('Updated successfully'); window.location='admin.php?id=overall';</script>";
    } else {
        echo "<script>alert('Not updated');</script>";
    }
}
?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Overall Status</a></li>
            <li>form</li>
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=overall">
                    <button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button>
                </a>

                <div class="card-title">Edit</div>

                <form class="needs-validation" novalidate method="post" action="" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                            <label class="control-label">Select Month</label>
                            <select name="month" id="month" class="form-control" required>
                                <option value="01">January</option>
                                <option value="02">February</option>
                                <option value="03">March</option>
                                <option value="04">April</option>
                                <option value="05">May</option>
                                <option value="06">June</option>
                                <option value="07">July</option>
                                <option value="08">August</option>
                                <option value="09">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="control-label">Select Year</label>
                            <select name="year" class="form-control" required>
                                <?php
                                $currentYear = date('Y');
                                for ($y = $currentYear - 10; $y <= $currentYear + 10; $y++) {
                                    $selected = ($y == $currentYear) ? ' selected' : '';
                                    echo '<option value="' . $y . '"' . $selected . '>' . $y . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <?php
                    $sql = mysqli_query($con, "SELECT * FROM `tbl_overname`");
                    foreach ($sql as $sqldata) {
                        echo '<h4>' . $sqldata['name'] . '</h4>';
                        ?>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="control-value">Value</label>
                                <input class="form-control" type="number" placeholder="Enter the value" required
                                    name="value[<?php echo $sqldata['id']; ?>]" />
                                <div class="invalid-tooltip">
                                    Please provide a valid number.
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <br>
                    <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
