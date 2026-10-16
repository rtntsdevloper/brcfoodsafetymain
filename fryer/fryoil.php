<?php
include 'connection.php';

$fdate = $_GET['date'];
$formattedDate = date("d/m/Y", strtotime($fdate));
?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2">Oil Change Record for <?php echo $formattedDate; ?></h1>

    </div>
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body ">
                    <a href="admin.php?id=fryeroil"><button class="btn btn-success float-right mt-3 mr-2 ml-1">Back</button></a>
                    <a href="admin.php?id=fryeroilpdf&date=<?php echo $fdate; ?>" class="btn btn-warning mt-3 mb-3 float-right">
                        View
                    </a>

                    <!-- Table (Same Design as prob.php) -->
                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered text-center" id="zero_configuration_table" style="width:100%">
                            <thead>

                                <tr>  <th>Day</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Has Oil been changed (Yes/No)</th>
                                    <th>Comment</th>
                                    <th>Signature</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = mysqli_query($con, "SELECT * FROM tblfryoil WHERE date='$fdate'");
                                $i = 0;
                                while ($row = mysqli_fetch_assoc($query)) {
                                    $i++;
                                   ?>
                                   <tr>
                                    <td><?php echo date("D", strtotime($row['date']));?></td>
                                   <td><?php echo date("d-m-Y", strtotime($row['date']));?></td>
                                   <td><?php echo $row['name'] ;?></td>
                                   <td><?php echo $row['ques'] ;?></td>
                                   <td><?php echo $row['cmnt'] ;?></td>
                                   <td><img src="precord/sign/<?php echo $row['sign'] ;?>" alt="" width="100" /></td>
                                   
                                </tr>
                                   <?php
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