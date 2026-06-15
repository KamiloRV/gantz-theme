<?php
/* =============================================================================
        SEO
============================================================================= */
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


function gantz_svg_favicon() {
    $icon = get_field('ajustes_icono', 'option');

    if ($icon && $icon['mime_type'] === 'image/svg+xml') {
        echo '<link rel="icon" href="' . esc_url($icon['url']) . '" type="image/svg+xml">';
    }
}
add_action('wp_head', 'gantz_svg_favicon');


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