<?php
include 'connection2.php';
require('tcpdf/tcpdf.php');
// $date = $_GET['date'];
// $ac = $_GET['ac'];
// $sno = $_GET['sno'];
// $date1 = date('d/m/Y', strtotime($_GET['date']));
$selectedDate = $_GET['date'];
$fdate = date("d/m/Y", strtotime($selectedDate));


// $dt = date("d-m-Y", strtotime($roww['date']));

class MYPDF extends TCPDF
{

    private $logo1Path = 'images/logo1.png';
    private $logo2Path = 'images/rtnts.png';
    private $footerHTML = '';

    public function Header()
    {
        // Set header background
        $this->SetFillColor(255, 255, 255);
        $this->Rect(0, 0, $this->getPageWidth(), 30, 'F');

        // Add logo 1 (left)
        file_exists($this->logo1Path);
        $this->Image($this->logo1Path, 15, 7, 25, '20', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        // Add logo 2 (right)
        file_exists($this->logo2Path);
        $this->Image($this->logo2Path, 260, 7, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        // Main title
        $this->SetFont('courier', 'B', 16);
        $this->SetTextColor(0, 51, 12);
        $this->SetXY(12, 12);
        $this->Cell(0, 0, 'Frying RECORD', 0, 1, 'C');

        // Header line
        $this->SetLineWidth(0.5);
        $this->SetDrawColor(0, 102, 204);
        $this->Line(15, 28, 285, 28);
    }

    public function Footer()
    {
        $this->SetY(-20);
        $this->SetFont('courier', '', 8);
        $this->SetTextColor(0, 0, 0);

        // Footer line
        $this->SetLineWidth(0.2);
        $this->SetDrawColor(204, 204, 204);
        $this->Line(15, $this->GetY(), 285, $this->GetY());

        // Custom footer HTML if set
        if (!empty($this->footerHTML)) {
            $this->SetY(-15);
            $this->writeHTML($this->footerHTML, true, false, true, false, '');
        } else {
            // Default footer text
            $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 0, 'C');
        }
    }

    public function setFooterHTML($html)
    {
        $this->footerHTML = $html;
    }


}

// Create new PDF document
$pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator('Your Company');
$pdf->SetAuthor('Record');
$pdf->SetTitle('');
$pdf->SetSubject('Daily Checklist');
$pdf->SetKeywords('checklist, report');

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(15, 30, 15, 15);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(20);
$pdf->SetAutoPageBreak(TRUE, 25);


$footerContent = <<<EOD

<table border="1" cellpadding="4" width="102%" >
    <tr>
    
        <td width="33%" rowspan="2">Reason For Change:New Document.</td>
        <td  width="33%"  >Issue Date: 14/08/2025</td>
        <td width="33%" >Issued by: Navdeep Kaur</td> 
    </tr>
    <tr>
    
        <td width="33%" >Version 1</td>
        <td width="33%" >Authorised by: Paramvir S. Deol</td> 
    </tr>
</table>

EOD;

$pdf->setFooterHTML($footerContent);


$pdf->AddPage();

// Start building HTML table
$pdf->SetY(40);



$sql1 = mysqli_query($con, "SELECT * from tblcookingtemp WHERE DATE(date)='$selectedDate' ");
$i = 1;


// Freezer Record Table (First Table)
$html = '<table border="1" cellpadding="4" width="100%">

<tr style="font-weight:bold; color:black; font-size:small;">
    <th width="10%">Sno</th>
    <th width="10%">Date</th>
    
    <th width="20%">Product</th>
    <th width="10%">Time</th>
    <th width="20%">Temperature</th>
    <th width="10%">Oil Temperature</th>
    <th width="10%">Comment</th>
    <th width="10%">Initials</th>
 
</tr>';

while ($row = mysqli_fetch_array($sql1)) {
    $pr = $row['product'];
    $sql11 = mysqli_query($con, "SELECT * FROM `tbldailyproduct` WHERE id='" . $pr . "' ");
    $row11 = mysqli_fetch_array($sql11);
    $pname = $row11['name'];

    $html .= '<tr>
    <td>' . $i++ . '</td>
    <td>' . htmlspecialchars($fdate) . '</td>
    <td>' . htmlspecialchars($pname) . '</td>
    <td>' . htmlspecialchars($row['time']) . '</td>
    <td>' . htmlspecialchars($row['temp']) . '&deg;C</td>
    <td>' . htmlspecialchars($row['oiltemp']) . '&deg;C</td>
    <td>' . htmlspecialchars($row['cmnt']) . '</td>
    <td>' . htmlspecialchars($row['initial']) . '</td>
</tr>';
}

$html .= '</table>';
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Ln(10);

$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "upl1/Cooking-Record.pdf", "F");
?>
<!-- <iframe src="upl1/Cooking-Record.pdf" frameborder="0" width="100%" height="600px"></iframe> -->
<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Dashboard</a></li>
            <li>Home</li>
        </ul>
    </div>













<div class="row ">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">

                <!-- <div class="row"> -->
                     <h3 style="float: left;" class="ml-2">Frying Record </h3>
               

                    <a href="admin.php?id=viewtemp1&tid=14"><button class="btn btn-primary mr-2"
                      style="float: right;" >Back </button></a>
                    <a href="upl1/Cooking-Record.pdf" target="_blank"><button class="btn btn-info mr-3"
                      style="float:right;" >View</button></a>
               </div>

                <div class="col-lg-12" id="table-responsive">
                    <div class="table-responsive">
                        <table id="datatable" class="table data-table table-striped">
                            <thead>
                                <tr class="ligth">
                                    <th>Sno</th>
                                    <!-- <th>Item</th> -->
                                    <th>Date</th>
                                    <th>Product</th>
                                    <th>Time</th>
                                    <th>Product Temperature</th>
                                    <th>Oil Temperature</th>

                                    <th>Comment</th>
                                    <th>Checked By </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include 'connection2.php';


                                $sql = mysqli_query($con, "SELECT * FROM tblcookingtemp where DATE(date)='$selectedDate'");
                                $i = 1;
                                while ($row = mysqli_fetch_array($sql)) {

                                    $pr = $row['product'];
                                    $sql1 = mysqli_query($con, "select * from `tbldailyproduct` where id='$pr' ");
                                    $row1 = mysqli_fetch_array($sql1);

                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?> </td>

                                        <td><?php echo date('d-m-y', strtotime($row['date'])); ?></td>

                                        <td><?php echo
                                            $row1['name'];
                                        ?></td>
                                        <td><?php echo $row['time']; ?></td>
                                        <td><?php echo $row['temp']; ?>&deg;C</td>
                                        <td><?php echo $row['oiltemp']; ?><sup>o</sup>C</td>
                                        <td><?php echo $row['cmnt']; ?></td>
                                        <td><?php echo $row['initial']; ?></td>




                                    </tr>



                                    <?php
                                    $i++;

                                }

                                ?>


                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>