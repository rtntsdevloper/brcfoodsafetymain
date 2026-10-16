<div class="main-content">

    <div class="breadcrumb">



        <ul>

            <li><a href=""></a></li>

            <!-- <li>Add Auditor</li> -->

        </ul>

    </div>

    <div class="col-md-12">

        <div class="card">

            <div class="card-body">

                <a href="admin.php?id=zendseal"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>



                <div class="card-title">Sealing & Labelling check

                </div>





                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data">

                    <div class="form-row">

                        <div class="col-md-6 mb-3">

                            <label for="validationTooltip01">Date</label>

                            <input class="form-control" id="validationTooltip01" type="date" required="required" name="idate" />

                            <div class="invalid-tooltip">

                                Please provide a valid first name.



                            </div>

                        </div>



                        <div class="col-md-6 mb-3">

                            <label for="validationTooltip02">Production Batch</label>

                            <select name="prodbatch" id="" class="form-control" onchange="getbatch(this)">

                                <option value="">Select Production Batch</option>

                                <?php

                                $nrk = mysqli_query($con, "SELECT * FROM `zendproduction` where label =''");
                                while ($nrk1 = mysqli_fetch_array($nrk)) {

                                    echo '<option value="' . $nrk1['id'] . '">' . $nrk1['pbatch'] . '( ' . $nrk1['batch'] . ')</option>';

                                }

                                ?>

                            </select>

                            <div class="invalid-tooltip">

                                Please fill the field.

                            </div>

                        </div>













                        <div class="col-md-6">

                            <label for="validationTooltip01">Is the Pouches Sealed Properly?</label>

                            <select name="sachetsealed" id="sachetsealed" class="form-control" onchange="getcmnt()" required>

                                <option value="">Select</option>

                                <option value="Yes">Yes</option>

                                <option value="No">No</option>

                            </select>

                        </div>

                   



                        <div class="col-md-6 mb-3">

                            <label for="validationTooltip02">Is labelling correct on packet?</label>

                            <select name="labelling" id="labelcorrect" class="form-control" onchange="getcmnt()" required>

                                <option value="">Select</option>

                                <option value="Yes">Yes</option>

                                <option value="No">No</option>

                            </select>

                            <div class="invalid-tooltip">

                                Please fill the field.



                            </div>

                        </div>







                        <div class="col-md-6 mb-3">

                            <label for="validationTooltip02">Is batch code & BBD printed adequately?</label>

                            <select name="print" id="bbprint" class="form-control" onchange="getcmnt()" required>

                                <option value="">Select</option>

                                <option value="Yes">Yes</option>

                                <option value="No">No</option>

                            </select>

                            <div class="invalid-tooltip">

                                Please fill the field.



                            </div>

                        </div>



                        <script>

                            function getcmnt() {

                                var sachetsealed = document.getElementById("sachetsealed").value;

                                var labelcorrect = document.getElementById("labelcorrect").value;

                                var bbprint = document.getElementById("bbprint").value;

                                if (sachetsealed == "No" || labelcorrect == "No" || bbprint == "No") {

                                    document.getElementById("cmnt").style.display = "block";

                                } else {

                                    document.getElementById("cmnt").style.display = "none";

                                }

                            }

                        </script>



                        <div class="col-md-6" id="cmnt">

                            <label for="validationTooltip01">Comments</label>

                            <textarea name="batch" id="" class="form-control"></textarea>

                           

                            <div class="invalid-tooltip">

                                Please provide a valid name.

                            </div>

                        </div>





                    </div>



                    </br>

                    <button class="btn btn-primary" type="submit" name="submit">Submit </button>

            </div>



        </div>









        </form>

    </div>

</div>

</div>





<?php



if (isset($_POST['submit'])) {


    $idate = $_POST['idate'];

    $prodbatch = $_POST['prodbatch'];

    $batch = $_POST['batch'];

    $sachetsealed = $_POST['sachetsealed'];

    $labelling = $_POST['labelling'];

    $print = $_POST['print'];

    $cdate = date('Y-m-d H:i:s');


 echo "SELECT * FROM `zendproduction` where label =''";



    $packq = mysqli_query($con, "INSERT INTO `zendseal`(`dates`, `productbatch`, `batch`, `sealed`, `labelling`, `print`, `user`, `cdate`) VALUES ('$idate','$prodbatch','$batch','$sachetsealed','$labelling','$print','$user','$cdate')");





    if ($packq) {

        $update = mysqli_query($con, "UPDATE `zendproduction` SET `label`='done' WHERE id='$prodbatch'");



        echo "<script> window.location.href='admin.php?id=zendseal';</script>";

    } else {

        echo "<script>alert('Failed to Add'); </script>";

    }

}



?>