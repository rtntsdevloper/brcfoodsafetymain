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

                    <a href="admin.php?id=baking&id2=<?php echo $_GET['id2']; ?>"><button class="btn btn-info" style="float:right; margin-left:15px">Go Back</button></a>


                    <h4 class="card-title mb-3">Baking Records</h4>


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
                                    $sqli = mysqli_query($con, "select * from tblmarination where dough='Done' and baking='' order by date DESC");
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
                                <label for="validationTooltip02">Product Temperature (Product temperature should not less than 85°C)</label>
                                <input class="form-control" id="validationTooltip02" type="number" required="required" name="ptemp" min="85" />
                                <div class="invalid-tooltip">
                                    Please fill the field.

                                </div>
                            </div>

                          
                            <div class="col-md-6"><br>
                                <label for="validationTooltip02">Baking Oven</label>
                                <select class="form-control" name="oven" required>
                                    <option>Please Select</option>
                                    <option value="Baking Oven 1">Baking Oven 1</option>
                                    <option value="Baking Oven 2">Baking Oven 2</option>
                                </select>
                                <div class="invalid-tooltip">
                                    Please fill the field.

                                </div>
                            </div>

                              <div class="col-md-6"><br>
                                <label for="validationTooltip02">Oven Temperature</label>
                                <input class="form-control" id="validationTooltip02" type="number" required="required" name="temp" min="120" />
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
    $oven = $_POST['oven'];
    $ptemp = $_POST['ptemp'];

    $user = $_SESSION['user'];
    $sql = mysqli_query($con, "INSERT INTO tblbaking (datetime,productbatch,temp,user,tray,ptemp) VALUES ('$date', '$product','$temp','$user','$oven','$ptemp')");
    $sql1 = mysqli_query($con, "update tblmarination set baking='done' where batchcode='$product'");
?>
    <script language="javascript">
        window.open('admin.php?id=baking&id2=<?php echo $_GET['id2']; ?>', '_self');
    </script>
<?php
}
?>

