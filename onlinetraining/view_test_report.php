<?php
require __DIR__.'/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;

// Initialize Html2Pdf with A4 size
$html2pdf = new Html2Pdf('P', 'A4', 'en', true, 'UTF-8', array(10, 15, 10, 15));

ob_start();
include('make_report.php');
$html_code = ob_get_clean();

// Add your inline CSS styles
$html_code .= '<style>
                table {
                    width: 100%;
                    margin: 0 auto;
                    border-collapse: collapse;
                    background-color:white;
                }
                td {
                    padding: 13px;
                   
                    width: 300px;
                    font-size: 15px;
                    text-align:left;
                    height: 20px;
                }
                    img{
                    height:100px;
                    width: 100px;
                    }
                    .a{
                    width: 55px;
                    height: 0px;
                   
                    }
                    .b{
                    width: 545px;
                     height:0px;
                    
                    }
                     .aa{
                    width: 100px;
                     height:5px;

                    }
                    .bb{
                    width: 500px;
                     height: 5px;
                    }
                    .light-logo{
                    height:auto;
                    width:auto;
                    }
                    
               </style>';

$html2pdf->writeHTML($html_code);
$html2pdf->output();
?>
