<?php
include '../connection.php';
$str = $_GET['q'];

?>
<div class="form-row"> 
<?php
$sql2 = mysqli_query($con, "select distinct section from tblques2 where status='$str'");
while ($rows2 = mysqli_fetch_array($sql2)) {
?>
    <div class="col-md-12">
        <label class="control-label mb-1" style="color:#0033FF; font-size:14px">
            <?php echo $rows2['section']; ?>
        </label>
    </div>
<?php
    $sql = mysqli_query($con, "select * from tblques2 where status='$str' and section='$rows2[section]'");
    $i = 0;
    while ($rows = mysqli_fetch_array($sql)) {
?>
        <div class="col-md-6">
            <label class="control-label mb-1"><?php echo $rows['ques']; ?></label>
        </div>

        <div class="col-md-2">
            <select class="form-control" name="ans[]" 
                    onchange ="commentx(this.value,<?= $rows['id']; ?> )">
                <option value="">Please Select</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
        </div>

        <div class="col-md-4">
            <textarea class="form-control" name="cmnt[]" 
                      placeholder="Comment if any?" 
                      id="f1<?php echo $rows['id']; ?>"></textarea>
        </div>
<?php
        $i++;
    }
}
?>
</div>

<div class="col-md-4">
	<label for="x_card_code" class="control-label mb-1">
		<textarea class="form-control" name="cmntm" placeholder="Comment if any?"></textarea>


	</label>

</div>
