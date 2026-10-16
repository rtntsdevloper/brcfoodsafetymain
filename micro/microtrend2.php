<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Results Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-container {
            width: 90%;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .controls {
            margin: 20px auto;
            width: 90%;
            text-align: center;
        }
        select {
            padding: 8px;
            margin: 0 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="controls">
        <label for="subjectSelect">Select Subject:</label>
        <select id="subjectSelect">
            <option value="all">All Subjects</option>
        </select>
    </div>
    <div class="chart-container">
        <canvas id="testResultsChart"></canvas>
    </div>

    <script>
        // Your JavaScript code will go here
    </script>
</body>
</html><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Results Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-container {
            width: 90%;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .controls {
            margin: 20px auto;
            width: 90%;
            text-align: center;
        }
        select {
            padding: 8px;
            margin: 0 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="controls">
        <label for="subjectSelect">Select Subject:</label>
        <select id="subjectSelect">
            <option value="all">All Subjects</option>
        </select>
    </div>
    <div class="chart-container">
        <canvas id="testResultsChart"></canvas>
    </div>

    <script>
        // Your JavaScript code will go here
    </script>
</body>
</html>
<script>
// Sample data for test results
const testData = {
    months: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
    subjects: ['Mathematics', 'Science', 'English', 'History'],
    results: {
        Mathematics: {
            pass: [45, 52, 48, 60, 55, 65, 58, 62, 70, 68, 72, 75],
            fail: [15, 12, 18, 10, 15, 8, 12, 10, 5, 7, 8, 6],
            retest: [8, 6, 10, 5, 8, 4, 7, 5, 3, 4, 3, 2]
        },
        Science: {
            pass: [38, 45, 50, 48, 52, 55, 58, 60, 62, 65, 68, 70],
            fail: [20, 18, 15, 16, 14, 12, 10, 11, 9, 8, 7, 6],
            retest: [10, 8, 7, 9, 8, 6, 5, 6, 5, 4, 3, 3]
        },
        English: {
            pass: [50, 55, 52, 58, 60, 62, 65, 68, 70, 72, 75, 78],
            fail: [12, 10, 15, 9, 8, 7, 6, 5, 4, 5, 4, 3],
            retest: [5, 4, 6, 4, 3, 3, 2, 2, 1, 2, 1, 1]
        },
        History: {
            pass: [42, 45, 48, 50, 52, 55, 53, 56, 58, 60, 62, 65],
            fail: [18, 16, 15, 14, 13, 10, 12, 11, 9, 8, 7, 6],
            retest: [7, 6, 5, 5, 4, 3, 4, 3, 2, 2, 1, 1]
        }
    }
};

// Initialize subject dropdown
const subjectSelect = document.getElementById('subjectSelect');
testData.subjects.forEach(subject => {
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
        pass: { border: '#4CAF50', background: 'rgba(76, 175, 80, 0.1)' },
        fail: { border: '#F44336', background: 'rgba(244, 67, 54, 0.1)' },
        retest: { border: '#FF9800', background: 'rgba(255, 152, 0, 0.1)' }
    };
    const labels = {
        pass: 'Pass',
        fail: 'Fail',
        retest: 'Retest'
    };

    if (selectedSubject === 'all') {
        // Show all subjects aggregated
        resultTypes.forEach(type => {
            const data = testData.months.map((month, index) => {
                return testData.subjects.reduce((sum, subject) => {
                    return sum + testData.results[subject][type][index];
                }, 0);
            });
            
            datasets.push({
                label: `${labels[type]} (All Subjects)`,
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
        resultTypes.forEach(type => {
            datasets.push({
                label: `${labels[type]} (${selectedSubject})`,
                data: testData.results[selectedSubject][type],
                borderColor: colors[type].border,
                backgroundColor: colors[type].background,
                borderWidth: 3,
                tension: 0.4,
                fill: true
            });
        });
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
            labels: testData.months,
            datasets: datasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: selectedSubject === 'all' 
                        ? 'Monthly Test Results - All Subjects' 
                        : `Monthly Test Results - ${selectedSubject}`,
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
                            return `${context.dataset.label}: ${context.parsed.y} students`;
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
                        text: 'Number of Students',
                        font: {
                            weight: 'bold'
                        }
                    },
                    beginAtZero: true,
                    ticks: {
                        stepSize: 10
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

// Initialize the chart
initializeChart();
</script>