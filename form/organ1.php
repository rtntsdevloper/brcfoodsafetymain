<?php
include 'connection.php';

?>


<div class="main-content">

    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>Weekly Production Organoleptic Assessment Record</li>
        </ul>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">

                <h4>Weekly Production Organoleptic Assessment Record</h4>
                <a href="admin.php?id=organ"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data" action="">
                    <div class="form-row mt-5">
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Date</label>
                            <input class="form-control" id="validationTooltip01" type="date" required="required" name="date" />
                            <div class="invalid-tooltip">
                                Please provide a valid date.
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Conducted by</label>
                            <input class="form-control" id="validationTooltip01" type="text" required="required" name="conduct" />
                            <div class="invalid-tooltip">
                                Please provide a valid date.
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Product Name</label>
                            <input class="form-control" id="validationTooltip02" type="text" placeholder="" name="product" required />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Batch Details</label>
                            <input class="form-control" id="validationTooltip02" type="text" placeholder="" name="details" required />
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Appearance</label>
                            <select name="appearance" class="form-control" id="" required>
                                <option value="">Please Select</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip03">Aroma</label>
                            <select name="aroma" class="form-control" id="" required>
                                <option value="">Please Select</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>


                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip03">Texture</label>
                            <select name="texture" class="form-control" id="" required>
                                <option value="">Please Select</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                            <div class="invalid-tooltip">
                                Please fill the field.

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip03">Flavour</label>
                            <select name="flavour" class="form-control" id="" required>
                                <option value="">Please Select</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                            <div class="invalid-tooltip">
                                Please fill the field.
                            </div>
                        </div>

                        <!-- <div class="col-md-12 mb-3">
                            <label for="validationTooltip03">QAS Comments</label>
                            <textarea class="form-control" id="validationTooltip04" type="text" required="required" name="qas"></textarea>
                            <div class="invalid-tooltip">
                                Please fill the field.
                            </div>
                        </div> -->

                    </div>

                    <style>
                        .heading-tab {
                            cursor: pointer;
                            padding: 10px;
                            background-color: #f8f9fa;
                            border: 1px solid #dee2e6;
                            border-radius: 4px;
                            margin-bottom: 5px;
                        }

                        .heading-tab h6 {
                            margin: 0;
                        }

                        .sub-tabs {
                            padding: 10px;
                            border: 1px solid #dee2e6;
                            border-top: none;
                            border-radius: 0 0 4px 4px;
                        }
                    </style>



                    <button class="btn btn-primary" type="submit" name="submit">Save & Next</button>

            </div>
        </div>
    </div>




    </form>
</div>
<?php

if (isset($_POST['submit'])) {

    $date = $_POST['date'];
    $product = $_POST['product'];
    $details = $_POST['details'];
    $appearance = $_POST['appearance'];
    $aroma = $_POST['aroma'];
    $texture = $_POST['texture'];
    $flavour = $_POST['flavour'];
    // $qas = $_POST['qas'];
    $conduct = $_POST['conduct'];
    $unique_id = 'REC-'.date('dmYhis');


    $sql = "INSERT INTO tblorgan (recordid, date, product, details, appearance, aroma, texture, flavour, conducted) VALUES ('$unique_id', '$date', '$product', '$details', '$appearance', '$aroma', '$texture', '$flavour', '$conduct')";
    if (mysqli_query($con, $sql)) {
    } else {
        echo "<script>alert('Error adding record: " . mysqli_error($con) . "');</script>";
    }


    if ($appearance == '1' || $aroma == '1' || $texture == '1' || $flavour == '1') {

        $emdate = date('d-m-Y', strtotime($date));
        require_once('PHPMailer/class.phpmailer.php');
        $mail = new PHPMailer();

        $cvyear = date('Y');


$body = '<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Organoleptic Testing Result</title>
<style>
    body { width:100%; font-family: Arial, sans-serif; background:#f4f4f4; margin:0; padding:0; }
    .email-container { max-width:600px; margin:20px auto; background: #fff; border-radius:8px; overflow:hidden; box-shadow:0 4px 8px rgba(0,0,0,0.1); }
    .header { background: #85a6f1; color: #fff; padding:40px 20px; text-align:center; }
    .logo-container { display:flex; justify-content:space-between; margin-bottom:10px; }
    .logo-container img { max-width:80px; }
    .customer-details { background:#f9f9f9; padding:15px; border-bottom:1px solid #fff; }
    .qa-section { padding:20px; }
    .qa-section h3 { color:#182848; margin-bottom:10px; }
    .rejection { color:red; margin:8px 0; }
    .approval { color:green; margin:8px 0; }
    .footer { background:#182848; color:#fff; text-align:center; padding:10px; font-size:12px; width:100%; }

    table {
      width: 100%;
      border-collapse: collapse;
      margin: 20px auto;
      font-family: Arial, sans-serif;
    }
    th, td {
      border: 1px solid #333;
      padding: 10px;
      text-align: center;
    }
    th {
      background-color: #f2f2f2;
    }
    .red {
      background-color: #ff0000;
      color: white;
      font-weight: bold;
    }
    .yellow {
      background-color: #ffa500;
      color: White;
      font-weight: bold;
    }
    .green {
      background-color: #018001;
      color: white;
      font-weight: bold;
    }
</style>
</head>
<body>
<div class="email-container">
    <div class="header">
        <div>
            <img src="images/1.png" alt="Logo1" height="40" width="60">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <img src="images/rtnts.png" alt="Logo2" height="50" width="70"><br>
        </div>
    </div>
    <div class="customer-details">
            <h2>Organoleptic Assessment </h2>

        <h4>Basic Information</h4>
        <p><strong>Date:</strong> ' . $emdate . '</p>
        <p><strong>Product Name:</strong> ' . $product . '</p>
        <p><strong>Batch Code:</strong> ' . $details . '</p>
        <p><strong>Attempted By:</strong> ' . $conduct . '</p>
    </div>
    <div class="qa-section">
        <h3> Results</h3>';

// rejection messages
// if ($appearance == '1') {
//     $body .= '<p class="rejection"><strong>Rejected:</strong> Appearance failed (value ' . $appearance . ')</p>';
// }
// if ($aroma == '1') {
//     $body .= '<p class="rejection"><strong>Rejected:</strong> Aroma failed (value ' . $aroma . ')</p>';
// }
// if ($texture == '1') {
//     $body .= '<p class="rejection"><strong>Rejected:</strong> Texture failed (value ' . $texture . ')</p>';
// }
// if ($flavour == '1') {
//     $body .= '<p class="rejection"><strong>Rejected:</strong> Flavour failed (value ' . $flavour . ')</p>';
// }

// helper function for table rows
// helper function for table rows
function statusRow($aspect, $value) {
    switch ($value) {
        case '1':
            $class = "red";
            $status = "Rejected";
            break;

        case '2':
            $class = "yellow";
            $status = "Warning";
            $action = "Monitor and adjust if needed";
            break;

        case '3':
            $class = "green";
            $status = "Accepted";
            $action = "No action required";
            break;

        default:
            $class = "";
            $status = "Unknown";
            $action = "Investigate further";
    }

    // Only return row if status is Rejected
    if ($status !== "Rejected") {
        return "";
    }

    return "<tr>
              <td>{$aspect}</td>
              <td>{$value}</td>
              <td class=\"{$class}\">{$status}</td>
            </tr>";
}

// Generate a unique record ID globally
$rid = "REC-".date('dmYhis');

$body .= ' <table>
    <tr>
      <th>Aspect</th>
      <th>Value</th>
      <th>Status</th>
    </tr>'
    . statusRow("Aroma", $aroma)
    . statusRow("Appearance", $appearance)
    . statusRow("Texture", $texture)
    . statusRow("Flavour", $flavour)
  . '</table>
  ';

// Correction Action button
$body .= '<a href="organ.php?id=' . $rid . '" class="btn btn-primary">Correction Action</a>';

echo $body;

        // $mail->SetFrom("techsupport@rtnts.co.uk", "RTNTS");
        // $mail->AddReplyTo("techsupport@rtnts.co.uk", "RTNTS");
        // $emaild = 'RITZ2@rtnts.co.uk';
        // $emailname = 'RTNTS';
        // $mail->AddAddress($emaild, $emailname);

        // $mail->Subject = 'Organolaptic testing results';
        // $mail->MsgHTML($body);

        // //$mail->AddAttachment("upl/".$date."-".$gh['concession']."-".$gh['username']."-".$depty.".pdf");
        
        // if (!$mail->Send()) {
        //     echo "Mailer Error: " . $mail->ErrorInfo;
        // } else {
        //     echo "mail sent";
        // }



        echo "<script>alert('Record added successfully');</script>";
        // echo "<script>window.location.href='admin.php?id=organ&rid=" . $unique_id . "';</script>";
    }
}
?>