<?php
include 'connection.php';
$pid = $_GET['eid'];

$qsp =mysqli_query($con,"Select * from tblouter1 where id='$pid'");
$qsp1 = mysqli_fetch_assoc($qsp);

$selectedDate = $qsp1['date'];
$formattedDate = date("d/m/Y", strtotime($selectedDate));
?>


<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <h2 class="mr-2">Entries for <?php echo $selectedDate; ?></h2>

    </div>
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <a href="admin.php?id=outerdate"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                    <a href="admin.php?id=addouter&eid=<?php echo $pid;  ?>"><button class="btn btn-danger mr-=2" style="float:right">Add Details</button></a>

                    <?php

                    $sq=mysqli_query($con,"SELECT * FROM tblouter1 WHERE id='$pid'");
                    $row1=mysqli_fetch_assoc($sq);

                    if(empty($row1['msign'])) { 
                        echo '<a href="admin.php?id=outerpdf&ac=2&eid=' . $pid . '&date=' . $selectedDate . '">
            <button class="btn btn-warning mr-3" style="float:right">Verify Report</button>
          </a>';
                    } else {
                        echo '<a href="admin.php?id=outerpdf&ac=1&date=' . $selectedDate . '&eid=' . $pid . '">
            <button class="btn btn-info mr-3" style="float:right">View Report</button>
          </a>';
                    }
                    ?>


                   
                    <h4 class="card-title mb-3"></h4>


                    <div class="table-responsive mt-5">
                        <table class="display table table-striped table-bordered text-center" id="zero_configuration_table" style="width:100%">
                            <thead>

                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Time</th>
                                    <th scope="col">Product code & Product Name</th>
                                    <th scope="col">Is Outer box label correct</th>
                                    <th scope="col">Outer coding(BB & Day coding)</th>
                                    <th scope="col">Inner coding(BB & Day coding)</th>
                                    <th scope="col">No. of Inners Per Outer</th>
                                    <th scope="col">Is Inner Packaging correct?</th>
                                    <th scope="col">In Spec (Y/N)</th>
                                    <th scope="col">Pack Sealed Correctly (Y/N)</th>
                                    <th scope="col">Sign</th>
                                </tr>

                            </thead>
                            <tbody>
                                <?php

                                $sq = mysqli_query($con, "SELECT * FROM tblouter where eid='$pid'");
                                $i = 1;

                                while ($row = mysqli_fetch_assoc($sq)) {
                                ?><tr>
                                        <td><?php echo $i++;  ?></td>

                                        <td><?php echo $row['time']; ?>
                                        </td>
                                        
                                        <td><?php echo $row['prodbt'] ." (".$row['pname'].")"; ?>
                                        </td>
                                        <td><?php echo $row['olabel']; ?>
                                        </td>
                                        <td><?php echo $row['ocoding']; ?>
                                        </td>
                                        <td><?php echo $row['icoding']; ?>
                                        </td>
                                        <td><?php echo $row['innerper']; ?>
                                        </td>
                                        <td><?php echo $row['innerpack']; ?>
                                        </td>
                                        <td><?php echo $row['inspec']; ?>
                                        </td>
                                        <td><?php echo $row['seal']; ?>
                                        </td>
                                        <td>
                                            <?php

                                            if (!empty($row['sign'])) {
                                              ?> 
                                              <img src="tracemp/sign/<?php echo $row['sign']; ?>.png" alt="" srcset="" width="100">
                                              <?php
                                            }
                                            ?>



                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>