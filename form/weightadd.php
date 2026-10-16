<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Daily Weight Check Records</a></li>
            <li>Add</li>
        </ul>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=weight">
                    <button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button>
                </a>

                <div class="card-title">Daily Weight Check Records</div>

                <form class="needs-validation" novalidate method="post" action="" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="date">Date</label>
                            <input class="form-control" id="date" type="date" required name="date" />
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="bestdate">Best before date</label>
                            <input class="form-control" id="bestdate" type="date" required name="bestdate" />
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="batchno">Batch No</label>
                            <input class="form-control" id="batchno" type="text" placeholder="enter batch number" required name="batchno" />
                        </div>

                        <div class="col-md-12">
                            <label>Product Details</label>
                            <div id="product-list">
                                <div class="row mb-2 product-item">
                                    <div class="col-md-5">
                                        <Label>Product Size</Label>
                                        <select class="form-control size-input">
                                            <option value="">Select Size</option>
                                            <option value="400g">400g</option>
                                            <option value="450g">450g</option>
                                            <option value="1000g">1,000g</option>
                                            <option value="2000g">2,000g</option>
                                            <option value="4600g">4,600g</option>
                                            <option value="5000g">5,000g</option>
                                            <option value="10000g">10,000g</option>
                                        </select>
                                    </div>
                                    <div class="col-md-5">
                                        <Label>Filling Machine</Label>

                                        <input type="text" class="form-control machine-input" placeholder="Filling Machine" />
                                    </div>
                                    <div class="col-md-2">
                                        <br>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="removeProduct(this)">Remove</button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-info btn-sm mt-2" onclick="addProduct()">+ Add More</button>
                        </div>


                        <div class="col-md-4 mb-3 mt-4">
                            <label for="date">Weight Scale Calibration </label>
                            <input class="form-control" type="text" placeholder="enter weight scale" required name="scale" />
                        </div>

                        <div class="col-md-4 mb-3 mt-4">
                            <label for="bestdate">Pass/Fail</label>
                            <select name="pass_fail" class="form-control" required>
                                <option value="" disabled selected>Select</option>
                                <option value="Pass">Pass</option>
                                <option value="Fail">Fail</option>
                            </select>
                        </div>


                        <div class="col-md-4 mb-3 mt-4">
                            <label for="date">Action </label>
                            <textarea name="action" class="form-control"></textarea>
                        </div>
                    </div>




                    <button class="btn btn-primary mt-3" type="submit" name="submit">Submit</button>
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
    <div class="col-md-5">
      <select class="form-control size-input">
        <option value="">Select Size</option>
        <option value="400g">400g</option>
        <option value="450g">450g</option>
        <option value="1000g">1,000g</option>
        <option value="2000g">2,000g</option>
        <option value="4600g">4,600g</option>
        <option value="5000g">5,000g</option>
        <option value="10000g">10,000g</option>
      </select>
    </div>
    <div class="col-md-5">
      <input type="text" class="form-control machine-input" placeholder="Filling Machine" />
    </div>
    <div class="col-md-2">
      <button type="button" class="btn btn-danger btn-sm" onclick="removeProduct(this)">Remove</button>
    </div>
  `;
        container.appendChild(newRow);
    }

    function removeProduct(btn) {
        const container = document.getElementById('product-list');
        if (container.children.length > 1) {
            btn.closest('.product-item').remove();
        } else {
            alert("At least one product is required!");
        }
    }

    document.querySelector('form').addEventListener('submit', function(e) {
        const sizes = [];
        const machines = [];

        document.querySelectorAll('.size-input').forEach(select => {
            if (select.value.trim()) sizes.push(select.value.trim());
        });

        document.querySelectorAll('.machine-input').forEach(input => {
            if (input.value.trim()) machines.push(input.value.trim());
        });

        if (sizes.length === 0 || machines.length === 0) {
            e.preventDefault();
            alert('Please add at least one product size and filling machine!');
            return;
        }

        if (sizes.length !== machines.length) {
            e.preventDefault();
            alert('Number of sizes and machines must match!');
            return;
        }

        const psizeHidden = document.createElement('input');
        psizeHidden.type = 'hidden';
        psizeHidden.name = 'psize';
        psizeHidden.value = sizes.join(';');

        const fillingHidden = document.createElement('input');
        fillingHidden.type = 'hidden';
        fillingHidden.name = 'filling';
        fillingHidden.value = machines.join(';');

        this.appendChild(psizeHidden);
        this.appendChild(fillingHidden);
    });
</script>

<?php
if (isset($_POST["submit"])) {
    $date     = mysqli_real_escape_string($con, $_POST["date"]);
    $bestdate = mysqli_real_escape_string($con, $_POST["bestdate"]);
    $batchno  = mysqli_real_escape_string($con, $_POST["batchno"]);
    $psize    = mysqli_real_escape_string($con, $_POST["psize"]);
    $filling  = mysqli_real_escape_string($con, $_POST["filling"]);

    $scale  = mysqli_real_escape_string($con, $_POST["scale"]);
    $pass_fail  = mysqli_real_escape_string($con, $_POST["pass_fail"]);
    $action  = mysqli_real_escape_string($con, $_POST["action"]);


    $q = "INSERT INTO `tblweight` (date, bestdate, batch, psize, filling,`scale`,`pass_fail`,`action`) 
          VALUES ('$date', '$bestdate', '$batchno', '$psize', '$filling','$scale','$pass_fail','$action')";
    $sql = mysqli_query($con, $q);

    if ($sql) {
        echo "<script>window.location.href='admin.php?id=weight';</script>";
    } else {
        echo "<div class='alert alert-danger'><strong>Database Error!</strong><br>" . mysqli_error($con) . "</div>";
    }
}
?>