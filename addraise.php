<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Machinery Management</a></li>
            <li>Raised</li>
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=ppmraise">
                    <button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button>
                </a>

                <div class="card-title">Add Machinery</div>

                <form class="needs-validation" novalidate="novalidate" method="post" action="" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip01">Date</label>
                            <input class="form-control" id="validationTooltip01" type="date" required="required" name="date" />
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="validationTooltipRaised">Raised By</label>
                            <input class="form-control" id="validationTooltipRaised" type="text" placeholder="enter name" required="required" name="raised" />
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip02">Production Area</label>
                            <input class="form-control" id="validationTooltip02" type="text" placeholder="enter production area" required="required" name="area" />
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Equipment Name</label>
                            <select name="eqptname" class="form-control" id="eqptname" onchange="autoFill()" required>
                                <option value="">Please Select</option>
                                <?php
                                $eqpt = mysqli_query($con, "SELECT * FROM `tblequipment`");
                                while ($eqname = mysqli_fetch_assoc($eqpt)) {
                                ?>
                                    <option value="<?php echo $eqname['id']; ?>"
                                        data-code="<?php echo htmlspecialchars($eqname['code']); ?>"
                                        data-location="<?php echo htmlspecialchars($eqname['location']); ?>">
                                        <?php echo htmlspecialchars($eqname['name']); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Equipment ID</label>
                            <input class="form-control" id="eqcode" type="text" required name="eqcode" readonly />
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Equipment Location</label>
                            <input class="form-control" id="location" type="text" required name="location" readonly />
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Description of Fault</label>
                            <input class="form-control" type="text" required name="fault" />
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Priority Level</label>
                            <select name="priority" class="form-control" required>
                                <option value="">Please Select</option>
                                <option value="Critical">Critical</option>
                                <option value="High">High</option>
                                <option value="Medium">Medium</option>
                                <option value="Low">Low</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Date & Time Issue Identified</label>
                            <input class="form-control" type="datetime-local" required name="issuedate" />
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Equipment Status</label>
                            <select name="eqpstatus" class="form-control" required>
                                <option value="">Please Select</option>
                                <option value="Partially Functional">Partially Functional</option>
                                <option value="Stopped / Breakdown">Stopped / Breakdown</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip01">Target Completion Date</label>
                            <input class="form-control" id="validationTooltip01" type="date" required="required" name="targetdate" />
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Maintenance Team Assigned</label>
                            <input class="form-control" type="text" required name="mteam" />
                        </div>

                        <div class="col-md-4 mb-3">
                            <label> Supporting Documents (If any) - Upload Attachments</label>
                            <input class="form-control" type="file" name="document" accept=".jpg,.jpeg,.png" />
                        </div>

                        <div class="col-md-12">
                            <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function autoFill() {
        var select = document.getElementById('eqptname');
        var selectedOption = select.options[select.selectedIndex];

        var code = selectedOption.getAttribute('data-code') || '';
        var location = selectedOption.getAttribute('data-location') || '';

        document.getElementById('eqcode').value = code;
        document.getElementById('location').value = location;
    }

    document.addEventListener('DOMContentLoaded', function() {
        autoFill();
    });
</script>

<?php
include_once('connection.php');

if (isset($_POST['submit'])) {

    $date       = $_POST['date'];
    $raised     = $_POST['raised'];
    $area       = $_POST['area'];
    $eqptname   = $_POST['eqptname'];
    $eqcode     = $_POST['eqcode'];
    $location   = $_POST['location'];
    $fault      = $_POST['fault'];
    $priority   = $_POST['priority'];
    $issuedate  = $_POST['issuedate'];
    $eqpstatus  = $_POST['eqpstatus'];
    $targetdate = $_POST['targetdate'];
    $mteam      = $_POST['mteam'];

    $mnth = date('m', strtotime($date));

    $document = '';
    if (!empty($_FILES['document']['name'])) {
        $upl1 = 'upl1/';
        $uniqueName = uniqid() . '_' . basename($_FILES['document']['name']);
        $uploadFile = $upl1 . $uniqueName;
        move_uploaded_file($_FILES['document']['tmp_name'], $uploadFile);
        $document = $uniqueName;
    }

    $insert = mysqli_query($con, "INSERT INTO ppmraise 
        (`date`, `raisedby`, `area`, `eqpname`, `equipmentcode`, `location`, 
         `fault`, `priority`, `issuedate`, `eqpstatus`, `targetdate`, `mteam`, `document`) 
        VALUES ('$date', '$raised', '$area', '$eqptname', '$eqcode', '$location',
                '$fault', '$priority', '$issuedate', '$eqpstatus', '$targetdate', '$mteam', '$document')");

    if ($insert) {
        $last_id = mysqli_insert_id($con);

        $reqno = str_pad($last_id, 4, "0", STR_PAD_LEFT);

        $request = "PPM" . date('dmy') . $reqno;

        $update = mysqli_query($con, "UPDATE ppmraise SET request='$request' WHERE id='$last_id'");

        // echo "INSERT INTO tblequipment1 (eid, date, month, request,rid) VALUES ('$eqptname', '$targetdate', '$mnth','Yes','$last_id'";die;
        $update1 = mysqli_query($con, "INSERT INTO tblequipment1 (eid, date, month, request,rid) VALUES ('$eqptname', '$date', '$mnth','Yes','$last_id')");

        echo "<script>window.location='admin.php?id=ppmraise';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
    }
}
?>