<?php
date_default_timezone_set('Europe/London');
$time = date("H:i");
?>
<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li>Yogurt production</li>
            <li><a href="">add</a></li>
        </ul>
    </div>

    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <a href="admin.php?id=yogurtproduction">
                        <button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button>
                    </a>

                    <h4 class="card-title mb-3">Yogurt Production</h4>

                    <form name="form1" method="post">
                        <div class="row">

                            <div class="col-md-6">
                                <label>Date</label>
                                <input type="date" name="date" id="productionDate" class="form-control" required />
                            </div>

                            <div class="col-md-6">
                                <label>Start Time</label>
                                <input type="time" name="stime" class="form-control" value="<?= $time; ?>" required />
                            </div>

                            <div class="col-md-6 mt-3">
                                <label>Product</label>
                                <select name="pname" class="form-control select2" id="yogurtSelect" required>
                                    <option value="">select</option>
                                    <?php
                                    $sql = mysqli_query($con, "SELECT * FROM `tblyogurt`");
                                    foreach ($sql as $row) { ?>
                                        <option value="<?php echo $row['id']; ?>">
                                            <?php echo $row['name']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <!-- Dynamic culture fields -->
                            <div id="cultureFields" style="display:none;" class="row mt-3"></div>

                            <div class="col-md-6 mt-3">
                                <label>Use By Date</label>
                                <input type="date" name="useby" id="useByDate" class="form-control" readonly required />
                            </div>

                            <div class="col-md-6 mt-3">
                                <label>Production Quantity</label>
                                <input type="number" name="qty" class="form-control" required />
                            </div>

                        </div>

                        <br>
                        <button type="submit" name="submit" class="btn btn-primary">Save & Next</button>
                    </form>
                </div>

                <!-- Select2 CSS/JS -->
                <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

                <script>
                $(document).ready(function() {
                    $('#yogurtSelect').select2({
                        placeholder: "Search product...",
                        allowClear: true,
                        minimumResultsForSearch: 0,
                        closeOnSelect: true
                    });

                    $('#yogurtSelect').on('change', function() {
                        let id = $(this).val();
                        if (id === "") {
                            $("#cultureFields").hide().html("");
                            return;
                        }
                        $.ajax({
                            url: "form/yogurtstock.php",
                            type: "GET",
                            data: { q: id },
                            success: function(response) {
                                let data = JSON.parse(response);
                                let fieldsHtml = "";
                                let nonEmpty = 0;

                                if (data.ct1) nonEmpty++;
                                if (data.ct2) nonEmpty++;
                                if (data.ct3) nonEmpty++;

                                let colClass = "col-md-12";
                                if (nonEmpty === 2) colClass = "col-md-6";
                                if (nonEmpty === 3) colClass = "col-md-4";

                                if (data.ct1) {
                                    fieldsHtml += `<div class="${colClass}">
                                        <label>Culture </label>
                                        <input type="text" name="ct1" id="ct1" class="form-control" value="${data.ct1}" />
                                    </div>`;
                                }
                                if (data.ct2) {
                                    fieldsHtml += `<div class="${colClass}">
                                        <label>Culture </label>
                                        <input type="text" name="ct2" id="ct2" class="form-control" value="${data.ct2}" />
                                    </div>`;
                                }
                                if (data.ct3) {
                                    fieldsHtml += `<div class="${colClass}">
                                        <label>Culture </label>
                                        <input type="text" name="ct3" id="ct3" class="form-control" value="${data.ct3}" />
                                    </div>`;
                                }

                                if (fieldsHtml !== "") {
                                    $("#cultureFields").html(fieldsHtml).show();
                                } else {
                                    $("#cultureFields").hide().html("");
                                }
                            }
                        });
                    });

                    // Auto-calculate Use By Date (next month, one day earlier)
                    $('#productionDate').on('change', function() {
                        let prodDate = new Date(this.value);
                        if (!isNaN(prodDate.getTime())) {
                            let nextMonthDate = new Date(prodDate);
                            nextMonthDate.setMonth(nextMonthDate.getMonth() + 1);
                            nextMonthDate.setDate(nextMonthDate.getDate() - 1);

                            let yyyy = nextMonthDate.getFullYear();
                            let mm = String(nextMonthDate.getMonth() + 1).padStart(2, '0');
                            let dd = String(nextMonthDate.getDate()).padStart(2, '0');

                            $('#useByDate').val(`${yyyy}-${mm}-${dd}`);
                        }
                    });
                });
                </script>

            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['submit'])) {
    $date   = mysqli_real_escape_string($con, $_POST['date']);
    $stime  = mysqli_real_escape_string($con, $_POST['stime']);
    $pname  = mysqli_real_escape_string($con, $_POST['pname']);
    $useby  = mysqli_real_escape_string($con, $_POST['useby']);
    $qty    = (float)$_POST['qty'];
    $finish = '';
    $ct1    = mysqli_real_escape_string($con, $_POST['ct1']);
    $ct2    = mysqli_real_escape_string($con, $_POST['ct2']);
    $ct3    = mysqli_real_escape_string($con, $_POST['ct3']);
    $uid    = date('dmY') . rand(1000, 9999);

    $factorQuery = mysqli_query($con, "SELECT cream, smp, type FROM tblyogurt WHERE id='$pname'");
    $factorRow   = mysqli_fetch_assoc($factorQuery);

    $creamFactor = (float)$factorRow['cream'];
    $smpFactor   = (float)$factorRow['smp'];
    $type        = $factorRow['type'];

    $cream = number_format($qty * $creamFactor, 2, '.', '');
    $smp   = number_format($qty * $smpFactor, 2, '.', '');

    if ($type === "fruit") {
        $fruit = number_format($qty * 0.16, 2, '.', '');
        $milk  = number_format($qty - $cream - $smp - $fruit, 2, '.', '');
    } else {
        $fruit = 0;
        $milk  = number_format($qty - $cream - $smp, 2, '.', '');
    }

    $sql = "INSERT INTO `tblyogurtproduction`
            (`date`,`start`,`finish`,`pname`,`useby`,`qty`,`uid`,`cream`,`smp`,`milk`,`fruit`,`ct1`,`ct2`,`ct3`) 
            VALUES('$date','$stime','$finish','$pname','$useby','$qty','$uid','$cream','$smp','$milk','$fruit','$ct1','$ct2','$ct3')";

    $result = mysqli_query($con, $sql);

    if ($result) {
        echo "<script>window.location.href='admin.php?id=yogurtproduction1&uid=$uid&pid=$pname';</script>";
    } else {
        echo "<script>alert('Error saving record: " . mysqli_error($con) . "');</script>";
    }
}
?>
