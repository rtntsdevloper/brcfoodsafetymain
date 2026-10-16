<?php

$sfid = $_GET['sfid'];
?>

<div class="main-content">

    <div class="breadcrumb">

        <h1 class="mr-2"><?php echo $headingname; ?></h1>

        <ul>

            <li><a style="text-decoration: none;" href="">Document Management</a></li>

            <li>View Detail</li>

        </ul>



    </div>
    <div class="ul-widget-app__browser-list px-3">
        <?php
        $sql = mysqli_query($con, "SELECT * FROM `subtest1` WHERE sid='$sfid'");
        $i = 0;
        while ($rows = mysqli_fetch_array($sql)) {
            $r1 = rand(0, 160);
            $r2 = rand(0, 170);
            $r3 = rand(0, 200);

            $i++;
        ?>
            <?php
            if (!empty($rows['ssid'])) {
            ?>
                <a href="admin.php?id=sectionadditionalview&ssid=<?php echo $rows['ssid']; ?>&sfid=<?php echo $sfid; ?>"> <button class="btn btn-rounded m-1 " type="button" style="font-size: 16px; color:#FFFFFF;background:rgba(<?php echo $r1; ?>, <?php echo $r2; ?>, <?php echo $r3; ?>,1)">
                        Clause <?php echo $rows['ssid']; ?></button> </a>
            <?php
            } else {
            ?>
                <a href="admin.php?id=sectionadditionalview&fid=<?php echo $rows['fid']; ?>&sfid=<?php echo $sfid; ?>"> <button class="btn btn-rounded m-1 " type="button" style="font-size: 16px; color:#FFFFFF;background:rgba(<?php echo $r1; ?>, <?php echo $r2; ?>, <?php echo $r3; ?>,1)">
                        Clause <?php echo $rows['fid']; ?></button> </a>
            <?php
            }
            ?>


        <?php
        }
        ?>
    </div>
    <div class="col-md-12 mb-5">

        <a href="admin.php?id=1" class="btn btn-primary" style="float: right;">Go Back</a>

    </div>

</div>



<?php

if (isset($_GET['fid'])) {
    $fid = $_GET['fid'];
    $fsdc = mysqli_query($con, "SELECT * FROM subtest1 WHERE fid='$fid'");

    $fsdc1 = mysqli_fetch_array($fsdc);
}


if (isset($_GET['ssid'])) {
    $fid = $_GET['ssid'];
    $fsdc = mysqli_query($con, "SELECT * FROM subtest1 WHERE ssid='$fid'");
    $fsdc1 = mysqli_fetch_array($fsdc);
}








?>



<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo $fsdc1['inter']; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>
<div class="row p-3 m-3" style="border: 1px solid #ccc;background-color:aliceblue;">
    <div class="col-md-9 col-lg-10">
        <h3 class="text-dark"><b>Clause <?php echo $fid; ?></b></h3>
    </div>
    <div class="col-md-3 col-lg-2 text-right"><button type="button" class="btn btn-warning" data-toggle="modal" data-target="#staticBackdrop">
            View Interpretation
        </button></div>
    <div class="col-md-12 mt-3">

        <h5 class="text-dark"> <?php echo $fsdc1['clause']; ?></h5>

    </div>
</div>
<hr>


<?php
$sql23 = mysqli_query($con, "SELECT * FROM tbldetail WHERE typee!='archive' AND fid='$fid'");
$sqln23 = mysqli_num_rows($sql23);

if($sqln23>0){

?>


<div class="table-responsive mt-4  py-5">

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



                        <a href="#" class='modalButton btn btn-info' data-target="#new-task-modal1" data-toggle="modal" data-qid='<?php echo $row23['id']; ?>'>

                            View</a>

                    </td> <!-- view link -->





                </tr>

            <?php $i++;
            }

            ?>

        </tbody>

    </table>

</div>

<?php
}
?>

<!-- <a href="aditionalmanage.php" class="btn btn-secondary mt-3">Back to All Categories</a> -->


<hr>

<?php
if (!empty($fsdc1['tabs'])) {
?>


    <div class="row p-3 m-3" style="background-color:aliceblue;border: 1px solid #ccc;">

        <div class="col-md-12 mb-3">
            <h3>Clause Relevant Tabs</h3>
        </div>

        <!-- ICON BG-->
        <?php

        $secarray = explode(';', $fsdc1['tabs']);

        foreach ($secarray as $arr) {
            $sq = mysqli_query($con, "select * from tbltabs where sno='$arr'");
            while ($qr = mysqli_fetch_array($sq)) {

        ?>

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <a href='<?php echo $qr['weblink']; ?>'>
                        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                            <div class="card-body text-center "><i class="fa fa-list" style="font-size:54px; color:<?php echo $qr['color']; ?>"></i>
                                <div class="content">
                                    <p class="text-muted mt-2 mb-0"><?php echo $qr['name']; ?></p>
                                    <p class="text-primary text-22 line-height-1 mb-2"><?php echo $qr['name1']; ?></p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
        <?php
            }
        }
        ?>

    </div>
<?php
}


?>








<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script>
    $('.modalButton').click(function() {

        var qid = $(this).attr('data-qid');







        $.ajax({

            url: "section/viewfile.php?qid=" + qid,

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



            <div id="modal-body2" class="col-md-12">



            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

            </div>

        </div>

    </div>