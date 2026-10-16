<?php
if (isset($_POST['search'])) {
    $selectedYear = $_POST['year'];
} else {
    $selectedYear = date('Y');
}


?>


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

                    <h4 class="card-title mb-3">PPM Status</h4>

                    <!-- Year Filter -->
                    <form method="post" action="">
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
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

                </div>
            </div>
        </div>
    </div>
</div>