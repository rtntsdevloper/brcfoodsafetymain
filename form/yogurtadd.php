<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li>Yogurt Planning</li>
            <li><a href="">add</a></li>
        </ul>
    </div>

    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <a href="admin.php?id=yogurt1">
                        <button type="button" class="btn btn-success" style="float:right; margin-left:15px">Go Back</button>
                    </a>

                    <h4 class="card-title mb-3">Yogurt Planning</h4>

                    <form name="form1" method="post" action="">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Select Date</label>
                                <input type="date" name="date" class="form-control" required />
                            </div>
                            <div class="col-md-6">
                                <label>Checked by</label>
                                <input type="text" name="cname" class="form-control" required />
                            </div>
                        </div>

                        <?php
                        $sql1 = mysqli_query($con, "SELECT * FROM tblyogurt");
                        $i = 0;
                        $fruitFactor = 0.16;

                        while ($row1 = mysqli_fetch_array($sql1)) {
                            $productType = $row1['type'];
                        ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <br>
                                    <div class="form-group label-floating" style="font-size: 20px;">
                                        <?php echo $i + 1; ?>. <?php echo htmlspecialchars($row1['name']); ?>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="ques[]" value="<?php echo $row1['id']; ?>" />
                            <input type="hidden" id="creamFactor<?php echo $i; ?>" value="<?php echo $row1['cream']; ?>" />
                            <input type="hidden" id="smpFactor<?php echo $i; ?>" value="<?php echo $row1['smp']; ?>" />
                            <input type="hidden" id="productType<?php echo $i; ?>" value="<?php echo $productType; ?>" />
                            <input type="hidden" id="fruitFactor<?php echo $i; ?>" value="<?php echo $fruitFactor; ?>" />

                            <div class="row">
                                <div class="col-md-3">
                                    <br> <label>Batch</label>
                                    <input type="number" class="form-control" step="0.1" min="0" name="batch[]" id="batch<?php echo $i; ?>"
                                        oninput="calculateValues(<?php echo $i; ?>)">
                                </div>

                                <div class="col-md-3">
                                    <br> <label>Cream</label>
                                    <input type="number" class="form-control" name="cream[]" id="cream<?php echo $i; ?>" readonly>
                                </div>
                                <div class="col-md-3">
                                    <br> <label>SMP</label>
                                    <input type="number" class="form-control" name="smp[]" id="smp<?php echo $i; ?>" readonly>
                                </div>
                                <div class="col-md-3">
                                    <br>
                                    <label>Milk</label>
                                    <input type="number" class="form-control" name="milk[]" id="milk<?php echo $i; ?>" readonly>
                                </div>

                                <?php if ($productType == 'fruit') { ?>
                                    <div class="col-md-3">
                                        <br><label>Fruit </label>
                                        <input type="number" class="form-control" name="fruit[]" id="fruit<?php echo $i; ?>" readonly>
                                    </div>
                                <?php } else { ?>
                                    <input type="hidden" name="fruit[]" value="0">
                                <?php } ?>
                            </div>
                        <?php
                            $i++;
                        }
                        ?>
                        <br>
                        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                    </form>

                    <script>
                        function calculateValues(index) {
                            const batch = parseFloat(document.getElementById("batch" + index).value) || 0;
                            const creamFactor = parseFloat(document.getElementById("creamFactor" + index).value) || 0;
                            const smpFactor = parseFloat(document.getElementById("smpFactor" + index).value) || 0;
                            const productType = document.getElementById("productType" + index).value;

                            let smp = batch * smpFactor;
                            let cream = batch * creamFactor;
                            let milk = 0;
                            let fruit = 0;

                            if (productType === 'fruit') {
                                const fruitFactor = parseFloat(document.getElementById("fruitFactor" + index).value) || 0.16;
                                fruit = batch * fruitFactor;
                                const fruitField = document.getElementById("fruit" + index);
                                if (fruitField) {
                                    fruitField.value = fruit.toFixed(1);
                                }

                                const milkField = document.getElementById("milk" + index);
                                if (milk < 0) {
                                    milkField.style.color = "red";
                                    milkField.style.fontWeight = "bold";
                                    milkField.style.backgroundColor = "#ffe6e6";
                                } else {
                                    milkField.style.color = "";
                                    milkField.style.fontWeight = "";
                                    milkField.style.backgroundColor = "";
                                }
                            } else {
                                milk = batch - cream - smp;
                            }

                            const smpField = document.getElementById("smp" + index);
                            const creamField = document.getElementById("cream" + index);
                            const milkField = document.getElementById("milk" + index);

                            if (smpField) smpField.value = smp.toFixed(1);
                            if (creamField) creamField.value = cream.toFixed(1);
                            if (milkField) milkField.value = milk.toFixed(1);
                        }
                    </script>

                    <?php
                    include("connection.php");

                    if (isset($_POST['submit'])) {
                        $date  = mysqli_real_escape_string($con, $_POST['date']);
                        $cname = mysqli_real_escape_string($con, $_POST['cname']);

                        $ques  = $_POST['ques'];
                        $batch = $_POST['batch'];
                        $cream = $_POST['cream'];
                        $smp   = $_POST['smp'];
                        $milk  = $_POST['milk'];
                        $fruit = isset($_POST['fruit']) ? $_POST['fruit'] : array();

                        $batch1 = date('Ymd');
                        $uid = date('YmdHis') . rand(1000, 9999);

                        for ($i = 0; $i < count($ques); $i++) {
                            $qid   = mysqli_real_escape_string($con, $ques[$i]);
                            $bval  = round(floatval(mysqli_real_escape_string($con, $batch[$i])), 1);
                            $cval  = round(floatval(mysqli_real_escape_string($con, $cream[$i])), 1);
                            $sval  = round(floatval(mysqli_real_escape_string($con, $smp[$i])), 1);
                            $mval  = round(floatval(mysqli_real_escape_string($con, $milk[$i])), 1);

                            $checkTypeSql = mysqli_query($con, "SELECT type, cream, smp FROM tblyogurt WHERE id='$qid'");
                            $typeRow = mysqli_fetch_assoc($checkTypeSql);
                            $productType = $typeRow['type'];

                            if ($productType == 'fruit') {
                                $fruitVal = round($bval * 0.16, 1);
                            } else {
                                $fruitVal = 0;
                            }

                            $sql = "INSERT INTO tblyogurt1 (date, cname, ques, batch, cream, smp, milk, fruit, uid, batch1)
                                    VALUES ('$date', '$cname', '$qid', '$bval', '$cval', '$sval', '$mval', '$fruitVal', '$uid', '$batch1')";

                            mysqli_query($con, $sql);
                        }

                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                Data saved successfully!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                              </div>';

                        echo '<script>
                                setTimeout(function() {
                                    window.location.href = "admin.php?id=yogurtview&uid=' . $uid . ' ";
                                }, 2000);
                              </script>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>