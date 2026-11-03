// js/main.js

// Esperamos a que todo el HTML cargue antes de ejecutar la lógica
document.addEventListener('DOMContentLoaded', () => {
    
    // ==========================================
    // 1. LÓGICA DEL MENÚ HAMBURGUESA (MÓVIL)
    // ==========================================
    const btnMenu = document.getElementById('btn-menu');
    const navMenu = document.getElementById('nav-menu');

    // Si los elementos existen en la página, activamos el botón
    if (btnMenu && navMenu) {
        btnMenu.addEventListener('click', () => {
            // Al hacer clic, le pone o le quita la clase "activo" al menú para desplegarlo
            navMenu.classList.toggle('activo');
        });
    }

    // ==========================================
    // 2. LÓGICA DEL FILTRO DE CURSOS
    // ==========================================
    // Seleccionamos todos los botones y todas las tarjetas
    const botonesFiltro = document.querySelectorAll('.filtro-btn');
    const tarjetasCursos = document.querySelectorAll('.curso-tarjeta');

    // MEDIDA DE SEGURIDAD: Solo ejecutamos esto si estamos en una página que tiene los filtros (como aprender.php)
    if (botonesFiltro.length > 0 && tarjetasCursos.length > 0) {
        
        // Iniciamos un ciclo para revisar cada vez que se haga clic en un botón
        botonesFiltro.forEach(boton => {
            boton.addEventListener('click', () => {
                
                // 1. Apagar el botón anterior y encender el nuevo
                botonesFiltro.forEach(btn => btn.classList.remove('activo'));
                boton.classList.add('activo');

                // 2. Capturar qué filtro eligió el usuario (ej: "frontend")
                const filtroSeleccionado = boton.getAttribute('data-filtro');

                // 3. Ciclo para evaluar qué tarjetas mostrar y cuáles ocultar
                tarjetasCursos.forEach(tarjeta => {
                    const categoriasTarjeta = tarjeta.getAttribute('data-categoria');

                    // CONDICIÓN LÓGICA: Si eligió "todos" o si la tarjeta tiene la palabra del filtro
                    if (filtroSeleccionado === 'todos' || (categoriasTarjeta && categoriasTarjeta.includes(filtroSeleccionado))) {
                        tarjeta.style.display = 'flex'; // La mostramos
                        
                        // Pequeña animación para que no aparezca de golpe
                        tarjeta.style.animation = 'fadeInUp 0.5s ease forwards';
                    } else {
                        tarjeta.style.display = 'none'; // La ocultamos
                    }
                });
            });
        });
    }

});