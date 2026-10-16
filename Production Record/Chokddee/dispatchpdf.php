<?php
include 'connection.php';
require_once('tcpdf/tcpdf.php');
$tid = $_GET['tid'];


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
        $this->Image($this->logo2Path, 255, 7, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);


        // Main title
        $this->SetFont('courier', 'B', 22);
        $this->SetTextColor(0, 51, 102);
        $this->SetXY(12, 12);
        $this->Cell(0, 0, 'DISPATCH LOG', 0, 1, 'C');

        // Header line
        $this->SetLineWidth(0.5);
        $this->SetDrawColor(0, 102, 204);
        $this->Line(15, 28, 280, 28);
    }

    public function Footer()
    {
        $this->SetY(-22);
        $this->SetFont('courier', '', 8);
        $this->SetTextColor(0, 0, 0);

        // Footer line
        $this->SetLineWidth(0.2);
        $this->SetDrawColor(204, 204, 204);
        $this->Line(15, $this->GetY(), 280, $this->GetY());

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
$pdf->SetTitle('Dispatch Log');
$pdf->SetSubject('Dispatch Log');
$pdf->SetKeywords('Dispatch, report');

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(15, 30, 15);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(20);
$pdf->SetAutoPageBreak(TRUE, 25);

$sq = mysqli_query($con, "SELECT * FROM tblfreeze");
$footerContent = <<<EOD

<table border="1" cellpadding="5">

    <tr>
    
        <td width="33%" style="text-align:center;">  Giggling Squid NEW CPU Records   </td>
        <td  width="33%" style="text-align:center;">Version 3.4</td>
        <td width="33%" style="text-align:center;">Prepared by:Issue Date: November 2024 </td> 
    </tr>
    

</table>

EOD;

$pdf->setFooterHTML($footerContent);
// Add a page
$pdf->AddPage();
$pdf->SetY(40);

$sql1 = mysqli_query($con, "select * from tbldispatch  where tid= $tid");


$html = '<table border="1" cellpadding="4" width="100%">


     <tr>
       <td width="757" ><div align="center" style="color:rgba(0, 51, 102); font-weight:bold; ">DISPATCH LOG</div><div style="color:red;">Chilled meat and meat prep +4°C; Raw meat & meat prep +4°C<br>Frozen food -15°C; Frozen raw meat & meat prep -18°C </div></td>
     </tr>
 

    <tr style="font-weight:bold; color:black;">
    
        <th width="10%">Date</th>
         <th width="10%">Customer Store</th>
        <th width="9%">Product</th>
        <th width="10%">Use by date/Best before date</th>
        <th width="11%">Total Weight/Quantity</th>
        <th width="10%">Product Temperature</th>
        <th width="10%">Vehicle Temperature</th>
        <th width="10%">Van Hygeine</th>
        <th width="10%">Packing Integrity</th>
        <th width= "10%">Signature</th>
    </tr>';

    while ($row = mysqli_fetch_assoc($sql1)) {
    $html .=
        '<tr>
    <td>' . date('d-m-Y',strtotime($row['date'])) . '</td>
    <td>' . $row['cstore'] . '</td>
    <td>' . $row['product'] . '</td>
    <td>' . date('d-m-Y',strtotime($row['useby'])). '</td>
    <td>' . $row['qty'] . '</td>
    <td>' . $row['ptemp'] . '</td>
    <td>' . $row['vtemp'] . '</td>
    <td>' . $row['vhygiene'] . '</td>
    <td>' . $row['pack'] . '</td>
    <td><img src="precord/sign/'.$row['sign'].'" width="120" height="40"></td>
    </tr>';
}

// Close table
$html .= '</table>';

// Write HTML to PDF
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "/brcfoodsafety/upl1/Freeze_Records_.pdf", "F");
?>
<a href="admin.php?id=1"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a><br><br>
<iframe src="upl1/Freeze_Records_.pdf" frameborder="0" width="100%" height="600px"></iframe>