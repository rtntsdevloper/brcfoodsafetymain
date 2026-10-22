<?php
// Database connection (make sure $con is properly initialized)

if (isset($_GET['year']) && !empty($_GET['year'])) {
    $cyear = $_GET['year'];
} else {
    $cyear = date("Y");
}






?>






<div class="row mb-12 " style="text-transform: capitalize;">
    <div class="col-md-12 mb-12">
        <div class="card text-left" style="margin-top:4%;">
            <div class="card-body">



                <div class="row mb-5">
                    <div class="col-md-12 mb-3">
                        <h1 class="mb-3">Micro-Trending Bacteria Results (<?php echo $cyear; ?>)</h1>
                    </div>
                    <div class="col-md-6">
                        <form method="GET" style="display: inline;">
                            <label for="yearSelect">Select Year:</label>
                            <select name="year" id="yearSelect" onchange="getnewyear(this.value)">
                                <?php
                                for ($i = date('Y'); $i >= 2023; $i--) {
                                    if ($i == $cyear) {
                                        echo '<option value="' . $i . '" selected>' . $i . '</option>';
                                    } else {
                                        echo '<option value="' . $i . '">' . $i . '</option>';
                                    }
                                } ?>

                            </select>
                        </form>
                    </div>

                    <script>
                        function getnewyear(year) {
                            window.location.href = "admin.php?id=microtrendbact&year=" + year;
                        }
                    </script>

                    <div class="col-md-6 text-right">
                        <a href="admin.php?id=microtrend" class="btn btn-success">Micro-Trending by Types</a>
                        <a href="admin.php?id=microtrendsub" class="btn btn-success">Micro-Trending Locations</a>
                        <a href="admin.php?id=microtrending" class="btn btn-primary">Go Back</a>


                    </div>
                </div>
                <div class="row mb-5">
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <style>
                        body{
                            text-transform: capitalize;
                        }
                        .chart-wrapper {
                            width: 100%;
                            height: 500px;
                            position: relative;
                            margin-top: 20px;
                        }

                        canvas {
                            width: 100% !important;
                            height: 100% !important;
                        }

                        select {
                            padding: 8px;
                            font-size: 14px;
                            border-radius: 5px;
                            margin-left: 10px;
                        }
                        .stats {
            margin-top: 20px;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 8px;
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }
        .stat-card {
            text-align: center;
            padding: 10px 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .stat-value {
            font-size: 24px;
            font-weight: bold;
        }
        .stat-label {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }
        .pass { color: #4caf50; }
        .fail { color: #f44336; }
        .total { color: #2196f3; }
        .no-data {
            text-align: center;
            padding: 50px;
            color: #999;
            font-size: 18px;
        }
                    </style>

                    <div class="col-md-3">
                        <div class="control-group">
                            <label>Select Section:</label>
                            <select id="sectionSelect" class="form-control">
                                <option value="">Loading Sections...</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="control-group">
                            <label>Select Bacteria:</label>
                            <select id="bacteriaSelect" disabled class="form-control">
                                <option value="">First select a section</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4"> </div>

                    <div class="col-md-2">
                        <button id="saveChartBtn" class="btn btn-info mt-3">💾 Save Chart as Image</button>
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="chart-container">
                            <div class="chart-wrapper">
                                <canvas id="bacteriaChart"></canvas>
                            </div>
                        </div>

                        <div id="statsPanel" class="stats"></div>
                    </div>
                    <hr>
                    <?php

                    $months = [];
                    $monthLabels = [];
                    for ($i = 1; $i <= 12; $i++) {
                        $month = str_pad($i, 2, '0', STR_PAD_LEFT);
                        $months[] = $cyear . '-' . $month;
                        $monthLabels[] = date('M', strtotime($cyear . '-' . $month . '-01'));
                    }

                    $data = [];
                    $sectionsData = [];

                    // Get all sections
                    $microsect = mysqli_query($con, "SELECT * FROM `tbl_micortrend`");
                    while ($section = mysqli_fetch_assoc($microsect)) {
                        $sectionId = $section['id'];
                        $sectionName = $section['name'];
                        $sectionsData[] = ['id' => $sectionId, 'name' => $sectionName];

                        // Get bacteria for this section
                        $microbact = mysqli_query($con, "SELECT * FROM `tbl_microbact` WHERE section='$sectionId'");
                        while ($bacteria = mysqli_fetch_assoc($microbact)) {
                            $bactname = $bacteria['name'];

                            // Get monthly data for this bacteria
                            foreach ($months as $month) {
                                $query = mysqli_query($con, "SELECT 
                    SUM(CASE WHEN t1.status = 'Pass' THEN 1 ELSE 0 END) AS cpass,
                    SUM(CASE WHEN t1.status = 'Fail' THEN 1 ELSE 0 END) AS cfail
                FROM microtrendb AS t1
                JOIN tbl_microtrending AS t2 ON t2.id = t1.mid
                WHERE t1.name = '$bactname' AND admonth = '$month'");

                                $result = mysqli_fetch_assoc($query);
                                $cpass = ($result['cpass'] == '') ? 0 : (int)$result['cpass'];
                                $cfail = ($result['cfail'] == '') ? 0 : (int)$result['cfail'];

                                $data[$sectionName][$bactname]['pass'][$month] = $cpass;
                                $data[$sectionName][$bactname]['fail'][$month] = $cfail;
                            }
                        }
                    }
                    ?>

                    <script>
                        const chartData = <?php echo json_encode($data); ?>;
                        const sections = <?php echo json_encode($sectionsData); ?>;
                        const months = <?php echo json_encode($months); ?>;
                        const monthLabels = <?php echo json_encode($monthLabels); ?>;

                        let currentChart = null;
                        let currentSection = null;
                        let currentBacteria = null;

                        function updateChart(sectionName, bacteriaName) {
                            if (!sectionName || !bacteriaName) return;

                            const sectionData = chartData[sectionName];
                            if (!sectionData || !sectionData[bacteriaName]) {
                                showNoData();
                                return;
                            }

                            const passData = months.map(month => sectionData[bacteriaName].pass[month] || 0);
                            const failData = months.map(month => sectionData[bacteriaName].fail[month] || 0);

                            // Calculate statistics
                            const totalPass = passData.reduce((a, b) => a + b, 0);
                            const totalFail = failData.reduce((a, b) => a + b, 0);
                            const totalTests = totalPass + totalFail;
                            const passRate = totalTests > 0 ? ((totalPass / totalTests) * 100).toFixed(1) : 0;

                            // Update stats panel
                            updateStatsPanel(totalPass, totalFail, totalTests, passRate, bacteriaName);

                            const canvas = document.getElementById('bacteriaChart');
                            const ctx = canvas.getContext('2d');

                            // Set canvas dimensions to prevent blur
                            const container = canvas.parentElement;
                            const rect = container.getBoundingClientRect();
                            canvas.width = rect.width;
                            canvas.height = rect.height;
                            canvas.style.width = `${rect.width}px`;
                            canvas.style.height = `${rect.height}px`;

                            if (currentChart) {
                                currentChart.destroy();
                            }

                            currentChart = new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: monthLabels,
                                    datasets: [{
                                            label: 'Pass',
                                            data: passData,
                                            borderColor: '#4caf50',
                                            backgroundColor: 'rgba(76, 175, 80, 0.1)',
                                            borderWidth: 3,
                                            tension: 0.3,
                                            fill: true,
                                            pointRadius: 6,
                                            pointHoverRadius: 8,
                                            pointBackgroundColor: '#4caf50',
                                            pointBorderColor: '#fff',
                                            pointBorderWidth: 2,
                                            pointStyle: 'circle'
                                        },
                                        {
                                            label: 'Fail',
                                            data: failData,
                                            borderColor: '#f44336',
                                            backgroundColor: 'rgba(244, 67, 54, 0.1)',
                                            borderWidth: 3,
                                            tension: 0.3,
                                            fill: true,
                                            pointRadius: 6,
                                            pointHoverRadius: 8,
                                            pointBackgroundColor: '#f44336',
                                            pointBorderColor: '#fff',
                                            pointBorderWidth: 2,
                                            pointStyle: 'rect'
                                        }
                                    ]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: true,
                                    devicePixelRatio: window.devicePixelRatio || 2,
                                    interaction: {
                                        mode: 'index',
                                        intersect: false
                                    },
                                    plugins: {
                                        title: {
                                            display: true,
                                            text: `${bacteriaName} - Yearly Pass/Fail Results (${new Date().getFullYear()})`,
                                            font: {
                                                size: 18,
                                                weight: 'bold'
                                            },
                                            padding: {
                                                top: 10,
                                                bottom: 20
                                            }
                                        },
                                        tooltip: {
                                            callbacks: {
                                                label: function(context) {
                                                    return `${context.dataset.label}: ${context.raw} tests`;
                                                },
                                                footer: function(tooltipItems) {
                                                    let total = passData[tooltipItems[0].dataIndex] + failData[tooltipItems[0].dataIndex];
                                                    return `Total: ${total} tests`;
                                                }
                                            }
                                        },
                                        legend: {
                                            position: 'top',
                                            labels: {
                                                usePointStyle: true,
                                                boxWidth: 15,
                                                padding: 15,
                                                font: {
                                                    size: 13,
                                                    weight: 'bold'
                                                }
                                            }
                                        }
                                    },
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            title: {
                                                display: true,
                                                text: 'Number of Tests',
                                                font: {
                                                    size: 13,
                                                    weight: 'bold'
                                                }
                                            },
                                            ticks: {
                                                stepSize: 1,
                                                precision: 0,
                                                font: {
                                                    size: 11
                                                }
                                            },
                                            grid: {
                                                color: 'rgba(0,0,0,0.08)'
                                            }
                                        },
                                        x: {
                                            title: {
                                                display: true,
                                                text: 'Months',
                                                font: {
                                                    size: 13,
                                                    weight: 'bold'
                                                }
                                            },
                                            ticks: {
                                                font: {
                                                    size: 11
                                                }
                                            },
                                            grid: {
                                                display: false
                                            }
                                        }
                                    },
                                    elements: {
                                        line: {
                                            borderWidth: 3
                                        },
                                        point: {
                                            radius: 6,
                                            hoverRadius: 8
                                        }
                                    }
                                }
                            });
                        }

                        function updateStatsPanel(totalPass, totalFail, totalTests, passRate, bacteriaName) {
                            const statsHtml = `
                <div class="stat-card">
                    <div class="stat-value pass">${totalPass}</div>
                    <div class="stat-label">✅ Total Pass</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value fail">${totalFail}</div>
                    <div class="stat-label">❌ Total Fail</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value total">${totalTests}</div>
                    <div class="stat-label">📊 Total Tests</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value ${passRate >= 70 ? 'pass' : 'fail'}">${passRate}%</div>
                    <div class="stat-label">📈 Pass Rate</div>
                </div>
            `;
                            document.getElementById('statsPanel').innerHTML = statsHtml;
                        }

                        function showNoData() {
                            const canvas = document.getElementById('bacteriaChart');
                            const ctx = canvas.getContext('2d');

                            const container = canvas.parentElement;
                            const rect = container.getBoundingClientRect();
                            canvas.width = rect.width;
                            canvas.height = rect.height;

                            if (currentChart) {
                                currentChart.destroy();
                            }

                            currentChart = new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: monthLabels,
                                    datasets: [{
                                        label: 'No Data',
                                        data: monthLabels.map(() => 0),
                                        borderColor: '#999',
                                        backgroundColor: 'transparent'
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: true,
                                    plugins: {
                                        title: {
                                            display: true,
                                            text: 'No data available for selected bacteria',
                                            font: {
                                                size: 16
                                            }
                                        }
                                    }
                                }
                            });

                            document.getElementById('statsPanel').innerHTML = '<div class="stat-card">No data available</div>';
                        }

                        function populateBacteriaDropdown(sectionName) {
                            const bacteriaSelect = document.getElementById('bacteriaSelect');
                            const sectionData = chartData[sectionName];

                            bacteriaSelect.innerHTML = '';

                            if (!sectionData || Object.keys(sectionData).length === 0) {
                                bacteriaSelect.innerHTML = '<option value="">No bacteria found</option>';
                                bacteriaSelect.disabled = true;
                                return;
                            }

                            const bacteria = Object.keys(sectionData);
                            bacteria.forEach(bacteriaName => {
                                const option = document.createElement('option');
                                option.value = bacteriaName;
                                option.textContent = bacteriaName;
                                bacteriaSelect.appendChild(option);
                            });

                            bacteriaSelect.disabled = false;

                            // Load first bacteria by default
                            if (bacteria.length > 0) {
                                bacteriaSelect.value = bacteria[0];
                                updateChart(sectionName, bacteria[0]);
                            }
                        }

                        function saveChartAsImage() {
                            const canvas = document.getElementById('bacteriaChart');
                            if (!currentChart) {
                                alert('No chart to save');
                                return;
                            }

                            const link = document.createElement('a');
                            const bacteriaName = document.getElementById('bacteriaSelect').value;
                            const sectionName = document.getElementById('sectionSelect').value;
                            link.download = `${sectionName}_${bacteriaName}_${new Date().getFullYear()}_results.png`;
                            link.href = canvas.toDataURL('image/png');
                            link.click();
                        }

                        // Initialize dropdowns
                        const sectionSelect = document.getElementById('sectionSelect');
                        sectionSelect.innerHTML = '<option value="">Select Section</option>';

                        sections.forEach(section => {
                            const option = document.createElement('option');
                            option.value = section.name;
                            option.textContent = section.name;
                            sectionSelect.appendChild(option);
                        });

                        // Section change event
                        sectionSelect.addEventListener('change', function() {
                            const sectionName = this.value;
                            if (sectionName) {
                                populateBacteriaDropdown(sectionName);
                            } else {
                                document.getElementById('bacteriaSelect').innerHTML = '<option value="">First select a section</option>';
                                document.getElementById('bacteriaSelect').disabled = true;
                            }
                        });

                        // Bacteria change event
                        document.getElementById('bacteriaSelect').addEventListener('change', function() {
                            const sectionName = sectionSelect.value;
                            const bacteriaName = this.value;
                            if (sectionName && bacteriaName) {
                                updateChart(sectionName, bacteriaName);
                            }
                        });

                        // Save button
                        document.getElementById('saveChartBtn').addEventListener('click', saveChartAsImage);

                        // Handle window resize
                        let resizeTimeout;
                        window.addEventListener('resize', function() {
                            clearTimeout(resizeTimeout);
                            resizeTimeout = setTimeout(function() {
                                const sectionName = sectionSelect.value;
                                const bacteriaName = document.getElementById('bacteriaSelect').value;
                                if (sectionName && bacteriaName) {
                                    updateChart(sectionName, bacteriaName);
                                }
                            }, 250);
                        });
                    </script>
                </div>













<br><hr><br>

                <?php
                $microsect = mysqli_query($con, "SELECT * FROM `tbl_micortrend`");
                foreach ($microsect as $microsectdata) {

                    $micd = $microsectdata['id'];

                    $microbact =  mysqli_query($con, "SELECT * FROM `tbl_microbact` WHERE section='$micd'");

                ?>





                    <h3 class="text-center mb-3"><?= $microsectdata['name'] ?> Bacteria Results </h3>
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
                            <?php

                            $index = 0;

                            foreach ($microbact as $microbactdata):
                                $bactname = $microbactdata['name'];



                            ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= htmlspecialchars($microbactdata['name']) ?></td>

                                    <?php
                                    $totalpass = 0;
                                    $totalfail = 0;
                                    $totalswab = 0;
                                    foreach ($months as $month) {
                                        $microat = mysqli_query($con, "SELECT 
            t1.name, 
            SUM(CASE WHEN t1.status = 'Pass' THEN 1 ELSE 0 END) AS cpass,
            SUM(CASE WHEN t1.status = 'Fail' THEN 1 ELSE 0 END) AS cfail
        FROM microtrendb AS t1
        JOIN tbl_microtrending AS t2 ON t2.id = t1.mid
       
        WHERE t1.name = '$bactname' 
        AND admonth = '$month' ");
                                        $microat1 = mysqli_fetch_assoc($microat);

                                        $totalpass += $microat1['cpass'];
                                        $totalfail += $microat1['cfail'];
                                        $totalswab += $microat1['cpass'] + $microat1['cfail'];


                                    ?>


                                        <td><?= $microat1['cpass'] ?></td>
                                        <td><?= $microat1['cfail'] ?></td>
                                    <?php
                                    }
                                    ?>



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
                            <?php
                                $index++;


                            endforeach; ?>
                        </tbody>
                    </table>
                    <br>
                    <br>
                    <hr>
                    <br>
                    <br>

                <?php
                }

                ?>














            </div>
        </div>
    </div>
</div>