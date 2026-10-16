<div class="main-content">
 <div class="breadcrumb">
 <h1 class="mr-2"><?php echo $headingname;?></h1>
  <ul>
          <li><a href="">Dashboard</a></li>
           <li>Home</li>
       </ul>
   </div>
				
      <div class="separator-breadcrumb border-top"></div>
      <div class="row">
                    <!-- ICON BG-->
				<?php
				if($access=="Auditor")
				{
				?>
					
<div class="col-lg-3 col-md-6 col-sm-6">
<a href="admin.php?id=auditdetail"><div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
<div class="card-body text-center"><i class="fa fa-bar-chart" style="font-size:54px; color:#E81766"></i>
<div class="content">
    <p class="text-muted mt-2 mb-0">BRC</p>
    <p class="text-primary text-22 line-height-1 mb-2">Audit</p>
    </div>
    </div>
    </div></a>
    </div>
					
			
 <div class="col-lg-3 col-md-6 col-sm-6">
  <a href="admin.php?id=gmpauditt">
  <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
  <div class="card-body text-center "><i class="fa fa-list" style="font-size:54px; color:#10C5AA"></i>
   <div class="content">
                                    <p class="text-muted mt-2 mb-0">Other</p>
                                    <p class="text-primary text-22 line-height-1 mb-2">Audit</p>
                                </div>
                            </div>
                        </div></a>
                    </div>
					
					
					<?php
					}
					else if($access=="Admin")
					{
					?>
					 <div class="col-lg-3 col-md-6 col-sm-6">
                     <a href="admin.php?id=umgmt">   <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                                <div class="card-body text-center "><i class="fa fa-user" style="font-size:54px; color:#10C5AA"></i>
                                <div class="content">
                                    <p class="text-muted mt-2 mb-0">User</p>
                                    <p class="text-primary text-22 line-height-1 mb-2">Management</p>
                                </div>
                            </div>
                        </div></a>
                    </div>
					
					
					
					 <div class="col-lg-3 col-md-6 col-sm-6">
                     <a href="admin.php?id=allowaudit">   <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                                <div class="card-body text-center "><i class="fa fa-user" style="font-size:54px; color:#10C5AA"></i>
                                <div class="content">
                                    <p class="text-muted mt-2 mb-0">Allow</p>
                                    <p class="text-primary text-22 line-height-1 mb-2">Audit</p>
                                </div>
                            </div>
                        </div></a>
                    </div>
					
					
					
				
				<div class="col-lg-3 col-md-6 col-sm-6">
                     <a href="admin.php?id=auditreport">   <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                                <div class="card-body text-center "><i class="fa fa-list" style="font-size:54px; color:#10C5AA"></i>
                                <div class="content">
                                    <p class="text-muted mt-2 mb-0">Audit</p>
                                    <p class="text-primary text-22 line-height-1 mb-2">Report</p>
                                </div>
                            </div>
                        </div></a>
                    </div>
					
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <a href="admin.php?id=auditdetail">  <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                            <div class="card-body text-center"><i class="fa fa-sticky-note" style="font-size:54px; color:#3399CC"></i>
                                <div class="content">
                                    <p class="text-muted mt-2 mb-0">Audit</p>
                                    <p class="text-primary text-22 line-height-1 mb-2">Management</p>
                                </div>
                            </div>
                        </div></a>
                    </div>
					
                    <div class="col-lg-3 col-md-6 col-sm-6">
                          <a href="admin.php?id=auditprogress&sno=1"><div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                            <div class="card-body text-center"><i class="fa fa-bar-chart" style="font-size:54px; color:#E81766"></i>
                                <div class="content">
                                    <p class="text-muted mt-2 mb-0">Audit</p>
                                    <p class="text-primary text-22 line-height-1 mb-2">Status</p>
                                </div>
                            </div>
                        </div></a>
                    </div>
					
					<div class="col-lg-3 col-md-6 col-sm-6">
                          <a href="admin.php?id=auditor"><div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                            <div class="card-body text-center"><i class="fa fa-users" style="font-size:54px; color:#CC9900"></i>
                                <div class="content">
                                    <p class="text-muted mt-2 mb-0">Auditor</p>
                                    <p class="text-primary text-22 line-height-1 mb-2">Management</p>
                                </div>
                            </div>
                        </div></a>
                    </div>
					
					
					<div class="col-lg-3 col-md-6 col-sm-6">
                          <a href="admin.php?id=auditorassign"><div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                            <div class="card-body text-center"><i class="fa fa-bars" style="font-size:54px; color:#669966"></i>
                                <div class="content">
                                    <p class="text-muted mt-2 mb-0">Auditor</p>
                                    <p class="text-primary text-22 line-height-1 mb-2">Assignment</p>
                                </div>
                            </div>
                        </div></a>
                    </div>
					
					<div class="col-lg-3 col-md-6 col-sm-6">
                          <a href="admin.php?id=auditeemgmt"><div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                            <div class="card-body text-center"><i class="fa fa-user" style="font-size:54px; color:#EACF15"></i>
                                <div class="content">
                                    <p class="text-muted mt-2 mb-0">Auditee</p>
                                    <p class="text-primary text-22 line-height-1 mb-2">Management</p>
                                </div>
                            </div>
                        </div></a>
                    </div>
				
				
				
					
					<div class="col-lg-3 col-md-6 col-sm-6">
                     <a href="admin.php?id=addaudit">   
					 <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                                <div class="card-body text-center "><i class="fa fa-list" style="font-size:54px; color:#10C5AA"></i>
                                <div class="content">
                                    <p class="text-muted mt-2 mb-0">Add</p>
                                    <p class="text-primary text-22 line-height-1 mb-2">Audit</p>
                                </div>
                            </div>
                        </div></a>
                    </div>
					
					<div class="col-lg-3 col-md-6 col-sm-6">
                     <a href="admin.php?id=ques">   <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                                <div class="card-body text-center "><i class="fa fa-list" style="font-size:54px; color:#10C5AA"></i>
                                <div class="content">
                                    <p class="text-muted mt-2 mb-0">Questionnaire </p>
                                    <p class="text-primary text-22 line-height-1 mb-2">Report</p>
                                </div>
                            </div>
                        </div></a>
                    </div>
					
					<?php
					 }
					else if($access=="Auditee")
					 {
					?>
					  <div class="col-lg-3 col-md-6 col-sm-6">
                          <a href="admin.php?id=auditreport"><div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                            <div class="card-body text-center"><i class="fa fa-bar-chart" style="font-size:54px; color:#E81766"></i>
                                <div class="content">
                                    <p class="text-muted mt-2 mb-0">BRC</p>
                                    <p class="text-primary text-22 line-height-1 mb-2">Audit</p>
                                </div>
                            </div>
                        </div></a>
                    </div>
					
					
					 <div class="col-lg-3 col-md-6 col-sm-6">
  <a href="admin.php?id=gmpauditt">
  <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
  <div class="card-body text-center "><i class="fa fa-list" style="font-size:54px; color:#10C5AA"></i>
   <div class="content">
                                    <p class="text-muted mt-2 mb-0">Other</p>
                                    <p class="text-primary text-22 line-height-1 mb-2">Audit</p>
                                </div>
                            </div>
                        </div></a>
                    </div>
					
					
					
					<?php
					}
					?>
                </div>
		<?php
		if($access=="Admin")
		{
		?>
				 <div class="row" id="audits">
				 
                    <div class="col-lg-12 col-md-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="card-title">Audits Status</div>
                                <div class="container">
  
   <?php
       include 'auditprogress1.php';
   ?>
   
    </div>
                            </div>
                        </div>
                    </div>
                   
                </div></div>
				<?php
				}
				?>