<?php
include 'connection.php';
require_once('tcpdf/tcpdf.php');
$uid = 3;


// Get current date

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
        $this->Image($this->logo1Path, 15, 7, 28, '18', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        // Add logo 2 (right)
        file_exists($this->logo2Path);
        $this->Image($this->logo2Path, 250, 7, 28, '18', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        // Main title
        $this->SetFont('centurygothic', 'B', 22);
        $this->SetTextColor(0, 51, 102);
        $this->SetXY(12, 12);
        $this->Cell(0, 0, 'Procedure Training', 0, 1, 'C');

        // Header line
        $this->SetLineWidth(0.5);
        $this->SetDrawColor(0, 102, 204);
        $this->Line(15, 28, 280, 28);
    }

    public function Footer()
    {
        $this->SetFont('centurygothic', '', 8);
        $this->SetY(-20);
        $this->writeHTML($this->longTableFooter);
    }
    public function setLongTableFooter($html)
    {
        $this->longTableFooter = $html;
    }
}

// Create new PDF document
$pdf = new MYPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);

// Set document information
$pdf->SetCreator('Rtnts');
$pdf->SetAuthor('gk');
$pdf->SetTitle('Staff Report');
$pdf->SetSubject('Staff Report');
$pdf->SetKeywords('Staff Report');

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(15, 30, 15);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(20);
$pdf->SetAutoPageBreak(TRUE, 30);

$sqq = mysqli_query($con, "SELECT * FROM tblformcontrol WHERE id = '3'");
$roww = mysqli_fetch_assoc($sqq);

$issueDate = date('d/m/Y', strtotime($roww['issuedate']));


$footer = <<<EOD

<table width="95%" cellpadding="3" border="0.2" style="font-size:9px;  border-color:#000000; color:black;">
    <tr>
        <td width="255">Issue date: {$issueDate}</td>
        <td width="240" rowspan="2" align="center">Page {$pdf->getAliasNumPage()}/{$pdf->getAliasNbPages()}</td>
        <td width="255">Author : {$roww['author']}</td>
    </tr>
    <tr>
        <td width="255" >Version No: {$roww['version']}</td>
      
        <td width="255" >Authorised By: {$roww['authoriesby']}</td>
    </tr>
    <tr>
        <td width="750" colspan="2" >Reason for change: {$roww['reason']}</td>
        
    </tr>
</table>
EOD;
$pdf->setLongTableFooter($footer);


$pdf->AddPage();
$pdf->SetY(40);

$html1 = '
<style>
   table{
   font-family:centurygothic;
}
   
    th {
        font-size: 12px;
    font-weight:bold;
        background-color: #E0E0E0;
        
    }
        td{
        font-size: 11px;
        }
</style>

<table border="1" cellpadding="8" width="100%" align="center">
<tr >
<th width="10%">Sno</th>
<th width="23%" >Procedure</th>
<th  width="15%" >Version</th>
  <th  width="17%" >Attempt Date</th>
  <th width="18%">Result</th>
  <th  width="17%" >Refresher Due On</th>
  

</tr >

';


$sql = mysqli_query($con, "SELECT s1.procedure1,s1.uid,s1.status,s2.name,s2.version FROM `tblproceduretraining1` as s1 JOIN tblprocedure as s2 ON s1.procedure1 = s2.id WHERE s1.uid= '$uid' and s1.status ='Completed' and s2.ccp =''");
$proce23 = 0;
$fix = 1;
foreach ($sql as $row) {
    $userid = $row['uid'];
    $proid = $row['procedure1'];
    $puserc = mysqli_query($con, "SELECT * FROM `tblresult1` WHERE staffid = '$userid' and tid = '$proid' order by sno desc limit 1");
    $puserc = mysqli_fetch_array($puserc);


    if ($puserc['result'] == 'Pass') {
        $proccp23++;
        $color = 'green';
        $presult = date('d-m-Y', strtotime("+3 year", strtotime($puserc['curdate'])));
    } else {
        $color = 'red';
        $presult = '';
    }

    if (!empty($puserc['curdate'])) {
        $prdate = date('d-m-Y', strtotime("+3 year", strtotime($puserc['curdate'])));
    } else {
        $prdate = '';
    }


    $html1 .= '<tr nobr="true" >
    <td  style="font-weight:bold;">' . $fix . '</td>
  <td  style="font-weight:bold;">' . $row['name'] .  '</td>
  <td  style="font-weight:bold;">' . $row['version'] .  '</td>
    <td  style="font-size:9px;">' . $prdate . '</td>
    <td  style="font-size:9px;">' . $puserc['result'] . '</td>


    <td  style="font-size:9px;">' . $presult . '</td>
</tr >';
    $fix++;
}
$html1 .= '</table>';

$pdf->writeHTML($html1, true, false, true, false, '');





$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "finemed/upl1/Procedure_report_" . $uid . ".pdf", "F");






echo $proccp23;
// Get current date

class MYPDF1 extends TCPDF
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
        $this->Image($this->logo1Path, 15, 7, 28, '18', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        // Add logo 2 (right)
        file_exists($this->logo2Path);
        $this->Image($this->logo2Path, 250, 7, 28, '18', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        // Main title
        $this->SetFont('centurygothic', 'B', 22);
        $this->SetTextColor(0, 51, 102);
        $this->SetXY(12, 12);
        $this->Cell(0, 0, 'CCP Procedure Training', 0, 1, 'C');

        // Header line
        $this->SetLineWidth(0.5);
        $this->SetDrawColor(0, 102, 204);
        $this->Line(15, 28, 280, 28);
    }

    public function Footer()
    {
        $this->SetFont('centurygothic', '', 8);
        $this->SetY(-20);
        $this->writeHTML($this->longTableFooter);
    }
    public function setLongTableFooter($html)
    {
        $this->longTableFooter = $html;
    }
}

// Create new PDF document
$pdf = new MYPDF1('L', PDF_UNIT, 'A4', true, 'UTF-8', false);

// Set document information
$pdf->SetCreator('Rtnts');
$pdf->SetAuthor('gk');
$pdf->SetTitle('Staff Report');
$pdf->SetSubject('Staff Report');
$pdf->SetKeywords('Staff Report');

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(15, 30, 15);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(20);
$pdf->SetAutoPageBreak(TRUE, 30);

$sqq = mysqli_query($con, "SELECT * FROM tblformcontrol WHERE id = '3'");
$roww = mysqli_fetch_assoc($sqq);

$issueDate = date('d/m/Y', strtotime($roww['issuedate']));


$footer = <<<EOD

<table width="95%" cellpadding="3" border="0.2" style="font-size:9px;  border-color:#000000; color:black;">
    <tr>
        <td width="255">Issue date: {$issueDate}</td>
        <td width="240" rowspan="2" align="center">Page {$pdf->getAliasNumPage()}/{$pdf->getAliasNbPages()}</td>
        <td width="255">Author : {$roww['author']}</td>
    </tr>
    <tr>
        <td width="255" >Version No: {$roww['version']}</td>
      
        <td width="255" >Authorised By: {$roww['authoriesby']}</td>
    </tr>
    <tr>
        <td width="750" colspan="2" >Reason for change: {$roww['reason']}</td>
        
    </tr>
</table>
EOD;
$pdf->setLongTableFooter($footer);


$pdf->AddPage();
$pdf->SetY(40);

$html1 = '
<style>
   table{
   font-family:centurygothic;
}
   
    th {
        font-size: 12px;
    font-weight:bold;
        background-color: #E0E0E0;
        
    }
        td{
        font-size: 11px;
        }
</style>

<table border="1" cellpadding="8" width="100%" align="center">
<tr >
<th width="10%">Sno</th>
<th width="23%" >Procedure</th>
<th  width="15%" >Version</th>
  <th  width="17%" >Attempt Date</th>
  <th width="18%">Result</th>
  <th  width="17%" >Refresher Due On</th>
  

</tr >

';


$sql = mysqli_query($con, "SELECT s1.procedure1,s1.uid,s1.status,s2.name,s2.version FROM `tblproceduretraining1` as s1 JOIN tblprocedure as s2 ON s1.procedure1 = s2.id WHERE s1.uid= '$uid' and s1.status ='Completed' and s2.ccp ='Yes'");
$proce23 = 0;
$fix = 1;
foreach ($sql as $row) {
    $userid = $row['uid'];
    $proid = $row['procedure1'];
    $puserc = mysqli_query($con, "SELECT * FROM `tblresult1` WHERE staffid = '$userid' and tid = '$proid' order by sno desc limit 1");
    $puserc = mysqli_fetch_array($puserc);


    if ($puserc['result'] == 'Pass') {
        $proce23++;
        $color = 'green';
        $presult = date('d-m-Y', strtotime("+3 year", strtotime($puserc['curdate'])));
    } else {
        $color = 'red';
        $presult = '';
    }

    if (!empty($puserc['curdate'])) {
        $prdate = date('d-m-Y', strtotime("+3 year", strtotime($puserc['curdate'])));
    } else {
        $prdate = '';
    }

    $html1 .= '<tr nobr="true" >
    <td  style="font-weight:bold;">' . $fix . '</td>
  <td  style="font-weight:bold;">' . $row['name'] .  '</td>
 <td  style="font-weight:bold;">' . $row['version'] .  '</td>
    <td  style="font-size:9px;">' . $presult . '</td>
    <td  style="font-size:9px;">' . $puserc['result'] . '</td>


    <td  style="font-size:9px;">' . $prdate . '</td>
</tr >';
    $fix++;
}
$html1 .= '</table>';

$pdf->writeHTML($html1, true, false, true, false, '');





$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "finemed/upl1/Procedure_ccpreport_" . $uid . ".pdf", "F");



?>

<div class="main-content">

    <div class="container-fluid " style="margin-top:20px;">
        <div class="row mb-12">
            <div class="col-md-12 mb-12">
                <div class="card text-left">
                    <div class="card-body">

                        <a href="admin.phh?id=1"><button class="btn btn-primary"
                                style="float:right; margin-left:15px">Go
                                Back</button></a>



                        <h4 class="card-title mb-3"> Staff Report</h4>
                        

                        <iframe src="upl1/Procedure_ccpreport_<?= $uid ?>.pdf" width="100%" height="500"></iframe>
                        <iframe src="upl1/Procedure_report_<?= $uid ?>.pdf" width="100%" height="500"></iframe>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>