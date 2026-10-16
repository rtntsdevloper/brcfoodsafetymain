<?php
$pro = $_GET['pro'];
$sid = $_GET['sid'];

$spq = mysqli_query($con,"SELECT * FROM `product_specification` WHERE id='$sid'");
$sprow = mysqli_fetch_array($spq);
?>
<div class="main-content">
   
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Add Specification (<?php echo $sprow['name']; ?>)</div>
                        <a href="admin.php?id=productspec2&pro=<?php echo $pro; ?>&sid=<?php echo $sid; ?>"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>

                        <form name="form1" class="needs-validation" novalidate="novalidate" method="post" action="" enctype="multipart/form-data">
                            <div class="form-row">
                               
                            <?php
                            // if($sprow['nmselect']=='Yes'){

                                $sqx = mysqli_query($con,"SELECT * FROM `product_specification1` WHERE `main` = '$sid'");
                                $srx = mysqli_fetch_array($sqx);

                                $sqxl = mysqli_query($con,"select * FROM `save_specification` WHERE pid ='$pro' and sid ='$sid'");
                                $secarry = [];
                               foreach($sqxl as $sqll){
                                   $secarry[] = $sqll['spid'];
                               }
                              
                                ?>
                                <div class="col-md-6">
                                    <label for="validationTooltip01">Section Name</label>
                                    <select name="sectname" class="form-control" id="sectname" required>
                                        <option value="">Please Select</option>
                                        <?php
                                        foreach($sqx as $srx){
                                            $srxid = $srx['id'];
                                            if(in_array($srxid,$secarry)){
                                                $sdis = 'disabled';
                                                $sstyle = 'background-color:#e9ecef';
                                            }else{
                                                $sdis='';
                                                $sstyle='';
                                            }
                                            ?>
                                            <option value="<?php echo $srx['id']; ?>" <?php echo $sdis; ?> style="<?php echo $sstyle; ?>" ><?php echo $srx['name']; ?></option>
                                            <?php
                                        }
                                        ?>
                                        

                                    </select>

                                    <div class="invalid-tooltip">
                                        Please provide a valid name.
                                    </div>
                                </div>





                                <?php

                            //use if if need to remove select
                            
                        //}
                            
                            // else{

                                ?>
                                <!-- <div class="col-md-6">
                                    <label for="validationTooltip01">Section Name</label>
                                    <input type="text" name="sectname" id="" class="form-control"  required>
                                   
                                </div> -->
                                <?php
                            // }
                            ?>






                            </div>



                            <br />

                            <button class="btn btn-success" type="submit" name="submit1">Save & Next</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if(isset($_POST['submit1'])){
    //  if ($sprow['nmselect'] == 'Yes') {
    
        $sectid = $_POST['sectname'];
        $sqx = mysqli_query($con, "SELECT * FROM `product_specification1` WHERE `id` = '$sectid'");
        $srx = mysqli_fetch_array($sqx);
        echo $sectname = $srx['name'];


    // } else {
    //     $sectname = $_POST['sectname'];

    //     $sqx = mysqli_query($con, "SELECT * FROM `product_specification1` WHERE `main` = '$sid'");
    //     $srx = mysqli_fetch_array($sqx);
    //     $sectid = $srx['id'];

    // }

    $datex = date('Y-m-d H:i:s');


    $uqsl = mysqli_query($con, "SELECT * FROM `save_specification`");
    $uqslid = mysqli_num_rows($uqsl);

    if($uqslid<10){
       $zx = '000';
    }elseif($uqslid<100 && $uqslid>10){
        $zx = '00';
    }elseif($uqslid<1000 && $uqslid>100){
        $zx = '0';
    }

    $unnid = "PS".rand(100,999).$zx.$uqslid;
   
    $sqlx = mysqli_query($con, "INSERT INTO `save_specification`(`name`, `sid`, `pid`, `user`, `dateon`,`spid`,`uniid`) VALUES ('$sectname','$sid','$pro','$user','$datex','$sectid','$unnid')");
    $sqlxid = mysqli_insert_id($con);

    if ($sqlx) {
        ?>

        <script>
       
        window.location.href = "admin.php?id=productspecadd1&pro=<?php echo $sqlxid; ?>";
        </script>
    
    <?php
        
    }
}
    

?>
