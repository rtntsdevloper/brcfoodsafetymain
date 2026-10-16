<?php
$tid = $_GET['tid'];
?>
<div class="main-content">
    <div class="breadcrumb">

        <ul>
            <li><a href="">Storage Temperature Management</a></li>
            <li>Add Storage Temperature</li>
        </ul>
    </div>


    <div class="col-md-12">
        <div class="card">
            <div class="card-body">


                <a href="admin.php?id=date&tid=<?php echo $tid; ?>"><button class="btn btn-success"
                        style="float:right; margin-left:15px">Go
                        Back</button></a>
                <div class="row">
                    <table border="1" cellpadding="" width="50%" class="table ">
                        <tr style=" color:black;">
                            <th width="20%">Spec</th>
                            <th width="30%">Action must be taken at warning level</th>
                            <td rowspan="3" width="50%">Temperature need to be checked every 4 hours.
                                Any warning level should be recorded and monitor within 30min, if there is still warning
                                level or critical limit action need to be taken and Supervisor/Manager need to be
                                informed immediately

                            </td>

                        </tr>
                        <tr>
                            <td width="20%">Freezer: -18<sup>o</sup>C</td>
                            <th width="30%">>-18<sup>o</sup>C </th>

                        </tr>
                        <tr>
                            <td width="20%">Chiller: 0 - 5<sup>o</sup>C</td>
                            <th width="30%"> >5<sup>o</sup> C</th>

                        </tr>
                    </table>
                </div>
                <div class="card-title">Add <?php

                $sql = mysqli_query($con, "SELECT * FROM tbltemp where id='$tid' ");
                $row = mysqli_fetch_array($sql);
                echo $sname = $row['name'];


                ?> Temperature</div>
                <?php
                if (isset($_GET['msg'])) {
                    ?>
                    <div class="card-title" style="color:#FF0000">Customer already exist</div>
                    <?php
                }
                ?>
                <form class="needs-validation" novalidate="novalidate" method="post" action=""
                    enctype="multipart/form-data">

                    <!-- <div class="col-md-4 mb-3">
                            <label for="validationTooltip01"> Section</label>
                            <input type="text" name="section" class="form-control" value=" -->



                    <div class="form-row ">
                        <div class="col-md-6">
                            <label for="validationTooltip01"> Date </label>
                            <input type="date" name="date" class="form-control" required />
                        </div>

                        <div class="col-md-6">
                            <label for="validationTooltip01"> Time</label>
                            <input type="time" name="time" class="form-control" required />
                        </div>


                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Temperature</label>
                            <input type="number" class="form-control" name="temprature">

                            <div class="invalid-tooltip">
                                Please provide a valid Address

                            </div>

                        </div>




                        <div class="col-md-6">
                            <label for="validationTooltip01"> Enter Your Name</label>
                            <input type="text" name="name" class="form-control" required />
                        </div>
                        <div class="col-md-6">
                            <label for="validationTooltip01"> Area</label>
                            <input type="text" name="area" class="form-control" required />
                        </div>


                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02"><?php echo $sname ?></label>

                            <select name="subsection" class="form-control" required>
                                <option value="">Please Select</option>
                                <?php
                                $tid = $_GET['tid'];
                                $sql = mysqli_query($con, "select * from tbltemp1 where tid='$tid'");
                                while ($row = mysqli_fetch_array($sql)) {
                                    ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['subsection']; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <div class="invalid-tooltip">
                                Please provide a valid Contact

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Comment</label>
                            <?php
                            if ($tid == 1) {
                                echo ' <input type="text" class="form-control" name="comment">';
                            } elseif ($tid == 2) {
                                echo ' <input type="text" class="form-control" name="comment1">';
                            }
                            ?>
                            <div class="invalid-tooltip">
                                Please provide a valid Address

                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit" name="submit">Submit </button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php
if (isset($_POST['submit'])) {
    $section = $sname;
    $subsection = $_POST['subsection'];
    $temprature = $_POST['temprature'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $name = $_POST['name'];
    $area = $_POST['area'];
    $tid = $_GET['tid'];

    if ($tid == 1) {
        $comment = $_POST['comment'];
    } elseif ($tid == 2) {
        $comment1 = $_POST['comment1'];
    }

    $sql = mysqli_query($con, "INSERT INTO `tbltemp2` ( `section`, `subsec`, `temp`,`name`,`date`,`area`, `time`, `tid`,`comment`,`comment1`) VALUES ( '$section', '$subsection', '$temprature','$name','$date','$area', '$time', '$tid', '$comment', '$comment1')");

    ?>
    <script language="javascript">
        alert('added');
        window.open('admin?id=date&tid=<?php echo $tid; ?>', '_self');
    </script>
    <?php
}

?>