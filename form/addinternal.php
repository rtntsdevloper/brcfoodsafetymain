<?php

include 'connection.php';

date_default_timezone_set('Europe/London');

$date = date('d-m-Y');
$time = date('h:i:s');
?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>Monthly Scale Calibration</li>
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">

                <a href="admin.php?id=internaldate&tid=4"><button class="btn btn-success"
                        style="float:right; margin-left:15px">Go Back</button></a>
                <div class="row">
                    <div class="col-md-4">
                        <img src="images/scale.png" height="150" width="250" style="float:left; margin-left:15px;"
                            alt="">
                    </div>
                    <div class="col-md-8">
                        <table border="3px" width="100%" class="mt-5 text-center">

                            <tr>
                                <td rowspan="3"> <b> Tolerance =</b></td>
                                <td><b>100g</b></td>
                                <td><b>± 0 g</b></td>

                            </tr>
                            <tr>

                                <td><b>1kg</b></td>
                                <td><b>± 10 g</b></td>
                            </tr>
                            <tr>

                                <td><b>5kg</b></td>
                                <td><b>± 20 g</b></td>
                            </tr>



                        </table>
                    </div>
                </div>

                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data"
                    action="">

                    <div class="form-row mt-5">
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip03">Date</label>
                            <input type="text" name="date" class="form-control" value='<?php echo $date; ?>' readonly
                                required>

                            <div class="invalid-tooltip">
                                Please provide a valid area.
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip03">Area</label>
                            <?php
                            $sq = mysqli_query($con, "SELECT * FROM tblscales");
                            ?>

                            <select name="area" id="sarea" class="form-control">
                                <option value="Please Select">Please Select</option>
                                <?php while ($row = mysqli_fetch_assoc($sq)) { ?>
                                    <option value="<?php echo $row['id']; ?>" data-name='<?php echo $row['scale']; ?>'>
                                        <?php echo $row['area']; ?>
                                    </option>
                                <?php } ?>
                            </select>

                            <div class="invalid-tooltip">
                                Please provide a valid area.
                            </div>
                        </div>


                    </div>
                    <script>
                        document.getElementById('sarea').addEventListener('change', function () {

                            const selectedOption = this.options[this.selectedIndex];
                            const dataName = selectedOption.getAttribute('data-name');
                            document.getElementById('showscale').value = dataName;
                        });
                    </script>

                    <div class="form-row mt-3">
                        <div class="col-md-12">
                            <label for="">Serial No.</label>
                            <input type="text" class="w-100 heading-tab sub-tab" name="scale" readonly id='showscale'>
                            <label for="">upload image</label>
                            <input type="file" name="img" class="form-control" accept="jpg,png,jpeg">
                            <div class="sub-tabs">
                                <!-- Add row wrapper here -->
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="heading-tab sub-tab">
                                            <h6>100g</h6>
                                        </div>
                                        <div class="sub-tabs">
                                            <label class="text-center">Testing Point For 100g</label>
                                            <ol style="padding-left: 20px; margin-top: 10px;">

                                                <li>
                                                    <div class="input-group mt-2">
                                                        <input name="th1" type="text" class="form-control avg-input"
                                                            data-group="hundred" required>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">g</span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="input-group mt-2">
                                                        <input name="th2" type="text" class="form-control avg-input"
                                                            data-group="hundred" required>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">g</span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="input-group mt-2">
                                                        <input name="th3" type="text" class="form-control avg-input"
                                                            data-group="hundred" required>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">g</span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="input-group mt-2">
                                                        <input name="th4" type="text" class="form-control avg-input"
                                                            data-group="hundred" required>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">g</span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="input-group mt-2">
                                                        <input name="th5" type="text" class="form-control avg-input"
                                                            data-group="hundred" required>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">g</span>
                                                        </div>
                                                    </div>
                                                </li>

                                            </ol>
                                            <!-- Average field for 100g -->
                                            <div class="form-group mt-2">
                                                <label>Average (100g):</label>
                                                <input type="text" id="hundredAvg" name="hundred_avg"
                                                    class="form-control" readonly style="background-color: #e9ecef;">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="heading-tab sub-tab">
                                            <h6>1kg</h6>
                                        </div>
                                        <div class="sub-tabs">
                                            <label class="text-center">Testing Points For 1kg</label>
                                            <ol style="padding-left: 20px; margin-top: 10px;">

                                                <li>
                                                    <div class="input-group mt-2">
                                                        <input name="ch1" type="number" class="form-control avg-input"
                                                            data-group="onekg" required>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">g</span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="input-group mt-2">
                                                        <input name="ch2" type="number" class="form-control avg-input"
                                                            data-group="onekg" required>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">g</span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="input-group mt-2">
                                                        <input name="ch3" type="number" class="form-control avg-input"
                                                            data-group="onekg" required>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">g</span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="input-group mt-2">
                                                        <input name="ch4" type="number" class="form-control avg-input"
                                                            data-group="onekg" required>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">g</span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="input-group mt-2">
                                                        <input name="ch5" type="number" class="form-control avg-input"
                                                            data-group="onekg" required>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">g</span>
                                                        </div>
                                                    </div>
                                                </li>

                                            </ol>
                                            <!-- Average field for 1kg -->
                                            <div class="form-group mt-2">
                                                <label>Average (1kg):</label>
                                                <input type="text" id="onekgAvg" name="onekg_avg" class="form-control"
                                                    readonly style="background-color: #e9ecef;">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="heading-tab sub-tab">
                                            <h6>5kg</h6>
                                        </div>
                                        <div class="sub-tabs">
                                            <label style="text-align: center;">Testing Point For 5kg</label>
                                            <ol style="padding-left: 20px;">
                                                <li>
                                                    <div class="input-group mt-2">
                                                        <input name="rt1" type="number" class="form-control avg-input"
                                                            data-group="fivekg" required>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">g</span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="input-group mt-2">
                                                        <input name="rt2" type="number" class="form-control avg-input"
                                                            data-group="fivekg" required>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">g</span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="input-group mt-2">
                                                        <input name="rt3" type="number" class="form-control avg-input"
                                                            data-group="fivekg" required>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">g</span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="input-group mt-2">
                                                        <input name="rt4" type="number" class="form-control avg-input"
                                                            data-group="fivekg" required>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">g</span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="input-group mt-2">
                                                        <input name="rt5" type="number" class="form-control avg-input"
                                                            data-group="fivekg" required>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">g</span>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ol>
                                            <!-- Average field for 5kg -->
                                            <div class="form-group mt-2">
                                                <label>Average (5kg):</label>
                                                <input type="text" id="fivekgAvg" name="fivekg_avg" class="form-control"
                                                    readonly style="background-color: #e9ecef;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <style>
                        .heading-tab {
                            cursor: pointer;
                            padding: 10px;
                            background: #f8f9fa;
                            border: 1px solid #ddd;
                            border-radius: 5px;
                            margin-bottom: 5px;
                        }

                        .heading-tab h6 {
                            margin: 0;
                            font-weight: bold;
                        }

                        .sub-tabs {
                            padding: 15px;
                            border: 1px solid #eee;
                            border-radius: 5px;
                            margin-bottom: 10px;
                        }

                        .form-control {
                            margin-bottom: 10px;
                        }

                        /* Fix for inline-block spacing */
                        .row {
                            margin-left: -15px;
                            margin-right: -15px;
                        }

                        .col-md-4 {
                            padding-left: 15px;
                            padding-right: 15px;
                        }
                    </style>

                    <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Function to get all input values for a specific group
    function getGroupValues(groupName) {
        let inputs = document.querySelectorAll(`.avg-input[data-group="${groupName}"]`);
        let values = [];
        inputs.forEach(input => {
            let val = parseFloat(input.value);
            if (!isNaN(val) && val !== '') {
                values.push(val);
            }
        });
        return values;
    }

    // Function to calculate average
    function calculateAverage(values) {
        if (values.length === 0) return 0;
        let sum = values.reduce((a, b) => a + b, 0);
        return (sum / values.length).toFixed(2);
    }

    // Function to update all averages
    function updateAverages() {
        // Calculate for 100g
        let hundredValues = getGroupValues('hundred');
        let hundredAvg = calculateAverage(hundredValues);
        document.getElementById('hundredAvg').value = hundredAvg + ' g';

        // Calculate for 1kg
        let onekgValues = getGroupValues('onekg');
        let onekgAvg = calculateAverage(onekgValues);
        document.getElementById('onekgAvg').value = onekgAvg + ' g';

        // Calculate for 5kg
        let fivekgValues = getGroupValues('fivekg');
        let fivekgAvg = calculateAverage(fivekgValues);
        document.getElementById('fivekgAvg').value = fivekgAvg + ' g';
    }

    // Add event listeners to all input fields
    document.addEventListener('DOMContentLoaded', function () {
        let allInputs = document.querySelectorAll('.avg-input');
        allInputs.forEach(input => {
            input.addEventListener('input', updateAverages);
            input.addEventListener('keyup', updateAverages);
        });
        updateAverages();
    });
</script>

<?php
if (isset($_POST['submit'])) {
    $date = $_POST['date'];
    // Extract year and month for date1 column
    $date1 = date('Y-m', strtotime($date));
    $scale = $_POST['scale'];
    $area = $_POST['area'];
    // $comment = $_POST['diff'];

    $rid=date('dmYhis'); 
    // $correct = $_POST['corrective'];

    $Date= date('Y-m-d', strtotime($date));
    // Process 50g fields
    $fifty = array(
        $_POST['th1'],
        $_POST['th2'],
        $_POST['th3'],
        $_POST['th4'],
        $_POST['th5']
    );
    $fifty = implode(",", $fifty);

    // Process 100g fields
    $one = array(
        $_POST['ch1'],
        $_POST['ch2'],
        $_POST['ch3'],
        $_POST['ch4'],
        $_POST['ch5']
    );
    $one = implode(",", $one);

    // Process 200g fields
    $two = array(
        $_POST['rt1'],
        $_POST['rt2'],
        $_POST['rt3'],
        $_POST['rt4'],
        $_POST['rt5']
    );
    $two = implode(",", $two);

    


$img = $_FILES['img']['name'];
$img = time() . '_' . $img;
$imgt = $_FILES['img']['tmp_name'];

$compressedPath = "form/upl1/" . $img;

$info = getimagesize($imgt);
if ($info['mime'] == 'image/jpeg') {
    $image = imagecreatefromjpeg($imgt);
    // Very strong compression (quality 10)
    imagejpeg($image, $compressedPath, 10);
} elseif ($info['mime'] == 'image/png') {
    $image = imagecreatefrompng($imgt);
    // Max compression level (9)
    imagepng($image, $compressedPath, 9);
} elseif ($info['mime'] == 'image/webp') {
    $image = imagecreatefromwebp($imgt);
    // Very strong compression (quality 10)
    imagewebp($image, $compressedPath, 10);
}

imagedestroy($image);


    $sql = "INSERT INTO `tblscales1` 
            (`date`, `date1`, `scale`, `area`, `50g`, `100g`, `200g`,`image`,`rid`) 
            VALUES 
            ('$Date', '$date1', '$scale', '$area', '$fifty', '$one', '$two', '$img','$rid')";
            

    if (mysqli_query($con, $sql)) {
        echo "<script>alert('Scale Calibration Record Added Successfully');</script>";
        echo "<script>window.location.href='admin.php?id=insign&rid=$rid';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
    }
}
?>