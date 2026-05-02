<?php
/**
 * functions.php
 * 
 * Prefijo: gantz_
 * Texto del dominio: 'gantz'
 */

defined( 'ABSPATH' ) || exit; // Seguridad: evita acceso directo al archivo


/* =============================================================================
   1. SETUP DEL TEMA
============================================================================= */

function gantz_setup() {

    // Etiqueta <title> gestionada por WordPress
    add_theme_support( 'title-tag' );

    // Imágenes destacadas
    add_theme_support( 'post-thumbnails' );

    // Tamaños de imagen adicionales (opcionales, personaliza según tu diseño)
    add_image_size( 'card',   480, 320, true ); // recorte exacto para cards
    add_image_size( 'hero',  1440, 600, true ); // recorte para banners

    // HTML5 en formularios y galerías
    add_theme_support( 'html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ]);

    // Logo personalizado
    add_theme_support( 'custom-logo', [
        'height'      => 300,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => [ 'site-title', 'site-description' ],
    ]);

    // Menús de navegación
    register_nav_menus([
        'header' => __( 'Menú del Header', 'gantz' ),
        'footer' => __( 'Menú del Footer', 'gantz' ),
    ]);

}
add_action( 'after_setup_theme', 'gantz_setup' );


/* =============================================================================
   2. ASSETS (CSS y JS)
============================================================================= */

function gantz_enqueue_assets() {

    $ver = wp_get_theme()->get( 'Version' ); // versión del tema para cache-busting

    // Google Fonts
    wp_enqueue_style(
        'google-fonts',
        'https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,600;1,800&display=swap',
        [],
        null
    );

    // Bootstrap CSS
    /* wp_enqueue_style(
        'bootstrap',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css',
        [],
        '5.3.7'
    ); */

    // CSS principal del tema (depende de bootstrap)
    wp_enqueue_style(
        'gantz-main',
        get_template_directory_uri() . '/assets/css/main.css',
        [],
        $ver
    );

    // jQuery (incluido en WordPress)
    wp_enqueue_script( 'jquery' );

    // Bootstrap JS
    wp_enqueue_script(
        'bootstrap',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js',
        [ 'jquery' ],
        '5.3.8',
        true
    );

    // JS principal del tema
    wp_enqueue_script(
        'gantz-main',
        get_template_directory_uri() . '/assets/js/main.js',
        [ 'jquery', 'bootstrap' ],
        $ver,
        true
    );

    // Solo cargar el slider en la página de inicio
    if (is_front_page()) {
        wp_enqueue_script(
            'sliders',
            get_template_directory_uri() . '/assets/js/sliders.js',
            [ 'jquery', 'bootstrap' ],
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


/* =============================================================================
   3. SEGURIDAD
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
    add_filter( 'rest_authentication_errors', function( $access ) {
        if ( ! is_user_logged_in() ) {
            return new WP_Error(
                'rest_disabled',
                __( 'La REST API está desactivada para usuarios no autenticados.', 'gantz' ),
                [ 'status' => 403 ]
            );
        }
        return $access;
    });

    // Deshabilitar edición de archivos desde el panel de WordPress
    if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
        define( 'DISALLOW_FILE_EDIT', true );
    }

}
add_action( 'init', 'gantz_security' );


/* =============================================================================
   SEO / SETTINGS SYNC (ACF <-> WORDPRESS)
============================================================================= */

/**
 * 🔄 Sync ACF → WordPress
 */
function gantz_sync_all_options($post_id) {

    if ($post_id !== 'options') return;

    /* ========================
       SITE NAME
    ======================== */

    $name = get_field('ajustes_name', 'option');
    if ($name && get_option('blogname') !== $name) {
        update_option('blogname', $name);
    }

    /* ========================
       DESCRIPTION
    ======================== */

    $description = get_field('ajustes_descripcion', 'option');
    if ($description && get_option('blogdescription') !== $description) {
        update_option('blogdescription', $description);
    }

    /* ========================
       FAVICON
    ======================== */

    $icon = get_field('ajustes_icono', 'option');
    if (!empty($icon['ID']) && get_option('site_icon') != $icon['ID']) {
        update_option('site_icon', $icon['ID']);
    }

    /* ========================
       LOGO
    ======================== */

    $logo = get_field('ajustes_logo', 'option');
    if (!empty($logo['ID']) && get_theme_mod('custom_logo') != $logo['ID']) {
        set_theme_mod('custom_logo', $logo['ID']);
    }

    /* ========================
       ADMIN EMAIL
    ======================== */

    $email = get_field('ajustes_correo_admin', 'option');

    if ($email && is_email($email)) {
        // WordPress manejará confirmación automáticamente
        if (get_option('admin_email') !== $email) {
            update_option('admin_email', $email);
        }
    }

}

// Si el favicon es un SVG imprimimos el link de favicon con url deL SVG
add_action('acf/save_post', 'gantz_sync_all_options', 20);

function gantz_svg_favicon() {
    $icon = get_field('ajustes_icono', 'option');

    if ($icon && $icon['mime_type'] === 'image/svg+xml') {
        echo '<link rel="icon" href="' . esc_url($icon['url']) . '" type="image/svg+xml">';
    }
}
add_action('wp_head', 'gantz_svg_favicon');



// Title and Desc SYNC
/* function gantz_sync_site_settings($post_id) {

    if ($post_id !== 'options') return;

    // Nombre del sitio
    $name = get_field('ajustes_name', 'option');
    if ($name) {
        update_option('blogname', $name);
    }

    // Descripción
    $description = get_field('ajustes_descripcion', 'option');
    if ($description) {
        update_option('blogdescription', $description);
    }

}

add_action('acf/save_post', 'gantz_sync_site_settings', 20);

// Favicon SYNC
function gantz_sync_favicon($post_id) {

    if ($post_id !== 'options') return;

    $icon = get_field('ajustes_icono', 'option');

    if ($icon) {
        update_option('site_icon', $icon['ID']);
    }

}

add_action('acf/save_post', 'gantz_sync_favicon', 20);


// Logo SYNC
function gantz_sync_logo($post_id) {

    if ($post_id !== 'options') return;

    $logo = get_field('ajustes_logo', 'option');

    if ($logo) {
        set_theme_mod('custom_logo', $logo['ID']);
    }

}

add_action('acf/save_post', 'gantz_sync_logo', 20);

// Admin Email SYNC
function gantz_sync_admin_email($post_id) {

    // Solo cuando se guarda la página de opciones
    if ($post_id !== 'options') {
        return;
    }

    // Obtener el campo ACF
    $email = get_field('ajustes_correo_admin', 'option');

    // Validar email
    if ($email && is_email($email)) {
        update_option('admin_email', $email);
    }

}

add_action('acf/save_post', 'gantz_sync_admin_email', 20); */

/* function gantz_custom_title($title) {

    $site_name = get_field('ajustes_name', 'option') ?: get_bloginfo('name');

    if ( is_front_page() || is_home() ) {
        $title['title'] = $site_name;
        unset($title['tagline']);
    }

    elseif ( is_singular() ) {
        $title['title'] = single_post_title('', false);
        $title['site'] = $site_name;
    }

    elseif ( is_category() || is_tag() || is_tax() ) {
        $title['title'] = single_term_title('', false);
        $title['site'] = $site_name;
    }

    else {
        $title['site'] = $site_name;
    }

    return $title;
}
add_filter('document_title_parts', 'gantz_custom_title'); */

function gantz_meta_description() {

    // Evitar conflictos con plugins SEO
    if (function_exists('wpseo_init')) return;

    if ( is_front_page() || is_home() ) {

        $description = get_bloginfo('description');

    } elseif ( is_singular() ) {

        $description = has_excerpt()
            ? wp_strip_all_tags( get_the_excerpt() )
            : wp_trim_words( wp_strip_all_tags( get_the_content() ), 25, '…' );

    } elseif ( is_category() || is_tag() || is_tax() ) {

        $description = wp_strip_all_tags( term_description() )
            ?: sprintf(
                'Explora los artículos de %s en %s.',
                single_term_title('', false),
                get_bloginfo('name')
            );

    } else {

        $description = sprintf(
            'Explora %s, un sitio dedicado a contenidos relevantes.',
            get_bloginfo('name')
        );
    }

    if ($description) {
        echo '<meta name="description" content="' . esc_attr($description) . '">' . "\n";
    }
}

add_action('wp_head', 'gantz_meta_description', 1);


/* =============================================================================
   5. PLANTILLAS DE PÁGINA (carpeta /templates/)
============================================================================= */

/**
 * Redirige las page templates a la carpeta /templates/
 * Busca en este orden: page-{slug}.php → page-{id}.php → page.php
 */
function gantz_page_templates( $template ) {

    if ( ! is_page() ) {
        return $template;
    }

    $post      = get_queried_object();
    $pages_dir = get_template_directory() . '/templates/';

    $candidates = [
        $pages_dir . 'page-' . $post->post_name . '.php',
        $pages_dir . 'page-' . $post->ID . '.php',
        $pages_dir . 'page.php',
    ];

    foreach ( $candidates as $file ) {
        if ( file_exists( $file ) ) {
            return $file;
        }
    }

    return $template;
}
add_filter( 'page_template', 'gantz_page_templates' );


/* =============================================================================
   6. UTILIDADES
============================================================================= */

/**
 * Formatea números de teléfono chilenos.
 *
 * @param  string $phone  Número crudo (con o sin +56)
 * @return array {
 *     @type string $raw        Solo dígitos, sin código de país
 *     @type string $type       'mobile' | 'landline' | 'unknown'
 *     @type string $formatted  Número con espacios (ej: "9 1234 5678")
 *     @type string $e164       Formato internacional (ej: "+56912345678")
 * }
 */
function gantz_parse_phone_cl( $phone ) {

    // Deja solo dígitos
    $clean = preg_replace( '/\D/', '', $phone );

    // Quita el prefijo 56 si viene completo (ej: 56912345678)
    if ( strlen( $clean ) === 11 && str_starts_with( $clean, '56' ) ) {
        $clean = substr( $clean, 2 );
    }

    $result = [
        'raw'       => $clean,
        'type'      => 'unknown',
        'formatted' => $clean,
        'e164'      => '+56' . $clean,
    ];

    // Celular: empieza en 9 y tiene 9 dígitos
    if ( preg_match( '/^9\d{8}$/', $clean ) ) {
        $result['type']      = 'mobile';
        $result['formatted'] = preg_replace( '/^(\d)(\d{4})(\d{4})$/', '$1 $2 $3', $clean );

    // Fijo: empieza en 2-7 y tiene 9 dígitos
    } elseif ( preg_match( '/^[2-7]\d{8}$/', $clean ) ) {
        $result['type']      = 'landline';
        $result['formatted'] = preg_replace( '/^(\d{2})(\d{3})(\d{4})$/', '$1 $2 $3', $clean );
    }

    return $result;
}