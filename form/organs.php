<?php
include 'connection.php';

?>


<div class="main-content">

    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>Weekly Production Organoleptic Assessment Record</li>
        </ul>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">

                <h4>Weekly Production Organoleptic Assessment Record</h4>
                <a href="admin.php?id=organ"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                <form class="needs-validation" novalidate="novalidate" method="post" enctype="multipart/form-data" action="">
                    <div class="form-row mt-5">
                   
                    <h1></h1>

                        <div class="col-md-6 mb-3">
                            <label for="validationTooltip03">QAS Comments</label>
                            <textarea class="form-control" id="validationTooltip04" type="text" required="required" name="qas"></textarea>
                            <div class="invalid-tooltip">
                                Please fill the field.
                            </div>
                        </div>

                    </div>

                    <style>
                        .heading-tab {
                            cursor: pointer;
                            padding: 10px;
                            background-color: #f8f9fa;
                            border: 1px solid #dee2e6;
                            border-radius: 4px;
                            margin-bottom: 5px;
                        }

                        .heading-tab h6 {
                            margin: 0;
                        }

                        .sub-tabs {
                            padding: 10px;
                            border: 1px solid #dee2e6;
                            border-top: none;
                            border-radius: 0 0 4px 4px;
                        }
                    </style>



                    <button class="btn btn-primary" type="submit" name="submit">Save & Next</button>

            </div>
        </div>
    </div>
