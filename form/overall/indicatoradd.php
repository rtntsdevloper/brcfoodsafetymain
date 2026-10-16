<?php
include('connection.php');
if (isset($_POST['submit'])) {
    $nm = $_POST['name'];
    $Target=htmlspecialchars($_POST['target']);
    $Accept= htmlspecialchars($_POST['accept']);
    $Action= htmlspecialchars($_POST['action']);

    $q = mysqli_query($con, "INSERT INTO `tbl_overname`( `name`,`target`,`acceptable`,`action`)
     VALUES ('$nm','$Target','$Accept','$Action') ");
    if ($q) {
        ?>
        <script language="javascript">
            window.open('admin.php?id=indicator', '_self');
        </script> ';
        <?Php
    }

}

?>
<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Indicator</a></li>
            <li>add</li>
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body ">

                <a href="admin.php?id=indicator"><button class="btn btn-success" style="float:right; margin-left:15px">Go
                        Back</button></a>

               
                <div class="card-title"> Indicator Add</div>


                <form class="needs-validation" novalidate="novalidate" method="post" action=""
                    enctype="multipart/form-data">
                    <div class="form-row mt-5">

                        <div class="col-md-3 mb-3">
                            <label for="validationTooltip01">Name</label>
                            <input class="form-control" type="text" placeholder="enter name"
                                required="required" name="name" />
                            <div class="invalid-tooltip">
                                Please provide a valid first name.

                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="validationTooltip01">Target</label>
                            <input class="form-control" id="validationTooltip01" type="text" placeholder=" enter target range"
                               name="target" />
                            <div class="invalid-tooltip">
                                Please provide a valid target.

                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="validationTooltip01">Acceptable</label>
                            <input class="form-control"  type="text" placeholder="enter acceptable range"
                               name="accept" />
                            <div class="invalid-tooltip">
                                Please provide a valid acceptable.

                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="validationTooltip01">Action</label>
                            <input class="form-control" type="text" placeholder="enter action range"
                                 name="action" required />
                            <div class="invalid-tooltip">
                                Please provide a valid action.

                            </div>
                        </div>




                    </div>

                    <button class="btn btn-primary" type="submit" name="submit">Submit </button>

                </form>
            </div>
        </div>
    </div>
</div>