<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

// Create a new spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set header row
$headers = ['Name', 'Age'];
foreach ($headers as $column => $header) {
    $sheet->setCellValueByColumnAndRow($column + 1, 1, $header);
}

// Set data rows
$data = [
    ['Alice', 30],
    ['Bob', 25],
    ['Charlie', 40],
];
foreach ($data as $row => $rowData) {
    foreach ($rowData as $column => $value) {
        $sheet->setCellValueByColumnAndRow($column + 1, $row + 2, $value);
    }
}

// Save the spreadsheet to a file
$writer = new Xlsx($spreadsheet);
$writer->save('example.xlsx');

// Load the same file to read data
$spreadsheet = IOFactory::load('example.xlsx');
$sheet = $spreadsheet->getActiveSheet();
$data = $sheet->toArray();

// Output the data
echo "<pre>";
print_r($data);
echo "</pre>";
