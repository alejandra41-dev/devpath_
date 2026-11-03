<?php
// panel-admin.php — Centro de control del administrador
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.html");
    exit();
}

include 'conexion.php';

// Mostrar mensajes de resultado de acciones previas
$mensaje_accion = '';
$mensajes_map = [
    'usuario_eliminado' => '✅ Usuario eliminado correctamente.',
    'rol_actualizado'   => '✅ Rol actualizado correctamente.',
    'error_eliminar'    => '❌ Error al eliminar el usuario.',
    'error_rol'         => '❌ Error al cambiar el rol.',
    'no_automodificar'  => '⚠️ No puedes cambiar tu propio rol desde aquí.',
    'datos_invalidos'   => '❌ Datos inválidos.',
];
if (isset($_GET['mensaje']) && array_key_exists($_GET['mensaje'], $mensajes_map)) {
    $mensaje_accion = $mensajes_map[$_GET['mensaje']];
}

// Estadísticas — prepared statements sin mysqli_stmt_get_result
$stmt = mysqli_prepare($conexion, "SELECT COUNT(*) FROM usuarios");
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $total_users);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

$stmt = mysqli_prepare($conexion, "SELECT COUNT(*) FROM usuarios WHERE rol = 'estudiante'");
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $total_estudiantes);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

$stmt = mysqli_prepare($conexion, "SELECT COUNT(*) FROM usuarios WHERE rol = 'profesor'");
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $total_profesores);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// Lista de usuarios — bind_result sin mysqlnd
$stmt = mysqli_prepare($conexion, "SELECT id, nombre, correo, rol, xp FROM usuarios ORDER BY id DESC");
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $u_id, $u_nombre, $u_correo, $u_rol, $u_xp);
$usuarios_lista = [];
while (mysqli_stmt_fetch($stmt)) {
    $usuarios_lista[] = [
        'id'     => $u_id,
        'nombre' => $u_nombre,
        'correo' => $u_correo,
        'rol'    => $u_rol,
        'xp'     => $u_xp,
    ];
}
mysqli_stmt_close($stmt);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Admin - Dev Path</title>
    <link rel="icon" type="image/png" href="media/img/logos.png">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/paneles.css">
    <style>
        .form-rol {
            display: inline-flex; gap: 0.4rem; align-items: center;
        }
        .form-rol select {
            padding: 0.3rem 0.5rem; border-radius: 6px;
            background: #1a1a2e; color: white;
            border: 1px solid rgba(255,255,255,0.2);
            font-size: 0.85rem;
        }
        .btn-cambiar-rol {
            padding: 0.3rem 0.8rem;
            background: var(--accent-blue, #3498db);
            color: white; border: none; border-radius: 6px;
            cursor: pointer; font-size: 0.8rem; font-weight: bold;
        }
        .btn-cambiar-rol:hover { opacity: 0.85; }
        .alerta-accion {
            padding: 0.8rem 1.2rem; border-radius: 8px;
            margin-bottom: 1.5rem; font-weight: bold;
        }
        .alerta-ok  { background: rgba(46,213,115,0.15); border: 1px solid #2ed573; color: #2ed573; }
        .alerta-err { background: rgba(255,71,87,0.15);  border: 1px solid #ff4757; color: #ff4757; }
        .alerta-warn { background: rgba(255,165,0,0.15); border: 1px solid orange;  color: orange; }
    </style>
</head>
<body>
    <header>
        <div class="logo-container">
            <img src="media/img/logos.png" alt="Dev Path Logo">
            <div class="logo-text">Dev<br><span>Path</span></div>
        </div>
        <nav class="nav-links">
            <a href="panel-admin.php" class="activo">Control Global</a>
            <a href="logout.php" class="btn-ingresar" style="background: #ff4757;">Cerrar Sesión</a>
        </nav>
    </header>

    <main class="panel-container">
        <h1>Centro de Control Maestro</h1>

        <?php if ($mensaje_accion): ?>
        <?php
        $clase_alerta = 'alerta-ok';
        if (strpos($mensaje_accion, '❌') !== false) $clase_alerta = 'alerta-err';
        if (strpos($mensaje_accion, '⚠️') !== false) $clase_alerta = 'alerta-warn';
        ?>
        <div class="alerta-accion <?php echo $clase_alerta; ?>">
            <?php echo htmlspecialchars($mensaje_accion); ?>
        </div>
        <?php endif; ?>

        <!-- Stats generales -->
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Usuarios</h3>
                <p class="stat-number"><?php echo intval($total_users); ?></p>
            </div>
            <div class="stat-card">
                <h3>Estudiantes</h3>
                <p class="stat-number"><?php echo intval($total_estudiantes); ?></p>
            </div>
            <div class="stat-card">
                <h3>Profesores</h3>
                <p class="stat-number"><?php echo intval($total_profesores); ?></p>
            </div>
        </div>

        <!-- Tabla de gestión de usuarios -->
        <section class="tabla-gestion">
            <h2>Gestión de Habitantes</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol Actual</th>
                        <th>XP</th>
                        <th>Cambiar Rol</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios_lista as $user): ?>
                    <tr>
                        <td>#<?php echo intval($user['id']); ?></td>
                        <td><?php echo htmlspecialchars($user['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($user['correo']); ?></td>
                        <td>
                            <span class="rol-tag <?php echo htmlspecialchars($user['rol']); ?>">
                                <?php echo htmlspecialchars($user['rol']); ?>
                            </span>
                        </td>
                        <td>⭐ <?php echo intval($user['xp']); ?></td>
                        <td>
                            <!-- Formulario inline para cambiar rol (POST a cambiar-rol.php) -->
                            <form method="POST" action="cambiar-rol.php" class="form-rol">
                                <input type="hidden" name="usuario_id" value="<?php echo intval($user['id']); ?>">
                                <select name="nuevo_rol" aria-label="Nuevo rol">
                                    <option value="estudiante" <?php echo $user['rol'] === 'estudiante' ? 'selected' : ''; ?>>Estudiante</option>
                                    <option value="profesor"   <?php echo $user['rol'] === 'profesor'   ? 'selected' : ''; ?>>Profesor</option>
                                    <option value="admin"      <?php echo $user['rol'] === 'admin'      ? 'selected' : ''; ?>>Admin</option>
                                </select>
                                <button type="submit" class="btn-cambiar-rol">Cambiar</button>
                            </form>
                        </td>
                        <td>
                            <a href="eliminar.php?id=<?php echo intval($user['id']); ?>"
                               class="btn-eliminar"
                               onclick="return confirm('¿Eliminar a <?php echo htmlspecialchars(addslashes($user['nombre'])); ?>?')">
                               Eliminar
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>
