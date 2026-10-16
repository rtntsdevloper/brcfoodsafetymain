<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>fscsurvey Management System</title>
    <link rel="stylesheet" href="fscsurvey/assets/style.css">
    <style>
      /* All CSS styles from your code */
      :root {
        --navy: #1B3A7B;
        --silver: #C8CDD5;
        --slate: #F1F4F8;
        --dark: #1A1A2E;
        --muted: #6B7A99;
        --white: #fff;
        --red: #B3261E;
        --amber: #B45309;
        --green: #1E7B34;
      }

      * {
        box-sizing: border-box;
        margin: 0;
        padding: 0
      }

      body {
        font-family: "Century Gothic", CenturyGothic, "Avenir Next", Avenir, AppleGothic, sans-serif;
        background: var(--slate);
        color: var(--dark);
        font-size: 14px
      }

      header {
        background: var(--navy);
        color: #fff;
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 10px 22px
      }

      header img {
        height: 44px;
        background: #fff;
        border-radius: 6px;
        padding: 3px
      }

      header .t {
        font-size: 17px;
        font-weight: bold;
        letter-spacing: .5px
      }

      header .u {
        margin-left: auto;
        font-size: 12px;
        color: var(--silver)
      }

      header .u a {
        color: #fff;
        text-decoration: underline
      }

      nav {
        background: #162F68;
        padding: 0 14px;
        display: flex;
        flex-wrap: wrap
      }

      nav a {
        color: var(--silver);
        text-decoration: none;
        padding: 10px 13px;
        font-size: 13px
      }

      nav a:hover {
        background: var(--navy);
        color: #fff
      }

      nav a.on {
        background: var(--slate);
        color: var(--navy);
        font-weight: bold;
        border-radius: 6px 6px 0 0
      }

      main {
        width: 100%;
        padding: 20px 22px;
        margin: 0 auto
      }

      h1 {
        color: var(--navy);
        font-size: 21px;
        margin-bottom: 4px
      }

      .sub {
        color: var(--muted);
        font-size: 12px;
        margin-bottom: 16px
      }

      .cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
        gap: 12px;
        margin-bottom: 20px
      }

      .card {
        background: #fff;
        border: 1px solid var(--silver);
        border-radius: 10px;
        padding: 14px
      }

      .card .n {
        font-size: 30px;
        font-weight: bold;
        color: var(--navy)
      }

      .card .l {
        font-size: 12px;
        color: var(--muted)
      }

      .card.bad .n {
        color: var(--red)
      }

      .card.warn .n {
        color: var(--amber)
      }

      .card.ok .n {
        color: var(--green)
      }

      table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        border: 1px solid var(--silver);
        margin-bottom: 18px
      }

      th {
        background: var(--navy);
        color: #fff;
        text-align: left;
        padding: 8px 10px;
        font-size: 12px
      }

      td {
        padding: 7px 10px;
        border-top: 1px solid var(--silver);
        font-size: 13px;
        vertical-align: top
      }

      tr:nth-child(even) td {
        background: var(--slate)
      }

      .badge {
        display: inline-block;
        padding: 2px 9px;
        border-radius: 10px;
        font-size: 11px;
        font-weight: bold;
        color: #fff
      }

      .b-open {
        background: var(--amber)
      }

      .b-closed {
        background: var(--green)
      }

      .b-over {
        background: var(--red)
      }

      .b-info {
        background: var(--navy)
      }

      .b-grey {
        background: var(--muted)
      }

      form.panel,
      div.panel {
        background: #fff;
        border: 1px solid var(--silver);
        border-radius: 10px;
        padding: 16px;
        margin-bottom: 18px
      }

      .grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 10px
      }

      label {
        display: block;
        font-size: 12px;
        color: var(--muted);
        margin-bottom: 2px
      }

      input,
      select,
      textarea {
        width: 100%;
        padding: 7px;
        border: 1px solid var(--silver);
        border-radius: 6px;
        font-family: inherit;
        font-size: 13px;
        background: #fff;
        color: var(--dark)
      }

      textarea {
        min-height: 60px
      }

      button,
      .btn {
        background: var(--navy);
        color: #fff;
        border: 0;
        border-radius: 6px;
        padding: 8px 16px;
        font-family: inherit;
        font-size: 13px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        margin-top: 8px
      }

      button:hover,
      .btn:hover {
        background: #162F68
      }

      .btn-small {
        padding: 4px 10px;
        font-size: 12px;
        margin: 0
      }

      .msg {
        background: #E8F5EC;
        border: 1px solid var(--green);
        color: var(--green);
        padding: 9px 12px;
        border-radius: 8px;
        margin-bottom: 14px
      }

      .err {
        background: #FBEAEA;
        border: 1px solid var(--red);
        color: var(--red);
        padding: 9px 12px;
        border-radius: 8px;
        margin-bottom: 14px
      }

      footer {
        color: var(--muted);
        font-size: 11px;
        text-align: center;
        padding: 18px
      }

      details summary {
        cursor: pointer;
        color: var(--navy);
        font-weight: bold;
        margin-bottom: 10px
      }
    </style>
  </head>

  <body>

  <!-- Navigation -->
  <nav>
    <a href="admin.php?id=fscsurvey&id2=1" class="on">Dashboard</a>
    <!-- <a href="admin.php?id=fscsurvey&id2=2">Take Survey</a> -->
    <a href="admin.php?id=fscsurvey&id2=3">Survey Results</a>
    <a href="admin.php?id=fscsurvey&id2=4">Tasks</a>
    <a href="admin.php?id=fscsurvey&id2=5">Roadmap</a>
    <a href="admin.php?id=fscsurvey&id2=6">Manage Surveys</a>
    <!-- <a href="admin.php?id=fscsurvey&id2=7">Users</a> -->
  </nav>

  <br>
  <main>
    <?php

    if ($_GET['id2'] == '1') {
      include 'fscsurvey/dashboard.php';
    } else if ($_GET['id2'] == '2') {
      include 'fscsurvey/survey.php';
    } else if ($_GET['id2'] == '3') {
      include 'fscsurvey/results.php';
    } else if ($_GET['id2'] == '4') {
      include 'fscsurvey/tasks.php';
    } else if ($_GET['id2'] == '5') {
      include 'fscsurvey/roadmap.php';
    } else if ($_GET['id2'] == '6') {
      include 'fscsurvey/managesurvey.php';
    } else if ($_GET['id2'] == '7') {
      include 'fscsurvey/users.php';
    }


    ?>
  </main>

  <!-- Footer -->
  <footer>
    RTNTS Global — Food Safety Culture Portal · Supports BRCGS Issue 9 (Cl. 1.1.2), FSSC 22000 V6 (Req. 2.5.8), Reg (EC) 852/2004 Ch. XIa, FDA FSMA · Survey responses are anonymous </footer>

</body>

</html>