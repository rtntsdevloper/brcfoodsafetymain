<div class="container-fluid">

    <div class="main-content">
        <div class="breadcrumb">
            <h1 class="mr-2"><?php echo $headingname; ?></h1>
            <br>
            <ul>
                <li><a href="">Product specifications</a></li>
                <li>Add specifications</li>
            </ul>
          
        </div>
        <div class="row mb-3">
        <div class="col-md-10"></div>
            <div class="col-md-2"><a href="admin.php?id=productspec_detail" class="btn btn-success text-right">Go Back</a></div>
        </div>
        
        <div class="container-fluid">
            <div class="row mb-3">



                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">Add Product specification</div>
                            

                            <form name="form1" class="needs-validation" novalidate="novalidate" method="post" action="" enctype="multipart/form-data">
                                <div class="form-row">
                                    <div class="col-12">
                                        <label for="validationTooltip01">Name</label>
                                        <input class="form-control" id="validationTooltip01" type="text" placeholder="Name" required="required" name="name" />
                                        <div class="invalid-tooltip">
                                            Please provide a valid name.

                                        </div>
                                    </div>
                                </div>



                                <br />

                                <button class="btn btn-primary" type="submit" name="submit1">Submit </button>
                            </form>
                        </div>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">

                            <div class="card-title">Add Sub-Section</div>

                            <form class="needs-validation" novalidate="novalidate" method="post" name="form2" action="" enctype="multipart/form-data">
                                <div class="form-row">
                                    <div class="col-12">
                                        <label for="validationTooltip01">Section</label>
                                        <select class="form-control" id="validationTooltip01" required="required" name="sid">
                                            <option value="">Please Select</option>
                                            <?php
                                            $gh = mysqli_query($con, "SELECT * FROM `tblauditsection` WHERE name1 ='spec'");
                                            while ($row = mysqli_fetch_array($gh)) {
                                            ?>
                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>

                                            <?php
                                            }
                                            ?>
                                        </select>
                                        <div class="invalid-tooltip">
                                            Please provide a valid name.
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="validationTooltip01">Section Name</label>
                                        <input class="form-control" id="validationTooltip01" type="text" placeholder="Name" required="required" name="sname" />
                                        <div class="invalid-tooltip">
                                            Please provide a valid name.
                                        </div>
                                    </div>


                                </div>



                                <br />

                                <button class="btn btn-primary" type="submit" name="submit2">Submit </button>
                            </form>
                        </div>
                    </div>
                </div>





                <div class="col-md-12 my-2">
                    <div class="card">
                        <div class="card-body">

                            <div class="card-title">Add Question</div>

                            <form class="needs-validation" novalidate="novalidate" method="post" name="form3" action="" enctype="multipart/form-data">
                                <div class="form-row">
                                    <div class="col-12">
                                        <label for="validationTooltip01">Section</label>
                                        <select class="form-control" id="sectionid" required="required" name="sidd">
                                            <option value="">Please Select</option>
                                            <?php
                                            $gh1 = mysqli_query($con, "SELECT * FROM `tblauditsection` WHERE name1 ='spec'");
                                            while ($row1 = mysqli_fetch_array($gh1)) {
                                            ?>
                                                <option value="<?php echo $row1['id']; ?>"><?php echo $row1['name']; ?></option>

                                            <?php
                                            }
                                            ?>
                                        </select>
                                     
                                        <div class="invalid-tooltip">
                                            Please provide a valid name.

                                        </div>
                                    </div>
                                    <script>
                                            document.getElementById('sectionid').addEventListener('change', function() {
                                                var option = this.value;
                                                var xhr = new XMLHttpRequest();
                                                
                                                xhr.open('GET', 'productspec_add1.php?option=' + option, true);
                                                xhr.onload = function() {
                                                    if (xhr.status === 200) {
                                                        document.getElementById('content').innerHTML = xhr.responseText;
                                                    }
                                                };
                                                xhr.send();
                                            });
                                        </script>
                                   


                                    <div class="col-12" id="content">
                                       
                                    </div>

                                    <div class="col-12">
                                        <label for="validationTooltip01">Question</label>
                                        <input class="form-control" id="validationTooltip01" type="text" placeholder="Name" required="required" name="ques" />
                                        <div class="invalid-tooltip">
                                            Please provide a valid name.

                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <br>
                                        <br>
                                        <label for="validationTooltip01"> Answer Type </label>
                                        <br />
                                        Comment Box: <input type="radio" name="cmnt" value="yes" />
                                        <br />
                                        Photo Upload : <input type="radio" name="pic" value="yes" />
                                        <br />
                                        Text Box : <input type="radio" name="text" value="yes" />
                                        <br />
                                        Number : <input type="radio" name="number" value="yes" />
                                        <br />
                                        <br>

                                    </div>
                                </div>

                                <br />

                                <button class="btn btn-primary " type="submit" name="submit3">Submit </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





<?php
if (isset($_POST['submit1'])) {
    $sid = $_POST['sid'];
    $spec = 'spec';
    $sname = mysqli_real_escape_string($con, $_POST['name']);
    $sql1 = mysqli_query($con, "insert into `tblauditsection`  (name,name1)values('$sname','$spec')");
?>
    <script language="javascript">
        window.open('admin.php?id=productspec_add', '_self');
    </script>
<?php
}
?>

<?php
if (isset($_POST['submit2'])) {
    $sid = $_POST['sid'];
    $sname = mysqli_real_escape_string($con, $_POST['sname']);
    $sql1 = mysqli_query($con, "insert into tblauditsection1(sid,name)values('$sid','$sname')");
?>
    <script language="javascript">
        window.open('admin.php?id=productspec_add', '_self');
    </script>
<?php
}
?>

<?php
if (isset($_POST['submit3'])) {
    $sidd = $_POST['sidd'];
    $ssid = $_POST['ssid'];
    $ques = mysqli_real_escape_string($con, $_POST['ques']);
    $cmnt = $_POST['cmnt'];
    $pic = $_POST['pic'];
    $text = $_POST['text'];
    $status = 'active';



        $sql2 = mysqli_query($con,"insert into tblauditsection2 (sid,ssid,ques,cmnt,pic,textbox,number,status)values('$sidd','$ssid','$ques','$cmnt','$pic','$text','$number','$status')");
    

?>
    <script language="javascript">
        alert('question add Sucessfully!');
        window.open('admin.php?id=productspec_add', '_self');
    </script>
<?php
}
?>