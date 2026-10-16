<?php
// $r=mysqli_query($con,"select * from attempt where username='$_SESSION[uname]'");
// $num=mysqli_num_rows($r);
// echo $num;

?>

<div class="main-content">
    <div class="breadcrumb">

        <ul>
            <li><a href="">Home</a></li>
            <li>Halal / Kosher Products </li>
        </ul>
    </div>
    <div class="container-fluid " style="margin-top:50px;">
        <div class="row mb-12">
            <div class="col-md-12 mb-12">
                <div class="card text-left">
                    <div class="card-body">
                        <div class="row mb-3">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#">All</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="admin?id=rawhalal2&pid=h">Halal Products</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="admin?id=rawhalal2&pid=k">Kosher Products</a>
                                </li>

                            </ul>
                        </div>

                        <a href="admin.php?id=1"><button class="btn btn-success"
                                style="float:right; margin-left:15px">Go Back</button></a>



                        <a href="admin.php?id=rawhalal1"><button class="btn btn-success ml-3 mb-3"
                                style="float:right">Add New</button></a>

                        <h4 class="card-title mb-3">Halal/Kosher Products</h4>
                        <!-- <p>List of staff</p> -->

                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered" id="zero_configuration_table"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sr. no</th>
                                        <th>Product name</th>
                                        <th>Supplier Name</th>
                                        <th>Type</th>
                                        <th>Certification Date</th>
                                        <th>Expiry Date</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = mysqli_query($con, "select * from tblhalal");



                                    $i = 0;
                                    // while (($y = mysqli_fetch_array($sql))&&(($z = mysqli_fetch_array($sql2))))  {
                                    while ($y = mysqli_fetch_array($sql)) {
                                        $i++;

                                    ?>
                                        <tr>
                                            <th scope="row"><?php echo $i; ?></th>
                                            <!-- <td ></td> -->
                                            <td><?php

                                                echo $y['name']; ?></td>
                                            <td><?php
                                                $spname = $y['supname'];
                                                $sname = mysqli_query($con, "SELECT * FROM `tblrawsupplier` WHERE supid ='$spname'");
                                                $sname1 = mysqli_fetch_array($sname);

                                                echo $sname1['supname']; ?></td>
                                            <td><?php

                                                echo $y['type']; ?></td>

                                            <td><?php

                                                echo  date('d-m-Y', strtotime($y['cdate'])); ?></td>
                                            <td><?php

                                                echo  date('d-m-Y', strtotime($y['edate'])); ?></td>
                                            <td>
                                                <a href="admin.php?id=rawhalal3&hid=<?php echo $y['id']; ?>" class="btn btn-info">Edit</a></a><?php

                                                                                                                                                echo  date('d-m-Y', strtotime($y['edate'])); ?>
                                            </td>

                                            <td>
                                                <?php
                                                if ($y['status'] == 'Active') {
                                                ?>
                                                    <button class="btn btn-warning" onclick="if(confirm('Are you sure?')) location.href='halaldelist.php?hid=<?php echo $y['id']; ?>';">
                                                        Archieve Product
                                                    </button>
                                                <?php
                                                } else {
                                                ?>
                                                    <button class="btn btn-danger"><i class="fa fa-trash"></i> Archieved</button>
                                                <?php
                                                }

                                                ?>
                                            </td>








                                        <?php
                                    }
                                        ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>






        <?php

        $sql1 = mysqli_query($con, "select * from tblhalal ");
        foreach ($sql1 as $rowp) {
            $rowid = $rowp['id'];
            $prodname = $rowp['name'];

            $rowty = $rowp['type'];

            $mdate =  date('d-m-Y', strtotime('-1 month'));
            $current = date('d-m-Y');
            echo $ldate = date('d-m-Y', strtotime($rowp['mail']));
            echo $taskan = $current - $ldate;


            $edate = date('d-m-Y', strtotime($rowp['edate']));
            $cdate = date('d-m-Y', strtotime($rowp['cdate']));
            $spname = $rowp['supname'];
            $sname = mysqli_query($con, "SELECT * FROM `tblrawsupplier` WHERE supid ='$spname'");
            $sname1 = mysqli_fetch_array($sname);
            if ($mdate > $edate) {
                $supnameq = $sname1['supname'];


                require_once('PHPMailer/class.phpmailer.php');
                $mail = new PHPMailer();



                $body = "";
                $body .= '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate Expiry Notification</title>
    <style>
        /* Reset styles for email clients */
        body, table, td, a {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
            margin: 0;
            padding: 0;
        }
        table, td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
            border-collapse: collapse;
        }
        img {
            -ms-interpolation-mode: bicubic;
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }
        
        /* Main styles */
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f6f9fc;
            color: #333333;
            margin: 0;
            padding: 20px 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #1a73e8 0%, #6c8ef5 100%);
            padding: 25px 30px;
            text-align: center;
        }
        .logo-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 100%;
        }
        .client-logo, .company-logo {
            max-height: 50px;
            width: auto;
        }
        .divider {
            color: white;
            font-size: 24px;
            margin: 0 15px;
        }
        .content {
            padding: 30px;
        }
        .alert-box {
            background-color: #fff8e6;
            border-left: 4px solid #ffc107;
            padding: 18px;
            margin-bottom: 25px;
            border-radius: 0 4px 4px 0;
        }
        .alert-title {
            font-weight: bold;
            color: #b76e00;
            margin-bottom: 8px;
            font-size: 18px;
        }
        .certificate-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 6px;
            margin: 25px 0;
            border: 1px solid #e8eaed;
        }
        .info-row {
            display: table;
            width: 100%;
            margin-bottom: 12px;
        }
        .info-label {
            display: table-cell;
            width: 40%;
            font-weight: bold;
            color: #5f6368;
            padding-bottom: 5px;
        }
        .info-value {
            display: table-cell;
            width: 60%;
            color: #202124;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(to right, #1a73e8, #6c8ef5);
            color: #ffffff;
            text-decoration: none;
            padding: 14px 30px;
            border-radius: 6px;
            font-weight: bold;
            margin: 20px 0;
            font-size: 16px;
            box-shadow: 0 2px 5px rgba(26, 115, 232, 0.3);
            transition: all 0.3s ease;
        }
        .cta-button:hover {
            background: linear-gradient(to right, #1669d6, #5a7ce8);
            box-shadow: 0 4px 8px rgba(26, 115, 232, 0.4);
        }
        .footer {
            background-color: #f8f9fa;
            padding: 25px;
            text-align: center;
            font-size: 14px;
            color: #5f6368;
            border-top: 1px solid #e8eaed;
        }
        .contact-info {
            margin-top: 15px;
            line-height: 1.6;
        }
        .small-text {
            font-size: 12px;
            color: #5f6368;
            margin-top: 25px;
            line-height: 1.5;
        }
        
        /* Media query for mobile responsiveness */
        @media screen and (max-width: 600px) {
            .container {
                width: 100% !important;
                border-radius: 0;
            }
            .content {
                padding: 20px !important;
            }
            .header {
                padding: 20px !important;
            }
            .logo-container {
                flex-direction: column;
                gap: 15px;
            }
            .divider {
                display: none;
            }
            .info-row {
                display: block;
            }
            .info-label, .info-value {
                display: block;
                width: 100%;
            }
            .info-label {
                margin-bottom: 5px;
                font-weight: bold;
            }
            .cta-button {
                display: block;
                text-align: center;
                margin: 25px auto;
            }
        }
    </style>
</head>
<body>
    <center>
        <table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%">
            <tr>
                <td align="center" valign="top">
                    <table class="container" border="0" cellpadding="0" cellspacing="0" width="600">
                        <!-- Header with both logos -->
                        <tr>
                            <td class="header">
                                <div class="logo-container">
                                    <!-- Client Logo -->
                                    <img src="images/1.png" alt="Client Logo" class="client-logo">
                                    <span class="divider"> </span>
                                    <!-- Company Logo -->
                                    <img src="images/rtnts.png" alt="Your Company" class="company-logo">
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Content -->
                        <tr>
                            <td class="content">
                                <h1 style="color: #1a73e8; margin-top: 0;">Certificate Expiry Notification</h1>
                                
                                <div class="alert-box">
                                    <div class="alert-title">⚠️ Important Security Notice</div>
                                    <div>Your certificate is about to expire. Please take action to renew it to avoid service disruption.</div>
                                </div>
                                
                                <p>Dear ,' . $supnameq . '</p>
                                
                                <p>This is a notification regarding your digital certificate for  which will expire soon.</p>
                                
                                <div class="certificate-info">
                                     <div class="info-row">
                                        <div class="info-label">Product Name:</div>
                                        <div class="info-value">' . $prodname . '</div>
                                    </div>
                                    <div class="info-row">
                                        <div class="info-label">Certificate Type:</div>
                                        <div class="info-value">' . $rowty . '</div>
                                    </div>
                                    <div class="info-row">
                                        <div class="info-label">Certificate Date:</div>
                                        <div class="info-value">' . $cdate . '</div>
                                    </div>
                                    <div class="info-row">
                                        <div class="info-label">Expiry Date:</div>
                                        <div class="info-value">' . $edate . '</div>
                                    </div>
                                   
                                   
                                </div>
                                
                               
                                
                               
                                
                                <p>Best regards,<br>
                                <strong>Technical Support Team</strong></p>
                                
                                
                            </td>
                        </tr>
                        
                        <!-- Footer -->
                        <tr>
                            <td class="footer">
                                <p>&copy; <?php echo date("Y"); ?> RTNTS . All rights reserved.</p>
                               
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </center>
</body>
</html>
';

                $mail->SetFrom("techsupport@rtnts.co.uk", "RTNTS");
                $mail->AddReplyTo("techsupport@rtnts.co.uk", "RTNTS");
                $pemail = 'RITZ2@rtnts.co.uk';
                $nme = 'RITZ2';

                $mail->AddAddress("$pemail", $nme);


                $mail->MsgHTML($body);


                if (!$mail->Send()) {
                    echo "Mailer Error: " . $mail->ErrorInfo;
                } else {
                    $esdate = date('d-m-Y');
                    $uraw = mysqli_query($con, "UPDATE `tblhalal` SET `mail`='Done' WHERE  `id` = '$rowid' ");
                    $emsent = mysqli_query($con, "INSERT INTO `tblhalalem`(`supid`, `product`, `cdate`, `hpid`) VALUES ('$spname','  $prodname','$esdate','$rowid')");
                }
            }
        }
        ?>