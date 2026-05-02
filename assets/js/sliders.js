/**
 * sliders.js
 */

'use strict';

document.addEventListener('DOMContentLoaded', () => {
    const sliders = document.querySelectorAll('.slider');

    if (!sliders.length) return;

    // =============================================================================
    // FUNCIÓN REUTILIZABLE
    // =============================================================================

    function initSlider({
        container,       // elemento que contiene los .slide
        controlsContext, // elemento donde buscar .dot, .prev-control, .next-control
    }) {
        if (!container) return;

        const ctx     = controlsContext || container;
        const slides  = container.querySelectorAll('.slide');
        const dots    = ctx.querySelectorAll('.dot');
        const btnPrev = ctx.querySelector('.prev-control');
        const btnNext = ctx.querySelector('.next-control');

        if (!slides.length) return;

        const INTERVAL  = parseInt(container.dataset.autoplay) || 5000;
        const DURATION  = 500;
        const THRESHOLD = 50;

        let current     = 0;
        let timer       = null;
        let isPaused    = false;
        let isAnimating = false;

        // ─── goTo ──────────────────────────────────────────────
        function goTo(index, direction = 'next') {
            if (isAnimating) return;
            isAnimating = true;

            const prevIndex = current;
            current = (index + slides.length) % slides.length;

            const incoming = slides[current];
            const outgoing = slides[prevIndex];

            incoming.classList.add(direction === 'next' ? 'is-prev-right' : 'is-prev-left');
            incoming.getBoundingClientRect();

            const leavingClass = direction === 'next' ? 'is-leaving' : 'is-leaving-right';
            outgoing.classList.add(leavingClass);
            outgoing.classList.remove('is-active');
            incoming.classList.remove('is-prev-right', 'is-prev-left');
            incoming.classList.add('is-active');

            dots[prevIndex]?.classList.remove('is-active');
            dots[prevIndex]?.setAttribute('aria-selected', 'false');
            dots[current]?.classList.add('is-active');
            dots[current]?.setAttribute('aria-selected', 'true');

            outgoing.setAttribute('aria-hidden', 'true');
            incoming.setAttribute('aria-hidden', 'false');

            setTimeout(() => {
                outgoing.classList.remove('is-leaving', 'is-leaving-right');
                isAnimating = false;
            }, DURATION);
        }

        // ─── Autoplay ──────────────────────────────────────────
        function startAutoplay() {
            timer = setInterval(() => {
                if (!isPaused) goTo(current + 1, 'next');
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

        // ─── Pausa — escuchar en ctx (cubre slider + controles externos)
        ctx.addEventListener('mouseenter', () => { isPaused = true; });
        ctx.addEventListener('mouseleave', () => { isPaused = false; });
        ctx.addEventListener('focusin',    () => { isPaused = true; });
        ctx.addEventListener('focusout',   () => { isPaused = false; });

        // ─── Teclado ───────────────────────────────────────────
        ctx.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft')  { goTo(current - 1, 'prev'); stopAutoplay(); startAutoplay(); }
            if (e.key === 'ArrowRight') { goTo(current + 1, 'next'); stopAutoplay(); startAutoplay(); }
        });

        // ─── Swipe táctil ──────────────────────────────────────
        let startX   = null;
        let startY   = null;
        let dragging = false;

        container.addEventListener('pointerdown', (e) => {
            if (e.button !== 0) return;
            startX   = e.clientX;
            startY   = e.clientY;
            dragging = true;
            container.setPointerCapture(e.pointerId);
        });

        container.addEventListener('pointerup', (e) => {
            if (!dragging || startX === null) return;

            const deltaX = e.clientX - startX;
            const deltaY = e.clientY - startY;
            dragging = false;

            if (Math.abs(deltaX) < Math.abs(deltaY)) return;

            if (deltaX < -THRESHOLD) {
                goTo(current + 1, 'next'); stopAutoplay(); startAutoplay();
            } else if (deltaX > THRESHOLD) {
                goTo(current - 1, 'prev'); stopAutoplay(); startAutoplay();
            }

            startX = null;
            startY = null;
        });

        container.addEventListener('pointercancel', () => {
            dragging = false;
            startX   = null;
            startY   = null;
        });

        container.addEventListener('pointermove', (e) => {
            if (!dragging || startX === null) return;
            if (Math.abs(e.clientX - startX) > Math.abs(e.clientY - startY)) {
                e.preventDefault();
            }
        }, { passive: false });

        // ─── Iniciar ───────────────────────────────────────────
        const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        if (!prefersReduced) startAutoplay();
    }


    // =============================================================================
    // INICIALIZAR
    // =============================================================================

    // Hero: los .slide están en #heroSlider pero .dot y .controls están en section.hero
    initSlider({
        container:       document.getElementById('heroSlider'),
        controlsContext: document.querySelector('section.hero'),
    });

    // Banners: todo está dentro de #imgBanners
    initSlider({
        container:       document.getElementById('imgBanners'),
        controlsContext: document.querySelector('section.banners'),
    });
});