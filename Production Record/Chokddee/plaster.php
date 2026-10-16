<?php

$tid = $_GET['tid'];


?>


<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <li> Plaster Record </li>
        </ul>
    </div>
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <a href="admin.php?id=1"><button class="btn btn-success"
                            style="float:right; margin-left:15px">Go Back</button></a>
                    <a href="admin.php?id=plaster1&tid=<?php echo $tid;?>"><button class="btn btn-danger" style="float:right">Add
                            New</button></a>
                    <a href="admin.php?id=plasterpdf&tid=<?php echo $tid;?>"><button class="btn btn-warning mr-3" style="float:right">View Record</button></a>
                    <h4 class="card-title mb-3">Plaster Record</h4>
                    <p>List of Record</p>

                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="zero_configuration_table"
                            style="width:100%">
                            <thead>
                                <tr>

                                    <th scope="col">#</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Issue to</th>
                                    <th scope="col">Issued by</th>
                                    <th scope="col">Check and intact end of shift</th>
                                    <th scope="col">Check By</th>
                                    <!-- <th scope="col">Attempt By</th> -->

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = mysqli_query($con, "select * from tblplaster where tid= $tid ORDER BY Date desc");
                                $i = 0;
                                while ($row = mysqli_fetch_array($sql)) {
                                    $i++;
                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $i; ?></th>
                                        <td><?php echo $row['date']; ?></td>
                                        <td><?php echo $row['issueto']; ?></td>

                                        <td><?php echo $row['issueby']; ?> </td>

                                        <td><?php echo $row['shift']; ?> </td>

                                        <td><?php echo $row['checkby']; ?> </td>
                                           


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