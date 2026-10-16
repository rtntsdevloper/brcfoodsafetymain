
<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Dashboard</a></li>
            <li>Home</li>
        </ul>
    </div>


    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h3 style="float: left;">Frying  Record </h3>
                <a href="admin.php?id=addcookingtemp"><button type="submit" class="btn btn-primary pl-3 pr-3"
                        style="float:right;"> Add </button></a>
                <a href="admin?id=1"><button type="submit" class="btn btn-success pl-3 pr-3" style="float:right;">
                        Back </button></a> <br> <br>
                <div class="row">


                    <!-- <a href="viewcookingtempdetails"><button type="submit" class="btn  btn-info"
            style="float:right;">View</button></a> -->
                    <div class="col-lg-12" id="table-responsive">

                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered text-center"
                                id="zero_configuration_table" style="width:100%">
                                <thead>
                                    <tr class="ligth">


                                        <th>Date</th>


                                        <th>view</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $dateQuery = mysqli_query($con, "SELECT Distinct gdate as sdate  FROM tblcookingtemp ORDER BY gdate DESC");
                                    $i = 1;

                                    while ($dateRow = mysqli_fetch_assoc($dateQuery)) {
                                        $formattedDate = date("d/m/Y", strtotime($dateRow['sdate']));
                                        echo '
            
            
            <tr>
          

            
                <td>' . $formattedDate . '</td>
                <td>
                    <a href="admin.php?id=cookingpdf&date=' . $dateRow['sdate'] . '" class="btn btn-sm btn-primary">
                        View
                    </a>
                </td>
            </tr>';
                                    }
                                    ?>
                                </tbody>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>