

<div class="main-content">
    <div class="breadcrumb">

        <ul>
            <li><a href="">Home</a></li>
            <li>Goods Out Management </li>
        </ul>
    </div>
    <div class="container " style="margin-top:100px;">
        <div class="row mb-12">
            <div class="col-md-12 mb-12">
                <div class="card text-left">
                    <div class="card-body">

                        <a href="admin.php?id=1"><button class="btn btn-success"
                                style="float:right; margin-left:15px">Go Back</button></a>


                        <a href="admin.php?id=addgoodsout"><button class="btn btn-danger"
                                style="float:right">Add New</button></a>
                        <h4 class="card-title mb-3">Goods Out</h4>
                        <!-- <p>List of staff</p> -->

                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered" id="zero_configuration_table"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sr. no</th>
                                        <th>Customer</th>
                                        <th>Product Name</th>
                                        <th>Category</th>
                                        <th>Edit</th>


                                    </tr>
                                </thead>
                                <tbody>
                                <?php
// Execute the first query
$sql1 = "SELECT * FROM tblgoodsoutproduct";
$result1 = mysqli_query($con, $sql1);

// Check if the query was successful
if (!$result1) {
    die("Query failed: " . mysqli_error($con));
}

// Fetch all records from the first query
$goodsOutProducts = array();
while ($row = mysqli_fetch_array($result1)) {
    $goodsOutProducts[] = $row;
}

// Close the first result set
mysqli_free_result($result1);

// Iterate through the goods out products and fetch the corresponding customer records
foreach ($goodsOutProducts as $goodsOutProduct) {
    $sql2 = "SELECT * FROM tblcustomer where id='" . $goodsOutProduct['cid'] . "'";
    $result2 = mysqli_query($con, $sql2);

    // Check if the query was successful
    if (!$result2) {
        die("Query failed: " . mysqli_error($con));
    }

    // Fetch the customer record
    $customer = mysqli_fetch_array($result2);

    // Close the second result set
    mysqli_free_result($result2);

    // Display the data
    ?>
    <tr>
        <th scope="row"><?= $goodsOutProduct['id'] ?></th>
        <td><?= $customer['name'] ?></td>
         <td><?= $goodsOutProduct['prodname'] ?></td>
        <td><?= $goodsOutProduct['catg'] ?></td>
        <td>
            <a href="admin.php?id=editgoodsout&sno=<?= $goodsOutProduct['id'] ?>"><button
                    class="btn btn-success" type="button"><i
                        class="fa fa-pencil"></i></button></a>
        </td>
    </tr>
    <?php
}

// Close the database connection
mysqli_close($con);
?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>