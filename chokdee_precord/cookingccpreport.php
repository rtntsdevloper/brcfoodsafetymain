<?php
include 'connection.php';
require_once('tcpdf/tcpdf.php');
$pid = $_GET['pid'];
$date = $_GET['date'];
$product = $_GET['product'];
// print_r("select * from  `tblproductlist` where id='$product'");die;
if ($pid == 1) {
    $ssql = mysqli_query($con, "SELECT * FROM tblproductlist  where id='$product'");
} elseif ($pid == 2) {
    $ssql = mysqli_query($con, "SELECT * FROM tblsauceproductlist  where id='$product'");
} elseif ($pid == 3) {
    $ssql = mysqli_query($con, "SELECT * FROM tblmeatproductlist  where id='$product'");
}
$roww = mysqli_fetch_array($ssql);
$pro = $roww['prname'];



$ac = $_GET['ac'];

$dt = date("d-m-y", strtotime($date));

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

        // Add logo 1 (left) if exists
        if (file_exists($this->logo1Path)) {
            $this->Image($this->logo1Path, 15, 7, 25, '', 'PNG', '', 'T', false, 290, '', false, false, 0, false, false, false);
        }

        // Add logo 2 (right) if exists
        if (file_exists($this->logo2Path)) {
            $this->Image($this->logo2Path, 255, 7, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }

        // Main title
        $this->SetFont('courier', 'B', 22);
        $this->SetTextColor(0, 51, 102);
        $this->SetXY(12, 12);
        if ($GLOBALS['pid'] == 1) {
            $this->Cell(0, 0, 'Savoury Production Record', 0, 1, 'C');
        } elseif ($GLOBALS['pid'] == 2) {
            $this->Cell(0, 0, 'Sauce Production Record', 0, 1, 'C');
        } elseif ($GLOBALS['pid'] == 3) {
            $this->Cell(0, 0, 'Meat Production Record', 0, 1, 'C');
        }



        // Header line
        $this->SetLineWidth(0.5);
        $this->SetDrawColor(0, 102, 204);
        $this->Line(20, 28, 280, 28);
    }

    public function Footer()
    {
        $this->SetY(-22);
        $this->SetFont('courier', '', 10);
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

$pdf->SetTitle('Production Record');
$pdf->SetSubject('Production Record');
$pdf->SetKeywords('Production Record');
// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(15, 30, 15);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(20);
$pdf->SetAutoPageBreak(TRUE, 25);
if ($pid == 2) {
    $footerContent = <<<EOD
<table  cellpadding="5" border="1" >
    <tr>
    
    
        
         <td width="50%">REC 6.1.005 Sauce Production Area CCP Record</td>
       
       
        <td width="20%" >Version:01</td> 
         <td width="30%" >Created by: Bijal Chauhan </td>
        
    </tr>
     <tr>
        <td width="50%" style=  colspan="2">Reason for change: New form</td>
        <td width="20%" style= >Issue date:02/09/2025</td> 
        <td width="30%" style= >Authorised by: Paramvir S. Deol</td>
        
    </tr>
</table>
EOD;
} elseif ($pid == 3) {
    $footerContent = <<<EOD
<table  cellpadding="5" border="1" >
    <tr>
    
    
      
    <td width="50%">REC 6.1.007 Prep Meat Product CCP Record</td>
       
       
        <td width="20%" >Version:01</td> 
         <td width="30%" >Created by: Bijal Chauhan </td>
        
    </tr>
     <tr>
        <td width="50%" style=  colspan="2">Reason for change: New form</td>
        <td width="20%" style= >Issue date:02/09/2025</td> 
        <td width="30%" style= >Authorised by: Paramvir S. Deol</td>
        
    </tr>
</table>
EOD;
} else {
    $footerContent = <<<EOD
<table  cellpadding="5" border="1" >
    <tr>
    
    
        
            <td width="50%">REC 6.1.006 Savoury Production CCP Record</td>
       
       
        <td width="20%" >Version:01</td> 
         <td width="30%" >Created by: Bijal Chauhan </td>
        
    </tr>
     <tr>
        <td width="50%" style=  colspan="2">Reason for change: New form</td>
        <td width="20%" style= >Issue date:02/09/2025</td> 
        <td width="30%" style= >Authorised by: Paramvir S. Deol</td>
        
    </tr>
</table>
EOD;
}

$pdf->setFooterHTML($footerContent);

// Add a page
$pdf->AddPage();
$pdf->SetY(40);

// Prepare SQL query (consider using prepared statements)
// print_r("SELECT * FROM tblcooking where pdate ='$date' and pname='$product'");die;
$sql11 = mysqli_query($con, "SELECT * FROM tblcooking where pdate ='$date' and pname='$product' and pid='$pid'");


$html = '<table border="1" cellpadding="4" width="100%" style="font-size: 9px;" > ';
$html .= '<tr>
    <td style="color:rgba(0, 51, 102); text-align:center;" colspan="10">Cooking (&gt;=90 &deg;C for 10 minutes)
(CCP 1a)</td>
</tr>
<tr style="font-weight:bold; color:black; text-align:center;">
   
<th width="7%" style="text-align:center;">Date </th>
<th width="7%" style="text-align:center;">Product </th>
<th width="10%" style="text-align:center;">Batch Code </th>
<th width="10%" style="text-align:center;">Cooking start time </th>
<th width="10%" style="text-align:center;">Actual Start time of CCP (°C) </th>
<th width="10%" style="text-align:center;">Actual Temperature of CCP at start time </th>
<th width="10%" style="text-align:center;">  Actual End time of CCP</th>
<th width="11%" style="text-align:center;">Actual Temperature of CCP at End time </th>


<th width="7%" style="text-align:center;">Checked By </th>
<th width="10%" style="text-align:center;">Comment </th>
<th width="8%" style="text-align:center;">Sign </th>

</tr>';
while ($row = mysqli_fetch_array($sql11)) {
    $query = mysqli_query($con, "SELECT * FROM tblstaff WHERE id='" . $row['checkedby'] . "'");
    $data = mysqli_fetch_array($query);
    $html .= '<tr nobr="true"  style="font-weight:bold; text-align:center;">
      
       
        <td width="7%" >' . $dt . '</td>
        <td width="7%" >' . $pro . '</td>
        <td width="10%" >' . $row['batchcode'] . '</td>
        <td width="10%" >' . $row['ctime'] . '</td>
        <td width="10%" >' . $row['starttime'] . '</td>
        <td width="10%" >' . $row['temp1'] . '&deg;C</td>
        <td width="10%" >' . $row['endtime'] . '</td>
        <td width="11%" >' . $row['temp2'] . '&deg;C</td>
        
      


    
      <td width="7%" >' .

        $data['fname'] . ' ' . $data['lname'] .
        '</td>
       

        <td width="10%" >' . $row['cmnt'] . '</td>
          <td width="8%" > 
     <img src="/chokdee_precord/sign/' . $row['sign'] . '" alt="Signature" width="90" height="30" />
      </td>

    </tr>';
}

$html .= '</table>';


$pdf->writeHTML($html, true, false, true, false, '');

// $pdf->AddPage();
$pdf->SetY(120);

if ($pid != 2) {
    $sql1 = mysqli_query($con, "SELECT * FROM tblblastchiller where pdate ='$date' and pname='$product'  and pid='$pid'");

    $html1 = '<table border="1" cellpadding="4" width="100%" style="font-size: 9px;"> ';
    $html1 .= '<tr>
    <td style="color:rgba(0, 51, 102); text-align:center;" colspan="10">Blast Chiller (&lt;=5&deg;C in 90  minutes)
CCP3</td>
</tr>


<tr style="font-weight:bold; color:black; text-align:center;">
   
<th width="8%" style="text-align:center;">Production Date </th>
<th width="7%" style="text-align:center;">Product Name </th>
<th width="5%" style="text-align:center;">Batch code </th>
<th width="10%" style="text-align:center;">Blast Chiller Temp  </th>
<th width="8%" style="text-align:center;">Start Time </th>
<th width="10%" style="text-align:center;">Product Temp </th>
<th width="10%" style="text-align:center;">Blast Chiller Temp </th>
<th width="7%" style="text-align:center;">End Time </th>
<th width="10%" style="text-align:center;">Production Temp </th>

 <th width="7%" style="text-align:center;">Checked By </th>
       <th width="10%" style="text-align:center;">Comment </th>
<th width="8%" style="text-align:center;">Sign </th>
</tr>';
    while ($row1 = mysqli_fetch_assoc($sql1)) {
        $query11 = mysqli_query($con, "SELECT * FROM tblstaff WHERE id='" . $row1['checkedby'] . "'");
        $data1 = mysqli_fetch_array($query11);
        $html1 .= '<tr nobr="true"  style="font-weight:bold; text-align:center;">
      
       
        
        <td width="8%" >' . $dt . '</td>
        <td width="7%" >' . $pro . '</td>
        <td width="5%" >' . $row1['batchcode'] . '</td>
        <td width="10%" >' . $row1['temp1'] . '&deg;C</td>
        <td width="8%" >' . $row1['starttime'] . '</td>
        <td width="10%" >' . $row1['ptemp'] . '&deg;C</td>
        <td width="10%" >' . $row1['temp2'] . '&deg;C</td>
        <td width="7%" >' . $row1['endtime'] . '</td>
        <td width="10%" >' . $row1['ptemp2'] . '&deg;C</td>
     <td width="7%" >' .

            $data1['fname'] . ' ' . $data1['lname'] .
            '</td>
    <td width="10%" >' . $row1['cmnt'] . '</td>
     <td width="8%" >  <img src="/chokdee_precord/sign/' . $row1['sign'] . '" alt="Signature" width="90" /></td>
   
    ';





        $html1 .= '   </tr>';
    }

    $html1 .= '</table>';


    $pdf->writeHTML($html1, true, false, true, false, '');


    // $pdf->AddPage();
    $pdf->SetY(280);

    $sql2 = mysqli_query($con, "SELECT * FROM tblfreezing where pdate ='$date' and pname='$product'  and pid='$pid'");
    $html2 = '<table border="1" cellpadding="4" width="100%" style="font-size: 9px;">  ';
    if ($pid == 2) {
        $html2 .= '<tr>
    <td style="color:rgba(0, 51, 102); text-align:center;" colspan="10">Add Hot Filling (&gt;=82&deg;C or above CCP2) </td>
  
</tr>';
    } else {
        $html2 .= '<tr>
    <td style="color:rgba(0, 51, 102); text-align:center;" colspan="10">Freezing Info </td>
  
</tr>';
    }

    $html2 .= '<tr style="font-weight:bold; color:black; text-align:center;">
   
<th width="10%" style="text-align:center;">Production Date </th>
<th width="10%" style="text-align:center;">Product Name </th>
<th width="10%" style="text-align:center;">Batch code </th>';
    if ($pid == 2) {
        $html2 .= '<th width="10%" style="text-align:center;">Product Temp (&gt;=82&deg;C ) </th>';
    } else {
        $html2 .= '<th width="10%" style="text-align:center;">Freezer Temp </th>';
    }



    $html2 .= '<th width="10%" style="text-align:center;">Start Time </th>
<th width="10%" style="text-align:center;">End Time </th>
';
    if ($pid == 2) {
        $html2 .= '<th width="10%" style="text-align:center;">Product Temp (&gt;=82&deg;C ) </th>';
    } else {
        $html2 .= '<th width="10%" style="text-align:center;">Freezer Temp </th>';
    }



    $html2 .= '

  <th width="10%" style="text-align:center;">Checked By </th>
       <th width="10%" style="text-align:center;">Comment </th>
       <th width="10%" style="text-align:center;">Sign </th>
</tr>';
    while ($row2 = mysqli_fetch_assoc($sql2)) {
        $query12 = mysqli_query($con, "SELECT * FROM tblstaff WHERE id='" . $row2['checkedby'] . "'");
        $data2 = mysqli_fetch_array($query12);
        $html2 .= '<tr nobr="true"  style="font-weight:bold; text-align:center;">
      
       
        <td width="10%" >' . $dt . '</td>
        <td width="10%" >' . $pro . '</td>
        <td width="10%" >' . $row2['batchcode'] . '</td>
        <td width="10%" >' . $row2['temp1'] . '&deg;C</td>
        <td width="10%" >' . $row2['starttime'] . '</td>
        <td width="10%" >' . $row2['endtime'] . '</td>
        <td width="10%" >' . $row2['ptemp'] . '&deg;C</td>
     
     <td width="10%" >' .

            $data1['fname'] . ' ' . $data1['lname'] .
            '</td>
        <td width="10%" >' . $row2['cmnt'] . '</td>
        <td width="10%" >  <img src="/chokdee_precord/sign/' . $row2['sign'] . '" alt="Signature" width="90" /></td>
    ';





        $html2 .= '  </tr>';



    }

    $html2 .= '</table>';


    $pdf->writeHTML($html2, true, false, true, false, '');
} else {


    // $pdf->AddPage();
    $pdf->SetY(100);

    $sql2 = mysqli_query($con, "SELECT * FROM tblfreezing where pdate ='$date' and pname='$product'  and pid='$pid'");
    $html2 = '<table border="1" cellpadding="4" width="100%" style="font-size: 9px;">  ';
    if ($pid == 2) {
        $html2 .= '<tr>
    <td style="color:rgba(0, 51, 102); text-align:center;" colspan="10">Add Hot Filling (&gt;=82&deg;C or above CCP2) </td>
  
</tr>';
    } else {
        $html2 .= '<tr>
    <td style="color:rgba(0, 51, 102); text-align:center;" colspan="10">Freezing Info </td>
  
</tr>';
    }

    $html2 .= '<tr style="font-weight:bold; color:black; text-align:center;">
   
<th width="10%" style="text-align:center;">Production Date </th>
<th width="10%" style="text-align:center;">Product Name </th>
<th width="10%" style="text-align:center;">Batch code </th>';




    $html2 .= '<th width="10%" style="text-align:center;">Start Time </th>';

    if ($pid == 2) {
        $html2 .= '<th width="10%" style="text-align:center;">Product Temp (&gt;=82&deg;C ) </th>';
    } else {
        $html2 .= '<th width="10%" style="text-align:center;">Freezer Temp </th>';
    }
    $html2 .= '<th width="10%" style="text-align:center;">Finish Time </th>
';
    if ($pid == 2) {
        $html2 .= '<th width="10%" style="text-align:center;">Product Temp (&gt;=82&deg;C ) </th>';
    } else {
        $html2 .= '<th width="10%" style="text-align:center;">Freezer Temp </th>';
    }



    $html2 .= '

  <th width="10%" style="text-align:center;">Checked By </th>
       <th width="10%" style="text-align:center;">Comment </th>
       <th width="10%" style="text-align:center;">Sign </th>
</tr>';
    while ($row2 = mysqli_fetch_assoc($sql2)) {
        $query12 = mysqli_query($con, "SELECT * FROM tblstaff WHERE id='" . $row2['checkedby'] . "'");
        $data2 = mysqli_fetch_array($query12);
        $html2 .= '<tr nobr="true"  style="font-weight:bold; text-align:center;">
      
       
        <td width="10%" >' . $dt . '</td>
        <td width="10%" >' . $pro . '</td>
        <td width="10%" >' . $row2['batchcode'] . '</td>
          <td width="10%" >' . $row2['starttime'] . '</td>
        <td width="10%" >' . $row2['temp1'] . '&deg;C</td>
      
        <td width="10%" >' . $row2['endtime'] . '</td>
        <td width="10%" >' . $row2['ptemp'] . '&deg;C</td>
     
     <td width="10%" >' .

            $data2['fname'] . ' ' . $data2['lname'] .
            '</td>
        <td width="10%" >' . $row2['cmnt'] . '</td>
        <td width="10%" >  <img src="/chokdee_precord/sign/' . $row2['sign'] . '" alt="Signature" width="90" /></td>
    ';





        $html2 .= '  </tr>';



    }

    $html2 .= '</table>';


    $pdf->writeHTML($html2, true, false, true, false, '');
    $pdf->SetY(200);
    $sql1 = mysqli_query($con, "SELECT * FROM tblblastchiller where pdate ='$date' and pname='$product'  and pid='$pid'");

    $html1 = '<table border="1" cellpadding="4" width="100%" style="font-size: 9px;"> ';
    $html1 .= '<tr>
    <td style="color:rgba(0, 51, 102); text-align:center;" colspan="10">Blast Chiller (&lt;=5&deg;C in 90  minutes)
CCP3</td>
</tr>


<tr style="font-weight:bold; color:black; text-align:center;">
   
<th width="8%" style="text-align:center;">Production Date </th>
<th width="7%" style="text-align:center;">Product Name </th>
<th width="5%" style="text-align:center;">Batch code </th>
<th width="10%" style="text-align:center;">Blast Chiller Temp  </th>
<th width="8%" style="text-align:center;">Start Time </th>
<th width="10%" style="text-align:center;">Product Temp </th>
<th width="10%" style="text-align:center;">Blast Chiller Temp </th>
<th width="7%" style="text-align:center;">End Time </th>
<th width="10%" style="text-align:center;">Production Temp </th>

 <th width="7%" style="text-align:center;">Checked By </th>
       <th width="10%" style="text-align:center;">Comment </th>
<th width="8%" style="text-align:center;">Sign </th>
</tr>';
    while ($row1 = mysqli_fetch_assoc($sql1)) {
        $query11 = mysqli_query($con, "SELECT * FROM tblstaff WHERE id='" . $row1['checkedby'] . "'");
        $data1 = mysqli_fetch_array($query11);
        $html1 .= '<tr nobr="true"  style="font-weight:bold; text-align:center;">
      
       
        
        <td width="8%" >' . $dt . '</td>
        <td width="7%" >' . $pro . '</td>
        <td width="5%" >' . $row1['batchcode'] . '</td>
        <td width="10%" >' . $row1['temp1'] . '&deg;C</td>
        <td width="8%" >' . $row1['starttime'] . '</td>
        <td width="10%" >' . $row1['ptemp'] . '&deg;C</td>
        <td width="10%" >' . $row1['temp2'] . '&deg;C</td>
        <td width="7%" >' . $row1['endtime'] . '</td>
        <td width="10%" >' . $row1['ptemp2'] . '&deg;C</td>
     <td width="7%" >' .

            $data1['fname'] . ' ' . $data1['lname'] .
            '</td>
    <td width="10%" >' . $row1['cmnt'] . '</td>
     <td width="8%" >  <img src="/chokdee_precord/sign/' . $row1['sign'] . '" alt="Signature" width="90" /></td>
   
    ';





        $html1 .= '   </tr>';
    }

    $html1 .= '</table>';


    $pdf->writeHTML($html1, true, false, true, false, '');



}
$html8 = "";
if ($ac == 2) {
    $html8 .= '
<p style="color:red; text-align:center">Not Verified Yet!</p>';
} elseif ($ac == '1') {

    $vrq = mysqli_query($con, "SELECT distinct vdate,sign FROM `tblsavoury` WHERE date='$date' and product='$product' and status='Verified'  and pid='$pid'");
    $vrq1 = mysqli_fetch_assoc($vrq);
    $vsign = $vrq1['sign'];
    $vdate = $vrq1['vdate'];

    $html8 .= '
    <table border="1" width="100%"   cellpadding="5">
        <tr nobr="true">
            <th style="text-align:center; width:50%;">
                <img src="chokdee_precord/sign/' . $vsign . '" alt="Signature" width="90" height="30" />
                <br>
                <strong>Verified By</strong>
            </th>
            <th style="text-align:center; font-weight:bold; width:50%;justify-item:center; ">
            
                <strong> <br> Date :</strong> ' . htmlspecialchars($vdate) . '
            </th>
        </tr>
    </table>
';
}
$pdf->writeHTML($html8, true, false, true, false, '');
// Output PDF
if ($pid = 2) {
    $outputPath = $_SERVER['DOCUMENT_ROOT'] . "/upl1/Sauce-Production-Record" . $date . ".pdf";
} elseif ($pid = 1) {
    $outputPath = $_SERVER['DOCUMENT_ROOT'] . "/upl1/Savoury-Production-Record" . $date . ".pdf";
} else {
    $outputPath = $_SERVER['DOCUMENT_ROOT'] . "/upl1/Meat-Production-Record" . $date . ".pdf";
}

$pdf->Output($outputPath, "F");

// Check if file was created
if (file_exists($outputPath)) {
    $pid=$_GET['pid'];
    ?>

    <a
        href="admin.php?id=savouryproduction1&date=<?php echo $date ?>&product=<?php echo $product ?>&pid=<?php echo $pid ?>"><button
            class="btn btn-success float-right mr-3 ">Back</button></a>
    <?php
    if ($pid = 2) {
        echo '<iframe src="upl1/Sauce-Production-Record' . $date . '.pdf" frameborder="0" width="100%" height="550px"></iframe>';
    } elseif ($pid = 1) {
        echo '<iframe src="upl1/Savoury-Production-Record' . $date . '.pdf" frameborder="0" width="100%" height="550px"></iframe>';

    } else {
        echo '<iframe src="upl1/Meat-Production-Record' . $date . '.pdf" frameborder="0" width="100%" height="550px"></iframe>';
    }
} else {
    echo '<p style="color:red;">Error: Could not generate PDF file. Please check server permissions.</p>';
}







if ($ac == '2') {





    $date = $_GET['date'];
    $product = $_GET['product'];
    ?>

    <script type="text/javascript" src="assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="assets/js/jquery.signature.min.js"></script>
    <link rel="stylesheet" type="text/css" href="assets/js/jquery.signature.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>

    <script language="javascript">
        jQuery(document).ready(function ($) {
            // Store the window width
            var windowWidth = $(window).width();
            // Resize Event
            $(window).resize(function () {

                // Checik window width has actually changed and it's not just OS triggering a resize event on scroll
                if ($(window).width() != windowWidth) {

                    // Update the window width for next time
                    windowWidth = $(window).width();


                }



            });

        }
        );</script>
    <style>
        .kbw-signature {
            width: 400px;
            height: 200px;
        }

        #signature canvas {
            width: 100% !important;
            height: auto;
        }

        .kbw-signature1 {
            width: 400px;
            height: 200px;
        }

        #signature1 canvas {
            width: 100% !important;
            height: auto;
        }

        .container {
            margin-left: 420px;

        }
    </style>
    <div class="main-content">
        <div class="breadcrumb">
            <!-- Removed undefined $headingname -->
            <ul>
                <li><a href="">Verification Signature
                    </a></li>
                <!-- <li>Detail</li> -->
            </ul>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <!-- <a href="admin.php?id=ppm"><button class="btn btn-success" style="float:right; margin-left:15px">Go
                        Back</button></a> -->


                    <div class="row">
                        <div class="col-md-6">
                            <h3 style="color:#FF0000">Verify Signature</h3>
                            <form id="uploadForm3" method="post" action="">

                                <input type="hidden" name="date" value="<?php echo $date; ?>">
                                <input type="hidden" name="product" value="<?php echo $product; ?>">


                                <div id="res" style="color:red; font-size:20px"></div>
                                <br />
                                <div id="signature"></div>
                                <br />
                                <button id="clear" class="btn btn-warning">Clear Signature</button>
                                <button class="btn btn-success" id="Submit" type="submit" style="margin-left:20px">Signature
                                    & Verify</button>

                                <textarea id="sigpad" name="signature_image" style="display: none"></textarea>

                            </form>


                        </div>


                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">

            var signature = $('#signature').signature({ syncField: '#sigpad', syncFormat: 'PNG' });
            $('#clear').click(function (e) {
                e.preventDefault();
                signature.signature('clear');
                $("#sigpad").val('');
            });
        </script>


        <script type="text/javascript">
            $(document).ready(function (g) {

                $("#uploadForm3").on('submit', (function (g) {
                    // $("#loading").show();
                    g.preventDefault();
                    $.ajax({
                        url: "chokdee_precord/savorysign",
                        type: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (data) {
                            $("#res").html(data);


                            if (data == "") {
                                $("#res").html('<span style="color:red;">Signature not verified.<span>');

                            }

                            else {

                                window.location.href = "admin.php?id=savouryproduction1&date=<?php echo $date ?>&product=<?php echo $product ?>&pid=<?php echo $pid ?>";

                            }


                        },
                        error: function (xhr, status, error) {
                            $("#res").html('<span style="color:red;">An error occurred: ' + error + '</span>');
                        }
                    });
                }));
            });
        </script>
    <?php } ?>