<?php
include 'connection.php';



?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"></h1>
        <ul>
            <li><a href="admin.php?id=1">Home</a></li>
            <li>Outer Packaging Check</li>
        </ul>
    </div>
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0 pl-3">Outer Packaging Check</h4>
                    <div class="p-3">
                        <a href="admin.php?id=outeradd"><button class="btn btn-danger" style="margin-right:10px;">Add New</button></a>
                        <a href="admin.php?id=1" class="btn btn-success mr-2" style="float: right;">Back</a>

                    </div>
                </div>

                <table class="table table-bordered" id="zero_configuration_table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Operator Name</th>
                            <th>Batch Numbers</th>
                            <th>View</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $dateQuery = mysqli_query($con, "SELECT*  FROM tblouter1 ORDER BY date DESC");
                        $i = 1;

                        while ($daterow = mysqli_fetch_assoc($dateQuery)) {
                            $formattedDate = date("d/m/Y", strtotime($daterow['date']));
                            echo '
            
            <tr>
            <td>' . $i++ . '</td>

                        
               
                 <td>' . date('d-m-Y', strtotime($daterow['date'])) . '</td>
                   <td>' . $daterow['name'] . '</td>
                   <td>' . $daterow['prodbatch'] . '</td>
                <td>
                    <a href="admin.php?id=outer&eid=' . $daterow['id'] . '&date=' . $formattedDate . '" class="btn btn-sm btn-primary">
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