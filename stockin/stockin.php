<?php
$sno = $_GET['sno'];
?>

<style>
    @media (max-width: 767.98px) {
        .btn-md-inline {
            width: 100%;
        }

        .card-body {
            padding: 1rem;
        }
    }
</style>

<div class="main-content">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body">

                <!-- Header: stacks on mobile, inline on sm+ -->
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center mb-3 pb-2 border-bottom" style="color:#996600">
                    <h3 class="mb-2 mb-sm-0">Add to Store</h3>
                    <button class="btn btn-success">Go Back</button>
                </div>

                <form name="form1" enctype="multipart/form-data" method="post">

                    <!-- Date -->
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <label for="validationTooltip01">Select Date</label>
                                <input type="date" name="date" class="form-control"
                                    value="<?= date('Y-m-d') ?>" required />
                            </div>
                        </div>
                    </div>

                    <?php
                    $sql1 = mysqli_query($con, "SELECT 
                            g1.*,
                            s.supname,
                            r.pname
                        FROM tblgrn1 AS g1
                        INNER JOIN tblgrnno2 AS g
                            ON g1.grncode = g.grnno
                        LEFT JOIN tblrawsupplier AS s
                            ON g1.supplier = s.supid
                        LEFT JOIN tblrawmaterial AS r
                            ON g1.product = r.id
                        WHERE g.id = '$sno';");
                    $i = 0;
                    while ($row1 = mysqli_fetch_array($sql1)) {
                        $rowid = $row1["id"];
                    ?>

                        <!-- Product name -->
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="form-group label-floating font-weight-bold">
                                    <?php echo $i + 1; ?>. <?php echo $row1['pname'] . "   (" . $row1['supname'] . ")"; ?>
                                    <input type="hidden" name="tid[]" value="<?php echo $rowid; ?>" />
                                    <input type="hidden" name="pname[]" value="<?php echo $row1['pname']; ?>" />
                                    <input type="hidden" name="prodid[]" value="<?php echo $row1['product']; ?>" />
                                    <input type="hidden" name="supname[]" value="<?php echo $row1['supname']; ?>" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-3">
                                <label for="qty_<?php echo $i; ?>">Quantity: <?= $row1['qty'] . ' ' . $row1['unitm'] ?></label>
                                <input type="hidden" name="goodqty[]" value="<?= $row1['qty'] ?>">

                            </div>

                            <div class="col-12 col-sm-6 col-md-3">
                                <label for="batch_<?php echo $i; ?>">Batch Code : <?= $row1['batchcode'] ?></label>
                                <input type="hidden" name="batchcode[]" value="<?= $row1['batchcode'] ?>">
                                <input type="hidden" name="grn[]" value="<?= $row1['grn'] ?>">

                            </div>

                            <div class="col-12 col-sm-6 col-md-3">
                                <label for="expdate_<?php echo $i; ?>">Exp Date : <?php
                                                                                    if ($row1['uomm'] == 'N/A') {
                                                                                        echo "N/A";
                                                                                    } else {
                                                                                        echo date('d-M-Y', strtotime($row1['useby']));
                                                                                    }
                                                                                    ?></label>
                                <input type="hidden" name="expdate[]" value="<?= $row1['useby'] ?>">
                                <input type="hidden" name="ubtype[]" value="<?= $row1['uomm'] ?>">
                            </div>

                            <div class="col-12 col-sm-6 col-md-3">
                                <label for="actualqty_<?php echo $i; ?>">Actual Quantity</label>
                                <div class="form-group">
                                    <div class="input-group mb-2">
                                        <input type="number" name="actualqty[]" step="0.001" id="actualqty_<?php echo $i; ?>"
                                            class="form-control" placeholder="Actual Quantity" value="<?= $row1['qty'] ?>" required />
                                        <div class="input-group-append">
                                            <div class="input-group-text bg-light"><?= $row1['unitm'] ?></div>
                                        </div>
                                        <input type="hidden" name="unitm[]" value="<?= $row1['unitm'] ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="error<?php echo $i; ?>" style="color:#FF0000"></div>
                    <?php
                        $i++;
                    }
                    ?>

                    <!-- Submit: full width on mobile -->
                    <div class="row  mt-4 mx-0 py-3">
                        <div class="col-md-2 text-center ">
                            <button type="submit" class="btn btn-primary btn-md-inline font-weight-bold d-inline-flex justify-content-center align-items-center" style="border-radius: 8px; padding: 12px 30px; background: linear-gradient(135deg, #0d6efd, #0b5ed7); border: none; box-shadow: 0 4px 10px rgba(13,110,253,0.3); transition: all 0.3s ease; letter-spacing: 0.5px;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 15px rgba(13,110,253,0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(13,110,253,0.3)';" name="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16" style="margin-right: 8px;">
                                    <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z" />
                                </svg>
                                Submit
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<?php
if (isset($_POST['submit'])) {
    $date = $_POST['date'];


    $tid = $_POST['tid'];

    foreach ($tid as $key => $value) {
        $pname = $_POST['pname'][$key];
        $supname = $_POST['supname'][$key];
        $unitm = $_POST['unitm'][$key];
        $actualqty = $_POST['actualqty'][$key];
        $grn = $_POST['grn'][$key];
        $goodqty = $_POST['goodqty'][$key];
        $add_on = date('Y-m-d H:i:s');
        $batchcode = $_POST['batchcode'][$key];
        $expdate = $_POST['expdate'][$key];
        $prodid = $_POST['prodid'][$key];
        $ubtype = $_POST['ubtype'][$key];


        $sql = mysqli_query($con, "INSERT INTO `stock_in`(`date`, `tid`,`prodid`, `pname`, `supname`, `unitm`, `actualqty`, `grn`, `add_on`, `add_by`,`goodqty`,`batchcode`,`useby`,`ubtype`) VALUES ('$date','$value','$prodid','$pname','$supname','$unitm','$actualqty','$grn','$add_on','$user','$goodqty','$batchcode','$expdate','$ubtype')");
    }

    $supq = mysqli_query($con, "UPDATE `tblgrnno2` SET `stockin`='Done' WHERE id='$sno'");

    if ($sql && $supq) {
        echo "<script> window.location.href='admin.php?id=goods';</script>";
    } else {
        echo "<script>alert('Stock In Failed'); window.location.href='admin.php?id=goods';</script>";
    }
}


?>