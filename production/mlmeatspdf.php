
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
$pdf->SetCreator('Your Company');
$pdf->SetAuthor('Record');
$pdf->SetTitle('ML Meats');
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
        <td width="33%" style="text-align:center;">REC 7.2 002 Stationary Record
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

// Start building HTML table
$pdf->SetY(40);

 $sql1 = mysqli_query($con, "select * from mlmeats ");
 

$html = '<table border="1" cellpadding="4" width="100%">


<tr>
      
       <td width="765" style="color:rgba(0, 51, 102); font-weight:bold; Background-color:white;"><div align="center">ML Meat Supplies
Stationary Record					
</div></td></tr>
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
 while ($row = mysqli_fetch_array($sql1)) {
    $html .=
    '<tr>
    <td>' . $row['date'] . '</td>
    <td>' . $row['disc'] . '</td>
    <td>' . $row['stationary'] . '</td>
    <td>' . $row['stationaryby'] . '</td>
    <td>' . $row['returned'] . '</td>
     <td>' . $row['sign'] . '</td>

    </tr>';
  }


// Close table
$html .= '</table>';
$pdf->writeHTML($html, true, false, true, false, '');


$pdf->Ln(10);


$sql2 = mysqli_query($con, "SELECT * FROM mldetect");

// Add second table structure with simplified border control
$html2 = '<table border="1" cellspacing="0" cellpadding="4" width="100%" style="border:1px solid #000; border-collapse: collapse;">

<tr>
<td width="765" style="color:rgba(0, 51, 102); font-weight:bold; Background-color:white;"><div align="center" color="">Metal Detectable stationary Check					
					
</div>
    </td>

</tr>
<tr>
    <td width="765" style="color:blue; font-weight:bold; background-color:;"><div align="center" color="red">All new batches of stationary must be passed through the metal detector to ensure they metal detect. The check must be recorded below:					
</div>
    </td>
</tr>
<tr style="font-weight:bold; color:black; font-size:small;">
    <th width="15%"> Delivery Date</th>
    <th width="15%">Batch No</th>
    <th width="15%">Date of Check </th>
    <th width="25%">Rejected by Metal Detector</th>
    <th width="15%">Checked By</th>
    <th width="16%">Signature</th>
</tr>';


while ($row1 = mysqli_fetch_array($sql2)) {
    $html2 .=
    '<tr>
    <td>' . $row1['date'] . '</td>
    <td>' . $row1['batch'] . '</td>
    <td>' . $row1['checked'] . '</td>
    <td>' . $row1['rejected'] . '</td>
    <td>' . $row1['checkedby'] . '</td>
     <td>' . $row1['signed'] . '</td>

    </tr>';
}
$html2 .= '</table>';

$pdf->writeHTML($html2, true, false, true, false, '');



ob_end_clean();
$pdf->Output('staionary_record_' . date('Ymd_His') . '.pdf', 'I');
exit;