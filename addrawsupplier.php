<div class="main-content">
    <div class="breadcrumb">

       <ul>
            <li><a href="">Home</a></li>
            <li>Raw Material Supplier </li>
        </ul>
    </div>
    <div class="container" style="margin-top:100px;">

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <a href="admin.php?id=rawsupplier"><button class="btn btn-success"
                            style="float:right; margin-left:15px">Go Back</button></a>

                    <div class="card-title">Raw Material Supplier</div>

                    <form class="needs-validation" novalidate="novalidate" method="post" action=""
                        enctype="multipart/form-data">
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="validationTooltip01">Sagecode</label>
                                <input class="form-control" id="validationTooltip01" type="text" placeholder=""
                                    required="required" name="sagecode" />
                                <div class="invalid-tooltip">
                                    Please fill in this field

                                </div>
                            </div>
                            
                            <div class="col-md-4 mb-3">
    <label for="validationTooltip02">Supplier name</label>
    <input type="text" class="form-control" id="validationTooltip02" required="required" name="supname">
        
    
    <div class="invalid-tooltip">
        Please select a supplier
    </div>
</div>
                            <div class="col-md-4 mb-3">
                                <label for="validationTooltip03">Address</label>
                                <textarea name="address" class="form-control" id="validationTooltip03"
                                    required="required"></textarea>
                                <div class="invalid-tooltip">
                                    Please fill in this field
                                </div>
                            </div></div>
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="validationTooltip04">City</label>
                                    <input class="form-control" id="validationTooltip04" type="name" placeholder=""
                                        required="required" name="city" accept="image/jpeg,jpg" />
                                    <div class="invalid-tooltip">
                                        Please fill the field.

                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationTooltip05">Contact</label>
                                    <input name="contact" type="text" class="form-control" id="validationTooltip05"
                                        placeholder="" required="required" />
                                    <div class="invalid-tooltip">
                                        Please fill the field

                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationTooltip06">Email</label>
                                    <input name="email" type="text" class="form-control" id="validationTooltip06"
                                        placeholder="" required="required" />
                                    <div class="invalid-tooltip">
                                        Please fill the field

                                    </div>
                                </div>


                            </div>

                            <button class="btn btn-primary" type="submit" name="submit">Submit </button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <?php

    if (isset($_POST['submit'])) {

        $sagecode = $_POST['sagecode'];
        $pcode = $_POST['supname'];
        $pname = $_POST['address'];
        $supid = $_POST['city'];
        $ingredients = $_POST['contact'];
        $chiller = $_POST['email'];
        $query = "INSERT INTO `tblrawsupplier`(`sagecode`, `supname`, `address`, `city`,`contact`,`email`)VALUES('$sagecode', '$pcode', '$pname','$supid','$ingredients','$chiller')";
        $result = mysqli_query($con, $query);
        if ($result) {

            echo "<script>
                                                       
                                                        document.location.href='admin.php?id=rawsupplier'
                                                        </script>";

            echo 'inserted';

        } else {
            echo "<script>
        alert('Data does'nt submitted sucessfully');
        document.location.href='admin.php?id=addrawsupplier'
        </script>";
            echo ' no inserted';
        }


    }
    ?>