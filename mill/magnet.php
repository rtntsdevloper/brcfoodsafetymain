<?php
include 'connection.php';
// $pid=$_GET['pid'];
// $tid=$_GET['tid'];
?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname;  ?></h1>
        <ul>
            <li><a href="admin.php?id=1">Home</a></li>
            <li>Millers Magnet Cleaning Record</li>
        </ul>
    </div>
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0 pl-3">Millers Magnet Cleaning Record</h4>
                    <div class="p-3">
                        <a href="admin.php?id=magnate" class="btn btn-primary mr-2">Add New</a>
                        <a href="admin.php?id=1" class="btn btn-success mr-2" style="float: right;">Back</a>

                    </div>
                </div>

                <table class="table table-bordered" id="zero_configuration_table">
                    <thead>
                        <tr style="text-align: center;">
                            <th>#</th>
                            <th>Month</th>
                            <th>View Detail</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Query distinct months from the date column
                        $sq = mysqli_query($con, "
                   SELECT DISTINCT MONTH(date) AS month_num, 
                   MONTHNAME(date) AS month_name 
           FROM tblmagnate
                ORDER BY month_num
");

                        $i = 1;
                        while ($row = mysqli_fetch_array($sq)) {
                        ?>
                            <tr style="text-align:center;">
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $row['month_name']; ?></td>
                                <td>
                                    <a href="admin.php?id=magnate1&month=<?php echo $row['month_num']; ?>"
                                        class="btn btn-success">
                                        View Detail
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>