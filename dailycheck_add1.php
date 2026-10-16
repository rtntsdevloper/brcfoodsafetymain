
<?php

$sectid= $_GET['option'];
include 'connection.php';

?>

<label for="validationTooltip01">Sub-Section</label>
<select class="form-control" id="validsub" required="required" name="ssid" onchange="document.getElementById('subid').value = this.options[this.selectedIndex].getAttribute('data-id')" >
    <option value="">Please Select</option>
    <?php
    $gh2 = mysqli_query($con, "select * from dailychecksub where tid='$sectid'");
    
    while ($row2 = mysqli_fetch_array($gh2)) {
    ?>
        <option value="<?php echo $row2['name']; ?>" data-id="<?php echo $row2['id']; ?>"><?php echo $row2['name']; ?></option>

    <?php
    }
    ?>
</select>


<input type="hidden" id="subid" name="subid">



<div class="invalid-tooltip">
    Please provide a valid name.
</div>