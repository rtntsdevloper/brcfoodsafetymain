<?php
include 'connection.php';

$wdate = $_GET['wdate'];
require_once('tcpdf/tcpdf.php');



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
        $this->Cell(0, 0, 'Wastage Record', 0, 1, 'C');

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
        <td width="33%" style="text-align:center;">REC 6.1.003a </td>
        <td  width="34%"  style="text-align:center;">Issue to: 11/12/2025</td>
        <td width="33%" style="text-align:center;">Author: Bijal Chauhan</td>
       
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

$sql = mysqli_query($con, "select * from `tbl_wastage` where date='$wdate'");


$html = '<table border="1" cellpadding="3" width="100%">

    <tr style="font-weight:bold; color:black;text-align:center; font-size:small;background-color: #e6e6e6;">
                                    <th scope="col" width="5%">S No.</th>
                                    <th scope="col" width="9%">Packaging Batch</th>
                                     <th scope="col" width="10%">Date</th>
                                      <th scope="col" width="10%">SKU Batchcode/Batchcode</th>
                                    <th scope="col" width="10%">BBD</th>
                                    <th scope="col" width="15%">GRN(Batchcode)</th>
                                    <th scope="col" width="9%">Is labelling coorect as per packaging</th>
                                    <th scope="col" width="11%">Corrective Action(if applicable)</th>
                                    
    </tr>';
$r = 0;
while ($row = mysqli_fetch_array($sql)) {
    $r++;
    $html .=

        '<tr nobr="true" style="text-align:center; font-size:small" >
        <td>' . $r . '</td>
    <td>' . date('d-m-Y', strtotime($row['date'])) . '</td>
    <td>' . $row['area'] . '</td>
    <td>' . $row['name'] . '</td>
    <td>' . $row['type'] . '</td>
    <td>' .  $row['batch'] . '</td>
    <td>' . $row['qty'] . '</td>
    <td>' .  $row['reason'] . '</td>
    <td>' . $row['action'] . '</td>
    <td>' . $row['actionby'] . '</td>
   
    </tr>';
}


// Close table
$html .= '</table>';
$pdf->writeHTML($html, true, false, true, false, '');



$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "upl1/Wastage_records_" . $wdate . ".pdf", "F");
?>
<a href="admin.php?id=wastageview&wcode=<?= $wdate ?>"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
<br>
<iframe src="upl1/Wastage_records_<?= $wdate ?>.pdf" frameborder="0" width="100%" height="600px"></iframe>