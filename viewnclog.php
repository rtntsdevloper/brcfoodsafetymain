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


                        <h4 class="card-title mb-3">Internal Audit Nc Log <?php echo $cyear; ?></h4>


                        <div class="row">
                            <div class="col-md-12 ml-3">
                                <div class="form-group" style="text-align:center;">
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
                                            $year = mysqli_query($con, "SELECT DISTINCT year(date) as cyear FROM `tblroster`");
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
                                window.location.href = "admin.php?id=viewnclog&year=" + year;

                            }
                        </script>
                       
                        <!-- <p>List of staff</p> -->

                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered" id="zero_configuration_table"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sr. no</th>
                                        <th>Date</th>
                                        <th>Ref no</th>
                                        <th>Clause</th>
                                        <th>Raise By</th>
                                        <th>Raise To</th>
                                        <th>Description of Nc</th>
                                        <th>Type of Nc</th>
                                        <th>Action Required</th>
                                        <th>Duration</th>
                                        <th>Status</th>
                                        <th>View</th>



                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = mysqli_query($con, "SELECT s1.auditdate as auditdate, s1.auditor as auditor,s1.auditee as auditee,s2.fid as clause,s2.status as status,s2.ans as ans,s2.title as ncdesc,s2.action as actionr,s2.deliver as deliver,s2.id as id from saveaudit as s2 join tblroster as s1 on s1.id =s2.sno WHERE (ans ='Major' || ans='Minor') and year(s1.auditdate) = '$cyear' order by s1.auditdate asc");
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

                                    ?>
                                        <tr>
                                            <th scope="row"><?php echo $i; ?></th>
                                            <!-- <td ></td> -->
                                            <td><?php

                                                echo date("d-m-Y", strtotime($row1['auditdate'])); ?></td>
                                            <td><?php
                                                if ($i <= 9) {
                                                    $ix = "0" . $i;
                                                } else {
                                                    $ix = $i;
                                                }
                                                echo "NC" . $ix;

                                                ?>





                                            </td>
                                            <td><?php echo $row1['clause']; ?></td>
                                            <td><?php echo $auditorn; ?></td>
                                            <td><?php echo $auditeen; ?></td>


                                            <td><?php echo $row1['ncdesc']; ?></td>
                                            <td><?php echo $row1['ans']; ?></td>
                                            <td><?php echo $row1['actionr']; ?></td>

                                            <td>
                                                <?php
                                                $auditdate = new DateTime($row1['auditdate']);
                                                $deliverydate = new DateTime($row1['deliver']);
                                                $interval = $auditdate->diff($deliverydate);
                                                echo $interval->days . " days";


                                                ?>




                                            </td>
                                            <td><?php echo $row1['status']; ?></td>
                                            <td><a href="admin.php?id=viewnclog1&sid=<?php echo $row1['id']; ?>"><i class="fa fa-eye" style="font-size:20px"></i></a></td>

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