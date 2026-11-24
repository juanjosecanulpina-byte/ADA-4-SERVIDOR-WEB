<?php
// Configuración de conexión a MySQL (Local XAMPP / Hosting en línea)
$servidor = "localhost";
$usuario_db = "root";
$password_db = "";
$base_datos = "mi_sitio_db";

$conexion = new mysqli($servidor, $usuario_db, $password_db, $base_datos);

if ($conexion->connect_error) {
    die("Error de conexión a la base de datos: " . $conexion->connect_error);
}

$conexion->set_charset("utf8mb4");
?>
