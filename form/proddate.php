<?php 
// Add database connection if not already present
// include 'db_connection.php'; // Uncomment and adjust as needed
?>

<div class="main-content">
    <div class="breadcrumb">
        
        <ul>
            <li><a href="admin.php?id=1">Home</a></li>
            <li>Production Record</li>
        </ul>
    </div>
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <a href="admin.php?id=zendrecord&pid=1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                    <a href="admin.php?id=zenprodadd"><button class="btn btn-danger" style="float:right">Add Production </button></a>

                    <h4 class="card-title mb-3">Production Record</h4>

                    <p>List of Record</p>

                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Date</th>
                                    <th>View</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                <?php
                                // Modified query to get distinct pdate values
                                $sql = mysqli_query($con, "SELECT DISTINCT `pdate` FROM `zendproduction` ORDER BY `pdate` DESC");
                                $i = 0;
                                while ($row = mysqli_fetch_array($sql)) {
                                    $i++;
                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $i; ?></th>
                                        <td><?php echo date('d-m-Y', strtotime($row['pdate'])); ?></td>
                                        <td><a href="admin.php?id=zenprod&date=<?php echo $row['pdate']; ?>"><button class="btn btn-primary">View</button></a></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>