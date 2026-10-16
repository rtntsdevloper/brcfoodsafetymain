  <?php
 $sno=$_GET['sno'];
 $pid=$_GET['pid'];
 $sql=mysqli_query($con,"select * from tblauditsection where id='$sno'");
 $row=mysqli_fetch_array($sql);

   $queryy=mysqli_query($con,"select * from tblproduct1 where prodid='$pid'");
   $queryy1=mysqli_fetch_array($queryy);
	 
	?>
	
 <div class="container-fluid">

                     <div class="row column_title">
                        <div class="col-md-12">
                           <div class="page_title">
                              <h2><?php echo $row['name'];?>  (<?php echo $queryy1['prodname'];?>)
							   <a href="admin.php?id=ps1&pid=<?php echo $pid;?>&id2=<?php echo $_GET['id2'];?>"><button class="btn btn-info" style="float:right">Go Back</button></a>

								 
							  </h2>
                           </div>
                        </div>
        </div>
					 
                     <!-- row -->
                   <div class="card">
				   <div class="col-12"> 
				   <div class="full graph_head">
				   <?php
		            $qryy1=mysqli_num_rows($qryy);
		            ?>
		 
		 <?php
		if($qryy1>=1)
		{
		?>
		
	    <form action="<?php echo $_GET['id2'];?>/pupdateaudit" method="post" enctype="multipart/form-data" name="form1" id="form1" >
	<?php
	}
	else
	{
	?>
	<form action="<?php echo $_GET['id2'];?>/pattemptaudit1" method="post" enctype="multipart/form-data" name="form1" id="form1" >
	<?php
	}
	?>
	  <?php
	  $sno=$_GET['sno'];
	  $sql1=mysqli_query($con,"select * from tblauditsection1 where sid='$sno'");
	   $i=0;
	  while($row1=mysqli_fetch_array( $sql1))
	  {
	 
	  ?>
	  <div class="row">
	    <div class="col-md-12">
		<div class="form-group label-floating">
		<label class="control-label" id="error" style="color:#0000FF"></label>
		</div></div>
		</div>
		<?php
		
		 $sql2=mysqli_query($con,"select * from tblauditsection2 where sid='$sno' and ssid='$row1[id]'");
		 $mch=mysqli_num_rows($sql2);
		 
	     while($row2=mysqli_fetch_array( $sql2))
	     {
			
		 $df=mysqli_query($con,"select * from tblproductdetail where sid='$sno' and pid='$pid' ");
		 $df1=mysqli_fetch_array($df);
		 $snoo=$df1['id'];
		 
		 
		 $df2=mysqli_query($con,"select * from tblsaveans1 where sno='$snoo' and qid='$row2[id]'");
		 $mchh=mysqli_num_rows($df2);
		  
		 $df3=mysqli_fetch_array($df2);
		 
		 
		if($qryy1>=1 && $mchh<=0)
		{
		$sqj=mysqli_query($con,"insert into tblsaveans1 (sno,qid,ques)values('$snoo','$row2[id]','$row2[ques]')");
		}
		 
		 ?>
		
		<input type="hidden" name="pid" value="<?php echo $pid;?>"  />
		<input type="hidden" name="sid" value="<?php echo $sno;?>"  />
		<input type="hidden" name="qid[]" value="<?php echo $row2['id'];?>"  />
		<input type="hidden" name="ques[]" value="<?php echo $row2['ques'];?>"  />
		<input type="hidden" name="id2" value="<?php echo $_GET['id2'];?>"  />
		  
		<div class="row">
	    <div class="col-md-12">
		<div class="form-group label-floating">
		 <?php echo $row2['ques'];?>
		</div></div>
		</div>
		
		<div class="row">
		<?php
		$sql4=mysqli_query($con,"select * from tblauditsection3 where qid='$row2[id]' and status='text'");
		$match1=mysqli_num_rows($sql4);
		
		if($match1>=1)
		{
		?>
		<?php
		$j=0;
		while($row5=mysqli_fetch_array($sql4))
		{
		 $string = $df3['ans'];
        $tags1 = explode(';' , $string);
      
		?>
		
		<div class="col-md-3">
		<div class="form-group label-floating">
		
		<textarea name="j<?php echo $i;?>[]" class="form-control" placeholder="<?php echo $row5['ans'];?>"><?php echo $tags1[$j];?></textarea>
		</div></div>
		
		<?php
		
		$j++;
		}
		?>
		<?php
		}
		?>
		</div>
		
		<div class="row">
		<?php
		$sql6=mysqli_query($con,"select * from tblauditsection3 where qid='$row2[id]' and status='checkbox'");
		$match6=mysqli_num_rows($sql6);
		
		if($match6>=1)
		{
		?>
		<?php
		$j=0;
		while($row6=mysqli_fetch_array($sql6))
		{
		 $string6 = $df3['ans'];
        $tags6 = explode(';' , $string6);
  
		?>
		
		<div class="col-md-3">
		<div class="form-group label-floating">
		<?php echo $row6['ans'];?>
		<input type="checkbox" name="j<?php echo $i;?><?php echo $j;?>" class="form-control" value="<?php echo $row6['ans'];?>"  <?php echo ($row6['ans']==$tags6[$j]) ?  "checked" : "" ;  ?>  />
		
		</div></div>
		
		<?php
		
		$j++;
		}
		?>
		<?php
		}
		?>
		</div>
		
		
		
		
		<div class="row">
		
		<?php
		$sql3=mysqli_query($con,"select * from tblauditsection3 where qid='$row2[id]' and status=''");
		$match=mysqli_num_rows($sql3);
		if($match>=1)
		{
		?>
		<div class="col-md-3">
		<div class="form-group label-floating"> 
		<select name="r1<?php echo $i;?>" class="form-control"  >
		<?php
		if($df3['ans']=="")
		{
		?>
		<option value="">Please Select</option>
		<?php
		}
		else
		{
		?>
		<option value="<?php echo $df3['ans'];?>"><?php echo $df3['ans'];?></option>
		<?php
		}
		?>
		<?php
		while($row4=mysqli_fetch_array($sql3))
		{
		?>
		
		<option value="<?php echo $row4['ans'];?>"><?php echo $row4['ans'];?></option>
		<?php
		}
		?>
		</select>
		</div></div>
		<?php
		
		}
		?>
		
		
		<?php
		if($row2['textbox']=="yes")
		{
		?>
	    <div class="col-md-3">
		<div class="form-group label-floating">
		<input type="text" name="r1<?php echo $i;?>" class="form-control"  value="<?php echo $df3['ans'];?>" />
		</div></div>
		<?php
		}
		?>
		
		<?php
		if($row2['cmnt']=="yes")
		{
		?>
	    <div class="col-md-3">
		<div class="form-group label-floating">
		<textarea  name="cmnt<?php echo $i;?>" class="form-control" placeholder="comment"><?php echo $df3['cmnt'];?></textarea>
		</div></div>
		<?php
		}
		?>
		
		
		<?php
		if($row2['number']!="")
		{
		?>
	    <div class="col-md-3">
		<div class="form-group label-floating">
		<input type="<?php echo $row2['number'];?>" name="r1<?php echo $i;?>" class="form-control" value="<?php echo $df3['ans'];?>" />
		</div></div>
		<?php
		}
		?>
		
		<?php
		if($row2['pic']=="yes")
		{
		?>
	    <div class="col-md-3">
		<div class="form-group label-floating"> <p style="color:#3333FF">
		<a href="productdoc/<?php echo $df3['pic'];?>" target="_blank"><?php echo $df3['pic'];?></a></p>
		<input type="file" name="pic<?php echo $i;?>" class="form-control" />
		</div></div>
		<?php
		}
		?>
		
		</div>
		
		<?php
		$i++;
		}
		}
		?>
		
		
		<div class="row">
		
	    
    <div class="col-md-3">
		<div class="form-group label-floating">
		<?php
		if($mch>=1)
		{
		?>
		 <button type="submit" class="btn btn-primary pull-right" name="submit" >Submit</button>
		 <?php
		 }
		 ?>
    </div></div></div>
    
</form>


</div></div></div></div>

