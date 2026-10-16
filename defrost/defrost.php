<?php $date = $_GET['date'];
// echo $date=date('d-m-Y', strtotime($date));
?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="admin.php?id=1">Home</a></li>
            <li>Defrost Record</li>
        </ul>
    </div>
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <a href="admin.php?id=defrostdate"><button class="btn btn-success"
                            style="float:right; margin-left:15px">Go Back </button></a>
                    <!-- <a href="admin.php?id=defrost"><button class="btn btn-danger" style="float:right">Add New
                        </button></a> -->
                    <a href="admin.php?id=defrostpdf&date=<?php echo $date; ?>"><button class="btn btn-warning mr-3" style="float:right">View
                            Record </button></a>
                    <h4 class="card-title mb-3">Defrost Record</h4>

                    <p>List of Record</p>

                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="zero_configuration_table"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Date <br></th>
                                    <th scope="col">Product Name <br></th>
                                    <th scope="col">Quantity <br></th>
                                    <th scope="col">Batch Code/Use-By<br></th>
                                    <th scope="col">Temperature <br></th>
                                    <th scope="col">Defrost Start Date<br></th>

                                    <th scope="col">Defrost Finish Date<br></th>
                                    <th scope="col">Product Temp after defrosting <br></th>

                                    <th scope="col">Comment<br></th>
                                    <th scope="col">Checked By<br></th>
                                    <th scope="col">Edit</th>


                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = mysqli_query($con, "select * from tbldefrost where date='$date' order by id desc");
                                $i = 0;
                                while ($row = mysqli_fetch_array($sql)) {
                                    $i++;
                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $i; ?></th>
                                        <td><?php echo date('d-m-y', strtotime($row['date'])); ?></td>
                                        <td><?php echo $row['product']; ?></td>
                                        <td><?php echo $row['qty']; ?> Kg</td>
                                        <td><?php echo $row['trace']; ?> </td>

                                        <td><?php echo $row['temp']; ?><sup>o</sup>C </td>
                                        <td><?php echo date('d-m-Y', strtotime($row['moved'])); ?> </td>

                                        <?php

                                        if ($row['temp2'] == '' && $row['moved2'] == '') {
                                        ?>

                                            <td colspan="2" class="text-center">
                                                <a href="admin?id=defrost2&sno=<?php echo $row['id']; ?>" class="btn btn-info">
                                                    Fill
                                                </a>
                                            </td>

                                        <?php
                                        } else {
                                        ?>

                                            <td><?php echo date('d-m-Y', strtotime($row['moved2'])); ?> </td>
                                            <td><?php echo $row['temp2']; ?><sup>o</sup>C </td>
                                        <?php } ?>

                                        <td><?php echo $row['cmnt']; ?> </td>
                                        <td><?php echo $row['sign']; ?> </td>
                                        <td><a href="admin.php?id=defrostedit&sno=<?php  echo $row['id'] ?>&date=<?php echo $row['date'] ?>" class="btn btn-info">Edit</a> </td>


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