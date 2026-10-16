<?php
include 'connection.php'
?>
        <style>
    .canvasjs-chart-credit {
        display: none !important;
    }
</style>


<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

<div id="chartContainer" style="height: 370px; width: 100%; margin: 10% 0% ; overflow:scroll"></div>

<script>
    window.onload = function() {
        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            title: {
                text: "Service Supplier KPI"
            },
            subtitles: [{

            }],
            data: [
                <?php
                $sp = mysqli_query($con, "SELECT * FROM `tblrawsupplier` WHERE suptype = 'Service Supplier'");
                foreach ($sp as $spr) {
                    $supnm = $spr['supname']; ?> {
                        type: "column",
                        name: "<?php echo $supnm; ?>",
                        legendText: "<?php echo $supnm; ?>",
                        showInLegend: "true",
                        dataPoints: [
                            <?php

                            $riskarr = explode(',', $riskstr);
                            foreach ($riskarr as $key1 => $value1) {
                                $sup1 = mysqli_query($con, " SELECT 
                  supplier, 
                  DATE_FORMAT(date, '%Y-%m') AS complaint_month,
                  COUNT(*) AS total_complaints
                FROM 
                 tblsuppliercomplaint
                WHERE 
                  DATE_FORMAT(date, '%Y-%m') = '$value1'
                  AND supplier = '$supnm'
                GROUP BY 
                  supplier, complaint_month;
              ");
                                $cmpdt = mysqli_fetch_array($sup1);
                                $count = mysqli_num_rows($sup1);  //get count row in query
                                //  echo $count;
                                if ($count == 0) {
                                    $totalcomp = 0;
                                } else {
                                    $totalcomp = $cmpdt['total_complaints'];
                                }
                            ?> {
                                    y: <?php echo $totalcomp; ?>,
                                    label: "<?php echo $value1; ?>"
                                },
                            <?php
                            }
                            ?>
                        ]
                    },
                <?php
                }
                ?>
            ]
        });
        chart.render();

        chart.render();
        var chartImage = chart.toDataURL();
        $.ajax({
            type: "POST",
            url: "generate-pdf.php",
            data: {
                chartImage: chartImage
            }
        });
    }
</script>