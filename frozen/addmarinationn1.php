<?php

$newdate = date("Y-m-d", strtotime("-3 months"));
$sqt1 = mysqli_query($con, "update tblgrn1 set status2='dactive' where useby<'$newdate' and useby!='0000-00-00'");

$batch = $_GET['batch'];
$sqq = mysqli_query($con, "select * from frozenmarination where batchcode='$batch'");
$rowq = mysqli_fetch_array($sqq);
$rowid = $rowq['id'];
$sno = $rowq['name'];
$str = $rowq['quantity'];

$sqlt = mysqli_query($con, "select * from frozenrecipe where id='$sno'");
$rowt = mysqli_fetch_array($sqlt);

$sql7 = mysqli_query($con, "select * from frozenrecipe1 where tid='$sno' and qty1 ='0'");
$hasExtra = (mysqli_num_rows($sql7) > 0);

$total17 = 0;
$qtyr7 = "";

if ($hasExtra) {
    $rows7 = mysqli_fetch_array($sql7);

    $totqty7 = $str * 1000;
    $total7 = $rows7['qty'];
    $total17 = round(($total7 * $totqty7) / 100, 5);

    if ($rows7['qty1'] == "1") {
        $total17 = $str;
        $qtyr7 = "Kg";
    } else {
        if ($total17 >= 1000) {
            $total17 = round($total17 / 1000, 5);
            $qtyr7 = "Kg";
        } else {
            $qtyr7 = "G";
        }
    }
}
?>

<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Dashboard</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="admin.php?id=1"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="#!">Home / Production - (Add New) </a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-12" style="margin-bottom:20px">
    <a href="admin.php?id=faddmarination">
        <button type="submit" class="btn btn-danger" style="float:right;">Go Back</button>
    </a>
</div>

<script>
    function cal1(str, qid, pid, sno, supid) {
        if (str == "") {
            str = "0";
        }

        if (str.length == 0) {
            document.getElementById("detail" + sno).innerHTML = "";
            return;
        } else {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("detail" + sno).innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "frozen/addmarination3.php?ans=" + str + "&qid=" + qid + "&pid=" + pid + "&batch=" + <?php echo $rowid; ?> + "&sno=" + sno + "&supid=" + supid, true);
            xmlhttp.send();
        }
    }
</script>

<div class="col-sm-12">
    <div class="card">
        <div class="card-body">
            <h4 style="color:#3399FF">Product: <?php echo $rowt['name']; ?></h4>

            <form name="form1" method="post" action="frozen/addmarination2" enctype="multipart/form-data" onsubmit="return cal2()">

                <div class="row">
                    <div class="col-md-12">
                        <?php
                        $sql = mysqli_query($con, "select * from frozenrecipe where id='$sno'");
                        $rows = mysqli_fetch_array($sql);
                        ?>

                        <input type="hidden" class="form-control" name="sno" value="<?php echo $sno; ?>" />
                        <input type="hidden" class="form-control" name="qt" value="<?php echo $str; ?>" />

                        <div class="col-12">
                            <input type="text" class="form-control" name="qtys" id="qtys" value="<?php echo $str; ?> Kg" disabled="disabled" />
                        </div>
                    </div>
                </div>

                <script language="javascript">
                    function cal3() {
                        var water = document.getElementById('water').value;
                        var water1 = document.getElementById('water1').value;

                        if (water != water1) {
                            document.getElementById('water1').value = "";
                            document.getElementById("qused").innerHTML = 'Please Enter Correct Value';
                            document.getElementById('water1').focus();
                            return false;
                        } else {
                            return true;
                        }
                    }
                </script>

                <div class="row" style="margin-top:10px">
                    <?php
                    $sql1 = mysqli_query($con, "select * from frozenrecipe1 where tid='$sno' and qty1 !='0'");
                    $i = 0;
                    while ($rows1 = mysqli_fetch_array($sql1)) {
                        $totqty = $str * 1000;
                        $total = $rows1['qty'];
                        $total1 = round(($total * $totqty) / 100, 5);

                        if ($total1 >= 1000) {
                            $total1 = round($total1 / 1000, 5);

                            if ($rows1['name'] == "Rapeseed Oil") {
                                $qtyr = "L";
                            } else {
                                $qtyr = "Kg";
                            }
                        } else {
                            $qtyr = "G";
                        }
                    ?>

                        <div class="col-12">
                            <label for="cc-exp" class="control-label mb-1" style="color:#0000FF">Ingredient</label>
                            <input type="text" class="form-control" value="<?php echo $rows1['name']; ?>: <?php echo $total1; ?> <?php echo $qtyr; ?>" disabled="disabled" />
                        </div>

                        <?php
                        $sql2 = mysqli_query($con, "select t1.*, SUM(t1.qty) AS s1, t2.rid from tblgrn1 t1, tblrawmaterial t2 where t1.leftqty!='0' and t1.leftqty!='' and t1.leftqty>=1 and t1.product=t2.id and t2.rid='$rows1[rid]' and t1.status2!='dactive' group by t1.product,t1.supplier,t1.grn");
                        while ($rows2 = mysqli_fetch_array($sql2)) {

                            $rty1 = mysqli_query($con, "select * from frozenmarination1 where batchcode='$batch' and pid='$rows2[product]' and grnid='$rows2[id]' and supplier='$rows2[supplier]'");
                            $matchh = mysqli_num_rows($rty1);
                            if ($matchh <= 0) {
                                $date = date("Y-m-d");
                                mysqli_query($con, "INSERT INTO frozenmarination1 (batchcode, pid, grnid, qty, qty1,product,useby,totalqty1,supplier) VALUES ('$batch', '$rows2[product]', '$rows2[id]','$total1','$qtyr','$rows1[name]','$rows2[useby]','$rows2[leftqty]','$rows2[supplier]')");
                            }

                            $rty = mysqli_query($con, "select * from frozenmarination1 where batchcode='$batch' and pid='$rows2[product]' and grnid='$rows2[id]' and supplier='$rows2[supplier]'");
                            $qury = mysqli_fetch_array($rty);

                            $y1 = mysqli_query($con, "select SUM(totalqty) AS totals, SUM(qty) AS totalqt from tblmarination1 where pid='$rows2[product]' and batchcode='$batch' and supplier='$rows2[supplier]'");
                            $fg = mysqli_fetch_array($y1);
                        ?>

                            <div class="col-3">
                                <label for="cc-exp" class="control-label mb-1">Left Quantity</label>
                                <input type="text" class="form-control" name="day<?php echo $i; ?>" value="<?php echo $rows2['leftqty']; ?>" disabled="disabled" />
                            </div>

                            <div class="col-4">
                                <label for="cc-exp" class="control-label mb-1">Use By : (Batch Code: <?php echo $rows2['batchcode']; ?>)</label>
                                <input type="date" class="form-control" name="day<?php echo $i; ?>" value="<?php echo $rows2['useby']; ?>" disabled="disabled" />
                            </div>

                            <div class="col-4">
                                <label for="x_card_code" class="control-label mb-1" id="qused<?php echo $i; ?>">Quantity Used</label>
                                <input type="text" class="form-control" name="qty<?php echo $i; ?>" id="qty<?php echo $i; ?>" value="<?php echo $qury['totalqty']; ?>" oninput="return cal1(this.value,<?php echo $qury['id']; ?>,<?php echo $rows2['product']; ?>,<?php echo $i; ?>,<?php echo $rows2['supplier']; ?>)" />
                            </div>

                        <?php
                        }
                        ?>

                        <div class="col-12" id="detail<?php echo $i; ?>" style="color:#FF0000; font-size:16px; font-family:Candara; margin:20px">
                            <?php
                            $savedQty = (float)$qury['totalqty'];
                            $requiredQ = (float)$qury['qty'];

                            if (abs($savedQty - $requiredQ) < 0.001) {
                            ?>
                                <input type="hidden" name="cmnt<?php echo $i; ?>" id="cmnt<?php echo $i; ?>" value="0" />
                            <?php
                            } else {
                            ?>
                                <input type="hidden" name="cmnt<?php echo $i; ?>" id="cmnt<?php echo $i; ?>" value="1" />
                            <?php
                            }
                            ?>
                        </div>

                        <div class="col-12" id="error<?php echo $i; ?>" style="color:#FF0000; font-size:16px; font-family:Candara; margin:20px"></div>

                    <?php
                        $i++;
                    }
                    ?>

                    <?php if ($hasExtra) { ?>
                        <div class="col-6">
                            <label for="cc-exp" class="control-label mb-1" style="color:#0000FF">Ingredient</label>
                            <input type="text" class="form-control" value="<?php echo $rows7['name']; ?>: <?php echo $total17; ?> <?php echo $qtyr7; ?>" disabled="disabled" />
                            <input type="hidden" class="form-control" id="water" value="<?php echo $total17; ?>" />
                        </div>
                        <div class="col-6">
                            <label for="x_card_code" class="control-label mb-1" id="qused" style="color:#FF0000">Quantity Used</label>
                            <input type="text" class="form-control" name="water1" id="water1" onchange="return cal3()" required />
                        </div>
                    <?php } ?>

                </div>
                <br />

                <script>
                    function cal() {
                        var n = <?php echo $i; ?>;
                        var hasExtra = <?php echo $hasExtra ? 'true' : 'false'; ?>;

                        // Step 1: validate all main ingredient rows
                        for (var t3 = 0; t3 < n; t3++) {
                            var y = t3;
                            var e = y + 1;

                            var cmntEl = document.getElementById("cmnt" + y);
                            if (!cmntEl) {
                                continue;
                            }

                            var cmnt = cmntEl.value;

                            if (cmnt == "" || cmnt == "1") {
                                document.getElementById('error' + y).innerHTML = "*Please enter correct value for input ." + e + " *";
                                document.getElementById('qty' + y).focus();
                                document.getElementById("submit").style.display = 'none';
                                return false;
                            } else {
                                document.getElementById('error' + y).innerHTML = "";
                            }
                        }

                        // Step 2: only if recipe needs an extra ingredient, validate water
                        if (hasExtra) {
                            var water = document.getElementById('water').value;
                            var water1 = document.getElementById('water1').value;

                            if (water1 == "") {
                                document.getElementById("qused").innerHTML = 'Please Enter Correct Value';
                                document.getElementById('water1').focus();
                                return false;
                            }

                            if (water != water1) {
                                document.getElementById('water1').value = "";
                                document.getElementById("qused").innerHTML = 'Please Enter Correct Value';
                                document.getElementById('water1').focus();
                                return false;
                            }
                        }

                        // Step 3: all good, redirect
                        window.open('frozen/addmarination2.php?batch=<?php echo $batch; ?>&water=<?php echo $total17; ?><?php echo $qtyr7; ?>', '_self');

                        return true;
                    }
                </script>

                <div class="row">
                    <div class="col-12"></div>
                    <div class="col-6">
                        <button class="btn btn-danger" type="button" name="check" onclick="return cal()">Verify</button>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>