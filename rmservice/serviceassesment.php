<?php
$sid = $_GET['view'];
$sup = mysqli_query($con, "SELECT * FROM `tblrawsupplier` WHERE supid='$sid'");
$sup1 = mysqli_fetch_assoc($sup);
$supname = $sup1['supname'];



if (isset($_POST['submit'])) {


    $jn = $_POST['ran'];





    $vda = '';
    $sum = 0;
    for ($a = 1; $a <= $jn; $a++) {
        $vd = $_POST['ra' . $a];
        $sum += $vd;
        if (empty($vda)) {
            $vda = $vd;
        } else {
            $vda .= ';' . $vd;
        }
    }


    $q = "UPDATE `tblrawsupplier` SET `risk`='$sum', `riskd`='$vda' WHERE `supid`='$sid'";

    $q1 = mysqli_query($con, $q);
?>


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
                                <h2 class="text-primary"> Supplier Risk Assessment</h2>
                                <a href="admin.php?id=supplier-management"><button class="btn btn-success"
                                        style="float:right; margin-left:15px">Go Back</button></a>


                            </div>
                            <div class="row mt-3">
                                <div class="col-md-4 col-sm-0"></div>
                                <div class="col-md-8 col-sm-12">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Risk Associated</th>
                                                <th>Third party certification</th>
                                                <th>Inherent Risk</th>
                                                <th>Performance history (Past Quality issues)</th>
                                                <th>Volumes Supplied</th>
                
                                            </tr>
                                        </thead>
                                        <tr style="background-color: #32CD32;">
                                            <th>1 (Low)</th>
                                            <td>BRC or Equivalnet</td>
                                            <td>Low</td>
                                            <td>Good</td>
                                            <td>Low</td>
                                           

                                        </tr>
                                        <tr style="background-color: #FFD700;">
                                            <th>2 (Medium)</th>
                                            <td>Salsa or Equivalnet</td>
                                            <td>Medium</td>
                                            <td>Acceptable</td>
                                            <td>Medium</td>
                                            

                                        </tr>
                                        <tr style="background-color: #FF0000;">
                                            <th>3 (High)</th>
                                            <td>No certification</td>
                                            <td>High</td>
                                            <td>Poor</td>
                                            <td>High</td>
                                            

                                        </tr>

                                    </table>


                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <span class="h4">Supplier Name : </span>
                                <span class="h4 ml-3"><?php echo $supname ?></span>
                            </div>


                        </div>
                        <form method="post">


                            <div class="row mt-3">

                                <?php
                                $q = mysqli_query($con, "SELECT * FROM `tblassesment` WHERE category ='Service' and type='Risk'");

                                $j = 0;

                                foreach ($q as $row) {
                                    $j++;

                                    $qr = $row['options'];
                                    $qr1 = explode(';', $qr);


                                ?>
                                    <div class="col-md-6 mb-2 pl-4">
                                        <label for="" class="h5"><?php echo $row['question']; ?></label>



                                        <select name="ra<?php echo $j; ?>" id="rad<?php echo $j; ?>" class="form-control"
                                            required>
                                            <option value="" selected>Please Select</option>
                                            <?php foreach ($qr1 as $key => $value) { ?>
                                                <option value="<?php echo $key + 1; ?>"><?php echo $value; ?></option>
                                            <?php } ?>
                                        </select>


                                    </div>

                                <?php } ?>
                            </div>

                            <input type="hidden" name="ran" value="<?php echo $j; ?>">

                            <div class="row ml-3">
                                <?php if (isset($q1)) { ?>
                                    <div class="col-md-12 mt-5">
                                        <h3 class="">Overall risk score : <?php if (isset($sum)) {

                                                                                if ($sum >= 4 && $sum <= 6) {
                                                                                    echo "<span class='text-success fs-2'>Low</h4>";
                                                                                } elseif ($sum >= 7 && $sum <= 9) {
                                                                                    echo "<span class='text-warning fs-2'>Medium</h4>";
                                                                                } elseif ($sum >= 10) {
                                                                                    echo "<span class='text-danger fs-2'>High</h4>";
                                                                                }
                                                                            }
                                                                            ?>
                                        </h3>
                                        <a href="admin.php?id=supplier-management" class="btn btn-success">Submit</a>
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