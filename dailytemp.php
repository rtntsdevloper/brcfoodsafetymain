

	            <div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Home</a></li>
                        <li>Knife, Fridge & Scale Register </li>
                    </ul>
                </div>

			
     <div class="col-md-12"></div>
	 <div class="col-md-12">
     <div class="card">
     <div class="card-body">
	
     
				
<form name="form1" action="dailytemp1" enctype="multipart/form-data" method="post">
     <div id="txtHint"></div>
 <h4 style="color:#0066CC">Knife</h4>
	  <?php
	  $cid=$_GET['cid'];
	
	  $sql=mysqli_query($con,"select * from tbltemprature where status='knife'");
	  $i=0;
	  while($row=mysqli_fetch_array( $sql))
	  {
	  ?>
		 <input type="hidden" name="cid" value="<?php echo $cid;?>"  />
		 <input type="hidden" name="ques[]" value="<?php echo $row['name'];?>"  />
		  <input type="hidden" name="name" value="knife"  />
		<div class="row">
	    <div class="col-md-12">
		<div class="form-group label-floating">
		
		</div></div>
		</div>
		
		<div class="row">
		
		 <div class="col-md-3">
		<div class="form-group label-floating">
		<?php echo $i+1;?>.  <?php echo $row['name'];?>
		<input type="text"  name="ans<?php echo $i;?>" class="form-control"  required >
		</div></div>
		
		
	    <div class="col-md-3">
		<div class="form-group label-floating">
		Are they intact? (YES/NO)
		<select  name="ans1<?php echo $i;?>" class="form-control"  required >
		<option value="">Please Select</option>
		<option value="Yes">Yes</option>
		<option value="No">No</option>
		</select>
		</div></div>
	
		
		<div class="col-md-3">
		<div class="form-group label-floating">
		Comment
		<textarea  name="cmnt<?php echo $i;?>"  class="form-control" placeholder="Comment" ></textarea>
		</div></div>
		
		</div>
		
		<?php
		$i++;
		}
	
		?>
		 <h4 style="color:#0066CC"> Scale checks and calibration</h4>
		<?php
	
	  $sql1=mysqli_query($con,"select * from tbltemprature where status='scale'");
	  $j=0;
	  while($row1=mysqli_fetch_array( $sql1))
	  {
	  ?>
	  	<input type="hidden" name="ques1[]" value="<?php echo $row1['name'];?>"  />
		  <input type="hidden" name="name1" value="scale"  />
		<div class="row">
	    <div class="col-md-12">
		<div class="form-group label-floating">
		<?php echo $j+1;?>.  <?php echo $row1['name'];?>
		</div></div>
		</div>
		
		<div class="row">
		
		 <div class="col-md-3">
		<div class="form-group label-floating">
		Calibrated weight

		<input type="text"  name="ans2<?php echo $j;?>" class="form-control"  required >
		</div></div>
		
		
	    <div class="col-md-3">
		<div class="form-group label-floating">
		Reading on the scale
		<input type="text"  name="ans3<?php echo $j;?>" class="form-control"  required >
		</div></div>
		
		
		
		
		<div class="col-md-3">
		<div class="form-group label-floating">
		Comment
		<textarea  name="cmnt1<?php echo $j;?>"  class="form-control" placeholder="Comment" ></textarea>
		</div></div>
		
		</div>
		
		<?php
		$j++;
		}
		?>
		
		
		
		 <h4 style="color:#0066CC"> Fridge</h4>
		<?php
	
	  $sql2=mysqli_query($con,"select * from tbltemprature where status='fridge'");
	  $k=0;
	  while($row2=mysqli_fetch_array( $sql2))
	  {
	  ?>
	  <input type="hidden" name="name2" value="fridge"  />
			<input type="hidden" name="ques2[]" value="<?php echo $row2['name'];?>"  />
		<div class="row">
	    <div class="col-md-12">
		<div class="form-group label-floating">
		<?php echo $k+1;?>.  <?php echo $row2['name'];?>
		</div></div>
		</div>
		
	
		<div class="row">
		
		 <div class="col-md-3">
		<div class="form-group label-floating">
		Display Temperature

		<input type="text"  name="ans4<?php echo $k;?>" class="form-control"  required >
		</div></div>
		
		
	    <div class="col-md-3">
		<div class="form-group label-floating">
			Probe Temperature
		<input type="text"  name="ans5<?php echo $k;?>" class="form-control"  required >
		</div></div>
		
		
		
		<div class="col-md-3">
		<div class="form-group label-floating">
		Comment
		<textarea  name="cmnt2<?php echo $k;?>" class="form-control" placeholder="Comment" ></textarea>
		</div></div>
		
		</div>
		
		<?php
		$k++;
		}
		?>
		<div class="row">
		
	    
    <div class="col-md-3">
		<div class="form-group label-floating">
		 <button type="submit" class="btn btn-primary pull-right" name="submit" onclick="return checkReq();" >Submit</button>
    </div></div></div>
    
</form>
							   
