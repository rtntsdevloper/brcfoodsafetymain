<?php
include 'connection.php';
//date wise

$consid = $_GET['consid'];


require('tcpdf/tcpdf.php');
ini_set('max_execution_time', 300);
// create new PDF document
class MYPDF extends TCPDF
{

    public function Header()
    {

        $image_file = 'images/hbh.png';
        $this->Image($image_file, 10, 2, 30, '', 'PNG', '', 'T', false, 200, '', false, false, 0, false, false, false);

    }

    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('centurygothic', 'I', 8);
        $this->Cell(20, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');

    }
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 003');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->SetMargins(PDF_MARGIN_LEFT, 40, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);


$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);


$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
    $pdf->setLanguageArray($l);
}

$pdf->SetFont('centurygothic', 'B', 16);


$pdf->AddPage('L');
$pdf->SetXY(115, 15);
$pdf->Write(0, "TEST", '', '0', '0', true, 'C', false, false, 0);




$pdf->SetFont('centurygothic', '', 12);

$pdf->SetXY(5, 38);


$tble7 = <<<EOD
<table width="800" border="0" style="font-weight:bold; font-size:12px " cellpadding="2">
 

  
  </table>
EOD;
$pdf->writeHTML($tble7, true, false, true, false, '');

$pdf->SetFont('centurygothic', '', 10);


$pdf->SetXY(5, 50);

$tbl_header = '<style>
table {
   
   border-spacing: 0;
}
tr {
   padding: 3px 0;
}

th {
      background-color:#F0F0F0;
 border: 1px solid #000000;
   color: #000000;
   text-align: left;
}
td {
  
    border: 1px solid #000000;
   color: #000000;
}
</style>
<table id="gallerytab" width="1200" cellspacing="0" cellpadding="4" border="0">
  ';

$tbl_footer = '</table>';



$x1 = mysqli_query($con, "select * from `tblconcession` where id='$consid'");
$y1 = mysqli_fetch_array($x1);




$tble7 = <<<EOD
<table width="1070" border="0" style="font-weight:bold; font-size:12px " cellpadding="2">
   <tr>
    <td width="870"><div align="right"><img src="locations/$consid.jpg"></div></td>
   
  </tr>
  
  </table>
EOD;
$pdf->writeHTML($tble7, true, false, true, false, '');

// $pdf->Output("pdf/".$consid.".pdf","F");
$pdf->Output($_SERVER['DOCUMENT_ROOT'] . 'newhbh/pdf/location_report.pdf', 'F');


?>

<iframe width="100%" height="900" src="pdf/location_report.pdf"></iframe>