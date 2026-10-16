<?php
$sno=$_GET['sno'];
$sql=mysqli_query($con,"select * from tbladmin where id='$sno'");
$row=mysqli_fetch_array($sql);
?>


<div class="main-content">
<div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Admin  Management</a></li>
                        <li>Edit Admin</li>
                    </ul>
                </div>
				 <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
							<a href="admin.php?id=adminmgmt"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							
                                <div class="card-title">Edit Admin</div>
								
                                <form class="needs-validation" novalidate="novalidate" method="post" action="" enctype="multipart/form-data">
                                    <div class="form-row">
                                        <div class="col-md-4 mb-3">
                                            <label for="validationTooltip01">Name</label>
                                            <input class="form-control" id="validationTooltip01" type="text" placeholder="Name"  required="required" name="name"
											 value="<?php echo $row['name'];?>" />
                                            <div class="invalid-tooltip">
                                                Please provide a valid first name.

                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="validationTooltip02">Username</label>
                                            <input class="form-control" id="validationTooltip02" type="text" placeholder="Username"  disabled="disabled" required="required" name="uname" value="<?php echo $row['username'];?>" />
                                            <div class="invalid-tooltip">
                                               Please fill the field.

                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="validationTooltip02">Password</label>
                                            <input name="pwd" type="text" class="form-control" id="validationTooltip03"  placeholder="Password"  required="required" value="<?php echo $row['pwd'];?>"/>
                                            <div class="invalid-tooltip">
                                              Please fill the field.

                                            </div>
                                        </div>
                                   
										
	<div class="col-12">
      <label for="validationTooltip05">Tabs Access</label>
    <input type="text"  hidden name="tab_ids" value="<?php echo $row['tabs']; ?>">
    <?php 
    $query=mysqli_query($con,"select * from tbltabs");
	$i=1;
    while($roc=mysqli_fetch_array($query))
	{
    ?>
     
	    <div class="form-check">
             <input class="form-check-input" type="checkbox" value="<?php echo $roc['sno']?>" id="flexCheckDefault-<?php echo $roc['sno']?>" name="tab_acess[]"
            <?php 
            $tab_ids = explode(';', $row['tabs']); // assuming tab_id is a comma-separated string
            if(in_array($roc['sno'], $tab_ids))
			{ 
             echo 'checked'; 
            }
            ?>>
            <label class="form-check-label" for="flexCheckDefault-<?php echo $roc['sno']?>">
                <?php echo $roc['name']?>  <?php echo $roc['name1']?>
            </label>
        </div>
    <?php
	$i++;
    }
    ?>
                                            <div class="invalid-tooltip">
                                               Please fill the field.
                                            </div>
                                        </div>
										
										 </div>
									
									
                                   </br>
                                        
                                        
										
										
										
										
                                      
                                       <button class="btn btn-primary" type="submit" name="submit">Submit </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


<?php
if(isset($_POST['submit']))
{

$sno=$_GET['sno'];
$name=$_POST['name'];
$pwd=$_POST['pwd'];


if(!empty($_POST['tab_acess']))
 {
        $tabs= $_POST['tab_acess'];    
         $tabs = implode( ';', $tabs).";";

    }
    else
	{
         $tabs = $_POST['tab_ids'];
    }
	
$fg=mysqli_query($con,"select * from tbladmin where username='$uname' and id!='sno'");
$match=mysqli_num_rows($fg);
if($match>=1)
{
?>
<script language="javascript">
alert("Already Exist!");
window.open('admin.php?id=editadmin&sno=<?php echo $sno;?>','_self');
</script>
<?php
}
else 
{
$sql=mysqli_query($con,"update tbladmin set name='$name',  pwd='$pwd', status='$access',tabs='$tabs' where id='$sno'");
?>
<script language="javascript">
window.open('admin.php?id=adminmgmt','_self');
</script>
<?php
}
}
?>