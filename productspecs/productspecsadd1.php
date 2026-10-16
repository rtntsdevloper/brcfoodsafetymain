<?php
$pro = $_GET['pro'];

$spq = mysqli_query($con, "SELECT * FROM `save_specification` WHERE id='$pro'");
$sprow = mysqli_fetch_array($spq);

$pxid = $sprow['spid'];
$prod = $sprow['pid'];
$sid = $sprow['sid'];

$prox = mysqli_query($con, "SELECT * FROM `tblproduct1` WHERE `prodid` = '$prod'");
$prox1 = mysqli_fetch_array($prox);

$sqxx = mysqli_query($con, "SELECT * FROM `product_specification1` WHERE `id` = '$pxid'");
$sqiddata = mysqli_fetch_array($sqxx);

if ($sid == 2) {
    $sqid = $prox1['nutname'];
    $sqdarr = explode(';', $sqid);
} else {
    $sqid = $sqiddata['nms'];
    $sqdarr = explode(';', $sqid);
}

?>
<div class="main-content">

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title mb-5">
                            <h2>Add Specification (<?php echo $prox1['prodname']; ?>)</h2>
                        </div>

                        <form name="form1" class="needs-validation" novalidate="novalidate" method="post" action="productspecs/specadd1" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="hidden" name="pro" value="<?php echo $pro; ?>">
                                    <input type="hidden" name="prod" value="<?php echo $prod; ?>">
                                    <input type="hidden" name="sid" value="<?php echo $sid; ?>">
                                    <input type="hidden" name="user" value="<?php echo $user; ?>">
                                </div>
                            </div>
                            <?php
                            $sqx = mysqli_query($con, "SELECT * FROM `product_specification2` WHERE `ssid` = '$pxid'");

                            $ix = 0;
                            foreach ($sqx as $sqxdata) {
                            ?>
                                <div class="form-row my-3">

                                    <div class="col-md-12"> <label for="inputEmail4" class="form-label">
                                            <h4><?php echo $sqxdata['ques']; ?></h4>
                                            <input type="hidden" name="ques[]" value="<?php echo $sqxdata['ques']; ?>">
                                            <input type="hidden" name="quesid[]" value="<?php echo $sqxdata['id']; ?>">

                                        </label></div>
                                    <?php

                                    if ($sqxdata['multi'] == 'main') {
                                    ?>

                                        <?php


                                        if ($sqxdata['input'] == 'text') {
                                            foreach ($sqdarr as $optd => $optdvalue) {
                                                $optd1 = $optd + 1;
                                        ?>
                                                <div class="col-md-4">

                                                    <input type="text" class="form-control" id="inputEmail4" name="ans<?php echo $optd1; ?>[]" placeholder="<?= $optdvalue ?>">
                                                </div>




                                            <?php
                                            }
                                        } elseif ($sqxdata['input'] == 'select') {

                                            ?>

                                            <div class="col-md-6">
                                                <select class="form-control" name="ans1[]">
                                                    <option value="">Please Select</option>
                                                    <?php
                                                    foreach ($sqdarr as $optd => $optdvalue) {
                                                    ?>
                                                        <option value="<?= $optdvalue ?>"><?= $optdvalue ?></option>
                                                    <?php
                                                    } ?>
                                                </select>
                                            </div>
                                            <?php

                                        } elseif ($sqxdata['input'] == 'checkbox') {
                                            foreach ($sqdarr as $optd => $optdvalue) {
                                                $optd1 = $optd + 1;
                                            ?>
                                                <div class="col-md-4">
                                                    <input type="checkbox" name="ans<?php echo $optd1 . $ix; ?>" value="Yes"><span style="font-size:18px"> <?= $optdvalue ?></span>
                                                </div>
                                            <?php
                                            }
                                        }
                                    } else {

                                        if ($sqxdata['input'] == 'text') {
                                            ?>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" id="inputEmail4" name="ans1[]">
                                            </div>




                                        <?php
                                        } elseif ($sqxdata['input'] == 'date') {
                                        ?>
                                            <div class="col-md-6">
                                                <input type="date" class="form-control" id="inputEmail4" name="ans1[]">


                                            </div>
                                        <?php
                                        } elseif ($sqxdata['input'] == 'time') {
                                        ?>
                                            <div class="col-md-6">
                                                <input type="time" class="form-control" id="inputEmail4" name="ans1[]">


                                            </div>
                                        <?php
                                        } elseif ($sqxdata['input'] == 'cmnt') {
                                        ?>
                                            <div class="col-md-6">
                                                <textarea class="form-control" id="inputEmail4" name="ans1[]"></textarea>


                                            </div>
                                        <?php
                                        }
                                        ?>

                                    <?php
                                    }
                                    ?>
                                </div>
                                <hr>

                            <?php
                                $ix++;
                            }
                            ?>



                            <br />

                            <button class="btn btn-success" type="submit" name="submit">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php





?>