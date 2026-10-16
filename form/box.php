<?php


$pxid = $_GET['pxid'];

?>

<div class="main-content">
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <a href="admin.php?id=zendrecord&pid=1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                    <a href="admin.php?id=zendboxadd&pxid=<?= $pxid ?>"><button class="btn btn-danger" style="float:right">Add Boxing Record </button></a>


                    </a>

 

                    <h4 class="card-title mb-3">Boxing Record</h4>

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
                                $sql = mysqli_query($con, "SELECT DISTINCT date FROM `zendboxing` WHERE pxid='$pxid' order by date desc ");
                                $i = 0;
                                while ($row = mysqli_fetch_array($sql)) {
                                    $i++;
                                ?>
                                    <tr>

                                        <th scope="row"><?php echo $i; ?></th>
                                        <td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>

                                        <td><a href="admin.php?id=zendbox1&vdate=<?= $row['date'] ?>" class="btn btn-info">View</a></td>




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