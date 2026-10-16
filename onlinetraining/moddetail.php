<?php
$tid=$_GET['scrsid'];
?> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
   <script>
   $(function()
   {
    $("button").click(function() {
	    var nm=this.name;
	if(nm == "btn1")
	{
        $("#disp").fadeIn(1000);
	    var vl=this.value;
        $("body").append("<div id='disp'></div>");
		 $("body").scrollTop(1);
		$("body").css("overflow","hidden");
		$("#img1").src="#";
		 $.ajax({url: "traininge.php?sno=1&modid="+vl+"&scrsid=<?php echo $tid;?>", success: function(result){
            $("#disp1").html(result);
        }});
      }
    });
	
	 $("#btn2").click(function() {
	   $("body").css("overflow","auto");
        $("#disp").fadeOut(1000);
		location.reload(true);
    });
}); 
</script>

<script>
function showNext(str,vl)
{
document.getElementById("img1").src="#";
var xmlhttp;    
if (str=="")
  {
  document.getElementById("disp1").innerHTML="";
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("disp1").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","traininge.php?sno="+str+"&modid="+vl+"&scrsid=<?php echo $tid;?>",true);
xmlhttp.send();
}

function chkk()
{
document.getElementById("myVideo").pause();
document.getElementById('pause').style.display="none";
document.getElementById('play').style.display="block";
}
function chkk1()
{
document.getElementById("myVideo").play();
document.getElementById('play').style.display="none";
document.getElementById('pause').style.display="block";
}
</script>

<style>
#progress {
    background: #333;
    border-radius: 0px;
    height: 22px;
    width: 200px;
    padding: 3px;
}

#progress1
{
    content: '';
    display: block;
    background: orange;
    width: 50%;
    height: 100%;
    border-radius:0px;
}
#disp
{
width:100%;
height:100%;
margin-top:0px;
top:0%;
left:0%;
z-index:999;
display:none;
position:absolute;
 background: rgba(0,0,0,.7);
 }
</style>
<?php
$query=mysqli_query($con,"select * from tblonlinetraining where id='$tid'");
$row=mysqli_fetch_array($query);

$name=$row['name'];

?>


	<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"> Module List</h1>
                    <ul>
                        <li><a href="">Home</a></li>
                        <li><?php echo $name;?>  </li>
						
                    </ul>
					
                </div>
				 
           
                         
				 <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
							   
								<div class="row">
							 <?php
	 $cmpchk=array();
     $i=0;
	 $sql=mysqli_query($con,"select * from tblmodule where crsid='$tid'");
while($r=mysqli_fetch_array($sql))
{
$sql0=mysqli_query($con,"select * from tblppt where modid='$r[modid]'");
$num0=mysqli_num_rows($sql0);

$sql1=mysqli_query($con,"select * from tbltrainingrecord where subcrsid='$tid' and modid='$r[modid]' and staffid='$staffid'");
$r1=mysqli_fetch_array($sql1);
$num1=(($r1['imgno']=="")?0:$r1['imgno']);
$prcnt=round((($num1/$num0)* 100));

if($r1['status']== "Completed")
{
$cmpchk[$i]=1;
}
else
{
$cmpchk[$i]=0;
}


?>			
   <div class="col-4"><?php echo $r['modname'];?></div>
   
      <div class="col-6">
	  
	  <div style="width:220px;height:22px;background:#00FF33">
	  <div style="width:190px;height:22px;background:#000099;float:left">
	  <div id="progress">
	  <div id="progress1" style="width:<?php echo $prcnt;?>%"></div>
	  </div>
	  </div>
	  <div style="width:30px;height:22px;background:#000000;float:left;color:#FFFFFF;line-height:22px;font-weight:500;font-size:11px">
	  <?php echo $prcnt."%";?>
	  </div>
      </div>
	  </div>
		  
      <div class="col-2">
	 <button name="btn1" id="btn1" class="btn btn-danger" value="<?php echo $r['modid'];?>" style="width:130px; margin:10px">
	 <?php echo (($r1['status']=='')?$row['p2']:$r1['status'])?> &raquo;</button>	   
	 </div>
		  <?php
      $i++;
         }
        ?>
		 
	 
		<div class="col-12">	
	    <?php
       if(in_array('0',$cmpchk))
       {
      ?> 
 <button class="btn btn-ff"><?php echo $row['p2'];?> </button>
		   <?php
            }
           else
            {
            ?>
           <a href="admin.php?id=starttest&tid=<?php echo $tid;?>"><button class="btn btn-success"><?php echo $row['p2'];?> </button></a>
          <?php
            }
            ?>
			
			 </div>
			 
   </div>
   
   
</div></div></div></div>


<div id="disp">

<div class="row" style=" float:right; margin:30px">
<button  name="btn2" id="btn2" class="btn btn-warning"> <?php echo $row['p4'];?>!!</button></div>
	<div class="row" id="disp1" style="margin-top:60px;">&nbsp;</div>
    

</div>
                            </div>
                        </div>
                    </div>
                </div>


