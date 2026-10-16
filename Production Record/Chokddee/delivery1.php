<?php
$tid = $_GET['tid'];    



include 'connection.php';
require_once('tcpdf/tcpdf.php');


class MYPDF extends TCPDF
{

    private $logo1Path = 'images/1.png';
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
        $this->SetFont('courier', 'B', 17);
        $this->SetTextColor(0, 51, 102);
        $this->SetXY(12, 12);
        $this->Cell(0, 0, 'Delivery And Delivery Vehicle Condition Log', 0, 1, 'C');

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

// Create new PDF document using custom MYPDF class
$pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator('Your Company');
$pdf->SetAuthor('Delivery');
$pdf->SetTitle('Delivery Report');
$pdf->SetSubject('Delivery');
$pdf->SetKeywords('delivery, report');

// Set default monospaced font
$pdf->SetDefaultMonospacedFont('courier');

// Set margins
$pdf->SetMargins(15, 30, 15);
$pdf->SetHeaderMargin(10);

$pdf->SetAutoPageBreak(TRUE, 25);


$footerContent = <<<EOD

<table border="1" cellpadding="4" width="102%" >
    <tr>
        <td width="33%" style="text-align:center;">REC 4.16-001
        </td>
        <td  width="33%"  style="text-align:center;">Issue date: 17/04/2025</td>
        <td width="33%" style="text-align:center;">Author: Bijal Chauhan</td>
       
    </tr>

    <tr>
     
        <td width="33%" style="text-align:center;">Reason for Change: New form</td>
         <td width="33%" style="text-align:center;">Issue number: 01</td>
    
        <td width="33%" style="text-align:center;">Authorised by: Paramvir S. Deol</td>
       
    </tr>
</table>
EOD;

$pdf->setFooterHTML($footerContent);
$sq = mysqli_query($con, "SELECT * FROM tbldelivery where tid= $tid");
// Add a page
$pdf->AddPage();
$pdf->SetY(40);

$html = '<table border="1" cellpadding="4" style="font-size:10px;" width="100%">
    <tr>
       
        <th><b>Date & Time of Dispatch</b></th>
       
        <th><b>Customer Invoice Number</b></th>
        <th><b>Vehicle Inspection</b></th>
        <th><b>Product Visual Inspection</b></th>
        <th><b>Temperature of Vehicle</b></th>
        <th><b>Delivery sent by</b></th>
        <th><b>Signature</b></th>
        <th><b>Driver Name</b></th>
        <th><b>Vehicle Reg. No.</b></th>
        
    </tr>';
   
while ($row = mysqli_fetch_assoc($sq)) {
     $dt = date("d-m-Y",strtotime($row['Date']));
    $dt1 = $dt." ".$row['ttime'];
    $html .= '<tr>

    <td>' . $dt1. '</td>
    <td>' . $row['cinvoice'] . '</td>
    <td>' . $row['vehcheck'] . '</td>
    <td>' . $row['prodcheck'] . '</td>
    <td>' . $row['tempvehicle'] . '<sup>o</sup>C</td>
    <td>' . $row['deliverysent'] . '</td>
     <td> <img src="precord/sign/' . $row['sign'] . '" width="120" height="40"></td>
    <td>' . $row['drivername'] . '</td>
    <td>' . $row['vehiclereg'] . '</td>
    
    </tr>';
}
$html .= '</table>';

$pdf->writeHTML($html, true, false, true, false, '');

$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "/brcfoodsafety/upl1/Delivery_Records_.pdf", "F");
?>
<a href="admin.php?id=deliverynote&tid=<?php echo $tid;?>"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
<iframe src="upl1/Delivery_Records_.pdf" frameborder="0" width="100%;" height="600px"></iframe>