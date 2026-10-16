<?php
$tid = $_GET['tid'];

?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>Weekly Scale Calibration </li>
        </ul>
    </div>
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <a href="admin.php?id=1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                    <a href="admin.php?id=scaleadd&tid=<?php echo $tid;?>"><button class="btn btn-danger" style="float:right">Add New</button></a>
                    <h4 class="card-title mb-3">Scale Calibration</h4>

                    <!-- <p>List of Dispatch</p> -->

                    <div class="table-responsive mt-5">
                        <table class="display table table-striped table-bordered text-center" id="zero_configuration_table" style="width:100%">
                            <thead>

                                <!-- <tr>
                                    <th colspan="11" style="color: red; text-align:center;">Chilled meat and meat prep +4°C; Raw meat & meat prep +4°C
                                        Frozen food -15°C; Frozen raw meat & meat prep -18°C </th>
                                </tr> -->

                                <tr>
                                    <th scope="col" rowspan="2"  class="pb-2" >#</th>
                                    <th scope="col" rowspan="2"  class="pb-2">Date</th>
                                    <th scope="col" colspan="5" class="">View</th>
                               
                                </tr>
                                

                            </thead>
                            <tbody>
                                <?php
                                $sql = mysqli_query($con, "SELECT distinct date FROM `tblscalee` where pid ='$tid' ORDER BY date DESC");
                                $i = 0;
                                while ($row = mysqli_fetch_array($sql)) {
                                    $i++;

                                    // Explode the comma-separated values back into arrays
                                   
                                ?>
                                    <tr>
                                        <td ><?php echo $i; ?></td>
                                        <td ><?php echo date('d-m-Y',strtotime($row['date'])); ?></td>
                                        <td ><a href="admin.php?id=scale1&dt=<?php echo $row['date']; ?>&tid=<?php echo $tid; ?>" class="btn btn-info">View</a></td>
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