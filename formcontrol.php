
 public function Footer()
  {
    
    $this->SetFont('centurygothic', '', 10);
    $this->SetTextColor(0, 0, 0);

    // Footer line

    // Custom footer HTML if set
    if (!empty($this->footerHTML)) {
      $this->SetY(-22);
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












$sqq = mysqli_query($con, "SELECT * FROM tblformcontrol WHERE id = '1'");
$roww = mysqli_fetch_assoc($sqq);
    // Assuming 'issue_date' and 'authorised_by' are columns in your table
    $issueDate = date('d/m/Y', strtotime($roww['issuedate'])); 
    
$pageNum = $pdf->getAliasNumPage();
$pageTotal = $pdf->getAliasNbPages(); // This will not resolve correctly


$footerContent = <<<EOD
<table border="1" cellpadding="5" width="100%">
    <tr>
        <td width="40%">Issue date: {$issueDate}</td>
        <td width="22%">Version No: {$roww['version']}</td>
        <td width="38%">Authorised by: {$roww['author']}</td>
    </tr>
    <tr>
        <td width="40%">Reason for change : {$roww['reason']}</td>
        <td width="22%">Page No: {$pageNum} of {$pageTotal}</td>
        <td width="38%">Authorised by: {$roww['authoriesby']}</td>
    </tr>
</table>
EOD;
