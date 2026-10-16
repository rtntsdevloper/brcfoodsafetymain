<?php
// Database connection (make sure $con is properly initialized)

if (isset($_GET['year']) && !empty($_GET['year'])) {
    $cyear = $_GET['year'];
} else {
    $cyear = date("Y");
}

$months = [];
for ($i = 1; $i <= 12; $i++) {
    $month = str_pad($i, 2, '0', STR_PAD_LEFT);
    $months[] = $cyear . '-' . $month;
}

$microvalue = [];
$subjects = [];

// First, get all distinct subjects/microtrend names
$micro1 = mysqli_query($con, "SELECT * FROM `tbl_micortrend`");
while ($microdata = mysqli_fetch_assoc($micro1)) {
    $subjects[] = $microdata['name'];
}

// Now get data for each subject and month
foreach ($subjects as $subject) {
    $subjectData = [
        'subject' => $subject,
        'pass' => [],
        'fail' => [],
        'retest' => []
    ];

    foreach ($months as $month) {
        // Fixed the query - removed hardcoded date and added proper WHERE clauses
        $minenm = mysqli_query($con, "SELECT 
            t1.name, 
            SUM(CASE WHEN t3.status = 'Pass' THEN 1 ELSE 0 END) AS cpass,
            SUM(CASE WHEN t3.status = 'Fail' THEN 1 ELSE 0 END) AS cfail,
            SUM(CASE WHEN t3.retest = 'Yes' THEN 1 ELSE 0 END) AS cretest
        FROM tbl_micortrend AS t1
        JOIN tbl_microtrending AS t2 ON t1.id = t2.mid
        JOIN tbl_microtrending1 AS t3 ON t2.id = t3.eid
        WHERE t1.name = '$subject' 
        AND DATE_FORMAT(t3.sample, '%Y-%m') = '$month' 
        GROUP BY t1.name");

        $minenm1 = mysqli_fetch_assoc($minenm);

        $subjectData['pass'][] = $minenm1 ? (int)$minenm1['cpass'] : 0;
        $subjectData['fail'][] = $minenm1 ? (int)$minenm1['cfail'] : 0;
        $subjectData['retest'][] = $minenm1 ? (int)$minenm1['cretest'] : 0;
    }

    $microvalue[] = $subjectData;
}

// Format months for display (e.g., "2025-01" becomes "Jan 2025")
$formattedMonths = array_map(function ($month) {
    return date('M Y', strtotime($month));
}, $months);

// Convert PHP arrays to JSON for JavaScript
$monthlyDataJson = json_encode($microvalue);

$monthsJson = json_encode($formattedMonths);
$subjectsJson = json_encode($subjects);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Results Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-container {
            width: 100%;
            height: 600px;
            margin: 10px auto;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .controls {
            margin: 20px auto;
            width: 90%;
            text-align: center;
        }

        select,
        input {
            padding: 8px;
            margin: 0 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .year-selector {
            margin-bottom: 15px;
        }
    </style>
</head>

<body>


    <div class="chart-container">
        <div class="row">
            <div class="col-md-6">
                <form method="GET" style="display: inline;">
                    <label for="yearSelect">Select Year:</label>
                    <select name="year" id="yearSelect" onchange="getnewyear(this.value)">
                        <?php
                        $yuin = mysqli_query($con, "SELECT distinct year FROM `tbl_microtrending`");
                        foreach ($yuin as $yuind) {
                            $yearu = $yuind['year'];
                            if ($yearu == $cyear) {
                                echo '<option value="' . $yuind['year'] . '" selected>' . $yuind['year'] . '</option>';
                            } else {
                                echo '<option value="' . $yuind['year'] . '">' . $yuind['year'] . '</option>';
                            }
                        }
                        ?>

                    </select>
                </form>
            </div>

            <script>
                function getnewyear(year) {
                    window.location.href = "admin.php?id=microtrend&year=" + year;
                }
            </script>

            <div class="col-md-6 text-right">
                <label for="subjectSelect">Select Type:</label>
                <select id="subjectSelect">
                    <option value="all">All Types</option>
                </select>
            </div>
        </div>
        <div class="col-md-12 text-right mt-3">
            <button id="download" class="btn btn-info"><i class="fa fa-download"> Download chart image</i></button>
        </div>

        <canvas id="testResultsChart"></canvas>
    </div>

    <script>
        // PHP data converted to JavaScript
        const monthlyData = <?php echo $monthlyDataJson; ?>;
        const months = <?php echo $monthsJson; ?>;
        const allSubjects = <?php echo $subjectsJson; ?>;

        // Initialize subject dropdown
        const subjectSelect = document.getElementById('subjectSelect');
        allSubjects.forEach(subject => {
            const option = document.createElement('option');
            option.value = subject;
            option.textContent = subject;
            subjectSelect.appendChild(option);
        });

        // Chart configuration
        const ctx = document.getElementById('testResultsChart').getContext('2d');
        let chart;

        // Function to create datasets based on selected subject
        function createDatasets(selectedSubject) {
            const datasets = [];
            const resultTypes = ['pass', 'fail', 'retest'];
            const colors = {
                pass: {
                    border: '#0c590fff',
                    background: 'rgba(76, 175, 80, 0.1)'
                },
                fail: {
                    border: '#d41709ff',
                    background: 'rgba(244, 67, 54, 0.1)'
                },
                retest: {
                    border: '#FF9800',
                    background: 'rgba(255, 152, 0, 0.1)'
                }
            };
            const labels = {
                pass: 'Pass',
                fail: 'Fail',
                retest: 'Retest'
            };

            if (selectedSubject === 'all') {
                // Show all subjects aggregated by result type
                resultTypes.forEach(type => {
                    const data = months.map((month, monthIndex) => {
                        return monthlyData.reduce((sum, subjectData) => {
                            return sum + subjectData[type][monthIndex];
                        }, 0);
                    });

                    datasets.push({
                        label: `${labels[type]} (All)`,
                        data: data,
                        borderColor: colors[type].border,
                        backgroundColor: colors[type].background,
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true
                    });
                });
            } else {
                // Show selected subject with all result types
                const subjectData = monthlyData.find(data => data.subject === selectedSubject);

                if (subjectData) {
                    resultTypes.forEach(type => {
                        datasets.push({
                            label: `${labels[type]} (${selectedSubject})`,
                            data: subjectData[type],
                            borderColor: colors[type].border,
                            backgroundColor: colors[type].background,
                            borderWidth: 3,
                            tension: 0.4,
                            fill: true
                        });
                    });
                }
            }

            return datasets;
        }

        // Function to initialize or update chart
        function initializeChart(selectedSubject = 'all') {
            const datasets = createDatasets(selectedSubject);

            if (chart) {
                chart.destroy();
            }

            chart = new Chart(ctx, {
                type: 'line',

                data: {
                    labels: months,
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: selectedSubject === 'all' ?
                                `Micro Trending Results - All (<?php echo $cyear; ?>)` : `Micro Trending Results - ${selectedSubject} (<?php echo $cyear; ?>)`,
                            font: {
                                size: 16,
                                weight: 'bold'
                            }
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            callbacks: {
                                label: function(context) {
                                    return `${context.dataset.label}: ${context.parsed.y}`;
                                }
                            }
                        },
                        legend: {
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                padding: 20
                            }
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Months',
                                font: {
                                    weight: 'bold'
                                }
                            },
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Number of Attempts',
                                font: {
                                    weight: 'bold'
                                }
                            },
                            beginAtZero: true,
                            ticks: {
                                stepSize: 2
                            }
                        }
                    },
                    interaction: {
                        mode: 'nearest',
                        axis: 'x',
                        intersect: false
                    },
                    elements: {
                        point: {
                            radius: 4,
                            hoverRadius: 6
                        }
                    }
                }
            });
        }

        // Event listener for subject selection
        subjectSelect.addEventListener('change', function() {
            initializeChart(this.value);
        });
        document.getElementById('download').addEventListener('click', function() {

            const link = document.createElement('a');
            link.download = 'chart.png'; // filename
            link.href = chart.toBase64Image(); // convert canvas to image
            link.click();
        });
        // Initialize the chart
        initializeChart();
    </script>


    <div class="row mb-12 " style="text-transform: capitalize;">
        <div class="col-md-12 mb-12">
            <div class="card text-left" style="margin-top:4%;">
                <div class="card-body">
                    <h1 class="text-center mb-3">Micro Results Tracker - <?php echo $cyear; ?></h1>
                    <table class="table table-responsive table-bordered table-striped text-center">
                        <thead>
                            <tr class="text-primary">
                                <th rowspan="2">#</th>
                                <th rowspan="2">Subject</th>
                                <?php
                                foreach ($months as $month) {
                                    $monthx = date('F', strtotime($month));
                                ?>
                                    <th colspan="2"><?= $monthx ?></th>
                                <?php
                                }
                                ?>
                                <th rowspan="2">Total Retest</th>
                                <th rowspan="2">Total Sample</th>
                                <th rowspan="2">% Total Pass</th>
                                <th rowspan="2">% Total Fail</th>




                            </tr>
                            <tr><?php
                                foreach ($months as $month) {
                                    $monthx = date('F', strtotime($month));
                                ?>
                                    <th class="text-success">Pass </th>
                                    <th class="text-danger">Fail </th>
                                <?php
                                }
                                ?>

                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($microvalue as $index => $subject): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= htmlspecialchars($subject['subject']) ?></td>

                                    <?php
                                    $totalswab = 0;
                                    $totalpass = 0;
                                    $totalfail = 0;
                                    $totalrecheck = 0;

                                    for ($i = 0; $i < 12; $i++):

                                        $totalswab += $subject['pass'][$i] + $subject['fail'][$i];
                                        $totalpass += $subject['pass'][$i];
                                        $totalfail += $subject['fail'][$i];
                                        $totalrecheck += $subject['retest'][$i];

                                        $month = $i + 1;
                                        $mpcx = strtotime($cyear . '-' . $month);
                                        if (date('Y-m') < date('Y-m', $mpcx)) {
                                            echo " <td>-</td><td>- </td>";
                                        } else {
                                    ?>


                                            <td><?= $subject['pass'][$i]  ?></td>
                                            <td><?= $subject['fail'][$i] ?></td>


                                    <?php }
                                    endfor; ?>

                                    <td><?php if ($totalrecheck == 0) {
                                            echo "";
                                        } else {
                                            echo $totalrecheck;
                                        }  ?></td>
                                    <td><?php if ($totalswab == 0) {
                                            echo "";
                                        } else {
                                            echo $totalswab;
                                        }  ?></td>
                                    <td><?php if ($totalswab == 0) {
                                            echo "";
                                        } else {
                                            $resultp =  ($totalpass / $totalswab) * 100;
                                            echo round($resultp, 2) . "%"; //echo $resultp . "%";
                                        }
                                        ?></td>
                                    <td><?php if ($totalswab == 0) {
                                            echo "";
                                        } else {
                                            $resultf =  ($totalfail / $totalswab) * 100;
                                            echo round($resultf, 2) . "%";
                                        }
                                        ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>


    <div class="row mb-12 " style="text-transform: capitalize;">
        <div class="col-md-12 mb-12">
            <div class="card text-left" style="margin-top:4%;">
                <div class="card-body">
                    <h1 class="text-center mb-3">Micro Trending Plan Tracker - <?php echo $cyear; ?></h1>
                    <table class="table table-responsive table-bordered table-striped text-center">
                        <thead>
                            <tr class="text-primary">
                                <th rowspan="2">#</th>
                                <th rowspan="2">Subject</th>
                                <?php
                                foreach ($months as $month) {
                                    $monthx = date('F', strtotime($month));
                                ?>
                                    <th colspan="2"><?= $monthx ?></th>
                                <?php
                                }
                                ?>
                                <th rowspan="2">Total Planned</th>
                                <th rowspan="2">Total Conducted</th>
                                <th rowspan="2">% Total Conducted</th>





                            </tr>
                            <tr><?php
                                foreach ($months as $month) {
                                    $monthx = date('F', strtotime($month));
                                ?>
                                    <th class="text-info">Planned</th>
                                    <th class="text-success">Conducted</th>
                                <?php
                                }
                                ?>

                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $smicro1 = mysqli_query($con, "SELECT * FROM `tbl_micortrend`");
                            $index = 0;

                            foreach ($smicro1 as $microdata) {
                                $index++;
                                $subject = $microdata['name'];
                                $totalswab = 0;
                                $totalpass = 0;
                                $totalfail = 0; ?>
                                <tr>
                                    <td><?= $index ?></td>
                                    <td><?= htmlspecialchars($microdata['name']) ?></td>
                                    <?php
                                    foreach ($months as $month) {
                                        // Fixed the query - removed hardcoded date and added proper WHERE clauses
                                        $minenm = mysqli_query($con, "SELECT 
                                            t1.name, 
                                            count(*) AS cpass,
                                            SUM( CASE WHEN t2.status != '' THEN 1 ELSE 0 END) AS cattempt

                                        FROM tbl_micortrend AS t1
                                        JOIN tbl_microtrending AS t2 ON t1.id = t2.mid
                                        WHERE t1.name = '$subject' 
                                        AND t2.admonth = '$month' 
                                    ");



                                    ?>



                                        <?php






                                        foreach ($minenm as $minenm1) {


                                            $totalswab += $minenm1['cpass'];
                                            $totalfail += $minenm1['cattempt'];


                                            $month = $i + 1;
                                            $mpcx = strtotime($cyear . '-' . $month);

                                        ?>


                                            <td><?php if (empty($minenm1['cpass'])) {
                                                    echo '-';
                                                } else {
                                                    echo $minenm1['cpass'];
                                                }   ?></td>
                                            <td><?php if (empty($minenm1['cattempt'])) {
                                                    echo '-';
                                                } else {
                                                    echo $minenm1['cattempt'];
                                                } ?></td>


                                    <?php


                                        }
                                    }



                                    ?>


                                    <td><?php if ($totalswab == 0) {
                                            echo "";
                                        } else {
                                            echo $totalswab;
                                        }  ?></td>
                                    <td><?php if ($totalfail == 0) {
                                            echo "";
                                        } else {
                                            echo $totalfail;
                                        }  ?></td>
                                    
                                    <td><?php if ($totalswab == 0) {
                                            echo "";
                                        } else {
                                            $resultp =  ($totalfail / $totalswab) * 100;
                                            echo round($resultp, 2) . "%"; //echo $resultp . "%";
                                        }
                                        ?></td>

                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>



</body>

</html>