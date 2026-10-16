<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>Defrost Record</li>
        </ul>
    </div>
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">

               <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0"></h4>
                    <div class="pt-3">

                    <a href="admin.php?id=1"><button class="btn btn-success"
                            style="float:right; margin-left:15px">Go Back </button></a>
                
                    <a href="admin.php?id=defrost"><button class="btn btn-warning mr-3" style="float:right">Add New
                             </button></a>
             
                        
                    </div></div>

                <table class="table table-bordered table-striped" id="zero_configuration_table">
                    <thead>
                        <tr>
                            <th>S.No.</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $dateQuery = mysqli_query($con, "SELECT Distinct date FROM tbldefrost ORDER BY date DESC");
                        $i = 1;

                        while ($dateRow = mysqli_fetch_assoc($dateQuery)) {
                            $formattedDate = date("d/m/Y", strtotime($dateRow['date']));
                            echo '
            
            
            <tr>
            <td>' . $i++ . '</td>

            
                <td>' . $formattedDate . '</td>
                <td>
                    <a href="admin.php?id=defrost1&date=' . $dateRow['date'] . '" class="btn btn-sm btn-primary">
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