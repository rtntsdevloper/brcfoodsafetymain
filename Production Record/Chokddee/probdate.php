<?php
include 'connection.php';
$tid = $_GET['tid'];
?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2">Weekly Probe Calibration</h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>Weekly Probe Calibration</li>
        </ul>
    </div>
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0"></h4>
                    <div class="pt-3">
                        <a href="admin.php?id=probadd&tid=<?php echo $tid;?>" class="btn btn-danger">Add New</a>
                        <a href="admin.php?id=1" class="btn btn-success mr-2">Back</a>

                    </div>
                </div>

                <table class="table table-bordered" id="zero_configuration_table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $dateQuery = mysqli_query($con, "SELECT DISTINCT date FROM tblprob where pid ='$tid' ORDER BY date DESC");
                        $i = 1;

                        while ($dateRow = mysqli_fetch_assoc($dateQuery)) {
                            $formattedDate = date("d/m/Y", strtotime($dateRow['date']));
                            echo '
            
            
            <tr>
            <td>' . $i++ . '</td>

            
                <td>' . $formattedDate . '</td>
                <td>
                    <a href="admin.php?id=prob&date=' . $dateRow['date'] . '&tid='.$tid.'" class="btn btn-sm btn-primary">
                        View
                    </a>
                </td>
            </tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>