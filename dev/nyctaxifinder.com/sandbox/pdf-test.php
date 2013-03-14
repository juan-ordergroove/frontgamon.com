<?php
require(PHP_DEV . 'lib/fpdf/fpdf.php');

$pdf=new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'Hello World!');
$pdf->Output('/var/www/dev/nyctaxifinder.com/pdf/pdf-test.pdf', 'F');
?>
