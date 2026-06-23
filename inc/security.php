<?php
/* =============================================================================
        SEGURIDAD
============================================================================= */
function gantz_security() {

    // Ocultar versión de WordPress
    add_filter( 'the_generator', '__return_empty_string' );
    remove_action( 'wp_head', 'wp_generator' );

    // Mensaje de error de login genérico (no revela si el usuario existe)
    add_filter( 'login_errors', function() {
        return __( 'Las credenciales ingresadas son incorrectas. Por favor, inténtelo de nuevo.', 'gantz' );
    });

    // Deshabilitar XML-RPC (vector de ataques de fuerza bruta)
    add_filter( 'xmlrpc_enabled', '__return_false' );

    // Eliminar emojis (reducen peticiones innecesarias)
    remove_action( 'wp_head',        'print_emoji_detection_script', 7 );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'admin_print_styles',  'print_emoji_styles' );

    // Limpiar etiquetas innecesarias del <head>
    remove_action( 'wp_head', 'wlwmanifest_link' );
    remove_action( 'wp_head', 'rsd_link' );
    remove_action( 'wp_head', 'wp_shortlink_wp_head' );
    remove_action( 'wp_head', 'rest_output_link_wp_head' );
    remove_action( 'template_redirect', 'rest_output_link_header' );

    // Bloquear REST API para usuarios no autenticados
    add_filter('rest_authentication_errors', function ($access) {

        if (!empty($access)) {
            return $access;
        }

        if (is_user_logged_in()) {
            return $access;
        }

        $route = $GLOBALS['wp']->query_vars['rest_route'] ?? '';

        $allowed_routes = [
            '/contact-form-7/',
        ];

        foreach ($allowed_routes as $allowed) {
            if (strpos($route, $allowed) === 0) {
                return $access;
            }
        }

        return new WP_Error(
            'rest_disabled',
            __('La REST API está desactivada para usuarios no autenticados.', 'gantz'),
            ['status' => 403]
        );
    });

    // Deshabilitar edición de archivos desde el panel de WordPress
    if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
        define( 'DISALLOW_FILE_EDIT', true );
    }

}
add_action( 'init', 'gantz_security' );