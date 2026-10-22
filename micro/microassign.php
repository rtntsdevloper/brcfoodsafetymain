<div class="main-content">

    <div class="breadcrumb">

        <h1 class="mr-2"><?php echo $headingname; ?></h1>

        <ul>

            <li><a href="">Home</a></li>

            <li>Micro Trending </li>

        </ul>

    </div>

    <div class="row mb-12">

        <div class="col-md-12 mb-12">

            <div class="card text-left">

                <div class="card-body">



                    <a href="admin.php?id=1"><button class="btn btn-success" style="float:right; margin-left:15px">Go
                            Back</button></a>

                    <a href="admin.php?id=microassignadd"><button class="btn btn-danger" style="float:right">Add
                            New</button></a>

                    <h4 class="card-title mb-3">Micro Trending Assign</h4>







                    <div class="table-responsive">

                        <table class="display table table-striped table-bordered" id="zero_configuration_table"
                            style="width:100%">

                            <thead>

                                <tr>

                                    <th scope="col">#</th>

                                    <th scope="col">Section</th>

                                    <th scope="col">Sub section </th>

                                    <th>Year</th>

                                    <th>Months</th>

                                </tr>

                            </thead>



                            <tbody>

                                <?php

                                $sql = mysqli_query($con, "select * from tbl_microtrending");

                                $g = 0;

                                while ($row = mysqli_fetch_array($sql)) {

                                    $msec = mysqli_query($con, "select * from tbl_micortrend where id='$row[mid]'");

                                    $msec1 = mysqli_fetch_array($msec);

                                    $msec2 = $msec1['name'];

                                    $ssec = mysqli_query($con, "select * from tbl_micortrend1 where id='$row[sid]'");

                                    $ssec1 = mysqli_fetch_array($ssec);

                                    $ssec2 = $ssec1['name'];



                                    $g++;

                                    $mnths = explode(";", $row['month']);

                                    ?>

                                    <tr>

                                        <td><?php echo $g; ?></td>

                                        <td><?php echo $msec2; ?></td>

                                        <td><?php echo $ssec2; ?></td>

                                        <td><?php

                                        echo $row['year']; ?></td>

                                        <td><?php

                                        $fk = 0;

                                        foreach ($mnths as $value) {

                                            $fk++;

                                            if ($fk == 1) {

                                                echo date("F", mktime(0, 0, 0, $value, 1));

                                            } else {

                                                echo ',' . date("F", mktime(0, 0, 0, $value, 1));

                                            }

                                        } ?></td>



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