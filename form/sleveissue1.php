<?php
include('connection.php');
$sno = $_GET['sno'];
?>
<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>Sleeve Issue</li>
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=sleveissue"><button class="btn btn-success mb-2" style="float:right; margin-left:15px">Go
                        Back</button></a>

         

                <div class="card-title"> </div>



                <div class="table-responsive">
                    <table class="display table table-striped table-bordered" id="zero_configuration_table"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">Sr No.</th>
                                <th scope="col">Is the correct product sleeve and coding used as per the product? </th>
                                <th>Time</th>
                                <th>Is the correct product sleeve being used ?</th>
                                <th>Comments</th>
                                <th scope="col">Checked by</th>
                                <th scope="col">Image</th>


                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $q = mysqli_query($con, "SELECT   * FROM `sleveissue1` where sno='$sno' ");

                            foreach ($q as $row) {
                                $i++;

                                ?>
                                <tr>
                                    <th scope="row"><?php echo $i; ?></th>
                                    <td><?php echo $row['sleeve'] ?></td>
                                    <td><?php echo $row['time']; ?></td>
                                    <td><?php echo $row['sleeveissue']; ?></td>
                                    <td><?php echo $row['comments']; ?></td>
                                    <td><?php echo $row['checkedby']; ?></td>
                                    <td>
                                        <img src="form/upl1/<?php echo $row['frontimage']; ?>" alt="Front Image" height="120px"
                                            width="140px" style="margin-right:10px;"><br><br>
                                        <img src="form/upl1/<?php echo $row['backimage']; ?>" alt="Back Image" height="120px"
                                            width="140px">
                                    </td>


                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>