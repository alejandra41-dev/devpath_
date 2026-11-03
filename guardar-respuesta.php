<?php
// guardar-respuesta.php
// Guarda la respuesta de un desafio, suma XP y devuelve confirmacion JSON.
session_start();

if (!isset($_SESSION['usuario_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'No autorizado']);
    exit();
}

include 'conexion.php';

$usuario_id  = intval($_SESSION['usuario_id']);
$desafio_id  = intval($_POST['desafio_id'] ?? 0);
$respuesta   = trim($_POST['respuesta']    ?? '');

if ($desafio_id <= 0 || $respuesta === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Datos incompletos']);
    exit();
}

// Verificar que el desafio existe y obtener su XP recompensa
$stmt = mysqli_prepare($conexion, "SELECT xp_recompensa FROM desafios WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $desafio_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $xp_recompensa);
$encontrado = mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

if (!$encontrado) {
    http_response_code(404);
    echo json_encode(['error' => 'Desafío no encontrado']);
    exit();
}

// Verificar que el usuario no haya entregado ya este desafio
$stmt2 = mysqli_prepare($conexion, "SELECT id FROM desafios_respuestas WHERE usuario_id = ? AND desafio_id = ?");
mysqli_stmt_bind_param($stmt2, "ii", $usuario_id, $desafio_id);
mysqli_stmt_execute($stmt2);
mysqli_stmt_bind_result($stmt2, $respuesta_existente_id);
$ya_respondio = mysqli_stmt_fetch($stmt2);
mysqli_stmt_close($stmt2);

if ($ya_respondio) {
    echo json_encode(['ok' => true, 'mensaje' => 'Ya entregaste este desafío anteriormente.', 'xp_ganado' => 0]);
    exit();
}

// Guardar la respuesta
$stmt3 = mysqli_prepare($conexion, "INSERT INTO desafios_respuestas (usuario_id, desafio_id, respuesta) VALUES (?, ?, ?)");
mysqli_stmt_bind_param($stmt3, "iis", $usuario_id, $desafio_id, $respuesta);
$ok = mysqli_stmt_execute($stmt3);
mysqli_stmt_close($stmt3);

if (!$ok) {
    http_response_code(500);
    echo json_encode(['error' => 'Error al guardar respuesta']);
    exit();
}

// Sumar XP al usuario
$stmt4 = mysqli_prepare($conexion, "UPDATE usuarios SET xp = xp + ? WHERE id = ?");
mysqli_stmt_bind_param($stmt4, "ii", $xp_recompensa, $usuario_id);
mysqli_stmt_execute($stmt4);
mysqli_stmt_close($stmt4);

echo json_encode([
    'ok'        => true,
    'mensaje'   => '¡Misión completada! +' . $xp_recompensa . ' XP ganados.',
    'xp_ganado' => $xp_recompensa
]);
?>
