 <?php
  if (isset($_GET['dmonth'])) {
    $month = $_GET['dmonth'];
  } else {
    $month = date('m');
  }

  if (isset($_GET['dyear'])) {
    $cyear = $_GET['dyear'];
  } else {
    $cyear = date('Y');
  }

  $visitmonth = $cyear . '-' . $month;


  ?>

 <div class="main-content">
   <div class="breadcrumb">
     <h1 class="mr-2"><?php echo $headingname; ?></h1>
     <ul>
       <li><a href="">Home</a></li>
       <li>Visitor Trending </li>
     </ul>
   </div>
   <div class="card-body">
     <div class="col-md-12">
       <div class="page_title">

         <div class="row">


           <div class="col-md-3">
             <div class="form-group label-floating">
               <label class="control-label" id="error2">Select Month</label>
               <select name="month" id="month" class="form-control" required>
                 <option value="">Please Select</option>
                 <option value="01" <?php if ($month == "01") echo "selected"; ?>>January</option>
                 <option value="02" <?php if ($month == "02") echo "selected"; ?>>February</option>
                 <option value="03" <?php if ($month == "03") echo "selected"; ?>>March</option>
                 <option value="04" <?php if ($month == "04") echo "selected"; ?>>April</option>
                 <option value="05" <?php if ($month == "05") echo "selected"; ?>>May</option>
                 <option value="06" <?php if ($month == "06") echo "selected"; ?>>June</option>
                 <option value="07" <?php if ($month == "07") echo "selected"; ?>>July</option>
                 <option value="08" <?php if ($month == "08") echo "selected"; ?>>August</option>
                 <option value="09" <?php if ($month == "09") echo "selected"; ?>>September</option>
                 <option value="10" <?php if ($month == "10") echo "selected"; ?>>October</option>
                 <option value="11" <?php if ($month == "11") echo "selected"; ?>>November</option>
                 <option value="12" <?php if ($month == "12") echo "selected"; ?>>December</option>
               </select>
             </div>
           </div>


           <div class="col-md-3">
             <div class="form-group label-floating">
               <label class="control-label" id="error2">Enter Year</label>
               <input type="text" name="year" id="year" class="form-control" value="<?php echo $cyear; ?>" />
             </div>
           </div>



           <div class="col-md-3">
             <div class="form-group label-floating">

               <br />
               <button class="btn btn-danger" type="submit" id="slctgo">Select & Go</button>
             </div>
           </div>
         </div>
       </div>
     </div>
   </div>



   <script>
     $('#slctgo').on('click', function() {
       var year = $('#year').val();
       var month = $('#month').val();

       window.open('admin?id=visitortrending&dyear=' + year + '&dmonth=' + month, '_self');
     });
   </script>



   <div class="row mb-12" id="des">
     <div class="col-md-12 mb-12">
       <div class="card text-left">
         <div class="card-body">




           <h4 class="card-title mb-3">Visitor TRENDING</h4>



           <div class="table-responsive mb-5">

             <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
               <thead>
                 <tr>
                   <th>Sno</th>
                   <th>Date of Attempt</th>
                   <th>Name</th>
                   <th>View Report</th>
                 </tr>
               </thead>
               <tbody>

                 <?php

                  $sql = mysqli_query($con, "SELECT * FROM `visit` WHERE DATE_FORMAT(date, '%Y-%m') = '$visitmonth' group by name");
                  $i = 0;
                  while ($row = mysqli_fetch_array($sql)) {
                    $i++;
                    $vdate = date('d-m-Y', strtotime($row['date']));

                  ?>
                   <tr nobr="true">
                     <td><?php echo $i; ?></td>
                     <td><?php echo $vdate; ?></td>
                     <td><?php echo $row['name']; ?></td>
                     <td><a href="upl1/<?php echo $vdate . '-' . $row['visitcode']; ?>.pdf" class="btn btn-primary">View Report</a></td>

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


     <style>
       .canvasjs-chart-credit {
         display: none !important;
       }
     </style>

     <?php
      $currentYearData = array();
      $riskstr = '' . $cyear . '-01,' . $cyear . '-02,' . $cyear . '-03,' . $cyear . '-04,' . $cyear . '-05,' . $cyear . '-06,' . $cyear . '-07,' . $cyear . '-08,' . $cyear . '-09,' . $cyear . '-10,' . $cyear . '-11,' . $cyear . '-12';

      $compraw = explode(',', $riskstr);

      // Get current year data for all months
      foreach ($compraw as $keyy => $valuey) {
        $donequery = mysqli_query($con, "SELECT 
        DATE_FORMAT(date, '%Y-%m') AS complaint_month
        
    FROM 
        saveques
    WHERE 
        DATE_FORMAT(date, '%Y-%m') = '$valuey'
    GROUP BY 
        complaint_month,name");

        $dom = mysqli_fetch_array($donequery);
        $donen = mysqli_num_rows($donequery);

        $currentYearData[$valuey] = ($donen > 0) ? $donen : 0;
      }


      // Prepare data points for chart
      $currentYearPoints = array();

      foreach ($compraw as $month) {
        $monthName = date("M", strtotime($month));
        $currentY = isset($currentYearData[$month]) ? $currentYearData[$month] : 0;

        $currentYearPoints[] = array(
          "label" => $monthName,
          "y" => $currentY
        );
      }

      ?>

     <script>
       window.onload = function() {
         var chart = new CanvasJS.Chart("chartContainer", {
           animationEnabled: true,
           exportEnabled: true,
           theme: "light1",
           title: {
             text: "Visitor Trending (<?php echo $cyear; ?>)"
           },
           axisX: {
             title: "Month",
             interval: 1
           },
           axisY: {
             title: "Number of Complaints",
             includeZero: true
           },
           toolTip: {
             shared: true
           },
           data: [{
             type: "column",
             name: "<?php echo $cyear; ?>",
             indexLabel: "{y}",
             indexLabelPlacement: "outside",
             color: "#369EAD",
             dataPoints: <?php echo json_encode($currentYearPoints, JSON_NUMERIC_CHECK); ?>
           }]
         });
         chart.render();
       }
     </script>

     <div id="chartContainer" style="height: 400px; width: 100%;"></div>
     <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>