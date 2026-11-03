<?php
// registro-admin.php — solo para ADMINS
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre   = trim($_POST['nombre']);
    $correo   = trim($_POST['correo']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $rol      = 'admin'; // fijo en el servidor

    $stmt = mysqli_prepare($conexion,
        "INSERT INTO usuarios (nombre, correo, password, rol) VALUES (?, ?, ?, ?)"
    );
    mysqli_stmt_bind_param($stmt, "ssss", $nombre, $correo, $password, $rol);

    if (mysqli_stmt_execute($stmt)) {
        session_start();
        $_SESSION['usuario_id'] = mysqli_stmt_insert_id($stmt);
        $_SESSION['nombre']     = $nombre;
        $_SESSION['rol']        = $rol;
        mysqli_stmt_close($stmt);
        header("Location: panel-admin.php");
        exit();
    } else {
        error_log("Error en registro admin: " . mysqli_stmt_error($stmt));
        header("Location: registroa.html?error=registro_fallido");
        exit();
    }
}
?>
