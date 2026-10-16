<?php
// Check if we're editing an existing record

    $edit_id = $_GET['sno'];
    $edit_query = mysqli_query($con, "SELECT * FROM `tblgoodsoutproduct` WHERE id='$edit_id'");
    $edit_data = mysqli_fetch_assoc($edit_query);


if (isset($_POST["btn"])) {
    $cid = mysqli_real_escape_string($con, $_POST['custom']);
    $prodname = mysqli_real_escape_string($con, $_POST['pname']);
    $catg = mysqli_real_escape_string($con, $_POST['pcat']);



    
    $q = "UPDATE `tblgoodsoutproduct` SET `cid`='$cid', `prodname`='$prodname', `catg`='$catg' WHERE id='$edit_id'";
    
    $result = mysqli_query($con, $q);

    if ($result) {
        ?>
        <script language="javascript">
            window.open('admin.php?id=goodoutmgmt', '_self');
        </script>
        <?php
    }

}
?>

<div class="row mb-12">
    <div class="col-md-12">
        <div class="card text-left ml-5" style="margin-top:8%;">
            <div class="card-body">
                <a href="admin.php?id=question"><button class="btn btn-success" style="float:right; margin-left:15px">Go
                        Back</button></a>
                <h4 class="card-title mb-3"></h4>

                <form class="needs-validation my-5" novalidate="novalidate" method="post" action=""
                    enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="col-md-12 mb-1">
                            <label for="validationTooltip02"><b>
                                    <h5>Edit Goods Out Product</h5>
                                </b></label><br><br>
                        </div>



                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Select Customer</label>
                            <select name="custom" id="" class="form-control" required>
                                <option value="">Select customer</option>
                                <?php
                                $pr = mysqli_query($con, "SELECT * FROM `tblcustomer`");
                                foreach ($pr as $row) {
                                    $selected = (isset($edit_data) && $edit_data['cid'] == $row['id']) ? 'selected' : '';
                                    ?>
                                    <option value="<?php echo $row['id']; ?>" <?php echo $selected; ?>>
                                        <?php echo $row['name']; ?>
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Product Name</label>
                            <input type="text" name="pname" class="form-control" required
                                value="<?php echo isset($edit_data) ? $edit_data['prodname'] : ''; ?>" />
                            <div class="invalid-tooltip">
                                Please enter product name
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Category</label>
                            <input type="text" name="pcat" class="form-control" required
                                value="<?php echo isset($edit_data) ? $edit_data['catg'] : ''; ?>" />
                            <div class="invalid-tooltip">
                                Please enter category
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <input type="submit" class="btn btn-primary" name="btn"  />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>