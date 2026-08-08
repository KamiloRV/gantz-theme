<?php

defined('ABSPATH') || exit;

add_action('admin_menu', function () {

    add_menu_page(
        'Consentimientos',
        'Consentimientos',
        'edit_pages',
        'gantz-consentimientos',
        'consent_forms_page',
        'dashicons-shield',
        27
    );
});

function consent_forms_page()
{
    global $wpdb;

    $table = $wpdb->prefix . 'consent_forms';

    $registros = $wpdb->get_results(
        "SELECT * FROM {$table}
         ORDER BY created_at DESC"
    );

    echo '<div class="wrap">';

    echo '<h1 class="wp-heading-inline">Consentimientos</h1>';

    printf(
        '<a href="%s" class="page-title-action">Exportar CSV</a>',
        esc_url(admin_url('admin-post.php?action=gantz_export_consentimientos'))
    );

    echo '<hr class="wp-header-end">';

    echo '<table class="wp-list-table widefat striped">';
    echo '<thead><tr>
            <th>Formulario</th>
            <th>Email</th>
            <th>Autorización terceros</th>
            <th>Consentimiento tratamiento</th>
            <th>Fecha</th>
          </tr></thead>';
    echo '<tbody>';

    foreach ($registros as $r) {

        $autorizacion = is_null($r->autorizacion_terceros)
            ? '—'
            : ($r->autorizacion_terceros ? 'Sí' : 'No');

        printf(
            '<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>',
            esc_html($r->formulario),
            esc_html($r->email),
            esc_html($autorizacion),
            $r->consentimiento_tratamiento ? 'Sí' : 'No',
            esc_html($r->created_at)
        );
    }

    echo '</tbody></table>';
    echo '</div>';
}

add_action(
    'admin_post_gantz_export_consentimientos',
    'gantz_export_consentimientos'
);

function gantz_export_consentimientos()
{
    if (!current_user_can('edit_pages')) {
        wp_die('No autorizado.');
    }

    global $wpdb;

    $table = $wpdb->prefix . 'consent_forms';

    $rows = $wpdb->get_results(
        "SELECT formulario, email, autorizacion_terceros, consentimiento_tratamiento, created_at
         FROM {$table}
         ORDER BY created_at DESC",
        ARRAY_A
    );

    header('Content-Type: text/csv; charset=utf-8');

    $filename = sprintf('Consentimientos-Gantz-%s.csv', date('d-m-Y'));
    header('Content-Disposition: attachment; filename="' . $filename . '"');

    $output = fopen('php://output', 'w');

    fputcsv($output, ['Formulario', 'Email', 'Autorización terceros', 'Consentimiento tratamiento', 'Fecha']);

    foreach ($rows as $row) {
        $row['autorizacion_terceros'] = is_null($row['autorizacion_terceros']) ? '—' : ($row['autorizacion_terceros'] ? 'Sí' : 'No');
        $row['consentimiento_tratamiento'] = $row['consentimiento_tratamiento'] ? 'Sí' : 'No';
        fputcsv($output, $row);
    }

    fclose($output);

    exit;
}