<?php
$sno=$_GET['sno'];
$sql=mysqli_query($con,"select * from tblauditor where id='$sno'");
$row=mysqli_fetch_array($sql);
$tid=$row['tid'];
$sid=$row['sid'];
?>
<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">Auditor Management</a></li>
                        <li>Tab Access</li>
                    </ul>
                </div>
				 <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
							<a href="admin.php?id=auditor"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							
                                <div class="card-title">Edit Auditor</div>
								
                                <form class="needs-validation" novalidate="novalidate" method="post" action="" enctype="multipart/form-data">
								
							
								
                                    <div class="form-row">
                                        <div class="col-md-4 mb-3">
                                            <label for="validationTooltip01">Name</label>
                                            <input class="form-control" id="validationTooltip01" type="text" placeholder="First name"  required="required" name="name" value="<?php echo $row['name'];?>" />
                                            <div class="invalid-tooltip">
                                                Please provide a valid first name.

                                            </div>
                                        </div>
                                       
									   
									   <div class="col-md-12">
                                            <label for="validationTooltip02">Select Tabs</label>
											<br/>
                                       
											
                                            <div class="invalid-tooltip">
                                               Please provide a valid last name.

                                            </div>
                                        </div>
										
										
										<div class="col-md-4 mb-3">
    <label for="validationTooltip05">Tabs-Access </label>
    <input type="text"  hidden name="tab_ids" value="<?php echo $row['tabs']; ?>">
    <?php 
    $query=mysqli_query($con,"select * from tbltabs");
    while($roc=mysqli_fetch_array($query)){
    ?>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="<?php echo $roc['sno']?>" id="flexCheckDefault-<?php echo $roc['sno']?>" name="tab_acess[]"
            <?php 
            $tab_ids = explode(';', $row['tabs']); // assuming tab_id is a comma-separated string
            if(in_array($roc['sno'], $tab_ids)){ 
                echo 'checked'; 
            }
            ?>>
            <label class="form-check-label" for="flexCheckDefault-<?php echo $roc['sno']?>">
                <?php echo $roc['name']?>
            </label>
        </div>
    <?php
    }
    ?>
</div>
										</div>
									
                                
                                    <button class="btn btn-primary" type="submit" name="submit">Submit </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
