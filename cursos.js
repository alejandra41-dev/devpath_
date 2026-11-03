// js/cursos.js
// Gestiona la lógica de los cursos: progreso por video, desbloqueo de módulos
// y sincronización con el servidor.
// IMPORTANTE: La autenticación depende SOLO de la sesión PHP, NO de localStorage.

document.addEventListener('DOMContentLoaded', () => {

    const mainContainer = document.querySelector('.aula-main');
    if (!mainContainer) return;

    const cursoId       = mainContainer.getAttribute('data-curso');
    const barraProgreso = document.getElementById('barra-progreso');
    const textoProgreso = document.getElementById('texto-progreso');
    const modulos       = document.querySelectorAll('.modulo-item');
    const btnSiguiente  = document.getElementById('btn-siguiente');

    // El progreso inicial es inyectado por PHP en cada página de curso.
    // Si la variable no existe (por algún fallo), empezamos en 0.
    let progresoActual = (typeof progresoInicial !== 'undefined') ? parseInt(progresoInicial) : 0;

    // -------------------------------------------------------
    // actualizarVista: sincroniza barra y estado de módulos
    // -------------------------------------------------------
    function actualizarVista(valor) {
        if (barraProgreso) barraProgreso.style.width = valor + '%';
        if (textoProgreso) textoProgreso.innerText   = 'Progreso: ' + valor + '%';

        modulos.forEach((modulo) => {
            const nivelModulo = parseInt(modulo.getAttribute('data-nivel') || '0');
            // Cada nivel vale 20% (5 niveles = 100%)
            if (valor >= (nivelModulo * 20)) {
                modulo.classList.remove('bloqueado');
                const icono = modulo.querySelector('.modulo-icono');
                if (valor > (nivelModulo * 20)) {
                    modulo.classList.add('completado');
                    if (icono) icono.innerText = '✅';
                } else {
                    if (icono) icono.innerText = '▶';
                }
            }
        });
    }

    // -------------------------------------------------------
    // guardarProgreso: envía progreso y XP al servidor (BD)
    // -------------------------------------------------------
    function guardarProgreso(nuevoProgreso, xpGanado) {
        const formData = new FormData();
        formData.append('curso',    cursoId);
        formData.append('progreso', nuevoProgreso);
        formData.append('xp',       xpGanado);

        fetch('guardar-progreso.php', {
            method: 'POST',
            body:   formData
        })
        .then(r => r.json())
        .then(data => {
            if (data.ok) {
                // Actualizar XP mostrado en pantalla si el elemento existe
                const xpDisplay = document.getElementById('xp-display');
                if (xpDisplay && data.xp_total !== undefined) {
                    xpDisplay.textContent = '⭐ ' + data.xp_total + ' XP';
                }
            } else {
                console.warn('No se pudo guardar el progreso:', data.error);
            }
        })
        .catch(e => console.error('Error de red al guardar progreso:', e));
    }

    // Cargar estado inicial desde el dato PHP
    actualizarVista(progresoActual);

    // -------------------------------------------------------
    // Evento: video termina → desbloquear siguiente módulo
    // -------------------------------------------------------
    const video = document.getElementById('video-curso');
    if (video) {
        video.addEventListener('ended', () => {
            if (progresoActual < 100) {
                progresoActual += 20;
                actualizarVista(progresoActual);
                guardarProgreso(progresoActual, 50); // 50 XP por video completado
                mostrarNotificacion('+50 XP ganados por completar el video 🎉');
            } else {
                mostrarNotificacion('¡Felicidades! Curso completado al 100% ⭐');
            }
        });
    }

    // -------------------------------------------------------
    // Botón "Siguiente Misión" como alternativa al video
    // -------------------------------------------------------
    if (btnSiguiente) {
        btnSiguiente.addEventListener('click', () => {
            if (progresoActual < 100) {
                progresoActual += 20;
                actualizarVista(progresoActual);
                guardarProgreso(progresoActual, 50);
                mostrarNotificacion('+50 XP ganados 🎉');
            } else {
                mostrarNotificacion('¡Felicidades! Has completado todos los niveles.');
            }
        });
    }

    // -------------------------------------------------------
    // Notificación temporal en pantalla
    // -------------------------------------------------------
    function mostrarNotificacion(mensaje) {
        let notif = document.getElementById('notif-xp');
        if (!notif) {
            notif = document.createElement('div');
            notif.id = 'notif-xp';
            notif.style.cssText = [
                'position:fixed', 'bottom:2rem', 'right:2rem',
                'background:linear-gradient(135deg,#00b894,#00cec9)',
                'color:white', 'padding:1rem 1.5rem', 'border-radius:12px',
                'font-weight:bold', 'font-size:1rem',
                'box-shadow:0 8px 25px rgba(0,184,148,0.4)',
                'z-index:9999', 'transition:opacity 0.5s'
            ].join(';');
            document.body.appendChild(notif);
        }
        notif.textContent  = mensaje;
        notif.style.opacity = '1';
        clearTimeout(notif._timer);
        notif._timer = setTimeout(() => { notif.style.opacity = '0'; }, 3000);
    }

});
