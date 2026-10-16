<?php
// Get the selected year from either POST or GET
if (isset($_POST['search'])) {
    $selectedYear = $_POST['year'];
} elseif (isset($_GET['year'])) {
    $selectedYear = $_GET['year'];
} else {
    $selectedYear = date('Y');
}

// Set the year for both sections
$year = $selectedYear;
?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>Machinery Management</li>
        </ul>
    </div>
    
    <!-- Unified Filter Section -->
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">
                    <a href="admin.php?id=ppm">
                        <button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button>
                    </a>

                    <!-- Unified Year Filter -->
                    <form method="POST" action="" style="margin-top: 20px;">
                        <input type="hidden" name="id" value="ppmtrending">
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <select name="year" class="form-control">
                                    <option value="">Select Year</option>
                                    <?php
                                    $currentYear = date("Y");
                                    for ($y = $currentYear - 5; $y <= $currentYear; $y++) {
                                        $selected = ($y == $selectedYear) ? "selected" : "";
                                        echo "<option value='$y' $selected>$y</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary" name="search">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- First Chart: PPM Status -->
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">
                    <h4 class="card-title mb-3">PPM Status</h4>
<?php
                    $year = !empty($_GET['year']) ? $_GET['year'] : date("Y");

                    $overdueCounts = [];
                    $dueCounts     = [];
                    $doneCounts    = [];
                    $serviceRequestCounts = [];
                    $doneServiceRequestCounts = [];

                    $curentxm = date('Y-m'); // current year-month string
                    $currentd = date('Y-m-d');

                    // --- Next Due (global, not per month) ---
                    $sqlNextDue = mysqli_query($con, "SELECT date 
    FROM tblequipment1 
    WHERE status1='waiting' 
      AND date >= '$currentd'");

                    $rowNextDue = mysqli_fetch_assoc($sqlNextDue);
                    $nextDueDate = $rowNextDue ? $rowNextDue['date'] : null;


                    // --- Monthly Loop ---
                    for ($m = 1; $m <= 12; $m++) {
                        $monthStr = str_pad($m, 2, "0", STR_PAD_LEFT); // "01", "02", etc.
                        $qmonth = $selectedYear . '-' . $monthStr;

                        // Overdue count - date less than current date (NOT month-based)
                        $sqlOverdue = mysqli_query($con, "SELECT COUNT(*) AS cnt 
        FROM tblequipment1 
        WHERE status1='waiting' 
          AND date < '$currentd' 
          AND request='' 
          AND MONTH(date)='$m' 
          AND YEAR(date)='$selectedYear'
    ");
                        $rowOverdue = mysqli_fetch_assoc($sqlOverdue);
                        $overdueCounts[$m] = $rowOverdue['cnt'];

                        // First and last day of this month
                        $firstDay = $selectedYear . '-' . $monthStr . '-01';
                        $lastDay  = date("Y-m-t", strtotime($firstDay));


                        // Due count for this month
                        if ($lastDay >= $currentd) {
                            $sqlDue = mysqli_query($con, "SELECT COUNT(*) AS cnt 
            FROM tblequipment1 
            WHERE status1='waiting' 
              AND date BETWEEN '$firstDay' AND '$lastDay'
        ");
                            $rowDue = mysqli_fetch_assoc($sqlDue);
                            $dueCounts[$m] = $rowDue['cnt'];
                        } else {
                            $dueCounts[$m] = 0;
                        }


                        // Completed
                        $sqlDone = mysqli_query($con, "SELECT COUNT(*) AS cnt 
                            FROM tblequipment1 
                            WHERE status1='Done' 
                              AND mverify='done'  And request=''
                              AND MONTH(date)='$m' 
                              AND YEAR(date)='$selectedYear'
                        ");
                        $rowDone = mysqli_fetch_assoc($sqlDone);
                        $doneCounts[$m] = $rowDone['cnt'];

                        // Service Request (request='yes')
                        $sqlServiceRequest = mysqli_query($con, "SELECT COUNT(*) AS cnt 
                            FROM tblequipment1 
                            WHERE request='Yes' 
                              AND MONTH(date)='$m' 
                              AND YEAR(date)='$selectedYear'
                        ");
                        $rowServiceRequest = mysqli_fetch_assoc($sqlServiceRequest);
                        $serviceRequestCounts[$m] = $rowServiceRequest['cnt'];

                        $sqlDoneServiceRequest = mysqli_query($con, "SELECT COUNT(*) AS cnt 
                            FROM tblequipment1 
                            WHERE request='Yes' 
                              AND mverify='done'
                              AND MONTH(date)='$m' 
                              AND YEAR(date)='$selectedYear'
                        ");
                        $rowDoneServiceRequest = mysqli_fetch_assoc($sqlDoneServiceRequest);
                        $doneServiceRequestCounts[$m] = $rowDoneServiceRequest['cnt'];
                    }


                    ?>
                    <!-- Fixed-height Chart -->
                    <div style="height:400px;">
                        <canvas id="yearBarChart" style="margin-bottom:30px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Chart: Breakdown Frequency By Asset -->
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">
                    <h3 style="text-align: center;">Breakdown Frequency By Asset</h3>
                    
                    <!-- Chart Section -->
                    <div style="margin-top: 20px; margin-bottom: 30px; width: 100%;">
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
                                </tr>
                            </thead>
                            <tbody>
                                <?php
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

<!-- First Chart Script -->
<script>
    const ctxBar = document.getElementById('yearBarChart').getContext('2d');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                    label: 'Overdue',
                    data: [<?php echo implode(",", $overdueCounts); ?>],
                    backgroundColor: '#C10000',
                    barPercentage: 0.35,
                    categoryPercentage: 0.7
                },
                {
                    label: 'Due',
                    data: [<?php echo implode(",", $dueCounts); ?>],
                    backgroundColor: '#2473AB',
                    barPercentage: 0.35,
                    categoryPercentage: 0.7
                },
                {
                    label: 'Completed',
                    data: [<?php echo implode(",", $doneCounts); ?>],
                    backgroundColor: '#669900',
                    barPercentage: 0.35,
                    categoryPercentage: 0.7
                },
                {
                    label: 'Service Request',
                    data: [<?php echo implode(",", $serviceRequestCounts); ?>],
                    backgroundColor: '#FFA500',
                    barPercentage: 0.35,
                    categoryPercentage: 0.7
                },
                {
                    label: 'Service Request Done',
                    data: [<?php echo implode(",", $doneServiceRequestCounts); ?>],
                    backgroundColor: '#8B008B',
                    barPercentage: 0.35,
                    categoryPercentage: 0.7
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: 'Monthly PPM Status - <?php echo $year; ?>'
                },
                legend: {
                    labels: {
                        font: {
                            size: 11
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
                            size: 11
                        }
                    },
                    title: {
                        display: true,
                        text: 'Number of PPM',
                        font: {
                            size: 12
                        }
                    }
                },
                x: {
                    ticks: {
                        font: {
                            size: 11
                        }
                    }
                }
            }
        }
    });
</script>

<!-- Second Chart Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php
        $year = $selectedYear; // Use the same year from unified filter
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
            data: {
                labels: <?php echo json_encode($chartLabels); ?>,
                datasets: [{
                    label: 'Breakdown Request',
                    data: <?php echo json_encode($requestData); ?>,
                    backgroundColor: 'rgba(255, 0, 0, 0.7)',
                    borderColor: 'rgba(255, 0, 0, 1)',
                    borderWidth: 2
                }, {
                    label: 'Breakdown Complete',
                    data: <?php echo json_encode($completeData); ?>,
                    backgroundColor: 'rgba(0, 128, 0, 0.6)',
                    borderColor: 'rgba(0, 128, 0, 1)',
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
                    title: {
                        display: true,
                        text: 'Monthly Breakdown Status - <?php echo $year; ?>'
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