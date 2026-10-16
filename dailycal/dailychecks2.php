<?php

session_start();
include '../connection.php';
date_default_timezone_set('Europe/London');
$date = $_POST['date'];
$name = $_POST['name'];
$tid = $_POST['tid'];
$user = $_SESSION['user'];
$ansa = array();
$qsa = array();
$cmsta = array();


$sxid = $_POST['sxid'];


$gh = mysqli_query($con, "insert into dailycheckss(name,date,user,ename)values('$tid','$date','$user','$name')");

$ghj = mysqli_query($con, "select * from dailycheckss where name='$tid' and date='$date' and user='$user' order by id desc limit 1");
$ghj11 = mysqli_fetch_array($ghj);
$cid = $ghj11['id'];
// echo $cid = '1';

if (!empty($_POST['ques'])) {
    for ($i = 0; $i < count($_POST['ques']); $i++) {
        $q = mysqli_real_escape_string($con, $_POST['ques'][$i]);
        $section = mysqli_real_escape_string($con, $_POST['section'][$i]);

        if (empty($_POST['r1' . $i])) {
            $ans = ''; // Or some default action
        } else {
            $ans = $_POST['r1' . $i];
        }

        if (empty($_POST['cmnt' . $i])) {
            $cmnt = ''; // Or some default action
        } else {
            $cmnt = $_POST['cmnt' . $i];
        }
        if (empty($_POST['input' . $i])) {
            $input = ''; // Or some default action
        } else {
            $input = $_POST['input' . $i];
        }
        if (empty($_POST['answer' . $i])) {
            $answer = ''; // Or some default action
        } else {
            $answer = $_POST['answer' . $i];
        }

        if (empty($_POST['dateinput' . $i])) {
            $dateinput = ''; // Or some default action
        } else {
            $dateinput = $_POST['dateinput' . $i];
        }

        if ($ans == 'No') {
            $ansa[$i] = 'No';
            $qsa[$i] = $q;
            $cmsta[$i] = $cmnt;
        }


        $file = $_FILES['img' . $i]['name'];


        if ($file != "") {
            $file = $i . date('dmyhis') . $_FILES['img' . $i]['name'];
            move_uploaded_file($_FILES["img" . $i]["tmp_name"], "upl1/" . $file);
        }

        $gh1 = mysqli_query($con, "insert into dailychecks2(cid,ques,ans,pic,cmnt,date,user,section,input,answer,dateinput)values('$cid','$q','$ans','$file','$cmnt','$date','$user','$section','$input','$answer','$dateinput')");
    }
}

$dsp = mysqli_query($con, "SELECT * FROM `dailychecks` WHERE id='$tid'");
$dsp1 = mysqli_fetch_array($dsp);
$dspn = $dsp1['name'];
$datec = date('d-m-Y', strtotime($date));
require_once('../PHPMailer/class.phpmailer.php');
$mail = new PHPMailer();
$body = '';
$body .= '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Email</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: "Arial", sans-serif;
            background-color: #f4f4f4;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(90deg, #4b6cb7, #182848);
            padding: 30px;
            text-align: center;
            color: #ffffff;
            position: relative;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .logo-container {
            display: flex;
            justify-content: space-between;
            position: absolute;
            top: 20px;
            width: 100%;
            padding: 0 20px;
            box-sizing: border-box;
        }
        .logo-container img {
            max-width: 80px;
            height: auto;
        }
        .customer-details {
            padding: 20px;
            background-color: #f9f9f9;
            border-bottom: 1px solid #e0e0e0;
        }
        .customer-details h2 {
            color: #4b6cb7;
            font-size: 20px;
            margin-bottom: 10px;
        }
        .customer-details p {
            margin: 5px 0;
            color: #333333;
        }
        .qa-section {
            padding: 20px;
            line-height: 1.6;
            color: #333333;
        }
        .qa-section h3 {
            color: #182848;
            font-size: 18px;
            margin-bottom: 10px;
        }
        .qa-item {
            margin-bottom: 15px;
        }
        .qa-item strong {
            color: #4b6cb7;
            display: block;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4b6cb7;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            text-align: center;
        }
        .button:hover {
            background-color: #182848;
        }
        .footer {
            background-color: #182848;
            color: #ffffff;
            text-align: center;
            padding: 15px;
            font-size: 12px;
        }
        @media screen and (max-width: 600px) {
            .email-container {
                width: 100%;
            }
            .logo-container {
                flex-direction: column;
                align-items: center;
                position: static;
                padding: 10px;
            }
            .logo-container img {
                margin-bottom: 10px;
            }
            .header {
                padding-top: 80px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="logo-container">
                 <img src="images/logo1.png" alt="Company Logo 1" width= "80">
                <img src="images/rtnts.png" alt="Company Logo 2" width= "80">
            </div>
            <h1>Daily Checks Nc Detail</h1>
        </div>
        <div class="customer-details">
            <h2>Basic Information</h2>
            <p><strong>Checks Name :</strong> ' . $dspn . '</p>
            <p><strong>Date :</strong> ' . $datec . '</p>
			 <p><strong>Attempted By :</strong> ' . $name . '</p>
           
        </div>

        <div class="qa-section">
            <h3>Non Conformance Detail</h3>';
$pkc = 1;
foreach ($ansa as $key => $value) {
    $qsnp = $qsa[$key];
    $qsna = $value;
    $qsnc = $cmsta[$key];
    $body .= '
	<div class="qa-section">
            
            <div class="qa-item">
                <strong>Question-' . $pkc . ' : ' . $qsnp . '</strong>
                <p><b >Answer : </b> ' . $qsna . '</p>
                 <p><b>Comment : </b> ' . $qsnc . '</p>
            </div>
          
           
            
        </div>
    
	';
    $pkc++;
}
$cvyear = date('Y');
$body .= '

    
  <div class="footer">
            <p>&copy; ' . $cvyear . ' RTNTS. All rights reserved.<br>
           
        </div>
    </div>
</body>
</html>';

if (!empty($ansa)) {


    // $mail->SetFrom("techsupport@rtnts.co.uk", "RTNTS");
    // $mail->AddReplyTo("techsupport@rtnts.co.uk", "RTNTS");
    // $sql = mysqli_query($con, "select * from tblemail");
    // while ($row = mysqli_fetch_array($sql)) {
    //     $email = $row['email'];
    //     $nme = $row['name'];
    //     $mail->AddAddress("$email", $nme);
    // }
    // $mail->AddBcc("email@rtnts.co.uk", "Admin");
    // $mail->Subject = 'Daily Checks Non Conformance Detail';
    // $mail->MsgHTML($body);

    //$mail->AddAttachment("upl/".$date."-".$gh['concession']."-".$gh['username']."-".$depty.".pdf");
    if (!$mail->Send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
    }
}


?>

<script language="javascript">
    window.open('../admin.php?id=dailycal&sid=<?php echo $sxid; ?>', '_self');
</script>