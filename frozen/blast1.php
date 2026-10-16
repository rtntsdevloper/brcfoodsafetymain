<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Traceability</a></li>
            <li>View Detail</li>
        </ul>
    </div>

    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <a href="admin.php?id=fblast"> <button class="btn btn-info" style="float:right; margin-left:15px" type="button">Go Back</button></a>
                    <h4 class="card-title mb-3">Storage Records</h4>

                    <form class="needs-validation" novalidate="novalidate" method="post" action="" enctype="multipart/form-data">

                        <div class="form-row">
                            <div class="col-md-6">
                                <label for="validationTooltip01">Date/Time</label>
                                <input class="form-control" id="validationTooltip01" type="datetime-local" required="required" name="date" />
                                <div class="invalid-tooltip">
                                    Please fill the field.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="validationTooltip02">Select Product Batchcode</label>
                                <select class="form-control" name="product" id="product" required onchange="fillShelfLife()">
                                    <option value="">Please Select</option>
                                    <?php
                                    $sqli = mysqli_query($con, "select * from frozenproduction where  storage = ''  order by date DESC");
                                    while ($row = mysqli_fetch_array($sqli)) {
                                    ?>
                                        <option value="<?php echo $row['batchcode']; ?>"
                                                data-useby="<?php echo date('Y-m-d', strtotime($row['useby'])); ?>"
                                                data-leftsheet="<?php echo $row['qty']; ?>">
                                            <?php echo $row['batchcode']; ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <div class="invalid-tooltip">
                                    Please fill the field.
                                </div>
                            </div>

                            <div class="col-md-6"><br>
                                <label for="validationTooltip03">Shelf life</label>
                                <input class="form-control" id="validationTooltip03" type="date" required="required" name="shelflife" readonly />
                                <div class="invalid-tooltip">
                                    Please fill the field.
                                </div>
                            </div>

                             <div class="col-md-6"><br>
                                <label for="validationTooltip07">Qty</label>
                                <input type="number" id="validationTooltip07" name="qty" class="form-control" >
                                <div class="invalid-tooltip">
                                    Please fill the field.
                                </div>
                            </div>  

                            <div class="col-md-6"><br>
                                <label for="validationTooltip04">Freezer No.</label>
                                <input type="text" id="validationTooltip04" name="freezerno" class="form-control">
                                <div class="invalid-tooltip">
                                    Please fill the field.
                                </div>
                            </div>

                            <div class="col-md-6"><br>
                                <label for="validationTooltip05">Temperature of Freezer</label>

                                <div class="input-group mb-3">
                                    <input type="number" id="validationTooltip05" name="temp" class="form-control" required>
                                    <span class="input-group-text" id="basic-addon2">°C</span>
                                </div>
                                <div class="invalid-tooltip">
                                    Please fill the field.
                                </div>
                            </div>
                           

                        </div>

                        <br />
                        <button class="btn btn-primary" type="submit" name="submit">Submit </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    function fillShelfLife() {
        var sel = document.getElementById('product');
        var selectedOption = sel.options[sel.selectedIndex];

        // Shelf Life auto-fill from data-useby
        var useby = selectedOption.getAttribute('data-useby') || '';
        document.getElementById('validationTooltip03').value = useby;

        // No of Sheet (Qty) auto-fill from data-leftsheet
        var leftsheet = selectedOption.getAttribute('data-leftsheet') || '';
        document.getElementById('validationTooltip07').value = leftsheet;
    }
</script>

<?php
if (isset($_POST['submit'])) {
    $date        = $_POST['date'];
    $product     = $_POST['product'];
    $shelflife   = $_POST['shelflife'];
    $freezerno   = $_POST['freezerno'];
    $temp        = $_POST['temp'];
    $qty     = $_POST['qty'];

    $user = $_SESSION['user'];
    $sql = mysqli_query($con, "INSERT INTO frozenblast (datetime, productbatch, shelflife, freezerno, temp, qty, user) VALUES ('$date', '$product', '$shelflife', '$freezerno', '$temp', '$qty', '$user')");
if($sql){
    $sql1 = mysqli_query($con, "update frozenproduction set storage='done' where batchcode='$product'");
}
?>
    <script language="javascript">
        window.open('admin.php?id=fblast', '_self');
    </script>
<?php
}
?>