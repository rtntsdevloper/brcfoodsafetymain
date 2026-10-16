<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cid = mysqli_real_escape_string($con, $_POST['custom']);
    $prodname = mysqli_real_escape_string($con, $_POST['pname']);
    $catg = mysqli_real_escape_string($con, $_POST['pcat']);

    $q = "INSERT INTO `tblgoodsoutproduct`(`cid`, `prodname`, `catg`) VALUES ('$cid', '$prodname', '$catg')";
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


<div class="row mb-12 ">
    <div class="col-md-12 ">
        <div class="card text-left ml-5" style="margin-top:8%;">
            <div class="card-body">

                <a href="admin.php?id=question"><button class="btn btn-success" style="float:right; margin-left:15px">Go
                        Back</button></a>




                <h4 class="card-title mb-3"></h4>


                <!-- <div class="row ml-5"> -->





                <form class="needs-validation my-5" novalidate="novalidate" method="post" action=""
                    enctype="multipart/form-data">
                    <div class="form-row">


                        <div class="col-md-12 mb-1 ">
                            <label for="validationTooltip02"><b>
                                    <h5>Add Goods Out Product</h5>
                                </b></label><br><br>
                        </div>



                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Select Customer</label>

                            <select name="custom" id="" class="form-control" required>
                                <option>Select supplier</option>
                                <?php
                                $pr = mysqli_query($con, "SELECT * FROM `tblcustomer`");
                                foreach ($pr as $row) {
                                    ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>

                                    <?php
                                }

                                ?>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Product Name</label>
                            <input type="text" name="pname" class="form-control" required />
                            <div class="invalid-tooltip">
                                Please select a supplier
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Category</label>
                            <input type="text" name="pcat" class="form-control" required />
                            <div class="invalid-tooltip">
                                Please select a supplier
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                           
                            <input type="submit" class="btn btn-primary" name="btn" />
                            
                        </div>



                    </div>
                </form>
            </div>
        </div>
    </div>
</div>