<?php

$sqli = mysqli_query($con, "SELECT * FROM `tblemailtrack`");
$total = mysqli_num_rows($sqli);

if ($total <= 0) {
    $new1 = 0;
    $new = 0;
    $progress1 = 0;
    $progress = 0;
    $info = 0;
    $info1 = 0;
    $done1 = 0;
    $done = 0;
} else {

    $sql2 = mysqli_query($con, "SELECT * FROM `tblemailtrack` WHERE status != 'Info Only' and status !='Completed' ");
    $progress = mysqli_num_rows($sql2);
    $progress1 = round($progress / $total * 100);


    $sql3 = mysqli_query($con, "SELECT * FROM `tblemailtrack` WHERE status = 'Info Only' ");
    $info = mysqli_num_rows($sql3);
    $info1 = round($info / $total * 100);

    $sql4 = mysqli_query($con, "SELECT * FROM `tblemailtrack` WHERE status = 'Completed'");
    $done = mysqli_num_rows($sql4);
    $done1 = round($done / $total * 100);
}


?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="main-content">
    <div class="breadcrumb ">
        <!-- <h1 class="mr-2"><?php echo $headingname; ?></h1> -->
        <ul>
            <li><a href="">Home</a></li>
            <li>Email Tracking</li>
        </ul>
    </div>
    <div class="card p-3">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-md-6 col-lg-3 ">
                    <div class="card card-block card-stretch card-height pb-2">
                        <div class="card-body">
                            <div class="top-block d-flex align-items-center justify-content-between">
                                <h5>Total Email Recieved</h5>
                                <span class="badge badge-primary">Total</span>
                            </div>
                            <br>
                            <h3><?php echo $total; ?></h3>


                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card card-block card-stretch card-height">
                        <div class="card-body">
                            <div class="top-block d-flex align-items-center justify-content-between">
                                <h5>Email In Progress</h5>
                                <span class="badge badge-warning">In Progress</span>
                            </div>
                            <h3><span class="counter"><?php echo $progress; ?></span></h3>
                            <div class="d-flex align-items-center justify-content-between mt-1">
                                <p class="mb-0">Total Progress</p>
                                <span class="text-warning"><?php echo $progress1; ?>%</span>
                            </div>
                            <div class="iq-progress-bar bg-warning-light mt-2">
                                <span class="bg-warning iq-progress progress-1" data-percent="<?php echo $progress1; ?>"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card card-block card-stretch card-height">
                        <div class="card-body">
                            <div class="top-block d-flex align-items-center justify-content-between">
                                <h5>Info Only Email</h5>
                                <span class="badge badge-danger">Info Only</span>
                            </div>
                            <h3><span class="counter"><?php echo $info; ?></span></h3>
                            <div class="d-flex align-items-center justify-content-between mt-1">
                                <p class="mb-0">info only</p>
                                <span class="text-danger"><?php echo $info1; ?>%</span>
                            </div>
                            <div class="iq-progress-bar bg-danger-light mt-2">
                                <span class="bg-danger iq-progress progress-1" data-percent="<?php echo $notstart1; ?>"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card card-block card-stretch card-height">
                        <div class="card-body">
                            <div class="top-block d-flex align-items-center justify-content-between">
                                <h5>Email Closed-off</h5>
                                <span class="badge badge-success">Completed</span>
                            </div>
                            <h3><span class="counter"><?php echo $done; ?></span></h3>
                            <div class="d-flex align-items-center justify-content-between mt-1">
                                <p class="mb-0">Total Progress</p>
                                <span class="text-success"><?php echo $done1; ?>%</span>
                            </div>
                            <div class="iq-progress-bar bg-success-light mt-2">
                                <span class="bg-success iq-progress progress-1" data-percent="<?php echo $done1; ?>"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


    </div>

    <div class="row mb-12 my-4">
        <div class="col-md-12 mb-12">
            <div class="card text-left" style="margin-top:1%;">
                <div class="card-body">
                    <h3>Email Tracking</h3>
                    <div class="row pr-4 mb-3" style="float:right">
                        <a href="admin.php?id=1"><button class="btn btn-success" style=" margin-left:15px">Go
                                Back</button></a>

                        <a href="admin.php?id=email_tracking_add"><button class="btn btn-info"
                                style="float:right; margin-left:15px">Add</button></a>

                    </div>
                    <h4 class="card-title mb-3"></h4>
                    <div class="table-responsive" id="basket">
                        <table class=" table table-striped table-bordered text-center" id="zero_configuration_table">
                            <thead>



                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Ticket</th>
                                    <th>Subject</th>
                                    <th>Email</th>
                                    <th>Company</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th>Comment</th>
                                    <th>View</th>


                                    <!-- <th>view</th> -->

                                </tr>
                            </thead>
                            <tbody>


                                <?php

                                $sql = mysqli_query($con, "SELECT * FROM `tblemailtrack` order by date desc");
                                $i = 0;
                                while ($row = mysqli_fetch_array($sql)) {
                                    $i++;




                                ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $row['date']; ?></td>
                                        <td><?php echo $row['tcode'] ?></td>
                                        <td><?php echo $row['subject'] ?></td>
                                        <td><?php echo $row['cemail'] ?></td>
                                        <td><?php echo $row['company'] ?></td>
                                        <td><?php echo $row['priority'] ?></td>

                                        <td class="text-center">
                                            <?php

                                            $statuses = explode(',', $row['status']);
                                            foreach ($statuses as $status) {
                                                $status = trim($status);
                                                if ($status == 'Completed') {
                                            ?>
                                                    <button class="btn form-control" style="background-color:#1d6109; margin:2px;">
                                                        <i class="fa fa-tags" style="font-size:20px;color:white;"></i>
                                                        <span style="font-size:15px;color:white;">Task Completed</span>
                                                    </button>
                                                <?php
                                                } else {
                                                    if ($status == 'AM Informed') {
                                                        $color = '#df8e64';
                                                    } elseif ($status == 'Email Read by') {
                                                        $color = '#dac257';
                                                    } elseif ($status == 'Email to be followed') {
                                                        $color = '#4170b9';
                                                    } elseif ($status == 'Info Only') {
                                                        $color = '#b7d667';
                                                    } elseif ($status == 'Task Pending') {
                                                        $color = '#fdee65';
                                                    } else {
                                                        $color = '#f264d2';
                                                    }
                                                ?>
                                                    <a href="admin?id=email_followup&view=<?php echo $row['id'] ?>">
                                                        <button class="btn " style="background-color:<?php echo $color; ?>; margin:2px;">
                                                            <i class="fa fa-tags" style="font-size:20px;"></i>
                                                            <span style="font-size:15px;"><?php echo htmlspecialchars($status); ?></span>
                                                        </button>

                                                    </a>
                                                    <br>
                                            <?php
                                                }
                                            }
                                            ?>


                                        </td>
                                        <td><?php echo $row['comment'] ?></td>
                                        <td> <a href="admin?id=email_view&view=<?php echo $row['id'] ?>"><button
                                                    class="btn btn-info">view</button></a></td>


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
    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>