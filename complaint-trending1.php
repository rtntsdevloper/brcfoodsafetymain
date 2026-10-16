<?php
// Database connection
if (isset($_GET['dyear'])) {
    $cyear = $_GET['dyear'];

} else {
    $cyear = date("Y");
}

$riskstr = '' . $cyear . '-01,' . $cyear . '-02,' . $cyear . '-03,' . $cyear . '-04,' . $cyear . '-05,' . $cyear . '-06,' . $cyear . '-07,' . $cyear . '-08,' . $cyear . '-09,' . $cyear . '-10,' . $cyear . '-11,' . $cyear . '-12';

$compraw = explode(',', $riskstr);
;


// Query for done complaints
?>

<div class="main-content">

    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <a href="admin.php?id=complaintmgmt"><button class="btn btn-success"
                            style="float:right; margin-left:15px">Go
                            Back</button></a>
                    <a href="admin.php?id=complaint-trending-year"><button class="btn btn-success"
                            style="float:right; margin-left:15px">Year-On-Year Trending</button></a>
                    <select name="" id="datayear">
                        <?php
                        echo '<option value="' . $cyear . '">' . $cyear . '</option>';
                        $month1 = "SELECT DATE_FORMAT(compdate, '%Y') AS compyear FROM `tblnewcomplaint` GROUP BY compyear";
                        $month1y = mysqli_query($con, $month1);

                        foreach ($month1y as $dcmnth) {
                            echo '<option value="' . $dcmnth['compyear'] . '">' . $dcmnth['compyear'] . '</option>';
                        }
                        ?>


                    </select>


                    <script>
                        $('#datayear').on('change', function () {
                            var selectedValue = $(this).val();


                            window.open('admin?id=complaint-trending&dyear=' + selectedValue, '_self');
                        });
                    </script>
                    <h4 class="card-title mb-3">Customer Complaint Trending</h4>

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
                                $category = mysqli_query($con, "SELECT distinct product FROM `tblnewcomplaint`");
                                foreach ($category as $catv) {
                                    $catname = $catv['product'];
                                    foreach ($compraw as $keyy => $valuey) {


                                        $donequery = mysqli_query($con, "SELECT 
                                            DATE_FORMAT(compdate, '%Y-%m') AS complaint_month,
                                            COUNT(*) AS total_complaints
                                        FROM 
                                            tblnewcomplaint
                                        WHERE 
                                            product='$catname' AND DATE_FORMAT(compdate, '%Y-%m') ='$valuey'
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


                                    ?>
                                    <tr>
                                        <th scope="row"><?php echo $catv['product']; ?></th>
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
                                    <?php
                                }
                                $comp1 = array();
                                foreach ($compraw as $ke => $valu) {

                                    $donq = "SELECT DATE_FORMAT(compdate, '%Y-%m') AS complaint_month,COUNT(*) AS total_complaints FROM `tblnewcomplaint` WHERE  DATE_FORMAT(compdate, '%Y-%m') ='$valu'";
                                    $donq1 = mysqli_query($con, $donq);
                                    $dond = mysqli_fetch_array($donq1);
                                    $dondn = mysqli_num_rows($donq1);
                                    if ($dondn > 0) {
                                        $compvl = $dond['total_complaints'];
                                    } else {
                                        $compvl = '0';
                                    }
                                    $comp1[$valu] = $compvl;
                                }


                                ?>
                                <tr>
                                    <th scope="row">Total</th>
                                    <td><?php echo $comp1[$cyear . '-01']; ?> </td>
                                    <td><?php echo $comp1[$cyear . '-02']; ?> </td>
                                    <td><?php echo $comp1[$cyear . '-03']; ?> </td>
                                    <td><?php echo $comp1[$cyear . '-04']; ?> </td>
                                    <td><?php echo $comp1[$cyear . '-05']; ?> </td>
                                    <td><?php echo $comp1[$cyear . '-06']; ?> </td>
                                    <td><?php echo $comp1[$cyear . '-07']; ?> </td>
                                    <td><?php echo $comp1[$cyear . '-08']; ?> </td>
                                    <td><?php echo $comp1[$cyear . '-09']; ?> </td>
                                    <td><?php echo $comp1[$cyear . '-10']; ?> </td>
                                    <td><?php echo $comp1[$cyear . '-11']; ?> </td>
                                    <td><?php echo $comp1[$cyear . '-12']; ?> </td>
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


<style>
    .canvasjs-chart-credit {
        display: none !important;
    }
</style>


<?php
$compgr = array();
$catg = array();
$category = mysqli_query($con, "SELECT distinct product FROM `tblnewcomplaint`");
foreach ($category as $catv) {
    $catname = $catv['product'];
    $catg[] = $catname;

    foreach ($compraw as $keyy => $valuey) {
        $donequery = mysqli_query($con, "SELECT 
                                        DATE_FORMAT(compdate, '%Y-%m') AS complaint_month,
                                        COUNT(*) AS total_complaints
                                    FROM 
                                        tblnewcomplaint
                                    WHERE 
                                        product='$catname' AND DATE_FORMAT(compdate, '%Y-%m') ='$valuey'
                                    GROUP BY 
                                        complaint_month");

        $dom = mysqli_fetch_array($donequery);
        $donen = mysqli_num_rows($donequery);

        if ($donen > 0) {
            $compv1 = $dom['total_complaints'];
        } else {
            $compv1 = '0';
        }

        $compgr[$catname][$valuey] = $compv1;
    }
}
?>
<script>
    window.onload = function () {
        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            title: {
                text: "Complaints by Products"
            },
            axisX: {
                title: "Month",
                valueFormatString: "MMM YYYY",  // Changed format to show abbreviated month and year
                interval: 1,  // Ensure all months are shown
                labelAngle: 0,  // Rotate labels for better readability
                intervalType: "month"  // Treat as monthly data
            },
            axisY: {
                title: "Number of Complaints",
                includeZero: true
            },
            legend: {
                cursor: "pointer",
                fontSize: 16,
                itemclick: toggleDataSeries
            },
            toolTip: {
                shared: true,
                contentFormatter: function (e) {
                    var content = CanvasJS.formatDate(e.entries[0].dataPoint.x, "MMM YYYY") + "<br/>";
                    e.entries.forEach(function (entry) {
                        content += entry.dataSeries.name + ": " + entry.dataPoint.y + "<br/>";
                    });
                    return content;
                }
            },
            data: [
                <?php
                foreach ($catg as $datac => $valc) {
                    ?>
                                                                                {
                        name: "<?php echo $valc; ?>",
                        type: "column",
                        showInLegend: true,
                        dataPoints: [
                            <?php
                            foreach ($compgr[$valc] as $dtkey => $dtval) {
                                $yearMonth = explode('-', $dtkey);
                                $year = $yearMonth[0];
                                $month = $yearMonth[1];
                                ?>
                                                                                                                                                        {
                                    x: new Date(<?php echo $year; ?>, <?php echo ($month - 1); ?>, 1),
                                    y: <?php echo $dtval; ?>
                                },
                                <?php
                            }
                            ?>
                        ]
                    },
                    <?php
                }
                ?>
            ]
        });
        chart.render();

        function toggleDataSeries(e) {
            if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                e.dataSeries.visible = false;
            } else {
                e.dataSeries.visible = true;
            }
            chart.render();
        }
    }
</script>

<div id="chartContainer" style="height: 500px; width: 100%;" class="my-5"></div>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>