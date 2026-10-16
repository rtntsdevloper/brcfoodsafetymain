<?php
include 'connection.php';
require_once('tcpdf/tcpdf.php');


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
        $this->Cell(0, 0, 'Procedure Training Record', 0, 1, 'C');

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

$sqq = mysqli_query($con, "SELECT * FROM tblformcontrol WHERE id = '1'");
$roww = mysqli_fetch_assoc($sqq);
// Assuming 'issue_date' and 'authorised_by' are columns in your table
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

$html0 ='<style>
   table{
   font-family:centurygothic;
}
   
    th {
        font-size: 13px;
    font-weight:bold;
        background-color: aliceblue;
        
    }
        td{
        font-size: 11px;
        }
</style>

<table border="1" cellpadding="4" width="100%" align="center">
<tr >
  <th width="25%" >Name</th>
  <td  width="25%" >ram</td>
  <th  width="25%" >Job Title</th>
  <td  width="25%" >Procedure training</td>
  

</tr >
<tr >
  <th width="25%" >Department</th>
  <td  width="25%" >ram</td>
  <th  width="25%" >Training Type</th>
  <td  width="25%" >Procedure training</td>
  

</tr >
</table>';

$pdf->writeHTML($html0, true, false, true, false, '');
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
        font-size: 9px;
        }
</style>

<table border="1" cellpadding="8" width="100%" align="center">
<tr >
  <th width="12%" >Sno</th>
  <th  width="18%" >Procedure</th>
  <th width="18%">Training Date</th>
  <th  width="18%" >Status</th>
  <th  width="18%" >Haccp</th>
 <th  width="18%" >CCP</th>

</tr >

';


$sql = mysqli_query($con, "SELECT * FROM `tblstaff` ");
foreach ($sql as $row) {

    $sno = $row['id'];

    if ($row['allergen'] == 'Yes') {
        $alcheck = 'Conducted';
        $alcolor = "green";
        $alcert = mysqli_query($con, "SELECT * FROM `tblstaffcert` WHERE `user` = '$sno' AND `type` = 'Allergen'");
        $rowal = mysqli_fetch_assoc($alcert);
        if (isset($rowal['certdate'])) {
            $aldate = date('d M, Y', strtotime($rowal['certdate']));
        } else {
            $aldate = '-';
        }
    } else {
        $alcheck = "N/A";
        $alcolor = "grey";
        $aldate = '-';
    }



    //level2

    if ($row['lvl2'] == 'Yes') {
        $lvcheck = 'Conducted';
        $lvcolor = "green";
        $lvl2cert = mysqli_query($con, "SELECT * FROM `tblstaffcert` WHERE `user` = '$sno' AND `type` = 'Level2'  order by id desc limit 1");
        $rowlvl2 = mysqli_fetch_assoc($lvl2cert);
        if (isset($rowlvl2['certdate'])) {
            $lvdate = date('d M, Y', strtotime($rowlvl2['certdate']));
        } else {
            $lvdate = '-';
        }
    } else {
        $lvcheck = "N/A";
        $lvcolor = "grey";
        $lvdate = '-';
    }

    //haccp

    if ($row['haccp'] == 'Yes') {
        $hcheck = 'Conducted';
        $hcolor = "green";
        $hcpcert = mysqli_query($con, "SELECT * FROM `tblstaffcert` WHERE `user` = '$sno' AND `type` = 'HACCP'  order by id desc limit 1");
        $hcpcert1 = mysqli_fetch_assoc($hcpcert);
        if (isset($hcpcert1['certdate'])) {
            $hdate = date('d M, Y', strtotime($hcpcert1['certdate']));
        } else {
            $hdate = '-';
        }
    } else {
        $hcheck = "N/A";
        $hcolor = "grey";
        $hdate = '-';
    }

    //procedure


    if ($row['procedur'] == 'Yes') {
        $pcheck = 'Conducted';
        $pcolor = "green";
        $procert = mysqli_query($con, "SELECT * FROM `tblstaffcert` WHERE `user` = '$sno' AND `type` = 'Procedure'  order by id desc limit 1");
        $procert1 = mysqli_fetch_assoc($procert);

        if (isset($procert1['certdate'])) {
            $pdate = date('d M, Y', strtotime($procert1['certdate']));
        } else {
            $pdate = '';
        }
    } else {
        $pcheck = "N/A";
        $pcolor = "grey";
        $pdate = '-';
    }



    //ccp

    if ($row['ccp'] == 'Yes') {
        $ccheck = 'Conducted';
        $ccolor = "green";

        $ccpcert = mysqli_query($con, "SELECT * FROM `tblstaffcert` WHERE `user` = '$sno' AND `type` = 'CCP'  order by id desc limit 1");
        $ccpcert1 = mysqli_fetch_assoc($ccpcert);



        if (isset($ccpcert1['certdate'])) {
            $cdate = date('d M, Y', strtotime($ccpcert1['certdate']));
        }
    } else {
        $ccheck = "N/A";
        $ccolor = "grey";
        $cdate = '-';
    }






    $html1 .= '<tr >
  <td width="12%" style="font-weight:bold;">' . $row['fname'] . ' ' . $row['lname'] . '</td>
 <td width="9%" style="font-size:9px;color:' . $lvcolor . '">' . $lvcheck . '</td>
    <td width="9%" style="font-size:9px;">' . $lvdate . '</td>
  <td width="9%" style="font-size:9px;color:' . $alcolor . '">' . $alcheck . '</td>
    <td width="9%" style="font-size:9px;">' . $aldate . '</td>
  <td width="9%" style="font-size:9px;color:' . $pcolor . '">' . $pcheck . '</td>
    <td width="9%" style="font-size:9px;">' . $pdate . '</td>
 <td width="9%" style="font-size:9px; color:' . $hcolor . '">' . $hcheck . ' </td>
    <td width="9%" style="font-size:9px;">' . $hdate . ' </td>
 <td width="9%" style="font-size:9px;color:' . $ccolor . '">' . $ccheck . '</td>
    <td width="9%" style="font-size:9px;">' . $cdate . '</td>
</tr >';
}
$html1 .= '</table>';

$pdf->writeHTML($html1, true, false, true, false, '');





$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "finemed/upl1/staffreport.pdf", "F");

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



                        <h4 class="card-title mb-3"> Staff Report
                        </h4>

                        <div class="embed-responsive embed-responsive-4by3" style="height: 678px;">


                            <iframe src="upl1/staffreport.pdf" frameborder="0" width="100%" height="600px"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>