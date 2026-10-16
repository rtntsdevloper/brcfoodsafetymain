<?php
ini_set('max_execution_time', 600);
ini_set('memory_limit', '-1');


$spo = $_GET['pro'];
$vrd = mysqli_query($con, "SELECT * FROM `save_specification3` WHERE `id` = '$spo' ");
$vrdrow = mysqli_fetch_array($vrd);

$sno = $vrdrow['pid'];

$sql = mysqli_query($con, "select * from tblproduct1 where prodid='$sno' ");
$row = mysqli_fetch_array($sql);

$sql5 = mysqli_query($con, "select * from tblproduct1 where prodid='$sno' ");
$row5 = mysqli_fetch_array($sql5);



?>

<div class="container-fluid">
  <div class="row column_title">
    <div class="col-md-12">
      <div class="page_title">
        <h2><?php echo $row['prodname']; ?> (<?php echo $row['prodcode']; ?>)

          <a href="productspecs/pdf/<?php echo $vrdrow['scode']; ?>-ProdSpec.pdf" target="_blank" download=""><button class="btn btn-warning" style="float:right; margin-left:10px">Download Spec</button></a>


          <a href="admin.php?id=1"><button class="btn btn-info" style="float:right">Go Back</button></a>


        </h2>
      </div>
    </div>
  </div>

  <!-- row -->
  <div class="card">
    <div class="col-12">
      <div class="full graph_head">

        <div class="row">
          <div class="col-12">
            <iframe src="productspecs/pdf/<?php echo $vrdrow['scode']; ?>-ProdSpec.pdf" width="100%" height="700"></iframe>
          </div>
        </div>
      </div>
      <form action="" method="post">
        <hr>
        <div class="row my-3  py-3">

          <div class="col-md-6">
            <label for="">Approval Status</label>
            <select name="status" id="status" class="form-control">
              <option value="">Select Status</option>
              <option value="Accepted">Accepted</option>
              <option value="Rejected">Rejected</option>
            </select>
          </div>
          <div class="col-md-6"></div>
          <div class="col-md-6">
            <label for="">Remarks</label>
            <textarea name="remarks" id="remarks"  class="form-control"></textarea>
          </div>
          <div class="col-md-6"></div>
          <div class="col-md-12 mt-5">
            <button type="submit" class="btn btn-success" name="submit" >Submit</button>
          </div>

        </div>
      </form>
    </div>
  </div>
</div>

<?php
if(isset($_POST['submit'])){
  $status = $_POST['status'];
  $remarks = $_POST['remarks'];
  $proid = $_GET['pro'];

  $datexn = date('Y-m-d H:i:s');
  $update = mysqli_query($con, "UPDATE `save_specification3` SET `apdate`='$datexn',`apdesc`='$remarks',`approveby`='$user',`status`='$status' WHERE `id` = '$proid'");

  $insertx = mysqli_query($con,"INSERT INTO `save_specaproval`(`status`, `date`, `remark`, `user`, `pid`) VALUES ('$status','$datexn','$remarks','$user','$proid')");
  if($update){
    echo "<script>
    alert('Status updated successfully'); 
    window.location.href='admin.php?id=prodspecr';
    </script>";
  }
}
?>
