<?php
 
 
 
// mysqli_set_charset($con,'utf8');
 
$tid = $_GET['tid'];
$sq2 = mysqli_query($con, "select * from dailychecks where id='$tid'");
$qu2 = mysqli_fetch_array($sq2);
?>
 
<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $qu2['name']; ?>
        </h1>
        <ul>
            <li><a href="">Home</a></li>
            <li><?php echo $headingname; ?></li>
        </ul>
    </div>
    <div class="row">
        <a href="admin.php?id=dailychecks&tid=<?php echo $tid; ?>"><button class="btn btn-success"
                style="float:right; margin-left:15px ">Go Back</button></a>
    </div> <br />
    <div class="col-md-12"></div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <!-- <div class="col-md-12" style="color:#996600"><?php echo $qu2['status']; ?></div> -->
                </br>
 
                <form name="form1" action="dailychecks2" enctype="multipart/form-data" method="post">
 
 
                    <div class="row">
                        <div class="col-md-6">
                            <label for="validationTooltip01"> Select Date</label>
                            <input type="date" name="date" class="form-control" required />
                        </div>
                        <div class="col-md-6">
                            <label for="validationTooltip01"> Enter Name</label>
                            <input type="text" name="name" class="form-control" required />
                        </div>
 
                        <?php if ($tid == 1) { ?>
                            <div class="col-md-6">
                                <label for="validationTooltip01"> Time</label>
                                <input type="time" name="stime" class="form-control" required />
                            </div>
 
                            <div class="col-md-6">
                                <label for="validationTooltip01">Truck No.</label>
                                <input type="text" name="truckno" class="form-control" required />
                            </div>
 
 
 
                            <div class="col-md-6">
                                <label for="validationTooltip01">Operator Name</label>
                                <input type="text" name="operator" class="form-control" required />
                            </div>
 
                        <?php } ?>
 
                    </div>
                    </br>
 
                    </br>
                    <div id="txtHint"></div>
 
                    <?php
                    $sql2 = mysqli_query($con, "select distinct section from dailychecks1 where tid='$tid'");
                    $j = 0;
                    $i = 0;
                    while ($th = mysqli_fetch_array($sql2)) {
                        $j++;
                    ?>
                        <div class="row">
                            <div class="col-md-12" align="center">
 
                                <h2 style="color:#0000FF"><?php echo $j; ?>. <?php echo $th['section']; ?></h2>
                            </div>
                        </div>
                        <?php
                        $sql1 = mysqli_query($con, "select * from dailychecks1 where tid='$tid' and section='$th[section]'");
 
                        while ($row1 = mysqli_fetch_array($sql1)) {
                            $comment = $row1['comment'];
                            $file = $row1['file'];
                            $yesno = $row1['yesno'];
                            $inputbox = $row1['inputbox'];
                            $dateinput = $row1['dateinput'];
                            $ans = $row1['ans_status'];
                            $answer = $row1['answer'];
 
                            $answer = explode(";", $answer);
                            //  print_r($answer);
 
 
                        ?>
 
                            <input type="hidden" name="tid" value="<?php echo $tid; ?>" />
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group label-floating">
 
                                        <?php if ($row1['name']) { ?>
                                            <b>Name:<?php echo $row1['name']; ?><br></b>
                                        <?php       }
                                        ?>
                                        <?php if ($row1['number']) { ?>
                                            <b> Number:<?php echo $row1['number']; ?></b><br>
                                        <?php       }
                                        ?>
 
                                        <?php echo $i + 1; ?>. <?php echo $row1['ques']; ?>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="section[]" value="<?php echo $th['section']; ?>" />
                            <input type="hidden" name="ques[]" value="<?php echo $row1['ques']; ?>" />
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group label-floating">
 
                                        <?php
                                        if ($ans == "yes" && !empty($answer)) {
                                            // echo '<b>Answer: </b>';
                                            echo '<select class="form-control" >';
                                            echo '<option value=""  >Select Please</option>';
                                            foreach ($answer as $ansOpt) {
                                                if (trim($ansOpt) !== '') {
                                                    echo '<option >' . htmlspecialchars($ansOpt) . '</option>';
                                                }
                                            }
                                            echo '</select>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
 
 
                            <div class="row">
 
                                <?php
                                if ($dateinput == "yes") {
                                ?>
                                    <div class="col-md-3">
                                        <?php if ($dateinput == "yes") { ?>
                                            <div class="form-group label-floating">
                                                <input type="datetime-local" name="dateinput<?php echo $i; ?>" class="form-control">
                                            </div>
                                        <?php } ?>
                                    </div>
 
                                <?php
                                }
                                ?>
                                <?php if ($inputbox == "yes") { ?>
                                    <div class="col-md-3">
                                        <div class="form-group label-floating">
                                            <input type="text" name="input<?php echo $i; ?>" class="form-control">
                                        </div>
                                    </div>
 
                                <?php } ?>
 
                                <?php if ($yesno === "yes") { ?>
                                    <div class="col-md-3">
                                        <div class="form-group label-floating">
                                            <select
                                                name="r1<?php echo $i; ?>"
                                                id="r1<?php echo $i; ?>"
                                                onclick="comment(<?php echo $i; ?>, this.value)"
                                                class="form-control"
                                                required>
                                                <option>Please Select</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </div>
                                    </div>
                                <?php } elseif ($tid == 1 && $th['section'] === 'Defect Reporting') { ?>
                                    <div class="col-md-3">
                                        <div class="form-group label-floating">
                                            <select
                                                name="r1<?php echo $i; ?>"
                                                id="r1<?php echo $i; ?>"
                                                onclick="comment(<?php echo $i; ?>, this.value)"
                                                class="form-control"
                                                required>
                                                <option>Please Select</option>
                                                <option value="Forklift Removed for Service">Forklift Removed for Service</option>
                                                <option value="Supervisor informed">Supervisor informed</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </div>
                                    </div>
                                <?php } ?>
 
 
                                <?php if ($comment == "yes") { ?>
                                    <div class="col-md-3">
                                        <div class="form-group label-floating">
                                            <textarea name="cmnt<?php echo $i; ?>" id="f1<?php echo $i; ?>" class="form-control"
                                                placeholder="Comment"></textarea>
                                        </div>
                                    </div>
                                <?php }
                                if ($file == "yes") {
                                ?>
 
                                    <div class="col-md-3">
                                        <div class="form-group label-floating">
                                            <input type="file" name="img<?php echo $i; ?>" class="form-control"
                                                accept="image/*,.jpg,.png,.jpeg">
                                        </div>
                                    </div>
                                <?php } ?>
 
 
 
                            </div>
                            <div class="row" id="error<?php echo $i; ?>" style="color:#FF0000"></div>
                    <?php
                            $i++;
                        }
                    }
                    ?>
 
                    <script>
                        function comment(id, ans) {
                            const commentr = document.getElementById("f1" + id);
                            if (ans == "No") {
                                commentr.setAttribute("required", "required");
                            } else {
                                commentr.removeAttribute("required");
                            }
                        }
                    </script>
 
 
 
 
                    <div class="row">
 
 
                        <div class="col-md-3">
                            <div class="form-group label-floating">
                                <button type="submit" class="btn btn-primary pull-right" name="submit">Submit</button>
                            </div>
                        </div>
                    </div>
 
                </form>