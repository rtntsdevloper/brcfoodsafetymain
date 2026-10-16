<?php
include 'connection.php';
$pid = $_GET['tid'];
?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2">Oven Temperature Log</h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>View by Date</li>
        </ul>
    </div>
    <div class="row mb-12">
        <div class="col-md-12 mb-12 ">
            <div class="card text-left p-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Oven Temperature Log</h4>
                    <div>
                        <a href="admin.php?id=ovenform&tid=<?php echo $pid;  ?>" class="btn btn-danger">Add New</a>
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
                        $dateQuery = mysqli_query($con, "SELECT DISTINCT date FROM tbloven where pid ='$pid' ORDER BY date DESC");
                        $i = 1;

                        while ($dateRow = mysqli_fetch_assoc($dateQuery)) {
                            $formattedDate = date("d/m/Y", strtotime($dateRow['date']));
                            echo '
            
            
            <tr>
            <td>' . $i++ . '</td>

            
                <td>' . $formattedDate . '</td>
                <td>
                    <a href="admin.php?id=oven&date=' . $dateRow['date'] . '&tid=' . $pid . '" class="btn btn-sm btn-primary">
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