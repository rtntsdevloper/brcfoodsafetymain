<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Traceability</a></li>
            <li>View Detail</li>
        </ul>
    </div>



    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <a href="admin.php?id=cooling&id2=<?php echo $_GET['id2']; ?>"><button class="btn btn-info" style="float:right; margin-left:15px">Go Back</button></a>


                    <h4 class="card-title mb-3">Cooling Records</h4>





                    <form class="needs-validation" novalidate="novalidate" method="post" action="" enctype="multipart/form-data">
                        <div class="form-row">
                            <div class="col-md-6">
                                <label for="validationTooltip01">Date/Time</label>
                                <input class="form-control" id="validationTooltip01" type="datetime-local" required="required" name="date" />
                                <div class="invalid-tooltip">
                                    Please provide a valid first name.

                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="validationTooltip02">Select Product Batchcode</label>
                                <select class="form-control" name="product">
                                    <option>Please Select</option>
                                    <?php
                                    $sqli = mysqli_query($con, "select * from tblmarination where status='Done' and cooling ='' order by date DESC");
                                    while ($row = mysqli_fetch_array($sqli)) {
                                    ?>
                                        <option value="<?php echo $row['batchcode']; ?>"><?php echo $row['batchcode']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <div class="invalid-tooltip">
                                    Please fill the field.

                                </div>
                            </div>
                            <div class="col-md-6"><br>
                                <label for="validationTooltip02">Temperature after baking</label>
                                <input class="form-control" id="validationTooltip02" type="number" required="required" name="temp1" step="0.0001" />
                                <div class="invalid-tooltip">
                                    Please fill the field.

                                </div>
                            </div>

                            <div class="col-md-6"><br>
                                <label for="validationTooltip02">Temperature after cooling (Temperature of Product should be less than 25°C)</label>
                                <input class="form-control" id="validationTooltip02" type="number" required="required" name="temp" max="25" step="0.0001" />
                                <div class="invalid-tooltip">
                                    Please fill the field.

                                </div>
                            </div>


                            <div class="col-md-6"><br>
                                <label for="validationTooltip02">Cooling</label>
                                <select class="form-control" name="oven" required>
                                    <option>Please Select</option>
                                    <option value="Spiral">Spiral</option>
                                    <option value="Cooling belt">Cooling belt</option>
                                    <!-- <option value="Spirals 3">Spirals 3</option> -->
                                </select>
                                <div class="invalid-tooltip">
                                    Please fill the field.

                                </div>
                            </div>



                        </div>

                        <br />
                        <button class="btn btn-primary" type="submit" name="submit">Submit </button>
                    </form>
                </div>


            </div>
        </div>
    </div>
</div>
<?php
if (isset($_POST['submit'])) {
    $date = $_POST['date'];
    $product = $_POST['product'];
    $temp = $_POST['temp'];
    $temp1 = $_POST['temp1'];
    $user = $_SESSION['user'];
    $oven = $_POST['oven'];

    // echo "INSERT INTO tblcooling(datetime,productbatch,temp,user,tray,temp1)  VALUES ('$date', '$product','$temp','$user','$oven','$temp1')";
    $sql = mysqli_query($con, "INSERT INTO tblcooling(datetime,productbatch,temp,user,tray,temp1) VALUES ('$date', '$product','$temp','$user','$oven','$temp1')");

    $sql1 = mysqli_query($con, "update tblmarination set cooling='done' where batchcode='$product'");
?>
    <script language="javascript">
        window.open('admin.php?id=cooling&id2=<?php echo $_GET['id2']; ?>', '_self');
    </script>
<?php
}
?>