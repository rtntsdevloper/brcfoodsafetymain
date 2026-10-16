<?php
$production_rows = [];
$res_prod = mysqli_query($con, "SELECT * FROM `frozenproduction` ORDER BY id DESC");
while ($r = mysqli_fetch_assoc($res_prod)) {
    $production_rows[] = $r;
}
?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">add</a></li>
            <li>Production</li>
        </ul>
    </div>

    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">

                    <a href="admin.php?id=frozen">
                        <button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button>
                    </a>
                    <a href="admin.php?id=faddproduction">
                        <button class="btn btn-primary" style="float:right; margin-left:15px">Add New</button>
                    </a>

                    <h4 class="card-title mb-3">Production Record</h4>

                    <div class="row">
                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>S No.</th>
                                        <th>Date</th>
                                        <th>Batch No.</th>
                                        <th>Product</th>
                                        <th>View</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($production_rows)): ?>
                                        <?php $i = 1; foreach ($production_rows as $row): ?>
                                            <tr>
                                                <td><?php echo $i++; ?></td>
                                                <td><?php echo htmlspecialchars($row['date']); ?></td>
                                                <td><?php echo htmlspecialchars($row['batchcode']); ?></td>
                                                <td>
                                                    <?php
                                                        if ($row['product'] == 2) {
                                                            echo "Samosa";
                                                        } elseif ($row['product'] == 3) {
                                                            echo "Spring Roll";
                                                        } else {
                                                            echo htmlspecialchars($row['product']);
                                                        }
                                                    ?>
                                                </td>
                                                <td><a href="admin.php?id=fproduction1&sno=<?php echo $row['id']  ?>" class="btn btn-info btn-sm">view</a></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center">No production records found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>