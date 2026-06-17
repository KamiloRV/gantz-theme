<?php

defined('ABSPATH') || exit;

/**
 * =====================================================
 * RESTRICCIONES PARA CLIENTES
 * =====================================================
 *
 * Administradores:
 * - Acceso total.
 *
 * Resto de usuarios:
 * - Dashboard
 * - Medios
 * - Páginas
 * - Landings
 * - CPTs
 * - Opciones ACF
 * - Menús
 *
 * Sin acceso a:
 * - Plugins
 * - Temas
 * - Usuarios
 * - Ajustes
 * - Herramientas
 * - ACF
 * - Contact Form 7
 *
 * =====================================================
 */


/**
 * Verifica si es administrador
 */
function gantz_is_admin_user()
{
    $user = wp_get_current_user();
    return in_array('administrator', (array) $user->roles, true);
}


/**
 * =====================================================
 * OCULTAR MENÚS
 * =====================================================
 */
add_action('admin_menu', function () {

    if (gantz_is_admin_user()) {
        return;
    }

    remove_menu_page('plugins.php');
    remove_menu_page('themes.php');
    remove_menu_page('users.php');
    remove_menu_page('tools.php');
    remove_menu_page('options-general.php');
    remove_menu_page('edit-comments.php');
    remove_menu_page('edit.php');

    // Contact Form 7
    remove_menu_page('wpcf7');

    // ACF
    remove_menu_page('edit.php?post_type=acf-field-group');

}, 999);


/**
 * =====================================================
 * OCULTAR BARRA SUPERIOR
 * =====================================================
 *
 * Opcional.
 * Si quieres que los usuarios
 * no vean accesos rápidos.
 *
 */

add_action('init', function () {
    if (!gantz_is_admin_user()) {
        show_admin_bar(false);
    }
});

add_action('admin_bar_menu', function ($wp_admin_bar) {

    if (gantz_is_admin_user()) {
        return;
    }

    $wp_admin_bar->remove_node('new-post');
    $wp_admin_bar->remove_node('new-page');
    $wp_admin_bar->remove_node('comments');
    $wp_admin_bar->remove_node('search');
    $wp_admin_bar->remove_node('command-palette');

    $wp_admin_bar->add_node([
        'id'   => 'new-content',
        'href' => false,
    ]);

}, 9999);



/**
 * =====================================================
 * OCULTAR BOTÓN
 * "AÑADIR NUEVA PÁGINA"
 * =====================================================
 */
add_action('admin_head', function () {

    if (gantz_is_admin_user()) {
        return;
    }

    $screen = get_current_screen();

    if (
        $screen &&
        in_array($screen->id, ['edit-page', 'page'], true)
    ) {
        ?>
        <style>
            .page-title-action{
                display:none !important;
            }
        </style>
        <?php
    }

});


/**
 * =====================================================
 * IMPEDIR CREAR PÁGINAS
 * =====================================================
 */
add_action('admin_init', function () {

    if (gantz_is_admin_user()) {
        return;
    }

    global $pagenow;

    if (
        $pagenow === 'post-new.php'
        && isset($_GET['post_type'])
        && $_GET['post_type'] === 'page'
    ) {
        wp_die(
            'No tienes permisos para crear páginas.'
        );
    }

});


/**
 * =====================================================
 * IMPEDIR ELIMINAR PÁGINAS
 * =====================================================
 */
add_filter(
    'map_meta_cap',
    function ($caps, $cap) {

        if (gantz_is_admin_user()) {
            return $caps;
        }

        if (
            in_array(
                $cap,
                [
                    'delete_page',
                    'delete_pages'
                ]
            )
        ) {
            return ['do_not_allow'];
        }

        return $caps;
    },
    10,
    2
);


/**
 * =====================================================
 * OCULTAR ENLACES DE PAPELERA
 * =====================================================
 */
add_filter(
    'page_row_actions',
    function ($actions) {

        if (gantz_is_admin_user()) {
            return $actions;
        }

        unset($actions['trash']);
        unset($actions['delete']);

        return $actions;
    }
);


/**
 * =====================================================
 * IMPEDIR ACCESO DIRECTO
 * A PLUGINS
 * =====================================================
 */
add_action('admin_init', function () {

    if (gantz_is_admin_user()) {
        return;
    }

    global $pagenow;

    $restricted = [
        'plugins.php',
        'plugin-install.php',
        'themes.php',
        'theme-install.php',
        'users.php',
        'user-new.php',
        'tools.php',
        'options-general.php'
    ];

    if (
        in_array(
            $pagenow,
            $restricted
        )
    ) {
        wp_die(
            'No tienes permisos para acceder a esta sección.'
        );
    }

});