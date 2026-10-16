<?php
include 'connection.php';
require_once('tcpdf/tcpdf.php');
$selectedDate = $_GET['date'];
$formattedDate = date("d/m/Y", strtotime($selectedDate));
$pid = $_GET['eid'];
$ac = $_GET['ac'];

$sq = mysqli_query($con, "SELECT * FROM tblouter1 where id= '$pid'");
$row1 = mysqli_fetch_assoc($sq);
// $dt = date("d-m-Y", strtotime($roww['date']));

 $pbdt = mysqli_query($con, "SELECT * FROM `tblouter3` WHERE eid='$pid' order by pbdate desc");
 $pbdt1 = mysqli_fetch_assoc($pbdt);
 $pbdt2 = $pbdt1['pbdate'];
   

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
        $this->Cell(0, 0, 'OUTER PACKAGING CHECK SHEET ', 0, 1, 'C');

        // Header line
        $this->SetLineWidth(0.5);
        $this->SetDrawColor(0, 102, 204);
        $this->Line(15, 28, 280, 28);
    }

    public function Footer()
    {
        $this->SetY(-25);
        $this->SetFont('courier', '', 8);
        $this->SetTextColor(0, 0, 0);

        // Footer line
        $this->SetLineWidth(0.2);
        $this->SetDrawColor(204, 204, 204);
        $this->Line(15, $this->GetY(), 280, $this->GetY());

        // Custom footer HTML if set
        if (!empty($this->footerHTML)) {
            $this->SetY(-22);
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
$pdf->SetTitle('Outer Packaging Record');
$pdf->SetSubject('Packaging Record ');
$pdf->SetKeywords('Delivery, report');

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(15, 30, 15);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(20);
$pdf->SetAutoPageBreak(TRUE, 25);

$footerContent = <<<EOD

<table border="1" cellpadding="5">

    <tr>
    
        <td width="33%" style="text-align:center;">   Issue date: 16/04/24 </td>
        <td  width="33%" style="text-align:center;">Version: 01</td>
        <td width="33%" style="text-align:center;">DOC REF REC: 5.5.003</td> 
    </tr>
    
    <tr>
        <td width="33%" style="text-align:center;">Reason for change: New Document  </td>
        <td  width="33%" style="text-align:center;">Issued by: Sonia Sharma</td>
        <td width="33%" style="text-align:center;">Authorised by: Paramvir S. Deol</td> 
    </tr>
    

</table>

EOD;

$pdf->setFooterHTML($footerContent);
// Add a page
$pdf->AddPage();
$pdf->SetY(40);

$sql1 = mysqli_query($con, "SELECT * FROM tblouter where eid='$pid'");

$firstRow = mysqli_fetch_assoc($sql1);


mysqli_data_seek($sql1, 0);

$html = '<table border="1" cellpadding="4" width="100%" style="font-size:small; text-align:center;">
    <tr>
        <td><b>Operator Name: </b>  ' . $row1['name'] . '</td>
       <td><b>Date: </b> ' . date('d-m-Y', strtotime($row1['date'])) . '</td>
        <td><b>Machine Number: </b>  ' . $row1['machine'] . '</td>
         <td><b>Batchcode: </b>  ' . $row1['prodbatch'] . '</td>
    </tr>
     <tr>
       
        <td><b>Best Before: </b> ' . date('d-m-Y', strtotime( $pbdt2)) . '</td>
       <td color="red" width="75%">Average Weight Must Not be Less than declared Weight. Stop Line if average Weight drops below declare weight.</td>
    </tr>
    <tr>
        <td width="757" colspan="10"><div align="center" style="color:rgba(0, 51, 102); font-weight:bold;">Report</div></td>
    </tr>
   
   <tr>
                                   
                                    <th  width="8%">Time</th>
                                    <th  width="20%">Product code & Product Name</th>
                                    <th  width="9%">Is Outer box label correct</th>
                                    <th  width="9%">Outer coding(BB & Day coding)</th>
                                    <th  width="9%">Inner coding(BB & Day coding)</th>
                                    <th  width="9%">No. of Inners Per Outer</th>
                                    <th  width="9%">Is Inner Packaging correct?</th>
                                    <th  width="9%">In Spec (Y/N)</th>
                                    <th  width="9%">Pack Sealed Correctly (Y/N)</th>
                                    <th  width="9%">Sign</th>
                                </tr>';

while ($row = mysqli_fetch_assoc($sql1)) {
    
    
    $html .= '
    <tr>
       
        <td>' . $row['time'] . '</td>
        <td>' . $nxn . '</td>
        <td>' . $row['olabel'] . '</td>
        <td>' . $row['ocoding'] . '</td>
        <td>' . $row['icoding'] . '</td>
        <td>' . $row['innerper'] . '</td>
        <td>' . $row['innerpack'] . '</td>
        <td>' . $row['inspec'] . '</td>
        <td>' . $row['seal'] . '</td>
        <td><img src="tracemp/sign/' . $row['sign'] . '.png" width="120" height="40"></td>
    </tr>';
}

$html .= '</table>';

// Add manager sign after the table

// Fetch manager sign from database (example: from tblouter1)
if (!empty($row1['msign'])) {
    $manager_sign = $row1['msign'];
    $html .= '<br><br>
<table width="100%">
    <tr>
      <td align="right" style="border:none;">
            <img src="tracemp/sign/' . $manager_sign . '.png" width="120" height="40" style="vertical-align:middle;">
           
        </td>
        </tr>
        <tr>
        <th align="right" style="border:none;">
            Manager Signature
           
        </th>
        
    </tr>
</table>';

    // Write HTML to PDF
   
}

 $pdf->writeHTML($html, true, false, true, false, '');


$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "/brcfoodsafety/upl1/outer_record_" . $pid . ".pdf", "F");
?>
<iframe src="upl1/outer_record_<?php echo $pid; ?>.pdf" frameborder="0" width="100%" height="600px"></iframe>

<?php

if ($ac == '2') {
    echo '<a href="admin.php?id=mouter&date=' . $selectedDate . '&eid=' . $pid . '">
            <button class="btn btn-warning  w-100" >Verify Report</button>';
}

?>