<?php
$sno = $_GET['sno'];
?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Specification Detail</a></li>
            <li>View Detail</li>
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=addrawmaterial"><button class="btn btn-success"
                        style="float:right; margin-left:15px">Go Back</button></a>

                <div>

                </div>

                <!-- <a href=""> <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">View More</button></a> -->
                <!-- Button trigger modal -->

                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
                <!-- Bootstrap CSS -->
                <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> -->

                <!-- Bootstrap Icons -->




                <!-- Modal -->
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable W-100">
                        <div class="modal-content">
                            <div class="modal-header">
                                <!-- <h5 class="modal-title" id="staticBackdropLabel">This all answers are given by </h5> -->
                                <button type="button" class="btn-close  btn-primary" data-bs-dismiss="modal" aria-label="Close">x</button>
                            </div>
                            <div class="modal-body">

                                <?php

                                $sno = $_GET['sno']; // Make sure variable names are consistent
                                $sq = mysqli_query($con, "SELECT * FROM tblrawspecdetail1 WHERE product = '$sno'");
                                ?>

                                <h5 class="modal-title" id="staticBackdropLabel">Questions</h5>

                                <?php
                                $i = 0;
                                while ($row = mysqli_fetch_assoc($sq)) {
                                    $i++;
                                ?>
                                    <div class="question-answer">
                                        <p class="question mt-3"><?= $i ?>.) <?= $row['question'] ?></p>

                                        <?php if (!empty($row['answer'])) { ?>
                                            <div class="answers">
                                                <p class="answer">Answer: <?= $row['answer'] ?></p>
                                                <input type="text" class="form-control" value="Comment: <?= $row['comment'] ?>" readonly>
                                            </div>
                                        <?php } ?>

                                        <?php if (!empty($row['question2']) && ($row['answer2'])) { ?>
                                            <p class="question mt-3"><?= $row['qid'] ?>.) <?= $row['question2'] ?></p>
                                            <?php if (!empty($row['answer2'])) { ?>
                                                <div class="answers">
                                                    <p class="answer">Answer: <?= $row['answer2'] ?></p>
                                                    <input type="text" class="form-control" value="Comment: <?= $row['comment2'] ?? '' ?>" readonly>
                                                </div>
                                            <?php } ?>
                                        <?php } ?>

                                        <?php if (!empty($row['question3'])  && ($row['answer3'])) { ?>
                                            <p class="question mt-3"><?= $row['qid'] ?>.) <?= $row['question3'] ?></p>
                                            <?php if (!empty($row['answer3'])) { ?>
                                                <div class="answers">
                                                    <p class="answer">Answer: <?= $row['answer3'] ?></p>
                                                    <input type="text" class="form-control" value="Comment: <?= $row['comment3'] ?? '' ?>" readonly>
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                <?php } ?>

                            </div>
                            <!-- Answers -->


                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <!-- <button type="button" class="btn btn-primary">Understood</button> -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap JS Bundle with Popper -->
        <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> -->



        <?php
        $sno = $_GET['sno'];

        $sq = mysqli_query($con, "select * from tblrawmaterial where id='$sno'");
        $row = mysqli_fetch_array($sq);

        $sq1 = mysqli_query($con, "select * from tblrawspecdetail where product='$sno'");
        $row1 = mysqli_fetch_array($sq1);
        ?>

        <div class="row mt-3">
            <div class="col-md-3">
                <div class="card card-profile-1 mb-4">
                    <div class="card-body text-center">

                        <p class="mt-0"> Product: <?php echo $row['pname']; ?></p>
                        <p>Product Code: <?php echo $row['pcode']; ?></p>
                        <p>Approved By: <?php echo $row1['uploadby']; ?></p>
                        <p>Approved On: <?php echo date('d-m-Y', strtotime($row1['date'])); ?></p>
                        <div>

                        <?php 
                        $snm = $row1['uploadby'];
                        $sgn = mysqli_query($con,"SELECT * FROM `tbladmin` WHERE name ='$snm'");
                        $sgn1 = mysqli_fetch_array($sgn);
                        
                        ?>

                            <img src="signature/<?php echo $sgn1['sign']; ?>" alt="" width="100" />

                            <button type="button" class="btn pl-3 pr-3 pt-2 pb-2" style=" background-color:#663399; color:white; " data-bs-toggle="modal" data-bs-target="#staticBackdrop">

                                View Detail

                            </button>
                        </div>

                    </div>
                </div>
            </div>

            <script>
                function cal() {
                    document.getElementById('cert1').style.display = "none";
                    document.getElementById('cert2').style.display = "block";

                }

                function cal1() {
                    document.getElementById('cert2').style.display = "none";
                    document.getElementById('cert1').style.display = "block";

                }
            </script>
            <div class="col-md-8">




                <div class="card card-profile-1 mb-12">

                    <iframe src="specdetail/<?php echo $row1['spec']; ?>" height="400" id="cert2"></iframe>



                </div>





            </div>


        </div>




    </div>
</div>
</div>
</div>