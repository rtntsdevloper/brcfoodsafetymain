<?php
$sid = $_GET['sid'];
$nc = mysqli_query($con, "SELECT s1.id,s1.date, s1.auditor,s1.auditee,s2.deliver,s1.audit,s2.ans,s2.status,s2.cmnt,s2.action,s1.sid FROM tblgmpaudit2 as s1 join tblgmpaudit3 as s2 ON s2.sno = s1.id where s2.id ='$sid'");
$row1 = mysqli_fetch_array($nc);
$snox1 = $row1['id'];

$auditee = mysqli_query($con, "select * from tblauditee where id='$row1[auditee]'");
$auditee1 = mysqli_fetch_array($auditee);
$auditeen = $auditee1["name"];


$auditor = mysqli_query($con, "select * from tblauditor where id='$row1[auditor]'");
$auditor1 = mysqli_fetch_array($auditor);
$auditorn = $auditor1["name"];

$auditsection = mysqli_query($con, "SELECT * FROM `tblauditsection1` WHERE id='$row1[sid]'");
$auditsection1 = mysqli_fetch_array($auditsection);
$sectionname = $auditsection1["name"];

$rootaction = mysqli_query($con, "SELECT * FROM `tblaction1` WHERE sno ='$sid'");
$rootaction1 = mysqli_fetch_array($rootaction);
?>

<div class="main-content">
    <div class="breadcrumb">

        <ul>
            <li><a href="">Home</a></li>
            <li>GMP Audit Nc Log</li>
        </ul>
    </div>
    <div class="container-fluid " style="margin-top:50px;">
        <div class="row mb-12">
            <div class="col-md-12 mb-12">
                <div class="card text-left">
                    <div class="card-body">

                        <a href="admin.php?id=viewnclog"><button class="btn btn-primary mb-3"
                                style="float:right; margin-left:15px">Go Back</button></a>


                        <h4 class="card-title mb-3">GMP Audit Nc Log Detail</h4>
                        <!-- <p>List of staff</p> -->
                        <table class="display table table-striped table-bordered table-hover" id="zero_configuration_table"
                            style="width:100%">

                            <tr>
                                <th>Date</th>
                                <td><?php echo date("d-m-Y", strtotime($row1['date'])); ?></td>
                            </tr>
                            <tr>
                                <th>Section</th>
                                <td><?php echo $sectionname; ?></td>
                            </tr>
                            <tr>
                                <th>Raise By</th>
                                <td><?php echo $auditorn; ?></td>
                            </tr>
                            <tr>
                                <th>Raise To</th>
                                <td><?php echo $auditeen; ?></td>
                            </tr>
                            <tr>
                                <th>Duration</th>
                                <td>
                                    <?php
                                    $auditdate = new DateTime($row1['date']);
                                    $deliverydate = new DateTime($row1['deliver']);
                                    $interval = $auditdate->diff($deliverydate);
                                    echo $interval->days . " days";


                                    ?>




                                </td>
                            </tr>
                            <tr>
                                <th>Description of the Non-Conformance</th>

                                <td><?php echo $row1['cmnt']; ?></td>
                            </tr>

                            <tr>
                                <th>Type of Non-Conformance (Minor/ Major/ Critical)</th>
                                <td><?php echo $row1['ans']; ?></td>
                            </tr>
                            <tr>
                                <th>Action Required</th>
                                <td><?php echo $row1['action']; ?></td>
                            </tr>
                            <tr>
                                <th>Findings Root Cause Analysis</th>
                                <td>
                                    <?php $frxc = explode(';', $rootaction1['comment']); ?>
                                    <?php foreach ($frxc as $key => $FVvalue) {
                                        if (!empty($FVvalue)) {


                                    ?>
                                            <ul>
                                                <li>Root Cause <?php echo $key + 1; ?> : <?php echo $FVvalue; ?></li>
                                            </ul>
                                    <?php }
                                    }

                                    ?>
                                </td>
                            </tr>


                            <tr>
                                <th>Corrective action taken by Auditee</th>
                                <td><?php echo $rootaction1['corrective']; ?></td>
                            </tr>


                            <tr>
                                <th>Verification activity</th>
                                <td><?php echo $rootaction1['cmnt']; ?></td>
                            </tr>
                            <tr>
                                <th>Verification Date</th>
                                <td><?php if (!empty($rootaction1['date'])) {
                                        echo date('d-m-Y', strtotime($rootaction1['date']));
                                    } ?></td>
                            </tr>
                            <tr>
                                <th>Completion Date</th>
                                <td><?php if (!empty($rootaction1['date1'])) {
                                        echo date('d-m-Y', strtotime($rootaction1['date1']));
                                    } ?></td>
                            </tr>
                            <tr>
                                <th>NC investigated </th>
                                <td><?php if (!empty($rootaction1['img'])) {
                                        echo "Yes";
                                    } else {
                                        echo "No";
                                    } ?></td>
                            </tr>
                            <tr>
                                <th>NC closed off </th>
                                <td><?php if ($row1['status'] == 'Accepted') {
                                        echo "Yes";
                                    } else {
                                        echo "No";
                                    } ?></td>
                            </tr>


                            <tr>
                                <th>Non-Conformance Link </th>
                                <td><a href="admin.php?id=gmpnc1&sno=<?php echo $sid; ?>&sno1=<?php echo $snox1; ?>" target="_blank" rel="noopener noreferrer">Nc View</a></td>
                            </tr>




                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>