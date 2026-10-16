 <?php
    $sno = $_GET['sno'];

    $sql = mysqli_query($con, "select * from dailychecks where id='$sno'");
    $row = mysqli_fetch_array($sql);



    ?>

 <div class="main-content">
     <div class="breadcrumb">
         <h1 class="mr-2"><?php echo $headingname; ?></h1>
         <ul>
             <li><a href="">Upload Checks</a></li>
             <li>View Detail</li>
         </ul>
     </div>
     <div class="col-md-12">
         <div class="card">
             <div class="card-body">
                 <a href="admin.php?id=dailychecksview<?php
                                                        if (isset($_GET['id2'])) {
                                                            echo "&id2=" . $_GET['id2'];
                                                        }
                                                        ?>"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

                 <div class="card-title"> Section: <?php echo $row['name']; ?></div>


                 <div class="row">
                     <div class="col-md-12">
                         <div class="card card-profile-1 mb-4">
                             <div class="card-body">
                                 <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                     <thead>
                                         <tr>
                                             <th scope="col">#</th>
                                             <th scope="col">Sub-Section</th>
                                             <th scope="col">Question</th>
                                             <th scope="col">Edit</th>
                                             <th scope="col">Delete</th>


                                         </tr>
                                     </thead>
                                     <tbody>
                                         <?php


                                            $sql2 = mysqli_query($con, "select * from dailychecks1 where tid='$sno'");
                                            $i = 0;
                                            while ($row2 = mysqli_fetch_array($sql2)) {
                                                $i++;
                                            ?>
                                             <tr>
                                                 <th scope="row"><?php echo $i; ?></th>
                                                 <td><?php echo $row2['section']; ?></td>
                                                 <td><?php echo $row2['ques']; ?></td>


                                                 <td>
                                                     <a href="admin.php?id=dailycheckedit&sno=<?php echo $row2['id']; ?><?php
                                                     
                                                                                                                        if (isset($_GET['id2'])) {
                                                                                                                            echo "&id2=" . $_GET['id2'];
                                                                                                                        }
                                                                                                                        ?>">
                                                         <span class="badge badge-info">Edit</span></a>
                                                 </td>

                                                 <td>
                                                     <a href="delchecksques?sno=<?php echo $row2['id']; ?>&tid=<?php
                                                     echo $sno;
                                                                                                        if (isset($_GET['id2'])) {
                                                                                                            echo "&id2=" . $_GET['id2'];
                                                                                                        }
                                                                                                        ?>" onclick="return confirm('Are You Sure?')">
                                                         <span class="badge badge-danger">Delete</span></a>
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
     </div>
 </div>
 </div>