<?php
include("auth_check.php");
include("conexion.php");

$id = intval($_GET['id'] ?? $_POST['id'] ?? 0);
if ($id <= 0) {
    header("Location: panel.php");
    exit();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre   = trim($_POST['nombre'] ?? '');
    $correo   = trim($_POST['correo'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $mensaje  = trim($_POST['mensaje'] ?? '');
    $estado   = ($_POST['estado'] === 'inactivo') ? 'inactivo' : 'activo';

    if ($nombre === "" || $correo === "" || $mensaje === "") {
        $error = "Todos los campos obligatorios deben completarse.";
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $error = "El formato del correo electrónico no es válido.";
    } else {
        $stmt = $conexion->prepare("UPDATE contactos SET nombre = ?, correo = ?, telefono = ?, mensaje = ?, estado = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $nombre, $correo, $telefono, $mensaje, $estado, $id);
        if ($stmt->execute()) {
            $stmt->close();
            header("Location: panel.php?msg=actualizado");
            exit();
        } else {
            $error = "Error al actualizar el registro: " . $conexion->error;
        }
    }
}

$stmt = $conexion->prepare("SELECT * FROM contactos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$registro = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$registro) {
    header("Location: panel.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Registro — ADA 6</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <header>
        <h1>Editar Registro (Operación UPDATE)</h1>
        <nav>
            <a href="panel.php">Volver al Panel</a>
            <a href="logout.php" class="btn-nav-danger">Cerrar Sesión</a>
        </nav>
    </header>

    <div class="container" style="max-width: 650px;">
        <div class="card">
            <h2>Modificar Registro #<?php echo $registro['id']; ?></h2>

            <?php if ($error !== ""): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form action="editar.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $registro['id']; ?>">
                <div class="form-group">
                    <label for="nombre">Nombre completo *</label>
                    <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($registro['nombre']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="correo">Correo electrónico *</label>
                    <input type="email" id="correo" name="correo" value="<?php echo htmlspecialchars($registro['correo']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($registro['telefono']); ?>">
                </div>
                <div class="form-group">
                    <label for="mensaje">Mensaje *</label>
                    <textarea id="mensaje" name="mensaje" rows="4" required><?php echo htmlspecialchars($registro['mensaje']); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="estado">Estado del registro</label>
                    <select id="estado" name="estado">
                        <option value="activo" <?php echo ($registro['estado'] === 'activo') ? 'selected' : ''; ?>>Activo</option>
                        <option value="inactivo" <?php echo ($registro['estado'] === 'inactivo') ? 'selected' : ''; ?>>Inactivo</option>
                    </select>
                </div>
                <div class="actions">
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    <a href="panel.php" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
