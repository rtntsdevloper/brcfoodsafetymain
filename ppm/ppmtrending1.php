<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>Machinery Management</li>
        </ul>
    </div>
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">
                    <a href="admin.php?id=ppmdash">
                        <button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button>
                    </a>

                    <!-- Year Filter -->
                    <form method="GET" action="" style="margin-top: 20px;">
                        <input type="hidden" name="id" value="ppmtrending1">
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <select name="year" class="form-control">
                                    <option value="">Select Year</option>
                                    <?php
                                    $currentYear = date("Y");
                                    $selectedYear = !empty($_GET['year']) ? $_GET['year'] : $currentYear;
                                    for ($y = $currentYear - 5; $y <= $currentYear; $y++) {
                                        $selected = ($y == $selectedYear) ? "selected" : "";
                                        echo "<option value='$y' $selected>$y</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                    </form>

                    <!-- Chart Section -->
                    <div style="margin-top: 20px; margin-bottom: 30px; width: 100%;">
                        <h3 style="text-align: center;">Breakdown Frequency By Asset</h3>
                        <div style="position: relative; height: 350px; width: 100%;">
                            <canvas id="equipmentChart" style="width:100% !important; height:100% !important; display:block;"></canvas>
                        </div>
                    </div>

                    <!-- Table Section -->
                    <div style="overflow-x: auto; margin-top: 20px;">
                        <table border="1" cellpadding="8" cellspacing="0" style="width: 100%; border-collapse: collapse; text-align: center;">
                            <thead>
                                <tr style="background-color: #f2f2f2;">
                                    <th style="padding: 10px;">Equipment Name</th>
                                    <th style="padding: 10px;">JAN</th>
                                    <th style="padding: 10px;">FEB</th>
                                    <th style="padding: 10px;">MAR</th>
                                    <th style="padding: 10px;">APR</th>
                                    <th style="padding: 10px;">MAY</th>
                                    <th style="padding: 10px;">JUN</th>
                                    <th style="padding: 10px;">JUL</th>
                                    <th style="padding: 10px;">AUG</th>
                                    <th style="padding: 10px;">SEP</th>
                                    <th style="padding: 10px;">OCT</th>
                                    <th style="padding: 10px;">NOV</th>
                                    <th style="padding: 10px;">DEC</th>
                                    <!-- <th style="padding: 10px; background-color: #4CAF50; color: white;">Total</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $year = !empty($_GET['year']) ? $_GET['year'] : date("Y");
                                $currentMonth = date('n');
                                $currentYear = date('Y');

                                $sql = mysqli_query($con, "SELECT * FROM `tblequipment`");
                                $allData = [];
                                $totalPerMonth = array_fill(1, 12, 0);

                                foreach ($sql as $row) {
                                    $eid = $row['id'];
                                    $monthlyCounts = [];
                                    $equipmentTotal = 0;
                                ?>
                                    <tr>
                                        <td style="font-weight: bold; padding: 10px; background-color: #f9f9f9;">
                                            <?php echo $row['name']; ?>
                                        </td>
                                        <?php
                                        for ($month = 1; $month <= 12; $month++) {
                                            // Check if this is a future month
                                            $isFutureMonth = ($month > $currentMonth && $year == $currentYear);

                                            if ($isFutureMonth) {
                                                // For future months, show blank and don't add to total
                                                $count = '';
                                                $bgColor = '#f9f9f9';
                                                $displayValue = '';
                                            } else {
                                                // For past/current months, get data from database
                                                $sql1 = mysqli_query($con, "SELECT COUNT(*) as count FROM `tblequipment1` 
                                                        WHERE eid='$eid' 
                                                        AND request='Yes' 
                                                        AND MONTH(date) = '$month'
                                                        AND YEAR(date) = '$year'");
                                                $data = mysqli_fetch_array($sql1);
                                                $count = $data['count'];
                                                $displayValue = $count;

                                                // Add to total only for past/current months
                                                $equipmentTotal += $count;
                                                $totalPerMonth[$month] += $count;

                                                $bgColor = ($count > 0) ? '#e8f5e9' : '';
                                            }

                                            $monthlyCounts[$month] = ($count !== '') ? $count : 0;
                                            echo '<td style="padding: 10px; background-color: ' . $bgColor . ';">' . $displayValue . '</td>';
                                        }
                                        ?>
                                        <!-- <td style="padding: 10px; font-weight: bold; background-color: #e8f5e9;">
                                            <?php echo $equipmentTotal; ?> -->
                                        </td>
                                    </tr>
                                <?php
                                    $allData[$row['name']] = $monthlyCounts;
                                }
                                ?>
                                <!-- Summary Row -->
                                <tr style="background-color: #e3f2fd; font-weight: bold;">
                                    <td style="padding: 10px;">MONTHLY TOTAL</td>
                                    <?php
                                    $grandTotal = 0;
                                    for ($month = 1; $month <= 12; $month++) {
                                        $isFutureMonth = ($month > $currentMonth && $year == $currentYear);
                                        if ($isFutureMonth) {
                                            echo '<td style="padding: 10px;">-</td>';
                                        } else {
                                            // Get total requests for this month across all equipment
                                            $sql3 = mysqli_query($con, "SELECT COUNT(*) as count FROM `tblequipment1` 
                                                    WHERE request='Yes' 
                                                    AND MONTH(date) = '$month'
                                                    AND YEAR(date) = '$year'");
                                            $data3 = mysqli_fetch_array($sql3);
                                            $monthTotal = intval($data3['count']);
                                            $grandTotal += $monthTotal;
                                            echo '<td style="padding: 10px; background-color: #bbdefb;">' . $monthTotal . '</td>';
                                        }
                                    }
                                    ?>
                                    <!-- <td style="padding: 10px; background-color: #4CAF50; color: white;"><?php echo $grandTotal; ?></td> -->
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php
        $year = !empty($_GET['year']) ? $_GET['year'] : date("Y");
        $currentMonth = date('n');
        $currentYear = date('Y');
        $chartLabels = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];

        $requestData = [];
        $completeData = [];

        for ($month = 1; $month <= 12; $month++) {
            // Check if future month
            $isFutureMonth = ($month > $currentMonth && $year == $currentYear);

            if ($isFutureMonth) {
                // Future months show 0
                $requestData[] = 0;
                $completeData[] = 0;
            } else {
                $sqlRequest = mysqli_query($con, "SELECT COUNT(*) as count FROM `tblequipment1` 
                                              WHERE request='Yes' 
                                              AND MONTH(date) = '$month'
                                              AND YEAR(date) = '$year'");
                $dataRequest = mysqli_fetch_array($sqlRequest);
                $requestData[] = $dataRequest['count'];

                $sqlComplete = mysqli_query($con, "SELECT COUNT(*) as count FROM `tblequipment1` 
                                               WHERE request='Yes' 
                                               AND mverify='done'
                                               AND MONTH(date) = '$month'
                                               AND YEAR(date) = '$year'");
                $dataComplete = mysqli_fetch_array($sqlComplete);
                $completeData[] = $dataComplete['count'];
            }
        }
        ?>

        const canvas = document.getElementById('equipmentChart');
        if (!canvas) {
            console.error('Canvas element not found');
            return;
        }

        const ctx = canvas.getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data:{
    labels: <?php echo json_encode($chartLabels); ?>,
    datasets: [{
        label: 'Breakdown Request',
        data: <?php echo json_encode($requestData); ?>,
        backgroundColor: 'rgba(255, 0, 0, 0.7)',      // Red with transparency
        borderColor: 'rgba(255, 0, 0, 1)',            // Solid Red
        borderWidth: 2
    }, {
        label: 'Breakdown Complete',
        data: <?php echo json_encode($completeData); ?>,
        backgroundColor: 'rgba(0, 128, 0, 0.6)',       // Green with transparency
        borderColor: 'rgba(0, 128, 0, 1)',             // Solid Green
        borderWidth: 2,
        borderDash: [5, 5]
    }]
},
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: {
                                size: 13,
                                weight: 'bold'
                            },
                            boxWidth: 15,
                            padding: 20
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                let value = context.parsed.y || 0;
                                return label + ': ' + value;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            precision: 0,
                            font: {
                                size: 12
                            }
                        },
                        title: {
                            display: true,
                            text: 'Number of Breakdowns',
                            font: {
                                size: 13,
                                weight: 'bold'
                            }
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
                                size: 12
                            }
                        }
                    }
                },
                datasets: {
                    bar: {
                        barPercentage: 0.2,
                        categoryPercentage: 0.6
                    }
                }
            }
        });
    });
</script>