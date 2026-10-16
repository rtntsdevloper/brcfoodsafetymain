 <?php
  $sno = $_GET['sno'];
  $sql = mysqli_query($con, "select * from addtest1 where testid='$_GET[sno]'");
  $row = mysqli_fetch_array($sql);
  $rid = $_GET['rid'];
  ?>
 <script>
   function showHint(str, fid, qid) {
     if (str.length == 0) {
       document.getElementById("txtHint").innerHTML = "";
       return;
     } else {
       var xmlhttp = new XMLHttpRequest();
       xmlhttp.onreadystatechange = function() {
         if (this.readyState == 4 && this.status == 200) {
           document.getElementById("txtHint").innerHTML = this.responseText;
         }
       };
       xmlhttp.open("GET", "savedoc.php?ans=" + str + "&fid=" + fid + "&qid=" + qid + "&rid=" + <?php echo $rid; ?>, true);
       xmlhttp.send();
     }
   }
 </script>


 <script>
   function showHint1(str, fid, qid) {
     if (str.length == 0) {
       document.getElementById("txtHint").innerHTML = "";
       return;
     } else {
       var xmlhttp = new XMLHttpRequest();
       xmlhttp.onreadystatechange = function() {
         if (this.readyState == 4 && this.status == 200) {
           document.getElementById("txtHint").innerHTML = this.responseText;
         }
       };
       xmlhttp.open("GET", "savenotes.php?ans=" + str + "&fid=" + fid + "&qid=" + qid + "&rid=" + <?php echo $rid; ?>, true);
       xmlhttp.send();
     }
   }
 </script>

 <script>
   // Debounce and abort logic
   let timeoutId = null;
   let currentXHR = null; // Track ongoing AJAX request

   function showHint2(str, fid, qid) {
     // Clear previous timeout and AJAX request
     clearTimeout(timeoutId);
     if (currentXHR) {
       currentXHR.abort(); // Cancel ongoing request
     }

     // Immediate clear if empty
     if (str.length === 0) {
       document.getElementById("txtHint").innerHTML = "";
       return;
     }

     // Debounce with 300ms delay
     timeoutId = setTimeout(() => {
       currentXHR = new XMLHttpRequest();
       currentXHR.onreadystatechange = function() {
         if (this.readyState === 4 && this.status === 200) {
           document.getElementById("txtHint").innerHTML = this.responseText;
         }
       };

       const params = new URLSearchParams({
         ans: str,
         fid: fid,
         qid: qid,
         rid: <?php echo json_encode($rid); ?>
       });

       currentXHR.open("GET", "savedate.php?" + params.toString(), true);
       currentXHR.send();
     }, 300); // Adjust debounce time (300ms)
   }
 </script>

 <script>
   function showHint3(str, fid, qid) {
     if (str.length == 0) {
       document.getElementById("txtHint").innerHTML = "";
       return;
     } else {
       var xmlhttp = new XMLHttpRequest();
       xmlhttp.onreadystatechange = function() {
         if (this.readyState == 4 && this.status == 200) {
           document.getElementById("txtHint").innerHTML = this.responseText;
         }
       };
       xmlhttp.open("GET", "savetitle.php?ans=" + str + "&fid=" + fid + "&qid=" + qid + "&rid=" + <?php echo $rid; ?>, true);
       xmlhttp.send();
     }
   }
 </script>


 <script>
   function showHint4(str, fid, qid) {
     if (str.length == 0) {
       document.getElementById("txtHint").innerHTML = "";
       return;
     } else {
       var xmlhttp = new XMLHttpRequest();
       xmlhttp.onreadystatechange = function() {
         if (this.readyState == 4 && this.status == 200) {
           document.getElementById("txtHint").innerHTML = this.responseText;
         }
       };
       xmlhttp.open("GET", "saveaction.php?ans=" + str + "&fid=" + fid + "&qid=" + qid + "&rid=" + <?php echo $rid; ?>, true);
       xmlhttp.send();
     }
   }
 </script>


 <script>
   function showHint5(str, qid) {
     if (str.length == 0) {
       document.getElementById("txtHint").innerHTML = "";
       return;
     } else {
       var xmlhttp = new XMLHttpRequest();
       xmlhttp.onreadystatechange = function() {
         if (this.readyState == 4 && this.status == 200) {
           document.getElementById("txtHint").innerHTML = this.responseText;
         }
       };
       xmlhttp.open("GET", "saveaction1.php?ans=" + str + "&qid=" + qid, true);
       xmlhttp.send();
     }
   }
 </script>

 <div id="txtHint"></div>
 <div class="main-content">
   <div class="breadcrumb">
     <h1 class="mr-2"><?php echo $headingname; ?></h1>
     <ul>
       <li><a href="">Audit Management</a></li>
       <li>Requirements</li>
     </ul>
   </div>

   <div class="row mb-12">
     <div class="col-md-12 mb-12">
       <div class="card text-left">
         <div class="card-body">
           <h4 class="card-title mb-3"><?php echo $row['testid']; ?>. <?php echo $row['subject']; ?></h4>
           <?php
            if (isset($_GET['msg'])) {
            ?>
             <h3 class="card-title mb-3" style="color:#FF0000">Some questions not answered please check </h3>
           <?php
            }
            ?>
           <div class="row">
             <div class="col-md-12">
               <ul class="nav nav-tabs justify-content-end mb-12" id="myTab" role="tablist">
                 <li class="nav-item"><a class="nav-link active" href="admin.php?id=auditdetail">Go Back</a></li>
               </ul>

               <div class="card">

                 <div class="tab-content" id="myTabContent">
                   <div class="tab-pane fade show active" id="invoice" role="tabpanel" aria-labelledby="invoice-tab">

                     <!-- -===== Print Area =======-->


                     <div class="mt-12 mb-12 border-top"></div>

                     <?php

                      $sql2 = mysqli_query($con, "select * from subtest1  where tid='$sno' and sid='$_GET[sid]' ");
                      $i = 0;
                      while ($row2 = mysqli_fetch_array($sql2)) {
                        if ($row2['ssid'] != "") {
                          $fid = $row2['ssid'];
                        } else {
                          $fid = $row2['fid'];
                        }

                      ?>


                       <div id="print-area">
                         <?php
                          if ($row2['cid'] == "1") {
                          ?>
                           <?php
                            if ($row2['ssid'] != "") {
                              $fd = $row2['fid'];
                              $kl = mysqli_query($con, "select * from subtest where tid='$sno' and ssid='$row2[fid]'");
                            } else {
                              $fd = $row2['sid'];
                              $kl = mysqli_query($con, "select * from subtest where tid='$sno' and sid='$row2[sid]'");
                            }

                            $hj = mysqli_fetch_array($kl);
                            ?>
                           <div class="row">
                             <div class="col-md-12">

                               <h4 class="font-weight-bold"><?php echo $fd; ?>- <?php echo $hj['subtest']; ?></h4>

                               <p>FUNDAMENTAL</p>
                               <p><?php echo $hj['fundamental']; ?></p>
                             </div>
                           </div>
                         <?php
                          }
                          ?>


                         <div class="row mb-12" style="margin:5px;">
                           <div class="col-md-12" style="padding:5px">
                             <button class="btn btn-primary" style="float:right" type="button" data-toggle="modal"
                               data-target="#exampleModalLong<?php echo $row2['id']; ?>">Interpretation </button>
                           </div>
                           <?php
                            if ($row2['img'] == "green") {
                            ?>
                             <div class="col-md-2" style="background:url(images/11.png); background-repeat:no-repeat;background-size: cover;">
                               <h5 class="font-weight-bold" style="margin:auto; text-align:center;  padding:15%"> Clause <?php echo $fid; ?></h5>
                             </div>
                             <div class="col-md-10" style="background-color:#E3E3E3">
                               <h5 class="font-weight-bold" style=" padding:1%"><?php echo $row2['clause']; ?></h5>
                             </div>
                           <?php
                            } else if ($row2['img'] == "yellow") {
                            ?>
                             <div class="col-md-2" style="background:url(images/2.png); background-repeat:no-repeat;background-size: cover;">
                               <h5 class="font-weight-bold" style="margin:auto; text-align:center;  padding:15%"> Clause <?php echo $fid; ?></h5>
                             </div>
                             <div class="col-md-10" style="background-color:#F6F6F6">
                               <h5 class="font-weight-bold" style=" padding:1%"><?php echo $row2['clause']; ?></h5>
                             </div>
                           <?php
                            } else if ($row2['img'] == "green/yellow") {
                            ?>
                             <div class="col-md-2" style="background:url(images/3.png); background-repeat:repeat-y;background-size: 100% 100%; ">
                               <h5 class="font-weight-bold" style="margin:auto; text-align:center;  padding:15%"> Clause <?php echo $fid; ?></h5>
                             </div>
                             <div class="col-md-10" style="background-color:#F6F6F6">
                               <h5 class="font-weight-bold" style=" padding:1%"><?php echo $row2['clause']; ?></h5>
                             </div>
                           <?php
                            } else {
                            ?>
                             <div class="col-md-2" style="background:url(images/11.png); background-repeat:repeat-y;background-size: 100% 100%; ">
                               <h5 class="font-weight-bold" style="margin:auto; text-align:center;  padding:15%"> Clause <?php echo $fid; ?></h5>
                             </div>
                             <div class="col-md-10" style="background-color:#F6F6F6">
                               <h5 class="font-weight-bold" style=" padding:1%"><?php echo $row2['clause']; ?></h5>
                             </div>
                           <?php
                            }

                            ?>

                         </div>


                         <div class="modal fade" id="exampleModalLong<?php echo $row2['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle1" aria-hidden="true">
                           <div class="modal-dialog" role="document">
                             <div class="modal-content">
                               <div class="modal-header">
                                 <h5 class="modal-title" id="exampleModalLongTitle1">Interpretation </h5>
                                 <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                               </div>
                               <div class="modal-body">
                                 <?php echo $row2['inter']; ?>
                               </div>
                               <div class="modal-footer">
                                 <button class="btn btn-primary" type="button" data-dismiss="modal">Close</button>


                               </div>
                             </div>
                           </div>


                         </div>
                         <form action="admin?id=verifyaudit" method="post" name="form1">
                           <input type="hidden" name="sno" value="<?php echo $rid; ?>" />
                           <input type="hidden" name="sid" value="<?php echo $_GET['sid']; ?>" />
                           <input type="hidden" name="tid" value="<?php echo $_GET['sno']; ?>" />

                           <div class="form-row">
                             <?php
                              $sql5 = mysqli_query($con, "select * from tbliaques  where testid='$fid'");
                              $ghf = mysqli_num_rows($sql5);
                              $k = 0;
                              while ($row5 = mysqli_fetch_array($sql5)) {


                                $sql6 = mysqli_query($con, "select * from saveiqques  where sno='$rid' and fid='$row5[testid]' ");
                                $matchq = mysqli_num_rows($sql6);

                                $quest = mysqli_real_escape_string($con, $row5['ques']);

                                if ($matchq < $ghf) {
                                  $fgr = mysqli_query($con, "insert into saveiqques(sno,fid,qid,ques)values('$rid','$fid','$row5[qid]','$quest')");
                                } else {
                                }
                                $quryy = mysqli_query($con, "select * from saveiqques where sno='$rid' and fid='$fid' and qid='$row5[qid]'");
                                $rtyy = mysqli_fetch_array($quryy);
                              ?>
                               <div class="col-md-12">
                                 <label for="validationTooltip01" style="color:#FF0000">Ques <?php echo $row5['qid']; ?> . <?php echo $row5['ques']; ?></label>
                                 </br>
                                 <textarea name="iaques<?php echo $k; ?>" id="iaques<?php echo $k; ?>" class="form-control" oninput="showHint5(this.value,'<?php echo $rtyy['id']; ?>')" required><?php echo $rtyy['ans']; ?></textarea>
                                 <div class="invalid-tooltip">
                                   Please provide title.

                                 </div>
                               </div>
                             <?php
                                $k++;
                              }
                              ?>


                           </div>

                           <div class="row">
                             <div class="col-md-12 table-responsive">
                               <table class="table table-hover mb-4">
                                 <thead class="bg-gray-300">
                                   <tr>

                                     <th></th>
                                     <th colspan="5">Outcome</th>
                                     <th>Docs</th>

                                   </tr>
                                 </thead>
                                 <tbody>
                                   <tr>
                                     <td></td>
                                     <td>Compliant</td>
                                     <td>Minor</td>
                                     <td>Major</td>
                                     <td>Critical</td>
                                     <td>Not Applicable</td>
                                     <td></td>


                                   </tr>
                                   <tr>
                                     <td></td>
                                     <?php



                                      $rty1 = mysqli_query($con, "select * from saveaudit where fid='$fid' and ques='$row2[cid]' and sno='$rid'");
                                      $matchh = mysqli_num_rows($rty1);
                                      if ($matchh <= 0) {
                                        $date = date("Y-m-d");
                                        $gjl = mysqli_query($con, "INSERT INTO saveaudit (date, fid, ques, tid, sid, sno) VALUES ('$date', '$fid', '$row2[cid]', '$sno', '$row2[sid]','$rid');");
                                      } else {
                                      }

                                      $rty = mysqli_query($con, "select * from saveaudit where fid='$fid' and ques='$row2[cid]' and sno='$rid'");
                                      $qury = mysqli_fetch_array($rty);

                                      $signi = $qury['ans'];

                                      ?>
                                     <script>
                                       function cal1(str, str1) {

                                         if (str == "Compliant" || str == "Not Applicable") {
                                           document.getElementById('cmnt' + str1).style.display = 'block';
                                           document.getElementById('taction' + str1).style.display = 'none';
                                           document.getElementById('cmntt' + str1).disabled = false;
                                           document.getElementById('date' + str1).disabled = true;
                                           document.getElementById('action' + str1).disabled = true;
                                         } else if (str == "Major" || str == "Minor" || str == "Critical") {
                                           document.getElementById('cmnt' + str1).style.display = 'none';
                                           document.getElementById('taction' + str1).style.display = 'block';
                                           document.getElementById('title' + str1).disabled = false;
                                           document.getElementById('date' + str1).disabled = false;
                                           document.getElementById('action' + str1).disabled = false;
                                         }
                                       }
                                     </script>



                                     <td>
                                       <input type="radio" value="Compliant" id="r1<?php echo $i; ?>" name="r1<?php echo $i; ?>" onclick="return cal1(this.value,<?php echo $i; ?>);" onchange="showHint(this.value,'<?php echo $fid; ?>','<?php echo $row2['cid']; ?>')" <?php echo ($signi == "Compliant") ?  "checked" : "";  ?> />
                                     </td>

                                     <td><input type="radio" value="Minor" id="r1<?php echo $i; ?>" name="r1<?php echo $i; ?>" onclick="return cal1(this.value,<?php echo $i; ?>);" onchange="showHint(this.value,'<?php echo $fid; ?>','<?php echo $row2['cid']; ?>')" <?php echo ($signi == "Minor") ?  "checked" : "";  ?> /></td>

                                     <td><input type="radio" value="Major" id="r1<?php echo $i; ?>" name="r1<?php echo $i; ?>" onclick="return cal1(this.value,<?php echo $i; ?>);" onchange="showHint(this.value,'<?php echo $fid; ?>','<?php echo $row2['cid']; ?>')" <?php echo ($signi == "Major") ?  "checked" : "";  ?> /></td>

                                     <td><input type="radio" value="Critical" id="r1<?php echo $i; ?>" name="r1<?php echo $i; ?>" onclick="return cal1(this.value,<?php echo $i; ?>);" onchange="showHint(this.value,'<?php echo $fid; ?>','<?php echo $row2['cid']; ?>')" <?php echo ($signi == "Critical") ?  "checked" : "";  ?> /></td>
                                     <td><input type="radio" value="Not Applicable" id="r1<?php echo $i; ?>" name="r1<?php echo $i; ?>" onclick="return cal1(this.value,<?php echo $i; ?>);" onchange="showHint(this.value,'<?php echo $fid; ?>','<?php echo $row2['cid']; ?>')" <?php echo ($signi == "Not Applicable") ?  "checked" : "";  ?> /></td>

                                     <td><a data-toggle="modal" class='modalButton' data-target="#myModal1" href="#<?php echo $fid; ?>" data-fid='<?php echo $fid; ?>' data-qid='<?php echo $row2['cid']; ?>'> <i class="fa fa-file" aria-hidden="true"></i> </a></td>
                                   </tr>
                                   <tr>
                                     <td></td>
                                     <?php
                                      $disable = '';
                                      $disable1 = '';
                                      if ($qury['ans'] != "Compliant" &&  $qury['ans'] != "Not Applicable") {
                                        $disable = 'disabled="disabled"';
                                      }

                                      if ($qury['ans'] != "Major" &&  $qury['ans'] != "Minor" &&  $qury['ans'] != "Critical") {
                                        $disable1 = 'disabled="disabled"';
                                      }

                                      ?>
                                     <td colspan="4">
                                       <?php
                                        if ($qury['ans'] == "Compliant" || $qury['ans'] == "Not Applicable") {
                                        ?>
                                         <div id="cmnt<?php echo $i; ?>">
                                         <?php
                                        } else {
                                          ?>
                                           <div id="cmnt<?php echo $i; ?>" style="display:none">
                                           <?php
                                          }
                                            ?>
                                           <textarea class="form-control" placeholder="Enter Comment" name="cmntt<?php echo $i; ?>" id="cmntt<?php echo $i; ?>" <?php echo $disable ?> oninput="showHint1(this.value,'<?php echo $fid; ?>','<?php echo $row2['cid']; ?>')"><?php echo $qury['notes']; ?></textarea>
                                           </div>

                                           <?php
                                            if ($qury['ans'] == "Major" || $qury['ans'] == "Minor" || $qury['ans'] == "Critical") {

                                            ?>
                                             <div id="taction<?php echo $i; ?>">
                                             <?php
                                            } else {
                                              ?>
                                               <div id="taction<?php echo $i; ?>" style="display:none">

                                               <?php
                                              }
                                                ?>





                                               <div class="form-row">
                                                 <div class="col-md-12">
                                                   <label for="validationTooltip01">Proposed Action </label>
                                                   <textarea name="action<?php echo $i; ?>" id="action<?php echo $i; ?>" class="form-control" required="required" <?php echo $disable1; ?> oninput="showHint4(this.value,'<?php echo $fid; ?>','<?php echo $row2['cid']; ?>')"><?php echo $qury['action']; ?></textarea>
                                                   <div class="invalid-tooltip">
                                                     Action required

                                                   </div>
                                                 </div>
                                               </div>


                                               <div class="form-row">
                                                 <div class="col-md-12">
                                                   <label for="validationTooltip01">NC Detail</label>
                                                   <textarea name="title<?php echo $i; ?>" id="title<?php echo $i; ?>" class="form-control" <?php echo $disable1; ?> oninput="showHint3(this.value,'<?php echo $fid; ?>','<?php echo $row2['cid']; ?>')"><?php echo $qury['title']; ?></textarea>
                                                   <div class="invalid-tooltip">
                                                     Please provide title.

                                                   </div>
                                                 </div>
                                               </div>

                                               <div class="form-row">
                                                 <div class="col-md-12">
                                                   <label for="validationTooltip01">Completion date agreed</label>
                                                   <input type="date" name="date<?php echo $i; ?>" id="date<?php echo $i; ?>" class="form-control" <?php echo $disable1; ?> required onchange="showHint2(this.value,'<?php echo $fid; ?>','<?php echo $row2['cid']; ?>')" value="<?php echo $qury['deliver']; ?>">
                                                   <div class="invalid-tooltip">
                                                     Please select date.


                                                   </div>
                                                 </div>
                                               </div>


                                               </div>
                                     </td>
                                   </tr>


                                 </tbody>
                               </table>
                             </div>

                           </div>




                           <div class="mt-12 mb-12 border-top" id="error<?php echo $i; ?>" style="color:#FF0000"></div>
                         <?php
                          $i++;
                        }
                          ?>
                         <!-- ==== / Print Area =====--><?php

                                                        ?><!-- ==== / Edit Area =====--><?php

                                                ?>


                         <button class="btn btn-danger" style="margin:30px; float:right" type="submit" onclick="return checkReq();">View & Submit</button>
                         </form>

                         <script>
                           function checkReq() {

                             var n = <?php echo $i; ?>;

                             for (var t3 = 0; t3 < n; t3++)

                             {

                               var y = t3;

                               var e = y + 1;

                               var boxes = document.getElementsByName("r1" + y);

                               for (var x = 0; x <= boxes.length; x++)

                               {
                                 if (boxes[0].checked == false && boxes[1].checked == false && boxes[2].checked == false && boxes[3].checked == false && boxes[4].checked == false)

                                 {
                                   document.getElementById('error' + y).innerHTML = "*Please choose one option[Yes, No, NA] for question no." + e + " *";
                                   document.getElementById('r1' + y).focus();

                                   return false;
                                 } else {
                                   document.getElementById('error' + y).innerHTML = "";
                                 }
                               }
                             }
                           }
                         </script>
                         <script>
                           $('.modalButton').click(function() {
                             var teacherid = $(this).attr('data-fid');
                             var qid = $(this).attr('data-qid');
                             var rid = <?php echo $rid; ?>;
                             $.ajax({
                               url: "saveaudit.php?sid=" + teacherid + "&qid=" + qid + "&rid=" + rid,
                               cache: false,
                               success: function(result) {
                                 $("#modal-body2").html(result);
                               }
                             });
                           });
                         </script>


                         <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModal1" aria-hidden="true">
                           <div class="modal-dialog">
                             <div class="modal-content">
                               <div class="modal-body" id="modal-body2">
                                 <?php
                                  include 'saveaudit.php';
                                  ?>
                               </div>
                             </div>
                           </div>
                         </div>