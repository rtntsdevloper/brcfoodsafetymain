<?php
include("connection.php");
require_once('tcpdf/tcpdf.php');

$sno = $_GET['sno'];
$rid = $_GET['rid'];

$sql = mysqli_query($con, "SELECT * FROM tblequipment1 WHERE id='$sno'");
$row = mysqli_fetch_array($sql);

$sql2 = mysqli_query($con, "SELECT * FROM tblequipment WHERE id='$row[eid]'");
$row2 = mysqli_fetch_array($sql2);

// Fetch request details from ppmraise
$sql_req = mysqli_query($con, "SELECT * FROM `ppmraise` WHERE eqpname='$row[eid]' and id='$rid' ");
$row_req = mysqli_fetch_array($sql_req);

$sql_eqp = mysqli_query($con, "SELECT * FROM `tblequipment` WHERE id='$row_req[eqpname]'");
$row_eqp = mysqli_fetch_array($sql_eqp);
$equipmentname = $row_eqp['name'];

class MYPDF extends TCPDF {
    private $logo1Path = 'images/1.png';
    private $logo2Path = 'images/rtnts.png';
    private $longTableFooter = '';

    public function Header() {
        $this->SetFillColor(255, 255, 255);
        $this->Rect(0, 0, $this->getPageWidth(), 30, 'F');

        if (file_exists($this->logo1Path)) {
            $this->Image($this->logo1Path, 15, 10, 32, '', '', '', 'T');
        }
        if (file_exists($this->logo2Path)) {
            $this->Image($this->logo2Path, 255, 7, 30, '', '', '', 'T');
        }

        $this->SetFont('century gothic', 'B', 22);
        $this->SetTextColor(0, 51, 102);
        $this->SetXY(12, 12);
        $this->Cell(0, 0, 'Equipment Maintenance Report', 0, 1, 'C');

        $this->SetLineWidth(0.5);
        $this->SetDrawColor(0, 102, 204);
        $this->Line(15, 28, 280, 28);
    }

    public function Footer() {
        $this->SetFont('helvetica', '', 8);
        $this->SetY(-20);
        $this->writeHTML($this->longTableFooter);
    }

    public function setLongTableFooter($html) {
        $this->longTableFooter = $html;
    }
}

$pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator('Your Company');
$pdf->SetAuthor('Record');
$pdf->SetTitle('Equipment Maintenance Report');
$pdf->SetSubject('Equipment Maintenance Report');
$pdf->SetMargins(15, 30, 15);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(20);
$pdf->SetAutoPageBreak(TRUE, 25);

$footer = '
<table width="100%" cellpadding="3" border="0.2" style="font-size:9px; border-color:#000000; color:black;">
    <tr>
        <td width="255">Issue date: </td>
        <td width="240" align="center">Page ' . $pdf->getAliasNumPage() . ' / ' . $pdf->getAliasNbPages() . '</td>
        <td width="255">Amended: </td>
    </tr>
    <tr>
        <td width="255">Version No:</td>
        <td width="240" align="center">Doc Ref:</td>
        <td width="255">Authorised by:</td>
    </tr>
    <tr>
        <td width="750" colspan="2">Reason for Change: Form has been reviewed</td>
    </tr>
</table>';

$pdf->setLongTableFooter($footer);
$pdf->AddPage();
$pdf->SetY(40);


$pdf->SetFont('centurygothic', 'B', 14);

// Set fill color (light orange)
$pdf->SetFillColor(255, 200, 150);
$pdf->Cell(0, 10, 'Equipment Maintenance Request', 0, 1, 'C', true);

// Section 1: Equipment Maintenance Request
$html1 = '<br><br><table border="1" cellpadding="6" width="100%" style="font-size:11px; line-height:1.4;">
<style>

th{
background-color: #90EE90;
}
</style>
    <tr><th width="30%">Request Number</th><td width="70%">'.$row_req['request'].'</td></tr>
    <tr><th width="30%">Date Raised</th><td width="70%">'.date("d-m-Y", strtotime($row_req['date'])).'</td></tr>
    <tr><th width="30%">Raised By</th><td width="70%">'.$row_req['raisedby'].'</td></tr>
    <tr><th width="30%">Production Area</th><td width="70%">'.$row_req['area'].'</td></tr>
    <tr><th width="30%">Equipment Name</th><td width="70%">'.$equipmentname.'</td></tr>
    <tr><th width="30%">Equipment ID</th><td width="70%">'.$row_req['equipmentcode'].'</td></tr>
    <tr><th width="30%">Equipment Location</th><td width="70%">'.$row_req['location'].'</td></tr>
</table>
<br>';

$pdf->writeHTML($html1, true, false, true, false, '');

// Section 2: Maintenance Completion
$string2 = $row['checks'];
$tags2 = explode(';', $string2);

// Additional fields
$safety2_reason = $row['safety2_reason'];



$pdf->SetFont('centurygothic', 'B', 14);

// Set fill color (light orange)
$pdf->SetFillColor(255, 200, 150);
$pdf->Cell(0, 10, 'Maintenance Completion', 0, 1, 'C', true);
$html2 = '<br><br>
<table border="1" cellpadding="4" width="100%" style="font-size:10px;">
<style>

th{
background-color: #90EE90;
}
</style>
    <tr>
    <th width="30%">1° Safety Check (Maintenance work carried out and complete)</th>
    <td width="70%">'. $tags2[0].'</td>
    </tr>
    <tr>
    <th width="30%">2° Safety Check: (Any residual debris from maintenance work removed and cleared)</th>
    <td width="70%">'. $tags2[1] . ' ('.$safety2_reason. ')' .'</td>
    </tr>';



    $html2 .= '<tr>
    <th width="30%">3° Safety Check (Are tools and equipment used maintenance wiped cleaned and sanitized)</th>
    <td width="70%">'. $tags2[2].'</td>
    </tr>
        <tr>
        <th width="30%">4° Safety Check (Equipment in good working order and ready for food safe operation</th>
        <td width="70%">'.$tags2[3].'</td>
    </tr>
    <tr nobr="true"><th width="30%">Corrective Action</th><td width="70%">'.$row['description'].'</td></tr>
    <tr><th width="30%">Date Performed</th><td width="70%">'.(!empty($row['dateperformed']) ? date('d-m-Y',strtotime($row['dateperformed'])) : '').'</td></tr>
    <tr><th width="30%">Any Parts Replaced</th><td width="70%">'.$row['preplace'].'</td></tr>
    <tr><th width="30%">Root Cause</th><td width="70%">'.$row['root'].'</td></tr>
    <tr><th width="30%">Downtime Duration</th><td width="70%">'.$row['duration'].'</td></tr>';

// Service Report - Check if file exists
if(!empty($row['serviceimg']) && file_exists('upl1/'.$row['serviceimg'])) {
    $html2 .= '<tr nobr="true"><th width="30%">Service Report</th>
        <td width="70%">
            <a href="../upl1/'.$row['serviceimg'].'" target="_blank" style="text-decoration:none;">View</a>
        </td>
    </tr>';
}

// Supporting Documents - Check if file exists
if(!empty($row['supdoc']) && file_exists('upl1/'.$row['supdoc'])) {
    $html2 .= '<tr nobr="true"><th width="30%">Supporting Documents</th>
        <td width="70%">
            <a href="/BRC/upl1/'.$row['supdoc'].'" target="_blank" style="text-decoration:none;">View</a>
        </td>
    </tr>';
}

// Additional fields
if(!empty($row['production'])) {
    $html2 .= '<tr>
    <th width="30%">Due Production needs be stopped for this Maintenance ?</th>
    <td width="70%">'.$row['production'].'</td></tr>';
}
if(!empty($row['hours'])) {
    $html2 .= '<tr>
    <th width="30%">How many hours production cannot be carried out ?</th>
    <td width="70%">'.$row['hours'].' hours</td>
    </tr>';
}
if(!empty($row['engineer_type'])) {
    $html2 .= '<tr>
    <th width="30%">Is the engineer internal or external?</th>
    <td width="70%">'.$row['engineer_type'].'</td>
    </tr>';
}
if(!empty($row['visit_completed'])) {
    $html2 .= '<tr>
    <th width="30%">The person has completed visit before enter Production ? </th>
    <td width="70%">'.$row['visit_completed'].'</td>
    </tr>';
}
if(!empty($row['corrective_reason'])) {
    $html2 .= '<tr><th width="30%">Corrective Action</th><td width="70%">'.$row['corrective_reason'].'</td></tr>';
}
if(!empty($row['stime'])) {
    $html2 .= '<tr><th width="30%">Maintenance Start Time</th><td width="70%">'.date('d-m-Y h:i a',strtotime($row['stime'])).'</td></tr>';
}
if(!empty($row['etime'])) {
    $html2 .= '<tr><th width="30%">Maintenance End Time</th><td width="70%">'.date('d-m-Y h:i a',strtotime($row['etime'])).'</td></tr>';
}

$html2 .= '<tr>
        <th width="30%">Engineer Name</th><td width="70%">'.$row['ename'].'</td>
    </tr>
    <tr>
        <th width="30%">Task Completed By</th><td width="70%">'.$row['completedby'].'</td>
    </tr>';

$html2 .= '</table>
<br>';

$pdf->writeHTML($html2, true, false, true, false, '');

// Section 3: Machine Verification (8 Questions)
if($row['mverify'] == 'done'){
    $vsql = mysqli_query($con, "SELECT * FROM `raiseverify` WHERE sno='$sno' ");
    $vrow = mysqli_fetch_array($vsql);
    
    if($vrow) {
        // Split the stored data
        $que_array = explode(' ; ', $vrow['que']);
        $comment_array = explode(' ; ', $vrow['comment']);
        $img_array = explode(' ; ', $vrow['img']);
        
        // 8 Verification Questions
        $questions = [
            '1' => 'Equipment visually inspected?',
            '2' => 'Equipment operates correctly?',
            '3' => 'Safety guards fitted?',
            '4' => 'Emergency stops functioning?',
            '5' => 'Is the area free from any foreign object?',
            '6' => 'Equipment safe for production use?',
            '7' => 'Is it visually clean?',
            '8' => 'Are the swabs required?'
        ];

        
        $pdf->SetFont('centurygothic', 'B', 14);

        // Set fill color (light orange)
        $pdf->SetFillColor(255, 200, 150);
        $pdf->Cell(0, 10, 'Machine Verification Detail', 0, 1, 'C', true);

        
        $html4 = '<br><br>
        <table border="1" cellpadding="4" width="100%" style="font-size:10px;">
        <style>

        th{
        background-color: #90EE90;
        }
        </style>';  
        
        $counter = 0;
        foreach($questions as $alpha => $question) {
            $answer = isset($que_array[$counter]) ? $que_array[$counter] : '';
            $comment = isset($comment_array[$counter]) ? $comment_array[$counter] : '';
            $image = isset($img_array[$counter]) ? $img_array[$counter] : '';
            
            $html4 .= '<tr nobr="true">
                <th width="3%">'.$alpha.'.</th>
                <th width="37%">'.$question.'</th>
                <td width="15%">'.$answer.'</td>
                <td width="45%">';
            
            if(!empty($comment)) {
                $html4 .= '<strong>Corrective Action:</strong> '.$comment.'<br>';
            }
            if(!empty($image) && file_exists('upl1/'.$image)) {
                $html4 .= '<br><img src="upl1/'.$image.'" height="60" width="60"><br>';
            } elseif(!empty($image)) {
                $html4 .= '<span style="color:red;">Image not found</span>';
            }
            
            $html4 .= '</td>
            </tr>';
            $counter++;
        }
        
        $html4 .= '</table>
        <br>';
        $pdf->writeHTML($html4, true, false, true, false, '');
        
        // Commissioning Details
        $commissioning_outcome = isset($vrow['outcome']) ? $vrow['outcome'] : '';
        $commissioning_comment = isset($vrow['comment1']) ? $vrow['comment1'] : '';
        $commissioning_date = !empty($vrow['datecommission']) ? date('d-m-Y', strtotime($vrow['datecommission'])) : '';
        $commissioned_by = isset($vrow['commisionby']) ? $vrow['commisionby'] : '';
        

  $pdf->SetFont('centurygothic', 'B', 14);

        // Set fill color (light orange)
        $pdf->SetFillColor(255, 200, 150);
        $pdf->Cell(0, 10, 'Commissioning Details', 0, 1, 'C', true);


        $html5 = '<br><br>
        <table border="1" cellpadding="4" width="100%" style="font-size:10px;">
        <style>

        th{
        background-color: #90EE90;
        }
        </style>
        <tr>
            <th width="20%">Commissioning Outcome</th>
            <td width="30%">'.$commissioning_outcome.'</td>
            <th width="20%">Date of Commissioned</th>
            <td width="30%">'.$commissioning_date.'</td>
        </tr>
        <tr>
            <th width="20%">Comment</th>
            <td colspan="3">'.$commissioning_comment.'</td>
        </tr>
        <tr>
            <th width="20%">Commissioned By</th>
            <td colspan="3">'.$commissioned_by.'</td>
        </tr>
        </table>
        <br>';
        
        $pdf->writeHTML($html5, true, false, true, false, '');
        
        // Section 5: Signature
        if(!empty($vrow['sign']) && file_exists('sign/'.$vrow['sign'].'.png')){
            $sign = '<img src="sign/'.$vrow['sign'].'.png" height="30">';
        } else {
            $sign = "";
        }
        
        $html6 = '<h3 style="color:#003366;"></h3>
        <table border="0" cellpadding="4" width="100%" style="font-size:10px;">
        <tr>
            <td width="80%"></td>
            <td width="20%">'.$sign.'</td>
        </tr>
        <tr>
            <td width="80%"></td>
            <td width="20%"><strong>Verified By:</strong> '.$commissioned_by.'</td>
        </tr>
        </table>';
        
        $pdf->writeHTML($html6, true, false, true, false, '');
    }
}
$filename = "raise_request_ad_$sno.pdf";
$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "finemed/ppm/upl1/$filename", "F");
?>

<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-12 d-flex justify-content-end">
            <a href="admin.php?id=rcomplete1&sno=<?php echo $sno; ?>&rid=<?php echo $rid; ?>&month=<?php echo $month; ?>&year=<?php echo $year;  ?>" class="btn btn-success mt-3">Go Back</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <iframe src="ppm/upl1/raise_request_ad_<?php echo $sno; ?>.pdf" frameborder="0" width="100%" height="600px"></iframe>

    
        </div>
    </div>
</div>