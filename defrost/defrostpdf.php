<?php
$date = $_GET['date'];
include 'connection.php';
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
        $this->Image($this->logo1Path, 15, 7, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        // Add logo 2 (right)
        file_exists($this->logo2Path);
        $this->Image($this->logo2Path, 260, 7, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);


        // Main title
        $this->SetFont('century gothic', 'B', 20);
        $this->SetTextColor(0, 51, 102);
        $this->SetXY(12, 12);
        $this->Cell(0, 0, ' Defrost Record', 0, 1, 'C');

        // Header line
        $this->SetLineWidth(0.5);
        $this->SetDrawColor(0, 102, 204);
        $this->Line(15, 28, 285, 28);
    }

    public function Footer()
    {
        $this->SetY(-20);
        $this->SetFont('century gothic', '', 8);
        $this->SetTextColor(0, 0, 0);

        // Footer line
        // $this->SetLineWidth(0.2);
        // $this->SetDrawColor(204, 204, 204);
        // $this->Line(15, $this->GetY(), 195, $this->GetY());

        // Custom footer HTML if set
        if (!empty($this->footerHTML)) {
            $this->SetY(-18);
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
$pdf->SetMargins(15, 30, 15);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(20);
$pdf->SetAutoPageBreak(TRUE, 25);


$footerContent = <<<EOD

<table border="1" cellpadding="3">
    <tr>
   
        <td width="33%" style="text-align:center;">Date Issued:11/03/2026 </td>
       <td rowspan="2" width="33%" style="text-align:center;">DOC Ref : REC 6.1.009 Defrost Record</td>
        <td width="33%" style="text-align:center;">Prepared by : Bijal Chauhan</td>
       
    </tr>
    <tr>
    <td width="33%" style="text-align:center;">Version No. 1</td>
        
        <td width="33%" style="text-align:center;">Authorised by : Paramvir S. Deol</td>
        </tr>
<tr>
<td width="33%" style="text-align:center;">Reason for Change: New Form</td>
</tr>
</table>

EOD;

$pdf->setFooterHTML($footerContent);
// Add a page
$pdf->AddPage();


// Start building HTML table
$pdf->SetY(40);

$sql1 = mysqli_query($con, "select * from tbldefrost where date='$date' order by id desc");



$html = '<table border="1" cellpadding="3" width="100%  " style="border-collapse: collapse;text-align:center;font-size:11px; font-family:century-gothic;">


     <tr>
       <td width="757" style="color:rgba(0, 51, 102); font-weight:bold; "><div align="center">Defrost Record</div></td>
     </tr>


   

    <tr style="font-weight:bold; color:black;">
    
        <th width="9%">Date</th>
        <th width="10%">Product Name</th>
        <th width="9%">Quantity</th>
        <th width="11%">Batch Code/UBD</th>
        <th width="11%">Temperature</th>
       
        <th width="11%">Defrost Start Date</th>
         <th width="11%">Chiller Temperature</th>
       
        <th width="11%">Defrost Finish Date</th>
          <th width="17%">Product Temperature after defrost</th>
       
    </tr>';

while ($row = mysqli_fetch_assoc($sql1)) {

if(!empty($row['moved2'])){
    $finish=date('d-m-Y', strtotime($row['moved2']));
}else{
    $finish='';
}

    $html .=
        '<tr>
    <td>' . date('d-m-Y', strtotime($row['date'])) . '</td>
    <td>' . $row['product'] . '</td>
    <td>' . $row['qty'] . 'Kg</td>
    <td>' . $row['trace'] . '</td>
    <td>' . $row['temp'] . '<sup>o</sup>C</td>
        <td>' . date('d-m-Y', strtotime($row['moved'])) . '</td>
        <td>' . $row['ctemp'] . '<sup>o</sup>C</td>
        <td>' . $finish . '</td>
       <td>' . $row['temp2'] . '<sup>o</sup>C</td>

    </tr>';
}

// Close table
$html .= '</table>';

// Write HTML to PDF
$pdf->writeHTML($html, true, false, true, false, '');

$sql2 = mysqli_query($con, "select * from tbldefrost where date='$date'");
$html1 = '<table border="1" cellpadding="3" width="100%" style="border-collapse: collapse;text-align:center;font-size:11px; font-family:century-gothic;">



    <tr style="font-weight:bold; color:black;">
    
       
          <th width="30%">Comment</th>
        <th width="30%">Checked By</th>
        <th width="40%">Signature</th>
    </tr>';

while ($row1 = mysqli_fetch_assoc($sql2)) {
    $html1 .=
        '<tr>
            <td>' . $row1['cmnt'] . '</td>
            <td>' . $row1['sign'] . '</td>
            <td><img src="upl1/' . $row1['signature'] . '" alt="Signature" width="100" height="50"></td>
        </tr>';
}

// Close table
$html1 .= '</table>';

// Write HTML to PDF
$pdf->writeHTML($html1, true, false, true, false, '');

$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "finemed/upl1/Defrost_Records_" . $date . ".pdf", "F");

?>
<iframe src="upl1/Defrost_Records_<?php echo $date; ?>.pdf" frameborder="0" width="100%" height="600px"></iframe>