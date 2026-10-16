<?php
include 'connection.php';
$sno = $_GET['sno'];
$sql = mysqli_query($con, "select * from tbldefrost where id='$sno'");
$row = mysqli_fetch_array($sql);
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
                <a href="admin.php?id=defrost1"><button class="btn btn-success" style="float:right; margin-left:15px">Go
                        Back</button></a>

                <div class="card-title">Add Defrost Record</div>


                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                            <label for="validationTooltip01">Date</label>
                            <input class="form-control" id="validationTooltip01" type="date" required="required"
                                name="date" value="<?php echo $row['date']; ?>" disabled />
                            <div class="invalid-tooltip">
                                Please provide a valid first name.

                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="validationTooltip02">Product Name</label>
                            <input name="product" type="text" class="form-control" id="validationTooltip02"
                                required="required" value="<?php echo $row['product']; ?>" disabled />
                            <!-- <select name="product" id="" class="form-control" disabled>
                                <option value="Paneer">Paneer</option>
                                <option value="Pakoda">Pakoda</option>
                            </select> -->
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="validationTooltip02">Quantity(kg)</label>
                            <input name="qty" type="number" class="form-control" id="validationTooltip03"
                                required="required" value="<?php echo $row['qty']; ?>" disabled />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                    </div>


                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                            <label for="validationTooltip03">Batch Code/UBD </label>
                            <input class="form-control" id="validationTooltip04" type="text" required="required"
                                name="trace" value="<?php echo $row['trace']; ?>" disabled />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>


                        <div class="col-md-3 mb-3">
                            <label for="validationTooltip05">Product Temperature after Defrost </label>
                            <div class="input-group">
                                <input name="temp2" type="text" class="form-control" id="validationTooltip05"
                                    required="required" value="<?php echo $row['temp2']; ?>" />
                                <div class="input-group-append">
                                    <span class="input-group-text">°C</span>
                                </div>
                                <div class="invalid-tooltip">
                                    Please fill the field.
                                </div>
                            </div>
                        </div>



                        <div class="col-md-3 mb-3">
                            <label for="validationTooltip05">Defrost Finish Date</label>
                            <input name="moved2" type="date" class="form-control" id="validationTooltip06"
                                required="required" value="<?php echo $row['moved2']; ?>" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>


                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip05">Comment</label>
                            <textarea name="cmnt" class="form-control" id="validationTooltip06" rows="3"></textarea>
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


        $temp2 = $_POST['temp2'];
        $moved2 = $_POST['moved2'];
        $cmnt = $_POST['cmnt'];


        $sq = "UPDATE tbldefrost SET  temp2='$temp2', moved2='$moved2', cmnt='$cmnt' WHERE id='$sno'";
        // print_r($sq);die;
        $result = mysqli_query($con, $sq);

        if ($result) {
            ?>

            <script language="javascript">
                window.open('admin.php?id=defrostsignature&tid=<?php echo $sno; ?>', '_self');
            </script>
            <?php
        }
    }

    ?>