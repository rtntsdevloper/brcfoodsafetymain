<?php

$id = $_GET['oid'];



$v = mysqli_query($con, "SELECT * FROM `tb_pestagency` WHERE id = $id");
$v1 = mysqli_fetch_array($v);

$d = mysqli_query($con, "SELECT * FROM `tb_pestoperator`");
$d1 = mysqli_num_rows($v);

if (isset($_POST['submit'])) {


    if (isset($_FILES["training"])) {
        $customName = "training00";
        $fileName = "{$customName}$d1." . pathinfo($_FILES["training"]['name'], PATHINFO_EXTENSION);
        $imagePath = "pest/img/{$fileName}";
        if (!file_exists("pest/img")) {
            mkdir("pest/img", 0777, true);
        }
        if (move_uploaded_file($_FILES["training"]["tmp_name"], $imagePath)) {
            $training = $imagePath;
        } else {
            $training = "Error uploading file";
        }
    } else {
        $training = "No file uploaded";
    }



    if (isset($_FILES["medical"])) {
        $customName = "medical00";
        $fileName = "{$customName}$d1." . pathinfo($_FILES["medical"]['name'], PATHINFO_EXTENSION);
        $imagePath = "data/agency/{$fileName}";
        if (!file_exists("data/agency")) {
            mkdir("data/agency", 0777, true);
        }
        if (move_uploaded_file($_FILES["medical"]["tmp_name"], $imagePath)) {
            $medical = $imagePath;
        } else {
            $medical = "Error uploading file";
        }
    } else {
        $medical = "No file uploaded";
    }

   $operator = $_POST['operate'];
   $agency = $v1['name'];
   $aid = $v1['id'];
   $user = $_SESSION['username'];


    $qr = "INSERT INTO `tb_pestoperator`( `name`, `agency_name`, `medicalreport`, `training`, `add_by`,`aid`) VALUES ('$operator','$agency','$medical','$training','$user',$aid)";
    $qr1 = mysqli_query($con, $qr);
    if($qr1){
       
            echo "<script> 
                 document.location.href='admin.php?id=agency_view';
                </script>";
      
    }
}



?>



<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-11 ">
                            <h5 class="card-title">Add Pest Control Agency Operators</h5>
                        </div>
                        <div class="col-md-1 text-center col-sm-3">


                            <a href="admin.php?id=agency_view" class="btn  btn-success  mt-3">Go Back</a>

                        </div>

                    </div>


                    <!-- General Form Elements -->
                    <form enctype="multipart/form-data" action="" method="post">


                        <div class="row mb-3">
                            <label for="inputDate" class="col-sm-2 col-form-label">Agency Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="nm" value="<?php echo $v1['name']; ?>" readonly>

                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="inputNumber" class="col-sm-2 col-form-label">Operator Name</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="operate" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="inputNumber" class="col-sm-2 col-form-label">Medical Report</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="file" id="formFile" name="medical" accept='.jpg,.jpeg,.png,.pdf' required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputNumber" class="col-sm-2 col-form-label">Training Certificate</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="file" id="formFile" name="training" accept='.jpg,.jpeg,.png,.pdf' required>
                            </div>
                        </div>










                        <div class="col-sm-3"></div>
                        <div class="col-sm-6">

                            <button type="submit" class="btn btn-primary" name="submit">Submit Form</button>
                        </div>
                        <div class="col-sm-3"></div>
                </div>

                </form><!-- End General Form Elements -->

            </div>
        </div>

    </div>






    </form><!-- End General Form Elements -->

    </div>
    </div>

    </div>
    </div>
</section>