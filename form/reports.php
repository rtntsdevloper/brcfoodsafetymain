<?php
include 'connection.php';
require('tcpdf/tcpdf.php');

// Get parameters
$id = isset($_GET['tid']) ? $_GET['tid'] : 0;

// Fetch supplier audit record
$main_query = mysqli_query($con, "SELECT * FROM supplier_audits WHERE submission_reference = '$id'");
$main_data = mysqli_fetch_array($main_query);

$wxt = $main_data['id'];
// Fetch uploaded files from tblfiles
$files_query = mysqli_query($con, "SELECT * FROM tblfiles WHERE audit_id = '$wxt'");
$files_data = mysqli_fetch_array($files_query);
$files = $files_data['attachment_files'];

// echo $files;
class MYPDF extends TCPDF
{
    

    private $logo1Path = 'images/logo1.png';
    private $logo2Path = 'images/rtnts.png';
    private $footerHTML = '';

    public function Header()
    {

        // Simple header with border line
        $this->SetFillColor(250, 250, 250);
        $this->Rect(0, 0, $this->getPageWidth(), 30, 'F');
        
        // Add logo 1 (left)
        if(file_exists($this->logo1Path)) {
            $this->Image($this->logo1Path, 15, 5, 25, 15, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }

        // Add logo 2 (right)
        if(file_exists($this->logo2Path)) {
            $this->Image($this->logo2Path, 170, 5, 25, 15, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }

        // Main title
        $this->SetFont('helvetica', 'B', 14);
        $this->SetTextColor(0, 0, 0);
        $this->SetXY(12, 12);
        $this->Cell(0, 0, 'SUPPLIER SELF AUDIT QUESTIONNAIRE REPORT', 0, 1, 'C');

        // Header line
        $this->SetLineWidth(0.3);
        $this->SetDrawColor(0, 0, 0);
        $this->Line(15, 28, 195, 28);
    }

    public function Footer()
    {

        $this->SetY(-22);
        
        // Footer line
        $this->SetLineWidth(0.2);
        $this->SetDrawColor(200, 200, 200);
        $this->Line(15, $this->GetY(), 285, $this->GetY());
        
        // Custom footer HTML if set
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
$pdf->SetTitle('Supplier Self Audit Questionnaire Report');
$pdf->SetSubject('Supplier Audit Report');
$pdf->SetKeywords('supplier, audit, questionnaire, report');

// Set margins
$pdf->SetMargins(15, 32, 15);
$pdf->SetHeaderMargin(8);
$pdf->SetFooterMargin(15);
$pdf->SetAutoPageBreak(TRUE, 25);

// Add page
$pdf->AddPage();
// ========== HEADER INFORMATION ==========
$html_header = '<table border="0" cellpadding="4" cellspacing="0" style="width: 100%; margin-bottom: 10px;">';
$html_header .= '<tr style="background-color: #d9e4f5;">
                    <td width="50%"><strong>Submission Reference:</strong> ' . htmlspecialchars($main_data['submission_reference']) . '</td>
                    <td width="50%"><strong>Submission Date:</strong> ' . date('d-m-Y H:i:s', strtotime($main_data['submission_date'])) . '</td>
                   </tr>';
$html_header .= '</table>';

$pdf->writeHTML($html_header, true, false, true, false, '');
$pdf->Ln(5);

// ========== SECTION 1: SUPPLIER DETAILS ==========
$html1 = '<h3 style="font-family: helvetica; font-weight: bold; margin-top: 10px; margin-bottom: 10px;">1. SUPPLIER DETAILS</h3>';
$html1 .= '<hr style="border: 0.5px solid #ccc; margin-bottom: 15px;">';

$html1 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
$html1 .= '<tr style="background-color: #d9e4f5;">
            <td width="30%"><strong>Supplier Name</strong></td>
            <td width="70%">' . htmlspecialchars($main_data['supplier_name']) . '</td>
           </tr>';

$html1 .= '<tr style="background-color: #ffffff;">
            <td><strong>Supplier Address</strong></td>
            <td>' . nl2br(htmlspecialchars($main_data['supplier_address'])) . '</td>
           </tr>';

$html1 .= '<tr style="background-color: #d9e4f5;">
            <td><strong>Technical Contact</strong></td>
            <td>' . htmlspecialchars($main_data['tech_contact']) . '</td>
           </tr>';

$html1 .= '<tr style="background-color: #ffffff;">
            <td><strong>Production Site Address</strong></td>
            <td>' . nl2br(htmlspecialchars($main_data['prod_site_address'])) . '</td>
           </tr>';

$html1 .= '<tr style="background-color: #d9e4f5;">
            <td><strong>Telephone No</strong></td>
            <td>' . htmlspecialchars($main_data['phone']) . '</td>
           </tr>';

$html1 .= '<tr style="background-color: #ffffff;">
            <td><strong>Fax No</strong></td>
            <td>' . htmlspecialchars($main_data['fax']) . '</td>
           </tr>';

$html1 .= '<tr style="background-color: #d9e4f5;">
            <td><strong>Email Address</strong></td>
            <td>' . htmlspecialchars($main_data['email']) . '</td>
           </tr>';

$html1 .= '<tr style="background-color: #ffffff;">
            <td><strong>Type of Supplier</strong></td>
            <td>' . ucfirst(htmlspecialchars($main_data['supplier_type'])) . '</td>
           </tr>';

$html1 .= '<tr style="background-color: #d9e4f5;">
            <td><strong>Products Supplied</strong></td>
            <td>' . htmlspecialchars($main_data['products']) . '</td>
           </tr>';

$html1 .= '<tr style="background-color: #ffffff;">
            <td><strong>Health Mark on goods supplied</strong></td>
            <td>' . htmlspecialchars($main_data['health_mark']) . '</td>
           </tr>';

$html1 .= '</table>';

$pdf->writeHTML($html1, true, false, true, false, '');
$pdf->Ln(5);

// ========== MAIN CONTACTS ==========
$html_contacts = '<h4 style="font-family: helvetica; font-weight: bold; margin-top: 10px;">MAIN CONTACTS</h4>';
$html_contacts .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
$html_contacts .= '<tr style="background-color: #d9e4f5; font-weight: bold;">
                    <th width="25%">Position</th>
                    <th width="25%">Name</th>
                    <th width="25%">Telephone</th>
                    <th width="25%">Email</th>
                   </tr>';
$html_contacts .= '<tr style="background-color: #ffffff;">
                    <td><strong>Managing Director</strong></td>
                    <td>' . htmlspecialchars($main_data['md_name']) . '</td>
                    <td>' . htmlspecialchars($main_data['md_tel']) . '</td>
                    <td>' . htmlspecialchars($main_data['md_email']) . '</td>
                   </tr>';
$html_contacts .= '<tr style="background-color: #f9f9f9;">
                    <td><strong>Technical</strong></td>
                    <td>' . htmlspecialchars($main_data['tech_name']) . '</td>
                    <td>' . htmlspecialchars($main_data['tech_tel']) . '</td>
                    <td>' . htmlspecialchars($main_data['tech_email']) . '</td>
                   </tr>';
$html_contacts .= '<tr style="background-color: #ffffff;">
                    <td><strong>Production</strong></td>
                    <td>' . htmlspecialchars($main_data['prod_name']) . '</td>
                    <td>' . htmlspecialchars($main_data['prod_tel']) . '</td>
                    <td>' . htmlspecialchars($main_data['prod_email']) . '</td>
                   </tr>';
$html_contacts .= '<tr style="background-color: #f9f9f9;">
                    <td><strong>Sales</strong></td>
                    <td>' . htmlspecialchars($main_data['sales_name']) . '</td>
                    <td>' . htmlspecialchars($main_data['sales_tel']) . '</td>
                    <td>' . htmlspecialchars($main_data['sales_email']) . '</td>
                   </tr>';
$html_contacts .= '</table>';

$pdf->writeHTML($html_contacts, true, false, true, false, '');
$pdf->Ln(5);

// ========== SECTION 2: QUALITY SYSTEMS & SITE SECURITY ==========
$html2 = '<h3 style="font-family: helvetica; font-weight: bold; margin-top: 15px; margin-bottom: 10px;">2. QUALITY SYSTEMS & SITE SECURITY</h3>';
$html2 .= '<hr style="border: 0.5px solid #ccc; margin-bottom: 15px;">';

$html2 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
$html2 .= '<tr style="background-color: #d9e4f5;">
            <td width="50%"><strong>GFSI Accredited?</strong></td>
            <td width="50%">' . ($main_data['gfsi_accredited'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
           </tr>';
if($main_data['gfsi_accredited'] == 'Yes'){
    $html2 .= '<tr style="background-color: #ffffff;">
                <td><strong>Most recent audit date</strong></td>
                <td>' . date('d-m-Y', strtotime($main_data['gfsi_audit_date'])) . '</td>
               </tr>';
    $html2 .= '<tr style="background-color: #f9f9f9;">
                <td><strong>Expiry date</strong></td>
                <td>' . date('d-m-Y', strtotime($main_data['gfsi_expiry'])) . '</td>
               </tr>';
    $html2 .= '<tr style="background-color: #ffffff;">
                <td><strong>Accredited Certifying Agency</strong></td>
                <td>' . htmlspecialchars($main_data['gfsi_agency']) . '</td>
               </tr>';
}
$html2 .= '<tr style="background-color: #f9f9f9;">
            <td><strong>Traceability Records (if not GFSI)</strong></td>
            <td>' . nl2br(htmlspecialchars($main_data['traceability_records'])) . '</td>
           </tr>';
$html2 .= '<tr style="background-color: #ffffff;">
            <td><strong>Site Security Risk Assessment?</strong></td>
            <td>' . ($main_data['security_risk'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
           </tr>';
$html2 .= '<tr style="background-color: #f9f9f9;">
            <td><strong>Written Quality Policy Statement?</strong></td>
            <td>' . ($main_data['quality_policy'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
           </tr>';
$html2 .= '<tr style="background-color: #ffffff;">
            <td><strong>Written Quality Manual?</strong></td>
            <td>' . ($main_data['quality_manual'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
           </tr>';
$html2 .= '<tr style="background-color: #f9f9f9;">
            <td><strong>HACCP System in place?</strong></td>
            <td>' . ($main_data['haccp_operational'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
           </tr>';
$html2 .= '<tr style="background-color: #ffffff;">
            <td><strong>HACCP Team & Qualifications</strong></td>
            <td>' . nl2br(htmlspecialchars($main_data['haccp_team'])) . '</td>
           </tr>';
$html2 .= '<tr style="background-color: #f9f9f9;">
            <td><strong>Pre-requisite Programme?</strong></td>
            <td>' . ($main_data['haccp_prp'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
           </tr>';
$html2 .= '<tr style="background-color: #ffffff;">
            <td><strong>CCP Validation Frequency</strong></td>
            <td>' . htmlspecialchars($main_data['ccp_validation_freq']) . '</td>
           </tr>';
$html2 .= '<tr style="background-color: #f9f9f9;">
            <td><strong>HACCP applied to product development?</strong></td>
            <td>' . ($main_data['haccp_dev'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
           </tr>';
$html2 .= '<tr style="background-color: #ffffff;">
            <td><strong>HACCP scope covers all process steps?</strong></td>
            <td>' . ($main_data['haccp_scope'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
           </tr>';
$html2 .= '<tr style="background-color: #f9f9f9;">
            <td><strong>Covers delivery & vehicle checks?</strong></td>
            <td>' . ($main_data['haccp_vehicle'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
           </tr>';
$html2 .= '</table>';

$pdf->writeHTML($html2, true, false, true, false, '');
$pdf->Ln(5);

// Determine if we show full form or limited form
$showFullForm = ($main_data['gfsi_accredited'] == 'No' || empty($main_data['gfsi_accredited']));

// ========== CONDITIONAL SECTIONS ==========
// Only show Sections 3,4,6-20 if GFSI is NO (full form required)
if($showFullForm) {
    // ========== SECTION 3: INTERNAL AUDITS ==========
    $html3 = '<h3 style="font-family: helvetica; font-weight: bold; margin-top: 15px; margin-bottom: 10px;">3. INTERNAL AUDITS</h3>';
    $html3 .= '<hr style="border: 0.5px solid #ccc; margin-bottom: 15px;">';
    $html3 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
    $html3 .= '<tr style="background-color: #d9e4f5;">
                <td width="30%"><strong>Internal Auditing Procedure</strong></td>
                <td width="70%">' . nl2br(htmlspecialchars($main_data['internal_audit_procedure'])) . '</td>
               </tr>';
    $html3 .= '<tr style="background-color: #ffffff;">
                <td><strong>Auditors & Training</strong></td>
                <td>' . nl2br(htmlspecialchars($main_data['auditors_training'])) . '</td>
               </tr>';
    $html3 .= '<tr style="background-color: #f9f9f9;">
                <td><strong>Audit Frequency</strong></td>
                <td>' . htmlspecialchars($main_data['audit_frequency']) . '</td>
               </tr>';
    $html3 .= '<tr style="background-color: #ffffff;">
                <td><strong>Non-compliance Review Frequency</strong></td>
                <td>' . htmlspecialchars($main_data['nc_review_frequency']) . '</td>
               </tr>';
    $html3 .= '</table>';
    $pdf->writeHTML($html3, true, false, true, false, '');
    $pdf->Ln(5);

    // ========== SECTION 4: FINISHED PRODUCT TESTING ==========
    $html4 = '<h3 style="font-family: helvetica; font-weight: bold; margin-top: 15px; margin-bottom: 10px;">4. FINISHED PRODUCT TESTING</h3>';
    $html4 .= '<hr style="border: 0.5px solid #ccc; margin-bottom: 15px;">';
    $html4 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
    $html4 .= '<tr style="background-color: #d9e4f5;">
                <td width="50%"><strong>Product Specification available?</strong></td>
                <td width="50%">' . ($main_data['product_spec'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
               </tr>';
    $html4 .= '<tr style="background-color: #ffffff;">
                <td><strong>Positive Release System?</strong></td>
                <td>' . ($main_data['positive_release'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
               </tr>';
    $html4 .= '<tr style="background-color: #f9f9f9;">
                <td><strong>How is this achieved?</strong></td>
                <td>' . nl2br(htmlspecialchars($main_data['release_method'])) . '</td>
               </tr>';
    $html4 .= '<tr style="background-color: #ffffff;">
                <td><strong>Certificate of Conformance?</strong></td>
                <td>' . ($main_data['coc'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
               </tr>';
    $html4 .= '<tr style="background-color: #f9f9f9;">
                <td><strong>In-house Accredited Laboratory?</strong></td>
                <td>' . ($main_data['inhouse_lab'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
               </tr>';
    $html4 .= '<tr style="background-color: #ffffff;">
                <td><strong>In-house Lab Details</strong></td>
                <td>' . nl2br(htmlspecialchars($main_data['inhouse_lab_details'])) . '</td>
               </tr>';
    $html4 .= '<tr style="background-color: #f9f9f9;">
                <td><strong>External Laboratory Used?</strong></td>
                <td>' . ($main_data['external_lab'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
               </tr>';
    $html4 .= '<tr style="background-color: #ffffff;">
                <td><strong>External Lab Details</strong></td>
                <td>' . nl2br(htmlspecialchars($main_data['external_lab_details'])) . '</td>
               </tr>';
    $html4 .= '</table>';
    $pdf->writeHTML($html4, true, false, true, false, '');
    $pdf->Ln(5);
}

// ========== SECTION 5: ALLERGENS (Always show) ==========
$html5 = '<h3 style="font-family: helvetica; font-weight: bold; margin-top: 15px; margin-bottom: 10px;">5. ALLERGENS</h3>';
$html5 .= '<hr style="border: 0.5px solid #ccc; margin-bottom: 15px;">';
$html5 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
$html5 .= '<tr style="background-color: #d9e4f5;">
            <td width="50%"><strong>Allergens on site</strong></td>
            <td width="50%">' . nl2br(htmlspecialchars($main_data['allergens_list'])) . '</td>
           </tr>';
$html5 .= '<tr style="background-color: #ffffff;">
            <td><strong>Allergen Risk Assessment?</strong></td>
            <td>' . ($main_data['allergen_risk'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
           </tr>';
$html5 .= '<tr style="background-color: #f9f9f9;">
            <td><strong>Controls in place?</strong></td>
            <td>' . ($main_data['allergen_controls'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
           </tr>';
$html5 .= '<tr style="background-color: #ffffff;">
            <td><strong>Cross Contamination Controls?</strong></td>
            <td>' . ($main_data['allergen_cross'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
           </tr>';
$html5 .= '<tr style="background-color: #f9f9f9;">
            <td><strong>Segregation in Storage?</strong></td>
            <td>' . ($main_data['allergen_storage'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
           </tr>';
$html5 .= '<tr style="background-color: #ffffff;">
            <td><strong>Cleaning System Validated?</strong></td>
            <td>' . ($main_data['allergen_clean_val'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
           </tr>';
$html5 .= '<tr style="background-color: #f9f9f9;">
            <td><strong>Allergen Validation (ELISA)?</strong></td>
            <td>' . ($main_data['allergen_elisa'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
           </tr>';
$html5 .= '</table>';
$pdf->writeHTML($html5, true, false, true, false, '');
$pdf->Ln(5);

// Continue with conditional sections
if($showFullForm) {
    // ========== SECTION 6: FABRICATION ==========
    $html6 = '<h3 style="font-family: helvetica; font-weight: bold; margin-top: 15px; margin-bottom: 10px;">6. FABRICATION (Premises & Equipment)</h3>';
    $html6 .= '<hr style="border: 0.5px solid #ccc; margin-bottom: 15px;">';
    $html6 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
    $html6 .= '<tr style="background-color: #d9e4f5;">
                <td width="50%"><strong>Premises comply with legislation?</strong></td>
                <td width="50%">' . ($main_data['fab_compliance'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
               </tr>';
    $html6 .= '<tr style="background-color: #ffffff;">
                <td><strong>Loading/Unloading areas covered?</strong></td>
                <td>' . ($main_data['fab_loading'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
               </tr>';
    $html6 .= '<tr style="background-color: #f9f9f9;">
                <td><strong>Drains clean & odour-free?</strong></td>
                <td>' . ($main_data['fab_drains'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
               </tr>';
    $html6 .= '<tr style="background-color: #ffffff;">
                <td><strong>Floors & walls in good condition?</strong></td>
                <td>' . ($main_data['fab_floors'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
               </tr>';
    $html6 .= '<tr style="background-color: #f9f9f9;">
                <td><strong>Windows & doors screened?</strong></td>
                <td>' . ($main_data['fab_windows'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
               </tr>';
    $html6 .= '<tr style="background-color: #ffffff;">
                <td><strong>Lights protected against breakage?</strong></td>
                <td>' . ($main_data['fab_lights'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
               </tr>';
    $html6 .= '<tr style="background-color: #f9f9f9;">
                <td><strong>Light lumens checks conducted?</strong></td>
                <td>' . ($main_data['fab_lumens'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
               </tr>';
    $html6 .= '<tr style="background-color: #ffffff;">
                <td><strong>Steam/dust/odours extracted?</strong></td>
                <td>' . ($main_data['fab_extraction'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
               </tr>';
    $html6 .= '<tr style="background-color: #f9f9f9;">
                <td><strong>Source of water in production</strong></td>
                <td>' . htmlspecialchars($main_data['fab_water_source']) . '</td>
               </tr>';
    $html6 .= '<tr style="background-color: #ffffff;">
                <td><strong>Water supply treated?</strong></td>
                <td>' . ($main_data['fab_water_treated'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
               </tr>';
    $html6 .= '<tr style="background-color: #f9f9f9;">
                <td><strong>Water testing frequency</strong></td>
                <td>' . htmlspecialchars($main_data['fab_water_micro_freq']) . '</td>
               </tr>';
    $html6 .= '<tr style="background-color: #ffffff;">
                <td><strong>Chemicals in lockable location?</strong></td>
                <td>' . ($main_data['fab_chemicals'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
               </tr>';
    $html6 .= '</table>';
    $pdf->writeHTML($html6, true, false, true, false, '');
    $pdf->Ln(5);

    // ========== SECTION 7: FOREIGN BODY CONTROL ==========
    $html7 = '<h3 style="font-family: helvetica; font-weight: bold; margin-top: 15px; margin-bottom: 10px;">7. FOREIGN BODY CONTROL</h3>';
   
    $html7 .= '<hr style="border: 0.5px solid #ccc; margin-bottom: 15px;">';
    $html7 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
    $html7 .= '<tr style="background-color: #d9e4f5;">
                <td width="50%"><strong>Glass permitted on-site?</strong></td>
                <td width="50%">' . ($main_data['fbc_glass'] == 'Yes' ? '<span style="color: orange;">Yes</span>' : '<span style="color: green;">No</span>') . '</td>
               </tr>';

    $html7 .= '<tr style="background-color: #ffffff;">
                <td><strong>Glass/Brittle plastic register?</strong></td>
                <td>' . ($main_data['fbc_register'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
               </tr>';

    $html7 .= '<tr style="background-color: #f9f9f9;">
                <td><strong>Glass breakage procedure?</strong></td>
                <td>' . ($main_data['fbc_breakage'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
               </tr>';

    $html7 .= '<tr style="background-color: #ffffff;">
                <td><strong>Metal detection in place?</strong></td>
                <td>' . ($main_data['fbc_metal'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
               </tr>';

    $html7 .= '<tr style="background-color: #f9f9f9;">
                <td><strong>Type of Metal detector</strong></td>
                <td>' . htmlspecialchars($main_data['fbc_detector_type']) . '</td>
               </tr>';

    $html7 .= '<tr style="background-color: #ffffff;">
                <td><strong>Detector testing frequency</strong></td>
                <td>' . nl2br(htmlspecialchars($main_data['fbc_detector_test'])) . '</td>
               </tr>';

    $html7 .= '<tr style="background-color: #f9f9f9;">
                <td><strong>Product filtering details</strong></td>
                <td>' . nl2br(htmlspecialchars($main_data['fbc_filtering'])) . '</td>
               </tr>';

    $html7 .= '<tr style="background-color: #ffffff;">
                <td><strong>Wood allowed in production?</strong></td>
                <td>' . ($main_data['fbc_wood'] == 'Yes' ? '<span style="color: orange;">Yes</span>' : '<span style="color: green;">No</span>') . '</td>
               </tr>';

    $html7 .= '<tr style="background-color: #f9f9f9;">
                <td><strong>Jewellery allowed?</strong></td>
                <td>' . htmlspecialchars($main_data['fbc_jewellery']) . '</td>
               </tr>';
    $html7 .= '</table>';
    $pdf->writeHTML($html7, true, false, true, false, '');
    $pdf->Ln(5);

    // ========== SECTION 8: PEST CONTROL ==========
$html8 = '<h3 style="font-family: helvetica; font-weight: bold; margin-top: 15px; margin-bottom: 10px;">8. PEST CONTROL</h3>';
$html8 .= '<hr style="border: 0.5px solid #ccc; margin-bottom: 15px;">';
$html8 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';

$html8 .= '<tr style="background-color: #d9e4f5;">
             <td width="50%"><strong>Contractor Name</strong></td>
             <td width="50%">' . htmlspecialchars($main_data['pc_contractor']) . '</td>
           </tr>';

$html8 .= '<tr style="background-color: #ffffff;">
             <td><strong>Routine visits/year</strong></td>
             <td>' . htmlspecialchars($main_data['pc_routine']) . '</td>
           </tr>';

$html8 .= '<tr style="background-color: #f9f9f9;">
             <td><strong>Other visits/year</strong></td>
             <td>' . htmlspecialchars($main_data['pc_other']) . '</td>
           </tr>';

$html8 .= '<tr style="background-color: #ffffff;">
             <td><strong>Part of BPCA?</strong></td>
             <td>' . ($main_data['pc_bpca'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
           </tr>';

$html8 .= '<tr style="background-color: #f9f9f9;">
             <td><strong>Registration Number</strong></td>
             <td>' . htmlspecialchars($main_data['pc_reg_no']) . '</td>
           </tr>';

$html8 .= '<tr style="background-color: #ffffff;">
             <td><strong>Electric fly killers?</strong></td>
             <td>' . ($main_data['pc_efk'] == 'Yes' 
                 ? '<span style="color: green;">Yes (' . htmlspecialchars($main_data['pc_efk_qty']) . ' units)</span>' 
                 : '<span style="color: red;">No</span>') . '</td>
           </tr>';

$html8 .= '<tr style="background-color: #f9f9f9;">
             <td><strong>Pheromone traps?</strong></td>
             <td>' . ($main_data['pc_pheromone'] == 'Yes' 
                 ? '<span style="color: green;">Yes (' . htmlspecialchars($main_data['pc_pheromone_qty']) . ' units)</span>' 
                 : '<span style="color: red;">No</span>') . '</td>
           </tr>';

$html8 .= '</table>';

$pdf->writeHTML($html8, true, false, true, false, '');
    $pdf->Ln(5);

    // ========== SECTION 9: STORAGE & TRANSPORTATION ==========
    $html9 = '<h3 style="font-family: helvetica; font-weight: bold; margin-top: 15px; margin-bottom: 10px;">9. STORAGE & TRANSPORTATION</h3>';
    $html9 .= '<hr style="border: 0.5px solid #ccc; margin-bottom: 15px;">';
    $html9 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
    $html9 .= '<tr style="background-color: #d9e4f5;">
                <td width="30%"><strong>Storage arrangements</strong></td>
                <td width="70%">' . nl2br(htmlspecialchars($main_data['storage_details'])) . '</td>
               </tr>';
    $html9 .= '<tr style="background-color: #ffffff;">
                <td><strong>Cold/Chill stores details</strong></td>
                <td>' . nl2br(htmlspecialchars($main_data['cold_store_details'])) . '</td>
               </tr>';
    $html9 .= '<tr style="background-color: #f9f9f9;">
                <td><strong>Third party storage approval</strong></td>
                <td>' . nl2br(htmlspecialchars($main_data['3rd_party_storage'])) . '</td>
               </tr>';
    $html9 .= '<tr style="background-color: #ffffff;">
                <td><strong>Refrigerated vehicles suitable?</strong></td>
                <td>' . ($main_data['refrig_vehicles'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
               </tr>';
 
$html9 .= '</table>';
$pdf->writeHTML($html9, true, false, true, false, '');
    $pdf->Ln(5);

    // ========== SECTION 10: PACKAGING ==========
    $html10 = '<h3 style="font-family: helvetica; font-weight: bold; margin-top: 15px; margin-bottom: 10px;">10. PACKAGING</h3>';
    $html10 .= '<hr style="border: 0.5px solid #ccc; margin-bottom: 15px;">';
    $html10 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
    $html10 .= '<tr style="background-color: #d9e4f5;">
                <td width="50%"><strong>Packaging complies with legislation?</strong></td>
                <td width="50%">' . ($main_data['pack_compliance'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
               </tr>';
    $html10 .= '</table>';
    $pdf->writeHTML($html10, true, false, true, false, '');
    $pdf->Ln(5);

    // ========== SECTION 11: WASTE DISPOSAL ==========
   $html11 = '<h3 style="font-family: helvetica; font-weight: bold; margin-top: 15px; margin-bottom: 10px;">11. WASTE DISPOSAL</h3>';
$html11 .= '<hr style="border: 0.5px solid #ccc; margin-bottom: 15px;">';
$html11 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';

$html11 .= '<tr style="background-color: #d9e4f5;">
              <td width="50%"><strong>Waste segregation adequate?</strong></td>
              <td width="50%">' . ($main_data['waste_seg'] == 'Yes' 
                  ? '<span style="color: green;">Yes</span>' 
                  : '<span style="color: red;">No</span>') . '</td>
            </tr>';

$html11 .= '<tr style="background-color: #ffffff;">
              <td><strong>External containers closed/covered?</strong></td>
              <td>' . ($main_data['waste_closed'] == 'Yes' 
                  ? '<span style="color: green;">Yes</span>' 
                  : '<span style="color: red;">No</span>') . '</td>
            </tr>';

$html11 .= '<tr style="background-color: #f9f9f9;">
              <td><strong>Registered contractor for waste?</strong></td>
              <td>' . ($main_data['waste_contractor'] == 'Yes' 
                  ? '<span style="color: green;">Yes</span>' 
                  : '<span style="color: red;">No</span>') . '</td>
            </tr>';

$html11 .= '</table>';

$pdf->writeHTML($html11, true, false, true, false, '');
    $pdf->Ln(5);

    // ========== SECTION 12: MAINTENANCE ==========
    $html12 = '<h3 style="font-family: helvetica; font-weight: bold; margin-top: 15px; margin-bottom: 10px;">12. MAINTENANCE</h3>';
$html12 .= '<hr style="border: 0.5px solid #ccc; margin-bottom: 15px;">';
$html12 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';

$html12 .= '<tr style="background-color: #d9e4f5;">
              <td width="50%"><strong>Planned maintenance system?</strong></td>
              <td width="50%">' . ($main_data['maint_planned'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
            </tr>';

$html12 .= '<tr style="background-color: #ffffff;">
              <td><strong>Maintenance documented?</strong></td>
              <td>' . ($main_data['maint_docs'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
            </tr>';

$html12 .= '<tr style="background-color: #f9f9f9;">
              <td><strong>Parts accounting system?</strong></td>
              <td>' . ($main_data['maint_parts'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
            </tr>';

$html12 .= '<tr style="background-color: #ffffff;">
              <td><strong>Air filtration for high-risk?</strong></td>
              <td>' . ($main_data['maint_air_filter'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
            </tr>';

$html12 .= '<tr style="background-color: #f9f9f9;">
              <td><strong>Filter changing procedure?</strong></td>
              <td>' . ($main_data['maint_filter_proc'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
            </tr>';

$html12 .= '<tr style="background-color: #ffffff;">
              <td><strong>Air/steam contacts food?</strong></td>
              <td>' . ($main_data['maint_air_contact'] == 'Yes' ? '<span style="color: orange;">Yes</span>' : '<span style="color: green;">No</span>') . '</td>
            </tr>';

$html12 .= '<tr style="background-color: #f9f9f9;">
              <td><strong>Suitable for direct contact?</strong></td>
              <td>' . ($main_data['maint_air_suitable'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
            </tr>';

$html12 .= '<tr style="background-color: #ffffff;">
              <td><strong>Food grade lubricants used?</strong></td>
              <td>' . ($main_data['maint_lubricants'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
            </tr>';

$html12 .= '<tr style="background-color: #f9f9f9;">
              <td><strong>Risk assessed for lubricants?</strong></td>
              <td>' . ($main_data['maint_lube_ra'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
            </tr>';

$html12 .= '</table>';

$pdf->writeHTML($html12, true, false, true, false, '');
    $pdf->Ln(5);

    // ========== SECTION 13: PERSONAL HYGIENE ==========
    $html13 = '<h3 style="font-family: helvetica; font-weight: bold; margin-top: 15px; margin-bottom: 10px;">13. PERSONAL HYGIENE</h3>';
    $html13 .= '<hr style="border: 0.5px solid #ccc; margin-bottom: 15px;">';
    $html13 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
    $html13 .= '<tr style="background-color: #d9e4f5;">
                <td width="30%"><strong>Protective clothing</strong></td>
                <td width="70%">' . nl2br(htmlspecialchars($main_data['hyg_clothing'])) . '</td>
               </tr>';
    $html13 .= '<tr style="background-color: #ffffff;">
                <td><strong>Overalls changing/laundering</strong></td>
                <td>' . htmlspecialchars($main_data['hyg_overalls']) . '</td>
               </tr>';
    $html13 .= '<tr style="background-color: #f9f9f9;">
                <td><strong>Smoking permitted?</strong></td>
                <td>' . ($main_data['hyg_smoking'] == 'Yes' ? '<span style="color: orange;">Yes (' . $main_data['hyg_smoke_areas'] . ')</span>' : '<span style="color: green;">No</span>') . '</td>
               </tr>';
    $html13 .= '<tr style="background-color: #ffffff;">
                <td><strong>Medical screening policy</strong></td>
                <td>' . nl2br(htmlspecialchars($main_data['hyg_medical'])) . '</td>
               </tr>';
    $html13 .= '<tr style="background-color: #f9f9f9;">
                <td><strong>Illness exclusion policy?</strong></td>
                <td>' . ($main_data['hyg_illness'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
               </tr>';
    $html13 .= '<tr style="background-color: #ffffff;">
                <td><strong>Eating/drinking banned?</strong></td>
                <td>' . ($main_data['hyg_food_drink'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
               </tr>';
    $html13 .= '<tr style="background-color: #f9f9f9;">
                <td><strong>Adequate toilets?</strong></td>
                <td>' . ($main_data['hyg_toilets'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
               </tr>';
    $html13 .= '<tr style="background-color: #ffffff;">
                <td><strong>Adequate handwashing facilities?</strong></td>
                <td>' . ($main_data['hyg_handwash'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
               </tr>';
    $html13 .= '<tr style="background-color: #f9f9f9;">
                <td><strong>Anti-bacterial soap used?</strong></td>
                <td>' . ($main_data['hyg_soap'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
               </tr>';
    $html13 .= '<tr style="background-color: #ffffff;">
                <td><strong>Adequate hand drying?</strong></td>
                <td>' . ($main_data['hyg_dryer'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
               </tr>';
    $html13 .= '<tr style="background-color: #f9f9f9;">
                <td><strong>Lidded waste bins?</strong></td>
                <td>' . ($main_data['hyg_bins'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
               </tr>';
    $html13 .= '</table>';
    $pdf->writeHTML($html13, true, false, true, false, '');
    $pdf->Ln(5);

    // ========== SECTION 14: TRAINING ==========
    $html14 = '<h3 style="font-family: helvetica; font-weight: bold; margin-top: 15px; margin-bottom: 10px;">14. TRAINING</h3>';
    $html14 .= '<hr style="border: 0.5px solid #ccc; margin-bottom: 15px;">';
    $html14 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
    $html14 .= '<tr style="background-color: #d9e4f5;">
                <td width="30%"><strong>Staff trained to SOPs?</strong></td>
                <td width="70%">' . ($main_data['train_sop'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
               </tr>';
    $html14 .= '<tr style="background-color: #ffffff;">
                <td><strong>Food hygiene training</strong></td>
                <td>' . nl2br(htmlspecialchars($main_data['train_hygiene'])) . '</td>
               </tr>';
    $html14 .= '<tr style="background-color: #f9f9f9;">
                <td><strong>Training records kept?</strong></td>
                <td>' . nl2br(htmlspecialchars($main_data['train_record'])) . '</td>
               </tr>';
    $html14 .= '</table>';
    $pdf->writeHTML($html14, true, false, true, false, '');
    $pdf->Ln(5);

    // ========== SECTION 15: CLEANING HYGIENE PROCEDURES ==========
    $html15 = '<h3 style="font-family: helvetica; font-weight: bold; margin-top: 15px; margin-bottom: 10px;">15. CLEANING HYGIENE PROCEDURES</h3>';
    $html15 .= '<hr style="border: 0.5px solid #ccc; margin-bottom: 15px;">';
    $html15 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
    $html15 .= '<tr style="background-color: #d9e4f5;">
                <td width="30%"><strong>Formal cleaning schedules?</strong></td>
                <td width="70%">' . ($main_data['clean_schedules'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
               </tr>';
    $html15 .= '<tr style="background-color: #ffffff;">
                <td><strong>Cleaning effectiveness monitoring</strong></td>
                <td>' . nl2br(htmlspecialchars($main_data['clean_monitor'])) . '</td>
               </tr>';
    $html15 .= '<tr style="background-color: #f9f9f9;">
                <td><strong>Environmental swabbing?</strong></td>
                <td>' . ($main_data['clean_swab'] == 'Yes' ? '<span style="color: green;">Yes (Frequency: ' . $main_data['clean_swab_freq'] . ')</span>' : '<span style="color: red;">No</span>') . '</td>
               </tr>';
    $html15 .= '<tr style="background-color: #ffffff;">
                <td><strong>Corrective action documentation</strong></td>
                <td>' . nl2br(htmlspecialchars($main_data['clean_ca_docs'])) . '</td>
               </tr>';
    $html15 .= '</table>';
    $pdf->writeHTML($html15, true, false, true, false, '');
    $pdf->Ln(5);

    // ========== SECTION 16: NON-CONFORMING PRODUCT ==========
    $html16 = '<h3 style="font-family: helvetica; font-weight: bold; margin-top: 15px; margin-bottom: 10px;">16. NON-CONFORMING PRODUCT</h3>';
    $html16 .= '<hr style="border: 0.5px solid #ccc; margin-bottom: 15px;">';
    $html16 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
    $html16 .= '<tr style="background-color: #d9e4f5;">
                <td><strong>Procedure for non-conforming product</strong></td>
                </tr>';
    $html16 .= '<tr style="background-color: #ffffff;">
                <td>' . nl2br(htmlspecialchars($main_data['nc_procedure'])) . '</td>
               </tr>';
    $html16 .= '</table>';
    $pdf->writeHTML($html16, true, false, true, false, '');
    $pdf->Ln(5);

    // ========== SECTION 17: CALIBRATION ==========
    $html17 = '<h3 style="font-family: helvetica; font-weight: bold; margin-top: 15px; margin-bottom: 10px;">17. CALIBRATION</h3>';
$html17 .= '<hr style="border: 0.5px solid #ccc; margin-bottom: 15px;">';
$html17 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';

$html17 .= '<tr style="background-color: #d9e4f5;">
              <td width="50%"><strong>Calibration schedule?</strong></td>
              <td width="50%">' . ($main_data['cal_schedule'] == 'Yes' 
                  ? '<span style="color: green;">Yes</span>' 
                  : '<span style="color: red;">No</span>') . '</td>
            </tr>';

$html17 .= '<tr style="background-color: #ffffff;">
              <td><strong>Equipment labelled with calibration status?</strong></td>
              <td>' . ($main_data['cal_labels'] == 'Yes' 
                  ? '<span style="color: green;">Yes</span>' 
                  : '<span style="color: red;">No</span>') . '</td>
            </tr>';
$html17 .= '</table>';

$pdf->writeHTML($html17, true, false, true, false, '');
    $pdf->Ln(5);

    // ========== SECTION 18: SUPPLIERS ==========
    $html18 = '<h3 style="font-family: helvetica; font-weight: bold; margin-top: 15px; margin-bottom: 10px;">18. SUPPLIERS</h3>';
    $html18 .= '<hr style="border: 0.5px solid #ccc; margin-bottom: 15px;">';
    $html18 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
    $html18 .= '<tr style="background-color: #d9e4f5;">
                <td width="30%"><strong>Supplier assessment method</strong></td>
                <td width="70%">' . nl2br(htmlspecialchars($main_data['sup_assessment'])) . '</td>
               </tr>';
    $html18 .= '<tr style="background-color: #ffffff;">
                <td><strong>Specifications held for all?</strong></td>
                <td>' . ($main_data['sup_specs'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
               </tr>';
    $html18 .= '</table>';
    $pdf->writeHTML($html18, true, false, true, false, '');
    $pdf->Ln(5);

    // ========== SECTION 19: CUSTOMER COMPLAINTS ==========
    $html19 = '<h3 style="font-family: helvetica; font-weight: bold; margin-top: 15px; margin-bottom: 10px;">19. CUSTOMER COMPLAINTS</h3>';
    $html19 .= '<hr style="border: 0.5px solid #ccc; margin-bottom: 15px;">';
    $html19 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
    $html19 .= '<tr style="background-color: #d9e4f5;">
                <td><strong>Complaint handling procedure</strong></td>
                </tr>';
    $html19 .= '<tr style="background-color: #ffffff;">
                <td>' . nl2br(htmlspecialchars($main_data['comp_procedures'])) . '</td>
               </tr>';
    $html19 .= '</table>';
    $pdf->writeHTML($html19, true, false, true, false, '');
    $pdf->Ln(5);

    // ========== SECTION 20: TRACEABILITY AND PRODUCT RECALL ==========
   $html20 = '<h3 style="font-family: helvetica; font-weight: bold; margin-top: 15px; margin-bottom: 10px;">20. TRACEABILITY AND PRODUCT RECALL</h3>';
$html20 .= '<hr style="border: 0.5px solid #ccc; margin-bottom: 15px;">';
$html20 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';

$html20 .= '<tr style="background-color: #d9e4f5;">
              <td width="50%"><strong>Traceability & Recall system</strong></td>
              <td width="50%">' . nl2br(htmlspecialchars($main_data['trace_recall_sys'])) . '</td>
            </tr>';

$html20 .= '<tr style="background-color: #ffffff;">
              <td><strong>Supplier contact list available?</strong></td>
              <td>' . ($main_data['tr_supplier_list'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
            </tr>';

$html20 .= '<tr style="background-color: #f9f9f9;">
              <td><strong>Customer contact list available?</strong></td>
              <td>' . ($main_data['tr_cust_list'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
            </tr>';

$html20 .= '<tr style="background-color: #ffffff;">
              <td><strong>Emergency contact list?</strong></td>
              <td>' . ($main_data['tr_emerg_list'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
            </tr>';

$html20 .= '<tr style="background-color: #f9f9f9;">
              <td><strong>Supply to foreign customers?</strong></td>
              <td>' . ($main_data['tr_foreign'] == 'Yes' ? '<span style="color: orange;">Yes</span>' : '<span style="color: green;">No</span>') . '</td>
            </tr>';

$html20 .= '<tr style="background-color: #ffffff;">
              <td><strong>Out of hours recall test conducted?</strong></td>
              <td>' . ($main_data['tr_oot_test'] == 'Yes' 
                  ? '<span style="color: green;">Yes (Last: ' . date('d-m-Y', strtotime($main_data['tr_oot_date'])) . ')</span>' 
                  : '<span style="color: red;">No</span>') . '</td>
            </tr>';

$html20 .= '<tr style="background-color: #f9f9f9;">
              <td><strong>Mass balance system in place?</strong></td>
              <td>' . ($main_data['tr_mass_balance'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
            </tr>';

$html20 .= '</table>';

$pdf->writeHTML($html20, true, false, true, false, '');
    $pdf->Ln(5);
}

// ========== SECTION 21: PRODUCT LIABILITY (Always show) ==========
$html21 = '<h3 style="font-family: helvetica; font-weight: bold; margin-top: 15px; margin-bottom: 10px;">21. PRODUCT LIABILITY</h3>';
$html21 .= '<hr style="border: 0.5px solid #ccc; margin-bottom: 15px;">';
$html21 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';

$html21 .= '<tr style="background-color: #d9e4f5;">
              <td width="50%"><strong>Liability & recall insurance scope</strong></td>
              <td width="50%">' . nl2br(htmlspecialchars($main_data['liability_scope'])) . '</td>
            </tr>';

$html21 .= '</table>';

$pdf->writeHTML($html21, true, false, true, false, '');
$pdf->Ln(5);


// ========== SECTION 22: G.M.O. DATA (Always show) ==========
$html22 = '<h3 style="font-family: helvetica; font-weight: bold; margin-top: 15px; margin-bottom: 10px;">22. G.M.O. DATA</h3>';
$html22 .= '<hr style="border: 0.5px solid #ccc; margin-bottom: 15px;">';
$html22 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
$html22 .= '<tr style="background-color: #d9e4f5;">
            <td width="50%"><strong>Contains G.M. ingredients?</strong></td>
            <td width="50%">' . ($main_data['gmo_contain'] == 'Yes' ? '<span style="color: orange;">Yes</span>' : '<span style="color: green;">No</span>') . '</td>
           </tr>';

if($main_data['gmo_contain'] == 'Yes'){
    $html22 .= '<tr style="background-color: #ffffff;">
                <td><strong>GM ingredient name</strong></td>
                <td>' . htmlspecialchars($main_data['gmo_name']) . '</td>
               </tr>';

    $html22 .= '<tr style="background-color: #f9f9f9;">
                <td><strong>GM ingredient source</strong></td>
                <td>' . htmlspecialchars($main_data['gmo_source']) . '</td>
               </tr>';
}

$html22 .= '</table>';
$pdf->writeHTML($html22, true, false, true, false, '');
$pdf->Ln(5);

// ========== SECTION 23: ETHICAL STANDARDS (Always show) ==========
$html23 = '<h3 style="font-family: helvetica; font-weight: bold; margin-top: 15px; margin-bottom: 10px;">23. ETHICAL STANDARDS & MSA 2015</h3>';
$html23 .= '<hr style="border: 0.5px solid #ccc; margin-bottom: 15px;">';
$html23 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
$html23 .= '<tr style="background-color: #d9e4f5;">
            <td width="50%"><strong>Willing to initiate SEDEX relationship?</strong></td>
            <td width="50%">' . ($main_data['eth_sedex'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
           </tr>';
$html23 .= '<tr style="background-color: #ffffff;">
            <td><strong>SMETA or equivalent audit conducted?</strong></td>
            <td>' . ($main_data['eth_smeta'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
           </tr>';
$html23 .= '<tr style="background-color: #f9f9f9;">
            <td><strong>Audit visible to our site?</strong></td>
            <td>' . ($main_data['eth_visible'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
           </tr>';
$html23 .= '</table>';  //✅ Correct closing tag
$pdf->writeHTML($html23, true, false, true, false, '');
$pdf->Ln(5);

// ========== SECTION 24: ORGANIC STATUS (Always show) ==========
$html24 = '<h3 style="font-family: helvetica; font-weight: bold; margin-top: 15px; margin-bottom: 10px;">24. ORGANIC STATUS COMPLIANCE</h3>';
$html24 .= '<hr style="border: 0.5px solid #ccc; margin-bottom: 15px;">';
$html24 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
$html24 .= '<tr style="background-color: #d9e4f5;">
            <td width="50%"><strong>Supply organic products?</strong></td>
            <td width="50%">' . ($main_data['org_supply'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
            </tr>';

if($main_data['org_supply'] == 'Yes'){
    $html24 .= '<tr style="background-color: #ffffff;">
                <td><strong>Exclusion of scope?</strong></td>
                <td>' . ($main_data['org_exclusion'] == 'Yes' ? '<span style="color: orange;">Yes</span>' : '<span style="color: green;">No</span>') . '</td>
               </tr>';
}

$html24 .= '</table>';
$pdf->writeHTML($html24, true, false, true, false, '');
$pdf->Ln(5);

// ========== SECTION 25: FEED COMPLIANCE (Always show) ==========
$html25 = '<h3 style="font-family: helvetica; font-weight: bold; margin-top: 15px; margin-bottom: 10px;">25. FEED COMPLIANCE</h3>';
$html25 .= '<hr style="border: 0.5px solid #ccc; margin-bottom: 15px;">';
$html25 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
$html25 .= '<tr style="background-color: #d9e4f5;">
            <td width="50%"><strong>Supply feed products?</strong></td>
            <td width="50%">' . ($main_data['feed_supply'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
           </tr>';

if($main_data['feed_supply'] == 'Yes'){
    $html25 .= '<tr style="background-color: #ffffff;">
                <td><strong>Exclusion of scope?</strong></td>
                <td>' . ($main_data['feed_exclusion'] == 'Yes' ? '<span style="color: orange;">Yes</span>' : '<span style="color: green;">No</span>') . '</td>
               </tr>';
}

$html25 .= '</table>';
$pdf->writeHTML($html25, true, false, true, false, '');
$pdf->Ln(5);

// ========== SECTION 26: CLAIM COMPLIANCE (Always show) ==========
$html26 = '<h3 style="font-family: helvetica; font-weight: bold; margin-top: 15px; margin-bottom: 10px;">26. CLAIM COMPLIANCE</h3>';
$html26 .= '<hr style="border: 0.5px solid #ccc; margin-bottom: 15px;">';
$html26 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
$html26 .= '<tr style="background-color: #d9e4f5;">
            <td width="50%"><strong>Claim validation available?</strong></td>
            <td width="50%">' . ($main_data['claim_val'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
           </tr>';
$html26 .= '</table>';
$pdf->writeHTML($html26, true, false, true, false, '');
$pdf->Ln(5);

// ========== SECTION 27: SUSTAINABILITY (Always show) ==========
$html27 = '<h3 style="font-family: helvetica; font-weight: bold; margin-top: 15px; margin-bottom: 10px;">27. SUSTAINABILITY & ENVIRONMENTAL COMPLIANCE</h3>';
$html27 .= '<hr style="border: 0.5px solid #ccc; margin-bottom: 15px;">';
$html27 .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
$html27 .= '<tr style="background-color: #d9e4f5;">
            <td width="50%"><strong>Sustainability policy?</strong></td>
            <td width="50%">' . ($main_data['sust_policy'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
           </tr>';
$html27 .= '<tr style="background-color: #ffffff;">
            <td><strong>Sustainability actions</strong></td>
            <td>' . nl2br(htmlspecialchars($main_data['sust_actions'])) . '</td>
           </tr>';   // ✅ Correct closing
$html27 .= '<tr style="background-color: #f9f9f9;">
            <td><strong>Environmental policy?</strong></td>
            <td>' . ($main_data['env_policy'] == 'Yes' ? '<span style="color: green;">Yes</span>' : '<span style="color: red;">No</span>') . '</td>
           </tr>';
$html27 .= '<tr style="background-color: #ffffff;">
            <td><strong>Environmental actions</strong></td>
            <td>' . nl2br(htmlspecialchars($main_data['env_actions'])) . '</td>
           </tr>';
$html27 .= '</table>';
$pdf->writeHTML($html27, true, false, true, false, '');
$pdf->Ln(5);

// ========== DECLARATION & SIGN OFF ==========
$html_declaration = '<h3 style="font-family: helvetica; font-weight: bold; margin-top: 15px; margin-bottom: 10px;">DECLARATION & SIGN OFF</h3>';
$html_declaration .= '<hr style="border: 0.5px solid #ccc; margin-bottom: 15px;">';
$html_declaration .= '<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
$html_declaration .= '<tr style="background-color: #d9e4f5;">
            <td colspan="2"><em>I confirm that the information on this questionnaire is correct, and that any changes which could affect product specifications, the HACCP plan or manufacture will be communicated to The Technical Department, at our site, immediately.</em></td>
           </tr>';
$html_declaration .= '<tr style="background-color: #ffffff;">
            <td width="33%"><strong>Completed by:</strong> ' . htmlspecialchars($main_data['dec_completed_by']) . '</td>
            <td width="33%"><strong>Completed on:</strong> ' . date('d-m-Y', strtotime($main_data['dec_completed_date'])) . '</td>
            <td width="34%"><strong>Position:</strong> ' . htmlspecialchars($main_data['dec_position']) . '</td>
           </tr>';
$html_declaration .= '<tr style="background-color: #f9f9f9;">
            <td><strong>Signature:</strong> ' . htmlspecialchars($main_data['dec_signature']) . '</td>
            <td><strong>Approved by:</strong> ' . htmlspecialchars($main_data['dec_approved_by']) . '</td>
            <td><strong>Approval Date:</strong> ' . date('d-m-Y', strtotime($main_data['dec_approval_date'])) . '</td>
           </tr>';
$html_declaration .= '</table>';
$pdf->writeHTML($html_declaration, true, false, true, false, '');
$pdf->Ln(5);

// ========== ATTACHMENTS CHECKLIST ==========

$clean_json = preg_replace('/<WebsiteContent_[^>]+>|<\/WebsiteContent_[^>]+>/', '', $main_data['attachments_checklist']);
$attachments = json_decode($clean_json, true);
print_r($attachments);
$html_attachments = '<h3 style="font-family: helvetica; font-weight: bold; margin-top: 15px; margin-bottom: 10px;">ATTACHMENTS CHECKLIST</h3>';
$html_attachments .= '<hr style="border: 0.5px solid #ccc; margin-bottom: 15px;">';


$html_attachments .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
$html_attachments .= '<tr style="background-color: #d9e4f5; font-weight: bold;">
                        <th width="80%">Document Description</th>
                        <th width="20%">Attached</th>
                      </tr>';// ✅ Correct closing

$att_list = [
    'att1' => 'Third Party Audit Report (Q2)',
    'att2' => 'Third Party Audit Certificate (Q2)',
    'att3' => 'HACCP Documents (Q2)',
    'att4' => 'Process Flow Diagram (Q2)',
    'att5' => 'Product liability/recall cover (Q21)',
    'att6' => 'Ethical Standards & MSA Policy (Q23)',
    'att7' => 'Product Traceability Exercise'
];

foreach($att_list as $key => $label){
    $checked = (isset($attachments[$key]) && !empty($attachments[$key])) ? '✓' : 'No';
    $color = (isset($attachments[$key]) && !empty($attachments[$key])) ? 'green' : 'red';
    $html_attachments .= '<tr style="background-color: #ffffff;">
                            <td>' . $label . '</td>
                            <td style="color: ' . $color . '; text-align: center; font-weight: bold;">' . $checked . '</td>
                          </tr>';
}

$html_attachments .= '</table>';
$pdf->writeHTML($html_attachments, true, false, true, false, '');
$pdf->Ln(5);

// ========== UPLOADED FILES SUMMARY ==========
if($files_data){
    $html_files = '<h3 style="font-family: helvetica; font-weight: bold; margin-top: 15px; margin-bottom: 10px;">UPLOADED DOCUMENTS</h3>';
    $html_files .= '<hr style="border: 0.5px solid #ccc; margin-bottom: 15px;">';
    
    $html_files .= '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
    $html_files .= '<tr style="background-color: #d9e4f5; font-weight: bold;">
                        <th width="40%">Document Type</th>
                        <th width="40%">File Name</th>
                        <th width="20%">Status</th>
                      </tr>';
    
    $file_fields = [
        'gfsi_docs' => 'GFSI Certificate & Audit Report',
        'traceability_files' => 'Traceability Files',
        'haccp_flow_ccp' => 'HACCP Process Flow & CCP Summary',
        'fsa_report' => 'FSA Audit Report',
        'fab_lumens_checks' => 'Light Lumens Checks',
        'tr_contact_list' => 'Contact List',
        'liability_doc' => 'Product Liability Insurance',
        'org_docs' => 'Organic Certificate',
        'feed_cert' => 'FEED Certificate',
        'claim_docs' => 'Claim Validation Studies',
        'all_attachments' => 'Other Attachments'
    ];
    
    foreach($file_fields as $field => $label){
        $file_value = $files_data[$field];
        if(!empty($file_value)){
            if(strpos($file_value, '[') === 0){
                // Multiple files (JSON array)
                $files_array = json_decode($file_value, true);
                if(is_array($files_array)){
                    foreach($files_array as $file){
                        $html_files .= '<tr style="background-color: #ffffff;">
                                            <td>' . $label . '</td>
                                            <td><a href="../uploads/' . $file . '" target="_blank">' . $file . '</a></td>
                                            <td style="color: green; font-weight: bold;">Uploaded</td>
                                          </tr>';
                    }
                }
            } else {
                // Single file
                $html_files .= '<tr style="background-color: #ffffff;">
                                    <td>' . $label . '</td>
                                    <td><a href="../uploads/' . $file_value . '" target="_blank">' . $file_value . '</a></td>
                                    <td style="color: green; font-weight: bold;">Uploaded</td>
                                  </tr>';
            }
        } else {
            $html_files .= '<tr style="background-color: #f9f9f9;">
                                <td>' . $label . '</td>
                                <td>-</td>
                                <td style="color: red; font-weight: bold;">Not Uploaded</td>
                              </tr>';
        }
    }
    
    $html_files .= '</table>';
    $pdf->writeHTML($html_files, true, false, true, false, '');
}
// Output PDF
$pdf->Output($_SERVER['DOCUMENT_ROOT'] . "pdf/supplier_audit_report_$id.pdf", "F");
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
<div class="main-content">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <a href="supplier_audit_list.php" class="btn float-right ml-2">Back</a>
                        <a href="pdf/supplier_audit_report_<?php echo $id; ?>.pdf" download class="btn float-right ml-2">Download PDF</a>
                    </div>
                </div>
                <div style="margin-top: 20px; clear: both;">
                    <iframe src="pdf/supplier_audit_report_<?php echo $id; ?>.pdf" frameborder="0"></iframe>
                </div>

            </div>
        </div>
    </div>
</div>
</body>
</html>