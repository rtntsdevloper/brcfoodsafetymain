<?php 
$sno = $_GET['sno'];


?>

<div class="main-content">
  <div class="breadcrumb">
    <h1 class="mr-2"><?php echo $headingname; ?></h1>
    <ul>
      <li><a href="">Home</a></li>
      <li>Daily Weight Check</li>
    </ul>
  </div>

  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <a href="admin.php?id=weight">
          <button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button>
        </a>
        <div class="card-title">Edit Daily Weight Check Records</div>

        <form class="needs-validation" novalidate method="post" action="" enctype="multipart/form-data">
          <input type="hidden" name="sno" value="<?php echo $sno; ?>">
          
          <div id="product-list">
            <?php
            
            ?>
            <div class="row mb-2 product-item">
              <div class="col-md-6 mb-3">
                <label>Product Size (g)</label>
                <select class="form-control size-input" name="psize[]">
                  <option value="">Select Size</option>
                  <option value="400" >400g</option>
                  <option value="450">450g</option>
                  <option value="1000" >1000g</option>
                  <option value="2000" >2000g</option>
                  <option value="4600" >4600g</option>
                  <option value="5000" >5000g</option>
                  <option value="10000" >10000g</option>
                </select>
              </div>
              <div class="col-md-6 mb-3">
                <label>Tare Weight</label>
                <input type="text" class="form-control tare-input" name="tare[]" placeholder="Enter tare weight">
              </div>
              <div class="col-md-2 remove-col">
                <button type="button" class="btn btn-danger btn-sm remove-btn" onclick="removeProduct(this)" >Remove</button>
              </div>
            </div>
           
            
          </div>
          <button type="button" class="btn btn-info btn-sm mt-2" onclick="addProduct()">+ Add More</button>
          <button class="btn btn-primary mt-3" type="submit" name="submit">submit</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
function addProduct() {
  const container = document.getElementById('product-list');
  const newRow = document.createElement('div');
  newRow.className = 'row mb-2 product-item';
  newRow.innerHTML = `
    <div class="col-md-6 mb-3">
      <label>Product Size (g)</label>
      <select class="form-control size-input" name="psize[]">
        <option value="">Select Size</option>
        <option value="400">400g</option>
        <option value="450">450g</option>
        <option value="1000">1000g</option>
        <option value="2000">2000g</option>
        <option value="4600">4600g</option>
        <option value="5000">5000g</option>
        <option value="10000">10,000g</option>
      </select>
    </div>
    <div class="col-md-6 mb-3">
      <label>Tare Weight</label>
      <input type="text" class="form-control tare-input" name="tare[]" placeholder="Enter tare weight">
    </div>
    <div class="col-md-2 remove-col">
      <button type="button" class="btn btn-danger btn-sm remove-btn" onclick="removeProduct(this)">Remove</button>
    </div>
  `;
  container.appendChild(newRow);
  toggleRemoveButtons();
}

function removeProduct(btn) {
  btn.closest('.product-item').remove();
  toggleRemoveButtons();
}

function toggleRemoveButtons() {
  const items = document.querySelectorAll('#product-list .product-item');
  const removeButtons = document.querySelectorAll('#product-list .remove-btn');
  
  if (items.length === 1) {
    removeButtons.forEach(btn => btn.style.display = 'none');
  } else {
    removeButtons.forEach(btn => btn.style.display = 'inline-block');
  }
}

document.addEventListener('DOMContentLoaded', toggleRemoveButtons);
</script>

<?php
if (isset($_POST["submit"])) {
    $sno   = mysqli_real_escape_string($con, $_POST["sno"]);
    $psize = $_POST["psize"] ;
    $tare  = $_POST["tare"] ;
    

        // Convert arrays to comma-separated strings
        $psize_str = implode(';', $psize);
        $tare_str = implode(';', $tare);
        
      
            // INSERT new record
            $q = "INSERT INTO `tblweights` (`size`, `tare`,`sno`) VALUES ('$psize_str', '$tare_str','$sno ')";
      
        $sql = mysqli_query($con, $q);
        
        if ($sql) {
            echo "<script>
                    alert('Record saved successfully!');
                    window.location.href='admin.php?id=weight';
                  </script>";
        } else {
            echo "<div class='alert alert-danger'><strong>Database Error!</strong><br>" . mysqli_error($con) . "</div>";
        }
    
}
?>