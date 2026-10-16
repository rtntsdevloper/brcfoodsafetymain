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
        if ($access == "Admin") {
        ?> <div class="col-lg-3 col-md-6 col-sm-6">
                <a href="admin.php?id=amgmt">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                        <div class="card-body text-center "><i class="fa fa-users" style="font-size:54px; color:#10C5AA"></i>
                            <div class="content">
                                <p class="text-muted mt-2 mb-0">Admin</p>
                                <p class="text-primary text-22 line-height-1 mb-2">Management</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <a href="admin.php?id=viewallreport">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                        <div class="card-body text-center "><i class="fa fa-list" style="font-size:54px; color:#990000"></i>
                            <div class="content">
                                <p class="text-muted mt-2 mb-0">View</p>
                                <p class="text-primary text-22 line-height-1 mb-2">Details</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <a href="admin.php?id=psdtaskview">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                        <div class="card-body text-center "><i class="fa  fa-tasks" style="font-size:54px; color:#0F52BA"></i>
                            <div class="content">
                                <p class="text-muted mt-2 mb-0">Task</p>
                                <p class="text-primary text-22 line-height-1 mb-2">Management</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>



        <?php
        }
        ?>
    </div>


    <style>
        .canvasjs-chart-credit {
            display: none !important;
        }

        #chartcomplaint {
            height: 500px;
            width: 100%;
            margin: 2rem 0;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        #chartcomplaint:hover {
            transform: translateY(-2px);
        }
    </style>

    <?php
    $cyear = date("Y");
    $months = [];
    for ($i = 1; $i <= 12; $i++) {
        $months[] = $cyear . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);
    }

    $compgr = [];
    $catg = [];

    // Fetch all categories
    $category = mysqli_query($con, "SELECT * FROM `tblcategory`");
    $categoryData = [];
    while ($catv = mysqli_fetch_assoc($category)) {
        $categoryData[] = $catv;
    }

    // Prepare data for all categories in single query (more efficient)
    if (!empty($categoryData)) {
        $categoryNames = array_column($categoryData, 'name');
        $placeholders = implode("','", array_map(function ($cat) use ($con) {
            return mysqli_real_escape_string($con, $cat);
        }, $categoryNames));

        $baseQuery = "SELECT 
                category,
                DATE_FORMAT(compdate, '%Y-%m') AS complaint_month,
                COUNT(*) AS total_complaints
            FROM 
                tblnewcomplaint
            WHERE 
                category IN ('$placeholders')
                AND DATE_FORMAT(compdate, '%Y-%m') IN ('" . implode("','", $months) . "')";

        if (!empty($filter)) {
            $safeFilter = mysqli_real_escape_string($con, $filter);
            $baseQuery .= " AND catt = '$safeFilter'";
        }

        $baseQuery .= " GROUP BY category, complaint_month ORDER BY category, complaint_month";

        $result = mysqli_query($con, $baseQuery);

        // Initialize all categories and months with 0
        foreach ($categoryData as $cat) {
            $catname = $cat['name'];
            $catg[] = $catname;
            foreach ($months as $month) {
                $compgr[$catname][$month] = 0;
            }
        }

        // Update with actual values
        while ($row = mysqli_fetch_assoc($result)) {
            $compgr[$row['category']][$row['complaint_month']] = (int)$row['total_complaints'];
        }
    }
    ?>

    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Prepare chart data
            var chartData = [
                <?php
                $colors = [
                    '#FF6384',
                    '#36A2EB',
                    '#FFCE56',
                    '#4BC0C0',
                    '#9966FF',
                    '#FF9F40',
                    '#8AC926',
                    '#1982C4',
                    '#6A4C93',
                    '#F15BB5',
                    '#00BBF9',
                    '#00F5D4',
                    '#FF6B6B',
                    '#4ECDC4',
                    '#45B7D1'
                ];

                if (!empty($catg)) {
                    foreach ($catg as $index => $valc) {
                        $color = $colors[$index % count($colors)];
                ?> {
                            name: "<?php echo htmlspecialchars($valc, ENT_QUOTES); ?>",
                            type: "column",
                            showInLegend: true,
                            color: "<?php echo $color; ?>",
                            indexLabel: "{y}",
                            indexLabelFontSize: 11,
                            indexLabelFontColor: "darkgrey",
                            indexLabelPlacement: "outside",
                            dataPoints: [
                                <?php
                                foreach ($compgr[$valc] as $dtkey => $dtval) {
                                    $yearMonth = explode('-', $dtkey);
                                    $year = $yearMonth[0];
                                    $month = $yearMonth[1];
                                ?> {
                                        x: new Date(<?php echo $year; ?>, <?php echo ($month - 1); ?>, 1),
                                        y: <?php echo $dtval; ?>,
                                        label: "<?php echo date('M Y', mktime(0, 0, 0, $month, 1, $year)); ?>"
                                    },
                                <?php
                                }
                                ?>
                            ]
                        },
                    <?php
                    }
                } else {
                    // Show empty state if no data
                    ?> {
                        type: "column",
                        name: "No Data Available",
                        showInLegend: false,
                        color: "#cccccc",
                        dataPoints: [{
                            x: new Date(<?php echo $cyear; ?>, 0, 1),
                            y: 0,
                            label: "No complaints found"
                        }]
                    }
                <?php
                }
                ?>
            ];

            // Create and render chart
            var chart2 = new CanvasJS.Chart("chartcomplaint", {
                animationEnabled: true,
                exportEnabled: true,
                backgroundColor: "#fafafa",
                title: {
                    text: "Complaints by Category <?php echo !empty($filter) ? '- ' . htmlspecialchars($filter, ENT_QUOTES) : ''; ?>",
                    fontSize: 16,
                    fontWeight: "bold",
                    fontFamily: "Arial, sans-serif"
                },
                axisX: {
                    title: "Month",
                    valueFormatString: "MMM YYYY",
                    interval: 1,
                    labelAngle: -45,
                    intervalType: "month",
                    labelFontSize: 11
                },
                axisY: {
                    title: "Number of Complaints",
                    includeZero: true,
                    labelFontSize: 11,
                    titleFontSize: 12
                },
                legend: {
                    cursor: "pointer",
                    fontSize: 12,
                    itemclick: function(e) {
                        if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                            e.dataSeries.visible = false;
                        } else {
                            e.dataSeries.visible = true;
                        }
                        e.chart.render();
                    },
                    maxHeight: 100,
                    verticalAlign: "bottom",
                    horizontalAlign: "center"
                },
                toolTip: {
                    shared: true,
                    backgroundColor: "rgba(0,0,0,0.8)",
                    fontSize: 12,
                    contentFormatter: function(e) {
                        var content = "<strong>" + CanvasJS.formatDate(e.entries[0].dataPoint.x, "MMM YYYY") + "</strong><br/>";
                        for (var i = 0; i < e.entries.length; i++) {
                            content += "<span style='color:" + e.entries[i].dataSeries.color + "'><strong></strong></span> " +
                                e.entries[i].dataSeries.name + ": <strong>" + e.entries[i].dataPoint.y + "</strong><br/>";
                        }
                        return content;
                    }
                },
                data: chartData
            });

            chart2.render();

            // Handle window resize
            window.addEventListener('resize', function() {
                chart2.render();
            });

            // Add click event to chart container for better UX

        });
    </script>








    <?php
    $currentYearData = array();
    $riskstr = '' . $cyear . '-01,' . $cyear . '-02,' . $cyear . '-03,' . $cyear . '-04,' . $cyear . '-05,' . $cyear . '-06,' . $cyear . '-07,' . $cyear . '-08,' . $cyear . '-09,' . $cyear . '-10,' . $cyear . '-11,' . $cyear . '-12';

    $compraw = explode(',', $riskstr);

    // Get current year data for all months
    foreach ($compraw as $keyy => $valuey) {
        $donequery = mysqli_query($con, "SELECT 
        DATE_FORMAT(date, '%Y-%m') AS complaint_month
        
    FROM 
        saveques
    WHERE 
        DATE_FORMAT(date, '%Y-%m') = '$valuey'
    GROUP BY 
        complaint_month,name");

        $dom = mysqli_fetch_array($donequery);
        $donen = mysqli_num_rows($donequery);

        $currentYearData[$valuey] = ($donen > 0) ? $donen : 0;
    }


    // Prepare data points for chart
    $currentYearPoints = array();

    foreach ($compraw as $month) {
        $monthName = date("M", strtotime($month));
        $currentY = isset($currentYearData[$month]) ? $currentYearData[$month] : 0;

        $currentYearPoints[] = array(
            "label" => $monthName,
            "y" => $currentY
        );
    }

    ?>

    <script>
        window.onload = function() {
            var chart1 = new CanvasJS.Chart("chartvisit", {
                animationEnabled: true,
                exportEnabled: true,
                theme: "light1",
                title: {
                    text: "Visitor Trending (<?php echo $cyear; ?>)"
                },
                axisX: {
                    title: "Month",
                    interval: 1
                },
                axisY: {
                    title: "Number of Visitors",
                    includeZero: true
                },
                toolTip: {
                    shared: true
                },
                data: [{
                    type: "column",
                    name: "<?php echo $cyear; ?>",
                    indexLabel: "{y}",
                    indexLabelPlacement: "outside",
                    color: "#369EAD",
                    dataPoints: <?php echo json_encode($currentYearPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart1.render();
        }
    </script>





    <div class="row p-3">
        <div class="col-md-6">

            <a href="admin?id=complaintmgmt" style="text-decoration: none; color: inherit;">
                <div id="chartcomplaint" style="height: 500px; width: 100%; margin: 2rem 0;"></div>
            </a>

        </div>
        <div class="col-md-6">
            <div id="chartvisit" style="height: 400px; width: 100%;"></div>
        </div>
        <br>
        <br>
        <div class="col-md-6">
            <div id="echartBar" style="height: 300px;"></div>
        </div>
        <div class="col-md-8 col-lg-8"></div>
        <!-- notification-->
        <div class="col-lg-4 col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">Monthly Management Meeting</div>

                    <?php
                    $dn = mysqli_query($con, "SELECT * FROM `tbl_meeting` ");
                    foreach ($dn as $dnv) {
                        $sno = $dnv['id'];
                        $filename = $dnv['mcover'] . "_monthly_Management_1meeting_" . $sno.".pdf";
                    ?>
                        <div class="d-flex align-items-center border-bottom-dotted-dim pb-3 mb-3"> <i class="fa fa-calendar text-primary" style="font-size: 25px;"></i>


                            <div class="flex-grow-1">
                                <h4 class="m-0 pl-2 text-info"> <?php echo $dnv['mcover']; ?></h6>

                            </div>
                            <div class="flex-grow-1">
                                <h5 class="m-0 text-center"> <?php echo date('D, d-m-Y',strtotime($dnv['mdate'])); ?></h6>

                            </div>
                            <div>
                                <a href="mrm/<?php echo $filename; ?>" target="_blank" rel="noopener noreferrer"><i class="fa fa-file-pdf-o text-info" style="font-size: 25px;"></i></a>
                            </div>
                        </div>
                    <?php
                    }   ?>

                </div>
            </div>
        </div>
    </div>


    <script src="dist-assets/js/plugins/echarts.min.js"></script>
    <script language="javascript">
        "use strict";


        $(document).ready(function() {
            // Chart in Dashboard version 1
            var echartElemBar = document.getElementById('echartBar');

            if (echartElemBar) {
                var echartBar = echarts.init(echartElemBar);
                echartBar.setOption({
                    legend: {
                        borderRadius: 0,
                        orient: 'horizontal',
                        x: 'right',
                        data: ['Allocated total score of questionnaires', 'Score received as per questionnaires']
                    },
                    grid: {
                        left: '8px',
                        right: '8px',
                        bottom: '0',
                        containLabel: true
                    },
                    tooltip: {
                        show: true,
                        backgroundColor: 'rgba(0, 0, 0, .8)'
                    },
                    xAxis: [{
                        type: 'category',
                        data: ['Leadership and vision', 'Workplace', 'Staff Knowledge and Actions'],
                        axisTick: {
                            alignWithLabel: true
                        },
                        splitLine: {
                            show: false
                        },
                        axisLine: {
                            show: true
                        }
                    }],
                    yAxis: [{
                        type: 'value',
                        axisLabel: {
                            formatter: '{value}'
                        },
                        min: 0,
                        max: <?php echo $totalpass1; ?>,
                        interval: 25000,
                        axisLine: {
                            show: false
                        },
                        splitLine: {
                            show: true,
                            interval: 'auto'
                        }
                    }],
                    series: [{
                        name: 'Allocated total score of questionnaires',
                        data: [<?php echo $totalpass1; ?>, <?php echo $totalpass1p; ?>, <?php echo $jtotalpass1; ?>],
                        label: {
                            show: false,
                            color: '#0168c1'
                        },
                        type: 'bar',
                        barGap: 0,
                        color: '#bcbbdd',
                        smooth: true,
                        itemStyle: {
                            emphasis: {
                                shadowBlur: 10,
                                shadowOffsetX: 0,
                                shadowOffsetY: -2,
                                shadowColor: 'rgba(0, 0, 0, 0.3)'
                            }
                        }
                    }, {
                        name: 'Score received as per questionnaires',
                        data: [<?php echo $totalfail1; ?>, <?php echo $totalfail1p; ?>, <?php echo $jtotalfail1; ?>],
                        label: {
                            show: false,
                            color: '#639'
                        },
                        type: 'bar',
                        color: '#7569b3',
                        smooth: true,
                        itemStyle: {
                            emphasis: {
                                shadowBlur: 10,
                                shadowOffsetX: 0,
                                shadowOffsetY: -2,
                                shadowColor: 'rgba(0, 0, 0, 0.3)'
                            }
                        }
                    }]
                });
                $(window).on('resize', function() {
                    setTimeout(function() {
                        echartBar.resize();
                    }, 500);
                });
            } // Chart in Dashboard version 1


        });
    </script>










<style>
    .canvasjs-chart-credit {
        display: none !important;
    }
</style>



<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>

<div id="chartContainer" style="height: 370px; width: 100%; margin: 10% 0% ; overflow:scroll"></div>
<?php
// Define your risk string and ensure database connection
 // Example - define this properly
$riskarr = explode(',', $riskstr);

// Fetch service suppliers
$sp = mysqli_query($con, "SELECT * FROM `tblrawsupplier` WHERE suptype != 'Service Supplier'");

// Prepare data array
$chartData = [];

foreach ($sp as $spr) {
    $supnm = mysqli_real_escape_string($con, $spr['supname']);
    $dataPoints = [];
    
    foreach ($riskarr as $value1) {
        $safe_month = mysqli_real_escape_string($con, $value1);
        $safe_supplier = mysqli_real_escape_string($con, $supnm);
        
        $sup1 = mysqli_query($con, "SELECT 
            supplier, 
            DATE_FORMAT(date, '%Y-%m') AS complaint_month,
            COUNT(*) AS total_complaints
        FROM 
            tblsuppliercomplaint
        WHERE 
            DATE_FORMAT(date, '%Y-%m') = '$safe_month'
            AND supplier = '$safe_supplier'
        GROUP BY 
            supplier, complaint_month");
        
        $cmpdt = mysqli_fetch_array($sup1);
        $count = mysqli_num_rows($sup1);
        
        $totalcomp = ($count == 0) ? 0 : $cmpdt['total_complaints'];
        
        $dataPoints[] = [
            'y' => (int)$totalcomp,
            'label' => $value1
        ];
    }
    
    $chartData[] = [
        'type' => "column",
        'name' => $supnm,
        'legendText' => $supnm,
        'showInLegend' => true,
        'dataPoints' => $dataPoints
    ];
}

// Convert to JSON for JavaScript
$chartDataJson = json_encode($chartData);
?>
<style>
    .canvasjs-chart-credit {
        display: none !important;
    }
    #chartContainer {
        height: 370px; 
        width: 100%; 
        margin: 10% 0%; 
        overflow: scroll;
    }
</style>

<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>

<div id="chartContainer"></div>

<script>
    window.onload = function() {
        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            exportEnabled: true,
            title: {
                text: "Service Supplier KPI"
            },
            axisX: {
                title: "Time Period"
            },
            axisY: {
                title: "Number of Complaints"
            },
            toolTip: {
                shared: true
            },
            legend: {
                cursor: "pointer",
                itemclick: function (e) {
                    if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                        e.dataSeries.visible = false;
                    } else {
                        e.dataSeries.visible = true;
                    }
                    e.chart.render();
                }
            },
            data: <?php echo $chartDataJson; ?>
        });
        
        chart.render();
        
        // Generate PDF after chart is fully rendered
        setTimeout(function() {
            var chartImage = chart.toDataURL();
            $.ajax({
                type: "POST",
                url: "generate-pdf.php",
                data: {
                    chartImage: chartImage,
                    chartTitle: "Service Supplier KPI"
                }
            });
        }, 1000);
    }
</script>