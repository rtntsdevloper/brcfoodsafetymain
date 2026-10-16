<?php 

  $v = "SELECT * FROM tb_visit ";
  $v1 = mysqli_query($con,$v);


 

?>

    

    <section class="section">
     <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-9">  <h5 class="card-title">Visit Record</h5></div>
                <div class="col-md-3 col-sm-5 text-center">
                  <a href="admin.php?id=visit_add" class="btn btn-primary text-right mt-3">Add Visit Record</a>
                  <a href="admin.php?id=Pest_dashboard" class="btn  btn-success  mt-3">Go Back</a>
                </div>
                
              </div>
              <div class="col-md-12">

               <!-- Table with stripped rows -->
               <table class="table datatable text-center">
                <thead>
                  <tr>
                    <th class='text-center'>S.No</th>
                    <th class='text-center'>Date of Visit</th>
                    <th class='text-center'>Next Date of Visit</th>
                    <th class='text-center'>Operator Name</th>
                    <th class='text-center'>Activites Conducted</th>
                  
                    
                  </tr>
                </thead>
                <tbody>

                <?php 
                $i =1;
                foreach($v1 as $key){?>
                <tr>
  <td><?php  echo $i;?></td>
                
                <td><?php echo date('d-m-Y',strtotime($key['date'])) ?></td>
                <td><?php echo date('d-m-Y',strtotime($key['next_date'])) ?></td>
                <td><?php  echo $key['name'];?></td>
                
                <td><?php 
                  echo $key['activity'];
                ?></td>
                </tr>
              
          

                  <?php
                  $i++;
                }?>
                  
                  

                </tbody>
              </table>

              </div>
            
            
             
              <!-- End Table with stripped rows -->

            </div>
          </div>

        </div>
    

 