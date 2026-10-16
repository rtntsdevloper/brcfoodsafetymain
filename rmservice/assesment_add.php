<?php
if (isset($_POST['submit'])) {
    $supplier_name = $_POST['name'];
    $category = $_POST['category'];
    
   if(!empty($_POST['cate-v'])){
    $type = $_POST['cate-v'];
} elseif(!empty($_POST['cate-r'])){
    $type = $_POST['cate-r'];
} 
   $q = "INSERT INTO `tblassesment`(`question`, `category`, `type`) VALUES ('$supplier_name','$category','$type')";
//    print_r($q);
   $q1= mysqli_query($conn,$q);
    
 

   if ($q1) {
    echo "<script>
     document.location.href='admin.php?id=question';
     </script>";
}
}

?>

<div class="row mb-12 ">
    <div class="col-md-12 ">
        <div class="card text-left ml-5" style="margin-top:8%;">
            <div class="card-body">

                <a href="admin.php?id=question"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>




                <h4 class="card-title mb-3"></h4>


                <!-- <div class="row ml-5"> -->




                  
                        <form class="needs-validation my-5" novalidate="novalidate" method="post" action=""
                            enctype="multipart/form-data">
                            <div class="form-row">


                                <div class="col-md-12 mb-1 ">
                                    <label for="validationTooltip02"><b>
                                            <h5>Add Questions</h5>
                                        </b></label><br><br>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Question</label>
                                    <input type="text" name="name" class="form-control" required />
                                    <div class="invalid-tooltip">
                                        Please select a supplier
                                    </div>
                                </div>


                                <div class="col-md-6 mb-3">
                                    <label for="validationTooltip02">Category</label>

                                    <select name="category" id="cat" class="form-control" required>
                                        <option value="">Select Please</option>
                                        <option value="Risk">Risk Assesment</option>
                                        <option value="Vulnerbility">Vulnerbility Assesment</option>
                                    </select>

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
                                    document.getElementById('cat').onchange = function() {
                                        var selectedValue = this.value;
                                        if (selectedValue == 'Risk') {
                                            document.getElementById('risk').classList.remove('hidden');
                                            document.getElementById('vulner').classList.add('hidden');
                                        } else if (selectedValue == 'Vulnerbility') {
                                            document.getElementById('vulner').classList.remove('hidden');
                                            document.getElementById('risk').classList.add('hidden');
                                        } else {
                                            document.getElementById('risk').classList.add('hidden');
                                            document.getElementById('vulner').classList.add('hidden');
                                        }
                                    }
                                </script>

                                <div class="col-md-6 mb-3 hidden" id='vulner'>
                                    <label for="validationTooltip02">Type</label>

                                    <select name="cate-v" id="" class="form-control">
                                        <option value="">Select Please</option>
                                        <option value="Occurance">Occurance</option>
                                        <option value="Detection">Detection</option>
                                    </select>

                                    <div class="invalid-tooltip">
                                        Please fill
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3 hidden" id="risk">
                                    <label for="validationTooltip02">Type</label>

                                    <select name="cate-r" id="" class="form-control">
                                        <option value="">Select Please</option>
                                        <option value="Description">Description</option>
                                        <option value="Associated">Risk Associated</option>
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