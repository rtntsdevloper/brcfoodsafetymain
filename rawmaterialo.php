<?php
// $r=mysqli_query($con,"select * from attempt where username='$_SESSION[uname]'");
// $num=mysqli_num_rows($r);
// echo $num;

?>

<div class="main-content">
    <div class="breadcrumb">

        <ul>
            <li><a href="">Home</a></li>
            <li>Raw Material Management </li>
        </ul>
    </div>

    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <a href="admin.php?id=1"><button class="btn btn-success"
                            style="float:right; margin-left:15px">Go Back</button></a>



                    <a href="admin.php?id=addrawmaterial1"><button class="btn btn-success ml-3 mb-3"
                            style="float:right">Add New</button></a>
                    <a href="admin.php?id=assesmentvulner"><button class="btn btn-danger ml-3 mb-3"
                            style="float:right">Vulnerability Assesment</button></a>
                    <a href="admin.php?id=assesmentrisk"><button class="btn btn-danger mb-3 "
                            style="float:right">Risk Assesment</button></a>
                    <h4 class="card-title mb-3">Raw Material</h4>
                    <!-- <p>List of staff</p> -->

                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="zero_configuration_table"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sr. no</th>
                                    <!-- <th>Category</th> -->
                                    <th>Product code</th>
                                    <th>Product name</th>
                                    <!-- <th>Image</th> -->
                                    <th>Supplier Name</th>
                                    <!-- <th>ingredients</th> -->
                                    <th>Storage Condition</th>
                                    <th>Vulnerability Assessment</th>
                                    <th>Risk Assessment</th>
                                    <!-- <th>Uom</th> -->
                                    <!-- <th>Kill date</th> -->
                                    <!-- <th>Shelf life</th> -->
                                    <!-- <th>shelf life 1</th> -->
                                    <th>Edit</th>
                                    <th>Assesment Detail</th>
                                    <th>View specs</th>
                                    <th>View Product</th>


                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = mysqli_query($con, "select * from tblrawmaterial");



                                $i = 0;
                                // while (($y = mysqli_fetch_array($sql))&&(($z = mysqli_fetch_array($sql2))))  {
                                while ($y = mysqli_fetch_array($sql)) {
                                    $i++;

                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $i; ?></th>
                                        <!-- <td ></td> -->
                                        <td><?php

                                            echo $y['pcode']; ?></td>
                                        <td><?php

                                            echo $y['pname']; ?></td>

                                        <td>
                                            <?php
                                            $supid = $y['supid'];
                                            $supl = mysqli_query($con, "SELECT * FROM tblrawsupplier WHERE supid=$supid");
                                            $row1 = mysqli_fetch_array($supl);
                                            echo $row1['supname'];
                                            ?>
                                        </td>
                                        <td><?php echo $y['chiller']; ?></td>
                                        <td><?php if ($y['vulner'] == 'Pending') {
                                                echo '<a  href="admin.php?id=vulner&view=' . $y['id'] . '" class="btn btn-primary">Complete Assesment</a>';
                                            } else {
                                                $vsum = $y['vulner'];
                                                if ($vsum <= 20) {
                                                    echo "<button class='btn btn-success'>Low</button>";
                                                } elseif ($vsum >= 21 && $vsum <= 40) {
                                                    echo "<button class='btn btn-warning'>Medium</button>";
                                                } elseif ($vsum >= 40) {
                                                    echo "<button class='btn btn-danger'>High</button>";
                                                }
                                            }

                                            ?></td>
                                        <td><?php
                                            if ($y['risk'] == 'Pending') {
                                                echo '<a  href="admin.php?id=risk&view=' . $y['id'] . '" class="btn btn-primary">Complete Assesment</a>';
                                            } else {
                                                $rasum = $y['risk'];
                                                if ($rasum >= 7 && $rasum < 15) {
                                                    echo "<button class='btn btn-success'>Low</button>";
                                                } elseif ($rasum >= 15 && $rasum <= 21) {
                                                    echo "<button class='btn btn-danger'>High</button>";
                                                }
                                            }
                                            ?></td>


                                        <td>
                                            <a href="admin.php?id=editrawmaterial&sno=<?php echo $y['id']; ?>"><button
                                                    class="btn btn-success" type="button"><i
                                                        class="fa fa-pencil"></i></button></a>


                                        </td>
                                        <td>
                                            <?php
                                            if ($y['risk'] != 'Pending' && $y['vulner'] != 'Pending') {
                                                echo ' <a href="admin.php?id=assesmentprod&sno=' . $y["id"] . '"><button class="btn btn-success" type="button">Assesment detail</button></a>';
                                            } else {
                                            }
                                            ?>



                                        </td>
                                        <td>



                                            <?php
                                            // $sno = $_GET['id'];
                                            $sq1 = mysqli_query($con, "select * from tblrawspecdetail where product='$y[id]'");
                                            $row1 = mysqli_fetch_array($sq1);
                                            //   echo   $row1['spec'];die;
                                            if ($row1['spec'] != '') { ?>
                                                <a href="admin.php?id=viewrawspecs&sno=<?php echo $y['id']; ?>">
                                                    <button class="btn btn-warning" type="button"><i
                                                            class="fa fa-eye"></i></button>
                                                </a>
                                            <?php   } else {
                                            ?>



                                                <a href="admin.php?id=uploadrawspec&product=<?php echo $y['id']; ?>&supp=<?php echo  $y['supid']; ?>">
                                                    <button class="btn btn-primary" type="button">Add</button>
                                                </a>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <a href="admin.php?id=rawmaterial_view&view=<?php echo $y['id']; ?>" class="btn btn-info">Product Detail</a>
                                        </td>

                                        </td>
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