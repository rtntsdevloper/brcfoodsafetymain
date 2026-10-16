<?php
$id = $_GET['view'];
$r = "SELECT * FROM `tblrawmaterial` Where id= $id";
$r1 = mysqli_query($con, $r);
$r2 = mysqli_fetch_array($r1);
$supid = $r2['supid'];


$s = mysqli_query($con, "SELECT * FROM tblrawsupplier WHERE supid=$supid");
$s1 = mysqli_fetch_array($s);
$supname = $s1['supname'];


if (isset($_POST['submit'])) {

    $i = $_POST['rdn'];
    $j = $_POST['ran'];
    $al = $_POST['all'];
    if (isset($_POST['all'])) {
        $aleg = implode(',', $al);
    } else {
        $aleg = '';
    }





    $vda = '';
    for ($a = 1; $a <= $i; $a++) {
        $vd = $_POST['ans' . $a];
        if (empty($vda)) {
            $vda = $vd;
        } else {
            $vda .= ';' . $vd;
        }
    }


    $rasu = 0;
    $raa = '';
    for ($a = 1; $a <= $j; $a++) {
        $vo = $_POST['ra' . $a];

        $rasu = $rasu + (int)$vo;

        if (empty($raa)) {
            $raa = $vo;
        } else {
            $raa .= ',' . $vo;
        }
    }



    $rasum = $rasu;

    $q = "UPDATE `tblrawmaterial` SET `risk`='$rasum',`riskdesc`='$vda',`riskassoc`='$raa',`riskall`='$aleg' WHERE id=$id";
    // print_r($q);die;
    $q1 = mysqli_query($con, $q);
	?>
	<script language="javascript">
	window.open('admin.php?id=addrawmaterial','_self');
	</script>
	
	<?php
}

?>

<div class="main-content">

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4" style="margin-top:8%;">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="text-primary">Risk Assessment</h2>
                                <a href="admin.php?id=addrawmaterial"><button class="btn btn-success"
                                        style="float:right; margin-left:15px">Go Back</button></a>


                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <span class="h4">Supplier Name : </span>
                                <span class="h4 ml-3"><?php echo $supname ?></span>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <span class="h4">Product Name : </span>
                                <span class="h4 ml-3"><?php echo $r2['pname']; ?></span>
                            </div>

                            <h3 class="mt-5 ml-4 text-success">Raw Material Description</h3>
                        </div>
                        <form action="" method="post">

                            <div class="row mt-3 mb-2 pl-3">

                                <?php
                                $q = mysqli_query($con, "SELECT * FROM `tblassesment` WHERE category ='Risk' and type='description'");

                                $i = 0;

                                foreach ($q as $row) {
                                    $i++;


                                ?>


                                    <style>
                                        .fsl {
                                            font-size: 15px;
                                            margin-left: 8px;
                                        }
                                    </style>
                                    <?php if ($row['question'] == 'Allergens') { ?>

                                        <div class="col-md-12 mb-4">
                                            <label class="h5"><?php echo $row['question']; ?></label>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <input type="checkbox" name="all[]" id="" value="Celery"> <label for="" class="mt-2 fsl">Celery</label>
                                                </div>
                                                <div class="col-md-3"> <input type="checkbox" name="all[]" id=""   value="Cereal contain Gluten"><label for="" class="mt-2 fsl">Cereal contain Gluten</label></div>
                                                <div class="col-md-3"><input type="checkbox" name="all[]" id=""     value="Crustaceance"> <label for="" class="mt-2 fsl">Crustaceance</label></div>
                                                <div class="col-md-3"><input type="checkbox" name="all[]" id=""   value="Fish"><label for="" class="mt-2 fsl">Fish </label></div>
                                                <div class="col-md-3"> <input type="checkbox" name="all[]" id=""   value="Egg"><label for="" class="mt-2 fsl">Egg</label></div>

                                                <div class="col-md-3">
                                                    <input type="checkbox" name="all[]" id="" value="Mustard"><label for="" class="mt-2 fsl">Mustard</label>
                                                </div>
                                                <div class="col-md-3"><input type="checkbox" name="all[]" id=""  value="Nuts"><label for="" class="mt-2 fsl">Nuts</label></div>
                                                <div class="col-md-3"><input type="checkbox" name="all[]" id=""  value="Peanuts"><label for="" class="mt-2 fsl">Peanuts</label></div>
                                                <div class="col-md-3"> <input type="checkbox" name="all[]" id=""  value="Lupin"><label for="" class="mt-2 fsl">Lupin</label></div>
                                                <div class="col-md-3"> <input type="checkbox" name="all[]" id=""  value="Molluscs"><label for="" class="mt-2 fsl">Molluscs</label></div>
                                                <div class="col-md-3"><input type="checkbox" name="all[]" id=""  value="Milk"><label for="" class="mt-2 fsl">Milk</label><br></div>
                                                <div class="col-md-3"><input type="checkbox" name="all[]" id="" value="Seasame Seeds"><label for="" class="mt-2 fsl">Seasame Seeds</label></div>
                                                <div class="col-md-3"> <input type="checkbox" name="all[]" id=""  value="Soya"><label for="" class="mt-2 fsl">Soya</label></div>
                                                <div class="col-md-3"> <input type="checkbox" name="all[]" id=""  value="Sulphur Dioxide"><label for="" class="mt-2 fsl">Sulphur Dioxide</label></div>
                                            </div>


                                        </div>




                                    <?php } else { ?>
                                        <div class="col-md-6 mb-4">
                                            <label class="h5"><?php echo $row['question']; ?></label>
                                            <div class="row">

                                                <div class="col-md-12">
                                                    <input type="text" class="form-control" name="ans<?php echo $i; ?>" class="ml-2">
                                                </div>
                                            </div>


                                        </div>


                                <?php }
                                } ?>
                            </div>

                            <input type="hidden" name="rdn" value="<?php echo $i; ?>">

                            <h3 class="ml-2 text-success">Risk Associated</h3>
                            <div class="row mt-3">

                                <?php
                                $q = mysqli_query($con, "SELECT * FROM `tblassesment` WHERE category ='Risk' and type='associated'");

                                $j = 0;

                                foreach ($q as $row) {
                                    $j++;


                                ?>
                                    <div class="col-md-6 mb-2 pl-4">
                                        <label for="" class="h5"><?php echo $row['question']; ?></label>



                                        <select name="ra<?php echo $j; ?>" id="" class="form-control" required>
                                            <option selected>Please Select</option>
                                            <option value="1">Low</option>
                                            <option value="2">Medium</option>
                                            <option value="3">High</option>
                                        </select>

                                    </div>

                                <?php } ?>
                            </div>

                            <input type="hidden" name="ran" value="<?php echo $j; ?>">

                            <div class="row ml-3">
                                <?php if (isset($q1)) { ?>
                                    <div class="col-md-12 mt-5">
                                        <h3 class="">Overall ingredient risk score : <?php if (isset($rasum)) {
                                                                                            if ($rasum >= 7 && $rasum < 15) {
                                                                                                echo "<span class='text-success fs-2'>Low</h4>";
                                                                                            } else {
                                                                                                echo "<span class='text-danger fs-2'>High</h4>";
                                                                                            }
                                                                                        }
                                                                                        ?>
                                        </h3>
                                        <a href="admin.php?id=rawmaterial" class="btn btn-success">Submit</a>
                                    </div>
                                <?php } else { ?>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary " name="submit">Check Score</button>
                                    </div>
                                    <div class="col-md-10"></div>
                                <?php } ?>
                            </div>


                    </div>


                    </form>

                </div>
            </div>
        </div>

    </div>


</div>