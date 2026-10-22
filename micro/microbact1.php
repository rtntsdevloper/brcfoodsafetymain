<div class="container-fluid">

    <div class="main-content">
        <div class="breadcrumb">
            <h1 class="mr-2"><?php echo $headingname; ?></h1>
            <ul>
                <li><a href="">Micro Trending</a></li>
                <li>Add Bacteria</li>
            </ul>
        </div>
        <div class="container mb-3">
            <div class="row">
                <div class="col-md-12">
                    <a href="admin.php?id=microbact" class="btn btn-success" style="float: right;">Go Back</a>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">Add Bacteria</div>

                            <form name="form1" class="needs-validation" novalidate="novalidate" method="post" action="" enctype="multipart/form-data">
                                <div class="form-row">
                                    <div class="col-md-6 col-sm-12">
                                        <label for="validationTooltip01">Name</label>
                                        <input class="form-control" id="validationTooltip01" type="text" placeholder="Name" required="required" name="sname" />
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
                                            while ($row = mysqli_fetch_array($sql)) {
                                            ?>
                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
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
                                        <input class="form-control" id="validationTooltip01" type="text" placeholder="Acceptable Limit" required="required" name="accept" />
                                        <div class="invalid-tooltip">
                                            Please provide a valid name.

                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="validationTooltip01">Rejectable Limit</label>
                                        <input class="form-control" id="validationTooltip01" type="text" placeholder="Rejectable Limit" required="required" name="reject" />
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
    $sname = mysqli_real_escape_string($con, $_POST['sname']);
    $accept = mysqli_real_escape_string($con, $_POST['accept']);
    $reject = mysqli_real_escape_string($con, $_POST['reject']);
    $section = mysqli_real_escape_string($con, $_POST['section']);
    $sq = mysqli_query($con, "insert into tbl_microbact (name,acceptl,rejectl,section) values ('$sname','$accept','$reject','$section')");
    if ($sq) {
        echo "<script>
        alert('Bacteria added successfully');
        window.location.href='admin.php?id=microbact';
        </script>";
    } else {
        echo "<script>alert('Bacteria not added'); 
        window.location.href='admin.php?id=microbact';</script>";
    }
}
