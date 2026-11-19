<?php
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $conexion->real_escape_string($_POST['nombre']);
    $correo = $conexion->real_escape_string($_POST['correo']);
    $mensaje = $conexion->real_escape_string($_POST['mensaje']);

    $sql = "INSERT INTO contactos (nombre, correo, mensaje) VALUES ('$nombre', '$correo', '$mensaje')";

    if ($conexion->query($sql) === TRUE) {
        echo "<script>alert('¡Mensaje enviado y guardado en la base de datos con éxito!'); window.location.href='index.php';</script>";
    } else {
        echo "Error al guardar: " . $conexion->error;
    }

    $conexion->close();
}
?>