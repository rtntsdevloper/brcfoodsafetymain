	  
	   <?php
       include 'connection.php';
	    $d1=$_POST['d1'];
	   $s1=$_POST['s1'];
	    $p1=$_POST['p1'];
	  
	  ?>     
	  
	  
	  <?php
	  if($d1!="" && $s1=="" && $p1!="")     
	  {
	  ?>             
	  
	      
	  <table id="bootstrap-data-table" class="table table-striped table-bordered">
	   <thead>
                                         <tr>
										     <th></th>
										     <th>Date</th>
                                          
											<th>Product</th>
											<th>Boxes</th>
											<th>Qty</th>
											 <th>GRN No</th>
											 <th>Detail</th>
                                        </tr>
      </thead>
                                    <tbody>
									<?php
								
		$sql2=mysqli_query($con,"select t1.pname, t1.uom, t2.*, t3.*, SUM(t3.box) AS c1,SUM(t3.qty) AS s1, t4.grnno,t4.po,t4.date AS dt,t4.id AS tid,t4.user from tblrawmaterial t1, tblrawsupplier t2, tblgrn t3 , tblgrnno t4 where t1.id=t3.product and t2.supid=t3.supplier and t3.grncode=t4.grnno and t3.cdate='$d1' and t3.product='$p1' group by t3.product ");
									$i=0;
									while($row2=mysqli_fetch_array($sql2))
									{
									$i++;
									?>
                                        <tr>
										<td><?php echo $i;?></td>
										 <td><?php echo date('d-m-Y', strtotime($row2['dt']));?></td>
										
										    
											  <td>	<?php echo $row2['pname'];	?> </td>
											   <td>	<?php echo $row2['c1'];	?> </td>
											   <td>	<?php echo $row2['s1'];	?> </td>
                                                <td><?php echo $row2['grnno'];?></td>
											
											
											<td> <a href="admin.php?id=goodsindetail&sno=<?php echo $row2['tid'];?>"> <button type="button" class="btn btn-info btn-sm">View </button></a></td>
											
                                          </tr>
										    <?php
										     }
										?>
										</tbody>
										
										</table>
										<?php
										}
										?>
										
										
										
										
										
										 <?php
	   if($d1!="" && $s1!="" && $p1=="")     
	  {
	  ?>             
	  
	      
	  <table id="bootstrap-data-table" class="table table-striped table-bordered">
	  <thead>
                                         <tr>
										     <th></th>
										     <th>Date</th>
                                           
											<th>Product</th>
											<th>Boxes</th>
											<th>Qty</th>
											 <th>GRN No</th>
											 <th>Detail</th>
                                        </tr>
      </thead>
                                    <tbody>
									<?php
								
		$sql2=mysqli_query($con,"select t1.pname, t1.uom, t2.*, t3.*, SUM(t3.box) AS c1,SUM(t3.qty) AS s1, t4.grnno,t4.po,t4.date AS dt,t4.id AS tid,t4.user from tblrawmaterial t1, tblrawsupplier t2, tblgrn t3 , tblgrnno t4 where t1.id=t3.product and t2.supid=t3.supplier and t3.grncode=t4.grnno and t4.cdate='$d1' and t4.supid='$s1' group by t3.product ");
									$i=0;
									while($row2=mysqli_fetch_array($sql2))
									{
									$i++;
									?>
                                        <tr>
										<td><?php echo $i;?></td>
										 <td><?php echo date('d-m-Y', strtotime($row2['dt']));?></td>
										
										   
											  <td>	<?php echo $row2['pname'];	?> </td>
											   <td>	<?php echo $row2['c1'];	?> </td>
											   <td>	<?php echo $row2['s1'];	?> </td>
                                                <td><?php echo $row2['grnno'];?></td>
											
											
											<td> <a href="admin.php?id=goodsindetail&sno=<?php echo $row2['tid'];?>"> <button type="button" class="btn btn-info btn-sm">View </button></a></td>
											
                                          </tr>
										    <?php
										     }
										?>
										</tbody>
										</table>
										<?php
										}
										?>
										
										
										
										
										
										 <?php
	   if($d1!="" && $s1!="" && $p1!="")     
	  {
	  ?>             
	  
	       
	  <table id="bootstrap-data-table" class="table table-striped table-bordered">
	  <thead>
                                         <tr>
										     <th></th>
										     <th>Date</th>
                                           
											<th>Product</th>
											<th>Boxes</th>
											<th>Qty</th>
											 <th>GRN No</th>
											 <th>Detail</th>
                                        </tr>
      </thead>
                                    <tbody>
									<?php
								
		$sql2=mysqli_query($con,"select t1.pname, t1.uom, t2.*, t3.*, SUM(t3.box) AS c1,SUM(t3.qty) AS s1, t4.grnno,t4.po,t4.date AS dt,t4.id AS tid,t4.user from tblrawmaterial t1, tblrawsupplier t2, tblgrn t3 , tblgrnno t4 where t1.id=t3.product and t2.supid=t3.supplier and t3.grncode=t4.grnno and t3.cdate='$d1' and t3.product='$p1'and t4.supid='$s1'  group by t3.product ");
									$i=0;
									while($row2=mysqli_fetch_array($sql2))
									{
									$i++;
									?>
                                        <tr>
										<td><?php echo $i;?></td>
										 <td><?php echo date('d-m-Y', strtotime($row2['dt']));?></td>
										
										  
											  <td>	<?php echo $row2['pname'];	?> </td>
											   <td>	<?php echo $row2['c1'];	?> </td>
											   <td>	<?php echo $row2['s1'];	?> </td>
                                                <td><?php echo $row2['grnno'];?></td>
											
											
											<td> <a href="admin.php?id=goodsindetail&sno=<?php echo $row2['tid'];?>"> <button type="button" class="btn btn-info btn-sm">View </button></a></td>
											
                                          </tr>
										    <?php
										     }
										?>
										</tbody>
										</table>
										<?php
										}
										?>
										
										