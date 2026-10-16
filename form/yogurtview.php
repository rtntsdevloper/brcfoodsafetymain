<?php
$uid=$_GET['uid'];
?>
<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">add</a></li>
            <li>Yogurt Planning</li>
        </ul>
    </div>

    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">
                    <a href="admin.php?id=yogurt1">
                        <button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button>
                    </a>

                    <h4 class="card-title mb-3">Stock vs Required vs New Order</h4>

                    <?php
                    $raw = mysqli_query($con, "SELECT r1.pname, SUM(g1.leftqty) AS totalleftqty
                                                FROM tblrawmaterial AS r1
                                                JOIN tblgrn1 AS g1 ON r1.id = g1.product
                                                GROUP BY r1.pname");

                    $stock = [];
                    while ($row = mysqli_fetch_assoc($raw)) {
                        $stock[trim($row['pname'])] = $row['totalleftqty'];
                    }

                    // Get all products with their total requirements from tblyogurt1
                    $displayData = [];

                    // Query for Milk
                    $milk_query = mysqli_query($con, "SELECT SUM(milk) as total FROM tblyogurt1 WHERE milk > 0 and uid=$uid");
                    $milk_total = mysqli_fetch_assoc($milk_query);
                    if ($milk_total['total'] > 0) {
                        $stock_qty = isset($stock['Milk']) ? $stock['Milk'] : 0;
                        $displayData[] = [
                            'name' => 'Milk',
                            'stock' => $stock_qty,
                            'required' => $milk_total['total'],
                            'new_order' => max(0, $milk_total['total'] - $stock_qty)
                        ];
                    }

                    // Query for Cream
                    $cream_query = mysqli_query($con, "SELECT SUM(cream) as total FROM tblyogurt1 WHERE cream > 0 and uid=$uid");
                    $cream_total = mysqli_fetch_assoc($cream_query);
                    if ($cream_total['total'] > 0) {
                        $stock_qty = isset($stock['Cream']) ? $stock['Cream'] : 0;
                        $displayData[] = [
                            'name' => 'Cream',
                            'stock' => $stock_qty,
                            'required' => $cream_total['total'],
                            'new_order' => max(0, $cream_total['total'] - $stock_qty)
                        ];
                    }

                    // Query for Skimmed Milk Powder
                    $smp_query = mysqli_query($con, "SELECT SUM(smp) as total FROM tblyogurt1 WHERE smp > 0 and uid=$uid" );
                    $smp_total = mysqli_fetch_assoc($smp_query);
                    if ($smp_total['total'] > 0) {
                        $stock_qty = isset($stock['Skimmed Milk Powder']) ? $stock['Skimmed Milk Powder'] : 0;
                        $displayData[] = [
                            'name' => 'Skimmed Milk Powder',
                            'stock' => $stock_qty,
                            'required' => $smp_total['total'],
                            'new_order' => max(0, $smp_total['total'] - $stock_qty)
                        ];
                    }

                    $fruit_query = mysqli_query($con, "SELECT y.fname, SUM(y1.fruit) as total 
                                                        FROM tblyogurt1 y1
                                                        INNER JOIN tblyogurt y ON y1.ques = y.id
                                                        WHERE y.fname NOT IN ('Milk', 'Cream', 'Skimmed Milk Powder')
                                                        AND y1.fruit > 0
                                                        GROUP BY y.fname and uid=$uid");

                    while ($fruit = mysqli_fetch_assoc($fruit_query)) {
                        $fruit_name = trim($fruit['fname']);
                        $fruit_total = $fruit['total'];

                        // Get stock for this fruit
                        $stock_qty = 0;
                        if (isset($stock[$fruit_name])) {
                            $stock_qty = $stock[$fruit_name];
                        } else {
                            // Try case-insensitive match
                            foreach ($stock as $key => $qty) {
                                if (strtolower($key) == strtolower($fruit_name)) {
                                    $stock_qty = $qty;
                                    break;
                                }
                            }
                        }

                        $displayData[] = [
                            'name' => $fruit_name,
                            'stock' => $stock_qty,
                            'required' => $fruit_total,
                            'new_order' => max(0, $fruit_total - $stock_qty)
                        ];
                    }
                    ?>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Product Name</th>
                                    <th>Total Stock (Available)</th>
                                    <th>Total Required (Production Need)</th>
                                    <th>New Order Required</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($displayData)): ?>
                                    <?php $serial = 1; ?>
                                    <?php foreach ($displayData as $item): ?>
                                        <?php
                                        $highlight = ($item['new_order'] > 0) ? 'text-danger' : 'text-success';
                                        ?>
                                        <tr>
                                            <td><?php echo $serial++; ?></td>
                                            <td><strong><?php echo htmlspecialchars($item['name']); ?></strong></td>
                                            <td class="<?php echo $highlight; ?>"><?php echo number_format($item['stock'], 2); ?></td>
                                            <td><?php echo number_format($item['required'], 2); ?></td>
                                            <td class="<?php echo $highlight; ?>">
                                                <?php echo ($item['new_order'] > 0) ? "<strong>" . number_format($item['new_order'], 2) . "</strong>" : "0.00"; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">No products found in yogurt planning</td>
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