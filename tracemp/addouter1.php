<?php
include 'connection.php';
$pid = $_GET['eid'];
$pdrb = $_GET['pdrb'];
$pde = mysqli_query($con, "SELECT * FROM tblouter1 WHERE id='$pid'");
$pde1 = mysqli_fetch_array($pde);
$pdate = $pde1['date'];

$pb = $pde1['prodbatch'];
$pb1  = explode(",", $pb);

?>


<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>Add Outer Packaging</li>
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=outer&eid=<?php echo $pid; ?>"><button class="btn btn-success"
                        style="float:right; margin-left:15px">Go Back</button></a>




                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data"
                    action="">
                    <div class="form-row mt-5">


                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Time</label>
                            <input class="form-control" id="validationTooltip02" type="time" placeholder="" name="time"
                                required />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                    


                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Outer Packaging Batchcode</label>
                            <input class="form-control" id="validationTooltip02" type="text" placeholder="" name="outbtch" />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Is Outer box label Correct</label>
                            <br>
                            <input type="radio" name="olabel" value="Yes" required> Yes
                            <input type="radio" name="olabel" value="No" required> No

                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Outer coding (BB & day coding)</label>
                            <input class="form-control" id="validationTooltip02" type="text" placeholder=""
                                name="ocoding" required />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Inner coding (BB & day coding)</label>
                            <input class="form-control" id="validationTooltip02" type="text" placeholder=""
                                name="icoding" required />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">No. of Inners Per Outer</label>
                            <input class="form-control" id="validationTooltip02" type="number" placeholder=""
                                name="innerper" required />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Is Inner Packaging Correct?</label>
                            <input class="form-control" id="validationTooltip02" type="text" placeholder=""
                                name="innerpack" required />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">In Spec (Y/N)</label>
                            <br>
                            <input type="radio" name="inspec" value="Yes" required> Yes
                            <input type="radio" name="inspec" value="No" required> No
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Pack Sealed Correctly (Yes/ No)</label>
                            <br>
                            <input type="radio" name="seal" value="Yes" required> Yes
                            <input type="radio" name="seal" value="No" required> No

                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Total Quantity Produced(in Kg)</label>
                            <input class="form-control" id="validationTooltip02" type="number" placeholder=""
                                name="tqty" required />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                    </div>


                    <button class="btn btn-primary" type="submit" name="submit">Save & Next</button>
            </div>
        </div>




    </div>



    </br>

    </form>
</div>

<?php

if (isset($_POST['submit'])) {
    $time = $_POST['time'];
    $pname = $_POST['tqty'];
    $outbatch = $_POST['outbtch'];
    $olabel = $_POST['olabel'];
    $ocoding = $_POST['ocoding'];
    $icoding = $_POST['icoding'];
    $innerper = $_POST['innerper'];
    $innerpack = $_POST['innerpack'];
    $inspec = $_POST['inspec'];
    $seal = $_POST['seal'];
    $pid = $_GET['eid'];


    $qsp = mysqli_query($con, "SELECT * FROM tblouter");
    $qsp1 = mysqli_num_rows($qsp);
    $qspn = $qsp1 + 1;

    $avcth = "OUTP00" . $qspn;


    $sql = "INSERT INTO tblouter 
        (eid, time, pname, olabel, ocoding, icoding, innerper, innerpack, inspec, seal, date,recordid,outbatch,prodbt) 
        VALUES 
        ('$pid', '$time', '$pname', '$olabel', '$ocoding', '$icoding', '$innerper', '$innerpack', '$inspec', '$seal', '$pdate','$avcth','$outbatch','$pdrb')";

    $sql1 = mysqli_query($con, $sql);
    
    

    if ($sql1) {
        echo "<script> window.location.href='admin.php?id=signouter&tid=$avcth&pid=$pid';</script>";
        exit;
    } else {
        echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
    }
}
?>