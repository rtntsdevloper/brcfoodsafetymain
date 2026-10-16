<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <li> ML Meat Supplies Stationary Record </li>
        </ul>
    </div>
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <a href="admin.php?id=1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                    <a href="admin.php?id=mlmeats"><button class="btn btn-danger" style="float:right">Add New</button></a>
                    <a href="mlmeatspdf.php"><button class="btn btn-warning mr-3" style="float:right">View Report</button></a>
                    </a>

                    <h4 class="card-title mb-3">ML Meat Supplies
                        Stationary Record</h4>

                    <p>List of Record</p>

                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                            <thead>
                                <div class="col-md-12 ml-3">
                                    <div class="form-group" style="text-align:center;">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-outline-primary text-white" style="background-color:#663399; border-radius: 2px 0px 0px 2px;">
                                                ML Meat Supplies
                                                Stationary
                                            </button>
                                            <a href="admin.php?id=mldetect1"> <button type="button" class="btn btn-outline-primary filter-btn" style="border-radius: 0px 2px 2px 0px;">
                                                    Metal Detectable Check
                                                </button></a>
                                            <!-- <button type="button" class="btn btn-outline-primary filter-btn" data-table="auditor-table">
                                   Auditors
                                </button> -->
                                        </div>
                                    </div>
                                </div>
                                <tr>

                                    <th scope="col">#</th>
                                    <th scope="col">Date of Issuing Stationary</th>
                                    <th scope="col"> Description of Issuing Statinary</th>
                                    <th scope="col">Stationary issued to</th>
                                    <th scope="col">Stationary issued By </th>
                                    <th scope="col">Is Used Stationary Returned?</th>
                                    <th scope="col">Checked By:</th>

                                    <!-- <th>View Report</th> -->

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = mysqli_query($con, " select * from mlmeats ");
                                $i = 0;
                                while ($row = mysqli_fetch_array($sql)) {
                                    $i++;
                                ?>
                                    <tr>

                                        <th scope="row"><?php echo $i; ?></th>
                                        <td><?php echo $row['date']; ?></td>
                                        <td><?php echo $row['disc']; ?></td>
                                        <td><?php echo $row['stationary']; ?> </td>
                                        <td><?php echo $row['stationaryby']; ?> </td>
                                        <td><?php echo $row['returned']; ?> </td>
                                        <td><?php echo $row['sign']; ?></td>
                                        <!-- <td><a href="plasterpdf.php"><button class="btn btn-primary">View</button></a>
                                        </td> -->

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
</div>




