<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a style="text-decoration: none;" href="">Procedure Management</a></li>
            <li>View Detail</li>
        </ul>

    </div>
    <div class="col-md-12">
        <a href="admin.php?id=additionalmanage" class="btn btn-primary" style="float: right;">Go Back</a>
    </div>
</div>

<?php
$ssid = $_GET['ssid'];

$catid = isset($_GET['catid']) ? intval($_GET['catid']) : 0;
if ($catid <= 0) {
    echo '<h3>Invalid category.</h3>';
    exit;
}
$sqlcat = mysqli_query($con, "SELECT * FROM tblcat WHERE id='$catid'");
$cat = mysqli_fetch_array($sqlcat);
if (!$cat) {
    echo '<h3>Category not found.</h3>';
    exit;
}
$rowid = $cat['name'];
// $headingname = $cat['name1']; // Set heading from category
?>


<div class="table-responsive mt-4">
    <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 12%;">Type</th>

                <th style="width: 10%;">Issue Date</th>
                <th style="width: 10%;">Version</th>
                <th style="width: 5%;">Authorised By</th>
                <th style="width: 23%;">Doc</th>
                <th style="width: 7%;">Clause</th>
                <th style="width: 5%;">View</th>

            </tr>
        </thead>
        <tbody>
            <?php
            $sql23 = mysqli_query($con, "SELECT * FROM tbldetail WHERE typee!='archive' AND sid='$ssid' AND typee ='$rowid'and category!='Multiple'");
            $i = 1;
            while ($row23 = mysqli_fetch_array($sql23)) {
                $hj = mysqli_query($con, "SELECT * FROM subtest WHERE sid='{$row23['sid']}'");
                $hj1 = mysqli_fetch_array($hj);
            ?>

                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo ($row23['typee'] == 'original' || $row23['typee'] == 'Original') ? 'Additional Documents' : $row23['typee']; ?></td>
                    <!-- <td>(<?php echo $hj1['tid']; ?>)<br /> <?php echo $hj1['subtest']; ?></td>
                            <td>(<?php echo $hj1['sid']; ?>) <br /><?php echo $row23['section']; ?></td> -->
                    <td><?php echo ($row23['issuedate'] != '0000-00-00') ? date('d-m-Y', strtotime($row23['issuedate'])) : ''; ?></td>
                    <td><?php echo $row23['ver']; ?></td>
                    <td><?php echo $row23['authrisedby']; ?></td>
                    <td><a style="text-decoration: none;  ;" href="document/<?php echo $row23['img']; ?>" target="_blank"><?php echo $row23['img']; ?></a></td>
                    <td><?php echo $row23['fid']; ?></td>
                    <td>

                        <a href="#" class='modalButton btn btn-info' data-target="#new-task-modal1" data-toggle="modal" data-qid='<?php echo $row23['id']; ?>' data-pid='<?php echo $clause; ?>'>
                            View</a>
                    </td> <!-- view link -->


                </tr>
            <?php $i++;
            }
            $sql24 = mysqli_query($con, "SELECT DISTINCT sid,section,img FROM `tbldetail` WHERE category='Multiple' and typee!='archive'AND typee ='$rowid'");

            while ($row24 = mysqli_fetch_array($sql24)) {
                $clause = "";
                $my24 = mysqli_query($con, "select * from tbldetail where sid='$row24[sid]' and category='Multiple' and typee!='archive'and section='$row24[section]'AND typee ='$rowid'");
                foreach ($my24 as $data24) {
                    if (empty($clause)) {
                        $clause = $data24['fid'];
                    } else {
                        $clause = $clause . ", " . $data24['fid'];
                    }
                }
                $hjx = mysqli_query($con, "select * from subtest where sid='$row24[sid]'");
                $hjx1 = mysqli_fetch_array($hjx);

            ?>

                <tr>
                    <td><?php echo $i; ?></td>
                    <td>

                        <?php
                        if ($data24['typee'] == "original" || $data24['typee'] == "Original") {
                            echo "Additional Documents";
                        } else {
                            echo $data24['typee'];
                        }
                        ?></td>


                    <td>
                        <?php
                        if ($data24['issuedate'] != '0000-00-00') {
                            echo date('d-m-Y', strtotime($data24['issuedate']));
                        }
                        ?>
                    </td>

                    <td><?php echo $data24['ver']; ?></td>
                    <td><?php echo $data24['authrisedby']; ?></td>

                    <td><a href="document/<?php echo $row24['img']; ?>" target="_blank"><?php echo $row24['img']; ?></a></td>
                    <td><?php echo $clause; ?></td>
                    <td>

                        <a href="#" class='modalButton btn btn-info' data-target="#new-task-modal1" data-toggle="modal" data-qid='<?php echo $data24['id']; ?>'>
                            View</a>
                    </td>


                </tr>
            <?php
                $i++;
            }

            ?>
        </tbody>
    </table>
</div>
<!-- <a href="aditionalmanage.php" class="btn btn-secondary mt-3">Back to All Categories</a> -->


<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    $('.modalButton').click(function() {
        var qid = $(this).attr('data-qid');
        var pid = $(this).attr('data-pid');


        $.ajax({
            url: "viewfile.php?qid=" + qid,
            cache: false,
            success: function(result) {
                $("#modal-body2").html(result);
            }
        });
    });
</script>

<div class="modal fade bd-example-modal-lg" role="dialog" aria-modal="true" id="new-task-modal1">
    <div class="modal-dialog  modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header d-block text-center pb-3 border-bttom">
                <h3 class="modal-title" id="exampleModalCenterTitle">Document Details</h3>

            </div>

            <div id="modal-body2">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>