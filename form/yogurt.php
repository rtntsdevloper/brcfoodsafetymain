<div class="main-content">

    <div class="row">
        <div class="col-md-8 col-sm-12">
            <div class="breadcrumb">
                <h1 class="mr-2"><?php echo $headingname; ?></h1>
                <ul>
                    <li><a href="">Dashboard</a></li>
                    <li>Home</li>
                </ul>
            </div>
        </div>
        <div class="col-md-4 col-sm-12"><input type="text" id="cardSearch" class="form-control form-control-lg"
                placeholder="Search Checks..."></div>
    </div>


    <div class="mb-4">
        <div class="row">
            <div class="col-md-8"></div>

        </div>

    </div>

    <div class="separator-breadcrumb border-top"></div>


    <!-- No results message -->
    <div id="noResults" class="alert alert-warning" style="display: none;">
        No cards match your search.
    </div>
    <div class="row" id="cardsContainer">


        <div class="col-lg-3 col-md-6 col-sm-12 card-item">
            <a href="admin.php?id=yogurt1">
                <div class="card card-icon-bg card-icon-bg-primary  mb-4">
                    <div class="card-body text-center ">
                        <div class="row">
                            <div class="col-md-4 text-center"><i class="fa fa-list" style="font-size:50px; color:#10C5AA"></i></div>
                            <div class="col-md-8">
                                <p class=" mt-2 mb-0 card-title text-center"> Yogurt Planning </p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12 card-item">
            <a href="admin.php?id=yogurtproduction">
                <div class="card card-icon-bg card-icon-bg-primary  mb-4">
                    <div class="card-body text-center ">
                        <div class="row">
                            <div class="col-md-4 text-center"><i class="fa fa-list" style="font-size:50px; color:#10C5AA"></i></div>
                            <div class="col-md-8">
                                <p class=" mt-2 mb-0 card-title text-center"> Production Record </p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>


        <div class="col-lg-3 col-md-6 col-sm-12 card-item">
            <a href="admin.php?id=yogurtpackaging">
                <div class="card card-icon-bg card-icon-bg-primary  mb-4">
                    <div class="card-body text-center ">
                        <div class="row">
                            <div class="col-md-4 text-center"><i class="fa fa-list" style="font-size:50px; color:#10C5AA"></i></div>
                            <div class="col-md-8">
                                <p class=" mt-2 mb-0 card-title text-center"> Packaging Record </p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>