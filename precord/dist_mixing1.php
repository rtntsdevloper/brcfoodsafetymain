<?php

include "../connection.php";

$distrecp = $_GET['prid'];

$sq = mysqli_query($con, "select * FROM `dist_recipe` where id='$distrecp'");
$rw = mysqli_fetch_array($sq);
$recipename = $rw['name'];
$recipecode = $rw['recnum'];

?>

<div class="col-md-12">

    <div class="row pl-3 my-4">
        <div class="col-md-12">
            <div class="row">
                <h3>Ingredients Details :</h3>
            </div>
            <div class="row">
                <h4>Recipe No : <?php echo $recipecode; ?> </h4>
            </div>
        </div>

        <input type="hidden" name="recipen" value="<?php echo $recipename; ?>">
        <input type="hidden" name="recipeno" value="<?php echo $recipecode; ?>">

    </div>

    <?php
    $ingre = mysqli_query($con, "SELECT * FROM `dist_recipe1` WHERE tid='$distrecp'");
    while ($rw_ingre = mysqli_fetch_array($ingre)) {


    ?>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">Ingredient</label>
                    <input type="text" name="ingredient_name[]" id="ingredient_name" class="form-control" value="<?php echo $rw_ingre['ingredient']; ?>" readonly>

                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">Ingredient Code</label>
                    <input type="text" name="ingredient_code[]" id="ingredient_code" class="form-control" value="<?php echo $rw_ingre['pcode']; ?>" readonly>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">Allergen Information</label>
                    <input type="text" name="allergen_info[]" id="allergen_info" class="form-control" value="<?php echo $rw_ingre['allergen']; ?>" readonly>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">Quantity(kg) as per 2000 ltrs</label>
                    <input type="text" name="quantity20[]" id="quantity" class="form-control" readonly value="<?php echo $rw_ingre['quantity20']; ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">Quantity(kg) as per 1200 ltrs</label>
                    <input type="text" name="quantity12[]" id="quantity" class="form-control" readonly value="<?php echo $rw_ingre['quantity12']; ?>">
                </div>
            </div>
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">Actual Quantity(kg)</label>
                    <div class="input-group">

                        <input type="number" name="actual_quantity[]" id="actual_quantity" class="form-control" required>

                        <span class="input-group-text">kg</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">Batch Number</label>
                    <input type="text" name="batch_number[]" id="batch_number" class="form-control" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">Best before/Use by Date</label>
                    <input type="date" name="best_before[]" id="best_before" class="form-control" required>
                </div>
            </div>
           




        </div>
        <br>
        <hr>
        <br>
    <?php } ?>


    <div class="row">

        <div class="col-md-4">
            <div class="form-group">
                <label for="">Milk Into Tank No.</label>
                <input type="text" name="tankno" id="tankno" class="form-control" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Tank Cleaned </label>
                <select name="tankcleaned" id="tankcleaned" class="form-control" required>
                    <option value="">Select</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Comments</label>
                <textarea name="mixcmnt" id="mixcmnt" class="form-control" required></textarea>
            </div>
        </div>

    </div>


    <div class="row">
        <div class="form-group">
            <button class="btn btn-primary" type="submit" name="submit">Submit</button>
        </div>
    </div>
</div>