<?php 
include 'connection.php';
$title = mysqli_real_escape_string($con,$_POST['title']);
 $action =mysqli_real_escape_string($con,$_POST['action']);
 $date=$_POST['date'];
 $fid=$_POST['fid'];
 $qid=$_POST['qid'];
 $rid=$_POST['rid'];

$dd=mysqli_query($con,"select * from subtest1 where fid='$fid' ");
$rows=mysqli_fetch_array($dd);

$qry=mysqli_query($con,"select * from action where fid='$fid' and ques='$qid' and sno='$rid'");
$mtch=mysqli_num_rows($qry);
if($mtch>=1)
{
$hl=mysqli_query($con,"update action set title='$title', action='$action', deliver='$date' where fid='$fid' and ques='$qid' and sno='$rid' ");
}
else
{
$sql=mysqli_query($con,"insert into action(fid,title,action,ques,deliver,tid,sid,status,sno)values('$fid','$title','$action','$qid','$date','$rows[tid]','$rows[sid]','waiting','$rid')");
}

?>
<script>
document.getElementById("peep").innerHTML = "Welcome " + name;
</script>
         <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
									 <thead>
                                            <th>Index</th>
                                            <th>Due</th>
                                            <th>Title</th>
											<th>Severity</th>
											<th>Delete</th>
                                        </thead>
                                        <tbody>
										<?php
					 include 'connection.php';
					 $query1=mysqli_query($con,"select * from action where sno='$rid' and fid='$fid' and ques='$qid' ");
					 $i=1;
					 while($rows1=mysqli_fetch_array($query1))
					  {
                      ?>  
			 	      <tr>
                     <td><?php echo $rows1['fid'];?></td>
                     <td><?php echo $rows1['deliver'];?></td>
                     <td><?php echo $rows1['title'];?></td>
					 <td><?php echo $rows1['action'];?></td>
					  <td><a href="#" onclick="return bnm(<?php echo $rows1['id'];?>);"><i class="fa fa-trash" ></i></a></td>
                       </tr>
                                            <?php
											$i++;
											}
											?>
											
                                        </tbody></table>