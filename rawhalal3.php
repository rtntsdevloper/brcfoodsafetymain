<?php
$hid = $_GET['hid'];

$rawq = "SELECT * FROM `tblhalal` WHERE id='$hid'";
$rawq1 = mysqli_query($con, $rawq);
$rawq2 = mysqli_fetch_array($rawq1);

$supname =  $rawq2['supname'];

$rawqn = "SELECT * FROM `tblrawsupplier` WHERE supid='$supname'";
$rawqn1 = mysqli_query($con, $rawqn);
$rawqn2 = mysqli_fetch_array($rawqn1);
$rawsupplier = $rawqn2['supname'];


?>

<div class="main-content">
    <div class="breadcrumb">

        <ul class="ml-4">
            <li><a href="">Home</a></li>
            <li>Raw Material Management </li>
        </ul>
    </div>
    <style>
        .hidden {
            display: none;
        }
    </style>
    <?php

    ?>
    <div class="container-fluid" style="margin-top:50px;">

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <a href="admin.php?id=rawhalal"><button class="btn btn-success"
                            style="float:right; margin-left:15px">Go Back</button></a>

                    <div class="card-title ml-1">Raw material</div>

                    <form class="needs-validation" novalidate="novalidate" method="post" action=""
                        enctype="multipart/form-data">
                        <div class="form-row">



                            <div class="col-md-6 mb-3" id="output">
                                <label for="validationTooltip03">ProductType</label>
                                <input type="text" name="id" value="<?php echo $rawsupplier ?>" class="form-control" readonly>

                            </div>

                            <div class="col-md-6 mb-3" id="output">
                                <label for="validationTooltip03">Raw Material</label>
                                <input type="text" name="id" value="<?php echo $rawq2['name']; ?>" class="form-control" readonly>

                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationTooltip03">ProductType</label>
                                <select name="type" class="form-control" id="" required>
                                    <option value="<?php echo $rawq2['type']; ?>" selected><?php echo $rawq2['type']; ?></option>
                                    <option value="Halal">Halal</option>
                                    <option value="Kosher">Kosher</option>
                                </select>
                                <div class="invalid-tooltip">
                                    Please fill in this field

                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationTooltip03">Certification Date</label>
                                <input name="cdate" type="date" class="form-control" id="validationTooltip03"
                                    placeholder="" value="<?php echo $rawq2['cdate']; ?>" />
                                <div class="invalid-tooltip">
                                    Please fill in this field

                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationTooltip04">Expiry Date</label>
                                <input class="form-control" id="validationTooltip04" type="date" placeholder=""
                                    name="edate" value="<?php echo $rawq2['edate']; ?>" />
                                <div class="invalid-tooltip">
                                    Please fill the field.

                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationTooltip04">Upload Certificate</label><?php
                                                                                            $fin = explode(';', $rawq2['file']);
                                                                                            foreach ($fin as $im => $value) {
                                                                                            ?>
                                    <a href="rawhalal/<?php echo $value; ?>" target="_blank" class="ml-3">View </a>
                                <?php
                                                                                            }

                                ?>
                                <input class="form-control" id="validationTooltip04" type="file"
                                    name="img[]" accept=".pdf" multiple />
                                <div class="invalid-tooltip">
                                    Please fill the field.

                                </div>
                            </div>
                        </div>

                        <br>
                        <button class="btn btn-primary"
                            type="submit"
                            name="submit"> Submit </button>
                </div>
                </form>
            </div>
        </div>
    </div>

</div>


<?php

if (isset($_POST['submit'])) {

  
    $type = $_POST['type'];
    $cdate = $_POST['cdate'];
    $edate = $_POST['edate'];
   
    $user = $_SESSION['user'];

    $targetDir = "rawhalal/";
    $tntimg = "";
    if (isset($_FILES['img']['name']) && !empty($_FILES['img']['name'])) {


        foreach ($_FILES['img']['tmp_name'] as $key => $tmpName) {
            $originalName = $_FILES['img']['name'][$key];
            $fileTmp = $_FILES['img']['tmp_name'][$key];
            $fileExt = pathinfo($originalName, PATHINFO_EXTENSION);
            // Generate a unique name using timestamp and random string

            $idt = date('dmyhis');
            $uniqueName =  uniqid('rawhalal_', true) . $idt . '.' . $fileExt;
            $targetFile = $targetDir . $uniqueName;

            // Move the file to the target directory
            if (move_uploaded_file($fileTmp, $targetFile)) {
                if (empty($tntimg)) {
                    $tntimg = $uniqueName;
                } else {
                    $tntimg = $tntimg . ";" . $uniqueName;
                }
            } else {
                $tntimg = $rawq2['file'];
            }
        }
    } else {
        $tntimg = $rawq2['file'];
    }
    $query =  "UPDATE `tblhalal` 
          SET  
             
              `cdate` = '$cdate', 
              `edate` = '$edate', 
              `type` = '$type', 
              `file` = '$tntimg', 
              `add_by` = '$user' 
          WHERE `id` = '$hid'";

    $result = mysqli_query($con, $query);
    if ($result) {
       echo "<script>
                                                       
                                                         document.location.href='admin.php?id=rawhalal'
                                                        </script>";
    }
}
?>