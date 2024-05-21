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

// Obtener lista de clientes en espera
$resultado = $conexion->query("SELECT id, numero_ticket, nombre FROM clientes WHERE estado = 'esperando' ORDER BY numero_ticket");

if ($resultado->num_rows > 0) {
    echo '<table class="table table-striped">';
    echo '<thead><tr><th>Ticket</th><th>Nombre</th><th>Acción</th></tr></thead>';
    echo '<tbody>';
    while ($fila = $resultado->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $fila['numero_ticket'] . '</td>';
        echo '<td>' . $fila['nombre'] . '</td>';
        echo '<td><button class="btn btn-success" onclick="atenderCliente(' . $fila['id'] . ')">Atender</button></td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
} else {
    echo '<div class="alert alert-info" role="alert">No hay clientes en espera.</div>';
}

$conexion->close();
?>
