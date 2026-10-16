
<?php
include 'connection.php';
require_once('tcpdf/tcpdf.php');

$dt = date("d-m-Y", strtotime($roww['date']));

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
        $this->Image($this->logo1Path, 15, 7, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        // Add logo 2 (right)
        file_exists($this->logo2Path);
        $this->Image($this->logo2Path, 260, 7, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);


        // Main title
        $this->SetFont('courier', 'B', 16);
        $this->SetTextColor(0, 51, 102);
        $this->SetXY(12, 12);
        $this->Cell(0, 0, 'Plaster Record', 0, 1, 'C');

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
// $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator('Your Company');
$pdf->SetAuthor('Record');
$pdf->SetTitle('Plaster Record');
$pdf->SetSubject('Daily Checklist');
$pdf->SetKeywords('checklist, report, Plaster');

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(15, 30, 15);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(20);
$pdf->SetAutoPageBreak(TRUE, 25);


$footerContent = <<<EOD

<table border="1" cellpadding="3" >
    <tr>
        <td width="33%" style="text-align:center;">REC 7.2 002 Plaster Record
</td>
        <td rowspan="2" width="33%"  style="text-align:center;">Issue to: 25/09/2023</td>
        <td width="33%" style="text-align:center;">Author: Bijal Chauhan</td>
       
    </tr>

     <tr>
        <td width="33%" style="text-align:center;">Reason for Change: Form Reviewed</td>
       
        <td width="33%" style="text-align:center;">Authorised by: P.S. Deol</td>
       
    </tr>
</table>
EOD;

$pdf->setFooterHTML($footerContent);
// Add a page
$pdf->AddPage();


// Create info box


// Start building HTML table
$pdf->SetY(40);

$sql1 = mysqli_query($con, "select * from tblplasterrecord");
$html = '<table border="1" cellpadding="4" width="100%">
<tr>     
       <td width="749" style="color:rgba(0, 51, 102); font-weight:bold; Background-color:white;"><div align="center">Plaster Record</div></td>
   </tr>
<tr>
      
       <td width="749" style=" font-weight:bold; "><div align="center">Plasters issued to staff working in production must have their plasters checked at the end of the shift by the supervisor / manager.				</div></td>
   </tr>

   

    <tr style="font-weight:bold; color:black;">
    
        <th width="19%">Date Of Issuing Plaster</th>
        <th width="18%">Plaster Issued to</th>
        <th width="18%">Plaster Issued By</th>
        <th width="31%">Plaster checked and intact end of shift?</th>
        <th width="13%">Checked By:</th>
    </tr>';

while ($row = mysqli_fetch_assoc($sql1)) {
    $html .=
        '<tr>
    <td>' . $row['dateissue'] . '</td>
    <td>' . $row['plasterissue'] . '</td>
    <td>' . $row['issueby'] . '</td>
    <td>' . $row['plaster'] . '</td>
    <td>' . $row['checkedby'] . '</td>
    </tr>';
}


// Close table
$html .= '</table>';

// Write HTML to PDF
$pdf->writeHTML($html, true, false, true, false, '');



$pdf->Ln(10);


$sql2 = mysqli_query($con, "SELECT * FROM metal");

// Add second table structure with simplified border control
$html2 = '<table border="1" cellspacing="0" cellpadding="4" width="100%" style="border:1px solid #000; border-collapse: collapse;">
<tr>
    <td width="749" style="color:rgba(0, 51, 102); font-weight:bold; text-align:center; background-color:white;">METAL DETECTION PLASTER CHECK</td>
</tr>

<tr>
    <td width="749" style=" font-weight:bold; text-align:center; ">All new batches of plasters must be passed through the metal detector to ensure they metal detect. The check must be recorded below				
</td>
</tr>
<tr style="font-weight:bold; color:black; ">
    <th width="20%">Delivery Date</th>
    <th width="20%">Batch No</th>
    <th width="20%">Date of Check</th>
    <th width="25%">Rejected by Metal Detector</th>
    <th width="13%">Signed</th>
</tr>';

while ($row1 = mysqli_fetch_array($sql2)) {
    $html2 .= '<tr>
    <td>'.$row1['date'].'</td>
    <td>'.$row1['batch'].'</td>
    <td>'.$row1['checked'].'</td>
    <td>'.$row1['rejected'].'</td>
    <td>'.$row1['signed'].'</td>
    </tr>';
}

$html2 .= '</table>';

$pdf->writeHTML($html2, true, false, true, false, '');






// Clean output buffer and send PDF
ob_end_clean();
$pdf->Output('plaster_records_' . date('Ymd_His') . '.pdf', 'I');
exit;
