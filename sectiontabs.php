 <?php
    $ssid = $_GET['ssid'];


    $sql = mysqli_query($con, "select * from subtest where id = '$ssid'");
    $row = mysqli_fetch_array($sql);

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
         <!-- <div class="col-lg-3 col-md-6 col-sm-6">
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
         </div> -->

         <div class="col-lg-6 col-md-12">
          <div class="card">
            <div class="card-body">
              <div class="card-title">General Compliance <a href="admin.php?id=brccompliance"><button class="btn btn-danger" style="float:right">View</button></a></div>
              <div class="ul-widget-app__browser-list">
                <?php
                $sql = mysqli_query($con, "select * from addtest1 where status2='active'");
                $i = 0;
                while ($rows = mysqli_fetch_array($sql)) {
                  $i++;
                ?>
                  <a href="admin.php?id=brccompliance"> <button class="btn btn-<?php echo $rows['bgcolor']; ?> btn-rounded m-1" type="button" style=" color:#FFFFFF;background:<?php echo $rows['bgcolor']; ?>">
                      <?php echo $i; ?>.&nbsp;&nbsp;<?php echo $rows['subject']; ?></button> </a>

                <?php
                }
                ?>
              </div>
            </div>
          </div>
        </div>


     </div>
 </div>