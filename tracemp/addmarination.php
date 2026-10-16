
<?php
					$sql5=mysqli_query($con,"select * from tblgrn1 where leftqty=''");
					while($row5=mysqli_fetch_array($sql5))
					{
					$rt=mysqli_query($con,"update tblgrn1 set leftqty='$row5[qty]' where id='$row5[id]'");
					}
					?>
					
					
					
  <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Dashboard</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="admin.php?id=1"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Home / Daily Potato Usage </a></li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
		
		<div  class="col-xl-12" style="margin-bottom:20px">
		
		<a href="admin.php?id=potatousage"><button type="submit" class="btn  btn-danger" style="float:right;">Go Back</button></a>
		</div>
		
 <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Product List</h5>
                       
                    </div>
					
					<div class="card-body">
						
						
	
	
						<div class="row">

						
				 <?php
					$sql=mysqli_query($con,"SELECT * FROM `tblrawmaterial` WHERE pname LIKE '%potato%' order by pname asc");
					while($row=mysqli_fetch_array($sql))
					{
					?>
							
							<div class="col-sm-4">
				<a href="admin.php?id=addpusage1&sno=<?php echo $row['id'];?>"><div class="card">
					<div class="card-header">
						<h5><?php echo $row['pname'];?></h5>
					</div>
					<div class="card-body">
						<div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
							<div class="carousel-inner">
								<div class="carousel-item active">
									<img class="img-fluid d-block w-100" src="../productimg/" >
								</div>
								
							</div>
						</div>
					</div>
				</div></a>
			</div>
			<?php
		}
	?>
			
			
			
			
					</div>
                  
					</div>
                </div>
