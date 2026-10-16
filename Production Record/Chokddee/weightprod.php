<?php
include 'connection.php';
$pid=$_GET['tid'];
?>


<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>Daily Weight Check</li>
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=weight"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

               <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data" action="">
   
       
        <div class="col-md-6 mb-1">
            <label for="opname">Operator Name</label>
            <input class="form-control" id="opname" type="text" required name="opname" />
            <div class="invalid-tooltip">
                Please provide operator name.
            </div>
        </div>
        
        <div class="col-md-6 mb-1">
            <label for="date">Date</label>
            <input class="form-control" id="date" type="date" required name="date" />
            <div class="invalid-tooltip">
                Please provide a valid date.
            </div>
        </div>

        <div class="col-md-6 mb-1">
            <label for="serial">Scale Serial Number</label>
            <input class="form-control" id="serial" type="text" required name="serial" />
            <div class="invalid-tooltip">
                Please provide serial number.
            </div>
        </div>


    <!-- Additional fields (hidden by default) -->
    <div id="additionalFields" style="display: none;">
        <div class="form-row mt-5">
                <div class="col-md-6 mb-3">
                <label for="packtare">Time </label>
                <input class="form-control" id="time" type="time" required name="time" />
                <div class="invalid-tooltip">
                    Please provide pack tare weight.
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <label for="packtare">Pack Tare Weight (g)</label>
                <input class="form-control" id="packtare" type="text" required name="packtare" />
                <div class="invalid-tooltip">
                    Please provide pack tare weight.
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <label for="pack1">Pack 1 Weight</label>
                <input class="form-control" id="pack1" type="text" required name="pack1" />
                <div class="invalid-tooltip">
                    Please provide pack 1 weight.
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <label for="pack2">Pack 2 Weight</label>
                <input class="form-control" id="pack2" type="text" required name="pack2" />
                <div class="invalid-tooltip">
                    Please provide pack 2 weight.
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <label for="pack3">Pack 3 Weight</label>
                <input class="form-control" id="pack3" type="text" required name="pack3" />
                <div class="invalid-tooltip">
                    Please provide pack 3 weight.
                </div>
            </div>

            <!-- Add more weight fields as needed -->
            <div class="col-md-6 mb-3">
                <label for="pack4">Pack 4 Weight</label>
                <input class="form-control" id="pack4" type="text" required name="pack4" />
                <div class="invalid-tooltip">
                    Please provide pack 4 weight.
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <label for="pack5">Pack 5 Weight</label>
                <input class="form-control" id="pack5" type="text" required name="pack5" />
                <div class="invalid-tooltip">
                    Please provide pack 5 weight.
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <label for="declared">Declared Weight (g)</label>
                <input class="form-control" id="declared" type="text" required name="declared" />
                <div class="invalid-tooltip">
                    Please provide declared weight.
                </div>
            </div>
        </div>
    </div>

    <br>
    <button class="btn btn-primary" type="button" id="showMoreBtn">Save & Next</button>
    <button class="btn btn-primary" type="submit" name="submit" id="submitBtn" style="display: none;">Submit</button>
</form>

<script>
document.getElementById('showMoreBtn').addEventListener('click', function() {
    // Validate first 3 fields
    const opname = document.getElementById('opname').value;
    const date = document.getElementById('date').value;
    const serial = document.getElementById('serial').value;
    
    if(opname && date && serial) {
        // Show additional fields
        document.getElementById('additionalFields').style.display = 'block';
        // Hide "Save & Next" button, show "Submit All Data" button
        this.style.display = 'none';
        document.getElementById('submitBtn').style.display = 'inline-block';
        // Scroll to additional fields
        document.getElementById('additionalFields').scrollIntoView({ behavior: 'smooth' });
    } else {
       
    }
});
</script>
            </div>
        </div>
    </div>
</div>

<?php
if(isset($_POST['submit'])) {
    // Basic input sanitization
    $time = $_POST['time'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $tare = $_POST['packtare'];
    $pack1 = $_POST['pack1'];
    $pack2 = $_POST['pack2'];
    $pack3 = $_POST['pack3'];
    $pack4 = $_POST['pack4'];
    $pack5 = $_POST['pack5'];
    $pid=$pid;
    $declare = mysqli_real_escape_string($con, $_POST['declared']);
    
    // Fixed table name from tnblweight to tblweight
    $nrk = mysqli_query($con, "SELECT * FROM tblweight");
    if(!$nrk) {
        die("Error in query: " . mysqli_error($con));
    }
    $nrk1 = mysqli_num_rows($nrk);
    $nrkn = $nrk1 + 1;
    $record = "Wei00" . $nrkn;

    $result = mysqli_query($con, "INSERT INTO tblweight (date, time, packtare, pack1, pack2, pack3, pack4, pack5, `declared`, `recordid`, `pid` ) 
                VALUES('$date', '$time', '$tare', '$pack1', '$pack2', '$pack3', '$pack4', '$pack5', '$declare', '$record', '$pid')");

    if ($result) {
        echo "<script>alert('Delivery Log added successfully!');</script>";
        echo '<script>window.location.href = "admin.php?id=weightsign&rid=' . $record . '&tid='.$pid.'";</script>';
    } else {
        echo "<script>alert('Error adding Delivery Log: " . addslashes(mysqli_error($con)) . "');</script>";
    }
}
?>