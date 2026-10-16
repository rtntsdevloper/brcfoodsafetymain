<div class="main-content">

    <div class="breadcrumb d-flex justify-content-between align-items-center">

        <div>

            <h1 class="mr-2"><?php echo $headingname; ?></h1>

            <ul>

                <li><a href="">Home</a></li>

                <li>Machinery Management</li>

            </ul>

        </div>

        <div>

            <?php

            // Preserve filter values in Go Back link

            $month = !empty($_GET['month']) ? $_GET['month'] : date("n");

            $year  = !empty($_GET['year']) ? $_GET['year'] : date("Y");

            ?>

        </div>

    </div>



    <div class="row mb-12">

        <div class="col-md-12 mb-12">

            <div class="card text-left">

                <div class="card-body">

                    <a href="admin.php?id=mcomplete"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>



                    <h4 class="card-title mb-3">Machinery Management</h4>



                    <!-- Filter Form -->

                    <form method="GET" action="">

                        <input type="hidden" name="id" value="rcomplete1">

                        <div class="row mb-3">

                            <div class="col-md-3">

                                <select name="month" class="form-control">

                                    <option value="">Select Month</option>

                                    <?php

                                    $currentMonth = date("n");

                                    $selectedMonth = !empty($_GET['month']) ? $_GET['month'] : $currentMonth;



                                    for ($m = 1; $m <= 12; $m++) {

                                        $monthName = date("F", mktime(0, 0, 0, $m, 1));



                                        // Use if/else instead of ternary

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

                                        $selected = (!empty($_GET['year']) && $_GET['year'] == $y) ? "selected" : (empty($_GET['year']) && $y == $currentYear ? "selected" : "");

                                        echo "<option value='$y' $selected>$y</option>";
                                    }

                                    ?>

                                </select>

                            </div>

                            <div class="col-md-3">

                                <button type="submit" class="btn btn-primary">Serach</button>

                            </div>

                        </div>

                    </form>



                    <div class="table-responsive">

                        <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">

                            <thead>

                                <tr>

                                    <th>S No.</th>

                                    <th>Date Raised</th>

                                    <th>Request Number</th>

                                    <th>Equipment ID</th>

                                    <th>Equipment Name</th>

                                    <th>Raised By</th>

                                    <th>View</th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php

                                $i = 1;



                                $month = !empty($_GET['month']) ? $_GET['month'] : date("n");

                                $year  = !empty($_GET['year']) ? $_GET['year'] : date("Y");



                                $sql = mysqli_query($con, "SELECT p.id,  p.request, e.code AS eqpcode, p.raisedby,p.date, e.name, t.rid FROM ppmraise p

                                INNER JOIN tblequipment e ON p.eqpname = e.id INNER JOIN tblequipment1 t ON t.eid = p.eqpname AND t.rid = p.id

                                WHERE MONTH(p.date)='$month' AND YEAR(p.date)='$year'  AND t.mverify='done' ORDER BY p.id DESC ");



                                while ($row = mysqli_fetch_array($sql)) {

                                ?>

                                    <tr>

                                        <td><?php echo $i; ?></td>

                                        <td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>

                                        <td><?php echo $row['request']; ?></td>

                                        <td><?php echo $row['eqpcode']; ?></td>

                                        <td><?php echo $row['name']; ?></td>

                                        <td><?php echo $row['raisedby']; ?></td>

                                        <td>

                                            <a href="admin.php?id=rcompview&sno=<?php echo $row['id']; ?>&rid=<?php echo $row['rid']; ?>&month=<?php echo $month; ?>&year=<?php echo $year; ?>">

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