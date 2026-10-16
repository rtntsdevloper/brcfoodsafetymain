
 <div class="main-content">
   <div class="breadcrumb">
     <h1 class="mr-2"><?php echo $headingname; ?></h1>
     <ul>
       <li><a href="">Home</a></li>
       <li>Premedical Reports</li>
     </ul>
   </div>
  

   <div class="row mb-12" id="des">
     <div class="col-md-12 mb-12">
       <div class="card text-left">
         <div class="card-body">




           <h4 class="card-title mb-3">Premedical Records</h4>



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

                  $sql = mysqli_query($con, "SELECT DISTINCT date,name FROM `saveques` where module='premedical' ORDER BY date DESC");
                  $i = 0;
                  while ($row = mysqli_fetch_array($sql)) {
                    $i++;
                    $vdate = date('d-m-Y', strtotime($row['date']));

                  ?>
                   <tr nobr="true">
                     <td><?php echo $i; ?></td>
                     <td><?php echo $vdate; ?></td>
                     <td><?php echo $row['name']; ?></td>
                     <td><a href="upl1/PRE_<?php echo $vdate . '-' . $row['name']; ?>.pdf" class="btn btn-primary">View Report</a></td>

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


    