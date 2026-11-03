<?php
session_start();
// Destruye todas las variables de sesión en el servidor
session_unset(); 
session_destroy();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cerrando sesión...</title>
</head>
<body>
    <script>
        // También limpiamos la "llave" del navegador que usamos para JS
        localStorage.removeItem('usuario_logueado');
        // Redirigimos al index
        window.location.href = 'index.php';
    </script>
</body>
</html>