/**
 * hero-sliders.js
 * hero slider automático vanilla JS — sin dependencias
 * Accesible: aria-live, aria-hidden, pause on hover/focus
 */

(function () {
    'use strict';

    const heroSlider   = document.getElementById('heroSlider');
    if (!heroSlider) return;

    const slides   = heroSlider.querySelectorAll('.slide');
    const dots     = document.querySelectorAll('.hero .dot');
    const btnPrev  = document.querySelector('.hero .prev-control');
    const btnNext  = document.querySelector('.hero .next-control');
    const INTERVAL = parseInt(heroSlider.dataset.autoplay) || 5000;

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
    heroSlider.addEventListener('mouseenter', () => { isPaused = true; });
    heroSlider.addEventListener('mouseleave', () => { isPaused = false; });
    heroSlider.addEventListener('focusin',    () => { isPaused = true; });
    heroSlider.addEventListener('focusout',   () => { isPaused = false; });
 
    // ─── Teclado ───────────────────────────────────────────
    heroSlider.addEventListener('keydown', (e) => {
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

(function () {
    'use strict';

    const imgBanners   = document.getElementById('imgBanners');
    if (!imgBanners) return;

    const slides   = imgBanners.querySelectorAll('.slide');
    const dots     = imgBanners.querySelectorAll('.dot');
    const btnPrev  = imgBanners.querySelector('.prev-control');
    const btnNext  = imgBanners.querySelector('.next-control');
    const INTERVAL = parseInt(imgBanners.dataset.autoplay) || 5000;

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
    imgBanners.addEventListener('mouseenter', () => { isPaused = true; });
    imgBanners.addEventListener('mouseleave', () => { isPaused = false; });
    imgBanners.addEventListener('focusin',    () => { isPaused = true; });
    imgBanners.addEventListener('focusout',   () => { isPaused = false; });
 
    // ─── Teclado ───────────────────────────────────────────
    imgBanners.addEventListener('keydown', (e) => {
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