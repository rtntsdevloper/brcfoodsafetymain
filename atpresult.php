  <div class="main-content">
      <div class="breadcrumb">
          <h1 class="mr-2"><?php echo $headingname; ?></h1>
          <ul>
              <li><a href="">ATP Results</a></li>
              <li>View Detail</li>
          </ul>
      </div>




      <div class="row mb-12">
          <div class="col-md-12 mb-12">
              <div class="card text-left">
                  <div class="card-body">

                      <a href="admin.php?id=1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                      <a href="admin.php?id=atpresult1"><button class="btn btn-info" style="float:right; margin-left:15px">Upload CSV</button></a>

                      <h4 class="card-title mb-3">ATP Result Details</h4>
                      <div class="row">
                          <div class="table-responsive">
                              <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                  <thead>
                                      <tr>

                                          <th>S no
                                          </th>
                                          <th>Date</th>
                                          <th>Total Swavs</th>
                                          <th>Pass</th>
                                          <th>Fail</th>
                                          <th>Caution</th>
                                          <th>Detail</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php
                                        $sql = mysqli_query($con, "select distinct date from tblatp order by date desc");

                                        $i = 0;
                                        while ($row = mysqli_fetch_array($sql)) {
                                            $i++;
                                            $sql1 = mysqli_query($con, "select *  from tblatp where date='$row[date]'");
                                            $totalrow = mysqli_num_rows($sql1);
                                            $pass =0;
                                            $fail= 0;
                                            $caut = 0;
                                            foreach($sql1 as $pdrd1){
                                                if($pdrd1['result'] =='Pass'){
                                                   $pass = $pass+1;
                                                }
                                                elseif($pdrd1['result'] =='Fail'){
                                                    $fail = $fail+1;
                                                }
                                                 elseif($pdrd1['result'] =='Caution'){
                                                    $caut = $caut+1;
                                                 }

                                            }

                                        ?>
                                          <tr>
                                              <td><?php echo $i; ?></td>
                                              <td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
                                              <td><?php echo $totalrow; ?></td>
                                               <td><?php echo $pass; ?></td>
                                                <td><?php echo $fail; ?></td>
                                                 <td><?php echo $caut; ?></td>
                                              <td><a href="admin.php?id=viewatp&date=<?php echo $row['date']; ?>" target="_blank"><button class="btn btn-info">View</button></a></td>
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
          </div>
      </div>











      <?php
        // Database connection
        $cyear = isset($_GET['dyear']) ? $_GET['dyear'] : date("Y");

        // Query to get monthly data for selected year
        $monthlyData = array();
        $monthQuery = mysqli_query($con, "SELECT 
    DATE_FORMAT(date, '%Y-%m') AS month,
    SUM(CASE WHEN result = 'Pass' THEN 1 ELSE 0 END) AS pass_count,
    SUM(CASE WHEN result = 'Fail' THEN 1 ELSE 0 END) AS fail_count,
    SUM(CASE WHEN result = 'Caution' THEN 1 ELSE 0 END) AS caution_count,
    COUNT(*) AS total_count
FROM `tblatp`
WHERE YEAR(date) = '$cyear'
GROUP BY DATE_FORMAT(date, '%Y-%m')
ORDER BY month ASC");

        // Create array with all months of the year
        $allMonths = array();
        for ($i = 1; $i <= 12; $i++) {
            $month = str_pad($i, 2, '0', STR_PAD_LEFT);
            $allMonths["$cyear-$month"] = array(
                'month' => "$cyear-$month",
                'pass_count' => 0,
                'fail_count' => 0,
                'caution_count' => 0,
                'total_count' => 0
            );
        }

        // Merge with actual data
        while ($row = mysqli_fetch_assoc($monthQuery)) {
            $allMonths[$row['month']] = $row;
        }

        // Prepare data for chart
        $chartData = array_values($allMonths);
        ?>






      <div class="row">
          <div class="col-md-3 col-sm-5">
              <label for="">Select Year for Graph</label>
              <select name="" id="datayear" class="form-control">
                  <?php
                    echo '<option value="' . $cyear . '">' . $cyear . '</option>';
                    $month1 = "SELECT DATE_FORMAT(date, '%Y') AS compyear FROM `tblatp` GROUP BY compyear";
                    $month1y = mysqli_query($con, $month1);

                    foreach ($month1y as $dcmnth) {
                        echo '<option value="' . $dcmnth['compyear'] . '">' . $dcmnth['compyear'] . '</option>';
                    }
                    ?>


              </select>


              <script>
                  $('#datayear').on('change', function() {
                      var selectedValue = $(this).val();
                      window.open('admin?id=atpresult&dyear=' + selectedValue, '_self');
                  });
              </script>
          </div>
      </div>

      <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
      <style>
          .canvasjs-chart-credit {
              display: none !important;
          }

          #chartContainer {
              height: 400px;
              width: 90%;
              margin: 20px auto;
          }
      </style>

      <div id="chartContainer"></div>

      <script>
          window.onload = function() {
              var chart = new CanvasJS.Chart("chartContainer", {
                  animationEnabled: true,
                  title: {
                      text: "Monthly ATP Results for <?php echo $cyear; ?>"
                  },
                  axisX: {
                      title: "Month",
                      interval: 1,

                  },
                  axisY: {
                      title: "Count",
                      includeZero: true
                  },
                  toolTip: {
                      shared: true,
                      content: "{name}: {y}<br/>Total: {total}"
                  },
                  legend: {
                      cursor: "pointer",
                      itemclick: toggleDataSeries
                  },
                  data: [{
                          type: "column",
                          name: "Pass",
                          showInLegend: true,
                          color: "#4CAF50",
                          dataPoints: [
                              <?php
                                foreach ($chartData as $month) {
                                    $monthName = date('M', strtotime($month['month']));
                                    echo "{ label: '$monthName', y: " . $month['pass_count'] . ", total: " . $month['total_count'] . " },";
                                }
                                ?>
                          ]
                      },
                      {
                          type: "column",
                          name: "Caution",
                          showInLegend: true,
                          color: "#FFC107",
                          dataPoints: [
                              <?php
                                foreach ($chartData as $month) {
                                    $monthName = date('M', strtotime($month['month']));
                                    echo "{ label: '$monthName', y: " . $month['caution_count'] . ", total: " . $month['total_count'] . " },";
                                }
                                ?>
                          ]
                      },
                      {
                          type: "column",
                          name: "Fail",
                          showInLegend: true,
                          color: "#F44336",
                          dataPoints: [
                              <?php
                                foreach ($chartData as $month) {
                                    $monthName = date('M', strtotime($month['month']));
                                    echo "{ label: '$monthName', y: " . $month['fail_count'] . ", total: " . $month['total_count'] . " },";
                                }
                                ?>
                          ]
                      },
                      {
                          type: "column",
                          name: "Total",
                          showInLegend: true,
                          color: "#40E0D0",
                          lineThickness: 3,
                          markerType: "square",
                          dataPoints: [
                              <?php
                                foreach ($chartData as $month) {
                                    $monthName = date('M', strtotime($month['month']));
                                    echo "{ label: '$monthName', y: " . $month['total_count'] . " },";
                                }
                                ?>
                          ]
                      }
                  ]
              });

              chart.render();

              function toggleDataSeries(e) {
                  if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                      e.dataSeries.visible = false;
                  } else {
                      e.dataSeries.visible = true;
                  }
                  chart.render();
              }
          }
      </script>