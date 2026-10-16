<?php
include('connection.php')
    ?>
<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>indicator</li>
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=over"><button class="btn btn-success" style="float:right; margin-left:15px">Go
                        Back</button></a>


                <a href="admin.php?id=indicatoradd"><button class="btn btn-danger"
                        style="float:right; margin-left:15px">Add
                        New</button></a>

                <div class="card-title"> Indicator</div>



                <div class="table-responsive">
                    <table class="display table table-striped table-bordered" id="zero_configuration_table"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">Sr No.</th>
                                <th scope="col">Name</th>
                                <th scope="col">Target</th>
                                <th scope="col">Acceptable</th>
                                <th scope="col">Action</th>

                                <th scope="col">Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $q = mysqli_query($con, "SELECT * FROM `tbl_overname` ");

                            foreach ($q as $row) {
                                $i++;

                                ?>
                                <tr>
                                    <th scope="row"><?php echo $i; ?></th>

                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['target']; ?></td>
                                    <td><?php echo $row['acceptable']; ?></td>
                                    <td><?php echo $row['action']; ?></td>


                                    <td>
                                        <a href="admin.php?id=indicatoredit&sno=<?php echo $row['id']; ?>">

                                            <span class="btn btn-info">Edit</span></a>


                                    </td>


                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>


<!-- <div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Overall Status</a></li>
            <li>form</li>
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=over"><button class="btn btn-success" style="float:right; margin-left:15px">Go
                        Back</button></a>

                <div class="card-title">Add</div>


                <form class="needs-validation" novalidate="novalidate" method="post" action=""
                    enctype="multipart/form-data">
                    <div class="form-row">

                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip01">Month</label>
                            <input class="form-control" id="validationTooltip01" type="text" placeholder="enter month"
                                required="required" name="mon" />
                            <div class="invalid-tooltip">
                                Please provide a valid first name.

                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="control-label" id="error2">Select Month</label>
                            <select name="month" id="month" class="form-control" required>
                                <option value="01">January</option>
                                <option value="02">February</option>
                                <option value="03">March</option>
                                <option value="04">April</option>
                                <option value="05">May</option>
                                <option value="06">June</option>
                                <option value="07">July</option>
                                <option value="08">August</option>
                                <option value="09">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip01">Value</label>
                            <input class="form-control" id="validationTooltip01" type="number" placeholder="enter the value"
                                required="required" name="value" />
                            <div class="invalid-tooltip">
                                Please provide a valid first name.

                            </div>
                        </div>


                    </div>

                    <button class="btn btn-primary" type="submit" name="submit">Submit </button>

                </form>
            </div>
        </div>
    </div>
</div> -->