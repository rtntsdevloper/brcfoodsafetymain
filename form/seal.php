<?php

if (isset($_POST['filter'])) {

    $startdate = $_POST['startdate'];

    $enddate = $_POST['enddate'];
} else {

    $startdate = date('Y-m-d', strtotime('last monday'));

    $enddate = date('Y-m-d');
}



?>



<div class="main-content">

    <div class="breadcrumb">



        <ul>

            <li><a href="admin.php?id=1">Home</a></li>

            <li>Labelling & Sealing Record </li>

        </ul>

    </div>





    <div class="card text-left mb-3">

        <div class="card-body">

            <form method="post">

                <div class="row">

                    <div class="col-12">

                        <label for="cc-exp" class="control-label mb-1" id="sd1" style="color:#FF0000"></label>

                    </div>

                    <div class="col-4">

                        <label for="validationTooltip02">Select Start Date</label>



                        <input type="date" name="startdate" class="form-control" value="<?= $startdate ?>">



                        <div class="invalid-tooltip">

                            Please fill the field.

                        </div>

                    </div>



                    <div class="col-4">

                        <label for="validationTooltip02">Select End Date</label>



                        <input type="date" name="enddate" class="form-control" value="<?= $enddate ?>">



                        <div class="invalid-tooltip">

                            Please fill the field.

                        </div>

                    </div>



                    <div class="col-2" style="margin:10px">

                        <label for="cc-exp" class="control-label mb-1"></label>

                        <div class="input-group">

                            <button class="btn btn-info" style="float:right" type="submit" name="filter">

                                <li class="fa fa-list"></li> Select & Go

                            </button>

                        </div>

                    </div>







                </div>

            </form>

        </div>

    </div>







    <div class="row mb-12">

        <div class="col-md-12 mb-12">

            <div class="card text-left">

                <div class="card-body">



                    <a href="admin.php?id=zendrecord&pid=1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

                    <!-- <a href="admin.php?id=zendsealpdf&startdate=<?= $startdate ?>&enddate=<?= $enddate ?>"><button class="btn btn-warning ml-3" style="float:right; margin-left:15px">View Report</button></a> -->

                    <a href="admin.php?id=zendsealadd"><button class="btn btn-danger" style="float:right">Add Labelling </button></a>





                    </a>







                    <h4 class="card-title mb-3">Labelling & Sealing Record</h4>



                    <p>List of Record</p>


 
                    <div class="table-responsive">

                        <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">

                            <thead>

                                <tr>

                                    <th scope="col">#</th>

                                    <th scope="col">Date</th>
                                    <th>View</th>
                                </tr>

                            </thead>
 
                            <tbody>

                                <?php

                                $sql = mysqli_query($con, " SELECT DISTINCT dates FROM `zendseal` WHERE dates BETWEEN '$startdate' AND '$enddate' ORDER BY dates DESC ");

                                $i = 0;

                                while ($row = mysqli_fetch_array($sql)) {



                                    $grnid = $row['productbatch'];



                                    $grnx = mysqli_query($con, "SELECT * FROM `zendproduction` WHERE id = '$grnid'");

                                    $grnx1 = mysqli_fetch_array($grnx);

                                    $i++;

                                ?>

                                    <tr>



                                        <th scope="row"><?php echo $i; ?></th>

                                        <td><?php echo date('d-m-Y', strtotime($row['dates'])); ?></td>

                                        <td><a href="admin.php?id=zendseal1&vdate=<?php echo $row['dates']; ?>" class="btn btn-primary">View</a></td>


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