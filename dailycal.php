
    
   
    <style>
       
        .page-header {
            margin-bottom: 1.8rem;
        }
        .page-header h1 {
            font-weight: 700;
            color: #1a2e45;
            border-left: 7px solid #0a58ca;
            padding-left: 1.3rem;
        }
        
        /* Tabs styling */
        .nav-tabs-custom {
            border-bottom: 2px solid #dee7ef;
            margin-bottom: 2rem;
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }
        .nav-tabs-custom .nav-link {
            border: none;
            background: transparent;
            font-weight: 600;
            padding: 0.9rem 1.8rem;
            color: #4a6679;
            border-radius: 40px 40px 0 0;
            margin-right: 4px;
            font-size: 1rem;
            transition: all 0.2s;
            position: relative;
        }
        .nav-tabs-custom .nav-link i {
            margin-right: 8px;
            font-size: 1rem;
        }
        .nav-tabs-custom .nav-link:hover {
            color: #0a58ca;
            background: #e9f0fa;
        }
        .nav-tabs-custom .nav-link.active {
            color: #0a58ca;
            background: white;
            box-shadow: 0 -2px 8px rgba(0,0,0,0.02), 0 4px 8px rgba(13,110,253,0.05);
            font-weight: 700;
            border-bottom: 3px solid #0a58ca;
        }
        
        /* Category card */
        .category-card {
            border: none;
            border-radius: 1.5rem;
            box-shadow: 0 16px 32px rgba(0, 0, 0, 0.04), 0 4px 12px rgba(0, 20, 40, 0.04);
            transition: box-shadow 0.2s;
            background: #ffffff;
            overflow: hidden;
        }
        .card-header-custom {
            padding: 1.5rem 1.8rem 0.8rem 1.8rem;
            background: white;
            border-bottom: 1px solid #edf2f9;
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .category-icon {
            width: 56px;
            height: 56px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
        }
        .category-title {
            font-weight: 700;
            font-size: 1.7rem;
            margin-bottom: 0;
            color: #14283a;
        }
        .category-sub {
            color: #62778b;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        /* checklist items */
        .checklist {
            padding: 0.2rem 0;
        }
        .list-group-item {
            border: none;
            border-bottom: 1px solid #f0f5fa;
            padding: 1.2rem 1.8rem;
            background: transparent;
        }
        .list-group-item:last-child {
            border-bottom: none;
        }
        .check-info {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
        }
        .check-info i {
            margin-right: 14px;
            font-size: 1.3rem;
            width: 22px;
        }
        .fa-check-circle { color: #1e8b4c; }
        .fa-times-circle { color: #cf3e3e; }
        .fa-clock { color: #e68a2e; }
        .fa-hourglass-half { color: #b06e0c; }
        
        .status-badge {
            font-size: 0.75rem;
            padding: 0.25rem 1rem;
            border-radius: 30px;
            font-weight: 600;
            margin-left: 15px;
            background: #eef2f6;
            color: #3a5670;
        }
        .status-badge.attempted {
            background: #fff3cd;
            color: #856404;
        }
        .status-badge.verified {
            background: #d4edda;
            color: #155724;
        }
        
        /* action buttons (Attempted / Verification) */
        .action-group {
            display: flex;
            gap: 12px;
            margin-top: 10px;
            margin-left: 36px;
            flex-wrap: wrap;
        }
        .btn-action {
            padding: 0.4rem 1.3rem;
            font-size: 0.8rem;
            font-weight: 600;
            border-radius: 40px;
            border: 1px solid transparent;
            transition: all 0.15s;
            background: #f1f5f9;
            color: #2e4c6b;
        }
        .btn-action i {
            margin-right: 6px;
            font-size: 0.75rem;
        }
        .btn-attempt {
            background: #fff1d6;
            border-color: #f7c97a;
            color: #8a5e00;
        }
        .btn-attempt:hover {
            background: #ffe4b1;
        }
        .btn-attempt.active {
            background: #f0a500;
            border-color: #c47f00;
            color: white;
        }
        .btn-verify {
            background: #e1f3e8;
            border-color: #9fcfb5;
            color: #1b6e4a;
        }
        .btn-verify:hover {
            background: #c2e5d4;
        }
        .btn-verify.active {
            background: #1f9a5a;
            border-color: #157347;
            color: white;
        }
        
        .card-footer-custom {
            background: #fbfdff;
            border-top: 1px solid #e6edf4;
            padding: 1rem 1.8rem 1.3rem;
        }
        .progress {
            height: 8px;
            border-radius: 20px;
            background-color: #e2eaf1;
        }
        .progress-bar {
            border-radius: 20px;
            background: #1a73e8;
        }
        .stat-summary {
            font-size: 0.9rem;
            font-weight: 500;
            color: #264b66;
        }
        
        /* tab pane transition */
        .tab-pane {
            transition: opacity 0.2s;
        }
        .fade:not(.show) {
            opacity: 0;
        }
        
        .container {
            max-width: 1300px;
        }
    </style>
</head>
<body>

<div class="container-fluid py-4 py-md-5">
    
    <!-- Header with date -->
    <div class="d-flex align-items-center justify-content-between flex-wrap page-header">
        <div>
            <h1 class="display-4 mb-1">
                <i class="fas fa-clipboard-list text-primary mr-3"></i>Daily Checks
            </h1>
            
        </div>
        <div class="mt-2">
            <span class="badge badge-light py-3 px-4 shadow-sm" style="font-size: 1.1rem; background: white; border-radius: 50px;">
                <i class="fa fa-calendar mr-2"></i>Tuesday, 14 Apr 2026
            </span>
        </div>
    </div>

    <!-- ========== NAVIGATION TABS ========== -->
    <ul class="nav nav-tabs-custom" id="categoryTabs" role="tablist">
        <?php
        $sqw = mysqli_query($con, "SELECT * FROM `dailychecks` WHERE status ='first'");
        $i=0;
        while($sqq = mysqli_fetch_array($sqw)){
            ?>
            <li class="nav-item">
                <a class="nav-link <?php if($i==0){ echo 'active'; } ?> " id="tab-safety" data-toggle="tab" href="#pane-<?= $sqq['id'] ?>" role="tab">
                <i class="fas fa-shield-alt"></i><?php echo $sqq['name']; ?>
            </a>
        </li>
        <?php
        $i++;
        }
        ?>
     
    </ul>

    <!-- ========== TAB CONTENT ========== -->
    <div class="tab-content">
        <?php
          $sqw = mysqli_query($con, "SELECT * FROM `dailychecks` WHERE status ='first'");
          $ix=0;
          foreach($sqw as $sqq){
            ?>
            <div class="tab-pane fade <?php if($ix==0){ echo 'show active'; } ?>" id="pane-<?= $sqq['id'] ?>" role="tabpanel">
            <div class="category-card">
                <div class="card-header-custom">
                    <div class="category-icon" style="background: #fdede7; color: #c44512;">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div>
                        <div class="category-sub">Category <?= $ix+1 ?></div>
                        <div class="category-title"><?= $sqq['name'] ?></div>
                    </div>
                </div>
                <div class="checklist">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item">
                            <div class="check-info">
                                <i class="fa fa-list"></i> Fire extinguisher inspection
                                <span class="status-badge verified">verified</span>
                            </div>
                            <div class="action-group">
                                <button class="btn-action btn-attempt" onclick="toggleAttempt(this)"><i class="fas fa-hourglass-half"></i>Attempted</button>
                                <button class="btn-action btn-verify active" onclick="toggleVerify(this)"><i class="fas fa-check"></i>Verification</button>
                            </div>
                        </div>
                        
                        
                    </div>
                </div>
               
            </div>
            </div>
            <?php
            $ix++;
          }
        ?>
        
    
   
    
</div>


<script>
    // Interactive toggle for Attempted / Verification (demo purpose)
    function toggleAttempt(btn) {
        const parent = btn.closest('.list-group-item');
        const verifyBtn = parent.querySelector('.btn-verify');
        const statusSpan = parent.querySelector('.status-badge');
        const icon = parent.querySelector('.check-info i');
        
        btn.classList.add('active');
        if(verifyBtn) verifyBtn.classList.remove('active');
        if(statusSpan) {
            statusSpan.textContent = 'attempted';
            statusSpan.className = 'status-badge attempted';
        }
        if(icon) {
            icon.className = 'fas fa-hourglass-half';
            icon.style.color = '#b06e0c';
        }
    }
    function toggleVerify(btn) {
        const parent = btn.closest('.list-group-item');
        const attemptBtn = parent.querySelector('.btn-attempt');
        const statusSpan = parent.querySelector('.status-badge');
        const icon = parent.querySelector('.check-info i');
        
        btn.classList.add('active');
        if(attemptBtn) attemptBtn.classList.remove('active');
        if(statusSpan) {
            statusSpan.textContent = 'verified';
            statusSpan.className = 'status-badge verified';
        }
        if(icon) {
            icon.className = 'fas fa-check-circle';
            icon.style.color = '#1e8b4c';
        }
    }
    // make functions global
    window.toggleAttempt = toggleAttempt;
    window.toggleVerify = toggleVerify;
</script>
</body>
</html>