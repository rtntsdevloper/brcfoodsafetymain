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
        $pcrf = mysqli_query($con, "SELECT * FROM `tblcheck` where pid='hca' ");
        foreach ($pcrf as $prdata) {
        ?>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <a href="<?php echo $prdata['url']; ?>">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                        <div class="card-body text-center ">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-4 py-3"> <i class="fa fa-list" style="font-size:54px; color:#10C5AA"></i></div>
                                    <div class="col-md-8 py-3">
                                        <p class="text-muted mt-2 mb-0"><?php echo $prdata['name']; ?></p>
                                        <p class="text-primary text-22 line-height-1 mb-2"><?php echo $prdata['name1']; ?></p>
                                    </div>
                                </div>
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