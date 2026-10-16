<?php
include 'connection.php';

echo $sno = $_GET['sno'];

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
            <td width="33%">Issue Date: 20/04/2026</td>
            <td width="34%" align="center">Doc Ref: REC-6.2.3</td>
            <td width="33%">Author: Navdeep Kaur</td>
        </tr>
        <tr>
            <td>Version No: 07</td>
            <td align="center">&nbsp;&nbsp; Page ' . $pdf->getAliasNumPage() . ' of ' . $pdf->getAliasNbPages() . '</td>
            <td>Authorised By: Nishan Eleyadath</td>
        </tr>
        <tr>
            <td>Reason for Change: Sleeves checks has been recorded every half an hour</td>
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

        $frontPath = 'paperwork/upl1/'. $row1['frontimage'];


        $backPath = 'paperwork/upl1/'. $row1['backimage'];

        $table2 .= '<tr nobr="true">
       <td>' . $row1['time'] . '</td>
       <td>' . $row1['sleeveissue'] . '</td>
       <td>' . $row1['comment'] . '</td>
       <td>' . $row1['checkedby'] . '</td>
       <td align="center">
       <br>
       <br>
       <a href="../' . $frontPath . '" target="_blank"><img src="'.$frontPath.'" height="100" width="120" alt=""></a><br><br>
           
           <a href="../' . $backPath . '" target="_blank"><img src="'. $backPath.'" height="100" width="120" alt=""></a>
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






$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "upl1/sleveissueview_" . $sno . ".pdf", "F");
?>



<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2"><?php echo $headingname; ?></h1>
        <ul>
            <li><a href="">Home</a></li>
            <li>Sleeve Issue</li>
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <a href="admin.php?id=sleeve"><button class="btn btn-success" style="float:right; margin-left:15px">Go
                        Back</button></a>


                <a href="upl1/sleveissueview_<?= $sno ?>.pdf" >
                    <button class="btn btn-success" style="float:right; margin-left:15px">
                        Download Report
                    </button>
                </a>




                <div class="card-title"> Sleeve Issue</div>
                <div class="table-responsive">
                    <table class="display table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Time</th>
                                <th>Product Code</th>
                                <th>Name of Issuer</th>
                                <th>Name of person receiving/returning sleeves</th>
                                <th>Is the machine being used free of any damage and fully functioning ?</th>
                                <th>Has the packing line been cleared from packaging materials used in previous run/shifts?</th>
                                <th>Number of batches to be packed</th>
                                <th>Number of pouches/sleeves issue</th>
                                <th>Signature</th>
                            </tr>


                        </thead>
                        <tbody>
                            <?php
                            $sql = mysqli_query($con, "SELECT * FROM `sleveissue` WHERE id='$sno'");
                            $srno = 1;
                            $row = mysqli_fetch_assoc($sql);

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
                            ?>
                            <tr>
                                <td><?php echo $row['time']; ?></td>
                                <td><?php echo $row['productcode']; ?></td>
                                <td><?php echo $row['issuername']; ?></td>
                                <td><?php echo $row['personname']; ?></td>
                                <td><?php echo $row['machine']; ?></td>
                                <td><?php echo $packingline .'<br>'. $row['packingline']; ?></td>
                                <td><?php echo $row['batches']; ?></td>
                                <td><?php echo $row['pouchessleevesissue']; ?></td>
                                <td><img src="paperwork/sign/<?= $row['sign'] ?>.png" alt=""></td>
                            </tr>
                            <tr>
                                <th>Is the correct product sleeve and coding used as per the Y/N</th>
                                <th>Barcode of sleeve issue</th>
                                <th>Last three digits of barcode matches barcode sheet</th>
                                <th>2D barcode of sleeve issued</th>
                                <th>Number of pouches/sleeves returned</th>
                                <th>Number of pouches/sleeves packed</th>
                                <th>Number of sleeves wasted/used for records</th>
                                <th>All sleeves accounted for ?</th>
                                <th>Comments</th>
                            </tr>
                            <tr>
                                <td><?php echo $correctsleeve .'<br>'. $row['correctsleeve'] ?></td>
                                <td><?php echo $barcodesleeveissue.'<br>' . $row['barcodesleeveissue'] ?></td>
                                <td><?php echo $lastdigit1 .'<br>'. $row['lastdigit']; ?></td>
                                <td><?php echo $twodbarcode .'<br>'. $row['twodbarcode'] ?></td>
                                <td><?php echo $row['pouchesreturned']; ?></td>
                                <td><?php echo $row['pouchespacked']; ?></td>
                                <td><?php echo $row['sleeveswasted']; ?></td>
                                <td><?php echo $row['accounted']; ?></td>
                                <td><?php echo $row['comment']; ?></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>


            <br>
            <hr>
            <br>

            <div class="table-responsive m-3">
                <h3 class="card-title">Check every half an hour</h3>
                <table width="100%" border="0.5" cellpadding="4" style="border-collapse:collapse;"
                    class="display table table-striped table-bordered" id="zero_configuration_table" align="center">
                    <thead>
                        <tr nobr="true" style="font-weight:bold; background-color:#f2f2f2;">
                            <td>S No.</td>
                            <td>Time</td>
                            <td>Is the correct product sleeve being used?</td>
                            <td>Comments</td>
                            <td>Checked By</td>
                            <td>Images</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql1 = mysqli_query($con, "SELECT * FROM `sleveissue1` WHERE sno='$sno'");
                        $si = 0;
                        while ($row1 = mysqli_fetch_assoc($sql1)) {
                            $si++;
                            $frontPath = 'paperwork/upl1/'. $row1['frontimage'];
                            $backPath  = 'paperwork/upl1/'. $row1['backimage'];
                        ?>
                            <tr nobr="true">
                                <td><?php echo $si; ?></td>
                                <td><?php echo $row1['time']; ?></td>
                                <td><?php echo $row1['sleeveissue']; ?></td>
                                <td><?php echo $row1['comment']; ?></td>
                                <td><?php echo $row1['checkedby']; ?></td>
                                <td align="center">
                                        <img src="<?php echo $frontPath; ?>" height="100" width="120" alt="">
                                 
                                    <br><br>
                            
                                        <img src="<?php echo $backPath; ?>" height="100" width="120" alt="">
                                  
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <br>
            <hr><br>

            <div>

                <h2>End of Shift Check</h2>
                <table style="width:100%; border:1px solid #000; border-collapse:collapse;" cellpadding="6">
                    <tr style="font-weight:bold; background-color:#f2f2f2;">
                        <td style="border:1px solid #000;">Time</td>
                        <td style="border:1px solid #000;">Is the correct product sleeve and coding used as per the product?</td>
                        <td style="border:1px solid #000;">Comments</td>
                        <td style="border:1px solid #000;">Checked By</td>
                    </tr>
                 

                    <tr>
                        <td style="border:1px solid #000;">
                            <?= $row['finaltime'] ?>
                        </td>
                        <td style="border:1px solid #000;">
                            <?= $row['correct1'] ?>
                        </td>
                        <td style="border:1px solid #000;">
                            <?= $row['comment1'] ?>
                        </td>
                        <td style="border:1px solid #000;">
                            <?= $row['checked1'] ?>
                        </td>
                    </tr>

                </table>
            </div>

            <br>

            <br>
            <div class="row mb-5">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <?php
                    if (empty($row['verify'])) {
                    ?>
                        <a href="admin.php?id=sleveverify&sno=<?php echo $sno; ?>"><button class="btn btn-danger bg-warning text-white form-control mx-3"
                                style="float:right; margin-left:15px">Verify</button></a>
                    <?php
                    }

                    ?>

                </div>
                <div class="col-md-1"></div>
            </div>


        </div>
    </div>