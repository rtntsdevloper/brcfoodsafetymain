<?php
$date = $_GET['date'];
$aid = $_GET['aid'];
?>
<div class="main-content">
    <div class="breadcrumb">

        <ul>
            <li><a href="admin.php?id=1">Home</a></li>
            <li>Add corrective Actions</li>
        </ul>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=internal&aid=<?php echo $aid;  ?>&date=<?php echo $date;  ?>"><button class="btn btn-success"
                        style="float:right; margin-left:15px">Go
                        Back</button></a>

                <div class="card-title">Add Corrective Action</div>

                <form class="needs-validation" novalidate="novalidate" method="post" action=""
                    enctype="multipart/form-data">

                    <table border="3" cellpadding="5" width="100%" style="text-align: center; font-weight:bold;">
                        <tr>
                            <td rowspan="3">Tolerance=</td>
                            <td>100g</td>
                            <td>± 0.0 g</td>
                        </tr>
                        <tr>
                            <td>1kg</td>
                            <td>± 0.10 Kg</td>
                        </tr>
                        <tr>

                            <td>5kg</td>
                            <td>± 0.20 Kg</td>

                        </tr>
                    </table>

                    <div class="form-row mt-5">
                        <div class="col-md-12">
                            <label for="validationTooltip01">Corrective Actions</label>
                            <textarea type="text" name="corrective" class="form-control" required></textarea>
                        </div>
                    </div>

                    <button class="btn btn-primary mt-2" type="submit" name="submit">Submit </button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php

if (isset($_POST['submit'])) {
    $range = $_GET['range'];
    $corrective = $_POST['corrective'];

    
if ($range == 'first') {
    // Update only 1–15 days of the month
    $sq = "UPDATE tblscales1 
           SET corrective = '$corrective' 
           WHERE area='$aid' 
             AND DATE_FORMAT(date, '%Y-%m')='$date' 
             AND DAY(date) BETWEEN 1 AND 15";
} elseif ($range == 'second') {
    // Update only 16–end of the month
    $sq = "UPDATE tblscales1 
           SET corrective = '$corrective' 
           WHERE area='$aid' 
             AND DATE_FORMAT(date, '%Y-%m')='$date' 
             AND DAY(date) > 15";
} else {
    // Update full month fallback
    $sq = "UPDATE tblscales1 
           SET corrective = '$corrective' 
           WHERE area='$aid' 
             AND DATE_FORMAT(date, '%Y-%m')='$date'";
}

$result = mysqli_query($con, $sq);
    if ($result) {
?>
        <script language="javascript">
            alert('added');
            window.open('admin?id=internal&date=<?php echo $date; ?>&aid=<?php echo $aid; ?>&range=<?php echo $range ?>', '_self');
        </script>
<?php
    }
}


?>