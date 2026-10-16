<?php
include 'connection.php';
if (isset($_POST['d1']) && !empty($_POST['d1'])) {
    $cdate = $_POST['d1'];
} else {
    $cdate = date('Y-m-d');
}


?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="probdate.php">Home</a></li>
        </ul>
    </div>
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 style="float: left;">Dough Weight Check Sheet</h3>

                            <a href="admin.php?id=goods1&id2=tracesounas"><button class="btn btn-success float-right mt-3 mr-2 ml-1">Back</button></a>
                            <!-- <a href="admin.php?"><button class="btn btn-danger float-right mt-3 mr-1 ml-1">Verify</button></a> -->
                            <a href="admin.php?id=doughpdf&date=<?php echo $cdate; ?>" class="btn btn-warning mt-3 mb-3 float-right">
                                View Report
                            </a>
                            <a href="admin.php?id=adddough"><button class="btn btn-danger float-right mt-3 mr-2 ml-1">Add New</button></a>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <form name="form1" method="post" action="admin?id=dough">
                                <div class="row">


                                    <div class="col-4" style="margin:10px">
                                        <label for="cc-exp" class="control-label mb-1" id="sd1">Select Date</label>
                                        <div class="input-group">

                                            <input type="date" name="d1" id="d1" class="form-control" value="<?php echo $cdate; ?>" required />
                                        </div>
                                    </div>



                                    <div class="col-2" style="margin:10px">
                                        <label for="cc-exp" class="control-label mb-1"></label>
                                        <div class="input-group">
                                            <button type="submit" class="btn btn-info" style="float:right">
                                                <li class="fa fa-list"></li> Select & Go
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </form>
                            </br></br>
                        </div>
                    </div>
                    <!-- Table (Same Design as prob.php) -->
                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered text-center" id="zero_configuration_table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Product Name</th>
                                    <th>Product Code</th>
                                    <th>Time</th>
                                    <th>Dough Weight</th>
                                    <th>Average Weight</th>
                                    <th>Add By</th>
                                    <th>Add detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = mysqli_query($con, "SELECT * FROM tbldough WHERE date ='$cdate' ORDER BY id DESC");

                                $i = 0;
                                while ($row = mysqli_fetch_assoc($query)) {
                                    $i++;
                                    $sd2 = mysqli_query($con, "SELECT * FROM tblmarination WHERE batchcode='$row[product]'");
                                    $sd3 = mysqli_fetch_array($sd2);

                                    $sd = mysqli_query($con, "SELECT * FROM tblrecipe WHERE id='$sd3[name]'");
                                    $sd1 = mysqli_fetch_array($sd);

                                    // Collect dough weights
                                    $w1 = $row['dough'];
                                    $w2 = $row['dough2'];
                                    $w3 = $row['dough3'];
                                    $w4 = $row['dough4'];
                                    $w5 = $row['dough5'];

                                    // Put them in an array
                                    $weights = [$w1, $w2, $w3, $w4, $w5];

                                    // Filter out empty values
                                    $validWeights = array_filter($weights, function ($v) {
                                        return $v !== null && $v !== '';
                                    });

                                    // Calculate average
                                    $average = count($validWeights) > 0 ? round(array_sum($validWeights) / count($validWeights), 2) : "-";
                                ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
                                        <td><?php echo $sd1['name']; ?></td>
                                        <td><?php echo $row['product']; ?></td>
                                        <td><?php echo date('H:i a',strtotime($row['time'])); ?></td>
                                        <td>
                                            Dough weight1 : <?php echo $row['dough']; ?> g <br>
                                            Dough weight2 : <?php echo $row['dough2']; ?> g <br>
                                            Dough weight3 : <?php echo $row['dough3']; ?> g <br>
                                            Dough weight4 : <?php echo $row['dough4']; ?> g <br>
                                            Dough weight5 : <?php echo $row['dough5']; ?> g <br>
                                        </td>
                                        <td><strong><?php echo $average; ?> g </strong></td>
                                        <td><?php echo $row['addby']; ?></td>
                                        <td><a href="admin.php?id=dough1&sid=<?php echo $row['id']; ?>" class="btn btn-primary">add details</a></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
</div>