 <?php 
 include 'connection.php';
  $dt=$_GET['q'];
 $days=$_GET['days'];
 $days1=$_GET['days1'];

 
// Add days to date and display it


  $maxdate= date('Y-m-d', strtotime($dt. ' + '.$days.' days'));
 
   $mindate= date('Y-m-d', strtotime($dt. ' + '.$days1.' days'));
  
  
  if($dt<$mindate)
  {
  echo "Shelflife shorter than expected";
  echo '<script type="text/javascript">jsFunction();</script>';
  ?>
    <script language="javascript">
	function jsFunction()
	{

	document.getElementById("useby").focus();
	document.getElementById("useby").value="";
	document.getElementById("perror1").style.color="red";
	}
  </script>
  <?php
  
  }
  else if($dt>$maxdate)
  {
   echo "Shelflife longer than expected";
  echo '<script type="text/javascript">jsFunction1();</script>';
   ?>
    <script language="javascript">
	function jsFunction1()
	{
	document.getElementById("useby").focus();
	document.getElementById("useby").value="";
	document.getElementById("perror1").style.color="red";
	}
  </script>
   <?php
  }
  
  ?>
 
