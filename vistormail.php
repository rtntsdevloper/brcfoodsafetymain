	<?php
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'
        || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

    // Build only scheme + host
    $baseURL = $protocol . $_SERVER['HTTP_HOST'];

    echo $baseURL;
    echo $baseURL."/visitorcheck.php";
    die;
    require_once('PHPMailer/class.phpmailer.php');

    $mail = new PHPMailer();







    $body = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visitor Report – Site Manager Confirmation</title>
    <style type="text/css">
        /* Outlook / cross-client friendly reset */
        body {
            margin: 0;
            padding: 0;
            background-color: #eef2f5;
            font-family: "Segoe UI", Helvetica Neue, Helvetica, Arial, sans-serif;
        }
        table {
            border-collapse: collapse;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }
        td, th {
            padding: 0;
            font-size: 0; /* kill extra spacing in outlook */
        }
        .ExternalClass, .ReadMsgBody {
            width: 100%;
            background-color: #eef2f5;
        }
        a, a:link, a:visited {
            color: #1e6f9f;
            text-decoration: underline;
        }
        /* main wrapper */
        .outer-wrapper {
            width: 100%;
            background-color: #eef2f5;
            padding: 24px 0;
        }
        .email-container {
            max-width: 620px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 20px;
            border: 1px solid #dce5ec;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0,0,0,0.03);
        }
        /* header */
        .header-bg {
            background-color: #1f4e3c;
            padding: 28px 32px;
        }
        .header-title {
            color: #ffffff;
            font-size: 26px;
            font-weight: 700;
            line-height: 1.3;
            margin: 0;
            letter-spacing: -0.2px;
        }
        .header-sub {
            color: #d1e6dd;
            font-size: 15px;
            margin-top: 8px;
            line-height: 1.4;
        }
        .badge-manager {
            background-color: rgba(255,255,255,0.2);
            border-radius: 40px;
            display: inline-block;
            padding: 4px 14px;
            font-size: 12px;
            font-weight: 600;
            color: #ffffff;
            margin-top: 12px;
        }
        /* content */
        .content-padding {
            padding: 32px 32px 24px;
        }
        .greeting {
            font-size: 20px;
            font-weight: 600;
            color: #1e2f2a;
            margin-bottom: 12px;
        }
        .message-text {
            font-size: 16px;
            line-height: 1.5;
            color: #2c3e3a;
            margin-bottom: 24px;
        }
        .alert-note {
            background-color: #fef7e0;
            border-left: 4px solid #e6a017;
            padding: 14px 20px;
            border-radius: 12px;
            margin: 20px 0 24px;
            font-size: 14px;
            color: #7a6300;
        }
        /* report summary card */
        .report-card {
            background-color: #f4faf7;
            border-radius: 16px;
            padding: 20px 24px;
            margin: 20px 0 24px;
            border: 1px solid #ddebe5;
        }
        .report-id-row {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            flex-wrap: wrap;
            border-bottom: 1px dashed #cbdcd3;
            padding-bottom: 12px;
            margin-bottom: 18px;
        }
        .report-label {
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: #2f7d5c;
        }
        .report-id {
            font-size: 18px;
            font-weight: 700;
            color: #1b4e3a;
            font-family: monospace;
        }
        .visit-meta {
            font-size: 13px;
            color: #5e7a6b;
            margin-top: 6px;
        }
        /* visitor details grid */
        .info-grid {
            width: 100%;
            margin: 12px 0 8px;
        }
        .info-row {
            margin-bottom: 14px;
        }
        .info-label {
            font-size: 14px;
            font-weight: 600;
            color: #3c5a4b;
            display: inline-block;
            min-width: 130px;
        }
        .info-value {
            font-size: 16px;
            color: #1e2f2a;
            font-weight: 500;
        }
        .status-badge {
            background-color: #eef2f0;
            color: #2c6e4f;
            font-weight: 600;
            font-size: 13px;
            padding: 4px 14px;
            border-radius: 40px;
            display: inline-block;
        }
        .divider-light {
            border-top: 1px solid #e2ece6;
            margin: 24px 0 16px;
        }
        /* action buttons group */
        .button-group {
            margin: 28px 0 12px;
            text-align: center;
        }
        .btn-confirm {
            background-color: #2a7f5c;
            border-radius: 60px;
            display: inline-block;
            padding: 12px 28px;
            font-size: 16px;
            font-weight: 600;
            color: #ffffff;
            text-decoration: none;
            text-align: center;
            margin: 0 8px 12px 0;
            border: 1px solid #236a4b;
        }
        .btn-review {
            background-color: #ffffff;
            border-radius: 60px;
            display: inline-block;
            padding: 12px 28px;
            font-size: 16px;
            font-weight: 600;
            color: #2a7f5c;
            text-decoration: none;
            text-align: center;
            margin: 0 0 12px 8px;
            border: 1px solid #cbdcd3;
        }
        .btn-confirm:hover {
            background-color: #1f6346;
        }
        .btn-review:hover {
            background-color: #f4faf7;
            border-color: #2a7f5c;
        }
        /* footer */
        .footer {
            background-color: #f9fcfb;
            padding: 20px 32px;
            border-top: 1px solid #e2ece6;
            font-size: 12px;
            color: #6c8a7a;
            text-align: center;
            line-height: 1.5;
        }
        .footer a {
            color: #2a7f5c;
            text-decoration: none;
        }
        @media only screen and (max-width: 550px) {
            .content-padding {
                padding: 24px 20px 20px;
            }
            .header-bg {
                padding: 22px 24px;
            }
            .btn-confirm, .btn-review {
                display: block;
                width: 80%;
                margin: 10px auto;
            }
            .info-label {
                display: block;
                margin-bottom: 4px;
            }
            .button-group {
                text-align: center;
            }
            .report-id-row {
                flex-direction: column;
                gap: 8px;
            }
        }
        /* Outlook button fix */
        .outlook-button-fix {
            mso-padding-alt: 12px 28px;
        }
        /* mso conditionals */
        <!--[if mso]>
        <style type="text/css">
            .btn-confirm, .btn-review {
                font-family: Segoe UI, Helvetica, Arial, sans-serif !important;
            }
            .report-card {
                border: 1px solid #ddebe5 !important;
            }
        </style>
        <![endif]-->
    </style>
</head>
<body style="margin:0; padding:0; background-color:#eef2f5;">
    <div class="outer-wrapper" style="background-color:#eef2f5; width:100%;">
        <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" bgcolor="#eef2f5" role="presentation">
             <tr>
                <td align="center" style="padding: 20px 12px;">
                    <!-- MAIN EMAIL CONTAINER (max-width 620px) -->
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" style="max-width:620px; width:100%; background-color:#ffffff; border-radius:20px; border:1px solid #dce5ec;" bgcolor="#ffffff">
                        <!-- HEADER: Site Manager notice -->
                        <tr>
                            <td class="header-bg" bgcolor="#1f4e3c" style="background-color:#1f4e3c; padding:28px 32px; border-radius:20px 20px 0 0;">
                                <table width="100%" cellpadding="0" cellspacing="0" border="0" role="presentation">
                                    <tr>
                                        <td>
                                            <h1 style="color:#ffffff; font-size:26px; font-weight:700; margin:0; line-height:1.3;">🔍 Visitor Report Review</h1>
                                            <p style="color:#d1e6dd; font-size:15px; margin:8px 0 0 0; line-height:1.4;">Action required – pending confirmation</p>
                                          
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <!-- MAIN CONTENT -->
                        <tr>
                            <td class="content-padding" style="padding:32px 32px 24px;">
                                <table width="100%" cellpadding="0" cellspacing="0" border="0" role="presentation">
                                    <!-- Greeting + intro -->
                                    <tr>
                                        <td>
                                            <p class="greeting" style="font-size:20px; font-weight:600; color:#1e2f2a; margin:0 0 12px 0;">Hello, <strong style="color:#1f4e3c;">Site Management Team</strong>,</p>
                                            <p class="message-text" style="font-size:16px; line-height:1.5; color:#2c3e3a; margin:0 0 24px 0;">A new visitor report has been submitted and is awaiting your final confirmation. Please verify the visitor details, access permissions, and visit purpose. Once confirmed, the visitor will receive an official badge pass and site entry approval.</p>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td>
                                            <div class="report-card" style="background-color:#f4faf7; border-radius:16px; padding:20px 24px; margin:0 0 24px 0; border:1px solid #ddebe5;">
                                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                    <tr>
                                                        <td style="padding-bottom:12px; border-bottom:1px dashed #cbdcd3;">
                                                            <table width="100%">
                                                                <tr>
                                                                    <td style="font-size:13px; font-weight:600; text-transform:uppercase; color:#2f7d5c;">Report ID</td>
                                                                    <td style="text-align:right; font-size:18px; font-weight:700; color:#1b4e3a; font-family:monospace;">#VSR-0326-1942</td>
                                                                </tr>
                                                            </table>
                                                            <div style="font-size:13px; color:#5e7a6b; margin-top:6px;">Submitted: March 21, 2026 · 09:47 AM</div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding-top:16px;">
                                                            <h3 style="font-size:18px; font-weight:600; color:#1f4e3c; margin:0 0 14px 0;">👤 Visitor Credentials</h3>
                                                            <table class="info-grid" width="100%" cellpadding="0" cellspacing="0">
                                                                <tr><td class="info-row" style="padding-bottom:10px;"><span class="info-label" style="font-weight:600; color:#3c5a4b; min-width:130px; display:inline-block;">Full name:</span> <span class="info-value" style="color:#1e2f2a;">Marcus T. Reynolds</span></td></tr>
                                                                <tr><td class="info-row" style="padding-bottom:10px;"><span class="info-label" style="font-weight:600; color:#3c5a4b; min-width:130px; display:inline-block;">Orgnisation:</span> <span class="info-value" style="color:#1e2f2a;">marcus.reynolds@partnerfirm.com</span></td></tr>
                                                                <tr><td class="info-row" style="padding-bottom:10px;"><span class="info-label" style="font-weight:600; color:#3c5a4b; min-width:130px; display:inline-block;">Vehicle No.:</span> <span class="info-value" style="color:#1e2f2a;">+1 (206) 555-8712</span></td></tr>
                                                                <tr><td class="info-row" style="padding-bottom:10px;"><span class="info-label" style="font-weight:600; color:#3c5a4b; min-width:130px; display:inline-block;">Reason for visit:</span> <span class="info-value" style="color:#1e2f2a;">Apex Infrastructure Group</span></td></tr>
                                                            </table>
                                                            
                                                            <div class="divider-light" style="border-top:1px solid #e2ece6; margin:20px 0 6px;"></div>
                                                            <div style="margin-top: 14px;">
                                                                <span class="status-badge" style="background-color:#eef2f0; color:#2c6e4f; font-size:13px; padding:4px 14px; border-radius:40px;">⏳ Status: Pending manager confirmation</span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Additional notes for site manager -->
                                    
                                    <!-- ACTION BUTTONS: confirm or request changes (manager actions) -->
                                    <tr>
                                        <td>
                                            <div class="button-group" style="margin:28px 0 12px; text-align:center;">
                                                <!-- Confirm button -->
                                                <a href="#" class="btn-confirm" style="background-color:#2a7f5c; border-radius:60px; display:inline-block; padding:12px 28px; font-size:16px; font-weight:600; color:#ffffff; text-decoration:none; text-align:center; margin:0 8px 12px 0; border:1px solid #236a4b;"> Review & Approve Report</a>
                                               
                                                
                                            </div>
                                           
                                        </td>
                                    </tr>
                                   
                                </table>
                            </td>
                        </tr>
                      
                       
                    </table>
                    <!-- END main container -->
                    <div style="height:10px; font-size:0;">&nbsp;</div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>';
    $mail->SetFrom("techsupport@rtnts.co.uk", "Tech Support");
    $mail->AddReplyTo("techsupport@rtnts.co.uk", "Tech Support");
    $mail->AddAddress("RITZ2@rtnts.co.uk", "It Support");

    $mail->Subject = "Visitor Report Approval";
    $mail->MsgHTML($body);

    if (!$mail->Send()) {
    } else {
    }


    ?>
	<script language="javascript">
	    alert("Thanks!");
	    window.open('index.php', '_self');
	</script>