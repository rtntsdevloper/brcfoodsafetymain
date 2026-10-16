<div class="main-content">
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left" style="margin-top:8%;">
                <div class="card-body">
                    <span style="float:left; font-size: 25px;">Raw Material Detail</span>

                    <?php
                    if (isset($_GET['sid'])) {

                    ?>
                        <a href="admin.php?id=rawmaterialc&sid=<?php echo $_GET['sid']; ?>"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                    <?php

                    } else {
                    ?>
                        <a href="admin.php?id=addrawmaterial"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                    <?php
                    }
                    ?>



                    <!-- <a href="admin.php?id=add_service_supplier_issues"><button class="btn btn-info" style="float:right; margin-left:15px">Add</button></a> -->



                    <h4 class="card-title mb-3"></h4>


                    <div class="row mt-5">
                        <?php
                        $id = $_GET['view'];
                        $q = "SELECT * FROM `tblrawmaterial` where id= $id";
                        $q1 = mysqli_query($con, $q);
                        $row = mysqli_fetch_array($q1);
                        ?>




                        <div class="table-responsive" id="basket">
                            <table class="display table table-striped table-bordered w-100" id="zero_configuration_table">




                                <tr>

                                    <th>Product Name</th>
                                    <td><?php echo $row['pname']; ?></td>

                                </tr>
                                <tr>

                                    <th>Product code</th>
                                    <td><?php echo $row['pcode']; ?></td>

                                </tr>
                                <tr>

                                    <th>Category</th>
                                    <td><?php echo $row['category']; ?></td>

                                </tr>
                                <?php if (!empty($row['pic'])) {
                                ?>
                                    <tr>

                                        <th>Image</th>
                                        <td><img src="img/<?php echo $row['pic']; ?>" alt="" style="height:200px; width:240px;"></td>

                                    </tr>
                                <?php
                                } ?>

                                <tr>

                                    <th>Supplier name</th>
                                    <td>
                                        <?php
                                        $sp1 = "SELECT * FROM `tblrawsupplier` WHERE supid=$row[supid]";

                                        $sp2 = mysqli_query($con, $sp1);
                                        $spq = mysqli_fetch_array($sp2);

                                        echo $spq['supname'];
                                        ?>
                                    </td>

                                </tr>
                                <tr>
                                    <th>Is there any claim?</th>
                                    <td><?php echo $row['pclaim']; ?></td>
                                </tr>
                                <?php
                                if ($row['pclaim'] == 'Yes') {
                                ?>
                                    <tr>
                                        <th>Specify the Claim</th>
                                        <td><?php echo $row['claimspecify']; ?></td>
                                    </tr>

                                    <tr>
                                        <th>Claim certificate</th>
                                        <td>
                                            <?php if ($row['cclaim']) { ?>
                                                <a href="img/<?php echo $row['cclaim']; ?>" class="btn btn-primary" target="_blank" rel="noopener noreferrer">Claim Certificate</a>
                                            <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>

                                <?php
                                }


                                ?>




                                <!-- raw materail -->

                                <?php
                                if ($row['category'] == 'Raw Material') {
                                ?>

                                    <tr>

                                        <th>Shelf Life?</th>
                                        <td><?php echo $row['shelflife']; ?></td>

                                    </tr>
                                    <tr>

                                        <th>Once Open Shelf Life</th>
                                        <td><?php echo $row['onceshelf']; ?></td>

                                    </tr>
                                    <tr>

                                        <th>Storage Condition</th>
                                        <td><?php echo $row['chiller']; ?></td>

                                    </tr>
                                    <tr>

                                        <th>Is product suitable for freezing?</th>
                                        <td><?php echo $row['freeze']; ?></td>

                                    </tr>

                                    <?php if ($row['freeze'] == 'Yes') {
                                    ?>
                                        <tr>

                                            <th> Frozen shelf life</th>
                                            <td><?php echo $row['freezelife']; ?></td>

                                        </tr>
                                    <?php
                                    }
                                    ?>


                                <?php
                                }

                                ?>


                                <!-- end -->
                                <tr>

                                    <th> Country of Origin</th>
                                    <td><?php echo $row['origin']; ?></td>

                                </tr>

                                <tr>

                                    <th>Is the product purchased from manufacturer?</th>
                                    <td><?php echo $row['purchase']; ?></td>

                                </tr>
                                <?php if ($row['purchase'] == 'No') {
                                ?>

                                    <tr>

                                        <th>Number of manufacturers?</th>
                                        <td><?php echo $row['manfact']; ?></td>

                                    </tr>
                                    <tr height="500">

                                        <th colspan="2">
                                            <h3>Manufactures Details</h3>
                                            <table class="table " width="100%">
                                                <tr>
                                                    <th>S No.</th>
                                                    <th>Name</th>
                                                    <th>Address</th>
                                                    <th>Location</th>
                                                </tr>
                                                <?php
                                                $manfname = explode(";", $row['manuf_name']);
                                                $manfadd = explode(';', $row['manuf_address']);
                                                $manfloc = explode('#', $row['manuf_location']);
                                                $i = 1;

                                                foreach ($manfname as $key => $value) {
                                                ?>


                                                    <tr>
                                                        <td><?php echo $i; ?></td>
                                                        <td><?php echo $value; ?></td>
                                                        <td><?php echo $manfadd[$key]; ?></td>
                                                        <td><?php echo $manfloc[$key]; ?></td>
                                                    </tr>
                                                <?php
                                                    $i++;
                                                }

                                                ?>
                                            </table>




                                        </th>


                                    </tr>
                                    <tr>
                                    <?php
                                }
                                    ?>

                                    <th>Is the Chain of Custody applicable?</th>
                                    <td><?php echo $row['custody']; ?></td>

                                    </tr>


                                    <?php
                                    if ($row['custody'] == 'Yes') {
                                    ?>
                                        <tr>

                                            <th>Specify Chain of Custody</th>
                                            <td><?php echo $row['chainspecify']; ?></td>

                                        </tr>


                                    <?php
                                    }


                                    ?>



                                    <?php
                                    if ($row['packaging_migration'] == 'Yes') {
                                    ?>
                                        <tr>

                                            <th>Is Packaging migration certificate available:</th>
                                            <td><?php echo $row['packaging_migration']; ?></td>

                                        </tr>
                                        <tr>

                                            <th>* Please Specify the Date</th>
                                            <td><?php echo $row['migration_date']; ?></td>

                                        </tr>
                                        <tr>

                                            <th>Packaging migration certificate</th>


                                            <?php if (!empty($row['migration_certification'])) {

                                            ?>
                                                <td><a href="img/<?php echo $row['migration_certification']; ?>" target="_blank" class="btn btn-info">Migration Certifcate</a></td>
                                            <?php
                                            } ?>


                                        </tr>

                                    <?php
                                    }
                                    ?>
                                    <tr>

                                        <th colspan="2" class="bg-white">
                                            <h3>List/Delist Record</h3>
                                            <table class="table table-striped " width="100%">
                                                <tr>
                                                    <th>S No.</th>
                                                    <th>Date</th>
                                                    <th>Status</th>

                                                </tr>
                                                <?php
                                                $listd = mysqli_query($con, "SELECT * FROM `tbldelist` WHERE pid='$id' and type='RAW'");

                                                $listdnm = mysqli_num_rows($listd);
                                                if ($listdnm == 0) {
                                                    echo "<tr><td colspan='4' class='text-center'>No Record Found</td></tr>";
                                                }

                                                $i = 1;
                                                foreach ($listd as $keyd) {
                                                ?>


                                                    <tr>
                                                        <td><?php echo $i; ?></td>
                                                        <td><?php echo $keyd['ddate']; ?></td>
                                                        <td class="text-<?php
                                                                        if ($keyd['status'] == 'Listed') {
                                                                            echo "success";
                                                                        } else {
                                                                            echo "danger";
                                                                        }

                                                                        ?>"><?php echo $keyd['status']; ?></td>

                                                    </tr>
                                                <?php
                                                    $i++;
                                                }

                                                ?>
                                            </table>




                                        </th>


                                    </tr>
                            </table>
                        </div>
                    </div>





                </div>
            </div>
        </div>
    </div>