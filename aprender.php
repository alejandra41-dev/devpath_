<?php
// aprender.php — Rutas de aprendizaje con vista según el rol del usuario
session_start();

include 'conexion.php';

// Datos del usuario si está logueado
$usuario_logueado = isset($_SESSION['usuario_id']);
$rol              = $_SESSION['rol'] ?? 'visitante';
$usuario_xp       = 0;
$cursos_progreso  = [];

if ($usuario_logueado) {
    $uid = intval($_SESSION['usuario_id']);

    // Cargar XP y progreso de todos los cursos con prepared statement
    $stmt = mysqli_prepare($conexion,
        "SELECT xp, progreso_python, progreso_html, progreso_css,
                progreso_javascript, progreso_react, progreso_sql,
                progreso_git, progreso_cpp
         FROM usuarios WHERE id = ?"
    );
    mysqli_stmt_bind_param($stmt, "i", $uid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt,
        $usuario_xp,
        $p_python, $p_html, $p_css,
        $p_js, $p_react, $p_sql,
        $p_git, $p_cpp
    );
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    $cursos_progreso = [
        'python'     => intval($p_python),
        'html'       => intval($p_html),
        'css'        => intval($p_css),
        'javascript' => intval($p_js),
        'react'      => intval($p_react),
        'sql'        => intval($p_sql),
        'git'        => intval($p_git),
        'cpp'        => intval($p_cpp),
    ];
}

// Info de cada curso para construir las tarjetas
$catalogo_cursos = [
    ['clave'=>'python',     'titulo'=>'Python Básico',       'desc'=>'Domina las bases de la programación con el lenguaje más amigable. Variables, ciclos y funciones.',             'img'=>'python.jpg',     'modulos'=>10, 'xp'=>500,  'nivel_badge'=>'facil',    'nivel_label'=>'Nivel 1', 'cat'=>'basico backend'],
    ['clave'=>'html',       'titulo'=>'Estructura HTML',      'desc'=>'Construye el esqueleto de la web. Aprende etiquetas, formularios y semántica.',                                'img'=>'html.jpg',       'modulos'=>8,  'xp'=>300,  'nivel_badge'=>'facil',    'nivel_label'=>'Nivel 1', 'cat'=>'basico frontend'],
    ['clave'=>'css',        'titulo'=>'Estilos CSS',          'desc'=>'Dale vida y color a la web. Domina Flexbox, Grid y animaciones para crear diseños increíbles.',               'img'=>'css.jpg',        'modulos'=>12, 'xp'=>600,  'nivel_badge'=>'medio',    'nivel_label'=>'Nivel 2', 'cat'=>'intermedio frontend'],
    ['clave'=>'javascript', 'titulo'=>'JavaScript Core',      'desc'=>'Añade magia e interactividad. Manipula el DOM, eventos y lógica compleja.',                                   'img'=>'javascript.jpg', 'modulos'=>15, 'xp'=>800,  'nivel_badge'=>'medio',    'nivel_label'=>'Nivel 2', 'cat'=>'intermedio frontend'],
    ['clave'=>'react',      'titulo'=>'React JS',             'desc'=>'Crea interfaces de usuario modernas y dinámicas usando el poder de los componentes.',                         'img'=>'react.jpg',      'modulos'=>20, 'xp'=>1200, 'nivel_badge'=>'dificil',  'nivel_label'=>'Nivel 3', 'cat'=>'intermedio frontend'],
    ['clave'=>'sql',        'titulo'=>'Bases de Datos SQL',   'desc'=>'Aprende a guardar, buscar y administrar datos estructurados como un profesional.',                            'img'=>'sql.gif',        'modulos'=>8,  'xp'=>400,  'nivel_badge'=>'facil',    'nivel_label'=>'Nivel 1', 'cat'=>'basico backend'],
    ['clave'=>'git',        'titulo'=>'Git & GitHub',         'desc'=>'Aprende a usar Git y GitHub, las herramientas de control de versiones más populares.',                       'img'=>'git.jpg',        'modulos'=>6,  'xp'=>450,  'nivel_badge'=>'medio',    'nivel_label'=>'Nivel 2', 'cat'=>'intermedio herramientas'],
    ['clave'=>'cpp',        'titulo'=>'C++',                  'desc'=>'Aprende los fundamentos de C++, uno de los lenguajes de programación más populares.',                        'img'=>'C++.jpg',        'modulos'=>14, 'xp'=>900,  'nivel_badge'=>'facil',    'nivel_label'=>'Nivel 1', 'cat'=>'basico backend'],
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Aprender - Dev Path</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="media/img/logos.png">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/aprender.css">
    <style>
        /* Barra de progreso integrada en tarjeta de curso */
        .progreso-tarjeta { margin: 0.5rem 0; }
        .progreso-tarjeta-bg {
            background: rgba(255,255,255,0.1);
            border-radius: 8px; height: 8px; overflow: hidden;
        }
        .progreso-tarjeta-fill {
            height: 100%;
            background: linear-gradient(90deg, #6c5ce7, #a29bfe);
            border-radius: 8px;
            transition: width 0.8s ease;
        }
        .badge-completado-mini {
            display: inline-block;
            padding: 0.15rem 0.5rem;
            background: rgba(46,213,115,0.2);
            color: #2ed573;
            border: 1px solid #2ed573;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: bold;
            margin-left: 0.4rem;
        }
        /* Panel stats del estudiante */
        .estudiante-stats {
            display: flex; gap: 1.5rem; flex-wrap: wrap;
            background: rgba(255,255,255,0.05);
            border-radius: 12px; padding: 1rem 1.5rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(255,255,255,0.1);
            align-items: center;
        }
        .estudiante-stats .stat { text-align: center; }
        .estudiante-stats .stat-val { font-size: 1.8rem; font-weight:700; color: #f9ca24; }
        .estudiante-stats .stat-lbl { font-size: 0.75rem; opacity: 0.7; }
        /* Panel profesor / admin */
        .panel-accion {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px; padding: 1.5rem;
            margin-bottom: 2rem;
        }
        .panel-accion h2 { margin-top: 0; color: var(--accent-blue, #3498db); }
        .btn-panel-accion {
            display: inline-block; margin: 0.5rem 0.5rem 0 0;
            padding: 0.7rem 1.4rem;
            background: var(--accent-blue, #3498db);
            color: white; border-radius: 8px; font-weight: bold;
            text-decoration: none; transition: opacity 0.2s;
        }
        .btn-panel-accion:hover { opacity: 0.85; }
    </style>
</head>
<body>

    <header>
        <a href="index.php" class="logo-container">
            <img src="media/img/logos.png" alt="Dev Path Logo">
            <div class="logo-text">Dev<br><span>Path</span></div>
        </a>
        <nav class="nav-links">
            <a href="aprender.php" class="activo">Aprender</a>
            <a href="desafios.php">Desafíos</a>
            <a href="teoria.php">Teoría</a>
            <a href="tutoriales.php">Tutoriales</a>
            <?php if ($usuario_logueado): ?>
                <a href="perfil.php">👤 <?php echo htmlspecialchars($_SESSION['nombre']); ?></a>
                <a href="logout.php" class="btn-ingresar" style="background: #ff4757;">Salir</a>
            <?php else: ?>
                <a href="login.html" class="btn-ingresar">Ingresar</a>
                <a href="roles.html" class="btn-ingresar" style="background: var(--accent-blue);">Registrarse</a>
            <?php endif; ?>
        </nav>
    </header>

    <main class="aprender-main">
        <div class="aprender-header">
            <h1 class="page-title">Rutas de Aprendizaje</h1>
            <p>Elige tu próximo destino. Completa los cursos para ganar experiencia y desbloquear nuevos desafíos.</p>
        </div>

        <?php if ($usuario_logueado && $rol === 'estudiante'): ?>
        <!-- VISTA ESTUDIANTE: stats de XP y progreso -->
        <div class="estudiante-stats">
            <div class="stat">
                <div class="stat-val">⭐ <?php echo intval($usuario_xp); ?></div>
                <div class="stat-lbl">XP Total</div>
            </div>
            <?php
            $completados = array_filter($cursos_progreso, fn($p) => $p >= 100);
            $en_progreso = array_filter($cursos_progreso, fn($p) => $p > 0 && $p < 100);
            ?>
            <div class="stat">
                <div class="stat-val"><?php echo count($completados); ?></div>
                <div class="stat-lbl">Cursos Completados</div>
            </div>
            <div class="stat">
                <div class="stat-val"><?php echo count($en_progreso); ?></div>
                <div class="stat-lbl">En Progreso</div>
            </div>
            <a href="perfil.php" class="btn-panel-accion" style="margin-left:auto;">Ver mi Perfil completo →</a>
        </div>

        <?php elseif ($usuario_logueado && $rol === 'profesor'): ?>
        <!-- VISTA PROFESOR: acciones de gestión -->
        <div class="panel-accion">
            <h2>👨‍🏫 Panel del Profesor</h2>
            <p>Gestiona tus tutoriales, crea desafíos y monitorea el avance de tus alumnos.</p>
            <a href="panel-profesor.php" class="btn-panel-accion">Ver estadísticas del curso</a>
            <a href="panel-profesor.php" class="btn-panel-accion" style="background:#6c5ce7;">Subir material</a>
        </div>

        <?php elseif ($usuario_logueado && $rol === 'admin'): ?>
        <!-- VISTA ADMIN: gestión global -->
        <div class="panel-accion">
            <h2>⚙️ Panel Administrador</h2>
            <p>Control total de la plataforma. Gestiona usuarios, roles y cursos.</p>
            <a href="panel-admin.php" class="btn-panel-accion">Gestionar cursos y usuarios</a>
        </div>
        <?php endif; ?>

        <!-- Filtros de categoría -->
        <div class="filtros-container">
            <button class="filtro-btn activo" data-filtro="todos">Todos</button>
            <button class="filtro-btn" data-filtro="basico">Básico</button>
            <button class="filtro-btn" data-filtro="intermedio">Intermedio</button>
            <button class="filtro-btn" data-filtro="frontend">Frontend</button>
            <button class="filtro-btn" data-filtro="backend">Backend</button>
            <button class="filtro-btn" data-filtro="herramientas">Herramientas</button>
        </div>

        <!-- Grid de cursos con progreso real -->
        <div class="cursos-grid-avanzado">
            <?php foreach ($catalogo_cursos as $curso):
                $progreso = $cursos_progreso[$curso['clave']] ?? 0;
            ?>
            <article class="curso-tarjeta" data-categoria="<?php echo $curso['cat']; ?>">
                <div class="curso-imagen">
                    <img src="media/img/<?php echo $curso['img']; ?>" alt="<?php echo htmlspecialchars($curso['titulo']); ?>">
                    <span class="nivel-badge <?php echo $curso['nivel_badge']; ?>"><?php echo $curso['nivel_label']; ?></span>
                </div>
                <div class="curso-info">
                    <h3>
                        <?php echo htmlspecialchars($curso['titulo']); ?>
                        <?php if ($progreso >= 100): ?>
                        <span class="badge-completado-mini">✅ Completado</span>
                        <?php endif; ?>
                    </h3>
                    <p><?php echo htmlspecialchars($curso['desc']); ?></p>

                    <?php if ($usuario_logueado && $rol === 'estudiante'): ?>
                    <!-- Barra de progreso personal del estudiante -->
                    <div class="progreso-tarjeta">
                        <div class="progreso-tarjeta-bg">
                            <div class="progreso-tarjeta-fill" style="width: <?php echo $progreso; ?>%;"></div>
                        </div>
                        <small style="opacity:0.7;"><?php echo $progreso; ?>% completado</small>
                    </div>
                    <?php endif; ?>

                    <div class="curso-meta">
                        <span>📚 <?php echo $curso['modulos']; ?> Módulos</span>
                        <span>⭐ +<?php echo $curso['xp']; ?> XP</span>
                    </div>
                    <a href="curso-<?php echo $curso['clave']; ?>.php" class="btn-empezar">
                        <?php echo ($progreso > 0 && $progreso < 100) ? 'Continuar' : ($progreso >= 100 ? 'Repasar' : 'Iniciar Aventura'); ?>
                    </a>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </main>

    <footer class="site-footer">
        <div class="footer-content">
            <div class="footer-logo">
                <img src="media/img/logos.png" alt="Dev Path Logo">
                <span>Dev Path</span>
            </div>
            <p>¡Aprende a programar en una dulce aventura espacial!</p>
            <div class="footer-links">
                <a href="nosotros.html">Sobre nosotros</a>
                <a href="terminos.html">Términos</a>
                <a href="privacidad.html">Privacidad</a>
            </div>
            <p class="copyright">&copy; 2026 Dev Path. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="js/main.js"></script>
</body>
</html>
