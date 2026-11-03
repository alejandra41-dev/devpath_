<?php
// desafios.php — Tablero de misiones con desafíos desde BD y control de sesión
    header('Content-Type: text/html; charset=utf-8');
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit();
}

include 'conexion.php';

$usuario_id = intval($_SESSION['usuario_id']);

// Obtener XP actual del usuario para filtrar desafíos bloqueados
$stmt = mysqli_prepare($conexion, "SELECT xp FROM usuarios WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $usuario_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $xp_usuario);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);
$xp_usuario = intval($xp_usuario);

// Cargar desafíos de la BD si la tabla existe
// Nota: usamos bind_result (compatible con InfinityFree sin mysqlnd)
$desafios = [];
$tabla_existe = @mysqli_query($conexion, "SHOW TABLES LIKE 'desafios'");
if ($tabla_existe && mysqli_num_rows($tabla_existe) > 0) {
    $stmt2 = mysqli_prepare($conexion,
        "SELECT id, titulo, descripcion, lenguaje, dificultad, xp_recompensa, xp_minimo
         FROM desafios ORDER BY xp_minimo ASC, id ASC"
    );
    mysqli_stmt_execute($stmt2);
    mysqli_stmt_bind_result($stmt2, $d_id, $d_titulo, $d_desc, $d_lang, $d_dif, $d_xp_r, $d_xp_m);
    while (mysqli_stmt_fetch($stmt2)) {
        $desafios[] = [
            'id'            => $d_id,
            'titulo'        => $d_titulo,
            'descripcion'   => $d_desc,
            'lenguaje'      => $d_lang,
            'dificultad'    => $d_dif,
            'xp_recompensa' => $d_xp_r,
            'xp_minimo'     => $d_xp_m,
        ];
    }
    mysqli_stmt_close($stmt2);
}

// Obtener IDs de desafíos ya completados por el usuario
$completados = [];
$tabla_resp = @mysqli_query($conexion, "SHOW TABLES LIKE 'desafios_respuestas'");
if ($tabla_resp && mysqli_num_rows($tabla_resp) > 0) {
    $stmt3 = mysqli_prepare($conexion,
        "SELECT desafio_id FROM desafios_respuestas WHERE usuario_id = ?"
    );
    mysqli_stmt_bind_param($stmt3, "i", $usuario_id);
    mysqli_stmt_execute($stmt3);
    mysqli_stmt_bind_result($stmt3, $comp_id);
    while (mysqli_stmt_fetch($stmt3)) {
        $completados[] = intval($comp_id);
    }
    mysqli_stmt_close($stmt3);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desafíos - Dev Path</title>
    <link rel="icon" type="image/png" href="media/img/logos.png">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/desafios.css">
</head>
<body>

    <header>
        <a href="index.php" class="logo-container">
            <img src="media/img/logos.png" alt="Dev Path Logo">
            <div class="logo-text">Dev<br><span>Path</span></div>
        </a>
        <nav class="nav-links">
            <a href="aprender.php">Aprender</a>
            <a href="desafios.php" style="color: var(--accent-blue);">Desafíos</a>
            <a href="teoria.php">Teoría</a>
            <a href="tutoriales.php">Tutoriales</a>
            <a href="perfil.php">👤 <?php echo htmlspecialchars($_SESSION['nombre']); ?></a>
            <a href="logout.php" class="btn-ingresar" style="background: #ff4757;">Salir</a>
        </nav>
    </header>

    <main class="desafios-main">

        <div class="desafios-header">
            <h1 class="page-title">Tablero de Misiones</h1>
            <p>Pon a prueba tus habilidades. XP actual: <strong>⭐ <?php echo $xp_usuario; ?></strong></p>
        </div>

        <!-- Desafío diario destacado -->
        <!-- ID=4 corresponde al Laberinto del Minotauro en el fallback estático -->
        <section class="mision-destacada">
            <div class="mision-destacada-info">
                <span class="etiqueta-diaria">🔥 Desafío Diario</span>
                <h2>El Laberinto del Minotauro (Python)</h2>
                <p>Escribe un algoritmo que encuentre la salida más rápida de un laberinto representado en una matriz 2D. Tienes 24 horas antes de que la misión expire.</p>
                <div class="recompensas">
                    <span>Recompensa:</span>
                    <span class="xp-ganancia">⭐ +500 XP</span>
                </div>
                <!-- ID=4: Minotauro es el 4.º desafío en el fallback estático -->
                <a href="desafio.php?id=4" class="btn-aceptar-mision">Aceptar Misión</a>
            </div>
            <div class="mision-destacada-img">
                <img src="media/img/luna.gif" alt="Luna animada">
            </div>
        </section>

        <h2 class="subtitulo-seccion">Misiones Disponibles</h2>

        <div class="retos-grid">

            <?php if (!empty($desafios)): ?>
                <!-- Desafíos cargados desde la BD -->
                <?php foreach ($desafios as $d):
                    $bloqueado  = $xp_usuario < $d['xp_minimo'];
                    $completado = in_array(intval($d['id']), $completados);
                    $clase_dif  = $d['dificultad'] === 'facil' ? 'facil' : ($d['dificultad'] === 'medio' ? 'media' : 'dificil');
                    $estrellas  = $d['dificultad'] === 'facil' ? '⭐ Fácil' : ($d['dificultad'] === 'medio' ? '⭐⭐ Medio' : '⭐⭐⭐ Difícil');
                ?>
                <div class="reto-card <?php echo $bloqueado ? 'bloqueado' : ''; ?>">
                    <div class="reto-header">
                        <span class="lenguaje-badge <?php echo htmlspecialchars($d['lenguaje']); ?>"><?php echo strtoupper(htmlspecialchars($d['lenguaje'])); ?></span>
                        <span class="dificultad <?php echo $clase_dif; ?>"><?php echo $estrellas; ?></span>
                    </div>
                    <h3><?php echo htmlspecialchars($d['titulo']); ?></h3>
                    <p><?php echo htmlspecialchars($d['descripcion']); ?></p>
                    <div class="reto-footer">
                        <?php if ($completado): ?>
                            <span style="color: #2ed573;">✅ Completado</span>
                        <?php elseif ($bloqueado): ?>
                            <span class="candado">🔒 Requiere <?php echo $d['xp_minimo']; ?> XP</span>
                        <?php else: ?>
                            <span class="xp-ganancia">⭐ +<?php echo $d['xp_recompensa']; ?> XP</span>
                            <a href="desafio.php?id=<?php echo $d['id']; ?>" class="btn-jugar">Jugar</a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>

            <?php else: ?>
                <!-- Desafíos estáticos de fallback (si la BD no tiene la tabla aún) -->
                <div class="reto-card">
                    <div class="reto-header">
                        <span class="lenguaje-badge html">HTML/CSS</span>
                        <span class="dificultad facil">⭐ Fácil</span>
                    </div>
                    <h3>Centrar un Div</h3>
                    <p>El clásico problema. Logra centrar un cuadrado perfecto tanto vertical como horizontalmente en la pantalla.</p>
                    <div class="reto-footer">
                        <span class="xp-ganancia">⭐ +50 XP</span>
                        <a href="desafio.php?id=1" class="btn-jugar">Jugar</a>
                    </div>
                </div>

                <div class="reto-card">
                    <div class="reto-header">
                        <span class="lenguaje-badge js">JavaScript</span>
                        <span class="dificultad media">⭐⭐ Medio</span>
                    </div>
                    <h3>Calculadora de Vidas</h3>
                    <p>Crea una función que calcule cuántos días has vivido ingresando tu fecha de nacimiento.</p>
                    <div class="reto-footer">
                        <span class="xp-ganancia">⭐ +150 XP</span>
                        <a href="desafio.php?id=2" class="btn-jugar">Jugar</a>
                    </div>
                </div>

                <?php if ($xp_usuario >= 500): ?>
                <div class="reto-card">
                    <div class="reto-header">
                        <span class="lenguaje-badge sql">SQL</span>
                        <span class="dificultad dificil">⭐⭐⭐ Difícil</span>
                    </div>
                    <h3>Fuga de Datos</h3>
                    <p>Encuentra al usuario que robó los datos haciendo una consulta compleja uniendo 3 tablas diferentes.</p>
                    <div class="reto-footer">
                        <span class="xp-ganancia">⭐ +500 XP</span>
                        <a href="desafio.php?id=3" class="btn-jugar">Jugar</a>
                    </div>
                </div>
                <?php else: ?>
                <div class="reto-card bloqueado">
                    <div class="reto-header">
                        <span class="lenguaje-badge sql">SQL</span>
                        <span class="dificultad dificil">⭐⭐⭐ Difícil</span>
                    </div>
                    <h3>Fuga de Datos</h3>
                    <p>Encuentra al usuario que robó los datos haciendo una consulta compleja uniendo 3 tablas diferentes.</p>
                    <div class="reto-footer">
                        <span class="candado">🔒 Requiere 500 XP</span>
                    </div>
                </div>
                <?php endif; ?>
            <?php endif; ?>

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

</body>
</html>
