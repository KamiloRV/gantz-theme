<?php
/* =============================================================================
        ASSETS (CSS y JS)
============================================================================= */
function gantz_enqueue_assets() {

    $ver = wp_get_theme()->get( 'Version' ); // versión del tema para cache-busting

    // Fuentes locales (antes: Google Fonts remoto)
    wp_enqueue_style(
        'gantz-fonts',
        get_template_directory_uri() . '/assets/css/fonts.css',
        [],
        $ver
    );

    // Bootstrap CSS
    /* wp_enqueue_style(
        'bootstrap',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css',
        [],
        '5.3.7'
    ); */

    // CSS principal del tema (depende de bootstrap y de las fuentes)
    wp_enqueue_style(
        'gantz-main',
        get_template_directory_uri() . '/assets/css/main.css',
        [ 'gantz-fonts' ],
        $ver
    );

    // jQuery (incluido en WordPress)
    /* wp_enqueue_script( 'jquery' ); */

    // Bootstrap JS
    wp_enqueue_script(
        'bootstrap',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js',
        [],
        '5.3.8',
        true
    );

    // JS principal del tema
    wp_enqueue_script(
        'gantz-main',
        get_template_directory_uri() . '/assets/js/main.js',
        [ 'bootstrap' ],
        $ver,
        true
    );

    // Solo cargar el slider en la página de inicio
    if (is_front_page()) {
        wp_enqueue_script(
            'sliders',
            get_template_directory_uri() . '/assets/js/sliders.js',
            [ 'bootstrap' ],
            $ver,
            true
        );
    }

    // Pasar datos de PHP a JS (disponibles como window.gantz.xxx)
    wp_localize_script( 'gantz-main', 'gantz', [
        'url'     => get_template_directory_uri(),
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'gantz-nonce' ),
    ]);

}
add_action( 'wp_enqueue_scripts', 'gantz_enqueue_assets' );