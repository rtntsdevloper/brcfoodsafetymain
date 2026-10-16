<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>Machinery Management </li>
        </ul>
    </div>
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <a href="admin.php?id=mcomplete"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                    <h4 class="card-title mb-3">Machinery Management</h4>

                    <!-- Filter Form -->
                    <form method="GET" action="">
                        <input type="hidden" name="id" value="mcomplete1">
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <select name="month" class="form-control">
                                    <option value="">Select Month</option>
                                    <?php
                                    $currentMonth = date("n");
                                    for ($m = 1; $m <= 12; $m++) {
                                        $monthName = date("F", mktime(0, 0, 0, $m, 1));
                                        if (!empty($_GET['month']) && $_GET['month'] == $m) {
                                            $selected = "selected";
                                        } elseif (empty($_GET['month']) && $m == $currentMonth) {
                                            $selected = "selected";
                                        } else {
                                            $selected = "";
                                        }
                                        echo "<option value='$m' $selected>$monthName</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="year" class="form-control">
                                    <option value="">Select Year</option>
                                    <?php
                                    $currentYear = date("Y");
                                    for ($y = $currentYear - 5; $y <= $currentYear; $y++) {
                                        if (!empty($_GET['year']) && $_GET['year'] == $y) {
                                            $selected = "selected";
                                        } elseif (empty($_GET['year']) && $y == $currentYear) {
                                            $selected = "selected";
                                        } else {
                                            $selected = "";
                                        }
                                        echo "<option value='$y' $selected>$y</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">S No.</th>
                                    <th scope="col">Date </th>

                                    <th scope="col">Equipment Code</th>
                                    <th scope="col">Equipment Name</th>
                                    <th scope="col">Model Number</th>
                                    <th scope="col">Manufacturer</th>
                                    <th scope="col">View</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;

                                // Default to current month/year if not selected
                                if (!empty($_GET['month'])) {
                                    $month = $_GET['month'];
                                } else {
                                    $month = date("n");
                                }

                                if (!empty($_GET['year'])) {
                                    $year = $_GET['year'];
                                } else {
                                    $year = date("Y");
                                }

                                $sql = mysqli_query($con, "
                                    SELECT t1.*, t2.code, t2.name, t2.model, t2.make 
                                    FROM tblequipment1 t1
                                    INNER JOIN tblequipment t2 ON t1.eid = t2.id
                                    WHERE t1.status1='done' 
                                      AND t1.request='' 
                                      AND t1.mverify='done'
                                      AND MONTH(t1.date)='$month' 
                                      AND YEAR(t1.date)='$year'
                                    ORDER BY t1.id DESC
                                ");

                                while ($row = mysqli_fetch_array($sql)) {
                                ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo date('d-m-Y', strtotime($row['stime'])); ?></td>

                                        <td><?php echo $row['code']; ?></td>
                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php echo $row['model']; ?></td>
                                        <td><?php echo $row['make']; ?></td>
                                        <td>
                                            <a href="admin.php?id=mcompview&sno=<?php echo $row['id']; ?>&month=<?php echo $month; ?>&year=<?php echo $year; ?>">
                                                <button class="btn btn-warning" type="button"><i class="fa fa-eye"></i></button>
                                            </a>
                                        </td>
                                    </tr>
                                <?php
                                    $i++;
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