<?php
// tutoriales.php — Videoteca con miniaturas locales y modal de reproducción
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit();
}

include 'conexion.php';

// -------------------------------------------------------
// Tutoriales estáticos con los 5 videos nuevos
// Cada entrada tiene: imagen local, ID de YouTube, título, descripción, autor
// -------------------------------------------------------
$tutoriales_estaticos = [
    [
        'titulo'      => 'Cómo crear un Portafolio desde cero',
        'descripcion' => 'Aprende a estructurar, diseñar y publicar tu primer portafolio como desarrollador usando HTML, CSS y JavaScript.',
        'autor'       => 'Dev Path Oficial',
        'imagen'      => 'media/img/tutoriales/fondo.gif',
        'yt_id'       => 'oYBC7r5oSzk',   // https://youtu.be/oYBC7r5oSzk
        'categoria'   => 'HTML / CSS / JS',
    ],
    [
        'titulo'      => 'Aprende React desde cero',
        'descripcion' => 'Curso completo de React: componentes, hooks, estado y más. Ideal para quienes ya conocen JavaScript.',
        'autor'       => 'Dev Path Oficial',
        'imagen'      => 'media/img/tutoriales/react.jpg',
        'yt_id'       => 'wGxDfSWC4Ww',   // https://youtu.be/wGxDfSWC4Ww
        'categoria'   => 'React',
    ],
    [
        'titulo'      => 'Trucos Ninja con JavaScript',
        'descripcion' => 'Los mejores trucos y patrones de JavaScript moderno que todo desarrollador debe conocer.',
        'autor'       => 'Profe Código',
        'imagen'      => 'media/img/tutoriales/javascript-trucos.jpg',
        'yt_id'       => 'L0VHJa0Bmi4',   // https://youtu.be/L0VHJa0Bmi4
        'categoria'   => 'JavaScript',
    ],
    [
        'titulo'      => 'Masterclass de Flexbox y Grid',
        'descripcion' => 'Domina los dos sistemas de layout más poderosos de CSS con ejemplos prácticos y proyectos reales.',
        'autor'       => 'Dev Path Oficial',
        'imagen'      => 'media/img/tutoriales/flexbox-grid.jpg',
        'yt_id'       => '6qko7Nbe8YA',   // https://youtu.be/6qko7Nbe8YA
        'categoria'   => 'CSS',
    ],
    [
        'titulo'      => 'Solucionando conflictos de Git',
        'descripcion' => 'Aprende a resolver merge conflicts en Git sin perder el trabajo de tu equipo. Paso a paso.',
        'autor'       => 'Dev Path Oficial',
        'imagen'      => 'media/img/tutoriales/git-conflictos.jpg',
        'yt_id'       => '1tEORD7FTPI',   // https://youtu.be/1tEORD7FTPI
        'categoria'   => 'Git',
    ],
];

// -------------------------------------------------------
// Cargar tutoriales subidos por profesores desde la BD
// (si la tabla existe y hay registros)
// -------------------------------------------------------
$tutoriales_bd = [];
$res_tabla = @mysqli_query($conexion, "SHOW TABLES LIKE 'tutoriales'");
if ($res_tabla && mysqli_num_rows($res_tabla) > 0) {
    $stmt = mysqli_prepare($conexion,
        "SELECT t.titulo, t.descripcion, t.url_video, t.categoria, u.nombre
         FROM tutoriales t
         LEFT JOIN usuarios u ON t.profesor_id = u.id
         ORDER BY t.fecha DESC LIMIT 20"
    );
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $t_titulo, $t_desc, $t_url, $t_cat, $t_profe);
    while (mysqli_stmt_fetch($stmt)) {
        // Extraer ID de YouTube si la URL es de YouTube
        $yt_id = '';
        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $t_url, $m)) {
            $yt_id = $m[1];
        }
        $tutoriales_bd[] = [
            'titulo'      => $t_titulo,
            'descripcion' => $t_desc,
            'url_video'   => $t_url,
            'yt_id'       => $yt_id,
            'categoria'   => $t_cat,
            'autor'       => $t_profe ?? 'Profesor',
        ];
    }
    mysqli_stmt_close($stmt);
}

// El primer tutorial estático es el destacado
$destacado = $tutoriales_estaticos[0];
// El resto va en la galería
$galeria   = array_slice($tutoriales_estaticos, 1);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutoriales - Dev Path</title>
    <link rel="icon" type="image/png" href="media/img/logos.png">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/tutoriales.css">
</head>
<body>

    <header>
        <a href="index.php" class="logo-container">
            <img src="media/img/logos.png" alt="Dev Path Logo">
            <div class="logo-text">Dev<br><span>Path</span></div>
        </a>
        <nav class="nav-links">
            <a href="aprender.php">Aprender</a>
            <a href="desafios.php">Desafíos</a>
            <a href="teoria.php">Teoría</a>
            <a href="tutoriales.php" style="color: var(--accent-blue);">Tutoriales</a>
            <a href="perfil.php">👤 <?php echo htmlspecialchars($_SESSION['nombre']); ?></a>
            <a href="logout.php" class="btn-ingresar" style="background: #ff4757;">Salir</a>
        </nav>
    </header>

    <main class="tutoriales-main">

        <div class="tutoriales-header">
            <h1 class="page-title">Hologramas de Entrenamiento</h1>
            <p>Aprende viendo a los maestros. Tutoriales paso a paso, guías visuales y resolución de proyectos en video.</p>
        </div>

        <!-- ====== VIDEO DESTACADO ====== -->
        <!-- Al hacer clic en el área del video, se abre el modal de reproducción -->
        <section class="video-destacado">
            <div class="video-player"
                 onclick="abrirModal('<?php echo htmlspecialchars($destacado['yt_id']); ?>', '<?php echo htmlspecialchars(addslashes($destacado['titulo'])); ?>')"
                 style="cursor: pointer;"
                 role="button"
                 aria-label="Reproducir: <?php echo htmlspecialchars($destacado['titulo']); ?>">

                <!-- Miniatura local (no thumbnail de YouTube) -->
                <img src="<?php echo htmlspecialchars($destacado['imagen']); ?>"
                     alt="Miniatura: <?php echo htmlspecialchars($destacado['titulo']); ?>"
                     class="miniatura-destacada">

                <!-- Ícono de reproducir superpuesto -->
                <div class="play-overlay">
                    <div class="play-btn">▶</div>
                </div>

                <span class="duracion-badge">YouTube</span>
            </div>

            <div class="video-info-destacada">
                <span class="etiqueta-nuevo">DESTACADO</span>
                <h2><?php echo htmlspecialchars($destacado['titulo']); ?></h2>
                <p><?php echo htmlspecialchars($destacado['descripcion']); ?></p>
                <div class="video-meta">
                    <span>👨‍🏫 <?php echo htmlspecialchars($destacado['autor']); ?></span>
                    <span>🏷️ <?php echo htmlspecialchars($destacado['categoria']); ?></span>
                </div>
                <!-- Botón explícito para abrir el modal -->
                <button
                    class="btn-ver-tutorial"
                    onclick="abrirModal('<?php echo htmlspecialchars($destacado['yt_id']); ?>', '<?php echo htmlspecialchars(addslashes($destacado['titulo'])); ?>')">
                    ▶ Ver Tutorial
                </button>
            </div>
        </section>

        <!-- ====== TUTORIALES DE PROFESORES (desde BD) ====== -->
        <?php if (!empty($tutoriales_bd)): ?>
        <h2 class="subtitulo-seccion">Tutoriales de Profesores</h2>
        <div class="videos-grid">
            <?php foreach ($tutoriales_bd as $tut): ?>
            <div class="video-card">
                <div class="video-thumbnail"
                     onclick="<?php echo $tut['yt_id'] ? "abrirModal('{$tut['yt_id']}', '" . addslashes(htmlspecialchars($tut['titulo'])) . "')" : ''; ?>"
                     style="<?php echo $tut['yt_id'] ? 'cursor:pointer;' : ''; ?>">

                    <!-- Si tiene YT ID: miniatura local de fallback + play overlay -->
                    <?php if ($tut['yt_id']): ?>
                        <img src="media/img/tutoriales/portafolio.jpg"
                             alt="<?php echo htmlspecialchars($tut['titulo']); ?>"
                             style="width:100%;height:100%;object-fit:cover;">
                        <div class="play-overlay-small">▶</div>
                    <?php else: ?>
                        <!-- Video local si la URL no es YouTube -->
                        <video controls style="width:100%; height:100%; object-fit:cover;">
                            <source src="<?php echo htmlspecialchars($tut['url_video']); ?>" type="video/mp4">
                        </video>
                    <?php endif; ?>
                </div>
                <div class="video-details">
                    <h3><?php echo htmlspecialchars($tut['titulo']); ?></h3>
                    <p class="video-autor">👨‍🏫 <?php echo htmlspecialchars($tut['autor']); ?></p>
                    <?php if ($tut['descripcion']): ?>
                    <p style="font-size:0.85rem; opacity:0.8; margin-top:4px;">
                        <?php echo htmlspecialchars($tut['descripcion']); ?>
                    </p>
                    <?php endif; ?>
                    <div class="video-stats">
                        <span><?php echo htmlspecialchars($tut['categoria']); ?></span>
                        <?php if ($tut['yt_id']): ?>
                        <button class="btn-ver-mini"
                                onclick="abrirModal('<?php echo htmlspecialchars($tut['yt_id']); ?>', '<?php echo htmlspecialchars(addslashes($tut['titulo'])); ?>')">
                            Ver ▶
                        </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- ====== GALERÍA DE TUTORIALES ESTÁTICOS ====== -->
        <h2 class="subtitulo-seccion">Últimos Entrenamientos</h2>

        <div class="videos-grid">
            <?php foreach ($galeria as $tut): ?>
            <div class="video-card">
                <!-- Thumbnail con imagen local + overlay de play -->
                <!-- Al hacer clic se abre el modal con el iframe de YouTube -->
                <div class="video-thumbnail"
                     onclick="abrirModal('<?php echo htmlspecialchars($tut['yt_id']); ?>', '<?php echo htmlspecialchars(addslashes($tut['titulo'])); ?>')"
                     style="cursor: pointer;"
                     role="button"
                     aria-label="Reproducir: <?php echo htmlspecialchars($tut['titulo']); ?>">

                    <!-- Imagen local (no miniatura de YouTube automática) -->
                    <img src="<?php echo htmlspecialchars($tut['imagen']); ?>"
                         alt="Miniatura: <?php echo htmlspecialchars($tut['titulo']); ?>">

                    <!-- Ícono de play que aparece al hacer hover -->
                    <div class="play-overlay-small">▶</div>

                    <span class="duracion-badge"><?php echo htmlspecialchars($tut['categoria']); ?></span>
                </div>

                <div class="video-details">
                    <h3><?php echo htmlspecialchars($tut['titulo']); ?></h3>
                    <p class="video-autor">👨‍🏫 <?php echo htmlspecialchars($tut['autor']); ?></p>
                    <div class="video-stats">
                        <span><?php echo htmlspecialchars($tut['categoria']); ?></span>
                        <!-- Botón explícito "Ver tutorial" -->
                        <button class="btn-ver-mini"
                                onclick="abrirModal('<?php echo htmlspecialchars($tut['yt_id']); ?>', '<?php echo htmlspecialchars(addslashes($tut['titulo'])); ?>')">
                            Ver ▶
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

    </main>

    <!-- ====== MODAL DE REPRODUCCIÓN ====== -->
    <!-- Se muestra al hacer clic en cualquier tarjeta de tutorial -->
    <div id="video-modal" class="modal-overlay" style="display:none;" onclick="cerrarModalAlFondo(event)">
        <div class="modal-contenido">
            <!-- Botón de cerrar -->
            <button class="modal-cerrar" onclick="cerrarModal()" aria-label="Cerrar video">✕</button>
            <h3 id="modal-titulo" class="modal-titulo"></h3>
            <!-- El iframe se construye dinámicamente en JS para evitar pre-carga -->
            <div class="modal-iframe-wrapper">
                <iframe id="modal-iframe"
                        src=""
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                </iframe>
            </div>
        </div>
    </div>

    <!-- ====== FOOTER ====== -->
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

    <script>
    // -------------------------------------------------------
    // Modal de reproducción de YouTube
    // Se inyecta el src del iframe solo al abrir (evita pre-carga)
    // -------------------------------------------------------
    function abrirModal(ytId, titulo) {
        if (!ytId) return;

        const modal    = document.getElementById('video-modal');
        const iframe   = document.getElementById('modal-iframe');
        const tituloEl = document.getElementById('modal-titulo');

        // Construir URL con parámetros: autoplay y rel=0 (sin sugerencias)
        iframe.src = 'https://www.youtube.com/embed/' + ytId + '?autoplay=1&rel=0';

        if (tituloEl) tituloEl.textContent = titulo || '';

        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden'; // Bloquear scroll del fondo
    }

    function cerrarModal() {
        const modal  = document.getElementById('video-modal');
        const iframe = document.getElementById('modal-iframe');

        // Limpiar src para detener el video al cerrar
        iframe.src = '';
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }

    // Cerrar si el usuario hace clic en el fondo oscuro (fuera del modal)
    function cerrarModalAlFondo(event) {
        if (event.target === document.getElementById('video-modal')) {
            cerrarModal();
        }
    }

    // Cerrar con tecla Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') cerrarModal();
    });
    </script>

</body>
</html>
