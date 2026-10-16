<?php
$tid=$_GET['tid'];
$_SESSION['tid']=$tid;
$query=mysqli_query($con,"select * from tblonlinetraining where id='$tid'");
while($row=mysqli_fetch_array($query))
{
$name=$row['name'];
}

$name=$_SESSION['user'];

mysqli_query($con,"delete from user_anss where uid='$staffid' and testid='$tid'");
?>
<script>
function hello(str)
{
if (str=="")
  {
  document.getElementById("des").innerHTML="";
  return;
  } 
if (window.XMLHttpRequest)
  {
  xmlhttp=new XMLHttpRequest();
  }
else
  {
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("des").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","starttest1.php?q="+str,true);
xmlhttp.send();
}
</script>
<?php
$query=mysqli_query($con,"select * from tblonlinetraining where id='$tid'");
$row=mysqli_fetch_array($query);

$name=$row['name'];

?>


	<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2">Attempt Test</h1>
                    <ul>
                        <li><a href="">Home</a></li>
                        <li><?php echo $name;?></li>
						
                    </ul>
				
                </div>
		
     <div class="col-md-12">	<div class="row"><div id="timer" class="btn btn-warning" style="float:right; margin:20px"></div></div>	</div>
                         
				 <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
							  
								<div class="row">
										 
  <script>
(function(endTime){
    endTime*=1000; // javascript works with milliseconds
    endTime+=new Date().getTime();// add the current system time into the equation
    // your timeSync function
    (function timerSync() {
        // get elapsed time as a Date Object
        var diff = new Date(endTime - new Date().getTime());
        // get timer span
        var timer=document.getElementById('timer');
        // has the timer finished?
        if(diff<=0)return timerEnd(timer);
        // set the current time difference
        timer.innerHTML = "Time Left: " + 
        	
        	doubleDigits(diff.getUTCMinutes())
            + ':' +
        	doubleDigits(diff.getUTCSeconds())
        ;
        // recursion
        setTimeout(timerSync,1000);
    })();// also call it to start the timer
    // your timer end function
	function timerEnd(timer) 
	{
       top.window.location='starttest2.php';
    }
    // double digit formatting
    function doubleDigits(number) {
    	return number<10
        	? '0'+number
        	: number
        ;
    } 
})(
     (58* 60) + (60)
);// time to elapse 1:30:10
</script>

<form method="post" action="starttest2" >

<input type="hidden" name="qid[]"   value="<?php echo $r['qid']?>">
    <input type="hidden" name="ques[]" value="<?php echo $r['ques'];?>">
    <input type="hidden" name="true[]" value="<?php echo $r['correctans'];?>">
	<input type="hidden" name="ansa[]" value="<?php echo $r['ansa']; ?>">
	<input type="hidden" name="ansb[]" value="<?php echo $r['ansb']; ?>">
	<input type="hidden" name="ansc[]" value="<?php echo $r['ansc']; ?>">
	<input type="hidden" name="ansd[]" value="<?php echo $r['ansd']; ?>">
	 <input type="hidden" name="tid"    value="<?php echo $tid; ?>">
	 
<input type="hidden" name="staffid" value="<?php echo $staffid;?>"   />
				<table class="table">
				 <tbody>
				<?php
$res1=mysqli_query($con,"SELECT distinct cid from trainingquess where tid='$tid' ORDER BY rand() LIMIT 30");
$i=1;
while($r1=mysqli_fetch_array($res1))
{
$res=mysqli_query($con,"select * from trainingquess where cid='$r1[cid]' AND tid='$tid' ");

while($r=mysqli_fetch_array($res))
{
$q=mysqli_real_escape_string($con,$r['ques']);
$true=mysqli_real_escape_string($con,$r['correctans']);
$ansa=mysqli_real_escape_string($con,$r['ansa']);
$ansb=mysqli_real_escape_string($con,$r['ansb']);
$ansc=mysqli_real_escape_string($con,$r['ansc']);
$ansd=mysqli_real_escape_string($con,$r['ansd']);
$sess_id=session_id();

$sq=mysqli_query($con,"select * from user_anss where quesdes='$q' and uid='$sess_id' and testid='$tid'");
$match=mysqli_num_rows($sq);
if($match>0)
{
}
else
{
$sql=mysqli_query($con,"insert into user_anss(sessionid,testid,quesdes,ansa,ansb,ansc,ansd,correctans,uid)values
('$sess_id',$tid,'$q','$ansa','$ansb','$ansc','$ansd','$true','$staffid')")or die(mysqli_error());
}
?>
				   <tr><th> <div class="col-12"><?php echo $i;?>. <?php echo $r['ques'];?></div></th></tr> 
				   <tr><td> <div class="col-12"><input name="a<?php echo $i;?>" type="radio" value="a.<?php echo $i;?>.<?php echo $tid;?>.<?php echo $r['qid']?>" onclick="hello(this.value)"/>
             <?php echo $r['ansa']?></div></td></tr>
				   <tr><td><div class="col-12"><input name="a<?php echo $i;?>" type="radio" value="b.<?php echo $i;?>.<?php echo $tid;?>.<?php echo $r['qid']?>" onclick="hello(this.value)" /> 
			<?php echo $r['ansb']?></div></td></tr>
			<?php
	if($r['ansc']!="")
	{
	?>
				   <tr><td> <div class="col-12"><input name="a<?php echo $i;?>" type="radio" value="c.<?php echo $i;?>.<?php echo $tid;?>.<?php echo $r['qid']?>" onclick="hello(this.value)" />
                <?php echo $r['ansc']?> </div></td></tr>
				   <?php
				   }
				   ?>
				   <?php
	if($r['ansd']!="")
	{
	?>
				   <tr><td><div class="col-12"> <input name="a<?php echo $i;?>" type="radio" value="d.<?php echo $i;?>.<?php echo $tid;?>.<?php echo $r['qid']?>" onclick="hello(this.value)" />
         <?php echo $r['ansd']?></div></td></tr>
				   <?php
				   }
				   ?>
				    <?php
					  $i++;
					 }
					 }
					 
					 ?>
					 </tbody>
				   </table>
				   
				   
				   <button type="submit" class="btn btn-danger" name="submit">Submit</button>
				   </form>
					 
</div>
                            </div>
                        </div>
                    </div>
                </div>


