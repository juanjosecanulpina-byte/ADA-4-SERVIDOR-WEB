<?php
include("auth_check.php");
include("conexion.php");

$id = intval($_GET['id'] ?? 0);
$accion = $_GET['accion'] ?? 'desactivar';

if ($id > 0) {
    if ($accion === 'borrar') {
        $stmt = $conexion->prepare("DELETE FROM contactos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        header("Location: panel.php?msg=eliminado");
        exit();
    } else {
        $stmt = $conexion->prepare("UPDATE contactos SET estado = 'inactivo' WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        header("Location: panel.php?msg=desactivado");
        exit();
    }
}

header("Location: panel.php");
exit();
?>
