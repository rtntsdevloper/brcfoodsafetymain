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
         <h1 class="mr-2"><?php echo $headingname; ?></h1>
         <ul>
             <li><a href="">Dashboard</a></li>
             <li>Home</li>
         </ul>
     </div>


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
         <div class="col-lg-3 col-md-6 col-sm-6">
             <a href='admin.php?id=sectionadditionalview&ssid=<?php echo $ssid; ?>'>
                 <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                     <div class="card-body text-center "><i class="fa fa-list" style="font-size:54px; color:#E81766"></i>
                         <div class="content">
                             <p class="text-muted mt-2 mb-0">Additional </p>
                             <p class="text-primary text-22 line-height-1 mb-2">Management</p>
                         </div>
                     </div>
                 </div>
             </a>
         </div>

     </div>
 </div>