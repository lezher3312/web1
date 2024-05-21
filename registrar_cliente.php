<?php
require 'phpqrcode/qrlib.php'; // Asegúrate de que la ruta es correcta

$servidor = "localhost";
$usuario = "root";
$contrasena = "33128841";
$base_datos = "panaderia_cola";

// Crear conexión
$conexion = new mysqli($servidor, $usuario, $contrasena, $base_datos);

// Verificar conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Obtener datos del formulario
$dpi = $_POST['dpi'];
$nombre = $_POST['nombre'];

// Obtener el último número de ticket
$resultado = $conexion->query("SELECT MAX(numero_ticket) AS ultimo_ticket FROM clientes");
$fila = $resultado->fetch_assoc();
$ultimo_ticket = $fila['ultimo_ticket'] ?? 0;
$numero_ticket = $ultimo_ticket + 1;

// Insertar nuevo cliente en la base de datos
$sql = "INSERT INTO clientes (dpi, nombre, numero_ticket) VALUES ('$dpi', '$nombre', $numero_ticket)";
if ($conexion->query($sql) === TRUE) {
    $fecha_creacion = date('Y-m-d H:i:s');

    // Generar el código QR
    $url_encuesta = 'http://' . $_SERVER['HTTP_HOST'] . '/encuesta.html';
    $ruta_qr = 'qr_tickets/ticket_' . $numero_ticket . '.png';
    QRcode::png($url_encuesta, $ruta_qr);

    $response = [
        'nombre_negocio' => 'Mi Panadería',
        'numero_ticket' => $numero_ticket,
        'nombre' => $nombre,
        'dpi' => $dpi,
        'fecha_creacion' => $fecha_creacion,
        'qr_ruta' => $ruta_qr
    ];
    echo json_encode($response);
} else {
    echo json_encode(['error' => 'Error al registrar el cliente']);
}

$conexion->close();
?>
