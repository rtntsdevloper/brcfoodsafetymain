<?php
include 'connection.php';

// Get current date
$month = isset($_GET['month']) ? $_GET['month'] : date('m'); // Default to current month if not set
$today = date('Y-m-d');

$monday = date('Y-m-d', strtotime('monday this week'));
$sunday = date('Y-m-d', strtotime('sunday this week'));

$from_date = isset($_GET['from']) ? $_GET['from'] : $monday;
$to_date = isset($_GET['to']) ? $_GET['to'] : $sunday;

// If month is provided, adjust from_date and to_date to cover the entire month
if (isset($_GET['month']) && $_GET['month'] != '') {
    $year = date('Y');
    $month = $_GET['month'];
    $first_day = date('Y-m-01', strtotime("$year-$month-01"));
    $last_day = date('Y-m-t', strtotime("$year-$month-01"));
    
    // Override from_date and to_date to show entire month
    if (!isset($_GET['from']) && !isset($_GET['to'])) {
        $from_date = $first_day;
        $to_date = $last_day;
    }
}
?>

<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="admin.php?id=1">Home</a></li>
            <li>Magnet Cleaning Record</li>
        </ul>
    </div>

    <div class="card">
        <form method="GET" action="">
            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
            <input type="hidden" name="month" value="<?php echo $month; ?>">
            
            <div class="row p-4">
                <div class="col-md-4">
                    <label for="from">Select Date From</label>
                    <input type="date" name="from" id="from" class="form-control" value="<?php echo $from_date; ?>">
                </div>

                <div class="col-md-4">
                    <label for="to">Select Date To</label>
                    <input type="date" name="to" id="to" class="form-control" value="<?php echo $to_date; ?>">
                </div>
                
                <div class="col-md-4">
                    <label for="filter">&nbsp;</label><br>
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <button type="button" class="btn btn-secondary" onclick="resetToCurrentWeek()">This Week</button>
                </div>
            </div>
        </form>
    </div>

    <div class="row mb-12">
        <div class="col-md-12 mb-12 mt-2">
            <div class="card text-left">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0 pl-3">Magnet Cleaning Record</h4>
                    <div class="p-3">
                        <?php
                        // Modified query to include month filter
                        $sq1 = mysqli_query($con, "SELECT * FROM tblmagnate WHERE date BETWEEN '$from_date' AND '$to_date' AND MONTH(date) = '$month'");
                        $rwo = mysqli_fetch_array($sq1);
                        if(isset($rwo['verify']) && $rwo['verify'] != ''){
                        ?>
                        <a href="admin.php?id=magnatepdf&from=<?php echo $from_date; ?>&to=<?php echo $to_date; ?>&month=<?php echo $month; ?>&vid=1" class="btn btn-warning mr-2">View Report</a>
                        <?php } else { ?>
                            <a href="admin.php?id=magnatepdf&from=<?php echo $from_date; ?>&to=<?php echo $to_date; ?>&month=<?php echo $month; ?>&vid=2" class="btn btn-danger mr-2">View Report</a>
                            <?php }?>
                        <a href="admin.php?id=magnate&month=<?php echo $month; ?>" class="btn btn-primary mr-2">Add New</a>
                        <a href="admin.php?id=millrecord" class="btn btn-success mr-2" style="float: right;">Back</a>
                    </div>
                </div>

                <div class="p-3">
                    <p class="mb-0">
                        Showing data from <strong><?php echo date('F d, Y', strtotime($from_date)); ?></strong> 
                        to <strong><?php echo date('F d, Y', strtotime($to_date)); ?></strong>
                        for month: <strong><?php echo date('F', mktime(0, 0, 0, $month, 1)); ?></strong>
                    </p>
                </div>

                <table class="table table-bordered" id="zero_configuration_table">
                    <thead>
                        <tr style="text-align: center;">
                            <th>#</th>
                            <th>Date</th>
                            <th>Magnet Name</th>
                            <th>Frequency</th>
                            <th>Any Findings</th>
                            <th>Reported To</th>
                            <th>Carried Out by</th>
                            <th>Corrective Actions</th>
                        </tr>
                        
                    </thead>
                    <tbody>
                        <?php
                        // Modified main query to include month filter
                        $query = "SELECT * FROM tblmagnate WHERE date BETWEEN '$from_date' AND '$to_date' AND MONTH(date) = '$month' ORDER BY date DESC";
                        $sq = mysqli_query($con, $query);
                        
                        if (mysqli_num_rows($sq) > 0) {
                            $i = 1;
                            while ($row = mysqli_fetch_array($sq)) {
                        ?>
                        <tr style="text-align:center;">
                            <td><?php echo $i++; ?></td>
                            <td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
                            <td><?php echo $row['magnet']; ?></td>
                            <td><?php
                            if($row['magnet'] == 'Intake Pit Magnet'){
                                echo 'Daily';
                            }else{
                                echo 'Once in Week';
                            }
                            ?></td>
                            <td><?php echo $row['findings']; ?></td>
                            <td><?php echo $row['report']; ?></td>
                            <td><?php echo $row['carried']; ?></td>
                            <td><?php echo $row['corrective']; ?></td>
                        </tr>
                        <?php 
                            }
                        } else {
                        ?>
                        <tr>
                            <td colspan="8" style="text-align: center;">
                                No records found for the selected date range in <?php echo date('F', mktime(0, 0, 0, $month, 1)); ?>.
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function resetToCurrentWeek() {
    const today = new Date();
    
    // Get current day (0=Sunday, 1=Monday, ..., 6=Saturday)
    const currentDay = today.getDay();
    
    // Calculate Monday (if Sunday, go back 6 days, otherwise go to Monday)
    const monday = new Date(today);
    const daysToMonday = currentDay === 0 ? -6 : 1 - currentDay;
    monday.setDate(today.getDate() + daysToMonday);
    
    // Calculate Sunday (6 days after Monday)
    const sunday = new Date(monday);
    sunday.setDate(monday.getDate() + 6);
    
    // Format dates
    const format = (date) => {
        const y = date.getFullYear();
        const m = String(date.getMonth() + 1).padStart(2, '0');
        const d = String(date.getDate()).padStart(2, '0');
        return `${y}-${m}-${d}`;
    };
    
    // Set values and submit
    document.getElementById('from').value = format(monday);
    document.getElementById('to').value = format(sunday);
    document.querySelector('form').submit();
}

// Set default dates on page load
window.onload = function() {
    const from = document.getElementById('from');
    const to = document.getElementById('to');
    
    if (!from.value || !to.value) {
        // Trigger the same logic as resetToCurrentWeek but don't submit
        const today = new Date();
        const currentDay = today.getDay();
        const monday = new Date(today);
        const daysToMonday = currentDay === 0 ? -6 : 1 - currentDay;
        monday.setDate(today.getDate() + daysToMonday);
        
        const sunday = new Date(monday);
        sunday.setDate(monday.getDate() + 6);
        
        const format = (date) => {
            const y = date.getFullYear();
            const m = String(date.getMonth() + 1).padStart(2, '0');
            const d = String(date.getDate()).padStart(2, '0');
            return `${y}-${m}-${d}`;
        };
        
        from.value = format(monday);
        to.value = format(sunday);
    }
}
</script>

















