<?php
include 'connection.php';
$sno = $_GET['sno'];
$date = $_GET['date'];

$sql = mysqli_query($con, "SELECT * FROM `tbldefrost` where id='$sno' ");
$data = mysqli_fetch_array($sql);

?>


<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href=""></a>Home</li>
            <li> Defrost Record</li>
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=defrost1&date=<?php echo $date; ?>"><button class="btn btn-success"
                        style="float:right; margin-left:15px">Go
                        Back</button></a>

                <div class="card-title"> Defrost Record</div>


                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip01">Date</label>
                            <input class="form-control" id="validationTooltip01" type="date" required="required" readonly value='<?php echo $date; ?>'
                                name="date" />
                            <div class="invalid-tooltip">
                                Please provide a valid first name.

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip02">Product Name</label>
                            <input name="product" type="text" class="form-control" id="validationTooltip02" value='<?php echo $data['product']; ?>'
                                required="required" />
                            <!-- <select name="product" id="" class="form-control">
                                <option value="product1">product1</option>
                                <option value="product2">product2</option>
                            </select> -->
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip02">Quantity(kg)</label>
                            <input name="qty" type="number" class="form-control" id="validationTooltip03" value='<?php echo $data['qty']; ?>'
                                required="required" step="0.0001" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                    </div>


                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip03">Batch Code/Use-By Date </label>
                            <input class="form-control" id="validationTooltip04" type="text" required="required" value='<?php echo $data['trace']; ?>'
                                name="trace" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip05">Temperature </label>
                            <div class="input-group">
                                <input name="temp" type="number" class="form-control" id="validationTooltip05" value='<?php echo $data['temp']; ?>'
                                    required="required" />
                                <div class="input-group-append">
                                    <span class="input-group-text">°C</span>
                                </div>
                                <div class="invalid-tooltip">
                                    Please fill the field.
                                </div>
                            </div>
                        </div>



                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip05"> Defrost start date</label>
                            <input name="moved" type="date" class="form-control" id="validationTooltip06" value='<?php echo $data['moved']; ?>'
                                required="required" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip05">Chiller Temperature </label>
                            <div class="input-group">
                                <input name="ctemp" type="number" class="form-control" id="validationTooltip05" value='<?php echo $data['ctemp']; ?>'
                                    required="required" />
                                <div class="input-group-append">
                                    <span class="input-group-text">°C</span>
                                </div>
                                <div class="invalid-tooltip">
                                    Please fill the field.
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-md-4 mb-3">
                            <label for="validationTooltip05">Comment</label>
                            <textarea name="cmnt" class="form-control" id="validationTooltip06" rows="3"></textarea>
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div> -->

                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip05">Checked By</label>
                            <input name="sign" type="text" class="form-control" id="validationTooltip07" value='<?php echo $data['sign']; ?>'
                                required="required" />
                            <!-- <select type="text" name="sign" class="form-control" required>

                                <option value="">Please Select</option>
                                <option value="User1">User1</option>
                                <option value="User2">User2</option>


                            </select> -->
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>



                    </div>

                    <?php
                    if (!empty($data['temp2'])) {

                    ?>

                        <div class="form-row">

                            <div class="col-md-4 mb-3">
                                <label for="validationTooltip05">Product Temperature after Defrost </label>
                                <div class="input-group">
                                    <input name="temp2" type="number" class="form-control" id="validationTooltip05"
                                        required="required" value="<?php echo $data['temp2']; ?>" />
                                    <div class="input-group-append">
                                        <span class="input-group-text">°C</span>
                                    </div>
                                    <div class="invalid-tooltip">
                                        Please fill the field.
                                    </div>
                                </div>
                            </div>



                            <div class="col-md-4 mb-3">
                                <label for="validationTooltip05">Defrost Finish Date</label>
                                <input name="moved2" type="date" class="form-control" id="validationTooltip06"
                                    required="required" value="<?php echo $data['moved2']; ?>" />
                                <div class="invalid-tooltip">
                                    Please fill the field.

                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationTooltip05">Comment</label>
                                <textarea name="cmnt" class="form-control" id="validationTooltip06" rows="3"><?php echo  $data['cmnt']; ?></textarea>
                                <div class="invalid-tooltip">
                                    Please fill the field.
                                </div>
                            </div>


                        </div>
                    <?php } ?>





                    </br>
                    <button class="btn btn-primary" type="submit" name="submit">Submit </button>
                </form>
            </div>
        </div>
    </div>
    <?php
    if (isset($_POST['submit'])) {

        $product = $_POST['product'];
        $qty = $_POST['qty'];
        $trace = $_POST['trace'];
        $temp = $_POST['temp'];
        $ctemp = $_POST['ctemp'];
        $moved = $_POST['moved'];
        $sign = $_POST['sign'];
        $moved2 = $_POST['moved2'];
        $temp2 = $_POST['temp2'];
        $cmnt = $_POST['cmnt'];

        $sq = "UPDATE `tbldefrost` SET `product`='$product',`qty`='$qty',`trace`='$trace',`temp`='$temp',`moved`='$moved',`sign`='$sign',`moved2`='$moved2',`temp2`='$temp2',`cmnt`='$cmnt' ,`lastupdate`='$user' WHERE id='$sno' ";
        $result = mysqli_query($con, $sq);

        if ($result) {
    ?>

            <script language="javascript">
                window.open('admin.php?id=defrost1&date=<?php echo $date; ?>', '_self');
            </script>
    <?php
        }
    }

    ?>





<!-- 


 <?php
    if (isset($_POST['submit'])) {

        $product = $_POST['product'];
        $qty = $_POST['qty'];
        $trace = $_POST['trace'];
        $temp = $_POST['temp'];
        $ctemp = $_POST['ctemp'];
        $moved = $_POST['moved'];
        $sign = $_POST['sign'];
        $moved2 = $_POST['moved2'];
        $temp2 = $_POST['temp2'];
        $cmnt = $_POST['cmnt'];

        // Check if sign has changed
        $old_sign = $data['sign'];
        $new_sign = $sign;
        $sign_changed = ($old_sign !== $new_sign);

        // Perform update
        $sq = "UPDATE `tbldefrost` SET `product`='$product',`qty`='$qty',`trace`='$trace',`temp`='$temp',`moved`='$moved',`sign`='$sign',`moved2`='$moved2',`temp2`='$temp2',`cmnt`='$cmnt' ,`lastupdate`='$user' WHERE id='$sno' ";
        $result = mysqli_query($con, $sq);

        if ($result) {
            // Redirect based on whether sign changed
            if ($sign_changed) {
    ?>
                <script language="javascript">
                    window.open('admin.php?id=defrostsignature&tid=<?php echo $data['id']; ?>', '_self');
                </script>
    <?php
            } else {
    ?>
                <script language="javascript">
                    window.open('admin.php?id=defrost1&date=<?php echo $date; ?>', '_self');
                </script>
    <?php
            }
        }
    }
?> -->