<?php
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $mensaje = trim($_POST['mensaje'] ?? '');

    if ($nombre === "" || $correo === "" || $mensaje === "") {
        echo "<script>alert('Por favor, completa todos los campos.'); window.history.back();</script>";
        exit();
    }

    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Por favor, ingresa un correo electrónico válido.'); window.history.back();</script>";
        exit();
    }

    $nombreEscapado = $conexion->real_escape_string($nombre);
    $correoEscapado = $conexion->real_escape_string($correo);
    $mensajeEscapado = $conexion->real_escape_string($mensaje);

    $sql = "INSERT INTO contactos (nombre, correo, mensaje) VALUES ('$nombreEscapado', '$correoEscapado', '$mensajeEscapado')";

    if ($conexion->query($sql) === TRUE) {
        echo "<script>alert('¡Mensaje enviado y guardado en la base de datos con éxito!'); window.location.href='index.php';</script>";
    } else {
        echo "Error al guardar: " . $conexion->error;
    }

    $conexion->close();
}
?>