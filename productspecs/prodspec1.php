<div class="main-content">

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Create Product Specification </div>
                        <a href="admin.php?id=prodspec"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                        <br>
                        <form name="form1" class="needs-validation" novalidate="novalidate" method="post" action="" enctype="multipart/form-data">
                            <div class="form-row">

                                <div class="col-md-6">
                                    <label for="validationTooltip01">Name</label>
                                    <input type="text" name="sectname" id="" class="form-control" required>

                                </div>
                                <div class="col-md-6">
                                    <label for="validationTooltip01">Product Name</label>
                                    <select name="prod" id="" class="form-control" required>
                                        <option value="">Select Product</option>
                                        <?php
                                        $sql = mysqli_query($con, "SELECT * FROM `tblproduct1` order by prodname asc");
                                        while ($row = mysqli_fetch_array($sql)) {
                                        ?>
                                            <option value="<?php echo $row['prodid']; ?>"><?php echo $row['prodname']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-12 py-2">

                                </div>
                                <div class="col-md-6">
                                    <label for="validationTooltip01">Product Code</label>
                                    <input type="text" name="prodcode" id="" class="form-control" required>

                                </div>
                                <div class="col-md-6">
                                    <label for="validationTooltip01">Description</label>
                                    <textarea name="description" id="" class="form-control"></textarea>
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label for="validationTooltip01">Finish Product Picture</label>
                                    <input type="file" name="finishproduct" id="" class="form-control" accept="image/*">
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="validationTooltip01">Packed Product Picture</label>
                                    <input type="file" name="packedproduct" id="" class="form-control" accept="image/*">
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="validationTooltip01">Outer Case Picture</label>
                                    <input type="file" name="outercase" id="" class="form-control" accept="image/*">
                                </div>
                            </div>

                            <div class="form-row mt-3">



                                <div class="col-md-6">
                                    <label for="validationTooltip01">Created By</label>
                                    <input type="text" name="create" id="" class="form-control" value='<?= $user ?>' readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="validationTooltip01">Job Title</label>
                                    <input type="text" name="jobt" id="" class="form-control" accept="image/*">
                                </div>



                            </div>



                            <br />

                            <button class="btn btn-success" type="submit" name="submit">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['submit'])) {
    $sectname = $_POST['sectname'];
    $prod = $_POST['prod'];
    $prodcode = $_POST['prodcode'];
    $description = $_POST['description'];
    $create = $_POST['create'];
    $jobt = $_POST['jobt'];


    $datex = date('Y-m-d H:i:s');


    $prodxnp = mysqli_query($con, "SELECT * FROM `tblproduct1` WHERE `prodid` = '$prod'");
    $prodxnpr = mysqli_fetch_array($prodxnp);
    $prodxname = $prodxnpr['prodname'];
    $prodxcode = $prodxnpr['prodcode'];

    $prodxn = mysqli_query($con, "SELECT * FROM `save_specification3`");
    $prodxnr = mysqli_num_rows($prodxn);


    if ($prodxnr < 10) {
        $zx = '000';
    } elseif ($prodxnr < 100 &&  $prodxnr > 10) {
        $zx = '00';
    } elseif ($prodxnr < 1000 &&  $prodxnr > 100) {
        $zx = '0';
    }

    $prodcodex = "PROD" . rand(1000, 9999) . $zx . $prodxnr;


    if (isset($_FILES['finishproduct']['name']) && !empty($_FILES['finishproduct']['name'])) {

        $file_name = $_FILES['finishproduct']['name'];

        $file_tmp = $_FILES['finishproduct']['tmp_name'];

        $new_name = date('YmdHis') . "_" . $file_name;
        $target = "productspecs/specpic/" . $new_name;
        if (move_uploaded_file($file_tmp, $target)) {
            $finishproduct = $new_name;
        } else {
            $finishproduct = "";
        }
    } else {
        $finishproduct = "";
    }


    if (isset($_FILES['packedproduct']['name']) && !empty($_FILES['packedproduct']['name'])) {

        $file_name = $_FILES['packedproduct']['name'];

        $file_tmp = $_FILES['packedproduct']['tmp_name'];

        $new_name1 = date('YmdHis') . "_" . $file_name;
        $target = "productspecs/specpic/" . $new_name1;
        if (move_uploaded_file($file_tmp, $target)) {
            $packedproduct = $new_name1;
        } else {
            $packedproduct = "";
        }
    } else {
        $packedproduct = "";
    }

    if (isset($_FILES['outercase']['name']) && !empty($_FILES['outercase']['name'])) {

        $file_name = $_FILES['outercase']['name'];

        $file_tmp = $_FILES['outercase']['tmp_name'];

        $new_name2 = date('YmdHis') . "_" . $file_name;
        $target = "productspecs/specpic/" . $new_name2;
        if (move_uploaded_file($file_tmp, $target)) {
            $outercase = $new_name2;
        } else {
            $outercase = "";
        }
    } else {
        $outercase = "";
    }








    $sql1 = mysqli_query($con, "INSERT INTO `save_specification3`(`scode`, `name`, `pid`, `prodname`, `prodcode`, `prdouctcode`, `description`, `user`, `dtime`, `finishpic`, `packpic`, `outerpic`,create,jobt) VALUES ('$prodcodex','$sectname','$prod','$prodxname','$prodcode','$prodxcode','$description','$user','$datex','$finishproduct','$packedproduct','$outercase')");

    if ($sql1) {
?>
        <script>
            // window.location.href = "admin.php?id=prodspec";
        </script>
<?php
    }
}



?>