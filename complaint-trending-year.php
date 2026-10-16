<?php
if (isset($_POST['submit'])) {
    $cyear = $_POST['fyear'];
    $cyear1 = $_POST['syear'];

} else {
    $cyear = date("Y");
    $cyear1 = $cyear - 1;
}


$riskstr = '' . $cyear . '-01,' . $cyear . '-02,' . $cyear . '-03,' . $cyear . '-04,' . $cyear . '-05,' . $cyear . '-06,' . $cyear . '-07,' . $cyear . '-08,' . $cyear . '-09,' . $cyear . '-10,' . $cyear . '-11,' . $cyear . '-12';

$compraw = explode(',', $riskstr);


$riskstr1 = '' . $cyear1 . '-01,' . $cyear1 . '-02,' . $cyear1 . '-03,' . $cyear1 . '-04,' . $cyear1 . '-05,' . $cyear1 . '-06,' . $cyear1 . '-07,' . $cyear1 . '-08,' . $cyear1 . '-09,' . $cyear1 . '-10,' . $cyear1 . '-11,' . $cyear1 . '-12';

$compraw1 = explode(',', $riskstr1);


$month1 = "SELECT DATE_FORMAT(compdate, '%Y') AS compyear FROM `tblnewcomplaint` GROUP BY compyear";
$month1y = mysqli_query($con, $month1);

// Query for done complaints
?>
<style>
    .canvasjs-chart-credit {
    display: none !important;
}
</style>
<div class="main-content">
    <form method="post">
        <div class="card text-left mb-3">
            <div class="card-body">
                <div class="row " >

                    <div class="col-md-5 col-sm-6">
                        <div class="form-group">
                            <label>Select First Date</label>

                            <select name="fyear" class="form-control">
                                <?php
                                echo '<option value="' . $cyear . '">' . $cyear . '</option>';

                                foreach ($month1y as $dcmnth) {
                                    echo '<option value="' . $dcmnth['compyear'] . '">' . $dcmnth['compyear'] . '</option>';
                                }
                                ?>


                            </select>
                        </div>

                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="form-group">
                            <label>Select Second Date</label>

                            <select name="syear" class="form-control">
                                <?php
                                echo '<option value="' . $cyear . '">' . $cyear1 . '</option>';

                                foreach ($month1y as $dcmnth) {
                                    echo '<option value="' . $dcmnth['compyear'] . '">' . $dcmnth['compyear'] . '</option>';
                                }
                                ?>


                            </select>
                        </div>


                    </div>
                    <div class="col-md-2  col-sm-6">
                        <button type="submit" name="submit"
                            class="btn btn-primary form-control bg-primary text-white mt-4">Submit</button>
                    </div>

                </div>
            </div>
            </div>
    </form>
















    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">
                    <a href="admin.php?id=complaintmgmt"><button class="btn btn-success"
                            style="float:right; margin-left:15px">Go
                            Back</button></a>
                    <a href="admin.php?id=complaint-trending"><button class="btn btn-success"
                            style="float:right; margin-left:15px">Complaint Trending</button></a>



                    <script>
                        $('#datayear').on('change', function () {
                            var selectedValue = $(this).val();


                            window.open('admin?id=complaint-trending&dyear=' + selectedValue, '_self');
                        });
                    </script>
                    <h4 class="card-title mb-3">Customer Complaint Trending YOY</h4>

                    <p>List of complaints</p>

                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">Category</th>
                                    <th scope="col">January</th>
                                    <th scope="col">Feburary</th>
                                    <th scope="col">March</th>
                                    <th scope="col">April</th>
                                    <th scope="col">May</th>
                                    <th scope="col">June</th>
                                    <th scope="col">July</th>
                                    <th scope="col">August</th>
                                    <th scope="col">September</th>
                                    <th scope="col">October</th>
                                    <th scope="col">November</th>
                                    <th scope="col">December</th>
                                    <th>Total</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $comp = array();
                                $comp1 = array();


                                foreach ($compraw as $keyy => $valuey) {


                                    $donequery = mysqli_query($con, "SELECT 
                                            DATE_FORMAT(compdate, '%Y-%m') AS complaint_month,
                                            COUNT(*) AS total_complaints
                                        FROM 
                                            tblnewcomplaint
                                        WHERE 
                                             DATE_FORMAT(compdate, '%Y-%m') ='$valuey'
                                        GROUP BY 
                                            complaint_month");


                                    $dom = mysqli_fetch_array($donequery);

                                    $donen = mysqli_num_rows($donequery);

                                    if ($donen > 0) {
                                        $compv = $dom['total_complaints'];
                                    } else {
                                        $compv = '0';
                                    }

                                    $comp[$valuey] = $compv;


                                }

                                foreach ($compraw1 as $key1 => $value1) {


                                    $donequery1 = mysqli_query($con, "SELECT 
                                            DATE_FORMAT(compdate, '%Y-%m') AS complaint_month,
                                            COUNT(*) AS total_complaints
                                        FROM 
                                            tblnewcomplaint
                                        WHERE 
                                             DATE_FORMAT(compdate, '%Y-%m') ='$value1'
                                        GROUP BY 
                                            complaint_month");


                                    $dom1 = mysqli_fetch_array($donequery1);

                                    $donen1 = mysqli_num_rows($donequery1);

                                    if ($donen1 > 0) {
                                        $compv1 = $dom1['total_complaints'];
                                    } else {
                                        $compv1 = '0';
                                    }

                                    $comp1[$value1] = $compv1;


                                }
                               



                                ?>
                                <tr>
                                    <th scope="row"><?php echo $cyear; ?></th>
                                    <td><?php echo $comp[$cyear . '-01']; ?> </td>
                                    <td><?php echo $comp[$cyear . '-02']; ?> </td>
                                    <td><?php echo $comp[$cyear . '-03']; ?> </td>
                                    <td><?php echo $comp[$cyear . '-04']; ?> </td>
                                    <td><?php echo $comp[$cyear . '-05']; ?> </td>
                                    <td><?php echo $comp[$cyear . '-06']; ?> </td>
                                    <td><?php echo $comp[$cyear . '-07']; ?> </td>
                                    <td><?php echo $comp[$cyear . '-08']; ?> </td>
                                    <td><?php echo $comp[$cyear . '-09']; ?> </td>
                                    <td><?php echo $comp[$cyear . '-10']; ?> </td>
                                    <td><?php echo $comp[$cyear . '-11']; ?> </td>
                                    <td><?php echo $comp[$cyear . '-12']; ?> </td>
                                    <td><?php echo array_sum($comp); ?> </td>


                                </tr>
                                <tr>
                                    <th scope="row"><?php echo $cyear1; ?></th>
                                    <td><?php echo $comp1[$cyear1 . '-01']; ?> </td>
                                    <td><?php echo $comp1[$cyear1 . '-02']; ?> </td>
                                    <td><?php echo $comp1[$cyear1 . '-03']; ?> </td>
                                    <td><?php echo $comp1[$cyear1 . '-04']; ?> </td>
                                    <td><?php echo $comp1[$cyear1 . '-05']; ?> </td>
                                    <td><?php echo $comp1[$cyear1 . '-06']; ?> </td>
                                    <td><?php echo $comp1[$cyear1 . '-07']; ?> </td>
                                    <td><?php echo $comp1[$cyear1 . '-08']; ?> </td>
                                    <td><?php echo $comp1[$cyear1 . '-09']; ?> </td>
                                    <td><?php echo $comp1[$cyear1 . '-10']; ?> </td>
                                    <td><?php echo $comp1[$cyear1 . '-11']; ?> </td>
                                    <td><?php echo $comp1[$cyear1 . '-12']; ?> </td>
                                    <td><?php echo array_sum($comp1); ?> </td>


                                </tr>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>









</div>









<?php


// Generate all months from January to December
$allMonths = array();
$currentYear = $cyear;
$previousYear = $cyear1;

for ($i = 1; $i <= 12; $i++) {
    $month = str_pad($i, 2, '0', STR_PAD_LEFT);
    $allMonths[] = $previousYear . '-' . $month; // Previous year months
}

// Prepare data for chart (January to December)
$currentYearPoints = array();
$previousYearPoints = array();


for ($i = 1; $i <= 12; $i++) {
    $monthNum = str_pad($i, 2, '0', STR_PAD_LEFT);
    $monthName = date("M", strtotime($cyear . '-' . $monthNum));
    
    $currentMonthKey = $cyear . '-' . $monthNum;
    $previousMonthKey = $cyear1 . '-' . $monthNum;
    
    // Get current year data
    $currentY = isset($comp[$currentMonthKey]) ? (int)$comp[$currentMonthKey] : 0;
    
    // Get previous year data
    $previousY = isset($comp1[$previousMonthKey]) ? (int)$comp1[$previousMonthKey] : 0;
    
    $currentYearPoints[] = [
        "label" => $monthName,
        "y" => $currentY
    ];
    
    $previousYearPoints[] = [
        "label" => $monthName,
        "y" => $previousY
    ];
}
?>


<script>
window.onload = function () {
    var chart = new CanvasJS.Chart("chartContainer", {
        animationEnabled: true,
        exportEnabled: true,
        theme: "light1",
        title: {
            text: "Monthly Complaints Comparison (<?php echo $previousYear; ?> vs <?php echo $currentYear; ?>)"
        },
        axisX: {
            title: "Month",
            interval: 1
        },
        axisY: {
            title: "Number of Complaints",
            includeZero: true
        },
        toolTip: {
            shared: true
        },
        legend: {
            cursor: "pointer",
            itemclick: toggleDataSeries
        },
        data: [
            {
                type: "column",
                name: "Current Year (<?php echo $currentYear; ?>)",
                showInLegend: true,
                indexLabel: "{y}",
                indexLabelPlacement: "outside",
                color: "#369EAD",
                dataPoints: <?php echo json_encode($currentYearPoints, JSON_NUMERIC_CHECK); ?>
            },
            {
                type: "column",
                name: "Previous Year (<?php echo $previousYear; ?>)",
                showInLegend: true,
                indexLabel: "{y}",
                indexLabelPlacement: "outside",
                color: "#C24642",
                dataPoints: <?php echo json_encode($previousYearPoints, JSON_NUMERIC_CHECK); ?>
            }
        ]
    });
    chart.render();
    function toggleDataSeries(e) {
        if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
            e.dataSeries.visible = false;
        } else {
            e.dataSeries.visible = true;
        }
        chart.render();
    }
}
</script>

<div id="chartContainer" style="height: 400px; mwidth: 100%;"></div>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>

