<?php
$sno = isset($_GET["sno"]) ? mysqli_real_escape_string($con, $_GET["sno"]) : '';
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
                <a href="admin.php?id=weight1&sno=<?php echo $sno; ?>">
                    <button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button>
                </a>

                <form class="needs-validation" novalidate method="post" enctype="multipart/form-data" action="">
                    <div class="form-row mt-5">
                        <!-- Product -->
                        <div class="col-md-4 mb-3">
                            <label for="product">Product</label>
                            <input class="form-control" id="product" type="text" name="product" required />
                        </div>

                        <?php
                        $sql = mysqli_query($con, "SELECT * FROM `tblweights` WHERE sno='$sno' ");
                        $data = mysqli_fetch_array($sql);
                        
                        if($data) {
                            $psize = explode(';', $data['size']);
                            $tare = explode(';', $data['tare']);
                            
                            // Create associative array mapping size to tare
                            $size_tare_map = [];
                            for($i = 0; $i < count($psize); $i++) {
                                if(isset($psize[$i]) && isset($tare[$i])) {
                                    $size_tare_map[trim($psize[$i])] = trim($tare[$i]);
                                }
                            }
                        } else {
                            $psize = [];
                            $tare = [];
                            $size_tare_map = [];
                        }
                        ?>

                        <div class="col-md-4 mb-3">
                            <label for="productsize">Product Size (g)</label>
                            <select class="form-control" id="productsize" name="productsize" required>
                                <option value="">Select Size</option>
                                <?php
                                if(!empty($psize)) {
                                    foreach($psize as $size) {
                                        $size = trim($size);
                                        if(!empty($size)) {
                                            echo "<option value='$size' data-tare='" . ($size_tare_map[$size] ?? '') . "'>$size g</option>";
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Time -->
                        <div class="col-md-4 mb-3">
                            <label for="time">Time</label>
                            <input class="form-control" id="time" type="time" name="time" required />
                        </div>

                        <!-- Tare -->
                        <div class="col-md-4 mb-3">
                            <label for="tare">Tare Weight (g) for this product</label>
                            <select class="form-control" id="tare" name="packtare" required>
                                <option value="">Select Tare Weight</option>
                            </select>
                        </div>

                        <!-- Weight Pots -->
                        <div class="col-md-4 mb-3">
                            <label for="pack1">Weight Pot 1 (g)</label>
                            <input class="form-control pack-weight" id="pack1" type="number" step="any" name="pack1" required />
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="pack2">Weight Pot 2 (g)</label>
                            <input class="form-control pack-weight" id="pack2" type="number" step="any" name="pack2" required />
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="pack3">Weight Pot 3 (g)</label>
                            <input class="form-control pack-weight" id="pack3" type="number" step="any" name="pack3" required />
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="pack4">Weight Pot 4 (g)</label>
                            <input class="form-control pack-weight" id="pack4" type="number" step="any" name="pack4" required />
                        </div>

                        <!-- Calculations -->
                        <div class="col-md-4 mb-3">
                            <label for="avgWeight">Average Weight (4 Pots) (g)</label>
                            <input class="form-control" id="avgWeight" type="number" step="any" name="avgWeight" readonly />
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="netWeight">Net Weight (g) = Avg – Tare</label>
                            <input class="form-control" id="netWeight" type="number" step="any" name="netWeight" readonly />
                        </div>
                    </div>

                    <button class="btn btn-primary" type="submit" name="submit">Save & Next</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Store the size-tare mapping in JavaScript
const sizeTareMap = <?php echo json_encode($size_tare_map); ?>;

document.addEventListener("DOMContentLoaded", function() {
    const packInputs = document.querySelectorAll(".pack-weight");
    const avgWeightInput = document.getElementById("avgWeight");
    const netWeightInput = document.getElementById("netWeight");
    const tareInput = document.getElementById("tare");
    const productSizeSelect = document.getElementById("productsize");

    function updateWeights() {
        let total = 0;
        let count = 0;

        packInputs.forEach(input => {
            const value = parseFloat(input.value);
            if (!isNaN(value) && input.value !== '') {
                total += value;
                count++;
            }
        });

        const tare = parseFloat(tareInput.value);

        if (count === packInputs.length && !isNaN(tare) && tareInput.value !== '') {
            const avgWeight = total / count;
            const netWeight = avgWeight - tare;

            avgWeightInput.value = avgWeight.toFixed(2);
            netWeightInput.value = netWeight.toFixed(2);
        } else {
            avgWeightInput.value = "";
            netWeightInput.value = "";
        }
    }

    // Function to update tare dropdown based on selected product size
    function updateTareDropdown() {
        const selectedSize = productSizeSelect.value;
        const tareSelect = document.getElementById("tare");
        
        // Clear existing options
        tareSelect.innerHTML = '<option value="">Select Tare Weight</option>';
        
        if (selectedSize && sizeTareMap[selectedSize]) {
            const tareValue = sizeTareMap[selectedSize];
            const option = document.createElement("option");
            option.value = tareValue;
            option.textContent = tareValue + " g";
            option.selected = true;
            tareSelect.appendChild(option);
            
            // Trigger weight update after tare is set
            updateWeights();
        } else if (selectedSize) {
            // If size exists but no tare mapping, you might want to fetch from database via AJAX
            fetchTareBySize(selectedSize);
        }
    }
    
    // Optional: AJAX function to fetch tare if not available in the map
    function fetchTareBySize(size) {
        fetch('get_tare_by_size.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'sno=<?php echo $sno; ?>&size=' + size
        })
        .then(response => response.json())
        .then(data => {
            if(data.success && data.tare) {
                const tareSelect = document.getElementById("tare");
                tareSelect.innerHTML = '<option value="">Select Tare Weight</option>';
                const option = document.createElement("option");
                option.value = data.tare;
                option.textContent = data.tare + " g";
                option.selected = true;
                tareSelect.appendChild(option);
                updateWeights();
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Add event listener to product size select
    if (productSizeSelect) {
        productSizeSelect.addEventListener("change", updateTareDropdown);
    }

    // Add event listeners for weight calculations
    [...packInputs, tareInput].forEach(input => {
        input.addEventListener("input", updateWeights);
        input.addEventListener("change", updateWeights);
    });
});
</script>

<?php
if (isset($_POST['submit'])) {
    // Escape all inputs to prevent SQL injection
    $product = mysqli_real_escape_string($con, $_POST['product']);
    $time = mysqli_real_escape_string($con, $_POST['time']);
    $packtare = mysqli_real_escape_string($con, $_POST['packtare']);
    $pack1 = mysqli_real_escape_string($con, $_POST['pack1']);
    $pack2 = mysqli_real_escape_string($con, $_POST['pack2']);
    $pack3 = mysqli_real_escape_string($con, $_POST['pack3']);
    $pack4 = mysqli_real_escape_string($con, $_POST['pack4']);
    $avgWeight = mysqli_real_escape_string($con, $_POST['avgWeight']);
    $netWeight = mysqli_real_escape_string($con, $_POST['netWeight']);
    $productsize = mysqli_real_escape_string($con, $_POST['productsize']);
    
    // Generate unique ID
    $rid = date('dmYhis');
    
    // Insert query
    $q = "INSERT INTO `tblweight1` 
          (`sno`, `product`, `time`, `packtare`, `pack1`, `pack2`, `pack3`, `pack4`, `avgweight`, `netweight`, `productsize`, `rid`) 
          VALUES ('$sno','$product','$time','$packtare','$pack1','$pack2','$pack3','$pack4','$avgWeight','$netWeight','$productsize','$rid')";
    
    $sql = mysqli_query($con, $q);
    
    if ($sql) {
        echo '<script>
                alert("Record saved successfully!");
                window.location.href = "admin.php?id=weightsign&rid=' . $rid . '&sno=' . $sno . '";
              </script>';
    } else {
        echo '<div class="alert alert-danger">Database Error: ' . mysqli_error($con) . '</div>';
    }
}
?>