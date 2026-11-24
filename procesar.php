<?php
session_start();
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre   = trim($_POST['nombre'] ?? '');
    $correo   = trim($_POST['correo'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $mensaje  = trim($_POST['mensaje'] ?? '');
    $origen   = $_POST['origen'] ?? 'publico';

    // Validación de campos obligatorios
    if ($nombre === "" || $correo === "" || $mensaje === "") {
        $destino = ($origen === 'panel') ? "panel.php?error=campos" : "index.php?error=campos";
        header("Location: $destino");
        exit();
    }

    // Validación de correo electrónico
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $destino = ($origen === 'panel') ? "panel.php?error=correo" : "index.php?error=correo";
        header("Location: $destino");
        exit();
    }

    // Inserción segura mediante consulta preparada (CREATE)
    $stmt = $conexion->prepare("INSERT INTO contactos (nombre, correo, telefono, mensaje, estado) VALUES (?, ?, ?, ?, 'activo')");
    $stmt->bind_param("ssss", $nombre, $correo, $telefono, $mensaje);

    if ($stmt->execute()) {
        $stmt->close();
        $conexion->close();
        $destino = ($origen === 'panel') ? "panel.php?msg=creado" : "index.php?msg=creado";
        header("Location: $destino");
        exit();
    } else {
        echo "Error al guardar el registro: " . $conexion->error;
    }
}
?>
