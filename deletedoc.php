<?php
include 'connection.php';
$sno=$_GET['sno'];
$rid=$_GET['rid'];

 $imgname=$_GET['key1'].";";
$sqll=mysqli_query($con,"select * from saveaudit where id='$sno' and sno='$rid'");
 $fg=mysqli_fetch_array( $sqll);
 $imgn=$fg['document'];
 
  $strr=str_replace($imgname,"",$imgn);
 
 
 $ui=mysqli_query($con,"update saveaudit set document='$strr' where id='$sno' and sno='$rid'");
 

?>
                                 
								 
								  <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
									 <thead>
                                            <th>Id</th>
                                          
                                            <th>Document</th>
											 <th>Delete</th>
                                            
                                        </thead>
                                        <tbody>
										
										

										<?php
					$query=mysqli_query($con,"select * from saveaudit where id='$sno' and sno='$rid' ");
					
							$rows=mysqli_fetch_array($query)
							
                                   ?>  
								   <?php
					$string = $rows['document'];
$tags1 = explode(';' , $string);
$i=0;
foreach($tags1 as $key1)
  {
  $i++;
   $info5= new SplFileInfo($key1);
  $tpe5=$info5->getExtension();
  if($tpe5!="")
  {
  ?>       
								   <tr>
                                    <td><?php echo $i;?></td>
                                               
                    <td>

					<a href="documents/<?php echo $key1;?>" target="_blank" style="color:#0066FF"> 
					
					<?php echo $key1;?></a>
					
					 </td>
					
					
					<td><a href="#" onclick="return bnm(<?php echo $rows['id'];?>,'<?php echo $key1;?>');"><i class="fa fa-trash" ></i></a></td>
                                 
                                            </tr>
                                            <?php
					}
					}
					?>             
											
                                        </tbody></table>