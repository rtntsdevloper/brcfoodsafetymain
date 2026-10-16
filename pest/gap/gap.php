<?php

$v = "SELECT * FROM tb_gap ";
$v1 = mysqli_query($con, $v);




?>



<section class="section">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-9 col-sm-7 ">
              <h5 class="card-title">Gap Audits Details</h5>
            </div>
            <div class="col-md-3 col-sm-5 text-center">
              <a href="admin.php?id=gap_add" class="btn btn-primary text-right mt-3">Add Gap Audits Details</a>
              <a href="admin.php?id=Pest_dashboard" class="btn  btn-success  mt-3">Go Back</a>
            </div>
          </div>


          <!-- Table with stripped rows -->
          <table class="table datatable text-center">
            <thead>
              <tr>
                <th class='text-center'>S.No</th>
                <th class='text-center'>Date of Gap Incidence</th>
                <th class='text-center'>Name of Auditor</th>
                <th class='text-center'>Areas Audited</th>
                <th class='text-center'>Number of Gaps</th>
                <th class='text-center'>Attach Files</th>
              </tr>
            </thead>
            <tbody>


              <?php
              $i = 1;
              foreach ($v1 as $key) { ?>
                <tr>
                  <td><?php echo $i; ?></td>
                  <td><?php echo date('d-m-Y', strtotime($key['date'])); ?></td>
                  <td><?php echo $key['name']; ?></td>
                  <td><?php echo $key['areas']; ?></td>
                  <td><?php echo $key['gaps']; ?></td>
                  <td><?php
                      $fls = $key['files'];
                      $fls = explode(',', $fls);
                      foreach ($fls as $fl) {
                        echo " <a href='" . $fl . "'target='_blank' class='btn btn-dark'>View</a>";
                      }

                      ?></td>

                <?php
                $i++;
              } ?>


                </tr>
            </tbody>
          </table>
          <!-- End Table with stripped rows -->

        </div>
      </div>

    </div>