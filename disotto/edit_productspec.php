<?php
if (isset($_POST['submit'])) {


    // Main Supplier Info
    $supplier_name = $_POST['supplier_name'];
    $category = $_POST['category'];
    $mail = $_POST['mail'];
    $contact = $_POST['contact']; // This will be overwritten by the next 'contact' field
    $address = $_POST['address'];
    $stc = $_POST['stc'];

    // Technical Contact
    $tname = $_POST['tname'];
    $tmail = $_POST['tmail'];
    $tcontact = $_POST['contact']; // This overwrites $contact above

    // Commercial Contact
    $comname = $_POST['comname'];
    $commail = $_POST['commail'];

    // Other Info
    $risk = $_POST['risk'];
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
                                            <h5>Edit Product</h5>
                                        </b></label><br><br>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Product Name</label>

                                    <input type="text" name="prod_name" class="form-control" required />
                                    <div class="invalid-tooltip">
                                        Please select a supplier
                                    </div>
                                </div>
                                 <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Product Code</label>

                                    <input type="text" name="prod_code" class="form-control" required />
                                    <div class="invalid-tooltip">
                                        Please select a supplier
                                    </div>
                                </div>





                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Category</label>

                                    <select name="category" id="" class="form-control" required>
                                        <option value="">Select Please</option>
                                        <option value="Manufacturer">Manufacturer </option>
                                        <option value="Agent & Broker"> Agent & Broker</option>
                                        <option value="Storage & Distribution">Storage & Distribution </option>


                                    </select>

                                    <div class="invalid-tooltip">
                                        Please fill
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Email</label>

                                    <input type="text" name="mail" class="form-control" required />
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
                                    <textarea name="address" class="form-control"></textarea>


                                    <!-- <textarea class ></textarea> -->

                                    <div class="invalid-tooltip">
                                        Please fill
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Sitecode</label>

                                    <input type="text" name="stc" class="form-control" />
                                    <div class="invalid-tooltip">
                                        Please select a supplier
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

                                    <input type="number" name="contact" class="form-control" />
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
                                    <label for="validationTooltip02">Risk Assesment</label>

                                    <!-- <input type="text" name="risk" class="form-control"> -->
                                    <select name="risk" id="" class="form-control" required>
                                        <option value="">Select Please</option>
                                        <option value="Low Risk">Low Risk</option>
                                        <option value="Medium Risk">Medium Risk</option>
                                        <option value="High Risk">High Risk</option>
                                    </select>
                                    <div class="invalid-tooltip">
                                        Please fill
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