<?php
// panel-profesor.php — Panel del profesor: subir tutoriales, crear desafíos, ver alumnos
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'profesor') {
    header("Location: login.html");
    exit();
}

include 'conexion.php';
$profesor_id = intval($_SESSION['usuario_id']);

// Mensajes de acción previa
$mensaje     = '';
$mensajes_map = [
    'tutorial_ok'    => '✅ Tutorial publicado correctamente.',
    'desafio_ok'     => '✅ Desafío creado correctamente.',
    'error_tutorial' => '❌ Error al guardar el tutorial.',
    'error_desafio'  => '❌ Error al guardar el desafío.',
];
if (isset($_GET['msg']) && array_key_exists($_GET['msg'], $mensajes_map)) {
    $mensaje = $mensajes_map[$_GET['msg']];
}

// ---------------------------------------------------------------
// Procesar POST: nuevo tutorial o nuevo desafío
// ---------------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {

    // NUEVO TUTORIAL
    if ($_POST['accion'] === 'nuevo_tutorial') {
        $titulo      = trim($_POST['titulo']      ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $url_video   = trim($_POST['url_video']   ?? '');
        $categoria   = trim($_POST['categoria']   ?? '');

        if ($titulo !== '' && $url_video !== '') {
            $stmt = mysqli_prepare($conexion,
                "INSERT INTO tutoriales (titulo, descripcion, url_video, categoria, profesor_id) VALUES (?,?,?,?,?)"
            );
            // s=string (x4), i=int (profesor_id)
            mysqli_stmt_bind_param($stmt, "ssssi", $titulo, $descripcion, $url_video, $categoria, $profesor_id);
            $ok = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            header("Location: panel-profesor.php?msg=" . ($ok ? 'tutorial_ok' : 'error_tutorial'));
            exit();
        }
    }

    // NUEVO DESAFÍO
    if ($_POST['accion'] === 'nuevo_desafio') {
        $titulo        = trim($_POST['titulo']        ?? '');
        $descripcion   = trim($_POST['descripcion']   ?? '');
        $lenguaje      = trim($_POST['lenguaje']      ?? '');
        $dificultad    = $_POST['dificultad']          ?? 'facil';
        $xp_recompensa = intval($_POST['xp_recompensa'] ?? 100);
        $xp_minimo     = intval($_POST['xp_minimo']     ?? 0);

        $dificultades_validas = ['facil', 'medio', 'dificil'];

        if ($titulo !== '' && in_array($dificultad, $dificultades_validas)) {
            $stmt = mysqli_prepare($conexion,
                "INSERT INTO desafios (titulo, descripcion, lenguaje, dificultad, xp_recompensa, xp_minimo, profesor_id)
                 VALUES (?,?,?,?,?,?,?)"
            );
            // s=titulo, s=descripcion, s=lenguaje, s=dificultad, i=xp_recompensa, i=xp_minimo, i=profesor_id
            mysqli_stmt_bind_param($stmt, "ssssiii",
                $titulo, $descripcion, $lenguaje, $dificultad,
                $xp_recompensa, $xp_minimo, $profesor_id
            );
            $ok = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            header("Location: panel-profesor.php?msg=" . ($ok ? 'desafio_ok' : 'error_desafio'));
            exit();
        }
    }
}

// ---------------------------------------------------------------
// Cargar lista de estudiantes con todos los progresos de cursos
// ---------------------------------------------------------------
$stmt_alumnos = mysqli_prepare($conexion,
    "SELECT nombre, correo, xp,
            progreso_python, progreso_html, progreso_css,
            progreso_javascript, progreso_react, progreso_sql,
            progreso_git, progreso_cpp
     FROM usuarios WHERE rol = 'estudiante' ORDER BY xp DESC"
);
mysqli_stmt_execute($stmt_alumnos);
mysqli_stmt_bind_result($stmt_alumnos,
    $a_nombre, $a_correo, $a_xp,
    $a_python, $a_html, $a_css,
    $a_js, $a_react, $a_sql,
    $a_git, $a_cpp
);
$alumnos = [];
while (mysqli_stmt_fetch($stmt_alumnos)) {
    $alumnos[] = [
        'nombre' => $a_nombre, 'correo' => $a_correo, 'xp'     => $a_xp,
        'python' => $a_python, 'html'   => $a_html,   'css'    => $a_css,
        'js'     => $a_js,     'react'  => $a_react,  'sql'    => $a_sql,
        'git'    => $a_git,    'cpp'    => $a_cpp,
    ];
}
mysqli_stmt_close($stmt_alumnos);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Profesor - Dev Path</title>
    <link rel="icon" type="image/png" href="media/img/logos.png">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/paneles.css">
    <style>
        .secciones-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 3rem; }
        @media (max-width: 800px) { .secciones-grid { grid-template-columns: 1fr; } }
        .form-panel {
            background: rgba(255,255,255,0.05);
            border-radius: 12px; padding: 1.5rem;
            border: 1px solid rgba(255,255,255,0.1);
        }
        .form-panel h2 { margin-top: 0; font-size: 1rem; color: var(--accent-blue, #3498db); }
        .form-panel label { display: block; margin: 0.8rem 0 0.3rem; font-size: 0.9rem; opacity: 0.8; }
        .form-panel input,
        .form-panel textarea,
        .form-panel select {
            width: 100%; padding: 0.6rem; border-radius: 6px;
            background: #0a0a1a; color: white;
            border: 1px solid rgba(255,255,255,0.2);
            font-size: 0.9rem; box-sizing: border-box;
        }
        .form-panel textarea { min-height: 80px; resize: vertical; }
        .btn-form {
            margin-top: 1rem; width: 100%; padding: 0.8rem;
            background: linear-gradient(135deg, #6c5ce7, #a29bfe);
            color: white; border: none; border-radius: 8px;
            font-weight: bold; cursor: pointer; font-size: 1rem;
        }
        .btn-form:hover { opacity: 0.9; }
        .alerta { padding: 0.8rem 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-weight: bold; }
        .alerta-ok  { background: rgba(46,213,115,0.15); border: 1px solid #2ed573; color: #2ed573; }
        .alerta-err { background: rgba(255,71,87,0.15);  border: 1px solid #ff4757; color: #ff4757; }
        .barra-mini-cell { width: 70px; height: 8px; background: rgba(255,255,255,0.1); border-radius: 4px; display:inline-block; vertical-align:middle; overflow:hidden; }
        .barra-mini-inner { height:100%; background: linear-gradient(90deg,#6c5ce7,#a29bfe); border-radius:4px; }
        table { font-size: 0.82rem; }
    </style>
</head>
<body>
    <header>
        <div class="logo-container">
            <img src="media/img/logos.png" alt="Dev Path Logo">
            <div class="logo-text">Dev<br><span>Path</span></div>
        </div>
        <nav class="nav-links">
            <a href="panel-profesor.php" class="activo">Mi Panel</a>
            <a href="logout.php" class="btn-ingresar" style="background: #ff4757;">Cerrar Sesión</a>
        </nav>
    </header>

    <main class="panel-container">

        <section class="bienvenida">
            <h1>Bienvenido, Prof. <?php echo htmlspecialchars($_SESSION['nombre']); ?></h1>
            <p>Sube tutoriales, crea desafíos y monitorea el avance de tus alumnos.</p>
        </section>

        <?php if ($mensaje): ?>
        <div class="alerta <?php echo strpos($mensaje, '✅') !== false ? 'alerta-ok' : 'alerta-err'; ?>">
            <?php echo htmlspecialchars($mensaje); ?>
        </div>
        <?php endif; ?>

        <!-- Formularios: tutoriales y desafíos en dos columnas -->
        <div class="secciones-grid">

            <!-- SECCIÓN: MIS TUTORIALES -->
            <div class="form-panel">
                <h2>📹 Subir Tutorial</h2>
                <form method="POST" action="panel-profesor.php">
                    <input type="hidden" name="accion" value="nuevo_tutorial">

                    <label for="tut-titulo">Título *</label>
                    <input type="text" id="tut-titulo" name="titulo" required placeholder="Ej: Aprende CSS Grid en 10 min">

                    <label for="tut-desc">Descripción</label>
                    <textarea id="tut-desc" name="descripcion" placeholder="De qué trata el tutorial..."></textarea>

                    <label for="tut-url">URL del Video * (local o YouTube)</label>
                    <input type="text" id="tut-url" name="url_video" required placeholder="https://youtube.com/watch?v=... o /media/videos/...">

                    <label for="tut-cat">Categoría</label>
                    <select id="tut-cat" name="categoria">
                        <option value="python">Python</option>
                        <option value="html">HTML</option>
                        <option value="css">CSS</option>
                        <option value="javascript">JavaScript</option>
                        <option value="react">React</option>
                        <option value="sql">SQL</option>
                        <option value="git">Git</option>
                        <option value="cpp">C++</option>
                        <option value="general">General</option>
                    </select>

                    <button type="submit" class="btn-form">Publicar Tutorial</button>
                </form>
            </div>

            <!-- SECCIÓN: MIS DESAFÍOS -->
            <div class="form-panel">
                <h2>🎯 Crear Desafío</h2>
                <form method="POST" action="panel-profesor.php">
                    <input type="hidden" name="accion" value="nuevo_desafio">

                    <label for="des-titulo">Título *</label>
                    <input type="text" id="des-titulo" name="titulo" required placeholder="Ej: El Algoritmo del Laberinto">

                    <label for="des-desc">Descripción</label>
                    <textarea id="des-desc" name="descripcion" placeholder="Describe el reto detalladamente..."></textarea>

                    <label for="des-lang">Lenguaje</label>
                    <select id="des-lang" name="lenguaje">
                        <option value="python">Python</option>
                        <option value="html">HTML</option>
                        <option value="css">CSS</option>
                        <option value="javascript">JavaScript</option>
                        <option value="sql">SQL</option>
                        <option value="cpp">C++</option>
                    </select>

                    <label for="des-dif">Dificultad</label>
                    <select id="des-dif" name="dificultad">
                        <option value="facil">Fácil</option>
                        <option value="medio">Medio</option>
                        <option value="dificil">Difícil</option>
                    </select>

                    <label for="des-xp">XP Recompensa</label>
                    <input type="number" id="des-xp" name="xp_recompensa" value="100" min="10" max="1000">

                    <label for="des-xpmin">XP Mínimo para desbloquearlo</label>
                    <input type="number" id="des-xpmin" name="xp_minimo" value="0" min="0">

                    <button type="submit" class="btn-form">Crear Desafío</button>
                </form>
            </div>

        </div>

        <!-- Tabla de alumnos con progreso de todos los cursos -->
        <section class="tabla-alumnos">
            <h2>Mis Alumnos (<?php echo count($alumnos); ?> registrados)</h2>
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>XP</th>
                            <th>Python</th>
                            <th>HTML</th>
                            <th>CSS</th>
                            <th>JS</th>
                            <th>React</th>
                            <th>SQL</th>
                            <th>Git</th>
                            <th>C++</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($alumnos)): ?>
                        <tr>
                            <td colspan="11" style="text-align:center; opacity:0.6; padding:2rem;">
                                No hay estudiantes registrados aún.
                            </td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($alumnos as $a): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($a['nombre']); ?></strong></td>
                            <td><?php echo htmlspecialchars($a['correo']); ?></td>
                            <td><span class="xp-badge">⭐ <?php echo intval($a['xp']); ?></span></td>
                            <?php
                            // Columnas de progreso por curso
                            foreach (['python','html','css','js','react','sql','git','cpp'] as $col):
                                $p = intval($a[$col]);
                            ?>
                            <td style="white-space:nowrap;">
                                <div class="barra-mini-cell" title="<?php echo $p; ?>%">
                                    <div class="barra-mini-inner" style="width:<?php echo $p; ?>%"></div>
                                </div>
                                <small> <?php echo $p; ?>%</small>
                            </td>
                            <?php endforeach; ?>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

    </main>
</body>
</html>
