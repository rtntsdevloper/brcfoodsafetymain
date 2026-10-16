<?php
$cid = $_GET['cid'];

$sqlx = mysqli_query($con, "SELECT g1.id,g1.grn,g2.pname FROM `tblgrn1` as g1 join tblrawmaterial as g2 on g1.product = g2.id where g2.coa ='Yes' and g1.grncode ='$cid'");
$sqlxn = mysqli_num_rows($sqlx);
if ($sqlxn > 0) {




?>
    <div class="col-md-12 mb-5">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=recip1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

                <div class="card-title">Goods In COA Upload
                </div>


                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data">
                    <div class="form-row">
                        <?php
                        foreach ($sqlx as $rowx) {
                        ?>
                            <div class="col-md-6 mb-3">
                                <label for="validationTooltip01">Upload COA For <?php echo $rowx['pname']; ?> (<?php echo $rowx['grn']; ?>)</label>
                                <input class="form-control" id="validationTooltip01" type="file" required="required" name="cfile[]" />
                                <input type="hidden" name="gid[]" value="<?php echo $rowx['id']; ?>">
                                <div class="invalid-tooltip">
                                    Please provide a valid first name.

                                </div>
                            </div>
                            <div class="col-md-6 mb-3"></div>
                        <?php
                        }
                        ?>
                    </div>
                    <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>

<?php
    if (isset($_POST['submit'])) {
        $gid = $_POST['gid'];
        $cfile = $_FILES['cfile'];

        for ($i = 0; $i < count($gid); $i++) {
            $gid1 = $gid[$i];
            if (isset($cfile['name'][$i]) && !empty($cfile['name'][$i])) {
                $filename = $_FILES['cfile']['name'][$i];
                $filetmp = $_FILES['cfile']['tmp_name'][$i];
                $filexn = date('YmdHis') . "_" . $gid1 . "_" . $filename;
                $filedest = "goodsin/coa/" . $filexn;
                if (move_uploaded_file($filetmp, $filedest)) {
                    $filesd = $filexn;
                } else {
                    $filesd = "";
                }
            }
            $sqlc = mysqli_query($con, "UPDATE `tblgrn1` SET `coa`='$filesd' WHERE `id`='$gid1'");
        }
        if ($sqlc) {
            echo "<script>
        window.open('admin.php?id=goods','_self');
        </script>";
        } else {
            echo "<script>alert('COA upload failed');</script>";
        }
    }
} else {
    echo "<script>
     window.open('admin.php?id=goods','_self');
     </script>";
}
?>