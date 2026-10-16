<?php
$pid = $_GET['pid'];
$date = $_GET['date'];
$product = $_GET['product'];
// print_r("SELECT * FROM `tblscalee` WHERE date='$dtc' AND status ='Verified'");
$pqx = mysqli_query($con, "SELECT * FROM `tblsavoury` WHERE status ='Verified' and  product='$product' and date='$date'");
// $rro=mysqli_fetch_array($pqx);
// $sign=$rro['sign'];
$pqxn = mysqli_fetch_assoc($pqx);


?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <?php
            $pid = $_GET['pid']; ?>
            <?php if ($pid == '1') { ?>
                <li>Savoury Production</li>
            <?php } elseif ($pid == '2') { ?>
                <li>Sauce Production</li>
            <?php } elseif ($pid == '3') { ?>
                <li>Meat Production</li>
            <?php }else{
                
            } ?>
        </ul>
    </div>
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <a href="admin.php?id=savouryproduction&pid=<?php echo $pid; ?>"><button class="btn btn-success"
                            style="float:right; margin-left:15px">Go Back</button></a>
<?php if($pid==2){ ?>
                    <a href="admin.php?id=weightdate&tid=18"><button class="btn btn-success"
                            style="float:right; margin-left:15px">View Daily Weight Check</button></a>
                            <?php }elseif($pid==3) {?>
                            <a href="admin.php?id=weightdate&tid=15"><button class="btn btn-success"
                            style="float:right; margin-left:15px">View Daily Weight Check</button></a>
  <?php }else{ ?>
<a href="admin.php?id=weightdate&tid=25"><button class="btn btn-success"
                            style="float:right; margin-left:15px">View Daily Weight Check</button></a>
 <?php }?>
                    <?php if ($pqxn > 0) { ?>
                        <a
                            href="admin.php?id=cookingccpreport&pid=<?php echo $pid; ?>&date=<?php echo $date; ?>&product=<?php echo $product; ?>&ac=1"><button
                                class="btn btn-warning mr-3" style="float:right" target="_blank">View Record</button></a>


                    <?php } else {
                        ?>
                        <a
                            href="admin.php?id=cookingccpreport&pid=<?php echo $pid; ?>&date=<?php echo $date; ?>&ac=2&product=<?php echo $product; ?>"><button
                                class="btn btn-warning mr-3" style="float:right" target="_blank"> Verify Record</button></a>
                        <?php
                    }
                    ?>


                    <h4 class="card-title mb-3">

                        <!-- <p>List of Dispatch</p> -->

                        <div class="table-responsive mt-5">
                            <?php if ($pid != 2) {

                                ?>
                                <table class="display table table-striped table-bordered text-center"
                                    id="zero_configuration_table" style="width:100%">
                                    <thead>
                                        <h4 class="card-title mb-3"> <?php if ($pid == '1') { ?>
                                                Savoury Production
                                            <?php } elseif ($pid == '2') { ?>
                                                Sauce Production
                                            <?php } elseif ($pid == '3') { ?>
                                                Meat Production
                                            <?php } ?>
                                        </h4>
                                        <?php

                                        $sql3 = mysqli_query($con, "SELECT * FROM `tblsavoury` where date ='$date' and product='$product'");
                                        $row3 = mysqli_fetch_array($sql3);
                                        $cooking = $row3['cooking'];
                                        $blastchiller = $row3['blastchiller'];
                                        $freezing = $row3['freezing'];
                                        $prod = $row3['product'];

                                        if ($pid == 1) {
                                            $ssql = mysqli_query($con, "SELECT * FROM tblproductlist  where id='$prod'");
                                        } elseif ($pid == 2) {
                                            $ssql = mysqli_query($con, "SELECT * FROM tblsauceproductlist  where id='$prod'");
                                        } elseif ($pid == 3) {
                                            $ssql = mysqli_query($con, "SELECT * FROM tblmeatproductlist  where id='$prod'");
                                        }
                                        $roww = mysqli_fetch_array($ssql);
                                        echo 'Product Name:' . $roww['prname']

                                            .
                                            '<br><br>';
                                        echo 'Date: ' . date('d-m-Y', strtotime($row3['date'])) . '<br><br>';

                                        ?> <input type="hidden" value="<?php echo $row3['product']; ?>">
                        </h4>
                        <tr>
                            <th> </th>
                            <th colspan="6">Cooking (>=90 °C for 10 minutes) CCP 1a </th>
                            <th colspan="6">Blast Chiller (<=5°C in 90 minutes) CCP3 </th>
                            <th colspan="4">
                                Freezing Record

                            </th>
                        </tr>

                        <tr>
                            <th scope="col" class="pb-5">S.No.</th>
                            <th scope="col" class="pb-5">Batch Code</th>
                            <th scope="col" class="pb-5">Cooking Start Time</th>
                            <th scope="col" class="pb-5">Actual Start time of CCP</th>
                            <th scope="col" class="pb-5">Actual Temperature of CCP at Start time</th>



                            <th scope="col" class="pb-5">Actual End time of CCP</th>
                            <th scope="col" class="pb-5">Actual Temperature of CCP at End time</th>
                            <th scope="col" class="pb-5">Blast Chiller Temperature</th>
                            <th scope="col" class="pb-5">Start Time</th>
                            <th scope="col" class="pb-5">Product Temperature</th>
                            <th scope="col" class="pb-5">Blast Chiller Temperature</th>
                            <th scope="col" class="pb-5">End Time</th>
                            <th scope="col" class="pb-5">Product Temperature</th>

                            <th scope="col" class="pb-5">

                                Freezer Temperature

                            </th>
                            <th scope="col" class="pb-5">Start Time </th>
                            <th scope="col" class="pb-5"> End Time </th>
                            <th scope="col" class="pb-5">

                                Product Temperature

                            </th>



                        </tr>

                        </thead>
                        <tbody>
                            <?php
                            // print_r("SELECT * FROM `tblcooking` where pdate ='$date' and pname='$product'");
                            $sql = mysqli_query($con, "SELECT * FROM `tblcooking` where pdate ='$date' and pname='$product' and pid='$pid'");
                            $i = 0;
                            while ($row = mysqli_fetch_array($sql)) {
                                $i++;
                                // print_r("SELECT * FROM `tblblastchiller` where pdate ='$date' and pname='$product'");
                                $sql1 = mysqli_query($con, "SELECT * FROM `tblblastchiller` where pdate ='$date' and pname='$product' and pid='$pid'");
                                $row1 = mysqli_fetch_array($sql1);
                                $sql2 = mysqli_query($con, "SELECT * FROM `tblfreezing` where pdate ='$date' and pname='$product' and pid='$pid' ");
                                $row2 = mysqli_fetch_array($sql2);
                                $sql3 = mysqli_query($con, "SELECT * FROM `tblsavoury` where date ='$date' and product='$product' and pid='$pid'");
                                $row3 = mysqli_fetch_array($sql3);
                                $cooking = $row3['cooking'];
                                $blastchiller = $row3['blastchiller'];
                                $freezing = $row3['freezing'];



                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <?php if ($cooking == 'Done') { ?>
                                        <td><?php echo $row['batchcode'] ?></td>
                                        <td><?php echo $row['ctime']; ?></td>
                                        <td><?php echo $row['starttime']; ?></td>
                                        <td><?php echo $row['temp1'] ?>&deg;C</td>

                                        <td><?php echo $row['endtime']; ?></td>
                                        <td><?php echo $row['temp2']; ?>&deg;C</td>
                                    <?php } else { ?>

                                        <td colspan="6"><button class="btn btn-success text-light"><a
                                                    href="admin?id=addcookingccp&pid=<?php echo $pid ?>&date=<?php echo $date ?>&product=<?php echo $product ?>">CLICK</a></button>
                                        </td>

                                    <?php } ?>
                                    <?php if ($blastchiller == 'Done') { ?>
                                        <td><?php echo $row1['temp1']; ?>&deg;C</td>
                                        <td><?php echo $row1['starttime']; ?></td>

                                        <td><?php echo $row1['ptemp']; ?>&deg;C</td>
                                        <td><?php echo $row1['temp2']; ?>&deg;C</td>
                                        <td><?php echo $row1['endtime']; ?></td>
                                        <td><?php echo $row1['ptemp2']; ?>&deg;C</td>
                                    <?php } else { ?>
                                        <td colspan="6"><button class="btn btn-success text-light"><a
                                                    href="admin?id=blastchilleradd&pid=<?php echo $pid ?>&date=<?php echo $date ?>&product=<?php echo $product ?>">CLICK</a></button>
                                        </td>
                                    <?php } ?>


                                    <?php if ($freezing == 'Done') { ?>

                                        <td><?php echo $row2['temp1']; ?>&deg;C</td>
                                        <td><?php echo $row2['starttime']; ?></td>
                                        <td><?php echo $row2['endtime']; ?></td>
                                        <td><?php echo $row2['ptemp']; ?>&deg;C</td>
                                    <?php } else { ?>
                                        <td colspan="4"><button class="btn btn-success text-light"><a
                                                    href="admin?id=freezingadd&pid=<?php echo $pid ?>&date=<?php echo $date ?>&product=<?php echo $product ?>">CLICK</a></button>
                                        </td>
                                    <?php } ?>

                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                        </table>
                    <?php } else { ?>
                        <table class="display table table-striped table-bordered text-center" id="zero_configuration_table"
                            style="width:100%">
                            <thead>
                                <h4 class="card-title mb-3"> <?php if ($pid == '1') { ?>
                                        Savoury Production
                                    <?php } elseif ($pid == '2') { ?>
                                        Sauce Production
                                    <?php } elseif ($pid == '3') { ?>
                                        Meat Production
                                    <?php } ?>
                                </h4>
                                <?php

                                $sql3 = mysqli_query($con, "SELECT * FROM `tblsavoury` where date ='$date' and product='$product'");
                                $row3 = mysqli_fetch_array($sql3);
                                $cooking = $row3['cooking'];
                                $blastchiller = $row3['blastchiller'];
                                $freezing = $row3['freezing'];
                                $prod = $row3['product'];

                                if ($pid == 1) {
                                    $ssql = mysqli_query($con, "SELECT * FROM tblproductlist  where id='$prod'");
                                } elseif ($pid == 2) {
                                    $ssql = mysqli_query($con, "SELECT * FROM tblsauceproductlist  where id='$prod'");
                                } elseif ($pid == 3) {
                                    $ssql = mysqli_query($con, "SELECT * FROM tblmeatproductlist  where id='$prod'");
                                }
                                $roww = mysqli_fetch_array($ssql);
                                echo 'Product Name:' . $roww['prname']

                                    .
                                    '<br><br>';
                                echo 'Date: ' . date('d-m-Y', strtotime($row3['date'])) . '<br><br>';

                                ?> <input type="hidden" value="<?php echo $row3['product']; ?>">
                                </h4>
                                <tr>
                                    <th> </th>
                                    <th colspan="6">Cooking (>=90 °C for 10 minutes) CCP 1a </th>

                                    <th colspan="4"> Hot Filling (&gt;=82&deg;C or above) CCP2</th>
                                    <th colspan="6">Blast Chiller (<=5°C in 90 minutes) CCP3 </th>
                                </tr>

                                <tr>
                                    <th scope="col" class="pb-5">S.No.</th>
                                    <th scope="col" class="pb-5">Batch Code</th>
                                    <th scope="col" class="pb-5">Cooking Start Time</th>
                                    <th scope="col" class="pb-5">Actual Start time of CCP</th>
                                    <th scope="col" class="pb-5">Actual Temperature of CCP at Start time</th>
                                    <th scope="col" class="pb-5">Actual End time of CCP</th>
                                    <th scope="col" class="pb-5">Actual Temperature of CCP at End time</th>
                                    <th scope="col" class="pb-5">Start Time </th>
                                    <th scope="col" class="pb-5">

                                        Product Temperature (>=82°C )

                                    </th>

                                    <th scope="col" class="pb-5"> Finish Time </th>
                                    <th scope="col" class="pb-5">

                                        Product Temperature (>=82°C )

                                    </th>

                                    <th scope="col" class="pb-5">Blast Chiller Temperature</th>
                                    <th scope="col" class="pb-5">Start Time</th>
                                    <th scope="col" class="pb-5">Product Temperature</th>
                                    <th scope="col" class="pb-5">Blast Chiller Temperature</th>
                                    <th scope="col" class="pb-5">End Time</th>
                                    <th scope="col" class="pb-5">Product Temperature</th>







                                </tr>

                            </thead>
                            <tbody>
                                <?php
                                // print_r("SELECT * FROM `tblcooking` where pdate ='$date' and pname='$product'");
                                $sql = mysqli_query($con, "SELECT * FROM `tblcooking` where pdate ='$date' and pname='$product' and pid='$pid'");
                                $i = 0;
                                while ($row = mysqli_fetch_array($sql)) {
                                    $i++;
                                    // print_r("SELECT * FROM `tblblastchiller` where pdate ='$date' and pname='$product'");
                                    $sql1 = mysqli_query($con, "SELECT * FROM `tblblastchiller` where pdate ='$date' and pname='$product' and pid='$pid'");
                                    $row1 = mysqli_fetch_array($sql1);
                                    $sql2 = mysqli_query($con, "SELECT * FROM `tblfreezing` where pdate ='$date' and pname='$product' and pid='$pid' ");
                                    $row2 = mysqli_fetch_array($sql2);
                                    $sql3 = mysqli_query($con, "SELECT * FROM `tblsavoury` where date ='$date' and product='$product' and pid='$pid'");
                                    $row3 = mysqli_fetch_array($sql3);
                                    $cooking = $row3['cooking'];
                                    $blastchiller = $row3['blastchiller'];
                                    $freezing = $row3['freezing'];



                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <?php if ($cooking == 'Done') { ?>
                                            <td><?php echo $row['batchcode'] ?></td>
                                            <td><?php echo $row['ctime']; ?></td>
                                            <td><?php echo $row['starttime']; ?></td>
                                            <td><?php echo $row['temp1'] ?>&deg;C</td>

                                            <td><?php echo $row['endtime']; ?></td>
                                            <td><?php echo $row['temp2']; ?>&deg;C</td>
                                        <?php } else { ?>

                                            <td colspan="6"><button class="btn btn-success text-light"><a
                                                        href="admin?id=addcookingccp&pid=<?php echo $pid ?>&date=<?php echo $date ?>&product=<?php echo $product ?>">CLICK</a></button>
                                            </td>

                                        <?php } ?>



                                        <?php if ($freezing == 'Done') { ?>


                                            <td><?php echo $row2['starttime']; ?></td>
                                            <td><?php echo $row2['temp1']; ?>&deg;C</td>
                                            <td><?php echo $row2['endtime']; ?></td>
                                            <td><?php echo $row2['ptemp']; ?>&deg;C</td>
                                        <?php } else { ?>
                                            <td colspan="4"><button class="btn btn-success text-light"><a
                                                        href="admin?id=freezingadd&pid=<?php echo $pid ?>&date=<?php echo $date ?>&product=<?php echo $product ?>">CLICK</a></button>
                                            </td>
                                        <?php } ?>

                                        <?php if ($blastchiller == 'Done') { ?>
                                            <td><?php echo $row1['temp1']; ?>&deg;C</td>
                                            <td><?php echo $row1['starttime']; ?></td>

                                            <td><?php echo $row1['ptemp']; ?>&deg;C</td>
                                            <td><?php echo $row1['temp2']; ?>&deg;C</td>
                                            <td><?php echo $row1['endtime']; ?></td>
                                            <td><?php echo $row1['ptemp2']; ?>&deg;C</td>
                                        <?php } else { ?>
                                            <td colspan="6"><button class="btn btn-success text-light"><a
                                                        href="admin?id=blastchilleradd&pid=<?php echo $pid ?>&date=<?php echo $date ?>&product=<?php echo $product ?>">CLICK</a></button>
                                            </td>
                                        <?php } ?>

                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>