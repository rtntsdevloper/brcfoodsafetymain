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
                    <li class="nav-item"><a class="nav-item-hold" href=""> <i class="fa fa-bank"
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

                        <div class="header">
                            <h4 class="title"> VISITORS QUESTIONNAIRE </h4>
                            <br />

                            <p style="color:#009933" style="text-align: justify;justify-item:center;">
                                ICU is committed to providing and maintaining a safe working environment for all employees and external visitors. As a contractor / visitor, we request that you read and comply with the standards we expect from our employees. If you feel you are unable to conform with one or all of the standards below, please inform your host who will refers to an internal authority to discuss your issues.<br>
                                <br>
                                It is UNACCEPTABLE for any contractor/visitor to circulate/work within this factory without the company's host authorisation. Failure to do so will result in the visit/contract being terminated immediately. PROOF OF IDENTITY SHALL BE REQUIRED.<br>
                                <br>
                                It is the company's host responsibility to ensure that his/her guest(s) understand and comply with the company's standards.<br>
                                <br>


                            </p>

                        </div>


                        <div class="content">
                            <form name="form1" onSubmit="return checkReq()" action="vistor1" method="post"
                                enctype="multipart/form-data">
                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label id="error">Name</label>
                                            <input type="text" class="form-control border-input" placeholder="Name"
                                                name="name" required>
                                        </div>
                                    </div>




                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label> Name of Organisation</label>
                                            <input name="org" id="" class="form-control">

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label> Reason for visit</label>
                                            <textarea class="form-control border-input" name="reason"
                                                required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label> Upload Picture</label>
                                            <input type="file" name="pic" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label> Vehicle Registration No.</label>
                                            <textarea class="form-control border-input" name="vehiclereg"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">



                                    <?php
                                    $sql = mysqli_query($con, "select * from tblques where module='vistor'");
                                    $i = 0;
                                    while ($row = mysqli_fetch_array($sql)) {

                                    ?>
                                        <input type="hidden" name="qid[]" value="<?php echo $row['id']; ?>">
                                        <input type="hidden" name="ques[]" value="<?php echo $row['ques']; ?>">
                                        <input type="hidden" name="module[]" value="<?php echo $row['module']; ?>">
                                        <input type="hidden" name="status[]" value="<?php echo $row['status']; ?>">
                                        <input type="hidden" name="statuss[]" value="<?php echo $row['status1']; ?>">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label style="color:#0000FF"><?php echo $i + 1; ?>.
                                                    <?php echo $row['ques']; ?></label>
                                            </div>
                                        </div>
                                        <?php
                                        if ($i == 8) {
                                        ?>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <input type="hidden" id="t1<?php echo $i; ?>"
                                                        value="<?php echo $row['status2']; ?>" />
                                                    <select class="form-control" name="ans[]" id="s1<?php echo $i; ?>"
                                                        onchange="showHint7(this.value,'<?php echo $i; ?>')" required>
                                                        <option value="">Please Select</option>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                        <?php
                                        } else if ($i == 9) {
                                        ?>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <input type="hidden" id="t1<?php echo $i; ?>"
                                                        value="<?php echo $row['status2']; ?>" />
                                                    <select class="form-control" name="ans[]" id="s1<?php echo $i; ?>"
                                                        onchange="showHint6(this.value,'<?php echo $i; ?>')" required>
                                                        <option value="">Please Select</option>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                        <?php
                                        } else {
                                        ?>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <input type="hidden" id="t1<?php echo $i; ?>"
                                                        value="<?php echo $row['status2']; ?>" />
                                                    <select class="form-control" name="ans[]" id="s1<?php echo $i; ?>" onchange="showHint5(this.value,'<?php echo $i; ?>')" required>
                                                        <option value="">Please Select</option>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No</option>
                                                    </select>

                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label>Comment</label>
                                                <textarea class="form-control border-input" id="cmnt<?php echo $i; ?>"
                                                    name="cmnt[]"></textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-4  hidden" id="opt<?php echo $i; ?>">
                                            <h1 class="text-warning mb-4"><?php echo $i + 1; ?>a. Have you been symptoms free for the last 48 hours?</h1>
                                            <input type="hidden" name="subpartq" value="Have you been symptoms free for the last 48 hours? ">
                                            <select class="form-control" name="ansparta<?php echo $i; ?>" id="optid<?php echo $i; ?>" onchange="showHint2(this.value,'<?php echo $i; ?>')">
                                                <option>Please Select</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>

                                        <div class="col-md-12 mb-4 hidden" id="warn<?php echo $i; ?>">
                                            <h1 class="text-danger mb-4">A doctor's certificate may be required before you enter any area containing products.</h1>


                                        </div>


                                        <div class="col-md-12 mb-4 hidden" id="warnp<?php echo $i; ?>">
                                            <h1 class="text-primary mb-4">Please request a First Aid Member or staff or Manager to issue</h1>


                                        </div>










                                        <div class="col-md-12">
                                            <div class="form-group" id="error<?php echo $i; ?>" style="color:#FF0000">
                                            </div>
                                        </div>
                                    <?php
                                        $i++;
                                    }
                                    ?>

                                </div>
                                <div class="col-md-12">
 <input type="checkbox" id="toggleBox" required> I hereby declare that I have presented my valid identification to the host. I understand that entry will not be permitted without providing proper ID. <br><br> 
                                    <input type="checkbox" id="toggleBox" onclick="toggleButton()"> I hereby declare that the information I have given is correct and I undertake to notify ICU if I suffer from any of the above illnesses/conditions.


                                </div>

                                <script>
                                    function showHint5(ans, qid) {
                                        const opt = document.getElementById('opt' + qid);
                                        const optid = document.getElementById('optid' + qid);

                                        if (ans === "No") {
                                            opt.classList.add('hidden');
                                            optid.removeAttribute('required');
                                        } else {
                                            opt.classList.remove('hidden');
                                            optid.setAttribute('required', 'true');
                                        }
                                    }

                                    function showHint2(ans, qpid) {
                                        var warn = document.getElementById('warn' + qpid);

                                        if (ans == "Yes") {
                                            // Set N/A values
                                            warn.classList.remove('hidden');


                                        } else {
                                            // Set N/A values
                                            warn.classList.add('hidden');


                                        }
                                    }



                                    function showHint6(aans, pid) {
                                        var divcmnt = document.getElementById("cmnt" + pid);

                                        if (aans === "No") {
                                            divcmnt.setAttribute('required', 'true');
                                        } else {
                                            divcmnt.removeAttribute('required');
                                        }
                                    }


                                    function showHint7(tans, tid) {

                                        var warnp = document.getElementById("warnp" + tid);

                                        if (tans == "Yes") {
                                            warnp.classList.remove('hidden');
                                        } else {
                                            warnp.classList.add('hidden');
                                        }
                                    }

                                    function toggleButton() {
                                        var checkBox = document.getElementById("toggleBox");
                                        var btn = document.getElementById("actionBtn");

                                        if (checkBox.checked) {
                                            btn.classList.remove('hidden');
                                        } else {
                                            btn.classList.add('hidden')
                                        }
                                    }
                                </script>

                                <?php


                                ?>








                                <div class="col-md-4 mt-2">
                                    <div class="form-group">
                                        <label>Enter Captcha</label>

                                        <img src="captcha.php?rand=<?php echo rand(); ?>" id='captchaimg'>
                                        <br>
                                        <label for='message'>Enter the code above here :</label>
                                        <br>
                                        <input id="captcha_code" name="captcha_code" type="text">
                                        <br>
                                        Can't read the image? click <a href='javascript: refreshCaptcha();'>here</a> to
                                        refresh.
                                    </div>
                                </div>
                                <div class="text-center " id="sbmt">
                                    <button type="submit" name="submit"
                                        class="btn btn-info btn-fill btn-wd hidden" id="actionBtn">Submit</button>
                                </div>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                </div>

                <script>
                    function checkReq() {
                        var n = <?php echo $i; ?>;
                        for (var t3 = 0; t3 <= n; t3++) {
                            var y = t3;
                            var e = y + 1;
                            var boxes = document.getElementsByName("a" + y);
                            for (var x = 0; x <= boxes.length; x++) {
                                if (boxes[0].checked == false && boxes[1].checked == false && boxes[2].checked == false) {
                                    document.getElementById('error' + y).innerHTML = "*Please choose one option for question no." + e + " *";
                                    boxes[x].focus();
                                    return false;
                                } else {
                                    document.getElementById('error' + y).innerHTML = "";
                                }
                            }
                        }
                    }
                </script>
            </div>
        </div>
        <!-- PAGINATION CONTROL -->
        <!-- ============ Search UI End ============= -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

</body>

</html>