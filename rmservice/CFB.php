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
                        Your Supplier Nc has been successfully submiited! <br>
                        Thank You!<br />Your Supplier Nc : <?php echo $_GET['refno']; ?></h4>
                    <a href="admin?id=1" class="btn btn-success">Go Back</a>
                    <?php
                    echo "<script>setTimeout(function(){ window.location.href='admin.php?id=1'; }, 5000);</script>";
                    ?>

                <?php
                } else {
                ?>

                    <div class="header">
                        <h4 class="title">Raise Supplier Nc</h4>
                        <br />

                    </div>

                    <style>
                        .hidden {
                            display: none;
                        }
                    </style>

                    <div class="content">
                        <form name="form1" onSubmit="return checkReq()" action="rmservice/newcomplaint1" method="post" enctype="multipart/form-data">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label id="error">Name of Supplier</label>
                                        <select name="supplier" class="form-control" id="supname" required>
                                            <option>Select Supplier</option>
                                            <?php

                                            $q1 = mysqli_query($con, "SELECT * FROM `tblrawsupplier`");

                                            foreach ($q1 as $value) {

                                            ?>

                                                <option value='<?php echo $value['supname'] ?>' data-name="<?php echo $value['suptype']; ?>" data-id="<?php echo $value['supid']; ?>"><?php echo $value['supname'] ?></option>

                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <script>
                                    document.getElementById('supname').addEventListener('change', function() {
                                        var selectedValue = this.value;
                                        const selectedOption = this.options[this.selectedIndex];
                                        const dtnmv = selectedOption.getAttribute("data-name");
                                        const dtid = selectedOption.getAttribute("data-id");

                                        document.getElementById('spt').value = dtnmv;

                                        const rtwy = document.getElementById('rtwy');

                                        if (dtnmv === 'Raw Material Supplier' || dtnmv === 'Primary Packaging Supplier') {

                                            rtwy.classList.remove('hidden');

                                            var xhr = new XMLHttpRequest();
                                            xhr.open('GET', 'rmservice/rawcfb.php?id=' + dtid, true);
                                            xhr.onload = function() {
                                                if (xhr.status === 200) {
                                                    document.getElementById('content').innerHTML = xhr.responseText;
                                                }
                                            };
                                            xhr.send();

                                        } else {
                                            rtwy.classList.add('hidden');
                                        }

                                        // Create the AJAX request

                                    });
                                </script>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Type of Supplier</label>
                                        <input type="text" name="spt" id="spt" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6" >
                                    <div class="form-group">
                                        <label>Raw Material</label>
                                        <select class="form-control" name="rawm" id="content" multiple>
                                            <option value="">Please Select </option>
                                        </select>

                                    </div>

                                </div>



                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label id="error">Nc Detail</label>
                                        <textarea name="ncdetail" id="" class="form-control" required></textarea>
                                    </div>
                                </div>
                               
                                <div class="col-md-12 hidden" id="rtwy">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Is the NC raised is related to any raw material/ primary packaging supplied?</label><br>
                                                <input type="radio" name="ques" value="Yes" onchange="showHideques('Yes')"> Yes
                                                <input type="radio" name="ques" value="No" onchange="showHideques('No')"> No
                                            </div>
                                        </div>

                                        



                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <label for="Evidence">* Upload Evidence</label>
                                    <input type="file" name="file" id="" class="form-control">

                                </div>
                                <div class="col-md-6"></div>








                                <div class="col-md-4 mt-5">
                                    <div class="form-group">
                                        <label>Enter Captcha</label>
                                        <img src="captcha.php?rand=<?php echo rand(); ?>" id='captchaimg'><br>
                                        <label for='message'>Enter the code above here :</label>
                                        <br>
                                        <input id="captcha_code" name="captcha_code" type="text">
                                        <br>
                                        Can't read the image? click <a href='javascript: refreshCaptcha();'>here</a> to refresh.
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3"><input type="submit" name="submit" class="btn btn-danger"></div>
                                        <div class="col-md-6"></div>
                                    </div>


                                </div>
                            </div>


                        </form>
                    </div>

                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>