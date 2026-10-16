<?php
$dategr = $_GET['date'];
$dateg = date('Y-m-d', strtotime($dategr));
?>

<div class="main-content">

    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <a href="admin.php?id=atpresult"><button class="btn btn-success"
                            style="float:right; margin-left:15px">Go
                            Back</button></a>





                    <h4 class="card-title mb-3">Atp Result Trending</h4>

                    <!-- <p>Listt of complaints</p> -->

                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">S no.</th>
                                    <th scope="col">Location</th>
                                    <th scope="col">Result</th>
                                    <!-- <th scope="col">Caution</th>
                                    <th scope="col">Total</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $data = mysqli_query($con, "SELECT * FROM `tblatp` Where DATE_FORMAT(date, '%Y-%m-%d') ='$dateg'");
                                $i = 1;
                                foreach ($data as $datav) {
                                ?>
                                    <tr>
                                        <td scope="col"><?php echo $i; ?></td>
                                        <td scope="col"><?php echo $datav['location']; ?></th>
                                        <td scope="col"><?php echo $datav['result']; ?></th>
                                            <!-- <td scope="col"><?php echo $ccaution; ?></th>
                                    <td scope="col"><?php echo $ctotal; ?></th> -->
                                    </tr>
                                <?php

                                    $i++;
                                }


                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php
$comp = array();
$category = mysqli_query($con, "SELECT * FROM `tblatp`  GROUP BY result");

foreach ($category as $catv) {

    $catname = $catv['result'];


    $donequery = mysqli_query($con, "SELECT 
                                            DATE_FORMAT(date, '%Y-%m-%d') AS complaint_day,
                                            COUNT(*) AS total_complaints
                                        FROM 
                                           `tblatp`
                                        WHERE 
                                            result='$catname' AND DATE_FORMAT(date, '%Y-%m-%d') ='$dateg'
                                       ");



    $dom = mysqli_fetch_array($donequery);

    $donen = mysqli_num_rows($donequery);

    if ($donen > 0) {
        $compv = $dom['total_complaints'];
    } else {
        $compv = '0';
    }

    $comp[$catname] = $compv;
}

$cpass = $comp['Pass'];
$ccaution = $comp['Caution'];
$cfail = $comp['Fail'];
$ctotal  = $cpass + $cfail + $ccaution;

?>

<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
<style>
    .canvasjs-chart-credit {
        display: none !important;
    }

    #chartContainer {
        height: 300px;
        width: 80%;
        margin: 20px auto;
    }
</style>

<div id="chartContainer"></div>

<script>
    window.onload = function() {
        var dataPoints = [{
                label: "Pass",
                y: <?php echo $cpass; ?>,
                color: "#4CAF50"
            },
            {
                label: "Fail",
                y: <?php echo $cfail; ?>,
                color: "#F44336"
            },
            {
                label: "Caution",
                y: <?php echo $ccaution; ?>,
                color: "#FFC107"
            },
            {
                label: "Total",
                y: <?php echo $ctotal; ?>,
                color: "#40E0D0"
            }
        ];

        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            title: {
                text: "ATP Result Summary <?php echo date('d-m-Y', strtotime($dateg)); ?>"
            },
            axisY: {
                title: "Count",
                includeZero: true,
                interval: "auto",
                valueFormatString: "#0", // This forces whole numbers only
                minimum: 0,
                labelFormatter: function(e) {
                    // Ensure only whole numbers are displayed
                    return e.value % 1 === 0 ? e.value : "";
                }
            },
            data: [{
                type: "column",
                indexLabel: "{y}",
                indexLabelPlacement: "outside",
                indexLabelFontWeight: "bold",
                dataPoints: dataPoints
            }]
        });

        chart.render();
    }
</script>