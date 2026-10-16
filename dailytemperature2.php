<?php

$tdate = $_GET['date'];
$tid = $_GET['tid'];
include 'connection.php';
require_once('tcpdf/tcpdf.php');


$ctdate = date('d-m-Y', strtotime($tdate));



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
        $this->Cell(0, 0, 'Daily Temperature Checks', 0, 1, 'C');

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
$pdf->SetTitle('Daily Temperature Checks');
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
    
        <td width="33%">Issue date: 17/04/2025</td>
        <td  width="34%" >Version 1</td>
        <td width="33%" >Issued by: Bijal Chauhan</td> 
    </tr>
    <tr>
    
        <td width="67%"  colspan="2">Reason for change: New form</td>
        <td width="33%" >Authorised by: Paramvir S. Deol</td> 
    </tr>
    

</table>

EOD;

$pdf->setFooterHTML($footerContent);
// Add a page
$pdf->AddPage();
$pdf->SetY(40);



$tbl0 = '<table border="1" cellpadding="5" width="100%">
<tr style="color:black;">
        <th style="font-weight:bold; color:black;" width="25%">Date  </th>
        <td width="75%">' . date('d-m-Y', strtotime($tdate)) .  '</td>
                               
    </tr><tr style="color:black;">
        <th style="font-weight:bold; color:black;" width="25%">Section  </th>
        <td width="75%">Daily Temperature Checks </td>
                               
    </tr>
    </table>
';

$pdf->writeHTML($tbl0, true, false, false, false, '');


$tbl1 = '';

$ghf1 = mysqli_query($con, "SELECT * FROM `tbldailytemp` WHERE edate='$tdate'");
$jki = 0;

while ($rowsf1 = mysqli_fetch_array($ghf1)) {
    $jki++;

    $tbl1 .= '
    <table border="1" cellpadding="4" width="100%" >
  <tr style="font-weight:bold; color:black;">
        <th width="378">Shift: ' . $jki . ' </th>
                          <th width="379">Time: ' . $rowsf1['etime'] . ' </th>
                               
    </tr>
   
   ';
    $i = 0;
    $ghf = mysqli_query($con, "select * from tbldailytemp2 where cid='2'");
    while ($rowsf = mysqli_fetch_array($ghf)) {
        $i++;


        $tbl1 .= '
  <tr nobr="true"> 
      <td width="160" style="font-weight:bold; color:black;" >Question : ' . $i . '</td>
       <td  width="597" >' . $rowsf['ques'] . '</td>
   </tr>
   
	<tr nobr="true"> 
	 <td width="160" style="font-weight:bold; color:black;">Answer</td>
       <td  width="597" style="color:green">' . $rowsf['ans'] . '</td>
   </tr>';
        if ($rowsf['cmnt'] != "") {
            $tbl1 .= '<tr nobr="true"> 
	 <td width="160" style="font-weight:bold; color:black;" >Comment</td>
       <td  width="597" style="color:green">' . $rowsf['cmnt'] . '</td>
   </tr>';
        }
        if ($rowsf['pic'] != "") {
            $tbl1 .= '
  <tr nobr="true"> 
      <td width="160" ></td>
       <td  width="597" ><img src="upl1/' . $rowsf['pic'] . '" width="100"></td>
   </tr>
';
        }
    }
    $tbl1 .= '</table>
    <br>
    <br>
    <br>
    
   ';
}

$pdf->writeHTML($tbl1, true, false, false, false, '');



$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "upl1/daily_temp_sd" . $tdate . ".pdf", "F");
?>


<div class="row mb-12">
    <div class="col-md-12 mb-12">
        <div class="card text-left">
            <iframe src="upl1/daily_temp_sd<?php echo $tdate; ?>.pdf" frameborder="0" width="100%" height="700"></iframe>
        </div>
    </div>
</div>