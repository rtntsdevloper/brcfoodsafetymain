<div class="container">

    <div class="main-content">
        <div class="breadcrumb">
            <h1 class="mr-2"><?php echo $headingname; ?></h1>
            <ul>
                <li><a href="">Audit Management</a></li>
                <li>Add Audit & Specification Details</li>
            </ul>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">Add Section</div>

                            <form name="form1" class="needs-validation" novalidate="novalidate" method="post" action="" enctype="multipart/form-data">
                                <div class="form-row">
                                    <div class="col-12">
                                        <label for="validationTooltip01">Name</label>
                                        <input class="form-control" id="validationTooltip01" type="text" placeholder="Name" required="required" name="name" />
                                        <div class="invalid-tooltip">
                                            Please provide a valid name.

                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="validationTooltip01">Section Type</label>
                                        <select name="sect_type" class="form-control" required>
                                            <option>Please Select</option>
                                            <option value="audit">Audit</option>
                                            <option value="spec">Specification</option>

                                        </select>

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



                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">

                            <div class="card-title">Add Sub-Section</div>

                            <form class="needs-validation" novalidate="novalidate" method="post" name="form2" action="" enctype="multipart/form-data">
                                <div class="form-row">
                                    <div class="col-12">
                                        <label for="validationTooltip01">Section</label>
                                        <select class="form-control" id="validationTooltip01" required="required" name="sid">
                                            <option value="">Please Select</option>
                                            <?php
                                            $gh = mysqli_query($con, "select * from tblauditsection");
                                            while ($row = mysqli_fetch_array($gh)) {
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

                                    <div class="col-12">
                                        <label for="validationTooltip01">Section Name</label>
                                        <input class="form-control" id="validationTooltip01" type="text" placeholder="Name" required="required" name="sname" />
                                        <div class="invalid-tooltip">
                                            Please provide a valid name.
                                        </div>
                                    </div>




                                </div>



                                <br />

                                <button class="btn btn-primary" type="submit" name="submit2">Submit </button>
                            </form>
                        </div>
                    </div>
                </div>


                <div class="col-md-12 my-2">
                    <div class="card">
                        <div class="card-body">

                            <div class="card-title">Add Question</div>

                            <form class="needs-validation" novalidate="novalidate" method="post" name="form3" action="" enctype="multipart/form-data">
                                <div class="form-row">
                                    <div class="col-12">
                                        <label for="validationTooltip01">Section</label>
                                        <select class="form-control" id="validationTooltip01" required="required" name="sidd">
                                            <option value="">Please Select</option>
                                            <?php
                                            $gh1 = mysqli_query($con, "select * from tblauditsection");
                                            while ($row1 = mysqli_fetch_array($gh1)) {
                                            ?>
                                                <option value="<?php echo $row1['id']; ?>"><?php echo $row1['name']; ?></option>

                                            <?php
                                            }
                                            ?>
                                        </select>
                                        <div class="invalid-tooltip">
                                            Please provide a valid name.

                                        </div>
                                    </div>


                                    <div class="col-12">
                                        <label for="validationTooltip01">Sub-Section</label>
                                        <select class="form-control" id="validationTooltip01" required="required" name="ssid">
                                            <option value="">Please Select</option>
                                            <?php
                                            $gh2 = mysqli_query($con, "select * from tblauditsection1");
                                            while ($row2 = mysqli_fetch_array($gh2)) {
                                            ?>
                                                <option value="<?php echo $row2['id']; ?>"><?php echo $row2['name']; ?></option>

                                            <?php
                                            }
                                            ?>
                                        </select>
                                        <div class="invalid-tooltip">
                                            Please provide a valid name.
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="validationTooltip01">Question</label>
                                        <input class="form-control" id="validationTooltip01" type="text" placeholder="Name" required="required" name="ques" />
                                        <div class="invalid-tooltip">
                                            Please provide a valid name.

                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="validationTooltip01">Image</label>
                                        <input class="form-control" id="validationTooltip01" type="file" name="img" />
                                        <div class="invalid-tooltip">
                                            Please provide a valid name.

                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="validationTooltip01"> Answer Type (if required)</label>
                                        <br />
                                        Comment Box: <input type="radio" name="cmnt" value="yes" />
                                        <br />
                                        Photo Upload : <input type="radio" name="pic" value="yes" />
                                        <br />
                                        Text Box : <input type="radio" name="text" value="yes" />
                                        <br />
                                        Type: DATE/ NUMBER:
                                        <select class="form-control" name="sec1">
                                            <option value="">Please Select</option>
                                            <option value="date">Date</option>
                                            <option value="number">Number</option>

                                        </select>

                                        <div class="invalid-tooltip">
                                            Please provide a valid name.
                                        </div>
                                    </div>
                                </div>


                                <div class="col-12">
                                    <label for="validationTooltip01"> Required (Yes / No)</label>
                                    <br />
                                    <select class="form-control" name="sec2">
                                        <option value="">Please Select</option>
                                        <option value="required">Yes</option>
                                        <option value="">No</option>
                                    </select>


                                    <div class="invalid-tooltip">
                                        Please provide a valid name.
                                    </div>
                                </div>
                        </div>

                        <br />

                        <button class="btn btn-primary " type="submit" name="submit3">Submit </button>
                        </form>
                    </div>
                </div>



                <div class="row">



                    <div class="col-md-6 mt-5">
                        <div class="card">
                            <div class="card-body">

                                <div class="card-title">Add Answer</div>

                                <form class="needs-validation" novalidate="novalidate" method="post" name="form4" action="" enctype="multipart/form-data">

                                    <div class="form-row">
                                        <div class="col-12">
                                            <label for="validationTooltip01">Section</label>
                                            <select class="form-control" id="validationTooltip01" required="required" name="ssidd">
                                                <option value="">Please Select</option>
                                                <?php
                                                $gh21 = mysqli_query($con, "select * from tblauditsection");
                                                while ($row21 = mysqli_fetch_array($gh21)) {
                                                ?>
                                                    <option value="<?php echo $row21['id']; ?>"><?php echo $row21['name']; ?></option>

                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <div class="invalid-tooltip">
                                                Please provide a valid name.

                                            </div>
                                        </div>


                                        <div class="col-12">
                                            <label for="validationTooltip01">Sub-Section</label>
                                            <select class="form-control" id="validationTooltip01" required="required" name="sssid">
                                                <option value="">Please Select</option>
                                                <?php
                                                $gh22 = mysqli_query($con, "select * from tblauditsection1");
                                                while ($row22 = mysqli_fetch_array($gh22)) {
                                                ?>
                                                    <option value="<?php echo $row22['id']; ?>"><?php echo $row22['name']; ?></option>

                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <div class="invalid-tooltip">
                                                Please provide a valid name.

                                            </div>
                                        </div>


                                        <div class="col-12">
                                            <label for="validationTooltip01">Answer</label>
                                            <select class="form-control" id="validationTooltip01" name="ans[]" multiple="multiple">
                                                <option value="">Please Select</option>
                                                <?php
                                                // $gh22 = mysqli_query($con, "select distinct name from tblauditsection4");
                                                $gh22 = mysqli_query($con, "select * from tblauditsection4");
                                                while ($row22 = mysqli_fetch_array($gh22)) {
                                                ?>
                                                    <option value="<?php echo $row22['name']; ?>"><?php echo $row22['name']; ?>



                                                    </option><br>

                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <div class="invalid-tooltip">
                                                Please provide a valid name.
                                            </div>
                                        </div>
                                        <BR><br>
                                        <!-- <div class="col-12 my-2">
                                   
                                        <label for="validationTooltip01"><b style="color:brown;">(If answer is not available in above select option you can text in below box.)</b><br>Add Answer</label>
                                        <label for="validationTooltip01"></label>
                                        <input type="text" class="form-control" name="answer">
                                        <div class="invalid-tooltip">
                                            Please provide a valid name.

                                        </div>
                                    </div>
                                   
                                    <div class="col-12">
                                        <label for="validationTooltip01">Status</label>
                                        <input type="text" class="form-control" name="status">
                                        <div class="invalid-tooltip">
                                            Please fill.

                                        </div>
                                    </div> -->
                                    </div>


                                    <br />




                                    <button class="btn btn-primary" type="submit" name="submit4">Submit </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mt-5">
                        <div class="card">
                            <div class="card-body">

                                <div class="card-title">Add New Answer</div>

                                <form class="needs-validation" novalidate="novalidate" method="post" name="form4" action="" enctype="multipart/form-data">

                                    <div class="form-row">




                                        <BR><br>
                                        <div class="col-12 my-2">

                                            <label for="validationTooltip01"><b style="color:brown;"></b><br>Add New Answer</label>
                                            <label for="validationTooltip01"></label>
                                            <input type="text" class="form-control" name="answer" required>
                                            <div class="invalid-tooltip">
                                                Please provide a valid name.

                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label for="validationTooltip01">Status</label>
                                            <select class="form-control" name="status" required>
                                                <option value="">Please Select</option>
                                                <option value="Completed">Compliant</option>
                                                <option value="Waiting">NC</option>
                                                <option value="Not Applicable">Not Applicable</option>
                                                <option value="checkbox">CheckBox</option>
                                                <option value="text">Text Box</option>
                                            </select>


                                            <div class="invalid-tooltip">
                                                Please fill.

                                            </div>
                                        </div>
                                    </div>


                                    <br />

                                    <button class="btn btn-primary" type="submit" name="submit5">Submit </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <?php
                if (isset($_POST['submit1'])) {
                    $name = mysqli_real_escape_string($con, $_POST['name']);
                    $sec_name = mysqli_real_escape_string($con, $_POST['sect_type']);
                    $sql = mysqli_query($con, "insert into tblauditsection (name,name1)values('$name','$sec_name')");
                ?>
                    <script language="javascript">
                        window.open('admin.php?id=addaudit1', '_self');
                    </script>
                <?php
                }
                ?>


                <?php
                if (isset($_POST['submit2'])) {
                    $sid = $_POST['sid'];
                    $sname = mysqli_real_escape_string($con, $_POST['sname']);
                    $sql1 = mysqli_query($con, "insert into tblauditsection1 (sid,name)values('$sid','$sname')");
                ?>
                    <script language="javascript">
                        window.open('admin.php?id=addaudit1', '_self');
                    </script>
                <?php
                }
                ?>

                <?php
                if (isset($_POST['submit3'])) {
                    $sidd = $_POST['sidd'];
                    $ssid = $_POST['ssid'];
                    $ques = mysqli_real_escape_string($con, $_POST['ques']);
                    $cmnt = $_POST['cmnt'];
                    $pic = $_POST['pic'];
                    $text = $_POST['text'];
                    $sec1 = $_POST['sec1'];
                    $sec2 = $_POST['sec2'];

                    $img = $_FILES['img']['name'];
                    move_uploaded_file($_FILES['img']['tmp_name'], "gmpreport/" . $img);
                    // print_r("insert into tblauditsection2 (sid,ssid,ques,cmnt,pic,textbox,number,status1,img)values('$sidd','$ssid','$ques','$cmnt','$pic','$text','$sec1','$sec2','$img')");die;
                    $sql2 = mysqli_query($con, "insert into tblauditsection2 (sid,ssid,ques,cmnt,pic,textbox,number,status1,img)values('$sidd','$ssid','$ques','$cmnt','$pic','$text','$sec1','$sec2','$img')");

                ?>
                    <script language="javascript">
                        window.open('addaudit2.php', '_self');
                    </script>
                <?php
                }
                ?>
                <?php
                if (isset($_POST['submit4'])) {
                    // $answer=$_POST['answer'];

                    $ssidd = $_POST['ssidd'];
                    $sssid = $_POST['sssid'];

                    // $quess=mysqli_real_escape_string($con,$_POST['quess']);
                    // $ans=mysqli_real_escape_string($con,$_POST['ans']);

                    if (isset($_POST['ans'])) {
                        $as = $_POST['ans'];
                        $sssid = $_POST['sssid'];


                        $qps = mysqli_query($con, "SELECT * FROM `tblauditsection2` WHERE ssid ='$sssid'");
                        foreach ($qps as $qps1) {

                            foreach ($as as $key => $row) {
                                $query = "SELECT * FROM tblauditsection4 WHERE `name` = '$row'";
                                $result = mysqli_query($con, $query);
                                // print_r($row);die;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $xyz = $row['ans'];
                                    $sql212 = mysqli_query($con, "INSERT INTO tblauditsection3 (qid, ans, status) VALUES ('$qps1[id]', '$as[$key]', '$xyz')");
                                }
                            }
                        }

                        mysqli_close($con);
                    }



                    // foreach( $as as $ans){



                    // }
                ?>
                    <!-- <script language="javascript">
                        window.open('admin.php?id=addaudit', '_self');
                    </script> -->
                <?php
                }
                ?>

                <?php
                if (isset($_POST['submit5'])) {


                    // $ssidd = $_POST['ssidd'];
                    // $sssid = $_POST['sssid'];


                    if (isset($_POST['answer'])) {
                        $answer = $_POST['answer'];
                        $sta = $_POST['status'];
                    }
                    $ins = mysqli_query($con, "insert into `tblauditsection4` (name,ans) values('$answer','$sta')");
                    // $sql212 = mysqli_query($con, "insert into tblauditsection3 (qid,ans,status)values('$sssid','$answer','$sta')");

                ?>
                    <script language="javascript">
                        window.open('admin.php?id=addaudit', '_self');
                    </script>
                <?php
                }
                ?>