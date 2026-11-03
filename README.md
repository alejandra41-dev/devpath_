# Dev Path — Plataforma de Aprendizaje de Programación

Academia gamificada para aprender programación con cursos en video, sistema de XP, desafíos y roles de usuario.

---

## Instalación local

### Requisitos
- XAMPP, Laragon o cualquier servidor con PHP 7.4+ y MySQL 5.7+
- Navegador moderno

### Pasos
1. Clona o copia la carpeta del proyecto en `htdocs/` (XAMPP) o `www/` (Laragon)
2. Importa el esquema base en tu gestor de BD (PhpMyAdmin o MySQL CLI):
   ```sql
   CREATE DATABASE IF NOT EXISTS dev_path;
   USE dev_path;

   CREATE TABLE usuarios (
     id       INT AUTO_INCREMENT PRIMARY KEY,
     nombre   VARCHAR(100) NOT NULL,
     correo   VARCHAR(150) NOT NULL UNIQUE,
     password VARCHAR(255) NOT NULL,
     rol      ENUM('estudiante','profesor','admin') DEFAULT 'estudiante',
     xp       INT DEFAULT 0,
     progreso_python      INT DEFAULT 0,
     progreso_html        INT DEFAULT 0,
     progreso_css         INT DEFAULT 0,
     progreso_javascript  INT DEFAULT 0,
     progreso_react       INT DEFAULT 0,
     progreso_sql         INT DEFAULT 0,
     progreso_git         INT DEFAULT 0,
     progreso_cpp         INT DEFAULT 0,
     foto_perfil          VARCHAR(255) DEFAULT NULL
   );
   ```
3. Luego ejecuta `setup.sql` para crear las tablas de desafíos y tutoriales:
   ```bash
   mysql -u root -p dev_path < setup.sql
   ```
4. Edita `conexion.php` con tus credenciales locales:
   ```php
   $servidor   = "localhost";
   $usuario    = "root";
   $password   = "";
   $base_datos = "dev_path";
   ```
5. Accede a `http://localhost/dev-path/` en tu navegador.

---

## Estructura del proyecto

```
htdocs/
├── index.php               — Página de inicio
├── login.html / login.php  — Formulario y procesador de login
├── registro.php            — Registro de estudiantes
├── registro-profesor.php   — Registro de profesores
├── registro-admin.php      — Registro de admins
├── logout.php              — Cierre de sesión
├── aprender.php            — Rutas de aprendizaje (vista por rol)
├── perfil.php              — Perfil del usuario con XP y progreso
├── panel-admin.php         — Panel de administración de usuarios
├── panel-profesor.php      — Panel de profesores: tutoriales y desafíos
├── cambiar-rol.php         — Cambia rol de usuario (solo admin)
├── eliminar.php            — Elimina usuario (solo admin)
│
├── curso-python.php        — Curso de Python
├── curso-html.php          — Curso de HTML
├── curso-css.php           — Curso de CSS
├── curso-javascript.php    — Curso de JavaScript
├── curso-react.php         — Curso de React
├── curso-sql.php           — Curso de SQL
├── curso-git.php           — Curso de Git
├── curso-cpp.php           — Curso de C++
│
├── desafios.php            — Tablero de desafíos (con control XP)
├── desafio.php             — Página individual de un desafío
├── tutoriales.php          — Galería de tutoriales en video
│
├── guardar-progreso.php    — API: guarda progreso del curso en BD
├── guardar-respuesta.php   — API: guarda respuesta de desafío en BD
├── conexion.php            — Conexión a la base de datos
├── setup.sql               — Script SQL de inicialización de tablas
│
├── css/                    — Hojas de estilo por sección
├── js/
│   ├── main.js             — Lógica general (filtros, menú móvil)
│   ├── auth.js             — Mensajes de error del login
│   └── cursos.js           — Lógica de progreso y video de cursos
└── media/
    ├── img/                — Imágenes del proyecto
    └── videos/             — Videos de cursos (nivel1.mp4 ... nivel5.mp4)
        ├── python/
        ├── html/
        ├── css/
        ├── javascript/
        ├── react/
        ├── sql/
        ├── git/
        ├── cpp/
        └── tutoriales/
```

---

## Base de datos

| Tabla               | Descripción                                  |
|---------------------|----------------------------------------------|
| `usuarios`          | Usuarios con rol, XP y progreso por curso    |
| `desafios`          | Desafíos creados por profesores              |
| `desafios_respuestas` | Respuestas enviadas por estudiantes        |
| `tutoriales`        | Tutoriales en video subidos por profesores   |

### Roles de usuario

| Rol         | Acceso                                                  |
|-------------|----------------------------------------------------------|
| `estudiante`| Cursos, desafíos, tutoriales, perfil personal           |
| `profesor`  | Panel propio para subir tutoriales y crear desafíos     |
| `admin`     | Panel global: gestionar usuarios, cambiar roles         |

### Sistema de niveles (XP)

| Nivel | XP requerido | Nombre            |
|-------|-------------|-------------------|
| 1     | 0 – 499     | Cadete            |
| 2     | 500 – 1499  | Astronauta        |
| 3     | 1500 – 3499 | Explorador Avanzado |
| 4     | 3500+       | Maestro Espacial  |

---

## Videos

Los archivos de video deben ubicarse en:
```
media/videos/{curso}/nivel1.mp4
media/videos/{curso}/nivel2.mp4
...
```

Los cursos soportados son: `python`, `html`, `css`, `javascript`, `react`, `sql`, `git`, `cpp`.

Mientras no haya videos disponibles, los estudiantes pueden avanzar con el botón "Siguiente Misión".

---

## Deploy en producción (InfinityFree u otro hosting)

1. Sube todos los archivos por FTP (excluye `.env` del repo).
2. Crea la BD desde el panel del hosting y ejecuta `setup.sql`.
3. Actualiza `conexion.php` con las credenciales del hosting.
4. Verifica que el archivo `.htaccess` esté en la raíz para proteger `conexion.php`.
5. Sube los videos a `media/videos/{curso}/`.

---

## Seguridad

- Toda autenticación depende de **sesiones PHP** (no localStorage).
- Todas las consultas SQL usan **prepared statements** con `mysqli_prepare`.
- Las páginas privadas verifican `$_SESSION['usuario_id']` al inicio.
- El cambio de roles y eliminación de usuarios solo está disponible para admins.
