<?php
/* =============================================================================
        SETUP DEL TEMA
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