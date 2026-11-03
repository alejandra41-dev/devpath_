<?php
// desafio.php — Página individual de un desafío con textarea para entregar respuesta
    header('Content-Type: text/html; charset=utf-8');
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit();
}

include 'conexion.php';

$usuario_id = intval($_SESSION['usuario_id']);
$desafio_id = intval($_GET['id'] ?? 0);

if ($desafio_id <= 0) {
    header("Location: desafios.php");
    exit();
}

// Cargar datos del desafío desde BD
$desafio = null;
$tabla_existe = @mysqli_query($conexion, "SHOW TABLES LIKE 'desafios'");
if ($tabla_existe && mysqli_num_rows($tabla_existe) > 0) {
    $stmt = mysqli_prepare($conexion, "SELECT id, titulo, descripcion, lenguaje, dificultad, xp_recompensa, xp_minimo FROM desafios WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $desafio_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $d_id, $d_titulo, $d_desc, $d_lang, $d_dif, $d_xp, $d_xp_min);
    if (mysqli_stmt_fetch($stmt)) {
        $desafio = [
            'id'            => $d_id,
            'titulo'        => $d_titulo,
            'descripcion'   => $d_desc,
            'lenguaje'      => $d_lang,
            'dificultad'    => $d_dif,
            'xp_recompensa' => $d_xp,
            'xp_minimo'     => $d_xp_min
        ];
    }
    mysqli_stmt_close($stmt);
}

// Fallback: desafíos estáticos cuando la BD no tiene la tabla
// IDs deben coincidir exactamente con los links en desafios.php
if (!$desafio) {
    $estaticos = [
        1 => [
            'id'            => 1,
            'titulo'        => 'Centrar un Div',
            'descripcion'   => 'El clasico problema. Logra centrar un cuadrado perfecto tanto vertical como horizontalmente en la pantalla usando solo CSS.',
            'lenguaje'      => 'css',
            'dificultad'    => 'facil',
            'xp_recompensa' => 50,
            'xp_minimo'     => 0,
        ],
        2 => [
            'id'            => 2,
            'titulo'        => 'Calculadora de Vidas',
            'descripcion'   => 'Crea una funcion en JavaScript que calcule cuantos dias has vivido ingresando tu fecha de nacimiento.',
            'lenguaje'      => 'javascript',
            'dificultad'    => 'medio',
            'xp_recompensa' => 150,
            'xp_minimo'     => 100,
        ],
        3 => [
            'id'            => 3,
            'titulo'        => 'Fuga de Datos',
            'descripcion'   => 'Encuentra al usuario que robo los datos haciendo una consulta SQL compleja uniendo 3 tablas diferentes.',
            'lenguaje'      => 'sql',
            'dificultad'    => 'dificil',
            'xp_recompensa' => 500,
            'xp_minimo'     => 500,
        ],
        // ID 4: Minotauro — usado por el botón "Aceptar Misión" en desafios.php
        4 => [
            'id'            => 4,
            'titulo'        => 'El Laberinto del Minotauro',
            'descripcion'   => 'Escribe en Python un algoritmo que encuentre la salida más rápida de un laberinto representado como una matriz 2D. El laberinto tiene paredes (1), caminos libres (0) y una salida marcada con (9). Debes implementar BFS o DFS para encontrar el camino más corto.',
            'lenguaje'      => 'python',
            'dificultad'    => 'dificil',
            'xp_recompensa' => 500,
            'xp_minimo'     => 0,
        ],
    ];
    $desafio = $estaticos[$desafio_id] ?? null;
}

if (!$desafio) {
    header("Location: desafios.php");
    exit();
}

// Verificar que el usuario tiene suficiente XP
$stmt_xp = mysqli_prepare($conexion, "SELECT xp FROM usuarios WHERE id = ?");
mysqli_stmt_bind_param($stmt_xp, "i", $usuario_id);
mysqli_stmt_execute($stmt_xp);
mysqli_stmt_bind_result($stmt_xp, $xp_usuario);
mysqli_stmt_fetch($stmt_xp);
mysqli_stmt_close($stmt_xp);

if (intval($xp_usuario) < intval($desafio['xp_minimo'])) {
    header("Location: desafios.php?error=bloqueado");
    exit();
}

// Verificar si ya fue completado
$ya_completado = false;
$tabla_resp = @mysqli_query($conexion, "SHOW TABLES LIKE 'desafios_respuestas'");
if ($tabla_resp && mysqli_num_rows($tabla_resp) > 0) {
    $stmt_c = mysqli_prepare($conexion, "SELECT id FROM desafios_respuestas WHERE usuario_id = ? AND desafio_id = ?");
    mysqli_stmt_bind_param($stmt_c, "ii", $usuario_id, $desafio_id);
    mysqli_stmt_execute($stmt_c);
    mysqli_stmt_bind_result($stmt_c, $resp_id);
    $ya_completado = (bool) mysqli_stmt_fetch($stmt_c);
    mysqli_stmt_close($stmt_c);
}

$dificultad_label = $desafio['dificultad'] === 'facil' ? '⭐ Fácil' : ($desafio['dificultad'] === 'medio' ? '⭐⭐ Medio' : '⭐⭐⭐ Difícil');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($desafio['titulo']); ?> - Dev Path</title>
    <link rel="icon" type="image/png" href="media/img/logos.png">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/desafios.css">
    <style>
        .desafio-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: var(--card-bg, #1a1a2e);
            border-radius: 16px;
            border: 1px solid rgba(255,255,255,0.1);
        }
        .desafio-meta {
            display: flex;
            gap: 1rem;
            margin: 1rem 0;
            flex-wrap: wrap;
        }
        .desafio-descripcion {
            line-height: 1.8;
            margin: 1.5rem 0;
            opacity: 0.9;
        }
        .respuesta-area {
            width: 100%;
            min-height: 200px;
            padding: 1rem;
            background: #0a0a1a;
            border: 2px solid rgba(255,255,255,0.2);
            border-radius: 8px;
            color: #e0e0ff;
            font-family: 'Courier New', monospace;
            font-size: 0.95rem;
            resize: vertical;
            box-sizing: border-box;
        }
        .respuesta-area:focus {
            outline: none;
            border-color: var(--accent-blue, #3498db);
        }
        .btn-entregar {
            display: inline-block;
            margin-top: 1rem;
            padding: 0.9rem 2rem;
            background: linear-gradient(135deg, #00b894, #00cec9);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            font-size: 1rem;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-entregar:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,184,148,0.4);
        }
        .btn-entregar:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        #mensaje-resultado {
            display: none;
            margin-top: 1.5rem;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            font-weight: bold;
            text-align: center;
        }
        .msg-exito  { background: rgba(46,213,115,0.2); border: 1px solid #2ed573; color: #2ed573; }
        .msg-error  { background: rgba(255,71,87,0.2);  border: 1px solid #ff4757; color: #ff4757; }
        .completado-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            background: rgba(46,213,115,0.2);
            border: 1px solid #2ed573;
            color: #2ed573;
            border-radius: 8px;
            font-weight: bold;
            margin: 1rem 0;
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
            <a href="desafios.php" style="color: var(--accent-blue);">Desafíos</a>
            <a href="perfil.php">👤 <?php echo htmlspecialchars($_SESSION['nombre']); ?></a>
            <a href="logout.php" class="btn-ingresar" style="background: #ff4757;">Salir</a>
        </nav>
    </header>

    <main style="padding: 1rem;">
        <div class="desafio-container">

            <a href="desafios.php" style="opacity:0.7; font-size:0.9rem;">← Volver al Tablero</a>

            <h1 style="margin-top: 1rem;"><?php echo htmlspecialchars($desafio['titulo']); ?></h1>

            <div class="desafio-meta">
                <span class="lenguaje-badge <?php echo htmlspecialchars($desafio['lenguaje']); ?>">
                    <?php echo strtoupper(htmlspecialchars($desafio['lenguaje'])); ?>
                </span>
                <span class="dificultad <?php echo $desafio['dificultad']; ?>">
                    <?php echo $dificultad_label; ?>
                </span>
                <span class="xp-ganancia">⭐ +<?php echo $desafio['xp_recompensa']; ?> XP</span>
            </div>

            <p class="desafio-descripcion"><?php echo nl2br(htmlspecialchars($desafio['descripcion'])); ?></p>

            <?php if ($ya_completado): ?>
                <div class="completado-badge">✅ Ya completaste este desafío</div>
            <?php endif; ?>

            <div>
                <label for="respuesta" style="font-weight: bold; display: block; margin-bottom: 0.5rem;">
                    Tu Solución (escribe tu código aquí):
                </label>
                <textarea
                    id="respuesta"
                    class="respuesta-area"
                    placeholder="// Escribe tu solución en <?php echo htmlspecialchars($desafio['lenguaje']); ?>..."
                    <?php echo $ya_completado ? 'disabled' : ''; ?>
                ></textarea>
            </div>

            <?php if (!$ya_completado): ?>
            <button class="btn-entregar" id="btn-entregar" onclick="entregarRespuesta()">
                🚀 Entregar Misión
            </button>
            <?php endif; ?>

            <div id="mensaje-resultado"></div>
        </div>
    </main>

    <footer class="site-footer">
        <div class="footer-content">
            <div class="footer-logo">
                <img src="media/img/logos.png" alt="Dev Path Logo">
                <span>Dev Path</span>
            </div>
            <p class="copyright">&copy; 2026 Dev Path. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script>
    // Envía la respuesta al servidor vía fetch (sin recargar la página)
    function entregarRespuesta() {
        const respuesta = document.getElementById('respuesta').value.trim();
        const btn       = document.getElementById('btn-entregar');
        const msgBox    = document.getElementById('mensaje-resultado');

        if (!respuesta) {
            msgBox.textContent = 'Debes escribir tu solución antes de entregar.';
            msgBox.className   = 'msg-error';
            msgBox.style.display = 'block';
            return;
        }

        btn.disabled     = true;
        btn.textContent  = '⏳ Enviando...';

        const formData = new FormData();
        formData.append('desafio_id', <?php echo $desafio['id']; ?>);
        formData.append('respuesta',  respuesta);

        fetch('guardar-respuesta.php', {
            method: 'POST',
            body: formData
        })
        .then(r => r.json())
        .then(data => {
            if (data.ok) {
                msgBox.textContent   = '🎉 ' + data.mensaje;
                msgBox.className     = 'msg-exito';
                msgBox.style.display = 'block';
                btn.textContent      = '✅ Entregado';
                document.getElementById('respuesta').disabled = true;
            } else {
                msgBox.textContent   = '❌ ' + (data.error || 'Error al enviar.');
                msgBox.className     = 'msg-error';
                msgBox.style.display = 'block';
                btn.disabled         = false;
                btn.textContent      = '🚀 Entregar Misión';
            }
        })
        .catch(() => {
            msgBox.textContent   = '❌ Error de conexión. Intenta de nuevo.';
            msgBox.className     = 'msg-error';
            msgBox.style.display = 'block';
            btn.disabled         = false;
            btn.textContent      = '🚀 Entregar Misión';
        });
    }
    </script>

</body>
</html>
