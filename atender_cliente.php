<?php
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

// Obtener id del cliente
$id_cliente = $_POST['id'];

// Actualizar estado del cliente a 'atendido'
$sql = "UPDATE clientes SET estado = 'atendido' WHERE id = $id_cliente";

if ($conexion->query($sql) === TRUE) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $conexion->error]);
}

$conexion->close();
?>
