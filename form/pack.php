<?php
$vdate=$_GET["vdate"];

if (isset($_POST['filter'])) {
    $startdate = $_POST['startdate'];
    $enddate = $_POST['enddate'];
} else {
    $startdate = date('Y-m-d', strtotime('last monday'));
    $enddate = date('Y-m-d');
}

?>

<div class="main-content">
    <div class="breadcrumb">
        <ul>
            <li><a href="admin.php?id=1">Home</a></li>
            <li>Packaging Record</li>
        </ul>
    </div>

    <!-- <div class="card text-left mb-3">
        <div class="card-body">
            <form method="post">
                <div class="row">
                    <div class="col-12">
                        <label for="cc-exp" class="control-label mb-1" id="sd1" style="color:#FF0000"></label>
                    </div>
                    <div class="col-4">
                        <label for="validationTooltip02">Select Start Date</label>
                        <input type="date" name="startdate" class="form-control" value="<?= $startdate ?>">
                        <div class="invalid-tooltip">Please fill the field.</div>
                    </div>

                    <div class="col-4">
                        <label for="validationTooltip02">Select End Date</label>
                        <input type="date" name="enddate" class="form-control" value="<?= $enddate ?>">
                        <div class="invalid-tooltip">Please fill the field.</div>
                    </div>

                    <div class="col-2" style="margin:10px">
                        <label for="cc-exp" class="control-label mb-1"></label>
                        <div class="input-group">
                            <button class="btn btn-info" style="float:right" type="submit" name="filter">
                                <li class="fa fa-list"></li> Select & Go
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div> 
    </div> -->

    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">
                    <a href="admin.php?id=zenpack1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                    <a href="admin.php?id=zenpackpdf&vdate=<?= $vdate ?>"><button class="btn btn-warning ml-3" style="float:right; margin-left:15px">View Report</button></a>
                    <!-- <a href="admin.php?id=zenpackadd"><button class="btn btn-danger" style="float:right">Add Packaging</button></a> -->

                    <h4 class="card-title mb-3">Packaging Record</h4>
                    <p>List of Record</p>

                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">S No.</th>
                                    <th scope="col">Packaging Code</th>
                                    <!-- <th scope="col">Date</th> -->
                                    <th scope="col">Raw Material Batchcode</th>
                                    <th>BB/UB Date</th>
                                    <th>GRN (Packaging Batchcode)</th>
                                    <th>Is labelling correct as per packaging?</th>
                                    <th>Updated By</th>
                                    <th>Updated On</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                <?php
                                $sql = mysqli_query($con, "SELECT * FROM `zendpackaging` WHERE sdate='$vdate' ");
                                $i = 0;
                                while ($row = mysqli_fetch_array($sql)) {
                                    $grnid = $row['grnid']; // This contains comma-separated GRN IDs like "101,105,108"
                                    $batchcode = $row['batchcode']; // This contains comma-separated batch codes
                                    
                                    // Split the comma-separated values into arrays
                                    $grn_ids = explode(',', $grnid);
                                    $batch_codes = explode(',', $batchcode);
                                    
                                    // Get all GRN details
                                    $grn_details = [];
                                    foreach($grn_ids as $index => $gid) {
                                        $gid = trim($gid);
                                        if(!empty($gid)) {
                                            $grn_query = mysqli_query($con, "SELECT * FROM tblgrn1 WHERE id = '$gid'");
                                            $grn_data = mysqli_fetch_array($grn_query);
                                            if($grn_data) {
                                                $batch_code_display = isset($batch_codes[$index]) ? trim($batch_codes[$index]) : $grn_data['batchcode'];
                                                 $grn_details[] = '• ' . $grn_data['grn'].'('.$grn_data['batchcode'].')' ;
                                                //  . '(' . $batch_code_display . ')'
                                            }
                                        }
                                    }
                                    
                                    // Join all GRN details with line break or comma
                                    $grn_display = implode('<br>', $grn_details);
                                    
                                    $i++;
                                ?>

                                    <tr>
                                        <th scope="row"><?php echo $i; ?></th>
                                        <td><?php echo $row['pbatch']; ?></td>
                                        <!-- <td><?php echo date('d-m-Y', strtotime($row['sdate'])); ?></td> -->
                                        <td><?php echo $row['batchcode']; ?></td>
                                        <td><?php echo date('d-m-Y', strtotime($row['bbdate'])); ?></td>
                                        <td><?php echo $grn_display; ?></td>
                                        <td><?php echo $row['label']; ?></td>
                                        <td><?php echo $row['user']; ?></td>
                                        <td><?php echo date('d-m-Y h:i:s', strtotime($row['adddate'])); ?></td>
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