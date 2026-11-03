<?php
// guardar-progreso.php
// Recibe POST con curso, progreso y xp, actualiza la BD del usuario logueado.
session_start();

// Solo usuarios autenticados pueden guardar progreso
if (!isset($_SESSION['usuario_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'No autorizado']);
    exit();
}

include 'conexion.php';

// Cursos válidos (whitelist para evitar inyección de columna)
$cursos_validos = ['python', 'html', 'css', 'javascript', 'react', 'sql', 'git', 'cpp'];

$curso    = $_POST['curso']    ?? '';
$progreso = intval($_POST['progreso'] ?? 0);
$xp       = intval($_POST['xp']       ?? 0);

// Validar que el curso sea uno de los permitidos
if (!in_array($curso, $cursos_validos)) {
    http_response_code(400);
    echo json_encode(['error' => 'Curso inválido']);
    exit();
}

// Limitar valores a rangos seguros
$progreso    = max(0, min(100, $progreso));
$xp          = max(0, $xp);
$usuario_id  = intval($_SESSION['usuario_id']);
$campo       = "progreso_" . $curso; // Seguro porque $curso viene del whitelist

// Actualizamos solo si el nuevo progreso es mayor al guardado (GREATEST evita retrocesos)
// y sumamos XP al total acumulado del usuario
$sql  = "UPDATE usuarios SET {$campo} = GREATEST({$campo}, ?), xp = xp + ? WHERE id = ?";
$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, "iii", $progreso, $xp, $usuario_id);
$ok = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

if ($ok) {
    // Devolvemos el XP actualizado para que el JS pueda mostrarlo
    $stmt2 = mysqli_prepare($conexion, "SELECT xp, {$campo} as progreso FROM usuarios WHERE id = ?");
    mysqli_stmt_bind_param($stmt2, "i", $usuario_id);
    mysqli_stmt_execute($stmt2);
    mysqli_stmt_bind_result($stmt2, $xp_total, $progreso_actual);
    mysqli_stmt_fetch($stmt2);
    mysqli_stmt_close($stmt2);

    echo json_encode([
        'ok'       => true,
        'xp_total' => $xp_total,
        'progreso' => $progreso_actual
    ]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Error al guardar en BD']);
}
?>
