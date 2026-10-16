<?php
if (isset($_POST['submit'])) {


    // Main Supplier Info
    $supplier_name = $_POST['supplier_name'];
    $category = $_POST['category'];
    $mail = $_POST['mail'];
    $contact = $_POST['contact']; // This will be overwritten by the next 'contact' field
    $address = $_POST['address'];
    $stc = $_POST['stc'];

    $adlink = $_POST['adlink'];

    // Technical Contact
    $tname = $_POST['tname'];
    $tmail = $_POST['tmail'];
    $tcontact = $_POST['contact']; // This overwrites $contact above

    // Commercial Contact
    $comname = $_POST['comname'];
    $commail = $_POST['commail'];

    // Other Info
    $risk = 'Pending';
    $type = $_POST['suptype'];



    // BRCGS Certification fields (conditional)
    $dlink = "";
    $dstand = "";
    $dgrade = "";
    $dcat = "";
    $dscope = "";
    $dmodule = "";
    $dbody = "";
    $dpro = "";
    $dexclusion = "";
    $dissue = "";
    $dexp = "";
    $docdate = "";
    $typeq = "";





    $sup = mysqli_query($con, "SELECT * FROM `tblrawsupplier`");
    $supn = mysqli_num_rows($sup);
    $supid = $supn + 1;
    if ($supid < 10) {
        $zer = '0';
    } else {
        $zer = '';
    }
    $pcode = "SUP" . $zer . $supid;


    if ($type == 'Service Supplier' || $type == 'Secondary Packaging Supplier') {
        $approval = $_POST['apvc'];
        $service = $_POST['ser-prov'];

        if (isset($_FILES["apv"])) {
            $customName = $pcode;
            $fileName = "{$customName}." . pathinfo($_FILES["apv"]['name'], PATHINFO_EXTENSION);
            $imagePath = "rmservice/docs/{$fileName}";
            if (!file_exists("rmservice/docs")) {
                mkdir("rmservice/docs", 0777, true);
            }
            if (move_uploaded_file($_FILES["apv"]["tmp_name"], $imagePath)) {
                $signature = $fileName;
            } else {
                $signature = "";
            }
        } else {
            $signature = "";
        }
    } else {
        $approval = $_POST['approval'];
        $service = '';
        if ($approval == 'BRCGS Certification') {

            if (isset($_FILES["dlink"])) {
                $customName = date('Ymdhis');
                $fileName = "{$customName}." . pathinfo($_FILES["dlink"]['name'], PATHINFO_EXTENSION);
                $imagePath = "rmservice/docs/{$fileName}";
                if (!file_exists("rmservice/docs")) {
                    mkdir("rmservice/docs", 0777, true);
                }
                if (move_uploaded_file($_FILES["dlink"]["tmp_name"], $imagePath)) {
                    $dlink = $imagePath;
                } else {
                    $dlink = "";
                }
            } else {
                $dlink = "";
            }

            $dstand = $_POST['dstand'];
            $dgrade = $_POST['dgrade'];
            $dcat = $_POST['dcat'];
            $dscope = $_POST['dscope'];
            $dmodule = $_POST['dmodule'];
            $dbody = $_POST['dbody'];
            $dpro = $_POST['dpro'];
            $dexclusion = $_POST['dexclusion'];
            $dissue = $_POST['dissue'];
            $dexp = $_POST['dexp'];
            $typeq = $_POST['typeq'];
            $signature = "";
        } else {
            $approval = $_POST['approval'];
            $docdate = $_POST['docdate'];
            if (isset($_FILES["doc"])) {
                $customName = $pcode;
                $fileName = "{$customName}." . pathinfo($_FILES["doc"]['name'], PATHINFO_EXTENSION);
                $imagePath = "rmservice/docs/{$fileName}";
                if (!file_exists("rmservice/docs")) {
                    mkdir("rmservice/docs", 0777, true);
                }
                if (move_uploaded_file($_FILES["doc"]["tmp_name"], $imagePath)) {
                    $signature = $fileName;
                } else {
                    $signature = "Error uploading file";
                }
            } else {
                $signature = "";
            }
        }
    }





    $q = "INSERT INTO `tblrawsupplier`(`sagecode`, `supname`, `address`, `contact`, `email`, `category`, `approval`, `risk`, `certificate`, `suptype`, `service`, `tname`, `tcontact`, `tmail`, `coname`, `comail`, `sitecode`, `dlink`, `dstand`, `dgrade`, `dcategory`, `dscope`, `body`, `dpro`, `dex`,`dmod`, `dissue`, `dexpire`, `docdate`, `docq`,`adlink`) VALUES
     ('$pcode','$supplier_name','$address','$contact',' $mail','$category','$approval','$risk','$signature','$type','$service',' $tname','$tcontact','$tmail','$comname','$commail','$stc','$dlink','$dstand','$dgrade','$dcat','$dscope ','$dbody','$dpro','$dexclusion','$dmodule','$dissue','$dexp','$docdate','$typeq','$adlink')";
    //  print_r($q);
    $q1 = mysqli_query($con, $q);

    // echo $pic;
    // die;

    if ($q1) {
        echo "<script>
  document.location.href ='admin.php?id=supplier-management';
  </script>";
    }
}

?>

<div class="row mb-12 ">

    <div class="col-md-12 ">
        <div class="card text-left" style="margin-top:4%;">
            <div class="card-body">

                <a href="admin.php?id=supplier-management"><button class="btn btn-success"
                        style="float:right; margin-left:15px">Go Back</button></a>




                <h4 class="card-title mb-3"></h4>


                <div class="row ml-5">




                    <div id="basket">
                        <form class="needs-validation my-5" novalidate="novalidate" method="post" action=""
                            enctype="multipart/form-data">
                            <div class="form-row">


                                <div class="col-md-12 mb-1 ">
                                    <label for="validationTooltip02"><b>
                                            <h5>Supplier Add</h5>
                                        </b></label><br><br>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Supplier Name</label>

                                    <input type="text" name="supplier_name" class="form-control" required />
                                    <div class="invalid-tooltip">
                                        Please select a supplier
                                    </div>
                                </div>



                                <style>
                                    .hidden {
                                        display: none;
                                    }
                                </style>


                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Category</label>

                                    <select name="category" id="" class="form-control" required>
                                        <option value="">Select Please</option>
                                        <option value="Manufacturer">Manufacturer </option>
                                        <option value="Agent & Broker"> Agent & Broker</option>
                                        <option value="Storage & Distribution">Storage & Distribution </option>
                                        <option value="Service Supplier">Service Supplier</option>


                                    </select>

                                    <div class="invalid-tooltip">
                                        Please fill
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Email</label>

                                    <input type="text" name="mail" class="form-control" />
                                    <div class="invalid-tooltip">
                                        Please select a supplier
                                    </div>
                                </div>


                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Contact No.</label>

                                    <input type="text" name="number" class="form-control" required />
                                    <div class="invalid-tooltip">
                                        Please select a supplier
                                    </div>
                                </div>




                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Address</label>
                                    <textarea name="address" class="form-control" required></textarea>


                                    <!-- <textarea class ></textarea> -->

                                    <div class="invalid-tooltip">
                                        Please fill
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Address Link</label>
                                    <textarea name="adlink" class="form-control"></textarea>

                                    <div class="invalid-tooltip">
                                        Provide Source Link
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <h2>Technical Contact</h2>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Name</label>

                                    <input type="text" name="tname" class="form-control" required />
                                    <div class="invalid-tooltip">
                                        Please select a supplier
                                    </div>
                                </div>


                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Contact No.</label>

                                    <input type="number" name="contact" class="form-control" required />
                                    <div class="invalid-tooltip">
                                        Please select a supplier
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Email</label>

                                    <input type="email" name="tmail" class="form-control" required />
                                    <div class="invalid-tooltip">
                                        Please select a supplier
                                    </div>
                                </div>


                                <div class="col-md-12 mb-3">
                                    <h2>Commerical Contact</h2>
                                </div>


                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Name</label>

                                    <input type="text" name="comname" class="form-control" required />
                                    <div class="invalid-tooltip">
                                        Please select a supplier
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Email</label>

                                    <input type="email" name="commail" class="form-control" required />
                                    <div class="invalid-tooltip">
                                        Please select a supplier
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <h2></h2>
                                </div>


                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Type of Supplier</label>

                                    <!-- <input type="text" name="risk" class="form-control"> -->
                                    <select name="suptype" class="form-control" id="suppliertype" onchange="showDiv()"
                                        required>
                                        <option value="">Select Please</option>
                                        <option value="Raw Material Supplier">Raw Material Supplier</option>
                                        <option value="Service Supplier">Service Supplier</option>
                                        <option value="Primary Packaging Supplier">Primary Packaging Supplier</option>
                                        <option value="Secondary Packaging Supplier">Secondary Packaging Supplier
                                        </option>

                                    </select>
                                    <div class="invalid-tooltip">
                                        Please fill
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3 hidden" id="daprove">
                                    <label for="validationTooltip02">Basis of Approval</label>

                                    <select name="approval" id="aprove" class="form-control" onchange="showHideDiv()">
                                        <option value="">Select Please</option>
                                        <option value="BRCGS Certification">BRCGS Certification or any GFSI Benchmark Certification</option>
                                        <option value="Supplier Site Audit">Supplier Site Audit</option>
                                        <option value="SSAQ">SSAQ</option>
                                         <option value="Reputated Supplier">Reputated Supplier</option>
                                    </select>

                                    <p id="perq" class="text-danger hidden">* Please Select Basis of Approval</p>

                                    <div class="invalid-tooltip">
                                        Please fill
                                    </div>
                                </div>


                                <script>
                                    function showDiv() {
                                        var aprove = document.getElementById('suppliertype');
                                        var show = document.getElementById('daprove');
                                        var show1 = document.getElementById('show');
                                        var show3 = document.getElementById('qshow');
                                        var show4 = document.getElementById('ushow');
                                        var show2 = document.getElementsByClassName('serv');

                                        if (aprove.value == "Service Supplier") {
                                            show.classList.add('hidden');
                                            show1.classList.add('hidden');
                                            show4.classList.add('hidden');


                                            for (var i = 0; i < show2.length; i++) {
                                                show2[i].classList.remove('hidden');
                                            }
                                            document.getElementById('pido').innerHTML = "Service";
                                        } else if (aprove.value == "Secondary Packaging Supplier") {
                                            show.classList.add('hidden');
                                            show1.classList.add('hidden');
                                            show4.classList.add('hidden');
                                            for (var i = 0; i < show2.length; i++) {
                                                show2[i].classList.remove('hidden');
                                            }
                                            document.getElementById('pido').innerHTML = "Product";
                                        } else if (aprove.value == "Raw Material Supplier") {
                                            for (var i = 0; i < show2.length; i++) {
                                                show2[i].classList.add('hidden');
                                            }
                                            show.classList.remove('hidden');
                                            show1.classList.add('hidden');


                                        } else if (aprove.value == "Primary Packaging Supplier") {
                                            for (var i = 0; i < show2.length; i++) {
                                                show2[i].classList.add('hidden');
                                            }
                                            show.classList.remove('hidden');
                                            show1.classList.add('hidden');
                                        } else {
                                            show.classList.add('hidden');
                                            show.classList.add('hidden');
                                            for (var i = 0; i < show2.length; i++) {
                                                show2[i].classList.add('hidden');
                                            }
                                        }
                                    }
                                </script>



                                <div class="col-md-6 mb-3 hidden serv">
                                    <label for="validationTooltip02"><span id='pido'></span> Provided</label>
                                    <input type="text" name="ser-prov" class="form-control">
                                    <div class="invalid-tooltip">
                                        Please fill
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3 hidden serv">
                                    <label for="validationTooltip02">Aproval Criteria</label>
                                    <input type="text" name="apvc" class="form-control">
                                    <div class="invalid-tooltip">
                                        Please fill
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3 hidden serv">
                                    <label for="validationTooltip02">Upload Aproval Supporting Document</label>
                                    <input type="file" name="apv" class="form-control" accept=".jpg, .jpeg, .png, .pdf">
                                    <div class="invalid-tooltip">
                                        Please fill
                                    </div>
                                </div>







                                <script>
                                    function showHideDiv() {
                                        var aprove = document.getElementById('aprove');
                                        var qshow = document.getElementById('qshow');
                                        var ushow = document.getElementById('ushow');
                                        var show = document.getElementById('show');
                                        const perq = document.getElementById('perq');
                                        const nameq = document.getElementsByName('typeq');
                                        perq.classList.add('hidden');

                                        if (aprove.value == "BRCGS Certification") {
                                            qshow.classList.remove('hidden');
                                            ushow.classList.add('hidden');
                                            nameq.forEach(el => el.removeAttribute('disabled', true));
                                        } else {
                                            qshow.classList.add('hidden');
                                            ushow.classList.remove('hidden');
                                            show.classList.add('hidden');
                                        }
                                    }
                                </script>

                                <div class="col-md-12 mb-3 hidden " id="qshow">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationTooltip02" class="h3">Are the raw material supplied by the supplier covered under the scope?</label>

                                            <input type="radio" name="typeq" value="Yes" onchange="showHideques('Yes')"> Yes
                                            <input type="radio" name="typeq" value="No" onchange="showHideques('No')"> No
                                            <div class="invalid-tooltip">
                                                Please select a supplier
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <script>
                                    function showHideques(qn) {
                                        const perq = document.getElementById('perq');
                                        const aprove = document.getElementById('aprove');
                                        const show = document.getElementById('show');
                                        const nameq = document.getElementsByName('typeq');

                                        if (qn == 'Yes') {
                                            show.classList.remove('hidden');
                                            perq.classList.add('hidden');
                                        } else {
                                            show.classList.add('hidden');
                                            perq.classList.remove('hidden');
                                            nameq.forEach(el => el.setAttribute('disabled', true));
                                            aprove.value = '';
                                        }
                                    }
                                </script>


                                <div class="col-md-12 mb-3 hidden" id="show">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationTooltip02">Upload Certificate</label>

                                            <input type="file" name="dlink" class="form-control" />
                                            <div class="invalid-tooltip">
                                                Provide Certificate
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationTooltip02">Sitecode</label>

                                            <input type="text" name="stc" class="form-control" />
                                            <div class="invalid-tooltip">
                                                Please select a supplier
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationTooltip02">Standard</label>

                                            <input type="text" name="dstand" class="form-control" />
                                            <div class="invalid-tooltip">
                                                Enter Standard
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationTooltip02">Grade</label>

                                            <input type="text" name="dgrade" class="form-control" />
                                            <div class="invalid-tooltip">
                                                Please select a supplier
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationTooltip02">Category</label>

                                            <input type="text" name="dcat" class="form-control" />
                                            <div class="invalid-tooltip">
                                                Please select a supplier
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationTooltip02">Scope</label>

                                            <input type="text" name="dscope" class="form-control" />
                                            <div class="invalid-tooltip">
                                                Please select a supplier
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationTooltip02">Additional Module</label>

                                            <input type="text" name="dmodule" class="form-control" />
                                            <div class="invalid-tooltip">
                                                Please select a supplier
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationTooltip02">Issue Date</label>

                                            <input type="date" name="dissue" class="form-control" />
                                            <div class="invalid-tooltip">
                                                Please select a supplier
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationTooltip02">Expiry Date</label>

                                            <input type="date" name="dexp" class="form-control" />
                                            <div class="invalid-tooltip">
                                                Please select a supplier
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationTooltip02">Certification Body</label>

                                            <input type="text" name="dbody" class="form-control" />
                                            <div class="invalid-tooltip">
                                                Please select a supplier
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationTooltip02">Audit Programme</label>
                                            <select name="dpro" id="" class="form-control">
                                                <option value="">-- Select Audit Programme --</option>
                                                <option value="Announced">Announced</option>
                                                <option value="Unannounced">Unannounced</option>
                                            </select>

                                            <div class="invalid-tooltip">
                                                Please select a supplier
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationTooltip02">Exclusion</label>

                                            <input type="text" name="dexclusion" class="form-control" />
                                            <div class="invalid-tooltip">
                                                Please select a supplier
                                            </div>
                                        </div>




                                    </div>

                                </div>
                                <div class="col-md-12 hidden mb-5 " id="ushow">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="validationTooltip02">Add Document</label>

                                            <!-- <input type="text" name="risk" class="form-control"> -->
                                            <input type="file" name="doc" class="form-control" accept=".jpg, .jpeg, .png, .pdf">


                                        </div>
                                        <div class="col-md-6">

                                            <label for="validationTooltip02">Date</label>

                                            <!-- <input type="text" name="risk" class="form-control"> -->
                                            <input type="date" name="docdate" class="form-control">

                                        </div>
                                    </div>

                                </div>



                            </div>

                            <button class="btn btn-primary btn-lg" type="submit" name="submit">Submit </button>
                        </form>
                    </div>
                </div>





            </div>
        </div>
    </div>
</div>