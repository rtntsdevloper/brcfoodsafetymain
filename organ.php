<?php
date_default_timezone_set("Europe/London");
include 'connection.php';

// Get record id from URL
$rid = $_GET['id'] ?? '';

if (empty($rid)) {
    die("Error: Record ID is required.");
}

// Select the row based on the dynamic id
$sql = mysqli_query($con, "SELECT * FROM `tblorgan` WHERE recordid='$rid' ");
$row = mysqli_fetch_array($sql);

if (!$row) {
    die("Error: Record not found.");
}

// Handle form submission
if (isset($_POST['submit'])) {
    $appearance1 = mysqli_real_escape_string($con, $_POST['appearance1'] ?? '');
    $aroma1      = mysqli_real_escape_string($con, $_POST['aroma1'] ?? '');
    $flavour1    = mysqli_real_escape_string($con, $_POST['flavour1'] ?? '');
    $texture1    = mysqli_real_escape_string($con, $_POST['texture1'] ?? '');

    // Update the same record id
    $update = "UPDATE `tblorgan` 
               SET `appearance1`='$appearance1',
                   `aroma1`='$aroma1',
                   `flavour1`='$flavour1',
                   `texture1`='$texture1'
               WHERE recordid='$rid'";

    if (mysqli_query($con, $update)) {
        echo "<script>
           
                    window.location.href = 'index.php';
        </script>";
    } else {
        echo "<script>
            Swal.fire({
                title: 'Error!',
                text: 'Error updating record: " . mysqli_error($con) . "',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en" dir="">

<head>
    <meta charset="ISO-8859-1">
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title> RTNTS - Web Portal </title>
    <link rel="shortcut icon" href="favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
    <link href="dist-assets/css/themes/lite-purple.min.css" rel="stylesheet" />
    <link href="dist-assets/css/plugins/perfect-scrollbar.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="dist-assets/css/plugins/sweetalert2.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="dist-assets/js/plugins/jquery-3.3.1.min.js"></script>
    <script src="dist-assets/js/plugins/bootstrap.bundle.min.js"></script>
    <script src="dist-assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="dist-assets/js/scripts/script.min.js"></script>
    <script src="dist-assets/js/scripts/sidebar.large.script.min.js"></script>
    <script src="dist-assets/js/plugins/echarts.min.js"></script>
    <script src="dist-assets/js/scripts/echart.options.min.js"></script>
    <script src="dist-assets/js/plugins/datatables.min.js"></script>
    <script src="dist-assets/js/scripts/form.validation.script.min.js"></script>
    <script src="dist-assets/js/scripts/dashboard.v1.script.min.js"></script>
    <script src="dist-assets/js/plugins/sweetalert2.min.js"></script>

    <link rel="stylesheet" type="text/css" href="assets/reset.css">

    <script type='text/javascript'>
        function refreshCaptcha() {
            var img = document.images['captchaimg'];
            img.src = img.src.substring(0, img.src.lastIndexOf("?")) + "?rand=" + Math.random() * 1000;
        }
    </script>

    <style>
        .form-section {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .form-section h5 {
            color: #6e00ff;
            border-bottom: 2px solid #6e00ff;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        textarea {
            resize: vertical;
        }
    </style>
</head>

<body class="text-left">
    <div class="app-admin-wrap layout-sidebar-large">
        <div class="main-header">
            <img src="images/logo1.png" alt="" width="70" style="margin-left:20px">
            <div class="menu-toggle">
                <div></div>
                <div></div>
                <div></div>
            </div>
            <div class="d-flex align-items-center">
                <div class="dropdown mega-menu d-none d-md-block">
                    Regal Technical and Training Solutions Limited
                </div>
            </div>
            <div style="margin: auto"></div>
            <div class="header-part-right">
                <i class="fa fa-arrows" data-fullscreen></i>
            </div>
        </div>

        <div class="side-content-wrap">
            <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar="" data-suppress-scroll-x="true">
                <ul class="navigation-left">
                    <li class="nav-item">
                        <a class="nav-item-hold" href="index.php"> 
                            <i class="fa fa-bank" style="font-size:34px"></i>
                            <span class="nav-text">Dashboard</span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                </ul>
            </div>
            <div class="sidebar-overlay"></div>
        </div>

        <div class="main-content-wrap sidenav-open d-flex flex-column">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="header">
                            <h4 class="title">Weekly Production Organoleptic Assessment Record</h4>
                            <br />
                            <p style="color:#009933">
                                Please complete the organoleptic assessment for the selected production record.
                            </p>
                        </div>

                        <div class="content">
                            <form method="post" enctype="multipart/form-data">
                                <?php if ($row['appearance'] == 1) { ?>
                                    <div class="form-section">
                                        <h5>Appearance</h5>
                                        <div class="form-group">
                                            <label>QAS Comments (Appearance)</label>
                                            <textarea class="form-control" name="appearance1" rows="4" required><?php echo htmlspecialchars($row['appearance1']); ?></textarea>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if ($row['aroma'] == 1) { ?>
                                    <div class="form-section">
                                        <h5>Aroma</h5>
                                        <div class="form-group">
                                            <label>QAS Comments (Aroma)</label>
                                            <textarea class="form-control" name="aroma1" rows="4" required><?php echo htmlspecialchars($row['aroma1']); ?></textarea>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if ($row['flavour'] == 1) { ?>
                                    <div class="form-section">
                                        <h5>Flavor</h5>
                                        <div class="form-group">
                                            <label>QAS Comments (Flavor)</label>
                                            <textarea class="form-control" name="flavour1" rows="4" required><?php echo htmlspecialchars($row['flavour1']); ?></textarea>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if ($row['texture'] == 1) { ?>
                                    <div class="form-section">
                                        <h5>Texture</h5>
                                        <div class="form-group">
                                            <label>QAS Comments (Texture)</label>
                                            <textarea class="form-control" name="texture1" rows="4" required><?php echo htmlspecialchars($row['texture1']); ?></textarea>
                                        </div>
                                    </div>
                                <?php } ?>

                                <div class="text-center">
                                    <button type="submit" name="submit" class="btn btn-primary btn-lg">
                                        <i class="fa fa-save"></i> Save Assessment
                                    </button>
                                    <!-- <a href="index.php" class="btn btn-secondary btn-lg">
                                        <i class="fa fa-arrow-left"></i> Cancel
                                    </a> -->
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<?php 

if(!empty($appearance1) || !empty($aroma1) || !empty($texture1) || !empty($flavour1)){
    echo "<script>
        Swal.fire({
            title: 'Success!',
            text: 'Corrective actions added successfully.',
            icon: 'success',
            showConfirmButton: false,
            timer: 5000
        });
        setTimeout(function(){
            window.location.href = 'index.php';
        }, 5000);
    </script>";


}

?>