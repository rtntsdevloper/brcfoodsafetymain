<div class="main-content">
    <div class="breadcrumb">

        <ul>
            <li><a href="">Home</a></li>
            <li>Raw Material Supplier </li>
        </ul>
    </div>
    <?php
    $sql = "SELECT * from `tblrawsupplier` where supid='$_REQUEST[sno]'";
    $result = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <div class="container" style="margin-top:100px;">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <a href="admin.php?id=rawsupplier"><button class="btn btn-success"
                                style="float:right; margin-left:15px">Go Back</button></a>

                        <div class="card-title">Supplier</div>

                        <form class="needs-validation" novalidate="novalidate" method="post" action=""
                            enctype="multipart/form-data">
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="validationTooltip01">Sagecode</label>
                                    <input class="form-control" id="validationTooltip01" type="text" placeholder=""
                                        required="required" name="sagecode" value="<?php echo $row['sagecode'] ?>" />
                                    <div class="invalid-tooltip">
                                        Please fill in this field

                                    </div>
                              
                                <div class="col-md-4 mb-3">
                                    <label for="validationTooltip02">Supplier name</label>
                                    <input type="text" class="form-control" id="validationTooltip02" required="required"
                                        name="supname" value="<?php echo $row5['supname'];?>">
                                       </div>
                                <div class="col-md-4 mb-3">
                                    <label for="address">Address</label>
                                    <textarea name="address" class="form-control" id="address" 
                                        placeholder="Enter your address"><?php echo htmlspecialchars($row['address']) ?></textarea>
                                    <div class="invalid-tooltip">
                                        Please fill in this field
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="validationTooltip04">City</label>
                                    <input class="form-control" id="validationTooltip04" type="name" placeholder=""
                                        name="city" value="<?php echo $row['city'] ?>" />
                                    <div class="invalid-tooltip">
                                        Please fill the field.

                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationTooltip05">Contact</label>
                                    <input name="contact" type="text" class="form-control" id="validationTooltip05"
                                        placeholder="" />
                                    <div class="invalid-tooltip" value="<?php echo $row['contact'] ?>">
                                        Please fill the field

                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationTooltip06">Email</label>
                                    <input name="email" type="text" class="form-control" id="validationTooltip06"
                                        placeholder="" value="<?php echo $row['email'] ?>" />
                                    <div class="invalid-tooltip">
                                        Please fill the field

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
    }
if (isset($_POST['submit'])) {
    $sagecode = $_POST['sagecode'];
    $supname = $_POST['supname'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];

    // Update query
  $que = "UPDATE `tblrawsupplier` SET 
              `supname` = '$supname', 
              `address` = '$address', 
              `city` = '$city', 
              `contact` = '$contact', 
              `email` = '$email',
               `sagecode` = '$sagecode'
                where supid='$_REQUEST[sno]'";

    $res = mysqli_query($con, $que);

    if ($res) {
        echo "<script> document.location.href='admin.php?id=rawsupplier' </script>";
        // echo 'updated';
    } else {
        echo "<script> alert('Data didn\'t update successfully'); document.location.href='admin.php?id=editrawsupplier' </script>";
        // echo 'not updated';
    }
}
?>