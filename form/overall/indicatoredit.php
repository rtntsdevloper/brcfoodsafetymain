<?php
include('connection.php');
$id = $_GET['sno'];

$sql = mysqli_query($con, "Select * from `tbl_overname` where id='$id'  ");
$result = mysqli_fetch_array($sql);  // this is select data in table and for show the data add input space value


if (isset($_POST['submit'])) {
    $name = $_POST['name'];
   $Target=htmlspecialchars($_POST['target']);
    $Accept= htmlspecialchars($_POST['accept']);
    $Action= htmlspecialchars($_POST['action']);


    // Run update query
    $update = mysqli_query($con, "UPDATE `tbl_overname` SET `name`='$name',`target`='$Target',
    `acceptable` ='$Accept' ,`action` ='$Action'  WHERE id='$id' ");

    if ($update) {
        echo "<script>alert(' updated successfully'); window.location='admin.php?id=indicator';</script>";
    } else {
        echo "<script>alert('not updated');</script>";
    }
}
?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Over all</a></li>
            <li>status</li>
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=indicator">
                    <button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button>
                </a>

                <div class="card-title">Edit</div>

                <form class="needs-validation" novalidate method="post" action="" enctype="multipart/form-data">
                    <input type="hidden" name="sno" value="<?php echo $id; ?>" />

                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip01">Name</label>
                            <input class="form-control" type="text" placeholder="Enter name" required name="name"
                                value="<?php echo $result['name']; ?>" />
                            <div class="invalid-tooltip">
                                Please provide a valid name.
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip01">Target</label>
                            <input class="form-control" type="text"  name="target"
                                value="<?php echo $result['target']; ?>" />
                            <div class="invalid-tooltip">
                                Please provide a valid name.
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip01">Acceptable</label>
                            <input class="form-control" type="text" name="accept"
                                value="<?php echo $result['acceptable']; ?>" />
                            <div class="invalid-tooltip">
                                Please provide a valid name.
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Action</label>
                            <input class="form-control" type="text"  required name="action"
                                value="<?php echo $result['action']; ?>" />
                            <div class="invalid-tooltip">
                                Please provide a valid name.
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>