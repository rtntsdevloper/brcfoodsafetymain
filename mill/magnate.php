
<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>Millers Magnet Cleaning</li>
        </ul>
    </div>


    <div class="col-md-12 mt-3">

        <div class="card mb-4 p-3 ">
            <center>
                <table border="1" style="width: 100%; text-align:center;">
                    <tr>
                        <th>Magnet Name</th>
                        <th>Frequency</th>
                        <th>Monday</th>
                        <th>Tuesday</th>
                        <th>Wednesday</th>
                        <th>Thursday</th>
                        <th>Friday</th>
                    </tr>
                    <tr style="text-align: center;">
                        <th>Intake Pit Magnet</th>
                        <th>Daily</th>
                        <td><img src="mill/sign/download.jpg" alt="" height="20" width="25"></td>
                        <td><img src="mill/sign/download.jpg" alt="" height="20" width="25"></td>
                        <td><img src="mill/sign/download.jpg" alt="" height="20" width="25"></td>
                        <td><img src="mill/sign/download.jpg" alt="" height="20" width="25"></td>
                        <td><img src="mill/sign/download.jpg" alt="" height="20" width="25"></td>
                    </tr>

                    <tr style="text-align: center;">
                        <th>Screen Room Magnet</th>
                        <th>Once in Week</th>
                        <td><img src="mill/sign/download.jpg" alt="" height="20" width="25"></td>
                        <td><img src="mill/sign/false.jpg" alt="" height="15" width="18"></td>
                        <td><img src="mill/sign/false.jpg" alt="" height="15" width="18"></td>
                        <td><img src="mill/sign/false.jpg" alt="" height="15" width="18"></td>
                        <td><img src="mill/sign/false.jpg" alt="" height="15" width="18"></td>
                    </tr>

                    <tr style="text-align: center;">
                        <th>Wheatfeed Magnet</th>
                        <th>Once in Week</th>
                        <td><img src="mill/sign/download.jpg" alt="" height="20" width="25"></td>
                        <td><img src="mill/sign/false.jpg" alt="" height="15" width="18"></td>
                        <td><img src="mill/sign/false.jpg" alt="" height="15" width="18"></td>
                        <td><img src="mill/sign/false.jpg" alt="" height="15" width="18"></td>
                        <td><img src="mill/sign/false.jpg" alt="" height="15" width="18"></td>
                    </tr>

                    <tr style="text-align: center;">
                        <th>First Break Magnet</th>
                        <th>Once in Week</th>
                        <td><img src="mill/sign/download.jpg" alt="" height="20" width="25"></td>
                        <td><img src="mill/sign/false.jpg" alt="" height="15" width="18"></td>
                        <td><img src="mill/sign/false.jpg" alt="" height="15" width="18"></td>
                        <td><img src="mill/sign/false.jpg" alt="" height="15" width="18"></td>
                        <td><img src="mill/sign/false.jpg" alt="" height="15" width="18"></td>
                    </tr>

                    <tr style="text-align: center;">
                        <th>Scourer Magnet</th>
                        <th>Once in Week</th>
                        <td><img src="mill/sign/download.jpg" alt="" height="20" width="25"></td>
                        <td><img src="mill/sign/false.jpg" alt="" height="15" width="18"></td>
                        <td><img src="mill/sign/false.jpg" alt="" height="15" width="18"></td>
                        <td><img src="mill/sign/false.jpg" alt="" height="15" width="18"></td>
                        <td><img src="mill/sign/false.jpg" alt="" height="15" width="18"></td>
                    </tr>
                </table>
            </center>

        </div>
        <div class="card">
            <div class="card-body">
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem;">
                    <h3 style="margin:0;">Millers Magnet Cleaning</h3>
                    <a href="admin.php?id=magnate1" class="btn btn-success">Go Back</a>
                </div>

                <form class="needs-validation" novalidate method="post" enctype="multipart/form-data" action="">
                    <div class="form-row mt-5">
                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip01">Date</label>
                            <input class="form-control" id="validationTooltip01" type="date" required name="date" />
                            <div class="invalid-tooltip">Please provide a valid date.</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip03">Carried Out By</label>
                            <input type="text" class="form-control" name="carried" required>
                            <div class="invalid-tooltip">Please fill the field.</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip02">Select Magnet</label>
                            <select name="magnet[]" class="form-control" required>
                                <option value="">Please Select</option>
                                <option value="Intake Pit Magnet">Intake Pit Magnet</option>
                                <option value="Screen Room Magnet">Screen Room Magnet</option>
                                <option value="Wheatfeed Magnet">Wheatfeed Magnet</option>
                                <option value="First Break Magnet">First Break Magnet</option>
                                <option value="Scourer Magnet">Scourer Magnet</option>
                            </select>
                            <div class="invalid-tooltip">Please fill the field.</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="findings">Any Findings</label>
                            <select name="findings[]" class="form-control" id="findings1" onchange="checkfindings(this.value,0)" required>
                                <option value="">Please Select</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                            <div class="invalid-tooltip">Please fill the field.</div>
                        </div>

                        <div class="col-md-6 mb-3" id="reportedToField0" style="display:none;">
                            <label for="report0">Reported To</label>
                            <input type="text" class="form-control" name="report[]" id="report0">
                            <div class="invalid-tooltip">Please fill the field.</div>
                        </div>

                        <div class="col-md-12 mb-3" id="correctiveField0" style="display:none;">
                            <label for="corrective">Corrective Actions</label>
                            <textarea name="corrective[]" id="corrective0" class="form-control"></textarea>
                            <div class="invalid-tooltip">Please fill the field.</div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <button type="button" class="btn btn-primary" onclick="addNewContainer()">Add Another Machine</button>
                        </div>

                        <div class="col-md-12">
                            <div id="containers-wrapper"></div>
                        </div>

                        <div class="col-md-12">
                            <button class="btn btn-primary" type="submit" name="submit">Save & Next</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <script>
            let containerCount = 0;

            function addNewContainer() {
                containerCount++;

                const containerDiv = document.createElement('div');
                containerDiv.className = 'container-fluid new-container mb-3';
                containerDiv.id = `container-${containerCount}`;
                containerDiv.style.borderTop = '1px solid #ddd';
                containerDiv.style.paddingTop = '15px';
                containerDiv.style.marginTop = '15px';

                containerDiv.innerHTML = `
            <h6 class="text-muted">Magnet #${containerCount+1}</h6>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                       
                    <label for="validationTooltip02">Select Magnet</label>
                    <select name="magnet[]" class="form-control" required>
                        <option value="">Please Select</option>
                        <option value="Intake Pit Magnet">Intake Pit Magnet</option>
                        <option value="Screen Room Magnet">Screen Room Magnet</option>
                        <option value="Wheatfeed Magnet">Wheatfeed Magnet</option>
                        <option value="First Break Magnet">First Break Magnet</option>
                        <option value="Scourer Magnet">Scourer Magnet</option>
                    </select>
                    <div class="invalid-tooltip">Please fill the field.</div>
                </div>
                </div>
                   
              <div class="col-md-6 mb-3">
                            <label for="findings">Any Findings</label>
                            <select name="findings[]" class="form-control" id="findings" required onchange="checkfindings(this.value,${containerCount})">
                                <option value="">Please Select</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                            <div class="invalid-tooltip">Please fill the field.</div>
                        </div>
                <div class="col-md-6 mb-3" id="reportedToField${containerCount}" style="display:none;">
                            <label for="report${containerCount}">Reported To</label>
                            <input type="text" class="form-control" name="report[]" id="report${containerCount}">
                            <div class="invalid-tooltip">Please fill the field.</div>
                        </div>

                        <div class="col-md-12 mb-3" id="correctiveField${containerCount}" style="display:none;">
                            <label for="corrective${containerCount}">Corrective Actions</label>
                            <textarea name="corrective[]" id="corrective${containerCount}" class="form-control"></textarea>
                            <div class="invalid-tooltip">Please fill the field.</div>
                        </div>
                <div class="col-md-12">
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeContainer(this)">Remove</button>
                </div>
            </div>
        `;

                document.getElementById('containers-wrapper').appendChild(containerDiv);
            }

            function removeContainer(button) {
                const container = button.closest('.new-container');
                if (container && confirm('Remove this machine?')) {
                    container.remove();
                    renumberContainers();
                }
            }

            function renumberContainers() {
                const containers = document.querySelectorAll('#containers-wrapper .new-container');
                containers.forEach((container, index) => {
                    const newNumber = index + 1;
                    const header = container.querySelector('h6');
                    if (header) header.textContent = `Magnet #${newNumber}`;
                    container.id = `container-${newNumber}`;
                });
                containerCount = containers.length;
            }

            function checkfindings(value, containerCount) {

                const reportedTo = document.getElementById("reportedToField" + containerCount);
                const corrective = document.getElementById("correctiveField" + containerCount);
                const reportInput = document.getElementById("report" + containerCount);
                const correctiveInput = document.getElementById("corrective" + containerCount);

                if (value === "yes") {
                    reportedTo.style.display = "block";
                    corrective.style.display = "block";
                    reportInput.value = "";
                    correctiveInput.value = "";
                } else if (value === "no") {
                    reportedTo.style.display = "none";
                    corrective.style.display = "none";
                    reportInput.value = "";
                    correctiveInput.value = "";
                }

            };
        </script>
        <?php

        if (isset($_POST['submit'])) {

            $date = $_POST['date'];
            $five = $_POST['carried'];
            
            $free = '';



            $product = $_POST['magnet'];
            print_r($product);
            foreach ($product as $p => $pvalue) {
                $three = $_POST['findings'][$p];
                $two = $_POST['report'][$p];
                $name = $_POST['corrective'][$p];
                $sql = "INSERT INTO tblmagnate (date, magnet, findings, report, carried, corrective) VALUES('$date', '$pvalue', '$three', '$two', '$five', '$name')";
                $sql1 = mysqli_query($con, $sql);
            }
            if ($sql1) {

                echo "<script>window.location.href='admin.php?id=magnate1';</script>";
            } else {
                echo "<script>alert('Error adding record: " . mysqli_error($con) . "');</script>";
            }
        }


        ?>