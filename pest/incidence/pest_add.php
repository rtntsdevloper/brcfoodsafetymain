<?php
include 'connection.php';

if (isset($_POST['submit'])) {
    $date_of_incidence = $_POST['inc_date'];
    $type_of_pest = $_POST['type_pest'];
    $pest_found_premises = $_POST['found'];
    $area = $_POST['area'];
    $number_of_pest = $_POST['pests'];
    $file = $_FILES['usefile']['name'];

    if ($pest_found_premises == 'inside') {
        $area = $_POST['area'];
    } else {
        $area = "outside";
    }
    $v1 = date('Ymdhis');

    $number_of_pest = $_POST['pests'];
    $file = $_FILES['usefile']['name'];
    $userg = $_SESSION['username'];
    if (isset($_FILES["usefile"])) {
        $customName = "File00";
        $fileName = "{$customName}$v1." . pathinfo($_FILES["usefile"]['name'], PATHINFO_EXTENSION);
        $imagePath = "pest/img/{$fileName}";
        if (!file_exists("pest/img")) {
            mkdir("pest/img", 0777, true);
        }
        if (move_uploaded_file($_FILES["usefile"]["tmp_name"], $imagePath)) {
            $signature = $fileName;
        } else {
            $signature = "Error uploading file";
        }
    } else {
        $signature = "No file uploaded";
    }



    $userg = $_SESSION['username'];
    $sql = "INSERT INTO tb_pest (`date_incidence`, `pest_type`, `found`, `found_area`, `pest_num`, `add_pdf`, `add_by`)
                VALUES ('$date_of_incidence', '$type_of_pest', '$pest_found_premises', '$area', '$number_of_pest', '$signature','$user')";


    // print_r($sql);die;

    $q = mysqli_query($con, $sql);

    if ($q) {
        echo "<script> 
             document.location.href='admin.php?id=Pest';
            </script>";
    }
}





?>









<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5 class="card-title d-inline mt-1">Add Pest Control Details</h5>
                            <a href="admin.php?id=Pest" class="btn btn-success" style="float: right;">Go Back</a>

                        </div>
                    </div>

                    <br>

                    <!-- General Form Elements -->
                    <form enctype="multipart/form-data" action="" method="post">

                        <div class="row mb-3">
                            <label for="inputNumber" class="col-sm-2 col-form-label">Upload Incidence
                                Report</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="file" id="formFile" name="usefile">
                            </div>
                        </div>



                        <div class="row mb-3">
                            <label for="inputDate" class="col-sm-2 col-form-label">Date of Incidence</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" name="inc_date">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Type Of Pest</label>
                            <div class="col-sm-10">
                                <select class="form-control" aria-label="Default select example" name="type_pest">
                                    <option selected> Select Type Of Pest</option>
                                    <option value="rodent">Rodent</option>
                                    <option value="lizard">Lizard</option>
                                    <option value="cockroach">Cockroach</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Pest Found Premises</label>
                            <div class="col-sm-10">
                                <select class="form-control" aria-label="Default select example" name='found' id="media"
                                    onchange="showDiv()">
                                    <option selected>Select Where Pest Found</option>
                                    <option value="inside">Inside</option>
                                    <option value="outside">Outside</option>
                                </select>
                            </div>
                        </div>

                        <style>
                            .hidden {
                                display: none;
                            }
                        </style>
                        <div class="hidden">
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Area</label>
                                <div class="col-sm-10">
                                    <select class="form-control" aria-label="Default select example" name="area">
                                        <option selected>Select Inside Area Pest Found</option>
                                        <option value="Receiving">Receiving</option>
                                        <option value="Prepation">Preparation</option>
                                        <option value="Storage">Storage</option>
                                        <option value="Serving">Serving</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <script>
                            function showDiv() {
                                const mediaSelect = document.getElementById("media").value;
                                const hiddenDiv = document.querySelector('.hidden');

                                if (mediaSelect == 'inside') {
                                    hiddenDiv.classList.remove('hidden');
                                } else {
                                    hiddenDiv.classList.add('hidden');
                                }
                            }
                        </script>



                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Number of Pest</label>
                            <div class="col-sm-10">
                                <input type="text" name="pests" class="form-control"
                                    placeholder="Enter total number of pest found">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-1"></div>
                        </div>

                        <div class="col-sm-8">

                            <button type="submit" class="btn btn-primary" name="submit">Submit Form</button>
                        </div>
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