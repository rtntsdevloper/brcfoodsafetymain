<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"></link> -->
<div class="main-content">
    <div class="breadcrumb">

        <ul>
            <li><a href="">Home</a></li>
            <li>Monthly Management Meeting</li>
            <li>Add Details</li>
        </ul>
    </div>
    <div class="container-fluid mb-5 pb-3" style="margin-top:100px;">

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <a href="admin.php?id=monthly_review"><button class="btn btn-success"
                            style="float:right; margin-left:15px">Go Back</button></a>

                    <div class="card-title">Monthly Management Meeting Details Add</div>

                    <form class="needs-validation" novalidate="novalidate" method="post" action=""
                        enctype="multipart/form-data">
                        <div class="form-row mt-5">
                            <div class="col-md-3"> <label for="validationTooltip03" class="h5">Month Covered In
                                    Meeting</label>
                            </div>
                            <div class="col-md-9 mb-3">

                                <select name="mtmn" class="form-control" id="validationTooltip03"
                                    placeholder="Select Month" required="required">
                                    <option value="">Select Month</option>
                                    <option value="January">January</option>
                                    <option value="February">February</option>
                                    <option value="March">March</option>
                                    <option value="April">April</option>
                                    <option value="May">May</option>
                                    <option value="June">June</option>
                                    <option value="July">July</option>
                                    <option value="August">August</option>
                                    <option value="September">September</option>
                                    <option value="October">October</option>
                                    <option value="November">November</option>
                                    <option value="December">December</option>
                                </select>
                            </div>


                        </div>

                        <div class="form-row">
                            <div class="col-md-3"> <label for="validationTooltip03" class="h5">Date of Meeting</label>
                            </div>
                            <div class="col-md-9 mb-3">

                                <input name="mtdt" type="date" class="form-control" id="validationTooltip03"
                                    placeholder="Attendees Name" required="required" />
                                <div class="invalid-tooltip">
                                    Please fill in this field

                                </div>
                            </div>


                        </div>
                        <div class="form-row">
                            <div class="col-md-3"> <label for="validationTooltip03" class="h5">Meeting Start
                                    Time</label></div>
                            <div class="col-md-9 mb-3">

                                <input name="mts" type="time" class="form-control" id="validationTooltip03"
                                    placeholder="Attendees Name" required="required" />
                                <div class="invalid-tooltip">
                                    Please fill in this field

                                </div>
                            </div>


                        </div>
                        <div class="form-row">
                            <div class="col-md-3"> <label for="validationTooltip03" class="h5">Meeting End Time</label>
                            </div>
                            <div class="col-md-9 mb-3">

                                <input name="mtend" type="time" class="form-control" id="validationTooltip03"
                                    placeholder="Attendees Name" required="required" />
                                <div class="invalid-tooltip">
                                    Please fill in this field

                                </div>
                            </div>

                        </div>

                        <div class="form-row">
                            <div class="col-md-3"> <label for="validationTooltip03" class="h5">Meeting Location</label>
                            </div>
                            <div class="col-md-9 mb-3">

                                <input name="mloc" type="text" class="form-control" id="validationTooltip03"
                                    placeholder="Meeting Location" required="required" />
                                <div class="invalid-tooltip">
                                    Please fill in this field

                                </div>
                            </div>


                        </div>




                        <style>
                            .selected-options {
                                margin-top: 10px;
                                border: 1px solid #ddd;
                                padding: 10px;
                                min-height: 20px;
                            }

                            .selected-item {
                                display: inline-block;
                                background: #f0f0f0;
                                padding: 5px 10px;
                                margin: 2px;
                                border-radius: 3px;
                            }

                            .remove-btn {
                                margin-left: 5px;
                                cursor: pointer;
                                color: red;
                            }
                        </style>


                        <div class="form-row mt-5">
                            <div class="col-md-3"> <label for="attendeeSelect" class="h5">Attendees of Meeting</label>
                            </div>
                            <div class="col-md-9 mb-3">
                                <select id="attendeeSelect" class="form-control" >
                                    <option value="" disabled selected>Select attendee</option>
                                    <?php
                                    $meetatte = mysqli_query($con, "SELECT * FROM `tbl_mmmattende`");
                                    foreach ($meetatte as $data) {
                                        ?>
                                        <option value="<?php echo $data['name']; ?>"
                                            data-name="<?php echo $data['designation']; ?>">
                                            <?php echo $data['name'] . " (" . $data['designation'] . " )"; ?>
                                        </option>

                                        <?php
                                    }
                                    ?>


                                </select>
                                <input type="hidden" id="attendeeValues" name="attendee_values">
                                <input type="hidden" id="attendeeDataNames" name="attendee_data">
                                <button type="button" id="addAttendeeBtn" class="btn btn-sm btn-primary mt-2">Add
                                    Attendee</button>

                                <div id="selectedAttendeesContainer" class="selected-options mt-2">
                                    No attendees selected yet
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-9" id="other_task_div"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 col-sm-8"></div>
                            <div class="col-md-2 col-sm-4">
                                <button class="btn btn-primary my-2" type="button" id="other_task"
                                    onclick="addInput()">Add More Attendees</button>
                            </div>
                        </div>


                        <script>
                            function addInput() {
                                var div = document.getElementById("other_task_div");
                                var input = document.createElement("input");
                                input.type = "text";
                                input.placeholder = "Attendees Name"
                                input.name = "name[]";
                                input.className = "form-control my-2";
                                div.appendChild(input);

                                var desigInput = document.createElement("input");
                                desigInput.type = "text";
                                desigInput.placeholder = "Attendees Designation"
                                desigInput.name = "desig[]";
                                desigInput.className = "form-control my-2";
                                div.appendChild(desigInput);
                            }
                        </script>


                        <!-- Add these hidden input fields to your form -->


                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                const attendeeSelect = document.getElementById('attendeeSelect');
                                const addAttendeeBtn = document.getElementById('addAttendeeBtn');
                                const selectedAttendeesContainer = document.getElementById('selectedAttendeesContainer');
                                const attendeeValuesInput = document.getElementById('attendeeValues');
                                const attendeeDataNamesInput = document.getElementById('attendeeDataNames');

                                // Arrays to store values separately
                                let attendeeValues = [];
                                let attendeeDataNames = [];

                                addAttendeeBtn.addEventListener('click', function () {
                                    const selectedOption = attendeeSelect.options[attendeeSelect.selectedIndex];

                                    if (selectedOption.value && !attendeeValues.includes(selectedOption.value)) {
                                        // Add to both arrays
                                        attendeeValues.push(selectedOption.value);
                                        attendeeDataNames.push(selectedOption.getAttribute('data-name') || '');

                                        updateSelectedAttendeesDisplay();
                                    }
                                });

                                function updateSelectedAttendeesDisplay() {
                                    if (attendeeValues.length === 0) {
                                        selectedAttendeesContainer.innerHTML = 'No attendees selected yet';
                                        attendeeValuesInput.value = '';
                                        attendeeDataNamesInput.value = '';
                                        return;
                                    }

                                    selectedAttendeesContainer.innerHTML = '';

                                    // Store as comma-separated strings in hidden inputs
                                    attendeeValuesInput.value = attendeeValues.join(';');
                                    attendeeDataNamesInput.value = attendeeDataNames.join(';');

                                    attendeeValues.forEach((value, index) => {
                                        const attendeeElement = document.createElement('div');
                                        attendeeElement.className = 'selected-item';

                                        // Display both values
                                        attendeeElement.innerHTML = `
                                        <span class="attendee-value">${value}</span>
                                        <span class="data-name">${attendeeDataNames[index] ? '(' + attendeeDataNames[index] + ')' : ''}</span>
                                        <span class="remove-btn" data-index="${index}">×</span>
                                    `;

                                        selectedAttendeesContainer.appendChild(attendeeElement);
                                    });

                                    // Add remove functionality
                                    document.querySelectorAll('.remove-btn').forEach(btn => {
                                        btn.addEventListener('click', function () {
                                            const index = parseInt(this.getAttribute('data-index'));
                                            attendeeValues.splice(index, 1);
                                            attendeeDataNames.splice(index, 1);
                                            updateSelectedAttendeesDisplay();
                                        });
                                    });
                                }

                                // Initialize display
                                updateSelectedAttendeesDisplay();
                            });
                        </script>





                        <!-- 
                        <div id="other_task_div"></div> -->


                        <div class="form-row">
                            <div class="col-md-3"> <label for="validationTooltip02" class="h5">Minute Taken By</label>
                            </div>
                            <div class="col-md-9 mb-3">

                                <input class="form-control" id="validationTooltip02" type="text"
                                    placeholder="Minute Taken By" name="mntk" required />
                                <div class="invalid-tooltip">
                                    Please fill in this field

                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-3"> <label for="validationTooltip02" class="h5">Apologies</label></div>
                            <div class="col-md-9 mb-3">

                                <input class="form-control" id="validationTooltip02" type="text" placeholder="Apologies"
                                    name="apol" required />
                                <div class="invalid-tooltip">
                                    Please fill in this field

                                </div>
                            </div>
                        </div>
                        <br>






                        <?php

                        $mmp = mysqli_query($con, "SELECT * FROM `tbl_meetingq`");
                        foreach ($mmp as $datam) {


                            ?>
                            <br>

                            <div class="form-row mt-3">
                                <div class="col-md-3"> <label for="validationTooltip02"
                                        class="h5"><?php echo $datam['question']; ?></label></div>
                                <div class="col-md-9 mb-3">

                                    <textarea   name="ds<?php echo $datam['id']; ?>" class="form-control"
                                        placeholder="Discussion Summary" required></textarea>
                                    <div class="invalid-tooltip">
                                        Please fill in this field

                                    </div>
                                </div>
                                <div class="col-md-3"> </div>
                                <div class="col-md-9 mb-3">

                                    <input type="text" name="ar<?php echo $datam['id']; ?>" class="form-control"
                                        placeholder="Action Required">
                                    <div class="invalid-tooltip">
                                        Please fill in this field

                                    </div>
                                </div>
                                <div class="col-md-3"> </div>
                                <div class="col-md-9 mb-3">

                                    <input type="text" name="ts<?php echo $datam['id']; ?>" class="form-control"
                                        placeholder="Time scale">
                                    <div class="invalid-tooltip">
                                        Please fill in this field

                                    </div>
                                </div>
                                <div class="col-md-3"> </div>
                                <div class="col-md-9 mb-3">

                                    <input type="text" name="res<?php echo $datam['id']; ?>" class="form-control"
                                        placeholder="Responsible">
                                    <div class="invalid-tooltip">
                                        Please fill in this field

                                    </div>
                                </div>
                                <?php

                                if ($datam['file'] == 'yes') {
                                    ?>
                                    <div class="col-md-3"> </div>
                                    <div class="col-md-9 mb-3">

                                        <input type="file" name="img<?php echo $datam['id']; ?>[]" class="form-control"
                                            accept=".jpg,.jpeg,.png,.pdf" required multiple>
                                        <div class="invalid-tooltip">
                                            Please fill in this field

                                        </div>
                                    </div>

                                    <?php
                                }
                                ?>


                            </div>


                            <?php

                        } ?>

                        <div class="col-md-1 col-sm-2"><input type="submit" name="submit" class="btn btn-primary "
                                placeholder="Responsible"></div>
                        <div class="col-md-9 mb-3">
                        </div>











                    </form>
                </div>
            </div>
        </div>


    </div>


    <?php
    if (isset($_POST['submit'])) {
        $mtdt = $_POST['mtdt'];
        if (isset($_POST['name'])) {
            $name = $_POST['name'];
            $ename = implode(';', $name);
        } else {
            $ename = '';
        }


        if (isset($_POST['desig'])) {
            $desig = $_POST['desig'];
            $edesig = implode(';', $desig);
        } else {
            $edesig = '';
        }


        $sname = $_POST['attendee_values'];
        $sdesig = $_POST['attendee_data'];

        if (!empty($ename)&& !empty($sname)) {
            $meetname = $sname . ';' . $ename;
        } 
         elseif (!empty($ename)&& empty($sname)) {
            $meetname =  $ename;
        } 
       
        else {
            $meetname = $sname;
        }

        if (!empty($edesig) && !empty($sdesig)) {
            $meetdesig = $sdesig . ';' . $edesig;
        }
         elseif (!empty($edesig)&& empty($sdesig)) {
            $meetdesig =  $edesig;
        }  else {
            $meetdesig = $sdesig;
        }

        $mntk = $_POST['mntk'];
        $apol = $_POST['apol'];


        $q = "SELECT * FROM `tbl_meeting`";
        $q1 = mysqli_query($con, $q);
        $qn1 = mysqli_num_rows($q1);
        $qn2 = $qn1 + 1;
        $mdq = date('Y-m', strtotime($mtdt));
        $mts = $_POST['mts'];
        $mte = $_POST['mtend'];
        $mloc = $_POST['mloc'];
        $meetcode = "Meet" . $qn2 . "_" . $mdq;
        $moncov = $_POST['mtmn'];



        // service suplier
        $qds = mysqli_query($con, "SELECT * FROM `tbl_meetingq`");
        foreach ($qds as $qdata) {

            $discuss = $_POST['ds'.$qdata['id']];
            $actr = $_POST['ar'.$qdata['id']];
            $tis = $_POST['ts'.$qdata['id']];
            $res = $_POST['res'.$qdata['id']];
            $quesi = $qdata['question'];
         

            if ($qdata['file'] == 'yes') {

                $nonc = '';
                if (isset($_FILES['img'.$qdata['id']]['name']) && !empty($_FILES['img'.$qdata['id']]['name'])) {

                    $non = $_FILES['img'.$qdata['id']]['name'];
                    foreach ($non as $key => $value) {
                        $filename = $_FILES['img'.$qdata['id']]['name'][$key];

                        // Move the uploaded image to a folder
    
                        if (move_uploaded_file($_FILES['img'.$qdata['id']]['tmp_name'][$key], "mrm/" . $filename)) {
                            if (empty($nonc)) {
                                $nonc .= $filename;
                            } else {
                                $nonc .= ';' . $filename;
                            }
                        }
                    }
                } else {
                    $nonc = "";
                }
               
                
                $qsda = mysqli_query($con, "INSERT INTO `tbl_meeting1`(`meetcode`, `discuss`, `action`, `response`, `scale`, `question`,`file`) 
                VALUES ('$meetcode','$discuss','$actr','$res','$tis',' $quesi','$nonc')");
            }else{
                $qsda = mysqli_query($con, "INSERT INTO `tbl_meeting1`(`meetcode`, `discuss`, `action`, `response`, `scale`, `question`) 
                VALUES ('$meetcode','$discuss','$actr','$res','$tis',' $quesi')");


            }





        }

        $qm = "INSERT INTO `tbl_meeting`(`mcover`, `mdate`, `meetstart`, `meetend`, `meetlocation`, `attend`, `desig`, `mntk`, `Apologies`,`mcode`) 
        VALUES ('$moncov','$mtdt','$mts','$mte','$mloc','$meetname','$meetdesig','$mntk','$apol','$meetcode')";
       




        $result = mysqli_query($con, $qm);
        if ($result) {
            echo "<script> 
              document.location.href='admin.php?id=monthly_review';
             </script>";
        } else {
            echo "Error posting data: " . mysqli_error($conn);
        }




        //Insert into database
    }
    ?>