 <div class="main-content">
     <div class="breadcrumb">
         <h1 class="mr-2"><?php echo $headingname; ?></h1>
         <ul>
             <li><a href="">Upload Specification</a></li>
             <li>Add Detail</li>
         </ul>
     </div>
     <div class="col-md-12">
         <div class="card">
             <div class="card-body">
                 <a href="admin.php?id=1"><button class="btn btn-success" style="float:right; margin-left:15px">Go
                         Back</button></a>
                 <script>
                    //  function getsupplier(str) {

                    //      if (str == "") {
                    //          document.getElementById("product").innerHTML = "";
                    //          return;
                    //      }
                    //      if (window.XMLHttpRequest) {
                    //          xmlhttp = new XMLHttpRequest();
                    //      } else {
                    //          xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    //      }
                    //      xmlhttp.onreadystatechange = function() {
                    //          if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    //              document.getElementById("product").innerHTML = xmlhttp.responseText;
                    //          }
                    //      }
                    //      xmlhttp.open("GET", "getproducts.php?q=" + str, true);
                    //      xmlhttp.send();
                    //  }
                 </script>


                 <form class="needs-validation" novalidate="novalidate" method="post" action=" "
                     enctype="multipart/form-data">
                     <div class="form-row">
                         <div class="col-md-4 mb-3">
                             <label for="validationTooltip01"> Product Supplier</label>

                             <?php
                                $pro = $_GET['product'];
                                $sup = $_GET['supp'];
                                $sql = mysqli_query($con, "SELECT * FROM tblrawsupplier WHERE supid='$sup' ORDER BY supname ASC");
                                $row = mysqli_fetch_array($sql);
                                ?>
                             <input type="text" class="form-control" name="supp" value="<?php echo $row['supname']; ?>"
                                 readonly />


                         </div>

                         <div class="col-md-4 mb-3">
                             <label for="validationTooltip02">Select Product</label>
                             <?php
                                $pro = $_GET['product'];

                                $sql = mysqli_query($con, "SELECT * FROM tblrawmaterial WHERE id='$pro'");
                                $row = mysqli_fetch_array($sql);
                                ?>
                             <input type="text" class="form-control" name="product" value="<?php echo $row['pname']; ?>"
                                 readonly />

                             <!-- <input type="hidden" name="id" value="<?php echo $pro; ?>" /> -->


                             <div class="invalid-tooltip">
                                 Please fill the field.

                             </div>
                         </div>
                         <!-- <div class="col-md-4 mb-3">
                                <label for="validationTooltip02">Reviewed On</label>
                                <input name="date" type="date" class="form-control" id="validationTooltip03"
                                    required="required" />
                                <div class="invalid-tooltip">
                                    Please fill the field.

                                </div>
                            </div>
                        </div> -->


                         <!-- <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="validationTooltip03">Reviewed By</label>
                                <input class="form-control" id="validationTooltip04" type="text" required="required"
                                    name="uploadby" />
                                <div class="invalid-tooltip">
                                    Please fill the field.
                                </div>
                            </div> -->


                         <div class="col-md-4 mb-3">
                             <label for="validationTooltip03">Upload Spec</label>
                             <input class="form-control" id="validationTooltip04" type="file" required="required"
                                 name="img1" />
                             <div class="invalid-tooltip">
                                 Please fill the field.
                             </div>
                         </div>


                        
                     </div>
 <br>
 <br>
 <br>

                     <?php
                        $sql = mysqli_query($con, "SELECT * FROM tblrawquestion");
                        $i = 0;

                        while ($row = mysqli_fetch_array($sql)) {
                            $i++;
                            $id = $row['id'];
                            $opt1 = htmlspecialchars($row['option1']);
                            $opt2 = htmlspecialchars($row['option2']);
                             $opt3 = htmlspecialchars($row['option3']);
                            $qid = "question_$id";
                        ?>
                         <div class="col-md-6">
                             <input type="hidden" name="qid<?php echo $i; ?>" value="<?php echo $id; ?>">
                             <input type="hidden" name="question<?php echo $i; ?>" value="<?php echo $row['question']; ?>">

                             <label for="<?php echo $qid; ?>">
                                 <?php echo "$i. {$row['question']}"; ?>
                             </label>

                             <div id="<?php echo $qid; ?>">
                                 <div class="form-group label-floating">
                                     <?php if ($opt1 || $opt2 || $opt3): ?>
                                         <input type="radio" name="r1<?php echo $i; ?>" id="opt1_<?php echo $i; ?>" value="<?php echo $opt1; ?>" onclick="toggleComment('commet<?php echo $i; ?>', 'commnt<?php echo $i; ?>', this.value, '<?php echo $opt1; ?>')"> <?php echo $opt1; ?>
                                         <input type="radio" name="r1<?php echo $i; ?>" id="opt2_<?php echo $i; ?>" value="<?php echo $opt2; ?>" onclick="toggleComment('commnt<?php echo $i; ?>', 'commet<?php echo $i; ?>', this.value, '<?php echo $opt2; ?>')"> <?php echo $opt2; ?>
                                         <input type="radio" name="r1<?php echo $i; ?>" id="opt2_<?php echo $i; ?>" value="<?php echo $opt3; ?>" onclick="toggleComment('commnt<?php echo $i; ?>', 'commet<?php echo $i; ?>', this.value, '<?php echo $opt3; ?>')"> <?php echo $opt3; ?>
                                     <?php else: ?>
                                         <input type="radio" name="r1<?php echo $i; ?>" value="Yes"> Yes
                                         <input type="radio" name="r1<?php echo $i; ?>" value="No"> No
                                     <?php endif; ?>
                                     <textarea class="form-control" name="coet<?php echo $i; ?>" placeholder="Comment"></textarea>
                                 </div>
                             </div>

                             <div class="invalid-tooltip">Please fill the field.</div>
                         </div>

                         <!-- Follow-up Question 2 -->
                         <?php if ($row['question2']): ?>
                             <div class="col-md-6" style="display:none" id="commnt<?php echo $i; ?>">
                                 <input type="hidden" name="question2<?php echo $i; ?>" value="<?php echo $row['question2']; ?>">
                                 <input type="hidden" name="qid1<?php echo $i; ?>" value="<?php echo $row['q2id']; ?>">
                                 <label><?php echo $row['question2']; ?></label>
                                 <div class="form-group label-floating">
                                     <input type="radio" name="rm1<?php echo $i; ?>" value="Yes"> Yes
                                     <input type="radio" name="rm1<?php echo $i; ?>" value="No"> No
                                     <textarea class="form-control" name="coet2<?php echo $i; ?>" placeholder="Comment"></textarea>
                                 </div>
                                 <div class="invalid-tooltip">Please fill the field.</div>
                             </div>
                         <?php endif; ?>

                         <!-- Follow-up Question 3 -->
                         <?php if ($row['question3']): ?>
                             <div class="col-md-6" style="display:none" id="commet<?php echo $i; ?>">
                                 <input type="hidden" name="question3<?php echo $i; ?>" value="<?php echo $row['question3']; ?>">
                                 <input type="hidden" name="rr2<?php echo $i; ?>" value="<?php echo $row['q3id']; ?>">
                                 <label><?php echo $row['question3']; ?></label>
                                 <div class="form-group label-floating">
                                     <input type="radio" name="rr1<?php echo $i; ?>" value="Yes"> Yes
                                     <input type="radio" name="rr1<?php echo $i; ?>" value="No"> No
                                     <textarea class="form-control" name="coet3<?php echo $i; ?>" placeholder="Comment"></textarea>
                                 </div>
                                 <div class="invalid-tooltip">Please fill the field.</div>
                             </div>
                         <?php endif; ?>
                     <?php } ?>
                     <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                 </form>

                 <script>
                     function toggleComment(showId, hideId, selectedValue, expectedValue) {
                         document.getElementById(showId).style.display = (selectedValue === expectedValue) ? "block" : "none";
                         document.getElementById(hideId).style.display = "none";
                     }
                 </script>
             </div>
         </div>
     </div>
 </div>


 <?php
    if (isset($_POST['submit'])) {
        $supp = $_GET['supp'];

        $comment = isset($_POST['coet' . $i]) ? $_POST['coet' . $i] : '';

        $question = $_POST['question' . $i];

        $qid = $_POST['qid' . $i];
        $answer = isset($_POST['r1' . $i]) ? $_POST['r1' . $i] : '';
        // $answer3 = isset($_POST['rq1' . $i]) ? $_POST['rq1' . $i] : '';
        $answer1 = isset($_POST['rm1' . $i]) ? $_POST['rm1' . $i] : '';
        $answer2 = isset($_POST['rr1' . $i]) ? $_POST['rr1' . $i] : '';

        $pro = $_GET['product'];

        $date = date('Y-m-d');
        $uploadby = $user;
        // $sql= mysqli_query($con,'select * from tblstaff where uname ="'.$user.'"');


        $img = "";


        $img1 = $_FILES['img1']['name'];
        $gh1 = move_uploaded_file($_FILES['img1']['tmp_name'], "specdetail/" . $img1);

//         print_r( "INSERT INTO tblrawspecdetail1 (supp, product, date, uploadby, sign, spec) VALUES ('$supp', '$pro', '$date', '$uploadby', '$img', '$img1')");
// echo"<br>";
        $sql = mysqli_query($con, "INSERT INTO tblrawspecdetail(supp, product, date, uploadby, sign, spec) VALUES ('$supp', '$pro', '$date', '$uploadby', '$img', '$img1')");

        for ($j = 1; $j <= $i; $j++) {
            $qid = isset($_POST['qid' . $j]) ? $_POST['qid' . $j] : '';
            $question = isset($_POST['question' . $j]) ? $_POST['question' . $j] : '';
            $question2 = isset($_POST['question2' . $j]) ? $_POST['question2' . $j] : '';
            $question3 = isset($_POST['question3' . $j]) ? $_POST['question3' . $j] : '';
            $comment = isset($_POST['coet' . $j]) ? $_POST['coet' . $j] : '';
            $comment2 = isset($_POST['coet2' . $j]) ? $_POST['coet2' . $j] : '';
            $comment3 = isset($_POST['coet3' . $j]) ? $_POST['coet3' . $j] : '';
            $answer = isset($_POST['r1' . $j]) ? $_POST['r1' . $j] : '';
            $answer1 = isset($_POST['rm1' . $j]) ? $_POST['rm1' . $j] : '';
            $answer2 = isset($_POST['rr1' . $j]) ? $_POST['rr1' . $j] : '';
            // print_r("INSERT INTO tblrawspecdetail1 (qid, question, answer, answer2, answer3, comment,product,question2,question3) VALUES ('$qid', '$question', '$answer', '$answer1', '$answer2', '$comment', '$pro','$question2','$question3')");die;
            $sql1 = mysqli_query($con, "INSERT INTO tblrawspecdetail1 (qid, question, answer, answer2, answer3, comment,product,question2,question3,comment2,comment3) VALUES ('$qid', '$question', '$answer', '$answer1', '$answer2', '$comment', '$pro','$question2','$question3','$comment2','$comment3')");
        }

    ?>
     <script language="javascript">
         window.open('admin.php?id=addrawmaterial', '_self');
     </script>
 <?php
    }
