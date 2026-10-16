<?php
$id = $_GET['view'];
$sup = mysqli_query($con, "SELECT * FROM `tblrawsupplier` Where supid = $id");
$sup1 = mysqli_fetch_array($sup);
$spid = $sup1['supid'];





?>

<div class="row mb-12 ">
    <div class="col-md-12 ">
        <div class="card text-left" style="margin-top:3%;">
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
                                            <h5>Supplier Edit</h5>
                                        </b></label><br><br>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Supplier Name</label>

                                    <input type="text" name="supplier_name" class="form-control"
                                        value="<?php echo $sup1['supname']; ?>" required />
                                    <div class="invalid-tooltip">
                                        Please fill
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Category</label>

                                    <select name="category" id="" class="form-control">
                                        <option value="<?php echo $sup1['category']; ?>">
                                            <?php echo $sup1['category']; ?>
                                        </option>
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

                                    <input type="email" name="mail" class="form-control"
                                        value="<?php echo $sup1['email']; ?>" />
                                    <div class="invalid-tooltip">
                                        Please fill email
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Contact No.</label>

                                    <input type="text" name="number" class="form-control"
                                        value="<?php echo $sup1['contact']; ?>" />
                                    <div class="invalid-tooltip">
                                        Please fill
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Address</label>
                                    <textarea name="address"
                                        class="form-control"><?php echo $sup1['address']; ?></textarea>


                                    <!-- <textarea class ></textarea> -->

                                    <div class="invalid-tooltip">
                                        Please fill
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Map Link</label>
                                    <textarea name="adlink" class="form-control"><?php if (isset($sup1['adlink'])) {
                                                                                        echo $sup1['adlink'];
                                                                                    }; ?></textarea>

                                    <div class="invalid-tooltip">
                                        Please fill url here
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <h2>Technical Contact</h2>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Name</label>

                                    <input type="text" name="tname" class="form-control"
                                        value="<?php echo $sup1['tname']; ?>" />
                                    <div class="invalid-tooltip">
                                        Please select a supplier
                                    </div>
                                </div>


                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Contact No.</label>

                                    <input type="number" name="contact" class="form-control"
                                        value="<?php echo $sup1['tcontact']; ?>" />
                                    <div class="invalid-tooltip">
                                        Please select a supplier
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Email</label>

                                    <input type="email" name="tmail" class="form-control"
                                        value="<?php echo $sup1['tmail']; ?>" />
                                    <div class="invalid-tooltip">
                                        Please select a supplier
                                    </div>
                                </div>


                                <div class="col-md-12 mb-3">
                                    <h2>Commerical Contact</h2>
                                </div>


                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Name</label>

                                    <input type="text" name="comname" class="form-control"
                                        value="<?php echo $sup1['coname']; ?>" />
                                    <div class="invalid-tooltip">
                                        Please select a supplier
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Email</label>

                                    <input type="email" name="commail" class="form-control"
                                        value="<?php echo $sup1['comail']; ?>" />
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
                                        <option value="<?php echo $sup1['suptype']; ?>"><?php echo $sup1['suptype']; ?>
                                        </option>
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
                                <div class="col-md-6 mb-3  <?php
                                                            if ($sup1['suptype'] == 'Primary Packaging Supplier') {
                                                                echo '';
                                                            } elseif ($sup1['suptype'] == 'Raw Material Supplier') {
                                                                echo '';
                                                            } else {
                                                                echo 'hidden';
                                                            }
                                                            ?>" id="daprove">

                                    <label for="validationTooltip02">Basis of Approval</label>
                                    <select name="approval" id="aprove" class="form-control" required
                                        onchange="showHideDiv()">
                                        <option value="<?php echo $sup1['approval']; ?>">
                                            <?php echo $sup1['approval']; ?>
                                        </option>
                                        <option value="BRCGS Certification">BRCGS Certification</option>
                                        <option value="Supplier Site Audit">Supplier Site Audit</option>
                                        <option value="SSAQ">SSAQ</option>
                                    </select>
                                    <p id="perq" class="text-danger hidden">* Please Select Basis of Approval</p>

                                    <div class="invalid-tooltip">
                                        Please fill
                                    </div>

                                </div>


                                <style>
                                    .hidden {
                                        display: none;
                                    }
                                </style>
                                <script>
                                    function showDiv() {
                                        var aprove = document.getElementById('suppliertype');
                                        var show = document.getElementById('daprove');
                                        var show1 = document.getElementById('show')
                                        var show2 = document.getElementsByClassName('serv');

                                        if (aprove.value == "Service Supplier") {
                                            show.classList.add('hidden');
                                            show1.classList.add('hidden');
                                            for (var i = 0; i < show2.length; i++) {
                                                show2[i].classList.remove('hidden');
                                            }
                                            document.getElementById('pido').innerHTML = "Service";
                                        } else if (aprove.value == "Secondary Packaging Supplier") {
                                            show.classList.add('hidden');
                                            show1.classList.add('hidden');
                                            for (var i = 0; i < show2.length; i++) {
                                                show2[i].classList.remove('hidden');
                                            }
                                            document.getElementById('pido').innerHTML = "Product";
                                        } else if (aprove.value == "Raw Material Supplier") {
                                            for (var i = 0; i < show2.length; i++) {
                                                show2[i].classList.add('hidden');
                                            }
                                            show.classList.remove('hidden');
                                            show1.classList.remove('hidden');


                                        } else if (aprove.value == "Primary Packaging Supplier") {
                                            for (var i = 0; i < show2.length; i++) {
                                                show2[i].classList.add('hidden');
                                            }
                                            show.classList.remove('hidden');
                                            show1.classList.remove('hidden');
                                        } else {
                                            show.classList.add('hidden');
                                            show.classList.add('hidden');
                                            for (var i = 0; i < show2.length; i++) {
                                                show2[i].classList.add('hidden');
                                            }
                                        }
                                    }
                                </script>




                                <div class="col-md-6 mb-3  serv  <?php
                                                                    if ($sup1['suptype'] == 'Service Supplier') {
                                                                        echo '';
                                                                    } else if ($sup1['suptype'] == 'Secondary Packaging Supplier') {
                                                                        echo '';
                                                                    } else {
                                                                        echo 'hidden';
                                                                    } ?>">
                                    <label for="validationTooltip02"><span id="pido"></span> Provided</label>
                                    <input type="text" name="ser-prov" class="form-control"
                                        value="<?php echo $sup1['service']; ?>">
                                    <div class="invalid-tooltip">
                                        Please fill
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3  serv <?php
                                                                if ($sup1['suptype'] == 'Service Supplier') {
                                                                    echo '';
                                                                } else if ($sup1['suptype'] == 'Secondary Packaging Supplier') {
                                                                    echo '';
                                                                } else {
                                                                    echo 'hidden';
                                                                } ?>">
                                    <label for="validationTooltip02">Aproval Criteria</label>
                                    <input type="text" name="apvc" class="form-control"
                                        value="<?php echo $sup1['approval']; ?>">
                                    <div class="invalid-tooltip">
                                        Please fill
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3  serv <?php if ($sup1['suptype'] == 'Service Supplier') {
                                                                    echo '';
                                                                } elseif ($sup1['suptype'] == 'Secondary Packaging Supplier') {
                                                                    echo '';
                                                                } else {
                                                                    echo 'hidden';
                                                                }
                                                                ?>">
                                    <label for="validationTooltip02">Upload Aproval Supporting
                                        Document</label><?php if (!empty($sup1['certificate'])) { ?><a href="rmservice/docs/<?php
                                                                                                                            echo $sup1['certificate'];

                                                                                                                            ?>" class="ml-3" target="_blank">View Document</a><?php } ?>
                                    <input type="file" name="apv" class="form-control">
                                    <div class="invalid-tooltip">
                                        Please fill
                                    </div>
                                </div>
                                <?php


                                ?>







                                <script>
                                    function showHideDiv() {
                                        var aprove = document.getElementById('aprove');
                                        var qshow = document.getElementById('qshow');
                                        var ushow = document.getElementById('ushow');
                                        var show = document.getElementById('show');
                                        const perq = document.getElementById('perq');
                                        perq.classList.add('hidden');

                                        if (aprove.value == "BRCGS Certification") {
                                            qshow.classList.remove('hidden');
                                            ushow.classList.add('hidden');
                                        } else {
                                            qshow.classList.add('hidden');
                                            ushow.classList.remove('hidden');
                                            show.classList.add('hidden');
                                        }
                                    }
                                </script>

                                <div class="col-md-12 mb-3  <?php

                                                            if ($sup1['suptype'] == 'Primary Packaging Supplier' && $sup1['approval'] == 'BRCGS Certification') {
                                                                echo '';
                                                            } elseif ($sup1['suptype'] == 'Raw Material Supplier' && $sup1['approval'] == 'BRCGS Certification') {
                                                                echo '';
                                                            } else {
                                                                echo 'hidden';
                                                            }
                                                            ?>" id="qshow">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationTooltip02" class="h3">Are the raw material supplied by the supplier covered under the scope?</label>

                                            <input type="radio" name="typeq" value="Yes" onchange="showHideques('Yes')" <?php if ($sup1['docq'] == 'Yes') {
                                                                                                                            echo 'checked';
                                                                                                                        } ?>> Yes
                                            <input type="radio" name="typeq" value="No" onchange="showHideques('No')" <?php if ($sup1['docq'] == 'No') {
                                                                                                                            echo 'checked';
                                                                                                                        } ?>> No
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

                                        if (qn == 'Yes') {
                                            show.classList.remove('hidden');
                                            perq.classList.add('hidden');
                                        } else {
                                            show.classList.add('hidden');
                                            perq.classList.remove('hidden');
                                            aprove.value = '';
                                        }
                                    }
                                </script>

                                <div class="col-md-12 mb-3 <?php

                                                            if ($sup1['suptype'] == 'Primary Packaging Supplier' && $sup1['approval'] == 'BRCGS Certification') {
                                                                echo '';
                                                            } elseif ($sup1['suptype'] == 'Raw Material Supplier' && $sup1['approval'] == 'BRCGS Certification') {
                                                                echo '';
                                                            } else {
                                                                echo 'hidden';
                                                            }






                                                            ?>" id="show">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationTooltip02">Upload Document</label> <?php if (!empty($sup1['dlink'])) {
                                                                                                            echo '<a href="' . $sup1['dlink'] . '" target="_blank">Document link</a>';
                                                                                                        } ?>

                                            <input type="file" name="dlink" class="form-control" />
                                            <div class="invalid-tooltip">
                                                Please fill url here
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationTooltip02">Sitecode</label>

                                            <input type="text" name="stc" class="form-control"
                                                value="<?php echo $sup1['sitecode']; ?>" />
                                            <div class="invalid-tooltip">
                                                Enter site code
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationTooltip02">Standard</label>

                                            <input type="text" name="dstand" class="form-control"
                                                value="<?php echo $sup1['dstand']; ?>" />
                                            <div class="invalid-tooltip">
                                                Please fill
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationTooltip02">Grade</label>

                                            <input type="text" name="dgrade" class="form-control"
                                                value="<?php echo $sup1['dgrade']; ?>" />
                                            <div class="invalid-tooltip">
                                                Please fill
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationTooltip02">Category</label>

                                            <input type="text" name="dcat" class="form-control"
                                                value="<?php echo $sup1['dcategory']; ?>" />
                                            <div class="invalid-tooltip">
                                                Please fill
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationTooltip02">Scope</label>

                                            <input type="text" name="dscope" class="form-control"
                                                value="<?php echo $sup1['dscope']; ?>" />
                                            <div class="invalid-tooltip">
                                                Please fill
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationTooltip02">Additional Module</label>

                                            <input type="text" name="dmodule" class="form-control"
                                                value="<?php echo $sup1['dmod']; ?>" />
                                            <div class="invalid-tooltip">
                                                Please fill
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationTooltip02">Certification Body</label>

                                            <input type="text" name="dbody" class="form-control"
                                                value="<?php echo $sup1['body']; ?>" />
                                            <div class="invalid-tooltip">
                                                Please fill
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationTooltip02">Issue Date</label>

                                            <input type="date" name="dissue" class="form-control" value="<?php
                                                                                                            if (!empty($sup1['dissue'])) {
                                                                                                                echo date('Y-m-d', strtotime($sup1['dissue']));
                                                                                                            } ?>" />
                                            <div class="invalid-tooltip">
                                                Please fill
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationTooltip02">Expiry Date</label>

                                            <input type="date" name="dexp" class="form-control" value="
                                            <?php
                                            if (!empty($sup1['dexpire'])) {
                                                echo date('Y-m-d', strtotime($sup1['dexpire']));
                                            } ?>
                                            " />
                                            <div class="invalid-tooltip">
                                                Please fill
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationTooltip02">Audit Programme</label>
                                            <select name="dpro" id="" class="form-control">
                                                <option value="">-- Select Audit Programme --</option>
                                                <option value="Announced" <?php if ($sup1['dpro'] == 'Announced') {
                                                                                echo 'selected';
                                                                            } ?>>Announced</option>
                                                <option value="Unannounced" <?php if ($sup1['dpro'] == 'Unannounced') {
                                                                                echo 'selected';
                                                                            } ?>>Unannounced</option>
                                            </select>

                                            <div class="invalid-tooltip">
                                                Please select a supplier
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationTooltip02">Exclusion</label>

                                            <input type="text" name="dexclusion" class="form-control"
                                                value="<?php echo $sup1['dex']; ?>" />
                                            <div class="invalid-tooltip">
                                                Please fill
                                            </div>
                                        </div>


                                    </div>
                                </div>

                                <div class="col-md-12 mb-3 <?php if ($sup1['suptype'] == 'Primary Packaging Supplier' && $sup1['approval'] != 'BRCGS Certification') {
                                                                echo '';
                                                            } elseif ($sup1['suptype'] == 'Raw Material Supplier' && $sup1['approval'] != 'BRCGS Certification') {
                                                                echo '';
                                                            } else {
                                                                echo 'hidden';
                                                            } ?>" id="ushow">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="validationTooltip02">Add
                                                Document</label><?php if (!empty($sup1['certificate'])) { ?><a
                                                    href="rmservice/docs/<?php echo $sup1['certificate']; ?>" class="ml-3"
                                                    target="_blank">View Document</a>
                                            <?php } ?>
                                            <!-- <input type="text" name="risk" class="form-control"> -->
                                            <input type="file" name="doc" class="form-control">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="validationTooltip02">Date</label>

                                            <!-- <input type="text" name="risk" class="form-control"> -->
                                            <input type="date" name="docdate" class="form-control" value="<?php
                                                                                                            if (!empty($sup1['docdate'])) {
                                                                                                                echo date('Y-m-d', strtotime($sup1['docdate']));
                                                                                                            } ?>" />
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




    $pcode = $sup1['sagecode'];










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
                $dlink = $sup1['dlink'];
            }

            $dstand = $_POST['dstand'];
            $dgrade = $_POST['dgrade'];
            $dcat = $_POST['dcat'];
            $dscope = $_POST['dscope'];
            $dmodule = $_POST['dmodule'];
            $dbody = $_POST['dbody'];
            $dpro = $_POST['dpro'];
            $dissue = $_POST['dissue'];
            $dexp = $_POST['dexp'];
            $dexclusion = $_POST['dexclusion'];
            $signature = "";
        } else {
            $docdate = $_POST['docdate'];
            $approval = $_POST['approval'];
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
























    $q = "UPDATE `tblrawsupplier` SET 
       `supname` = '$supplier_name',
       `address` = '$address',
       `contact` = '$contact',
       `email` = '$mail',
       `category` = '$category',
       `approval` = '$approval',
       `certificate` = '$signature',
       `suptype` = '$type',
       `service` = '$service',
       `tname` = '$tname',
       `tcontact` = '$tcontact',
       `tmail` = '$tmail',
       `coname` = '$comname',
       `comail` = '$commail',
       `sitecode` = '$stc',
       `dlink` = '$dlink',
       `dstand` = '$dstand',
       `dgrade` = '$dgrade',
       `dcategory` = '$dcat',
       `dscope` = '$dscope',
       `body` = '$dbody',
       `dpro` = '$dpro',
       `dex` = '$dexclusion',
       `dmod` = '$dmodule'
       ,`dissue`='$dissue'
       ,`dexpire`='$dexp'
       ,`docdate`='$docdate',
       `adlink` ='$adlink'
     WHERE `supid` = '$spid'";

    // print_r($q);
    // die;
    $q1 = mysqli_query($con, $q);



    if ($q1) {
        echo "<script>
          document.location.href ='admin.php?id=supplier-management';
          </script>";
    }
}

?>