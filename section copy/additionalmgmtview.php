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
$ssid = $_GET['ssid'];
$qsd = mysqli_query($con,"SELECT * FROM `tblcat`");
foreach($qsd as $tdata){?>

<div class="col-lg-3 col-md-6 col-sm-6">
            <a href="admin.php?id=sectionadditional&type=<?php echo $tdata['name']; ?>&ssid=<?php echo $ssid; ?>">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center"><i class="fa fa-list" style="font-size:54px; color:#E81766"></i>
                        <div class="content">
                            <p class="text-muted mt-2 mb-0"><?php echo $tdata['name1']; ?></p>
                            <!-- <p class="text-primary text-22 line-height-1 mb-2">Document</p> -->
                        </div>
                    </div>
                </div>
            </a>
        </div>

<?php

}
?>
       
    </div>
</div>