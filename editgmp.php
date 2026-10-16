
<?php 
$sno=$_GET['sno'];
$sid=$_GET['sid'];
$ssid=$_GET['ssid'];

$sql=mysqli_query($con,"select * from tblauditsection where id='$sid'");
$row=mysqli_fetch_array($sql);

$sql1=mysqli_query($con,"select * from tblauditsection1 where sid='$sid'");
$row1=mysqli_fetch_array($sql1);

 $sql2=mysqli_query($con,"select * from tblauditsection2 where id='$sno'");
 $row2=mysqli_fetch_array($sql2);
										 
								
?>

<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Edit Question </a></li>
                        <li>Edit Question</li>
                    </ul>
                </div>
				<div class="row">
				 <div class="col-md-6">
                  <div class="card">
                  <div class="card-body">
                   <div class="card-title">Edit Question</div>
							
                                <form name="form1" class="needs-validation" novalidate="novalidate" method="post" action="" enctype="multipart/form-data">
                                    <div class="form-row">
									
									 <div class="col-12">
                                            <label for="validationTooltip01">Section</label>
                                            <input class="form-control" id="validationTooltip01" type="text"  name="name" value="<?php echo $row['name'];?>" disabled="disabled" />
                                            <div class="invalid-tooltip">
                                                Please provide a valid  name.

                                            </div>
                                        </div>
										
										 <div class="col-12">
                                            <label for="validationTooltip01">Sub-Section</label>
                                            <input class="form-control" id="validationTooltip01" type="text" value="<?php echo $row1['name'];?>" disabled="disabled" />
                                            <div class="invalid-tooltip">
                                                Please provide a valid  name.

                                            </div>
                                        </div>
										
										
										
										 <div class="col-12">
                                            <label for="validationTooltip01">Question</label>
                                            <textarea class="form-control" required="required" name="ques"><?php echo $row2['ques'];?></textarea>
                                            <div class="invalid-tooltip">
                                                Please provide a valid  name.
                                            </div>
                                        </div>
										
                                       
									    <div class="col-12">
                                            <label for="validationTooltip01">Image: <a href="gmpreport/<?php echo $row2['img'];?>" target="_blank"><?php echo $row2['img'];?></a></label>
                                            <input type="file" class="form-control" name="img">
                                            <div class="invalid-tooltip">
                                                Please provide a valid  name.
                                            </div>
                                        </div>
										
										
										</div>
                                      
                                      
										
										<br/>
										
                                    <button class="btn btn-primary" type="submit" name="submit">Submit </button>
                                </form>
                            </div>
                        </div>
                    </div>
					
					
					
					
										
                              
                            </div>
                        </div>
                    </div>
					
					</div>
                </div>

<?php
if(isset($_POST['submit']))
{
$ques=mysqli_real_escape_string($con,$_POST['ques']);
$img=$_FILES['img']['name'];
if($img!='')
{
move_uploaded_file($_FILES['img']['tmp_name'],"gmpreport/".$img);
$sql=mysqli_query($con,"update tblauditsection2 set ques='$ques' , img='$img' where id='$_GET[sno]'");

}
else
{

$sql=mysqli_query($con,"update tblauditsection2 set ques='$ques' where id='$_GET[sno]'");

}
?>
<script language="javascript">
window.open('admin.php?id=viewaudit&sno=<?php echo $sid;?>&ssid=<?php echo $ssid;?>','_self');
</script>
<?php
}
?>

