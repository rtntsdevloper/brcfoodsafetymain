<?php
$sno = $_GET['sno'];
$rid = $_GET['rid'];

$sql = mysqli_query($con, "select * from tblequipment1 where id='$sno'");
$row = mysqli_fetch_array($sql);

$sql2 = mysqli_query($con, "select * from tblequipment where id='$row[eid]'");
$row2 = mysqli_fetch_array($sql2);

// Define questions array for loop
$questions = [
    '1' => 'Equipment visually inspected?',
    '2' => 'Equipment operates correctly?',
    '3' => 'Safety guards fitted?',
    '4' => 'Emergency stops functioning?',
    '5' => 'Is the area free from any foreign object?',
    '6' => 'Equipment safe for production use?',
    '7' => 'Is it visually clean?',
    '8' => 'Are the swabs required?'
];
?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">verification</a></li>
            <li>Detail</li>
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="card-body">
                        <h3 align="center" style="color:#FF0000"> Machine Verification Detail</h3>
                        <form enctype="multipart/form-data" method="post" name="form1" style="font-size:16px;">

                            <?php 
                            $counter = 1;
                            foreach($questions as $alpha => $question){ 
                            ?>
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip01"><?php echo $alpha; ?>. <?php echo $question; ?></label>
                                    <select class="form-control" name="que[<?php echo $counter; ?>]" required="required" onchange="toggleComment(this, <?php echo $counter; ?>)">
                                        <option value="">Please Select</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                    
                                    <!-- Comment and Picture section (hidden by default) -->
                                    <div id="commentSection<?php echo $counter; ?>" style="display:none; margin-top:10px;">
                                        <div class="form-group">
                                            <label>Corrective Action</label>
                                            <textarea class="form-control" name="comment[<?php echo $counter; ?>]" rows="2" placeholder="Please provide your comment..." id="comment<?php echo $counter; ?>"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Upload image</label>
                                            <input type="file" class="form-control" name="picture[<?php echo $counter; ?>]" accept="image/*">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php 
                            $counter++;
                            } 
                            ?>

                            <!-- Commissioning Section - Display in Different Columns -->
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label>Commissioning Outcome</label>
                                    <select class="form-control" name="commissioning_outcome" required="required">
                                        <option value="">Please Select</option>
                                        <option value="Pass">Pass</option>
                                        <option value="Fail">Fail</option>
                                    </select>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label>Date of Commissioned</label>
                                    <input type="date" class="form-control" name="commissioning_date" required>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label>Commissioned By</label>
                                    <input type="text" class="form-control" name="commissioned_by" required placeholder="Enter name">
                                </div>
                            </div>

                            <!-- Comment in full width -->
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label>Comment</label>
                                    <textarea class="form-control" name="commissioning_comment" rows="3" placeholder="Enter your comment..."></textarea>
                                </div>
                            </div>

                            <br>
                            <button class="btn btn-primary" type="submit" name="submit">Submit</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleComment(selectElement, index) {
    var commentSection = document.getElementById('commentSection' + index);
    var textarea = document.getElementById('comment' + index);
    
    if (selectElement.value === 'No') {
        commentSection.style.display = 'block';
        textarea.required = true;
    } else {
        commentSection.style.display = 'none';
        textarea.required = false;
        textarea.value = '';
        // Clear file input
        var fileInput = commentSection.querySelector('input[type="file"]');
        if (fileInput) {
            fileInput.value = '';
        }
    }
}

// Form validation
document.addEventListener('DOMContentLoaded', function() {
    var form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            var selects = document.querySelectorAll('select[name^="que"]');
            var isValid = true;
            var errorMessages = [];
            
            selects.forEach(function(select) {
                var name = select.getAttribute('name');
                var index = name.match(/\d+/)[0];
                var commentSection = document.getElementById('commentSection' + index);
                
                if (select.value === 'No') {
                    var textarea = document.getElementById('comment' + index);
                    
                    if (textarea && textarea.value.trim() === '') {
                        var label = select.closest('.col-md-6').querySelector('label');
                        errorMessages.push('Please provide a comment for: ' + label.textContent);
                        isValid = false;
                    }
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert(errorMessages.join('\n'));
            }
        });
    }
});
</script>

<?php
if (isset($_POST['submit'])) {
    
    // Store only Yes/No answers
    $que_answers = array();
    $comment_answers = array();
    $image_names = array();
    
    foreach($_POST['que'] as $key => $que_value) {
        // Store only the answer (Yes/No)
        $que_answers[] = $que_value;
        
        // Store comment if exists
        if(!empty($_POST['comment'][$key])) {
            $comment_answers[] = $_POST['comment'][$key];
        } else {
            $comment_answers[] = ''; // Empty comment for this question
        }
        
        // Handle image upload
        if (isset($_FILES['picture']['name'][$key]) && $_FILES['picture']['name'][$key] != '') {
            $file_name = $_FILES['picture']['name'][$key];
            $file_tmp = $_FILES['picture']['tmp_name'][$key];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            $unique_name = uniqid() . '_' . time() . '.' . $file_ext;
            $file_destination = "upl1/" . $unique_name;
            
            if (move_uploaded_file($file_tmp, $file_destination)) {
                $image_names[] = $unique_name;
            }
        } else {
            $image_names[] = ''; // Empty image for this question
        }
    }
    
    // Get commissioning data
    $commissioning_outcome = $_POST['commissioning_outcome'];
    $commissioning_comment = $_POST['commissioning_comment'];
    $commissioning_date = $_POST['commissioning_date'];
    $commissioned_by = $_POST['commissioned_by'];
    
    // Combine all data into single fields with semicolon separator
    $que_combined = implode(' ; ', $que_answers);
    $comment_combined = implode(' ; ', $comment_answers);
    $image_combined = implode(' ; ', $image_names);
    
    // Escape strings for database
    $que_combined =  $que_combined;
    $comment_combined =  $comment_combined;
    $image_combined =  $image_combined;
    $commissioning_outcome =  $commissioning_outcome;
    $commissioning_comment =  $commissioning_comment;
    $commissioning_date =  $commissioning_date;
    $commissioned_by =  $commissioned_by;
    
    // Insert into database with separate columns for commissioning data
    $sq1 = mysqli_query($con, "INSERT INTO `raiseverify`(`sno`, `que`, `comment`, `img`, `outcome`, `comment1`, `datecommission`, `commisionby`) 
                               VALUES ('$sno','$que_combined','$comment_combined','$image_combined','$commissioning_outcome','$commissioning_comment','$commissioning_date','$commissioned_by')");

    if($sq1) {
        // Update equipment status
        $update = mysqli_query($con, "UPDATE `tblequipment1` SET `mverify` = 'done' WHERE `tblequipment1`.`id` ='$sno'");
    }

    ?>
    <script language="javascript">
        window.open('admin.php?id=raisereportverify&sno=<?php echo $sno; ?>&rid=<?php echo $rid; ?>', '_self');
    </script>
    <?php
}
?>