
<?php

    if (isset($_POST['submit'])) {
   
    $name = $_POST['nm'];
    $start = $_POST['stdt'];
    $end = $_POST['endt'];
    $frequency = $_POST['frequency'];
    $pest = $_POST['pestcover'];
   
    $user = $_SESSION['username'];




    if (isset($_FILES["agrm"])) {
        $customName = "agreement00"; 
        $fileName = "{$customName}$v1." . pathinfo($_FILES["agrm"]['name'], PATHINFO_EXTENSION);
        $imagePath = "pest/img/{$fileName}";
        if (!file_exists("pest/img")) {
            mkdir("pest/img", 0777, true);
        }
        if (move_uploaded_file($_FILES["agrm"]["tmp_name"], $imagePath)) {
            $signature = $imagePath;
        } else {
            $signature = "Error uploading file";
        }
                
        } else {
            $signature = "No file uploaded";
        }
       

    
      
            

            if (isset($_FILES["license"])) {
                $customName = "licensel00"; 
                $fileName = "{$customName}$v1." . pathinfo($_FILES["license"]['name'], PATHINFO_EXTENSION);
                $imagePath = "pest/img/{$fileName}";
                if (!file_exists("pest/img")) {
                    mkdir("pest/img", 0777, true);
                }
                if (move_uploaded_file($_FILES["license"]["tmp_name"], $imagePath)) {
                    $license = $imagePath;
                } else {
                    $license = "Error uploading file";
                }
                        
                } 
                else {
                    $license = "No file uploaded";
                }
              
   
          
                       

$q1 = "INSERT INTO `tb_pestagency`(`name`, `frequency`, `pest_cover`, `date_start`, `date_end`, `agrefile`, `license`,`add_by`)
VALUES ('$name','$frequency','$pest','$start','$end','$signature','$license','$user')";
// print_r($q1);die;
    $q = mysqli_query($con, $q1);

    if ($q) {
        echo "<script> 
             document.location.href='admin.php?id=agency';
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
                            <h5 class="card-title">Add Pest Control Agency Details</h5>
                        </div>
                        <div class="col-md-1 text-center col-sm-3">

                           
                            <a href="admin.php?id=agency" class="btn  btn-success  mt-3">Go Back</a>

                        </div>

                    </div>
                    

                    <!-- General Form Elements -->
                    <form enctype="multipart/form-data" action="" method="post">


                    <div class="row mb-3">
                            <label for="inputDate" class="col-sm-2 col-form-label">Name of Pest Control Agency</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="nm"  required>
                                
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="inputNumber" class="col-sm-2 col-form-label">Upload Agreement</label>
                            <div class="col-sm-10">
                               <input class="form-control" type="file" id="formFile" name="agrm" accept ='.jpg,.jpeg,.png,.pdf' required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputNumber" class="col-sm-2 col-form-label">Agreement Start Date</label>
                            <div class="col-sm-10">
                               <input class="form-control" type="date" id="formFile" name="stdt" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputNumber" class="col-sm-2 col-form-label">Agreement End Date</label>
                            <div class="col-sm-10">
                               <input class="form-control" type="date" id="formFile" name="endt" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="inputDate" class="col-sm-2 col-form-label">Pest Cover In Agreement</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="pestcover" required>
                            </div>
                        </div>

                        
                        

                        <div class="row mb-3">
                            <label for="inputDate" class="col-sm-2 col-form-label">Frequency of Service</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="frequency" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputNumber" class="col-sm-2 col-form-label">License of Pest Control Agency</label>
                            <div class="col-sm-10">
                               <input class="form-control" type="file" id="formFile" name="license" accept ='.jpg,.jpeg,.png,.pdf' required>
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