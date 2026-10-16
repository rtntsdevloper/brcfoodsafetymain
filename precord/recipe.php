<?php
$wdate = $_GET['wcode'];

?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="admin.php?id=1">Home</a></li>
            <li>Monitoring Form > Wastage Record </li>
        </ul>
    </div>
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <a href="admin.php?id=recipe1"><button class="btn btn-success" style="float:right; margin-left:15px">Add Recipe</button></a>
                    <a href="admin.php?id=recipepdf&wdate=<?php echo $wdate; ?>"><button class="btn btn-warning mr-3" style="float:right">View Report</button></a>
                    </a>

                    <h4 class="card-title mb-3">Recipe Record</h4>

                    <p>List of Record</p>

                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                            <thead>
                                <tr>

                                    <th scope="col">#</th>
                                     <th scope="col">Reciepe Batch</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">View</th>


        

                                </tr>
                            </thead>
                            <tbody>
                                <?php


                                $sql = mysqli_query($con, "SELECT * FROM `recipedetail`");
                                $i = 0;
                                while ($row = mysqli_fetch_array($sql)) {
                                    $i++;
                                ?>
                                    <tr>

                                        <th scope="row"><?php echo $i; ?></th>
                                        <td><?php echo $row['recordid']; ?></td>
                                        <td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
                                        <td><?php echo $row['fproduct']; ?></td>
                                        
                                        <td>
                                            <?php

                                            if($row['status']=='Draft')
                                            {
                                                ?>
                                                <a href="admin.php?id=recipe3&vid=<?php echo $row['id']; ?>"><button class="btn btn-success mr-3" style="float:right">Complete Detail</button></a>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <a href="admin.php?id=recipereport&vid=<?php echo $row['id']; ?>"><button class="btn btn-info mr-3" style="float:right">View Report</button></a>
                                                <?php
                                            }
                                            
                                       ?>
                                      
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