<div class="main-content">
	<div class="breadcrumb" style="border-bottom: 1px solid #e0e0e0; padding-bottom: 20px;">
		<h1 class="mr-2"><?php echo $headingname; ?></h1>
		<ul>
			<li><a href="">Procedure Management</a></li>
			<li>View Detail</li>
		</ul>
	</div>


	<script language="javascript">
		function cal() {
			var d1 = document.getElementById("d1").value;
			var d2 = document.getElementById("d2").value;
			var s1 = document.getElementById("s1").value;


			if (d1 == "" && d2 == "") {
				document.getElementById("sd1").innerHTML = "* Please select one option from below";
			} else {
				$.post("additiondetail", {
						d1: d1,
						d2: d2,
						s1: s1
					},
					function(data) {
						$("#myTabContent").html(data);
					});
			}
		}
	</script>


	<div class="row mb-4">
		<div class="col-12">
			<div class="card text-left">

				<div class="card-body">

					<a href="admin.php?id=1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>



					<h4 class="card-title mb-3">View Details</h4>


					<div class="row " id="cardTabNav">
						<?php
						$sql1 = mysqli_query($con, "select * from tblcat ");
						while ($row1 = mysqli_fetch_array($sql1)) {
						?>
							<div class="col-lg-3 col-md-6 col-sm-6 mt-3">
								<a href="admin.php?id=viewaddmanage&catid=<?php echo $row1['id']; ?>" style="text-decoration:none;">
									<div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4" style="cursor:pointer;">
										<div class="card-body text-center "><i class="fa fa-list" style="font-size:54px; color:<?php if(isset($row1['color'])){
											echo $row1['color']; }
											else{
												echo '#5867dd'; }?>;"></i>
											
											<div class="content">
												<!-- <p class="text-muted mt-2 mb-0"><?php echo $row1['name']; ?></p> -->
												<p class="text-primary text-21 line-height-1 mb-2"><?php echo $row1['name1']; ?></p>
											</div>
										</div>
									</div>
								</a>
							</div>
						<?php }
						?>
					</div>


				</div>
			</div>
		</div>
	</div>
</div>