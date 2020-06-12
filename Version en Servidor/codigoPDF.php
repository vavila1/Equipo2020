<?php 
ob_start();
require "barcode.php";
$html = ob_get_clean();
// Jalamos las librerias de dompdf
require_once './dompdf/autoload.inc.php';
use Dompdf\Dompdf;
// Inicializamos dompdf
$dompdf = new Dompdf();
// Le pasamos el html a dompdf
$dompdf->loadHtml($html);
// Colocamos als propiedades de la hoja
$dompdf->setPaper("A4", "landscape");
// Escribimos el html en el PDF
$dompdf->render();
// Ponemos el PDF en el browser
$dompdf->stream();
?>