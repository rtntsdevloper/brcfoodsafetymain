<?php
$id = $_GET['view'];
$r = "SELECT * FROM `tblrawmaterial` Where id= $id";
$r1 = mysqli_query($con, $r);
$r2 = mysqli_fetch_array($r1);
$supid = $r2['supid'];

$s = mysqli_query($con, "SELECT * FROM tblrawsupplier WHERE supid=$supid");
$s1 = mysqli_fetch_array($s);
$supname = $s1['supname'];

if (isset($_POST['submit']))
 {

    $i = $_POST['van'];
    $j = $_POST['vdn'];

    $vdsu = 0;
    $vda = '';
    for ($a = 1; $a <= $j; $a++) {
        $vd = $_POST['vd' . $a];

        $vdsu = $vdsu + (int)$vd;

        if (empty($vda)) {
            $vda = $vd;
        } else {
            $vda .= ',' . $vd;
        }
    }


    $vosu = 0;
    $voa = '';
    for ($a = 1; $a <= $i; $a++) {
        $vo = $_POST['vo' . $a];

        $vosu = $vosu + (int)$vo;

        if (empty($voa)) {
            $voa = $vo;
        } else {
            $voa .= ',' . $vo;
        }
    }

    $vsum = intval($vdsu) + intval($vosu);


    $q = "UPDATE `tblrawmaterial` SET `vulner`='$vsum',`vulnerocc`='$voa',`vulnerdet`='$vda' WHERE id='$id'";
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
                <div class="card mb-5" style="margin-top:8%;">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="text-primary">Vulnerability Assessment</h2>
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

                            <h3 class="mt-5 ml-3 text-success">Likelihood Occurance</h3>
                        </div>
                        <form action="" method="post">

                            <div class="row mt-3 mb-2">

                                <?php
                                $q = mysqli_query($con, "SELECT * FROM `tblassesment` WHERE category ='vulnerbility' and type='occurance'");

                                $i = 0;

                                foreach ($q as $row) {
                                    $i++;


                                ?>

                                    <div class="col-md-6  col-sm-12 mb-2">
                                        <label for="" class="h4"><?php echo $row['question']; ?></label>
                                        <select name="vo<?php echo $i; ?>" id="" class="form-control" required>
                                            <option selected>Please Select</option>
                                            <option value="1">Very Unlikely</option>
                                            <option value="2">Unlikely</option>
                                            <option value="3">Possible</option>
                                            <option value="4">Likely</option>
                                            <option value="5">Almost certain</option>
                                        </select>

                                    </div>

                                <?php } ?>
                                <input type="hidden" name="van" value="<?php echo $i; ?>">
                            </div>


                            <h3 class="text-success mt-3">Likelihood of Detection</h3>
                            <div class="row mt-3 mb-3">

                                <?php
                                $q = mysqli_query($con, "SELECT * FROM `tblassesment` WHERE category ='vulnerbility' and type='detection'");

                                $j = 0;

                                foreach ($q as $row) {
                                    $j++;


                                ?>

                                    <div class="col-md-6 col-sm-12">
                                        <label class="h4 mt-2"><?php echo $row['question']; ?></label>
                                        <select name="vd<?php echo $j; ?>" id="" class="form-control" required>
                                            <option selected>Please Select</option>
                                            <option value="1">Almost certain</option>
                                            <option value="2">Likely</option>
                                            <option value="3">Possible</option>
                                            <option value="4">Unlikely</option>
                                            <option value="5">Very Unlikely</option>
                                        </select>

                                    </div>

                                <?php } ?>
                                <input type="hidden" name="vdn" value="<?php echo $j; ?>">
                            </div>

                            <div class="row">

                                <?php if (isset($q1)) { ?>
                                    <div class="col-md-12">

                                        <h3>Overall ingredient risk score : <?php if (isset($vsum)) {
                                                                                if ($vsum <= 20) {
                                                                                    echo "<span class='text-success fs-2'>Low</h4>";
                                                                                } elseif ($vsum >= 21 && $vsum <= 40) {
                                                                                    echo "<span class='text-warning fs-2'>Medium</h4>";
                                                                                } elseif ($vsum >= 40) {
                                                                                    echo "<span class='text-danger fs-2'>High</h4>";
                                                                                }
                                                                            }  ?></h3>
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