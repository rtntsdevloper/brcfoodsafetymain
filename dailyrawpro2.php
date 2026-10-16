<?php

$sno = $_GET['sno'];

$sql = mysqli_query($con, "SELECT * FROM `tbl_dailyproduct` WHERE id='$sno'");
$row = mysqli_fetch_array($sql);

?>

<div class="container-fluid">

    <div class="main-content">
        <div class="breadcrumb">
            <h1 class="mr-2"><?php echo $headingname; ?></h1>
            <ul>
                <li><a href="">Product daily checks</a></li>
                <li>Edit Product</li>
            </ul>
        </div>
        <div class="container mb-3">
            <div class="row">
                <div class="col-md-12">
                    <a href="admin.php?id=dailyrawpro" class="btn btn-success" style="float: right;">Go Back</a>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">Edit Products</div>

                            <form name="form1" class="needs-validation" novalidate="novalidate" method="post" action="" enctype="multipart/form-data">
                                <div class="form-row">
                                    <div class="col-md-6 col-sm-12">
                                        <label for="validationTooltip01"> Product Name</label>
                                        <input class="form-control" id="validationTooltip01" type="text" placeholder="Name" required="required" name="sname" value="<?php echo $row['name']; ?>"/>
                                        <div class="invalid-tooltip">
                                            Please provide a valid name.

                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 col-sm-12">
                                        <label for="validationTooltip01">Uom</label>
                                        <select name="uom" id="uom" class="form-control">
                                            <?php
                                            $uomx = $row['uom']; 

                                            ?>
                                            <option value="">Select Uom</option>
                                            <option value="kg" <?php if($uomx == 'kg'){ echo 'selected'; } ?>>kg</option>
                                            <option value="gm" <?php if($uomx == 'gm'){ echo 'selected'; } ?>>gm</option>
                                            <option value="ml" <?php if($uomx == 'ml'){ echo 'selected'; } ?>>ml</option>
                                            <option value="ltr" <?php if($uomx == 'ltr'){ echo 'selected'; } ?>>ltr</option>
                                            <option value="pcs" <?php if($uomx == 'pcs'){ echo 'selected'; } ?>>pcs</option>
                                            <option value="packs" <?php if($uomx == 'packs'){ echo 'selected'; } ?>>packs</option>
                                            <option value="other" <?php if($uomx == 'other'){ echo 'selected'; } ?>>Other</option>
                                        </select>
                                        <div class="invalid-tooltip">
                                            Please provide a valid name.

                                        </div>
                                    </div>
                                   

                                </div>



                                <br />

                                <button class="btn btn-primary" type="submit" name="submit1">Update </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['submit1'])) {
    $sname = mysqli_real_escape_string($con, $_POST['sname']);
    $uom = mysqli_real_escape_string($con, $_POST['uom']);
    $sq = mysqli_query($con, "update `tbl_dailyproduct` set name='$sname',uom='$uom' where id='$sno'");
    if ($sq) {
        echo "<script>
        alert('Product updated successfully');
        window.location.href='admin.php?id=dailyrawpro';
        </script>";
    } 
}
