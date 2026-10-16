<style>
#progress {
    background: #333;
    border-radius: 0px;
    height: 22px;
    width: 200px;
    padding: 3px;
}

#progress1{
    content: '';
    display: block;
    background: orange;
    width: 50%;
    height: 100%;
    border-radius:0px;
}
</style>
<?php
$tid=$_GET['tid'];

$query=mysqli_query($con,"select * from tblonlinetraining where id='$tid'");
$row=mysqli_fetch_array($query);

$name=$row['name'];


$sql0=mysqli_query($con,"select * from tblppt where tid='$tid'");
   $num0=mysqli_num_rows($sql0);

$sql1=mysqli_query($con,"select sum(imgno) as imgno from tbltrainingrecord where subcrsid='$tid' and staffid='$_SESSION[staffid]'");
$r1=mysqli_fetch_array($sql1);
$num1=(($r1['imgno']=="")?0:$r1['imgno']);
$prcnt=round((($num1/$num0)* 100));

$sql81=mysqli_query($con,"select * from tblresult where tid='$tid'  and staffid='$_SESSION[staffid]'");
$num81=mysqli_num_rows($sql81)



?>
	<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $name;?> Courses</h1>
                    <ul>
                     <li><a href="">Home</a></li>
                     <li>Online Training</li>
                    </ul>
                </div>
				 
           
                         
				 <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
							<table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
	      <tr>
      <td><div><?php echo $name;?></div></td></tr>
	   <tr>
      <td ><div style="width:220px;height:22px;background:#00FF33">
	  <div style="width:190px;height:22px;background:#000099;float:left">
	  <div id="progress">
	  <div id="progress1" style="width:<?php echo $prcnt;?>%"></div>
	  </div>
	  </div>
	  <div style="width:30px;height:22px;background:#000000;float:left;color:#FFFFFF;line-height:22px;font-weight:500;font-size:11px"><?php echo $prcnt."%";?></div>
          </div></td></tr>
		   <tr>
      <td><center>
	  <?php
	  if($prcnt == 100 && $num81 > 0)
	  {
	  ?>
	<a href="admin.php?id=moddetail&scrsid=<?php echo $tid;?>"><button class="btn btn-success"><?php echo $row['p3'];?></button></a>
	  <?php
	  }
	  else if($prcnt == 100 && $num81 == 0)
	  {
	  ?>
	<a href="admin.php?id=moddetail&scrsid=<?php echo $tid;?>"><button class="btn btn-danger"><?php echo $row['p2'];?></button></a>
	  <?php
	  }
	  else
	  {
	  ?>
	 <a href="admin.php?id=moddetail&scrsid=<?php echo $tid;?>"><button class="btn btn-info"><?php echo $row['p1'];?></button></a>
	  <?php
	  }
	  ?>
	  </center></td>
    </tr>
   </table>
                            </div>
                        </div>
                    </div>
                </div>


