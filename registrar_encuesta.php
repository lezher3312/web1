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

// Obtener datos del formulario
