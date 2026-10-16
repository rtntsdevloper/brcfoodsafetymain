<div class="main-content">
    <div class="breadcrumb">

        <ul>
            <li><a href="">Customer Management</a></li>
            <li>Add Customer</li>
        </ul>
    </div>
    <?php
    $sql = mysqli_query($con, "select * from `tblcustomer` where id='$_REQUEST[sno]'");
    $row = mysqli_fetch_array($sql);
    ?>
    <div class="container" style="margin-top:100px;">

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <a href="admin.php?id=customer"><button class="btn btn-success"
                            style="float:right; margin-left:15px">Go Back</button></a>


                    <form class="needs-validation" novalidate="novalidate" method="post" action=""
                        enctype="multipart/form-data">
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="validationTooltip01">Customer name</label>
                                <input class="form-control" id="validationTooltip01" type="text" required="required"
                                    name="name" value="<?php echo $row['name']; ?>" />
                                <div class="invalid-tooltip">
                                    Please provide a valid Customer name.

                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationTooltip02">Contact</label>
                                <input class="form-control" id="validationTooltip02" type="text" placeholder=""
                                     name="contact" value="<?php echo $row['contact']; ?>" />
                                <div class="invalid-tooltip">
                                    Please provide a valid Contact

                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationTooltip03">Address</label>
                                <textarea name="adr" class="form-control" id="validationTooltip03" placeholder=""
                                    required="required">
                    <?php echo $row['adr']; ?>
                    </textarea>
                                <div class="invalid-tooltip">
                                    Please provide a valid Address
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-primary" type="submit" name="submit">Submit </button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <?php
   if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $address = $_POST['adr'];

    $sql = mysqli_query($con, "UPDATE `tblcustomer` SET `name` = '$name', `Contact` = '$contact', `adr` = '$address' WHERE `id` = '$_REQUEST[sno]'");

    ?>
    <script language="javascript">
        window.open('admin.php?id=customer', '_self');
    </script>
	
<?php
}
?>