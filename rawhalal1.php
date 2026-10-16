<div class="main-content">
    <div class="breadcrumb">

        <ul class="ml-4">
            <li><a href="">Home</a></li>
            <li>Raw Material Management </li>
        </ul>
    </div>
    <style>
        .hidden {
            display: none;
        }
    </style>
    <?php

    ?>
    <div class="container-fluid" style="margin-top:50px;">

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <a href="admin.php?id=addrawmaterial"><button class="btn btn-success"
                            style="float:right; margin-left:15px">Go Back</button></a>

                    <div class="card-title ml-1">Raw material</div>

                    <form class="needs-validation" novalidate="novalidate" method="post" action=""
                        enctype="multipart/form-data">
                        <div class="form-row">


                            <?php
                            $query = "select * from  `tblrawsupplier` order by supname ASC";
                            // $query1="select * from  `basicinfo`";
                            $result = mysqli_query($con, $query);

                            ?>
                            <div class="col-md-6 mb-3">
                                <label for="validationTooltip02">Supplier name</label>
                                <select class="form-control" id="validationTooltip02"
                                    name="supname" required onchange="loadData(this.value)">
                                    <option value="">Select Supplier</option>
                                    <?php while ($row4 = mysqli_fetch_assoc($result)) { ?>
                                        <option value="<?php echo $row4['supid']; ?>"><?php echo $row4['supname']; ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <script>
                                function loadData(ans) {
                                  
                                    const xhr = new XMLHttpRequest();
                                    xhr.open("GET", "rawhalal11.php?sid=" + ans + "", true); // Replace "data.txt" with your actual file or endpoint

                                    xhr.onload = function() {
                                        if (xhr.status === 200) {
                                            document.getElementById("output").innerHTML = xhr.responseText;
                                        } else {
                                            document.getElementById("output").innerHTML = "Error loading data.";
                                        }
                                    };

                                    xhr.send();
                                }
                            </script>
                            <div class="col-md-6 mb-3" id="output">
                               
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationTooltip03">ProductType</label>
                              <select name="type" class="form-control" id="" required>
                                <option>Select Type</option>
                                <option value="Halal">Halal</option>
                                <option value="Kosher">Kosher</option>
                              </select>
                                <div class="invalid-tooltip">
                                    Please fill in this field

                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationTooltip03">Certification Date</label>
                                <input name="cdate" type="date" class="form-control" id="validationTooltip03"
                                    placeholder="" required="required" />
                                <div class="invalid-tooltip">
                                    Please fill in this field

                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationTooltip04">Expiry Date</label>
                                <input class="form-control" id="validationTooltip04" type="date" placeholder=""
                                    name="edate" />
                                <div class="invalid-tooltip">
                                    Please fill the field.

                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationTooltip04">Upload Certificate</label>
                                <input class="form-control" id="validationTooltip04" type="file" placeholder=""
                                    name="img[]" accept=".pdf" multiple />
                                <div class="invalid-tooltip">
                                    Please fill the field.

                                </div>
                            </div>
                        </div>

                        <br>
                        <button class="btn btn-primary"
                            type="submit"
                            name="submit"> Submit </button>
                </div>
                </form>
            </div>
        </div>
    </div>

</div>


<?php

if (isset($_POST['submit'])) {

    $supname = $_POST['supname'];
    $type = $_POST['type'];
    $cdate = $_POST['cdate'];
    $edate = $_POST['edate'];
    $rawname = $_POST['rawname'];
    $user = $_SESSION['user'];

    $targetDir ="rawhalal/";
    $tntimg = "";
    foreach ($_FILES['img']['tmp_name'] as $key => $tmpName) {
				$originalName = $_FILES['img']['name'][$key];
				$fileTmp = $_FILES['img']['tmp_name'][$key];
				$fileExt = pathinfo($originalName, PATHINFO_EXTENSION);
				// Generate a unique name using timestamp and random string
                
                $idt = date('dmyhis');
				$uniqueName =  uniqid('rawhalal_', true).$idt . '.' . $fileExt;
				$targetFile = $targetDir . $uniqueName;

				// Move the file to the target directory
				if (move_uploaded_file($fileTmp, $targetFile)) {
					if (empty($tntimg)) {
						$tntimg = $uniqueName;
					} else {
						$tntimg = $tntimg . ";" . $uniqueName;
					}
				} else {
					echo "Failed to upload: $originalName<br>";
				}
			}
    $query = "INSERT INTO `tblhalal`(`name`, `supname`, `cdate`, `edate`, `type`,`file`, `add_by`) VALUES ('$rawname','$supname','$cdate','$edate','$type','$tntimg','$user')";
    
    $result = mysqli_query($con, $query);
    if ($result) {
        echo "<script>
                                                       
                                                        document.location.href='admin.php?id=rawhalal'
                                                        </script>";
    }

}
?>

