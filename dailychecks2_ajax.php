<?php
// dailychecks2_ajax.php
session_start();
include 'connection.php';
date_default_timezone_set('Europe/London');

// Only allow autosave action
if (empty($_POST['action']) || $_POST['action'] !== 'autosave') {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid action']);
    exit;
}

// Validate required fields
$required = ['cid', 'ques', 'section'];
foreach ($required as $field) {
    if (empty($_POST[$field])) {
        http_response_code(400);
        echo json_encode(['error' => "Missing required field: $field"]);
        exit;
    }
}

// Sanitize inputs
$cid = mysqli_real_escape_string($con, $_POST['cid']);
$tid = isset($_POST['tid']) ? mysqli_real_escape_string($con, $_POST['tid']) : '';
$ques = mysqli_real_escape_string($con, $_POST['ques']);
$section = mysqli_real_escape_string($con, $_POST['section']);
$current_date = date("Y-m-d H:i:s");
$user = isset($_SESSION['user']) ? $_SESSION['user'] : '';

// Check if record exists for this specific cid and ques combination
$check_query = "SELECT id, pic, ans FROM dailychecks2 WHERE cid='$cid' AND ques='$ques'";
$check_result = mysqli_query($con, $check_query);

if (!$check_result) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . mysqli_error($con)]);
    exit;
}

$exists = mysqli_num_rows($check_result) > 0;
$existing_images = [];
$current_ans = '';

if ($exists) {
    $row = mysqli_fetch_assoc($check_result);
    $current_ans = $row['ans'];
    
    if (!empty($row['pic'])) {
        $existing_images = json_decode($row['pic'], true);
        if (!is_array($existing_images)) {
            $existing_images = [];
        }
    }
}

// Build SET clause for non-file fields
$fields = "date='$current_date', user='$user', section='$section'";

// Process form fields
$field_mappings = [
    'r1' => 'ans',
    'input' => 'input',
    'cmnt' => 'cmnt',
    'answer' => 'answer',
    'dateinput' => 'dateinput',
    'timeinput' => 'timeinput'
];

foreach ($_POST as $key => $value) {
    // Skip system fields
    if (in_array($key, ['action', 'cid', 'tid', 'ques', 'section'])) {
        continue;
    }
    
    // Check if this key matches any of our field patterns
    foreach ($field_mappings as $prefix => $db_field) {
        if (strpos($key, $prefix) === 0) {
            $value = mysqli_real_escape_string($con, $value);
            
            // SPECIAL HANDLING FOR 'ans' FIELD
            // Only update if the value is different from current
            if ($db_field === 'ans') {
                // Check if record exists and current ans value
                if ($exists && $current_ans !== '') {
                    // Only update if the new value is different from current
                    if ($value !== $current_ans) {
                        $fields .= ", $db_field='$value'";
                    }
                    // If same value, skip this field
                } else {
                    // New record or empty current ans, set the value
                    $fields .= ", $db_field='$value'";
                }
            } else {
                $fields .= ", $db_field='$value'";
            }
            break;
        }
    }
}

// Handle multiple file uploads
$uploaded_files = [];
$upload_dir = "upl1/";


if (!empty($_FILES)) {
    foreach ($_FILES as $key => $fileArr) {
        if (!is_array($fileArr['name'])) {
            continue;
        }
        
        foreach ($fileArr['name'] as $idx => $originalName) {
            if (empty($originalName) || $fileArr['error'][$idx] !== UPLOAD_ERR_OK) {
                continue;
            }
            
            $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
            $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg', 'ico', 'tiff', 'tif'];
            
            if (!in_array($ext, $allowed_types)) {
                continue;
            }
            
            if ($fileArr['size'][$idx] > 5 * 1024 * 1024) {
                continue;
            }
            
            $safeName = time() . '_' . uniqid() . '.' . $ext;
            
            if (move_uploaded_file($fileArr['tmp_name'][$idx], $upload_dir . $safeName)) {
                $uploaded_files[] = $safeName;
            }
        }
    }
}

// Merge existing and new images
if (!empty($uploaded_files)) {
    $all_images = array_merge($existing_images, $uploaded_files);
    $fields .= ", pic='" . mysqli_real_escape_string($con, json_encode($all_images)) . "'";
} elseif (!empty($existing_images)) {
    $fields .= ", pic='" . mysqli_real_escape_string($con, json_encode($existing_images)) . "'";
}

// Build and execute query - use UPDATE if exists, INSERT if not
if ($exists) {
    $query = "UPDATE dailychecks2 SET $fields WHERE cid='$cid' AND ques='$ques'";
} else {
    $query = "INSERT INTO dailychecks2 SET cid='$cid', ques='$ques', $fields";
}

if (!mysqli_query($con, $query)) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Database error: ' . mysqli_error($con)
    ]);
    exit;
}

// Return success response with debug info
echo json_encode([ 
    'success' => true,
    'message' => 'Saved successfully',
    'uploaded_files' => $uploaded_files,
    'total_files' => count($uploaded_files),
    'record_exists' => $exists,
    'query' => $query // Added for debugging - remove in production
]);
?>