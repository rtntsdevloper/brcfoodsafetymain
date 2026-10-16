								
				<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Home</a></li>
                        <li>Food Fraud and Adulteration</li>
                    </ul>
                </div>
		<script language="javascript">
		function cal()
		{
		var d1= document.getElementById("d1").value;
		var d2= document.getElementById("d2").value;
		var s1= document.getElementById("s1").value;
	
		
		if(d1=="" && d2=="" && s1=="")
		{
		 document.getElementById("sd1").innerHTML="* Please select one option from below";
		}
		
		else
		{
		$.post("legislationdetaill",{d1: d1,d2: d2, s1: s1 }, 
		function(data) 
       { 
      $("#myTabContent").html(data);
       });
		}
		}
		</script>	
				
				<div class="row mb-12">
                    <div class="col-md-12 mb-12">
                        <div class="card text-left">
                            <div class="card-body">
	                        
								 <div class="row">
                                    
									<div class="col-12" ><label for="cc-exp" class="control-label mb-1" id="sd1" style="color:#FF0000"></label>
									</div>
								<div class="col-4" >
                                                        <label for="cc-exp" class="control-label mb-1" >Date From</label>
														 <div class="input-group">
														 
                                                        <input type="date" name="d1"  id="d1" class="form-control"  />
                                                    </div> </div>
													
													<div class="col-4" >
                                                        <label for="cc-exp" class="control-label mb-1" > Date To</label>
														 <div class="input-group">
														 
                                                        <input type="date" name="d2"  id="d2" class="form-control"  />
                                                    </div> </div>
													
													<div class="col-4">
                                                        <label for="cc-exp" class="control-label mb-1" >Select Category</label>
														 <div class="input-group">
														 
														  
                                                        <select  name="s1" id="s1"  class="form-control"  >
														<option value="">Please Select</option>
														<?php
														$sql2=mysqli_query($con,"select *  from tbllegislationcate");
											while($rows=mysqli_fetch_array($sql2))
											{
											?>
											<option value="<?php echo $rows['id'];?>"> <?php echo $rows['name'];?></option>
											
											<?php
											}
											?>
											 
														</select>
                                                    </div> </div>
													
													
													<div class="col-2" style="margin:10px">
                                                        <label for="cc-exp" class="control-label mb-1"></label>
														 <div class="input-group">
														  <button class="btn btn-info" style="float:right" onclick="return cal();"><li class="fa fa-list"></li> Select & Go</button>
													</div></div>
								
								</div></div></div></div>	</div>
								
								
								
				  <div class="row mb-12">
                    <div class="col-md-12 mb-12">
                        <div class="card text-left">
						
                            <div class="card-body">
						
							<!--1st TAB START-->
				 <div class="row mb-4">
                    <div class="col-12">
                        <div class="card text-left">
                            <div class="card-body">
							<a href="admin.php?id=knowledgehub"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							<a href="admin.php?id=addfoodfraud"><button class="btn btn-info" style="float:right; margin-left:15px">Add New</button></a>
                                <h4 class="card-title mb-3">Food Fraud and Adulteration</h4>
                              
                                 <div class="ul-widget__head-toolbar">
                                                <ul class="nav nav-tabs nav-tabs-line nav-tabs-bold ul-widget-nav-tabs-line" role="tablist">
								<?php
								$cn="";
								$sql7=mysqli_query($con,"select distinct state from tblfoodfraud order by id ASC limit 1");
								$row7=mysqli_fetch_array($sql7);
								$cn=$row7['state'];
								
								$sql1=mysqli_query($con,"select distinct state from tblfoodfraud");
								$i=0;
								while($row1=mysqli_fetch_array($sql1))
										{
								$sql5=mysqli_query($con,"select * from tblcountry where id='$row1[state]'");
								$row6=mysqli_fetch_array($sql5);
								
								
										$i++;
										
										
										if($i==1)
										{
										?>
                          <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#__g-widget-s7-<?php echo $row1['state'];?>-content" role="tab" aria-selected="true"><?php echo $row6['name'];?></a></li>
													<?php
													}
													else
													{
													?>
                          <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#__g-widget-s7-<?php echo $row1['state'];?>-content" role="tab" aria-selected="false"><?php echo $row6['name'];?></a></li>
												<?php
												}
												}
												?>
                                                </ul>
                                            </div>
											
											
                              <div class="ul-widget__body">
                              <div class="tab-content">
								<?php
								$sql4=mysqli_query($con,"select * from tblfoodfraud");
								$j=0;
								while($row4=mysqli_fetch_array($sql4))
								{
								$j++;
								if($j==1)
								{
								?>
								
								 <div class="tab-pane active show" id="__g-widget-s7-<?php echo $row4['state'];?>-content">
                                 <div class="ul-widget-s7n">
							
								<?php
								$sql2=mysqli_query($con,"select t1.*,t2.name from tblfoodfraud t1, tblalert1 t2 where t1.state='$cn' and t2.id=t1.category");
								while($row2=mysqli_fetch_array($sql2))
								{
								
								
								
								$color = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);
								?>
                                               
                                 <div class="ul-widget-s7__items mb-2">
														* <?php echo $row2['name'];?>
														<br/>
								<?php
								$sql3=mysqli_query($con,"select t1.*,t2.name from tblfoodfraud1 t1, tblalert1 t2 where t1.sno='$row2[id]' and t1.cate=t2.id ");
								while($row3=mysqli_fetch_array($sql3))
								{
								?>
								* <?php echo $row3['name'];?>
								<br/>
								<?php
								}
								?>
                                                            <div class="ul-widget-s7__item-circle">
                                                                <p class="ul-vertical-line" style="background-color:<?php echo $color;?>"></p>
                                                            </div>
                                                            <div class="ul-widget-s7__item-text">
                                                               <?php echo $row2['detail'];?>
                                                            </div>
                                                        </div>
                                                   <?php
												   }
												   ?>
												 </div>
                                                </div>
												
												<?php
												}
												else
												{
												?>
													
								<div class="tab-pane" id="__g-widget-s7-<?php echo $row4['state'];?>-content">
                                
								<div class="ul-widget-s7n">
							
								<?php
								$sql2=mysqli_query($con,"select t1.*,t2.name from tblfoodfraud t1, tblalert1 t2 where t1.state='$row4[state]' and t2.id=t1.category");
								while($row2=mysqli_fetch_array($sql2))
								{
								$color ="#". str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, 0, STR_PAD_LEFT);
								
								?>
								
                               <div class="ul-widget-s7__items mb-4">
								* <?php echo $row2['name'];?><br/>
								<?php
								$sql3=mysqli_query($con,"select t1.*,t2.name from tblfoodfraud1 t1, tblalert1 t2 where t1.sno='$row2[id]' and t1.cate=t2.id ");
								while($row3=mysqli_fetch_array($sql3))
								{
								?>
								* <?php echo $row3['name'];?><br/>
								<?php
								}
								?>
                               <div class="ul-widget-s7__item-circle">
                                 <p class="ul-vertical-line" style="background-color:<?php echo $color;?>"></p>
                                 </div>
                               <div class="ul-widget-s7__item-text">
                               <?php echo $row2['detail'];?>
                               </div>
                             </div>
                                                   <?php
												   }
												   ?>
												 </div>
                                                </div>
												<?php
												}
												}
												?>
												
												  </div>
												  </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					<!--1st TAB END-->
					

						</div>
						
						</div></div></div></div>
					
  