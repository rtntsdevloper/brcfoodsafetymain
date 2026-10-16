<?php
$aid =$_GET['an'];
 $sql = mysqli_query($con, "SELECT * FROM `tbl_mmmattende` where id = '$aid'");
 $row = mysqli_fetch_array($sql);


?>


<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"></link> -->
<div class="main-content">
    <div class="breadcrumb">

        <ul>
            <li><a href="">Home</a></li>
            <li>Monthly Management Meeting</li>
            <li>Add Details</li>
        </ul>
    </div>
    <div class="container-fluid mb-5 pb-3" style="margin-top:100px;">

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <a href="admin.php?id=meeting_attendee"><button class="btn btn-success"
                            style="float:right; margin-left:15px">Go Back</button></a>

                    <div class="card-title">Monthly Management Meeting Details Add</div>

                    <form class="needs-validation" novalidate="novalidate" method="post" action=""
                        enctype="multipart/form-data">


                        <div class="form-row">
                            <div class="col-md-3"> <label for="validationTooltip03" class="h5">Name</label>
                            </div>
                            <div class="col-md-9 mb-3">

                                <input name="aname" type="text" class="form-control" 
                                    placeholder="Attendees Name" required="required" value="<?php echo $row['name'];?>" />
                                <div class="invalid-tooltip">
                                    Please fill in this field

                                </div>
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="col-md-3"> <label for="validationTooltip03" class="h5">Designation</label>
                            </div>
                            <div class="col-md-9 mb-3">

                                <input name="desg" type="text" class="form-control" 
                                    placeholder="Attendees Name" required="required" value="<?php echo $row['designation'];?>" />
                                <div class="invalid-tooltip">
                                    Please fill in this field

                                </div>
                            </div>

                        </div>
                        <div class="form-row">
                         <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                        </div>


                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<?php
// Check if form is submitted
if (isset($_POST["submit"])) {
    // Get form data and sanitize
    $name = $_POST['aname'] ;
    $designation = $_POST['desg'];


    $result = mysqli_query($con,"UPDATE `tbl_mmmattende` SET `name`='$name',`designation`='$designation' WHERE id = '$aid'"); 

   
        if ($result) {
            echo "<script> 
              document.location.href='admin.php?id=meeting_attendee';
             </script>";
        } else {
            echo "Error posting data: " . mysqli_error($conn);
        }

}

    // Basic validation
    
?>