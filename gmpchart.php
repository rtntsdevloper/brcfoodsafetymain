<?php

include 'connection.php';
$date1 = $year . "-" . $month . "-01";
$date2 = date("Y-m-t", strtotime($date1));









$sql0 = mysqli_query($con, "select t1.name as section,t2.*,t3.*,t2.id as sd,t2.id AS sno, t2.date as auditdate , t4.name as auditor,t5.name as auditee from tblauditsection1 t1, tblgmpaudit2 t2, tblgmpaudit3 t3, tblauditor t4, tblauditee t5 where (t2.date BETWEEN '$date1' and '$date2') and t2.audit='$sid'  and t1.sid=t2.audit and t1.id=t2.sid and t3.sno=t2.id and t4.id=t2.auditor and t5.id=t2.auditee group by t2.sid,t2.auditor,t2.auditee,t2.date");
$i = 1;
while ($rows0 = mysqli_fetch_array($sql0)) {
    $auditdate = date("d-m-Y", strtotime($rows0['auditdate']));


    $major = mysqli_query($con, "select * from tblgmpaudit3 where ans='Major' and sno='$rows0[sd]'");
    $major1 = mysqli_num_rows($major);


    $minor = mysqli_query($con, "select * from tblgmpaudit3 where ans='Minor' and sno='$rows0[sd]'");
    $minor1 = mysqli_num_rows($minor);


    $compliant = mysqli_query($con, "select * from tblgmpaudit3 where ans='Compliant' and sno='$rows0[sd]'");
    $compliant1 = mysqli_num_rows($compliant);


    $chartData[] = [
        'section' => $rows0['section'],
        'major' => $major1,
        'minor' => $minor1,
        'compliant' => $compliant1,
    ];
    $chartDataJson = json_encode($chartData);

    $i++;
}

?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<div class="col-md-12 bg-white" style="height: auto;">
    <h1 class="text-center">GMP Trending <?php echo date("F", strtotime($date1)); ?></h1>
    <canvas id="auditChart"></canvas>
</div>
<script>
    const chartData = <?php echo $chartDataJson; ?>;

    // Extract labels (sections) and datasets
    const labels = chartData.map(item => item.section);
    const majorData = chartData.map(item => item.major);
    const minorData = chartData.map(item => item.minor);
    const compliantData = chartData.map(item => item.compliant);

    // Create chart
    const ctx = document.getElementById('auditChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                    label: 'Major',
                    data: majorData,
                    backgroundColor: 'rgba(255, 99, 132, 0.7)',
                },
                {
                    label: 'Minor',
                    data: minorData,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                },
                {
                    label: 'Compliant',
                    data: compliantData,
                    backgroundColor: 'rgba(75, 192, 104, 0.7)',
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>