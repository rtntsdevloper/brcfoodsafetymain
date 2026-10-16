<?php
$pro = $_GET['pro'];
$sid = $_GET['sid'];

$sdq = mysqli_query($con,"SELECT * FROM `product_specification` WHERE id='$sid'");
$sdq1 = mysqli_fetch_array($sdq);

$specx = mysqli_query($con, "SELECT * FROM `save_specification3` WHERE `id` = '$pro'");
$specx1 = mysqli_fetch_array($specx);
$prodid = $specx1['pid'];
$sqxarr =[];
$sqx= "SELECT * FROM `save_specification4` WHERE pro ='$pro' and sid='$sid'";
$sqx1 = mysqli_query($con,$sqx);
$sqxn1 = mysqli_num_rows($sqx1 );
if($sqxn1 > 0){
$sqx2 = mysqli_fetch_array($sqx1);
$sqxid = $sqx2['id'];

$sqxarr = explode(';',$sqx2['spec']);
}



if($sdq1['addition'] =='ex'){
    $producop = mysqli_query($con, "SELECT * FROM `save_specification_m`");

}else{
$producop = mysqli_query($con, "SELECT * FROM `save_specification` WHERE sid='$sid' and pid='$prodid'");
}



?>
<div class="main-content">

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-title">Add Specification </div>
                                <a href="admin.php?id=prodspec2&pro=<?= $pro ?>"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                            </div>
                        </div>


                        <form name="form1" method="post" enctype="multipart/form-data">
                            <div class="form-row">

                                <?php
                                foreach ($producop as $prodata) {
                                ?>
                                    <div class="col-md-4">
                                        <label><input type="checkbox" name="checknm[]" value="<?= $prodata['id'] ?>" <?php
                                        if(in_array($prodata['id'],$sqxarr)){echo "checked";}
                                        
                                        ?>> <span style="font-size:medium;"><?= $prodata['name'] ?></span></label>
                                    </div>

                                <?php
                                }
                                ?>
                            </div>



                            <br />

                            <button class="btn btn-success" type="submit" name="submit">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['submit'])) { 
    $checknm = $_POST['checknm'];

    $checknmx = implode(';',$checknm);
  
if($sqxn1 > 0){
 $sqx ="Update  `save_specification4` set `spec`='$checknmx' where id='$sqxid'";
}else{
 $sqx ="INSERT INTO `save_specification4`(`pro`, `sid`, `spec`) VALUES ('$pro','$sid','$checknmx')";
}
   

    $sqx1 = mysqli_query($con,$sqx) ;
    if($sqx1){
        ?>
        <script>
            window.location.href="admin.php?id=prodspec2&pro=<?= $pro ?>"
        </script>

        <?php
    }


}



?>