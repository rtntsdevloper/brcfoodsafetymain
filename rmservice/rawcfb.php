  <?php
  include '../connection.php';
    $prid = $_GET['id'];
    $qtp = mysqli_query($con, "SELECT * FROM `tblrawmaterial` WHERE supid ='$prid'");
    ?>
 echo '  <option selected disabled>Please Select </option>';
 
          <?php
            foreach ($qtp as $rdata) { 
                $prname = $rdata['pname'];
                echo '  <option value="'.  $prname.'">'.  $prname.'</option>';

            }

            ?>

    