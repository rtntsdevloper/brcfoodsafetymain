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
        $gh = mysqli_query($con, "select * from dailychecks");
        while ($row = mysqli_fetch_array($gh)) {
            if (!empty($row['url'])) {
        ?>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <a href="<?= $row['url'] ?>&tid=<?php echo $row['id']; ?>">
                        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                            <div class="card-body text-center "><i class="fa fa-list" style="font-size:54px; color:#10C5AA"></i>
                                <div class="content">
                                    <p class="text-muted mt-2 mb-0"><?php echo $row['name']; ?></p>

                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php
            } else {
            ?>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <a href="admin.php?id=dailychecks&tid=<?php echo $row['id']; ?>">
                        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                            <div class="card-body text-center "><i class="fa fa-list" style="font-size:54px; color:#10C5AA"></i>
                                <div class="content">
                                    <p class="text-muted mt-2 mb-0"><?php echo $row['name']; ?></p>

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