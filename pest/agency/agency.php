<?php
include 'connection.php';

$v = "SELECT * FROM tb_pestagency ";
$v1 = mysqli_query($con, $v);




?>



<section class="section">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-9 ">
              <h5 class="card-title">Pest Control Agency Details</h5>
            </div>
            <div class="col-md-3 col-sm-5 text-center">
              <a href="admin.php?id=agency_add" class="btn btn-primary text-right mt-3">Add Pest Control Agency</a>
              <a href="admin.php?id=agency_view" class="btn  btn-success  mt-3">Go Back</a>
            </div>
          </div>
          <div class="col-md-12">

            <!-- Table with stripped rows -->
            <table class="table datatable text-center">
              <thead>
                <tr>
                  <th class='text-center'>S.No</th>
                  <th class='text-center'>Pest Control Agency Name</th>
                  <th class='text-center'>Agreement Date</th>
                  <th class='text-center'>Agreement</th>
                  <th class='text-center'>License</th>
                  <th class='text-center'>status</th>
                  <th class='text-center'>Action</th>


                </tr>
              </thead>
              <tbody>

                <?php
                $i = 1;
                foreach ($v1 as $key) { ?>

                  <td><?php echo $i; ?></td>
                  <td><?php echo $key['name']; ?></td>
                  <td><?php echo date('d-m-Y', strtotime($key['date_start'])) . " - " . date('d-m-Y', strtotime($key['date_end'])); ?></td>


                  <td><?php
                      echo " <a href='" . $key['agrefile'] . "'target='_blank' class='btn btn-dark'>View</a>";
                      ?></td>
                  <td><?php
                      echo " <a href='" . $key['license'] . "'target='_blank' class='btn btn-dark'>View</a>";
                      ?></td>




                  <td><?php echo $key['status']; ?></td>
                  <td>
                    <?php
                    if ($key['status'] == 'Active') {
                    ?>

                      <a href="admin?id=agency_active&aid=<?php echo $key['id']; ?>&ch=InActive" class="btn btn-danger">Make InActive</a>
                    <?php
                    } elseif ($key['status'] == 'InActive') {
                    ?>

                      <a href="admin?id=agency_active&aid=<?php echo $key['id']; ?>&ch=Active" class="btn btn-success">Make Active</a>
                    <?php
                    }
                    ?>

                  </td>
                  </tr>





                <?php
                  $i++;
                } ?>



              </tbody>
            </table>

          </div>



          <!-- End Table with stripped rows -->

        </div>
      </div>

    </div>