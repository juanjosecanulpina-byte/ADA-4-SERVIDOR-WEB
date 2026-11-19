<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Sitio Web - ADA 4</title>
</head>
<body>
    <h1>Formulario de Contacto Local</h1>
    
    <form action="procesar.php" method="POST">
        <label for="nombre">Nombre:</label><br>
        <input type="text" id="nombre" name="nombre" required><br><br>

        <label for="correo">Correo Electrónico:</label><br>
        <input type="email" id="correo" name="correo" required><br><br>

        <label for="mensaje">Mensaje:</label><br>
        <textarea id="mensaje" name="mensaje" rows="4" required></textarea><br><br>

        <button type="submit">Enviar Mensaje</button>
    </form>
</body>
</html>