<?php
session_start();
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $correo  = trim($_POST['correo']);
    $password = $_POST['password'];

    // ✅ Prepared Statement sin mysqli_stmt_get_result (InfinityFree no tiene mysqlnd)
    $stmt = mysqli_prepare($conexion, "SELECT id, nombre, rol, password FROM usuarios WHERE correo = ?");
    mysqli_stmt_bind_param($stmt, "s", $correo);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id, $nombre, $rol, $hash);
    $encontrado = mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    $usuario = $encontrado ? ['id' => $id, 'nombre' => $nombre, 'rol' => $rol, 'password' => $hash] : null;

    if ($usuario && password_verify($password, $usuario['password'])) {

        session_regenerate_id(true);

        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['nombre']     = $usuario['nombre'];
        $_SESSION['rol']        = $usuario['rol'];

        if ($usuario['rol'] === 'admin') {
            header("Location: panel-admin.php");
        } elseif ($usuario['rol'] === 'profesor') {
            header("Location: panel-profesor.php");
        } else {
            header("Location: aprender.php");
        }
        exit();

    } else {
        header("Location: login.html?error=incorrecto");
        exit();
    }
}
?>
