<?php 
$uid = $_GET['uid'];
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
                    <a href="admin.php?id=yogurtplaningreport&uid=<?php echo $uid; ?>">
                        <button class="btn btn-info" style="float:right; margin-left:15px">View Report</button>
                    </a>


                    <h4 class="card-title mb-3">Stock vs Required vs New Order</h4>

                    <?php
                    // Query raw materials totals (all raw materials)
                    $raw = mysqli_query($con, "SELECT r1.pname, 
                            SUM(g1.leftqty) AS totalleftqty
                            FROM tblrawmaterial AS r1
                            JOIN tblgrn1 AS g1 
                                ON r1.id = g1.product
                            GROUP BY r1.pname");

                    $totals = [];
                    while ($row = mysqli_fetch_assoc($raw)) {
                        $totals[trim($row['pname'])] = $row['totalleftqty'];
                    }

                    // Get base product requirements for this uid
                    $sql2 = mysqli_query($con, "SELECT 
                            SUM(cream) AS total_cream,
                            SUM(smp) AS total_smp,
                            SUM(milk) AS total_milk
                            FROM tblyogurt1 
                            WHERE uid='$uid'");

                    $grand_req_cream = 0;
                    $grand_req_smp = 0;
                    $grand_req_milk = 0;

                    if ($req = mysqli_fetch_assoc($sql2)) {
                        $grand_req_cream = $req['total_cream'] ? $req['total_cream'] : 0;
                        $grand_req_smp = $req['total_smp'] ? $req['total_smp'] : 0;
                        $grand_req_milk = $req['total_milk'] ? $req['total_milk'] : 0;
                    }

                    // Get fruit requirements for this uid from tblyogurt1
                    $fruit_query = mysqli_query($con, "SELECT y.fname, SUM(y1.fruit) as total_fruit
                                                        FROM tblyogurt1 y1
                                                        INNER JOIN tblyogurt y ON y1.ques = y.id
                                                        WHERE y1.uid = '$uid' 
                                                        AND y.fname NOT IN ('Milk', 'Cream', 'Skimmed Milk Powder')
                                                        AND y1.fruit > 0
                                                        GROUP BY y.fname");

                    $fruit_requirements = [];
                    while ($fruit = mysqli_fetch_assoc($fruit_query)) {
                        $fruit_requirements[] = [
                            'name' => trim($fruit['fname']),
                            'required' => $fruit['total_fruit']
                        ];
                    }

                    // Helper function to get stock value
                    function getStockValue($productName, $totals) {
                        $productName = trim($productName);
                        
                        // Exact match
                        if (isset($totals[$productName])) {
                            return $totals[$productName];
                        }
                        
                        // Case-insensitive match
                        foreach ($totals as $key => $value) {
                            if (strtolower($key) == strtolower($productName)) {
                                return $value;
                            }
                        }
                        
                        // Partial match
                        foreach ($totals as $key => $value) {
                            if (stripos($key, $productName) !== false || stripos($productName, $key) !== false) {
                                return $value;
                            }
                        }
                        
                        return 0;
                    }

                    // Stock values for base products
                    $cream_stock = getStockValue('Cream', $totals);
                    $smp_stock = getStockValue('Skimmed Milk Powder', $totals);
                    $milk_stock = getStockValue('Milk', $totals);
                    
                    $serial = 1;
                    ?>

                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>S No.</th>
                                        <th>Product Name</th>
                                        <th>Total Stock (Available)</th>
                                        <th>Total Required (Production Need)</th>
                                        <th>New Order Required</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Display Cream if required > 0
                                    if ($grand_req_cream > 0):
                                        $cream_new_order = max(0, $grand_req_cream - $cream_stock);
                                        $cream_status_class = ($cream_new_order > 0) ? "text-danger" : "text-success";
                                    ?>
                                    <tr>
                                        <td><?php echo $serial++; ?></td>
                                        <td><strong>Cream</strong></strong></td>
                                        <td class="<?php echo ($cream_new_order > 0) ? 'text-danger' : 'text-success'; ?>">
                                            <?php echo number_format($cream_stock, 2); ?>
                                        </td>
                                        <td><?php echo number_format($grand_req_cream, 2); ?></td>
                                        <td class="<?php echo $cream_status_class; ?>">
                                            <?php echo ($cream_new_order > 0) ? "<strong>" . number_format($cream_new_order, 2) . "</strong>" : "0.00"; ?>
                                        </td>
                                    </tr>
                                    <?php endif; ?>

                                    <?php
                                    // Display Skimmed Milk Powder if required > 0
                                    if ($grand_req_smp > 0):
                                        $smp_new_order = max(0, $grand_req_smp - $smp_stock);
                                        $smp_status_class = ($smp_new_order > 0) ? "text-danger" : "text-success";
                                    ?>
                                    <tr>
                                        <td><?php echo $serial++; ?></td>
                                        <td><strong>Skimmed Milk Powder</strong></td>
                                        <td class="<?php echo ($smp_new_order > 0) ? 'text-danger' : 'text-success'; ?>">
                                            <?php echo number_format($smp_stock, 2); ?>
                                        </td>
                                        <td><?php echo number_format($grand_req_smp, 2); ?></td>
                                        <td class="<?php echo $smp_status_class; ?>">
                                            <?php echo ($smp_new_order > 0) ? "<strong>" . number_format($smp_new_order, 2) . "</strong>" : "0.00"; ?>
                                        </td>
                                    </tr>
                                    <?php endif; ?>

                                    <?php
                                    // Display Milk if required > 0
                                    if ($grand_req_milk > 0):
                                        $milk_new_order = max(0, $grand_req_milk - $milk_stock);
                                        $milk_status_class = ($milk_new_order > 0) ? "text-danger" : "text-success";
                                    ?>
                                    <tr>
                                        <td><?php echo $serial++; ?></td>
                                        <td><strong>Milk</strong></td>
                                        <td class="<?php echo ($milk_new_order > 0) ? 'text-danger' : 'text-success'; ?>">
                                            <?php echo number_format($milk_stock, 2); ?>
                                        </td>
                                        <td><?php echo number_format($grand_req_milk, 2); ?></td>
                                        <td class="<?php echo $milk_status_class; ?>">
                                            <?php echo ($milk_new_order > 0) ? "<strong>" . number_format($milk_new_order, 2) . "</strong>" : "0.00"; ?>
                                        </td>
                                    </tr>
                                    <?php endif; ?>

                                    <?php
                                    // Display Fruits that are used
                                    if (!empty($fruit_requirements)):
                                        foreach ($fruit_requirements as $fruit):
                                            $fruit_name = $fruit['name'];
                                            $fruit_required = $fruit['required'];
                                            $fruit_stock = getStockValue($fruit_name, $totals);
                                            $fruit_new_order = max(0, $fruit_required - $fruit_stock);
                                            $fruit_status_class = ($fruit_new_order > 0) ? "text-danger" : "text-success";
                                    ?>
                                    <tr>
                                        <td><?php echo $serial++; ?></td>
                                        <td><strong><?php echo htmlspecialchars($fruit_name); ?></strong></td>
                                        <td class="<?php echo ($fruit_new_order > 0) ? 'text-danger' : 'text-success'; ?>">
                                            <?php echo number_format($fruit_stock, 2); ?>
                                            <?php if ($fruit_stock == 0): ?>
                                                <small class="text-danger"> (No stock)</small>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo number_format($fruit_required, 2); ?></td>
                                        <td class="<?php echo $fruit_status_class; ?>">
                                            <?php echo ($fruit_new_order > 0) ? "<strong>" . number_format($fruit_new_order, 2) . "</strong>" : "0.00"; ?>
                                        </td>
                                    </tr>
                                    <?php 
                                        endforeach;
                                    endif; 
                                    
                                    // If no products at all
                                    if ($grand_req_cream == 0 && $grand_req_smp == 0 && $grand_req_milk == 0 && empty($fruit_requirements)):
                                    ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">No products found for this yogurt planning</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                                <?php
                                // Calculate totals for footer
                                $total_stock = 0;
                                $total_required = 0;
                                $total_new_order = 0;
                                
                                if ($grand_req_cream > 0) {
                                    $total_stock += $cream_stock;
                                    $total_required += $grand_req_cream;
                                    $total_new_order += max(0, $grand_req_cream - $cream_stock);
                                }
                                if ($grand_req_smp > 0) {
                                    $total_stock += $smp_stock;
                                    $total_required += $grand_req_smp;
                                    $total_new_order += max(0, $grand_req_smp - $smp_stock);
                                }
                                if ($grand_req_milk > 0) {
                                    $total_stock += $milk_stock;
                                    $total_required += $grand_req_milk;
                                    $total_new_order += max(0, $grand_req_milk - $milk_stock);
                                }
                                foreach ($fruit_requirements as $fruit) {
                                    $fruit_stock = getStockValue($fruit['name'], $totals);
                                    $total_stock += $fruit_stock;
                                    $total_required += $fruit['required'];
                                    $total_new_order += max(0, $fruit['required'] - $fruit_stock);
                                }
                                
                                ?>
                               
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>