<script language="javascript">
function cal(str,str1)
{
 
 if (window.XMLHttpRequest)
  {
  xmlhttp=new XMLHttpRequest();
  }
else
  {
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("des").innerHTML=xmlhttp.responseText;

    }
  }
xmlhttp.open("GET","addproceduredetail1.php?sno="+str+"&sno1="+str1,true);
xmlhttp.send();
 
}
</script><div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Procedure Trainings</a></li>
                        <li>View Detail</li>
                    </ul>
                </div>
				
												
												
				
			       <div class="row mb-12">
                    <div class="col-md-12 mb-12">
                        <div class="card text-left">
                            <div class="card-body">
							
						<a href="admin.php?id=proceduredetail&sno=<?php echo $_GET['sno'];?>"><button class="btn btn-info" style="float:right">Go Back</button></a>
							
							
                             <h4 class="card-title mb-3">View Detail</h4>
								
                           
								 <div class="row" id="des">
                                    
								  <div class="table-responsive">
                                     <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                 
                      <thead>
				        <tr>
				        <th></th>
					    <th></th>
                        <th>First Name </th>
                        <th>Last Name</th>
                        <th>User Name</th>
                        <th>Password</th>
						<th>Add</th>
                         </tr>
					</thead>
					<tbody>
		 <?php
		$sno1=$_GET['sno'];
		 
	                  $sql=mysqli_query($con,"select * from tblprocedurestaff where pid='$sno1'");
							$i=0;
						    while($row=mysqli_fetch_array($sql))
						     {
							
							  $gh2=mysqli_query($con,"select * from tblstaff where id='$row[uid]'");
							 $gh3=mysqli_fetch_array($gh2);
							  $i++;
							?>
                      
				
					  <tr>
					  <td><?php echo $i;?></td>
					  <td></td>
					   <td><?php echo $gh3['fname']; ?></td>
                       <td><?php echo $gh3['lname']; ?></td>
                       <td><?php echo $gh3['uname']; ?></td>
					   
                       <td><?php echo $gh3['pwd']; ?></td>
					    <td><a href="admin.php?id=addstaffprocedure1&sno=<?php echo $gh3['id'];?>&sno1=<?php echo $sno1;?>"><button class="btn btn-success" >Add Procedure</button></a></td>
						</tr>
					
                    
					<?php
					}
					?>
				
				 </tbody>
                                    </table>
									</div>
									</div>
									
									
									
							</div></div></div></div></div>