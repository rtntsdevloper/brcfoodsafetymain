<?php

$tid = $_GET['tid'];


?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>Dispatch Log </li>
        </ul>
    </div>
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <a href="admin.php?id=1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                    <a href="admin.php?id=dispatchadd&tid=<?php echo $tid;?>"><button class="btn btn-danger" style="float:right">Add New</button></a>
                    <a href="admin.php?id=dispatchpdf&tid=<?php echo $tid;?>"><button class="btn btn-warning mr-3" style="float:right">View Record</button></a>
                    <h4 class="card-title mb-3">Dispatch Log</h4>

                    <p>List of Dispatch</p>

                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                            <thead>

                                <!-- <tr>
                                    <th colspan="11" style="color: red; text-align:center;">Chilled meat and meat prep +4°C; Raw meat & meat prep +4°C
                                        Frozen food -15°C; Frozen raw meat & meat prep -18°C </th>
                                </tr> -->

                                <tr>


                                    <th scope="col">#</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Customer Store</th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Used by Date/Best before Date</th>
                                    <th scope="col">Total Weight/Quantity</th>
                                    <th scope="col">Product Temperature</th>
                                    <th scope="col">Vehicle Temperature</th>
                                    <th scope="col">Van Hygeine</th>
                                    <th scope="col">Packaging Integrity</th>
                                    <th scope="col">Attempt By</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = mysqli_query($con, "select * from tbldispatch where tid= $tid");
                                $i = 0;
                                while ($row = mysqli_fetch_array($sql)) {
                                    $i++;
                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $i; ?></th>
                                        <td><?php echo $row['date']; ?></td>
                                        <td><?php echo $row['cstore']; ?></td>
                                        <td><?php echo $row['product']; ?> </td>
                                        <td><?php echo $row['useby']; ?> </td>
                                        <td><?php echo $row['qty']; ?> </td>
                                        <td><?php echo $row['ptemp']; ?> <sup>o</sup>C </td>
                                        <td><?php echo $row['vtemp']; ?><sup>o</sup>C </td>
                                        <td><?php echo $row['vhygiene']; ?> </td>
                                        <td><?php echo $row['pack']; ?> </td>
                                         <td><?php echo $row['add_by']; ?> </td>






                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>