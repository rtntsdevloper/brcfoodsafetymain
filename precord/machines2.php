<?php
include 'connection.php';

$wcode = $_GET['wcode'];
require_once('tcpdf/tcpdf.php');



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
        $this->Cell(0, 0, 'Daily Machine Cleaning Record', 0, 1, 'C');

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
        <td width="33%" style="text-align:center;"> </td>
        <td  width="34%"  style="text-align:center;">Issue to: </td>
        <td width="33%" style="text-align:center;">Author: </td>
       
    </tr>

     <tr>
        <td width="33%" style="text-align:center;">Reason for Change:</td>
    <td  width="34%"  style="text-align:center;">Version : </td>
        <td width="33%" style="text-align:center;">Authorised by: </td>
       
    </tr>
</table>

EOD;

$pdf->setFooterHTML($footerContent);
// Add a page
$pdf->AddPage();

// Start building HTML table
$pdf->SetY(40);
$html = '';
$html .= '<table border="1" cellpadding="3" width="100%">';
$sql = mysqli_query($con, "select * from `dailymachine1` where date ='$wcode'");
foreach ($sql as $rowl) {

    $vid = $rowl['id'];



    $html .= '

    <tr style="background-color: #B0E0E6;">

                                        <th scope="col" colspan="3">Date : ' . $rowl['date'] . '</th>
                                        <th scope="col" colspan="2">Time : ' . $rowl['atime'] . '</th>


                                    </tr>
                                    <tr style="background-color: #E5E4E2;">

                                        <th scope="col">S No.</th>
                                        <th scope="col">Machine Name</th>
                                        <th scope="col">Is Cleaned</th>
                                        <th scope="col">Comments</th>
                                        <th scope="col">Image</th>


                                    </tr>';
    $sqlx = mysqli_query($con, "SELECT * FROM `dailymachine2` WHERE vid='$vid' ");
    $r = 0;
    while ($row = mysqli_fetch_array($sqlx)) {
        $r++;
        $html .=

            '<tr>

                                        <th scope="row">' . $r . '  </th>
                                        <td>' . $row['name'] . '</td>
                                        <td>' . $row['checkq'] . '</td>
                                        <td>' . $row['cmnt'] . '</td>
                                        <td>';



        if ($row['file'] != '') {

            $html .= ' <a href="' . $row['file'] . '" target="_blank">View</a>';
        }


        $html .= '</td>

                                    </tr>';
    }
}


// Close table
$html .= '</table>';
$pdf->writeHTML($html, true, false, true, false, '');

$wdatexc = "Machine_".$wcode;

$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "finemed/precord/files/machines_" . $wdatexc . ".pdf", "F");
?>


<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="admin.php?id=1"></a></li>
            <li>Machine Cleaning Record </li>
        </ul>
    </div>
    <div class="row mb-12">
        <div class="col-md-12 mb-12">
            <div class="card text-left">
                <div class="card-body">
                    <a href="admin.php?id=machines1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
                    <a href="precord/files/machines_<?= $wdatexc ?>.pdf"><button class="btn btn-success" style="float:right; margin-left:15px">View Report</button></a>


                    </a>

                    <h4 class="card-title mb-3">Machine Cleaning Record</h4>

                    <p>List of Record</p>

                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                            <thead>



                                <?php
                                $wcode = $_GET['wcode'];
                                $sqnl = mysqli_query($con, "SELECT * FROM `dailymachine1` WHERE date ='$wcode' ");
                                foreach ($sqnl as $rowl) {
                                    $vid = $rowl['id'];
                                ?>
                                    <tr>

                                        <th scope="col" colspan="3">Date : <?php echo $rowl['date']; ?></th>
                                        <th scope="col" colspan="2">Time : <?php echo $rowl['atime']; ?></th>


                                    </tr>
                                    <tr>

                                        <th scope="col">S No.</th>
                                        <th scope="col">Machine Name</th>
                                        <th scope="col">Is Cleaned</th>
                                        <th scope="col">Comments</th>
                                        <th scope="col">Image</th>


                                    </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sql = mysqli_query($con, "SELECT * FROM `dailymachine2` WHERE vid='$vid' ");
                                    $i = 0;
                                    while ($row = mysqli_fetch_array($sql)) {
                                        $i++;
                                ?>
                                    <tr>

                                        <th scope="row"><?php echo $i; ?></th>
                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php echo $row['checkq']; ?></td>
                                        <td><?php echo $row['cmnt']; ?></td>
                                        <td><?php if ($row['file'] != '') { ?>
                                                <a href="<?php echo $row['file']; ?>" target="_blank">View</a>
                                            <?php } ?>
                                        </td>

                                    </tr>
                                <?php
                                    }
                                ?>
                            </tbody>
                        <?php
                                }
                        ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>