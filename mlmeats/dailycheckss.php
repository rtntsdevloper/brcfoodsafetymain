<div class="main-content">
 <div class="breadcrumb">
 <h1 class="mr-2"><?php echo $headingname;?></h1>
  <ul>
          <li><a href="">Dashboard</a></li>
           <li>Home</li>
       </ul>
   </div>jii
				
      <div class="separator-breadcrumb border-top"></div><a href="admin.php?id=dailychecks"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
      <div class="row">
	  
                    <!-- ICON BG-->
				<?php
				$sql=mysqli_query($con,"select * from dailychecks");
				while($row=mysqli_fetch_array($sql))
		     	{
				?>
					 <div class="col-lg-3 col-md-6 col-sm-6">
                     <a href="admin.php?id=dailycheckks1&tid=<?php echo $row['id'];?>">   <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                                <div class="card-body text-center "><i class="fa fa-list" style="font-size:54px; color:#10C5AA"></i>
                                <div class="content">
                                    <p class="text-muted mt-2 mb-0"><?php echo $row['name'];?></p>
                                  
                                </div>
                            </div>
                        </div></a>
                    </div>
					<?php
					}
					?>
                    jii
					
                  
					</div></div>