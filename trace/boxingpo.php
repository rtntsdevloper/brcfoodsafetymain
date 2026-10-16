<?php
$po = $_GET['po'];

?>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
    :root {
        --bg: #f1f5f9;
        --panel: #ffffff;
        --panel-2: #f8fafc;
        --border: #e2e8f0;
        --border-dark: #cbd5e1;
        --fg: #0f172a;
        --muted: #64748b;
        --accent: #ea580c;
        --accent-2: #d97706;
        --accent-light: #fff7ed;
        --ok: #16a34a;
        --warn: #ca8a04;
        --bad: #dc2626;
        --info: #0284c7;
    }

    * {
        box-sizing: border-box;
    }

    /* Century Gothic as default font globally */
    html,
    body {
        background: var(--bg);
        color: var(--fg);
        font-family: "Century Gothic", "CenturyGothic", "AppleGothic", "Avant Garde", "Futura", sans-serif;
        margin: 0;
        padding: 0;
    }

    body {
        background: radial-gradient(1200px 600px at 80% -10%, rgba(234, 88, 12, .06), transparent 60%), var(--bg);
        min-height: 100vh;
    }

    body::before {
        content: "";
        position: fixed;
        inset: 0;
        pointer-events: none;
        z-index: 0;
        background-image: linear-gradient(rgba(15, 23, 42, .025) 1px, transparent 1px), linear-gradient(90deg, rgba(15, 23, 42, .025) 1px, transparent 1px);
        background-size: 48px 48px;
    }

    button,
    input,
    select,
    textarea,
    table,
    th,
    td,
    span,
    div,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        font-family: inherit !important;
    }

    /* Header */
    .topbar {
        background: rgba(255, 255, 255, .95);
        border-bottom: 1px solid var(--border);
        backdrop-filter: blur(10px);
        box-shadow: 0 4px 20px -12px rgba(15, 23, 42, .1);
        position: sticky;
        top: 0;
        z-index: 1020;
        padding: 18px 32px;
    }

    .topbar h5 {
        margin: 0;
        font-weight: 700;
        color: var(--fg);
        font-size: 1.25rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Full Width Layout */
    .main-container {
        position: relative;
        z-index: 1;
        padding: 32px;
        width: 100%;
        max-width: 100%;
    }

    /* Search Forms Panel */
    .search-panel {
        background: var(--panel);
        border: 1px solid var(--border);
        border-radius: 16px;
        box-shadow: 0 10px 40px -20px rgba(15, 23, 42, .15);
        padding: 24px;
        margin-bottom: 24px;
    }

    .form-controls-row {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        align-items: flex-end;
    }

    .form-group-custom {
        flex: 1;
        min-width: 250px;
    }

    .form-label-custom {
        display: block;
        color: var(--muted);
        font-size: 11px;
        letter-spacing: 1px;
        text-transform: uppercase;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .form-input-custom {
        width: 100%;
        background: var(--panel-2);
        border: 1px solid var(--border-dark);
        color: var(--fg);
        font-size: 14px;
        padding: 12px 16px;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .form-input-custom:focus {
        outline: none;
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(234, 88, 12, .15);
        background: #fff;
    }

    .btn-search-custom {
        background: linear-gradient(135deg, var(--accent), var(--accent-2));
        color: #fff;
        font-weight: 700;
        border: none;
        padding: 12px 28px;
        border-radius: 8px;
        box-shadow: 0 8px 24px -8px rgba(234, 88, 12, .5);
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        height: 44px;
        transition: all 0.2s ease;
    }

    .btn-search-custom:hover {
        transform: translateY(-1px);
        box-shadow: 0 12px 28px -8px rgba(234, 88, 12, .6);
        color: #fff;
        text-decoration: none;
    }

    .btn-clear-custom {
        background: transparent;
        color: var(--muted);
        font-weight: 600;
        border: 1px solid var(--border-dark);
        padding: 12px 20px;
        border-radius: 8px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        height: 44px;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .btn-clear-custom:hover {
        border-color: var(--bad);
        color: var(--bad);
        text-decoration: none;
    }

    /* Table Styling */
    .table-list-wrap {
        background: var(--panel);
        border: 1px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 40px -20px rgba(15, 23, 42, .15);
    }

    .table {
        margin-bottom: 0;
        width: 100%;
        border-collapse: collapse;
    }

    .table thead th {
        background: var(--panel-2);
        color: var(--muted);
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 1px;
        font-weight: 700;
        border-bottom: 2px solid var(--border-dark);
        padding: 18px 24px;
        text-align: left;
        white-space: nowrap;
    }

    .table tbody td {
        padding: 18px 24px;
        vertical-align: middle;
        border-bottom: 1px solid var(--border);
        font-size: 15px;
        color: var(--fg);
        transition: all 0.2s ease;
    }

    .table tbody tr {
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .table tbody tr:hover {
        background: var(--accent-light);
    }

    .table tbody tr:hover td:first-child {
        box-shadow: inset 4px 0 0 var(--accent);
    }

    .table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Badges */
    .badge-status {
        font-size: 11px;
        font-weight: 700;
        padding: 6px 14px;
        border-radius: 20px;
        letter-spacing: .5px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-transform: uppercase;
    }

    .badge-status::before {
        content: "";
        width: 6px;
        height: 6px;
        border-radius: 50%;
        display: inline-block;
    }

    .badge-completed {
        background: #dcfce7;
        color: #16a34a;
        border: 1px solid #86efac;
    }

    .badge-completed::before {
        background: #16a34a;
    }

    .badge-waiting {
        background: #fef9c3;
        color: #ca8a04;
        border: 1px solid #fde047;
    }

    .badge-waiting::before {
        background: #ca8a04;
    }

    .badge-in-progress {
        background: #e0f2fe;
        color: #0284c7;
        border: 1px solid #7dd3fc;
    }

    .badge-in-progress::before {
        background: #0284c7;
    }

    .empty-state {
        text-align: center;
        padding: 80px 20px;
        color: var(--muted);
    }

    .empty-state i {
        font-size: 56px;
        color: var(--border-dark);
        margin-bottom: 16px;
        display: block;
    }

    .empty-state h6 {
        color: var(--muted);
        font-weight: 600;
        font-size: 18px;
    }
</style>

<!-- Top bar -->
<header class="topbar">
    <h5><i class="bi bi-clipboard2-pulse" style="color: var(--accent);"></i> Packaging Film Batchcode Detail</h5>
</header>

<div class="main-container">


    <section id="listView">
        <div class="table-list-wrap py-4">
            <div style="overflow-x: auto;">
                <table class="table table-hover mb-0" id="zero_configuration_table">
                    <thead>
                        <tr>
                            <th width="80">S No.</th>
                            <th>Date</th>
                            <th>Raw Material</th>
                            <th>Supplier</th>
                            <th>PO</th>
                            <th>Batchcode</th>
                            <th>Quantity</th>
                            <th>Report</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $qsp = mysqli_query($con, "SELECT g.date,g.po,g1.batchcode,g.id,g1.qty,g1.supplier,g1.product,r.pname as rawname , s.supname  FROM `tblgrn1` as g1 join tblgrnno2 as g join tblrawmaterial as r join tblrawsupplier as s on g1.grncode = g.grnno and s.supid = g1.supplier and g1.product = r.id where  g.po ='$po'")

                            ?>

                        <?php
                        $row2 = $qsp->num_rows;
                        $sr1 = 1;
                        if ($row2 > 0) {
                            while ($fetch = mysqli_fetch_array($qsp)) {
                                $rawid = $fetch['product'];

                                $rawspec = mysqli_query($con, "SELECT * FROM `tblrawspecdetail` WHERE status !='archived' and product ='$rawid'");
                                $sqw = mysqli_fetch_assoc($rawspec);
                                ?>
                                <tr id="row_<?php echo $fetch['id']; ?>">
                                    <td><?php echo $sr1; ?></td>
                                    <td><?php echo $fetch['date']; ?></td>
                                    <td><a href="specdetail/<?= $sqw['spec'] ?>" target="_blank"
                                            rel="noopener noreferrer"><?php echo $fetch['rawname']; ?></a></td>
                                    <td><a href="admin.php?id=trace_supplier&view=<?= $fetch['supplier'] ?>" target="_blank"
                                            rel="noopener noreferrer"><?php echo $fetch['supname']; ?></a></td>
                                    <td><?php echo $fetch['po']; ?></td>
                                    <td><?php echo $fetch['batchcode']; ?></td>
                                    <td><?php echo $fetch['qty']; ?></td>
                                    <td><a href="admin.php?id=goodsinreport&sno=<?= $fetch['id'] ?>" class="h4 text-danger"
                                            target="_blank"><i class="bi bi-file-pdf"></i></a></td>
                                </tr>
                                <?php
                                $sr1++;
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="6" class="text-center">
                                    <h5>No Data Available</h5>
                                    <p>No records found for the selected criteria.</p>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>


                    </tbody>
                </table>
            </div>
        </div>
    </section>

</div>