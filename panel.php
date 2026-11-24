<?php
include("auth_check.php");
include("conexion.php");

$filtro = $_GET['filtro'] ?? 'todos';
if ($filtro === 'activos') {
    $sql = "SELECT * FROM contactos WHERE estado = 'activo' ORDER BY id DESC";
} elseif ($filtro === 'inactivos') {
    $sql = "SELECT * FROM contactos WHERE estado = 'inactivo' ORDER BY id DESC";
} else {
    $sql = "SELECT * FROM contactos ORDER BY id DESC";
}
$resultado = $conexion->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel CRUD — ADA 6</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <header>
        <h1>Panel Administrativo CRUD</h1>
        <nav>
            <span style="font-size: 0.9rem; color: #fde68a;">Sesión: <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?></span>
            <a href="index.php">Sitio Público</a>
            <a href="logout.php" class="btn-nav-danger">Cerrar Sesión</a>
        </nav>
    </header>

    <div class="container">
        <?php if (isset($_GET['msg'])): ?>
            <div class="alert alert-success">
                <?php
                if ($_GET['msg'] === 'creado') echo "Registro creado exitosamente.";
                elseif ($_GET['msg'] === 'actualizado') echo "Registro actualizado correctamente.";
                elseif ($_GET['msg'] === 'desactivado') echo "Registro desactivado correctamente (baja lógica).";
                elseif ($_GET['msg'] === 'eliminado') echo "Registro eliminado permanentemente.";
                ?>
            </div>
        <?php endif; ?>

        <!-- SECCIÓN CREATE DESDE PANEL -->
        <div class="card">
            <h2>Registrar Nuevo Contacto (CREATE)</h2>
            <form action="procesar.php" method="POST" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); gap: 0.8rem; align-items: end;">
                <input type="hidden" name="origen" value="panel">
                <div>
                    <label>Nombre *</label>
                    <input type="text" name="nombre" required placeholder="Nombre completo">
                </div>
                <div>
                    <label>Correo *</label>
                    <input type="email" name="correo" required placeholder="correo@dominio.com">
                </div>
                <div>
                    <label>Teléfono</label>
                    <input type="text" name="telefono" placeholder="9990000000">
                </div>
                <div>
                    <label>Mensaje *</label>
                    <input type="text" name="mensaje" required placeholder="Detalle o comentario">
                </div>
                <div>
                    <button type="submit" class="btn btn-success" style="width: 100%;">+ Agregar</button>
                </div>
            </form>
        </div>

        <!-- SECCIÓN READ + ACCIONES UPDATE Y DELETE -->
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem;">
                <h2 style="border: none; margin: 0;">Registros Almacenados (READ / UPDATE / DELETE)</h2>
                <div>
                    <a href="panel.php?filtro=todos" class="btn btn-secondary btn-sm">Todos</a>
                    <a href="panel.php?filtro=activos" class="btn btn-success btn-sm">Activos</a>
                    <a href="panel.php?filtro=inactivos" class="btn btn-warning btn-sm">Inactivos</a>
                </div>
            </div>

            <div style="overflow-x: auto;">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Teléfono</th>
                            <th>Mensaje</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($resultado && $resultado->num_rows > 0): ?>
                            <?php while ($fila = $resultado->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $fila['id']; ?></td>
                                    <td><?php echo htmlspecialchars($fila['nombre']); ?></td>
                                    <td><?php echo htmlspecialchars($fila['correo']); ?></td>
                                    <td><?php echo htmlspecialchars($fila['telefono']); ?></td>
                                    <td><?php echo htmlspecialchars($fila['mensaje']); ?></td>
                                    <td>
                                        <span class="badge <?php echo ($fila['estado'] === 'activo') ? 'badge-activo' : 'badge-inactivo'; ?>">
                                            <?php echo ucfirst($fila['estado']); ?>
                                        </span>
                                    </td>
                                    <td class="actions">
                                        <a href="editar.php?id=<?php echo $fila['id']; ?>" class="btn btn-primary btn-sm">Editar</a>
                                        <?php if ($fila['estado'] === 'activo'): ?>
                                            <a href="eliminar.php?id=<?php echo $fila['id']; ?>&accion=desactivar" class="btn btn-warning btn-sm" onclick="return confirm('¿Deseas desactivar este registro?');">Desactivar</a>
                                        <?php endif; ?>
                                        <a href="eliminar.php?id=<?php echo $fila['id']; ?>&accion=borrar" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar permanentemente este registro?');">Eliminar</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" style="text-align: center; color: #64748b;">No hay registros disponibles con este filtro.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
