document.addEventListener('DOMContentLoaded', function() {
    /* SubMenu Toggler */
    const menuItemsWithSubmenu = document.querySelectorAll('.menu-item-has-children');

    menuItemsWithSubmenu.forEach(item => {
        const link = item.querySelector('a');
        link.setAttribute('aria-expanded', 'false');
        const submenu = item.querySelector('.sub-menu');
        submenu.setAttribute('aria-hidden', 'true');

        link.addEventListener('click', function(e) {
            e.preventDefault();
            const isExpanded = link.getAttribute('aria-expanded') === 'true';
            link.setAttribute('aria-expanded', !isExpanded);
            submenu.classList.toggle('active');
            item.classList.toggle('open');
            submenu.setAttribute('aria-hidden', isExpanded);

            /* document.querySelectorAll('.sub-menu').forEach(otherSubmenu => {
                if (otherSubmenu !== submenu) {
                    otherSubmenu.classList.remove('active');
                    otherSubmenu.setAttribute('aria-hidden', 'true');
                    const parentLink = otherSubmenu.closest('.menu-item-has-children').querySelector('a');
                    parentLink.setAttribute('aria-expanded', 'false');
                }
            }); */

            document.addEventListener('click', function(event) {
                if (!item.contains(event.target)) {
                    submenu.classList.remove('active');
                    item.classList.remove('open');
                    submenu.setAttribute('aria-hidden', 'true');
                    link.setAttribute('aria-expanded', 'false');
                }
            });
        });
    });

    /* Cerrar offcanvas al pasar a desktop (xl) */
    (function ($) {
        'use strict';

        const XL_BREAKPOINT = 1440; // breakpoint xl
        const offcanvasEl   = document.getElementById('navOffcanvas');
        let   bsOffcanvas   = null;

        // Inicializar instancia de Bootstrap Offcanvas
        if (offcanvasEl) {
            bsOffcanvas = new bootstrap.Offcanvas(offcanvasEl);
        }

        // ─── Cerrar offcanvas al pasar a desktop (xl) ───────────────
        function handleResize() {
            if (window.innerWidth >= XL_BREAKPOINT && bsOffcanvas) {
                bsOffcanvas.hide();
            }
        }

        window.addEventListener('resize', handleResize, { passive: true });

    }(jQuery));
});