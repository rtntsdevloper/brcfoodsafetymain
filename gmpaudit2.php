<?php

$sno=$_GET['sno'];
$sno1=$_GET['sno1'];
$sid=$_GET['sno2'];

$sq3=mysqli_query($con,"select * from tblauditsection where id='$sno1'");
$ro3=mysqli_fetch_array($sq3);
	  
	  
?>
	            <div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"> ATTEMPT AUDIT </h1>
                    
					 <ul>
                        <li><a href="">Home</a></li>
                        <li><?php echo $headingname;?></li>
                    </ul>
					
                </div>
	 <div class="col-md-12">
     <div class="card">
     <div class="card-body">
	 
	 <script>
 function calr(str,qid,sid) 
{
 
  if (str.length == 0) 
  {
   document.getElementById("txtHint").innerHTML = "";
   return;
  } 
 else 
 {
   var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function()
	 {
      if (this.readyState == 4 && this.status == 200) 
	  {
        document.getElementById("txtHint").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET", "saveansr.php?ans=" + str +"&qid="+ qid+"&sid="+sid, true);
    xmlhttp.send();
  }
}
</script>


 <script>
 function cal1(str,qid,sid) 
{
 
  if (str.length == 0) 
  {
   document.getElementById("txtHint").innerHTML = "";
   return;
  } 
 else 
 {
   var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function()
	 {
      if (this.readyState == 4 && this.status == 200) 
	  {
        document.getElementById("txtHint").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET", "saveans.php?ans=" + str +"&qid="+ qid+"&sid="+sid, true);
    xmlhttp.send();
  }
}
</script>


<script>
function cal2(str,qid) 
{
  if (str.length == 0) 
  {
   document.getElementById("txtHint").innerHTML = "";
   return;
  } 
 else 
 {
   var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function()
	 {
      if (this.readyState == 4 && this.status == 200) 
	  {
        document.getElementById("txtHint").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET", "saveans1.php?ans=" + str +"&qid="+ qid, true);
    xmlhttp.send();
  }
}
</script>

<script>
function cal3(str,qid) 
{
  if (str.length == 0) 
  {
   document.getElementById("txtHint").innerHTML = "";
   return;
  } 
 else 
 {
   var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function()
	 {
      if (this.readyState == 4 && this.status == 200) 
	  {
        document.getElementById("txtHint").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET", "saveans2.php?ans=" + str +"&qid="+ qid, true);
    xmlhttp.send();
  }
}
</script>


<script>
function cal4(str,qid) 
{
  if (str.length == 0) 
  {
   document.getElementById("txtHint").innerHTML = "";
   return;
  } 
 else 
 {
   var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function()
	 {
      if (this.readyState == 4 && this.status == 200) 
	  {
        document.getElementById("txtHint").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET", "saveans3.php?ans=" + str +"&qid="+ qid, true);
    xmlhttp.send();
  }
}
</script>

     <div id="txtHint"></div>
	 
	 <?php
	  $sno=$_GET['sno'];
	  $sql1=mysqli_query($con,"select * from tblauditsection1 where id='$sid'");
	   $i=0;
	  while($row1=mysqli_fetch_array( $sql1))
	  {
	  ?>
<div class="col-md-12">
		<div class="form-group label-floating">
		<label class="control-label" id="error" style="color:#0000FF"><?php echo $row1['name'];?></label>
		</div></div>
		
		<?php
	       $sql2=mysqli_query($con,"select * from tblauditsection2 where ssid='$row1[id]' ");
	       while($row2=mysqli_fetch_array( $sql2))
	       {
	    $q=$row2['id'];
	    $ques=mysqli_real_escape_string($con,$row2['ques']);

$sq=mysqli_query($con,"select * from tblgmpaudit3  where qid='$q' and tid='$sno1' and sno='$sno'");
$match=mysqli_num_rows($sq);
if($match>=1)
{
}
else
{
$sql=mysqli_query($con,"insert into tblgmpaudit3(tid,sno,ques,qid)values('$sno1',$sno,'$ques','$q')")or die(mysqli_error());
}
$sq=mysqli_query($con,"select * from tblgmpaudit3  where qid='$q' and tid='$sno1' and sno='$sno'");
$df3=mysqli_fetch_array($sq);
?>
 <input type="hidden" name="sid" value="<?php echo $sno;?>"  />
 
		<div class="col-md-12">
		<div class="form-group label-floating">
		 <?php echo $row2['ques'];?>
		</div></div>
		
		<?php
		if($ro3['name']=="GMP Audit")
		{
		?>
		<div class="col-md-3">
		<div class="form-group label-floating">
		<select name="t1<?php echo $i;?>" id="t1<?php echo $i;?>" class="form-control"  onchange="return calr(this.value,<?php echo $df3['id']?>,<?php echo $row2['id']?>);" required >
		<?php
		if($df3['stype']=="")
		{
		?>
		<option value="">Please Select</option>
		<?php
		}
		else
		{
		?>
		<option value="<?php echo $df3['stype']?>"><?php echo $df3['stype']?></option>
		<?php
		}
		?>
		<option value="Operations">Operations</option>
		<option value="Fabrication">Fabrication</option>
		<option value="Hygiene">Hygiene</option>
		
		</select>
		</div></div>
		
		<?php
		}
		?>
		
		<?php
		$sql3=mysqli_query($con,"select * from tblauditsection3 where qid='$row2[id]'");
		$match=mysqli_num_rows($sql3);
		if($match>=1)
		{
		?>
		
		<div class="col-md-12">
		
		<div class="col-md-12">
		<div class="col-md-3">
		<div class="form-group label-floating"> 
		<select name="r1<?php echo $i;?>" id="r1<?php echo $i;?>" class="form-control"  onchange="return cal1(this.value,<?php echo $df3['id']?>,<?php echo $row2['id']?>);" required >
		<?php
		if($df3['ans']=="")
		{
		?>
		<option value="">Please Select</option>
		<?php
		}
		else
		{
		?>
		<option value="<?php echo $df3['ans']?>"><?php echo $df3['ans']?></option>
		<?php
		}
		?>
		<?php
		while($row4=mysqli_fetch_array($sql3))
		{
		?>
		
		<option value="<?php echo $row4['ans'];?>"><?php echo $row4['ans'];?></option>
		<?php
		}
		?>
		</select>
		
		</div></div>
	
		<?php
		if($row2['textbox']=="yes")
		{
		?>
	    <div class="col-md-3">
		<div class="form-group label-floating">
		<input  type="text" name="f1<?php echo $i;?>" id="f1<?php echo $i;?>"  placeholder="Comment if any?"  class="form-control"  value="<?php echo $df3['cmnt'];?>"
		 oninput="return cal2(this.value,<?php echo $df3['id']?>);" required />
		</div></div>
		<?php
		}
		?>
		
		<?php
		if($row2['cmnt']=="yes")
		{
		?>
	    <div class="col-md-3">
		<div class="form-group label-floating">
		<textarea  name="cmnt<?php echo $i;?>" class="form-control" placeholder="Action Required"  oninput="return cal3(this.value,<?php echo $df3['id']?>);"><?php echo $df3['action'];?></textarea>
		</div></div>
		<?php
		}
		?>
		
		
		<?php
		if($row2['number']!="")
		{
		?>
	    <div class="col-md-3">
		<div class="form-group label-floating">
		<input type="<?php echo $row2['number'];?>" name="r1<?php echo $i;?>" class="form-control" value="<?php echo $df3['deliver'];?>" onchange="return cal4(this.value,<?php echo $df3['id']?>);" />
		</div></div>
		<?php
		}
		?>
		</div>
		
		
		<?php
		if($row2['pic']=="yes")
		{
		?>
	   
				   
 <script type="text/javascript">
$(document).ready(function (e)
 {

  var phpvalue = <?php echo $i; ?>

	$("#uploadForm"+phpvalue).on('change',(function(e)
	 {
		e.preventDefault();
		$.ajax({
        	url: "audit6",
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	    cache: false,
			processData:false,
			success: function(data)
		    {
			//alert("");
			//$('#uploadForm')[0].reset();
	$('#uploadStatus'+phpvalue).append(data);
			
			 document.getElementById('dupload'+phpvalue).value="yes";
		    },
		  	error: function() 
	    	{
	    	} 	        
	   });
	}));
});
</script>	
								 <div class="col-12">						
								<div class="col-md-4">
                              <div class="form-group label-floating">
   <label class="control-label" ></label>
			<form id="uploadForm<?php echo $i;?>" name="form5">
<input type="hidden" name="sn" value="<?php echo $df3['id'];?>" />
<input type="hidden" name="y" value="<?php echo $i;?>" />
<input name="userImage[]" type="file" class="inputFile"  accept="image/*,.jpg,.gif,.png,.jpeg" multiple    />
</form>
</div></div>	
													
						<div class="col-md-12" id="uploadStatus<?php echo $i;?>">
												<div class="form-group label-floating">
												
<input type="hidden" id="dupload<?php echo $i;?>" name="dupload<?php echo $i;?>" value=""  />

<script>
function bnm(img,sno,y)
  {
 
   var r=confirm("Are you sure?");
   if (r==true)
   {
    $.ajax({
	url: "delete?sno="+sno+"&img="+img+"&y="+y, 
	type: "GET",
	success: function(result)
	{
      $("#uploadStatus"+y).html(result);
    }
	});
	}
	else
   {
       //nothing to do here
   }
  };

</script>

 <?php
 $string = $df3['img'];
$tags1 = explode(';' , $string);
foreach($tags1 as $key1)
  {
  $info5= new SplFileInfo($key1);
  $tpe5=$info5->getExtension();
 if($tpe5=="jpg" || $tpe5=="jpeg" || $tpe5=="png" || $tpe5=="PNG")
    {
  ?>
  
  <img src="auditpic/<?php echo $key1;?>" width="100"  />
   <a href"#" class="notificationn" id="ghjk<?php echo $i;?>" onclick="return bnm('<?php echo $key1;?>','<?php echo $df3['id']?>','<?php echo $i;?>')" style="cursor:pointer">
    <span class="badge">X</span></a>
   
  <?php
  }
  }
  ?></div></div>
  </div>
  
  <?php
  }
?>
		</div>
<?php
		}
		?>
		
		
		
		<div class="row" id="error<?php echo $i;?>" style="color:#FF0000"></div>
		<?php
		$i++;
		}
		}
		?>
		
	    
    <div class="col-md-3">
		<div class="form-group label-floating">
		 <button type="submit" class="btn btn-primary pull-right" name="submit" onclick="return checkReq();" >Submit</button>
    </div></div></div>
	
	
			 </div></div></div></div>
			 
			 
			 <script>
   function checkReq() 
 {

 var n=<?php echo $i;?>;

for (var t3=0; t3<n;t3++) 

{

var y=t3;

var e=y+1;

var cmnt = document.getElementById("r1"+y).value;
var cmnt1 = document.getElementById("f1"+y).value;
  if(cmnt=="")
	{
	document.getElementById('error'+y).innerHTML="*Please choose one option for question no."+e+" *";

     document.getElementById('r1'+y).focus();

    return false;
     }  
	else if(cmnt1=="")
	{
	document.getElementById('error'+y).innerHTML="*Please enter comment for question no. "+e+" *";

     document.getElementById('f1'+y).focus();

    return false;
     }   
     else
      {
    document.getElementById('error'+y).innerHTML="";
       }
       }
	   window.open('admin.php?id=gmpauditt&tid=<?php echo $sno1;?>','_self');
	 }

</script>	