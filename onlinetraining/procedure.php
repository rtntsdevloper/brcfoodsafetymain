	<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Home</a></li>
                        <li>Procedure Training</li>
						
                    </ul>
				
                </div>
		
                         
				 <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
							  
								<div class="row">
				<?php
	 $cmpchk=array();
     $i=0;
$sql=mysqli_query($con,"select * from tblproceduretraining1 where uid='$staffid'");
while($r=mysqli_fetch_array($sql))
{

$jk=mysqli_query($con,"select * from tblprocedure where id='$r[procedure1]'");
$jk1=mysqli_fetch_array($jk);

?>	 <div class="col-8"><?php echo $jk1['name'];?></div>
   
		  
      <div class="col-2">
	 <a href="admin.php?id=procedure1&sno=<?php echo $jk1['id'];?>&sno1=<?php echo $r['id'];?>">
	 <button  class="btn btn-danger" value="<?php echo $r['modid'];?>" style="width:130px; margin:10px">
	 <?php echo $r['status'];?>&raquo;</button>
	 </a>	   
	 </div>
		  <?php
      $i++;
         }
        ?>
					 
</div>
                            </div>
                        </div>
                    </div>
                </div>


