<div class="col-md-12 mb-5">
    <div class="card">
        <div class="card-body">
            <a href="admin.php?id=recip1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

            <div class="card-title">Cleaning Checks</div>
            <form method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Date</label>
                            <input type="date" name="cdate" id="" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Time</label>
                            <input type="time" name="ctime" id="" class="form-control" required>
                        </div>
                    </div>
                </div>
                <br>
                <div id="containers-wrapper">
                    <!-- First container -->
                    <div class="container-fluid new-container mb-3" id="container-1">
                        <h6 class="text-muted">Machine #1</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Select Machine:</label>
                                    <select class="form-control machine-select" name="machine[]" required>
                                        <option value="">-- Choose Machine --</option>
                                        <?php
                                        $dailym = mysqli_query($con, "SELECT * FROM `daily_machines`");
                                        foreach ($dailym as $row) {
                                            echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
                                        }
                                        ?>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Is this machine cleaned?</label>
                                    <select class="form-control machine-select" name="cleaned[]" required>
                                        <option value="">-- Please Select --</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Comments:</label>
                                    <textarea class="form-control comment-box" rows="3" name="cmnt[]" placeholder="Enter any additional comments..."></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Upload Image:</label>
                                    <input type="file" name="imgfile[]" id="" class="form-control" accept="image/*" >
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-danger btn-sm remove-btn" onclick="removeContainer(this)">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-primary" onclick="addNewContainer()">Add Another Machine</button>
                <button class="btn btn-info" type="submit" name="submit">Submit</button>
            </form>
        </div>

    </div>
</div>

<script>
    let containerCount = 1;

    function addNewContainer() {
        containerCount++;

        const containerTemplate = `
            <div class="container-fluid new-container mb-3" id="container-${containerCount}" style="border-top: 1px solid #ddd; padding-top: 15px; margin-top: 15px;">
                <h6 class="text-muted">Machine #${containerCount}</h6>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Select Machine:</label>
                            <select class="form-control machine-select" name="machine[]" required>
                                <option value="">-- Choose Machine --</option>
                                <?php
                                $dailym = mysqli_query($con, "SELECT * FROM `daily_machines`");
                                while ($row = mysqli_fetch_assoc($dailym)) {
                                    echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
                                }

                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Is this machine cleaned?</label>
                            <select class="form-control machine-select" name="cleaned[]" required>
                                <option value="">-- Please Select --</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Comments:</label>
                            <textarea class="form-control comment-box" rows="3" name="cmnt[]" placeholder="Enter any additional comments..."></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Upload Image:</label>
                            <input type="file" name="imgfile[]" id="" class="form-control" accept="image/*">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button class="btn btn-danger btn-sm remove-btn" onclick="removeContainer(this)">Remove</button>
                    </div>
                </div>
            </div>
        `;

        const containerDiv = document.createElement('div');
        containerDiv.innerHTML = containerTemplate;

        document.getElementById('containers-wrapper').appendChild(containerDiv);
    }

    function removeContainer(button) {
        const container = button.closest('.new-container');
        if (container) {
            container.remove();
            // Optionally, you can renumber the containers here
            renumberContainers();
        }
    }

    function renumberContainers() {
        const containers = document.querySelectorAll('.new-container');
        containers.forEach((container, index) => {
            const header = container.querySelector('h6');
            if (header) {
                header.textContent = `Machine #${index + 1}`;
                container.id = `container-${index + 1}`;
            }
        });
        containerCount = containers.length;
    }
</script>
<?php
if (isset($_POST['submit'])) {
    $date = $_POST['cdate'];
    $time = $_POST['ctime'];
 $adate = date('Y-m-d H:i:s');

     $sqn = "INSERT INTO `dailymachine1`(`name`, `date`, `atime`, `user`, `stime`) VALUES ('Machine','$date','$time','$user','$adate')";
     $sq = mysqli_query($con, $sqn);
     $sqli = mysqli_insert_id($con);
  

    $machine = $_POST['machine'];
    $cleaned = $_POST['cleaned'];
    $cmnt = $_POST['cmnt'];
    $image = $_FILES['imgfile'];
    print_r($image);

foreach ($machine as $key => $value) {
    $machine1 = $value;
    $cleaned1 = $cleaned[$key];
    $cmnt1 = $cmnt[$key];
    if (isset($image['name'][$key]) && !empty($image['name'][$key])) {
        $image1 = $image['name'][$key];
        $iname = "Machine-".date('Ymdhis')."-".$image1;
        $image1_tmp = $image['tmp_name'][$key];
        $iname1 = "precord/files/".$iname;
        move_uploaded_file($image1_tmp, $iname1);

        
    }else{
        $iname = "";
    }
    $sqnn = "INSERT INTO `dailymachine2`(`name`, `checkq`, `cmnt`, `vid`, `file`) VALUES ('$machine1','$cleaned1','$cmnt1','$sqli','$iname')";
        $sqnnn = mysqli_query($con, $sqnn);
    
}

if($sqnnn && $sq){
    echo "<script>alert('Machine Added Successfully');</script>
    
    <script>window.location.href='admin.php?id=machines1';</script>";
}
   

   
}
?>