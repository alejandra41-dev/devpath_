// js/auth.js
// Este archivo ahora solo muestra mensajes de error del servidor en el login.
// La autenticación real ocurre en login.php (lado del servidor).

document.addEventListener('DOMContentLoaded', () => {

    // Mostrar mensaje de error si el servidor redirigió con ?error=
    const params = new URLSearchParams(window.location.search);
    const error  = params.get('error');

    if (error) {
        const msgBox = document.getElementById('mensaje-error');
        if (msgBox) {
            if (error === 'incorrecto') {
                msgBox.textContent = 'Correo o contraseña incorrectos.';
            } else {
                msgBox.textContent = 'Ocurrió un error. Intenta de nuevo.';
            }
            msgBox.style.display = 'block';
        }
    }
});
