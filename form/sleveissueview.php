<?php
include 'connection.php';

$sno = $_GET['sno'];

require_once('tcpdf/tcpdf.php');

class MYPDF extends TCPDF
{
    private $logo1Path = 'images/logo1.png';
    private $logo2Path = 'images/rtnts.png';
    private $footerHTML = '';

    public function Header()
    {
        $this->SetFillColor(255, 255, 255);
        $this->Rect(0, 0, $this->getPageWidth(), 30, 'F');

        if (file_exists($this->logo1Path)) {
            $this->Image($this->logo1Path, 15, 7, 25, '18', 'PNG');
        }
        if (file_exists($this->logo2Path)) {
            $this->Image($this->logo2Path, $this->getPageWidth() - 50, 7, 35, '18', 'PNG');
        }

        $this->SetFont('helvetica', 'B', 16);
        $this->SetTextColor(0, 51, 102);
        $this->Cell(280, 13, 'Sleeve Issue Control', 0, 1, 'C');

        $this->SetLineWidth(0.5);
        $this->SetDrawColor(0, 102, 204);
        $this->Line(15, 28, $this->getPageWidth() - 15, 28);
    }

    public function Footer()
    {
        $this->SetY(-28);
        $this->SetFont('helvetica', '', 10);
        $this->SetTextColor(0, 0, 0);

        $this->SetLineWidth(0.2);
        $this->SetDrawColor(204, 204, 204);

        if (!empty($this->footerHTML)) {
            $this->SetY(-25);
            $this->writeHTML($this->footerHTML, true, false, true, false, '');
        } else {
            $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . ' / ' . $this->getAliasNbPages(), 0, 0, 'C');
        }
    }

    public function setFooterHTML($footer)
    {
        $this->footerHTML = $footer;
    }
}

$pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetMargins(5, 50, 115);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(30);
$pdf->SetAutoPageBreak(TRUE, 40);

$footer = '
    <table width="163%" cellpadding="3" border="1" style="font-size:10px;">
        <tr>
            <td width="33%">Issue date:01/03/2022</td>
            <td width="34%" align="center">Doc Ref: REC-6.2.3</td>
            <td width="33%">Issued by: Nishita Rai</td>
        </tr>
        <tr>
            <td>Version No:006</td>
            <td align="center">&nbsp;&nbsp; Page ' . $pdf->getAliasNumPage() . ' of ' . $pdf->getAliasNbPages() . '</td>
            <td>Authorised By: Kathryn Bricken</td>
        </tr>
        <tr>
            <td>Reason for change:Line Checks added</td>
        </tr>
    </table>';
$pdf->setFooterHTML($footer);

$pdf->AddPage();
$pdf->SetFont('helvetica', 'B', 12);
$pdf->SetXY(15, 32);

$sql = mysqli_query($con, "SELECT * FROM `sleveissue` where id='$sno'");
$row = mysqli_fetch_assoc($sql);
$pdf->writeHTML('Date: ' . date('d-m-Y', strtotime($row['date'])) . ' ');
$pdf->SetFont('helvetica', '', 10);

$pdf->SetXY(14, 40);

$header = '
        <table width="100%" cellpadding="3" style="font-size:12px; color:black;">
        <style>
        td{
        
        }
        </style>
           
<tr>
    <td style="text-align:left; font-size:11px;">
        1. All sleeves need to be issued by the operations supervisor/authorised personnel. 
        All details below must be entered for every production run.<br>
        2. The verification of correct product sleeve and coding being used as per product has to be done prior to start the run, hourly and at the end of each run.<br>
        3. All sleeves should be accounted for i.e. sleeves issued = sleeves used + sleeves returned + sleeves wasted/discarded.<br>
        4. Any material disposed must be recorded in this form. Any discrepancy needs to be immediately reported to the direct Manager, and a non-conformance raised and investigated.
    </td>
</tr>



        </table>';
$pdf->writeHTML($header, true, false, true, false, '');

$pdf->SetY(90);
// Example data table
$table1 = '<table width="70%" border="0.5" cellpadding="2" style="border-collapse:collapse;">
            <tr nobr="true">
                <th width="10%">Time</th>
                <th width="12%">Product Code</th>
                <th width="12%">Product Name</th>
                <th width="10%">Name of Issuer</th>
                <th width="11.5%">Name of person receiving/returning sleeves</th>
                <th width="15%">Is the machine being used free of any damage and fully functioning ?</th>
                <th width="17%">Has the packing line being cleared from packaging materials used in previous run/shifts?</th>
                <th width="10.5%">Number of batches of be packed</th>
                <th width="11%">Number of pouches/sleeves issue</th>
                <th width="11%">Is the correct product sleeve and coding used as per the Y/N</th>
                <th width="11.5%">Barcode of sleeve issue</th>
            <th width="17%">Last three Number of digits of barcode matches barcode sheet(note last three digits)</th>
                <th width="12%">2 D barcode of sleeve issued</th>
                <th width="12%">Number of pouches/sleeves returned</th>
                <th width="11.5%">Number of pouches/sleeves is packed</th>
                <th width="20%">Number of sleeves wasted/used for records (note manufacturing defects separately and inform)</th>
                <th width="14.5%">All sleeve accounted for ?</th>
                <th width="15%">Comments</th>
            </tr>';

$sql = mysqli_query($con, "SELECT * FROM `sleveissue` where id='$sno'");
while ($row = mysqli_fetch_assoc($sql)) {

    if ($row['packingline'] == 'Yes') {
        $packingline = '<a href="../paperwork/upl1/' . $row['packingline1'] . '" target="_blank"><img src="paperwork/upl1/' . $row['packingline1'] . '" height="100" width="120" alt=""></a>';
    } else {
        $packingline = $row['packingline1'];
    }

    if ($row['correctsleeve'] == 'Yes') {
        $correctsleeve = '<a href="../paperwork/upl1/' . $row['correctsleeve1'] . '" target="_blank"><img src="paperwork/upl1/' . $row['correctsleeve1'] . '" height="100" width="120" alt=""></a>';
    } else {
        $correctsleeve = $row['correctsleeve1'];
    }

    $barcodesleeveissue = '<a href="../paperwork/upl1/' . $row['barcodesleeveissue1'] . '" target="_blank"><img src="paperwork/upl1/' . $row['barcodesleeveissue1'] . '" height="100" width="120" alt=""></a>';


    $twodbarcode = '<a href="../paperwork/upl1/' . $row['twodbarcode1'] . '" target="_blank"><img src="paperwork/upl1/' . $row['twodbarcode1'] . '" height="100" width="120" alt=""></a>';
    $lastdigit1 = '<a href="../paperwork/upl1/' . $row['lastdigit1'] . '" target="_blank"><img src="paperwork/upl1/' . $row['lastdigit1'] . '" height="100" width="120" alt=""></a>';

    $table1 .= '<tr nobr="true">
                <td>' . $row['time'] . '</td>
                <td>' . $row['productcode'] . '</td>
                <td>' . $row['productname'] . '</td>
                <td>' . $row['issuername'] . '</td>
                <td>' . $row['personname'] . '</td>
               <td>' . $row['machine'] . '</td>
                <td align="center">' . $packingline . '<br>' . $row['packingline'] . '</td>
                <td>' . $row['batches'] . '</td>
                <td>' . $row['pouchessleevesissue'] . '</td>
                <td align="center">' . $correctsleeve . '<br>' . $row['correctsleeve'] . '</td>
                <td align="center">' . $barcodesleeveissue . '<br>' . $row['barcodesleeveissue'] . '</td>
                <td align="center">' . $lastdigit1 . '<br>' . $row['lastdigit'] . '</td>
                <td align="center">' . $twodbarcode . '<br>' . $row['twodbarcode'] . '</td>
                <td>' . $row['pouchesreturned'] . '</td>
                <td>' . $row['pouchespacked'] . '</td>
                <td>' . $row['sleeveswasted'] . '</td> 
                <td>' . $row['accounted'] . '</td>
                <td>' . $row['comment'] . '</td>
            </tr>';

    $table1 .= '</table>';

    $pdf->writeHTML($table1, true, false, true, false, '');


    $pdf->SetY(165);
    $table2 = '<h2>Check every half an hour</h2>
<table width="120%" border="0.5" cellpadding="4" style="border-collapse:collapse;" align="center">
    <tr nobr="true" style="font-weight:bold; background-color:#f2f2f2;">
       <td>Time</td>
       <td>Is the correct product sleeve being used?</td>
       <td>Comments</td>
       <td>Checked By</td>
       <td width="50%">Images</td>
    </tr>';

    $sql1 = mysqli_query($con, "SELECT * FROM `sleveissue1` WHERE sno='$sno'");
    while ($row1 = mysqli_fetch_assoc($sql1)) {

        $frontPath = 'paperwork/upl1/' . $row1['frontimage'];


        $backPath = 'paperwork/upl1/' . $row1['backimage'];

        $table2 .= '<tr nobr="true">
       <td>' . $row1['time'] . '</td>
       <td>' . $row1['sleeveissue'] . '</td>
       <td>' . $row1['comment'] . '</td>
       <td>' . $row1['checkedby'] . '</td>
       <td align="center">
       <br>
       <br>
       <a href="../' . $frontPath . '" target="_blank"><img src="' . $frontPath . '" height="100" width="120" alt=""></a><br><br>
           
           <a href="../' . $backPath . '" target="_blank"><img src="' . $backPath . '" height="100" width="120" alt=""></a>
           </td>
    </tr>';
    }

    $table2 .= '</table>';

    $pdf->writeHTML($table2, true, false, true, false, '');




    $table3 = '<h2>End of shift check</h2>
<table width="155%" border="0.5" cellpadding="2" style="border-collapse:collapse;">
    <tr nobr="true" style="font-weight:bold; background-color:#f2f2f2;">
       <td>Time</td>
       <td>Is the correct product sleeve and coding used as per the product?</td>
       <td>Comments</td>
       <td>Checked By</td>
    </tr>';
    $table3 .= '<tr nobr="true">
       <td>' . $row['finaltime'] . '</td>
       <td>' . $row['correct1'] . '</td>
       <td>' . $row['comment1'] . '</td>
       <td>' . $row['checked1'] . '</td>
    </tr>';


    $table3 .= '</table>';

    $pdf->writeHTML($table3, true, false, true, false, '');




    $pdf->SetX(50);
    $table4 = '<table width="155%" border="0" cellpadding="2" style="border-collapse:collapse;">
    <tr nobr="true" >

      <td  width="70%"><img src="paperwork/sign/' . $row['sign'] . '.png" height="100" width="120" alt=""></td>
      <td  width="50%"><img src="paperwork/sign/' . $row['verify'] . '.png" height="100" width="120" alt=""></td>
    </tr>';
    $table4 .= '<tr nobr="true">
            <td width="70%">Issuer By</td>            
            <td width="50%">Verify By</td>

    </tr>';
}
$table4 .= '</table>';

$pdf->writeHTML($table4, true, false, true, false, '');






$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "upl1/sleveissueview.pdf", "F");
?>


<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-12 d-flex justify-content-end">
            <a href="admin.php?id=sleeve" class="btn btn-primary">Go Back</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <iframe src="upl1/sleveissueview.pdf" frameborder="0" width="100%" height="600px"></iframe>


            <?php
            $verify = mysqli_query($con, "SELECT * FROM `sleveissue` where id='$sno'");
            $verifyrow = mysqli_fetch_array($verify);

            if (empty($verifyrow['verify'])) {
            ?>

                <a href="admin.php?id=sleveverify&sno=<?php echo $sno ?>"
                    class="btn btn-warning text-white w-100">Verify</a>
            <?php
            } else {
            }
            ?>
        </div>
    </div>
</div>