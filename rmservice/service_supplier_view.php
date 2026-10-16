<div class="main-content">
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left" style="margin-top:8%;">
                <div class="card-body">
                    <span style="float:left; font-size: 25px;">Supplier Detail</span>

                    <a href="admin.php?id=supplier-management"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

                    <!-- <a href="admin.php?id=add_service_supplier_issues"><button class="btn btn-info" style="float:right; margin-left:15px">Add</button></a> -->



                    <h4 class="card-title mb-3"></h4>


                    <div class="row mt-5">
                        <?php
                        $id = $_GET['view'];
                        $q = "SELECT * FROM `tblrawsupplier` where supid= $id";
                        $q1 = mysqli_query($con, $q);
                        $row = mysqli_fetch_array($q1);
                        ?>




                        <div class="table-responsive" id="basket">
                            <table class="display table table-striped table-bordered w-100" id="zero_configuration_table">




                                <tr>

                                    <th>Supplier Name</th>
                                    <td><?php echo $row['supname']; ?></td>

                                </tr>
                                <tr>
                                    <th>Address </th>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-6"><?php echo  $row['address']; ?></div>
                                            <div class="col-md-6">
                                                <?php echo $row['adlink']; ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Basis of Approval </th>
                                    <td><?php if ($row['approval'] == 'BRCGS Certification') {
                                            echo "BRCGS Certification or any GFSI Benchmark Certification";
                                        } else {
                                            echo $row['approval'];
                                        };
                                        if ($row['approval'] == 'BRCGS Certification' && !empty($row['dlink'])) { ?>
                                            <a href="<?php echo $row['dlink']; ?>" target="_blank" class="ml-5 btn btn-primary">View Source</a>
                                            <br>
                                        <?php } elseif ($row['approval'] == 'SSAQ' && !empty($row['certificate'])) {
                                        ?>
                                            <a href="rmservice/docs/<?php echo $row['certificate']; ?>" target="_blank" class="ml-5 btn btn-primary">View SSAQ</a>
                                            <br><br>

                                            <?php
                                        } else {
                                            if (!empty($row['certificate'])) {
                                            ?>
                                                <a href="rmservice/docs/<?php echo $row['certificate']; ?>" target="_blank" class="ml-5 btn btn-primary">View Cerificate</a>
                                        <?php
                                            }
                                        }
                                        ?>

                                    </td>
                                </tr>
                                <?php if (!empty($row['docdate']) && $row['approval'] == 'SSAQ') {
                                ?>
                                    <tr>
                                        <th>SSAQ Date</th>
                                        <td><?php echo date('d-m-Y', strtotime($row['docdate'])); ?></td>
                                    </tr>
                                <?php
                                } ?>
                                <?php if (!empty($row['docq']) && $row['approval'] == 'BRCGS Certification') {
                                ?>
                                    <tr>
                                        <th>Are the raw material supplied by the supplier covered under the scope?</th>
                                        <th><?php echo $row['docq']; ?></th>
                                    </tr>
                                <?php
                                } ?>

                                <?php if ($row['approval'] == 'BRCGS Certification') {
                                ?>

                                    <tr>
                                        <th>Site Code</th>
                                        <td><?php if (!empty($row['sitecode'])) {
                                                echo  $row['sitecode'];
                                            } ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                                <tr>
                                    <th>Risk Assessment </th>
                                    <td><?php echo  $row['risk']; ?></td>
                                </tr>


                                <tr>
                                    <th colspan="2">
                                        <h3>Technical Contact</h3>
                                    </th>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <td><?php echo  $row['tname'];  ?></td>
                                </tr>
                                <tr>
                                    <th>Contact No.</th>
                                    <td><?php echo  $row['tcontact'];  ?></td>
                                </tr>

                                <tr>
                                    <th>Email</th>
                                    <td><?php echo  $row['tmail'];  ?></td>
                                </tr>

                                <tr>
                                    <th colspan="2">
                                        <h3>Commerical Contact</h3>
                                    </th>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <td><?php echo  $row['coname'];  ?></td>
                                </tr>


                                <tr>
                                    <th>Email</th>
                                    <td><?php echo  $row['comail'];  ?></td>
                                </tr>
                                <?php if ($row['approval'] == 'BRCGS Certification') { ?>
                                    <tr>
                                        <th colspan="2">
                                            <h3>Certification Details</h3>
                                        </th>
                                    </tr>

                                    <tr>
                                        <th>Standard</th>
                                        <td><?php echo  $row['dstand'];  ?></td>

                                    </tr>
                                    <tr>
                                        <th>Grade</th>
                                        <td><?php echo  $row['dgrade'];  ?></td>

                                    </tr>


                                    <tr>
                                        <th>Category</th>
                                        <td><?php echo  $row['dcategory'];  ?></td>

                                    </tr>
                                    <tr>
                                        <th>Issue Date</th>
                                        <td>
                                            <?php if (!empty($row['dissue'])) {

                                                echo date('d-m-Y', strtotime($row['dissue']));
                                            }  ?>


                                    </tr>
                                    <tr>
                                        <th>Expiry Date</th>
                                        <td><?php if (!empty($row['dexpire'])) {
                                                echo date('d-m-Y', strtotime($row['dexpire']));
                                            } ?></td>

                                    </tr>
                                    <tr>
                                        <th>Scope</th>
                                        <td><?php echo  $row['dscope'];  ?></td>

                                    </tr>
                                    <tr>
                                        <th>Certification Body</th>
                                        <td><?php echo  $row['body'];  ?></td>

                                    </tr>
                                    <tr>
                                        <th>Additional Module</th>
                                        <td><?php echo  $row['dmod'];  ?></td>

                                    </tr>
                                    <tr>
                                        <th>Audit Programme</th>
                                        <td><?php echo  $row['dpro'];  ?></td>

                                    </tr>
                                    <tr>
                                        <th>Exclusion</th>
                                        <td><?php echo  $row['dex'];  ?></td>

                                    </tr>



                                <?php } ?>





                                <tr>
                                    <th colspan="2">
                                        <h3></h3>
                                    </th>
                                </tr>


                                <?php if ($row['suptype'] == "Service Supplier" || $row['suptype'] == "Secondary Packaging Supplier") {
                                    if ($row['suptype'] == "Service Supplier") {
                                        $pack = 'Service';
                                    } else {
                                        $pack = 'Product';
                                    }

                                ?>

                                    <tr>
                                        <th><?php echo $pack; ?> Provided </th>
                                        <td><?php echo  $row['service']; ?></td>
                                    </tr>

                                    <tr>
                                        <th>Services Management</th>
                                        <!-- <td> <a href="admin.php?id="><button class="btn btn-info">Services Management</button></a> -->
                                    </tr>
                                <?php } else {
                                ?>
                                    <tr>
                                        <th>Raw Material Management</th>
                                        <td> <a href="admin.php?id=rawmaterialmgmt&sid=<?php echo $id; ?>"><button class="btn btn-info">Raw Material Management</button></a>
                                    </tr>


                                <?php } ?>


                                <!-- <tr>
                                    <th>Monthly Review</th>
                                    <td> <a href=""><button class="btn btn-info">Complete Monthly Review</button></a></td>
                                </tr> -->





                                <!-- <th>raise complaint</th>-->
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
                                            $listd = mysqli_query($con, "SELECT * FROM `tbldelist` WHERE pid='$id' and type='SUP'");

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