<?php
// curso-css.php — Curso de CSS con video HTML5 y progreso en BD
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit();
}

include 'conexion.php';
$usuario_id = intval($_SESSION['usuario_id']);

$stmt = mysqli_prepare($conexion, "SELECT progreso_css FROM usuarios WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $usuario_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $progreso_usuario);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);
$progreso_usuario = intval($progreso_usuario);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Curso de CSS - Dev Path</title>
    <link rel="icon" type="image/png" href="media/img/logos.png">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/curso.css">
</head>
<body>

    <header>
        <a href="index.php" class="logo-container">
            <img src="media/img/logos.png" alt="Dev Path Logo">
            <div class="logo-text">Dev<br><span>Path</span></div>
        </a>
        <nav class="nav-links">
            <a href="aprender.php">Aprender</a>
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <a href="perfil.php">👤 <?php echo htmlspecialchars($_SESSION['nombre']); ?></a>
                <a href="logout.php" class="btn-ingresar" style="background: #ff4757;">Salir</a>
            <?php else: ?>
                <a href="login.html" class="btn-ingresar">Ingresar</a>
                <a href="roles.html" class="btn-ingresar" style="background: var(--accent-blue);">Registrarse</a>
            <?php endif; ?>
        </nav>
    </header>

    <main class="aula-main" data-curso="css">

        <section class="clase-area">
            <div class="video-container">
                <video id="video-curso" controls style="width:100%; border-radius:8px;" poster="media/img/css.jpg">
                    <source src="media/videos/css/nivel1.mp4" type="video/mp4">
                    <p style="text-align:center; padding:2rem; opacity:0.7;">
                        Video no disponible aún. Usa "Siguiente Misión" para avanzar.
                    </p>
                </video>
            </div>

            <div class="clase-info">
                <div class="clase-header">
                    <h1 class="clase-titulo">Nivel 1: Pintando la Web (Colores y Fuentes)</h1>
                    <span class="xp-recompensa">⭐ +70 XP</span>
                </div>
                <p class="clase-descripcion">
                    El HTML por sí solo es aburrido. En esta misión vamos a inyectarle estilo usando CSS. Aprenderemos a cambiar el <code>background-color</code>, modificar el tamaño de las letras y darle personalidad a nuestra interfaz.
                </p>
                <div class="clase-navegacion">
                    <button class="btn-nav inactivo">⬅ Anterior</button>
                    <button class="btn-nav activo" id="btn-siguiente">Siguiente Misión ➡</button>
                </div>
            </div>
        </section>

        <aside class="mapa-curso">
            <div class="curso-resumen">
                <img src="media/img/css.jpg" alt="Icono CSS" class="curso-icono-pequeño">
                <div>
                    <h2>Estilos CSS</h2>
                    <p id="texto-progreso">Progreso: <?php echo $progreso_usuario; ?>%</p>
                </div>
            </div>

            <div class="barra-progreso-bg">
                <div class="barra-progreso-fill" id="barra-progreso" style="width: <?php echo $progreso_usuario; ?>%;"></div>
            </div>

            <div class="modulos-lista">
                <a href="#" class="modulo-item" data-nivel="0">
                    <div class="modulo-icono">▶</div>
                    <div class="modulo-texto">
                        <h4>Nivel 1: Colores y Fuentes</h4>
                        <span>10 mins</span>
                    </div>
                </a>
                <a href="#" class="modulo-item bloqueado" data-nivel="1">
                    <div class="modulo-icono">🔒</div>
                    <div class="modulo-texto">
                        <h4>Nivel 2: El Modelo de Cajas</h4>
                        <span>Bloqueado</span>
                    </div>
                </a>
                <a href="#" class="modulo-item bloqueado" data-nivel="2">
                    <div class="modulo-icono">🔒</div>
                    <div class="modulo-texto">
                        <h4>Nivel 3: Magia con Flexbox</h4>
                        <span>Bloqueado</span>
                    </div>
                </a>
                <a href="#" class="modulo-item bloqueado" data-nivel="3">
                    <div class="modulo-icono">🔒</div>
                    <div class="modulo-texto">
                        <h4>Nivel 4: CSS Grid</h4>
                        <span>Bloqueado</span>
                    </div>
                </a>
                <a href="#" class="modulo-item bloqueado jefe-final" data-nivel="4">
                    <div class="modulo-icono">🐉</div>
                    <div class="modulo-texto">
                        <h4>Reto Final: Clonar Netflix</h4>
                        <span>Jefe Final</span>
                    </div>
                </a>
            </div>
        </aside>

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

    <script>const progresoInicial = <?php echo $progreso_usuario; ?>;</script>
    <script src="js/cursos.js"></script>
</body>
</html>
