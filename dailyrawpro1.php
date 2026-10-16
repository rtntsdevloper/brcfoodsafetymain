<div class="container-fluid">

    <div class="main-content">
        <div class="breadcrumb">
            <h1 class="mr-2"><?php echo $headingname; ?></h1>
            <ul>
                <li><a href="">Product daily checks</a></li>
                <li>Add Product</li>
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
                            <div class="card-title">Add Products</div>

                            <form name="form1" class="needs-validation" novalidate="novalidate" method="post" action="" enctype="multipart/form-data">
                                <div class="form-row">
                                    <div class="col-md-6 col-sm-12">
                                        <label for="validationTooltip01"> Product Name</label>
                                        <input class="form-control" id="validationTooltip01" type="text" placeholder="Name" name="sname" value=""/>
                                        <div class="invalid-tooltip">
                                            Please provide a valid name.

                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 col-sm-12">
                                        <label for="validationTooltip01">Uom</label>
                                        <select name="uom" id="uom" class="form-control">
                                            <option value="">Select Uom</option>
                                            <option value="kg">kg</option>
                                            <option value="gm">gm</option>
                                            <option value="ml">ml</option>
                                            <option value="ltr">ltr</option>
                                            <option value="pcs">pcs</option>
                                            <option value="packs">packs</option>
                                            <option value="other">Other</option>
                                        </select>
                                        <div class="invalid-tooltip">
                                            Please provide a valid name.

                                        </div>
                                    </div>
                                   

                                </div>



                                <br />

                                <button class="btn btn-primary" type="submit" name="submit1">Submit </button>
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
    $sq = mysqli_query($con, "insert into `tbl_dailyproduct` (name,uom) values ('$sname','$uom')");
    if ($sq) {
        echo "<script>
        alert('Product added successfully');
        window.location.href='admin.php?id=dailyrawpro';
        </script>";
    } 
}
