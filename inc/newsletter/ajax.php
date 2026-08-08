<?php

defined('ABSPATH') || exit;

add_action(
    'wp_ajax_nopriv_gantz_newsletter_subscribe',
    'gantz_newsletter_subscribe'
);

add_action(
    'wp_ajax_gantz_newsletter_subscribe',
    'gantz_newsletter_subscribe'
);

function gantz_newsletter_subscribe()
{
    check_ajax_referer(
        'gantz-nonce',
        'nonce'
    );

    $email = sanitize_email(
        $_POST['email'] ?? ''
    );

    if (!is_email($email)) {

        wp_send_json_error([
            'message' => 'Correo inválido.'
        ]);
    }

    $consentido = isset($_POST['newsletter_consent']) && $_POST['newsletter_consent'] === '1';

    if (!$consentido) {

        wp_send_json_error([
            'message' => 'Debes aceptar el tratamiento de datos para suscribirte.'
        ]);
    }

    $inserted = gantz_add_subscriber(
        $email,
        'newsletter',
        $consentido
    );

    if (!$inserted) {

        error_log(
            '[Newsletter] Correo duplicado: ' .
            $email
        );

        wp_send_json_success([
            'message' => 'Suscripción realizada correctamente.'
        ]);
    }

    wp_send_json_success([
        'message' => 'Suscripción realizada correctamente.'
    ]);
}