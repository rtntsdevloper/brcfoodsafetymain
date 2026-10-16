<?php
$sid = $_GET['sid'];
$nc = "SELECT s1.auditdate as auditdate, s1.auditor as auditor,s1.auditee as auditee,s2.fid as clause,s2.ans as ans,s2.status as status,s2.title as ncdesc,s2.action as actionr,s2.deliver as deliver,s2.id as id,s1.id as sno from saveaudit as s2 join tblroster as s1 on s1.id =s2.sno WHERE s2.id = $sid";
$nc1 = mysqli_query($con, $nc);
$row1 = mysqli_fetch_array($nc1);


$auditee = mysqli_query($con, "select * from tblauditee where id='$row1[auditee]'");
$auditee1 = mysqli_fetch_array($auditee);
$auditeen = $auditee1["name"];


$auditor = mysqli_query($con, "select * from tblauditor where id='$row1[auditor]'");
$auditor1 = mysqli_fetch_array($auditor);
$auditorn = $auditor1["name"];

$rootcause = mysqli_query($con,"SELECT * FROM `tblrootcause` WHERE sno ='$sid'");
$rootcause1 = mysqli_fetch_array($rootcause);


$rootaction = mysqli_query($con,"SELECT * FROM `tblaction` WHERE sno ='$sid'");
$rootaction1 = mysqli_fetch_array($rootaction);
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

                        <a href="admin.php?id=viewnclog"><button class="btn btn-primary mb-3"
                                style="float:right; margin-left:15px">Go Back</button></a>


                        <h4 class="card-title mb-3">Internal Audit Nc Log Detail</h4>
                        <!-- <p>List of staff</p> -->
                        <table class="display table table-striped table-bordered table-hover" id="zero_configuration_table"
                            style="width:100%">

                            <tr>
                                <th>Date</th>
                                <td><?php echo date("d-m-Y", strtotime($row1['auditdate'])); ?></td>
                            </tr>
                            <tr>
                                <th>Clause</th>
                                <td><?php echo $row1['clause']; ?></td>
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
                                    $auditdate = new DateTime($row1['auditdate']);
                                    $deliverydate = new DateTime($row1['deliver']);
                                    $interval = $auditdate->diff($deliverydate);
                                    echo $interval->days . " days";


                                    ?>




                                </td>
                            </tr>
                            <tr>
                                <th>Description of the Non-Conformance</th>
                                
<td><?php echo $row1['ncdesc']; ?></td>
                            </tr>

                            <tr>
                                <th>Type of Non-Conformance (Minor/ Major/ Critical)</th>
                                <td><?php echo $row1['ans']; ?></td>
                            </tr>
                            <tr>
                                <th>Action Required</th>
                                <td><?php echo $row1['actionr']; ?></td>
                            </tr>
                            <tr>
                                <th>Findings Root Cause Analysis</th>
                                <td>
                                    Y1 <?php echo $rootcause1['root1']; ?><br>
                                    Y2 <?php echo $rootcause1['root2']; ?><br>
                                    Y3 <?php echo $rootcause1['root3']; ?><br>
                                    <?php if(!empty($rootcause1['root4'])){
                                        ?>
  Y4 <?php echo $rootcause1['root4']; ?><br>
                                        <?php
                                    }
                                    if(!empty($rootcause1['root5'])){
                                        ?>
 Y5 <?php echo $rootcause1['root5']; ?><br>
                                        <?php
                                    }
                                    ?>
                                  
                                   
                                    
                                
                               </td>
                               </tr>


                               <tr>
                                <th>Corrective action taken by Auditee</th>
                                <td><?php echo $rootaction1['corrective']; ?></td>
                            </tr>
                            </tr>
 <tr>
                                <th>Preventive action</th>
                                <td><?php echo $rootaction1['preventive']; ?></td>
                            </tr> <tr>
                                <th>Verification activity</th>
                                <td><?php echo $rootaction1['cmnt']; ?></td>
                            </tr>
                            <tr>
                                <th>Verification Date</th>
                                <td><?php if(!empty($rootaction1['date'])) { echo date('d-m-Y',strtotime($rootaction1['date'])); } ?></td>
                            </tr>
                            <tr>
                                <th>Completion Date</th>
                                <td><?php if(!empty($rootaction1['date1'])) { echo date('d-m-Y',strtotime($rootaction1['date1'])); } ?></td>
                            </tr> <tr>
                                <th>NC investigated </th>
                                <td><?php if (!empty($rootaction1['img'])) {
                                        echo "Yes";
                                    } else {
                                        echo "No";
                                    } ?></td>
                            </tr>
                            <tr>
                                <th>NC closed off </th>
                                <td><?php if($row1['status']=='Accepted') { echo "Yes"; } else { echo "No"; } ?></td>
                            </tr>
                                            
                                            
<tr>
                                <th>Non-Conformance Link </th>
                                <td><a href="admin.php?id=ncview&sno=<?php echo $row1['sno']; ?>" target="_blank" rel="noopener noreferrer">Nc View</a></td>
                            </tr>




                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>