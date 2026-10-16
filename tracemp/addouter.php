<?php
include 'connection.php';
$pid = $_GET['eid'];
$pde = mysqli_query($con, "SELECT * FROM tblouter1 WHERE id='$pid'");
$pde1 = mysqli_fetch_array($pde);
$pdate = $pde1['date'];

$addout = mysqli_query($con, "SELECT * FROM tblouter where eid='$pid'");
$addout1 = mysqli_num_rows($addout);
$addn = "Out" . $pid . $addout1;

$pb = $pde1['prodbatch'];
$pb1  = explode(",", $pb);

?>


<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>Add Outer Packaging</li>
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=outer&eid=<?php echo $pid; ?>"><button class="btn btn-success"
                        style="float:right; margin-left:15px">Go Back</button></a>




                <form class="needs-validation" novalidate="novalidate" action="tracemp/packdone" method="post" enctype="multipart/form-data"
                    action="">
                    <div class="form-row mt-5">

                        <div class="col-md-12">
                            <h4 class="text-primary mt-5 mb-3">All Available Batches : </h4>
                            <div class="row">



                                <?php
                                $i = 1;
                                foreach ($pb1 as $key => $value) {
                                    $sqlp = mysqli_query($con, "SELECT *  FROM `tbllabel` where recordid = '$value' and produceleft != 0;");
                                    $pdata = mysqli_fetch_array($sqlp);




                                ?>

                                    <div class="col-md-4">
                                        <label for="cc-exp" class="control-label mb-1">Left Quantity (In Kg)</label>
                                        <input type="text" class="form-control" name="day<?php echo $i; ?>" value="<?php echo htmlspecialchars($pdata['produceleft']); ?>" disabled="disabled" />
                                    </div>

                                    <div class="col-md-4">
                                        <label for="cc-exp" class="control-label mb-1">Use By (Batchcode :<?php echo $pdata['recordid']; ?> )</label>
                                        <input type="date" class="form-control" name="day<?php echo $i; ?>" value="<?php echo htmlspecialchars($pdata['bbdate']); ?>" disabled="disabled" />
                                    </div>

                                    <div class="col-md-4">
                                        <label for="x_card_code" class="control-label mb-1" id="qused<?php echo $i; ?>"> Quantity Used (In Kg) </label>
                                        <input type="number"
                                            class="form-control"
                                            name="qty<?php echo $i; ?>"
                                            id="qty<?php echo $i; ?>"
                                            min="0"
                                            step="0.001"
                                            max="<?php echo $pdata['produceleft']; ?>"
                                            oninput="calculateQuantity(this.value, <?php echo $pdata['id']; ?>,<?php echo $i; ?>)" />
                                    </div>
                                <?php
                                    $i++;
                                }



                                ?>
                            </div>
                        </div>

                    </div>

                    <input type="hidden" name="btch" value="<?php echo $addn; ?>">
                     <input type="hidden" name="prid" value="<?php echo $pid; ?>">
                    <div id="newk">

                    </div>
                    <script>
                        function calculateQuantity(quantity, qid, index) {

                            // Basic validation
                            const batch = <?php echo json_encode($addn); ?>;
                            if (isNaN(quantity) || quantity < 0) {
                                document.getElementById('qused' + index).innerHTML = "Please enter a valid quantity";
                                return;
                            }


                            // Make the AJAX request
                            const xhr = new XMLHttpRequest();
                            xhr.onreadystatechange = function() {
                                if (this.readyState === 4) {
                                    if (this.status === 200) {

                                      


                                    } else {
                                        console.error("Request failed with status:", this.status);
                                        document.getElementById('qused' + index).innerHTML = "Error updating quantity";
                                    }
                                }
                            };



                            xhr.open("GET", "tracemp/packsdetail.php?quantity=" + quantity +
                                "&qid=" + qid + "&batch=" + batch, true);
                            xhr.send();

                        }
                    </script>


                    <button class="btn btn-primary" type="submit" name="submit">Save & Next</button>
            </div>
        </div>




    </div>



    </br>

    </form>
</div>