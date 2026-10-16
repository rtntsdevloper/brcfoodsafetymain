<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="admin.php?id=1">Home</a></li>
            <li>QMS Metal Detector </li>
        </ul>
    </div>
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <a href="admin.php?id=paperwork"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                    <a href="admin.php?id=pw_qsmetaladd"><button class="btn btn-danger" style="float:right">Add Record </button></a>
                    
                    </a>

                    <h4 class="card-title mb-3">QMS Metal Detector Fail Safe Test Form (For Retail)</h4>

                    <p>List of Record</p>

                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                            <thead>
                                <tr>

                                    <th scope="col">#</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Time</th>
                                    <th scope="col">Verification</th>
                                    <th scope="col">View</th>


                                    <!-- <th>View Report</th> -->

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = mysqli_query($con, "SELECT * FROM `pw_qmsmetal` order by qdate desc");
                                $i = 0;
                                while ($row = mysqli_fetch_array($sql)) {
                                    $i++;
                                ?>
                                    <tr>

                                        <th scope="row"><?php echo $i; ?></th>
                                        <td><?php echo date('d-m-Y', strtotime($row['qdate'])); ?></td>
                                         <td><?php echo date('h:i a', strtotime($row['qtime'])); ?></td>
                                           <td><?php 
                                           if(isset($row['checkby']) && !empty($row['checkby']))
                                           {
                                           ?>
                                           <button class="btn btn-success">Completed</button>

                                           <?php
                                           }
                                           else
                                           {
                                            ?>
                                            <a href="admin.php?id=pw_qsmetalcheckr&eid=<?php echo $row['id']; ?>" class="btn btn-danger">Pending</a>
                                            <?php
                                           }
                                           
                                           
                                           ?></td>
                                       
                                        <td><a href="admin.php?id=pw_qsmetalview&eid=<?php echo $row['id']; ?>"><button class="btn btn-primary">View</button></a></td>
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