<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Sitio Web - Proyecto Integrador ADA 6</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <header>
        <h1>MI SITIO WEB — Proyecto Integrador</h1>
        <nav>
            <a href="index.php">Inicio</a>
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <a href="panel.php" class="btn-nav-primary">Panel CRUD (<?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?>)</a>
                <a href="logout.php" class="btn-nav-danger">Cerrar Sesión</a>
            <?php else: ?>
                <a href="login.php" class="btn-nav-primary">Iniciar Sesión</a>
            <?php endif; ?>
        </nav>
    </header>

    <div class="container">
        <div class="card">
            <h2>Bienvenido a nuestro Portal Web</h2>
            <p>Este sitio web evoluciona el proyecto integrador incorporando gestión completa de registros mediante operaciones <strong>CRUD (Create, Read, Update, Delete)</strong>, base de datos relacional en MySQL y <strong>autenticación de usuarios mediante sesiones</strong> en PHP.</p>
        </div>

        <div class="card">
            <h2>Formulario de Registro / Contacto (Operación CREATE)</h2>
            <p style="margin-bottom: 1rem; color: #475569;">Completa los siguientes datos para registrar una solicitud o mensaje en la base de datos.</p>

            <?php if (isset($_GET['msg']) && $_GET['msg'] === 'creado'): ?>
                <div class="alert alert-success">¡Registro guardado exitosamente en la base de datos!</div>
            <?php elseif (isset($_GET['error'])): ?>
                <div class="alert alert-error">Por favor verifica que todos los campos obligatorios estén completos y el correo sea válido.</div>
            <?php endif; ?>

            <form action="procesar.php" method="POST">
                <input type="hidden" name="origen" value="publico">
                <div class="form-group">
                    <label for="nombre">Nombre completo *</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Ej. Juan José Canul Piña" required>
                </div>
                <div class="form-group">
                    <label for="correo">Correo electrónico *</label>
                    <input type="email" id="correo" name="correo" placeholder="correo@ejemplo.com" required>
                </div>
                <div class="form-group">
                    <label for="telefono">Teléfono (opcional)</label>
                    <input type="text" id="telefono" name="telefono" placeholder="Ej. 9991234567">
                </div>
                <div class="form-group">
                    <label for="mensaje">Mensaje o detalle de solicitud *</label>
                    <textarea id="mensaje" name="mensaje" rows="4" placeholder="Escribe aquí tu mensaje..." required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Guardar Registro</button>
            </form>
        </div>
    </div>

    <footer>
        Construcción de Software — ADA 6 | Desarrollado por Juan José Canul Piña
    </footer>
</body>
</html>
