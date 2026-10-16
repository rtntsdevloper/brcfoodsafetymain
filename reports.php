<?php
include '../connection.php';
require('../tcpdf/tcpdf.php');

// Get parameters
$id = isset($_GET['tid']) ? $_GET['tid'] : 0;
// Fetch supplier audit record
$main_query = mysqli_query($con, "SELECT * FROM supplier_audits WHERE submission_reference = '$id'");
$main_data = mysqli_fetch_array($main_query);
$name = $main_data['supplier_name'];
if(!$main_data){
    die("Record not found for Reference: " . htmlspecialchars($id));
}

// Get the actual audit ID
$audit_id = $main_data['id'];
// Fetch uploaded files from tblfiles using audit_id
$files_query = mysqli_query($con, "SELECT * FROM tblfiles WHERE audit_id = '$audit_id'");
$files_data = mysqli_fetch_array($files_query);

class MYPDF extends TCPDF
{

    private $logo1Path = '../images/logo1.png';
    private $logo2Path = '../images/rtnts.png';
    private $footerHTML = '';

    public function Header()
    {

        $this->SetFillColor(250, 250, 250);
        $this->Rect(0, 0, $this->getPageWidth(), 30, 'F');
        
        if(file_exists($this->logo1Path)) {
            $this->Image($this->logo1Path, 15, 5, 25, 15, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }

        if(file_exists($this->logo2Path)) {
            $this->Image($this->logo2Path, 170, 5, 25, 15, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }

        $this->SetFont('helvetica', 'B', 14);
        $this->SetTextColor(0, 0, 0);
        $this->SetXY(12, 12);
        $this->Cell(0, 0, 'SUPPLIER SELF AUDIT QUESTIONNAIRE REPORT', 0, 1, 'C');

        $this->SetLineWidth(0.3);
        $this->SetDrawColor(0, 0, 0);
        $this->Line(15, 28, 195, 28);
    }

    public function Footer()
    {

        $this->SetY(-22);
        $this->SetLineWidth(0.2);
        $this->SetDrawColor(200, 200, 200);
        $this->Line(15, $this->GetY(), 285, $this->GetY());
        
        if (!empty($this->footerHTML)) {
            $this->SetY(-20);
            $this->writeHTML($this->footerHTML, true, false, true, false, '');
        }
    }
    
    public function setFooterHTML($html)
    {
        $this->footerHTML = $html;
    }
}

// Create new PDF document
$pdf = new MYPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);

// Set document information
$pdf->SetCreator('Quality Department');
$pdf->SetAuthor('Supplier Audit System');
$pdf->SetTitle('');
$pdf->SetSubject('Supplier Audit Report');
$pdf->SetKeywords('supplier, audit, questionnaire, report');


// Set margins
$pdf->SetMargins(15, 32, 15);
$pdf->SetHeaderMargin(8);
$pdf->SetFooterMargin(15);
$pdf->SetAutoPageBreak(TRUE, 25);
$pdf->setCellHeightRatio(1.5);

// Add page
$pdf->AddPage();

// Helper function for safe text
function safeText($text) {
    if(!isset($text) || $text == '') {
        return 'Not provided';
    }

    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function formatDate($date) {
    if(empty($date) || $date == '0000-00-00' || $date == '0000-00-00 00:00:00' || $date == '1970-01-01') {
        return 'Not provided';
    }
    return date('d-m-Y', strtotime($date));
}

function getFileLink($file_value, $file_name = '') {
    if(empty($file_value)) {
        return '<span style="color: red;">Not Uploaded</span>';
    }
    $display_name = !empty($file_name) ? $file_name : $file_value;
    return '<a href="../uploads/' . $file_value . '" target="_blank" style="color: blue; text-decoration: underline;">' . $display_name . '</a>';
}

function getMultipleFileLinks($file_value) {
    if(empty($file_value)) {
        return '<span style="color: red;">Not Uploaded</span>';
    }
    // Check if it's comma separated (not JSON)
    if(strpos($file_value, ',') !== false && strpos($file_value, '[') === false) {
        $files_array = explode(',', $file_value);
        $links = '';
        foreach($files_array as $file) {
            $file = trim($file);
            if(!empty($file)) {
                $links .= '<a href="../uploads/' . $file . '" target="_blank" style="color: blue; text-decoration: underline; display: block;">' . $file . '</a>';
            }
        }
        return !empty($links) ? $links : '<span style="color: red;">Not Uploaded</span>';
    }
    // Try JSON decode
    $files_array = json_decode($file_value, true);
    if(!is_array($files_array) || empty($files_array)) {
        // If not JSON, treat as single file
        return getFileLink($file_value);
    }

    $links = '';
    foreach($files_array as $file) {
        $links .= '<a href="../uploads/' . $file . '" target="_blank" style="color: blue; text-decoration: underline; display: block;">' . $file . '</a>';
    }
    return $links;
}

// Determine GFSI status
$isGFSIYes = ($main_data['gfsi_accredited'] == 'Yes');
$isGFSINo = ($main_data['gfsi_accredited'] == 'No');

// Function to show NA or actual data
function showNAorData($condition, $data, $isGFSIYes) {
    if($isGFSIYes && $condition == 'NA') {
        return '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>';
    }
    return $data;
}

// ========== HEADER INFORMATION ==========
$html_header = '<table border="0" cellpadding="4" cellspacing="0" style="width: 100%; margin-bottom: 10px;">
    <tr style="background-color: #d9e4f5;">
        <td width="50%"><strong>Submission Reference:</strong> ' . safeText($main_data['submission_reference']) . '</td>
        <td width="50%"><strong>Submission Date:</strong> ' . formatDate($main_data['submission_date']) . '</td>
    </tr>
</table>';
$pdf->writeHTML($html_header, true, false, true, false, '');
$pdf->Ln(5);

// ========== SECTION 1: SUPPLIER DETAILS ==========
$html1 = '<h3>1. SUPPLIER DETAILS</h3>';
$html1 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';

$html1 .= '<tr style="background-color: #d9e4f5;">
              <td width="30%"><strong>Supplier Name</strong></td>
              <td width="70%">' . safeText($main_data['supplier_name']) . ' </td>
            </tr>';

$html1 .= '<tr style="background-color: #ffffff;">
              <td><strong>Supplier Address</strong></td>
              <td>' . nl2br(safeText($main_data['supplier_address'])) . ' </td>
            </tr>';

$html1 .= '<tr style="background-color: #d9e4f5;">
              <td><strong>Technical Contact</strong></td>
              <td>' . safeText($main_data['tech_contact']) . ' </td>
            </tr>';

$html1 .= '<tr style="background-color: #ffffff;">
              <td><strong>Production Site Address</strong></td>
              <td>' . nl2br(safeText($main_data['prod_site_address'])) . ' </td>
            </tr>';

$html1 .= '<tr style="background-color: #d9e4f5;">
              <td><strong>Telephone No</strong></td>
              <td>' . safeText($main_data['phone']) . ' </td>
            </tr>';

$html1 .= '<tr style="background-color: #ffffff;">
              <td><strong>Fax No</strong></td>
              <td>' . safeText($main_data['fax']) . ' </td>
            </tr>';

$html1 .= '<tr style="background-color: #d9e4f5;">
              <td><strong>Email Address</strong></td>
              <td>' . safeText($main_data['email']) . ' </td>
            </tr>';

$html1 .= '<tr style="background-color: #ffffff;">
              <td><strong>Type of Supplier</strong></td>
              <td>' . ucfirst(safeText($main_data['supplier_type'])) . ' </td>
            </tr>';

$html1 .= '<tr style="background-color: #d9e4f5;">
              <td><strong>Products Supplied</strong></td>
              <td>' . safeText($main_data['products']) . ' </td>
            </tr>';

$html1 .= '<tr style="background-color: #ffffff;">
              <td><strong>Health Mark on goods supplied</strong></td>
              <td>' . safeText($main_data['health_mark']) . ' </td>
            </tr>';

$html1 .= '</table>';

$pdf->writeHTML($html1, true, false, true, false, '');
$pdf->Ln(5);

// ========== MAIN CONTACTS ==========
$html_contacts = '<h4>MAIN CONTACTS</h4>';
$html_contacts .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
$html_contacts .= '<tr style="background-color: #d9e4f5; font-weight: bold;">
    <th width="25%">Position</th>
    <th width="25%">Name</th>
    <th width="25%">Telephone</th>
    <th width="25%">Email</th>
</tr>';

$html_contacts .= '<tr style="background-color: #ffffff;">
    <td><strong>Managing Director</strong></td>
    <td>' . safeText($main_data['md_name']) . '</td>
    <td>' . safeText($main_data['md_tel']) . '</td>
    <td>' . safeText($main_data['md_email']) . '</td>
</tr>';

$html_contacts .= '<tr style="background-color: #f9f9f9;">
    <td><strong>Technical</strong></td>
    <td>' . safeText($main_data['tech_name']) . '</td>
    <td>' . safeText($main_data['tech_tel']) . '</td>
    <td>' . safeText($main_data['tech_email']) . '</td>
</tr>';

$html_contacts .= '<tr style="background-color: #ffffff;">
    <td><strong>Production</strong></td>
    <td>' . safeText($main_data['prod_name']) . '</td>
    <td>' . safeText($main_data['prod_tel']) . '</td>
    <td>' . safeText($main_data['prod_email']) . '</td>
</tr>';

$html_contacts .= '<tr style="background-color: #f9f9f9;">
    <td><strong>Sales</strong></td>
    <td>' . safeText($main_data['sales_name']) . '</td>
    <td>' . safeText($main_data['sales_tel']) . '</td>
    <td>' . safeText($main_data['sales_email']) . '</td>
</tr>';

$html_contacts .= '</table>';

$pdf->writeHTML($html_contacts, true, false, true, false, '');
$pdf->Ln(5);

// ========== SECTION 2: QUALITY SYSTEMS & SITE SECURITY ==========
$html2 = '<h3>2. QUALITY SYSTEMS & SITE SECURITY</h3>';
$html2 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';

$html2 .= '<tr style="background-color: #d9e4f5;">
              <td width="50%"><strong>GFSI Accredited?</strong></td>
              <td width="50%">' . ($isGFSIYes ? 'Yes' : 'No') . '</td>
            </tr>';

if($isGFSIYes){
    $html2 .= '<tr style="background-color: #ffffff;">
                   <td><strong>Most recent audit date</strong></td>
                   <td>' . formatDate($main_data['gfsi_audit_date']) . '</td>
                </tr>';
    $html2 .= '<tr style="background-color: #f9f9f9;">
                   <td><strong>Expiry date</strong></td>
                   <td>' . formatDate($main_data['gfsi_expiry']) . '</td>
                </tr>';
    $html2 .= '<tr style="background-color: #ffffff;">
                   <td><strong>Accredited Certifying Agency</strong></td>
                   <td>' . safeText($main_data['gfsi_agency']) . '</td>
                </tr>';

    $gfsi_cert_link = !empty($files_data['gfsi_certificate']) ? getFileLink($files_data['gfsi_certificate']) : '<span style="color: red;">Not Uploaded</span>';
    $html2 .= '<tr style="background-color: #f9f9f9;">
                   <td><strong>GFSI Certificate</strong></td>
                   <td>' . $gfsi_cert_link . '</td>
                </tr>';
    
    $gfsi_report_link = !empty($files_data['gfsi_audit_report']) ? getFileLink($files_data['gfsi_audit_report']) : '<span style="color: red;">Not Uploaded</span>';
    $html2 .= '<tr style="background-color: #ffffff;">
                   <td><strong>GFSI Audit Report</strong></td>
                   <td>' . $gfsi_report_link . '</td>
                </tr>';
    
    // For GFSI Yes, show NA for sections that would normally be filled
    $html2 .= '<tr style="background-color: #f9f9f9;">
                   <td><strong>Traceability Records (For Non-GFSI)</strong></td>
                   <td><span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span></td>
                </tr>';
    $html2 .= '<tr style="background-color: #ffffff;">
                   <td><strong>Site Security Risk Assessment</strong></td>
                   <td><span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span></td>
                </tr>';
} else {
    $html2 .= '<tr style="background-color: #f9f9f9;">
                   <td><strong>Traceability Records</strong></td>
                   <td>' . nl2br(safeText($main_data['traceability_records'])) . '</td>
                </tr>';

    $trace_link = !empty($files_data['traceability_records_file']) ? getFileLink($files_data['traceability_records_file']) : '<span style="color: red;">Not Uploaded</span>';
    $html2 .= '<tr style="background-color: #ffffff;">
                   <td><strong>Traceability Records File</strong></td>
                   <td>' . $trace_link . '</td>
                </tr>';

    $html2 .= '<tr style="background-color: #ffffff;">
                   <td><strong>Site Security Risk Assessment?</strong></td>
                   <td>' . ($main_data['security_risk'] == 'Yes' ? 'Yes' : 'No') . '</td>
                </tr>';
    $html2 .= '<tr style="background-color: #f9f9f9;">
                   <td><strong>Written Quality Policy Statement?</strong></td>
                   <td>' . ($main_data['quality_policy'] == 'Yes' ? 'Yes' : 'No') . '</td>
                </tr>';
    $html2 .= '<tr style="background-color: #ffffff;">
                   <td><strong>Written Quality Manual?</strong></td>
                   <td>' . ($main_data['quality_manual'] == 'Yes' ? 'Yes' : 'No') . '</td>
                </tr>';
    $html2 .= '<tr style="background-color: #f9f9f9;">
                   <td><strong>HACCP System in place?</strong></td>
                   <td>' . ($main_data['haccp_operational'] == 'Yes' ? 'Yes' : 'No') . '</td>
                </tr>';
    $html2 .= '<tr style="background-color: #ffffff;">
                   <td><strong>HACCP Team & Qualifications</strong></td>
                   <td>' . nl2br(safeText($main_data['haccp_team'])) . '</td>
                </tr>';
    $html2 .= '<tr style="background-color: #f9f9f9;">
                   <td><strong>Pre-requisite Programme?</strong></td>
                   <td>' . ($main_data['haccp_prp'] == 'Yes' ? 'Yes' : 'No') . '</td>
                </tr>';
    $html2 .= '<tr style="background-color: #ffffff;">
                   <td><strong>CCP Validation Frequency</strong></td>
                   <td>' . safeText($main_data['ccp_validation_freq']) . '</td>
                </tr>';
    $html2 .= '<tr style="background-color: #f9f9f9;">
                   <td><strong>HACCP applied to product development?</strong></td>
                   <td>' . ($main_data['haccp_dev'] == 'Yes' ? 'Yes' : 'No') . '</td>
                </tr>';
    $html2 .= '<tr style="background-color: #ffffff;">
                   <td><strong>HACCP scope covers all process steps?</strong></td>
                   <td>' . ($main_data['haccp_scope'] == 'Yes' ? 'Yes' : 'No') . '</td>
                </tr>';
    $html2 .= '<tr style="background-color: #f9f9f9;">
                   <td><strong>Covers delivery & vehicle checks?</strong></td>
                   <td>' . ($main_data['haccp_vehicle'] == 'Yes' ? 'Yes' : 'No') . '</td>
                </tr>';

    $haccp_flow_link = !empty($files_data['haccp_flow_diagram']) ? getFileLink($files_data['haccp_flow_diagram']) : '<span style="color: red;">Not Uploaded</span>';
    $html2 .= '<tr style="background-color: #ffffff;">
                   <td><strong>HACCP Process Flow Diagram</strong></td>
                   <td>' . $haccp_flow_link . '</td>
                </tr>';
    
    $ccp_summary_link = !empty($files_data['ccp_summary']) ? getFileLink($files_data['ccp_summary']) : '<span style="color: red;">Not Uploaded</span>';
    $html2 .= '<tr style="background-color: #f9f9f9;">
                   <td><strong>CCP Summary</strong></td>
                   <td>' . $ccp_summary_link . '</td>
                </tr>';

    $fsa_link = !empty($files_data['fsa_audit_report']) ? getFileLink($files_data['fsa_audit_report']) : '<span style="color: red;">Not Uploaded</span>';
    $html2 .= '<tr style="background-color: #ffffff;">
                   <td><strong>FSA Audit Report</strong></td>
                   <td>' . $fsa_link . '</td>
                </tr>';
}

$html2 .= '</table>';
$pdf->writeHTML($html2, true, false, true, false, '');
$pdf->Ln(5);

// ========== SECTION 3: INTERNAL AUDITS ==========
$html3 = '<h3>3. INTERNAL AUDITS</h3>';
$html3 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
$html3 .= '<tr style="background-color: #d9e4f5;">
              <td width="30%"><strong>Internal Auditing Procedure</strong></td>
              <td width="70%">' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : nl2br(safeText($main_data['internal_audit_procedure']))) . '</td>
            </tr>';
$html3 .= '<tr style="background-color: #ffffff;">
               <td><strong>Auditors & Training</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : nl2br(safeText($main_data['auditors_training']))) . '</td>
            </tr>';
$html3 .= '<tr style="background-color: #f9f9f9;">
               <td><strong>Audit Frequency</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : safeText($main_data['audit_frequency'])) . '</td>
            </tr>';
$html3 .= '<tr style="background-color: #ffffff;">
               <td><strong>Non-compliance Review Frequency</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : safeText($main_data['nc_review_frequency'])) . '</td>
            </tr>';
$html3 .= '</table>';
$pdf->writeHTML($html3, true, false, true, false, '');
$pdf->Ln(5);

// ========== SECTION 4: FINISHED PRODUCT TESTING ==========
$html4 = '<h3>4. FINISHED PRODUCT TESTING</h3>';
$html4 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
$html4 .= '<tr style="background-color: #d9e4f5;">
              <td width="50%"><strong>Product Specification available?</strong></td>
              <td width="50%">' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['product_spec'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html4 .= '<tr style="background-color: #ffffff;">
               <td><strong>Positive Release System?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['positive_release'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html4 .= '<tr style="background-color: #f9f9f9;">
               <td><strong>How is this achieved?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : nl2br(safeText($main_data['release_method']))) . '</td>
            </tr>';
$html4 .= '<tr style="background-color: #ffffff;">
               <td><strong>Certificate of Conformance?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['coc'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html4 .= '<tr style="background-color: #f9f9f9;">
               <td><strong>In-house Accredited Laboratory?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['inhouse_lab'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html4 .= '<tr style="background-color: #ffffff;">
               <td><strong>In-house Lab Details</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : nl2br(safeText($main_data['inhouse_lab_details']))) . '</td>
            </tr>';
$html4 .= '<tr style="background-color: #f9f9f9;">
               <td><strong>External Laboratory Used?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['external_lab'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html4 .= '<tr style="background-color: #ffffff;">
               <td><strong>External Lab Details</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : nl2br(safeText($main_data['external_lab_details']))) . '</td>
            </tr>';
$html4 .= '</table>';
$pdf->writeHTML($html4, true, false, true, false, '');
$pdf->Ln(5);

// ========== SECTION 5: ALLERGENS ==========
$html5 = '<h3>5. ALLERGENS</h3><hr />';
$html5 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
$html5 .= '<tr style="background-color: #d9e4f5;">
              <td width="50%"><strong>Allergens on site</strong></td>
              <td width="50%">' . nl2br(safeText($main_data['allergens_list'])) . '</td>
            </tr>';
$html5 .= '<tr style="background-color: #ffffff;">
               <td><strong>Allergen Risk Assessment?</strong></td>
               <td>' . ($main_data['allergen_risk'] == 'Yes' ? 'Yes' : 'No') . '</td>
            </tr>';
$html5 .= '<tr style="background-color: #f9f9f9;">
               <td><strong>Controls in place?</strong></td>
               <td>' . ($main_data['allergen_controls'] == 'Yes' ? 'Yes' : 'No') . '</td>
            </tr>';
$html5 .= '<tr style="background-color: #ffffff;">
               <td><strong>Cross Contamination Controls?</strong></td>
               <td>' . ($main_data['allergen_cross'] == 'Yes' ? 'Yes' : 'No') . '</td>
            </tr>';
$html5 .= '<tr style="background-color: #f9f9f9;">
               <td><strong>Segregation in Storage?</strong></td>
               <td>' . ($main_data['allergen_storage'] == 'Yes' ? 'Yes' : 'No') . '</td>
            </tr>';
$html5 .= '<tr style="background-color: #ffffff;">
               <td><strong>Cleaning System Validated?</strong></td>
               <td>' . ($main_data['allergen_clean_val'] == 'Yes' ? 'Yes' : 'No') . '</td>
            </tr>';
$html5 .= '<tr style="background-color: #f9f9f9;">
               <td><strong>Allergen Validation (ELISA)?</strong></td>
               <td>' . ($main_data['allergen_elisa'] == 'Yes' ? 'Yes' : 'No') . '</td>
            </tr>';
$html5 .= '</table>';
$pdf->writeHTML($html5, true, false, true, false, '');
$pdf->Ln(5);

// ========== SECTION 6: FABRICATION ==========
$html6 = '<h3>6. FABRICATION (Premises & Equipment)</h3>';
$html6 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
$html6 .= '<tr style="background-color: #d9e4f5;">
              <td width="50%"><strong>Premises comply with legislation?</strong></td>
              <td width="50%">' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['fab_compliance'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html6 .= '<tr style="background-color: #ffffff;">
               <td><strong>Loading/Unloading areas covered?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['fab_loading'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html6 .= '<tr style="background-color: #f9f9f9;">
               <td><strong>Drains clean & odour-free?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['fab_drains'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html6 .= '<tr style="background-color: #ffffff;">
               <td><strong>Floors & walls in good condition?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['fab_floors'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html6 .= '<tr style="background-color: #f9f9f9;">
               <td><strong>Windows & doors screened?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['fab_windows'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html6 .= '<tr style="background-color: #ffffff;">
               <td><strong>Lights protected against breakage?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['fab_lights'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html6 .= '<tr style="background-color: #f9f9f9;">
               <td><strong>Light lumens checks conducted?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['fab_lumens'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
    
$lumens_link = !empty($files_data['light_lumens_checks']) ? getFileLink($files_data['light_lumens_checks']) : '<span style="color: red;">Not Uploaded</span>';
$html6 .= '<tr style="background-color: #ffffff;">
               <td><strong>Light Lumens Checks Document</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : $lumens_link) . '</td>
            </tr>';
    
$html6 .= '<tr style="background-color: #f9f9f9;">
               <td><strong>Steam/dust/odours extracted?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['fab_extraction'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html6 .= '<tr style="background-color: #ffffff;">
               <td><strong>Source of water in production</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : safeText($main_data['fab_water_source'])) . '</td>
            </tr>';
$html6 .= '<tr style="background-color: #f9f9f9;">
               <td><strong>Water supply treated?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['fab_water_treated'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html6 .= '<tr style="background-color: #ffffff;">
               <td><strong>Water testing frequency</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : safeText($main_data['fab_water_micro_freq'])) . '</td>
            </tr>';
$html6 .= '<tr style="background-color: #f9f9f9;">
               <td><strong>Chemicals in lockable location?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['fab_chemicals'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html6 .= '</table>';
$pdf->writeHTML($html6, true, false, true, false, '');
$pdf->Ln(5);

// ========== SECTION 7: FOREIGN BODY CONTROL ==========
$html7 = '<h3>7. FOREIGN BODY CONTROL</h3>';
$html7 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
$html7 .= '<tr style="background-color: #d9e4f5;">
              <td width="50%"><strong>Glass permitted on-site?</strong></td>
              <td width="50%">' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['fbc_glass'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html7 .= '<tr style="background-color: #ffffff;">
               <td><strong>Glass/Brittle plastic register?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['fbc_register'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html7 .= '<tr style="background-color: #f9f9f9;">
               <td><strong>Glass breakage procedure?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['fbc_breakage'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html7 .= '<tr style="background-color: #ffffff;">
               <td><strong>Metal detection in place?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['fbc_metal'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html7 .= '<tr style="background-color: #f9f9f9;">
               <td><strong>Type of Metal detector</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : safeText($main_data['fbc_detector_type'])) . '</td>
            </tr>';
$html7 .= '<tr style="background-color: #ffffff;">
               <td><strong>Detector testing frequency</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : nl2br(safeText($main_data['fbc_detector_test']))) . '</td>
            </tr>';
$html7 .= '<tr style="background-color: #f9f9f9;">
               <td><strong>Product filtering details</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : nl2br(safeText($main_data['fbc_filtering']))) . '</td>
            </tr>';
$html7 .= '<tr style="background-color: #ffffff;">
               <td><strong>Wood allowed in production?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['fbc_wood'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html7 .= '<tr style="background-color: #f9f9f9;">
               <td><strong>Jewellery allowed?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : safeText($main_data['fbc_jewellery'])) . '</td>
            </tr>';
$html7 .= '</table>';
$pdf->writeHTML($html7, true, false, true, false, '');
$pdf->Ln(5);

// ========== SECTION 8: PEST CONTROL ==========
$html8 = '<h3>8. PEST CONTROL</h3>';
$html8 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
$html8 .= '<tr style="background-color: #d9e4f5;">
              <td width="50%"><strong>Contractor Name</strong></td>
              <td width="50%">' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : safeText($main_data['pc_contractor'])) . '</td>
            </tr>';
$html8 .= '<tr style="background-color: #ffffff;">
               <td><strong>Routine visits/year</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : safeText($main_data['pc_routine'])) . '</td>
            </tr>';
$html8 .= '<tr style="background-color: #f9f9f9;">
               <td><strong>Other visits/year</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : safeText($main_data['pc_other'])) . '</td>
            </tr>';
$html8 .= '<tr style="background-color: #ffffff;">
               <td><strong>Part of BPCA?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['pc_bpca'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html8 .= '<tr style="background-color: #f9f9f9;">
               <td><strong>Registration Number</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : safeText($main_data['pc_reg_no'])) . '</td>
            </tr>';
$html8 .= '<tr style="background-color: #ffffff;">
               <td><strong>Electric fly killers?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['pc_efk'] == 'Yes' ? 'Yes (' . safeText($main_data['pc_efk_qty']) . ' units)' : 'No')) . '</td>
            </tr>';
$html8 .= '<tr style="background-color: #f9f9f9;">
               <td><strong>Pheromone traps?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['pc_pheromone'] == 'Yes' ? 'Yes (' . safeText($main_data['pc_pheromone_qty']) . ' units)' : 'No')) . '</td>
            </tr>';
$html8 .= '</table>';
$pdf->writeHTML($html8, true, false, true, false, '');
$pdf->Ln(5);

// ========== SECTION 9: STORAGE & TRANSPORTATION ==========
$html9 = '<h3>9. STORAGE & TRANSPORTATION</h3>';
$html9 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
$html9 .= '<tr style="background-color: #d9e4f5;">
              <td width="30%"><strong>Storage arrangements</strong></td>
              <td width="70%">' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : nl2br(safeText($main_data['storage_details']))) . '</td>
            </tr>';
$html9 .= '<tr style="background-color: #ffffff;">
               <td><strong>Cold/Chill stores details</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : nl2br(safeText($main_data['cold_store_details']))) . '</td>
            </tr>';
$html9 .= '<tr style="background-color: #f9f9f9;">
               <td><strong>Third party storage approval</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : nl2br(safeText($main_data['3rd_party_storage']))) . '</td>
            </tr>';
$html9 .= '<tr style="background-color: #ffffff;">
               <td><strong>Refrigerated vehicles suitable?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['refrig_vehicles'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html9 .= '</table>';
$pdf->writeHTML($html9, true, false, true, false, '');
$pdf->Ln(5);

// ========== SECTION 10: PACKAGING ==========
$html10 = '<h3>10. PACKAGING</h3>';
$html10 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
$html10 .= '<tr style="background-color: #d9e4f5;">
              <td width="50%"><strong>Packaging complies with legislation?</strong></td>
              <td width="50%">' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['pack_compliance'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html10 .= '</table>';
$pdf->writeHTML($html10, true, false, true, false, '');
$pdf->Ln(5);

// ========== SECTION 11: WASTE DISPOSAL ==========
$html11 = '<h3>11. WASTE DISPOSAL</h3>';
$html11 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
$html11 .= '<tr style="background-color: #d9e4f5;">
              <td width="50%"><strong>Waste segregation adequate?</strong></td>
              <td width="50%">' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['waste_seg'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html11 .= '<tr style="background-color: #ffffff;">
               <td><strong>External containers closed/covered?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['waste_closed'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html11 .= '<tr style="background-color: #f9f9f9;">
               <td><strong>Registered contractor for waste?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['waste_contractor'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html11 .= '</table>';
$pdf->writeHTML($html11, true, false, true, false, '');
$pdf->Ln(5);

// ========== SECTION 12: MAINTENANCE ==========
$html12 = '<h3>12. MAINTENANCE</h3>';
$html12 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
$html12 .= '<tr style="background-color: #d9e4f5;">
              <td width="50%"><strong>Planned maintenance system?</strong></td>
              <td width="50%">' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['maint_planned'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html12 .= '<tr style="background-color: #ffffff;">
               <td><strong>Maintenance documented?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['maint_docs'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html12 .= '<tr style="background-color: #f9f9f9;">
               <td><strong>Parts accounting system?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['maint_parts'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html12 .= '<tr style="background-color: #ffffff;">
               <td><strong>Air filtration for high-risk?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['maint_air_filter'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html12 .= '<tr style="background-color: #f9f9f9;">
               <td><strong>Filter changing procedure?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['maint_filter_proc'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html12 .= '<tr style="background-color: #ffffff;">
               <td><strong>Air/steam contacts food?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['maint_air_contact'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html12 .= '<tr style="background-color: #f9f9f9;">
               <td><strong>Suitable for direct contact?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['maint_air_suitable'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html12 .= '<tr style="background-color: #ffffff;">
               <td><strong>Food grade lubricants used?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['maint_lubricants'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html12 .= '<tr style="background-color: #f9f9f9;">
               <td><strong>Risk assessed for lubricants?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['maint_lube_ra'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html12 .= '</table>';
$pdf->writeHTML($html12, true, false, true, false, '');
$pdf->Ln(5);

// ========== SECTION 13: PERSONAL HYGIENE ==========
$html13 = '<h3>13. PERSONAL HYGIENE</h3>';
$html13 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
$html13 .= '<tr style="background-color: #d9e4f5;">
              <td width="30%"><strong>Protective clothing</strong></td>
              <td width="70%">' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : nl2br(safeText($main_data['hyg_clothing']))) . '</td>
            </tr>';
$html13 .= '<tr style="background-color: #ffffff;">
               <td><strong>Overalls changing/laundering</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : safeText($main_data['hyg_overalls'])) . '</td>
            </tr>';
$html13 .= '<tr style="background-color: #f9f9f9;">
               <td><strong>Smoking permitted?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['hyg_smoking'] == 'Yes' ? 'Yes (' . safeText($main_data['hyg_smoke_areas']) . ')' : 'No')) . '</td>
            </tr>';
$html13 .= '<tr style="background-color: #ffffff;">
               <td><strong>Medical screening policy</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : nl2br(safeText($main_data['hyg_medical']))) . '</td>
            </tr>';
$html13 .= '<tr style="background-color: #f9f9f9;">
               <td><strong>Illness exclusion policy?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['hyg_illness'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html13 .= '<tr style="background-color: #ffffff;">
               <td><strong>Eating/drinking banned?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['hyg_food_drink'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html13 .= '<tr style="background-color: #f9f9f9;">
               <td><strong>Adequate toilets?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['hyg_toilets'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html13 .= '<tr style="background-color: #ffffff;">
               <td><strong>Adequate handwashing facilities?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['hyg_handwash'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html13 .= '<tr style="background-color: #f9f9f9;">
               <td><strong>Anti-bacterial soap used?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['hyg_soap'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html13 .= '<tr style="background-color: #ffffff;">
               <td><strong>Adequate hand drying?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['hyg_dryer'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html13 .= '<tr style="background-color: #f9f9f9;">
               <td><strong>Lidded waste bins?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['hyg_bins'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html13 .= '</table>';
$pdf->writeHTML($html13, true, false, true, false, '');
$pdf->Ln(5);

// ========== SECTION 14: TRAINING ==========
$html14 = '<h3>14. TRAINING</h3>';
$html14 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
$html14 .= '<tr style="background-color: #d9e4f5;">
              <td width="30%"><strong>Staff trained to SOPs?</strong></td>
              <td width="70%">' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['train_sop'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html14 .= '<tr style="background-color: #ffffff;">
               <td><strong>Food hygiene training</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : nl2br(safeText($main_data['train_hygiene']))) . '</td>
            </tr>';
$html14 .= '<tr style="background-color: #f9f9f9;">
               <td><strong>Training records kept?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : nl2br(safeText($main_data['train_record']))) . '</td>
            </tr>';
$html14 .= '</td>';
$pdf->writeHTML($html14, true, false, true, false, '');
$pdf->Ln(5);

// ========== SECTION 15: CLEANING HYGIENE PROCEDURES ==========
$html15 = '<h3>15. CLEANING HYGIENE PROCEDURES</h3>';
$html15 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
$html15 .= '<tr style="background-color: #d9e4f5;">
              <td width="30%"><strong>Formal cleaning schedules?</strong></td>
              <td width="70%">' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['clean_schedules'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html15 .= '<tr style="background-color: #ffffff;">
               <td><strong>Cleaning effectiveness monitoring</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : nl2br(safeText($main_data['clean_monitor']))) . '</td>
            </tr>';
$html15 .= '<tr style="background-color: #f9f9f9;">
               <td><strong>Environmental swabbing?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['clean_swab'] == 'Yes' ? 'Yes (Frequency: ' . safeText($main_data['clean_swab_freq']) . ')' : 'No')) . '</td>
            </tr>';
$html15 .= '<tr style="background-color: #ffffff;">
               <td><strong>Corrective action documentation</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : nl2br(safeText($main_data['clean_ca_docs']))) . '</td>
            </tr>';
$html15 .= '</table>';
$pdf->writeHTML($html15, true, false, true, false, '');
$pdf->Ln(5);

// ========== SECTION 16: NON-CONFORMING PRODUCT ==========
$html16 = '<h3>16. NON-CONFORMING PRODUCT</h3>';
$html16 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
$html16 .= '<tr style="background-color: #d9e4f5;">
              <td width="30%"><strong>Procedure for non-conforming product</strong></td>
              <td width="70%">' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : nl2br(safeText($main_data['nc_procedure']))) . '</td>
            </tr>';
$html16 .= '</table>';
$pdf->writeHTML($html16, true, false, true, false, '');
$pdf->Ln(5);

// ========== SECTION 17: CALIBRATION ==========
$html17 = '<h3>17. CALIBRATION</h3>';
$html17 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
$html17 .= '<tr style="background-color: #d9e4f5;">
              <td width="50%"><strong>Calibration schedule?</strong></td>
              <td width="50%">' . ($isGFSIYes 
                  ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' 
                  : ($main_data['cal_schedule'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html17 .= '<tr style="background-color: #ffffff;">
               <td><strong>Equipment labelled with calibration status?</strong></td>
               <td>' . ($isGFSIYes 
                   ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' 
                   : ($main_data['cal_labels'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html17 .= '</table>';  // <-- fixed closing tag
$pdf->writeHTML($html17, true, false, true, false, '');

$pdf->Ln(5);

// ========== SECTION 18: SUPPLIERS ==========
$html18 = '<h3>18. SUPPLIERS</h3>';
$html18 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
$html18 .= '<tr style="background-color: #d9e4f5;">
              <td width="30%"><strong>Supplier assessment method</strong></td>
              <td width="70%">' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : nl2br(safeText($main_data['sup_assessment']))) . '</td>
            </tr>';
$html18 .= '<tr style="background-color: #ffffff;">
               <td><strong>Specifications held for all?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['sup_specs'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html18 .= '</table>';
$pdf->writeHTML($html18, true, false, true, false, '');
$pdf->Ln(5);

// ========== SECTION 19: CUSTOMER COMPLAINTS ==========
$html19 = '<h3>19. CUSTOMER COMPLAINTS</h3>';
$html19 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
$html19 .= '<tr style="background-color: #d9e4f5;">
              <td width="30%"><strong>Complaint handling procedure</strong></td>
              <td width="70%">' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : nl2br(safeText($main_data['comp_procedures']))) . '</td>
            </tr>';
$html19 .= '</table>';
$pdf->writeHTML($html19, true, false, true, false, '');
$pdf->Ln(5);

// ========== SECTION 20: TRACEABILITY AND PRODUCT RECALL ==========
$html20 = '<h3>20. TRACEABILITY AND PRODUCT RECALL</h3>';
$html20 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
$html20 .= '<tr style="background-color: #d9e4f5;">
              <td width="30%"><strong>Traceability & Recall system</strong></td>
              <td width="70%">' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : nl2br(safeText($main_data['trace_recall_sys']))) . '</td>
            </tr>';

$supplier_contact_link = !empty($files_data['supplier_contact_list']) ? getFileLink($files_data['supplier_contact_list']) : '<span style="color: red;">Not Uploaded</span>';
$html20 .= '<tr style="background-color: #f9f9f9;">
               <td><strong>Supplier Contact List</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : $supplier_contact_link) . '</td>
            </tr>';

$customer_contact_link = !empty($files_data['customer_contact_list']) ? getFileLink($files_data['customer_contact_list']) : '<span style="color: red;">Not Uploaded</span>';
$html20 .= '<tr style="background-color: #ffffff;">
               <td><strong>Customer Contact List</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : $customer_contact_link) . '</td>
            </tr>';

$emergency_contact_link = !empty($files_data['emergency_contact_list']) ? getFileLink($files_data['emergency_contact_list']) : '<span style="color: red;">Not Uploaded</span>';
$html20 .= '<tr style="background-color: #f9f9f9;">
               <td><strong>Emergency Contact List</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : $emergency_contact_link) . '</td>
            </tr>';

$html20 .= '<tr style="background-color: #ffffff;">
               <td><strong>Supplier contact list available?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['tr_supplier_list'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html20 .= '<tr style="background-color: #f9f9f9;">
               <td><strong>Customer contact list available?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['tr_cust_list'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html20 .= '<tr style="background-color: #ffffff;">
               <td><strong>Emergency contact list?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['tr_emerg_list'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html20 .= '<tr style="background-color: #f9f9f9;">
               <td><strong>Supply to foreign customers?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['tr_foreign'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html20 .= '<tr style="background-color: #ffffff;">
               <td><strong>If yes, included in recall procedure?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['tr_foreign_recall'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html20 .= '<tr style="background-color: #f9f9f9;">
               <td><strong>Out of hours recall test conducted?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['tr_oot_test'] == 'Yes' ? 'Yes (Last: ' . formatDate($main_data['tr_oot_date']) . ')' : 'No')) . '</td>
            </tr>';
$html20 .= '<tr style="background-color: #ffffff;">
               <td><strong>Mass balance system in place?</strong></td>
               <td>' . ($isGFSIYes ? '<span style="color: red; font-weight: bold;">Not Applicable (GFSI Accredited)</span>' : ($main_data['tr_mass_balance'] == 'Yes' ? 'Yes' : 'No')) . '</td>
            </tr>';
$html20 .='</table>';
$pdf->writeHTML($html20, true, false, true, false, '');
$pdf->Ln(5);

// ========== SECTION 21: PRODUCT LIABILITY (Always show) ==========
$html21 = '<h3>21. PRODUCT LIABILITY</h3>';
$html21 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
$html21 .= '<tr style="background-color: #d9e4f5;">
              <td width="30%"><strong>Liability & recall insurance scope</strong></td>
              <td width="70%">' . nl2br(safeText($main_data['liability_scope'])) . '</td>
            </tr>';

$liability_link = !empty($files_data['product_liability_insurance']) ? getFileLink($files_data['product_liability_insurance']) : '<span style="color: red;">Not Uploaded</span>';
$html21 .= '<tr style="background-color: #f9f9f9;">
               <td><strong>Product Liability Insurance Document</strong></td>
               <td>' . $liability_link . '</td>
            </tr>';
$html21 .= '</table>';
$pdf->writeHTML($html21, true, false, true, false, '');
$pdf->Ln(5);

// ========== SECTION 22: G.M.O. DATA (Always show) ==========
$html22 = '<h3>22. G.M.O. DATA</h3>';
$html22 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
$html22 .= '<tr style="background-color: #d9e4f5;">
              <td width="50%"><strong>Contains G.M. ingredients?</strong></td>
              <td width="50%">' . ($main_data['gmo_contain'] == 'Yes' ? 'Yes' : 'No') . '</td>
            </tr>';

if($main_data['gmo_contain'] == 'Yes'){
    $html22 .= '<tr style="background-color: #ffffff;">
                   <td><strong>GM ingredient name</strong></td>
                   <td>' . safeText($main_data['gmo_name']) . '</td>
                </tr>';
    $html22 .= '<tr style="background-color: #f9f9f9;">
                   <td><strong>GM ingredient source</strong></td>
                   <td>' . safeText($main_data['gmo_source']) . '</td>
                </tr>';
}

$html22 .= '</table>';
$pdf->writeHTML($html22, true, false, true, false, '');
$pdf->Ln(5);

// ========== SECTION 23: ETHICAL STANDARDS (Always show) ==========
$html23 = '<h3>23. ETHICAL STANDARDS & MSA 2015</h3>';
$html23 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
$html23 .= '<tr style="background-color: #d9e4f5;">
              <td width="50%"><strong>Willing to initiate SEDEX relationship?</strong></td>
              <td width="50%">' . ($main_data['eth_sedex'] == 'Yes' ? 'Yes' : 'No') . '</td>
            </tr>';
            
$html23 .= '<tr style="background-color: #ffffff;">
               <td><strong>SMETA or equivalent audit conducted?</strong></td>
               <td>' . ($main_data['eth_smeta'] == 'Yes' ? 'Yes' : 'No') . '</td>
            </tr>';
$html23 .= '<tr style="background-color: #f9f9f9;">
               <td><strong>Audit visible to our site?</strong></td>
               <td>' . ($main_data['eth_visible'] == 'Yes' ? 'Yes' : 'No') . '</td>
            </tr>';

$ethical_policy_link = !empty($files_data['ethical_policy']) ? getFileLink($files_data['ethical_policy']) : '<span style="color: red;">Not Uploaded</span>';
$html23 .= '<tr style="background-color: #ffffff;">
               <td><strong>Ethical Policy</strong></td>
               <td>' . $ethical_policy_link . '</td>
            </tr>';

$msa_policy_link = !empty($files_data['msa_policy']) ? getFileLink($files_data['msa_policy']) : '<span style="color: red;">Not Uploaded</span>';
$html23 .= '<tr style="background-color: #f9f9f9;">
               <td><strong>Modern Slavery Act Policy</strong></td>
               <td>' . $msa_policy_link . '</td>
            </tr>';

$html23 .= '</table>';
$pdf->writeHTML($html23, true, false, true, false, '');
$pdf->Ln(5);

// ========== SECTION 24: ORGANIC STATUS (Always show) ==========
$html24 = '<h3>24. ORGANIC STATUS COMPLIANCE</h3>';
$html24 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
$html24 .= '<tr style="background-color: #d9e4f5;">
              <td width="50%"><strong>Supply organic products?</strong></td>
              <td width="50%">' . ($main_data['org_supply'] == 'Yes' ? 'Yes' : 'No') . '</td>
            </tr>';

$org_cert_link = !empty($files_data['organic_certificate']) ? getFileLink($files_data['organic_certificate']) : '<span style="color: red;">Not Uploaded</span>';
$html24 .= '<tr style="background-color: #ffffff;">
               <td><strong>Organic Certificate</strong></td>
               <td>' . $org_cert_link . '</td>
            </tr>';

$org_schedule_link = !empty($files_data['organic_trading_schedule']) ? getFileLink($files_data['organic_trading_schedule']) : '<span style="color: red;">Not Uploaded</span>';
$html24 .= '<tr style="background-color: #f9f9f9;">
               <td><strong>Organic Trading Schedule</strong></td>
               <td>' . $org_schedule_link . '</td>
            </tr>';

if($main_data['org_supply'] == 'Yes'){
    $html24 .= '<tr style="background-color: #ffffff;">
                   <td><strong>Exclusion of scope?</strong></td>
                   <td>' . ($main_data['org_exclusion'] == 'Yes' ? 'Yes' : 'No') . '</td>
                </tr>';
}

$html24 .= '</table>';
$pdf->writeHTML($html24, true, false, true, false, '');
$pdf->Ln(5);

// ========== SECTION 25: FEED COMPLIANCE (Always show) ==========
$html25 = '<h3>25. FEED COMPLIANCE</h3>';
$html25 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
$html25 .= '<tr style="background-color: #d9e4f5;">
              <td width="50%"><strong>Supply feed products?</strong></td>
              <td width="50%">' . ($main_data['feed_supply'] == 'Yes' ? 'Yes' : 'No') . '</td>
            </tr>';

$feed_cert_link = !empty($files_data['feed_certificate']) ? getFileLink($files_data['feed_certificate']) : '<span style="color: red;">Not Uploaded</span>';
$html25 .= '<tr style="background-color: #ffffff;">
               <td><strong>FEED Certificate</strong></td>
               <td>' . $feed_cert_link . '</td>
            </tr>';

if($main_data['feed_supply'] == 'Yes'){
    $html25 .= '<tr style="background-color: #f9f9f9;">
                   <td><strong>Exclusion of scope?</strong></td>
                   <td>' . ($main_data['feed_exclusion'] == 'Yes' ? 'Yes' : 'No') . '</td>
                </tr>';
}

$html25 .='</table>';
$pdf->writeHTML($html25, true, false, true, false, '');
$pdf->Ln(5);

// ========== SECTION 26: CLAIM COMPLIANCE (Always show) ==========
$html26 = '<h3>26. CLAIM COMPLIANCE</h3>';
$html26 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
$html26 .= '<tr style="background-color: #d9e4f5;">
              <td width="50%"><strong>Claim validation available?</strong></td>
              <td width="50%">' . ($main_data['claim_val'] == 'Yes' ? 'Yes' : 'No') . '</td>
            </tr>';

$gluten_free_link = !empty($files_data['gluten_free_validation']) ? getFileLink($files_data['gluten_free_validation']) : '<span style="color: red;">Not Uploaded</span>';
$html26 .= '<tr style="background-color: #ffffff;">
               <td><strong>Gluten Free Validation Study</strong></td>
               <td>' . $gluten_free_link . '</td>
            </tr>';

$vegan_link = !empty($files_data['vegan_validation']) ? getFileLink($files_data['vegan_validation']) : '<span style="color: red;">Not Uploaded</span>';
$html26 .= '<tr style="background-color: #f9f9f9;">
               <td><strong>Vegan Validation Study</strong></td>
               <td>' . $vegan_link . '</td>
            </tr>';

$allergen_free_link = !empty($files_data['allergen_free_validation']) ? getFileLink($files_data['allergen_free_validation']) : '<span style="color: red;">Not Uploaded</span>';
$html26 .= '<tr style="background-color: #ffffff;">
               <td><strong>Allergen Free Validation Study</strong></td>
               <td>' . $allergen_free_link . '</td>
            </tr>';

$html26 .= '</table>';
$pdf->writeHTML($html26, true, false, true, false, '');
$pdf->Ln(5);

// ========== SECTION 27: SUSTAINABILITY (Always show) ==========
$html27 = '<h3>27. SUSTAINABILITY & ENVIRONMENTAL COMPLIANCE</h3>';
$html27 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
$html27 .= '<tr style="background-color: #d9e4f5;">
              <td width="50%"><strong>Sustainability policy?</strong></td>
              <td width="50%">' . ($main_data['sust_policy'] == 'Yes' ? 'Yes' : 'No') . '</td>
            </tr>';

$sust_policy_link = !empty($files_data['sustainability_policy']) ? getFileLink($files_data['sustainability_policy']) : '<span style="color: red;">Not Uploaded</span>';
$html27 .= '<tr style="background-color: #ffffff;">
               <td><strong>Sustainability Policy Document</strong></td>
               <td>' . $sust_policy_link . '</td>
            </tr>';

$html27 .= '<tr style="background-color: #f9f9f9;">
               <td><strong>Sustainability actions</strong></td>
               <td>' . nl2br(safeText($main_data['sust_actions'])) . '</td>
            </tr>';
$html27 .= '<tr style="background-color: #ffffff;">
               <td><strong>Environmental policy?</strong></td>
               <td>' . ($main_data['env_policy'] == 'Yes' ? 'Yes' : 'No') . '</td>
           </tr>';

$env_policy_link = !empty($files_data['environmental_policy']) ? getFileLink($files_data['environmental_policy']) : '<span style="color: red;">Not Uploaded</span>';
$html27 .= '<tr style="background-color: #f9f9f9;">
               <td><strong>Environmental Policy Document</strong></td>
               <td>' . $env_policy_link . '</td>
            </tr>';

$html27 .= '<tr style="background-color: #ffffff;">
               <td><strong>Environmental actions</strong></td>
               <td>' . nl2br(safeText($main_data['env_actions'])) . '</td>
            </tr>';

$html27 .= '</table>';
$pdf->writeHTML($html27, true, false, true, false, '');
$pdf->Ln(5);

// ========== DECLARATION & SIGN OFF ==========
$html_declaration = '<h3>DECLARATION & SIGN OFF</h3>';
$html_declaration .= '<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
$html_declaration .= '<tr style="background-color: #d9e4f5;">
                        <td colspan="3"><em>I confirm that the information on this questionnaire is correct, and that any changes which could affect product specifications, the HACCP plan or manufacture will be communicated to The Technical Department, at our site, immediately.</em></td>
                       </tr>';
$html_declaration .= '<tr style="background-color: #ffffff;">
                        <td width="33%"><strong>Completed by:</strong> ' . safeText($main_data['dec_completed_by']) . '</td>
                        <td width="33%"><strong>Completed on:</strong> ' . formatDate($main_data['dec_completed_date']) . '</td>
                        <td width="34%"><strong>Position:</strong> ' . safeText($main_data['dec_position']) . '</td>
                       </tr>';
$html_declaration .= '<tr style="background-color: #f9f9f9;">
                        <td><strong>Signature:</strong> ' . safeText($main_data['dec_signature']) . '</td>
                        <td><strong>Approved by:</strong> ' . safeText($main_data['dec_approved_by']) . '</td>
                        <td><strong>Approval Date:</strong> ' . formatDate($main_data['dec_approval_date']) . '</td>
                       </tr>';
$html_declaration .= '</table>';
$pdf->writeHTML($html_declaration, true, false, true, false, '');
$pdf->Ln(5);

// ========== ATTACHMENTS CHECKLIST ==========
$attachments = json_decode($main_data['attachments_checklist'], true);
if(!is_array($attachments)) {
    $attachments = array();
}

$html_attachments = '<h3>ATTACHMENTS CHECKLIST</h3>';
$html_attachments .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
$html_attachments .= '<tr style="background-color: #d9e4f5; font-weight: bold;">
    <th width="80%">Document Description</th>
    <th width="20%">Attached</th>
</tr>';

$att_list = array(
    'att1' => 'Third Party Audit Report (Q2)',
    'att2' => 'Third Party Audit Certificate (Q2)',
    'att3' => 'HACCP Documents (Q2)',
    'att4' => 'Process Flow Diagram (Q2)',
    'att5' => 'Product liability/recall cover (Q21)',
    'att6' => 'Ethical Standards & MSA Policy (Q23)',
    'att7' => 'Product Traceability Exercise'
);

$row_color = '#ffffff';
foreach($att_list as $key => $label){
    $checked = (isset($attachments[$key]) && !empty($attachments[$key])) ? 'Yes' : 'No';
    $color = (isset($attachments[$key]) && !empty($attachments[$key])) ? 'green' : 'red';
    $html_attachments .= '<tr style="background-color: ' . $row_color . ';">
        <td>' . $label . '</td>
        <td style="color: ' . $color . '; text-align: center; font-weight: bold;">' . $checked . '</td>
    </tr>';
    $row_color = ($row_color == '#ffffff') ? '#f9f9f9' : '#ffffff';
}

$html_attachments .= '</table>';
$pdf->writeHTML($html_attachments, true, false, true, false, '');
$pdf->Ln(5);

// Output PDF
$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "/supplier/pdf/supplier_approval_questionnaire_" .$name. ".pdf", "F");
?>

<!-- HTML view for the PDF -->
<!DOCTYPE html>
<html>

<head>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, Helvetica, sans-serif; background: #f5f5f5; }
        .main-content { padding: 20px; }
        .card { background: white; border: 1px solid #ddd; }
        .card-body { padding: 20px; }
        .btn { padding: 6px 12px; border: 1px solid #ddd; cursor: pointer; font-size: 12px; text-decoration: none; display: inline-block; background: #f5f5f5; color: #333; }
        .btn:hover { background: #e5e5e5; }
        .float-right { float: right; }
        .ml-2 { margin-left: 8px; }
        iframe { border: 1px solid #ddd; margin-top: 20px; width: 100%; height: 600px; }
    </style>
</head>

<body>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                  
                    <div class="row">
                        <div class="col-md-12">
                            <a href="supplier_audit_list.php" class="btn float-right ml-2">Back</a>
                            <a href="pdf/supplier_approval_questionnaire_<?php echo $name; ?>.pdf" download class="btn float-right ml-2">Download PDF</a>
                        </div>
                    </div>

                    <div style="margin-top: 20px; clear: both;">
                        <iframe src="pdf/supplier_approval_questionnaire_<?php echo $name; ?>.pdf" frameborder="0" style="width: 100%; height: 800px;"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>