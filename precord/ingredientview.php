<?php
$wdate = $_GET['wcode'];

?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="admin.php?id=1">Home</a></li>
            <li>Monitoring Form > Ingredient and Product Transfer form </li>
        </ul>
    </div>
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <a href="admin.php?id=ingredient"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                    <a href="admin.php?id=ingredientpdf&wdate=<?php echo $wdate; ?>"><button class="btn btn-warning mr-3" style="float:right">View Report</button></a>
                    </a>

                    <h4 class="card-title mb-3">Ingredient and Product Transfer form </h4>

                    <p>List of Record</p>

                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                            <thead>
                                <tr>

                                    <th scope="col">#</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Time of Transfer</th>
                                    
                                    <th scope="col">Name of Product/Ingredient</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Is Raw material/Packaging intact prior to transfer?</th>
                                    <th scope="col">Comment</th>
                                    <th scope="col">Operator Sign</th>



                                    <!-- <th>View Report</th> -->

                                </tr>
                            </thead>
                            <tbody>
                                <?php 


                                $sql = mysqli_query($con, "select * from `tbl_ingredienttrans` where tdate='$wdate'");
                                $i = 0;
                                while ($row = mysqli_fetch_array($sql)) {
                                    $i++;
                                ?>
                                    <tr>

                                        <th scope="row"><?php echo $i; ?></th>
                                        <td><?php echo date('d-m-Y', strtotime($row['tdate'])); ?></td>
                                        <td><?php echo $row['ttime']; ?></td>
                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php echo $row['qty']; ?> </td>
                                        <td><?php echo $row['ques']; ?> </td>
                                        <td><?php echo $row['comment']; ?> </td>
                                        <td><img src="precord/sign/<?php echo $row['operatorsign']; ?>.png" alt="" width="80"></td>
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