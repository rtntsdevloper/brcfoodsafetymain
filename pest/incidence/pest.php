<?php
$v = "SELECT * FROM tb_pest ";
$v1 = mysqli_query($con, $v);




?>



<section class="section">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-9 ">
              <h5 class="card-title">Pest Management Details</h5>
            </div>
            <div class="col-md-3 text-center col-sm-3">

              <a href="admin.php?id=Pest_add" class="btn btn-primary text-right mt-3 ">Add Pest Details</a>
              <a href="admin.php?id=Pest_dashboard" class="btn  btn-success  mt-3">Go Back</a>

            </div>

          </div>

          <div class="table-responsive">


            <!-- Table with stripped rows -->
            <table class="display table table-striped table-bordered text-center" id="zero_configuration_table">
              <thead>
                <tr>
                  <th class='text-center'>S.No</th>
                  <th class='text-center'>Date of Incidence</th>
                  <th class='text-center'>Area of Pest Found</th>
                  <th class='text-center'>Type of Pest</th>
                  <th class='text-center'>Number of Pest Found</th>
                  <th class='text-center'>File</th>
                  


                </tr>
              </thead>
              <tbody>

                <?php
                $i = 1;
                foreach ($v1 as $key) { ?>
                  <tr>

                    <td><?php echo $i; ?></td>
                    <td><?php echo date('d-m-Y', strtotime($key['date_incidence'])); ?></td>
                    <td><?php echo $key['found']; ?></td>
                    <td><?php echo $key['pest_type']; ?></td>
                    <td><?php echo $key['pest_num']; ?></td>
                    <td><?php
                          echo " <a href='pest/img/" . $key['add_pdf'] . "'target='_blank' class='btn btn-dark'>View</a>";
                        ?>
                    </td>




                  </tr>

                <?php
                  $i++;
                } ?>



              </tbody>
            </table>
            <!-- End Table with stripped rows -->
          </div>
        </div>
      </div>

    </div>