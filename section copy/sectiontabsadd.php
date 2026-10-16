<?php
$sno = $_GET['sno'];

if (isset($change) && $change == 1) {
    $change = $_GET['change'];
    $sql = mysqli_query($con, "select * from addtest1 where id = '$sno'");
    $row = mysqli_fetch_array($sql);
    $tabc = $row['tabs'];
    $tbac1 = explode(';', $tabc);
} else {

    $sql = mysqli_query($con, "select * from subtest where id = '$sno'");
    $row = mysqli_fetch_array($sql);
    $tabc = $row['tabs'];
    $tbac1 = explode(';', $tabc);
}


?>



<div class="main-content">
    <div class="breadcrumb">

        <ul class="ml-4">
            <li><a href="">Home</a></li>
            <li>Section Tabs </li>
        </ul>
    </div>
    <style>
        .hidden {
            display: none;
        }
    </style>

    <div class="container-fluid" style="margin-top:50px;">

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <a href="admin.php?id=sectiontabsview"><button class="btn btn-success"
                            style="float:right; margin-left:15px">Go Back</button></a>

                    <div class="card-title ml-1">Raw material</div>

                    <form class="needs-validation" novalidate="novalidate" method="post"
                        enctype="multipart/form-data">
                        <div class="form-row">



                            <div class="col-md-6 mb-3">
                                <label for="validationTooltip02">Sub-Section</label>
                                <input class="form-control" id="validationTooltip02" type="text" placeholder=""
                                    required="required" name="pcode" value="Section <?php echo $row['sid']; ?>" />
                                <div class="invalid-tooltip">
                                    Please fill in this field

                                </div>
                            </div>
                            <div class="col-md-6 mb-3">

                            </div>
                            <div class="col-12">
                                <label for="validationTooltip05">Tabs Access</label>
                                <div class="row">


                                    <?php
                                    $query = mysqli_query($con, "select * from tbltabs");
                                    $i = 1;
                                    while ($roc = mysqli_fetch_array($query)) {
                                        $sno1 = $roc['sno'];

                                    ?>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="<?php echo $roc['sno'] ?>" id="flexCheckDefault-<?php echo $roc['sno'] ?>" name="tab_acess[]" <?php in_array($sno1, $tbac1) ? $checked = 'checked' : $checked = ''; ?> />
                                                <label class="form-check-label" for="flexCheckDefault-<?php echo $roc['sno'] ?>">
                                                    <?php echo $roc['name'] ?> <?php echo $roc['name1'] ?>
                                                </label>
                                            </div>
                                        </div>

                                    <?php
                                        $i++;
                                    }
                                    ?>
                                </div>
                                <div class="invalid-tooltip">
                                    Please fill the field. </div>
                            </div>

                        </div>
                        <button class="btn btn-primary mt-5" type="submit" name="submit">Submit form</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
if (isset($_POST['submit'])) {

    $tab_acess = $_POST['tab_acess'];
    $tab_acess = implode(';', $tab_acess);

    $sql = mysqli_query($con, "update subtest set tabs = '$tab_acess' where id = '$sno'");
    if ($sql) {
        echo "<script>
        window.location.href = 'admin.php?id=sectiontabsview';
        </script>";
        echo "<script>alert('Data Updated Successfully')</script>";
    }
}

?>