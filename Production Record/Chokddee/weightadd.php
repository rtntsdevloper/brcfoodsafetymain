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
                <a href="admin.php?id=weightdate"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

               <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data" action="">
   
       
        <div class="col-md-6 mb-1">
            <label for="opname">Operator Name</label>
            <input class="form-control" id="opname" type="text"  name="opname" required />
            <div class="invalid-tooltip">
                Please provide operator name.
            </div>
        </div>
        
        <div class="col-md-6 mb-1">
            <label for="date">Date</label>
            <input class="form-control" id="date" type="date" name="date"   required />
            <div class="invalid-tooltip">
                Please provide a valid date.
            </div>
        </div>

        <div class="col-md-6 mb-1">
            <label for="serial">Scale Serial Number</label>
            <input class="form-control" id="serial" type="text" name="serial" required  />
            <div class="invalid-tooltip">
                Please provide serial number.
            </div>
        </div>

    <br>
    
    <button class="btn btn-primary" type="submit" name="submit" id="submitBtn" >Submit</button>
</form>

</div>

<?php
if(isset($_POST['submit'])) {
    // Basic input sanitization
    $opname = $_POST['opname'];
    $date = $_POST['date'];
    $time = $_POST['serial'];
   
  

    $result = mysqli_query($con, "INSERT INTO `tblweight1`(`name`, `serial`, `date`,pid) VALUES ('$opname','$time','$date','$pid')");
               

    if ($result) {
       
        echo '<script>window.location.href = "admin.php?id=weightdate&tid='.$pid.'";</script>';
    }
}
?>