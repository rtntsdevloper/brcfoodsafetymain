<?php
include 'connection.php';
$monthlyData = [];

for ($i = 1; $i <= 12; $i++) {
    if ($i < 10) {
        $mname = '0' . $i . '-' . date('Y');
    } else {
        $mname = $i . '-' . date('Y');
    }

    $chart1 = mysqli_query($con, "SELECT 
        t1.subject AS section,
        t6.subtest AS subsection,
        t2.*,              
        t3.*,             
        t2.sid AS sid,     
        t2.id AS sno,     
        t2.date AS auditdate,
        t4.name AS auditor,
        t5.name AS auditee
    FROM 
        addtest1 t1,
        tblroster t2,
        saveaudit t3,
        tblauditor t4,
        tblauditee t5,
        subtest t6
    WHERE 
        DATE_FORMAT(t2.date, '%m-%Y') = '$mname'
        AND t3.sno = t2.id
        AND t6.sid = t2.sid
        AND t1.testid = t2.tid
        AND t4.id = t2.auditor
        AND t5.id = t2.auditee
    GROUP BY 
        t2.sid, t2.auditor, t2.auditee");

    // Initialize monthly counters
    $monthCritical = 0;
    $monthMinor = 0;
    $monthMajor = 0;
    $monthCompliant = 0;
    $monthTotal = 0;

    while ($chart2 = mysqli_fetch_array($chart1)) {
        $aauditdate = date("d-m-Y", strtotime($chart2['auditdate']));

        $amajor = mysqli_query($con, "select * from saveaudit where ans='Major' and sid='$chart2[sid]' and sno='$chart2[sno]'");
        $cmajor1 = mysqli_num_rows($amajor);

        $aminor = mysqli_query($con, "select * from saveaudit where ans='Minor' and sid='$chart2[sid]'  and sno='$chart2[sno]'");
        $cminor1 = mysqli_num_rows($aminor);

        $acompliant = mysqli_query($con, "select * from saveaudit where ans='Compliant' and sid='$chart2[sid]'  and sno='$chart2[sno]'");
        $ccompliant1 = mysqli_num_rows($acompliant);

        $acritical = mysqli_query($con, "select * from saveaudit where ans='Critical' and sid='$chart2[sid]' and sno='$chart2[sno]'");
        $ccritical1 = mysqli_num_rows($acritical);

        // Accumulate counts for the month
        $monthCritical += $ccritical1;
        $monthMinor += $cminor1;
        $monthMajor += $cmajor1;
        $monthCompliant += $ccompliant1;
    }

    // Calculate total for the month
    $monthTotal = $monthCritical + $monthMinor + $monthMajor + $monthCompliant;

    // Store data for the month
    $monthName = DateTime::createFromFormat('m-Y', $mname)->format('M Y');
    $monthlyData[$monthName] = [
        "Critical" => $monthCritical,
        "Minor" => $monthMinor,
        "Major" => $monthMajor,
        "Compliant" => $monthCompliant,
        "Total" => $monthTotal
    ];
}

// Prepare data for each category (including Total)
$categories = ["Critical", "Minor", "Major", "Compliant", "Total"];
$chartData = [];

foreach ($categories as $category) {
    $dataPoints = [];
    foreach ($monthlyData as $month => $values) {
        $dataPoints[] = array("label" => $month, "y" => $values[$category]);
    }
    
    // Customize the Total series to make it stand out
    if ($category === "Total") {
        $chartData[] = array(
            "type" => "bar", // Use line for total to make it visible
            "name" => $category,
            "showInLegend" => true,
            "markerSize" => 8,
            "color" => "#000000",
            "lineThickness" => 3,
            "dataPoints" => $dataPoints
        );
    } else {
        $chartData[] = array(
            "type" => "column",
            "name" => $category,
            "showInLegend" => true,
            "dataPoints" => $dataPoints
        );
    }
}
?>

<script>
window.onload = function() {
    var chart = new CanvasJS.Chart("chartContainer", {
        animationEnabled: true,
        exportEnabled: true,
        theme: "light1",
        title: {
            text: "Monthly Audit Summary - <?php echo date('Y'); ?>"
        },
        axisX: {
            title: "Months",
            labelAngle: -45
        },
        axisY: {
            title: "Number of Findings",
            includeZero: true
        },
        axisY2: {
            title: "Total Findings",
            includeZero: true
        },
        toolTip: {
            shared: true
        },
        legend: {
            cursor: "pointer",
            itemclick: function(e) {
                e.dataSeries.visible = !(typeof e.dataSeries.visible === "undefined" || e.dataSeries.visible);
                chart.render();
            }
        },
        data: <?php echo json_encode($chartData, JSON_NUMERIC_CHECK); ?>
    });

    chart.render();
}
</script>

<div id="chartContainer" style="height: 450px; width: 100%;"></div>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>