<?php
$querys = "SELECT * from `attempt`";
$results = mysqli_query($con, $querys);
$k = mysqli_fetch_array($results);
?>
<div class="container">
    <div class="main-content ">
        <div class="breadcrumb ">
            <!-- <h1 class="mr-2"><?php echo $headingname; ?></h1> -->
           
        </div>
        <div class="col-lg-12" style="margin-top:100px;">
            <div class="card my-5">
                <div class="card-body">
                    <a href="admin.php?id=warehouse"><button class="btn btn-success" style="float:right; margin-left:15px">Go
                            Back</button></a>
                            <input type="text" name="ide" hidden  value="<?php echo $_GET['ide']; ?>" />
                    <div class="card-title">Attempt test</div>
                    <?php
                    // $ide=$_GET['ide'];
                    $query = "SELECT * from `tab_que`";

                    $result = mysqli_query($con, $query);
                    while ($y = mysqli_fetch_array($result)) {
                        echo "<p style='color:red;'>" . ($y['section']) . "</p>";



                        ?>

                        <h6 style="color:black;font-size:18px;" class="card-title"><?php echo $y['sr_no'];
                        echo ".";
                        echo $y['question'];


                        echo "<br>";
                        echo "<br>";
                        ?> </h6>

                        <form class="needs-validation" novalidate="novalidate" method="post" action=""
                            enctype="multipart/form-data">
                            <?php 
 if(($y['sr_no']>='1') && ($y['sr_no']<='31')){


?>
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <select class="form-control form-control-normal" name="answer[]"   id="validationTooltip01" required="required">

                                        <option value="">Select Please</option>

                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>

                                        <option value="NA">NA</option>

                                        <input type="text" name="sr_no[]"  hidden value="<?php echo $y['sr_no']; ?>" />
                                       
                                    </select>
                                   
                                    <div class="invalid-tooltip">
                                        Please attempt

                                    </div>
                                </div>
                                
                                <div class="col-md-12 mb-3">
                                    <label for="validationTooltip02">Comment</label>
                                    <input type="text" class="form-control form-control-normal" placeholder="comment if any"
                                        name="comment[] " id="validationTooltip02" >
                                    
                                    <div class="invalid-tooltip">
                                        Please fill

                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="validationTooltip02"></label>
                                    <input type="file" class="form-control form-control-normal"
                                        placeholder=".form-control-normal" name="pic[]"   id="validationTooltip03">
                                   
                                    <div class="invalid-tooltip">
                                        Please fill 


                                    </div>

                                </div><?php } ?>
                                <?php 
 if( ($y['sr_no']<='31')){


?>
                        <div class="form-group row">
                     
                          <div class="col-lg-12">
                          
     <textarea  rows="4" cols="50" name="fur_com[]" class="form-control form-control-normal"  hidden placeholder="Enter comment" height="300px"></textarea>
                            
                          
                          </div>

                        </div><?php
                         }
                        ?>
<?php 
 if( ($y['sr_no']>='32')){


?>
                        <div class="form-group row">
                     
                          <div class="col-sm-12">
                          <input type="text" name="sr_no[]"  hidden  value="<?php echo $y['sr_no']; ?>" />
     <textarea  rows="4" cols="50" name="fur_com[]" class="form-control " placeholder="Enter comment" height="300px"></textarea>
                            
                          
                          </div>

                        <?php
                         }
                        ?>

                            </div>
                            <?php
                    }?>
                          </div>  
                          <div class="col-sm-12">   
                        <button class="btn btn-primary" type="submit" name="submit">Submit </button> </form>
                        </div>  
                       
                   
                
                    </div>
        </div>
    </div>
</div>
</div>
</div>
<?php

?>
 <?php
              if (isset($_POST['submit'])) {
                
                // Establish database connection
                // include 'connection.php';
                // Check connection
                if (!$con) {
                  die("Connection failed: " . mysqli_connect_error());
                }
              
                // Loop through each set of form data
                foreach($_POST['sr_no'] as $i => $a) {
                  $comment = $_POST['comment'][$i];
                 $f = $_POST['fur_com'][$i];
                  $first = $_POST['answer'][$i];
                  $a = $_POST['sr_no'][$i];
                  $pic_name = $_FILES['pic']['name'][$i];
                  $pic_tmp = $_FILES['pic']['tmp_name'][$i];
                  $upload_directory = '../auditpic/';
                  $ide = $_GET['ide'];

        // Check if file was uploaded successfully
                  if (!empty($_FILES['pic']['name'][$i])) {
                    $pic_name = $_FILES['pic']['name'][$i];
                    $pic_tmp = $_FILES['pic']['tmp_name'][$i];
                  } else {
                    // If no picture was uploaded, set default values
                    $pic_name = '';
                    $pic_tmp = '';
                  }
                  
             $query1 = "INSERT INTO `response` (`sr_no`,`answer`, `comment`,`fur_com`, `pic`,`ide`) 
                  VALUES ('$a','$first', '$comment','$f', '$pic_name','$ide')";

                  if (mysqli_query($con, $query1)) {
                    move_uploaded_file($pic_tmp, $upload_directory . $pic_name);
                    // echo "Data inserted successfully. ID: " . mysqli_insert_id($connection) . "<br>";
                    // echo "Data inserted successfully of question $id "."<br>";
                    // echo $id;
                    echo "<script>
                         
                          document.location.href='admin.php?id=warehouse'
                          </script>";

                  } else {
                    // echo "Error: " . $query . "<br>" . mysqli_error($connection);
                    // echo 'Please try again,data not inserted';
                    echo "<script>
                          alert('Please Try Again,Data Not Inserted');
                          document.location.href='#'
                          </script>";

                  }
                }
              }




              // Close connection
              else {
                //   echo "Form submission error!";
              

              }
              mysqli_close($con);

              ?>