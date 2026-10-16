<?php
$pro = $_GET['prid'];

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
};
?>
<div class="main-content">

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title mb-5">
                            <h2>Update Specification (<?php echo $prox1['prodname']; ?>)</h2>
                        </div>
                        <a href="admin.php?id=productspec2&pro=<?php echo $prod; ?>&sid=<?php echo $sid; ?>" class="btn btn-primary">Back</a>

                        <form name="form1" class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data">
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
                            foreach ($sqx as $sqxdata) {
                                $squesid = $sqxdata['id'];

                                $updateqx = mysqli_query($con, "SELECT * FROM `save_specification1` WHERE pxid ='$pro' and qid ='$squesid'");
                                $upans = mysqli_fetch_array($updateqx);
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
                                                    <label for="inputEmail4"><?= $optdvalue ?></label>
                                                    <input type="text" class="form-control" id="inputEmail4" name="ans<?php echo $optd1; ?>[]" value="<?= $upans['ans' . $optd1] ?>" placeholder="<?= $optdvalue ?>">
                                                </div>




                                            <?php
                                            }
                                        } elseif ($sqxdata['input'] == 'select') {

                                            ?>

                                            <div class="col-md-6">
                                                <select class="form-control" name="ans1[]">
                                                    <option value="<?= $upans['ans1'] ?>"><?= $upans['ans1'] ?></option>
                                                    <?php
                                                    foreach ($sqdarr as $optd => $optdvalue) {
                                                    ?>
                                                        <option value="<?= $optdvalue ?>"><?= $optdvalue ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <?php

                                        } elseif ($sqxdata['input'] == 'checkbox') {
                                            foreach ($sqdarr as $optd => $optdvalue) {
                                                $optd1 = $optd + 1;
                                                $pdxnu = $upans['ans' . $optd1]
                                            ?>
                                                <div class="col-md-4">
                                                    <input type="checkbox" name="ans<?php echo $optd1; ?>[]" value="Yes" <?php if ($pdxnu == 'Yes') {
                                                                                                                                echo 'checked';
                                                                                                                            } ?>><span style="font-size:18px"> <?= $optdvalue ?></span>
                                                </div>
                                            <?php
                                            }
                                        }
                                    } else {

                                        if ($sqxdata['input'] == 'text') {
                                            ?>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" id="inputEmail4" name="ans1[]" value="<?= $upans['ans1'] ?>">
                                            </div>




                                        <?php
                                        } elseif ($sqxdata['input'] == 'date') {
                                        ?>
                                            <div class="col-md-6">
                                                <input type="date" class="form-control" id="inputEmail4" name="ans1[]" value="<?= $upans['ans1'] ?>">


                                            </div>
                                        <?php
                                        } elseif ($sqxdata['input'] == 'time') {
                                        ?>
                                            <div class="col-md-6">
                                                <input type="time" class="form-control" id="inputEmail4" name="ans1[]" value="<?= $upans['ans1'] ?>">


                                            </div>
                                        <?php
                                        } elseif ($sqxdata['input'] == 'cmnt') {
                                        ?>
                                            <div class="col-md-6">
                                                <textarea class="form-control" id="inputEmail4" name="ans1[]"><?= $upans['ans1'] ?></textarea>


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

if (isset($_POST['submit'])) {
    $pro = $_POST['pro'];
    $prod = $_POST['prod'];
    $sid = $_POST['sid'];
    $user = $_POST['user'];

    $ques = $_POST['ques'];
    foreach ($ques as $qkey => $qvalue) {
        $quesid = $_POST['quesid'][$qkey];
        if ($sid == '3') {
            if (isset($_POST['ans1' . $qkey])) {
                $ans1 = htmlspecialchars($_POST['ans1' . $qkey]);
            } else {
                $ans1 = '';
            }

            if (isset($_POST['ans2' . $qkey])) {
                $ans2 = htmlspecialchars($_POST['ans2' . $qkey]);
            } else {
                $ans2 = '';
            }


            if (isset($_POST['ans3' . $qkey])) {
                $ans3 = htmlspecialchars($_POST['ans3' . $qkey]);
            } else {
                $ans3 = '';
            }
        } else {


            if (isset($_POST['ans1'][$qkey])) {
                $ans1 = htmlspecialchars($_POST['ans1'][$qkey]);
            } else {
                $ans1 = '';
            }

            if (isset($_POST['ans2'][$qkey])) {
                $ans2 = htmlspecialchars($_POST['ans2'][$qkey]);
            } else {
                $ans2 = '';
            }


            if (isset($_POST['ans3'][$qkey])) {
                $ans3 = htmlspecialchars($_POST['ans3'][$qkey]);
            } else {
                $ans3 = '';
            }
        }


        $sqxl = "UPDATE `save_specification1` 
         SET
             `ques`='$qvalue',
             `ans1`='$ans1',
             `ans2`='$ans2',
             `ans3`='$ans3',
             `user`='$user'
         WHERE `qid`='$quesid' and `pxid`='$pro' and  `product`='$prod'";


        $sqxl1 = mysqli_query($con, $sqxl);
    }


    if ($sqxl1) {
?>
        <script>
            window.location.href = "admin.php?id=productspec2&pro=<?php echo $prod; ?>&sid=<?php echo $sid; ?>";
        </script>

<?php
    } else {
        echo "Error: " . $sqxl . "<br>" . mysqli_error($con);
    }
}
?>