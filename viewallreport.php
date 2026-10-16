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
            $string = $tabs;
            $array = explode(";", $string);
            $data = array();
            foreach ($array as $arr) {
                $sq = mysqli_query($con, "select * from tbltabs where sno='$arr' and status='report'");
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