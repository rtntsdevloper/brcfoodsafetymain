<?php
if (isset($_GET["year"])) {
    $cyear = $_GET["year"];
} else {
    $cyear = date('Y');
}




?>
<div class="main-content">
    <div class="breadcrumb">

        <ul>
            <li><a href="">Home</a></li>
            <li>Nc Log</li>
        </ul>
    </div>
    <div class="container-fluid " style="margin-top:50px;">
        <div class="row mb-12">
            <div class="col-md-12 mb-12">
                <div class="card text-left">
                    <div class="card-body">

                    <a href="admin.php?id=1"><button class="btn btn-primary mb-3"
                                style="float:right; margin-left:15px">Go Back</button></a>


                        <h4 class="card-title mb-3">GMP Audit Nc Log <?php echo $cyear; ?></h4>
                        <!-- <p>List of staff</p> -->


                        <div class="row">
                            <div class="col-md-12 ml-3">
                                <div class="form-group" style="text-align:center;font-size:16px;">
                                    <div class="btn-group" role="group">
                                        <!-- All Complaints Button -->
                                        <a href="admin.php?id=viewnclog" class="btn btn-outline-primary filter-btn <?php if ($_GET['id'] == 'viewnclog') echo 'active'; ?>">Internal Audit</a>

                                        <!-- Gluten Free Button -->

                                        <a href="admin.php?id=viewnclogg" class="btn btn-outline-primary filter-btn <?php if ($_GET['id'] == 'viewnclogg') echo 'active'; ?>">GMP Audit</a>


                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 col-sm-6">
                                <form method="post">
                                    <div class="form-group">

                                        <select name="xcyear" onchange="datashow(this.value)" class="form-control">
                                            <option selected disabled>Select Year</option>
                                            <?php
                                            $year = mysqli_query($con, "SELECT DISTINCT year(date) as cyear FROM `tblgmpaudit2`");
                                            foreach ($year as $row) {
                                                if ($row['cyear'] == $cyear) {
                                                    echo "<option value='" . $row['cyear'] . "' selected>" . $row['cyear'] . "</option>";
                                                } else {
                                                    echo "<option value='" . $row['cyear'] . "'>" . $row['cyear'] . "</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <script>
                            function datashow(year) {
                                window.location.href = "admin.php?id=viewnclogg&year=" + year;

                            }
                        </script>

                        

                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered" id="zero_configuration_table"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sr. no</th>
                                        <th>Date</th>
                                        <th>Ref no</th>
                                        <th>Section</th>
                                        <th>Raise By</th>
                                        <th>Raise To</th>

                                        <th>Type of Nc</th>
                                        <th>Comment</th>
                                        <th>Action Required</th>
                                        <th>Duration</th>
                                        <th>Status</th>
                                        <th>View</th>



                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $querid = mysqli_query($con, "SELECT * FROM `tblauditsection` where name ='GMP Audit'");
                                    foreach ($querid as $rowq) {
                                        $sqid = $rowq['id'];
                                        $sql = mysqli_query($con, "SELECT s2.id,s1.date, s1.auditor,s1.auditee,s2.deliver,s1.audit,s2.ans,s2.status,s2.cmnt,s2.action,s1.sid FROM tblgmpaudit2 as s1 join tblgmpaudit3 as s2 ON s2.sno = s1.id where s1.audit ='$sqid' and (s2.ans ='Major' || s2.ans ='Minor') and year(s1.date) ='$cyear' order by s1.date asc;");
                                        $i = 0;
                                        // while (($y = mysqli_fetch_array($sql))&&(($z = mysqli_fetch_array($sql2))))  {
                                        while ($row1 = mysqli_fetch_array($sql)) {
                                            $i++;
                                            $auditee = mysqli_query($con, "select * from tblauditee where id='$row1[auditee]'");
                                            $auditee1 = mysqli_fetch_array($auditee);
                                            $auditeen = $auditee1["name"];


                                            $auditor = mysqli_query($con, "select * from tblauditor where id='$row1[auditor]'");
                                            $auditor1 = mysqli_fetch_array($auditor);
                                            $auditorn = $auditor1["name"];

                                            $auditsection = mysqli_query($con, "SELECT * FROM `tblauditsection1` WHERE id='$row1[sid]'");
                                            $auditsection1 = mysqli_fetch_array($auditsection);
                                            $sectionname = $auditsection1["name"];

                                    ?>
                                            <tr>
                                                <th scope="row"><?php echo $i; ?></th>
                                                <!-- <td ></td> -->
                                                <td><?php

                                                    echo date("d-m-Y", strtotime($row1['date'])); ?></td>
                                                <td><?php
                                                    if ($i <= 9) {
                                                        $ix = "0" . $i;
                                                    } else {
                                                        $ix = $i;
                                                    }
                                                    echo "NC" . $ix;

                                                    ?>





                                                </td>
                                                <td><?php echo  $sectionname; ?></td>
                                                <td><?php echo $auditorn; ?></td>
                                                <td><?php echo $auditeen; ?></td>


                                                <td><?php echo $row1['ans']; ?></td>
                                                <td><?php echo $row1['cmnt']; ?></td>
                                                <td><?php echo $row1['action']; ?></td>

                                                <td>
                                                    <?php
                                                    $auditdate = new DateTime($row1['date']);
                                                    $deliverydate = new DateTime($row1['deliver']);
                                                    $interval = $auditdate->diff($deliverydate);
                                                    echo $interval->days . " days";


                                                    ?>




                                                </td>
                                                <td><?php echo $row1['status']; ?></td>
                                                <td><a href="admin.php?id=viewnclogg1&sid=<?php echo $row1['id']; ?>"><i class="fa fa-eye" style="font-size:20px"></i></a></td>

                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>