<?php
include 'connection.php';

require_once('tcpdf/tcpdf.php');


$sno = $_GET['sno'];
$query = mysqli_query($con, "select * from tblnewcomplaint where id='$sno'");
$row = mysqli_fetch_array($query);
$queryr = mysqli_query($con, "select * from tblnewcomplaint1 where sno='$sno'");
$row1 = mysqli_fetch_array($queryr);

// Get current date
$currentDate = date("d/m/Y");

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
        $this->Image($this->logo1Path, 15, 25, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        // Add custom text on the right side of the logo
        $this->SetFont('century gothic', 'B', 12);
        $this->SetTextColor(0, 0, 0);
        $this->SetXY(45, 12); // Position to the right of the logo
        $this->Cell(0, 0, 'Chokdee Ltd ', 0, 1, 'R');
        $this->Cell(0, 0, 'Unit 3', 0, 1, 'R');
        $this->Cell(0, 0, 'Elland Road', 0, 1, 'R');
        $this->Cell(0, 0, 'Leicester', 0, 1, 'R');
        $this->Cell(0, 0, 'LE3 1TU', 0, 1, 'R');
        


        // Main title (centered below logo/text)
        $this->SetFont('century gothic', 'B', 22);
        $this->SetTextColor(0, 51, 102);
        $this->SetXY(12, 20);
        $this->Cell(0, 0, '', 0, 1, 'C');

        // Header line

        // $this->SetLineWidth(0.5);
        // $this->SetDrawColor(0, 102, 204);
        // $this->Line(15, 28, 280, 28);

    }

    public function Footer()
    {
        $this->SetY(-28);
        $this->SetFont('courier', '', 10);
        $this->SetTextColor(0, 0, 0);

        // Footer line
        $this->SetLineWidth(0.2);
        $this->SetDrawColor(204, 204, 204);
        $this->Line(15, $this->GetY(), 280, $this->GetY());

        // Custom footer HTML if set
        if (!empty($this->footerHTML)) {
            $this->SetY(-25);
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
$pdf = new MYPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator('RTNTS');
$pdf->SetAuthor('IT');
$pdf->SetTitle('Complaint Report');
$pdf->SetSubject('Report');
$pdf->SetKeywords('Report, Complaint');

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(15, 50, 15);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(20);
$pdf->SetAutoPageBreak(TRUE, 25);


// Add a page
$pdf->AddPage();
$pdf->SetY(60);

// Add custom text before the table
$pdf->SetFont('century gothic', '', 12);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(0, 0, 'Date: ' . date('d-m-Y'), 0, 1, 'L');
$pdf->Cell(0, 10, 'Dear Customer,', 0, 1, 'L');
$pdf->Ln(1);

// // Add date and name at the top
// $pdf->SetFont('helvetica', '', 12);
// $pdf->Cell(0, 0, 'Date: ' . $currentDate, 0, 0, 'L');
// $pdf->Cell(0, 0, 'Name: ', 0, 0, 'R');
// $pdf->Ln(10); // Add some space after the date and name



// Start HTML table
$html = '<table border="1" cellpadding="5" style=" width:100%;">';

$html .= '<tr>
   <th width="25%">Product</th>
    <th width="75%">' . $row['product'] . '</th>
</tr>
<tr>
 <th width="25%">Product Code </th>
    <th width="75%">' . $row['pcode'] . '</th>
</tr>
<tr>
 <th width="25%">Batch</th>
    <th width="75%">' . $row['batch'] . '</th>
</tr>
<tr>
 <th width="25%">UB/BB</th>
    <th width="75%">' . date('d-m-Y', strtotime($row['useby'])) . '</th>
</tr>
<tr>
 <th width="25%">Category</th>
    <th width="75%">' . $row['category'] . '</th>
</tr>
<tr>
<th width="25%">Issue</th>
    <th width="75%">' . $row['issue'] . '</th>
</tr>
<tr>
<th width="25%">Investigation detail</th>
    <th width="75%">' . $row1['rootcause'] . '</th>
</tr>
<tr>
<th width="25%">Corrective action:
</th>
    <th width="75%">' . $row1['corrective'] . '</th>
</tr>
<p style="">' . $row['content'] . '</p> ';


$html .= '</table>';

// Write HTML to PDF
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->SetY(300);
$pdf->SetFont('century gothic', 'B', 12);
$html1 = '
<br><br><br><br><br><br><table   style=" width:100%;">';

$html1 .= '<tr>
   <th width="100%">Your Sincerly,</th>
</tr>
<tr>
   <th width="100%">' . $row['person'] . '</th>
</tr>
<tr>
   <th width="100%">' . $row['desig'] . '</th>
</tr>
<tr>
   <th width="100%">On Behalf of ' . $row['behalf'] . '</th>
</tr>
';

$html1 .= '</table>';


$pdf->writeHTML($html1, true, false, true, false, '');
$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "/brcfoodsafety/upl1/cooking_record_" . ".pdf", "F");

if ($access == 'Admin') { ?>
    <div class="my-5">
        <form method="post" action="complaintperson" class="pt-3" enctype="multipart/form-data">

            <h5 style="color:#993300">Contact Person Details:</h5>
            <input type="hidden" name="srno" value="<?php echo $sno; ?>">
            Name: <input type="text" class="form-control" name="product" required />
            Designation : <input type="text" class="form-control" name="code" required />
            Designation : <input type="text" class="form-control" name="behalf" required />
            On Behalf of : <textarea class="form-control mb-2" name="content" required height="200">First of all, please accept our sincere apologies regarding the inconvenience caused due to the 
complaint. Please be assured that we have taken this complaint very seriously. We have contacted our 
supplier regarding this complaint.  <br><br>Following this complaint, we have contacted our supplier and notified them regarding this complaint. 
Our supplier has carried out thorough investigation based on the information provided to identify root 
cause.<br><br>
As per the supplier investigation report, Investigation has been carried out based on product photo as 
there is no traceability info provided. At this instance, supplier is at loss of explanation re this 
complaint. it is believed that at some point the chill chain may have been breached.<br><br>
As corrective action, supplier has informed our production operatives regarding the complaint, 
instructed staff to be extra vigilant during process. They have been told to inform any anomalies to 
production manager immediately</textarea>



            <input type="submit" class="btn btn-danger" name="submit" />

        </form>
    </div>




<?php
}
?>
<iframe src="upl1/cooking_record_.pdf" frameborder="0" width="100%" height="600px"></iframe>