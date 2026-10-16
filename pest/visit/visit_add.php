<?php


if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $date = $_POST['date'];
    $next = $_POST['next'];

    $act = $_POST['activity'];

    







    $q1  = "INSERT INTO `tb_visit`(`date`, `next_date`, `name`, `activity`, `add_by`) VALUES ('$date','$next','$name','$act','$user')";;
    // print_r($q1);
    $q = mysqli_query($con, $q1);
// die;
    if ($q) {
        echo "<script> 
             document.location.href='admin.php?id=visit';
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
                        <div class="col-md-11 col-sm-9">
                            <h5 class="card-title" class="d-inline">Add Visit Details</h5>

                        </div>
                        <div class="col-md-1 col-sm-3">
                            <a href="admin.php?id=visit" class="btn  btn-success  mt-3">Go Back</a>

                        </div>
                    </div>


                    <!-- General Form Elements -->
                    <form enctype="multipart/form-data" action="" method="post">




                        <div class="row mb-3">
                            <label for="inputNumber" class="col-sm-2 col-form-label">Date of Visit</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="date" id="formFile" name="date" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="inputDate" class="col-sm-2 col-form-label">Activities Conducted</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="activity" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputNumber" class="col-sm-2 col-form-label">Next Date of Visit</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="date" id="formFile" name="next" required>
                            </div>
                        </div>




                        <div class="row mb-3">
                            <label for="inputDate" class="col-sm-2 col-form-label">Operator Name</label>
                            <div class="col-sm-10">
                                <select name="name" id="" class="form-control" required>
                                    <option>Select Operator</option>

                                    <?php
                                    $q = mysqli_query($con, "SELECT tb_pestagency.name,tb_pestoperator.name AS opr FROM `tb_pestagency` 
                                        JOIN `tb_pestoperator` 
                                        ON `tb_pestagency`.`id` = `tb_pestoperator`.`aid` 
                                        WHERE `tb_pestagency`.`status` = 'Active' ;
                                        ");
                                        foreach($q as $pstd){
                                            echo ' <option value="'.$pstd['opr'].'">'.$pstd['opr'].'( '. $pstd['name'] .' )</option>';
                                        }


                                    ?>
                                   
                                </select>
                            </div>


                            <div class="row mb-3 mt-3">

                                <div class="col-sm-9">

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