<?php 
require __DIR__ . "/../vendor/autoload.php";
require "../connect.php";

use Dompdf\Dompdf;
use Dompdf\Options;

// options
$options = new Options;
$options->setChroot(__DIR__);
$options->setIsRemoteEnabled(true);

$dompdf = new Dompdf($options);

ob_start();
require('details_med_clearance_nrml.php');
$html =ob_get_contents();
ob_get_clean();

$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream('details_med_clearance_nrml.php',['Attachment'=>false]);

/**
 * Save the PDF file locally
 */
$output = $dompdf->output();
file_put_contents("file.pdf", $output);
