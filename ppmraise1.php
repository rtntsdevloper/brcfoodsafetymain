<style>
table.display {
  width: 100%;
  table-layout: fixed;
  border-collapse: collapse;
}

table.display th,
table.display td {
  width: 50%;               
  padding: 10px 12px;
  vertical-align: top;
  border: 1px solid #ddd;  
}

table.display th {
  background-color: #f8f9fa; 
  font-weight: 600;
}
</style>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>Equipment Maintenance Request</li>
        </ul>
    </div>
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <a href="admin.php?id=ppmraise">
                        <button class="btn btn-success mb-2" style="float:right; margin-left:15px">Go Back</button>
                    </a>
                    <h4 class="card-title mb-3">Equipment Maintenance Request</h4>

                    <?php
                    $sno = $_GET['sno'];
                    $sql = mysqli_query($con, "SELECT * FROM `ppmraise` WHERE id='$sno'");
                    $row2 = mysqli_fetch_array($sql);

                    $sql1 = mysqli_query($con, "SELECT * FROM `tblequipment` WHERE id='$row2[eqpname]'");
                    $row1 = mysqli_fetch_array($sql1);
                    $equipmentname = $row1['name'];
                    ?>

                    <!-- Request Details -->
                    <table class="display table table-striped table-bordered">
                        <tbody>
                            <tr><th>Request Number</th><td><?php echo $row2['request']; ?></td></tr>
                            <tr><th>Date Raised</th><td><?php echo date("d-m-Y", strtotime($row2['date'])); ?></td></tr>
                            <tr><th>Raised By</th><td><?php echo $row2['raisedby']; ?></td></tr>
                            <tr><th>Production Area</th><td><?php echo $row2['area']; ?></td></tr>
                            <tr><th>Equipment Name</th><td><?php echo $equipmentname; ?></td></tr>
                            <tr><th>Equipment ID</th><td><?php echo $row2['equipmentcode']; ?></td></tr>
                            <tr><th>Equipment Location</th><td><?php echo $row2['location']; ?></td></tr>
                        </tbody>
                    </table>

                    <h4 class="card-title mb-3">Maintenance Issue Details</h4>
                    <table class="display table table-striped table-bordered">
                        <tbody>
                            <tr><th>Description of Fault</th><td><?php echo $row2['fault']; ?></td></tr>
                            <tr><th>Priority Level</th><td><?php echo $row2['priority']; ?></td></tr>
                            <tr><th>Date & Time Issue Identified</th><td><?php echo date('d-m-Y h:i a', strtotime($row2['issuedate'])); ?></td></tr>
                            <tr><th>Equipment Status</th><td><?php echo $row2['eqpstatus']; ?></td></tr>
                        </tbody>
                    </table>

                    <h4 class="card-title mb-3">Completion Requirements</h4>
                    <table class="display table table-striped table-bordered">
                        <tbody>
                            <tr><th>Target Completion Date</th><td><?php echo date('d-m-Y', strtotime($row2['targetdate'])); ?></td></tr>
                            <tr><th>Maintenance Team Assigned</th><td><?php echo $row2['mteam']; ?></td></tr>
                            <tr>
                                <th>Supporting Documents (If any)</th>
                                <td>
                                    <?php
                                    if (!empty($row2['document'])) {
                                        echo '<a href="upl1/'.$row2['document'].'" target="_blank">View Attachment</a><br>';
                                        echo '<img src="upl1/'.$row2['document'].'" height="100">';
                                    } else {
                                        echo 'No document uploaded';
                                    }
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
