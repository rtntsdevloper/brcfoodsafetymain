<?php

 $_SESSION['sno']=$_GET['sno1'];
 $pid=$_GET['sno'];

  $staffid;
$sno1=$_GET['sno1'];
$query=mysqli_query($con,"select * from tblprocedure where id='$pid'");
while($row=mysqli_fetch_array($query))
{
$name=$row['name'];
}

$sql2=mysqli_query($con,"delete from user_anss1 where sessionid='$staffid' and testid='$pid'");

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
xmlhttp.open("GET","proceduretest1.php?q="+str,true);
xmlhttp.send();
}
</script>
					<div class="container-fluid">
                     <div class="row column_title">
                        <div class="col-md-12">
                           <div class="page_title">
                              <h2>
							 <?php echo $name;?>
							  
							  </h2>
                           </div>
                        </div>
                     </div>
					 
				
                     <!-- row -->
                   <div class="card">
				   <div class="col-12"> 
				   <div class="full graph_head">
				    <div id="timer" class="btn btn-warning" style="float:right; margin:20px"></div>
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
       top.window.location='procedureresult.php?pid=<?php echo $pid;?>&staffid=<?php echo $staffid;?>';
    }
    // double digit formatting
    function doubleDigits(number) {
    	return number<10
        	? '0'+number
        	: number
        ;
    } 
})(
     (9* 60) + (60)
);// time to elapse 1:30:10
</script>





<div class="col-12" id="des">
					  </div>
				   
<form method="post" action="proceduretest2" >

    <input type="hidden" name="qid[]"   value="<?php echo $r['qid']?>">
    <input type="hidden" name="ques[]" value="<?php echo $r['ques'];?>">
    <input type="hidden" name="true[]" value="<?php echo $r['correctans'];?>">
	<input type="hidden" name="ansa[]" value="<?php echo $r['ansa']; ?>">
	<input type="hidden" name="ansb[]" value="<?php echo $r['ansb']; ?>">
	<input type="hidden" name="ansc[]" value="<?php echo $r['ansc']; ?>">
	<input type="hidden" name="ansd[]" value="<?php echo $r['ansd']; ?>">
	<input type="hidden" name="pid"    value="<?php echo $pid; ?>">
    <input type="hidden" name="staffid" value="<?php echo $staffid;?>"   />

				<table class="table">
				 <tbody>
<?php
$res1=mysqli_query($con,"SELECT distinct cid from trainingquess1 where tid='$pid'");
$i=1;
while($r1=mysqli_fetch_array($res1))
{
$res=mysqli_query($con,"select * from trainingquess1 where cid='$r1[cid]' AND tid='$pid' ");
while($r=mysqli_fetch_array($res))
{
$q=$r['ques'];
$true=$r['correctans'];
$ansa=$r['ansa'];
$ansb=$r['ansb'];
$ansc=$r['ansc'];
$ansd=$r['ansd'];
$sess_id=session_id();

$sql=mysqli_query($con,"insert into user_anss1(sessionid,testid,quesdes,ansa,ansb,ansc,ansd,correctans)values
('$staffid',$pid,'$q','$ansa','$ansb','$ansc','$ansd','$true')")or die(mysqli_error());

?>
				   <tr><th> <div class="col-12"><?php echo $i;?>. <?php echo $r['ques'];?></div></th></tr> 
				   <?php
				   if($r['ansa']=="" && $r['ansb']=="" && $r['ansc']=="" && $r['ansd']=="")
				   {
				   ?>
				    <tr><td><div class="col-12"> <textarea name="a<?php echo $i;?>" value="d.<?php echo $i;?>.<?php echo $pid;?>.<?php echo $r['qid']?>"  
					onchange="hello(this.value)"></textarea>
         <?php echo $r['ansd']?></div></td></tr>
				   
				   <?php
				   }
				   else
				   {
				   ?>
				   <tr><td> <div class="col-12"><input name="a<?php echo $i;?>" type="radio" value="a.<?php echo $i;?>.<?php echo $pid;?>.<?php echo $r['qid']?>" onclick="hello(this.value)"/>
             <?php echo $r['ansa']?></div></td></tr>
				   <tr><td><div class="col-12"><input name="a<?php echo $i;?>" type="radio" value="b.<?php echo $i;?>.<?php echo $pid;?>.<?php echo $r['qid']?>" onclick="hello(this.value)" /> 
			<?php echo $r['ansb']?></div></td></tr>
			<?php
	if($r['ansc']!="")
	{
	?>
	 <tr><td> 
	 <div class="col-12"><input name="a<?php echo $i;?>" type="radio" value="c.<?php echo $i;?>.<?php echo $pid;?>.<?php echo $r['qid']?>" onclick="hello(this.value)" />
                <?php echo $r['ansc']?> </div></td></tr>
				   <?php
				   }
				   ?>
    <?php
	if($r['ansd']!="")
	{
	?>
   <tr><td><div class="col-12"> <input name="a<?php echo $i;?>" type="radio" value="d.<?php echo $i;?>.<?php echo $pid;?>.<?php echo $r['qid']?>" onclick="hello(this.value)" />
         <?php echo $r['ansd']?></div></td></tr>
				   <?php
				   }
				   ?>
				   
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
					 
                            </div></div>  </div> </div> 
							
							
							
							
							
							 <!-- The Modal -->
							 
							