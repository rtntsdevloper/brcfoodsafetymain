<?php

if (isset($_GET['year'])) {
    $cyear = $_GET['year'];
} else {
    $cyear = date("Y");
}
?>

<div class="container-fluid">
    <div class="row pb-3 bg-white pt-2">
        <div class="col-md-10 text-center">
            <h4 class="ml-5">Monthly Pest Incidence Report Year : <?php echo $cyear; ?></h4>
        </div>
        <div class="col-md-2 col-sm-3 ">
            <select id="select-option" class="form-select">
                <?php
                echo "<option>" . $cyear . "</option>";

                $qyear = mysqli_query($con, "SELECT DATE_FORMAT(`date_incidence`, '%Y') AS year FROM `tb_pest` GROUP BY year");
                foreach ($qyear as  $keyy) {
                    echo "<option value =" . $keyy['year'] . ">" . $keyy['year'] . "</option>";
                }

                ?>

            </select>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
            <script>
                $('#select-option').on('change', function() {
                    var selectedValue = $(this).val();
                    window.open('admin?id=trend&year=' + selectedValue, '_self');
                });
            </script>
        </div>
    </div>
</div>












<?php
$riskstr = '';
for ($i = 1; $i <= 12; $i++) {
    $riskstr .= $cyear . '-' . str_pad($i, 2, '0', STR_PAD_LEFT) . ',';
}
$riskstr = rtrim($riskstr, ',');
$months = explode(',', $riskstr)

?>




<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<canvas id="monthlyReportChart" style="border-radius: 2px solid black; background-color:white"></canvas>

<?php
$months = explode(',', $riskstr);

$lizardCounts = [];
$rodentCounts = [];
$cockCounts = [];
$othCounts = [];
$monthly = [];
foreach ($months as $key1 => $value1) {
    $sup1 = mysqli_query($con, " SELECT 
    DATE_FORMAT(`date_incidence`, '%Y-%m') AS complaint_month,
    SUM(pest_num) AS pest_num
FROM 
    tb_pest
WHERE 
    DATE_FORMAT(`date_incidence`, '%Y-%m') = '$value1' AND pest_type='lizard'
GROUP BY
    complaint_month");
    $cmpdt = mysqli_fetch_array($sup1);
    $count = mysqli_num_rows($sup1);  //get count row in query
    //  echo $count;
    if ($count == 0) {
        $totalcomp = 0;
    } else {
        $totalcomp = $cmpdt['pest_num'];
    }


    $lizardCounts[] = $totalcomp;

    $sup2 = mysqli_query($con, " SELECT 
    DATE_FORMAT(`date_incidence`, '%Y-%m') AS complaint_month,
    SUM(pest_num) AS pest_num
FROM 
    tb_pest
WHERE 
    DATE_FORMAT(`date_incidence`, '%Y-%m') = '$value1' AND pest_type='rodent'
GROUP BY
    complaint_month");
    $cmpdt1 = mysqli_fetch_array($sup2);
    $count1 = mysqli_num_rows($sup2);  //get count row in query
    //  echo $count;
    if ($count1 == 0) {
        $totalcomp1 = 0;
    } else {
        $totalcomp1 = $cmpdt1['pest_num'];
    }
    $rodentCounts[] = $totalcomp1;


    $sup3 = mysqli_query($con, " SELECT 
DATE_FORMAT(`date_incidence`, '%Y-%m') AS complaint_month,
SUM(pest_num) AS pest_num
FROM 
tb_pest
WHERE 
DATE_FORMAT(`date_incidence`, '%Y-%m') = '$value1' AND pest_type='cockroach' 
GROUP BY
complaint_month");
    $cmpdt2 = mysqli_fetch_array($sup3);
    $count2 = mysqli_num_rows($sup3);  //get count row in query
    //  echo $count;
    if ($count2 == 0) {
        $totalcomp2 = 0;
    } else {
        $totalcomp2 = $cmpdt2['pest_num'];
    }



    $cockCounts[] = $totalcomp2;

    $sup4 = mysqli_query($con, " SELECT 
DATE_FORMAT(`date_incidence`, '%Y-%m') AS complaint_month,
SUM(pest_num) AS pest_num
FROM 
tb_pest
WHERE 
DATE_FORMAT(`date_incidence`, '%Y-%m') = '$value1' AND pest_type='other' 
GROUP BY
complaint_month");
    $cmpdt3 = mysqli_fetch_array($sup4);
    $count3 = mysqli_num_rows($sup4);  //get count row in query
    //  echo $count;
    if ($count3 == 0) {
        $totalcomp3 = 0;
    } else {
        $totalcomp3 = $cmpdt3['pest_num'];
    }

    $othCounts[] = $totalcomp3;

    $monthly[] = date('M Y', strtotime($value1));
}



?>
<?php


?>

<script>
    const ctx = document.getElementById('monthlyReportChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($monthly); ?>,
            datasets: [{
                    label: 'Count of Lizard Found',
                    data: <?php echo json_encode($lizardCounts); ?>,
                    backgroundColor: 'rgb(198, 164, 53)',
                    borderColor: 'rgb(56, 64, 82)',
                    borderWidth: 1
                },
                {
                    label: 'Count of Rodent Found ',
                    data: <?php echo json_encode($rodentCounts); ?>,
                    backgroundColor: 'rgb(77,13,0)',
                    borderColor: 'rgb(56, 64, 82)',
                    borderWidth: 1
                },
                {
                    label: 'Count of Cockroaches Found',
                    data: <?php echo json_encode($cockCounts); ?>,
                    backgroundColor: 'rgba(54, 162, 235)',
                    borderColor: 'rgb(56, 64, 82)',
                    borderWidth: 1
                }, {
                    label: 'Count Other Pest Found',
                    data: <?php echo json_encode($othCounts); ?>,
                    backgroundColor: 'rgb(12, 75, 4)',
                    borderColor: 'rgb(56, 64, 82)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>