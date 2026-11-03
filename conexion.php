<?php
// Credenciales de la base de datos
// Protegido por .htaccess — nunca subir a GitHub
$servidor   = "sql107.infinityfree.com";
$usuario    = "if0_41275366";
$password   = "2pepas2kuromis";
$base_datos = "if0_41275366_dev_path";

$conexion = mysqli_connect($servidor, $usuario, $password, $base_datos);
mysqli_set_charset($conexion, "utf8");
if (!$conexion) {
    error_log("Error BD: " . mysqli_connect_error());
    die("Error al conectar con la base de datos. Intenta más tarde.");
}
?>
