<?php
include('connection.php');

if (isset($_POST['submit'])) {
    $month = $_POST['month'];
    $year = $_POST['year'];
    $value = $_POST['value'];
    $color = $_POST['color']; // capture color array

    // Get month name from numeric month
    $mname = date('F', mktime(0, 0, 0, $month, 1, $year));

    foreach ($value as $key => $values) {
        $sid = $_POST['sid'][$key];
        $selcolor = $color[$key]; // match color with same index

        $q = mysqli_query($con, "INSERT INTO `tbl_overall` 
            (`month`, `year`, `mname`, `dvalue`, `sid`, `color`) 
            VALUES ('$month', '$year', '$mname', '$values', '$sid', '$selcolor')");
    }

    if ($q) {
        echo "<script>window.open('admin.php?id=overall','_self');</script>";
    } else {
        echo "<script>alert('Not inserted');</script>";
    }
}
?>


<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Overall </a></li>
            <li>add</li>
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=overall">
                    <button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button>
                </a>



                <div class="card-title">Add Overall Value</div>


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
                    $i = 1;
                    foreach ($sql as $sqldata) {
                        echo "<h4> $i. {$sqldata['name']}</h4>";
                        $i++;
                        echo "<table border='1' cellspadding='4'>
                        <tr> 
                        <td>Target</td>
                        <td>Acceptable</td>
                        <td>Action</td>

                        </tr>
                        <tr> 
                        <td style='background-color: #5af15a;'>$sqldata[target]</td>
                        <td style='background-color: #FFBF00;'>$sqldata[acceptable]</</td>
                        <td style='background-color: #F08080;'>$sqldata[action]</</td>

                        </tr>
</table>";
                    ?>
                        <input type="hidden" value="<?php echo $sqldata['id']; ?>" name="sid[]">
                        <div class="form-row">


                            <div class="col-md-6" style="margin-top: 30px;">
                               
                                <input class="form-control" type="text" placeholder="Enter the value" required name="value[]" />
                                <div class="invalid-tooltip">
                                    Please provide a valid value.
                                </div>

                               
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="color-<?php echo $sqldata['id']; ?>">Select Color</label>
                                <select name="color[]" class="form-control" required>
                                    <option value="" disabled selected>Select</option>
                                    <option value="red">Red</option>
                                    <option value="yellow">yellow</option>
                                    <option value="green">Green</option>
                                </select>

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