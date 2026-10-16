<?php
include 'connection.php';

$wdate = $_GET['pdate'];
require_once('tcpdf/tcpdf.php');

$sql = mysqli_query($con, " select * from `tbl_stationary` ");

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
        $this->Image($this->logo1Path, 15, 7, 23, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        // Add logo 2 (right)
        file_exists($this->logo2Path);
        $this->Image($this->logo2Path, 260, 7, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        // Main title
        $this->SetFont('courier', 'B', 16);
        $this->SetTextColor(0, 51, 102);
        $this->SetXY(12, 12);
        $this->Cell(0, 0, 'Blade check list', 0, 1, 'C');

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
$pdf->SetCreator('GK');
$pdf->SetAuthor('PSD');
$pdf->SetTitle('Wastage Record');
$pdf->SetSubject('Wastage Record');
$pdf->SetKeywords('Wastage Record, report');

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
        <td width="33%" style="text-align:center;">REC 4.9.2.002 </td>
        <td  width="34%"  style="text-align:center;">Issue to: 28/01/2021</td>
        <td width="33%" style="text-align:center;">Author: </td>
       
    </tr>

     <tr>
        <td width="33%" style="text-align:center;">Reason for Change: New Document</td>
    <td  width="34%"  style="text-align:center;">Version : 01</td>
        <td width="33%" style="text-align:center;">Authorised by: Mahesh Prajapati</td>
       
    </tr>
</table>

EOD;

$pdf->setFooterHTML($footerContent);
// Add a page
$pdf->AddPage();

// Start building HTML table
$pdf->SetY(40);

$sql = mysqli_query($con, "select * from  `fryer_blades_inspection`  where date='$wdate'");


$html = '<table border="1" cellpadding="3" width="100%">

    <tr style="font-weight:bold; color:black;text-align:center; font-size:small;background-color: #e6e6e6;">
                                   <th scope="col" width="5%">SNo.</th>
                                <th scope="col" width="10%">Date</th>
                                <th scope="col" width="10%">Time</th>
                                <th scope="col" width="15%">Fryer name</th>
                                <th scope="col" width="15%">Blade No</th>
                                <th scope="col" width="10%">No. of blades returned</th>
                                <th scope="col" width="10%">No. of blades issued</th>
                                <th width="10%">Are all blades intact?</th>
                                <th scope="col" width="15%">Sign</th>
    </tr>';
$r = 0;
while ($row = mysqli_fetch_array($sql)) {
    $r++;
    $html .=

        '<tr nobr="true" style="text-align:center; font-size:small" >
        <td>' . $r . '</td>
    <td>' . date('d-m-Y', strtotime($row['date'])) . '</td>
    <td>' . $row['time'] . '</td>
    <td>' . $row['fryer_name'] . '</td>
    <td>' . $row['blade_no'] . '</td>
    <td>' .  $row['blades_returned'] . '</td>
    <td>' . $row['blades_issued'] . '</td>
    <td>' . $row['blades_intact'] . '</td>
    <td><img src="precord/sign/' . $row['sign'] . '.png" alt="" width="80"></td>
   
    </tr>';
}


// Close table
$html .= '</table>';
$pdf->writeHTML($html, true, false, true, false, '');



$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "finemed/upl1/Blade_checks_" . $wdate . ".pdf", "F");
?>

<div class="row mb-12">
    <div class="col-md-12 mb-12">
        <div class="card text-left">
            <div class="card-body">

                <a href="admin.php?id=bladechecks"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                <a href="upl1/Blade_checks_<?php echo $wdate; ?>.pdf"><button class="btn btn-warning mr-3" style="float:right">View Report</button></a>


                <h4 class="card-title mb-3">Blade Checks List</h4>

                <p>List of Record</p>

                <div class="table-responsive">
                    <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                        <thead>
                            <tr>

                                <th scope="col">#</th>
                                <th scope="col">Date</th>
                                <th scope="col">Time</th>
                                <th scope="col">Fryer name</th>
                                <th scope="col">Blade No</th>
                                <th scope="col">No. of blades returned</th>
                                <th scope="col">No. of blades issued</th>
                                <th>Are all blades intact?</th>
                                <th scope="col">Sign</th>



                                <!-- <th>View Report</th> -->

                            </tr>
                        </thead>
                        <tbody>
                            <?php


                            $sql = mysqli_query($con, "SELECT * FROM `fryer_blades_inspection` where date='$wdate'");
                            $i = 0;
                            while ($row = mysqli_fetch_array($sql)) {
                                $i++;
                            ?>
                                <tr>

                                    <th scope="row"><?php echo $i; ?></th>
                                    <td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
                                    <td><?php echo $row['time']; ?></td>
                                    <td><?php echo $row['fryer_name']; ?></td>
                                    <td><?php echo $row['blade_no']; ?> </td>
                                    <td><?php echo $row['blades_returned']; ?> </td>
                                    <td><?php echo $row['blades_issued']; ?> </td>
                                    <td><?php echo $row['blades_intact']; ?> </td>
                                    <td><img src="precord/sign/<?php echo $row['sign']; ?>.png" alt="" width="80"></td>
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
</div>
</div>