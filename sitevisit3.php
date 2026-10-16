    <?php
    // Initialize variables
    $sno = $_GET['sno'] ?? '';


    $ds = mysqli_query($pcon, "SELECT * FROM `tblform_users` where id = $sno");
    $ds1 =mysqli_fetch_array($ds);
    $name = $ds1['user_name'];




    $nm  = str_replace(' ', '', $name);




    ?>



    <div class="col-lg-12 mb-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-wrap align-items-center justify-content-between breadcrumb-content">
                    <h5>Site Visit Report</h5>
                    <a href="admin.php?id=sitevisit" class="btn btn-primary">Go Back</a>
                </div>
            </div>
        </div>
    </div>


    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <iframe src="https://psdteams.com/sitevisit/SITEVISIT-<?php echo $nm. '-' . $sno; ?>.pdf" width="100%" height="800"></iframe>
                </div>
            </div>