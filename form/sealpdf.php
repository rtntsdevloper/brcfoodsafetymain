<?php
$vdate=$_GET["vdate"];

$startdate = $_GET['startdate'];
$enddate = $_GET['enddate'];

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
        $this->Cell(0, 0, 'Labelling & Sealing Record', 0, 1, 'C');

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
$pdf->SetTitle('Labelling & Sealing Record');
$pdf->SetSubject('Labelling & Sealing Record');
$pdf->SetKeywords('Labelling & Sealing Record, report');

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
        <td  width="34%"  style="text-align:center;">Issue to: 03/03/2026</td>
        <td width="33%" rowspan="2" style="text-align:center;">REC 6.1.004</td>
        <td width="33%" style="text-align:center;">Author:  Usama Mustafa</td>
       
    </tr>

     <tr>
    <td  width="34%"  style="text-align:center;">Version : 01</td>
        <td width="33%" style="text-align:center;">Authorised by: Paramvir S. Deol </td>
       
    </tr>
</table>

EOD;

$pdf->setFooterHTML($footerContent);
// Add a page
$pdf->AddPage();

// Start building HTML table
$pdf->SetY(40);

$sql = mysqli_query($con, "select * from `zendseal` where dates='$vdate' ");

$html = '';
$html .= '<table border="1" cellpadding="3" width="100%">

    <tr style="font-weight:bold;font-size:small; color:black;text-align:center;background-color: #e6e6e6;">
                                    
                                    <th scope="col" width="5%">sno</th>
                                    <th scope="col" width="10%">Date</th>
                                    <th scope="col"  width="19%">Batch(Use by)</th>
                                   
                                    
                                    <th scope="col" width="18%">Is the Pouches Sealed Properly?</th>
                                    <th scope="col" width="18%">Is labelling correct on packet?</th>
                                    <th scope="col" width="18%">Is batch code & BBD printed adequately?</th>
                                     <th scope="col" width="12%">Attempt by </th>

                              
                       
    </tr>';
$r = 0;
while ($row = mysqli_fetch_array($sql)) {
    $grnid = $row['productbatch'];

    $grnx = mysqli_query($con, "SELECT * FROM `zendproduction` WHERE id = '$grnid'");
    $grnx1 = mysqli_fetch_array($grnx);
    $packbt = $grnx1['pbatch'];

    $packg = mysqli_query($con,"SELECT * FROM `zendpackaging` where pbatch='$packbt'");
    $packg1 = mysqli_fetch_array($packg);
    $bbdate = date('d-m-Y',strtotime($packg1['bbdate']));

    $r++;
    $html .=

        '<tr nobr="true" style="text-align:center; font-size:small" >
                                               <td >' . $r . '</td>
                                        <td>' . date('d-m-Y', strtotime($row['dates'])) . '</td>
                                         <td>' . $grnx1['batch'] .'('. $bbdate .')</td>
                                        
                                        <td>' . $row['sealed'] . '</td>
                                        <td>' . $row['labelling'] . '</td>
                                        <td>' . $row['print'] . '</td>  
                                         <td>' . $row['user'] . '</td>
                                        
    
   
    </tr>';
}


// Close table
$html .= '</table>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdfname = "Label_" . $startdate . "_" . $enddate . ".pdf";

$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "zendboxg/pdf/" . $pdfname, "F");

?>
<a href="admin.php?id=zendseal1&vdate=<?php echo $vdate ?>"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
<br>
<iframe src="zendboxg/pdf/<?= $pdfname ?>" frameborder="0" width="100%" height="600px"></iframe>