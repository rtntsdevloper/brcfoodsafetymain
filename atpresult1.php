
<div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2"><?php echo $headingname;?></h1>
                    <ul>
                        <li><a href="">CSV</a></li>
                        
                    </ul>
                </div>
				 <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
							<a href="admin.php?id=atpresult"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
							
                                <div class="card-title">CSV Upload</div>
								<script>
function getsupplier(str)
{
if (str=="")
  {
  document.getElementById("product").innerHTML="";
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
    document.getElementById("product").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","getproducts.php?q="+str,true);
xmlhttp.send();  
  }
</script>
<script>
			  function cal()
			  {
			
			  
			   if(document.getElementById("po").value=="")
			  {
			  document.getElementById("supperror2").innerHTML="* Please  enter  PO number";
	          document.getElementById("po").focus();
			  }
			  else if(document.getElementById("img").value=="")
			  {
			  document.getElementById("supperror3").innerHTML="* Please  upload invoice";
	          document.getElementById("img").focus();
			  }
			  else
			  {
			  
			  document.getElementById("po").disabled = true;
			  document.getElementById("div1").style.display = "block";
              document.getElementById("div1").focus();
			  }		
			  }

			  </script>
			  
       <form class="needs-validation" novalidate="novalidate" method="post" action="" enctype="multipart/form-data">
								
                                    <div class="form-row">
										 
										
										 <div class="col-md-4 mb-3">
                                            <label for="validationTooltip02">CSV</label>
                                            <input class="form-control" id="img" type="file"  required name="img" required  accept="application/msexcel,.csv"/>
                                            <div class="invalid-tooltip" id="supperror3">
                                            Please fill the field.
                                            </div>
                                           </div>
										</div>
										
                                    <button class="btn btn-primary" type="submit"  name="submit">Submit </button>
                               
                           
                     </form></div></div></div></div>
					 
					 
					 <?php
					 if(isset($_POST['submit']))
					 {
					 $nh=mysqli_query($con,"select * from tblcsv order by id desc limit 1");
					 $match=mysqli_fetch_array($nh);
					 $cid=$match['id']+1;
					
					 $csv=$cid.$_FILES['img']['name'];
					 
					 move_uploaded_file($_FILES['img']['tmp_name'],"csvdoc/".$csv);
					 
					 
				require 'PHPExcel1/Classes/PHPExcel.php';
                require_once 'PHPExcel1/Classes/PHPExcel/IOFactory.php';
                $path="csvdoc/".$csv;
				
				$objPHPExcel = PHPExcel_IOFactory::load($path);
foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
 {
    $worksheetTitle     = $worksheet->getTitle();
    $highestRow         = $worksheet->getHighestRow(); // e.g. 10
    $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
    $nrColumns = ord($highestColumn) - 150;
    
	
	
	
  
for ($row = 2; $row <= $highestRow; ++ $row) 
{
    $val=array();
for ($col = 0; $col < $highestColumnIndex; ++ $col) 
{
   $cell = $worksheet->getCellByColumnAndRow($col, $row);
   $val[] = $cell->getValue();
}
   
$dateVisited = str_replace('m/d/y', "Y-m-d", $val[3]);
 $orderdate = date('Y-m-d', strtotime($dateVisited));


  
$Connection=mysqli_query($con,"INSERT INTO `tblatp` (`result`, `rid`, `date`, `site`, `location`, `testdevice`, `username`, `rlu`, `retest`, `retested`, `serialno`, `instrument`, `planname`, `lower`, `upper`, `notes`, `swabtemp`, `ambienttemp`, `groupname`, `surfacename`, `createdby`, `rank`, `zone`, `unittype`, `line`, `product`, `inspection`, `cleaner`, `roomnumber`, `personnel`, `corrective`, `isdeleted`, `lot`, `modify`, `reason`) VALUES ('".$val[1] . "', '".$val[2] . "', '".$orderdate."', '".$val[4] . "', '".$val[5] . "', '".$val[6] . "', '".$val[7] . "', '".$val[8] . "', '".$val[9] . "', '".$val[10] . "', '".$val[11] . "', '".$val[12] . "', '".$val[13] . "', '".$val[14] . "', '".$val[15] . "', '".$val[16] . "', '".$val[17] . "', '".$val[18] . "', '".$val[19] . "', '".$val[20] . "', '".$val[21] . "', '".$val[22] . "', '".$val[23] . "', '".$val[24] . "', '".$val[25] . "', '".$val[26] . "','".$val[27] . "','".$val[28] . "','".$val[29] . "','".$val[30] . "','".$val[31] . "','".$val[32] . "','".$val[33] . "','".$val[34] . "','".$val[35] . "')");

}
}
					 
					
					 
					 
					 ?>
					<script >
				window.open('admin.php?id=atpresult','_self');
					</script> 
					 <?php
					 }
					 
					 ?>
					 