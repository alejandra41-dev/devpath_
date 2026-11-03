-- ============================================================
-- setup.sql — Dev Path: Configuración de base de datos
-- Ejecutar una sola vez para agregar columnas y tablas nuevas.
-- ============================================================

-- ------------------------------------------------------------
-- 1. COLUMNAS EN TABLA usuarios (solo si no existen)
-- ------------------------------------------------------------
ALTER TABLE usuarios
    ADD COLUMN IF NOT EXISTS xp                INT DEFAULT 0,
    ADD COLUMN IF NOT EXISTS progreso_python   INT DEFAULT 0,
    ADD COLUMN IF NOT EXISTS progreso_html     INT DEFAULT 0,
    ADD COLUMN IF NOT EXISTS progreso_css      INT DEFAULT 0,
    ADD COLUMN IF NOT EXISTS progreso_javascript INT DEFAULT 0,
    ADD COLUMN IF NOT EXISTS progreso_react    INT DEFAULT 0,
    ADD COLUMN IF NOT EXISTS progreso_sql      INT DEFAULT 0,
    ADD COLUMN IF NOT EXISTS progreso_git      INT DEFAULT 0,
    ADD COLUMN IF NOT EXISTS progreso_cpp      INT DEFAULT 0,
    ADD COLUMN IF NOT EXISTS foto_perfil       VARCHAR(255) DEFAULT NULL;

-- ------------------------------------------------------------
-- 2. TABLA desafios (creada por profesores/admin)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS desafios (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    titulo        VARCHAR(200)                         NOT NULL,
    descripcion   TEXT,
    lenguaje      VARCHAR(50),
    dificultad    ENUM('facil', 'medio', 'dificil')   DEFAULT 'facil',
    xp_recompensa INT                                  DEFAULT 100,
    xp_minimo     INT                                  DEFAULT 0,
    profesor_id   INT,
    fecha         TIMESTAMP                            DEFAULT CURRENT_TIMESTAMP
);

-- Insertar desafíos de ejemplo si la tabla está vacía
INSERT INTO desafios (titulo, descripcion, lenguaje, dificultad, xp_recompensa, xp_minimo)
SELECT 'Centrar un Div', 'El clásico problema. Logra centrar un cuadrado perfecto tanto vertical como horizontalmente en la pantalla usando CSS.', 'css', 'facil', 50, 0
WHERE NOT EXISTS (SELECT 1 FROM desafios LIMIT 1);

INSERT INTO desafios (titulo, descripcion, lenguaje, dificultad, xp_recompensa, xp_minimo)
SELECT 'Calculadora de Vidas', 'Crea una función en JavaScript que calcule cuántos días has vivido ingresando tu fecha de nacimiento.', 'javascript', 'medio', 150, 100
WHERE NOT EXISTS (SELECT 1 FROM desafios WHERE titulo = 'Calculadora de Vidas');

INSERT INTO desafios (titulo, descripcion, lenguaje, dificultad, xp_recompensa, xp_minimo)
SELECT 'Fuga de Datos', 'Encuentra al usuario que robó los datos haciendo una consulta SQL compleja uniendo 3 tablas diferentes.', 'sql', 'dificil', 500, 500
WHERE NOT EXISTS (SELECT 1 FROM desafios WHERE titulo = 'Fuga de Datos');

-- ------------------------------------------------------------
-- 3. TABLA desafios_respuestas (respuestas de estudiantes)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS desafios_respuestas (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id  INT,
    desafio_id  INT,
    respuesta   TEXT,
    fecha       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_respuesta (usuario_id, desafio_id)
);

-- ------------------------------------------------------------
-- 4. TABLA tutoriales (subidos por profesores)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS tutoriales (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    titulo      VARCHAR(200)      NOT NULL,
    descripcion TEXT,
    url_video   VARCHAR(500),
    categoria   VARCHAR(50),
    profesor_id INT,
    fecha       TIMESTAMP         DEFAULT CURRENT_TIMESTAMP
);
