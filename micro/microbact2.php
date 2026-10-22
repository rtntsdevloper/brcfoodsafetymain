<?php
$sno = $_GET['sno'];

$sql = mysqli_query($con, "select * from tbl_microbact where id='$sno'");
$row = mysqli_fetch_array($sql);

?>

<div class="container-fluid">

    <div class="main-content">
        <div class="breadcrumb">
            <h1 class="mr-2"><?php echo $headingname; ?></h1>
            <ul>
                <li><a href="">Micro Trending</a></li>
                <li>Edit Bacteria</li>
            </ul>
        </div>
        <div class="container mb-3">
            <div class="row">
                <div class="col-md-12">
                    <a href="admin.php?id=microview" class="btn btn-success" style="float: right;">Go Back</a>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">Edit Bacteria</div>

                            <form name="form1" class="needs-validation" novalidate="novalidate" method="post" action="" enctype="multipart/form-data">
                                <div class="form-row">
                                    <div class="col-md-6 col-sm-12">
                                        <label for="validationTooltip01">Name</label>
                                        <input class="form-control" id="validationTooltip01" type="text" placeholder="Name" value="<?= $row['name'] ?>" required="required" name="sname" />
                                        <div class="invalid-tooltip">
                                            Please provide a valid name.

                                        </div>
                                    </div>
                                     <div class="col-md-6 col-sm-12">
                                        <label for="validationTooltip01">Select Section</label>
                                        <select name="section" id="section" class="form-control">
                                            <option value="">Select Section</option>
                                            <?php
                                            $sql = mysqli_query($con, "SELECT * FROM `tbl_micortrend`");
                                            while ($rowd = mysqli_fetch_array($sql)) {
                                                if($rowd['id'] == $row['section']){
                                                    $selected = "selected";
                                                }else{
                                                    $selected = "";
                                                }
                                            ?>
                                                <option value="<?php echo $rowd['id']; ?>" <?= $selected ?>><?php echo $rowd['name']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        <div class="invalid-tooltip">
                                            Please provide a valid name.

                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="validationTooltip01">Acceptable Limit</label>
                                        <input class="form-control" id="validationTooltip01" type="text" placeholder="Acceptable Limit" value="<?= $row['acceptl'] ?>" required="required" name="accept" />
                                        <div class="invalid-tooltip">
                                            Please provide a valid name.

                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="validationTooltip01">Rejectable Limit</label>
                                        <input class="form-control" id="validationTooltip01" type="text" placeholder="Rejectable Limit" value="<?= $row['rejectl'] ?>" required="required" name="reject" />
                                        <div class="invalid-tooltip">
                                            Please provide a valid name.

                                        </div>
                                    </div>

                                </div>



                                <br />

                                <button class="btn btn-primary" type="submit" name="submit1">Submit </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['submit1'])) {
    $sname = $_POST['sname'];
    $accept = $_POST['accept'];
    $reject = $_POST['reject'];
    $section = $_POST['section'];
    $sq = mysqli_query($con, "update tbl_microbact set name='$sname',acceptl='$accept',rejectl='$reject',section='$section' where id='$sno'");
    if ($sq) {
        echo "<script>
        alert('Bacteria updated successfully');
        window.location.href='admin.php?id=microbact';
        </script>";
    } else {
        echo "<script>alert('Bacteria not updated'); window.location.href='admin.php?id=microbact';</script>";
    }
}