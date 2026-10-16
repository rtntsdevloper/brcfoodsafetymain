<?php
include 'connection.php';
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
        $this->Cell(0, 0, ' Stationary Record', 0, 1, 'C');

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
$pdf->SetAuthor('Record');
$pdf->SetTitle('Stationary Record');
$pdf->SetSubject('Stationary Record');
$pdf->SetKeywords('Stationary Record, report');

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
        <td width="33%" style="text-align:center;">REC 7.2 003 Stationary Record
</td>
        <td rowspan="2" width="33%"  style="text-align:center;">Issue to: 11/12/2025</td>
        <td width="33%" style="text-align:center;">Author: Bijal Chauhan</td>
       
    </tr>

     <tr>
        <td width="33%" style="text-align:center;">Reason for Change: New Document</td>
    
        <td width="33%" style="text-align:center;">Authorised by: Mahesh Prajapati</td>
       
    </tr>
</table>

EOD;

$pdf->setFooterHTML($footerContent);
// Add a page
$pdf->AddPage();

// Start building HTML table
$pdf->SetY(40);

$sql1 = mysqli_query($con, "select * from mlmeats ");


$html = '<table border="1" cellpadding="4" width="100%">



<tr>
       <td width="765" style="color:red; font-weight:bold; "><div align="center">Metal detectable stationary must have been issued by Technical Staff.					
</div></td>
   </tr>
    <tr style="font-weight:bold; color:black; font-size:small;">
    
        <th width="16%">Date of Issuing Stationary</th>
        <th width="20%">Description of Issuing Stationary</th>
        <th width="18%">Stationary Issue To</th>
        <th width="18%">Stationary Issued by</th>
        <th width="18%">Is Used Stationary Returned</th>
        <th width="11%">Signature</th>
    </tr>';
while ($row = mysqli_fetch_array($sql)) {
    $html .=

        '<tr >
    <td>' . date('d-m-Y', strtotime($row['issueon'])) . '</td>
    <td>' . $row['desc'] . '</td>
    <td>' . $row['issue'] . '</td>
    <td>' . $row['issueby'] . '</td>
    <td>' . $row['return'] . '</td>
     <td><img src="precord/sign/' . $row['verifyn'] . '.png" width="120" height="40"><div class=""></div></td>

    </tr>';
}


// Close table
$html .= '</table>';
$pdf->writeHTML($html, true, false, true, false, '');



$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "finemed/upl1/Stationary_records_.pdf", "F");
?>
<a href="admin.php?id=stationary"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
<br>
<iframe src="upl1/Stationary_records_.pdf" frameborder="0" width="100%" height="600px"></iframe>