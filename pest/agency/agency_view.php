<?php
include 'connection.php';

$v = "SELECT * FROM tb_pestagency WHERE status='Active' ";
$result = mysqli_query($con, $v);
$nm = mysqli_num_rows($result);


?>
<section class="section">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">




          <div class="row">
            <div class="col-md-9 ">
              <h3 class="card-title">Pest Control Agency Details</h3>
            </div>
            <div class="col-md-3 ">
              
                <a href="admin.php?id=agency" class="btn btn-primary text-right mt-3">View Pest Control Agencies</a>
             
              <a href="admin.php?id=Pest_dashboard" class="btn btn-success text-right mt-3">Go Back</a>
            </div>
          </div>
          <?php foreach ($result as $v1) { ?>
            <div class="row mt-5 ">

              <div class="col-md-6 mt-5">

                <!-- Table with stripped rows -->
                <table class="table table-striped table-bordered table-hover table-responsive mt-5">

                  <tr>
                    <th>Pest Agency Name</th>
                    <td><?php echo $v1['name']; ?></td>
                  </tr>
                  <tr>
                    <th>Agreement Start Date</th>
                    <td><?php echo date('d-m-Y', strtotime($v1['date_start'])); ?></td>
                  </tr>
                  <tr>
                    <th>Agreement End Date</th>
                    <td><?php echo  date('d-m-Y', strtotime($v1['date_end'])); ?></td>
                  </tr>

                  <tr>
                    <th>Frequency Of Service</th>
                    <td><?php echo $v1['frequency']; ?></td>
                  </tr>


                  <tr>
                    <th>License</th>
                    <td>
                      <?php echo " <a class='btn btn-dark w-100' href='" . $v1['agrefile'] . "'target='_blank'>View</a>"; ?>
                    </td>
                  </tr>
                  <tr>
                    <th>Pest Cover in Agreement</th>
                    <td>
                      <?php echo $v1['pest_cover']; ?>
                    </td>
                  </tr>


                </table>


              </div>
              <div class="col-md-6">

                <?php
                $file = $v1['agrefile'];
                $fileInfo = pathinfo($file);
                $extension = $fileInfo['extension'];


                if ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png') { ?>
                  <img src="<?php
                            echo $v1['agrefile']; ?>" class="img-fluid" alt="">
                <?php
                } elseif ($extension == 'pdf') {
                ?>


                  <iframe src="<?php
                                echo $v1['agrefile']; ?>" width="100%" height="500"></iframe>


                <?php
                }
                ?>




              </div>


              <div class="col-md-12 mt-5">
                <div class="row">
                  <div class="col-md-10 col-sm-9">
                    <h3><b>Agency Operators List</b></h3>
                  </div>
                  <div class="col-md-2 col-sm-3">
                    <a class="btn btn-primary" href="admin?id=operator&oid=<?php echo $v1['id']; ?>">Add Operators</a>
                  </div>
                </div>


                <table class="table mt-5">
                  <thead>
                    <tr class="text-center">
                      <th>
                        Sr no.
                      </th>
                      <th>
                        Name
                      </th>
                      <th>
                        Medical
                      </th>
                      <th>
                        Training
                      </th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php
                    $aid = $v1['id'];
                    $opd = mysqli_query($con, "SELECT * FROM `tb_pestoperator` WHERE aid = $aid");
                    $onm = mysqli_num_rows($opd);
                    if ($onm > 0) {
                      $o = 0;
                      foreach ($opd as $opr) {
                        $o++;
                    ?>
                        <tr class="text-center">
                          <td><?php echo $o; ?></td>
                          <td><?php echo $opr['name'] ?></td>
                          <td><a href="<?php echo $opr['medicalreport'] ?>" class="btn btn-dark" target="_blank">View</a></td>
                          <td><a href="<?php echo $opr['training'] ?>" class="btn btn-dark" target="_blank">View</a></td>


                        </tr>


                    <?php
                      }
                    }

                    ?>

                  </tbody>
                </table>
              </div>

            </div>
            <br>
            <br>
            <hr>
            <hr>
          <?php }
          if ($nm < 1) { ?>
            <div class="col-md-12">
              <div class="text-center">
                <h5 class="card-title text-center">No Pest Agency Available Yet ! </h5>
              </div>
            </div>
          <?php } ?>
          <!-- End Table with stripped rows -->

        </div>
      </div>

    </div>