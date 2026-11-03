<?php
// perfil.php — Perfil del usuario con progreso, XP y nivel calculado
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit();
}

include 'conexion.php';
$usuario_id = intval($_SESSION['usuario_id']);

// Consulta con prepared statement — sin interpolación directa de $id
// Nota: progreso_html en adelante pueden no existir si no se ejecutó setup.sql;
// se devuelven como 0 por DEFAULT en la BD si existen, o NULL si aún no existen.
$stmt = mysqli_prepare($conexion,
    "SELECT nombre, correo, rol, xp,
            progreso_python, progreso_html, progreso_css,
            progreso_javascript, progreso_react, progreso_sql,
            progreso_git, progreso_cpp
     FROM usuarios WHERE id = ?"
);
mysqli_stmt_bind_param($stmt, "i", $usuario_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt,
    $nombre, $correo, $rol, $xp,
    $prog_python, $prog_html, $prog_css,
    $prog_js, $prog_react, $prog_sql,
    $prog_git, $prog_cpp
);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);
$foto_perfil = null; // La columna foto_perfil se añade con setup.sql

// Calcular nivel según XP acumulado
$xp = intval($xp);
if ($xp >= 3500) {
    $nivel = 4; $nivel_nombre = 'Maestro Espacial';   $nivel_min = 3500; $nivel_max = 9999;
} elseif ($xp >= 1500) {
    $nivel = 3; $nivel_nombre = 'Explorador Avanzado'; $nivel_min = 1500; $nivel_max = 3499;
} elseif ($xp >= 500) {
    $nivel = 2; $nivel_nombre = 'Astronauta';          $nivel_min = 500;  $nivel_max = 1499;
} else {
    $nivel = 1; $nivel_nombre = 'Cadete';              $nivel_min = 0;    $nivel_max = 499;
}

// Porcentaje de progreso hacia el siguiente nivel
$rango       = $nivel_max - $nivel_min;
$xp_en_nivel = $xp - $nivel_min;
$pct_nivel   = ($nivel < 4) ? min(100, round($xp_en_nivel / $rango * 100)) : 100;

// Cursos y su progreso (clave BD => etiqueta visual)
$cursos = [
    'python'     => ['nombre' => 'Python Básico',     'progreso' => intval($prog_python)],
    'html'       => ['nombre' => 'Estructura HTML',    'progreso' => intval($prog_html)],
    'css'        => ['nombre' => 'Estilos CSS',        'progreso' => intval($prog_css)],
    'javascript' => ['nombre' => 'JavaScript Core',    'progreso' => intval($prog_js)],
    'react'      => ['nombre' => 'React JS',           'progreso' => intval($prog_react)],
    'sql'        => ['nombre' => 'Bases de Datos SQL', 'progreso' => intval($prog_sql)],
    'git'        => ['nombre' => 'Git & GitHub',       'progreso' => intval($prog_git)],
    'cpp'        => ['nombre' => 'C++',                'progreso' => intval($prog_cpp)],
];

$foto = $foto_perfil ? htmlspecialchars($foto_perfil) : 'media/img/peppa.png';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - Dev Path</title>
    <link rel="icon" type="image/png" href="media/img/logos.png">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/perfil.css">
    <style>
        /* Contador animado de XP */
        .xp-contador {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #f9ca24, #f0932b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
        }
        .nivel-barra-bg {
            background: rgba(255,255,255,0.1);
            border-radius: 8px;
            height: 12px;
            margin: 0.5rem 0 0.3rem;
            overflow: hidden;
        }
        .nivel-barra-fill {
            height: 100%;
            background: linear-gradient(90deg, #f9ca24, #f0932b);
            border-radius: 8px;
            transition: width 1s ease;
        }
        .badge-completado {
            display: inline-block;
            padding: 0.15rem 0.6rem;
            background: rgba(46,213,115,0.2);
            color: #2ed573;
            border: 1px solid #2ed573;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: bold;
        }
        .foto-perfil-container {
            position: relative;
            display: inline-block;
        }
        .cambiar-foto-label {
            position: absolute;
            bottom: 0; right: 0;
            background: var(--accent-blue, #3498db);
            border-radius: 50%;
            width: 32px; height: 32px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

    <header>
        <a href="index.php" class="logo-container">
            <img src="media/img/logos.png" alt="Dev Path Logo">
            <div class="logo-text">Dev<br><span>Path</span></div>
        </a>
        <nav class="nav-links">
            <a href="aprender.php">Aprender</a>
            <a href="perfil.php" class="activo">Mi Perfil</a>
            <a href="logout.php" class="btn-ingresar" style="background: #ff4757;">Cerrar Sesión</a>
        </nav>
    </header>

    <main class="perfil-main">
        <div class="perfil-card">

            <!-- Cabecera: avatar, nombre y rol -->
            <div class="perfil-header">
                <div class="avatar-container foto-perfil-container">
                    <img src="<?php echo $foto; ?>" alt="Avatar" id="img-avatar">
                </div>
                <h1>¡Hola, <?php echo htmlspecialchars($nombre); ?>!</h1>
                <span class="badge-rol"><?php echo ucfirst(htmlspecialchars($rol)); ?></span>
            </div>

            <!-- Stats: XP y nivel -->
            <div class="perfil-stats">
                <div class="stat-item">
                    <!-- El contador se anima desde 0 hasta el XP real con JS -->
                    <span class="xp-contador" id="xp-counter" data-xp="<?php echo $xp; ?>">0</span>
                    <span class="stat-label">XP Total</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">Nivel <?php echo $nivel; ?></span>
                    <span class="stat-label"><?php echo htmlspecialchars($nivel_nombre); ?></span>
                </div>
            </div>

            <!-- Barra de nivel -->
            <div style="padding: 0 1rem 1rem;">
                <small>Progreso al siguiente nivel: <?php echo $pct_nivel; ?>%</small>
                <div class="nivel-barra-bg">
                    <div class="nivel-barra-fill" style="width: <?php echo $pct_nivel; ?>%;"></div>
                </div>
                <?php if ($nivel < 4): ?>
                <small style="opacity:0.7;"><?php echo $xp; ?> / <?php echo $nivel_max + 1; ?> XP para Nivel <?php echo $nivel + 1; ?></small>
                <?php else: ?>
                <small style="color: #f9ca24;">¡Nivel máximo alcanzado! ⭐</small>
                <?php endif; ?>
            </div>

            <!-- Progreso por cursos -->
            <div class="perfil-progreso">
                <h3>Tu Progreso en Cursos</h3>
                <?php foreach ($cursos as $key => $curso): ?>
                <div class="curso-stat">
                    <span><?php echo htmlspecialchars($curso['nombre']); ?></span>
                    <div class="barra-mini-bg">
                        <div class="barra-mini-fill" style="width: <?php echo $curso['progreso']; ?>%;"></div>
                    </div>
                    <div style="display:flex; align-items:center; gap:0.5rem; min-width:80px; justify-content:flex-end;">
                        <span><?php echo $curso['progreso']; ?>%</span>
                        <?php if ($curso['progreso'] >= 100): ?>
                        <span class="badge-completado">Completado</span>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

        </div>
    </main>

    <script>
    // Contador animado de XP (cuenta de 0 hasta el valor real)
    (function animarXP() {
        const el      = document.getElementById('xp-counter');
        if (!el) return;
        const target  = parseInt(el.getAttribute('data-xp')) || 0;
        const duracion = 1500; // ms
        const paso     = Math.ceil(target / (duracion / 16));
        let actual     = 0;

        const timer = setInterval(() => {
            actual = Math.min(actual + paso, target);
            el.textContent = actual.toLocaleString();
            if (actual >= target) clearInterval(timer);
        }, 16);
    })();
    </script>

</body>
</html>
