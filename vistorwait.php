<script>
  setTimeout(function() {
    location.reload();
  }, 5000); // 5000 ms = 5 seconds
</script>


<?php
include "connection.php";

$visit = $_GET['visit'];

$vquery = mysqli_query($con, "SELECT * FROM `visit` WHERE visitcode='$visit'");
$vdata = mysqli_fetch_array($vquery);

$vname = $vdata['name'];
$vorg = $vdata['org'];
$vreason = $vdata['reason'];
$vehicle = $vdata['register'];
$vstatus = $vdata['status'];

$vdate = date('D, M,d Y', strtotime($vdata['date']));
$vtime = date('h:i A', strtotime($vdata['time']));

$apvd = date('D, M,d Y h:i A', strtotime($vdata['apvtime']));


?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Host Approval | Waiting & Approved Status</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #eef2fa 0%, #e3e9f2 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1.5rem;
    }

    /* main card */
    .approval-card {
      max-width: 760px;
      width: 100%;
      background: #ffffff;
      border-radius: 2rem;
      box-shadow: 0 20px 40px -12px rgba(37, 99, 235, 0.2), 0 4px 12px rgba(0, 0, 0, 0.05);
      overflow: hidden;
    }

    /* header section - blue theme */
    .approval-header {
      background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
      padding: 2rem 2rem;
      text-align: center;
      color: white;
    }

    .approval-header h1 {
      font-weight: 700;
      font-size: 1.9rem;
      margin-bottom: 0.5rem;
      letter-spacing: -0.3px;
    }

    .approval-header p {
      opacity: 0.92;
      font-size: 0.95rem;
      margin-bottom: 0;
    }

    /* body content */
    .approval-body {
      padding: 2rem 2rem 2rem 2rem;
    }

    /* ========== WAITING STATUS STYLES ========== */
    /* animated pulse icon - blue theme */
    .pulse-wrapper {
      text-align: center;
      margin-bottom: 1.5rem;
    }

    .icon-circle {
      width: 88px;
      height: 88px;
      background: #eff4ff;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 8px 20px rgba(37, 99, 235, 0.2);
      animation: softPulse 2s infinite ease-in-out;
    }

    .icon-circle i {
      font-size: 3rem;
      color: #2563eb;
    }

    @keyframes softPulse {
      0% {
        transform: scale(1);
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.15);
      }

      50% {
        transform: scale(1.05);
        box-shadow: 0 12px 28px rgba(37, 99, 235, 0.3);
      }

      100% {
        transform: scale(1);
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.15);
      }
    }

    /* status badge - waiting */
    .status-badge-waiting {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      background: #eff4ff;
      padding: 0.55rem 1.5rem;
      border-radius: 60px;
      color: #1e40af;
      font-weight: 600;
      font-size: 0.9rem;
      border: 1px solid #c7d9fe;
      margin-bottom: 1.5rem;
    }

    /* animated dots (pure CSS) */
    .waiting-dots {
      display: inline-flex;
      gap: 5px;
      align-items: center;
      margin-left: 8px;
    }

    .waiting-dots span {
      width: 7px;
      height: 7px;
      background-color: #2563eb;
      border-radius: 50%;
      display: inline-block;
      animation: dotBounce 1.2s infinite ease-in-out both;
    }

    .waiting-dots span:nth-child(1) {
      animation-delay: -0.32s;
    }

    .waiting-dots span:nth-child(2) {
      animation-delay: -0.16s;
    }

    @keyframes dotBounce {

      0%,
      80%,
      100% {
        transform: scale(0.5);
        opacity: 0.4;
      }

      40% {
        transform: scale(1);
        opacity: 1;
      }
    }

    /* ========== APPROVED STATUS STYLES ========== */
    /* success icon - no pulse, static celebration */
    .success-wrapper {
      text-align: center;
      margin-bottom: 1.5rem;
    }

    .icon-circle-success {
      width: 88px;
      height: 88px;
      background: #e8f5e9;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 8px 20px rgba(16, 185, 129, 0.2);
    }

    .icon-circle-success i {
      font-size: 3rem;
      color: #10b981;
    }

    /* status badge - approved */
    .status-badge-approved {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      background: #e8f5e9;
      padding: 0.55rem 1.5rem;
      border-radius: 60px;
      color: #2e7d32;
      font-weight: 600;
      font-size: 0.9rem;
      border: 1px solid #c8e6c9;
      margin-bottom: 1.5rem;
    }

    /* celebration confetti effect (pure CSS) */
    .confetti-bg {
      position: relative;
      overflow: hidden;
    }

    .confetti-bg::before {
      content: "🎉";
      position: absolute;
      font-size: 20px;
      top: 10%;
      left: 5%;
      animation: floatConfetti 3s ease-in-out infinite;
      opacity: 0.6;
    }

    .confetti-bg::after {
      content: "✨";
      position: absolute;
      font-size: 18px;
      bottom: 15%;
      right: 8%;
      animation: floatConfetti 2.5s ease-in-out infinite reverse;
      opacity: 0.5;
    }

    @keyframes floatConfetti {

      0%,
      100% {
        transform: translateY(0px) rotate(0deg);
      }

      50% {
        transform: translateY(-10px) rotate(10deg);
      }
    }

    /* info message - approved version */
    .info-message-approved {
      background: #e8f5e9;
      border-radius: 1.25rem;
      padding: 1.2rem 1.4rem;
      margin: 1.5rem 0;
      border-left: 4px solid #10b981;
    }

    .info-message-approved i {
      color: #10b981;
      margin-right: 10px;
      font-size: 1.1rem;
    }

    .info-message-approved strong {
      color: #2e7d32;
    }

    /* timeline steps - completed style */
    .timeline-box-approved {
      background: #f8faff;
      border-radius: 1.25rem;
      padding: 1.2rem 1.3rem;
      margin: 1.2rem 0;
      border: 1px solid #e2ebf6;
      display: flex;
      gap: 14px;
      align-items: flex-start;
    }

    .timeline-box-approved i {
      font-size: 1.3rem;
      color: #10b981;
      margin-top: 0.1rem;
    }

    .step-badge-completed {
      font-size: 0.75rem;
      padding: 0.25rem 0.9rem;
      border-radius: 30px;
      background: #10b981;
      color: white;
    }

    .step-badge-approved {
      font-size: 0.75rem;
      padding: 0.25rem 0.9rem;
      border-radius: 30px;
      background: #10b981;
      color: white;
    }

    /* booking details section - shared */
    .details-section {
      margin: 1.5rem 0;
    }

    .section-title {
      font-weight: 700;
      font-size: 1rem;
      color: #1e3a8a;
      margin-bottom: 1rem;
      display: flex;
      align-items: center;
      gap: 8px;
      border-left: 3px solid #2563eb;
      padding-left: 12px;
    }

    .section-title-approved {
      font-weight: 700;
      font-size: 1rem;
      color: #2e7d32;
      margin-bottom: 1rem;
      display: flex;
      align-items: center;
      gap: 8px;
      border-left: 3px solid #10b981;
      padding-left: 12px;
    }

    .detail-card {
      background: #ffffff;
      border-radius: 1rem;
      border: 1px solid #e6edf8;
      overflow: hidden;
    }

    .detail-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0.9rem 1.2rem;
      border-bottom: 1px solid #f0f4fa;
    }

    .detail-row:last-child {
      border-bottom: none;
    }

    .detail-label {
      font-weight: 600;
      color: #5a6e8a;
      font-size: 0.85rem;
      text-transform: uppercase;
      letter-spacing: 0.4px;
    }

    .detail-label i {
      width: 22px;
      color: #2563eb;
      margin-right: 6px;
    }

    .detail-value {
      font-weight: 500;
      color: #1f2a44;
      text-align: right;
      font-size: 0.95rem;
    }

    .amount-value {
      font-weight: 700;
      color: #2563eb;
      font-size: 1rem;
    }

    .amount-value-approved {
      font-weight: 700;
      color: #10b981;
      font-size: 1rem;
    }

    /* timeline steps */
    .timeline-steps {
      display: flex;
      flex-wrap: wrap;
      gap: 12px;
      margin-top: 10px;
    }

    .step-badge {
      font-size: 0.75rem;
      padding: 0.25rem 0.9rem;
      border-radius: 30px;
      background: #f0f4fe;
      color: #2563eb;
    }

    .step-badge.active {
      background: #2563eb;
      color: white;
    }

    .step-badge.pending {
      background: #eef2f8;
      color: #7c8ba0;
    }

    /* voucher / ticket section for approved status */
    .voucher-card {
      background: linear-gradient(135deg, #f0f9ff 0%, #e6f0fa 100%);
      border-radius: 1rem;
      padding: 1.2rem;
      margin: 1.2rem 0;
      border: 1px solid #cde1f0;
    }

    .voucher-code {
      background: white;
      padding: 0.5rem 1rem;
      border-radius: 0.75rem;
      font-family: monospace;
      font-size: 1rem;
      font-weight: 700;
      letter-spacing: 1px;
      color: #2563eb;
      display: inline-block;
    }

    /* action buttons */
    .action-buttons {
      display: flex;
      flex-wrap: wrap;
      gap: 1rem;
      justify-content: center;
      margin: 1.8rem 0 0.5rem;
    }

    .btn-outline-blue {
      background: transparent;
      border: 1.5px solid #2563eb;
      color: #2563eb;
      padding: 0.65rem 1.5rem;
      border-radius: 3rem;
      font-weight: 600;
      font-size: 0.9rem;
      transition: all 0.2s;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }

    .btn-outline-blue:hover {
      background: #eff4ff;
      border-color: #1d4ed8;
      color: #1e40af;
    }

    .btn-primary-blue {
      background: #2563eb;
      border: none;
      padding: 0.7rem 1.8rem;
      border-radius: 3rem;
      font-weight: 600;
      font-size: 0.9rem;
      transition: all 0.2s;
      color: white;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }

    .btn-primary-blue:hover {
      background: #1d4ed8;
      transform: translateY(-1px);
      box-shadow: 0 6px 14px rgba(37, 99, 235, 0.3);
    }

    .btn-success-approved {
      background: #10b981;
      border: none;
      padding: 0.7rem 1.8rem;
      border-radius: 3rem;
      font-weight: 600;
      font-size: 0.9rem;
      color: white;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }

    .btn-success-approved:hover {
      background: #059669;
      transform: translateY(-1px);
    }

    .btn-outline-success {
      background: transparent;
      border: 1.5px solid #10b981;
      color: #10b981;
      padding: 0.65rem 1.5rem;
      border-radius: 3rem;
      font-weight: 600;
      font-size: 0.9rem;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }

    .btn-outline-success:hover {
      background: #e8f5e9;
      border-color: #059669;
    }

    /* footer */
    .footer-note {
      font-size: 0.7rem;
      text-align: center;
      border-top: 1px solid #e6edf8;
      padding-top: 1.3rem;
      margin-top: 1.5rem;
      color: #6f7d98;
    }

    .footer-note i {
      margin-right: 4px;
    }

    /* help note */
    .help-note {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: #fff9e6;
      padding: 0.4rem 1rem;
      border-radius: 40px;
      font-size: 0.7rem;
      color: #b45f06;
      margin-top: 0.8rem;
    }

    /* section divider */
    .status-divider {
      text-align: center;
      margin: 2rem 0 1.5rem;
      position: relative;
    }

    .status-divider:before {
      content: '';
      position: absolute;
      top: 50%;
      left: 0;
      right: 0;
      height: 1px;
      background: linear-gradient(90deg, transparent, #cbd5e1, transparent);
    }

    .status-divider span {
      background: white;
      padding: 0 1rem;
      position: relative;
      color: #64748b;
      font-size: 0.8rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    @media (max-width: 550px) {
      .approval-body {
        padding: 1.5rem;
      }

      .approval-header h1 {
        font-size: 1.5rem;
      }

      .detail-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 6px;
      }

      .detail-value {
        text-align: left;
      }

      .action-buttons {
        gap: 0.8rem;
      }
    }
  </style>
</head>

<body>

  <div class="approval-card">
    <!-- Header with blue gradient -->
    <div class="approval-header">
      <h1><i class="fas fa-calendar-check me-2"></i>Host Approval </h1>

    </div>

    <div class="approval-body">
      <!-- ==================== SECTION 1: WAITING FOR APPROVAL ==================== -->
      <!-- This section shows the waiting/pending state -->

      <?php
      if ($vstatus != 'Yes') {
      ?>


        <div class="status-section">
          <div class="pulse-wrapper">
            <div class="icon-circle">
              <i class="fas fa-hourglass-half"></i>
            </div>
          </div>

          <div class="text-center">
            <div class="status-badge-waiting">
              <i class="fas fa-clock"></i> Waiting for host approval
              <div class="waiting-dots">
                <span></span><span></span><span></span>
              </div>
            </div>
          </div>

          <!-- Info message for waiting -->
          <div class="info-message">
            <i class="fas fa-envelope-open-text"></i>
            <strong>Host has been notified</strong><br>
            The host is reviewing your request and will get back to you shortly.
          </div>

          <!-- Booking details section -->
          <div class="details-section">
            <div class="section-title">
              <i class="fas fa-receipt"></i> Booking Summary
            </div>
            <div class="detail-card">
              <div class="detail-row">
                <span class="detail-label"><i class="fas fa-user"></i> Name</span>
                <span class="detail-value"><?= $vname ?></span>
              </div>
              <div class="detail-row">
                <span class="detail-label"><i class="fas fa-building"></i> Organisation</span>
                <span class="detail-value"><?= $vorg ?></span>
              </div>
              <div class="detail-row">
                <span class="detail-label"><i class="far fa-calendar-alt"></i> Date & Time</span>
                <span class="detail-value"><?= $vdate ?> · <?= $vtime ?></span>
              </div>
              <div class="detail-row">
                <span class="detail-label"><i class="fas fa-map-marker-alt"></i> Vehicle Registration</span>
                <span class="detail-value"><?= $vehicle ?></span>
              </div>
              <div class="detail-row">
                <span class="detail-label"><i class="fas fa-clock"></i> Ticket Id</span>
                <span class="detail-value"><?= $visit ?></span>
              </div>
              <div class="detail-row">
                <span class="detail-label"><i class="fas fa-hashtag"></i> Reason for visit</span>
                <span class="detail-value">#<?= $vreason ?></span>
              </div>

            </div>
          </div>



          <!-- Action buttons for waiting state -->
          <div class="action-buttons">
            <a href="#" class="btn-outline-blue">
              <i class="fas fa-sync-alt me-2"></i>Refresh Status
            </a>

          </div>
        </div>





      <?php
      } else {
      ?>






        <!-- ==================== SECTION 2: APPROVED STATUS ==================== -->
        <!-- This section shows the approved/confirmed state after host approval -->
        <div class="status-section confetti-bg " style="margin-top: 40px;">
          <div class="success-wrapper">
            <div class="icon-circle-success">
              <i class="fas fa-check-circle"></i>
            </div>
          </div>

          <div class="text-center">
            <div class="status-badge-approved">
              <i class="fas fa-check-double"></i> Request Approved & Confirmed
              <i class="fas fa-grin-beam ms-1"></i>
            </div>
          </div>

          <!-- Success message for approved -->
          <div class="info-message-approved">
            <i class="fas fa-tada"></i>
            <strong>Congratulations! Your visiting request has been successfully confirmed.</strong><br>
            The host has approved your request. you'll receive all the details below. Get ready for an amazing experience!
          </div>

          <!-- Booking details section (approved) -->
          <div class="details-section">
            <div class="section-title-approved">
              <i class="fas fa-check-circle"></i> Confirmed Visit Details
            </div>
            <div class="detail-card">
              <div class="detail-row">
                <span class="detail-label"><i class="fas fa-user"></i> Name</span>
                <span class="detail-value"><?= $vname ?></span>
              </div>
              <div class="detail-row">
                <span class="detail-label"><i class="fas fa-building"></i> Organisation</span>
                <span class="detail-value"><?= $vorg ?></span>
              </div>
              <div class="detail-row">
                <span class="detail-label"><i class="far fa-calendar-alt"></i> Date & Time</span>
                <span class="detail-value"><?= $apvd ?></span>
              </div>
              <div class="detail-row">
                <span class="detail-label"><i class="fas fa-map-marker-alt"></i> Vehicle Registration</span>
                <span class="detail-value"><?= $vehicle ?></span>
              </div>
              <div class="detail-row">
                <span class="detail-label"><i class="fas fa-hashtag"></i> Ticket ID</span>
                <span class="detail-value">#<?= $visit ?></span>
              </div>
              <div class="detail-row">
                <span class="detail-label"><i class="fas fa-clock"></i> Reason for visit</span>
                <span class="detail-value"><?= $vreason ?></span>
              </div>


            </div>
          </div>










        </div>

      <?php
      }
      ?>

    </div>
  </div>

  <!-- Bootstrap CSS only - no JavaScript included for pure design -->
</body>

</html>