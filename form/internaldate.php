<?php
include 'connection.php';

// Get distinct years from the database
$yearQuery = mysqli_query($con, "SELECT DISTINCT YEAR(date) as year FROM tblscales1 ORDER BY year DESC");
$years = [];
while ($yearRow = mysqli_fetch_assoc($yearQuery)) {
    $years[] = $yearRow['year'];
}

// Get current page URL without query parameters
$currentPage = 'admin.php?id=' . $_GET['id']; // Assuming 'id' is always present in your URL

// Get selected year and month from request
$cyear  = isset($_GET['year']) ? $_GET['year'] : date('Y');
$cmonth = isset($_GET['month']) ? $_GET['month'] : date('m');
$mtp    = $cyear . '-' . $cmonth;
?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2">Monthly Scale Calibration</h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>View by Date</li>
        </ul>
    </div>

    <!-- Year and Month Filter -->
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="yearFilter">Select Year:</label>
            <select id="yearFilter" class="form-control">
                <?php foreach ($years as $year): ?>
                    <option value="<?php echo $year; ?>" <?php echo $year == $cyear ? 'selected' : ''; ?>>
                        <?php echo $year; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <label for="monthFilter">Select Month:</label>
            <select id="monthFilter" class="form-control">
                <?php
                $months = [
                    '01' => 'January','02' => 'February','03' => 'March','04' => 'April',
                    '05' => 'May','06' => 'June','07' => 'July','08' => 'August',
                    '09' => 'September','10' => 'October','11' => 'November','12' => 'December'
                ];
                foreach ($months as $num => $name): ?>
                    <option value="<?php echo $num; ?>" <?php echo $num == $cmonth ? 'selected' : ''; ?>>
                        <?php echo $name; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <button class="btn btn-primary" onclick="applyFilter()">Filter</button>
        </div>
    </div>

    <div class="card text-left">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="card-title mb-0">Select Date</h4>
            <div>
                <a href="admin.php?id=addinternal" class="btn btn-danger">Add New</a>
                <a href="admin.php?id=precord" class="btn btn-success mr-2">Back</a>
            </div>
        </div>

        <table class="table table-bordered" id="zero_configuration_table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Area</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $dateQuery = mysqli_query($con, "SELECT DISTINCT DATE_FORMAT(date, '%Y-%m') as dst, area 
                                                 FROM tblscales1 
                                                 WHERE DATE_FORMAT(date, '%Y-%m') ='$mtp'
                                                 ORDER BY date DESC");
                $i = 1;

                if (mysqli_num_rows($dateQuery) > 0) {
                    while ($dateRow = mysqli_fetch_assoc($dateQuery)) {
                        $formattedDate = date("M, Y", strtotime($dateRow['dst']));
                        $areaid = $dateRow['area'];

                        $sty = mysqli_query($con, "SELECT * FROM `tblscales` WHERE id='$areaid'");
                        $sty1 = mysqli_fetch_array($sty);

                        echo '
                            <tr>
                                <td>' . $i++ . '</td>
                                <td>' . $formattedDate . '</td>
                                <td>' . $sty1['area'] . '</td>
                                <td>
                                    <a href="admin.php?id=internal&date=' . $dateRow['dst'] . '&aid=' . $dateRow['area'] . '&range=first" class="btn btn-sm btn-primary">
                                        View (1-15)
                                    </a>
                                    <a href="admin.php?id=internal&date=' . $dateRow['dst'] . '&aid=' . $dateRow['area'] . '&range=second" class="btn btn-sm btn-secondary">
                                        View (16-end)
                                    </a>
                                </td>
                            </tr>';
                    }
                } else {
                    echo '<tr><td colspan="4" class="text-center">No records found for selected month and year</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function applyFilter() {
        const year = document.getElementById('yearFilter').value;
        const month = document.getElementById('monthFilter').value;
        const currentPage = '<?php echo $currentPage; ?>';
        window.location.href = currentPage + '&year=' + year + '&month=' + month;
    }
</script>