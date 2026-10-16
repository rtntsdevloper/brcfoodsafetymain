<?php

$fid = $_GET['fid'];
$pid = $_GET['pid'];
?>

<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Dashboard</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#!">Home / Frying Record - (Add New) </a></li>
                </ul>

            </div>
        </div>
    </div>
</div>

<div class="container-fluid">

    <div class="card">

        <div class="card-body">





            <form method="post">

                <div class="row  mt-2">
                    <div class="col-md-6 col-sm-12">
                        <label for="cc-exp" class="control-label mb-1">Select Flavour Batch</label>
                        <select name="flvb" class="form-control" id="flvid">
                            <option>Select Grn Batch</option>

                            <?php

                            $sg = mysqli_query($con, "SELECT * FROM `tblgrn1` WHERE product='$fid'");
                            foreach ($sg as $sgdata) {
                            ?>
                                <option value="<?php echo $sgdata['grn']; ?>" data-name="<?php echo $sgdata['leftqty']; ?>" data-date="<?php echo $sgdata['useby']; ?>"><?php echo $sgdata['grn']; ?></option>
                            <?php
                            }

                            ?>

                        </select>
                    </div>
                    <script>
                        document.getElementById('flvid').addEventListener('change', function() {
                            const selectedOption = this.options[this.selectedIndex];
                            const dataName = selectedOption.getAttribute('data-name');
                            const dataDate = selectedOption.getAttribute('data-date');

                            document.getElementById('adstw').value = dataName;

                        });
                    </script>



                    <div class="col-md-6 col-sm-12">
                        <label for="cc-exp" class="control-label mb-1">Additional Batch Start Weight (In Kg )</label>
                        <input type="number" class="form-control" name="adstrw" id="adstw" required />
                    </div>

                    <div class="col-md-6 col-sm-12">
                        <label for="cc-exp" class="control-label mb-1">Additional Batch End Weight (In Kg ) </label>
                        <input type="number" class="form-control" name="adendw" id="stw" required />
                    </div>
                    <div class="col-md-12 mt-3">
                        <button type="submit" class="btn btn-info" name="btn">Submit</button>
                    </div>

                </div>
            </form>
        </div>
    </div>

</div>

<?php
if (isset($_POST['btn'])) {

    $flvb = $_POST['flvb'];
    $adstrw = $_POST['adstrw'];
    $adendw = $_POST['adendw'];


    $sql = "UPDATE `tbllabel` SET `astrw`='$adstrw',`aenw`='$adendw', `adbatchx`='$flvb' WHERE id='$pid'";
    $sql1 = mysqli_query($con, $sql);

    $updt = mysqli_query($con, "UPDATE `tblgrn1` SET `leftqty`='$adendw' WHERE grn ='$flvb'");



    if ( $sql1 and $updt) {

?>
        <script>
            document.location.href = 'admin.php?id=package';
        </script>

<?php
    }
}


?>