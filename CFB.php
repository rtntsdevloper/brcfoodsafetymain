<?php
date_default_timezone_set("Europe/London"); 
include 'connection.php';
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

    <link rel="stylesheet" href="dist-assets/css/plugins/dropzone.min.css" />


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
    <script src="dist-assets/js/plugins/dropzone.min.js"></script>
    <script src="dist-assets/js/scripts/dropzone.script.min.js"></script>
    <link rel="stylesheet" type="text/css" href="assets/reset.css">

    <script type='text/javascript'>
        function refreshCaptcha() {
            var img = document.images['captchaimg'];
            img.src = img.src.substring(0, img.src.lastIndexOf("?")) + "?rand=" + Math.random() * 1000;
        }
    </script>


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
                <!-- Mega menu -->
                <div class="dropdown mega-menu d-none d-md-block">
                    Regal Technical and Training Solutions Limited </div>
                <!-- / Mega menu -->
            </div>
            <div style="margin: auto"></div>
            <div class="header-part-right">
                <!-- Full screen toggle -->
                <i class="fa fa-arrows" data-fullscreen></i>
                <!-- Grid menu Dropdown -->

                <!-- Notificaiton -->

                <!-- Notificaiton End -->
                <!-- User avatar dropdown -->
                <div class="dropdown">

                </div>
            </div>
        </div>

        <div class="side-content-wrap">
            <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar="" data-suppress-scroll-x="true">
                <ul class="navigation-left">
                    <li class="nav-item"><a class="nav-item-hold" href="#"> <i class="fa fa-bank"
                                style="font-size:34px"></i><span class="nav-text">Dashboard</span></a>
                        <div class="triangle"></div>
                    </li>

                </ul>
            </div>

            <div class="sidebar-overlay"></div>
        </div>
        <!-- =============== Left side End ================-->
        <div class="main-content-wrap sidenav-open d-flex flex-column">
            <!-- ============ Body content start ============= -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <?php

                        if (isset($_GET['refno'])) {
                        ?>

                            <h4 style="color:#FF0000" align="center">
                                Thank You!<br />Your Complaint Reference No: <?php echo $_GET['refno']; ?></h4>
                        <?php
                        } else {
                        ?>

                            <div class="header">
                                <h4 class="title">Enter New Complaint</h4>
                                <br />

                            </div>

                            <div class="content">
                                <form name="form1" onSubmit="return checkReq()" action="newcomplaint1" method="post"
                                    enctype="multipart/form-data">

                                    <div class="row">

                                        <div class="col-md-12">
                                            <h1 class="my-3">
                                                Complaint information
                                            </h1>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label id="error">Date of complaint</label>
                                                <input type="date" class="form-control border-input" placeholder="Name"
                                                    name="compdate" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Type of complaint</label>
                                                <select class="form-control" name="catt" id="complaintType" onchange="showCategory(this.value)" required>
                                                    <option value="">Please Select</option>
                                                    <option value="Gluten Free">Gluten Free Complaint</option>
                                                    <option value="Other Complaints">Other Complaints</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label id="error">Category of complaint </label>
                                                <select name="catcomp" id="" class="form-control" required>
                                                    <option>Select Category</option>
                                                    <?php
                                                    $category = mysqli_query($con, "SELECT * FROM `tblcategory`");
                                                    foreach ($category as $catv) {

                                                    ?>

                                                        <option value="<?php echo $catv['name'] ?>"><?php echo $catv['name'] ?></option>
                                                    <?php
                                                    }

                                                    ?>


                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <h1 class="my-3">
                                                Customer details
                                            </h1>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label id="error">Name of customer</label>
                                                <input type="text" class="form-control border-input" placeholder="Name"
                                                    name="name" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Contact</label>
                                                <input type="number" class="form-control border-input" name="contact"
                                                    required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" class="form-control border-input" name="email">
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input type="text" class="form-control border-input" name="address"
                                                    required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Complaint Channel</label>
                                                <input type="text" class="form-control border-input" name="channel"
                                                    required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Select Country</label>
                                                <select name="country" id="" class="form-control" required>
                                                    <option value="">Please Select</option>
                                                    <option value="UK">UK</option>
                                                    <option value="USA">USA</option>
                                                </select>

                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Customer Store</label>
                                                <input type="text" class="form-control border-input" name="customerstore"
                                                    required>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <h1 class="my-3">
                                                Product details
                                            </h1>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Product Name</label>


                                                <select name="product" class="form-control" id="product" required>
                                                    <option value="">Please Select</option>
                                                    <?php
                                                    $sql2 = mysqli_query($con, "select * from tblproduct");
                                                    while ($rows = mysqli_fetch_array($sql2)) {
                                                    ?>
                                                        <option value="<?php echo $rows['name']; ?>" data-name="<?php echo $rows['prodcode']; ?>"> <?php echo $rows['name']; ?>
                                                        </option>

                                                    <?php
                                                    }
                                                    ?>

                                                </select>

                                            </div>
                                        </div>

                                        <div class="col-md-6" id="code1" style="display:none;">
                                            <div class="form-group">
                                                <label>Product code</label>

                                                <input type="text" name="code" id="myinput">
                                                <script>
                                                    document.getElementById('product').addEventListener('change', function() {
                                                        document.getElementById('code1').style.display = 'block';
                                                        const selectedOption = this.options[this.selectedIndex];
                                                        const dataName = selectedOption.getAttribute("data-name");
                                                        document.getElementById("myinput").value = dataName; // Corrected 'myInput' to 'myinput'
                                                    });
                                                </script>
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Batch code </label>
                                                <input type="text" class="form-control border-input" name="batch" >
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>UB / BB date</label><br>

                                                <label><input type="radio" name="showOption" value="Yes" onclick="toggleFields()" required> Yes</label>
                                                <label><input type="radio" name="showOption" value="No"  onclick="toggleFields()" required> No</label>

                                                <div id="dateField" style="display:none; margin-top: 10px;">
                                                    <input type="date" class="form-control border-input" name="udate">
                                                </div>

                                                <div id="commentBox" style="display:none; margin-top: 10px;">
                                                    <textarea class="form-control border-input" name="cdate" placeholder="Enter your comment..."></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Product Type</label>
                                                <select class="form-control" name="capty" id="" required>
                                                    <option value="">Please Select</option>
                                                    <option value="Ready to Eat">Ready To Eat</option>
                                                    <option value="Ready to Bake">Ready To Bake</option>
                                                </select>
                                            </div>
                                        </div>

                                        <script>
                                            function toggleFields() {
                                                const selectedValue = document.querySelector('input[name="showOption"]:checked').value;
                                                document.getElementById('dateField').style.display = selectedValue === 'Yes' ? 'block' : 'none';
                                                document.getElementById('commentBox').style.display = selectedValue === 'No' ? 'block' : 'none';
                                            }
                                        </script>


                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Issue (Please provide full detail) </label>
                                                <textarea type="batch" class="form-control border-input" name="issue"
                                                    required></textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Upload Photo</label>
                                                <input type="file" class="form-control border-input" name="file">
                                            </div>
                                        </div>

                                    </div>



                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Enter Captcha</label>
                                            <img src="captcha.php?rand=<?php echo rand(); ?>" id='captchaimg'><br>
                                            <label for='message'>Enter the code above here :</label>
                                            <br>
                                            <input id="captcha_code" name="captcha_code" type="text">
                                            <br>
                                            Can't read the image? click <a href='javascript: refreshCaptcha();'>here</a> to
                                            refresh.
                                        </div>
                                    </div>

                                    <input type="submit" name="submit" class="btn btn-danger">
                                </form>
                            </div>

                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ============ Search UI End ============= -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

</body>

</html>