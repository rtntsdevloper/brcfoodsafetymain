<?php
include 'connection.php';

$pid=$_GET['tid'];

?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"></h1>
        <ul>
            <li><a href="admin.php?id=1">Home</a></li>
            <li>Daily Weight Check</li>
        </ul>
    </div>
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="card-title mb-0 pl-3">Daily Weight Check</h4>
    <div class="p-3">
        <a href="admin.php?id=weightform&tid=<?php echo $pid; ?>"><button class="btn btn-danger" style="margin-right:10px;">Add New</button></a>
        <a href="admin.php?id=1" class="btn btn-success mr-2" style="float: right;">Back</a>
        
    </div>
</div>

<table class="table table-bordered" id="zero_configuration_table">
    <thead>
        <tr>
            <th>#</th>
            <th>Date</th>
            <th>Operator Name</th>
            <th>Serial No.</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $dateQuery = mysqli_query($con, "SELECT*  FROM tblweight1 where pid ='$pid' ORDER BY date DESC");
        $i = 1;

        while ($daterow = mysqli_fetch_assoc($dateQuery)) {
            $formattedDate = date("d/m/Y", strtotime($daterow['date']));
            echo '
            
            
            <tr>
            <td>' . $i++ . '</td>

            
                <td>' . $formattedDate .'</td>
                 <td>' . $daterow['name'] .'</td>
                  <td>' .$daterow['serial'].'</td>
                <td>
                    <a href="admin.php?id=weight&eid='.$daterow['id'].'&date='.$formattedDate.'" class="btn btn-sm btn-primary">
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