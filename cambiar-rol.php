<?php
// cambiar-rol.php
// Solo el admin puede cambiar roles de usuario.
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.html");
    exit();
}

include 'conexion.php';

$roles_validos = ['estudiante', 'profesor', 'admin'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario_id = intval($_POST['usuario_id'] ?? 0);
    $nuevo_rol  = $_POST['nuevo_rol'] ?? '';

    if ($usuario_id <= 0 || !in_array($nuevo_rol, $roles_validos)) {
        header("Location: panel-admin.php?mensaje=datos_invalidos");
        exit();
    }

    // Evitar que el admin cambie su propio rol accidentalmente
    if ($usuario_id === intval($_SESSION['usuario_id'])) {
        header("Location: panel-admin.php?mensaje=no_automodificar");
        exit();
    }

    $stmt = mysqli_prepare($conexion, "UPDATE usuarios SET rol = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "si", $nuevo_rol, $usuario_id);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if ($ok) {
        header("Location: panel-admin.php?mensaje=rol_actualizado");
    } else {
        header("Location: panel-admin.php?mensaje=error_rol");
    }
    exit();
}

// Si alguien accede por GET, redirigir al panel
header("Location: panel-admin.php");
exit();
?>
