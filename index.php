<?php
// Esto va en la línea 1 para encender la memoria de la sesión
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dev Path</title>
    <link rel="icon" type="image/png" href="media/img/logos.png">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
<header>
        <a href="index.php" class="logo-container">
            <img src="media/img/logos.png" alt="Dev Path Logo">
            <div class="logo-text">
                Dev<br><span>Path</span>
            </div>
        </a>

<button class="menu-hamburguesa" id="btn-menu">☰</button>    
       <nav class="nav-links" id="nav-menu">
            <a href="aprender.php">Aprender</a>
            <a href="desafios.php">Desafíos</a>
            <a href="teoria.php">Teoría</a>
            <a href="tutoriales.php">Tutoriales</a>
            
            <?php 
            // Menú inteligente: Si ya entraste, ves tu perfil. Si no, ves los botones de acceso.
            if (isset($_SESSION['usuario_id'])) { 
            ?>
                <a href="perfil.php">👤 <?php echo $_SESSION['nombre']; ?></a>
                <a href="logout.php" class="btn-ingresar" style="background: #ff4757;">Salir</a>
            <?php } else { ?>
                <a href="login.html" class="btn-ingresar">Ingresar</a>
                <a href="roles.html" class="btn-ingresar" style="background: var(--accent-blue);">Registrarse</a>
            <?php } ?>
        </nav>
    </header>

    <main>
        <section class="hero-section">
            <div class="hero-container">
                <article class="hero-card">
                    <p>Para que puedas empezar tu dulce aventura y ver la codificación de manera divertida</p>
                    
                    <?php if (!isset($_SESSION['usuario_id'])) { ?>
                        <a class="btn-hero" href="roles.html">Ingresa para tener acceso a todo</a>
                    <?php } else { ?>
                        <a class="btn-hero" href="aprender.php">Continuar mi aventura</a>
                    <?php } ?>
                    
                </article>
            </div>
        </section>
        
       <section class="menu-cursos">
            <h2 class="diviertete">Diviértete aprendiendo</h2>
            <p class="aventura">¿En cuál aventura te gustaría participar?</p>

            <input type="radio" id="popular" name="menu" checked>
            <input type="radio" id="webdev" name="menu">
            <input type="radio" id="datasci" name="menu">
            <input type="radio" id="tools" name="menu">

            <div class="menu-cursos-botones">
                <label for="popular">Popular</label>
                <label for="webdev">Desarrollo de web</label>
                <label for="datasci">Ciencia de datos</label>
                <label for="tools">Herramientas</label>
            </div>
        
            <div class="cursos-cards" id="cursos-popular">
                <div class="card">
                    <img src="media/img/python.jpg" alt="Python" class="card-img">
                    <div class="card-content">
                        <div>
                            <div class="card-title">Python</div>
                            <div class="card-desc">Aprende fundamentos de programación como variables, control de flujo y bucles.</div>
                        </div>
                        <div class="card-footer">
                            <span class="card-badge">Basico</span>
                            <a href="curso-python.php" class="card-link">Ir al curso</a>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <img src="media/img/html.jpg" alt="HTML" class="card-img">
                    <div class="card-content">
                        <div>
                            <div class="card-title">HTML</div>
                            <div class="card-desc">Aprende los fundamentos de HTML, la estructura básica de la web.</div>
                        </div>
                        <div class="card-footer">
                            <span class="card-badge">Basico</span>
                            <a href="curso-html.php" class="card-link">Ir al curso</a>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <img src="media/img/css.jpg" alt="CSS" class="card-img">
                    <div class="card-content">
                        <div>
                            <div class="card-title">CSS</div>
                            <div class="card-desc">Aprende los fundamentos de CSS, el estilo de la web.</div>
                        </div>
                        <div class="card-footer">
                            <span class="card-badge">Basico</span>
                            <a href="curso-css.php" class="card-link">Ir al curso</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="cursos-cards" id="cursos-webdev">
                <div class="card">
                    <img src="media/img/javascript.jpg" alt="JavaScript" class="card-img">
                    <div class="card-content">
                        <div>
                            <div class="card-title">JavaScript</div>
                            <div class="card-desc">Aprende los fundamentos de JavaScript, el lenguaje de programación de la web.</div>
                        </div>
                        <div class="card-footer">
                            <span class="card-badge">Basico</span>
                            <a href="curso-javascript.php" class="card-link">Ir al curso</a>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <img src="media/img/react.jpg" alt="React" class="card-img">
                    <div class="card-content">
                        <div>
                            <div class="card-title">React</div>
                            <div class="card-desc">Aprende los fundamentos de React, la biblioteca para construir interfaces de usuario.</div>
                        </div>
                        <div class="card-footer">
                            <span class="card-badge">Intermedio</span>
                            <a href="curso-react.php" class="card-link">Ir al curso</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="cursos-cards" id="cursos-datasci">
                <div class="card">
                    <img src="media/img/sql.gif" alt="SQL" class="card-img">
                    <div class="card-content">
                        <div>
                            <div class="card-title">SQL</div>
                            <div class="card-desc">Aprende los fundamentos de SQL, el lenguaje de consulta para bases de datos.</div>
                        </div>
                        <div class="card-footer">
                            <span class="card-badge">Basico</span>
                            <a href="curso-sql.php" class="card-link">Ir al curso</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="cursos-cards" id="cursos-tools">
                <div class="card">
                    <img src="media/img/git.jpg" alt="Git" class="card-img">
                    <div class="card-content">
                        <div>
                            <div class="card-title">Git & GitHub</div>
                            <div class="card-desc">Aprende a usar Git y GitHub, las herramientas de control de versiones.</div>
                        </div>
                        <div class="card-footer">
                            <span class="card-badge">Intermedio</span>
                            <a href="curso-git.php" class="card-link">Ir al curso</a>
                        </div>
                    </div>
                </div> 
                <div class="card">
                    <img src="media/img/C++.jpg" alt="C++" class="card-img">
                    <div class="card-content">
                        <div>
                            <div class="card-title">C++</div>
                            <div class="card-desc">Aprende los fundamentos de C++, uno de los lenguajes de programación más populares.</div>
                        </div>
                        <div class="card-footer">
                            <span class="card-badge">Basico</span>
                            <a href="curso-cpp.php" class="card-link">Ir al curso</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="game-features-section">
            <div class="glass-panel">
                <h2 class="game-title">Explora la magia de aprender mientras juegas</h2>
                
                <div class="features-grid">
                    <div class="feature-box">
                        <div class="feature-icon">🎮</div>
                        <h3>Desafíos Interactivos</h3>
                        <p>Practica tu codificación con desafíos reales. Escribe código, corrige errores y ve tus resultados al instante.</p>
                    </div>

                    <div class="feature-box">
                        <div class="feature-icon">⭐</div>
                        <h3>Sube de Nivel</h3>
                        <p>Completa módulos para ganar experiencia, desbloquear nuevos lenguajes y convertirte en un Maestro del Código.</p>
                    </div>

                    <div class="feature-box">
                        <div class="feature-icon">🤝</div>
                        <h3>Juega con Amigos</h3>
                        <p>No aprendas solo. Conéctate con tus amigos, compitan en las tablas de clasificación y estudien juntos.</p>
                    </div>
                </div>
            </div>
        </section>
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