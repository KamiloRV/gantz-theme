<?php
$current_page_id = get_queried_object_id();
$pre_footers = get_field('pre_footers_pre-footer', 'option');

if (!$pre_footers) return;

if (is_singular('noticia')) {
    $current_page_id = get_page_by_path('noticias')->ID;
}

if (is_singular('newsletter')) {
    $current_page_id = get_page_by_path('newsletters')->ID;
}

if (is_singular('galeria-fotos')) {
    $current_page_id = get_page_by_path('galeria-de-fotos')->ID;
}

if (is_singular('galeria-videos')) {
    $current_page_id = get_page_by_path('galeria-de-videos')->ID;
}

foreach ($pre_footers as $pre_footer) {

    $assigned_pages = $pre_footer['assigned_pages'] ?? [];

    $page_ids = array_map(function($page) {
        return is_object($page) ? $page->ID : $page;
    }, $assigned_pages);

    if (in_array($current_page_id, $page_ids, true)) {
        get_template_part(
            'template-parts/components/pre-footer/layouts/' . $pre_footer['tipo'],
            null,
            $pre_footer
        );
        break;
    }
}