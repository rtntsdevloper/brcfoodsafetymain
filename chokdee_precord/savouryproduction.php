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
            <?php } ?>
        </ul>
    </div>
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <a href="admin.php?id=1"><button class="btn btn-success" style="float:right; margin-left:15px">Go
                            Back</button></a>
                    <a href="admin.php?id=addcookingccp&pid=<?php echo $pid; ?>"><button class="btn btn-danger" style="float:right">Add
                            New</button></a>
                    <h4 class="card-title mb-3"> <?php if ($pid == '1') { ?>
                            Savoury Production
                        <?php } elseif ($pid == '2') { ?>
                            Sauce Production
                        <?php } elseif ($pid == '3') { ?>
                            Meat Production
                        <?php } ?>
                    </h4>

                    <!-- <p>List of Dispatch</p> -->

                    <div class="table-responsive mt-5">
                        <table class="display table table-striped table-bordered text-center"
                            id="zero_configuration_table" style="width:100%">
                            <thead>

                                <!-- <tr>
                                    <th colspan="11" style="color: red; text-align:center;">Chilled meat and meat prep +4°C; Raw meat & meat prep +4°C
                                        Frozen food -15°C; Frozen raw meat & meat prep -18°C </th>
                                </tr> -->

                                <tr>
                                    <th scope="col" class="pb-5">S.No.</th>
                                    <th scope="col" class="pb-5">Date</th>
                                    <th scope="col" class="pb-5">Product</th>
                                    <th scope="col" class="pb-5">View</th>

                                </tr>


                            </thead>
                            <tbody>
                                <?php
                                $sql = mysqli_query($con, "SELECT DISTINCT date,product  FROM `tblsavoury` where pid='$pid' ORDER BY date DESC ");

                                $i = 0;
                                while ($row = mysqli_fetch_array($sql)) {
                                    $formattedDate = date("d/m/Y", strtotime($row['date']));
                                    $i++;

                                    // Explode the comma-separated values back into arrays
                                
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $formattedDate ?></td>
                                        <td><?php $prod = $row['product'];
                           if ($pid == 1) {
                                    $ssql = mysqli_query($con, "SELECT * FROM tblproductlist  where id='$prod'");
                                } elseif ($pid == 2) {
                                    $ssql = mysqli_query($con, "SELECT * FROM tblsauceproductlist  where id='$prod'");
                                } elseif ($pid == 3) {
                                    $ssql = mysqli_query($con, "SELECT * FROM tblmeatproductlist  where id='$prod'");
                                } 

                                        $roww = mysqli_fetch_array($ssql);
                                        echo $roww['prname'];
                                        ?></td>
                                        <td><a href="admin.php?id=savouryproduction1&date=<?php echo $row['date']; ?>&product=<?php echo $row['product']; ?>&pid=<?php echo $pid; ?>"
                                                class="btn btn-info">View</a></td>
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