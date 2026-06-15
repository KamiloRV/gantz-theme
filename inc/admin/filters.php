<?php
/* =============================================================================
        FILTERS
============================================================================= */
/* Dropdown filtro expertos */
add_action('restrict_manage_posts', function () {

    global $typenow;

    if ($typenow !== 'experto') {
        return;
    }

    wp_dropdown_categories([
        'show_option_all' => 'Todas las áreas',
        'taxonomy'        => 'area',
        'name'            => 'area',
        'orderby'         => 'name',
        'selected'        => $_GET['area'] ?? '',
        'hierarchical'    => true,
        'hide_empty'      => false,
        'show_count'      => true,
        'value_field'     => 'slug',
    ]);
});

/* =========================================================
 * ORDENAR Y FILTRAR EXPERTOS
 * =======================================================*/

add_action('pre_get_posts', function ($query) {

    if (
        !is_admin()
        || !$query->is_main_query()
    ) {
        return;
    }

    if ($query->get('post_type') !== 'experto') {
        return;
    }

    /**
     * Orden manual
     */
    $query->set('orderby', 'menu_order');
    $query->set('order', 'ASC');

    /**
     * Filtro por área
     */
    if (!empty($_GET['area'])) {

        $query->set('tax_query', [
            [
                'taxonomy' => 'area',
                'field'    => 'slug',
                'terms'    => sanitize_text_field($_GET['area']),
            ]
        ]);
    }
});

/* =========================================================
 * FILTRAR ESPECIALIDADES
 * =======================================================*/

add_action('pre_get_posts', function ($query) {

    if (
        !is_admin()
        || !$query->is_main_query()
    ) {
        return;
    }

    if ($query->get('post_type') !== 'especialidad') {
        return;
    }

    /**
     * Filtro tipo especialidad
     */
    if (!empty($_GET['tipo-especialidad'])) {

        $query->set('tax_query', [
            [
                'taxonomy' => 'tipo-especialidad',
                'field'    => 'slug',
                'terms'    => sanitize_text_field($_GET['tipo-especialidad']),
            ]
        ]);
    }
});