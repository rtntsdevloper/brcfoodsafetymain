<?php

if (isset($_POST['submit'])) {
    $inc_date = $_POST['inc_date'];
    $Auditor = $_POST['Auditor'];
    $Area = $_POST['Area'];
    $gaps = $_POST['gaps'];
    $usefile = $_FILES['usefile']['name'];
    $user = $_SESSION['user'];
    if (isset($_FILES["usefile"])) {

        $signature = '';
        foreach ($_FILES["usefile"]["tmp_name"] as $key => $value) {
            $v1 = date('Ymdhis');
            $customName = "gap00" . $v1;
            // echo $customName;
            $fileName = "{$customName}." . pathinfo($_FILES["usefile"]["name"][$key], PATHINFO_EXTENSION);
            $imagePath = "pest/img/{$fileName}";
            if (!file_exists("pest/img")) {
                mkdir("pest/img", 0777, true);
            }
            if (move_uploaded_file($value, $imagePath)) {
                if (empty($signature)) {
                    $signature .= $imagePath;
                } else {
                    $signature .= ',' . $imagePath;
                }
            } else {
                $signature = "Error uploading file";
            }
        }
        if (empty($signature)) {
            $signature = "No file uploaded";
        }

        $attchfile = $signature;

        $q1 = "INSERT INTO `tb_gap`( `name`,`date`, `areas`, `gaps`, `files`, `add_by`)VALUES ('$Auditor','$inc_date','$Area','$gaps','$attchfile','$user')";
        //    print_r($q1);die;
        $q = mysqli_query($con, $q1);

        if ($q) {
            echo "<script> 
             document.location.href='admin.php?id=gap';
            </script>";
        }
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
                            <h5 class="card-title">Add Gap Audits Details</h5>
                        </div>
                        <div class="col-md-1 text-center col-sm-3">

                           
                            <a href="admin.php?id=gap" class="btn  btn-success  mt-3">Go Back</a>

                        </div>

                    </div>

                    <!-- General Form Elements -->
                    <form enctype="multipart/form-data" action="" method="post">




                        <div class="row mb-3">
                            <label for="inputDate" class="col-sm-2 col-form-label">Date of Gap Audit</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" name="inc_date" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputDate" class="col-sm-2 col-form-label">Name of Auditor</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="Auditor" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="inputDate" class="col-sm-2 col-form-label">Area Audited</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="Area" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputDate" class="col-sm-2 col-form-label">Number of Gaps</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="gaps" required>
                            </div>
                        </div>




                        <div class="row mb-3">
                            <label for="inputNumber" class="col-sm-2 col-form-label">Attach Gap Audit Report</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="file" id="formFile" name="usefile[]" multiple required>
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