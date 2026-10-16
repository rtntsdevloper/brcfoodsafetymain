
<div class="main-content">
    <div class="breadcrumb">

        <ul>
            <li><a href="">Home</a></li>
            <li>Customer Report </li>
        </ul>
    </div>



    <div class="col-md-12">
        <div class="card">
            <a href="admin.php?id=1"><button class="btn btn-success" style="float:right; margin-left:15px">Go
                    Back</button></a>
            <div class="card-body">

                <div class="row">

                    <div class="col-lg-12" id="table-responsive">

                        <div class="table-responsive">

                            <table id="datatable" class="table data-table table-striped">

                                <thead>

                                    <tr class="ligth">

                                        <th></th>

                                        <th>Customer</th>

                                        <th>Title</th>

                                        <th>Date</th>

                                        <th>Start Time</th>

                                        <th>End Time</th>

                                        <th>Report</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    <?php



                                    $sql = mysqli_query($con, "select * from tblreport  where customer ='$psdcust'");

                                    $i = 0;

                                    while ($row = mysqli_fetch_array($sql)) {

                                        $i++;



                                        $sql1 = mysqli_query($con, "select * from tblcustomer where  id='$row[customer]'");

                                        $row1 = mysqli_fetch_array($sql1);





                                        ?>

                                        <tr>

                                            <td><?php echo $i; ?> </td>

                                            <td> <?php echo $row1['name']; ?></td>

                                            <td><?php echo $row['name']; ?></td>

                                            <td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>

                                            <td><?php echo $row['stime']; ?></td>

                                            <td><?php echo $row['etime']; ?></td>



                                            <td>
                                                <a href="psdteams.com/customerreport/<?php echo $row['img']; ?>"
                                                    target="_blank">
                                                    <?php echo $row['img']; ?>
                                                </a>
                                            </td>




                                        </tr>







                                        <?php

                                    }

                                    ?>

                                    </tfoot>

                            </table>

                        </div>



                    </div>

                </div>
            </div>
        </div>
    </div>