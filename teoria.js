// js/teoria.js — Lógica del buscador y menú lateral de teoría

document.addEventListener('DOMContentLoaded', () => {

    // -------------------------------------------------------
    // 1. ACORDEÓN DEL SIDEBAR — expandir/colapsar categorías
    // -------------------------------------------------------
    const categorias = document.querySelectorAll('.sidebar-categoria');

    categorias.forEach(cat => {
        const btn = cat.querySelector('.sidebar-cat-header');
        if (!btn) return;

        btn.addEventListener('click', () => {
            const estaAbierta = cat.classList.contains('abierta');

            // Cerrar todas las demás (comportamiento acordeón)
            categorias.forEach(c => c.classList.remove('abierta'));

            // Abrir la clickeada si estaba cerrada
            if (!estaAbierta) cat.classList.add('abierta');
        });
    });

    // -------------------------------------------------------
    // 2. SIDEBAR MÓVIL — abrir y cerrar
    // -------------------------------------------------------
    const sidebar       = document.getElementById('sidebar-teoria');
    const btnAbrir      = document.getElementById('btn-abrir-sidebar');
    const btnCerrar     = document.getElementById('btn-cerrar-sidebar');

    if (btnAbrir && sidebar) {
        btnAbrir.addEventListener('click', () => {
            sidebar.classList.add('sidebar-abierto');
            document.body.style.overflow = 'hidden'; // Bloquea scroll del fondo
        });
    }

    if (btnCerrar && sidebar) {
        btnCerrar.addEventListener('click', cerrarSidebar);
    }

    // Cerrar al hacer clic en un tema (en móvil)
    document.querySelectorAll('.sidebar-tema-link').forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth < 900) cerrarSidebar();
        });
    });

    function cerrarSidebar() {
        if (sidebar) sidebar.classList.remove('sidebar-abierto');
        document.body.style.overflow = '';
    }

    // -------------------------------------------------------
    // 3. BUSCADOR — filtra el índice de temas en tiempo real
    // -------------------------------------------------------
    const inputBusqueda   = document.getElementById('input-busqueda');
    const divResultados   = document.getElementById('resultados-busqueda');

    if (!inputBusqueda || !divResultados || typeof INDICE_TEMAS === 'undefined') return;

    inputBusqueda.addEventListener('input', () => {
        const query = inputBusqueda.value.trim().toLowerCase();

        if (query.length < 2) {
            divResultados.style.display = 'none';
            divResultados.innerHTML = '';
            return;
        }

        // Filtrar el índice por título o descripción
        const coincidencias = INDICE_TEMAS.filter(item =>
            item.titulo.toLowerCase().includes(query) ||
            item.desc.toLowerCase().includes(query) ||
            item.lenguaje.toLowerCase().includes(query)
        ).slice(0, 8); // Máximo 8 resultados

        if (coincidencias.length === 0) {
            divResultados.innerHTML = '<div class="resultado-vacio">Sin resultados para "' + escapeHtml(query) + '"</div>';
            divResultados.style.display = 'block';
            return;
        }

        // Construir HTML de resultados
        let html = '';
        coincidencias.forEach(item => {
            const tituloResaltado = resaltar(item.titulo, query);
            html += `
                <a href="${item.url}" class="resultado-item">
                    <span class="resultado-icono">${item.icono}</span>
                    <div class="resultado-info">
                        <strong>${tituloResaltado}</strong>
                        <small>${escapeHtml(item.desc)}</small>
                    </div>
                </a>
            `;
        });

        divResultados.innerHTML = html;
        divResultados.style.display = 'block';
    });

    // Cerrar resultados al hacer clic fuera del buscador
    document.addEventListener('click', (e) => {
        if (!e.target.closest('#buscador-container')) {
            divResultados.style.display = 'none';
        }
    });

    // Navegar con teclado en los resultados
    inputBusqueda.addEventListener('keydown', (e) => {
        const items = divResultados.querySelectorAll('.resultado-item');
        if (!items.length) return;

        const activo = divResultados.querySelector('.resultado-item.foco');
        let idx = Array.from(items).indexOf(activo);

        if (e.key === 'ArrowDown') {
            e.preventDefault();
            if (activo) activo.classList.remove('foco');
            idx = (idx + 1) % items.length;
            items[idx].classList.add('foco');
            items[idx].scrollIntoView({ block: 'nearest' });
        }
        if (e.key === 'ArrowUp') {
            e.preventDefault();
            if (activo) activo.classList.remove('foco');
            idx = (idx - 1 + items.length) % items.length;
            items[idx].classList.add('foco');
        }
        if (e.key === 'Enter' && activo) {
            e.preventDefault();
            window.location.href = activo.href;
        }
        if (e.key === 'Escape') {
            divResultados.style.display = 'none';
        }
    });

    // -------------------------------------------------------
    // 4. RESALTAR TÉRMINO BUSCADO EN LOS RESULTADOS
    // -------------------------------------------------------
    function resaltar(texto, query) {
        const regex = new RegExp(`(${escapeRegex(query)})`, 'gi');
        return escapeHtml(texto).replace(regex, '<mark>$1</mark>');
    }

    function escapeHtml(str) {
        return str
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    function escapeRegex(str) {
        return str.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    }

    // -------------------------------------------------------
    // 5. SCROLL SUAVE A ANCHORS (#cap1, etc.) DEL CONTENIDO
    // -------------------------------------------------------
    document.querySelectorAll('.indice-lista a[href^="#"], .sidebar-tema-link').forEach(link => {
        if (link.hash) {
            link.addEventListener('click', (e) => {
                const target = document.querySelector(link.hash);
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        }
    });

});
