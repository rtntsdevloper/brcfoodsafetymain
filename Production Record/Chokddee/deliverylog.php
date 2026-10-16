<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="admin.php?id=1">Home</a></li>
            <li>Delivery Log </li>
        </ul>
    </div>
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <a href="admin.php?id=1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                    <a href="admin.php?id=deliverylogadd"><button class="btn btn-danger" style="float:right">Add New</button></a>
                    <a href="admin.php?id=deliverylogpdf"><button class="btn btn-warning mr-3" style="float:right">View Record</button></a>
                    <h4 class="card-title mb-3">Delivery Log Record</h4>

                    <p>List of Delivery Log</p>

                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered " id="zero_configuration_table" style="width:100%">
                            <thead>

                                <!-- <tr>
                                    <th colspan="11" style="color: red; text-align:center;">Chilled meat and meat prep +4°C; Raw meat & meat prep +4°C
                                        Frozen food -15°C; Frozen raw meat & meat prep -18°C </th>
                                </tr> -->

                                <tr>


                                    <th scope="col" >#</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Time</th>
                                      <th scope="col">Supplier</th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Delivery Acceped Y/N</th>
                                    <th scope="col">Temprature</th>
                                    <th scope="col">Used by Date/Best before Date</th>
                                    <th scope="col">Product Batch Code</th>
                                   

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = mysqli_query($con, "select * from deliverylog");
                                $i = 0;
                                while ($row = mysqli_fetch_array($sql)) {
                                    $i++;
                                ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $row['date']; ?></td>
                                        <td><?php echo $row['time']; ?></td>
                                        <td><?php echo $row['supplier']; ?></td>
                                        <td><?php echo $row['product']; ?></td>
                                        <td><?php echo $row['delivery_accepted']; ?></td>
                                         <td><?php echo $row['temp']; ?></td>

                                        <td><?php echo $row['useby']; ?></td>
                                        <td><?php echo $row['batchcode']; ?></td>
                                       
                                     



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