<?php
// Database connection (make sure $con is properly initialized)
$ssid = $_GET['ssid'];
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
$subjects = ['Egg', 'Milk', 'Almond', 'Gluten'];

// Get aggregated data for all subjects
$allSubjectsData = [
    'subject' => 'All Types',
    'pass' => [],
    'fail' => []
];

foreach ($months as $month) {
    $totalPass = 0;
    $totalFail = 0;

    // Query to get data for this month
    $minenm = mysqli_query($con, "SELECT  SUM(CASE WHEN s2.input = 'Positive' THEN 1 ELSE 0 END) AS cfail,
        SUM(CASE WHEN s2.input = 'Negative' THEN 1 ELSE 0 END) AS cpass,s2.input,s1.date,s2.ques,s1.name FROM `dailychecks2` as s2 JOIN `dailycheckss` as s1 ON s1.id = s2.cid WHERE s1.name = $ssid and s2.ques='Result' AND DATE_FORMAT(s2.date, '%Y-%m') = '$month'");

    $minenm1 = mysqli_fetch_assoc($minenm);

    $allSubjectsData['pass'][] = $minenm1 ? (int)$minenm1['cpass'] : 0;
    $allSubjectsData['fail'][] = $minenm1 ? (int)$minenm1['cfail'] : 0;
}

$microvalue[] = $allSubjectsData;

// Format months for display
$formattedMonths = array_map(function ($month) {
    return date('M Y', strtotime($month));
}, $months);

// Convert PHP arrays to JSON for JavaScript
$monthlyDataJson = json_encode($microvalue);
$monthsJson = json_encode($formattedMonths);
?>

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


<div class="chart-container">
    <div class="row">
        <div class="col-md-6">
            <form method="GET" style="display: inline;">
                <label for="yearSelect">Select Year:</label>
                <select name="year" id="yearSelect" onchange="getnewyear(this.value)">
                    <?php
                    $yuin = mysqli_query($con, "SELECT distinct year(date) as year FROM `dailycheckss` where name= $ssid order by year desc");
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
        <div class="col-md-6">
             <a href="admin.php?id=dailychecks&tid=<?php echo $ssid; ?>"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
        </div>

        <script>
            function getnewyear(year) {
                window.location.href = "admin.php?id=dailycheckallergen&year=" + year+"&ssid="+<?php echo $ssid; ?>;
            }
        </script>
    </div>
    <div class="col-md-12 text-right mt-3">
        <button id="download" class="btn btn-info"><i class="fa fa-download"> Download chart image</i></button>
    </div>

    <canvas id="testResultsChart" class="mb-5"></canvas>
</div>

<script>
    // PHP data converted to JavaScript
    const monthlyData = <?php echo $monthlyDataJson; ?>;
    const months = <?php echo $monthsJson; ?>;

    // Chart configuration
    const ctx = document.getElementById('testResultsChart').getContext('2d');
    let chart;

    // Function to create datasets (only All Types)
    function createDatasets() {
        const datasets = [];
        const resultTypes = ['pass', 'fail'];
        const colors = {
            pass: {
                border: '#0c590fff',
                background: 'rgba(76, 175, 80, 0.1)'
            },
            fail: {
                border: '#d41709ff',
                background: 'rgba(244, 67, 54, 0.1)'
            }
        };
        const labels = {
            pass: 'Negative',
            fail: 'Positive'
        };

        // Always show aggregated data for All Types
        resultTypes.forEach(type => {
            const data = monthlyData[0] ? monthlyData[0][type] : months.map(() => 0);

            datasets.push({
                label: labels[type],
                data: data,
                borderColor: colors[type].border,
                backgroundColor: colors[type].background,
                borderWidth: 3,
                tension: 0.4,
                fill: true
            });
        });

        return datasets;
    }

    // Function to initialize chart
    function initializeChart() {
        const datasets = createDatasets();

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
                        text: `Allergen Test- Inhouse (<?php echo $cyear; ?>)`,
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
                            text: 'Number of Tests',
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

    // Download chart image
    document.getElementById('download').addEventListener('click', function() {
        const link = document.createElement('a');
        link.download = 'micro-trending-chart.png';
        link.href = chart.toBase64Image();
        link.click();
    });

    // Initialize the chart
    initializeChart();
</script>









<div class="row mb-12">
    <div class="col-md-12 mb-12">
        <div class="card text-left">
            <div class="card-body">

               
                <h4 class="card-title mb-3">Allergen Test - Inhouse (<?php echo $cyear; ?>)</h4>

                <p>List of tests</p>

                <div class="table-responsive">
                    <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Date</th>
                                <th scope="col">Result</th>
                                <th scope="col">Type</th>
                                <th scope="col">Attempted By</th>



                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = mysqli_query($con, "SELECT s1.id,s2.input,s1.ename,s1.date,s2.ques,s1.name FROM `dailychecks2` as s2 JOIN `dailycheckss` as s1 ON s1.id = s2.cid WHERE s1.name = $ssid and s2.ques ='Result' and year(s1.date) = '$cyear' order by date desc ");
                            $i = 0;
                            while ($row = mysqli_fetch_array($sql)) {
                                $i++;
                                $rowid = $row['id'];
                               
                                $sqlx = mysqli_query($con, "select * from `dailychecks2` where cid='$rowid'");
                                $rowx = mysqli_fetch_array($sqlx);
                            ?>
                                <tr>
                                    <th scope="row"><?php echo $i; ?></th>
                                    <td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
                                    <td><?php echo $row['input']; ?></td>
                                    <td><?php echo $rowx['input']; ?> </td>
                                    <td><?php echo $row['ename']; ?> </td>


                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>