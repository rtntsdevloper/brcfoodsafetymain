 <?php
    $ssid = $_GET['ssid'];


    $sql = mysqli_query($con, "select * from subtest where id = '$ssid'");
    $row = mysqli_fetch_array($sql);
    $ssid = $row['sid'];

    $sectiontabs = $row['tabs'];
    $sectiontabs1 = explode(";", $sectiontabs);
    $string = $sectiontabs;
    $array = explode(";", $string);

    $secarray = array_intersect($sectiontabs1, $array);



    ?>

 <div class="main-content">
     <div class="breadcrumb">
         <h1 class="mr-2">Section <?php echo $ssid; ?> (<?php echo $row['subtest']; ?>)</h1>



     </div>
     <div class="ul-widget-app__browser-list">
         <?php
            $sql = mysqli_query($con, "SELECT * FROM `subtest1` WHERE sid='$ssid'");
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
                 <a href="admin.php?id=sectionadditionalview&ssid=<?php echo $rows['ssid']; ?>&sfid=<?php echo $ssid; ?>"> <button class="btn btn-rounded m-1 " type="button" style="font-size: 16px; color:#FFFFFF;background:rgba(<?php echo $r1; ?>, <?php echo $r2; ?>, <?php echo $r3; ?>,1)">
                         Clause <?php echo $rows['ssid']; ?></button> </a>
             <?php
                } else {
                ?>
                 <a href="admin.php?id=sectionadditionalview&fid=<?php echo $rows['fid']; ?>&sfid=<?php echo $ssid; ?>"> <button class="btn btn-rounded m-1 " type="button" style="font-size: 16px; color:#FFFFFF;background:rgba(<?php echo $r1; ?>, <?php echo $r2; ?>, <?php echo $r3; ?>,1)">
                         Clause <?php echo $rows['fid']; ?></button> </a>
             <?php
                }
                ?>


         <?php
            }
            ?>
     </div>
     <br>




     <div class="separator-breadcrumb border-top"></div>
     <div class="row">
         <!-- ICON BG-->
         <?php


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
 </div>