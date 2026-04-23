/**
 * hero-slider.js
 * Slider automático vanilla JS — sin dependencias
 * Accesible: aria-live, aria-hidden, pause on hover/focus
 */

/* /**
 * hero-slider.js
 * Slider automático vanilla JS — sin dependencias
 * Accesible: aria-live, aria-hidden, pause on hover/focus
 */

(function () {
    'use strict';

    const slider   = document.getElementById('heroSlider');
    if (!slider) return;

    const slides   = slider.querySelectorAll('.slide');
    const dots     = document.querySelectorAll('.dot');
    const btnPrev  = document.querySelector('.prev-control');
    const btnNext  = document.querySelector('.next-control');
    const INTERVAL = parseInt(slider.dataset.autoplay) || 5000;

    let current  = 0;
    let timer    = null;
    let isPaused = false;

    // ─── Ir a un slide específico ──────────────────────────
    let isAnimating = false;
 
    function goTo(index, direction = 'next') {
        if (isAnimating) return;
        isAnimating = true;
 
        const prevIndex = current;
        current = (index + slides.length) % slides.length;
 
        const incoming = slides[current];
        const outgoing = slides[prevIndex];
 
        // Posicionar el slide entrante fuera de pantalla
        // según la dirección (derecha si avanza, izquierda si retrocede)
        incoming.classList.add(direction === 'next' ? 'is-prev-right' : 'is-prev-left');
 
        // Forzar reflow para que el navegador registre la posición inicial
        incoming.getBoundingClientRect();
 
        // Activar transición
        const leavingClass = direction === 'next' ? 'is-leaving' : 'is-leaving-right';
        outgoing.classList.add(leavingClass);
        outgoing.classList.remove('is-active');
        incoming.classList.remove('is-prev-right', 'is-prev-left');
        incoming.classList.add('is-active');
 
        // Actualizar dots
        dots[prevIndex]?.classList.remove('is-active');
        dots[prevIndex]?.setAttribute('aria-selected', 'false');
        dots[current]?.classList.add('is-active');
        dots[current]?.setAttribute('aria-selected', 'true');
 
        // Actualizar aria
        outgoing.setAttribute('aria-hidden', 'true');
        incoming.setAttribute('aria-hidden', 'false');
 
        // Limpiar clases cuando termina la transición
        const DURATION = 500; // debe coincidir con transition en SCSS
        setTimeout(() => {
            outgoing.classList.remove('is-leaving', 'is-leaving-right');
            isAnimating = false;
        }, DURATION);
    }
 
    // ─── Autoplay ──────────────────────────────────────────
    function startAutoplay() {
        timer = setInterval(() => {
            if (!isPaused) goTo(current + 1);
        }, INTERVAL);
    }
 
    function stopAutoplay() {
        clearInterval(timer);
    }
 
    // ─── Flechas ───────────────────────────────────────────
    btnPrev?.addEventListener('click', () => {
        goTo(current - 1, 'prev');
        stopAutoplay();
        startAutoplay();
    });
 
    btnNext?.addEventListener('click', () => {
        goTo(current + 1, 'next');
        stopAutoplay();
        startAutoplay();
    });
 
    // ─── Dots ──────────────────────────────────────────────
    dots.forEach((dot) => {
        dot.addEventListener('click', () => {
            const target = parseInt(dot.dataset.index);
            const dir    = target > current ? 'next' : 'prev';
            goTo(target, dir);
            stopAutoplay();
            startAutoplay();
        });
    });
 
    // ─── Pausa al hover y al focus (accesibilidad) ─────────
    slider.addEventListener('mouseenter', () => { isPaused = true; });
    slider.addEventListener('mouseleave', () => { isPaused = false; });
    slider.addEventListener('focusin',    () => { isPaused = true; });
    slider.addEventListener('focusout',   () => { isPaused = false; });
 
    // ─── Teclado ───────────────────────────────────────────
    slider.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft')  { goTo(current - 1, 'prev'); stopAutoplay(); startAutoplay(); }
        if (e.key === 'ArrowRight') { goTo(current + 1, 'next'); stopAutoplay(); startAutoplay(); }
    });
 
    // ─── Autoplay ──────────────────────────────────────────
    function startAutoplay() {
        timer = setInterval(() => {
            if (!isPaused) goTo(current + 1, 'next');
        }, INTERVAL);
    }
 
    // ─── Respetar prefers-reduced-motion ───────────────────
    const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (!prefersReduced) startAutoplay();
 
}());