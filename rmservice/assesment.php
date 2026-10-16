<div class="main-content">
    <div class="breadcrumb ">
        <!-- <h1 class="mr-2"><?php echo $headingname; ?></h1> -->
        <ul>
            <li><a href="">BARE POPCORN TASTE PANEL Management</a></li>
            <li>View Detail</li>
        </ul>
    </div>

    <div class="row mb-12 my-5">
        <div class="col-md-12 mb-12">
            <div class="card text-left" style="margin-top:4%;">
                <div class="card-body">

                    <a href="admin.php?id=1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

                    <a href="admin.php?id=question-add"><button class="btn btn-info" style="float:right; margin-left:15px">Add</button></a>



                    <h4 class="card-title mb-3"></h4>


                    <div class="row">




                        <div class="table-responsive" id="basket">
                            <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                <thead>



                                    <tr>
                                        <th>Sr.no</th>
                                        <th>Question</th>
                                        <th>Category</th>
                                        <th>Sub-category</th>
                                        <th>Edit</th>



                                        <!-- <th>view</th> -->

                                    </tr>
                                </thead>
                                <tbody>


                                    <?php

                                    $sql = mysqli_query($con, "SELECT * FROM `tblassesment`");
                                    $i = 0;
                                    while ($row = mysqli_fetch_array($sql)) {
                                        $i++;

                                        $id = $row['id'];


                                    ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $row['question']; ?></td>



                                            <td><?php echo  $row['category']  ?></td>
                                            <td><?php echo  $row['type'] ?></td>
                                            <td><a href="admin?id=question-edit&edit=<?php echo $row['id'];?>" class='btn btn-success'><i class="fa fa-pencil"></i>Edit</a></td>

                                            </td>
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