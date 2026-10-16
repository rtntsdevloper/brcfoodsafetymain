<?php
include 'connection.php';
$selectedDate = $_GET['date'] ?? '';
$formattedDate = date("d/m/Y", strtotime($selectedDate));
$tid = $_GET['tid']
?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2">Calibration for <?php echo $formattedDate; ?></h1>
       
    </div>
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body ">
                    <a href="admin.php?id=probdate&tid=<?php echo $tid;?>"><button class="btn btn-success float-right mt-3 mr-2 ml-1">Back</button></a>
                    <a href="admin.php?id=probpdf&date=<?php echo $selectedDate; ?>&tid=<?php echo $tid; ?>" class="btn btn-warning mt-3 mb-3 float-right">
                       View 
                    </a>
                    
                    <!-- Table (Same Design as prob.php) -->
                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered text-center" id="zero_configuration_table" style="width:100%">
                            <thead>
                                <tr>
                                    <th rowspan="2">#</th>
                                    <th rowspan="2">Thermometer ID</th>
                                    <th rowspan="2">Serial No</th>
                                    <th rowspan="2">Area</th>
                                    <th colspan="2">Hot Water Check (100°C ±1°C)</th>
                                    <th colspan="2">Chill Water Check (-5°C to 0°C)</th>
                                    <th rowspan="2">Checked By</th>
                                </tr>
                                <tr>
                                    <th>Ref. Temp</th>
                                    <th>Prob Temp</th>
                                    <th>Ref. Temp</th>
                                    <th>Prob Temp</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = mysqli_query($con, "SELECT * FROM tblprob WHERE date='$selectedDate'and pid ='$tid'");
                                $i = 0;
                                while ($row = mysqli_fetch_assoc($query)) {
                                    $i++;
                                    echo "<tr>
                                        <td>$i</td>
                                        <td>{$row['tident']}</td>
                                        <td>{$row['tserial']}</td>
                                        <td>{$row['area']}</td>
                                        <td>{$row['th1']}</td>
                                        <td>{$row['th2']}</td>
                                        <td>{$row['ch1']}</td>
                                        <td>{$row['ch2']}</td>
                                        <td>{$row['checked']}</td>
                                    </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Generate PDF Button -->
                    
                </div>
            </div>
        </div>
    </div>
</div>