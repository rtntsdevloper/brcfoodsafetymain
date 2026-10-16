<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Machinery Management</a></li>
            <li>Add Machinery</li>
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=ppmmgmt">
                    <button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button>
                </a>

                <div class="card-title">Add Machinery</div>

                <form class="needs-validation" novalidate="novalidate" method="post" action="" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip01">Equipment Name</label>
                            <input class="form-control" id="validationTooltip01" type="text" placeholder="Equipment name" required="required" name="name" />
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip02">Manufacturer</label>
                            <input class="form-control" id="validationTooltip02" type="text" placeholder="Manufacturer" required="required" name="make" />

                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip02">Model Number</label>
                            <input class="form-control" id="validationTooltip02" type="text" placeholder="Model Number" required="required" name="model" />

                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip02">Equipment Code</label>
                            <input class="form-control" id="validationTooltip02" type="text" placeholder="Equipment Code" required="required" name="code" />

                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip02">Site</label>
                            <input name="site" type="text" class="form-control" id="validationTooltip03" placeholder="Site" required="required" />

                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip03">Location</label>
                            <input class="form-control" id="validationTooltip04" type="text" placeholder="Location" required="required" name="location" />

                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip03">Is PPM applicable on this equipment?</label>
                            <select name="isppm" id="isppm" class="form-control">
                                <option value="">Select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>

                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip03">Is calibration applicable on this equipment?</label>
                            <select name="iscalib" id="iscalib" class="form-control">
                                <option value="">Select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>

                        </div>
                    </div>

                    <script>
                        $(document).ready(function() {
                            $('#isppm').change(function() {
                                if ($(this).val() == 'Yes') {
                                    $('#ppmd').removeClass('d-none');
                                    $('#eqserv').attr('required', 'required');
                                    $('#servsup').attr('required', 'required');
                                    $('#maintain').attr('required', 'required');
                                    $('#frequency').attr('required', 'required');
                                    $('#resperson').attr('required', 'required');
                                } else {
                                    $('#ppmd').addClass('d-none');
                                    $('#eqserv').removeAttr('required');
                                    $('#servsup').removeAttr('required');
                                    $('#maintain').removeAttr('required');
                                    $('#frequency').removeAttr('required');
                                    $('#resperson').removeAttr('required');
                                }
                            });

                            // Auto-set maintenance date based on frequency
                            $('#frequency').change(function() {
                                var freq = $(this).val();
                                var today = new Date();
                                var newDate = new Date(today);
                                
                                if (freq == 'Weekly') {
                                    newDate.setDate(today.getDate() + 7);
                                } else if (freq == 'Monthly') {
                                    newDate.setMonth(today.getMonth() + 1);
                                } else if (freq == 'Quarterly') {
                                    newDate.setMonth(today.getMonth() + 3);
                                } else if (freq == 'Six Monthly') {
                                    newDate.setMonth(today.getMonth() + 6);
                                } else if (freq == 'Annually') {
                                    newDate.setFullYear(today.getFullYear() + 1);
                                } else {
                                    $('#maintain').val('');
                                    return;
                                }
                                
                                var year = newDate.getFullYear();
                                var month = String(newDate.getMonth() + 1).padStart(2, '0');
                                var day = String(newDate.getDate()).padStart(2, '0');
                                $('#maintain').val(year + '-' + month + '-' + day);
                            });
                        });
                    </script>

                    <div class="form-row d-none" id="ppmd">
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip03">Frequency</label>
                            <select name="frequency" id="frequency" class="form-control">
                                <option value="">Select</option>
                                <option value="Weekly">Weekly</option>
                                <option value="Monthly">Monthly</option>
                                <option value="Quarterly">Quarterly</option>
                                <option value="Six Monthly">Six Monthly</option>
                                <option value="Annually">Annually</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip03">Is equipment being serviced Internally or Externally?</label>
                            <select class="form-control" id="eqserv" name="service">
                                <option value="">Please Select</option>
                                <option value="IN">IN</option>
                                <option value="EX">EX</option>
                                <option value="IN/EX">IN/EX</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip03">Service Supplier</label>
                            <input class="form-control" id="servsup" type="text" placeholder="Location" name="sname" />
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip03">Maintenance Date</label>
                            <input class="form-control" id="maintain" type="date" placeholder="Frequency" name="maintenance" />
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip03">Responsible Person</label>
                            <input class="form-control" id="resperson" type="text" placeholder="Location" name="rperson" />
                        </div>
                    </div>

                    <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $code = $_POST['code'];
    $make = $_POST['make'];
    $site = $_POST['site'];
    $location = $_POST['location'];
    $frequency = $_POST['frequency'];
    $service = $_POST['service'];
    $sname = $_POST['sname'];
    $maintenance = $_POST['maintenance'];
    $ppmap = $_POST['isppm'];
    $calbap = $_POST['iscalib'];
    $model = $_POST['model'];
    $rperson = $_POST['rperson'];
    $mnth = date('m', strtotime($maintenance));
    $lastupdated = date('d-m-Y H:i:s');
    
    if (isset($_FILES['calfile'])) {
        $file = $_FILES['calfile'];
        $filename = $file['name'];
        $filename1 = "calb" . date('dmyhis') . $filename;
        $filetmp = $file['tmp_name'];
        move_uploaded_file($filetmp, "uploads/" . $filename1);
    }

    $sql = mysqli_query($con, "INSERT INTO tblequipment (name,make,code,site,location,service,sname,frequency,ppmap,calbap,lastupdated,model,rperson) VALUES ('$name', '$make', '$code', '$site', '$location', '$service', '$sname', '$frequency', '$ppmap', '$calbap', '$lastupdated','$model','$rperson')");

    $sno = mysqli_insert_id($con);
    if ($ppmap == "Yes") {
        $sql2 = mysqli_query($con, "INSERT INTO tblequipment1 (eid,date,month) VALUES ('$sno', '$maintenance', '$mnth')");
    }

?>
    <script language="javascript">
        window.open('admin.php?id=ppmmgmt', '_self');
    </script>
<?php
}
?>