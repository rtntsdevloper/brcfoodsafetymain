<?php
 
$pdate = $_GET['pdate'];

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
        $this->Cell(0, 0, 'Production Record', 0, 1, 'C');

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
$pdf->SetTitle('Production Record');
$pdf->SetSubject('Production Record');
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
        <td  width="34%"  style="text-align:center;">Issue to: 03/03/2026</td>
        <td width="33%" rowspan="2" style="text-align:center;">REC 6.1.003 </td>
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


// Start building HTML table


$sql = mysqli_query($con, "SELECT * FROM `zendproduction` where pdate='$pdate' ");
foreach ($sql as $sqlx) {
$pdf->AddPage();
$pdf->SetY(40);
$wxcode = $sqlx['id'];


    $sqldate = date('d-m-Y', strtotime($sqlx['pdate']));
    $fpro = mysqli_query($con, " SELECT * FROM `zendfinalproduct` where id='$sqlx[fproduct]' ");
    $fpro1 = mysqli_fetch_array($fpro);


    $basic = '
<style>
table{
font-size:11px;
}
th{

font-weight:bold;
background-color: #e6e6e6;
}

</style>

';
    $basic .= '<table border="1" cellpadding="3" width="100%">

    <tr style=" color:black; ">
                                    <th scope="col" width="30%">Date</th>
                                    <td scope="col" width="20%">' . $sqldate . '</td>
                                    <th scope="col" width="30%">Production Batch</th>
                                    <td scope="col" width="20%">' . $sqlx['prodbatch'] . '</td>
                                   
                                    
    </tr>
     <tr style=" color:black; ">
                                    <th scope="col" width="30%">Final Product</th>
                                    <td scope="col" width="20%">' . $fpro1['name'] . '</td>
                                    <th scope="col" width="30%">Batchcode</th>
                                    <td scope="col" width="20%">' . $sqlx['batch'] . '</td>
                                                          
    </tr>
     <tr style="color:black; ">
                                    <th scope="col" width="30%">SKU Batchcode</th>
                                    <td scope="col" width="20%">' . $sqlx['skbatch'] . '</td>
                                    <th scope="col" width="30%">Units Produced</th>
                                    <td scope="col" width="20%">' . $sqlx['sachet'] . '</td>
                                                          
    </tr>
     <tr style="color:black; ">
                                    <th scope="col" width="30%">Packaging Batchcode</th>
                                    <td scope="col" width="20%">' . $sqlx['pbatch'] . '</td>
                                    <th scope="col" width="30%">Is Packaging Batch Finished Completely?</th>
                                    <td scope="col" width="20%">' . $sqlx['coded'] . '</td>
                                                          
    </tr>  <tr style="color:black; ">
                                   
                                    <th scope="col" width="30%">Is Any Other Packaging Batch Used?</th>
                                    <td scope="col" width="20%">' . $sqlx['othercode'] . '</td>
                                      
                                    
                                    <td scope="col" width="50%" colspan="2"></td>
                                    
                                                          
    </tr>
                                                          
      ';
    if ($sqlx['othercode'] == 'Yes') {

        $basic .= '
    <tr style="color:black; ">
                                    <th scope="col" width="30%">Other Packaging Batchcode</th>
                                    <td scope="col" width="20%">' . $sqlx['otherbatch'] . '</td>
                                    <th scope="col" width="30%">Is Other Packaging Batch Finished Completely?</th>
                                    <td scope="col" width="20%">' . $sqlx['othercheck'] . '</td>
                                                          
    </tr>
    ';
    }

    $basic .= '
    </table>';
    $pdf->writeHTML($basic, true, false, true, false, '');


    $html = '<table border="1" cellpadding="3" width="100%">

    <tr style="font-weight:bold; color:black;text-align:center; font-size:small;background-color: #e6e6e6;">
                                    <th scope="col" width="5%">#</th>
                                    <th scope="col" width="25%">Input Product</th>
                                    <th scope="col" width="20%">Batchcode</th>
                                    <th scope="col" width="20%">GRN</th>
                                    <th scope="col" width="15%">Quantity</th>
                                    <th scope="col" width="15%">BBD</th>
                                  
                                    
    </tr>';
    $r = 0;
    $grnx = mysqli_query($con, "SELECT * FROM `zendprod1` where vid = '$wxcode'");
    while ($row = mysqli_fetch_array($grnx)) {
        $grnxd = $row['grn'];

        $grnu = mysqli_query($con, "select * from tblgrn1 where id='$grnxd'");
        $grnux = mysqli_fetch_array($grnu);

        $r++;
        $html .=

            '<tr nobr="true" style="text-align:center; font-size:small" >
        <td>' . $r . '</td>
    <td>' . $row['pname'] . '</td>
     <td>' . $row['batch'] . '</td>
    <td>' . $grnux['grn'] . '</td>
    <td>' . $row['qty'] . '</td>
    <td>' . date('d-m-Y', strtotime($row['useby'])) . '</td>
   
    
   
    </tr>';
    }


    // Close table
    $html .= '</table>';
    $pdf->writeHTML($html, true, false, true, false, '');
}

$pdfname = "PROD00" . $wcode . ".pdf";

$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "zendboxg/pdf/" . $pdfname, "F");

?>
<a href="admin.php?id=zenprod&date=<?php echo $pdate; ?>"><button class="btn btn-success" style="float:right; margin-left:15px">Go Back</button></a>
<br>
<iframe src="zendboxg/pdf/<?= $pdfname ?>" frameborder="0" width="100%" height="600px"></iframe>