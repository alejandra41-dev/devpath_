<?php
// teoria/contenido.php — Datos de todos los temas de teoría
// Se incluye desde teoria.php, NO se accede directamente.

$temas = [

// ═══════════════════════════════════════════════════════
// PYTHON
// ═══════════════════════════════════════════════════════
'python' => [
    'nombre' => 'Python',
    'color'  => '#3776ab',
    'icono'  => '🐍',
    'temas'  => [

        'intro' => [
            'titulo' => 'Introducción a Python',
            'desc'   => '¿Qué es Python y por qué aprenderlo?',
            'contenido' => '
<h2>¿Qué es Python?</h2>
<p>Python es un lenguaje de programación de propósito general creado por Guido van Rossum en 1991. Es famoso por su sintaxis limpia y legible — casi parece pseudocódigo en inglés. Lo usan desde principiantes hasta empresas como Google, Netflix e Instagram.</p>
<ul>
    <li><strong>Fácil de leer:</strong> No necesitas punto y coma ni llaves para delimitar bloques.</li>
    <li><strong>Versátil:</strong> Sirve para web, ciencia de datos, IA, automatización, juegos y más.</li>
    <li><strong>Gran comunidad:</strong> Millones de librerías disponibles en <a href="#" style="color:var(--accent-blue)">PyPI</a>.</li>
</ul>
<div class="caja-codigo">
<pre><code># Tu primer programa en Python
print("¡Hola, Dev Path!")

# Python no necesita llaves ni punto y coma
nombre = "Peppa"
print("Bienvenida,", nombre)</code></pre>
</div>
<div class="mini-ejercicio">
<h4>Mini ejercicio</h4>
<p>Modifica el código para que imprima tu nombre y tu lenguaje favorito en dos líneas separadas.</p>
</div>
<div class="buenas-practicas">
<h4>Buenas prácticas</h4>
<ul>
    <li>Usa Python 3 (Python 2 está obsoleto).</li>
    <li>Instala VS Code + extensión Python para empezar.</li>
    <li>Ejecuta scripts con <code>python nombre_archivo.py</code> desde la terminal.</li>
</ul>
</div>',
        ],

        'variables' => [
            'titulo' => 'Variables y tipos de datos',
            'desc'   => 'Cómo guardar y manipular información.',
            'contenido' => '
<h2>Variables: las cajas mágicas</h2>
<p>Una variable es un nombre que apunta a un valor en la memoria. En Python no necesitas declarar el tipo — Python lo deduce solo.</p>
<div class="caja-codigo">
<pre><code># Tipos básicos
nombre    = "Peppa"        # str  (texto)
vidas     = 3              # int  (entero)
velocidad = 9.8            # float (decimal)
activo    = True           # bool (verdadero/falso)

# Python infiere el tipo
print(type(nombre))    # &lt;class \'str\'&gt;
print(type(vidas))     # &lt;class \'int\'&gt;</code></pre>
</div>
<h3>Conversión de tipos</h3>
<div class="caja-codigo">
<pre><code>edad_texto = "25"
edad_numero = int(edad_texto)   # "25" → 25
precio = float("19.99")         # "19.99" → 19.99
texto  = str(42)                # 42 → "42"</code></pre>
</div>
<div class="mini-ejercicio">
<h4>Mini ejercicio</h4>
<p>Crea variables para: tu nombre, tu edad, tu estatura y si tienes mascota. Luego imprime cada una con su tipo usando <code>type()</code>.</p>
</div>
<div class="buenas-practicas">
<h4>Buenas prácticas</h4>
<ul>
    <li>Usa <code>snake_case</code> para nombres de variables: <code>mi_nombre</code>, no <code>miNombre</code>.</li>
    <li>Nombres descriptivos: <code>velocidad_maxima</code> en lugar de <code>v</code>.</li>
    <li>Constantes en MAYÚSCULAS: <code>MAX_VIDAS = 5</code>.</li>
</ul>
</div>',
        ],

        'condicionales' => [
            'titulo' => 'Condicionales if / elif / else',
            'desc'   => 'Tomar decisiones en el código.',
            'contenido' => '
<h2>Tomando decisiones</h2>
<p>Los condicionales permiten ejecutar código solo si se cumple una condición. Son los guardias de seguridad del programa.</p>
<div class="caja-codigo">
<pre><code>vidas = 3

if vidas == 0:
    print("Game Over")
elif vidas == 1:
    print("¡Cuidado! Última vida")
else:
    print(f"Vidas restantes: {vidas}")</code></pre>
</div>
<h3>Operadores de comparación</h3>
<div class="caja-codigo">
<pre><code>x = 10
print(x == 10)   # True  — igual
print(x != 5)    # True  — diferente
print(x > 8)     # True  — mayor
print(x < 8)     # False — menor
print(x >= 10)   # True  — mayor o igual
print(x <= 9)    # False — menor o igual</code></pre>
</div>
<h3>Operadores lógicos</h3>
<div class="caja-codigo">
<pre><code>xp = 500
nivel = 3

# and: ambas deben ser True
if xp >= 500 and nivel >= 3:
    print("Desbloqueaste el jefe final")

# or: al menos una debe ser True
if xp >= 1000 or nivel >= 5:
    print("Eres un maestro")

# not: invierte el resultado
if not activo:
    print("Usuario inactivo")</code></pre>
</div>
<div class="mini-ejercicio">
<h4>Mini ejercicio</h4>
<p>Crea un sistema de clasificación: si el XP es mayor a 1000 imprime "Maestro", si es mayor a 500 imprime "Avanzado", si no imprime "Principiante".</p>
</div>',
        ],

        'bucles' => [
            'titulo' => 'Bucles for y while',
            'desc'   => 'Repetir tareas sin escribir código duplicado.',
            'contenido' => '
<h2>Bucles: la repetición sin sufrimiento</h2>
<p>Un bucle ejecuta un bloque de código múltiples veces. Las computadoras son perfectas para tareas repetitivas — aprovéchalo.</p>
<h3>Bucle for</h3>
<div class="caja-codigo">
<pre><code># Iterar un rango de números
for i in range(1, 6):
    print(f"Nivel {i}")

# range(inicio, fin, paso)
for i in range(0, 11, 2):   # 0, 2, 4, 6, 8, 10
    print(i)

# Iterar una lista
lenguajes = ["Python", "JS", "CSS"]
for lang in lenguajes:
    print(f"Aprendiendo {lang}")</code></pre>
</div>
<h3>Bucle while</h3>
<div class="caja-codigo">
<pre><code>vidas = 3

while vidas > 0:
    print(f"Jugando... vidas: {vidas}")
    vidas -= 1   # Equivale a vidas = vidas - 1

print("Game Over")</code></pre>
</div>
<h3>break y continue</h3>
<div class="caja-codigo">
<pre><code>for i in range(10):
    if i == 5:
        break       # Sale del bucle completamente
    if i % 2 == 0:
        continue    # Salta al siguiente ciclo
    print(i)        # Solo imprime impares menores a 5: 1, 3</code></pre>
</div>
<div class="mini-ejercicio">
<h4>Mini ejercicio</h4>
<p>Usa un bucle <code>for</code> con <code>range()</code> para calcular la suma de todos los números del 1 al 100. Pista: crea una variable <code>total = 0</code> y ve sumando en cada iteración.</p>
</div>',
        ],

        'funciones' => [
            'titulo' => 'Funciones',
            'desc'   => 'Bloques de código reutilizables.',
            'contenido' => '
<h2>Funciones: hechizos reutilizables</h2>
<p>Una función es un bloque de código con nombre que puedes invocar cuando quieras. Evita repetir código y hace tu programa más ordenado.</p>
<div class="caja-codigo">
<pre><code># Definir una función
def saludar(nombre):
    return f"¡Hola, {nombre}!"

# Llamar la función
mensaje = saludar("Peppa")
print(mensaje)   # ¡Hola, Peppa!</code></pre>
</div>
<h3>Parámetros y valores por defecto</h3>
<div class="caja-codigo">
<pre><code>def calcular_xp(nivel, multiplicador=1.5):
    """Calcula el XP según el nivel y un multiplicador."""
    return nivel * 100 * multiplicador

print(calcular_xp(3))         # 450.0
print(calcular_xp(3, 2.0))    # 600.0</code></pre>
</div>
<h3>Múltiples valores de retorno</h3>
<div class="caja-codigo">
<pre><code>def dividir(a, b):
    if b == 0:
        return None, "Error: división por cero"
    return a / b, "OK"

resultado, estado = dividir(10, 2)
print(resultado, estado)   # 5.0 OK</code></pre>
</div>
<div class="mini-ejercicio">
<h4>Mini ejercicio</h4>
<p>Crea una función <code>nivel_usuario(xp)</code> que reciba XP y devuelva el nivel: "Cadete" (0-499), "Astronauta" (500-1499), "Explorador" (1500-3499), "Maestro" (3500+).</p>
</div>',
        ],

        'listas' => [
            'titulo' => 'Listas y diccionarios',
            'desc'   => 'Las estructuras de datos más usadas en Python.',
            'contenido' => '
<h2>Listas: el inventario del héroe</h2>
<p>Una lista guarda múltiples valores en orden, como un inventario de videojuego.</p>
<div class="caja-codigo">
<pre><code>inventario = ["espada", "escudo", "poción"]

# Acceder por índice (empieza en 0)
print(inventario[0])    # "espada"
print(inventario[-1])   # "poción" (último)

# Modificar
inventario.append("llave")    # Agrega al final
inventario.remove("escudo")   # Elimina el primero encontrado
inventario.insert(1, "arco")  # Inserta en posición 1

print(len(inventario))   # Cantidad de elementos</code></pre>
</div>
<h2>Diccionarios: el archivo de personajes</h2>
<p>Un diccionario guarda pares clave:valor, como un archivo de identidad.</p>
<div class="caja-codigo">
<pre><code>jugador = {
    "nombre": "Peppa",
    "nivel":  5,
    "xp":     1250,
    "activo": True
}

# Acceder
print(jugador["nombre"])          # "Peppa"
print(jugador.get("xp", 0))       # 1250 (con valor por defecto)

# Modificar / Agregar
jugador["xp"] += 100
jugador["clan"] = "Dev Path"

# Iterar
for clave, valor in jugador.items():
    print(f"{clave}: {valor}")</code></pre>
</div>
<div class="mini-ejercicio">
<h4>Mini ejercicio</h4>
<p>Crea una lista de 5 cursos y un diccionario con tu progreso en cada uno (0-100). Luego imprime solo los cursos con progreso mayor a 50%.</p>
</div>',
        ],

        'cadenas' => [
            'titulo' => 'Cadenas de texto (Strings)',
            'desc'   => 'Manipulación de texto en Python.',
            'contenido' => '
<h2>Strings: el lenguaje del código</h2>
<p>El texto es uno de los tipos de datos más usados. Python tiene decenas de métodos para manipularlo.</p>
<div class="caja-codigo">
<pre><code>texto = "  Hola Dev Path  "

# Métodos básicos
print(texto.strip())       # "Hola Dev Path" (quita espacios)
print(texto.upper())       # "  HOLA DEV PATH  "
print(texto.lower())       # "  hola dev path  "
print(texto.replace("Dev Path", "Mundo"))  # "  Hola Mundo  "
print(texto.split())       # ["Hola", "Dev", "Path"]</code></pre>
</div>
<h3>f-strings (la forma moderna)</h3>
<div class="caja-codigo">
<pre><code>nombre = "Peppa"
xp     = 1250
nivel  = 3

# f-string: escribe variables directamente en el texto
mensaje = f"Jugador: {nombre} | Nivel: {nivel} | XP: {xp:,}"
print(mensaje)   # Jugador: Peppa | Nivel: 3 | XP: 1,250

# Operaciones dentro de la f-string
print(f"El doble de XP sería: {xp * 2}")</code></pre>
</div>
<h3>Slicing: cortar strings</h3>
<div class="caja-codigo">
<pre><code>texto = "Python es genial"
#        0123456789...

print(texto[0:6])    # "Python"
print(texto[7:])     # "es genial"
print(texto[:6])     # "Python"
print(texto[-6:])    # "genial"
print(texto[::-1])   # "laieneg se nohtyP" (invertido)</code></pre>
</div>
<div class="mini-ejercicio">
<h4>Mini ejercicio</h4>
<p>Pide al usuario su nombre completo (usa <code>input()</code>) y muéstralo en mayúsculas, con las palabras invertidas y su longitud.</p>
</div>',
        ],

        'archivos' => [
            'titulo' => 'Manejo de archivos',
            'desc'   => 'Leer y escribir archivos desde Python.',
            'contenido' => '
<h2>Archivos: guardando más allá de la RAM</h2>
<p>Los archivos permiten persistir datos aunque el programa se cierre. Es la base de cualquier aplicación real.</p>
<div class="caja-codigo">
<pre><code># Escribir en un archivo
with open("puntuaciones.txt", "w") as f:
    f.write("Peppa: 5000\n")
    f.write("Kat: 3200\n")

# "with" cierra el archivo automáticamente al terminar</code></pre>
</div>
<h3>Leer archivos</h3>
<div class="caja-codigo">
<pre><code># Leer todo el contenido
with open("puntuaciones.txt", "r") as f:
    contenido = f.read()
    print(contenido)

# Leer línea por línea
with open("puntuaciones.txt", "r") as f:
    for linea in f:
        print(linea.strip())</code></pre>
</div>
<h3>Modos de apertura</h3>
<div class="caja-codigo">
<pre><code"># Modos principales
open("archivo.txt", "r")   # Leer (error si no existe)
open("archivo.txt", "w")   # Escribir (crea o sobreescribe)
open("archivo.txt", "a")   # Agregar al final
open("archivo.txt", "x")   # Crear (error si ya existe)</code></pre>
</div>
<h3>JSON: guardar estructuras</h3>
<div class="caja-codigo">
<pre><code>import json

jugador = {"nombre": "Peppa", "xp": 1250}

# Guardar
with open("jugador.json", "w") as f:
    json.dump(jugador, f, indent=2)

# Cargar
with open("jugador.json", "r") as f:
    datos = json.load(f)
    print(datos["nombre"])</code></pre>
</div>',
        ],

        'poo' => [
            'titulo' => 'Programación orientada a objetos',
            'desc'   => 'Clases, objetos, herencia y encapsulamiento.',
            'contenido' => '
<h2>POO: construyendo personajes</h2>
<p>La Programación Orientada a Objetos (POO) te permite modelar el mundo real con código. Una <strong>clase</strong> es el molde; un <strong>objeto</strong> es el personaje creado con ese molde.</p>
<div class="caja-codigo">
<pre><code>class Personaje:
    """Clase base para todos los personajes del juego."""

    def __init__(self, nombre, vida=100):
        self.nombre = nombre    # Atributo público
        self.vida   = vida
        self._nivel = 1         # Atributo "protegido"

    def atacar(self, enemigo):
        danio = 25
        enemigo.vida -= danio
        print(f"{self.nombre} ataca a {enemigo.nombre} por {danio}")

    def __str__(self):
        return f"{self.nombre} (Vida: {self.vida})"


# Crear objetos
peppa = Personaje("Peppa", vida=150)
kat   = Personaje("Kat")
print(peppa)            # Peppa (Vida: 150)
peppa.atacar(kat)       # Peppa ataca a Kat por 25</code></pre>
</div>
<h3>Herencia</h3>
<div class="caja-codigo">
<pre><code>class Mago(Personaje):
    def __init__(self, nombre):
        super().__init__(nombre, vida=80)
        self.mana = 200

    def lanzar_hechizo(self, enemigo):
        if self.mana >= 50:
            enemigo.vida -= 60
            self.mana -= 50
            print(f"{self.nombre} lanza ¡Bola de Fuego!")

mago = Mago("Gandalf")
mago.lanzar_hechizo(kat)</code></pre>
</div>
<div class="mini-ejercicio">
<h4>Mini ejercicio</h4>
<p>Crea una clase <code>Curso</code> con atributos <code>nombre</code>, <code>progreso</code> y un método <code>avanzar(porcentaje)</code> que sume al progreso (máximo 100). Crea 3 objetos de curso.</p>
</div>',
        ],

        'modulos' => [
            'titulo' => 'Módulos y paquetes',
            'desc'   => 'Organizar y reutilizar código con imports.',
            'contenido' => '
<h2>Módulos: el arsenal del programador</h2>
<p>Un módulo es un archivo .py que contiene funciones, clases y variables que puedes importar en otros archivos. Python incluye una librería estándar enorme y además puedes instalar módulos externos con <code>pip</code>.</p>
<h3>Módulos de la librería estándar</h3>
<div class="caja-codigo">
<pre><code>import math
import random
import datetime

print(math.sqrt(144))          # 12.0
print(math.pi)                 # 3.14159...
print(random.randint(1, 100))  # Número aleatorio 1-100
print(datetime.date.today())   # Fecha actual</code></pre>
</div>
<h3>Importar funciones específicas</h3>
<div class="caja-codigo">
<pre><code>from math import sqrt, ceil, floor
from random import choice, shuffle

print(sqrt(25))           # 5.0 (sin necesitar math.sqrt)
idiomas = ["Python", "JS", "C++"]
print(choice(idiomas))    # Uno al azar</code></pre>
</div>
<h3>Crear tus propios módulos</h3>
<div class="caja-codigo">
<pre><code># archivo: utilidades.py
def calcular_nivel(xp):
    if xp >= 3500: return "Maestro"
    if xp >= 1500: return "Explorador"
    if xp >= 500:  return "Astronauta"
    return "Cadete"

# En otro archivo:
from utilidades import calcular_nivel
print(calcular_nivel(750))    # "Astronauta"</code></pre>
</div>
<h3>Instalar paquetes externos</h3>
<div class="caja-codigo">
<pre><code># En la terminal:
pip install requests    # Para hacer peticiones HTTP
pip install pandas      # Para análisis de datos
pip install flask       # Para crear webs con Python</code></pre>
</div>',
        ],
    ],
],

// ═══════════════════════════════════════════════════════
// HTML
// ═══════════════════════════════════════════════════════
'html' => [
    'nombre' => 'HTML',
    'color'  => '#e34c26',
    'icono'  => '🌐',
    'temas'  => [

        'intro' => [
            'titulo' => 'Estructura básica de HTML',
            'desc'   => 'El esqueleto de toda página web.',
            'contenido' => '
<h2>¿Qué es HTML?</h2>
<p>HTML (HyperText Markup Language) es el lenguaje que define la <strong>estructura</strong> de una página web. No es un lenguaje de programación — es un lenguaje de marcado. Piensa en él como los ladrillos de una casa.</p>
<div class="caja-codigo">
<pre><code>&lt;!DOCTYPE html&gt;
&lt;html lang="es"&gt;
&lt;head&gt;
    &lt;meta charset="UTF-8"&gt;
    &lt;meta name="viewport" content="width=device-width, initial-scale=1.0"&gt;
    &lt;title&gt;Mi primera página&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;h1&gt;¡Hola Mundo!&lt;/h1&gt;
    &lt;p&gt;Esta es mi primera página web.&lt;/p&gt;
&lt;/body&gt;
&lt;/html&gt;</code></pre>
</div>
<h3>Partes del documento</h3>
<ul>
    <li><code>&lt;!DOCTYPE html&gt;</code> — Le dice al navegador que es HTML5.</li>
    <li><code>&lt;html&gt;</code> — El contenedor raíz de todo.</li>
    <li><code>&lt;head&gt;</code> — Información que el navegador lee pero no muestra (SEO, CSS, etc.).</li>
    <li><code>&lt;body&gt;</code> — Todo lo que el usuario ve en pantalla.</li>
</ul>
<div class="mini-ejercicio">
<h4>Mini ejercicio</h4>
<p>Crea un archivo <code>index.html</code> con la estructura básica. Agrega un título, un párrafo de bienvenida y un subtítulo.</p>
</div>',
        ],

        'etiquetas' => [
            'titulo' => 'Etiquetas principales',
            'desc'   => 'Las etiquetas HTML que usarás el 90% del tiempo.',
            'contenido' => '
<h2>El vocabulario del HTML</h2>
<p>Las etiquetas son palabras especiales entre corchetes angulares <code>&lt; &gt;</code>. La mayoría se abren y se cierran.</p>
<div class="caja-codigo">
<pre><code>&lt;!-- TEXTOS --&gt;
&lt;h1&gt;Título principal&lt;/h1&gt;
&lt;h2&gt;Subtítulo&lt;/h2&gt;
&lt;h3&gt;hasta h6...&lt;/h3&gt;
&lt;p&gt;Un párrafo de texto.&lt;/p&gt;
&lt;strong&gt;Negrita&lt;/strong&gt; y &lt;em&gt;cursiva&lt;/em&gt;
&lt;span&gt;Texto en línea&lt;/span&gt;

&lt;!-- ENLACES E IMÁGENES --&gt;
&lt;a href="https://devpath.com"&gt;Ir a Dev Path&lt;/a&gt;
&lt;img src="imagen.jpg" alt="Descripción de la imagen"&gt;

&lt;!-- LISTAS --&gt;
&lt;ul&gt;                          &lt;!-- Lista desordenada --&gt;
    &lt;li&gt;Python&lt;/li&gt;
    &lt;li&gt;JavaScript&lt;/li&gt;
&lt;/ul&gt;
&lt;ol&gt;                          &lt;!-- Lista ordenada --&gt;
    &lt;li&gt;Primero&lt;/li&gt;
    &lt;li&gt;Segundo&lt;/li&gt;
&lt;/ol&gt;

&lt;!-- CONTENEDORES --&gt;
&lt;div&gt;Caja bloque (ocupa línea completa)&lt;/div&gt;
&lt;span&gt;Caja en línea&lt;/span&gt;
&lt;section&gt;Sección semántica&lt;/section&gt;</code></pre>
</div>
<div class="buenas-practicas">
<h4>Buenas prácticas</h4>
<ul>
    <li>Siempre cierra tus etiquetas.</li>
    <li>Usa la etiqueta correcta para cada cosa (no uses <code>&lt;div&gt;</code> para todo).</li>
    <li>El atributo <code>alt</code> en imágenes es obligatorio para accesibilidad.</li>
</ul>
</div>',
        ],

        'formularios' => [
            'titulo' => 'Formularios',
            'desc'   => 'Capturar datos del usuario.',
            'contenido' => '
<h2>Formularios: la puerta de entrada al servidor</h2>
<p>Los formularios son el principal canal de comunicación entre el usuario y el servidor. Login, registro, búsqueda — todo usa formularios.</p>
<div class="caja-codigo">
<pre><code>&lt;form action="login.php" method="POST"&gt;

    &lt;!-- Texto --&gt;
    &lt;label for="correo"&gt;Correo:&lt;/label&gt;
    &lt;input type="email" id="correo" name="correo" required&gt;

    &lt;!-- Contraseña --&gt;
    &lt;label for="pass"&gt;Contraseña:&lt;/label&gt;
    &lt;input type="password" id="pass" name="password" minlength="8"&gt;

    &lt;!-- Selección --&gt;
    &lt;label for="rol"&gt;Rol:&lt;/label&gt;
    &lt;select id="rol" name="rol"&gt;
        &lt;option value="estudiante"&gt;Estudiante&lt;/option&gt;
        &lt;option value="profesor"&gt;Profesor&lt;/option&gt;
    &lt;/select&gt;

    &lt;!-- Área de texto --&gt;
    &lt;textarea name="bio" placeholder="Cuéntanos sobre ti..."&gt;&lt;/textarea&gt;

    &lt;!-- Checkbox --&gt;
    &lt;input type="checkbox" name="terminos" id="terminos"&gt;
    &lt;label for="terminos"&gt;Acepto los términos&lt;/label&gt;

    &lt;button type="submit"&gt;Ingresar&lt;/button&gt;
&lt;/form&gt;</code></pre>
</div>
<div class="mini-ejercicio">
<h4>Mini ejercicio</h4>
<p>Crea un formulario de registro con: nombre, correo, contraseña, selección de curso favorito y un botón de envío.</p>
</div>',
        ],

        'semantica' => [
            'titulo' => 'HTML Semántico',
            'desc'   => 'Darle significado a la estructura.',
            'contenido' => '
<h2>Semántica: cuando el HTML habla</h2>
<p>Las etiquetas semánticas describen el propósito de su contenido. No solo para el navegador — también para los lectores de pantalla, Google y otros developers.</p>
<div class="caja-codigo">
<pre><code>&lt;!-- ❌ Sin semántica (todo son divs) --&gt;
&lt;div class="header"&gt;...&lt;/div&gt;
&lt;div class="nav"&gt;...&lt;/div&gt;
&lt;div class="main"&gt;...&lt;/div&gt;
&lt;div class="footer"&gt;...&lt;/div&gt;

&lt;!-- ✅ Con semántica HTML5 --&gt;
&lt;header&gt;Logo y barra de navegación&lt;/header&gt;
&lt;nav&gt;Menú de navegación&lt;/nav&gt;
&lt;main&gt;
    &lt;article&gt;Artículo principal&lt;/article&gt;
    &lt;aside&gt;Contenido lateral&lt;/aside&gt;
&lt;/main&gt;
&lt;section&gt;Una sección temática&lt;/section&gt;
&lt;footer&gt;Pie de página&lt;/footer&gt;</code></pre>
</div>
<h3>Beneficios del HTML semántico</h3>
<ul>
    <li><strong>SEO:</strong> Google entiende mejor tu contenido.</li>
    <li><strong>Accesibilidad:</strong> Los lectores de pantalla navegan correctamente.</li>
    <li><strong>Mantenimiento:</strong> El código es más fácil de leer para otros developers.</li>
</ul>',
        ],

        'tablas' => [
            'titulo' => 'Tablas HTML',
            'desc'   => 'Mostrar datos en filas y columnas.',
            'contenido' => '
<h2>Tablas: organizar datos estructurados</h2>
<p>Las tablas son perfectas para datos comparativos o tabulares. Úsalas solo para datos, nunca para diseño de layouts.</p>
<div class="caja-codigo">
<pre><code>&lt;table&gt;
    &lt;thead&gt;
        &lt;tr&gt;
            &lt;th&gt;Nombre&lt;/th&gt;
            &lt;th&gt;XP&lt;/th&gt;
            &lt;th&gt;Nivel&lt;/th&gt;
        &lt;/tr&gt;
    &lt;/thead&gt;
    &lt;tbody&gt;
        &lt;tr&gt;
            &lt;td&gt;Peppa&lt;/td&gt;
            &lt;td&gt;1250&lt;/td&gt;
            &lt;td&gt;Astronauta&lt;/td&gt;
        &lt;/tr&gt;
        &lt;tr&gt;
            &lt;td&gt;Kat&lt;/td&gt;
            &lt;td&gt;800&lt;/td&gt;
            &lt;td&gt;Astronauta&lt;/td&gt;
        &lt;/tr&gt;
    &lt;/tbody&gt;
&lt;/table&gt;</code></pre>
</div>',
        ],

        'multimedia' => [
            'titulo' => 'Multimedia',
            'desc'   => 'Video, audio e imágenes en HTML.',
            'contenido' => '
<h2>Multimedia nativa en HTML5</h2>
<p>HTML5 permite incrustar video y audio sin plugins externos como Flash.</p>
<div class="caja-codigo">
<pre><code>&lt;!-- VIDEO --&gt;
&lt;video controls width="100%" poster="miniatura.jpg"&gt;
    &lt;source src="video.mp4" type="video/mp4"&gt;
    &lt;source src="video.webm" type="video/webm"&gt;
    Tu navegador no soporta video HTML5.
&lt;/video&gt;

&lt;!-- AUDIO --&gt;
&lt;audio controls&gt;
    &lt;source src="musica.mp3" type="audio/mpeg"&gt;
&lt;/audio&gt;

&lt;!-- IMAGEN RESPONSIVA --&gt;
&lt;img
    src="foto.jpg"
    alt="Descripción"
    width="800"
    height="600"
    loading="lazy"&gt;</code></pre>
</div>
<div class="buenas-practicas">
<h4>Buenas prácticas</h4>
<ul>
    <li>Usa <code>loading="lazy"</code> en imágenes para mejorar la velocidad.</li>
    <li>Proporciona múltiples formatos de video para compatibilidad.</li>
    <li>El atributo <code>poster</code> en video muestra una imagen mientras carga.</li>
</ul>
</div>',
        ],

        'accesibilidad' => [
            'titulo' => 'Accesibilidad web',
            'desc'   => 'Hacer la web para todos.',
            'contenido' => '
<h2>Accesibilidad: la web es para todos</h2>
<p>La accesibilidad web asegura que personas con discapacidades puedan usar tu sitio. Es también un requisito legal en muchos países.</p>
<div class="caja-codigo">
<pre><code>&lt;!-- ARIA Labels para elementos sin texto visible --&gt;
&lt;button aria-label="Cerrar menú"&gt;✕&lt;/button&gt;

&lt;!-- Roles para elementos personalizados --&gt;
&lt;div role="alert"&gt;Error: correo inválido&lt;/div&gt;

&lt;!-- Skip link (para usuarios de teclado) --&gt;
&lt;a href="#contenido-principal" class="skip-link"&gt;
    Ir al contenido
&lt;/a&gt;

&lt;!-- Orden de tabulación correcto --&gt;
&lt;input type="text" tabindex="1"&gt;
&lt;input type="email" tabindex="2"&gt;
&lt;button tabindex="3"&gt;Enviar&lt;/button&gt;</code></pre>
</div>
<h3>Lista de verificación básica</h3>
<ul>
    <li>Todas las imágenes tienen atributo <code>alt</code>.</li>
    <li>El contraste de colores es suficiente (ratio mínimo 4.5:1).</li>
    <li>El sitio es navegable completamente con teclado.</li>
    <li>Los formularios tienen <code>&lt;label&gt;</code> asociados a cada campo.</li>
</ul>',
        ],
    ],
],

// ═══════════════════════════════════════════════════════
// CSS
// ═══════════════════════════════════════════════════════
'css' => [
    'nombre' => 'CSS',
    'color'  => '#264de4',
    'icono'  => '🎨',
    'temas'  => [

        'selectores' => [
            'titulo' => 'Selectores CSS',
            'desc'   => 'Cómo apuntar a elementos HTML.',
            'contenido' => '
<h2>Selectores: el bisturí del diseñador</h2>
<p>Un selector indica a qué elemento HTML se le aplican los estilos. Es la parte más importante y compleja del CSS.</p>
<div class="caja-codigo">
<pre><code>/* Por etiqueta */
p { color: white; }

/* Por clase (.) */
.mi-boton { background: blue; }

/* Por ID (#) — único en la página */
#header { height: 70px; }

/* Descendiente */
nav a { color: cyan; }

/* Hijo directo (>) */
ul > li { list-style: none; }

/* Pseudo-clases */
a:hover  { color: yellow; }
li:first-child { font-weight: bold; }
input:focus { border-color: blue; }

/* Pseudo-elementos */
p::first-line { font-size: 1.2em; }
.card::before { content: "★ "; }</code></pre>
</div>
<h3>Especificidad</h3>
<p>Cuando dos reglas apuntan al mismo elemento, gana la más específica:</p>
<div class="caja-codigo">
<pre><code>/* Orden de especificidad (mayor a menor):
   1. !important (evitar siempre que sea posible)
   2. style="..." (inline)
   3. #id
   4. .clase, :pseudo-clase
   5. etiqueta, ::pseudo-elemento */

p { color: red; }         /* pierde */
.texto { color: blue; }   /* gana (más específico) */</code></pre>
</div>',
        ],

        'boxmodel' => [
            'titulo' => 'Box Model',
            'desc'   => 'Cómo CSS calcula el tamaño de cada elemento.',
            'contenido' => '
<h2>El modelo de caja</h2>
<p>Cada elemento HTML es una caja rectangular compuesta por 4 capas: contenido, padding, border y margin.</p>
<div class="caja-codigo">
<pre><code>.tarjeta {
    /* Contenido */
    width:  300px;
    height: 200px;

    /* Padding: espacio interno (entre contenido y borde) */
    padding: 20px;          /* todos lados */
    padding: 10px 20px;     /* vertical horizontal */
    padding: 5px 10px 15px 20px;  /* top right bottom left */

    /* Border: el borde visible */
    border: 2px solid #7ed6ff;
    border-radius: 12px;    /* esquinas redondeadas */

    /* Margin: espacio externo (entre este elemento y los vecinos) */
    margin: 20px auto;      /* auto = centrar horizontalmente */
}</code></pre>
</div>
<h3>box-sizing: border-box</h3>
<div class="caja-codigo">
<pre><code>/* Por defecto, padding y border SE SUMAN al width.
   Con border-box, quedan DENTRO del width declarado. */
* {
    box-sizing: border-box;  /* ← Ponlo siempre al inicio */
}

.caja {
    width: 300px;     /* Con border-box, 300px = total visible */
    padding: 20px;    /* Incluido en los 300px */
    border: 2px solid white;  /* Incluido en los 300px */
}</code></pre>
</div>',
        ],

        'flexbox' => [
            'titulo' => 'Flexbox',
            'desc'   => 'Alinear elementos en una dimensión.',
            'contenido' => '
<h2>Flexbox: el rey de la alineación</h2>
<p>Flexbox organiza elementos en una fila o columna. Es ideal para barras de navegación, tarjetas y centrar cosas.</p>
<div class="caja-codigo">
<pre><code>.contenedor {
    display: flex;

    /* Dirección */
    flex-direction: row;        /* row | column | row-reverse */

    /* Alineación en el eje principal */
    justify-content: center;    /* flex-start | flex-end | center | space-between | space-around */

    /* Alineación en el eje cruzado */
    align-items: center;        /* flex-start | flex-end | center | stretch */

    /* Salto de línea */
    flex-wrap: wrap;

    /* Espacio entre elementos */
    gap: 20px;
}</code></pre>
</div>
<h3>Propiedades de los hijos</h3>
<div class="caja-codigo">
<pre><code>.hijo {
    flex: 1;          /* Crece para llenar el espacio disponible */
    flex-grow: 1;     /* Cuánto crece */
    flex-shrink: 0;   /* Cuánto se encoge (0 = no se encoge) */
    flex-basis: 200px; /* Tamaño base */
    align-self: flex-end; /* Sobrescribe align-items para este hijo */
}</code></pre>
</div>
<div class="mini-ejercicio">
<h4>Mini ejercicio</h4>
<p>Crea un header con logo a la izquierda y nav a la derecha usando solo flexbox y <code>justify-content: space-between</code>.</p>
</div>',
        ],

        'grid' => [
            'titulo' => 'CSS Grid',
            'desc'   => 'Layouts complejos en dos dimensiones.',
            'contenido' => '
<h2>CSS Grid: el tablero de ajedrez</h2>
<p>Grid divide el contenedor en filas y columnas. Es el sistema más poderoso para layouts de página completa.</p>
<div class="caja-codigo">
<pre><code>.pagina {
    display: grid;

    /* 3 columnas: fija, flexible, fija */
    grid-template-columns: 250px 1fr 200px;

    /* 2 filas */
    grid-template-rows: 70px 1fr;

    /* Espacio entre celdas */
    gap: 20px;

    min-height: 100vh;
}

/* Posicionar elementos en el grid */
.header  { grid-column: 1 / -1; }    /* Ocupa todas las columnas */
.sidebar { grid-row: 2; }
.main    { grid-column: 2; }
.aside   { grid-column: 3; }</code></pre>
</div>
<h3>Grid con repeat() y auto-fit</h3>
<div class="caja-codigo">
<pre><code>/* Grid responsive sin media queries */
.tarjetas {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 25px;
}
/* Crea tantas columnas como quepan, mínimo 280px cada una */</code></pre>
</div>',
        ],

        'responsive' => [
            'titulo' => 'Diseño Responsive',
            'desc'   => 'Adaptar el diseño a cualquier pantalla.',
            'contenido' => '
<h2>Responsive Design: una web para todos los dispositivos</h2>
<p>El diseño responsive adapta la interfaz al tamaño de pantalla del usuario usando Media Queries.</p>
<div class="caja-codigo">
<pre><code>/* Mobile First: diseñas para móvil primero,
   luego agregas estilos para pantallas más grandes */

/* Base: móvil (sin media query) */
.grid {
    display: grid;
    grid-template-columns: 1fr;  /* 1 columna */
    gap: 15px;
}

/* Tablet (768px+) */
@media (min-width: 768px) {
    .grid { grid-template-columns: 1fr 1fr; }  /* 2 columnas */
}

/* Desktop (1024px+) */
@media (min-width: 1024px) {
    .grid { grid-template-columns: repeat(3, 1fr); }  /* 3 columnas */
}

/* Ocultar en móvil */
@media (max-width: 767px) {
    .solo-desktop { display: none; }
}</code></pre>
</div>
<div class="buenas-practicas">
<h4>Buenas prácticas</h4>
<ul>
    <li>Siempre incluye <code>&lt;meta name="viewport" content="width=device-width, initial-scale=1.0"&gt;</code>.</li>
    <li>Usa unidades relativas: <code>%</code>, <code>rem</code>, <code>em</code>, <code>vw</code>, <code>vh</code>.</li>
    <li>Prueba en varios dispositivos antes de publicar.</li>
</ul>
</div>',
        ],

        'animaciones' => [
            'titulo' => 'Animaciones CSS',
            'desc'   => 'Movimiento y vida sin JavaScript.',
            'contenido' => '
<h2>Animaciones: vida sin JavaScript</h2>
<h3>Transitions: cambio suave entre estados</h3>
<div class="caja-codigo">
<pre><code>.boton {
    background: #1563da;
    transform: scale(1);
    /* transition: propiedad duración timing-function retraso */
    transition: background 0.3s ease, transform 0.2s ease;
}

.boton:hover {
    background: #7ed6ff;
    transform: scale(1.05);
}</code></pre>
</div>
<h3>Keyframes: animaciones complejas</h3>
<div class="caja-codigo">
<pre><code>@keyframes flotar {
    0%   { transform: translateY(0); }
    50%  { transform: translateY(-15px); }
    100% { transform: translateY(0); }
}

@keyframes aparecer {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}

.elemento-flotante {
    animation: flotar 3s ease-in-out infinite;
}

.aparece-al-cargar {
    animation: aparecer 0.5s ease forwards;
}</code></pre>
</div>',
        ],
    ],
],

// ═══════════════════════════════════════════════════════
// JAVASCRIPT
// ═══════════════════════════════════════════════════════
'javascript' => [
    'nombre' => 'JavaScript',
    'color'  => '#f7df1e',
    'icono'  => '⚡',
    'temas'  => [

        'variables' => [
            'titulo' => 'Variables y tipos de datos',
            'desc'   => 'let, const, var y los tipos en JS.',
            'contenido' => '
<h2>Variables en JavaScript</h2>
<p>JavaScript tiene tres formas de declarar variables. En código moderno usamos <code>let</code> y <code>const</code>.</p>
<div class="caja-codigo">
<pre><code>// const: no se puede reasignar (úsala por defecto)
const PI = 3.14159;
const nombre = "Peppa";

// let: puede cambiar de valor
let vidas = 3;
vidas = 2;  // ✅ OK

// var: evítala (ámbito confuso, era la antigua forma)
var antiguo = "no usar";</code></pre>
</div>
<h3>Tipos de datos</h3>
<div class="caja-codigo">
<pre><code>// Primitivos
const texto    = "Hola";           // String
const numero   = 42;               // Number
const decimal  = 3.14;            // Number (no hay float separado)
const activo   = true;            // Boolean
const nada     = null;            // Null
const indefinido = undefined;      // Undefined

// Referencia
const lista  = [1, 2, 3];         // Array
const objeto = { nombre: "Peppa"}; // Object

// Verificar tipo
console.log(typeof "Hola");   // "string"
console.log(typeof 42);       // "number"
console.log(typeof true);     // "boolean"</code></pre>
</div>
<h3>Template literals (backticks)</h3>
<div class="caja-codigo">
<pre><code>const nombre = "Peppa";
const xp = 1250;

// Antiguo (concatenar con +)
console.log("Hola " + nombre + ", tienes " + xp + " XP");

// Moderno (template literal)
console.log(`Hola ${nombre}, tienes ${xp} XP`);
console.log(`El doble de XP: ${xp * 2}`);</code></pre>
</div>',
        ],

        'funciones' => [
            'titulo' => 'Funciones y scope',
            'desc'   => 'Funciones clásicas, arrow functions y ámbito.',
            'contenido' => '
<h2>Funciones en JavaScript</h2>
<div class="caja-codigo">
<pre><code>// Función clásica (function declaration)
function saludar(nombre) {
    return `¡Hola, ${nombre}!`;
}

// Función expresión (function expression)
const despedir = function(nombre) {
    return `Adiós, ${nombre}`;
};

// Arrow function (moderna, más concisa)
const calcularXP = (nivel) => nivel * 100;

// Arrow con múltiples líneas
const calcularNivel = (xp) => {
    if (xp >= 3500) return "Maestro";
    if (xp >= 1500) return "Explorador";
    if (xp >= 500)  return "Astronauta";
    return "Cadete";
};</code></pre>
</div>
<h3>Parámetros por defecto y rest</h3>
<div class="caja-codigo">
<pre><code>// Valor por defecto
function saludar(nombre = "Aventurero") {
    return `¡Hola, ${nombre}!`;
}
console.log(saludar());         // "¡Hola, Aventurero!"

// Rest: captura los argumentos restantes en un array
function sumarTodo(primero, ...resto) {
    return primero + resto.reduce((a, b) => a + b, 0);
}
console.log(sumarTodo(1, 2, 3, 4));  // 10</code></pre>
</div>',
        ],

        'dom' => [
            'titulo' => 'Manipulación del DOM',
            'desc'   => 'Cambiar HTML y CSS desde JavaScript.',
            'contenido' => '
<h2>DOM: el puente entre JS y HTML</h2>
<p>El DOM (Document Object Model) es la representación en memoria del HTML. JavaScript puede leerlo y modificarlo en tiempo real.</p>
<div class="caja-codigo">
<pre><code>// SELECCIONAR ELEMENTOS
const titulo   = document.getElementById("mi-titulo");
const botones  = document.querySelectorAll(".btn");
const primero  = document.querySelector(".tarjeta");  // el primero

// LEER Y MODIFICAR CONTENIDO
titulo.textContent = "Nuevo texto";       // Solo texto
titulo.innerHTML   = "Texto &lt;b&gt;bold&lt;/b&gt;"; // HTML permitido

// MODIFICAR ATRIBUTOS
const img = document.querySelector("img");
img.src = "nueva-imagen.jpg";
img.setAttribute("alt", "Nueva descripción");

// MODIFICAR ESTILOS
titulo.style.color = "#7ed6ff";
titulo.style.fontSize = "2rem";

// CLASES
titulo.classList.add("activo");
titulo.classList.remove("oculto");
titulo.classList.toggle("visible");
titulo.classList.contains("activo");  // → true/false</code></pre>
</div>
<h3>Crear y eliminar elementos</h3>
<div class="caja-codigo">
<pre><code>// Crear elemento
const nuevaTarjeta = document.createElement("div");
nuevaTarjeta.classList.add("tarjeta");
nuevaTarjeta.textContent = "Nueva tarjeta";

// Insertar en el DOM
document.getElementById("grid").appendChild(nuevaTarjeta);

// Eliminar elemento
const viejo = document.querySelector(".obsoleto");
viejo.remove();</code></pre>
</div>',
        ],

        'eventos' => [
            'titulo' => 'Eventos',
            'desc'   => 'Reaccionar a las acciones del usuario.',
            'contenido' => '
<h2>Eventos: cuando el usuario actúa</h2>
<p>Los eventos son acciones del usuario (clic, tecla, scroll...) a las que JavaScript puede reaccionar.</p>
<div class="caja-codigo">
<pre><code>const boton = document.getElementById("mi-boton");

// addEventListener: la forma correcta
boton.addEventListener("click", function(evento) {
    console.log("Hiciste clic en:", evento.target);
    console.log("Tecla con Shift:", evento.shiftKey);
});

// Arrow function (más moderna)
boton.addEventListener("click", (e) => {
    e.preventDefault();  // Cancela el comportamiento por defecto
    e.stopPropagation(); // No propaga al elemento padre
});</code></pre>
</div>
<h3>Eventos comunes</h3>
<div class="caja-codigo">
<pre><code>// Ratón
elemento.addEventListener("click", fn);
elemento.addEventListener("dblclick", fn);
elemento.addEventListener("mouseenter", fn);
elemento.addEventListener("mouseleave", fn);

// Teclado
document.addEventListener("keydown", (e) => {
    if (e.key === "Enter") { /* acción */ }
    if (e.key === "Escape") { /* acción */ }
});

// Formulario
form.addEventListener("submit", (e) => {
    e.preventDefault();    // No recargar la página
    const datos = new FormData(form);
});

// DOM listo
document.addEventListener("DOMContentLoaded", () => {
    // El HTML ya está cargado, seguro para manipular el DOM
});</code></pre>
</div>',
        ],

        'fetch' => [
            'titulo' => 'Fetch API',
            'desc'   => 'Comunicarse con el servidor sin recargar.',
            'contenido' => '
<h2>Fetch: hablar con el servidor</h2>
<p>Fetch permite hacer peticiones HTTP desde JavaScript. Es la base de las aplicaciones modernas (AJAX).</p>
<div class="caja-codigo">
<pre><code>// GET: pedir datos
fetch("https://api.devpath.com/usuarios")
    .then(response => {
        if (!response.ok) throw new Error("Error HTTP: " + response.status);
        return response.json();
    })
    .then(datos => {
        console.log(datos);
    })
    .catch(error => {
        console.error("Error:", error);
    });</code></pre>
</div>
<h3>POST: enviar datos</h3>
<div class="caja-codigo">
<pre><code>// Enviar datos al servidor
fetch("guardar-progreso.php", {
    method:  "POST",
    headers: { "Content-Type": "application/json" },
    body:    JSON.stringify({ curso: "python", progreso: 60 })
})
.then(r => r.json())
.then(data => {
    if (data.ok) console.log("Guardado:", data);
});

// Con FormData (más simple para PHP)
const formData = new FormData();
formData.append("curso", "python");
formData.append("progreso", 60);

fetch("guardar-progreso.php", { method: "POST", body: formData })
    .then(r => r.json())
    .then(console.log);</code></pre>
</div>',
        ],

        'async' => [
            'titulo' => 'Async / Await',
            'desc'   => 'Código asíncrono más legible.',
            'contenido' => '
<h2>Async/Await: promesas sin .then()</h2>
<p><code>async/await</code> hace que el código asíncrono se lea como si fuera síncrono. Es azúcar sintáctico sobre las Promesas.</p>
<div class="caja-codigo">
<pre><code>// Una función async siempre devuelve una Promesa
async function cargarUsuario(id) {
    try {
        const respuesta = await fetch(`api/usuario/${id}`);

        if (!respuesta.ok) {
            throw new Error(`Error ${respuesta.status}`);
        }

        const usuario = await respuesta.json();
        return usuario;

    } catch (error) {
        console.error("Falló la carga:", error.message);
        return null;
    }
}

// Usar la función async
const usuario = await cargarUsuario(5);
console.log(usuario?.nombre);</code></pre>
</div>
<h3>Ejecutar varias peticiones en paralelo</h3>
<div class="caja-codigo">
<pre><code>async function cargarDashboard() {
    // ❌ Lento: una tras otra (secuencial)
    const usuario  = await fetch("/api/usuario");
    const cursos   = await fetch("/api/cursos");

    // ✅ Rápido: todas al mismo tiempo (paralelo)
    const [resUser, resCursos] = await Promise.all([
        fetch("/api/usuario"),
        fetch("/api/cursos")
    ]);

    const user   = await resUser.json();
    const cursos2 = await resCursos.json();
}</code></pre>
</div>',
        ],

        'poo' => [
            'titulo' => 'POO en JavaScript',
            'desc'   => 'Clases, herencia y el patrón moderno.',
            'contenido' => '
<h2>Clases en JavaScript (ES6+)</h2>
<div class="caja-codigo">
<pre><code>class Personaje {
    #vida;  // Atributo privado (ES2022+)

    constructor(nombre, vida = 100) {
        this.nombre = nombre;
        this.#vida  = vida;
    }

    get vida() { return this.#vida; }

    atacar(enemigo) {
        const daño = 25;
        enemigo.recibirDaño(daño);
        console.log(`${this.nombre} ataca por ${daño}`);
    }

    recibirDaño(cantidad) {
        this.#vida = Math.max(0, this.#vida - cantidad);
    }

    toString() { return `${this.nombre} (♥ ${this.#vida})`; }
}

class Mago extends Personaje {
    #mana;

    constructor(nombre) {
        super(nombre, 80);
        this.#mana = 200;
    }

    lanzarHechizo(enemigo) {
        if (this.#mana < 50) return console.log("Sin maná");
        enemigo.recibirDaño(60);
        this.#mana -= 50;
    }
}

const peppa = new Mago("Peppa");
const kat   = new Personaje("Kat");
peppa.lanzarHechizo(kat);
console.log(`${kat}`);</code></pre>
</div>',
        ],
    ],
],

// ═══════════════════════════════════════════════════════
// REACT
// ═══════════════════════════════════════════════════════
'react' => [
    'nombre' => 'React',
    'color'  => '#61dafb',
    'icono'  => '⚛️',
    'temas'  => [

        'intro' => [
            'titulo' => 'Introducción a React',
            'desc'   => '¿Qué es React y por qué usarlo?',
            'contenido' => '
<h2>¿Qué es React?</h2>
<p>React es una librería de JavaScript creada por Meta para construir interfaces de usuario. Su idea principal: dividir la UI en <strong>componentes</strong> reutilizables, como piezas de Lego.</p>
<h3>Instalación (Vite — el método moderno)</h3>
<div class="caja-codigo">
<pre><code># Crear proyecto con Vite
npm create vite@latest mi-app -- --template react
cd mi-app
npm install
npm run dev</code></pre>
</div>
<h3>JSX: HTML dentro de JavaScript</h3>
<div class="caja-codigo">
<pre><code>// JSX es la sintaxis especial de React
function Bienvenida({ nombre }) {
    return (
        &lt;div className="tarjeta"&gt;
            &lt;h1&gt;Hola, {nombre}&lt;/h1&gt;
            &lt;p&gt;Bienvenido a Dev Path&lt;/p&gt;
        &lt;/div&gt;
    );
}

// Diferencias con HTML:
// class → className
// for → htmlFor
// style={{ color: "red" }} en lugar de style="color:red"</code></pre>
</div>',
        ],

        'componentes' => [
            'titulo' => 'Componentes',
            'desc'   => 'El bloque fundamental de React.',
            'contenido' => '
<h2>Componentes funcionales</h2>
<p>Un componente es una función que devuelve JSX. Es la unidad básica de React.</p>
<div class="caja-codigo">
<pre><code>// Componente simple
function TarjetaCurso({ titulo, xp, progreso }) {
    return (
        &lt;article className="curso-card"&gt;
            &lt;h3&gt;{titulo}&lt;/h3&gt;
            &lt;p&gt;⭐ +{xp} XP&lt;/p&gt;
            &lt;div className="barra"&gt;
                &lt;div style={{ width: `${progreso}%` }} /&gt;
            &lt;/div&gt;
        &lt;/article&gt;
    );
}

// Usar el componente
function App() {
    return (
        &lt;div&gt;
            &lt;TarjetaCurso titulo="Python" xp={500} progreso={75} /&gt;
            &lt;TarjetaCurso titulo="React"  xp={1200} progreso={30} /&gt;
        &lt;/div&gt;
    );
}</code></pre>
</div>
<h3>Renderizado de listas</h3>
<div class="caja-codigo">
<pre><code>const cursos = ["Python", "HTML", "CSS", "React"];

function ListaCursos() {
    return (
        &lt;ul&gt;
            {cursos.map((curso, index) => (
                &lt;li key={index}&gt;{curso}&lt;/li&gt;
            ))}
        &lt;/ul&gt;
    );
}</code></pre>
</div>',
        ],

        'props' => [
            'titulo' => 'Props y State',
            'desc'   => 'Pasar datos y gestionar el estado local.',
            'contenido' => '
<h2>Props: datos de padre a hijo</h2>
<p>Las props son datos que el componente padre pasa al hijo. Son de solo lectura — el hijo no puede modificarlas.</p>
<div class="caja-codigo">
<pre><code>// Padre
function App() {
    return &lt;Perfil nombre="Peppa" xp={1250} nivel={3} /&gt;;
}

// Hijo recibe props
function Perfil({ nombre, xp, nivel }) {
    return (
        &lt;div&gt;
            &lt;h2&gt;{nombre}&lt;/h2&gt;
            &lt;p&gt;Nivel {nivel} — {xp} XP&lt;/p&gt;
        &lt;/div&gt;
    );
}</code></pre>
</div>
<h2>State: datos que cambian</h2>
<div class="caja-codigo">
<pre><code>import { useState } from "react";

function Contador() {
    // [valor, función para cambiarlo] = useState(valorInicial)
    const [count, setCount] = useState(0);

    return (
        &lt;div&gt;
            &lt;p&gt;Vidas: {count}&lt;/p&gt;
            &lt;button onClick={() => setCount(count + 1)}&gt;+1&lt;/button&gt;
            &lt;button onClick={() => setCount(count - 1)}&gt;-1&lt;/button&gt;
        &lt;/div&gt;
    );
}
// Cada vez que setCount cambia el valor, React re-renderiza el componente</code></pre>
</div>',
        ],

        'hooks' => [
            'titulo' => 'Hooks principales',
            'desc'   => 'useState, useEffect y más.',
            'contenido' => '
<h2>Hooks: superpoderes para los componentes</h2>
<h3>useEffect: efectos secundarios</h3>
<div class="caja-codigo">
<pre><code>import { useState, useEffect } from "react";

function Usuarios() {
    const [usuarios, setUsuarios] = useState([]);
    const [cargando, setCargando] = useState(true);

    useEffect(() => {
        // Se ejecuta después del primer render
        fetch("/api/usuarios")
            .then(r => r.json())
            .then(data => {
                setUsuarios(data);
                setCargando(false);
            });
    }, []);  // [] = solo se ejecuta una vez al montar

    if (cargando) return &lt;p&gt;Cargando...&lt;/p&gt;;

    return (
        &lt;ul&gt;
            {usuarios.map(u => &lt;li key={u.id}&gt;{u.nombre}&lt;/li&gt;)}
        &lt;/ul&gt;
    );
}</code></pre>
</div>
<h3>useRef: referencias sin re-render</h3>
<div class="caja-codigo">
<pre><code>import { useRef } from "react";

function VideoPlayer() {
    const videoRef = useRef(null);

    const reproducir = () => videoRef.current.play();
    const pausar    = () => videoRef.current.pause();

    return (
        &lt;&gt;
            &lt;video ref={videoRef} src="video.mp4" /&gt;
            &lt;button onClick={reproducir}&gt;Play&lt;/button&gt;
            &lt;button onClick={pausar}&gt;Pausa&lt;/button&gt;
        &lt;/&gt;
    );
}</code></pre>
</div>',
        ],

        'router' => [
            'titulo' => 'React Router',
            'desc'   => 'Navegación entre páginas en React.',
            'contenido' => '
<h2>React Router: navegación sin recarga</h2>
<div class="caja-codigo">
<pre><code>npm install react-router-dom</code></pre>
</div>
<div class="caja-codigo">
<pre><code>import { BrowserRouter, Routes, Route, Link, useParams } from "react-router-dom";

function App() {
    return (
        &lt;BrowserRouter&gt;
            &lt;nav&gt;
                &lt;Link to="/"&gt;Inicio&lt;/Link&gt;
                &lt;Link to="/cursos"&gt;Cursos&lt;/Link&gt;
                &lt;Link to="/perfil"&gt;Perfil&lt;/Link&gt;
            &lt;/nav&gt;

            &lt;Routes&gt;
                &lt;Route path="/"         element={&lt;Inicio /&gt;} /&gt;
                &lt;Route path="/cursos"   element={&lt;Cursos /&gt;} /&gt;
                &lt;Route path="/curso/:id" element={&lt;DetalleCurso /&gt;} /&gt;
                &lt;Route path="*"         element={&lt;PaginaNo404 /&gt;} /&gt;
            &lt;/Routes&gt;
        &lt;/BrowserRouter&gt;
    );
}

function DetalleCurso() {
    const { id } = useParams();  // Lee el :id de la URL
    return &lt;h1&gt;Curso: {id}&lt;/h1&gt;;
}</code></pre>
</div>',
        ],

        'context' => [
            'titulo' => 'Context API',
            'desc'   => 'Estado global sin librerías externas.',
            'contenido' => '
<h2>Context: estado compartido globalmente</h2>
<p>Context evita pasar props por múltiples niveles de componentes (prop drilling).</p>
<div class="caja-codigo">
<pre><code>import { createContext, useContext, useState } from "react";

// 1. Crear el contexto
const AuthContext = createContext(null);

// 2. Proveedor (envuelve la app)
function AuthProvider({ children }) {
    const [usuario, setUsuario] = useState(null);

    const login = (datos) => setUsuario(datos);
    const logout = () => setUsuario(null);

    return (
        &lt;AuthContext.Provider value={{ usuario, login, logout }}&gt;
            {children}
        &lt;/AuthContext.Provider&gt;
    );
}

// 3. Consumir en cualquier componente hijo
function Navbar() {
    const { usuario, logout } = useContext(AuthContext);

    return (
        &lt;nav&gt;
            {usuario ? (
                &lt;&gt;
                    &lt;span&gt;Hola, {usuario.nombre}&lt;/span&gt;
                    &lt;button onClick={logout}&gt;Salir&lt;/button&gt;
                &lt;/&gt;
            ) : (
                &lt;a href="/login"&gt;Ingresar&lt;/a&gt;
            )}
        &lt;/nav&gt;
    );
}</code></pre>
</div>',
        ],
    ],
],

// ═══════════════════════════════════════════════════════
// SQL
// ═══════════════════════════════════════════════════════
'sql' => [
    'nombre' => 'SQL',
    'color'  => '#336791',
    'icono'  => '🗄️',
    'temas'  => [

        'intro' => [
            'titulo' => 'Introducción a SQL',
            'desc'   => '¿Qué son las bases de datos relacionales?',
            'contenido' => '
<h2>¿Qué es una base de datos relacional?</h2>
<p>Una base de datos relacional organiza la información en <strong>tablas</strong> (como hojas de Excel), con filas (registros) y columnas (campos). SQL es el lenguaje para comunicarse con ella.</p>
<h3>Crear una tabla</h3>
<div class="caja-codigo">
<pre><code>CREATE TABLE usuarios (
    id       INT AUTO_INCREMENT PRIMARY KEY,
    nombre   VARCHAR(100) NOT NULL,
    correo   VARCHAR(150) UNIQUE NOT NULL,
    xp       INT DEFAULT 0,
    rol      ENUM(\'estudiante\',\'profesor\',\'admin\') DEFAULT \'estudiante\',
    creado   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);</code></pre>
</div>
<h3>Tipos de datos más comunes</h3>
<div class="caja-codigo">
<pre><code>INT          -- Entero
VARCHAR(n)   -- Texto variable hasta n caracteres
TEXT         -- Texto largo sin límite fijo
DECIMAL(p,s) -- Número decimal (p dígitos, s decimales)
BOOLEAN      -- TRUE o FALSE
DATE         -- Solo fecha: 2026-03-07
TIMESTAMP    -- Fecha y hora: 2026-03-07 14:30:00
ENUM(...)    -- Lista de valores permitidos</code></pre>
</div>',
        ],

        'select' => [
            'titulo' => 'SELECT — Consultas básicas',
            'desc'   => 'Leer datos de la base de datos.',
            'contenido' => '
<h2>SELECT: el lenguaje de las preguntas</h2>
<div class="caja-codigo">
<pre><code>-- Todos los registros y columnas
SELECT * FROM usuarios;

-- Solo columnas específicas
SELECT nombre, correo, xp FROM usuarios;

-- Con alias para los nombres de columna
SELECT nombre AS "Nombre del usuario",
       xp     AS "Experiencia"
FROM usuarios;

-- Ordenar resultados
SELECT nombre, xp FROM usuarios
ORDER BY xp DESC;        -- Mayor a menor
ORDER BY nombre ASC;     -- Alfabético

-- Limitar resultados
SELECT nombre, xp FROM usuarios
ORDER BY xp DESC
LIMIT 10;                -- Solo los 10 primeros (Top 10)</code></pre>
</div>
<h3>Funciones de agregación</h3>
<div class="caja-codigo">
<pre><code>SELECT COUNT(*)          AS total_usuarios  FROM usuarios;
SELECT AVG(xp)           AS xp_promedio     FROM usuarios;
SELECT MAX(xp)           AS xp_maximo       FROM usuarios;
SELECT MIN(xp)           AS xp_minimo       FROM usuarios;
SELECT SUM(xp)           AS xp_total        FROM usuarios;

-- GROUP BY: agrupar por una columna
SELECT rol, COUNT(*) AS cantidad, AVG(xp) AS xp_medio
FROM usuarios
GROUP BY rol;</code></pre>
</div>',
        ],

        'where' => [
            'titulo' => 'WHERE — Filtros',
            'desc'   => 'Seleccionar solo los registros que necesitas.',
            'contenido' => '
<h2>WHERE: el filtro inteligente</h2>
<div class="caja-codigo">
<pre><code>-- Comparaciones
SELECT * FROM usuarios WHERE xp > 500;
SELECT * FROM usuarios WHERE rol = \'estudiante\';
SELECT * FROM usuarios WHERE xp BETWEEN 500 AND 1500;

-- Múltiples condiciones
SELECT * FROM usuarios
WHERE rol = \'estudiante\' AND xp >= 1000;

SELECT * FROM usuarios
WHERE rol = \'admin\' OR xp >= 5000;

-- Búsqueda de texto (LIKE)
SELECT * FROM usuarios WHERE nombre LIKE \'Pep%\';    -- Empieza con "Pep"
SELECT * FROM usuarios WHERE correo LIKE \'%gmail%\'; -- Contiene "gmail"

-- Valores nulos
SELECT * FROM usuarios WHERE foto_perfil IS NULL;
SELECT * FROM usuarios WHERE foto_perfil IS NOT NULL;

-- Lista de valores
SELECT * FROM usuarios WHERE rol IN (\'profesor\', \'admin\');</code></pre>
</div>',
        ],

        'joins' => [
            'titulo' => 'JOINs — Unir tablas',
            'desc'   => 'Combinar datos de múltiples tablas.',
            'contenido' => '
<h2>JOINs: el poder de las relaciones</h2>
<div class="caja-codigo">
<pre><code>-- INNER JOIN: solo registros que coinciden en ambas tablas
SELECT u.nombre, d.titulo, dr.fecha
FROM desafios_respuestas dr
INNER JOIN usuarios  u ON dr.usuario_id = u.id
INNER JOIN desafios  d ON dr.desafio_id = d.id;

-- LEFT JOIN: todos los de la izquierda + coincidencias
SELECT u.nombre, COUNT(dr.id) AS desafios_completados
FROM usuarios u
LEFT JOIN desafios_respuestas dr ON u.id = dr.usuario_id
GROUP BY u.id, u.nombre
ORDER BY desafios_completados DESC;</code></pre>
</div>
<h3>Tipos de JOIN</h3>
<ul>
    <li><strong>INNER JOIN:</strong> Solo filas con coincidencia en ambas tablas.</li>
    <li><strong>LEFT JOIN:</strong> Todas las filas de la tabla izquierda + coincidencias.</li>
    <li><strong>RIGHT JOIN:</strong> Todas las filas de la tabla derecha + coincidencias.</li>
    <li><strong>FULL OUTER JOIN:</strong> Todos los registros de ambas tablas.</li>
</ul>',
        ],

        'modificar' => [
            'titulo' => 'INSERT, UPDATE, DELETE',
            'desc'   => 'Crear, editar y borrar datos.',
            'contenido' => '
<h2>Modificar datos</h2>
<div class="caja-codigo">
<pre><code>-- INSERT: agregar registros
INSERT INTO usuarios (nombre, correo, rol)
VALUES (\'Peppa\', \'peppa@devpath.com\', \'estudiante\');

-- INSERT múltiple
INSERT INTO desafios (titulo, lenguaje, xp_recompensa)
VALUES
    (\'Centrar un div\', \'css\',  50),
    (\'Fuga de datos\',  \'sql\', 500);

-- UPDATE: modificar registros (¡SIEMPRE usa WHERE!)
UPDATE usuarios SET xp = xp + 50 WHERE id = 5;
UPDATE usuarios SET rol = \'profesor\' WHERE correo = \'kat@dev.com\';

-- DELETE: eliminar (¡SIEMPRE usa WHERE!)
DELETE FROM desafios_respuestas WHERE usuario_id = 3;

-- ⚠️ Sin WHERE actualizas/borras TODOS los registros
-- Usa transacciones para operaciones críticas:
START TRANSACTION;
UPDATE usuarios SET xp = xp - 100 WHERE id = 5;
-- Verificar y confirmar:
COMMIT;
-- O cancelar si algo sale mal:
-- ROLLBACK;</code></pre>
</div>',
        ],

        'indices' => [
            'titulo' => 'Índices y rendimiento',
            'desc'   => 'Hacer consultas más rápidas.',
            'contenido' => '
<h2>Índices: el buscador interno</h2>
<p>Un índice es como el índice de un libro — permite encontrar datos sin leer toda la tabla. Úsalos en columnas que filtras con frecuencia.</p>
<div class="caja-codigo">
<pre><code>-- Crear índice básico
CREATE INDEX idx_xp ON usuarios(xp);

-- Índice único (no permite duplicados)
CREATE UNIQUE INDEX idx_correo ON usuarios(correo);

-- Ver índices de una tabla
SHOW INDEX FROM usuarios;

-- Eliminar índice
DROP INDEX idx_xp ON usuarios;

-- EXPLAIN: ver cómo ejecuta MySQL la consulta
EXPLAIN SELECT * FROM usuarios WHERE xp > 500;
-- Si "type" dice "ALL" → necesitas un índice
-- Si dice "range" o "index" → está usando índice</code></pre>
</div>
<div class="buenas-practicas">
<h4>Buenas prácticas</h4>
<ul>
    <li>Crea índices en columnas usadas en WHERE, ORDER BY y JOIN.</li>
    <li>No indexar todo — los índices ralentizan INSERT/UPDATE.</li>
    <li>La PRIMARY KEY ya es un índice automáticamente.</li>
</ul>
</div>',
        ],
    ],
],

// ═══════════════════════════════════════════════════════
// GIT
// ═══════════════════════════════════════════════════════
'git' => [
    'nombre' => 'Git',
    'color'  => '#f05032',
    'icono'  => '🔀',
    'temas'  => [

        'intro' => [
            'titulo' => 'Introducción a Git',
            'desc'   => '¿Qué es el control de versiones?',
            'contenido' => '
<h2>Git: el sistema de guardado del código</h2>
<p>Git es un sistema de control de versiones. Guarda una foto del proyecto en cada punto que le indiques, permitiéndote volver atrás si algo sale mal.</p>
<div class="caja-codigo">
<pre><code># Configuración inicial (solo una vez)
git config --global user.name  "Tu Nombre"
git config --global user.email "tu@email.com"

# Iniciar repositorio en una carpeta
git init

# Clonar un repositorio existente
git clone https://github.com/usuario/proyecto.git

# Ver el estado actual
git status</code></pre>
</div>
<h3>Las 3 zonas de Git</h3>
<ul>
    <li><strong>Working Directory:</strong> Tu carpeta de trabajo. Los archivos que editas.</li>
    <li><strong>Staging Area:</strong> La "sala de espera" antes del commit. Agrega archivos con <code>git add</code>.</li>
    <li><strong>Repository:</strong> El historial permanente. Se guarda con <code>git commit</code>.</li>
</ul>',
        ],

        'commits' => [
            'titulo' => 'Commits y staging',
            'desc'   => 'Guardar puntos de control en el historial.',
            'contenido' => '
<h2>El ciclo básico de Git</h2>
<div class="caja-codigo">
<pre><code># 1. Ver qué cambió
git status
git diff                    # Diferencias en detalle

# 2. Añadir al staging area
git add archivo.php         # Un archivo específico
git add css/               # Toda una carpeta
git add .                  # Todo (con cuidado)

# 3. Crear el commit (el "save")
git commit -m "Agrega sistema de progreso de cursos"

# Ver el historial
git log                     # Completo
git log --oneline           # Una línea por commit
git log --oneline --graph   # Con árbol de ramas</code></pre>
</div>
<h3>Deshacer cosas</h3>
<div class="caja-codigo">
<pre><code># Quitar del staging sin borrar cambios
git restore --staged archivo.php

# Deshacer cambios en working directory
git restore archivo.php

# Volver a un commit anterior (sin borrar historial)
git revert HEAD             # Deshace el último commit

# Ver versión de un archivo en otro commit
git show abc123:archivo.php</code></pre>
</div>',
        ],

        'ramas' => [
            'titulo' => 'Ramas (Branches)',
            'desc'   => 'Trabajar en paralelo sin romper el código.',
            'contenido' => '
<h2>Ramas: universos paralelos de código</h2>
<p>Una rama es una copia independiente del proyecto donde puedes experimentar sin afectar la rama principal.</p>
<div class="caja-codigo">
<pre><code># Ver todas las ramas
git branch
git branch -a              # Incluye remotas

# Crear rama nueva
git branch feature/sistema-xp

# Cambiar a esa rama
git checkout feature/sistema-xp

# Crear y cambiar en un solo comando (moderno)
git switch -c feature/desafios

# Eliminar rama (después de merge)
git branch -d feature/sistema-xp</code></pre>
</div>
<h3>Flujo recomendado</h3>
<div class="caja-codigo">
<pre><code># main     → código que va a producción
# develop  → integración de features
# feature/* → una rama por funcionalidad

git switch develop
git switch -c feature/panel-profesor
# ... trabajas y haces commits ...
git switch develop
git merge feature/panel-profesor
git branch -d feature/panel-profesor</code></pre>
</div>',
        ],

        'merge' => [
            'titulo' => 'Merge y resolución de conflictos',
            'desc'   => 'Unir ramas y resolver diferencias.',
            'contenido' => '
<h2>Merge: uniendo universos</h2>
<div class="caja-codigo">
<pre><code># Merge normal: crea un "merge commit"
git switch main
git merge feature/nueva-feature

# Fast-forward: si no hubo divergencia, simplemente mueve el puntero
git merge --ff feature/hotfix</code></pre>
</div>
<h3>Resolver conflictos</h3>
<p>Un conflicto ocurre cuando dos ramas modificaron la misma línea de código. Git marca el conflicto así:</p>
<div class="caja-codigo">
<pre><code>&lt;&lt;&lt;&lt;&lt;&lt;&lt; HEAD (tu rama actual)
$xp = intval($_POST[\'xp\']);
=======
$xp = max(0, intval($_POST[\'xp\']));
&gt;&gt;&gt;&gt;&gt;&gt;&gt; feature/validacion-xp

# Debes editar el archivo, dejar solo la versión correcta,
# luego:
git add archivo-con-conflicto.php
git commit -m "Resuelve conflicto en validación XP"</code></pre>
</div>
<h3>Rebase (alternativa al merge)</h3>
<div class="caja-codigo">
<pre><code># Rebase: reaplica tus commits encima de otra rama
# Historial más limpio (una sola línea)
git rebase main

# ⚠️ Nunca hagas rebase en ramas compartidas/públicas</code></pre>
</div>',
        ],

        'github' => [
            'titulo' => 'Trabajo con GitHub',
            'desc'   => 'Repositorios remotos y colaboración.',
            'contenido' => '
<h2>GitHub: Git en la nube</h2>
<div class="caja-codigo">
<pre><code># Conectar repositorio local con GitHub
git remote add origin https://github.com/usuario/proyecto.git

# Subir código por primera vez
git push -u origin main    # -u guarda la referencia remota

# Subir cambios posteriores
git push

# Bajar cambios del repositorio remoto
git pull

# Fetch: descarga sin integrar
git fetch origin
git merge origin/main</code></pre>
</div>
<h3>Pull Requests (PR)</h3>
<ul>
    <li>Una PR es una propuesta para integrar tu rama a la principal.</li>
    <li>Permite que otros revisen tu código antes de hacer merge.</li>
    <li>Base del trabajo en equipo profesional.</li>
</ul>
<div class="caja-codigo">
<pre><code># Flujo típico con PR:
git switch -c feature/nueva-funcionalidad
# ... hacer cambios y commits ...
git push -u origin feature/nueva-funcionalidad
# → Abrir Pull Request en GitHub
# → Code review del equipo
# → Merge cuando todo está OK</code></pre>
</div>',
        ],

        'gitignore' => [
            'titulo' => '.gitignore y buenas prácticas',
            'desc'   => 'Qué no subir y cómo trabajar bien con Git.',
            'contenido' => '
<h2>.gitignore: archivos que Git debe ignorar</h2>
<div class="caja-codigo">
<pre><code># .gitignore — ejemplo para proyecto PHP
.env                  # Credenciales (¡NUNCA subir!)
/vendor/              # Dependencias de Composer
node_modules/         # Dependencias de Node
*.log                 # Archivos de log
.DS_Store             # Archivos de macOS
Thumbs.db             # Archivos de Windows
/uploads/             # Archivos subidos por usuarios</code></pre>
</div>
<h3>Mensajes de commit profesionales</h3>
<div class="caja-codigo">
<pre><code># Formato: tipo(scope): descripción breve

feat(auth):     agrega validación de sesión en cursos
fix(progreso):  corrige desbordamiento de XP en nivel 5
docs(readme):   actualiza instrucciones de instalación
style(css):     ajusta colores del panel de profesor
refactor(bd):   usa prepared statements en panel-admin
test(desafios): agrega pruebas para guardar-respuesta

# Tipos: feat, fix, docs, style, refactor, test, chore</code></pre>
</div>',
        ],
    ],
],

// ═══════════════════════════════════════════════════════
// C++
// ═══════════════════════════════════════════════════════
'cpp' => [
    'nombre' => 'C++',
    'color'  => '#00599c',
    'icono'  => '⚙️',
    'temas'  => [

        'intro' => [
            'titulo' => 'Introducción a C++',
            'desc'   => 'El lenguaje de los videojuegos y sistemas.',
            'contenido' => '
<h2>¿Por qué aprender C++?</h2>
<p>C++ es uno de los lenguajes más poderosos y rápidos. Es la base de motores como Unreal Engine, sistemas operativos y software de alto rendimiento.</p>
<div class="caja-codigo">
<pre><code>#include &lt;iostream&gt;
using namespace std;

int main() {
    // Tu primer programa en C++
    cout &lt;&lt; "¡Hola, Dev Path!" &lt;&lt; endl;

    // Leer del usuario
    string nombre;
    cout &lt;&lt; "¿Cómo te llamas? ";
    cin  &gt;&gt; nombre;
    cout &lt;&lt; "¡Hola, " &lt;&lt; nombre &lt;&lt; "!" &lt;&lt; endl;

    return 0;  // 0 = programa terminó correctamente
}</code></pre>
</div>
<h3>Compilar y ejecutar</h3>
<div class="caja-codigo">
<pre><code># Compilar (con g++)
g++ -o mi_programa main.cpp

# Ejecutar
./mi_programa          # Linux/Mac
mi_programa.exe        # Windows</code></pre>
</div>',
        ],

        'variables' => [
            'titulo' => 'Variables y tipos en C++',
            'desc'   => 'Tipos estáticos, sizeof y casting.',
            'contenido' => '
<h2>Variables en C++: tipado estricto</h2>
<p>A diferencia de Python o JS, en C++ debes declarar el tipo de cada variable. El compilador verifica los tipos en tiempo de compilación.</p>
<div class="caja-codigo">
<pre><code>#include &lt;iostream&gt;
#include &lt;string&gt;
using namespace std;

int main() {
    // Tipos fundamentales
    int      vidas     = 3;
    double   velocidad = 9.8;
    char     inicial   = \'P\';
    bool     activo    = true;
    string   nombre    = "Peppa";   // Requiere &lt;string&gt;

    // Constantes
    const int MAX_VIDAS = 5;

    // sizeof: tamaño en bytes
    cout &lt;&lt; "int ocupa: " &lt;&lt; sizeof(int) &lt;&lt; " bytes" &lt;&lt; endl;

    // Casting (conversión de tipos)
    double resultado = (double)7 / 2;   // 3.5 (no 3)
    cout &lt;&lt; resultado &lt;&lt; endl;

    return 0;
}</code></pre>
</div>',
        ],

        'funciones' => [
            'titulo' => 'Funciones en C++',
            'desc'   => 'Definir, llamar y pasar parámetros.',
            'contenido' => '
<h2>Funciones</h2>
<div class="caja-codigo">
<pre><code>#include &lt;iostream&gt;
using namespace std;

// Declaración (prototipo) — antes de main
int calcularXP(int nivel, double multiplicador = 1.5);

int main() {
    cout &lt;&lt; calcularXP(3)      &lt;&lt; endl;  // 450
    cout &lt;&lt; calcularXP(3, 2.0) &lt;&lt; endl;  // 600
    return 0;
}

// Definición
int calcularXP(int nivel, double multiplicador) {
    return (int)(nivel * 100 * multiplicador);
}</code></pre>
</div>
<h3>Paso por referencia</h3>
<div class="caja-codigo">
<pre><code>// Por valor: se copia el dato (no modifica el original)
void sumarUno(int x) { x++; }

// Por referencia (&): modifica el original
void sumarUnoRef(int &x) { x++; }

int main() {
    int a = 5;
    sumarUno(a);      // a sigue siendo 5
    sumarUnoRef(a);   // a ahora es 6
    cout &lt;&lt; a;        // 6
}</code></pre>
</div>',
        ],

        'punteros' => [
            'titulo' => 'Punteros y memoria',
            'desc'   => 'La característica más poderosa (y peligrosa) de C++.',
            'contenido' => '
<h2>Punteros: las coordenadas de la memoria</h2>
<p>Un puntero es una variable que guarda la <strong>dirección de memoria</strong> de otra variable. Son la esencia de C++.</p>
<div class="caja-codigo">
<pre><code>#include &lt;iostream&gt;
using namespace std;

int main() {
    int xp = 1250;
    int* ptr = &xp;   // ptr guarda la dirección de xp

    cout &lt;&lt; xp;       // 1250       (el valor)
    cout &lt;&lt; &xp;      // 0x7ffee... (la dirección)
    cout &lt;&lt; ptr;      // 0x7ffee... (la dirección guardada)
    cout &lt;&lt; *ptr;     // 1250       (el valor en esa dirección)

    // Modificar a través del puntero
    *ptr = 1500;
    cout &lt;&lt; xp;       // 1500

    return 0;
}</code></pre>
</div>
<h3>Memoria dinámica (heap)</h3>
<div class="caja-codigo">
<pre><code>// Reservar memoria
int* arreglo = new int[100];

// Usar
arreglo[0] = 42;

// ⚠️ SIEMPRE liberar cuando termines
delete[] arreglo;
arreglo = nullptr;  // Buena práctica: anular el puntero</code></pre>
</div>',
        ],

        'clases' => [
            'titulo' => 'Clases y objetos',
            'desc'   => 'POO en C++: encapsulamiento y herencia.',
            'contenido' => '
<h2>Clases en C++</h2>
<div class="caja-codigo">
<pre><code>#include &lt;iostream&gt;
#include &lt;string&gt;
using namespace std;

class Personaje {
private:
    int vida;           // Solo accesible desde la clase

public:
    string nombre;      // Accesible desde afuera

    // Constructor
    Personaje(string nom, int v = 100) : nombre(nom), vida(v) {}

    // Destructor
    ~Personaje() { cout &lt;&lt; nombre &lt;&lt; " fue eliminado" &lt;&lt; endl; }

    // Getters y setters
    int getVida() const { return vida; }
    void recibirDaño(int d) { vida = max(0, vida - d); }

    // Método virtual (para herencia)
    virtual void atacar(Personaje& enemigo) {
        enemigo.recibirDaño(25);
    }
};

class Mago : public Personaje {
    int mana = 200;
public:
    Mago(string nom) : Personaje(nom, 80) {}

    void atacar(Personaje& enemigo) override {
        if (mana >= 50) { enemigo.recibirDaño(60); mana -= 50; }
    }
};</code></pre>
</div>',
        ],

        'stl' => [
            'titulo' => 'STL y contenedores',
            'desc'   => 'vector, map, set y algoritmos estándar.',
            'contenido' => '
<h2>STL: la librería estándar de C++</h2>
<div class="caja-codigo">
<pre><code>#include &lt;vector&gt;
#include &lt;map&gt;
#include &lt;algorithm&gt;
using namespace std;

// VECTOR: arreglo dinámico
vector&lt;string&gt; cursos = {"Python", "HTML", "CSS"};
cursos.push_back("JavaScript");
cursos.pop_back();

for (const string& c : cursos) {
    cout &lt;&lt; c &lt;&lt; endl;
}

// MAP: diccionario clave-valor
map&lt;string, int&gt; progreso;
progreso["python"]     = 75;
progreso["javascript"] = 30;

for (auto& [curso, pct] : progreso) {
    cout &lt;&lt; curso &lt;&lt; ": " &lt;&lt; pct &lt;&lt; "%" &lt;&lt; endl;
}

// ALGORITMOS
sort(cursos.begin(), cursos.end());           // Ordenar
auto it = find(cursos.begin(), cursos.end(), "HTML");
if (it != cursos.end()) cout &lt;&lt; "Encontrado";</code></pre>
</div>',
        ],
    ],
],

]; // fin de $temas
