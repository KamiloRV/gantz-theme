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

/* Formateo RUT */
document.addEventListener('DOMContentLoaded', function () {

    ['rut-paciente', 'rut-cuidador'].forEach(function(id) {

        const input = document.getElementById(id);

        if (!input) return;

        input.addEventListener('input', function () {

            let valor = this.value.replace(/[^0-9kK]/g, '').toUpperCase();

            if (valor.length < 2) {
                this.value = valor;
                return;
            }

            const dv = valor.slice(-1);
            let cuerpo = valor.slice(0, -1);

            cuerpo = cuerpo.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

            this.value = cuerpo + "-" + dv;

        });

    });

});

/* Formateo Numero de telefono */
document.addEventListener('DOMContentLoaded', () => {

    const telInputs = document.querySelectorAll('input[type="tel"]');

    telInputs.forEach((input) => {

        input.addEventListener('input', () => {

            // Guarda posición del cursor antes de reformatear
            const cursorPos = input.selectionStart;
            const originalLength = input.value.length;

            // Solo dígitos, máximo 9 (formato chileno sin +56)
            let digits = input.value.replace(/\D/g, '').slice(0, 9);

            let formatted = '';

            if (digits.length > 0) {
                formatted = digits.slice(0, 1);
            }
            if (digits.length > 1) {
                formatted += ' ' + digits.slice(1, 5);
            }
            if (digits.length > 5) {
                formatted += ' ' + digits.slice(5, 9);
            }

            input.value = formatted;

            // Reajusta cursor considerando los espacios agregados
            const newLength = input.value.length;
            const diff = newLength - originalLength;
            input.setSelectionRange(cursorPos + diff, cursorPos + diff);
        });
    });
});
