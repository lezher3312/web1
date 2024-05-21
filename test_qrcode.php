<?php
require 'phpqrcode/qrlib.php';

// Directorio donde se guardarán los QR
$dir = 'qr_tickets/';
if (!file_exists($dir)) {
    mkdir($dir, 0777, true);
}

// Contenido del QR
$url_encuesta = 'http://' . $_SERVER['HTTP_HOST'] . '/encuesta.html';

// Generar el código QR
$archivo_qr = $dir . 'test_qr.png';
QRcode::png($url_encuesta, $archivo_qr);

echo 'Código QR generado: <a href="' . $archivo_qr . '" target="_blank">Ver QR</a>';
?>
