<?php
// teoria.php — Biblioteca de Conocimiento
// Diseño: landing usa teoría.css original; tema usa tomo.css original
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit();
}

// Carga el array $temas con todo el contenido educativo
include 'teoria/contenido.php';

// -------------------------------------------------------
// Leer y validar parámetros de la URL
// -------------------------------------------------------
$lang_activo = $_GET['lenguaje'] ?? '';
$tema_activo = $_GET['tema']     ?? '';

// Validar que existan en el array de contenido
if ($lang_activo && !isset($temas[$lang_activo]))                           $lang_activo = '';
if ($lang_activo && $tema_activo && !isset($temas[$lang_activo]['temas'][$tema_activo])) $tema_activo = '';

// Si hay lenguaje pero no tema, abrir el primero
if ($lang_activo && !$tema_activo) {
    $tema_activo = array_key_first($temas[$lang_activo]['temas']);
}

// Datos del tema activo
$contenido_actual = null;
$tema_titulo      = '';
if ($lang_activo && $tema_activo) {
    $contenido_actual = $temas[$lang_activo]['temas'][$tema_activo];
    $tema_titulo      = $contenido_actual['titulo'];
}

// -------------------------------------------------------
// Calcular tema anterior y siguiente (navegación)
// -------------------------------------------------------
$tema_anterior  = null;
$tema_siguiente = null;
if ($lang_activo && $tema_activo) {
    $keys   = array_keys($temas[$lang_activo]['temas']);
    $idx    = array_search($tema_activo, $keys);

    if ($idx > 0) {
        $k = $keys[$idx - 1];
        $tema_anterior = [
            'url'    => "teoria.php?lenguaje={$lang_activo}&tema={$k}",
            'titulo' => $temas[$lang_activo]['temas'][$k]['titulo'],
        ];
    }
    if ($idx < count($keys) - 1) {
        $k = $keys[$idx + 1];
        $tema_siguiente = [
            'url'    => "teoria.php?lenguaje={$lang_activo}&tema={$k}",
            'titulo' => $temas[$lang_activo]['temas'][$k]['titulo'],
        ];
    }
}

// Color y estilo del badge según lenguaje (igual que los tomos originales)
$estilos_lang = [
    'python'     => 'background:rgba(55,118,171,0.2); color:#4fa3e0; border-color:#3776ab;',
    'html'       => 'background:rgba(227,76,38,0.2);  color:#ff6b4a; border-color:#e34c26;',
    'css'        => 'background:rgba(38,77,228,0.2);  color:#6f8fff; border-color:#264de4;',
    'javascript' => 'background:rgba(247,223,30,0.15); color:#f7df1e; border-color:#c8b400;',
    'react'      => 'background:rgba(97,218,251,0.15); color:#61dafb; border-color:#21a1c4;',
    'sql'        => 'background:rgba(51,103,145,0.2); color:#5b9bd5; border-color:#336791;',
    'git'        => 'background:rgba(240,80,50,0.2);  color:#f05032; border-color:#c0392b;',
    'cpp'        => 'background:rgba(0,89,156,0.2);   color:#4fa3e0; border-color:#00599c;',
];

$titulo_pagina = $tema_titulo
    ? htmlspecialchars($tema_titulo) . ' — Teoría Dev Path'
    : 'Biblioteca de Conocimiento — Dev Path';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo_pagina; ?></title>
    <link rel="icon" type="image/png" href="media/img/logos.png">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/global.css">
    <!-- tomo.css: estilos del sidebar + contenido (diseño original de los tomos) -->
    <link rel="stylesheet" href="css/tomo.css">
    <!-- teoria.css: estilos de la landing (buscador, archivos-grid, glosario) -->
    <link rel="stylesheet" href="css/teoria.css">
</head>
<body>

    <!-- ====== HEADER (idéntico al resto del proyecto) ====== -->
    <header>
        <a href="index.php" class="logo-container">
            <img src="media/img/logos.png" alt="Dev Path Logo">
            <div class="logo-text">Dev<br><span>Path</span></div>
        </a>
        <nav class="nav-links">
            <a href="aprender.php">Aprender</a>
            <a href="desafios.php">Desafíos</a>
            <a href="teoria.php" style="color: var(--accent-blue);">Teoría</a>
            <a href="tutoriales.php">Tutoriales</a>
            <a href="perfil.php">👤 <?php echo htmlspecialchars($_SESSION['nombre']); ?></a>
            <a href="logout.php" class="btn-ingresar" style="background: #ff4757;">Salir</a>
        </nav>
    </header>

    <?php if (!$lang_activo): ?>
    <!-- ════════════════════════════════════════════════════
         VISTA LANDING — diseño igual al teoria.html original
         ════════════════════════════════════════════════════ -->
    <main class="teoria-main">

        <!-- Hero con buscador -->
        <section class="buscador-seccion">
            <h1 class="page-title">Biblioteca de Conocimiento</h1>
            <p>Encuentra conceptos, documentación y trucos para superar tus misiones.</p>

            <!-- Buscador conectado a teoria.js -->
            <div id="buscador-container" style="position: relative; max-width: 600px; margin: 0 auto;">
                <div class="search-box">
                    <span class="search-icon">🔍</span>
                    <input type="text" id="input-busqueda"
                           placeholder="Ej: ¿Qué es una variable en Python?"
                           autocomplete="off">
                    <button class="btn-buscar" onclick="document.getElementById('input-busqueda').dispatchEvent(new Event('input'))">Buscar</button>
                </div>
                <!-- Resultados dinámicos generados por JS -->
                <div id="resultados-busqueda" class="resultados-busqueda" style="display:none;"></div>
            </div>
        </section>

        <!-- Grid de lenguajes (8 tarjetas) -->
        <h2 class="subtitulo-seccion">Rutas de Conocimiento</h2>
        <div class="archivos-grid">
            <?php
            // Configuración visual de cada tarjeta de lenguaje
            $config_cards = [
                'python'     => ['icono' => '🐍', 'clase' => 'logica',       'desc' => 'Fundamentos de programación, POO, módulos y más.'],
                'html'       => ['icono' => '🌐', 'clase' => 'frontend',     'desc' => 'Estructura web, formularios, semántica y accesibilidad.'],
                'css'        => ['icono' => '🎨', 'clase' => 'frontend',     'desc' => 'Selectores, Flexbox, Grid, animaciones y diseño responsive.'],
                'javascript' => ['icono' => '⚡', 'clase' => 'frontend',     'desc' => 'DOM, eventos, Fetch API, Async/Await y POO moderna.'],
                'react'      => ['icono' => '⚛️', 'clase' => 'frontend',     'desc' => 'Componentes, hooks, React Router y Context API.'],
                'sql'        => ['icono' => '🗄️', 'clase' => 'bd',          'desc' => 'Consultas SQL, JOINs, índices y optimización.'],
                'git'        => ['icono' => '🔀', 'clase' => 'herramientas', 'desc' => 'Control de versiones, ramas, merge y GitHub.'],
                'cpp'        => ['icono' => '⚙️', 'clase' => 'herramientas', 'desc' => 'Variables, funciones, punteros, clases y STL.'],
            ];
            foreach ($temas as $key => $lang):
                $cfg       = $config_cards[$key] ?? ['icono' => '📖', 'clase' => '', 'desc' => ''];
                $num_temas = count($lang['temas']);
                $primer    = array_key_first($lang['temas']);
                $url       = "teoria.php?lenguaje={$key}&tema={$primer}";
            ?>
            <a href="<?php echo $url; ?>" class="archivo-card <?php echo $cfg['clase']; ?>">
                <div class="archivo-icon"><?php echo $cfg['icono']; ?></div>
                <div class="archivo-info">
                    <h3><?php echo htmlspecialchars($lang['nombre']); ?></h3>
                    <p><?php echo htmlspecialchars($cfg['desc']); ?></p>
                    <span class="leer-mas">Explorar <?php echo $num_temas; ?> temas ➔</span>
                </div>
            </a>
            <?php endforeach; ?>
        </div>

        <!-- Glosario de términos (igual al original) -->
        <section class="glosario-seccion">
            <h2 class="subtitulo-seccion">Términos del Día</h2>
            <div class="glosario-grid">
                <div class="termino-box">
                    <h4>Variable</h4>
                    <p>Una "caja" en la memoria de la computadora donde guardamos datos que pueden cambiar durante el programa.</p>
                </div>
                <div class="termino-box">
                    <h4>API</h4>
                    <p>Un "mesero" que toma tu pedido (solicitud), lo lleva a la cocina (servidor) y te trae la comida (datos).</p>
                </div>
                <div class="termino-box">
                    <h4>Bug</h4>
                    <p>Un error o comportamiento inesperado en el código. ¡Tu misión es cazarlos y eliminarlos!</p>
                </div>
            </div>
        </section>

    </main>

    <?php else: ?>
    <!-- ════════════════════════════════════════════════════
         VISTA TEMA — diseño igual al tomo-*.html original
         Usa las mismas clases CSS de tomo.css
         ════════════════════════════════════════════════════ -->
    <main class="tomo-main">

        <!-- Barra superior: volver + badge del lenguaje -->
        <div class="tomo-top-bar">
            <a href="teoria.php" class="btn-volver">⬅ Volver a la Biblioteca</a>
            <span class="tomo-badge"
                  style="<?php echo $estilos_lang[$lang_activo] ?? ''; ?>">
                <?php echo $temas[$lang_activo]['icono']; ?>
                <?php echo htmlspecialchars($temas[$lang_activo]['nombre']); ?>
            </span>
        </div>

        <!-- Layout: sidebar izquierda + contenido derecha -->
        <div class="tomo-layout">

            <!-- SIDEBAR: lista de temas del lenguaje activo -->
            <aside class="tomo-sidebar">
                <h3>Temas de <?php echo htmlspecialchars($temas[$lang_activo]['nombre']); ?></h3>
                <ul class="indice-lista">
                    <?php foreach ($temas[$lang_activo]['temas'] as $t_key => $t_data):
                        $es_activo = ($t_key === $tema_activo);
                        $url_tema  = "teoria.php?lenguaje={$lang_activo}&tema={$t_key}";
                    ?>
                    <li>
                        <a href="<?php echo $url_tema; ?>"
                           class="<?php echo $es_activo ? 'activo' : ''; ?>"
                           title="<?php echo htmlspecialchars($t_data['desc']); ?>">
                            <?php echo htmlspecialchars($t_data['titulo']); ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>

                <!-- Selector rápido de lenguaje -->
                <div style="margin-top: 20px; border-top: 1px solid rgba(255,255,255,0.08); padding-top: 15px;">
                    <p style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 8px;">Cambiar lenguaje:</p>
                    <select onchange="window.location.href=this.value"
                            style="width:100%; padding:6px 8px; background:#0a0a1a; color:#fff; border:1px solid rgba(255,255,255,0.15); border-radius:6px; font-size:0.85rem;">
                        <?php foreach ($temas as $lk => $ld): ?>
                        <option value="teoria.php?lenguaje=<?php echo $lk; ?>"
                                <?php echo ($lk === $lang_activo) ? 'selected' : ''; ?>>
                            <?php echo $ld['icono']; ?> <?php echo htmlspecialchars($ld['nombre']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </aside>

            <!-- CONTENIDO: artículo del tema -->
            <?php if ($contenido_actual): ?>
            <article class="tomo-content">

                <!-- Título -->
                <h1 class="tomo-titulo"><?php echo htmlspecialchars($tema_titulo); ?></h1>
                <p style="color: var(--text-muted); font-style: italic; margin-bottom: 1.5rem;">
                    <?php echo htmlspecialchars($contenido_actual['desc']); ?>
                </p>

                <hr class="separador">

                <!-- Contenido educativo (HTML generado internamente) -->
                <?php echo $contenido_actual['contenido']; ?>

                <!-- Navegación anterior / siguiente -->
                <hr class="separador">
                <nav class="navegacion-temas">
                    <?php if ($tema_anterior): ?>
                    <a href="<?php echo $tema_anterior['url']; ?>" class="btn-nav-tema btn-anterior">
                        ← <?php echo htmlspecialchars($tema_anterior['titulo']); ?>
                    </a>
                    <?php else: ?>
                    <span></span>
                    <?php endif; ?>

                    <?php if ($tema_siguiente): ?>
                    <a href="<?php echo $tema_siguiente['url']; ?>" class="btn-nav-tema btn-siguiente">
                        <?php echo htmlspecialchars($tema_siguiente['titulo']); ?> →
                    </a>
                    <?php endif; ?>
                </nav>

            </article>
            <?php endif; ?>

        </div>
    </main>
    <?php endif; ?>

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

    <!-- Índice de temas para el buscador JS -->
    <script>
    const INDICE_TEMAS = <?php
        $indice = [];
        foreach ($temas as $lk => $ld) {
            foreach ($ld['temas'] as $tk => $td) {
                $indice[] = [
                    'lenguaje' => $lk,
                    'tema'     => $tk,
                    'titulo'   => $td['titulo'],
                    'desc'     => $td['desc'],
                    'icono'    => $ld['icono'],
                    'url'      => "teoria.php?lenguaje={$lk}&tema={$tk}",
                ];
            }
        }
        echo json_encode($indice, JSON_UNESCAPED_UNICODE);
    ?>;
    </script>
    <script src="js/teoria.js"></script>

</body>
</html>
