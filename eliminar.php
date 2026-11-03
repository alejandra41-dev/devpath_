<?php
session_start();

// Seguridad: Solo el administrador puede borrar usuarios
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.html");
    exit();
}

include 'conexion.php';

if (isset($_GET['id'])) {

    // ✅ SEGURIDAD: Prepared Statement procedural
    $stmt = mysqli_prepare($conexion, "DELETE FROM usuarios WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $_GET['id']);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        header("Location: panel-admin.php?mensaje=usuario_eliminado");
    } else {
        error_log("Error al eliminar usuario: " . mysqli_stmt_error($stmt));
        header("Location: panel-admin.php?mensaje=error_eliminar");
    }
    exit();
}
?>
