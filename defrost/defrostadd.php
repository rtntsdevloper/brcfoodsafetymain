<?php
include 'connection.php';
?>


<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href=""></a>Home</li>
            <li>Add Defrost Record</li>
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=defrostdate"><button class="btn btn-success"
                        style="float:right; margin-left:15px">Go
                        Back</button></a>

                <div class="card-title">Add Defrost Record</div>


                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip01">Date</label>
                            <input class="form-control" id="validationTooltip01" type="date" required="required"
                                name="date" />
                            <div class="invalid-tooltip">
                                Please provide a valid first name.

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip02">Product Name</label>
                            <input name="product" type="text" class="form-control" id="validationTooltip02"
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
                            <input name="qty" type="number" class="form-control" id="validationTooltip03"
                                required="required" step="0.0001" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                    </div>


                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip03">Batch Code/Use-By Date </label>
                            <input class="form-control" id="validationTooltip04" type="text" required="required"
                                name="trace" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip05">Temperature </label>
                            <div class="input-group">
                                <input name="temp" type="number" class="form-control" id="validationTooltip05"
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
                            <input name="moved" type="date" class="form-control" id="validationTooltip06"
                                required="required" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip05">Chiller Temperature </label>
                            <div class="input-group">
                                <input name="ctemp" type="number" class="form-control" id="validationTooltip05"
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
                            <input name="sign" type="text" class="form-control" id="validationTooltip07"
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






                    </br>
                    <button class="btn btn-primary" type="submit" name="submit">Submit </button>
                </form>
            </div>
        </div>
    </div>
    <?php
    if (isset($_POST['submit'])) {

        $date = $_POST['date'];
        $product = $_POST['product'];
        $qty = $_POST['qty'];
        $trace = $_POST['trace'];
        $temp = $_POST['temp'];
        $ctemp = $_POST['ctemp'];
        $moved = $_POST['moved'];
        $sign = $_POST['sign'];
        // $cmnt = $_POST['cmnt'];
    
        $sq = "INSERT INTO tbldefrost(date, product, qty, trace, temp, ctemp, moved,  sign) VALUES ('$date', '$product', '$qty', '$trace', '$temp', '$ctemp', '$moved', '$sign')";
        $result = mysqli_query($con, $sq);

        if ($result) {
            ?>

            <script language="javascript">
                window.open('admin.php?id=defrostdate', '_self');
            </script>
            <?php
        }
    }

    ?>