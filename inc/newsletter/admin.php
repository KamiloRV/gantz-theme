<?php

defined('ABSPATH') || exit;

add_action('admin_menu', function () {

    add_menu_page(
        'Suscriptores',
        'Suscriptores',
        'edit_pages',
        'gantz-newsletter',
        'gantz_newsletter_page',
        'dashicons-email',
        26
    );
});

/* Listado */
function gantz_newsletter_page()
{
    global $wpdb;

    $table = $wpdb->prefix . 'newsletter_subscribers';

    $subscribers = $wpdb->get_results(
        "SELECT * FROM {$table}
         ORDER BY created_at DESC"
    );

    ?>

    <div class="wrap">

        <h1 class="wp-heading-inline">
            Suscriptores Newsletter
        </h1>

        
            <a href="<?php echo admin_url('admin-post.php?action=gantz_export_newsletter'); ?>"
            class="page-title-action"
        >
            Exportar CSV
        </a>

        <hr class="wp-header-end">

        <table class="wp-list-table widefat striped">

            <thead>
                <tr>
                    <th>Email</th>
                    <th>Origen</th>
                    <th>Consentido</th>
                    <th>Fecha</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach ($subscribers as $subscriber) : ?>

                    <tr>

                        <td>
                            <?php echo esc_html($subscriber->email); ?>
                        </td>

                        <td>
                            <?php echo esc_html($subscriber->source); ?>
                        </td>

                        <td>
                            <?php echo $subscriber->consentido ? 'Sí' : 'No'; ?>
                        </td>

                        <td>
                            <?php echo esc_html($subscriber->created_at); ?>
                        </td>

                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    </div>

    <?php
}

/* Exportar suscriptores */
add_action(
    'admin_post_gantz_export_newsletter',
    'gantz_export_newsletter'
);

function gantz_export_newsletter()
{
    if (!current_user_can('edit_pages')) {
        wp_die('No autorizado.');
    }

    global $wpdb;

    $table = $wpdb->prefix . 'newsletter_subscribers';

    $rows = $wpdb->get_results(
        "SELECT email, source, consentido, created_at
         FROM {$table}
         ORDER BY created_at DESC",
        ARRAY_A
    );

    header('Content-Type: text/csv; charset=utf-8');

    $filename = sprintf(
        'Newsletter-Gantz-%s.csv',
        date('d-m-Y')
    );
    header('Content-Disposition: attachment; filename="' . $filename . '"');

    $output = fopen('php://output', 'w');

    fputcsv(
        $output,
        ['Email', 'Origen', 'Consentido', 'Fecha']
    );

    foreach ($rows as $row) {
        $row['consentido'] = $row['consentido'] ? 'Sí' : 'No';
        fputcsv($output, $row);
    }

    fclose($output);

    exit;
}


/* Guardar correos */
function gantz_add_subscriber(
    $email,
    $source = 'newsletter',
    $consentido = false
)
{
    global $wpdb;

    $table = $wpdb->prefix . 'newsletter_subscribers';

    $email = sanitize_email($email);

    if (!is_email($email)) {
        return false;
    }

    if (!$consentido) {
        return false;
    }

    $existing = $wpdb->get_row(
        $wpdb->prepare(
            "SELECT id, consentido
             FROM {$table}
             WHERE email = %s",
            $email
        )
    );

    if ($existing) {

        /* Ya estaba consentido: no hay nada que actualizar */
        if ((int) $existing->consentido === 1) {
            return false;
        }

        /* Estaba en la lista antigua sin consentimiento: se actualiza */
        return $wpdb->update(
            $table,
            [
                'consentido' => 1,
                'source'     => $source,
                'created_at' => current_time('mysql'),
            ],
            ['id' => $existing->id]
        );
    }

    /* Suscriptor nuevo */
    return $wpdb->insert(
        $table,
        [
            'email'      => $email,
            'source'     => $source,
            'consentido' => 1,
        ]
    );
}