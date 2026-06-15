<?php
/* =============================================================================
        TEMPLATES
============================================================================= */
/**
 * Redirige las page templates a la carpeta /templates/pages/
 * Busca en este orden: page-{slug}.php → page-{id}.php → page.php
 */
function gantz_page_templates( $template ) {

    if ( ! is_page() ) {
        return $template;
    }

    $post      = get_queried_object();
    $pages_dir = get_template_directory() . '/templates/pages/';

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



function gantz_single_templates($template) {

    if (!is_single()) {
        return $template;
    }

    $post = get_queried_object();
    $singles_dir = get_template_directory() . '/templates/singles/';

    $post_type = get_post_type($post);

    $candidates = [
        $singles_dir . 'single-' . $post->post_name . '.php', // single por slug
        $singles_dir . 'single-' . $post->ID . '.php', // single por ID
        $singles_dir . 'single-' . $post_type . '.php', // single por CPT
        $singles_dir . 'single.php', // fallback
    ];

    foreach ($candidates as $file) {
        if (file_exists($file)) {
            return $file;
        }
    }

    return $template;
}
add_filter('single_template', 'gantz_single_templates');



function gantz_404_template($template) {

    $custom_404 = get_template_directory() . '/templates/404.php';

    if (file_exists($custom_404)) {
        return $custom_404;
    }

    return $template;
}
add_filter('404_template', 'gantz_404_template');



function gantz_add_page_slug_body_class($classes) {
    if (is_page()) {
        $post = get_queried_object();

        if ($post && !empty($post->post_name)) {
            $classes[] = 'page-' . sanitize_html_class($post->post_name);
        }
    }

    return $classes;
}
add_filter('body_class', 'gantz_add_page_slug_body_class');