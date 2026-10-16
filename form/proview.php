<?php
include 'connection.php';
require_once('tcpdf/tcpdf.php');
$cid = $_GET['cid'];
// Get record ID from query string
$record_id = $_GET['tid'];

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
        if (file_exists($this->logo1Path)) {
            $this->Image($this->logo1Path, 15, 7, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }

        // Add logo 2 (right)
        if (file_exists($this->logo2Path)) {
            $this->Image($this->logo2Path, 260, 7, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }

        // Main title
        $this->SetFont('helvetica', 'B', 16);
        $this->SetTextColor(0, 51, 102);
        $this->SetXY(12, 12);
        $this->Cell(0, 0, 'PRODUCT PACKING RECORD CHECK SHEET', 0, 1, 'C');

        // Header line
        $this->SetLineWidth(0.5);
        $this->SetDrawColor(0, 51, 102);
        $this->Line(15, 28, 285, 28);
    }

    public function Footer()
    {
        $this->SetY(-20);
        $this->SetFont('helvetica', '', 8);
        $this->SetTextColor(0, 0, 0);

        // Custom footer HTML if set
        if (!empty($this->footerHTML)) {
            $this->SetY(-21);
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
$pdf = new MYPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);

// Set document information
$pdf->SetCreator('BRC Food Safety');
$pdf->SetAuthor('BRC Food Safety');
$pdf->SetTitle('Product Packing Record Check Sheet');
$pdf->SetSubject('CD 60 Product Packing Record');

// Set default monospaced font
$pdf->SetDefaultMonospacedFont('courier');

// Set margins
$pdf->SetMargins(15, 30, 15);
$pdf->SetHeaderMargin(10);
$pdf->SetAutoPageBreak(TRUE, 25);

// Footer content
$footerContent = <<<EOD
<table border="1" cellpadding="4" width="102%" style="font-size:8px;">
    <tr>
        <td width="33%" style="text-align:left;">CD 60</td>
        <td width="33%" style="text-align:center;">Issue: 14</td>
        <td width="33%" style="text-align:left;">Amended by: Bijal Chauhan</td>
    </tr>
    
    <tr>
            <td width="33%" style="text-align:left;">Product packing record check sheet</td>

        <td width="33%" style="text-align:center;">Issue Date: 05/05/2018</td>
        <td width="33%" style="text-align:left;">Authorised by: Mahesh Prajapati (RTNTS)</td>
    </tr>
</table>
EOD;

$pdf->setFooterHTML($footerContent);

// Add first page
$pdf->AddPage();

// Get data from database
$data = [];
if ($record_id) {
    $query = "SELECT * FROM tblproductpacking WHERE id = '$record_id'";
    $result = mysqli_query($con, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
    }
}

// Function to clean and parse pallet data
function cleanPalletData($string)
{
    if (empty($string)) {
        return [];
    }

    // Remove all quotes and brackets
    $string = str_replace(['"', "'", '[', ']', '(', ')', '{', '}'], '', $string);

    // Split by commas
    $items = explode(',', $string);

    // Trim whitespace from each item and filter empty
    $cleaned = [];
    foreach ($items as $item) {
        $item = trim($item);
        if (!empty($item)) {
            $cleaned[] = $item;
        }
    }

    return $cleaned;
}

// Parse pallet details
$palletserial_array = cleanPalletData($data['palletserial']);
$palletnumber_array = cleanPalletData($data['palletnumber']);
$box_array = cleanPalletData($data['box']);
$pstart_array = cleanPalletData($data['pstart']);

// Get the maximum number of entries
$max_entries = max(
    count($palletserial_array),
    count($palletnumber_array),
    count($box_array),
    count($pstart_array)
);

// Set starting position
$pdf->SetY(35);

// Main content HTML for first page
$html = '
<style>
    .label { font-weight: bold; font-size: 10pt; }
    .field { font-size: 10pt; padding: 2px; }
    .table-border { border: 1px solid #000; }
    .cell { border: 1px solid #000; padding: 5px; }
    .center { text-align: center; }
    .left { text-align: left; }
    .right { text-align: right; }
    .border-bottom { border-bottom: 1px solid #000; }
    .border-top { border-top: 1px solid #000; }
    .border-left { border-left: 1px solid #000; }
    .border-right { border-right: 1px solid #000; }
    .bold { font-weight: bold; }
    .underline { text-decoration: underline; }
    .no-border { border: none; }
    .small { font-size: 8pt; }
</style>';
// First row: Date and Ink Jet Code
$html .= '
<table border="0" cellpadding="2" cellspacing="0" width="100%" style="font-size: 10pt;">
    <tr>
        <td width="45%" class="label">Date: ' . date('d-m-Y', strtotime($data['date'])) . '</td>
        <td width="50%" colspan="2" class="label" style="text-align: right;">INK JET CODE: ' . $data['inkjet'] . '</td>
    </tr>
</table>
<br><br>';

// INNER PACKAGING LABEL section
$html .= '
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size: 10pt;">
    <tr>
        <td width="60%" style="vertical-align: top;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td width="100%" class="label">INNER PACKAGING LABEL</td>
                </tr>
            </table>
            
            <table border="1" cellpadding="4" cellspacing="0" width="100%" style="font-size: 8.5pt; border-collapse: collapse; margin-top: 5px;">
                <tr>
                    <td width="25%" rowspan="2" style="border: 1px solid #000; text-align: center; vertical-align: middle; font-weight: bold; font-size: 9pt;"></td>
                    <td width="75%" colspan="3" style="border: 1px solid #000; text-align: center; font-weight: bold; border-bottom: 2px solid #000; font-size: 9pt;">Control of Label</td>
                </tr>

                <tr style="text-align:center;">
                    <td width="25%">No. of label Printed</td>
                    <td width="25%">No. of label used</td>
                    <td width="25%">No. of label discard</td>
                </tr>

                <tr>
                    <td style="border: 1px solid #000; text-align: center; font-weight: bold; font-size: 9pt; padding: 8px;">Inner label</td>
                    <td style="text-align: center;">' . $data['iprinted'] . '</td>
                    <td style="text-align: center;">' . $data['iused'] . '</td>
                    <td style="text-align: center;">' . $data['idiscard'] . '</td>
                </tr>

                <tr style="text-align:center;">
                    <td width="25%" style="font-size:12px;"><br><br>Evidence</td>
                    <td width="25%">
                        <a href="../form/upl1/' . $data['uprinted'] . '" target="_blank" style="text-decoration:none;">
                            <img src="form/upl1/' . $data['uprinted'] . '" alt="" style="height:50px; width:80px;">
                        </a>
                    </td>
                    <td width="25%">
                        <a href="../form/upl1/' . $data['uused'] . '" target="_blank" style="text-decoration:none;">
                            <img src="form/upl1/' . $data['uused'] . '" alt="" style="height:50px; width:80px;">
                        </a>
                    </td>
                    <td width="25%">
                        <a href="../form/upl1/' . $data['udiscard'] . '" target="_blank" style="text-decoration:none;">
                            <img src="form/upl1/' . $data['udiscard'] . '" alt="" style="height:50px; width:80px;">
                        </a>
                    </td>
                </tr>

                <tr style="text-align:center;">
                 <th align="center" style="font-size:12px;"><br><br>Start Label</th>
                <td> <a href="../form/upl1/' . $data['uistart'] . '" target="_blank" style="text-decoration:none;">
                            <img src="form/upl1/' . $data['uistart'] . '" alt="" style="height:50px; width:80px;" align="center">
                        </a></td>
                   <th align="center" style="font-size:12px;"><br><br>End Label</th>
                <td><a href="../form/upl1/' . $data['uiend'] . '" target="_blank" style="text-decoration:none;">
                            <img src="form/upl1/' . $data['uiend'] . '" alt="" style="height:50px; width:80px;">
                        </a></td>
                </tr>
            </table>
        </td>

<td width="10%"></td>
        <td width="30%" style="vertical-align: top;">
             <div style="text-align: center;">
                <div style="border: 1px solid #ccc; ">
                    <div style="font-size: 10px; font-weight: bold; margin-bottom: 10px;">INNER Label Image</div><br>';

if (!empty($data['iimg'])) {
    $html .= '<img src="form/upl1/' . $data['iimg'] . '" style="width: 200px; height: 90px; "><br>';
} else {
    $html .= '<div style="height: 50px; display: flex; align-items: center; justify-content: center; color: #999; font-size: 7pt; border: 1px dashed #ccc; border-radius: 3px;">No image uploaded</div>';
}
$html .= '
                </div>
            </div>
        </td>
    </tr>
</table>



<br><br>';

// OUTTER PACKAGING LABEL section
$html .= '
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size: 10pt;">
    <tr>
        <td width="60%" style="vertical-align: top;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td width="100%" class="label">Outer PACKAGING LABEL</td>
                </tr>
            </table>
            
            <table border="1" cellpadding="4" cellspacing="0" width="100%" style="font-size: 8.5pt; border-collapse: collapse; margin-top: 5px;">
                <tr>
                    <td width="25%" rowspan="2" style="border: 1px solid #000; text-align: center; vertical-align: middle; font-weight: bold; font-size: 9pt;"></td>
                    <td width="75%" colspan="3" style="border: 1px solid #000; text-align: center; font-weight: bold; border-bottom: 2px solid #000; font-size: 9pt;">Control of Label</td>
                </tr>

                <tr style="text-align:center;">
                    <td width="25%">No. of label Printed</td>
                    <td width="25%">No. of label used</td>
                    <td width="25%">No. of label discard</td>
                </tr>

                <tr>
                    <td style="border: 1px solid #000; text-align: center; font-weight: bold; font-size: 9pt; padding: 8px;">Outer label</td>
                    <td style="text-align: center;">' . $data['oprint'] . '</td>
                    <td style="text-align: center;">' . $data['oused'] . '</td>
                    <td style="text-align: center;">' . $data['odiscard'] . '</td>
                </tr>

                <tr style="text-align:center;">
                    <td width="25%" style="font-size:12px;"><br><br>Evidence</td>
                    <td width="25%">
                        <a href="../form/upl1/' . $data['uoprint'] . '" target="_blank" style="text-decoration:none;">
                            <img src="form/upl1/' . $data['uoprint'] . '" alt="" style="height:50px; width:80px;">
                        </a>
                    </td>
                    <td width="25%">
                        <a href="../form/upl1/' . $data['uoused'] . '" target="_blank" style="text-decoration:none;">
                            <img src="form/upl1/' . $data['uoused'] . '" alt="" style="height:50px; width:80px;">
                        </a>
                    </td>
                    <td width="25%">
                        <a href="../form/upl1/' . $data['uodiscard'] . '" target="_blank" style="text-decoration:none;">
                            <img src="form/upl1/' . $data['uodiscard'] . '" alt="" style="height:50px; width:80px;">
                        </a>
                    </td>
                </tr>
                <tr style="text-align:center;">
                <th align="center" style="font-size:12px;"><br><br> Start Label</th>
                <td> <a href="../form/upl1/' . $data['uostart'] . '" target="_blank" style="text-decoration:none;">
                            <img src="form/upl1/' . $data['uostart'] . '" alt="" style="height:50px; width:80px;" align="center">
                        </a></td>
                   <th align="center" style="font-size:12px;"><br><br>End Label</th>
                <td><a href="../form/upl1/' . $data['uoend'] . '" target="_blank" style="text-decoration:none;">
                            <img src="form/upl1/' . $data['uoend'] . '" alt="" style="height:50px; width:80px;">
                        </a></td>
                </tr>
            </table>

        </td>

    <td width="10%"></td>
         <td width="30%" style="vertical-align: top;">
            <div style="text-align: center;">
                <div style="border: 1px solid #ccc; ">
                    <div style="font-size: 10px; font-weight: bold; margin-bottom: 10px;">Outer Label Image</div><br>';

if (!empty($data['oimg'])) {
    $html .= '<img src="form/upl1/' . $data['oimg'] . '" style="width: 200px; height: 90px; "><br>';
} else {
    $html .= '<div style="height: 50px; display: flex; align-items: center; justify-content: center; color: #999; font-size: 7pt; border: 1px dashed #ccc; border-radius: 3px;">No image uploaded</div>';
}

$html .= '
                </div>
            </div>
        </td>
    </tr>
</table>
<br><br>';

$html .= '
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size: 10pt;">
    <tr>
        <td width="60%" style="vertical-align: top;">

            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td width="100%" class="label">Label checks  </td>
                </tr>
            </table>
            
            <table border="1" cellpadding="4" cellspacing="0" width="100%" style="font-size: 8.5pt; border-collapse: collapse; margin-top: 5px;">
                <tr>
                    <td width="25%" rowspan="2" style="border: 1px solid #000; text-align: center; vertical-align: middle; font-weight: bold; font-size: 9pt;"></td>
                    <td width="75%" colspan="4" style="border: 1px solid #000; text-align: center; font-weight: bold; border-bottom: 2px solid #000; font-size: 9pt;">Label checks at (initial all that apply)</td>
                </tr>
                <tr style="text-align:center;">
                    <td width="18.75%">Start of run</td>
                    <td width="18.75%">Mid-run</td>
                    <td width="18.75%">End of run</td>
                    <td width="18.75%">Packaging Batch change</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #000; text-align: center; font-weight: bold; font-size: 9pt; padding: 8px;">Checked by</td>
                    <td style="text-align: center;">' . $data['start'] . '</td>
                    <td style="text-align: center;">' . $data['mid'] . '</td>
                    <td style="text-align: center;">' . $data['end'] . '</td>
                    <td style="text-align: center;">' . $data['batch'] . '</td>
                </tr>

               
            </table>
        </td>
        
        
        
       
    </tr>
</table>
<br><br>';

$html .= '
<table border="1" cellpadding="0" cellspacing="0" width="75%" style="font-size: 10pt; margin-top: 10px;">
    <tr>
        <td width="40%" >
            <span class="label">Packing start time: </span>' . $data['stime'] . '<br>
        </td>
        <td width="40%">
            <span class="label">Packing end time: </span>' . $data['etime'] . '<br>
        </td>
    </tr>
</table><br><br><br>';

$html .= '
<table border="1" cellpadding="4" cellspacing="0" width="100%" style="font-size: 9pt; border-collapse: collapse; margin-top: 10px;">
    
    <tr>
        <td width="20%" style="border: 1px solid #000; text-align: center; font-weight: bold; padding: 8px;">Julien code</td>
        <td width="20%" style="border: 1px solid #000; text-align: center; font-weight: bold; padding: 8px;">Best before<br>or use by date</td>
        <td width="15%" style="border: 1px solid #000; text-align: center; font-weight: bold; padding: 8px;">Units<br>per box</td>
        <td width="20%" style="border: 1px solid #000; text-align: center; font-weight: bold; padding: 8px;">Number of units<br>packed in last box</td>
        <td width="25%" style="border: 1px solid #000; text-align: center; font-weight: bold; padding: 8px;">Comments</td>
    </tr>

    <tr>
        <td>' . $data['julien'] . '</td>
        <td>' . $data['buse'] . '</td>
        <td>' . $data['unit'] . '</td>
        <td>' . $data['pack'] . '</td>
        <td>' . $data['comments'] . '</td>
    </tr>

</table>';

// Write first page content
$pdf->writeHTML($html, true, false, true, false, '');

// Add second page for pallet details

$html = '
<style>
    .label { font-weight: bold; font-size: 10pt; }
    .cell { border: 1px solid #000; padding: 5px; }
    .center { text-align: center; }
    .left { text-align: left; }
    .small { font-size: 8pt; }
</style>';

// Pallet Details Table - Now on second page
$html .= '
<table border="1" cellpadding="4" cellspacing="0" width="100%" style="font-size: 9pt; border-collapse: collapse;">
    <tr>
        <td colspan="4" style="border: 1px solid #000; text-align: center; font-weight: bold; padding: 8px; background-color: #f0f0f0;">Pallet Details</td>
    </tr>
    <tr>
        <td width="25%" style="border: 1px solid #000; text-align: center; font-weight: bold; padding: 8px;">Pallet Serial Number</td>
        <td width="25%" style="border: 1px solid #000; text-align: center; font-weight: bold; padding: 8px;">Pallet Number</td>
        <td width="25%" style="border: 1px solid #000; text-align: center; font-weight: bold; padding: 8px;">No. Boxes on Pallet</td>
        <td width="25%" style="border: 1px solid #000; text-align: center; font-weight: bold; padding: 8px;">Start Time</td>
    </tr>';

// Add rows for each pallet entry
if ($max_entries > 0) {
    for ($i = 0; $i < $max_entries; $i++) {
        $serial = isset($palletserial_array[$i]) ? $palletserial_array[$i] : '';
        $number = isset($palletnumber_array[$i]) ? $palletnumber_array[$i] : '';
        $boxes = isset($box_array[$i]) ? $box_array[$i] : '';
        $time = isset($pstart_array[$i]) ? $pstart_array[$i] : '';

        $html .= '
    <tr>
        <td style="border: 1px solid #000; text-align: center; padding: 6px;">' . htmlspecialchars($serial) . '</td>
        <td style="border: 1px solid #000; text-align: center; padding: 6px;">' . htmlspecialchars($number) . '</td>
        <td style="border: 1px solid #000; text-align: center; padding: 6px;">' . htmlspecialchars($boxes) . '</td>
        <td style="border: 1px solid #000; text-align: center; padding: 6px;">' . htmlspecialchars($time) . '</td>
    </tr>';
    }
} else {
    // If no entries, show 5 empty rows
    for ($i = 0; $i < 5; $i++) {
        $html .= '
    <tr>
        <td style="border: 1px solid #000; text-align: center; padding: 6px; height: 25px;"></td>
        <td style="border: 1px solid #000; text-align: center; padding: 6px; height: 25px;"></td>
        <td style="border: 1px solid #000; text-align: center; padding: 6px; height: 25px;"></td>
        <td style="border: 1px solid #000; text-align: center; padding: 6px; height: 25px;"></td>
    </tr>';
    }
}

$html .= '
</table>
<br><br>';
$html .= '
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size: 9pt;">
    <tr>
        <td width="100%" style="padding-bottom: 10px;">
            Please sign here to confirm that the previous / redundant product labels and packaging have been completely removed:
        </td>
    </tr>

    <tr>
        <td>
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                
                <tr><br>
                <td width="70%"></td>
                <td><img src="form/sign/' . $data['msign'] . '.png" height="50px" width="80px"></td>

                    
                </tr>
                 
                <tr>
                <td width="70%"></td>
                <td style="font-size: 8pt; text-align: center; padding-top: 5px;" width="10%"><b>Signature:</b></td>
                </tr>
                
            </table>
        </td>
    </tr>
</table>';

// Write second page content
$pdf->writeHTML($html, true, false, true, false, '');

// Output PDF
$filename = 'product_packing_record_' . $record_id . '.pdf';
$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "finemed/upl1/" . $filename, "F");

// Display PDF in iframe
echo '<iframe src="upl1/' . $filename . '" frameborder="0" width="100%;" height="600px"></iframe>';

if ($cid == 2) {
    echo '<a href="admin.php?id=prosign&mas=' . $record_id . '" class="btn btn-warning">Verify Report</a>';
}
